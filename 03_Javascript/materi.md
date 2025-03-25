# Praktikum Pemrograman Web 3: JavaScript

JavaScript adalah bahasa pemrograman yang digunakan untuk membuat halaman web interaktif. Dalam bab ini, kita akan mempelajari konsep-konsep dasar JavaScript yang relevan untuk praktikum Web Programming.

## Daftar Isi

1. [Pengenalan JavaScript](#1-pengenalan-javascript)
2. [Variabel dan Tipe Data](#2-variabel-dan-tipe-data)
3. [Operator](#3-operator)
4. [Struktur Kontrol](#4-struktur-kontrol)
5. [Fungsi](#5-fungsi)
6. [DOM Manipulation](#6-dom-manipulation)
7. [Event Handling](#7-event-handling)
8. [Array dan Method](#8-array-dan-method)
9. [Objek dan JSON](#9-objek-dan-json)
10. [Error Handling](#10-error-handling)

## 1. Pengenalan JavaScript

JavaScript dapat disisipkan ke dalam halaman HTML dengan tiga cara:

- **Inline**: Kode ditulis langsung pada atribut elemen HTML.
- **Internal**: Kode ditulis di dalam elemen `<script>` pada HTML.
- **External**: Kode ditulis di file terpisah (`.js`) dan dihubungkan ke HTML.

### Cara Penyisipan JavaScript

#### 1.1 Inline

```html
<button onclick="alert('Hello World!')">Klik Saya</button>
```

#### 1.2 Internal

```html
<head>
  <script>
    function greet() {
      alert("Hello World!");
    }
  </script>
</head>
<body>
  <button onclick="greet()">Klik Saya</button>
</body>
```

#### 1.3 External

File `script.js`:

```javascript
function greet() {
  alert("Hello World!");
}
```

File HTML:

```html
<head>
  <script src="script.js"></script>
</head>
<body>
  <button onclick="greet()">Klik Saya</button>
</body>
```

---

## 2. Variabel dan Tipe Data

Variabel digunakan untuk menyimpan data. JavaScript mendukung deklarasi variabel dengan `var`, `let`, dan `const`, serta tipe data seperti string, number, boolean, array, dan object.

### 2.1 Deklarasi Variabel

- `var`: Function scope, deklarasi lama.
- `let`: Block scope, lebih modern.
- `const`: Nilai konstan, tidak dapat diubah.

Perbandingan dalam table:
| Fitur | `var` | `let` | `const` |
| ------------- | -------------------- | ----------------------------- | ----------------------------- |
| Scope | Function scope | Block scope | Block scope |
| Redeclaration | Bisa | Tidak bisa | Tidak bisa |
| Reassignment | Bisa | Bisa | Tidak bisa |
| Hoisting | Ya (nilai undefined) | Ya (dalam temporal dead zone) | Ya (dalam temporal dead zone) |

```javascript
function perbedaanVarLetConst() {
  if (true) {
    var a = "var"; // Function scope
    let b = "let"; // Block scope
    const c = "const"; // Block scope
  }
  console.log(a); // Output: "var"
  // console.log(b); // Error: b is not defined
  // console.log(c); // Error: c is not defined
}

perbedaanVarLetConst();
```

### 2.2 Tipe Data Dasar

```javascript
// Primitif
let teksString = "Hello"; // String
let angkaBulat = 42; // Number
let desimal = 3.14; // Number
let benar = true; // Boolean
let kosong = null; // Null
let takTerdefinisi = undefined; // Undefined

// Kompleks
let daftarBuah = ["Apel", "Pisang"]; // Array
let orang = { nama: "Budi", umur: 25 }; // Object
```

---

## 3. Operator

Operator digunakan untuk operasi pada data.

- **Aritmatika**: `+`, `-`, `*`, `/`, `%`
- **Perbandingan**: `==`, `===`, `!=`, `>`, `<`
- **Logika**: `&&`, `||`, `!`

### 3.1 Operator Aritmatika

```javascript
let x = 10,
  y = 5;
console.log(x + y); // Penjumlahan: 15
console.log(x - y); // Pengurangan: 5
console.log(x * y); // Perkalian: 50
console.log(x / y); // Pembagian: 2
console.log(x % y); // Modulus: 0
```

### 3.2 Operator Perbandingan

```javascript
console.log(x === y); // Identik: false
console.log(x > y); // Lebih besar: true
console.log(x <= y); // Kurang dari atau sama: false
```

Perbedaan tanda = , == , dan === dalam table:
| Tanda | Keterangan |
| ------------- | -------------------- |
| = | Operator assignment, digunakan untuk memberikan nilai pada variabel |
| == | Operator perbandingan, digunakan untuk membandingkan dua nilai, tanpa memperhatikan tipe data |
| === | Operator perbandingan, digunakan untuk membandingkan dua nilai, dengan memperhatikan tipe data |

```javascript
let x = 10,
  y = "10";
console.log(x == y); // true
console.log(x === y); // false
```

### 3.3 Operator Logika

```javascript
let a = true,
  b = false;
console.log(a && b); // AND: false
console.log(a || b); // OR: true
console.log(!a); // NOT: false
```

---

## 4. Struktur Kontrol

Struktur kontrol mengatur alur program.

- **if-else**: Percabangan berdasarkan kondisi.
- **switch**: Pilihan banyak kondisi.
- **for**: Perulangan dengan batas.
- **while**: Perulangan selama kondisi benar.
- **do-while**: Perulangan minimal satu kali.

### 4.1 Percabangan

```javascript
let skor = 85;
if (skor >= 80) {
  console.log("Lulus dengan Baik");
} else if (skor >= 70) {
  console.log("Lulus");
} else {
  console.log("Tidak Lulus");
}

// Switch
let hari = 3;
switch (hari) {
  case 1:
    console.log("Senin");
    break;
  case 2:
    console.log("Selasa");
    break;
  default:
    console.log("Hari Lain");
}
```

### 4.2 Perulangan

```javascript
// For
for (let i = 0; i < 5; i++) {
  console.log(i);
}

// While
let j = 0;
while (j < 5) {
  console.log(j);
  j++;
}

// Do-While
let k = 0;
do {
  console.log(k);
  k++;
} while (k < 5);
```

---

## 5. Fungsi

Fungsi adalah blok kode yang dapat dipanggil ulang dengan parameter dan mengembalikan nilai.

- **Deklarasi Biasa**: Menggunakan `function`.
- **Arrow Function**: Sintaks modern dengan `=>`.

### Contoh

```javascript
// Fungsi biasa
function jumlah(a, b) {
  return a + b;
}
console.log(jumlah(3, 4)); // 7

// Arrow Function
const kali = (a, b) => a * b;
console.log(kali(2, 3)); // 6

// Fungsi dengan Parameter Default
function sapa(nama = "Tamu") {
  return `Halo, ${nama}!`;
}
```

---

## 6. DOM Manipulation

DOM (Document Object Model) memungkinkan JavaScript mengubah elemen HTML.

- **Seleksi**: `getElementById()`, `querySelector()`
- **Mengubah Konten**: `innerHTML`, `textContent`
- **Mengubah Atribut**: `setAttribute()`, `style`

### Contoh

```javascript
// Seleksi Elemen
let elemen = document.getElementById("myElement");
let elemenPertama = document.querySelector(".class");

// Mengubah Konten
elemen.innerHTML = "Konten Baru";
elemen.textContent = "Teks Baru";

// Mengubah Gaya
elemen.style.color = "red";
elemen.style.backgroundColor = "yellow";
```

---

## 7. Event Handling

Event adalah aksi seperti klik atau hover yang ditangani JavaScript.

### Contoh

```javascript
// Cara 1: Inline
// <button onclick="fungsi()">Klik</button>

// Cara 2: addEventListener
document.getElementById("tombol").addEventListener("click", function () {
  alert("Tombol Diklik!");
});

// Berbagai Event
elemen.addEventListener("mouseover", function () {
  console.log("Mouse di atas elemen");
});
```

---

## 8. Array dan Method Array

Array menyimpan banyak data dan memiliki method untuk manipulasi.

- `push()`: Tambah elemen di akhir.
- `pop()`: Hapus elemen terakhir.
- `map()`: Buat array baru dari fungsi.
- `filter()`: Saring elemen berdasarkan kondisi.
- `forEach()`: Jalankan fungsi untuk setiap elemen.

### Contoh

```javascript
let buah = ["Apel", "Pisang", "Jeruk"];

// Menambah/Mengurangi Elemen
buah.push("Mangga"); // Tambah di akhir
buah.pop(); // Hapus terakhir
buah.unshift("Anggur"); // Tambah di awal
buah.shift(); // Hapus pertama

// Transformasi
let angka = [1, 2, 3, 4];
let kaliDua = angka.map((x) => x * 2); // [2, 4, 6, 8]
let genap = angka.filter((x) => x % 2 === 0); // [2, 4]

// Iterasi
angka.forEach((x) => console.log(x));
```

---

## 9. Objek dan JSON

Objek menyimpan data dalam pasangan key-value. JSON adalah format untuk pertukaran data.

### Contoh Objek

```javascript
// Objek
let mahasiswa = {
  nama: "Ani",
  nim: "12345",
  kuliah: function () {
    console.log(`${this.nama} sedang kuliah`);
  },
};

// JSON
let jsonString = JSON.stringify(mahasiswa); // untuk mengubah objek ke JSON
let objekLagi = JSON.parse(jsonString); // untuk mengubah JSON ke objek
```

### Contoh JSON

```javascript
let jsonData = '{"nama":"Ani","umur":22}';
let obj = JSON.parse(jsonData); // JSON ke objek
console.log(obj.nama); // Ani
let jsonBaru = JSON.stringify(obj); // Objek ke JSON
console.log(jsonBaru); // '{"nama":"Ani","umur":22}'
```

---

## 10. Pengenalan Error Handling

Error handling menangani kesalahan saat program berjalan.

- `try`: Kode yang mungkin error.
- `catch`: Tangkap error.
- `finally`: Selalu dijalankan.

### Contoh

```javascript
try {
  let z = undeclaredVar + 10; // Error: variabel tidak didefinisikan
} catch (error) {
  console.log("Error: " + error.message);
} finally {
  console.log("Selesai.");
}
```

## Referensi

- [MDN Web Docs: JavaScript](https://developer.mozilla.org/en-US/docs/Learn_web_development/Core/Scripting)
