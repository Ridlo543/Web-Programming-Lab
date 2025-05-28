Berikut adalah materi mengenai **Cookies & Session** untuk mata kuliah Pemrograman Web:

---

# **Cookies & Session**

## **1. Perbedaan Cookies dan Session (Penjelasan Detail)**

| Aspek                   | Cookies                                                                                                                                                                             | Session                                                                                                                                                             |
| ----------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Penyimpanan**         | Cookies disimpan di sisi **klien**, yaitu di browser pengguna. Setiap kali pengguna mengunjungi website, browser akan mengirimkan cookie ke server.                                 | Session disimpan di sisi **server**. Klien hanya menyimpan ID session (biasanya dalam cookie), sementara data aslinya berada di server.                             |
| **Kapasitas**           | Cookie memiliki batasan ukuran sekitar **4KB per domain**. Jika data terlalu besar, tidak bisa disimpan di cookie.                                                                  | Session tidak memiliki batasan ukuran tetap, tetapi tergantung pada **konfigurasi dan memori server**. Umumnya digunakan untuk data yang lebih besar atau sensitif. |
| **Keamanan**            | Karena cookie berada di browser pengguna, cookie bisa dilihat, diubah, atau dicuri oleh pihak ketiga (misalnya dengan JavaScript jika tidak diatur dengan benar).                   | Lebih aman karena data session **tidak terlihat oleh klien**. Hanya ID session yang dikirim, sehingga data lebih terlindungi.                                       |
| **Waktu Kedaluwarsa**   | Cookie bisa memiliki waktu kedaluwarsa yang ditentukan saat dibuat. Setelah waktu tersebut, cookie akan otomatis dihapus.                                                           | Session biasanya akan berakhir saat browser ditutup, atau jika tidak aktif selama waktu tertentu (timeout).                                                         |
| **Akses antar halaman** | Cookie dikirim secara otomatis ke server setiap kali user berpindah halaman (selama domainnya sama), sehingga bisa digunakan untuk melacak data antar halaman atau antar kunjungan. | Session hanya aktif selama sesi user berlangsung dan digunakan untuk menyimpan data antar halaman **dalam satu kunjungan/sesi pengguna**.                           |
| **Contoh Penggunaan**   | Cocok untuk data yang tidak sensitif dan ingin disimpan dalam jangka panjang, seperti pengaturan bahasa, preferensi tema, atau informasi non-kritis.                                | Cocok untuk data yang bersifat sementara dan sensitif, seperti informasi login, data keranjang sementara, atau status transaksi.                                    |

---

### **Contoh Implementasi di Fitur Website**

#### **Cookies**

1. **Menyimpan Tema Tampilan Pengguna**

   * Misalnya pengguna memilih mode gelap (dark mode), nilai ini disimpan di cookie agar saat membuka ulang halaman, website tetap dalam mode gelap.
   * Implementasi:

     ```php
     setcookie("theme", "dark", time() + (86400 * 30)); // 30 hari
     ```

2. **Tracking Pengunjung untuk Analitik**

   * Digunakan oleh layanan seperti Google Analytics untuk mengenali pengunjung yang sama di waktu yang berbeda.
   * Cookie menyimpan ID unik untuk setiap pengunjung.

3. **Menyimpan Barang di Keranjang Belanja**

   * Pada toko online sederhana tanpa login, cookie bisa menyimpan daftar ID produk yang dimasukkan pengguna.

---

#### **Session**

1. **Autentikasi Pengguna Setelah Login**

   * Setelah pengguna berhasil login, data akun pengguna disimpan di session.
   * Saat berpindah halaman, session digunakan untuk memverifikasi bahwa pengguna masih login.
   * Implementasi:

     ```php
     session_start();
     $_SESSION["username"] = "andi123";
     ```

2. **Menyimpan Data Sementara Saat Checkout**

   * Saat proses pembelian yang terdiri dari beberapa langkah, data seperti alamat, pilihan pengiriman, dan pembayaran disimpan di session sebelum dikonfirmasi.

3. **Menyimpan Data Kuis/Ujian Online**

   * Untuk memastikan peserta tidak bisa mengulang soal dari awal, atau untuk melacak sisa waktu ujian, session digunakan sebagai penyimpanan data ujian sementara.

---

### **Kesimpulan**

* Gunakan **cookies** untuk menyimpan informasi ringan yang tidak sensitif dan perlu bertahan antar kunjungan.
* Gunakan **session** untuk informasi yang bersifat sensitif dan hanya perlu disimpan sementara selama pengguna aktif.


## **2. Membuat dan Mengelola Cookies di PHP**

