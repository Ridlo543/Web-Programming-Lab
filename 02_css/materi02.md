# Praktikum Pemrograman Web 2 - CSS (Cascading Style Sheets)

## Pengertian CSS

CSS (_Cascading Style Sheets_) adalah bahasa yang digunakan untuk mengatur tampilan dan format elemen HTML pada halaman web. CSS memungkinkan pemisahan antara konten (HTML) dan presentasi (gaya tampilan), sehingga kita dapat mengatur warna, font, layout, dan aspek visual lainnya dengan lebih terstruktur.

## Cara Menerapkan CSS

Ada tiga metode utama untuk menerapkan CSS pada dokumen HTML:

### 1. Inline CSS

Style ditulis langsung pada elemen HTML menggunakan atribut `style`.

```html
<p style="color: blue; font-size: 16px; font-weight: bold;">
  Ini adalah paragraf dengan inline CSS.
</p>
```

**Kelebihan**:

- Cepat diterapkan untuk perubahan kecil

**Kekurangan**:

- Sulit untuk dikelola pada skala besar
- Tidak dapat digunakan kembali

### 2. Internal CSS

Style ditulis di dalam elemen `<style>` pada bagian `<head>` dokumen HTML.

```html
<head>
  <style>
    p {
      color: blue;
      font-size: 16px;
      font-weight: bold;
    }
    .highlight {
      background-color: yellow;
    }
  </style>
</head>
<body>
  <p>Paragraf dengan internal CSS.</p>
  <p class="highlight">Paragraf dengan highlight.</p>
</body>
```

**Kelebihan**:

- Dapat diterapkan ke beberapa elemen dalam satu halaman
- Tidak perlu file tambahan

**Kekurangan**:

- Tidak dapat digunakan kembali untuk halaman lain
- Meningkatkan ukuran file HTML

### 3. External CSS

Gaya ditulis di file terpisah (`.css`) dan dihubungkan ke HTML dengan elemen `<link>`.

File `styles.css`:

```css
p {
  color: blue;
  font-size: 16px;
  font-weight: bold;
}
.highlight {
  background-color: yellow;
}
```

File HTML:

```html
<head>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <p>Paragraf dengan external CSS.</p>
  <p class="highlight">Paragraf dengan highlight.</p>
</body>
```

**Kelebihan**:

- Dapat digunakan kembali di beberapa halaman
- Pemisahan yang jelas antara HTML dan CSS
- File HTML lebih kecil dan lebih bersih
- Browser dapat menyimpan file CSS dalam cache

**Kekurangan**:

- Memerlukan permintaan HTTP tambahan

## Selektor CSS

Selektor CSS digunakan untuk memilih elemen HTML yang akan diberi gaya.

### Selektor Dasar

| Selektor  | Contoh        | Keterangan                                  |
| --------- | ------------- | ------------------------------------------- |
| Elemen    | `p { }`       | Memilih semua elemen `<p>`                  |
| Kelas     | `.intro { }`  | Memilih semua elemen dengan `class="intro"` |
| ID        | `#header { }` | Memilih elemen dengan `id="header"`         |
| Universal | `* { }`       | Memilih semua elemen                        |

### Selektor Kombinasi

| Selektor         | Contoh        | Keterangan                                                    |
| ---------------- | ------------- | ------------------------------------------------------------- |
| Descendant       | `div p { }`   | Memilih semua `<p>` yang berada di dalam `<div>`              |
| Child            | `div > p { }` | Memilih semua `<p>` yang merupakan anak langsung dari `<div>` |
| Adjacent Sibling | `h1 + p { }`  | Memilih `<p>` yang tepat berada setelah `<h1>`                |
| General Sibling  | `h1 ~ p { }`  | Memilih semua `<p>` yang berada setelah `<h1>`                |

### Selektor Atribut

```css
/* Memilih elemen dengan atribut tertentu */
[type] {
}

/* Memilih elemen dengan atribut dan nilai tertentu */
[type="text"] {
}

/* Memilih elemen dengan nilai atribut yang mengandung kata tertentu */
[class~="btn"] {
}
```

### Pseudo-class dan Pseudo-element

