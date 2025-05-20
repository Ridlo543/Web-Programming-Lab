# Sanitasi dan Validasi Input

- Untuk Apa: Membersihkan input pengguna dari karakter berbahaya atau tidak diinginkan untuk mencegah serangan seperti XSS (Cross-Site Scripting) atau injeksi data.
- Mengapa Penting: Input pengguna tidak bisa dipercaya. Tanpa sanitasi, penyerang bisa menyisipkan kode berbahaya (misalnya, `<script>alert('hacked')</script>`) yang dieksekusi di browser pengguna lain.
- Bagaimana Diterapkan:
  - `htmlspecialchars()`: Mengkodekan karakter khusus (misalnya, < menjadi `&lt;`) agar aman ditampilkan di HTML.
  - `filter_var()`: Menyaring input berdasarkan tipe (misalnya, FILTER_SANITIZE_EMAIL menghapus karakter tidak valid dari email).

# Regular Expression

- Untuk Apa: Memeriksa apakah input cocok dengan pola tertentu (misalnya, format nomor telepon atau nama tanpa angka).
- Mengapa Penting: Regex memungkinkan validasi format yang kompleks yang tidak bisa ditangani oleh fungsi sederhana seperti filter_var(). Misalnya, memastikan nama hanya berisi huruf dan spasi.
- Bagaimana Diterapkan:
  - Gunakan `preg_match($pattern, $input)` untuk mencocokkan pola.
  - Contoh pola:
    - Nama: `/^[a-zA-Z\s\']+$/` (huruf, spasi, apostrof).
    - Telepon: `/^(08|\+62)\d{8,11}$/` (format Indonesia).

# Implementasi

## Perbarui Struktur Database

Tambahkan kolom phone dan password ke tabel users di database/migration/

```sql
CREATE DATABASE IF NOT EXISTS crud_db_pemweb8_1;
USE crud_db_pemweb8_1;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

atau

```sql
ALTER TABLE users
ADD phone VARCHAR(15),
ADD password VARCHAR(255) NOT NULL;
```

## Perbarui Model User.php

Sesuaikan model untuk menangani kolom baru (phone, password)

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

    public function delete($id) {
        $statement = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $statement->execute([$id]);
    }
}
```

- create: Menyimpan name, email, phone (opsional), dan password (dihash).
- update: Memperbarui name, email, phone, dan password (jika diisi).
- password_hash(): Mengamankan kata sandi dengan hash bcrypt.
- phone: Menggunakan null jika tidak diisi, sesuai kolom opsional.

## Perbarui Form pada views

### Tambahkan input untuk phone, password, dan pesan error pada views/users/create.php

```php

<?php require_once 'views/components/header.php'; ?>

<h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Pengguna</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/pemweb_crud/store" method="POST" class="space-y-4 max-w-md" enctype="multipart/form-data">
    <div>
        <label class="block text-gray-700 mb-1">Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? ''); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? ''); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Nomor Telepon:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($old['phone'] ?? ''); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 081234567890">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Kata Sandi:</label>
        <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Foto Profil (opsional):</label>
        <input type="file" name="photo" accept="image/jpeg,image/png" class="w-full px-3 py-2 border rounded">
    </div>
    <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
</form>

<?php require_once 'views/components/footer.php'; ?>
```

- Input Baru: Tambah phone, password, dan photo (file upload opsional).
- Error Display: Menampilkan pesan error jika $errors ada.
- Form State: Menggunakan $old untuk mempertahankan input (didefinisikan di controller).
- Client-Side: Atribut required dan type="email" untuk validasi dasar.
- File Upload: Atribut enctype="multipart/form-data" untuk mendukung upload file.

### Perbarui View edit.php

Sesuaikan form edit untuk mendukung kolom baru dan validasi.

