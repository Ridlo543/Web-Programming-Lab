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

## Materi MySQL Dasar

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

CRUD (Create, Read, Update, Delete) merupakan operasi dasar dalam pengelolaan data pada sistem basis data. PHP dan MySQL sering digunakan bersama untuk membangun aplikasi web dinamis yang memerlukan interaksi dengan database.

### 1. Koneksi ke Database (`connect.php`)

File ini digunakan untuk membuat koneksi ke database MySQL.

```php
<?php
$koneksi = new mysqli("localhost", "root", "", "nama_database");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
```

**Penjelasan:**

* `localhost`: Server database, default-nya adalah localhost untuk pengembangan lokal.
* `root`: Username default dari MySQL.
* `""`: Password default kosong (jika tidak diubah).
* `nama_database`: Ganti dengan nama database yang akan digunakan.
* `die()`: Menghentikan eksekusi program jika koneksi gagal.

### 2. Form Input Data (`form.html`)

Form HTML sederhana untuk menginput data ke database.

```html
<form method="POST" action="proses_input.php">
    Nama: <input type="text" name="nama"><br>
    NIM: <input type="text" name="nim"><br>
    <input type="submit" value="Simpan">
</form>
```

**Penjelasan:**

* `method="POST"`: Mengirim data secara aman ke server.
* `action="proses_input.php"`: Data akan diproses oleh file `proses_input.php`.

### 3. Proses Input Data (`proses_input.php`)

Menerima input dari form dan menyimpannya ke database.

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

**Penjelasan:**

* `include 'connect.php'`: Memanggil file koneksi.
* `$_POST['nama']`: Mengambil data dari input form.
* `INSERT INTO`: Menyimpan data ke tabel `mahasiswa`.
* `header("Location: tampil.php")`: Mengarahkan kembali ke halaman tampilan data.

> ⚠️ **Catatan Keamanan:**
> Langkah ini sebaiknya disertai dengan validasi dan sanitasi input (misalnya menggunakan `mysqli_real_escape_string` atau prepared statements) untuk menghindari serangan SQL Injection.

### 4. Tampilkan Data (`tampil.php`)

Menampilkan data mahasiswa dalam bentuk tabel.

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

**Penjelasan:**

* `SELECT * FROM mahasiswa`: Mengambil seluruh data dari tabel mahasiswa.
* `fetch_assoc()`: Mengubah hasil query menjadi array asosiatif.
* Menampilkan setiap data dalam baris tabel HTML.
* Disediakan link untuk edit dan hapus berdasarkan `id`.

---

## Edit & Hapus Data

Fitur edit dan hapus digunakan untuk memperbarui data yang telah disimpan atau menghapus data yang tidak diperlukan.

### Edit Data (`edit.php`)

File ini digunakan untuk menampilkan form dengan data yang sudah ada agar bisa diedit.

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

**Penjelasan:**

* `$_GET['id']`: Mengambil ID dari URL.
* `SELECT * FROM mahasiswa WHERE id=$id`: Mengambil data mahasiswa berdasarkan ID.
* Form akan menampilkan data lama agar bisa diperbarui.
* Nilai ID disimpan secara tersembunyi (`hidden`) untuk digunakan saat update.

> Disarankan untuk memvalidasi dan membersihkan input `$_GET['id']` agar terhindar dari SQL injection.

### Update Data (`update.php`)

File ini memproses perubahan data dari form edit.

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

**Penjelasan:**

* `$_POST['id']`, `$_POST['nama']`, dan `$_POST['nim']`: Mengambil data hasil input dari form.
* `UPDATE mahasiswa SET ...`: Mengubah data mahasiswa di database.
* Setelah update selesai, pengguna diarahkan kembali ke halaman tampil data.

> Gunakan prepared statement (`$stmt = $koneksi->prepare(...)`) untuk keamanan lebih baik.

### Hapus Data (`hapus.php`)

File ini akan menghapus data berdasarkan ID yang dipilih.

```php
<?php
include 'connect.php';
$id = $_GET['id'];
$koneksi->query("DELETE FROM mahasiswa WHERE id=$id");
header("Location: tampil.php");
?>
```

**Penjelasan:**

* `$_GET['id']`: Mengambil ID dari URL yang dipilih untuk dihapus.
* `DELETE FROM mahasiswa WHERE id=$id`: Menghapus data dari tabel mahasiswa.
* Setelah dihapus, pengguna diarahkan kembali ke daftar data.

>  Selalu validasi input dan pastikan bahwa `id` benar-benar ada sebelum melakukan query delete.

---

## 🔗 Relasi Antar Tabel & JOIN

Relasi antar tabel adalah konsep penting dalam database relasional. Relasi ini digunakan untuk menghubungkan data antar tabel agar lebih terstruktur dan efisien. Salah satu contoh relasi umum adalah **one-to-many**.

### Contoh Kasus: Mahasiswa dan Jurusan

Setiap mahasiswa hanya memiliki satu jurusan, namun satu jurusan bisa memiliki banyak mahasiswa. Ini adalah relasi **one-to-many** dari `jurusan` ke `mahasiswa`.

### Struktur Tabel

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
- `jurusan.id` adalah **primary key**.
- `mahasiswa.jurusan_id` adalah **foreign key** yang merujuk ke `jurusan.id`.

---

### JOIN pada SQL

##### 1. INNER JOIN

Digunakan untuk mengambil data yang memiliki pasangan yang cocok di kedua tabel.

```sql
SELECT mahasiswa.nama, mahasiswa.nim, jurusan.nama_jurusan
FROM mahasiswa
INNER JOIN jurusan ON mahasiswa.jurusan_id = jurusan.id;
```

📌 **Catatan**:
- Hanya mahasiswa yang memiliki `jurusan_id` yang sesuai di tabel `jurusan` yang akan ditampilkan.

---

##### 2. LEFT JOIN

Mengambil semua data dari tabel kiri (`mahasiswa`), dan data yang cocok dari tabel kanan (`jurusan`). Jika tidak ada pasangan di tabel kanan, maka akan ditampilkan `NULL`.

```sql
SELECT mahasiswa.nama, mahasiswa.nim, jurusan.nama_jurusan
FROM mahasiswa
LEFT JOIN jurusan ON mahasiswa.jurusan_id = jurusan.id;
```

📌 **Catatan**:
- Mahasiswa tanpa jurusan tetap ditampilkan, tetapi `nama_jurusan` akan bernilai `NULL`.

---

#### Ilustrasi Visual

```
[ jurusan ]               [ mahasiswa ]
 id | nama_jurusan   <--  jurusan_id | nama | nim
```

---

#### Kesimpulan

- Gunakan **INNER JOIN** jika hanya ingin menampilkan data yang memiliki pasangan di kedua tabel.
- Gunakan **LEFT JOIN** jika ingin menampilkan semua data dari tabel utama (mahasiswa), meskipun tidak ada pasangan di tabel relasi (jurusan).

---

##  Contoh Kasus One-to-Many

* **Satu jurusan** memiliki **banyak mahasiswa**
* Tabel `jurusan` → parent
* Tabel `mahasiswa` → child (menggunakan `jurusan_id` sebagai foreign key)

---

### Referensi
- [W3Schools – SQL JOINs](https://www.w3schools.com/sql/sql_join.asp)  
- [TutorialsPoint – SQL One-to-Many Relationship](https://www.tutorialspoint.com/sql/sql-one-to-many-relationship.htm)  
- [GeeksForGeeks – SQL JOINs](https://www.geeksforgeeks.org/sql-join-set-1-inner-left-right-and-full-joins/)  

---
