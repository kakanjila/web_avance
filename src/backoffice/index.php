<?php
/**
 * BackOffice - Point d'entrée
 * Redirige vers login ou dashboard
 */
require_once __DIR__ . '/../includes/auth.php';

if (isLoggedIn()) {
    header('Location: /backoffice/dashboard.php');
} else {
    header('Location: /backoffice/login.php');
}
exit;
