# Praktikum Pemrograman Web 2: CSS

## Table of Contents

- [Pengertian CSS](#pengertian-css)
- [Cara Menerapkan CSS](#cara-menerapkan-css)
  - [1. Inline CSS](#1-inline-css)
  - [2. Internal CSS](#2-internal-css)
  - [3. External CSS](#3-external-css)
- [Selektor CSS](#selektor-css)
  - [Selektor](#selektor)
  - [Selektor Atribut](#selektor-atribut)
  - [Pseudo-class dan Pseudo-element](#pseudo-class-dan-pseudo-element)
- [Properti CSS Penting](#properti-css-penting)
  - [Warna dan Latar Belakang](#warna-dan-latar-belakang)
  - [Font dan Teks](#font-dan-teks)
  - [Box Model](#box-model)
- [Display dan Position](#display-dan-position)
  - [Display](#display)
  - [Position](#position)
- [Flexbox](#flexbox)
- [Grid](#grid)
- [Responsif Design](#responsif-design)
  - [Media Queries](#media-queries)
  - [Ukuran Responsif](#ukuran-responsif)
- [CSS Variables (Custom Properties)](#css-variables-custom-properties)
- [Best Practice CSS atau Tips](#best-practice-css-atau-tips)
- [Contoh Proyek Praktikum](#contoh-proyek-praktikum)
  - [Membuat ...](#membuat-)

## Pengertian CSS

CSS (_Cascading Style Sheets_) adalah bahasa yang digunakan untuk mengatur tampilan dan format elemen HTML pada halaman web. CSS memungkinkan pemisahan antara konten (HTML) dan presentasi (gaya tampilan), sehingga kita dapat mengatur warna, font, layout, dan aspek visual lainnya dengan lebih terstruktur.

## Cara Menerapkan CSS

Ada tiga metode utama

### 1. Inline CSS

**Kelebihan**:
**Kekurangan**:

### 2. Internal CSS

**Kelebihan**:

### 3. External CSS

## Selektor CSS

Selektor CSS digunakan untuk memilih elemen HTML yang akan diberi gaya.

### Selektor

### Selektor Atribut

### Pseudo-class dan Pseudo-element

## Properti CSS Penting

### Warna dan Latar Belakang

### Font dan Teks

### Box Model

![Box Model Diagram](./implementation/assets/CSS-box-model.webp)
[Sumber gambar](https://www.reddit.com/media?url=https%3A%2F%2Fi.redd.it%2Frofzm44oka091.png&rdt=39915)

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

### Contoh Implementasi

<details>
  <summary>Klik untuk contoh</summary>
  
  ```html
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display & Position Example</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .box {
            width: 100px;
            height: 100px;
            background-color: #3498db;
            color: white;
            text-align: center;
            line-height: 100px;
            margin: 10px;
        }

        .block-box {
            display: block;
            background-color: #e74c3c;
        }

        .inline-box {
            display: inline;
            background-color: #2ecc71;
        }

        .inline-block-box {
            display: inline-block;
            background-color: #f1c40f;
        }

        .relative-box {
            position: relative;
            top: 20px;
            left: 20px;
            <!-- background-color: #9b59b6;  -->
            background-color: ;
        }

        .absolute-container {
            position: relative;
            width: 300px;
            height: 200px;
            background-color: #ecf0f1;
            margin: 20px;
        }

        .absolute-box {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #e67e22;
        }

        .fixed-box {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #34495e;
        }
    </style>

</head>
<body>
    <h1>Display & Position Example</h1>
    <div class="box block-box">Block</div>
    <span class="box inline-box">Inline</span>
    <span class="box inline-block-box">Inline-Block</span>
    <div class="box relative-box">Relative</div>
    <div class="absolute-container">
        <div class="box absolute-box">Absolute</div>
    </div>
    <div class="box fixed-box">Fixed</div>
</body>
</html>
  ```
</details>

## Flexbox

Flexbox adalah model layout satu dimensi untuk mengatur elemen dalam container.

![Flexbox Diagram](./implementation/assets/flexbox.png)
[Sumber gambar](https://www.reddit.com/media?url=https%3A%2F%2Fi.redd.it%2Frofzm44oka091.png&rdt=39915)

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

### Contoh Implementasi

<details>
  <summary>Klik untuk contoh flex</summary>

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Flexbox Example</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      .flex-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        background-color: #ecf0f1;
        padding: 20px;
        margin: 20px;
        min-height: 200px;
      }

      .box {
        width: 100px;
        height: 100px;
        background-color: #3498db;
        color: white;
        text-align: center;
        line-height: 100px;
        margin: 10px;
      }

      .box:nth-child(2) {
        background-color: #e74c3c;
        flex-grow: 1;
      }

      .box:nth-child(3) {
        background-color: #2ecc71;
        align-self: flex-end;
      }
    </style>
  </head>
  <body>
    <h1>Flexbox Example</h1>
    <div class="flex-container">
      <div class="box">Box 1</div>
      <div class="box">Box 2</div>
      <div class="box">Box 3</div>
      <div class="box">Box 4</div>
    </div>
  </body>
</html>
```

</details>

## Grid

CSS Grid adalah model layout dua dimensi untuk mengatur elemen dalam baris dan kolom.

![Grid Diagram](./implementation/assets/css-grid.jpg)
[Sumber gambar](https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.simplilearn.com%2Ftutorials%2Fcss-tutorial%2Fcss-box-model&psig=AOvVaw0_XTzLgKpR6pBIGdvimE7h&ust=1742356482560000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCLD07-vdkowDFQAAAAAdAAAAABAE)

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

### Contoh Implementasi

<details>
  <summary>Klik untuk contoh grid</summary>

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Grid Example</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: 100px 100px;
        gap: 10px;
        background-color: #ecf0f1;
        padding: 20px;
        margin: 20px;
      }

      .box {
        background-color: #3498db;
        color: white;
        text-align: center;
        line-height: 100px;
      }

      .box:nth-child(1) {
        background-color: #e74c3c;
        grid-column: 1 / 3; /* Membentang 2 kolom */
      }

      .box:nth-child(2) {
        background-color: #2ecc71;
      }

      .box:nth-child(3) {
        background-color: #f1c40f;
        grid-row: 1 / 3; /* Membentang 2 baris */
      }

      .box:nth-child(4) {
        background-color: #9b59b6;
        grid-column: span 2; /* Membentang 2 kolom */
      }
    </style>
  </head>
  <body>
    <h1>Grid Example</h1>
    <div class="grid-container">
      <div class="box">Box 1</div>
      <div class="box">Box 2</div>
      <div class="box">Box 3</div>
      <div class="box">Box 4</div>
    </div>
  </body>
</html>
```

</details>

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

## Tips atau Best Practice CSS

1. **Gunakan External CSS** untuk memisahkan struktur (HTML) dan presentasi (CSS).
2. **Gunakan Class** untuk styling daripada ID (kecuali untuk JavaScript).
3. **Minimize Specificity** untuk menghindari kaskade yang rumit.
4. **Gunakan Naming Convention** seperti BEM (Block, Element, Modifier).
5. **Organisasikan CSS** dengan baik, kelompokkan berdasarkan komponen atau fungsionalitas.
6. **Optimasi Performa** dengan menghindari selektor universal dan selektor yang terlalu dalam.
7. **Responsif Design** dengan mobile-first approach.
8. **Gunakan CSS Variables** untuk mengatur warna, ukuran, dan properti lain yang sering digunakan.
9. **Gunakan Library CSS** seperti Bootstrap, Tailwind CSS, atau Materialize CSS untuk mempercepat pengembangan.

## Contoh Proyek Praktikum

[implementation](./implementation/)
