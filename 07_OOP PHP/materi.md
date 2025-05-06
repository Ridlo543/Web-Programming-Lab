
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

---

## Apa Itu OOP?

**Object-Oriented Programming (OOP)** adalah paradigma pemrograman yang berfokus pada penggunaan *objek* dan *class* sebagai cara utama untuk menyusun dan membangun program.

Berbeda dengan pemrograman prosedural (seperti menggunakan fungsi global secara terpisah), OOP menggabungkan **data (properties)** dan **perilaku (methods)** ke dalam satu unit yang disebut **objek**.

---

## Konsep Utama dalam OOP

Berikut adalah empat pilar utama dari OOP yang akan kamu temui saat mempelajari OOP dalam PHP:

| Pilar            | Penjelasan Singkat                                                                 |
|------------------|-------------------------------------------------------------------------------------|
| **Encapsulation** | Menyembunyikan detail internal dari objek agar tidak bisa diakses sembarangan.      |
| **Inheritance**   | Kemampuan suatu class untuk mewarisi sifat dan perilaku dari class lain.            |
| **Polymorphism**  | Objek dapat memiliki banyak bentuk, biasanya lewat overriding method.               |
| **Abstraction**   | Menyembunyikan kompleksitas dan hanya menunjukkan informasi penting ke pengguna.    |

---

## Mengapa Menggunakan OOP di PHP?

- **Modularitas:** Kode lebih mudah dipisahkan dalam class/class file.
- **Reusability:** Class bisa digunakan kembali tanpa perlu menulis ulang kode.
- **Maintainability:** Perubahan dalam satu class tidak akan berdampak langsung ke bagian lain.
- **Scalability:** Struktur program lebih mudah diperluas karena berbasis objek.

---

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

---

## Kesimpulan

OOP membantu kamu menulis kode yang lebih **terstruktur**, **mudah dibaca**, dan **fleksibel untuk dikembangkan**. Konsep ini sangat penting, terutama untuk proyek berskala menengah ke atas di PHP seperti aplikasi web, sistem manajemen konten (CMS), dan framework seperti Laravel atau Symfony.

---

#  2. Class dan Object

## Apa Itu Class?

Class adalah *blueprint* atau cetakan untuk membuat objek. Di dalam class, kita mendefinisikan:
- **Properties**: variabel yang menyimpan data atau atribut dari objek.
- **Methods**: fungsi yang mendefinisikan perilaku atau aksi dari objek.

---

## Apa Itu Object?

Object adalah instansi nyata dari sebuah class. Setelah class didefinisikan, kita bisa membuat objek menggunakan keyword `new`.

---

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

### Keyword $this
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
### Tipe Akses Property dan Method
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

### Banyak Objek dari Satu Class
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
### Kesimpulan
- Class adalah cetakan untuk membuat objek.
- Object adalah instansi nyata dari class.
- Gunakan keyword $this untuk mengakses property/method dari dalam class.
- PHP menyediakan access modifiers (public, private, protected) untuk keamanan dan pengaturan akses.
- Satu class bisa digunakan untuk membuat banyak objek dengan data yang berbeda.



# 3. Properties dan Methods

### Apa Itu Properties?

*Properties* adalah variabel yang dideklarasikan di dalam class untuk menyimpan data atau atribut dari objek. Properti bisa bersifat publik, privat, atau protektif tergantung pada kebutuhan keamanan data.

Contoh:

php
class Produk {
    public $nama;
    public $harga;
}


### Apa Itu Methods?

*Methods* adalah fungsi yang berada di dalam class. Method menggambarkan perilaku atau aksi dari objek. Seperti fungsi biasa, method bisa menerima parameter dan mengembalikan nilai.

Contoh:

php
class Produk {
    public $nama;
    public $harga;

    public function tampilkanInfo() {
        echo "Produk: $this->nama, Harga: $this->harga\n";
    }
}


### Mengakses Properties dan Methods

Gunakan -> untuk mengakses property dan method dari objek.

php
$produk1 = new Produk();
$produk1->nama = "Laptop";
$produk1->harga = 10000000;
$produk1->tampilkanInfo(); // Output: Produk: Laptop, Harga: 10000000


### Modifikasi Property dari Method

Kita bisa mengatur atau mengubah nilai property langsung dari dalam method menggunakan $this.

php
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


### Jenis Visibility pada Property & Method

