# Praktikum Pemrograman Web 8: CRUD Database

# Implementasi

## Arsitektur MVC (Model-View-Controller)
- **Model**: Mengelola data dan logika bisnis. Dalam contoh ini, model adalah `User.php` yang berfungsi untuk berinteraksi dengan database.
- **View**: Menampilkan data kepada pengguna. Dalam contoh ini, view adalah file HTML yang menampilkan daftar pengguna.
- **Controller**: Menghubungkan model dan view. Dalam contoh ini, controller adalah `UserController.php` yang mengatur logika aplikasi.

<img src="./assets/image.png" alt="MVC Architecture" width="75%" style="margin: 0 auto; display: block;">

## Contoh Struktur project

```
📦 project
├─ index.php
├─ [assets]
│  ├─ [image]
│  ├─ [js]
│  │  └─ script.js
│  └─ [css]
│     └─ style.css
├─ [controllers]
│  └─ UserController.php
├─ [database]
│  ├─ config.php
│  └─ [migrations]
│     └─ migration1.php
├─ [models]
│  └─ User.php
└─ [views]
   ├─ [components]
   ├─ [users]
   │  ├─ index.php
   │  ├─ create.php
   │  ├─ show.php
   │  └─ edit.php
   └─ others
```

## Database Connection

### Buat Skema Database

buat file di database/migration/migration1.php

```sql
CREATE DATABASE crud_db_pemweb8_1;

use crud_db_pemweb8_1;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Konfigurasi Database

buat file di database/config.php

```php
$host = 'localhost';
$dbname = 'crud_db_pemweb8_1';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // echo "Connected successfully";
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
```

## Menampilkan Data User

### Buat Model

buat file di models/User.php

```php
<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $statement = $this->pdo->query("SELECT * FROM users");
        return $statement->fetchAll(); // artinya ambil semua data
    }
}
```

### Buat Controller

Controller: UserController adalah kelas yang mengatur logika aplikasi, seperti menampilkan daftar pengguna.
buat file di controllers/UserController.php

```php
require_once 'models/User.php';

class UserController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    // Menampilkan daftar pengguna
    public function index() {
        $users = $this->user->all();
        require_once 'views/users/index.php';
    }
}
```

### Buat View

#### 1. buat file di root index.php

```php
<?php

require_once 'database/config.php';
require_once 'controllers/UserController.php';

$controller = new UserController($pdo);

$controller->index();
```

#### 2. buat file di views/users/index.php

Buat file html untuk menampilkan daftar pengguna. File ini akan menggunakan data yang diambil dari database melalui model dan controller.
terdapat tombol "Tambah Pengguna" yang mengarahkan ke halaman untuk menambah pengguna baru. dengan link yang relative ke root project

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Sederhana</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Daftar Pengguna</h2>
        <a href="create" class="btn">Tambah Pengguna</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= htmlspecialchars($user['name']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="show/<?= $user['id']; ?>">Lihat</a> |
                            <a href="edit/<?= $user['id']; ?>">Edit</a> |
                            <a href="delete/<?= $user['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>
```

Guanakan `htmlspecialchars()` untuk mencegah XSS (Cross-Site Scripting) dengan mengubah karakter khusus menjadi entitas HTML. XSS adalah singkatan dari Cross-Site Scripting, sebuah kerentanan keamanan web yang memungkinkan penyerang menyisipkan skrip berbahaya ke dalam halaman web yang kemudian dijalankan oleh pengguna lain.

#### 3. Bisa dipisah per components

buat file di views/components/header.php

```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Sederhana</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
```

buat file di views/components/footer.php

```php
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>
```

## Routing

Sekarang kita akan memperbarui index.php untuk menangani URL seperti /create, /show/1, dll., dengan routing sederhana. Kita akan memproses parameter url dari $\_GET

kode index.php

```php
<?php
require_once 'database/config.php';
require_once 'controllers/UserController.php';

$controller = new UserController($pdo);

// Langkah 1: Ambil alamat dari URL (misalnya, create, show/1)
$requestedUrl = ''; // Default: kosong
if (isset($_GET['url'])) {
    $requestedUrl = $_GET['url'];
    // Hapus tanda '/' di akhir (misalnya, create/ jadi create)
    $requestedUrl = rtrim($requestedUrl, '/');
}

// Langkah 2: Pecah URL menjadi bagian-bagian (misalnya, show/1 jadi ['show', '1'])
$urlParts = explode('/', $requestedUrl);

// Langkah 3: Tentukan aksi (halaman) yang diminta
$action = 'index'; // Default: halaman daftar pengguna
if (!empty($urlParts[0])) {
    $action = $urlParts[0]; // Misalnya, create, show
}

// Langkah 4: Ambil ID jika ada (misalnya, 1 untuk show/1)
$id = null; // Default: tidak ada ID
if (isset($urlParts[1])) {
    $id = $urlParts[1]; // Misalnya, 1
}

// Langkah 5: Pilih halaman berdasarkan aksi
switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store'
        $controller->store();
        break;
    case 'edit':
        if ($id) {
            $controller->edit($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    case 'update':
        if ($id) {
            $controller->update($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    case 'delete':
        if ($id) {
            $controller->delete($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    case 'show':
        if ($id) {
            $controller->show($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    default:
        $controller->index();
        break;
}
```

