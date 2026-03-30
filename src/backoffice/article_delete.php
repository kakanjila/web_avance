<?php
/**
 * BackOffice - Suppression d'article
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

requireLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Vérifier que l'article existe
    $stmt = $pdo->prepare("SELECT id, image_path FROM articles WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($article) {
        // Supprimer l'image associée si elle existe
        if (!empty($article['image_path'])) {
            $imagePath = __DIR__ . '/../' . ltrim($article['image_path'], '/');
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Supprimer l'article (les images liées seront supprimées par CASCADE)
        $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

header('Location: /backoffice/articles.php?success=deleted');
exit;
