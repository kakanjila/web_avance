<?php
// Fichier de test pour vérifier le URL rewriting

// Récupérer l'URI demandée
$request_uri = $_SERVER['REQUEST_URI'];
$request_method = $_SERVER['REQUEST_METHOD'];
$script_name = $_SERVER['SCRIPT_NAME'];

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head><title>Test URL Rewriting</title>";
echo "<style>body { font-family: monospace; margin: 20px; } .success { color: green; } .info { background: #f0f0f0; padding: 10px; margin: 10px 0; }</style>";
echo "</head>";
echo "<body>";

echo "<h1>🔗 Test d'URL Rewriting</h1>";
echo "<div class='info'>";
echo "<strong>REQUEST_URI:</strong> " . htmlspecialchars($request_uri) . "<br>";
echo "<strong>SCRIPT_NAME:</strong> " . htmlspecialchars($script_name) . "<br>";
echo "<strong>REQUEST_METHOD:</strong> " . htmlspecialchars($request_method) . "<br>";
echo "</div>";

// Test 1: Accueil
if ($request_uri === '/' || $request_uri === '') {
    echo "<p class='success'>✅ Accueil détecté (rewriting fonctionne!)</p>";
} else if ($request_uri === '/article/guerre-iran-2026' || strpos($request_uri, '/article/') === 0) {
    echo "<p class='success'>✅ Article détecté (rewriting fonctionne!)</p>";
} else {
    echo "<p>📌 URI: " . htmlspecialchars($request_uri) . "</p>";
}

echo "<h2>Tests disponibles:</h2>";
echo "<ul>";
echo "<li><a href='/'>Accueil</a></li>";
echo "<li><a href='/article/guerre-iran-2026'>Article (rewriting)</a></li>";
echo "<li><a href='/actualites'>Actualités</a></li>";
echo "<li><a href='/actualites/guerre-iran-2026'>Article via actualites (rewriting)</a></li>";
echo "</ul>";

echo "<h2>Fichiers de configuration:</h2>";
echo "<pre>";
if (file_exists('.htaccess')) {
    echo "✅ .htaccess présent\n";
    echo "Taille: " . filesize('.htaccess') . " bytes\n";
} else {
    echo "❌ .htaccess manquant\n";
}

// Vérifier mod_rewrite
if (extension_loaded('mod_rewrite')) {
    echo "✅ Extension mod_rewrite active\n";
} else if (in_array('mod_rewrite', apache_get_modules())) {
    echo "✅ Module Apache mod_rewrite active\n";
} else {
    echo "⚠️ mod_rewrite statut inconnu\n";
}
echo "</pre>";

echo "</body></html>";
?>