Penjelasan Proses:

1. **Mengambil URL**:
   - Parameter `url` diambil dari `$_GET['url']` (misalnya, `index.php?url=create` menghasilkan `create`).
   - `rtrim($requestedUrl, '/')` menghapus tanda `/` di akhir untuk konsistensi.
2. **Memecah URL**:
   - `explode('/', $requestedUrl)` memecah URL di tanda `/` menjadi array. Misalnya, `show/1` menjadi `['show', '1']`.
3. **Menentukan Aksi**:
   - Aksi default adalah `index`.
   - Jika ada elemen pertama (`$urlParts[0]`), itu menjadi aksi (misalnya, `create`).
4. **Mengambil ID**:
   - Jika ada elemen kedua (`$urlParts[1]`), itu menjadi ID (misalnya, `1`).
5. **Memilih Halaman**:
   - Struktur `switch` memetakan aksi ke metode di `UserController`.
   - Untuk aksi yang membutuhkan ID (`edit`, `update`, `delete`, `show`), kita memeriksa apakah `$id` ada.

### Clean URL dengan .htaccess

Untuk membuat URL lebih bersih, seperti Untuk membuat URL bersih (misalnya, /create alih-alih index.php?url=create), kita perlu file .htaccess di root project:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

# Jika menggunakan XAMPP, pastikan mod_rewrite diaktifkan
```

### Perbarui UserController untuk Menangani CRUD

Perbarui `UserController` untuk menangani semua operasi CRUD (Create, Read, Update, Delete).

```php
<?php

require_once 'models/User.php';

class UserController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    // GET
    // Menampilkan daftar pengguna
    public function index() {
        $users = $this->user->all();
        require_once 'views/users/index.php';
    }

    // GET
    // Menampilkan form tambah pengguna
    public function create() {
        require_once 'views/users/create.php';
    }

    // POST
    // Menyimpan pengguna baru
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'email' => htmlspecialchars($_POST['email'])
            ];
            if ($this->user->create($data)) {
                header('Location: /pemweb-crud1/');
            } else {
                echo "Gagal menyimpan data.";
            }
        }
    }

    // GET
    // Menampilkan form edit pengguna
    public function edit($id) {
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/edit.php';
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    }

    // POST
    // Memperbarui pengguna
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'email' => htmlspecialchars($_POST['email'])
            ];
            if ($this->user->update($id, $data)) {
                header('Location: /pemweb-crud1/');
            } else {
                echo "Gagal memperbarui data.";
            }
        }
    }

    // POST
    // Menghapus pengguna
    public function delete($id) {
        if ($this->user->delete($id)) {
            header('Location: /pemweb-crud1/');
        } else {
            echo "Gagal menghapus data.";
        }
    }

    // GET
    // Menampilkan detail pengguna
    public function show($id) {
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/show.php';
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    }
}
```

### Perbarui Model User.php agar Mendukung CRUD

Perbarui model `User` untuk menambahkan metode untuk menyimpan, memperbarui, menghapus, dan menemukan pengguna berdasarkan ID.

```php
<?php
// models/User.php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Mendapatkan semua pengguna
    public function all() {
        $statement = $this->pdo->query("SELECT * FROM users");
        return $statement->fetchAll();
    }

    // Mendapatkan pengguna berdasarkan ID
    public function find($id) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $statement->execute([$id]);
        return $statement->fetch();
    }

    // Membuat pengguna baru
    public function create($data) {
        $statement = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        return $statement->execute([$data['name'], $data['email']]);
    }

    // Memperbarui pengguna
    public function update($id, $data) {
        $statement = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $statement->execute([$data['name'], $data['email'], $id]);
    }

    // Menghapus pengguna
    public function delete($id) {
        $statement = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $statement->execute([$id]);
    }
}
```

### Buat View untuk Menambah Pengguna

#### 1. buat file di views/users/create.php

```php
<?php require_once 'views/components/header.php'; ?>
<h2>Tambah Pengguna</h2>
<form action="store" method="POST">
    <label>Nama:</label>
    <input type="text" name="name" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Simpan</button>
</form>
<?php require_once 'views/components/footer.php'; ?>a
```

#### 2. buat file di views/users/edit.php

```php
<?php require_once 'views/components/header.php'; ?>
<h2>Edit Pengguna</h2>
<form action="update/<?= $user['id']; ?>" method="POST">
    <label>Nama:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
    <button type="submit">Perbarui</button>
</form>
<?php require_once 'views/components/footer.php'; ?>
```

#### 3. buat file di views/users/show.php

```php
<?php require_once 'views/components/header.php'; ?>

<h2>Detail Pengguna</h2>
<p><strong>Nama:</strong> <?= htmlspecialchars($user['name']); ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
<p><strong>Dibuat:</strong> <?= $user['created_at']; ?></p>
<a href="/">Kembali</a>

<?php require_once 'views/components/footer.php'; ?>
```