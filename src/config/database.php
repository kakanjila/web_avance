<?php
$host = 'db'; 
$dbname = 'seo';
$user = 'admin';
$password = 'admin';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

/**
 * Formate une date en français sans utiliser strftime() (dépréciée en PHP 8.1+)
 * @param string $date_string Date à formater (format: YYYY-MM-DD ou timestamp)
 * @return string Date formatée en français (format: "29 mars 2026")
 */
function formatDateFR($date_string) {
    $mois_fr = [
        'janvier', 'février', 'mars', 'avril', 'mai', 'juin',
        'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'
    ];
    
    $timestamp = strtotime($date_string);
    if ($timestamp === false) {
        return $date_string; // Retourne la valeur originale si invalide
    }
    
    $jour = date('d', $timestamp);
    $mois_index = (int)date('n', $timestamp) - 1;
    $annee = date('Y', $timestamp);
    
    // Retirer les zéros inutiles du jour
    $jour = (int)$jour;
    
    return $jour . ' ' . $mois_fr[$mois_index] . ' ' . $annee;
}
?>