```php
<?php require_once 'views/components/header.php'; ?>

<h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Pengguna</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/pemweb_crud/update/<?= $user['id']; ?>" method="POST" class="space-y-4 max-w-md" enctype="multipart/form-data">
    <div>
        <label class="block text-gray-700 mb-1">Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? $user['name']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? $user['email']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Nomor Telepon:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($old['phone'] ?? $user['phone']); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 081234567890">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Kata Sandi Baru (kosongkan jika tidak diubah):</label>
        <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Foto Profil Baru (opsional):</label>
        <input type="file" name="photo" accept="image/jpeg,image/png" class="w-full px-3 py-2 border rounded">
    </div>
    <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbarui</button>
</form>

<?php require_once 'views/components/footer.php'; ?>
```

- Input Baru: phone, password (opsional), dan photo.
- Form State: $old digunakan jika validasi gagal, fallback ke $user.
- Password Opsional: Kosongkan untuk tidak mengubah kata sandi.
- Error Display: Sama seperti create.php untuk menampilkan pesan error.

### Perbarui View index.php dan show.php

Tambahkan kolom phone di daftar dan detail pengguna.

views/users/index.php

```php
<?php require_once 'views/components/header.php'; ?>

<h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Pengguna</h2>
<a href="/pemweb_crud/create" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">Tambah Pengguna</a>
<table class="w-full border-collapse bg-white shadow-md rounded">
    <thead>
        <tr class="bg-gray-200">
            <th class="border px-4 py-2 text-left">ID</th>
            <th class="border px-4 py-2 text-left">Nama</th>
            <th class="border px-4 py-2 text-left">Email</th>
            <th class="border px-4 py-2 text-left">Telepon</th>
            <th class="border px-4 py-2 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td class="border px-4 py-2"><?= $user['id']; ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($user['name']); ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($user['email']); ?></td>
                <td class="border px-4 py-2"><?= htmlspecialchars($user['phone'] ?? '-'); ?></td>
                <td class="border px-4 py-2 space-x-2">
                    <a href="/pemweb_crud/show/<?= $user['id']; ?>" class="text-blue-500 hover:underline">Lihat</a>
                    <a href="/pemweb_crud/edit/<?= $user['id']; ?>" class="text-green-500 hover:underline">Edit</a>
                    <a href="/pemweb_crud/delete/<?= $user['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-500 hover:underline">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/components/footer.php'; ?>
```

views/users/show.php

```php
<?php require_once 'views/components/header.php'; ?>

<h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Pengguna</h2>
<div class="bg-white p-6 rounded shadow-md max-w-md">
    <p class="mb-2"><strong>Nama:</strong> <?= htmlspecialchars($user['name']); ?></p>
    <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
    <p class="mb-2"><strong>Telepon:</strong> <?= htmlspecialchars($user['phone'] ?? '-'); ?></p>
    <p class="mb-4"><strong>Dibuat:</strong> <?= $user['created_at']; ?></p>
    <a href="/pemweb_crud" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
</div>

<?php require_once 'views/components/footer.php'; ?>
```

## Perbarui Controller untuk Validasi

Perbarui UserController.php untuk menangani validasi input pada metode store (create) dan update (edit)