| Modifier    | Akses dari Luar | Akses dari Class Sendiri | Akses dari Class Turunan |
| ----------- | --------------- | ------------------------ | ------------------------ |
| public    | ✔              | ✔                       | ✔                       |
| protected | ❌               | ✔                       | ✔                       |
| private   | ❌               | ✔                       | ❌                        |

php
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


### Kesimpulan

* *Properties* adalah data/atribut objek.
* *Methods* adalah aksi/perilaku objek.
* Gunakan -> untuk mengakses properties dan methods dari objek.
* Gunakan $this untuk merujuk ke properti/method di dalam class.
* Atur visibilitas (public, private, protected) untuk keamanan data.

---

# 4. Constructor dan Destructor

### Apa Itu Constructor?

**Constructor** adalah method khusus yang secara otomatis dijalankan saat sebuah objek dari class dibuat. Fungsinya biasanya digunakan untuk menginisialisasi nilai properti atau melakukan proses awal saat objek dibuat.

- Nama method constructor di PHP adalah `__construct()`.
- Bisa menerima parameter saat pembuatan objek.
- Tidak perlu dipanggil secara manual.

### Apa Itu Destructor?

**Destructor** adalah method khusus yang otomatis dipanggil saat objek dihancurkan atau keluar dari *scope* (misalnya di akhir eksekusi script). Umumnya digunakan untuk membersihkan resource seperti koneksi database, file, atau memori.

- Nama method destructor adalah `__destruct()`.
- Tidak menerima parameter.

---

### Contoh Penggunaan Constructor

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

---

### Contoh Penggunaan Destructor
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


## 5. Inheritance (Pewarisan)

### 👪 Apa Itu Inheritance?

**Inheritance (Pewarisan)** adalah konsep dalam OOP yang memungkinkan sebuah class (disebut *child class* atau *subclass*) untuk mewarisi properti dan method dari class lain (disebut *parent class* atau *superclass*).

Tujuannya adalah untuk:
- **Menghindari duplikasi kode**
- **Mendukung prinsip DRY (Don't Repeat Yourself)**
- **Memungkinkan ekspansi dan modifikasi tanpa mengubah class induk**

---

### 🧩 Struktur Pewarisan di PHP

Gunakan keyword `extends` untuk mewarisi class lain:

```php
class ParentClass {
    // Properties dan methods
}

class ChildClass extends ParentClass {
    // Bisa menambahkan atau menimpa (override) method
}
```
### Contoh Sederhana
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

### Overriding Method
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
### Menambahkan Method Baru di Child Class
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
### Aksesibilitas Pewarisan
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

---

## 6. Encapsulation (Enkapsulasi)

Menyembunyikan data internal dengan **access modifiers**: `public`, `private`, `protected`.

```php
class Bank {
    private $saldo = 1000;

    public function lihatSaldo() {
        return $this->saldo;
    }
}
```

---

## 7. Abstraction dan Interface

- **Abstract Class**: Tidak bisa diinstansiasi langsung.
- **Interface**: Menyediakan kontrak method yang harus diimplementasikan.

```php
abstract class Bentuk {
    abstract public function luas();
}

interface Kendaraan {
    public function jalan();
}
```

---

## 8. Static Properties dan Methods

Dapat diakses tanpa membuat objek.

```php
class Kalkulator {
    public static $pi = 3.14;

    public static function tambah($a, $b) {
        return $a + $b;
    }
}

echo Kalkulator::$pi;
echo Kalkulator::tambah(2, 3);
```

---

## 9. Method Chaining

Memanggil beberapa method secara berurutan dalam satu baris.

```php
class Builder {
    public function step1() {
        echo "Langkah 1
";
        return $this;
    }

    public function step2() {
        echo "Langkah 2
";
        return $this;
    }
}

$obj = new Builder();
$obj->step1()->step2();
```

---

## 10. Namespaces

Menghindari konflik nama class atau fungsi.

```php
namespace App\Utils;

class Helper {
    public static function greet() {
        echo "Halo dari Utils!";
    }
}
```

---

## 11. Magic Methods (Opsional)

Method khusus dengan awalan `__`, seperti `__construct`, `__get`, `__set`, `__toString`.

```php
class User {
    private $name;

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }
}
```

---

## 📎 Referensi

- [PHP Manual - OOP](https://www.php.net/manual/en/language.oop5.php)
- [PHP: Magic Methods](https://www.php.net/manual/en/language.oop5.magic.php)

---
