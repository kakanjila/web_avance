<?php
require 'config/database.php';

// Récupérer les articles publiés
$articles = $pdo->query("SELECT * FROM articles WHERE statut='publie' ORDER BY date_publication DESC")->fetchAll();
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
            <h2><?= htmlspecialchars($article['titre']) ?></h2>
            <p><?= substr(strip_tags($article['contenu']), 0, 100) ?>...</p>
        </div>
    <?php endforeach; ?>
</body>
</html>