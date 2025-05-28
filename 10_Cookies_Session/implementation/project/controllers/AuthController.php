<?php
require_once 'models/Auth.php';
require_once 'models/User.php';

class AuthController {
    private $auth;
    private $user;

    public function __construct($pdo) {
        $this->auth = new Auth($pdo);
        $this->user = new User($pdo);
    }

    public function login() {
        if ($this->auth->check()) {
            header('Location: /pemweb_crud');
            exit;
        }
        require_once 'views/auth/login.php';
    }

    public function doLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
            header('Location: /pemweb_crud/login');
            exit;
        }

        if (!$this->auth->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $errors[] = "CSRF token tidak valid.";
            require_once 'views/auth/login.php';
            return;
        }

        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        $errors = [];
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid.";
        }
        if (empty($password)) {
            $errors[] = "Kata sandi wajib diisi.";
        }

        if (empty($errors) && $this->auth->login($email, $password)) {
            if ($remember) {
                $token = bin2hex(random_bytes(16));
                $this->user->updateToken($_SESSION['user_id'], $token);
                setcookie('remember_me', $token, time() + (30 * 24 * 3600), '/', '', false, true);
            }
            header('Location: /pemweb_crud');
        } else {
            $errors[] = "Email atau kata sandi salah.";
            require_once 'views/auth/login.php';
        }
    }

    public function register() {
        if ($this->auth->check()) {
            header('Location: /pemweb_crud');
            exit;
        }
        require_once 'views/auth/register.php';
    }

    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
            header('Location: /pemweb_crud/register');
            exit;
        }

        if (!$this->auth->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $errors[] = "CSRF token tidak valid.";
            require_once 'views/auth/register.php';
            return;
        }

        $data = [
            'name' => htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'phone' => filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING),
            'password' => $_POST['password'] ?? ''
        ];

        $errors = [];
        if (empty($data['name']) || !preg_match('/^[a-zA-Z\s\']+$/', $data['name'])) {
            $errors[] = "Nama wajib diisi dan hanya boleh huruf.";
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid.";
        }
        if (!empty($data['phone']) && !preg_match('/^(08|\+62)\d{8,11}$/', $data['phone'])) {
            $errors[] = "Nomor telepon tidak valid.";
        }
        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors[] = "Kata sandi minimal 8 karakter.";
        }

        if (empty($errors) && $this->user->create($data)) {
            $this->auth->login($data['email'], $data['password']);
            header('Location: /pemweb_crud');
        } else {
            $old = $data;
            $errors[] = $errors ? $errors[0] : "Gagal mendaftar.";
            require_once 'views/auth/register.php';
        }
    }

    public function logout() {
        $this->auth->logout();
        header('Location: /pemweb_crud/login');
    }
}