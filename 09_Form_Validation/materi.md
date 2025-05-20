## Validasi & Keamanan Input Data dalam PHP

### Pengertian Umum

Dalam pengembangan aplikasi web, data yang dikirimkan oleh pengguna (user input) sangat rentan terhadap berbagai bentuk penyalahgunaan. Oleh karena itu, diperlukan mekanisme untuk memastikan bahwa data tersebut:

1. **Benar secara format dan jenisnya** (validasi), dan
2. **Aman untuk diproses dan disimpan** (sanitasi/keamanan input).

Dengan menerapkan validasi dan sanitasi, kita dapat:

* Mencegah eksekusi kode berbahaya.
* Melindungi struktur dan isi database dari kerusakan.
* Menjaga kepercayaan pengguna terhadap keamanan aplikasi.
* Mengurangi risiko sistem crash akibat data tidak sesuai.

---

### Apa itu Validasi?

**Validasi** adalah proses **memverifikasi** bahwa data yang dikirim oleh pengguna **memenuhi aturan yang ditetapkan**. Validasi memastikan bahwa data tersebut:

* Memiliki format yang sesuai (contoh: tanggal, email, URL).
* Memiliki tipe data yang diharapkan (angka, string, boolean, dsb).
* Tidak kosong (untuk field wajib).
* Memenuhi batasan panjang atau nilai minimum/maksimum.

Contoh validasi:

* Cek apakah kolom email benar-benar berisi alamat email yang valid.
* Cek apakah umur adalah angka dan berada dalam rentang 17–99.
* Pastikan nama tidak kosong dan tidak lebih dari 100 karakter.

Validasi bisa dilakukan di:

* **Client-side**: menggunakan JavaScript (cepat, tapi bisa dilewati).
* **Server-side**: menggunakan PHP (lebih aman, wajib dilakukan).

---

### Apa itu Sanitasi?

**Sanitasi** adalah proses **membersihkan input dari karakter atau nilai yang tidak aman** sebelum data tersebut diproses atau ditampilkan kembali. Ini melibatkan:

* Menghapus karakter yang tidak diinginkan.
* Menghindari injeksi kode ke dalam HTML, JavaScript, atau SQL.
* Menyaring nilai-nilai yang berpotensi menyebabkan error atau celah keamanan.

Contoh:

* Pengguna menginputkan: `<script>alert('xss')</script>`
* Jika langsung ditampilkan, ini akan menjalankan JavaScript berbahaya.
* Dengan `htmlspecialchars()`, input itu akan diubah menjadi teks biasa.

---

### Mengapa Validasi & Sanitasi Penting?

1. **Keamanan Aplikasi** = Melindungi aplikasi dari serangan umum seperti XSS, SQL Injection, dan lainnya.

2. **Konsistensi Data** = Data yang masuk ke database lebih bersih, rapi, dan dapat diandalkan.

3. **Pengalaman Pengguna** = Validasi input di sisi klien membantu memberikan feedback cepat kepada pengguna.

4. **Mencegah Kesalahan Logika** = Data yang salah atau kosong dapat menyebabkan proses bisnis tidak berjalan dengan baik.


---
## Validasi Client-side vs Server-side

Dalam proses input data oleh pengguna, validasi dapat dilakukan di dua sisi, yaitu **client-side** (di browser) dan **server-side** (di server). Keduanya memiliki fungsi dan karakteristik yang berbeda namun saling melengkapi.

### 1. Validasi Client-side

**Client-side validation** adalah validasi yang dilakukan menggunakan bahasa pemrograman yang dijalankan di sisi klien, seperti JavaScript. Validasi ini terjadi **sebelum data dikirimkan ke server**.

#### Contoh validasi client-side:

* Mengecek apakah semua form input sudah diisi.
* Memastikan format email benar (`user@domain.com`).
* Menampilkan pesan kesalahan secara langsung jika data tidak sesuai.

#### Kelebihan:

* Memberikan **umpan balik secara langsung** kepada pengguna tanpa perlu memuat ulang halaman.
* **Mengurangi beban server**, karena data yang tidak valid bisa dicegah sebelum dikirim.
* Meningkatkan **user experience (UX)**.

#### Kekurangan:

* Tidak bisa diandalkan untuk keamanan, karena pengguna dapat **mematikan JavaScript** atau **memodifikasi kode HTML**.
* Data tetap bisa dimanipulasi dan dikirim langsung ke server menggunakan alat seperti Postman atau browser dev tools.

> **Kesimpulan:** Validasi client-side tidak bisa menggantikan validasi server-side. Hanya cocok untuk kenyamanan pengguna.

---

### 2. Validasi Server-side

**Server-side validation** dilakukan setelah data dikirim ke server, menggunakan bahasa seperti PHP. Validasi ini bersifat **wajib**, karena hanya pada titik ini kita benar-benar dapat memverifikasi dan mengontrol semua input yang masuk.