```php
<?php
require_once 'models/User.php';

class UserController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function index() {
        $users = $this->user->all();
        require_once 'views/users/index.php';
    }

    public function create() {
        require_once 'views/users/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
            header('Location: /pemweb_crud');
            exit;
        }

        // Sanitasi input
        $data = [
            'name' => htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'phone' => filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING),
            'password' => $_POST['password'] ?? ''
        ];

        // Validasi input
        $errors = [];

        // Validasi tipe data
        if (!is_string($data['name'])) {
            $errors[] = "Nama harus berupa teks.";
        }

        // Validasi wajib
        if (empty($data['name'])) {
            $errors[] = "Nama wajib diisi.";
        } elseif (!preg_match('/^[a-zA-Z\s\']+$/', $data['name'])) {
            $errors[] = "Nama hanya boleh berisi huruf, spasi, atau apostrof.";
        }

        if (empty($data['email'])) {
            $errors[] = "Email wajib diisi.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid.";
        }

        if (!empty($data['phone']) && !preg_match('/^(08|\+62)\d{8,11}$/', $data['phone'])) {
            $errors[] = "Nomor telepon tidak valid (contoh: 081234567890 atau +6281234567890).";
        }

        if (empty($data['password'])) {
            $errors[] = "Kata sandi wajib diisi.";
        } elseif (strlen($data['password']) < 8) {
            $errors[] = "Kata sandi minimal 8 karakter.";
        }

        // Validasi file upload (opsional)
        if (!empty($_FILES['photo']['name'])) {
            $file = $_FILES['photo'];
            $allowedTypes = ['image/jpeg', 'image/png'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($file['type'], $allowedTypes)) {
                $errors[] = "File harus berupa JPEG atau PNG.";
            }
            if ($file['size'] > $maxSize) {
                $errors[] = "File terlalu besar (maksimum 2MB).";
            }
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Gagal mengunggah file.";
            }
        }

        // Jika ada error, tampilkan kembali form
        if (!empty($errors)) {
            $old = $data;
            require_once 'views/users/create.php';
            return;
        }

        // Simpan file jika ada
        if (!empty($_FILES['photo']['name']) && empty($errors)) {
            $uploadDir = 'assets/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = uniqid() . '-' . basename($file['name']);
            $uploadPath = $uploadDir . $fileName;
            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $errors[] = "Gagal menyimpan file.";
                $old = $data;
                require_once 'views/users/create.php';
                return;
            }
            // Simpan path file ke data (opsional, jika tabel mendukung)
            // $data['photo'] = $uploadPath;
        }

        // Simpan ke database
        if ($this->user->create($data)) {
            header('Location: /pemweb_crud');
        } else {
            $errors[] = "Gagal menyimpan data.";
            $old = $data;
            require_once 'views/users/create.php';
        }
    }

    public function edit($id) {
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/edit.php';
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
            header('Location: /pemweb_crud');
            exit;
        }

        // Sanitasi input
        $data = [
            'name' => htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
            'phone' => filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING),
            'password' => $_POST['password'] ?? ''
        ];

        // Validasi input
        $errors = [];

        if (!is_string($data['name'])) {
            $errors[] = "Nama harus berupa teks.";
        }

        if (empty($data['name'])) {
            $errors[] = "Nama wajib diisi.";
        } elseif (!preg_match('/^[a-zA-Z\s\']+$/', $data['name'])) {
            $errors[] = "Nama hanya boleh berisi huruf, spasi, atau apostrof.";
        }

        if (empty($data['email'])) {
            $errors[] = "Email wajib diisi.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email tidak valid.";
        }

        if (!empty($data['phone']) && !preg_match('/^(08|\+62)\d{8,11}$/', $data['phone'])) {
            $errors[] = "Nomor telepon tidak valid (contoh: 081234567890 atau +6281234567890).";
        }

        if (!empty($data['password']) && strlen($data['password']) < 8) {
            $errors[] = "Kata sandi baru minimal 8 karakter.";
        }

        // Validasi file upload (opsional)
        if (!empty($_FILES['photo']['name'])) {
            $file = $_FILES['photo'];
            $allowedTypes = ['image/jpeg', 'image/png'];
            $maxSize = 2 * 1024 * 1024; // 2MB

            if (!in_array($file['type'], $allowedTypes)) {
                $errors[] = "File harus berupa JPEG atau PNG.";
            }
            if ($file['size'] > $maxSize) {
                $errors[] = "File terlalu besar (maksimum 2MB).";
            }
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Gagal mengunggah file.";
            }
        }

        // Jika ada error, tampilkan kembali form
        if (!empty($errors)) {
            $old = $data;
            $user = $this->user->find($id);
            require_once 'views/users/edit.php';
            return;
        }

        // Simpan file jika ada
        if (!empty($_FILES['photo']['name']) && empty($errors)) {
            $uploadDir = 'assets/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = uniqid() . '-' . basename($file['name']);
            $uploadPath = $uploadDir . $fileName;
            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $errors[] = "Gagal menyimpan file.";
                $old = $data;
                $user = $this->user->find($id);
                require_once 'views/users/edit.php';
                return;
            }
            // Simpan path file ke data (opsional)
            // $data['photo'] = $uploadPath;
        }

        // Update database
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
        if ($this->user->delete($id)) {
            header('Location: /pemweb_crud');
        } else {
            echo "Gagal menghapus data.";
        }
    }

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
