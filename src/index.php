<?php
require 'config/database.php';

// Récupérer tous les articles
$articles = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC")->fetchAll();
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
        <div>
            <h2><?= htmlspecialchars($article['title']) ?></h2>
            <p><?= substr(strip_tags($article['content']), 0, 100) ?>...</p>
        </div>
    <?php endforeach; ?>
</body>
</html>