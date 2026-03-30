<?php
/**
 * BackOffice - Formulaire d'ajout/édition d'article
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;
$article = null;
$errors = [];

if ($isEdit) {
    $article = getArticleById($pdo, $id);
    if (!$article) {
        header('Location: /backoffice/articles.php');
        exit;
    }
}

$boPageTitle = $isEdit ? 'Modifier l\'article' : 'Nouvel article';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';
    $slug = trim($_POST['slug'] ?? '');
    $metaDescription = trim($_POST['meta_description'] ?? '');
    $imageAlt = trim($_POST['image_alt'] ?? '');
    $published = isset($_POST['published']) ? true : false;
    
    // Validation
    if (empty($title)) {
        $errors[] = 'Le titre est obligatoire.';
    }
    if (empty($content)) {
        $errors[] = 'Le contenu est obligatoire.';
    }
    
    // Générer le slug si vide
    if (empty($slug)) {
        $slug = generateSlug($title);
    } else {
        $slug = generateSlug($slug);
    }
    
    // Vérifier l'unicité du slug
    $slugCheck = $pdo->prepare("SELECT id FROM articles WHERE slug = :slug AND id != :id");
    $slugCheck->execute(['slug' => $slug, 'id' => $id]);
    if ($slugCheck->fetch()) {
        $errors[] = 'Ce slug est déjà utilisé par un autre article.';
    }
    
    // Upload d'image
    $imagePath = $isEdit ? ($article['image_path'] ?? '') : '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Format d\'image non autorisé. Utilisez JPG, PNG, WebP ou GIF.';
        } else {
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['image']['size'] > $maxSize) {
                $errors[] = 'L\'image ne doit pas dépasser 5 Mo.';
            } else {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = $slug . '-' . time() . '.' . $ext;
                $uploadDir = __DIR__ . '/../assets/img/uploads/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                    $imagePath = '/assets/img/uploads/' . $filename;
                } else {
                    $errors[] = 'Erreur lors de l\'upload de l\'image.';
                }
            }
        }
    }
    
    if (empty($errors)) {
        if ($isEdit) {
            $stmt = $pdo->prepare("UPDATE articles SET title = :title, content = :content, slug = :slug, 
                meta_description = :meta_description, image_path = :image_path, image_alt = :image_alt, 
                published = :published, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
            $stmt->execute([
                'title' => $title,
                'content' => $content,
                'slug' => $slug,
                'meta_description' => $metaDescription,
                'image_path' => $imagePath,
                'image_alt' => $imageAlt,
                'published' => $published ? 'true' : 'false',
                'id' => $id
            ]);
            header('Location: /backoffice/articles.php?success=updated');
        } else {
            $stmt = $pdo->prepare("INSERT INTO articles (title, content, slug, meta_description, image_path, image_alt, published) 
                VALUES (:title, :content, :slug, :meta_description, :image_path, :image_alt, :published)");
            $stmt->execute([
                'title' => $title,
                'content' => $content,
                'slug' => $slug,
                'meta_description' => $metaDescription,
                'image_path' => $imagePath,
                'image_alt' => $imageAlt,
                'published' => $published ? 'true' : 'false'
            ]);
            header('Location: /backoffice/articles.php?success=created');
        }
        exit;
    }
    
    // En cas d'erreur, préparer l'article avec les données soumises
    $article = [
        'id' => $id,
        'title' => $title,
        'content' => $content,
        'slug' => $slug,
        'meta_description' => $metaDescription,
        'image_path' => $imagePath,
        'image_alt' => $imageAlt,
        'published' => $published
    ];
}

require_once __DIR__ . '/header.php';
?>

<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="" enctype="multipart/form-data" class="article-form">
    <div class="form-row">
        <div class="form-col-8">
            <div class="form-group">
                <label for="title">Titre *</label>
                <input type="text" id="title" name="title" required 
                       value="<?= htmlspecialchars($article['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Titre de l'article">
            </div>
            
            <div class="form-group">
                <label for="slug">Slug (URL)</label>
                <input type="text" id="slug" name="slug" 
                       value="<?= htmlspecialchars($article['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Sera généré automatiquement si vide">
                <small>Laissez vide pour générer automatiquement à partir du titre</small>
            </div>
            
            <div class="form-group">
                <label for="content">Contenu *</label>
                <textarea id="content" name="content" rows="20"><?= htmlspecialchars($article['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
        </div>
        
        <div class="form-col-4">
            <div class="form-group">
                <label for="meta_description">Méta description (SEO)</label>
                <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                          placeholder="Description pour les moteurs de recherche (max 160 caractères)"><?= htmlspecialchars($article['meta_description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                <small class="char-count">0/160 caractères</small>
            </div>
            
            <div class="form-group">
                <label for="image">Image principale</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
                <?php if (!empty($article['image_path'])): ?>
                <div class="current-image">
                    <img src="<?= htmlspecialchars($article['image_path'], ENT_QUOTES, 'UTF-8') ?>" 
                         alt="Image actuelle" class="preview-img">
                    <small>Image actuelle</small>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="image_alt">Texte alternatif de l'image (SEO)</label>
                <input type="text" id="image_alt" name="image_alt" 
                       value="<?= htmlspecialchars($article['image_alt'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Description de l'image pour le SEO">
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="published" value="1" 
                           <?= (!$isEdit || ($article['published'] ?? false)) ? 'checked' : '' ?>>
                    Publier l'article
                </label>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-block">
                    <?= $isEdit ? 'Mettre à jour' : 'Créer l\'article' ?>
                </button>
                <a href="/backoffice/articles.php" class="btn btn-secondary btn-block">Annuler</a>
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.tiny.cloud/1/8ygrf2ghui3zezqy4cr0sadf5tvwmcqh9cf1mrru4omszmzg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#content',
    language: 'fr_FR',
    height: 500,
    menubar: true,
    plugins: 'lists link image table code wordcount fullscreen',
    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code fullscreen',
    block_formats: 'Paragraphe=p; Titre 2=h2; Titre 3=h3; Titre 4=h4; Titre 5=h5; Titre 6=h6',
    content_style: 'body { font-family: Segoe UI, sans-serif; font-size: 16px; line-height: 1.6; }',
    branding: false,
    promotion: false
});
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