#### Contoh validasi server-side:

* Mengecek apakah email valid menggunakan `filter_var()`.
* Memastikan data tidak kosong menggunakan `empty()` atau `isset()`.
* Menolak data yang tidak sesuai dengan kriteria database (misalnya angka bukan numeric).

#### Kelebihan:

* **Lebih aman**, karena pengguna tidak bisa melewati validasi ini.
* Dapat digunakan untuk **memastikan integritas data** sebelum diproses atau disimpan.
* Mampu menangani berbagai jenis input dari berbagai sumber (bukan hanya form HTML).

#### Kekurangan:

* Membutuhkan **waktu lebih lama**, karena proses validasi baru terjadi setelah request sampai ke server.
* Jika terjadi kesalahan, halaman harus dimuat ulang, kecuali menggunakan teknik seperti AJAX.

---

### Tabel Perbandingan

| Jenis Validasi  | Dilakukan Di         | Kelebihan                                       | Kekurangan                                        |
| --------------- | -------------------- | ----------------------------------------------- | ------------------------------------------------- |
| **Client-side** | Browser (JavaScript) | Cepat, memberikan pengalaman pengguna yang baik | Tidak aman jika digunakan sendirian               |
| **Server-side** | Server (PHP)         | Aman dan tidak bisa dilewati oleh pengguna      | Lebih lambat, karena memerlukan request ke server |

---

### Kesimpulan

Validasi terbaik adalah dengan **menggabungkan keduanya**:

* Gunakan **client-side validation** untuk meningkatkan kenyamanan dan kecepatan dalam memberikan umpan balik kepada pengguna.
* Gunakan **server-side validation** untuk menjaga keamanan dan integritas data, karena data yang masuk ke server harus selalu dianggap tidak terpercaya sampai divalidasi.

Dengan pendekatan ini, aplikasi akan menjadi **lebih aman, lebih tangguh, dan tetap nyaman digunakan**.

---

## Sanitasi Input

**Sanitasi input** adalah proses **membersihkan data yang dikirim oleh pengguna** agar aman untuk digunakan dalam aplikasi web. Tujuannya adalah untuk **menghilangkan atau mengubah karakter berbahaya** yang dapat menyebabkan celah keamanan atau error dalam program.

Sanitasi berbeda dengan validasi. Jika validasi bertujuan untuk **memeriksa apakah data sesuai aturan**, maka sanitasi fokus pada **mengubah data agar aman** meskipun input belum tentu valid sepenuhnya.

Sanitasi sangat penting terutama saat:

* Menyimpan data ke database
* Menampilkan data ke dalam halaman HTML
* Memproses input dalam perintah sistem, query SQL, atau skrip lainnya

---

### Fungsi `htmlspecialchars()`

Fungsi ini digunakan untuk **mengonversi karakter khusus HTML menjadi entitas HTML** agar tidak dieksekusi sebagai kode oleh browser. Ini sangat penting untuk mencegah **serangan XSS (Cross-Site Scripting)**, yaitu teknik di mana penyerang menyisipkan skrip berbahaya ke dalam halaman web melalui input pengguna.

#### Contoh:

```php
$nama = htmlspecialchars($_POST['nama']);
```

Jika input:

```html
<script>alert('XSS')</script>
```

Maka akan diubah menjadi:

```html
&lt;script&gt;alert('XSS')&lt;/script&gt;
```

Dengan begitu, skrip tidak akan dijalankan oleh browser, tetapi hanya ditampilkan sebagai teks biasa.

---

### Fungsi `filter_var()`

Fungsi `filter_var()` digunakan untuk **melakukan sanitasi dan validasi input** menggunakan filter yang telah disediakan PHP. Fungsi ini sangat fleksibel dan aman digunakan untuk menangani berbagai jenis data seperti email, URL, angka, dan sebagainya.

#### Contoh penggunaan untuk sanitasi:

```php
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
```

* `FILTER_SANITIZE_EMAIL`: Menghapus karakter yang tidak valid untuk alamat email.
* `FILTER_SANITIZE_URL`: Menghapus karakter yang tidak valid dalam URL.

> Catatan: Setelah disanitasi, sebaiknya tetap lakukan **validasi** untuk memastikan format data sudah benar, seperti menggunakan `FILTER_VALIDATE_EMAIL`.

---

### Perbandingan `htmlspecialchars()` vs `filter_var()`

| Fungsi               | Tujuan                              | Cocok Untuk                |
| -------------------- | ----------------------------------- | -------------------------- |
| `htmlspecialchars()` | Menghindari eksekusi HTML atau JS   | Output HTML (prevent XSS)  |
| `filter_var()`       | Membersihkan atau memvalidasi input | Email, URL, angka, boolean |

---

### Kesimpulan

