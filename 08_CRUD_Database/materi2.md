# Bab 8: Database (PHP & MySQL) - Implementasi CRUD dengan PHP

Dalam bab ini, kita akan mempelajari cara mengimplementasikan operasi **CRUD** (Create, Read, Update, Delete) menggunakan **PHP** dan **MySQL** pada aplikasi web sederhana. Aplikasi ini akan mengelola data pengguna (user) dengan fitur menampilkan daftar pengguna, menambah, mengedit, melihat detail, dan menghapus pengguna. Implementasi akan dilakukan secara bertahap dengan langkah-langkah yang mudah dipahami, dimulai dari menampilkan halaman utama tanpa pengolahan URL, kemudian menambahkan pengolahan string URL untuk mendukung operasi CRUD.

Kita akan menggunakan **XAMPP** dengan **Apache** sebagai server web, sehingga URL bersih (misalnya, `/create`) dapat bekerja dengan bantuan file `.htaccess`. Struktur proyek akan dijelaskan, dan setiap langkah akan disertai dengan penjelasan proses untuk pemula.

---

## Tujuan Pembelajaran
- Memahami cara menghubungkan PHP dengan MySQL menggunakan PDO.
- Membuat aplikasi CRUD sederhana dengan struktur MVC (Model-View-Controller).
- Mengimplementasikan routing sederhana untuk URL bersih tanpa `index.php`.
- Menangani operasi CRUD dengan aman menggunakan sanitasi input.

---

## Prasyarat
- **XAMPP** terinstal dan berjalan (Apache dan MySQL aktif).
- Database MySQL bernama `crud_db_pemweb8_1` dengan tabel `users`.
- Struktur proyek seperti berikut:

```
📦 project
├─ index.php
├─ [assets]
│  ├─ [image]
│  ├─ [js]
│  │  └─ script.js
│  └─ [css]
│     └─ style.css
├─ [controllers]
│  └─ UserController.php
├─ [database]
│  ├─ config.php
│  └─ [migrations]
│     └─ migration1.php
├─ [models]
│  └─ User.php
└─ [views]
   ├─ [components]
   ├─ [users]
   │  ├─ index.php
   │  ├─ create.php
   │  ├─ show.php
   │  └─ edit.php
   └─ others
```

- Proyek ditempatkan di `C:\xampp\htdocs\pemweb-crud1`, sehingga diakses melalui `http://localhost:8080/pemweb-crud1/`.

---

## Persiapan Database
Sebelum memulai, kita perlu menyiapkan database dan tabel.

1. **Buat Database**:
   Buka `http://localhost:8080/phpmyadmin`, lalu jalankan SQL berikut:
   ```sql
   CREATE DATABASE crud_db_pemweb8_1;
   ```

2. **Buat Tabel `users`**:
   Di database `crud_db_pemweb8_1`, jalankan:
   ```sql
   USE crud_db_pemweb8_1;
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(255) NOT NULL,
       email VARCHAR(255) NOT NULL UNIQUE,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```

3. **Konfigurasi Koneksi Database**:
   File `database/config.php` sudah disediakan untuk menghubungkan PHP dengan MySQL menggunakan PDO:
   ```php
   <?php
   // database/config.php
   $host = 'localhost';
   $dbname = 'crud_db_pemweb8_1';
   $username = 'root';
   $password = '';

   try {
       $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
       die("Koneksi gagal: " . $e->getMessage());
   }
   ```
   **Penjelasan**:
   - PDO digunakan untuk koneksi database yang aman.
   - Jika koneksi gagal, aplikasi akan menampilkan pesan error.

---

## Langkah-Langkah Implementasi CRUD

Kita akan membangun aplikasi CRUD secara bertahap, mulai dari menampilkan halaman utama hingga mendukung operasi CRUD dengan pengolahan URL.

### **Langkah 1: Menampilkan Halaman Index Tanpa Parameter**
Di langkah ini, kita akan membuat `index.php` yang hanya menampilkan daftar pengguna tanpa memproses parameter URL. Tujuannya adalah memahami dasar struktur MVC tanpa logika routing.

#### **Kode `index.php`**
```php
<?php
// index.php

// Sertakan file konfigurasi dan controller
require_once 'database/config.php'; // Koneksi database
require_once 'controllers/UserController.php';

// Buat objek controller untuk mengelola pengguna
$controller = new UserController($pdo);

// Tampilkan halaman daftar pengguna
$controller->index();
```

**Penjelasan Proses**:
- **Koneksi Database**: `database/config.php` menyediakan objek `$pdo` untuk mengakses database.
- **Controller**: `UserController` adalah kelas yang mengatur logika aplikasi, seperti menampilkan daftar pengguna.
- **Aksi `index`**: Memanggil `$controller->index()` untuk menampilkan `views/users/index.php`, yang berisi daftar pengguna.
- **Hasil**: Jika Anda membuka `http://localhost:8080/pemweb-crud1/`, Anda akan melihat daftar pengguna, tetapi link seperti "Tambah Pengguna" belum berfungsi.

