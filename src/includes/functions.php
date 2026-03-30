<?php
/**
 * Fonctions utilitaires du site
 */

/**
 * Génère un slug à partir d'un titre
 */
function generateSlug(string $title): string {
    $slug = mb_strtolower($title, 'UTF-8');
    $slug = preg_replace('/[àáâãäå]/u', 'a', $slug);
    $slug = preg_replace('/[èéêë]/u', 'e', $slug);
    $slug = preg_replace('/[ìíîï]/u', 'i', $slug);
    $slug = preg_replace('/[òóôõö]/u', 'o', $slug);
    $slug = preg_replace('/[ùúûü]/u', 'u', $slug);
    $slug = preg_replace('/[ýÿ]/u', 'y', $slug);
    $slug = preg_replace('/[ç]/u', 'c', $slug);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

/**
 * Échappe les caractères HTML
 */
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Récupère tous les articles publiés
 */
function getPublishedArticles(PDO $pdo, int $limit = 0, ?string $typeSlug = null): array {
    $sql = "SELECT a.*, t.name AS type_name, t.slug AS type_slug
            FROM articles a
            LEFT JOIN article_types t ON t.id = a.type_id
            WHERE a.published = true";

    if (!empty($typeSlug)) {
        $sql .= " AND t.slug = :type_slug";
    }

    $sql .= " ORDER BY a.created_at DESC";

    if ($limit > 0) {
        $sql .= " LIMIT :limit";
    }

    $stmt = $pdo->prepare($sql);

    if (!empty($typeSlug)) {
        $stmt->bindValue(':type_slug', $typeSlug, PDO::PARAM_STR);
    }

    if ($limit > 0) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère un article par son slug
 */
function getArticleBySlug(PDO $pdo, string $slug): ?array {
    $stmt = $pdo->prepare("SELECT a.*, t.name AS type_name, t.slug AS type_slug
                           FROM articles a
                           LEFT JOIN article_types t ON t.id = a.type_id
                           WHERE a.slug = :slug AND a.published = true");
    $stmt->execute(['slug' => $slug]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    return $article ?: null;
}

/**
 * Récupère un article par son ID
 */
function getArticleById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    return $article ?: null;
}

/**
 * Récupère tous les articles (pour le backoffice)
 */
function getAllArticles(PDO $pdo): array {
    $stmt = $pdo->query("SELECT a.*, t.name AS type_name, t.slug AS type_slug
                         FROM articles a
                         LEFT JOIN article_types t ON t.id = a.type_id
                         ORDER BY a.created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les types d'articles
 */
function getArticleTypes(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id, name, slug FROM article_types ORDER BY name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Tronque un texte HTML en texte brut
 */
function truncateText(string $html, int $length = 200): string {
    $text = strip_tags($html);
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '...';
}

/**
 * Génère l'URL d'un article
 */
function articleUrl(string $slug): string {
    return '/article/' . e($slug);
}

/**
 * Formate une date
 */
function formatDate(string $date): string {
    $dt = new DateTime($date);
    return $dt->format('d/m/Y à H:i');
}