### **Pengertian Cookie**

Cookie adalah data kecil yang disimpan oleh browser pada perangkat pengguna, dan dikirimkan kembali ke server setiap kali pengguna mengakses situs yang sama. Cookie digunakan untuk menyimpan informasi pengguna secara **persisten** antar kunjungan.


### **A. Membuat Cookie**

#### **Sintaks Dasar**

```php
setcookie(name, value, expire, path, domain, secure, httponly);
```

* `name`: Nama cookie.
* `value`: Nilai cookie (disimpan dalam format string).
* `expire`: Waktu kedaluwarsa dalam **timestamp Unix** (jumlah detik sejak 1 Januari 1970).
* `path`: Jalur (path) di mana cookie tersedia. Default `/`.
* `domain`: Domain yang dapat mengakses cookie (opsional).
* `secure`: Jika `true`, cookie hanya dikirim melalui HTTPS.
* `httponly`: Jika `true`, cookie tidak dapat diakses melalui JavaScript (untuk keamanan).

#### **Contoh Sederhana**

```php
// Membuat cookie 'user' dengan nilai 'Andi' selama 1 jam
setcookie("user", "Andi", time() + 3600);
```

* Cookie akan disimpan di browser dan akan tersedia dalam 1 jam ke depan.
* Cookie akan dikirim ke server saat pengguna mengakses kembali halaman dalam domain yang sama.

> **Catatan Penting:**
> Fungsi `setcookie()` **harus dipanggil sebelum ada output HTML** dikirim ke browser (tidak boleh setelah `echo`, `<html>`, dll.).

---

### **B. Membaca Cookie**

Cookie yang telah diset dan tersimpan di browser dapat diakses menggunakan array global `$_COOKIE`.

#### **Contoh:**

```php
if (isset($_COOKIE["user"])) {
    echo "Nama pengguna: " . $_COOKIE["user"];
} else {
    echo "Cookie tidak ditemukan.";
}
```

* `$_COOKIE["user"]` mengakses nilai cookie yang bernama `user`.
* Perlu dicek dengan `isset()` untuk memastikan cookie tersedia (karena bisa saja belum terset atau sudah kadaluarsa).

---

### **C. Menghapus Cookie**

Untuk menghapus cookie, kita perlu **mengatur waktu kedaluwarsa ke masa lalu**.

#### **Contoh:**

```php
// Menghapus cookie 'user'
setcookie("user", "", time() - 3600);
```

* Cookie `user` akan dianggap kadaluarsa oleh browser, dan akan dihapus.
* Proses ini harus dilakukan **dengan nama yang sama** seperti cookie yang ingin dihapus.

> **Catatan:** Menghapus cookie di server **tidak langsung menghapusnya dari browser**. Browser akan menghapus cookie saat menerima cookie baru dengan nama sama dan waktu kedaluwarsa di masa lalu.

---

### **Contoh Lengkap Pengelolaan Cookie**

```php
<?php
// Set cookie selama 1 jam
setcookie("theme", "dark", time() + 3600);

// Baca cookie
if (isset($_COOKIE["theme"])) {
    echo "Tema saat ini: " . $_COOKIE["theme"];
} else {
    echo "Belum ada tema disimpan.";
}

// Hapus cookie
// setcookie("theme", "", time() - 3600);
?>
```

---

### **Kapan Cookie Digunakan?**

* Menyimpan preferensi pengguna (tema, bahasa)
* Autentikasi login dasar (walaupun session lebih disarankan)
* Tracking pengguna antar halaman atau antar kunjungan

## **3. Session Management di PHP dan Timeout**

Session di PHP digunakan untuk menyimpan informasi pengguna di server **selama sesi berlangsung**. Tidak seperti cookie yang disimpan di browser, session menyimpan data di server dan lebih cocok untuk **data sensitif atau sementara** seperti data login, data keranjang belanja, dan status pengguna.

---

### **A. Memulai Session**

```php
session_start();
```

* Fungsi ini **wajib dipanggil di awal** setiap file PHP yang akan menggunakan session.
* `session_start()` akan:

  * Mengecek apakah session sudah ada. Jika belum, akan membuat session baru.
  * Mengaktifkan superglobal `$_SESSION`.
  * Mengirimkan cookie `PHPSESSID` ke browser jika belum ada.

> **Catatan:** `session_start()` harus dipanggil **sebelum ada output HTML** apa pun (seperti `echo`, tag HTML, atau spasi di luar PHP).

---

### **B. Menyimpan Data di Session**

```php
$_SESSION["username"] = "Andi";
```

