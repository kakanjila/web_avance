<?php
/**
 * FrontOffice - Page d'article
 * Affiche un article complet par son slug
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    header('Location: /');
    exit;
}

$article = getArticleBySlug($pdo, $slug);
if (!$article) {
    http_response_code(404);
    $pageTitle = 'Article non trouvé — Daily News';
    $metaDescription = 'L\'article demandé n\'a pas été trouvé.';
    require_once __DIR__ . '/../includes/header.php';
    echo '<div class="error-page"><h1>Article non trouvé</h1><p>L\'article que vous recherchez n\'existe pas ou a été supprimé.</p><a href="/" class="btn btn-primary">Retour à l\'accueil</a></div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Récupérer les images associées
$stmtImages = $pdo->prepare("SELECT * FROM images WHERE article_id = :id");
$stmtImages->execute(['id' => $article['id']]);
$images = $stmtImages->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les articles associés (les 3 derniers sauf l'actuel)
$stmtRelated = $pdo->prepare("SELECT a.*, t.name AS type_name, t.slug AS type_slug
                             FROM articles a
                             LEFT JOIN article_types t ON t.id = a.type_id
                             WHERE a.published = true AND a.id != :id
                             ORDER BY a.created_at DESC
                             LIMIT 3");
$stmtRelated->execute(['id' => $article['id']]);
$relatedArticles = $stmtRelated->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = e($article['title']) . ' — Daily News';
$metaDescription = $article['meta_description'] ?? truncateText($article['content'], 160);

require_once __DIR__ . '/../includes/header.php';
?>

<article class="article-full" itemscope itemtype="https://schema.org/Article">
    <header class="article-header">
        <?php if (!empty($article['type_name'])): ?>
        <span class="category-tag"><?= e($article['type_name']) ?></span>
        <?php endif; ?>
        <h1 itemprop="headline"><?= e($article['title']) ?></h1>
        <div class="article-info">
            <time datetime="<?= $article['created_at'] ?>" itemprop="datePublished">
                Publié le <?= formatDate($article['created_at']) ?>
            </time>
            <?php if ($article['updated_at'] !== $article['created_at']): ?>
            <span> — Mis à jour le 
                <time datetime="<?= $article['updated_at'] ?>" itemprop="dateModified"><?= formatDate($article['updated_at']) ?></time>
            </span>
            <?php endif; ?>
        </div>
    </header>

    <?php if (!empty($article['image_path'])): ?>
    <figure class="article-main-image">
        <img src="<?= e($article['image_path']) ?>" 
             alt="<?= e($article['image_alt'] ?? $article['title']) ?>" 
             itemprop="image" fetchpriority="high"
             width="800" height="400">
    </figure>
    <?php endif; ?>

    <div class="article-content" itemprop="articleBody">
        <?= $article['content'] ?>
    </div>

    <?php if (!empty($images)): ?>
    <section class="article-gallery" aria-label="Galerie d'images">
        <h2>Galerie</h2>
        <div class="gallery-grid">
            <?php foreach ($images as $image): ?>
            <figure class="gallery-item">
                <img src="<?= e($image['path']) ?>" 
                     alt="<?= e($image['alt_text'] ?? 'Image de l\'article') ?>" 
                     loading="lazy"
                     width="400" height="300">
                <?php if (!empty($image['alt_text'])): ?>
                <figcaption><?= e($image['alt_text']) ?></figcaption>
                <?php endif; ?>
            </figure>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</article>

<?php if (!empty($relatedArticles)): ?>
<section class="related-articles" aria-label="Articles associés">
    <h2 class="section-title">À lire aussi</h2>
    <div class="articles-grid">
        <?php foreach ($relatedArticles as $related): ?>
        <article class="article-card">
            <div class="article-card-img-wrap">
                <?php if (!empty($related['image_path'])): ?>
                <img src="<?= e($related['image_path']) ?>" 
                     alt="<?= e($related['image_alt'] ?? $related['title']) ?>" 
                     class="article-card-img" loading="lazy"
                     width="400" height="200">
                <?php else: ?>
                <div class="article-card-img-placeholder" aria-hidden="true"></div>
                <?php endif; ?>
                <?php if (!empty($related['type_name'])): ?>
                <span class="category-tag category-tag--blue"><?= e($related['type_name']) ?></span>
                <?php endif; ?>
            </div>
            <div class="article-card-body">
                <h3><a href="<?= articleUrl($related['slug']) ?>"><?= e($related['title']) ?></a></h3>
                <p class="article-excerpt"><?= e(truncateText($related['content'], 120)) ?></p>
                <div class="article-meta">
                    <time datetime="<?= $related['created_at'] ?>"><?= formatDate($related['created_at']) ?></time>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
