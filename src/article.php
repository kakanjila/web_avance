<?php
require 'config/database.php';

// Récupérer le slug depuis l'URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : null;

if (!$slug) {
    header('Location: index.php');
    exit;
}

// Récupérer l'article via le slug
$stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = ? AND status = 'published'");
$stmt->execute([$slug]);
$article = $stmt->fetch();

// Si l'article n'existe pas, rediriger vers l'accueil
if (!$article) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Article non trouvé</title>
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>
    <body>
        <div class="container">
            <div class="error-404">
                <h1>Article non trouvé</h1>
                <p>Désolé, l'article que vous recherchez n'existe pas ou a été supprimé.</p>
                <a href="/" class="btn btn-primary">Retour à l'accueil</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Variables SEO
$base_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
$current_url = $base_url . str_replace('article.php', 'article/' . $article['slug'], $_SERVER['REQUEST_URI']);
$meta_description = $article['meta_description'] ?? substr(strip_tags($article['content']), 0, 160);
$meta_keywords = implode(', ', array_filter([
    'Iran',
    'actualités',
    'article',
    strlen($article['title']) > 10 ? substr($article['title'], 0, 20) : $article['title']
]));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Titres et descriptions -->
    <title><?= htmlspecialchars($article['title']) ?> — Actualités Iran</title>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">
    
    <!-- Balises de robots -->
    <meta name="robots" content="index, follow">
    <meta name="language" content="French">
    <meta name="author" content="Actualités Iran">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= htmlspecialchars($current_url) ?>">
    
    <!-- Open Graph (réseaux sociaux) -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="<?= htmlspecialchars($article['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($current_url) ?>">
    <meta property="og:site_name" content="Actualités Iran">
    <meta property="og:locale" content="fr_FR">
    <?php if (!empty($article['image'])): ?>
        <meta property="og:image" content="<?= htmlspecialchars($base_url . '/assets/images/' . $article['image']) ?>">
        <meta property="og:image:type" content="image/jpeg">
    <?php endif; ?>
    <meta property="article:published_time" content="<?= $article['created_at'] ?>">
    <meta property="article:modified_time" content="<?= $article['updated_at'] ?>">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($article['title']) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($meta_description) ?>">
    <?php if (!empty($article['image'])): ?>
        <meta name="twitter:image" content="<?= htmlspecialchars($base_url . '/assets/images/' . $article['image']) ?>">
    <?php endif; ?>
    
    <!-- Feuille de style -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <!-- Fil d'Ariane -->
        <nav class="breadcrumb" aria-label="Fil d'Ariane">
            <a href="/">Accueil</a>
            <span class="separator">/</span>
            <span class="current" aria-current="page"><?= htmlspecialchars($article['title']) ?></span>
        </nav>

        <!-- Article complet -->
        <article class="article-detail" itemscope itemtype="https://schema.org/Article">
            <!-- En-tête de l'article -->
            <header class="article-detail-header">
                <h1 class="article-detail-title" itemprop="headline"><?= htmlspecialchars($article['title']) ?></h1>
                
                <div class="article-detail-meta">
                    <time class="article-detail-date" datetime="<?= $article['created_at'] ?>" itemprop="datePublished">
                        Publié le <?= formatDateFR($article['created_at']); ?>
                    </time>
                    <?php if ($article['updated_at'] !== $article['created_at']): ?>
                        <span class="article-detail-updated" itemprop="dateModified" content="<?= $article['updated_at'] ?>">
                            (Mis à jour le <?= formatDateFR($article['updated_at']); ?>)
                        </span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($article['meta_description'])): ?>
                    <p class="article-detail-description" itemprop="description">
                        <?= htmlspecialchars($article['meta_description']) ?>
                    </p>
                <?php endif; ?>
            </header>

            <!-- Image principale -->
            <?php if (!empty($article['image'])): ?>
                <figure class="article-detail-image">
                    <img 
                        src="/assets/images/<?= htmlspecialchars($article['image']) ?>" 
                        alt="Illustration de : <?= htmlspecialchars($article['title']) ?>"
                        itemprop="image"
                    >
                    <figcaption>Illustration : <?= htmlspecialchars($article['title']) ?></figcaption>
                </figure>
            <?php endif; ?>

            <!-- Contenu de l'article -->
            <div class="article-detail-content" itemprop="articleBody">
                <?php
                // Afficher le contenu brut (il peut contenir du HTML)
                echo $article['content'];
                ?>
            </div>

            <!-- Pied de l'article -->
            <footer class="article-detail-footer">
                <div class="article-actions">
                    <a href="/index.php" class="btn btn-secondary">← Retour à la liste</a>
                </div>
            </footer>
        </article>

        <!-- Articles connexes -->
        <?php
        // Récupérer les 3 derniers articles (sauf celui actuel)
        $related_stmt = $pdo->prepare("
            SELECT id, title, slug, image, created_at 
            FROM articles 
            WHERE status = 'published' AND id != ? 
            ORDER BY created_at DESC 
            LIMIT 3
        ");
        $related_stmt->execute([$article['id']]);
        $related_articles = $related_stmt->fetchAll();
        
        if (count($related_articles) > 0):
        ?>
        <section class="related-articles" aria-label="Articles connexes">
            <h2>Articles connexes</h2>
            <div class="related-articles-grid">
                <?php foreach ($related_articles as $related): ?>
                    <article class="related-article-card" itemscope itemtype="https://schema.org/Article">
                        <?php if (!empty($related['image'])): ?>
                            <div class="related-article-image">
                                <img 
                                    src="/assets/images/<?= htmlspecialchars($related['image']) ?>" 
                                    alt="<?= htmlspecialchars($related['title']) ?>"
                                    itemprop="image"
                                >
                            </div>
                        <?php endif; ?>
                        <div class="related-article-content">
                            <h3 class="related-article-title" itemprop="headline">
                                <a href="/article/<?= urlencode($related['slug']) ?>" itemprop="url">
                                    <?= htmlspecialchars($related['title']) ?>
                                </a>
                            </h3>
                            <time class="related-article-date" datetime="<?= $related['created_at'] ?>" itemprop="datePublished">
                                <?= formatDateFR($related['created_at']); ?>
                            </time>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </div>
    
    <!-- Schema.org JSON-LD pour l'article -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": <?= json_encode($article['title']) ?>,
        "description": <?= json_encode($meta_description) ?>,
        "datePublished": <?= json_encode($article['created_at']) ?>,
        "dateModified": <?= json_encode($article['updated_at']) ?>,
        "author": {
            "@type": "Organization",
            "name": "Actualités Iran"
        },
        "publisher": {
            "@type": "Organization",
            "name": "Actualités Iran"
        }
        <?php if (!empty($article['image'])): ?>
        ,"image": <?= json_encode($base_url . '/assets/images/' . $article['image']) ?>
        <?php endif; ?>
    }
    </script>
</body>
</html>
