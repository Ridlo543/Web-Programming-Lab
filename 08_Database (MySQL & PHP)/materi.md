# Praktikum Pemrograman Web: MySQL & PHP
# Praktikum Pemrograman Web: MySQL & PHP

## Pengenalan Database dan MySQL + PHP

### Apa Itu Database?

Database (basis data) adalah kumpulan data yang tersimpan secara sistematis dan dapat dikelola, diakses, serta diperbarui dengan mudah. Database digunakan untuk menyimpan informasi seperti data pengguna, produk, transaksi, dan lainnya.

### Manfaat Penggunaan Database

* Menyimpan data secara terstruktur dan efisien
* Memudahkan pencarian dan manipulasi data
* Mendukung multi-user environment
* Menjamin integritas dan keamanan data

### Apa Itu MySQL?

MySQL adalah sistem manajemen basis data relasional (RDBMS) berbasis SQL (Structured Query Language) yang bersifat open-source dan banyak digunakan dalam aplikasi web.

**Fitur MySQL:**

* Open source dan gratis
* Cepat dan handal
* Kompatibel dengan berbagai platform (Windows, Linux, macOS)
* Banyak didukung oleh komunitas dan dokumentasi

### Apa Itu PHP?

PHP (Hypertext Preprocessor) adalah bahasa pemrograman server-side yang digunakan untuk mengembangkan aplikasi web dinamis. PHP dapat terhubung dengan MySQL untuk membuat aplikasi web berbasis data.

### Mengapa Menggunakan MySQL dan PHP Bersama?

* Keduanya open source dan sering digunakan bersama dalam stack LAMP (Linux, Apache, MySQL, PHP)
* PHP memiliki fungsi-fungsi bawaan untuk koneksi dan manipulasi database MySQL
* Sangat cocok untuk membangun aplikasi CRUD (Create, Read, Update, Delete)

---

### 1. CREATE (Membuat Tabel)

```sql
CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    nim VARCHAR(20),
    jurusan_id INT
);
```

### 2. INSERT (Menambahkan Data)

```sql
INSERT INTO mahasiswa (nama, nim, jurusan_id)
VALUES ('Budi', '12345678', 1);
```

### 3. SELECT (Menampilkan Data)

```sql
SELECT * FROM mahasiswa;
```

### 4. UPDATE (Mengubah Data)

```sql
UPDATE mahasiswa
SET nama = 'Budi Santoso'
WHERE id = 1;
```

### 5. DELETE (Menghapus Data)

```sql
DELETE FROM mahasiswa
WHERE id = 1;
```

---

## Perbandingan MySQL vs SQL Server

| Aspek          | MySQL                              | SQL Server                        |
| -------------- | ---------------------------------- | --------------------------------- |
| Vendor         | Oracle                             | Microsoft                         |
| Tipe Data      | `VARCHAR`, `TEXT`, `INT`, dll      | `VARCHAR`, `NVARCHAR`, `INT`, dll |
| Auto Increment | `AUTO_INCREMENT`                   | `IDENTITY(1,1)`                   |
| Limitasi       | `LIMIT`                            | `TOP`, `OFFSET FETCH`             |
| Query Sampel   | `SELECT * FROM mahasiswa LIMIT 5;` | `SELECT TOP 5 * FROM mahasiswa;`  |

---

## Implementasi CRUD MySQL dengan PHP

### 1. Koneksi ke Database (`connect.php`)

```php
<?php
$koneksi = new mysqli("localhost", "root", "", "nama_database");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
```

### 2. Form Input Data (`form.html`)

```html
<form method="POST" action="proses_input.php">
    Nama: <input type="text" name="nama"><br>
    NIM: <input type="text" name="nim"><br>
    <input type="submit" value="Simpan">
</form>
```

### 3. Proses Input Data (`proses_input.php`)

```php
<?php
include 'connect.php';
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$sql = "INSERT INTO mahasiswa (nama, nim) VALUES ('$nama', '$nim')";
$koneksi->query($sql);
header("Location: tampil.php");
?>
```

### 4. Tampilkan Data (`tampil.php`)