```css
/* Pseudo-class */
a:hover {
  color: red;
} /* Saat mouse di atas link */
input:focus {
  outline: 2px solid blue;
} /* Saat input difokuskan */
li:nth-child(odd) {
  background-color: #f2f2f2;
} /* Untuk elemen ganjil */

/* Pseudo-element */
p::first-letter {
  font-size: 200%;
} /* Huruf pertama paragraf */
p::before {
  content: "»";
} /* Menambahkan konten sebelum paragraf */
```

## Properti CSS Penting

### Warna dan Latar Belakang

```css
.box {
  /* Warna teks */
  color: #333333;

  /* Latar belakang */
  background-color: #f0f0f0;
  background-image: url("gambar.jpg");
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;

  /* Shorthand */
  background: #f0f0f0 url("gambar.jpg") no-repeat center/cover;
}
```

### Font dan Teks

```css
.text {
  /* Font */
  font-family: Arial, Helvetica, sans-serif;
  font-size: 16px;
  font-weight: bold;
  font-style: italic;

  /* Shorthand */
  font: italic bold 16px/1.5 Arial, sans-serif;

  /* Teks */
  text-align: center;
  text-decoration: underline;
  text-transform: uppercase;
  line-height: 1.5;
  letter-spacing: 1px;
  word-spacing: 3px;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}
```

### Box Model

