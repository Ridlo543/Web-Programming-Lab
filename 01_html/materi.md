# Praktikum Pemrograman Web 1: HTML

## Table of Contents

1.  [Struktur Dasar HTML](#1-struktur-dasar-html)
2.  [Elemen HTML](#2-elemen-html)
    1. [Heading](#21-heading)
    2. [Paragraph](#22-paragraph)
    3. [Anchor atau Tautan link](#23-anchor-atau-tautan-link)
    4. [Image](#24-image)
    5. [List](#25-list)
    6. [Table](#26-table)
    7. [Form](#27-form)
3.  [Elemen Blok dan Inline](#3-elemen-blok-dan-inline)
4.  [Komentar](#4-komentar)
5.  [Elemen Semantik](#5-elemen-semantik)
    1. [`<header>`](#51-header)
    2. [`<nav>`](#52-nav)
    3. [`<main>`](#53-main)
    4. [`<section>`](#54-section)
    5. [`<article>`](#55-article)
    6. [`<aside>`](#56-aside)
    7. [`<footer>`](#57-footer)
6.  [Multimedia](#6-multimedia)
    1. [Audio](#61-audio)
    2. [Video](#62-video)
7.  [Iframe](#7-iframe)
8.  [Entitas HTML](#8-entitas-html)
9.  [Atribut Global di Elemen HTML](#9-atribut-global-di-elemen-html)
10. [Penggunaan Meta Tags](#10-penggunaan-meta-tags)
11. [Favicon](#11-favicon)

# HTML

HTML (Hyper Text Markup Language) adalah bahasa markup yang digunakan untuk membuat halaman web. HTML terdiri dari serangkaian elemen yang memberi tahu browser bagaiman menampilkan konten.

## 1. Struktur Dasar HTML

Setiap halaman web terdiri dari elemen-elemen dasar HTML. Berikut adalah struktur dasar HTML:

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Judul Halaman</title>
  </head>
  <body>
    <!-- Konten halaman web -->
  </body>
</html>
```

- `<!DOCTYPE html>`: Mendefinisikan dokumen ini adalah HTML5.
- `<html>`: Elemen root dari halaman web.
- `<head>`: Elemen yang berisi informasi meta tentang dokumen, seperti judul, meta tag, dan referensi ke file eksternal.
- `<meta charset="UTF-8">`: Mendefinisikan karakter set yang digunakan dalam dokumen.
- `<meta name="viewport" content="width=device-width, initial-scale=1.0">`: Mendefinisikan viewport agar halaman web menyesuaikan lebar perangkat atau membuat halaman web responsif.
- `<title>`: Menentukan judul halaman web yang akan ditampilkan di tab browser.
- `<body>`: Elemen yang berisi konten halaman web yang akan ditampilkan di browser.

## 2. Elemen HTML

### 2.1. Heading

Heading digunakan untuk mendefinisikan judul dan subjudul. Terdapat enam level heading, dimulai dari `<h1>` hingga `<h6>`. Semakin besar angka heading, semakin kecil ukuran fontnya.

```html
<h1>Heading 1</h1>
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Heading 6</h6>
```

**Best Practice:**

- Gunakan satu `<h1>` per halaman untuk judul utama
- Struktur heading secara hierarkis (h1 → h2 → h3)
- Jangan lewatkan level (misal dari h2 langsung ke h4)

### 2.2. Paragraph

Paragraph digunakan untuk menampilkan teks paragraf.

```html
<p>Ini adalah contoh paragraf.</p>

<p>Paragraf baru akan dimulai pada baris baru dengan jarak yang sesuai.</p>
```

### 2.3. Anchor atau Tautan link

Anchor digunakan untuk membuat tautan ke halaman web lain, bagian dalam halaman yang sama, atau untuk menjalankan fungsi tertentu.

```html
<a href="https://www.google.com">Google</a>
```

#### Atribut Anchor:

- `href`: URL tujuan tautan.
- `target`: Menentukan di mana halaman yang ditautkan akan dibuka.
  - `_blank`: Membuka di tab baru
  - `_self`: Membuka di frame yang sama (default)
  - `_parent`: Membuka di frame induk
  - `_top`: Membuka di jendela penuh
- `download`: Menentukan bahwa tautan akan mengunduh file.
- `rel`: Menentukan hubungan antara halaman saat ini dan halaman yang ditautkan.
- `title`: Memberikan informasi tambahan tentang tautan (muncul saat hover).

```html
<!-- Tautan ke halaman eksternal yang terbuka di tab baru -->
<a href="https://www.google.com" target="_blank" rel="noopener">Google</a>

<!-- Tautan untuk mengunduh file -->
<a href="dokumen.pdf" download="laporan.pdf">Download PDF</a>

<!-- Tautan ke bagian dalam halaman yang sama (anchor) -->
<a href="#section1">Pergi ke Bagian 1</a>
<div id="section1">Bagian 1</div>

<!-- Tautan email -->
<a href="mailto:email@contoh.com">Kirim Email</a>

<!-- Tautan telepon -->
<a href="tel:+621234567890">Hubungi Kami</a>
```

### 2.4. Image

Elemen <img> digunakan untuk menampilkan/menyisipkan gambar. Atribut `src` menentukan sumber gambar dan `alt` adalah teks alternatif yang akan ditampilkan jika gambar tidak dapat ditampilkan.

```html
<img src="gambar.jpg" alt="Deskripsi gambar" />
```

#### Atribut Image:

- `src`: URL atau path ke file gambar (wajib).
- `alt`: Teks alternatif yang akan ditampilkan jika gambar tidak dapat dimuat (wajib untuk aksesibilitas).
- `width`: Lebar gambar dalam piksel atau persentase.
- `height`: Tinggi gambar dalam piksel atau persentase.
- `loading`: Mengatur pemuatan gambar (lazy, eager).
- `title`: Memberikan informasi tambahan saat mouse hover.

```html
<!-- Gambar dasar -->
<img src="gambar.jpg" alt="Deskripsi gambar" />

<!-- Gambar dengan ukuran tertentu -->
<img src="gambar.jpg" alt="Deskripsi gambar" width="300" height="200" />

<!-- Gambar dengan lazy loading -->
<img src="gambar.jpg" alt="Deskripsi gambar" loading="lazy" />

<!-- Gambar responsif -->
<img
  src="gambar.jpg"
  alt="Deskripsi gambar"
  style="max-width:100%; height:auto;"
/>
```

### 2.5. List

List digunakan untuk menampilkan daftar. Terdapat beberapa jenis list, yaitu ordered list (ol), unordered list (ul), dan description list (dl).

#### a. Ordered List (Daftar Berurutan)

```html
<ol>
  <li>Item pertama</li>
  <li>Item kedua</li>
  <li>Item ketiga</li>
</ol>
```

#### Atribut Ordered List:

- `type`: Menentukan jenis penomoran (1, A, a, I, i).
- `start`: Menentukan nilai awal penomoran.
- `reversed`: Membalikkan urutan penomoran.

```html
<!-- Daftar dengan angka romawi -->
<ol type="I">
  <li>Item pertama</li>
  <li>Item kedua</li>
  <li>Item ketiga</li>
</ol>

<!-- Daftar dengan awal nomor 5 -->
<ol start="5">
  <li>Item kelima</li>
  <li>Item keenam</li>
  <li>Item ketujuh</li>
</ol>
```

#### b. Unordered List (Daftar Tidak Berurutan)

```html
<ul>
  <li>Item satu</li>
  <li>Item dua</li>
  <li>Item tiga</li>
</ul>
```

#### Atribut Unordered List:

- `type`: Menentukan jenis bullet (disc, circle, square).

```html
<!-- Daftar dengan bullet kotak -->
<ul style="list-style-type: square;">
  <li>Item satu</li>
  <li>Item dua</li>
  <li>Item tiga</li>
</ul>
```

#### c. Description List (Daftar Deskripsi)

```html
<dl>
  <dt>HTML</dt>
  <dd>Hyper Text Markup Language</dd>

  <dt>CSS</dt>
  <dd>Cascading Style Sheets</dd>

  <dt>JS</dt>
  <dd>JavaScript</dd>
</dl>
```

#### d. List Bersarang (Nested List)

```html
<ul>
  <li>
    Buah-buahan
    <ul>
      <li>Apel</li>
      <li>Jeruk</li>
      <li>Pisang</li>
    </ul>
  </li>
  <li>
    Sayuran
    <ul>
      <li>Wortel</li>
      <li>Bayam</li>
      <li>Tomat</li>
    </ul>
  </li>
</ul>
```

### 2.6. Table

Table digunakan untuk menampilkan data dalam bentuk tabel. Table dibuat dengan elemen <table>, yang berisi baris (row) dengan elemen <tr>, dan kolom (cell) dengan elemen <td> atau <th> sebagai header.

```html
<table>
  <thead>
    <tr>
      <th>Nama</th>
      <th>Umur</th>
      <th>Kota</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Andi</td>
      <td>20</td>
      <td>Jakarta</td>
    </tr>
    <tr>
      <td>Budi</td>
      <td>25</td>
      <td>Bandung</td>
    </tr>
    <tr>
      <td>Citra</td>
      <td>22</td>
      <td>Surabaya</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3">Total: 3 orang</td>
    </tr>
  </tfoot>
</table>
```

#### Elemen-elemen Tabel:

- `<table>`: Mendefinisikan tabel.
- `<thead>`: Mengelompokkan konten header tabel.
- `<tbody>`: Mengelompokkan konten utama tabel.
- `<tfoot>`: Mengelompokkan konten footer tabel.
- `<tr>`: Mendefinisikan baris tabel.
- `<th>`: Mendefinisikan sel header tabel.
- `<td>`: Mendefinisikan sel data tabel.
- `<caption>`: Memberikan judul tabel.

#### Atribut Tabel:

- `colspan`: Menggabungkan beberapa kolom.
- `rowspan`: Menggabungkan beberapa baris.
- `border`: Menentukan tebal border tabel (disarankan menggunakan CSS).
- `width`, `height`: Menentukan lebar dan tinggi tabel (disarankan menggunakan CSS).

```html
<!-- Tabel dengan caption dan sel yang digabung -->
<table border="1">
  <caption>
    Data Karyawan
  </caption>
  <thead>
    <tr>
      <th>Nama</th>
      <th>Departemen</th>
      <th colspan="2">Kontak</th>
    </tr>
    <tr>
      <th></th>
      <th></th>
      <th>Email</th>
      <th>Telepon</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td rowspan="2">Andi</td>
      <td>IT</td>
      <td>andi@example.com</td>
      <td>081234567890</td>
    </tr>
    <tr>
      <td>Support</td>
      <td>support@example.com</td>
      <td>089876543210</td>
    </tr>
  </tbody>
</table>
```

### 2.7. Form

Form digunakan untuk mengumpulkan input dari pengguna. Form dibuat dengan elemen `form`, yang berisi elemen-elemen input seperti `input`, `textarea`, `select`, dan `button`.

```html
<form action="/proses.php" method="post">
  <div>
    <label for="nama">Nama:</label>
    <input
      type="text"
      id="nama"
      name="nama"
      placeholder="Masukkan nama"
      required
    />
  </div>

  <div>
    <label for="email">Email:</label>
    <input
      type="email"
      id="email"
      name="email"
      placeholder="Masukkan email"
      required
    />
  </div>

  <div>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required />
  </div>

  <div>
    <label for="jenis_kelamin">Jenis Kelamin:</label>
    <select id="jenis_kelamin" name="jenis_kelamin">
      <option value="">Pilih Jenis Kelamin</option>
      <option value="L">Laki-laki</option>
      <option value="P">Perempuan</option>
    </select>
  </div>

  <div>
    <p>Hobi:</p>
    <input type="checkbox" id="membaca" name="hobi[]" value="membaca" />
    <label for="membaca">Membaca</label>

    <input type="checkbox" id="menulis" name="hobi[]" value="menulis" />
    <label for="menulis">Menulis</label>

    <input type="checkbox" id="coding" name="hobi[]" value="coding" />
    <label for="coding">Coding</label>
  </div>

  <div>
    <p>Status:</p>
    <input type="radio" id="single" name="status" value="single" />
    <label for="single">Single</label>

    <input type="radio" id="menikah" name="status" value="menikah" />
    <label for="menikah">Menikah</label>
  </div>

  <div>
    <label for="pesan">Pesan:</label>
    <textarea
      id="pesan"
      name="pesan"
      rows="4"
      cols="50"
      placeholder="Tulis pesan Anda di sini"
    ></textarea>
  </div>

  <div>
    <button type="submit">Kirim</button>
    <button type="reset">Reset</button>
  </div>
</form>
```

#### Elemen-elemen Form:

- `<form>`: Mendefinisikan formulir.
- `<input>`: Mendefinisikan kontrol input.
- `<label>`: Mendefinisikan label untuk kontrol input.
- `<select>`: Mendefinisikan daftar dropdown.
- `<option>`: Mendefinisikan opsi dalam daftar dropdown.
- `<textarea>`: Mendefinisikan area input teks multi-baris.
- `<button>`: Mendefinisikan tombol.
- `<fieldset>`: Mengelompokkan elemen-elemen form.
- `<legend>`: Mendefinisikan caption untuk fieldset.

#### Atribut Form:

- `action`: URL tempat data form akan dikirim.
- `method`: Metode HTTP yang digunakan untuk mengirim data (GET, POST).
- `enctype`: Menentukan encoding data form (multipart/form-data untuk upload file).
- `autocomplete`: Mengaktifkan/menonaktifkan autocompletion.
- `novalidate`: Menonaktifkan validasi default browser.

#### Tipe Input:

```html
<!-- Text -->
<input type="text" name="nama" />

<!-- Password -->
<input type="password" name="password" />

<!-- Email -->
<input type="email" name="email" />

<!-- Number -->
<input type="number" name="umur" min="0" max="120" />

<!-- Checkbox -->
<input type="checkbox" name="setuju" />

<!-- Radio -->
<input type="radio" name="gender" value="L" />

<!-- Date -->
<input type="date" name="tanggal_lahir" />

<!-- Time -->
<input type="time" name="waktu" />

<!-- File -->
<input type="file" name="foto" accept="image/*" />

<!-- Color -->
<input type="color" name="warna" />

<!-- Range -->
<input type="range" name="volume" min="0" max="100" />

<!-- Hidden -->
<input type="hidden" name="user_id" value="123" />

<!-- Submit -->
<input type="submit" value="Kirim" />

<!-- Reset -->
<input type="reset" value="Reset" />
```

#### Atribut Input:

- `type`: Menentukan tipe input.
- `name`: Menentukan nama input (digunakan saat mengirim data).
- `value`: Menentukan nilai awal input.
- `placeholder`: Menampilkan teks petunjuk.
- `required`: Membuat input wajib diisi.
- `disabled`: Menonaktifkan input.
- `readonly`: Membuat input hanya bisa dibaca, tidak bisa diubah.
- `min`, `max`: Menentukan nilai minimum dan maksimum (untuk input numerik).
- `pattern`: Menentukan pola regex untuk validasi.
- `autocomplete`: Mengaktifkan/menonaktifkan autocompletion pada input.

## 3. Elemen Blok dan Inline

HTML membagi elemen menjadi dua kategori utama: blok dan inline.

### 3.1. Elemen Blok (Block Elements)

Elemen blok selalu dimulai pada baris baru dan mengambil lebar penuh yang tersedia.

**Contoh elemen blok:**

- `<div>`: Kontainer generik blok
- `<h1>` hingga `<h6>`: Heading
- `<p>`: Paragraf
- `<ul>`, `<ol>`, `<li>`: List
- `<table>`: Tabel
- `<form>`: Formulir
- `<header>`, `<footer>`, `<section>`, `<article>`, `<nav>`, `<aside>`: Elemen semantik

```html
<div>Ini adalah elemen blok</div>
<p>Ini juga elemen blok</p>

<div style="border: 1px solid blue; padding: 10px;">
  <p>Elemen blok bisa berisi elemen blok lain</p>
  <div style="border: 1px solid red; padding: 5px;">
    Ini adalah div dalam div
  </div>
</div>
```

### 3.2. Elemen Inline (Inline Elements)

Elemen inline tidak memulai pada baris baru dan hanya mengambil lebar sesuai dengan kontennya.

**Contoh elemen inline:**

- `<span>`: Kontainer generik inline
- `<a>`: Anchor/Link
- `<img>`: Gambar
- `<strong>`, `<em>`: Teks terformat
- `<button>`: Tombol
- `<input>`, `<label>`: Elemen form

```html
<p>
  Ini adalah paragraf dengan
  <span style="color: red;">teks berwarna merah</span> dan
  <a href="#">link</a> di dalamnya serta <strong>teks tebal</strong>.
</p>

<div>
  Elemen blok bisa berisi elemen inline:
  <span style="background-color: yellow;">Ini adalah elemen inline</span>
  dan <span style="font-style: italic;">ini juga elemen inline</span>.
</div>
```

### 3.3. Perbedaan Utama

| Elemen Blok                         | Elemen Inline                                    |
| ----------------------------------- | ------------------------------------------------ |
| Dimulai pada baris baru             | Tidak dimulai pada baris baru                    |
| Mengambil lebar penuh               | Hanya mengambil lebar sesuai konten              |
| Dapat berisi elemen blok dan inline | Umumnya hanya berisi data dan elemen inline lain |
| Bisa diatur lebar dan tingginya     | Pengaturan lebar dan tinggi terbatas             |

## 4. Komentar

Komentar digunakan untuk memberikan keterangan pada kode HTML. Komentar tidak akan ditampilkan di browser.

```html
<!-- Ini adalah komentar -->
```

## 5. Elemen Semantik HTML5

Elemen semantik adalah elemen HTML yang memberikan makna pada konten, bukan hanya untuk presentasi. Penggunaan elemen semantik mempermudah mesin pencari, screen reader, dan pengembang untuk memahami struktur halaman.

### 5.1. `<header>`

Mendefinisikan bagian header dari dokumen atau bagian. Biasanya berisi logo, judul, dan navigasi utama.

```html
<header>
  <img src="logo.png" alt="Logo Website" />
  <h1>Judul Website</h1>
  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>
</header>
```

### 5.2. `<nav>`

Mendefinisikan bagian navigasi dari dokumen. Berisi link-link navigasi utama.

```html
<nav>
  <ul>
    <li><a href="index.html">Home</a></li>
    <li><a href="about.html">About</a></li>
    <li><a href="services.html">Services</a></li>
    <li><a href="contact.html">Contact</a></li>
  </ul>
</nav>
```

### 5.3. `<main>`

Mendefinisikan konten utama dari dokumen. Setiap halaman hanya boleh memiliki satu elemen `<main>`.

```html
<main>
  <h1>Judul Halaman</h1>
  <p>
    Ini adalah konten utama halaman. Main hanya boleh ada satu dalam sebuah
    halaman.
  </p>

  <section>
    <h2>Bagian 1</h2>
    <p>Konten bagian 1...</p>
  </section>

  <section>
    <h2>Bagian 2</h2>
    <p>Konten bagian 2...</p>
  </section>
</main>
```

### 5.4. `<section>`

Mendefinisikan bagian dalam dokumen. Biasanya berisi konten yang tematik terkait.

```html
<section>
  <h2>Produk Terbaru</h2>
  <p>Lihat koleksi produk terbaru kami.</p>

  <article>
    <h3>Produk A</h3>
    <p>Deskripsi produk A...</p>
  </article>

  <article>
    <h3>Produk B</h3>
    <p>Deskripsi produk B...</p>
  </article>
</section>
```

### 5.5. `<article>`

Mendefinisikan konten independen yang dapat berdiri sendiri. Cocok untuk posting blog, berita, atau konten serupa.

```html
<article>
  <header>
    <h2>Judul Artikel</h2>
    <p>
      Ditulis oleh <a href="#">Nama Penulis</a> pada
      <time datetime="2023-03-15">15 Maret 2023</time>
    </p>
  </header>

  <p>Paragraf pertama artikel...</p>
  <p>Paragraf kedua artikel...</p>

  <footer>
    <p>
      Tags: <a href="#">web</a>, <a href="#">html</a>, <a href="#">tutorial</a>
    </p>
  </footer>
</article>
```

### 5.6. `<aside>`

Mendefinisikan konten yang berhubungan secara tidak langsung dengan konten utama. Biasanya digunakan untuk sidebar.

```html
<aside>
  <h3>Kategori</h3>
  <ul>
    <li><a href="#">HTML</a></li>
    <li><a href="#">CSS</a></li>
    <li><a href="#">JavaScript</a></li>
  </ul>

  <h3>Artikel Terkait</h3>
  <ul>
    <li><a href="#">Belajar HTML Dasar</a></li>
    <li><a href="#">Tips HTML untuk Pemula</a></li>
  </ul>
</aside>
```

### 5.7. `<footer>`

Mendefinisikan bagian footer dari dokumen atau bagian. Biasanya berisi informasi kontak, hak cipta, dan link-link terkait.

```html
<footer>
  <p>&copy; 2023 Nama Website. All rights reserved.</p>
  <address>
    Email: <a href="mailto:info@example.com">info@example.com</a><br />
    Telepon: <a href="tel:+621234567890">+62 123 4567 890</a>
  </address>
  <div class="social-media">
    <a href="#">Facebook</a>
    <a href="#">Twitter</a>
    <a href="#">Instagram</a>
  </div>
</footer>
```

## 6. Multimedia

HTML5 memiliki dukungan bawaan untuk elemen multimedia seperti audio dan video.

### 6.1. Audio

Elemen `<audio>` digunakan untuk menambahkan audio ke halaman web.

```html
<audio src="musik.mp3" controls></audio>
```

#### Atribut Audio:

- `controls`: Menampilkan kontrol pemutaran (play, pause, volume, dll).
- `autoplay`: Memulai pemutaran secara otomatis ketika halaman dimuat.
- `loop`: Mengulang audio setelah selesai diputar.
- `muted`: Mematikan suara audio.
- `preload`: Menentukan bagaimana browser harus memuat audio (auto, metadata, none).

```html
<!-- Audio dasar dengan kontrol -->
<audio src="musik.mp3" controls></audio>

<!-- Audio dengan berbagai atribut -->
<audio controls autoplay loop muted preload="auto">
  <source src="musik.mp3" type="audio/mpeg" />
  <source src="musik.ogg" type="audio/ogg" />
  Browser Anda tidak mendukung elemen audio.
</audio>
```

### 6.2. Video

Elemen `<video>` digunakan untuk menambahkan video ke halaman web.

```html
<video src="video.mp4" controls></video>
```

#### Atribut Video:

- `controls`: Menampilkan kontrol pemutaran.
- `autoplay`: Memulai pemutaran secara otomatis.
- `loop`: Mengulang video setelah selesai diputar.
- `muted`: Mematikan suara video.
- `poster`: Gambar yang ditampilkan sebelum video dimainkan.
- `width`, `height`: Menentukan ukuran video.
- `preload`: Menentukan bagaimana browser harus memuat video.

```html
<!-- Video dasar dengan kontrol -->
<video src="video.mp4" controls></video>

<!-- Video dengan berbagai atribut -->
<video
  controls
  autoplay
  loop
  muted
  poster="thumbnail.jpg"
  width="640"
  height="360"
>
  <source src="video.mp4" type="video/mp4" />
  <source src="video.webm" type="video/webm" />
  <track src="subtitles.vtt" kind="subtitles" srclang="id" label="Indonesia" />
  Browser Anda tidak mendukung elemen video.
</video>
```

## 7. Iframe

Elemen `<iframe>` digunakan untuk menampilkan halaman web lain di dalam halaman web saat ini.

```html
<iframe src="https://www.google.com"></iframe>
```

#### Atribut Iframe:

- `src`: URL halaman web yang akan ditampilkan.
- `width`, `height`: Menentukan ukuran iframe.
- `title`: Judul iframe (penting untuk aksesibilitas).
- `frameborder`: Menentukan apakah akan menampilkan border (1 atau 0).
- `allow`: Menentukan fitur yang diperbolehkan dalam iframe.
- `sandbox`: Membatasi fitur yang diperbolehkan dalam iframe.

```html
<!-- Iframe dasar -->
<iframe src="https://www.google.com"></iframe>

<!-- Iframe dengan ukuran dan judul -->
<iframe
  src="https://www.youtube.com/embed/dQw4w9WgXcQ"
  width="560"
  height="315"
  title="YouTube video"
  frameborder="0"
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
  allowfullscreen
></iframe>
```

## 8. Entitas HTML

Entitas HTML digunakan untuk menampilkan karakter khusus dalam dokumen HTML yang biasanya tidak bisa langsung digunakan karena memiliki makna khusus dalam sintaks HTML.

| Karakter | Entitas    | Deskripsi             |
| -------- | ---------- | --------------------- |
| <        | `&lt;`     | Less than             |
| >        | `&gt;`     | Greater than          |
| &        | `&amp;`    | Ampersand             |
| "        | `&quot;`   | Double quotation mark |
| '        | `&apos;`   | Single quotation mark |
| ©        | `&copy;`   | Copyright             |
| ®        | `&reg;`    | Registered trademark  |
| ™        | `&trade;`  | Trademark             |
| €        | `&euro;`   | Euro                  |
| £        | `&pound;`  | Pound                 |
| ¥        | `&yen;`    | Yen                   |
| ½        | `&frac12;` | Fraction 1/2          |
| ¼        | `&frac14;` | Fraction 1/4          |
| ×        | `&times;`  | Multiplication sign   |
| ÷        | `&divide;` | Division sign         |
| ±        | `&plusmn;` | Plus-minus sign       |
| °        | `&deg;`    | Degree sign           |
| µ        | `&micro;`  | Micro sign            |
| •        | `&bull;`   | Bullet                |
| —        | `&mdash;`  | Em dash               |
| –        | `&ndash;`  | En dash               |
| "        | `&ldquo;`  | Left double quote     |
| "        | `&rdquo;`  | Right double quote    |
| '        | `&lsquo;`  | Left single quote     |
| '        | `&rsquo;`  | Right single quote    |
| «        | `&laquo;`  | Left angle quote      |
| »        | `&raquo;`  | Right angle quote     |
| →        | `&rarr;`   | Right arrow           |
| ←        | `&larr;`   | Left arrow            |
| ↑        | `&uarr;`   | Up arrow              |
| ↓        | `&darr;`   | Down arrow            |
| ♠        | `&spades;` | Spade                 |
| ♥        | `&hearts;` | Heart                 |
| ♦        | `&diams;`  | Diamond               |
| ♣        | `&clubs;`  | Club                  |

Tujuan dari penggunaan entitas HTML adalah untuk menghindari konflik dengan karakter khusus dalam kode HTML. Contohnya jika kita ingin menampilkan karakter <, >, atau & dalam dokumen HTML, maka kita harus menggunakan entitas HTML, karena karakter tersebut baisanya digunakan dalam sintaks HTML.

```html
<p>&lt; adalah entitas HTML untuk karakter kurang dari (<)</p>
<p>&gt; adalah entitas HTML untuk karakter lebih dari (>)</p>
<p>&amp; adalah entitas HTML untuk karakter dan (&)</p>
```

## 9. Atribut Global di Elemen HTML

- `id`: Menentukan ID unik untuk elemen.
- `class`: Menentukan satu atau lebih kelas untuk elemen.
- `style`: Menentukan inline CSS untuk elemen.
- `title`: Menentukan informasi tambahan tentang elemen (tooltip).
- `lang`: Menentukan bahasa konten elemen.
- `data-*`: Menyimpan data kustom yang dapat digunakan oleh JavaScript.
- `hidden`: Menyembunyikan elemen.
- `spellcheck`: Menentukan apakah elemen akan diperiksa ejaan dan tata bahasanya.
- `tabindex`: Menentukan urutan tabbing elemen.
- `contenteditable`: Menentukan apakah konten elemen dapat diedit oleh pengguna.
- `draggable`: Menentukan apakah elemen dapat di-drag.
- `dir`: Menentukan arah teks (ltr, rtl).

```html
<!-- Contoh penggunaan atribut global -->
<div
  id="container"
  class="section main-content"
  style="background-color: #f5f5f5; padding: 20px;"
  title="Ini adalah container utama"
  lang="id"
  data-value="123"
  tabindex="1"
  contenteditable="true"
  draggable="true"
  dir="ltr"
>
  <p>Ini adalah contoh penggunaan atribut global pada elemen div.</p>
</div>

<!-- Elemen dengan atribut hidden -->
<p hidden>Teks ini tidak akan ditampilkan di browser.</p>

<!-- Elemen dengan atribut spellcheck -->
<textarea spellcheck="true">Teks ini akan diperiksa ejaan.</textarea>
```

### 10. Penggunaan Meta Tags

Meta tags bertujujuan penting untuk SEO (Search Engine Optimization) dan aksesibilitas responsif. Berikut adalah beberapa meta tags yang umum digunakan:

```html
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Deskripsi halaman untuk SEO" />
<meta name="keywords" content="kata kunci, seo, html" />
<meta name="author" content="Nama Penulis" />
```

### 11. Favicon

Favicon adalah ikon kecil yang ditampilkan di tab browser. Favicon biasanya berupa file `.ico` atau gambar `.png`.

```html
<link rel="icon" href="favicon.ico" type="image/x-icon" />
```
