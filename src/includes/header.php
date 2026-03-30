<?php
/**
 * Header du FrontOffice — Style Le Monde
 * Variables attendues : $pageTitle, $metaDescription (optionnelles)
 */
if (!isset($pageTitle)) $pageTitle = 'Daily News — Informations et Analyses';
if (!isset($metaDescription)) $metaDescription = 'Daily News — votre source d\'informations et d\'analyses sur l\'actualité internationale.';

// Date formatée en français
$joursSemaine = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
$moisFr = ['','janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
$dateFr = $joursSemaine[(int)date('w')] . ' ' . date('j') . ' ' . $moisFr[(int)date('n')] . ' ' . date('Y');

$headerTypes = [];
if (isset($pdo) && function_exists('getArticleTypes')) {
    $headerTypes = getArticleTypes($pdo);
}

$currentTypeFilter = isset($_GET['type']) ? (string)$_GET['type'] : '';
$currentTypeFilter = preg_replace('/[^a-z0-9-]/', '', mb_strtolower($currentTypeFilter));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Binôme Web Design">
    <meta name="theme-color" content="#ffffff">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Source+Sans+3:wght@300;400;500;600;700&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Source+Sans+3:wght@300;400;500;600;700&display=swap"></noscript>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <!-- Barre utilitaire haute -->
        <div class="header-top">
            <div class="container">
                <span class="header-top-date"><?= $dateFr ?></span>
                <ul class="header-top-links">
                    <li><a href="/backoffice/">Espace rédaction</a></li>
                </ul>
            </div>
        </div>

        <!-- Zone logo / titre -->
        <div class="header-brand">
            <div class="container">
                <a href="/" class="logo" aria-label="Accueil">
                    <h1 class="site-title">Daily News</h1>
                    <p class="site-subtitle">Informations &amp; Analyses</p>
                </a>
            </div>
        </div>

        <!-- Navigation rubriques -->
        <nav class="navbar" aria-label="Navigation principale">
            <div class="container">
                <button class="nav-toggle" aria-label="Menu" aria-expanded="false">
                    <span class="hamburger"></span>
                </button>
                <ul class="nav-links">
                    <li><a href="/"<?= $currentTypeFilter === '' ? ' class="active"' : '' ?>>Accueil</a></li>
                    <?php foreach ($headerTypes as $type): ?>
                    <li>
                        <a href="/?type=<?= e($type['slug']) ?>"<?= $currentTypeFilter === $type['slug'] ? ' class="active"' : '' ?>>
                            <?= e($type['name']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="container">
