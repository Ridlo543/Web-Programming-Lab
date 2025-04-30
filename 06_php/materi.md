# Praktikum Pemrograman Web 6: PHP

## 1. Pengenalan PHP dan Instalasi

PHP (PHP: Hypertext Preprocessor) adalah bahasa pemrograman server-side yang dirancang khusus untuk pengembangan web. Berbeda dengan HTML, CSS, dan JavaScript yang diproses di sisi klien, PHP dieksekusi di server sebelum hasilnya dikirim ke browser pengguna.

### Karakteristik PHP

- Bersifat open-source
- Server-side scripting language
- Dapat disisipkan dalam HTML
- Dukungan database yang luas seperti MySQL, PostgreSQL, SQLite, dll.
- Cross-platform

### Instalasi Environment PHP

#### Menggunakan XAMPP (Windows, MacOS, Linux)

XAMPP adalah paket perangkat lunak yang berisi Apache (server web), MySQL (database), PHP, dan Perl. cocok untuk cross platform (Windows, MacOS, Linux) dan proyek skala kecil.

**Langkah Instalasi XAMPP:**

1. Download dari [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Instal seperti aplikasi biasa
3. Start Apache dan MySQL dari control panel
4. Buka browser dan akses `http://localhost`
5. folder `xampp/htdocs/` untuk folder working sebagai root ketika mengakses localhost

#### Menggunakan HERD (Untuk MacOS dan Windows)

HERD adalah alternatif modern untuk MAMP/XAMPP di MacOS dan windows. Mendukung beberapa versi php sekaligus untuk proyek besar.

**Langkah Instalasi HERD:**

1. Download dari [https://herd.laravel.com/](https://herd.laravel.com/)
2. Instal aplikasi
3. Pilih versi php yang ingin digunakan

#### Laragon (Windows only, Free untuk versi 6 ke bawah)

Laragon sama seperti sebelumnya untuk server lokal untuk Windows. Laragon mendukung PHP, MySQL, dan berbagai framework PHP seperti Laravel, Symfony, dll.
Tetapi yang free adalah versi 6 kebawah

#### Docker

### Extension VS Code untuk PHP

Beberapa extension VS Code yang membantu dalam pengembangan PHP:

- **PHP Intelephense**: Untuk autocomplete dan intellisense
- **PHP Debug**: Untuk debugging dengan XDebug
- **PHP Server**: Untuk menjalankan server PHP sederhana
- **PHP Live Server**: Untuk auto-refresh saat file berubah

### Struktur Dasar File PHP

```php
<!DOCTYPE html>
<html>
<head>
    <title>Halaman PHP Pertama</title>
</head>
<body>
    <h1>Selamat Datang di PHP</h1>

    <?php
        // Kode PHP bisa ditulis di sini
        echo "Hello, World!";
    ?>
</body>
</html>
```

Sintaks Dasar (Variabel, Echo, Data Type)

Operator dan Struktur Kontrol (if, switch, for, while)

Fungsi (Deklarasi, Parameter, Return)

Array dan Array Associative

## 5. Array dalam PHP

Array adalah struktur data yang dapat menyimpan beberapa nilai dalam satu variabel.

### Array Indexed

Array indexed menggunakan angka sebagai key, dimulai dari 0.

```php
<?php
    // Deklarasi array indexed
    $buah = array("Apel", "Jeruk", "Mangga", "Pisang");
    $buah_baru = ["Apel", "Jeruk", "Mangga", "Pisang"]; // Sintaks baru (sejak PHP 5.4)

    // Mengakses elemen array
    echo $buah[0]; // Output: Apel
    echo $buah[2]; // Output: Mangga

    // Mengubah nilai array
    $buah[1] = "Anggur";

    // Menambah elemen di akhir array
    $buah[] = "Nanas";

    // Menghitung jumlah elemen
    echo count($buah); // Output: 5

    // Perulangan pada array
    for ($i = 0; $i < count($buah); $i++) {
        echo "Buah ke-" . ($i+1) . ": " . $buah[$i] . "<br>";
    }

    // Perulangan dengan foreach (lebih disarankan)
    foreach ($buah as $b) {
        echo "Buah: $b <br>";
    }

    // Perulangan dengan index
    foreach ($buah as $index => $value) {
        echo "Index $index: $value <br>";
    }
?>
```

### Array Associative

Array associative menggunakan string sebagai key.

```php
<?php
    // Deklarasi array associative
    $mahasiswa = array(
        "nim" => "123456",
        "nama" => "John Doe",
        "jurusan" => "Informatika",
        "ipk" => 3.75
    );

    // Sintaks baru
    $mahasiswa = [
        "nim" => "123456",
        "nama" => "John Doe",
        "jurusan" => "Informatika",
        "ipk" => 3.75
    ];

    // Mengakses elemen
    echo $mahasiswa["nama"]; // Output: John Doe
    echo $mahasiswa["ipk"];  // Output: 3.75

    // Mengubah nilai
    $mahasiswa["jurusan"] = "Teknik Komputer";

    // Menambah elemen baru
    $mahasiswa["alamat"] = "Jl. Merdeka No. 123";

    // Perulangan dengan foreach
    foreach ($mahasiswa as $key => $value) {
        echo "$key: $value <br>";
    }
?>
```

### Array Multidimensi

Array multidimensi adalah array yang berisi array lain.

```php
<?php
    // Array multidimensi
    $siswa = [
        [
            "nama" => "John",
            "nilai" => [80, 75, 90]
        ],
        [
            "nama" => "Jane",
            "nilai" => [85, 92, 78]
        ],
        [
            "nama" => "Bob",
            "nilai" => [70, 65, 88]
        ]
    ];

    // Mengakses elemen array multidimensi
    echo $siswa[0]["nama"]; // Output: John
    echo $siswa[1]["nilai"][1]; // Output: 92

    // Perulangan array multidimensi
    foreach ($siswa as $s) {
        echo "Nama: " . $s["nama"] . "<br>";
        echo "Nilai: ";
        foreach ($s["nilai"] as $nilai) {
            echo $nilai . " ";
        }
        echo "<br>";

        // Menghitung rata-rata nilai
        $rata_rata = array_sum($s["nilai"]) / count($s["nilai"]);
        echo "Rata-rata: " . $rata_rata . "<br><br>";
    }
?>
```

### Fungsi-fungsi Array

PHP memiliki banyak fungsi bawaan untuk manipulasi array:

```php
<?php
    $angka = [3, 1, 7, 2, 9];
    $buah = ["Apel", "Jeruk", "Mangga"];

    // Sorting
    sort($angka);        // Sort ascending
    rsort($angka);       // Sort descending
    asort($buah);        // Sort associative array by value (ascending)
    arsort($buah);       // Sort associative array by value (descending)
    ksort($buah);        // Sort associative array by key (ascending)
    krsort($buah);       // Sort associative array by key (descending)

    // Push, pop, shift, unshift
    array_push($buah, "Pisang", "Nanas"); // Tambah satu atau lebih elemen di akhir
    $last = array_pop($buah);   // Ambil dan hapus elemen terakhir
    $first = array_shift($buah); // Ambil dan hapus elemen pertama
    array_unshift($buah, "Strawberry", "Kiwi"); // Tambah di awal

    // Combine, merge, diff
    $keys = ["a", "b", "c"];
    $values = [1, 2, 3];
    $combined = array_combine($keys, $values); // Hasilnya: ["a"=>1, "b"=>2, "c"=>3]

    $array1 = ["a"=>1, "b"=>2];
    $array2 = ["c"=>3, "b"=>4];
    $merged = array_merge($array1, $array2); // Hasilnya: ["a"=>1, "b"=>4, "c"=>3]

    $diff = array_diff($array1, $array2); // Elemen $array1 yang tidak ada di $array2

    // Other useful functions
    echo count($buah);        // Jumlah elemen
    echo in_array("Apel", $buah); // Cek apakah nilai ada dalam array
    print_r(array_keys($array1)); // Dapatkan semua key
    print_r(array_values($array1)); // Dapatkan semua value
    print_r(array_unique($angka)); // Hapus nilai duplikat

    $keys = array_keys($array1);
    $flipped = array_flip($array1); // Tukar key dan value
    $chunked = array_chunk($angka, 2); // Bagi array menjadi chunk dengan size 2

    // Filter dan map
    $genap = array_filter($angka, function($n) {
        return $n % 2 == 0;
    });

    $kuadrat = array_map(function($n) {
        return $n * $n;
    }, $angka);

    // Reduce
    $sum = array_reduce($angka, function($carry, $item) {
        return $carry + $item;
    }, 0);
?>
```

## 6. Superglobals

Superglobals adalah array bawaan PHP yang selalu tersedia di semua scope.

### $\_GET

Digunakan untuk mengumpulkan data yang dikirim melalui URL dengan metode GET.

```php
<?php
    // URL: example.php?nama=John&umur=25

    echo "Nama: " . $_GET["nama"]; // Output: Nama: John
    echo "Umur: " . $_GET["umur"];  // Output: Umur: 25

    // Cek apakah parameter ada
    if (isset($_GET["nama"])) {
        echo "Parameter nama tersedia";
    }

    // Mengamankan data GET
    $nama = htmlspecialchars($_GET["nama"]);

    // Form dengan metode GET
?>

<form action="proses.php" method="GET">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama"><br>

    <label for="umur">Umur:</label>
    <input type="number" id="umur" name="umur"><br>

    <input type="submit" value="Kirim">
</form>
```

### $\_POST

Digunakan untuk mengumpulkan data yang dikirim melalui metode HTTP POST.

```php
<?php
    // Data dikirim melalui form POST

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "Nama: " . $_POST["nama"];
        echo "Email: " . $_POST["email"];

        // Validasi data
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            echo "Email tidak valid";
        }
    }
?>

<form action="proses.php" method="POST">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama"><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email"><br>

    <input type="submit" value="Kirim">
</form>
```

### $\_SERVER

Array yang berisi informasi tentang header, path, dan lokasi script.

```php
<?php
    echo "Server Name: " . $_SERVER["SERVER_NAME"] . "<br>";
    echo "HTTP Host: " . $_SERVER["HTTP_HOST"] . "<br>";
    echo "User Agent: " . $_SERVER["HTTP_USER_AGENT"] . "<br>";
    echo "Server Software: " . $_SERVER["SERVER_SOFTWARE"] . "<br>";
    echo "Document Root: " . $_SERVER["DOCUMENT_ROOT"] . "<br>";
    echo "Current Script: " . $_SERVER["PHP_SELF"] . "<br>";
    echo "Request Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    echo "Remote Address (IP): " . $_SERVER["REMOTE_ADDR"] . "<br>";
    echo "Query String: " . $_SERVER["QUERY_STRING"] . "<br>";

    // Menentukan apakah request adalah AJAX
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
              $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

    // Mendapatkan URL saat ini
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $current_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Mendapatkan referrer URL
    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct visit';
?>
```

### Superglobals Lainnya

```php
<?php
    // $_REQUEST - Berisi data dari $_GET, $_POST, dan $_COOKIE
    echo $_REQUEST["nama"];

    // $_FILES - Berisi informasi tentang file yang diupload
    if (isset($_FILES["fileUpload"])) {
        echo "File Name: " . $_FILES["fileUpload"]["name"] . "<br>";
        echo "File Type: " . $_FILES["fileUpload"]["type"] . "<br>";
        echo "File Size: " . $_FILES["fileUpload"]["size"] . "<br>";
        echo "Temporary File: " . $_FILES["fileUpload"]["tmp_name"] . "<br>";

        // Pindahkan file yang diupload
        move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "uploads/" . $_FILES["fileUpload"]["name"]);
    }

    // $_SESSION - Berisi variabel session (akan dibahas di bab Session)
    session_start();
    $_SESSION["username"] = "john_doe";
    echo $_SESSION["username"];

    // $_COOKIE - Berisi cookies yang dikirim dengan HTTP request (akan dibahas di bab Cookies)
    echo $_COOKIE["user"];

    // $_ENV - Berisi variabel environment
    echo $_ENV["PATH"];

    // $GLOBALS - Berisi referensi ke semua variabel yang tersedia dalam scope global
    $x = 10;
    function test() {
        echo $GLOBALS['x']; // Mengakses variabel global $x
    }
    test();
?>
```

## 7. Pengolahan String dan Regular Expression

### Operasi Dasar String

```php
<?php
    $str = "Hello, World!";

    // Panjang string
    echo strlen($str); // Output: 13

    // Menghitung jumlah kata
    echo str_word_count($str); // Output: 2

    // Reverse string
    echo strrev($str); // Output: !dlroW ,olleH

    // Mencari posisi substring
    echo strpos($str, "World"); // Output: 7

    // Mengganti substring
    echo str_replace("World", "PHP", $str); // Output: Hello, PHP!

    // Mengubah huruf kecil/besar
    echo strtolower($str); // Output: hello, world!
    echo strtoupper($str); // Output: HELLO, WORLD!
    echo ucfirst($str);    // Output: Hello, world!
    echo ucwords($str);    // Output: Hello, World!

    // Menghapus whitespace
    echo trim("  Hello  "); // Output: Hello

    // Substring
    echo substr($str, 0, 5); // Output: Hello
    echo substr($str, 7);    // Output: World!
    echo substr($str, -6);   // Output: World!

    // Explode (string ke array)
    $arr = explode(", ", $str);
    print_r($arr); // Output: Array ( [0] => Hello [1] => World! )

    // Implode (array ke string)
    $arr = ["Hello", "PHP", "World"];
    echo implode(" - ", $arr); // Output: Hello - PHP - World

    // String padding
    echo str_pad("Hello", 10, "-"); // Output: Hello-----
    echo str_pad("Hello", 10, "-", STR_PAD_LEFT); // Output: -----Hello

    // Repeat string
    echo str_repeat("Hello ", 3); // Output: Hello Hello Hello

    // Membandingkan string
    echo strcmp("Hello", "Hello"); // Output: 0 (sama)
    echo strcmp("Hello", "World"); // Output: negatif (Hello < World)

    // String formatting
    $name = "John";
    $age = 30;
    echo sprintf("Name: %s, Age: %d", $name, $age); // Output: Name: John, Age: 30
?>
```

### Heredoc dan Nowdoc

```php
<?php
    $name = "John";

    // Heredoc (interpolasi variabel)
    $text = <<<EOT
    Hello, $name!
    This is a multiline text.
    No need to escape quotes.
    EOT;

    echo $text;

    // Nowdoc (tanpa interpolasi)
    $text = <<<'EOT'
    Hello, $name!
    This is a multiline text.
    Variables are not interpolated.
    EOT;

    echo $text;
?>
```

### Regular Expression

```php
<?php
    $str = "The quick brown fox jumps over the lazy dog";
    $email = "user@example.com";
    $phone = "123-456-7890";

    // preg_match() - Mencari pattern dalam string
    // Mengembalikan 1 jika cocok, 0 jika tidak cocok, dan false jika error

    // Contoh 1: Mencari kata "fox"
    if (preg_match("/fox/", $str)) {
        echo "Pattern 'fox' ditemukan.<br>";
    }

    // Contoh 2: Mencari kata dengan awalan 'b'
    if (preg_match("/\bb\w+/", $str, $matches)) {
        echo "Kata yang dimulai dengan 'b': " . $matches[0] . "<br>"; // Output: brown
    }

    // Contoh 3: Validasi email
    $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    if (preg_match($pattern, $email)) {
        echo "Email valid.<br>";
    }

    // Contoh 4: Validasi nomor telepon
    $pattern = "/^\d{3}-\d{3}-\d{4}$/";
    if (preg_match($pattern, $phone)) {
        echo "Nomor telepon valid.<br>";
    }

    // preg_match_all() - Mencari semua kemunculan pattern
    preg_match_all("/\b\w{5}\b/", $str, $matches); // Mencari semua kata 5 huruf
    print_r($matches[0]); // Output: Array ( [0] => quick [1] => brown [2] => jumps )

    // preg_replace() - Mengganti pattern dengan string lain
    $result = preg_replace("/fox/", "cat", $str);
    echo $result . "<br>"; // Output: The quick brown cat jumps over the lazy dog

    // Contoh lebih kompleks
    $result = preg_replace("/\b(\w+?)(o)(\w+)\b/", "$1-O-$3", $str);
    echo $result . "<br>"; // Mengganti kata dengan 'o' di tengah

    // preg_split() - Memecah string berdasarkan pattern
    $result = preg_split("/\s+/", $str);
    print_r($result); // Memecah string berdasarkan whitespace

    // Modifiers
    // i - case-insensitive
    if (preg_match("/fox/i", "FOX")) {
        echo "Match found with case-insensitive.<br>";
    }

    // m - multiline
    $str = "Line 1\nLine 2\nLine 3";
    preg_match_all("/^Line/m", $str, $matches);
    print_r($matches[0]); // Menemukan semua baris yang dimulai dengan "Line"

    // s - dot matches newline
    // g - global search (tidak ada di PHP, gunakan preg_match_all)
    // e - evaluate replacement (deprecated, gunakan preg_replace_callback)

    // preg_replace_callback() - Mengganti dengan callback function
    $result = preg_replace_callback(
        "/\b(\w)(\w+)\b/",
        function($matches) {
            return strtoupper($matches[1]) . $matches[2];
        },
        $str
    );
    echo $result . "<br>"; // Kapitalisasi huruf pertama setiap kata
?>
```

### Metakarakter dalam Regex

| Metakarakter | Deskripsi                          |
| ------------ | ---------------------------------- |
| ^            | Awal string                        |
| $            | Akhir string                       |
| .            | Karakter apa pun kecuali newline   |
| [...]        | Karakter dalam bracket             |
| [^...]       | Karakter di luar bracket           |
| \|           | Alternatif (atau)                  |
| (...)        | Grup                               |
| \d           | Digit (0-9)                        |
| \D           | Bukan digit                        |
| \w           | Word character (a-z, A-Z, 0-9, \_) |
| \W           | Bukan word character               |
| \s           | Whitespace                         |
| \S           | Bukan whitespace                   |
| \b           | Word boundary                      |
| \B           | Bukan word boundary                |
| \*           | 0 atau lebih                       |
| +            | 1 atau lebih                       |
| ?            | 0 atau 1                           |
| {n}          | Tepat n kali                       |
| {n,}         | Minimal n kali                     |
| {n,m}        | Antara n dan m kali                |

## 8. Include dan Require

Include dan require digunakan untuk menyisipkan dan mengeksekusi file PHP lain ke dalam script.

### Include dan Include_once

```php
<?php
    // include - Menyisipkan dan mengeksekusi file lain
    // Jika file tidak ditemukan, menghasilkan warning dan script terus berjalan

    // contoh file1.php
    $greeting = "Hello, World!";
    function sapa() {
        echo "Selamat Datang!";
    }
?>

<?php
    // contoh file2.php
    include "file1.php";
    echo $greeting; // Output: Hello, World!
    sapa(); // Output: Selamat Datang!

    // Path relatif
    include "folder/file.php";

    // Path absolut
    include "/var/www/html/file.php";

    // include_once - Seperti include, tetapi hanya disertakan sekali
    include_once "file1.php"; // File akan disertakan
    include_once "file1.php"; // File tidak akan disertakan lagi
?>
```

### Require dan Require_once

```php
<?php
    // require - Mirip dengan include, tetapi jika file tidak ditemukan
    // akan menghasilkan fatal error dan script berhenti

    require "file_penting.php";

    // require_once - Seperti require, tetapi hanya disertakan sekali
    require_once "file_penting.php"; // File akan disertakan
    require_once "file_penting.php"; // File tidak akan disertakan lagi
?>
```

### Best PRactice

```php
<?php
    // 1. Menggunakan require untuk file yang wajib ada
    require_once "config.php";     // File konfigurasi
    require_once "functions.php";  // Library functions

    // 2. Menggunakan include untuk file yang opsional
    include "header.php";

    // Konten halaman
    echo "<h1>Halaman Utama</h1>";
    echo "<p>Ini adalah konten halaman utama.</p>";

    include "footer.php";

    // 3. Menggunakan return dalam included file
    // file: data.php
    // return ["apple", "orange", "banana"];

    $buah = include "data.php";
    print_r($buah);

    // 4. Variabel scope dalam included file
    // Variabel yang didefinisikan dalam file yang di-include
    // tersedia dalam file yang meng-include
?>
```

### Struktur Aplikasi PHP

```
project/
├── config/
│   └── database.php       # Konfigurasi database
├── includes/
│   ├── functions.php      # Fungsi umum
│   ├── header.php         # Header website
│   └── footer.php         # Footer website
├── public/
│   ├── css/               # File CSS
│   ├── js/                # File JavaScript
│   └── images/            # Gambar
├── index.php              # Halaman utama
└── contact.php            # Halaman kontak
```

```php
<?php
    // index.php
    require_once "config/database.php";
    require_once "includes/functions.php";

    include "includes/header.php";
?>

<div class="content">
    <h1>Selamat Datang</h1>
    <p>Ini adalah halaman utama.</p>
</div>

<?php
    include "includes/footer.php";
?>
```

## 9. Error Handling dan Debugging

### Jenis-jenis Error

1. **Syntax Error** - Kesalahan penulisan kode
2. **Fatal Error** - Kesalahan fatal yang menghentikan eksekusi script
3. **Warning** - Peringatan tetapi script tetap berjalan
4. **Notice** - Pemberitahuan ringan, script tetap berjalan
5. **Parse Error** - Kesalahan parsing yang mencegah script dijalankan

### Error Reporting

```php
<?php
    // Menampilkan semua error
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Hanya menampilkan error dan warning
    error_reporting(E_ERROR | E_WARNING);

    // Menyembunyikan semua error (tidak disarankan untuk development)
    error_reporting(0);

    // Menuliskan error ke log
    ini_set('log_errors', 1);
    ini_set('error_log', 'path/to/error.log');
?>
```

### Try-Catch-Finally

Untuk menangani exception (kesalahan).

```php
<?php
    // Basic try-catch
    try {
        // Kode yang mungkin menghasilkan exception
        $result = 10 / 0; // Akan melempar DivisionByZeroError
    } catch (Exception $e) {
        // Menangani exception
        echo "Caught exception: " . $e->getMessage() . "<br>";
    }

    // Try-catch dengan multiple catch blocks
    try {
        $file = fopen("non_existent_file.txt", "r");
        if (!$file) {
            throw new Exception("File tidak dapat dibuka");
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage() . "<br>";
    } catch (Error $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }

    // Try-catch-finally
    try {
        $conn = new PDO("mysql:host=localhost;dbname=test", "user", "pass");
        $result = $conn->query("SELECT * FROM non_existent_table");
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage() . "<br>";
    } finally {
        // Kode ini selalu dijalankan, baik ada exception atau tidak
        $conn = null; // Menutup koneksi database
        echo "Connection closed<br>";
    }

    // Throwing custom exception
    function divide($a, $b) {
        if ($b == 0) {
            throw new Exception("Division by zero");
        }
        return $a / $b;
    }

    try {
        echo divide(10, 0);
    } catch (Exception $e) {
        echo "Caught exception: " . $e->getMessage() . "<br>";
    }
?>
```

### Custom Error Handler

```php
<?php
    // Mendefinisikan custom error handler
    function customErrorHandler($errno, $errstr, $errfile, $errline) {
        echo "<b>Error:</b> [$errno] $errstr<br>";
        echo "Error on line $errline in $errfile<br>";

        // Jika error cukup parah, hentikan script
        if ($errno == E_USER_ERROR) {
            echo "Fatal error. Exiting...<br>";
            exit(1);
        }

        // Kembalikan true agar PHP tidak menjalankan internal error handler
        return true;
    }

    // Set custom error handler
    set_error_handler("customErrorHandler");

    // Memicu error
    trigger_error("This is a user error", E_USER_ERROR);
    trigger_error("This is a user warning", E_USER_WARNING);
    trigger_error("This is a user notice", E_USER_NOTICE);

    // Mengembalikan ke default error handler
    restore_error_handler();
?>
```

### Debugging Techniques

```php
<?php
    // 1. Menggunakan var_dump() dan print_r()
    $array = [1, 2, 3, ["a", "b", "c"]];
    var_dump($array); // Menampilkan detail tipe data dan nilai
    print_r($array);  // Format yang lebih ringkas

    // 2. Menggunakan die() atau exit() untuk menghentikan eksekusi
    $result = someFunction();
    if (!$result) {
        die("Function failed");
    }

    // 3. Debug backtrace
    function a() {
        b();
    }

    function b() {
        c();
    }

    function c() {
        print_r(debug_backtrace());
    }

    a(); // Menampilkan stack trace

    // 4. Logging
    error_log("Debug info: " . json_encode($data));

    // 5. Debug bar / format HTML
    function debug($var, $exit = false) {
        echo '<pre style="background-color: #f5f5f5; padding: 10px; margin: 10px; border: 1px solid #ccc; border-radius: 5px; color: #333;">';
        var_dump($var);
        echo '</pre>';

        if ($exit) {
            exit;
        }
    }

    debug($array, true);
?>
```
