<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$boPageTitle = 'Gestion des articles';
$articles = getAllArticles($pdo);

$success = $_GET['success'] ?? '';

require_once __DIR__ . '/header.php';
?>

<?php if ($success === 'created'): ?>
<div class="alert alert-success">Article créé avec succès.</div>
<?php elseif ($success === 'updated'): ?>
<div class="alert alert-success">Article mis à jour avec succès.</div>
<?php elseif ($success === 'deleted'): ?>
<div class="alert alert-success">Article supprimé avec succès.</div>
<?php endif; ?>

<div class="section-header">
    <h2>Tous les articles (<?= count($articles) ?>)</h2>
    <a href="/backoffice/article_form.php" class="btn btn-primary">+ Nouvel article</a>
</div>

<?php if (empty($articles)): ?>
<p class="empty-state">Aucun article. <a href="/backoffice/article_form.php">Créer votre premier article</a>.</p>
<?php else: ?>
<table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Slug</th>
            <th>Statut</th>
            <th>Créé le</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article['id'] ?></td>
            <td><strong><?= e($article['title']) ?></strong></td>
            <td><code><?= e($article['slug']) ?></code></td>
            <td>
                <span class="badge <?= $article['published'] ? 'badge-success' : 'badge-warning' ?>">
                    <?= $article['published'] ? 'Publié' : 'Brouillon' ?>
                </span>
            </td>
            <td><?= formatDate($article['created_at']) ?></td>
            <td class="actions">
                <a href="<?= articleUrl($article['slug']) ?>" class="btn btn-sm" target="_blank" title="Voir">👁</a>
                <a href="/backoffice/article_form.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-primary" title="Modifier">✏️</a>
                <a href="/backoffice/article_delete.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Supprimer cet article ?')">🗑</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
