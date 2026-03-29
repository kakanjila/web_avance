<?php
require 'config/database.php';

// Récupérer tous les articles
$articles = $pdo->query("
    SELECT * FROM articles 
    WHERE status='published'
    ORDER BY created_at DESC
")->fetchAll();

// Variables SEO
$page_title = 'Actualités sur la Guerre en Iran | Informations en direct';
$meta_description = 'Découvrez les dernières actualités et informations sur la situation en Iran. Articles détaillés, analyses et mises à jour régulières.';
$meta_keywords = 'Iran, actualités, guerre, informations, analyses, Moyen-Orient';
$base_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
$current_url = $base_url . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Titres et descriptions -->
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($meta_keywords) ?>">
    
    <!-- Balises de robots -->
    <meta name="robots" content="index, follow">
    <meta name="language" content="French">
    <meta name="author" content="Actualités Iran">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?= htmlspecialchars($current_url) ?>">
    
    <!-- Open Graph (réseaux sociaux) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($meta_description) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($current_url) ?>">
    <meta property="og:site_name" content="Actualités Iran">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($meta_description) ?>">
    
    <!-- Feuille de style -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <!-- En-tête de la page -->
        <header class="header" role="banner">
            <h1 class="page-title">Actualités</h1>
            <p class="page-subtitle">Dernières informations sur la situation en Iran</p>
        </header>

        <!-- Contenu principal -->
        <main class="articles-container" role="main">
            <!-- Grille d'articles -->
            <section class="articles-grid" aria-label="Liste des articles">
                <?php if (count($articles) > 0): ?>
                    <?php foreach ($articles as $article): ?>
                        <article class="article-card" itemscope itemtype="https://schema.org/Article">
                            <!-- Image de l'article -->
                            <?php if (!empty($article['image'])): ?>
                                <div class="article-image">
                                    <img 
                                        src="assets/images/<?= htmlspecialchars($article['image']) ?>" 
                                        alt="<?= htmlspecialchars($article['title']) ?>"
                                        itemprop="image"
                                    >
                                </div>
                            <?php endif; ?>

                            <!-- Contenu de l'article -->
                            <div class="article-content">
                                <div class="article-meta">
                                    <time class="article-date" datetime="<?= $article['created_at'] ?>" itemprop="datePublished">
                                        <?= strftime('%d %B %Y', strtotime($article['created_at'])); ?>
                                    </time>
                                </div>

                                <h2 class="article-title" itemprop="headline"><?= htmlspecialchars($article['title']) ?></h2>

                                <p class="article-excerpt" itemprop="description">
                                    <?= htmlspecialchars(substr(strip_tags($article['content']), 0, 150)) ?>
                                    <span class="ellipsis">...</span>
                                </p>

                                <?php if (!empty($article['meta_description'])): ?>
                                    <p class="article-meta-description">
                                        <?= htmlspecialchars($article['meta_description']) ?>
                                    </p>
                                <?php endif; ?>

                                <a href="article/<?= urlencode($article['slug']) ?>" class="article-link" itemprop="url">
                                    Lire l'article complet →
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-articles">
                        <p>Aucun article publié pour le moment.</p>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>