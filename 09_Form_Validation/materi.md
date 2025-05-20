# Validasi & Keamanan Input Data dalam PHP

Dalam pengembangan web, **validasi dan sanitasi data** sangat penting untuk menjaga keamanan dan integritas data. Berikut adalah materi penting terkait validasi input dan praktik keamanannya.

---

## Validasi Client-side vs Server-side

| Validasi | Dilakukan Di | Kelebihan | Kekurangan |
|----------|---------------|-----------|------------|
| **Client-side** | Browser (JavaScript) | Cepat, pengalaman pengguna lebih baik | Mudah dilewati (tidak aman tanpa server-side) |
| **Server-side** | Server (PHP) | Lebih aman, tidak bisa dilewati | Lebih lambat karena membutuhkan request |

**Kesimpulan**: Gunakan kombinasi **client-side** untuk UX dan **server-side** untuk keamanan.

---

## Sanitasi Input

Sanitasi adalah proses **membersihkan input** dari karakter berbahaya sebelum digunakan.

### `htmlspecialchars()`
Mencegah serangan XSS (Cross Site Scripting)

```php
$nama = htmlspecialchars($_POST['nama']);
```

### `filter_var()`
Digunakan untuk sanitasi dan validasi dengan filter bawaan

```php
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
```

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

### Validasi Email

```php
$email = $_POST['email'];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Email tidak valid";
}
```

### Validasi URL

```php
$url = $_POST['website'];
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo "URL tidak valid";
}
```

### Validasi Nomor Telepon (Regex)

```php
$telepon = $_POST['telepon'];
if (!preg_match("/^[0-9]{10,13}$/", $telepon)) {
    echo "Nomor telepon tidak valid (harus 10–13 digit)";
}
```

---

## Praktik Terbaik

- Jangan **percaya 100%** pada input pengguna.
- Validasi di sisi server meskipun sudah ada validasi client.
- Gunakan sanitasi sebelum menampilkan data ke browser.
- Gunakan prepared statement (PDO/Mysqli) untuk input ke database.

---

## Kesimpulan

Validasi dan sanitasi adalah **garis pertahanan pertama** terhadap ancaman seperti SQL Injection, XSS, dan data corrupt. Pastikan semua input selalu dicek dan dibersihkan sebelum digunakan.

