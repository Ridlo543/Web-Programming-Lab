<?php
class Auth {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        $userModel = new User($this->pdo);
        $user = $userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['last_activity'] = time(); // Untuk timeout
            return true;
        }
        return false;
    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie('remember_me', '', time() - 3600, '/');
    }

    public function check() {
        if (isset($_SESSION['user_id'])) {
            // Periksa timeout (30 menit)
            if (time() - $_SESSION['last_activity'] > 1800) {
                $this->logout();
                return false;
            }
            $_SESSION['last_activity'] = time();
            return true;
        } elseif (isset($_COOKIE['remember_me'])) {
            $userModel = new User($this->pdo);
            $user = $userModel->findByToken($_COOKIE['remember_me']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['last_activity'] = time();
                return true;
            }
        }
        return false;
    }

    public function generateCsrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public function validateCsrfToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}