* Menyimpan nilai ke dalam session.
* Data disimpan di sisi server dan hanya ID session yang dikirim ke browser melalui cookie.

Contoh lain:

```php
$_SESSION["role"] = "admin";
$_SESSION["login_time"] = time();
```

---

### **C. Mengakses Data dari Session**

```php
echo $_SESSION["username"];
```

* Mengambil nilai session yang telah disimpan.
* Harus memanggil `session_start()` sebelum mengakses `$_SESSION`.

Contoh pengecekan login:

```php
if (isset($_SESSION["username"])) {
    echo "Halo, " . $_SESSION["username"];
} else {
    echo "Silakan login terlebih dahulu.";
}
```


### **D. Menghapus Session**

#### **1. Menghapus Salah Satu Data di Session**

```php
unset($_SESSION["username"]);
```

* Menghapus elemen tertentu dari session.

#### **2. Menghapus Semua Data Session**

```php
session_unset();      // Menghapus semua variabel di $_SESSION
session_destroy();    // Mengakhiri session dan menghapus data dari server
```

> Setelah `session_destroy()`, variabel `$_SESSION` masih tersedia di memori, tapi data tidak bisa digunakan lagi.

---

### **E. Timeout Session (Manual Handling)**

PHP menyediakan konfigurasi default untuk session timeout, tetapi kita bisa membuat **timeout manual** menggunakan timestamp.

#### **Contoh Implementasi Timeout Session:**

```php
session_start();

$timeout = 600; // timeout 10 menit (600 detik)

if (isset($_SESSION['last_activity'])) {
    $inactive = time() - $_SESSION['last_activity'];
    if ($inactive > $timeout) {
        // Jika waktu tidak aktif lebih dari batas
        session_unset();
        session_destroy();
        echo "Sesi telah kedaluwarsa. Silakan login kembali.";
        exit();
    }
}

// Perbarui waktu aktivitas terakhir
$_SESSION['last_activity'] = time();
```

#### **Penjelasan Kode:**

* `$_SESSION['last_activity']` menyimpan waktu terakhir user aktif.
* Jika selisih waktu saat ini dan waktu terakhir aktivitas melebihi `$timeout`, maka session dihapus.
* Waktu aktivitas diperbarui setiap kali user mengakses halaman.

---

### **F. File dan Penyimpanan Session**

Secara default, PHP menyimpan file session di server, biasanya di direktori `/tmp`. File-file ini diberi nama seperti:

```
sess_a7f8b6de0fdf7e15a12345a6c982abc9
```

Untuk mengubah lokasi atau pengaturan session lainnya, dapat dilakukan lewat file `php.ini` atau secara programatik:

```php
ini_set('session.gc_maxlifetime', 1800); // 30 menit
ini_set('session.save_path', '/path/to/custom/session/dir');
session_start();
```

---

### **G. Contoh Kasus Penggunaan Session**

1. **Autentikasi Login**

   * Menyimpan `$_SESSION["user_id"]` setelah login berhasil.
2. **Form Multi-Tahap**

   * Menyimpan data form tahap 1 sebelum dikirim di tahap 2.
3. **Aplikasi Ujian Online**

   * Menyimpan skor sementara dan sisa waktu ujian pengguna.

---

### **Kesimpulan**

* **Session** adalah cara aman dan efisien untuk menyimpan data pengguna selama sesi aktif.
* Pastikan untuk selalu memulai session dengan `session_start()`.
* Implementasi timeout sangat penting untuk mencegah akses tidak sah setelah periode tidak aktif.


## **4. Cross-Site Request Forgery (CSRF)**

### **A. Apa Itu CSRF?**

**Cross-Site Request Forgery (CSRF)** adalah jenis serangan di mana penyerang mengeksploitasi **otentikasi dan sesi aktif** pengguna tanpa sepengetahuan atau persetujuan pengguna. Dengan kata lain, **penyerang membuat korban menjalankan perintah di situs web yang korban telah login ke dalamnya**.

> **CSRF = Menipu browser korban untuk mengirim request tidak sah ke server tempat korban telah login.**

---

### **B. Karakteristik Serangan CSRF**

* Terjadi **tanpa interaksi langsung dari pengguna**.
* Memanfaatkan **session/cookie yang sah** (misalnya, cookie login masih aktif).
* Sering ditujukan ke endpoint yang **melakukan aksi penting**, seperti:

  * Mengubah password
  * Transfer dana
  * Menghapus akun
  * Mengubah data pengguna

---

### **C. Ilustrasi Serangan CSRF (Langkah per Langkah)**

