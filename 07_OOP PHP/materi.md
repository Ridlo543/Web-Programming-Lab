
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

## 4. Constructor dan Destructor

- **Constructor** otomatis dijalankan saat objek dibuat.
- **Destructor** otomatis dijalankan saat objek dihancurkan.

```php
class Buku {
    public function __construct() {
        echo "Buku dibuat
";
    }

    public function __destruct() {
        echo "Buku dihancurkan
";
    }
}
```

---

## 5. Inheritance (Pewarisan)

Memungkinkan class untuk mewarisi properti dan method dari class lain.

```php
class Hewan {
    public function suara() {
        echo "Suara hewan";
    }
}

class Kucing extends Hewan {
    public function suara() {
        echo "Meong";
    }
}
```

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