![Box Model Diagram](https://i.imgur.com/NMWWDYn.png)

```css
.box {
  /* Dimensi */
  width: 300px;
  height: 200px;

  /* Padding (ruang dalam) */
  padding-top: 10px;
  padding-right: 20px;
  padding-bottom: 10px;
  padding-left: 20px;
  /* Shorthand */
  padding: 10px 20px; /* atas-bawah kiri-kanan */

  /* Border (garis batas) */
  border-width: 2px;
  border-style: solid;
  border-color: #000;
  /* Shorthand */
  border: 2px solid #000;
  border-radius: 5px; /* Sudut melengkung */

  /* Margin (ruang luar) */
  margin-top: 10px;
  margin-right: auto;
  margin-bottom: 10px;
  margin-left: auto;
  /* Shorthand */
  margin: 10px auto; /* atas-bawah kiri-kanan (otomatis) */

  /* Mengubah cara box model dihitung */
  box-sizing: border-box; /* width & height termasuk padding dan border */
}
```

## Display dan Position

### Display

```css
/* Block: mengambil seluruh lebar, memulai baris baru */
div {
  display: block;
}

/* Inline: hanya mengambil lebar sesuai konten */
span {
  display: inline;
}

/* Inline-block: inline tapi dapat diatur width dan height */
.inline-box {
  display: inline-block;
}

/* None: menyembunyikan elemen sepenuhnya */
.hidden {
  display: none;
}

/* Flex: layout satu dimensi */
.container {
  display: flex;
}

/* Grid: layout dua dimensi */
.grid {
  display: grid;
}
```

### Position

```css
/* Static: posisi default */
.static {
  position: static;
}

/* Relative: relatif terhadap posisi normal */
.relative {
  position: relative;
  top: 10px;
  left: 20px;
}

/* Absolute: relatif terhadap ancestor berposisi (non-static) */
.absolute {
  position: absolute;
  top: 0;
  right: 0;
}

/* Fixed: relatif terhadap viewport */
.fixed {
  position: fixed;
  bottom: 20px;
  right: 20px;
}

/* Sticky: kombinasi relative & fixed */
.sticky {
  position: sticky;
  top: 0;
}
```

## Flexbox

Flexbox adalah model layout satu dimensi untuk mengatur elemen dalam container.

```css
.flex-container {
  display: flex;

  /* Arah utama */
  flex-direction: row; /* (default) | row-reverse | column | column-reverse */

  /* Perataan di sumbu utama */
  justify-content: space-between; /* flex-start | flex-end | center | space-around | space-evenly */

  /* Perataan di sumbu silang */
  align-items: center; /* flex-start | flex-end | center | stretch | baseline */

  /* Perataan multi-baris */
  align-content: space-between; /* flex-start | flex-end | center | stretch | space-around | space-evenly */

  /* Wrap atau tidak */
  flex-wrap: wrap; /* nowrap | wrap | wrap-reverse */
}

.flex-item {
  /* Urutan tampilan */
  order: 1;

  /* Kemampuan untuk tumbuh */
  flex-grow: 1;

  /* Kemampuan untuk menyusut */
  flex-shrink: 1;

  /* Ukuran dasar */
  flex-basis: 200px;

  /* Shorthand */
  flex: 1 1 200px; /* flex-grow flex-shrink flex-basis */

  /* Menimpa align-items untuk item tertentu */
  align-self: flex-end; /* auto | flex-start | flex-end | center | stretch | baseline */
}
```

## Grid

CSS Grid adalah model layout dua dimensi untuk mengatur elemen dalam baris dan kolom.

```css
.grid-container {
  display: grid;

  /* Mendefinisikan kolom */
  grid-template-columns: 1fr 2fr 1fr; /* 3 kolom dengan rasio lebar 1:2:1 */
  grid-template-columns: repeat(3, 1fr); /* 3 kolom dengan lebar sama */

  /* Mendefinisikan baris */
  grid-template-rows: 100px auto 100px; /* Baris atas & bawah 100px, tengah otomatis */

  /* Jarak antar sel */
  gap: 10px; /* row-gap & column-gap */
  row-gap: 15px;
  column-gap: 10px;

  /* Nama area */
  grid-template-areas:
    "header header header"
    "sidebar content content"
    "footer footer footer";
}

.grid-item {
  /* Menempatkan item di grid */
  grid-column: 1 / 3; /* Dari garis 1 sampai 3 (2 kolom) */
  grid-row: 2 / 4; /* Dari garis 2 sampai 4 (2 baris) */

  /* Atau dengan area */
  grid-area: header; /* Sesuai dengan nama di grid-template-areas */

  /* Shortcuts */
  grid-column: span 2; /* Membentang 2 kolom */
  grid-row: span 2; /* Membentang 2 baris */
}
```

## Responsif Design

Design responsif memungkinkan halaman web terlihat baik di semua perangkat.

### Media Queries

```css
/* Untuk layar kecil (smartphone) */
@media (max-width: 600px) {
  .container {
    flex-direction: column;
  }
}

/* Untuk layar sedang (tablet) */
@media (min-width: 601px) and (max-width: 1024px) {
  .container {
    flex-direction: row;
    flex-wrap: wrap;
  }
}

/* Untuk layar besar (desktop) */
@media (min-width: 1025px) {
  .container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
  }
}

/* Untuk orientasi landscape */
@media (orientation: landscape) {
  .banner {
    height: 200px;
  }
}
```

### Ukuran Responsif

```css
/* Ukuran relatif */
.container {
  width: 80%; /* Persentase dari container induk */
  max-width: 1200px; /* Batasan lebar maksimum */
}

.fluid-image {
  width: 100%; /* Gambar mengikuti lebar container */
  height: auto; /* Menjaga rasio aspek */
}

/* Unit relatif ke viewport */
.hero {
  height: 100vh; /* 100% tinggi viewport */
  width: 50vw; /* 50% lebar viewport */
}

/* Unit relatif ke font */
.text {
  font-size: 1.2rem; /* Relatif ke ukuran font root */
  padding: 1em; /* Relatif ke ukuran font elemen */
}
```

## CSS Variables (Custom Properties)

```css
:root {
  --primary-color: #3498db;
  --secondary-color: #2ecc71;
  --border-radius: 4px;
  --default-padding: 15px;
  --header-height: 60px;
}

.button {
  background-color: var(--primary-color);
  border-radius: var(--border-radius);
  padding: var(--default-padding);
}

.alert {
  background-color: var(--secondary-color);
  margin-top: calc(var(--header-height) + 10px);
}
```

## Transformasi dan Transisi

### Transformasi

```css
.transform-example {
  /* Skala */
  transform: scale(1.5);
  transform: scaleX(1.2) scaleY(0.8);

  /* Rotasi */
  transform: rotate(45deg);

  /* Translasi (perpindahan) */
  transform: translateX(20px) translateY(-10px);
  transform: translate(20px, -10px);

  /* Miring */
  transform: skew(10deg, 5deg);

  /* Kombinasi */
  transform: rotate(45deg) scale(1.5) translate(20px, 0);
}
```

### Transisi

```css
.transition-example {
  background-color: #3498db;
  transition: background-color 0.3s ease, transform 0.5s ease-out;
}

.transition-example:hover {
  background-color: #2ecc71;
  transform: scale(1.1);
}
```

## Animasi CSS

```css
@keyframes slide-in {
  0% {
    transform: translateX(-100%);
    opacity: 0;
  }

  100% {
    transform: translateX(0);
    opacity: 1;
  }
}

.animate {
  animation-name: slide-in;
  animation-duration: 1s;
  animation-timing-function: ease-out;
  animation-delay: 0.2s;
  animation-iteration-count: 1;
  animation-direction: normal;
  animation-fill-mode: forwards;

  /* Shorthand */
  animation: slide-in 1s ease-out 0.2s 1 normal forwards;
}
```

## Praktik Terbaik CSS

1. **Gunakan External CSS** untuk memisahkan struktur (HTML) dan presentasi (CSS).
2. **Gunakan Class** untuk styling daripada ID (kecuali untuk JavaScript).
3. **Minimize Specificity** untuk menghindari kaskade yang rumit.
4. **Gunakan Naming Convention** seperti BEM (Block, Element, Modifier).
5. **Organisasikan CSS** dengan baik, kelompokkan berdasarkan komponen atau fungsionalitas.
6. **Optimasi Performa** dengan menghindari selektor universal dan selektor yang terlalu dalam.
7. **Kompatibilitas Browser** dengan menggunakan prefiks vendor atau Autoprefixer.
8. **Gunakan Preprocessing** seperti SCSS atau LESS untuk proyek besar.
9. **Responsif Design** dengan mobile-first approach.
10. **Validasi CSS** untuk memastikan tidak ada kesalahan sintaks.

## Contoh Proyek Praktikum

### Membuat Kartu Profile dengan Flexbox

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Card</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <div class="card">
      <div class="card-header">
        <img src="profile.jpg" alt="Profile Picture" class="avatar" />
      </div>
      <div class="card-body">
        <h2 class="name">John Doe</h2>
        <p class="title">Web Developer</p>
        <p class="description">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary">Contact</button>
        <button class="btn btn-secondary">Profile</button>
      </div>
    </div>
  </body>
</html>
```

```css
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Arial", sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f5f5f5;
}

