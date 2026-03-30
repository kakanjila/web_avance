<?php
/**
 * Gestion de l'authentification
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Exige une connexion - redirige sinon
 */
function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /backoffice/login.php');
        exit;
    }
}

/**
 * Tente de connecter un utilisateur
 */
function attemptLogin(PDO $pdo, string $username, string $password): bool {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        session_regenerate_id(true);
        return true;
    }
    return false;
}

/**
 * Déconnecte l'utilisateur
 */
function logout(): void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