1. **Pengguna login ke situs A**

   * Situs A adalah situs yang sah (contoh: situs bank).
   * Setelah login, server memberikan session dan menyimpan cookie di browser pengguna.

2. **Pengguna mengunjungi situs berbahaya (situs B)**

   * Situs ini bisa berupa situs biasa, blog, atau halaman iklan yang disusupi skrip.

3. **Situs B menyisipkan permintaan otomatis ke situs A**

   * Contoh: tag HTML tersembunyi seperti berikut:

     ```html
     <img src="https://bank.com/transfer?to=hacker&amount=1000000" />
     ```

4. **Browser pengguna secara otomatis mengirimkan cookie login ke situs A**

   * Karena pengguna telah login dan cookie masih aktif, permintaan tersebut dianggap **sah oleh server situs A**.

5. **Server situs A memproses permintaan karena mengira berasal dari pengguna**

   * Akibatnya, **aksi yang tidak diinginkan dilakukan**, padahal pengguna tidak pernah berniat melakukannya.

---

### **D. Mengapa CSRF Berbahaya?**

* Serangan ini sulit dideteksi oleh pengguna.
* Tidak membutuhkan pencurian password.
* Bisa menyebabkan **kerugian finansial, pencurian data, atau perubahan data penting**.

### **E. Pencegahan CSRF di PHP**

#### **1. Menggunakan CSRF Token**

CSRF token adalah string acak yang disisipkan dalam setiap form dan diperiksa saat form dikirim. Karena token ini hanya dimiliki oleh pengguna sah, maka **permintaan dari pihak ketiga tidak bisa menebak token ini.**

---

#### **Langkah-Langkah Implementasi CSRF Token**

##### **1. Membuat Token Saat Memuat Form**

```php
session_start();

// Buat token baru jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Token acak 64 karakter
}
```

##### **2. Menyisipkan Token ke Dalam Form HTML**

```php
echo '<form method="post" action="proses.php">';
echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
echo '<input type="text" name="nama">';
echo '<input type="submit" value="Submit">';
echo '</form>';
```

* Token ini **tidak terlihat oleh pengguna**, tapi dikirim saat form disubmit.

##### **3. Memvalidasi Token di Server Saat Form Diproses**

```php
session_start();

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    // Token tidak cocok atau tidak ada
    die("Permintaan tidak valid (kemungkinan CSRF)");
}

// Lanjutkan proses form
```

> **Kenapa menggunakan `hash_equals()`?**
> Untuk mencegah serangan **timing attack**, yaitu serangan yang mencoba membedakan token melalui perbedaan waktu eksekusi.

---

### **F. Praktik Tambahan Pencegahan CSRF**

* Gunakan metode **POST** untuk operasi yang mengubah data, jangan GET.

  ```php
  session_set_cookie_params([
      'samesite' => 'Strict', // atau 'Lax'
      'httponly' => true,
      'secure' => true
  ]);
  session_start();
  ```
* Batasi waktu hidup CSRF token (misalnya 30 menit).
* Regenerasi token setelah token digunakan (opsional untuk tingkat lanjut).

---

### **G. Contoh Implementasi Lengkap**

#### **form.php**

```php
<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<form method="post" action="proses.php">
    Nama: <input type="text" name="nama"><br>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="submit" value="Kirim">
</form>
```

#### **proses.php**

```php
<?php
session_start();
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    die("Permintaan tidak valid (CSRF terdeteksi)");
}

$nama = htmlspecialchars($_POST['nama']);
echo "Data berhasil dikirim: $nama";
```

---

### **H. Kesimpulan**

* CSRF adalah serangan **sangat berbahaya** karena menyerang kepercayaan antara browser pengguna dan server.
* Pencegahan yang paling efektif adalah dengan menerapkan **CSRF token** secara konsisten di semua form yang melakukan aksi penting.
* Tambahan pengamanan seperti **SameSite cookie**, validasi metode HTTP, dan pembatasan waktu sesi juga sangat disarankan.


## REFERENCE
Berikut adalah daftar referensi yang dapat Anda gunakan untuk memperdalam pemahaman tentang **Cookies, Session, dan CSRF di PHP**:

---

## **Referensi Umum PHP (Resmi & Dokumentasi)**

- [PHP Manual: Session Handling](https://www.php.net/manual/en/book.session.php)
- [PHP Manual: setcookie() Function](https://www.php.net/manual/en/function.setcookie.php)
- [PHP Manual: random\_bytes() Function](https://www.php.net/manual/en/function.random-bytes.php)
- [PHP Manual: hash\_equals() Function](https://www.php.net/manual/en/function.hash-equals.php)
