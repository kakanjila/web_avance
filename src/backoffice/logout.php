<?php
/**
 * BackOffice - Déconnexion
 */
require_once __DIR__ . '/../includes/auth.php';
logout();
header('Location: /backoffice/login.php');
exit;
