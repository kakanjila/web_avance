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
    <title>Guerre en Iran — Actualités</title>
</head>
<body>
    <h1>Liste des articles</h1>

    <?php foreach ($articles as $article): ?>
    <div class="article">
        <?php if (!empty($article['image'])): ?>
            <img src="images/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
        <?php endif; ?>
        <h2><?= htmlspecialchars($article['title']) ?></h2>
        <div class="date"><?= date('d/m/Y', strtotime($article['created_at'])) ?></div>
        <p><?= substr(strip_tags($article['content']), 0, 120) ?>...</p>
        <a href="article.php?slug=<?= urlencode($article['slug']) ?>">Lire l'article</a>
    </div>
<?php endforeach; ?>
</body>
</html>