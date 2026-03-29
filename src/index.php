<?php
require 'config/database.php';

// Récupérer tous les articles
$articles = $pdo->query("
    SELECT * FROM articles 
    WHERE status='published'
    ORDER BY created_at DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités — Guerre en Iran</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <header class="header">
            <h1 class="page-title">Actualités</h1>
            <p class="page-subtitle">Dernières informations sur la situation en Iran</p>
        </header>

        <!-- Grille d'articles -->
        <main class="articles-grid">
            <?php if (count($articles) > 0): ?>
                <?php foreach ($articles as $article): ?>
                    <article class="article-card">
                        <!-- Image de l'article -->
                        <?php if (!empty($article['image'])): ?>
                            <div class="article-image">
                                <img src="assets/images/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                            </div>
                        <?php endif; ?>

                        <!-- Contenu de l'article -->
                        <div class="article-content">
                            <div class="article-meta">
                                <time class="article-date" datetime="<?= $article['created_at'] ?>">
                                    <?= strftime('%d %B %Y', strtotime($article['created_at'])); ?>
                                </time>
                            </div>

                            <h2 class="article-title"><?= htmlspecialchars($article['title']) ?></h2>

                            <p class="article-excerpt">
                                <?= htmlspecialchars(substr(strip_tags($article['content']), 0, 150)) ?>
                                <span class="ellipsis">...</span>
                            </p>

                            <?php if (!empty($article['meta_description'])): ?>
                                <p class="article-meta-description">
                                    <?= htmlspecialchars($article['meta_description']) ?>
                                </p>
                            <?php endif; ?>

                            <a href="article.php?slug=<?= urlencode($article['slug']) ?>" class="article-link">
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
        </main>
    </div>
</body>
</html>