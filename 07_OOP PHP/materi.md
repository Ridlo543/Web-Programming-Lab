
# OOP PHP (Object-Oriented Programming)

Panduan dasar dan lanjutan mengenai konsep Object-Oriented Programming (OOP) dalam PHP.

---

## 📌 Daftar Isi

1. [Pengenalan OOP](#1-pengenalan-oop)
2. [Class dan Object](#2-class-dan-object)
3. [Properties dan Methods](#3-properties-dan-methods)
4. [Constructor dan Destructor](#4-constructor-dan-destructor)
5. [Inheritance (Pewarisan)](#5-inheritance-pewarisan)
6. [Encapsulation (Enkapsulasi)](#6-encapsulation-enkapsulasi)
7. [Abstraction dan Interface](#7-abstraction-dan-interface)
8. [Static Properties dan Methods](#8-static-properties-dan-methods)
9. [Method Chaining](#9-method-chaining)
10. [Namespaces](#10-namespaces)
11. [Magic Methods (Opsional)](#11-magic-methods-opsional)


## Apa Itu OOP?

**Object-Oriented Programming (OOP)** adalah paradigma pemrograman yang berfokus pada penggunaan *objek* dan *class* sebagai cara utama untuk menyusun dan membangun program.

Berbeda dengan pemrograman prosedural (seperti menggunakan fungsi global secara terpisah), OOP menggabungkan **data (properties)** dan **perilaku (methods)** ke dalam satu unit yang disebut **objek**.


## Konsep Utama dalam OOP

Berikut adalah empat pilar utama dari OOP yang akan kamu temui saat mempelajari OOP dalam PHP:

| Pilar            | Penjelasan Singkat                                                                 |
|------------------|-------------------------------------------------------------------------------------|
| **Encapsulation** | Menyembunyikan detail internal dari objek agar tidak bisa diakses sembarangan.      |
| **Inheritance**   | Kemampuan suatu class untuk mewarisi sifat dan perilaku dari class lain.            |
| **Polymorphism**  | Objek dapat memiliki banyak bentuk, biasanya lewat overriding method.               |
| **Abstraction**   | Menyembunyikan kompleksitas dan hanya menunjukkan informasi penting ke pengguna.    |

## Mengapa Menggunakan OOP di PHP?

- **Modularitas:** Kode lebih mudah dipisahkan dalam class/class file.
- **Reusability:** Class bisa digunakan kembali tanpa perlu menulis ulang kode.
- **Maintainability:** Perubahan dalam satu class tidak akan berdampak langsung ke bagian lain.
- **Scalability:** Struktur program lebih mudah diperluas karena berbasis objek.

## Contoh Singkat (Perbandingan)

**Tanpa OOP (Prosedural):**

```php
function tampilkanMobil($merk) {
    echo "Mobil merek $merk\n";
}

tampilkanMobil("Toyota");
```

**Dengan OOP:**

```php
class Mobil {
    public $merk;

    public function tampilkan() {
        echo "Mobil merek $this->merk\n";
    }
}

$mobil = new Mobil();
$mobil->merk = "Toyota";
$mobil->tampilkan();
```

OOP membantu kamu menulis kode yang lebih **terstruktur**, **mudah dibaca**, dan **fleksibel untuk dikembangkan**. Konsep ini sangat penting, terutama untuk proyek berskala menengah ke atas di PHP seperti aplikasi web, sistem manajemen konten (CMS), dan framework seperti Laravel atau Symfony.

---

#  2. Class dan Object

## Apa Itu Class?

Class adalah *blueprint* atau cetakan untuk membuat objek. Di dalam class, kita mendefinisikan:
- **Properties**: variabel yang menyimpan data atau atribut dari objek.
- **Methods**: fungsi yang mendefinisikan perilaku atau aksi dari objek.

## Apa Itu Object?

Object adalah instansi nyata dari sebuah class. Setelah class didefinisikan, kita bisa membuat objek menggunakan keyword `new`.

## Struktur Dasar Class di PHP

```php
class NamaClass {
    // Property
    public $property1;
    public $property2;

    // Method
    public function namaMethod() {
        echo "Ini adalah method.";
    }
}
```

## Membuat Objek dari Class

Objek dibuat menggunakan keyword `new`:

```php
$objek = new NamaClass();
$objek->property1 = "Nilai";
$objek->namaMethod(); // Memanggil method
```

## Contoh Lengkap

```php
class Mahasiswa {
    public $nama;
    public $nim;

    public function tampilkanData() {
        echo "Nama: $this->nama, NIM: $this->nim\n";
    }
}

// Membuat objek
$mhs1 = new Mahasiswa();
$mhs1->nama = "Andi";
$mhs1->nim = "12345678";
$mhs1->tampilkanData();
```

## Keyword $this
Keyword $this digunakan untuk merujuk pada objek saat ini. Biasanya digunakan di dalam method untuk mengakses property atau method dari objek itu sendiri.
 ```php
$this->propertyName;
$this->methodName();
 ```
contoh penggunaan
``` php
class Buku {
    public $judul;

    public function tampilkanJudul() {
        echo "Judul buku: " . $this->judul;
    }
}
```
## Tipe Akses Property dan Method
PHP menggunakan access modifiers untuk mengatur hak akses terhadap member (property/method):
- `public`: dapat diakses dari mana saja
- `private`: hanya dapat diakses dari dalam class itu sendiri
- `protected`: dapat diakses dari class itu sendiri dan turunannya (class anak)

Contoh:
```php
class Contoh {
    public $dataPublic = "Bisa diakses dari luar";
    private $dataPrivate = "Hanya bisa diakses dari dalam class";

    public function tampilkan() {
        echo $this->dataPrivate;
    }
}

$obj = new Contoh();
echo $obj->dataPublic; // OK
// echo $obj->dataPrivate; // Error
$obj->tampilkan(); // OK

```

## Banyak Objek dari Satu Class
Satu class dapat digunakan untuk membuat banyak objek berbeda dengan nilai property yang berbeda-beda.

```php
class Mobil {
    public $merk;
    public $warna;

    public function info() {
        echo "Mobil $this->merk berwarna $this->warna\n";
    }
}

$mobil1 = new Mobil();
$mobil1->merk = "Toyota";
$mobil1->warna = "Merah";
$mobil1->info();

$mobil2 = new Mobil();
$mobil2->merk = "Honda";
$mobil2->warna = "Putih";
$mobil2->info();

```
## Kesimpulan
- Class adalah cetakan untuk membuat objek.
- Object adalah instansi nyata dari class.
- Gunakan keyword $this untuk mengakses property/method dari dalam class.
- PHP menyediakan access modifiers (public, private, protected) untuk keamanan dan pengaturan akses.
- Satu class bisa digunakan untuk membuat banyak objek dengan data yang berbeda.



# 3. Properties dan Methods

## Apa Itu Properties?

*Properties* adalah variabel yang dideklarasikan di dalam class untuk menyimpan data atau atribut dari objek. Properti bisa bersifat publik, privat, atau protektif tergantung pada kebutuhan keamanan data.

Contoh:
```php
class Produk {
    public $nama;
    public $harga;
}
```

## Apa Itu Methods?

*Methods* adalah fungsi yang berada di dalam class. Method menggambarkan perilaku atau aksi dari objek. Seperti fungsi biasa, method bisa menerima parameter dan mengembalikan nilai.

Contoh:
```php
class Produk {
    public $nama;
    public $harga;

    public function tampilkanInfo() {
        echo "Produk: $this->nama, Harga: $this->harga\n";
    }
}
```

## Mengakses Properties dan Methods

Gunakan -> untuk mengakses property dan method dari objek.

```php
$produk1 = new Produk();
$produk1->nama = "Laptop";
$produk1->harga = 10000000;
$produk1->tampilkanInfo(); // Output: Produk: Laptop, Harga: 10000000
```

## Modifikasi Property dari Method

Kita bisa mengatur atau mengubah nilai property langsung dari dalam method menggunakan $this.

```php
class Produk {
    public $nama;
    public $harga;

    public function setHarga($hargaBaru) {
        $this->harga = $hargaBaru;
    }

    public function getHarga() {
        return $this->harga;
    }
}
```

## Jenis Visibility pada Property & Method

| Modifier    | Akses dari Luar | Akses dari Class Sendiri | Akses dari Class Turunan |
| ----------- | --------------- | ------------------------ | ------------------------ |
| public    | ✔              | ✔                       | ✔                       |
| protected | ❌               | ✔                       | ✔                       |
| private   | ❌               | ✔                       | ❌                        |

```php
class Contoh {
    public $terbuka = "Bisa diakses";
    private $rahasia = "Tidak bisa diakses langsung";

    public function lihatRahasia() {
        return $this->rahasia;
    }
}

$obj = new Contoh();
echo $obj->terbuka; // OK
// echo $obj->rahasia; // Error
echo $obj->lihatRahasia(); // OK
```

## Kesimpulan

* *Properties* adalah data/atribut objek.
* *Methods* adalah aksi/perilaku objek.
* Gunakan -> untuk mengakses properties dan methods dari objek.
* Gunakan $this untuk merujuk ke properti/method di dalam class.
* Atur visibilitas (public, private, protected) untuk keamanan data.

# 4. Constructor dan Destructor

## Apa Itu Constructor?

**Constructor** adalah method khusus yang secara otomatis dijalankan saat sebuah objek dari class dibuat. Fungsinya biasanya digunakan untuk menginisialisasi nilai properti atau melakukan proses awal saat objek dibuat.

- Nama method constructor di PHP adalah `__construct()`.
- Bisa menerima parameter saat pembuatan objek.
- Tidak perlu dipanggil secara manual.

## Apa Itu Destructor?

**Destructor** adalah method khusus yang otomatis dipanggil saat objek dihancurkan atau keluar dari *scope* (misalnya di akhir eksekusi script). Umumnya digunakan untuk membersihkan resource seperti koneksi database, file, atau memori.

- Nama method destructor adalah `__destruct()`.
- Tidak menerima parameter.


## Contoh Penggunaan Constructor

```php
class Mahasiswa {
    public $nama;
    public $nim;

    // Constructor
    public function __construct($nama, $nim) {
        $this->nama = $nama;
        $this->nim = $nim;
        echo "Objek Mahasiswa '$this->nama' dengan NIM '$this->nim' telah dibuat.\n";
    }

    public function tampilkanData() {
        echo "Nama: $this->nama, NIM: $this->nim\n";
    }
}

// Membuat objek
$mhs1 = new Mahasiswa("Andi", "12345678");
$mhs1->tampilkanData();
```
output
```php
Objek Mahasiswa 'Andi' dengan NIM '12345678' telah dibuat.
Nama: Andi, NIM: 12345678
```

## Contoh Penggunaan Destructor
```php
class KoneksiDatabase {
    public function __construct() {
        echo "Koneksi ke database dibuat.\n";
    }

    public function __destruct() {
        echo "Koneksi ke database ditutup.\n";
    }
}

// Membuat objek
$db = new KoneksiDatabase();

// Di akhir eksekusi script, destructor otomatis dijalankan

```
output
```php
Koneksi ke database dibuat.
Koneksi ke database ditutup.
```
| Method          | Kapan Dijalanakan              | Fungsi Utama                               |
| --------------- | ------------------------------ | ------------------------------------------ |
| `__construct()` | Saat objek dibuat (`new`)      | Menginisialisasi data saat pembuatan objek |
| `__destruct()`  | Saat objek dihancurkan/selesai | Membersihkan resource atau proses akhir    |

- Constructor membantu menyederhanakan pembuatan objek dengan langsung mengisi nilai.
- Destructor berguna untuk penanganan cleanup otomatis saat objek sudah tidak dipakai lagi.


# 5. Inheritance (Pewarisan)

## Apa Itu Inheritance?

**Inheritance (Pewarisan)** adalah konsep dalam OOP yang memungkinkan sebuah class (disebut *child class* atau *subclass*) untuk mewarisi properti dan method dari class lain (disebut *parent class* atau *superclass*).

Tujuannya adalah untuk:
- **Menghindari duplikasi kode**
- **Mendukung prinsip DRY (Don't Repeat Yourself)**
- **Memungkinkan ekspansi dan modifikasi tanpa mengubah class induk**


## Struktur Pewarisan di PHP

Gunakan keyword `extends` untuk mewarisi class lain:

```php
class ParentClass {
    // Properties dan methods
}

class ChildClass extends ParentClass {
    // Bisa menambahkan atau menimpa (override) method
}
```
## Contoh Sederhana
```php
class Hewan {
    public $nama;

    public function bersuara() {
        echo "$this->nama bersuara...\n";
    }
}

class Kucing extends Hewan {
    public function bersuara() {
        echo "$this->nama berkata: Meong!\n";
    }
}

// Membuat objek
$kucing = new Kucing();
$kucing->nama = "Kitty";
$kucing->bersuara();
```
output
```php
Kitty berkata: Meong!
```

## Overriding Method
Child class bisa menimpa method dari parent class dengan mendefinisikan ulang method dengan nama yang sama.

```php
class Kendaraan {
    public function jalan() {
        echo "Kendaraan berjalan...\n";
    }
}

class Mobil extends Kendaraan {
    public function jalan() {
        echo "Mobil melaju di jalan raya.\n";
    }
}
```
## Menambahkan Method Baru di Child Class
Child class juga dapat menambahkan method tambahan yang tidak ada di parent class.
```php
class Pegawai {
    public function kerja() {
        echo "Pegawai sedang bekerja...\n";
    }
}

class Manajer extends Pegawai {
    public function rapat() {
        echo "Manajer sedang memimpin rapat.\n";
    }
}
```
## Aksesibilitas Pewarisan
Pewarisan tetap tunduk pada access modifier:
- `public`: dapat diwarisi dan diakses
- `protected`: dapat diwarisi, tapi hanya diakses dari class itu sendiri dan subclass
- `private`: tidak dapat diwarisi atau diakses dari subclass
```php
class Orang {
    private $nama = "Rahasia";

    protected $umur = 30;

    public function tampilkanUmur() {
        echo "Umur: $this->umur\n";
    }
}

class Anak extends Orang {
    public function tampilkanData() {
        // echo $this->nama; // ❌ Error (private)
        echo $this->umur;    // ✅ Bisa (protected)
    }
}
```
| Konsep          | Penjelasan                                                         |
| --------------- | ------------------------------------------------------------------ |
| `extends`       | Digunakan untuk mendefinisikan class anak dari class induk         |
| Overriding      | Method dari class induk bisa ditimpa dengan versi baru di subclass |
| Reusability     | Inheritance mendorong penggunaan ulang kode                        |
| Access Modifier | Menentukan properti/method mana yang bisa diwarisi dan diakses     |

Inheritance membantu membuat struktur kode yang modular, bersih, dan terorganisir, terutama ketika ada hierarki objek seperti Hewan → Kucing, Pegawai → Manajer, atau Kendaraan → Mobil.

# 6. Encapsulation (Enkapsulasi)

## Apa Itu Enkapsulasi?

**Encapsulation (Enkapsulasi)** adalah konsep OOP yang digunakan untuk menyembunyikan data atau implementasi detail dari suatu objek agar tidak bisa diakses secara langsung dari luar class. Tujuannya adalah:

- Meningkatkan keamanan data (data protection)
- Mengontrol akses terhadap properti dan method
- Menyediakan antarmuka (interface) yang jelas

---

## Access Modifiers di PHP

PHP menyediakan tiga modifier untuk mengatur visibilitas properti dan method:

| Modifier     | Keterangan                                                                 |
|--------------|-----------------------------------------------------------------------------|
| `public`     | Dapat diakses dari mana saja (dalam class, luar class, dan subclass)       |
| `protected`  | Hanya dapat diakses di dalam class itu sendiri dan subclass-nya            |
| `private`    | Hanya dapat diakses di dalam class itu sendiri                             |

---

## Contoh Enkapsulasi Dasar

```php
class RekeningBank {
    private $saldo = 0;

    public function setor($jumlah) {
        if ($jumlah > 0) {
            $this->saldo += $jumlah;
        }
    }

    public function tarik($jumlah) {
        if ($jumlah > 0 && $jumlah <= $this->saldo) {
            $this->saldo -= $jumlah;
        }
    }

    public function lihatSaldo() {
        return $this->saldo;
    }
}

// Penggunaan
$akun = new RekeningBank();
$akun->setor(1000);
$akun->tarik(200);
echo "Saldo sekarang: " . $akun->lihatSaldo();        
```
output
```php
Saldo sekarang: 800
```
##  Tanpa Enkapsulasi (Buruk)
```php
class Buruk {
    public $data = 0;
}

$obj = new Buruk();
$obj->data = -100; // Tidak ada kontrol, data bisa tidak valid

```
## Getter dan Setter
Getter dan Setter digunakan untuk mengakses dan mengubah properti yang bersifat private/protected.
```php
class Produk {
    private $harga;

    public function setHarga($harga) {
        if ($harga > 0) {
            $this->harga = $harga;
        }
    }

    public function getHarga() {
        return $this->harga;
    }
}

// Penggunaan
$barang = new Produk();
$barang->setHarga(50000);
echo "Harga produk: " . $barang->getHarga();

```
## Enkapsulasi + Validasi
Enkapsulasi memungkinkan kita menambahkan logika validasi dalam setter:
```php
public function setUmur($umur) {
    if ($umur < 0) {
        echo "Umur tidak boleh negatif!";
        return;
    }
    $this->umur = $umur;
}
```
| Konsep          | Penjelasan Singkat                                               |
| --------------- | ---------------------------------------------------------------- |
| Enkapsulasi     | Menyembunyikan data internal dan hanya membukanya lewat method   |
| Access Modifier | Menentukan level akses data: `public`, `protected`, `private`    |
| Getter & Setter | Digunakan untuk mengakses dan memodifikasi properti private      |
| Keamanan Data   | Enkapsulasi mencegah data diubah secara langsung dan sembarangan |

Dengan enkapsulasi, kode menjadi lebih aman, terkontrol, dan terstruktur. Ini adalah salah satu pilar OOP yang krusial untuk menjaga integritas data dalam program.


# 7. Abstraction dan Interface

## Apa Itu Abstraction?

**Abstraction (Abstraksi)** adalah konsep OOP yang menyembunyikan detail implementasi dan hanya menampilkan fungsionalitas penting kepada pengguna. Abstraksi dilakukan menggunakan:

- **Abstract Class**
- **Interface**

Tujuannya adalah agar pengguna cukup mengetahui *apa yang dilakukan*, tanpa perlu tahu *bagaimana cara melakukannya*.

## Abstract Class

- Tidak dapat diinstansiasi langsung.
- Dapat memiliki property dan method biasa (dengan implementasi).
- Harus memiliki minimal satu method `abstract`.
- Child class wajib mengimplementasikan method abstract tersebut.

```php
abstract class Bentuk {
    protected $warna;

    public function __construct($warna) {
        $this->warna = $warna;
    }

    abstract public function luas(); // Harus diimplementasi di child class
}

class Persegi extends Bentuk {
    private $sisi;

    public function __construct($warna, $sisi) {
        parent::__construct($warna);
        $this->sisi = $sisi;
    }

    public function luas() {
        return $this->sisi * $this->sisi;
    }
}

$persegi = new Persegi("Biru", 4);
echo "Luas: " . $persegi->luas();
```
## Interface
Menyediakan kontrak method tanpa implementasi.

Tidak memiliki property atau method dengan isi.

Tidak dapat memiliki constructor.

Sebuah class dapat mengimplementasi lebih dari satu interface (`multiple inheritance`).

```php
interface Kendaraan {
    public function jalan();
    public function berhenti();
}

class Mobil implements Kendaraan {
    public function jalan() {
        echo "Mobil berjalan...\n";
    }

    public function berhenti() {
        echo "Mobil berhenti.\n";
    }
}

$avanza = new Mobil();
$avanza->jalan();
$avanza->berhenti();
```

## Perbedaan Abstract Class vs Interface
| Fitur                 | Abstract Class                        | Interface                           |
| --------------------- | ------------------------------------- | ----------------------------------- |
| Dapat diinstansiasi?  | ❌ Tidak                               | ❌ Tidak                             |
| Method dengan isi?    | ✅ Bisa                                | ❌ Tidak                             |
| Property?             | ✅ Bisa                                | ❌ Tidak                             |
| Constructor?          | ✅ Bisa                                | ❌ Tidak                             |
| Multiple inheritance? | ❌ Tidak bisa diwarisi lebih dari satu | ✅ Bisa implement lebih dari satu    |
| Tujuan                | Pewarisan dengan dasar umum           | Kontrak perilaku yang harus diikuti |

## Kapan Abstract Class dan Interface digunakan?
| Situasi                                        | Gunakan        |
| ---------------------------------------------- | -------------- |
| Butuh pewarisan dengan method umum + wajib     | Abstract Class |
| Hanya ingin memaksa class agar punya method    | Interface      |
| Perlu inheritance jamak (multiple inheritance) | Interface      |

## Kesimpulan
- Abstraction menyembunyikan detail implementasi dan menampilkan fungsionalitas penting.
- Abstract Class digunakan jika kita ingin menyediakan implementasi dasar.
- Interface digunakan saat kita ingin membuat kontrak method yang harus dipenuhi class.

Dengan abstraksi, kode menjadi lebih modular, mudah dikembangkan, dan mengikuti prinsip design to interface, not implementation.


## 8. Static Properties dan Methods

## Apa Itu Static?

Dalam OOP PHP, keyword `static` digunakan untuk mendefinisikan **property** atau **method** yang **terikat ke class**, bukan ke objek. Artinya, kita **tidak perlu membuat objek** untuk mengaksesnya.

## Kapan Menggunakan Static?

Gunakan `static` ketika:
- Fungsi/properti tidak tergantung pada data instance.
- Ingin menyimpan nilai global dalam konteks class.
- Membuat utility/helper function (misalnya kalkulasi).


## Contoh Static Property

```php
class Counter {
    public static $jumlah = 0;

    public static function tambah() {
        self::$jumlah++;
    }
}

Counter::tambah();
Counter::tambah();
echo "Jumlah: " . Counter::$jumlah; // Output: Jumlah: 2
```
Penjelasan:
-`static $jumlah` menyimpan data yang bersifat global antar objek (shared).
-`self::` digunakan untuk mengakses property/method statis dari dalam class.
-`Counter::$jumlah` digunakan dari luar class.

## Contoh Static Method
```php
class Kalkulator {
    public static function tambah($a, $b) {
        return $a + $b;
    }

    public static function kali($a, $b) {
        return $a * $b;
    }
}

echo Kalkulator::tambah(5, 3); // Output: 8
echo Kalkulator::kali(4, 2);   // Output: 8
```
Static methods cocok untuk fungsi-fungsi utilitas karena bisa dipanggil langsung tanpa objek.

## self vs $this
| Keyword  | Digunakan untuk     | Kapan digunakan                  |
| -------- | ------------------- | -------------------------------- |
| `$this`  | Instance (objek)    | Untuk properti/method non-static |
| `self::` | Class (bukan objek) | Untuk properti/method static     |

## Catatan Penting
- Static property bersifat global dalam konteks class, bukan per objek.
- Static methods tidak bisa mengakses $this karena tidak ada objek yang terlibat.
- Tidak bisa override static method seperti method biasa (polymorphism terbatas).

## Contoh Kasus Sederhana
```php
class LoginTracker {
    public static $totalLogin = 0;

    public static function userLogin() {
        self::$totalLogin++;
        echo "User login. Total: " . self::$totalLogin . "\n";
    }
}

LoginTracker::userLogin(); // User login. Total: 1
LoginTracker::userLogin(); // User login. Total: 2
```
## Kesimpulan
- `static` membuat method/property terikat ke class, bukan objek.
- Digunakan untuk fungsi atau data yang tidak butuh konteks objek.
- Diakses menggunakan `self::` (dalam class) dan `ClassName::` (dari luar class).

Dengan static, kamu bisa membuat class seperti kalkulator, logger, atau konfigurasi global dengan lebih efisien.


## 9. Method Chaining

## Apa Itu Method Chaining?

**Method Chaining** adalah teknik dalam OOP PHP yang memungkinkan kita untuk memanggil beberapa method secara berurutan **dalam satu baris**. Hal ini membuat kode lebih singkat dan terlihat rapi.

Agar method chaining bisa dilakukan, setiap method **harus mengembalikan objek itu sendiri**, biasanya menggunakan `return $this;`.


## Kenapa Menggunakan Method Chaining?

- Membuat kode lebih ringkas.
- Meningkatkan keterbacaan saat mengatur banyak properti/metode berurutan.
- Populer dalam library seperti Laravel, Guzzle, atau Query Builder.

## Contoh Sederhana

```php
class Builder {
    private $text = "";

    public function tambahTeks($teks) {
        $this->text .= $teks . " ";
        return $this; // Mengembalikan objek saat ini
    }

    public function cetak() {
        echo trim($this->text) . "\n";
        return $this;
    }
}

// Penggunaan method chaining
$kalimat = new Builder();
$kalimat->tambahTeks("Halo")
        ->tambahTeks("dunia")
        ->tambahTeks("PHP!")
        ->cetak(); // Output: Halo dunia PHP!
```
## Cara Kerja return $this
- Setiap method yang mengembalikan `$this` akan membuat objek yang dipanggil
- Method berikutnya dapat dipanggil langsung setelah method sebelumnya
- Ini memungkinkan penggunaan method chaining
```php
public function namaMethod() {
    // aksi
    return $this; // penting untuk method chaining
}
```
Dengan mengembalikan `$this`, setiap method akan "mengembalikan dirinya", sehingga kita bisa memanggil method berikutnya.

## Contoh Lain: Konfigurasi Objek
```php
class Pengguna {
    private $nama;
    private $email;

    public function setNama($nama) {
        $this->nama = $nama;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function info() {
        echo "Nama: $this->nama, Email: $this->email\n";
        return $this;
    }
}

$user = new Pengguna();
$user->setNama("Salsa")
     ->setEmail("salsa@example.com")
     ->info();
```
## Perhatian
- Jangan lupa menambahkan return $this; di setiap method yang ingin digunakan dalam chaining.
- Tidak cocok untuk method yang hanya melakukan satu aksi final (seperti exit() atau die()).

## Kesimpulan
- Method chaining memudahkan pemanggilan method berantai dalam satu baris.
- Setiap method harus `return $this`.
- Berguna untuk builder pattern, konfigurasi objek, atau chaining query.

Dengan method chaining, kode PHP kamu akan terlihat lebih profesional dan bersih.


## 10. Namespaces

## Apa Itu Namespace?

**Namespace** adalah cara untuk mengelompokkan class, interface, fungsi, atau konstanta ke dalam satu nama yang terpisah. Tujuannya adalah untuk menghindari **konflik nama** antara class atau fungsi yang memiliki nama sama, terutama dalam proyek besar yang melibatkan banyak file dan library.

Namespace memungkinkan kita untuk memiliki beberapa class atau fungsi dengan nama yang sama tetapi berada di dalam namespace yang berbeda.

## Mengapa Menggunakan Namespace?

1. **Menghindari Konflik Nama**: Jika dua library berbeda menggunakan nama yang sama untuk class atau fungsi, kita bisa menaruhnya dalam namespace yang berbeda.
2. **Organisasi Kode**: Namespace membantu mengelompokkan class atau fungsi berdasarkan fungsionalitas, sehingga lebih mudah dalam manajemen dan pemeliharaan.
3. **Mempermudah Autoloading**: Framework PHP seperti Composer menggunakan namespace untuk autoloading class.

## Cara Mendefinisikan Namespace

```php
namespace App\Utils;

class Helper {
    public static function greet() {
        echo "Halo, selamat datang di namespace App\\Utils!";
    }
}
```
- `namespace App\Utils;` mendefinisikan namespace `App\Utils`.
- Class `Helper` berada di dalam namespace ini.

## Menggunakan Namespace
Untuk menggunakan class atau fungsi yang berada dalam namespace, kita perlu menggunakan `use` untuk mendeklarasikan namespace tersebut.
```php
namespace App\Main;

use App\Utils\Helper; // Import namespace App\Utils

class MainClass {
    public function __construct() {
        Helper::greet(); // Memanggil fungsi dari namespace App\Utils
    }
}

$obj = new MainClass();

```
- `use App\Utils\Helper;` memberitahu PHP untuk mencari class Helper dalam namespace App\Utils.
- Fungsi `greet` dapat dipanggil langsung menggunakan `Helper::greet()` setelah di-import.

## Penggunaan Namespace dalam File Terpisah
Namespace memudahkan manajemen kode ketika kita membagi kode ke dalam banyak file. Misalnya, file `Helper.php` akan berisi class `Helper` dengan namespace `App\Utils`, dan file lain seperti `MainClass.php` akan memanggilnya.
```php
// File Helper.php
namespace App\Utils;

class Helper {
    public static function greet() {
        echo "Halo dari Helper!";
    }
}
```
```php
// File MainClass.php
namespace App\Main;

use App\Utils\Helper;

class MainClass {
    public function __construct() {
        Helper::greet(); // Memanggil fungsi dari namespace App\Utils
    }
}

$obj = new MainClass();
```
## Tanpa Namespace
Jika tidak menggunakan namespace, semua class dan fungsi berada di dalam satu ruang nama global, yang bisa menyebabkan konflik jika ada class dengan nama yang sama.

```php
class Helper {
    public static function greet() {
        echo "Halo tanpa namespace!";
    }
}

class Helper { // Konflik: class dengan nama yang sama
    public static function greet() {
        echo "Ini adalah helper kedua!";
    }
}

```
## Menghindari Konflik Nama Dengan Alias
Kadang kita membutuhkan alias untuk namespace atau class agar tidak ada konflik atau untuk penamaan yang lebih singkat.

```php
namespace MyLongNamespace\SubNamespace;

class MyClass {
    public function sayHello() {
        echo "Hello from MyClass!";
    }
}

// Aliasing namespace untuk penggunaan yang lebih mudah
use MyLongNamespace\SubNamespace\MyClass as MC;

$mc = new MC();
$mc->sayHello();

```
## Kesimpulan
-Namespace membantu mengorganisir kode dan menghindari konflik nama antara class, fungsi, atau konstanta.
- Gunakan `namespace` untuk mengelompokkan class yang memiliki fungsionalitas yang serupa.
- Gunakan `use` untuk mengimpor class atau fungsi dari namespace lain.
- Namespace sangat penting dalam proyek besar dan ketika menggunakan composer atau library eksternal.

Dengan namespace, kode kamu menjadi lebih terstruktur, terorganisir, dan mudah di-manage.


## 11. Magic Methods (Opsional)

## Apa Itu Magic Methods?

**Magic methods** adalah metode khusus dalam PHP yang memiliki awalan `__` (dua garis bawah). PHP secara otomatis memanggil magic methods ini pada saat-saat tertentu, tanpa perlu memanggilnya langsung. 

Magic methods memberikan kemampuan untuk menangani perilaku khusus dalam objek, seperti ketika properti diakses atau objek dikonstruksi.

## Daftar Magic Methods

1. **`__construct()`** - Digunakan untuk inisialisasi objek saat objek dibuat (Constructor).
2. **`__destruct()`** - Digunakan untuk melakukan pembersihan objek sebelum objek dihancurkan (Destructor).
3. **`__get()`** - Dipanggil saat mencoba mengakses properti yang tidak ada atau tidak terdefinisi dalam objek.
4. **`__set()`** - Dipanggil saat mencoba mengubah nilai properti yang tidak ada atau tidak terdefinisi.
5. **`__call()`** - Dipanggil saat mencoba memanggil metode yang tidak ada dalam objek.
6. **`__callStatic()`** - Dipanggil saat mencoba memanggil metode statis yang tidak ada dalam objek.
7. **`__toString()`** - Digunakan untuk mengonversi objek menjadi string saat dipanggil dengan `echo` atau `print`.
8. **`__isset()`** - Dipanggil saat memeriksa apakah properti yang tidak ada sudah diset.
9. **`__unset()`** - Dipanggil saat mencoba menghapus properti yang tidak ada.
10. **`__clone()`** - Dipanggil saat objek di-clone menggunakan `clone`.


## Contoh Magic Method: `__construct` dan `__destruct`

```php
class Produk {
    public $nama;

    public function __construct($nama) {
        $this->nama = $nama;
        echo "Produk {$this->nama} telah dibuat.\n";
    }

    public function __destruct() {
        echo "Produk {$this->nama} telah dihancurkan.\n";
    }
}

$produk = new Produk("Laptop");
unset($produk); // Menjalankan __destruct()
```
- `__construct()` digunakan untuk inisialisasi objek dan menjalankan kode saat objek dibuat.
- `__destruct()` dipanggil saat objek dihancurkan, misalnya dengan unset().

## Magic Method: `__get()` dan `__set()`
Magic method `__get()` dan `__set()` digunakan untuk menangani akses atau penulisan ke properti yang tidak ada.
```php
class Mahasiswa {
    private $data = [];

    public function __get($key) {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }
}

$mhs = new Mahasiswa();
$mhs->nama = "Andi"; // Memanggil __set()
echo $mhs->nama;      // Memanggil __get()
```
- `__get($key)` menangani saat properti yang tidak ada diakses.
- `__set($key, $value)` menangani saat properti yang tidak ada diubah nilainya.

## Magic Method: `__call()`
`__call()` dipanggil saat mencoba memanggil method yang tidak ada pada objek.
```php
class Kontak {
    public function __call($method, $args) {
        echo "Memanggil method: $method dengan argumen: " . implode(", ", $args) . "\n";
    }
}

$kontak = new Kontak();
$kontak->hubungi("John", "Malam ini"); // Memanggil __call()

```
## Magic Method: `__toString()`
`__toString()` digunakan untuk mengonversi objek menjadi string, yang memungkinkan kita untuk menampilkan objek secara langsung menggunakan `echo`.
```php
class Buku {
    public $judul;

    public function __construct($judul) {
        $this->judul = $judul;
    }

    public function __toString() {
        return "Buku ini berjudul: {$this->judul}";
    }
}

$buku = new Buku("Belajar PHP");
echo $buku; // Memanggil __toString()
```
- `__toString()` memungkinkan objek ditampilkan sebagai string.

## Menggunakan Magic Methods dengan Bijak
Magic methods sangat berguna, tetapi penggunaan yang berlebihan atau tidak tepat bisa membuat kode sulit dibaca dan dipelihara. Sebaiknya hanya gunakan magic methods ketika benar-benar diperlukan, dan pastikan untuk mendokumentasikannya dengan jelas agar pengembang lain memahami bagaimana objek tersebut berfungsi.

## Kesimpulan
- Magic Methods memungkinkan PHP untuk menangani beberapa perilaku objek secara otomatis.
- Magic methods seperti `__construct()`, `__get()`, `__set()`, dan lainnya memberikan fleksibilitas tambahan dalam OOP.
- Gunakan magic methods untuk menangani skenario yang membutuhkan kontrol dinamis terhadap objek atau properti.

Dengan magic methods, kamu bisa mengontrol cara objek berperilaku lebih lanjut dalam aplikasi PHP kamu!

---

## 📎 Referensi

- [PHP Manual - OOP](https://www.php.net/manual/en/language.oop5.php)
- [PHP: Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php)

---