.card {
  display: flex;
  flex-direction: column;
  width: 300px;
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-header {
  padding: 20px;
  background-color: #3498db;
  display: flex;
  justify-content: center;
}

.avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  border: 3px solid white;
  object-fit: cover;
}

.card-body {
  padding: 20px;
  flex-grow: 1;
}

.name {
  font-size: 1.5rem;
  margin-bottom: 5px;
  color: #333;
}

.title {
  color: #3498db;
  font-weight: bold;
  margin-bottom: 15px;
}

.description {
  color: #666;
  line-height: 1.5;
}

.card-footer {
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  border-top: 1px solid #eee;
}

.btn {
  padding: 8px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s;
}

.btn-primary {
  background-color: #3498db;
  color: white;
}

.btn-primary:hover {
  background-color: #2980b9;
}

.btn-secondary {
  background-color: #f2f2f2;
  color: #333;
}

.btn-secondary:hover {
  background-color: #e6e6e6;
}

/* Media Queries for Responsiveness */
@media (max-width: 350px) {
  .card {
    width: 90%;
  }

  .card-footer {
    flex-direction: column;
    gap: 10px;
  }

  .btn {
    width: 100%;
  }
}
```

## Kesimpulan

CSS adalah komponen penting dalam pengembangan web yang memungkinkan desainer dan developer untuk membuat halaman web yang menarik dan responsif. Dengan memahami konsep dasar CSS seperti selektor, box model, layout, serta teknik-teknik lanjutan seperti flexbox, grid, dan animasi, Anda dapat membuat interface yang menarik dan fungsional untuk pengguna.

Praktik terbaik adalah selalu tetap memisahkan HTML dan CSS, menggunakan naming convention yang konsisten, dan membuat design yang responsif agar dapat diakses oleh berbagai perangkat.
