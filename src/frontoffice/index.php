<?php
/**
 * FrontOffice - Page d'accueil
 * Liste tous les articles publiés
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$selectedTypeSlug = isset($_GET['type']) ? (string)$_GET['type'] : '';
$selectedTypeSlug = preg_replace('/[^a-z0-9-]/', '', mb_strtolower($selectedTypeSlug));

$articleTypes = getArticleTypes($pdo);
$articles = getPublishedArticles($pdo, 0, $selectedTypeSlug !== '' ? $selectedTypeSlug : null);
$mostReadArticles = getPublishedArticles($pdo, 5);

$selectedTypeName = 'Tous les articles';
foreach ($articleTypes as $type) {
    if ($type['slug'] === $selectedTypeSlug) {
        $selectedTypeName = $type['name'];
        break;
    }
}

$pageTitle = 'Daily News — Informations et Analyses';
$metaDescription = 'Daily News — analyses, décryptages et chronologie du conflit en Iran et de l\'actualité internationale.';

require_once __DIR__ . '/../includes/header.php';
?>

<section class="articles-section" aria-label="Articles récents">
    <h2 class="section-title"><?= e($selectedTypeName) ?></h2>

    <div class="layout-two-col home-layout">
        <div class="home-feed" aria-label="Flux principal">
            <?php if (empty($articles)): ?>
            <div class="home-empty">
                <p>Aucun article disponible pour ce type.</p>
            </div>
            <?php else: ?>
            <?php foreach ($articles as $article): ?>
            <article class="home-feed-item">
                <div class="home-feed-text">
                    <?php if (!empty($article['type_name'])): ?>
                    <span class="category-tag"><?= e($article['type_name']) ?></span>
                    <?php endif; ?>

                    <h3>
                        <a href="<?= articleUrl($article['slug']) ?>"><?= e($article['title']) ?></a>
                    </h3>

                    <p class="article-excerpt"><?= e(truncateText($article['content'], 240)) ?></p>

                    <div class="article-meta">
                        <time datetime="<?= $article['created_at'] ?>"><?= formatDate($article['created_at']) ?></time>
                    </div>
                </div>

                <a href="<?= articleUrl($article['slug']) ?>" class="home-feed-media" aria-label="Lire l'article : <?= e($article['title']) ?>">
                    <?php if (!empty($article['image_path'])): ?>
                    <img src="<?= e($article['image_path']) ?>"
                         alt="<?= e($article['image_alt'] ?? $article['title']) ?>"
                         class="article-card-img" loading="lazy"
                         width="300" height="180">
                    <?php else: ?>
                    <div class="article-card-img-placeholder" aria-hidden="true"></div>
                    <?php endif; ?>
                </a>
            </article>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <aside class="sidebar" aria-label="Contenu secondaire">
            <section class="sidebar-widget">
                <h3 class="section-title">Les plus lus</h3>
                <ol class="articles-list">
                    <?php foreach ($mostReadArticles as $index => $topArticle): ?>
                    <li>
                        <span class="list-number"><?= $index + 1 ?></span>
                        <h4><a href="<?= articleUrl($topArticle['slug']) ?>"><?= e($topArticle['title']) ?></a></h4>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </section>

            <section class="sidebar-widget">
                <h3 class="section-title">Édition du jour</h3>
                <p class="edition-date"><?= date('d/m/Y') ?></p>
                <div class="edition-box">
                    <p class="edition-logo">Daily News</p>
                    <a href="/" class="btn btn-primary">Lire les derniers articles</a>
                </div>
            </section>
        </aside>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
