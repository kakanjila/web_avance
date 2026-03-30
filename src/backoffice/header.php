<?php
/**
 * BackOffice - Header
 * Variables attendues : $boPageTitle (optionnel)
 */
require_once __DIR__ . '/../includes/auth.php';
requireLogin();

if (!isset($boPageTitle)) $boPageTitle = 'Administration';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= htmlspecialchars($boPageTitle, ENT_QUOTES, 'UTF-8') ?> - Administration</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <h2>Admin</h2>
            <p class="sidebar-user">Connecté : <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <nav class="sidebar-nav" aria-label="Navigation administration">
            <ul>
                <li><a href="/backoffice/dashboard.php" class="sidebar-link">📊 Tableau de bord</a></li>
                <li><a href="/backoffice/articles.php" class="sidebar-link">📝 Articles</a></li>
                <li><a href="/backoffice/article_form.php" class="sidebar-link">➕ Nouvel article</a></li>
                <li class="sidebar-divider"></li>
                <li><a href="/" class="sidebar-link" target="_blank">🌐 Voir le site</a></li>
                <li><a href="/backoffice/logout.php" class="sidebar-link sidebar-logout">🚪 Déconnexion</a></li>
            </ul>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" aria-label="Toggle menu">☰</button>
            <h1><?= htmlspecialchars($boPageTitle, ENT_QUOTES, 'UTF-8') ?></h1>
        </header>
        <div class="admin-content">