#### **Kode `controllers/UserController.php`**
```php
<?php
// controllers/UserController.php
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

**Penjelasan**:
- `index()` memanggil metode `all()` dari model `User` untuk mengambil semua data pengguna.
- Data disimpan di variabel `$users` dan ditampilkan di `views/users/index.php`.

#### **Kode `models/User.php`**
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
}
```

**Penjelasan**:
- Model `User` berisi logika untuk mengambil data dari tabel `users`.
- Metode `all()` menjalankan query `SELECT * FROM users` dan mengembalikan semua baris.

#### **Kode `views/users/index.php`**
```php
<?php require_once 'views/components/header.php'; ?>

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
                    <a href="/show/<?= $user['id']; ?>">Lihat</a> |
                    <a href="/edit/<?= $user['id']; ?>">Edit</a> |
                    <a href="/delete/<?= $user['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once 'views/components/footer.php'; ?>
```

**Penjelasan**:
- Menampilkan daftar pengguna dalam tabel.
- Link `<a href="create">` menggunakan path relatif agar sesuai dengan subdirektori `pemweb-crud1`.
- `htmlspecialchars()` digunakan untuk mencegah serangan XSS.

#### **Kode `views/components/header.php` (Contoh)**
```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Sederhana</title>
    <link rel="stylesheet" href="/pemweb-crud1/assets/css/style.css">
</head>
<body>
    <div class="container">
```

#### **Tes Langkah 1**
1. Buka `http://localhost:8080/pemweb-crud1/`.
2. Anda akan melihat daftar pengguna (jika tabel `users` sudah berisi data).
3. Klik "Tambah Pengguna" atau link lain akan menghasilkan error 404 karena belum ada routing.

**Catatan**:
- Langkah ini sangat sederhana, hanya menampilkan satu halaman.
- Kita belum mendukung operasi lain (create, edit, dll.).

---

### **Langkah 2: Menambahkan Routing Sederhana untuk Operasi CRUD**
Sekarang kita akan memperbarui `index.php` untuk menangani URL seperti `/create`, `/show/1`, dll., dengan routing sederhana. Kita akan memproses parameter `url` dari `$_GET` dan menggunakan struktur yang mudah dipahami.

#### **Kode `index.php`**
```php
<?php
// index.php

// Sertakan file konfigurasi dan controller
require_once 'database/config.php'; // Koneksi database
require_once 'controllers/UserController.php';

// Buat objek controller untuk mengelola pengguna
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
        // Tampilkan form untuk menambah pengguna
        $controller->create();
        break;
    case 'store':
        // Simpan data pengguna baru
        $controller->store();
        break;
    case 'edit':
        // Tampilkan form untuk mengedit pengguna
        if ($id) {
            $controller->edit($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    case 'update':
        // Perbarui data pengguna
        if ($id) {
            $controller->update($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    case 'delete':
        // Hapus pengguna
        if ($id) {
            $controller->delete($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    case 'show':
        // Tampilkan detail pengguna
        if ($id) {
            $controller->show($id);
        } else {
            echo "ID tidak ditemukan.";
        }
        break;
    default:
        // Tampilkan daftar pengguna
        $controller->index();
        break;
}
```

**Penjelasan Proses**:
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

#### **Aktifkan URL Bersih dengan `.htaccess`**
Untuk membuat URL bersih (misalnya, `/create` alih-alih `index.php?url=create`), kita perlu file `.htaccess`:
```apache
# .htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
```

**Penjelasan**:
- `RewriteEngine On`: Mengaktifkan modul rewrite di Apache.
- `RewriteCond`: Memastikan permintaan bukan file atau direktori yang ada.
- `RewriteRule`: Mengarahkan semua permintaan ke `index.php` dengan parameter `url`.

**Konfigurasi Apache**:
1. Pastikan `mod_rewrite` aktif di `C:\xampp\apache\conf\httpd.conf`:
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
2. Pastikan `AllowOverride All`:
   ```apache
   <Directory "C:/xampp/htdocs">
       Options Indexes FollowSymLinks
       AllowOverride All
       Require all granted
   </Directory>
   ```
3. Restart Apache dari XAMPP Control Panel.

