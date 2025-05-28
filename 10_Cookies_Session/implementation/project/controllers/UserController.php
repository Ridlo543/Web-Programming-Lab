<?php
require_once 'models/User.php';
require_once 'models/Auth.php';

class UserController {
    private $user;
    private $auth;

    public function __construct($pdo) {
        $this->user = new User($pdo);
        $this->auth = new Auth($pdo);
    }

    private function checkAuth() {
        if (!$this->auth->check()) {
            header('Location: /pemweb_crud/login');
            exit;
        }
    }

    public function index() {
        $this->checkAuth();
        $users = $this->user->all();
        require_once 'views/users/index.php';
    }

    public function create() {
        $this->checkAuth();
        require_once 'views/users/create.php';
    }

    public function store() {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
            header('Location: /pemweb_crud');
            exit;
        }

        if (!$this->auth->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $errors[] = "CSRF token tidak valid.";
            require_once 'views/users/create.php';
            return;
        }

        $data = [
            'name' => htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'phone' => filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING),
            'password' => $_POST['password'] ?? ''
        ];

        $errors = [];
        if (!is_string($data['name'])) {
            $errors[] = "Nama harus berupa teks.";
        }
        if (empty($data['name']) || !preg_match('/^[a-zA-Z\s\']+$/', $data['name'])) {
            $errors[] = "Nama hanya boleh berisi huruf, spasi, atau apostrof.";
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

        if (!empty($errors)) {
            $old = $data;
            require_once 'views/users/create.php';
            return;
        }

        if ($this->user->create($data)) {
            header('Location: /pemweb_crud');
        } else {
            $errors[] = "Gagal menyimpan data.";
            $old = $data;
            require_once 'views/users/create.php';
        }
    }

    public function edit($id) {
        $this->checkAuth();
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/edit.php';
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    }

    public function update($id) {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
            header('Location: /pemweb_crud');
            exit;
        }

        if (!$this->auth->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $errors[] = "CSRF token tidak valid.";
            $user = $this->user->find($id);
            require_once 'views/users/edit.php';
            return;
        }

        $data = [
            'name' => htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'phone' => filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING),
            'password' => $_POST['password'] ?? ''
        ];

        $errors = [];
        if (!is_string($data['name'])) {
            $errors[] = "Nama harus berupa teks.";
        }
        if (empty($data['name']) || !preg_match('/^[a-zA-Z\s\']+$/', $data['name'])) {
            $errors[] = "Nama hanya boleh berisi huruf, spasi, atau apostrof.";
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid.";
        }
        if (!empty($data['phone']) && !preg_match('/^(08|\+62)\d{8,11}$/', $data['phone'])) {
            $errors[] = "Nomor telepon tidak valid.";
        }
        if (!empty($data['password']) && strlen($data['password']) < 8) {
            $errors[] = "Kata sandi baru minimal 8 karakter.";
        }

        if (!empty($errors)) {
            $old = $data;
            $user = $this->user->find($id);
            require_once 'views/users/edit.php';
            return;
        }

        if ($this->user->update($id, $data)) {
            header('Location: /pemweb_crud');
        } else {
            $errors[] = "Gagal memperbarui data.";
            $old = $data;
            $user = $this->user->find($id);
            require_once 'views/users/edit.php';
        }
    }

    public function delete($id) {
        $this->checkAuth();
        if ($this->user->delete($id)) {
            header('Location: /pemweb_crud');
        } else {
            echo "Gagal menghapus data.";
        }
    }

    public function show($id) {
        $this->checkAuth();
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/show.php';
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    }
}