Sanitasi input adalah langkah wajib dalam proses pengolahan data dari pengguna. Dengan menyaring data sejak awal, kita dapat mencegah berbagai celah keamanan dan menjaga aplikasi tetap stabil dan aman.

Untuk keamanan maksimal:

* **Sanitasi data sebelum ditampilkan**
* **Validasi data sebelum diproses atau disimpan**
* Gunakan kombinasi `htmlspecialchars()`, `filter_var()`, dan validasi manual sesuai kebutuhan data

---

## Validasi Tipe Data

Pastikan data memiliki tipe yang sesuai sebelum diproses atau dimasukkan ke database.

| Fungsi | Kegunaan |
|--------|----------|
| `is_numeric()` | Apakah data angka? |
| `is_string()` | Apakah data string? |
| `is_bool()` | Apakah data boolean? |
| `is_array()` | Apakah data array? |

```php
if (!is_numeric($_POST['umur'])) {
    echo "Umur harus berupa angka.";
}
```

---


## Validasi Email, URL, dan Format Khusus

Validasi format input adalah bagian penting dari keamanan dan integritas data. PHP menyediakan beberapa fungsi bawaan serta dukungan terhadap **ekspresi reguler (regex)** untuk memeriksa apakah format data yang dikirim oleh pengguna sesuai dengan yang diharapkan.

### Validasi Email

Validasi email bertujuan untuk memastikan bahwa string yang dimasukkan pengguna memiliki **struktur alamat email yang valid** seperti `nama@domain.com`. PHP menyediakan filter khusus untuk ini.

#### Contoh:

```php
$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email tidak valid";
}
```

* `FILTER_VALIDATE_EMAIL` akan memeriksa struktur email apakah sesuai dengan standar RFC.
* Jika email tidak valid, maka bisa ditolak atau diminta untuk diperbaiki.

> Penting: Filter ini tidak memverifikasi apakah email **benar-benar ada**, hanya memeriksa strukturnya.

---

### Validasi URL

Validasi URL digunakan untuk memastikan input merupakan alamat web yang valid, seperti `https://example.com`. Sama seperti validasi email, PHP juga menyediakan filter bawaan.

#### Contoh:

```php
$url = $_POST['website'];
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo "URL tidak valid";
}
```

* `FILTER_VALIDATE_URL` memeriksa apakah string memenuhi pola umum URL (dengan protokol `http`, `https`, dll).
* Ini sangat penting untuk mencegah input tidak aman atau salah format.

> Gunakan ini saat menerima input dari pengguna seperti form kontak, profil pengguna, atau referensi eksternal.

---

### Validasi Nomor Telepon (dengan Regex)

Validasi nomor telepon biasanya dilakukan menggunakan **regular expression (regex)** karena format nomor telepon bisa sangat bervariasi tergantung negara atau standar perusahaan.

#### Contoh (validasi sederhana, 10–13 digit angka):

```php
$telepon = $_POST['telepon'];
if (!preg_match("/^[0-9]{10,13}$/", $telepon)) {
    echo "Nomor telepon tidak valid (harus 10–13 digit)";
}
```

Penjelasan regex `/^[0-9]{10,13}$/`:

* `^` dan `$` menandakan awal dan akhir string (agar seluruh string dicek).
* `[0-9]` berarti hanya angka.
* `{10,13}` berarti jumlah digit harus antara 10 sampai 13 angka.

> Validasi nomor telepon bisa disesuaikan untuk mendukung awalan seperti +62, tanda kurung, atau spasi jika diperlukan.

---

## Kesimpulan

| Format        | Metode Validasi     | Fungsi atau Teknik                       |
| ------------- | ------------------- | ---------------------------------------- |
| Email         | Built-in PHP Filter | `filter_var(..., FILTER_VALIDATE_EMAIL)` |
| URL           | Built-in PHP Filter | `filter_var(..., FILTER_VALIDATE_URL)`   |
| Nomor Telepon | Regular Expression  | `preg_match()` dengan regex              |

### Tips Tambahan:

* **Gunakan filter bawaan** PHP sebanyak mungkin karena lebih aman dan efisien.
* **Gunakan regex** saat format data lebih kompleks atau tidak tersedia filter bawaan.
* Lakukan **sanitasi sebelum validasi** jika data berasal dari sumber tak terpercaya.

---

## Praktik Terbaik

- Jangan **percaya 100%** pada input pengguna.
- Validasi di sisi server meskipun sudah ada validasi client.
- Gunakan sanitasi sebelum menampilkan data ke browser.
- Gunakan prepared statement (PDO/Mysqli) untuk input ke database.

---

## Kesimpulan

Validasi dan sanitasi adalah **garis pertahanan pertama** terhadap ancaman seperti SQL Injection, XSS, dan data corrupt. Pastikan semua input selalu dicek dan dibersihkan sebelum digunakan.

