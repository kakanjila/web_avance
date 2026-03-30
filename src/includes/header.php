<?php
/**
 * Header du FrontOffice
 * Variables attendues : $pageTitle, $metaDescription (optionnelles)
 */
if (!isset($pageTitle)) $pageTitle = 'La Guerre en Iran - Informations et Analyses';
if (!isset($metaDescription)) $metaDescription = 'Site d\'informations complet sur la guerre en Iran : contexte historique, acteurs internationaux, impact humanitaire et conséquences économiques.';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Binôme Web Design">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <nav class="navbar" aria-label="Navigation principale">
            <div class="container">
                <a href="/" class="logo" aria-label="Accueil">
                    <h1 class="site-title">La Guerre en Iran</h1>
                </a>
                <button class="nav-toggle" aria-label="Menu" aria-expanded="false">
                    <span class="hamburger"></span>
                </button>
                <ul class="nav-links">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/article/contexte-historique-conflit-iran">Contexte</a></li>
                    <li><a href="/article/guerre-iran-irak-1980-1988">Guerre Iran-Irak</a></li>
                    <li><a href="/article/chronologie-evenements-majeurs">Chronologie</a></li>
                    <li><a href="/article/acteurs-internationaux-crise-iranienne">Acteurs</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main class="main-content">
        <div class="container">
