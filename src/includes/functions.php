<?php

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

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function getPublishedArticles(PDO $pdo, int $limit = 0): array {
    $sql = "SELECT * FROM articles WHERE published = true ORDER BY created_at DESC";
    if ($limit > 0) {
        $sql .= " LIMIT :limit";
    }
    $stmt = $pdo->prepare($sql);
    if ($limit > 0) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getArticleBySlug(PDO $pdo, string $slug): ?array {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = :slug AND published = true");
    $stmt->execute(['slug' => $slug]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    return $article ?: null;
}

function getArticleById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
    return $article ?: null;
}

function getAllArticles(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function truncateText(string $html, int $length = 200): string {
    $text = strip_tags($html);
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '...';
}

function articleUrl(string $slug): string {
    return '/article/' . e($slug);
}

function formatDate(string $date): string {
    $dt = new DateTime($date);
    return $dt->format('d/m/Y à H:i');
}
