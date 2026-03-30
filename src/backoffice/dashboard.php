<?php
/**
 * BackOffice - Tableau de bord
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$boPageTitle = 'Tableau de bord';

// Statistiques
$totalArticles = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$publishedArticles = $pdo->query("SELECT COUNT(*) FROM articles WHERE published = true")->fetchColumn();
$draftArticles = $totalArticles - $publishedArticles;
$totalImages = $pdo->query("SELECT COUNT(*) FROM images")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Derniers articles
$recentArticles = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/header.php';
?>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-number"><?= $totalArticles ?></div>
        <div class="stat-label">Articles total</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $publishedArticles ?></div>
        <div class="stat-label">Publiés</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $draftArticles ?></div>
        <div class="stat-label">Brouillons</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $totalImages ?></div>
        <div class="stat-label">Images</div>
    </div>
</div>

<section class="dashboard-section">
    <div class="section-header">
        <h2>Derniers articles</h2>
        <a href="/backoffice/article_form.php" class="btn btn-primary">+ Nouvel article</a>
    </div>
    
    <?php if (empty($recentArticles)): ?>
    <p class="empty-state">Aucun article pour le moment. <a href="/backoffice/article_form.php">Créer votre premier article</a>.</p>
    <?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Slug</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentArticles as $article): ?>
            <tr>
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
                    <a href="/backoffice/article_delete.php?id=<?= $article['id'] ?>" class="btn btn-sm btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">🗑</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