```php
<?php
include 'connect.php';
$result = $koneksi->query("SELECT * FROM mahasiswa");
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Nama</th><th>NIM</th><th>Aksi</th></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nama']}</td>
        <td>{$row['nim']}</td>
        <td>
            <a href='edit.php?id={$row['id']}'>Edit</a> |
            <a href='hapus.php?id={$row['id']}'>Hapus</a>
        </td>
    </tr>";
}
echo "</table>";
?>
```

---

## Edit & Hapus Data

### Edit Data (`edit.php`)

```php
<?php
include 'connect.php';
$id = $_GET['id'];
$result = $koneksi->query("SELECT * FROM mahasiswa WHERE id=$id");
$data = $result->fetch_assoc();
?>
<form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    Nama: <input type="text" name="nama" value="<?= $data['nama'] ?>"><br>
    NIM: <input type="text" name="nim" value="<?= $data['nim'] ?>"><br>
    <input type="submit" value="Update">
</form>
```

### Update Data (`update.php`)

```php
<?php
include 'connect.php';
$id = $_POST['id'];
$nama = $_POST['nama'];
$nim = $_POST['nim'];
$sql = "UPDATE mahasiswa SET nama='$nama', nim='$nim' WHERE id=$id";
$koneksi->query($sql);
header("Location: tampil.php");
?>
```

### Hapus Data (`hapus.php`)

```php
<?php
include 'connect.php';
$id = $_GET['id'];
$koneksi->query("DELETE FROM mahasiswa WHERE id=$id");
header("Location: tampil.php");
?>
```

---

## Relasi Antar Tabel & JOIN

### Struktur Tabel

```sql
CREATE TABLE jurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(100)
);

-- Tabel mahasiswa sudah memiliki kolom jurusan_id sebagai foreign key
```

### Contoh INNER JOIN

```sql
SELECT mahasiswa.nama, mahasiswa.nim, jurusan.nama_jurusan
FROM mahasiswa
INNER JOIN jurusan ON mahasiswa.jurusan_id = jurusan.id;
```

### Contoh LEFT JOIN

```sql
SELECT mahasiswa.nama, mahasiswa.nim, jurusan.nama_jurusan
FROM mahasiswa
LEFT JOIN jurusan ON mahasiswa.jurusan_id = jurusan.id;
```

---

## Contoh Kasus One-to-Many

Relasi one-to-many terjadi ketika satu baris di tabel A dapat dikaitkan dengan banyak baris di tabel B.

### Studi Kasus:
- **Satu jurusan** memiliki **banyak mahasiswa**
- Tabel `jurusan` berperan sebagai **parent**
- Tabel `mahasiswa` berperan sebagai **child** (menggunakan `jurusan_id` sebagai foreign key)

### Struktur Tabel:

```sql
CREATE TABLE jurusan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(100)
);

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    nim VARCHAR(20),
    jurusan_id INT,
    FOREIGN KEY (jurusan_id) REFERENCES jurusan(id)
);
```

### Penjelasan:
- Tabel `jurusan` menyimpan data master untuk setiap jurusan.
- Tabel `mahasiswa` menyimpan data mahasiswa dan mengacu ke `jurusan_id` sebagai penghubung ke tabel `jurusan`.

### Contoh Data:

Tabel `jurusan`:

| id | nama_jurusan       |
|----|---------------------|
| 1  | Teknik Informatika |
| 2  | Sistem Informasi   |

Tabel `mahasiswa`:

| id | nama         | nim      | jurusan_id |
|----|--------------|----------|------------|
| 1  | Andi         | 12345678 | 1          |
| 2  | Budi         | 87654321 | 1          |
| 3  | Citra        | 11223344 | 2          |

### Visualisasi Relasi:

```
jurusan
  ├─ Teknik Informatika (id: 1)
  │   ├─ Andi
  │   └─ Budi
  └─ Sistem Informasi (id: 2)
      └─ Citra
```

### Kesimpulan:
Relasi one-to-many sangat umum digunakan untuk mengelola data yang saling terkait dan menghindari duplikasi data di database relasional.

---

### Referensi
- [W3Schools – SQL JOINs](https://www.w3schools.com/sql/sql_join.asp)  
- [TutorialsPoint – SQL One-to-Many Relationship](https://www.tutorialspoint.com/sql/sql-one-to-many-relationship.htm)  
- [GeeksForGeeks – SQL JOINs](https://www.geeksforgeeks.org/sql-join-set-1-inner-left-right-and-full-joins/)  

---
