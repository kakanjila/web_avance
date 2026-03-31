<?php
/**
 * BackOffice - Gestion des types d'articles
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$boPageTitle = 'Types d\'articles';
$errors = [];
$success = $_GET['success'] ?? '';

// Traitement ajout / modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $typeId = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;

    if (empty($name)) {
        $errors[] = 'Le nom du type est obligatoire.';
    }

    $slug = generateSlug($name);

    if (empty($errors)) {
        if ($action === 'edit' && $typeId > 0) {
            $check = $pdo->prepare("SELECT id FROM article_types WHERE slug = :slug AND id != :id");
            $check->execute(['slug' => $slug, 'id' => $typeId]);
            if ($check->fetch()) {
                $errors[] = 'Ce type existe déjà.';
            } else {
                $stmt = $pdo->prepare("UPDATE article_types SET name = :name, slug = :slug WHERE id = :id");
                $stmt->execute(['name' => $name, 'slug' => $slug, 'id' => $typeId]);
                header('Location: /backoffice/article_types.php?success=updated');
                exit;
            }
        } else {
            $check = $pdo->prepare("SELECT id FROM article_types WHERE slug = :slug");
            $check->execute(['slug' => $slug]);
            if ($check->fetch()) {
                $errors[] = 'Ce type existe déjà.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO article_types (name, slug) VALUES (:name, :slug)");
                $stmt->execute(['name' => $name, 'slug' => $slug]);
                header('Location: /backoffice/article_types.php?success=created');
                exit;
            }
        }
    }
}

// Traitement suppression
if (isset($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    // Vérifier qu'aucun article n'utilise ce type
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE type_id = :id");
    $countStmt->execute(['id' => $deleteId]);
    $articleCount = (int)$countStmt->fetchColumn();

    if ($articleCount > 0) {
        $errors[] = "Impossible de supprimer : $articleCount article(s) utilisent ce type.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM article_types WHERE id = :id");
        $stmt->execute(['id' => $deleteId]);
        header('Location: /backoffice/article_types.php?success=deleted');
        exit;
    }
}

// Charger le type à modifier si demandé
$editType = null;
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM article_types WHERE id = :id");
    $stmt->execute(['id' => $editId]);
    $editType = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Récupérer tous les types avec le nombre d'articles
$types = $pdo->query("SELECT t.*, COUNT(a.id) AS article_count 
                      FROM article_types t 
                      LEFT JOIN articles a ON a.type_id = t.id 
                      GROUP BY t.id 
                      ORDER BY t.name ASC")->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/header.php';
?>

<?php if ($success === 'created'): ?>
<div class="alert alert-success">Type d'article créé avec succès.</div>
<?php elseif ($success === 'updated'): ?>
<div class="alert alert-success">Type d'article mis à jour.</div>
<?php elseif ($success === 'deleted'): ?>
<div class="alert alert-success">Type d'article supprimé.</div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<div class="form-row">
    <div class="form-col-4">
        <div class="card">
            <h3><?= $editType ? 'Modifier le type' : 'Ajouter un type' ?></h3>
            <form method="POST" action="/backoffice/article_types.php">
                <input type="hidden" name="action" value="<?= $editType ? 'edit' : 'add' ?>">
                <?php if ($editType): ?>
                <input type="hidden" name="type_id" value="<?= $editType['id'] ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="name">Nom du type *</label>
                    <input type="text" id="name" name="name" required
                           value="<?= htmlspecialchars($editType['name'] ?? ($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                           placeholder="Ex: Géopolitique, Histoire...">
                    <small>Le slug URL sera généré automatiquement</small>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <?= $editType ? 'Mettre à jour' : 'Ajouter' ?>
                </button>
                <?php if ($editType): ?>
                <a href="/backoffice/article_types.php" class="btn btn-secondary btn-block">Annuler</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="form-col-8">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Slug</th>
                    <th>Articles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($types)): ?>
                <tr><td colspan="5" style="text-align:center;">Aucun type d'article.</td></tr>
                <?php else: ?>
                <?php foreach ($types as $type): ?>
                <tr>
                    <td><?= $type['id'] ?></td>
                    <td><strong><?= htmlspecialchars($type['name'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                    <td><code><?= htmlspecialchars($type['slug'], ENT_QUOTES, 'UTF-8') ?></code></td>
                    <td><?= $type['article_count'] ?></td>
                    <td class="actions">
                        <a href="/backoffice/article_types.php?edit=<?= $type['id'] ?>" class="btn btn-sm btn-secondary">✏️ Modifier</a>
                        <?php if ((int)$type['article_count'] === 0): ?>
                        <a href="/backoffice/article_types.php?delete=<?= $type['id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Supprimer ce type ?')">🗑️ Supprimer</a>
                        <?php else: ?>
                        <span class="btn btn-sm btn-disabled" title="Articles liés">🗑️ Supprimer</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
