# Implementation

Fitur:

- Session: Autentikasi login untuk mengakses halaman CRUD.
- Cookies: Opsi "Remember Me" untuk login otomatis.
- CSRF Protection: Melindungi form create, update, dan login.
- Session Timeout: Sesi kadaluarsa setelah 30 menit tidak aktif.


### Implementasi Remember me dengan cookies, tambahkan kolom remember token di table user.

```sql
CREATE DATABASE IF NOT EXISTS crud_db_pemweb8_1;
USE crud_db_pemweb8_1;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL, -- Kolom untuk token Remember Me
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Kolom remember_token ditambahkan untuk menyimpan token unik yang digunakan untuk autentikasi otomatis via cookie.
Fitur "Remember Me" memungkinkan pengguna tetap login meski browser ditutup, dengan menyimpan token di database dan cookie.

### Perbaruii Model Users

Tambahkan metode untuk autentikasi dan pengelolaan token "Remember Me"

```php
<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $statement = $this->pdo->query("SELECT * FROM users");
        return $statement->fetchAll();
    }

    public function find($id) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function findByEmail($email) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $statement->execute([$email]);
        return $statement->fetch();
    }

    public function findByToken($token) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
        $statement->execute([$token]);
        return $statement->fetch();
    }

    public function create($data) {
        $statement = $this->pdo->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        return $statement->execute([
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?";
        $params = [$data['name'], $data['email'], $data['phone'] ?? null];

        if (!empty($data['password'])) {
            $sql .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $statement = $this->pdo->prepare($sql);
        return $statement->execute($params);
    }

    public function updateToken($id, $token) {
        $statement = $this->pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
        return $statement->execute([$token, $id]);
    }

    public function delete($id) {
        $statement = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $statement->execute([$id]);
    }
}
``` 

- Tambah findByEmail untuk mencari pengguna saat login.
- Tambah findByToken untuk memverifikasi cookie "Remember Me".
- updateToken untuk menyimpan token "Remember Me" ke database.

### Membuat Model untuk menangani autentikasi, session da CSRF

buat model Auth.php di folder models/
```php
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
```

- login: Verifikasi email dan password, simpan data pengguna ke session.
- logout: Hapus session dan cookie "Remember Me".
- check: Periksa status login (via session atau cookie) dan timeout.
- generateCsrfToken dan validateCsrfToken: Kelola token CSRF untuk form.

- Session digunakan untuk menyimpan status login sementara, aman karena data disimpan di server.
- Timeout (30 menit) mencegah akses tidak sah jika pengguna lupa logout.
- Cookie "Remember Me" memungkinkan login otomatis dengan token unik.
- CSRF token melindungi form dari serangan pihak ketiga.
- hash_equals digunakan untuk validasi CSRF agar tahan terhadap timing attacks.

### buat Controller untuk auth

AuthController: Controller untuk autentikasi login dan register.

```php
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
```

- login dan doLogin: Menampilkan dan memproses form login, dengan validasi CSRF dan fitur "Remember Me".
- register dan doRegister: Menampilkan dan memproses form registrasi, dengan validasi CSRF dan otomatis login setelah registrasi.
- logout: Mengakhiri session dan menghapus cookie
- 

### Perbarui UserController

Tambahkan autentikasi dan CSRF protection untuk form create dan update.

```php
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
```

- Tambah checkAuth untuk memastikan hanya pengguna terautentikasi yang bisa mengakses CRUD.
- Tambah validasi CSRF di store dan update.


### Perbarui header untuk navigasi autentikasi

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Sederhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-4 py-8">
        <nav class="mb-6">
            <ul class="flex space-x-4">
                <li><a href="/pemweb_crud" class="text-blue-500 hover:underline">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/pemweb_crud/logout" class="text-red-500 hover:underline">Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="/pemweb_crud/login" class="text-blue-500 hover:underline">Login</a></li>
                    <li><a href="/pemweb_crud/register" class="text-blue-500 hover:underline">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
```

### Buat View untuk login register

views/auth/login.php:
```php
<?php
require_once 'views/components/header.php';
require_once 'models/Auth.php';
$auth = new Auth($pdo);
?>

<h2 class="text-2xl font-bold mb-6">Login</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/pemweb_crud/doLogin" method="POST" class="space-y-4 max-w-md">
    <input type="hidden" name="csrf_token" value="<?= $auth->generateCsrfToken(); ?>">
    <div>
        <label class="block mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Kata Sandi:</label>
        <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="flex items-center">
            <input type="checkbox" name="remember" class="mr-2"> Ingat Saya
        </label>
    </div>
    <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</button>
</form>

<?php require_once 'views/components/footer.php'; ?>
```

views/auth/register.php:
```php
<?php
require_once 'views/components/header.php';
require_once 'models/Auth.php';
$auth = new Auth($pdo);
?>

<h2 class="text-2xl font-bold mb-6">Register</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/pemweb_crud/doRegister" method="POST" class="space-y-4 max-w-md">
    <input type="hidden" name="csrf_token" value="<?= $auth->generateCsrfToken(); ?>">
    <div>
        <label class="block mb-1">Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? ''); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Nomor Telepon:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($old['phone'] ?? ''); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 081234567890">
    </div>
    <div>
        <label class="block mb-1">Kata Sandi:</label>
        <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Daftar</button>
</form>

<?php require_once 'views/components/footer.php'; ?>
```

### Perbarui View agar mendukung CSRF token

CSRF token melindungi aksi create dari serangan

views/users/create.php:
```php
<?php
require_once 'views/components/header.php';
require_once 'models/Auth.php';
$auth = new Auth($pdo);
?>

<h2 class="text-2xl font-bold mb-6">Tambah Pengguna</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/pemweb_crud/store" method="POST" class="space-y-4 max-w-md">
    <input type="hidden" name="csrf_token" value="<?= $auth->generateCsrfToken(); ?>">
    <div>
        <label class="block mb-1">Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? ''); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div trent">
        <label class="block mb-1">Nomor Telepon:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($old['phone'] ?? ''); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 081234567890">
    </div>
    <div>
        <label class="block mb-1">Kata Sandi:</label>
        <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
</form>

<?php require_once 'views/components/footer.php'; ?>
```

views/users/edit.php:
```php
<?php
require_once 'views/components/header.php';
require_once 'models/Auth.php';
$auth = new Auth($pdo);
?>

<h2 class="text-2xl font-bold mb-6">Edit Pengguna</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/pemweb_crud/update/<?= $user['id']; ?>" method="POST" class="space-y-4 max-w-md">
    <input type="hidden" name="csrf_token" value="<?= $auth->generateCsrfToken(); ?>">
    <div>
        <label class="block mb-1">Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? $user['name']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? $user['email']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Nomor Telepon:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($old['phone'] ?? $user['phone']); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 081234567890">
    </div>
    <div>
        <label class="block mb-1">Kata Sandi Baru (kosongkan jika tidak diubah):</label>
        <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbarui</button>
</form>

<?php require_once 'views/components/footer.php'; ?>
```

### Perbarui index.pho di root untuk menambah autentikasi

```php
<?php
session_start();
require_once 'database/config.php';
require_once 'controllers/UserController.php';
require_once 'controllers/AuthController.php';

$controller = new UserController($pdo);
$authController = new AuthController($pdo);

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$url = explode('/', $url);

$action = isset($url[0]) && !empty($url[0]) ? $url[0] : 'index';
$id = isset($url[1]) ? $url[1] : null;

switch ($action) {
    case 'login':
        $authController->login();
        break;
    case 'doLogin':
        $authController->doLogin();
        break;
    case 'register':
        $authController->register();
        break;
    case 'doRegister':
        $authController->doRegister();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        if ($id) $controller->edit($id);
        break;
    case 'update':
        if ($id) $controller->update($id);
        break;
    case 'delete':
        if ($id) $controller->delete($id);
        break;
    case 'show':
        if ($id) $controller->show($id);
        break;
    default:
        $controller->index();
        break;
}
```

- Tambah session_start() di awal untuk mengelola session. session_start() diperlukan untuk semua halaman yang menggunakan session.
- routing untuk login, register, dan logout