#### **Perbarui `UserController.php`**
Tambahkan semua metode untuk operasi CRUD:
```php
<?php
// controllers/UserController.php
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

    // Menampilkan form tambah pengguna
    public function create() {
        require_once 'views/users/create.php';
    }

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

    // Menampilkan form edit pengguna
    public function edit($id) {
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/edit.php';
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    }

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

    // Menghapus pengguna
    public function delete($id) {
        if ($this->user->delete($id)) {
            header('Location: /pemweb-crud1/');
        } else {
            echo "Gagal menghapus data.";
        }
    }

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

**Penjelasan**:
- Setiap metode menangani operasi CRUD:
  - `index`: Menampilkan daftar pengguna.
  - `create`: Menampilkan form tambah pengguna.
  - `store`: Menyimpan data pengguna baru.
  - `edit`: Menampilkan form edit pengguna.
  - `update`: Memperbarui data pengguna.
  - `delete`: Menghapus pengguna.
  - `show`: Menampilkan detail pengguna.
- Redirect menggunakan `/pemweb-crud1/` karena kita tidak menggunakan base URL dinamis.

#### **Perbarui `User.php`**
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

**Penjelasan**:
- Model berisi query SQL untuk operasi CRUD.
- Menggunakan prepared statements untuk keamanan.

#### **Perbarui View**
1. **views/users/create.php**:
   ```php
   <?php require_once 'views/components/header.php'; ?>
   <h2>Tambah Pengguna</h2>
   <form action="/pemweb-crud1/store" method="POST">
       <label>Nama:</label>
       <input type="text" name="name" required>
       <label>Email:</label>
       <input type="email" name="email" required>
       <button type="submit">Simpan</button>
   </form>
   <?php require_once 'views/components/footer.php'; ?>
   ```

2. **views/users/edit.php**:
   ```php
   <?php require_once 'views/components/header.php'; ?>
   <h2>Edit Pengguna</h2>
   <form action="/pemweb-crud1/update/<?= $user['id']; ?>" method="POST">
       <label>Nama:</label>
       <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
       <label>Email:</label>
       <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
       <button type="submit">Perbarui</button>
   </form>
   <?php require_once 'views/components/footer.php'; ?>
   ```

3. **views/users/show.php**:
   ```php
   <?php require_once 'views/components/header.php'; ?>
   <h2>Detail Pengguna</h2>
   <p><strong>ID:</strong> <?= $user['id']; ?></p>
   <p><strong>Nama:</strong> <?= htmlspecialchars($user['name']); ?></p>
   <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
   <p><strong>Dibuat pada:</strong> <?= $user['created_at']; ?></p>
   <a href="/pemweb-crud1/">Kembali</a>
   <?php require_once 'views/components/footer.php'; ?>
   ```

**Penjelasan**:
- View menggunakan path `/pemweb-crud1/` untuk link dan form agar sesuai dengan subdirektori.
- `htmlspecialchars()` mencegah XSS.

#### **Tes Langkah 2**
1. Buka `http://localhost:8080/pemweb-crud1/`.
2. Klik "Tambah Pengguna" (`/pemweb-crud1/create`) untuk menampilkan form.
3. Isi form dan simpan untuk menambah pengguna.
4. Coba edit, hapus, dan lihat detail pengguna.
5. Pastikan redirect kembali ke `/pemweb-crud1/`.

---

## Debugging dan Pemecahan Masalah
Jika aplikasi tidak berfungsi:
1. **Error 404**:
   - Periksa `.htaccess` dan pastikan `mod_rewrite` aktif.
   - Cek log Apache di `C:\xampp\apache\logs\error.log`.
2. **Error 403**:
   - Pastikan izin folder `C:\xampp\htdocs\pemweb-crud1` mengizinkan akses (beri "Full control" untuk "Everyone").
3. **Database Error**:
   - Verifikasi database `crud_db_pemweb8_1` dan tabel `users` di phpMyAdmin.
   - Tes koneksi dengan script sederhana:
     ```php
     <?php
     require_once 'database/config.php';
     echo "Koneksi berhasil!";
     ```
4. **Link Salah**:
   - Pastikan link menggunakan `/pemweb-crud1/` atau path relatif (`create`).
   - Debug URL dengan:
     ```php
     var_dump($urlParts); exit;
     ```

---

## Best Practice untuk Pemula
1. **Struktur MVC**:
   - Pisahkan logika (controller), data (model), dan tampilan (view).
2. **Keamanan**:
   - Gunakan `htmlspecialchars()` untuk output di view.
   - Gunakan prepared statements di model.
3. **Komentar Jelas**:
   - Tambahkan komentar untuk menjelaskan setiap langkah.
4. **URL Bersih**:
   - Gunakan `.htaccess` untuk menghilangkan `index.php` dari URL.

---

## Kesimpulan
Dalam bab ini, kita telah belajar:
- Menghubungkan PHP dengan MySQL menggunakan PDO.
- Membuat aplikasi CRUD dengan struktur MVC.
- Mengimplementasikan routing sederhana dengan dua langkah:
  1. Menampilkan halaman index tanpa parameter.
  2. Menambahkan pengolahan URL untuk operasi CRUD.
- Menggunakan `.htaccess` untuk URL bersih.

Aplikasi ini dapat diperluas dengan fitur seperti validasi form atau proteksi CSRF untuk meningkatkan keamanan.

--- 

**Catatan Tambahan**:
- Karena Anda memilih untuk tidak menggunakan base URL dinamis, pastikan semua link dan redirect menggunakan `/pemweb-crud1/` atau path relatif. Jika proyek dipindahkan ke subdirektori lain, Anda perlu mengubah path secara manual.
- Untuk portabilitas lebih baik, pertimbangkan menggunakan base URL dinamis di masa depan.