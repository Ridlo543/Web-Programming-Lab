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
- `<head>`: Elemen yang berisi informasi tentang dokumen, seperti judul, meta tag, dan lain-lain.
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

### 2.2. Paragraph

Paragraph digunakan untuk menampilkan teks paragraf.

```html
<p>Ini adalah contoh paragraf.</p>
```

### 2.3. Anchor atau Tautan link

Anchor digunakan untuk membuat tautan ke halaman web lain.

```html
<a href="https://www.google.com">Google</a>
```

Anchor memiliki beberapa atribut, di antaranya:

- `href`: URL tujuan tautan.
- `target`: Menentukan di mana halaman yang ditautkan akan dibuka. Nilai yang umum digunakan adalah `_blank` untuk membuka halaman di tab baru
- `download`: Menentukan apakah tautan akan diunduh sebagai file. Nilai yang digunakan adalah nama file yang diunduh.

```html
<a href="https://www.google.com" target="_blank">Google</a>
<a href="file.pdf" download>Download PDF</a>
```

### 2.4. Image

Elemen <img> digunakan untuk menampilkan/menyisipkan gambar. Atribut `src` menentukan sumber gambar dan `alt` adalah teks alternatif yang akan ditampilkan jika gambar tidak dapat ditampilkan.

```html
<img src="gambar.jpg" alt="Deskripsi gambar" />
```

Image memiliki beberapa atribut, di antaranya:

- `src`: URL gambar.
- `alt`: Deskripsi gambar.
- `width`: Lebar gambar.
- `height`: Tinggi gambar.

```html
<img src="gambar.jpg" alt="Deskripsi gambar" width="200" height="200" />
```

### 2.5. List

List digunakan untuk menampilkan daftar. Terdapat beberapa jenis list, yaitu ordered list (ol), unordered list (ul), dan description list (dl).

```html
<!-- Ordered List -->
<ol>
  <li>Item 1</li>
  <li>Item 2</li>
  <li>Item 3</li>
</ol>

<!-- Unordered List -->
<ul>
  <li>Item 1</li>
  <li>Item 2</li>
  <li>Item 3</li>
</ul>

<!-- Description List -->
<dl>
  <dt>Item 1</dt>
  <dd>Deskripsi item 1</dd>
  <dt>Item 2</dt>
  <dd>Deskripsi item 2</dd>
</dl>
```

### 2.6. Table

Table digunakan untuk menampilkan data dalam bentuk tabel. Table dibuat dengan elemen <table>, yang berisi baris (row) dengan elemen <tr>, dan kolom (cell) dengan elemen <td> atau <th> sebagai header.

```html
<table>
  <tr>
    <th>Nama</th>
    <th>Umur</th>
  </tr>
  <tr>
    <td>Andi</td>
    <td>20</td>
  </tr>
  <tr>
    <td>Budi</td>
    <td>25</td>
  </tr>
</table>
```

### 2.7. Form

Form digunakan untuk mengumpulkan input dari pengguna. Form dibuat dengan elemen `form`, yang berisi elemen-elemen input seperti `input`, `textarea`, `select`, dan `button`.

```html
<form>
  <label for="nama">Nama:</label>
  <input type="text" id="nama" name="nama" />

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" />

  <label for="pesan">Pesan:</label>
  <textarea id="pesan" name="pesan"></textarea>

  <button type="submit">Kirim</button>
</form>
```

<br>

## 3. Elemen Blok dan Inline

- Elemen Blok: Memulai pada baris baru dan mengambil lebar penuh yang tersedia. Contoh `div`, `h1`, `p`, `ul`, `table`.
- Elemen Inline: Tidak memulai pada baris baru dan hanya mengambil lebar yang diperlukan. Contoh `span`, `a`, `img`, `input`.

Contoh:

```html
<div>Ini adalah elemen blok</div>
<div>
  Ini juga adalah elemen blok
  <span>ini adalah elemen inline di dalam elemen blok</span>
</div>
```

## 4. Komentar

Komentar digunakan untuk memberikan keterangan pada kode HTML. Komentar tidak akan ditampilkan di browser.

```html
<!-- Ini adalah komentar -->
```

## 5. Elemen Semantik

Elemen semantik adalah elemen HTML yang memberikan makna pada konten. Beberapa elemen semantik yang sering digunakan:

### 5.1. `<header>`

Elemen `<header>` digunakan untuk menentukan header dari sebuah dokumen atau bagian. Perbedaan dengan elemen `<h1>` adalah elemen `<header>` digunakan untuk menentukan header dari sebuah dokumen atau bagian, sedangkan elemen `<h1>` digunakan untuk menentukan judul. Biasanya digunakan untuk menampilkan logo, judul, dan navigasi.

```html
<header>
  <h1>Judul Header</h1>
  <p>Deskripsi header</p>
</header>
```

### 5.2. `<nav>`

Elemen `<nav>` digunakan untuk menentukan bagian navigasi. Biasanya digunakan untuk menampilkan menu navigasi.

```html
<nav>
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Contact</a></li>
  </ul>
</nav>
```

### 5.3. `<main>`

Elemen `<main>` digunakan untuk menentukan konten utama dari sebuah dokumen. Biasanya digunakan untuk menampilkan konten utama dari sebuah halaman web.

```
<main>
  <h1>Judul Konten Utama</h1>
  <p>Deskripsi konten utama</p>
</main>
```

### 5.4. `<section>`

Elemen `<section>` digunakan untuk menentukan bagian dalam sebuah dokumen. Biasanya digunakan untuk mengelompokkan konten yang berbeda.

```html
<section>
  <h2>Sub Judul</h2>
  <p>Deskripsi sub judul</p>
</section>
```

### 5.5. `<article>`

Elemen `<article>` digunakan untuk menentukan konten independen, seperti postingan blog atau artikel berita.

```html
<article>
  <h2>Judul Artikel</h2>
  <p>Deskripsi artikel</p>
</article>
```

### 5.6. `<aside>`

Elemen `<aside>` digunakan untuk menentukan konten yang berhubungan dengan konten di sekitarnya, seperti sidebar.

```html
<aside>
  <h3>Widget</h3>
  <p>Deskripsi widget</p>
</aside>
```

### 5.7. `<footer>`

Elemen `<footer>` digunakan untuk menentukan footer dari sebuah dokumen atau bagian. Biasanya digunakan untuk menampilkan informasi kontak, hak cipta, dan lain-lain.

```html
<footer>
  <p>&copy; 2021 Nama Perusahaan</p>
</footer>
```

## 6. Multimedia

Selain gambar, HTML juga mendukung multimedia seperti audio dan video.

### 6.1. Audio

Elemen `<audio>` digunakan untuk menambahkan audio ke halaman web. Atribut `src` menentukan sumber audio dan `controls` menampilkan kontrol audio.

```html
<audio src="audio.mp3" controls></audio>
```

Atribut lain yang sering digunakan:

- `autoplay`: Memulai audio secara otomatis.
- `loop`: Mengulang audio setelah selesai.
- `muted`: Mematikan suara audio.
- `preload`: Menentukan apakah audio akan dimuat saat halaman dimuat.

```html
<audio src="audio.mp3" controls autoplay loop muted preload="auto"></audio>
```

### 6.2. Video

Elemen `<video>` digunakan untuk menambahkan video ke halaman web. Atribut `src` menentukan sumber video dan `controls` menampilkan kontrol video.

```html
<video src="video.mp4" controls></video>
```

Atribut controls digunakan untuk menampilkan kontrol video seperti play, pause, dan volume. Atribut lain yang sering digunakan:

- `autoplay`: Memulai video secara otomatis.
- `loop`: Mengulang video setelah selesai.
- `muted`: Mematikan suara video.
- `poster`: Gambar yang ditampilkan sebelum video dimainkan.

```html
<video src="video.mp4" controls autoplay loop muted poster="poster.jpg"></video>
```

## 7. Iframe

Elemen `<iframe>` digunakan untuk menampilkan halaman web lain di dalam halaman web saat ini.

```html
<iframe src="https://www.google.com"></iframe>
```

Atribut yang sering digunakan:

- `src`: URL halaman web yang akan ditampilkan.
- `width`: Lebar iframe.
- `height`: Tinggi iframe.
- `title`: Judul iframe.

```html
<iframe
  src="https://www.google.com"
  width="800"
  height="600"
  title="Google"
></iframe>
```

## 8. Entitas HTML

Entitas HTML digunakan untuk menampilkan karakter khusus dalam dokumen HTML. Beberapa entitas HTML yang sering digunakan:

- `&lt;`: < (kurang dari)
- `&gt;`: > (lebih dari)
- `&amp;`: & (dan)
- `&quot;`: " (petik dua)
- `&copy;`: © (hak cipta)
- `&reg;`: ® (merek dagang)

Tujuan dari penggunaan entitas HTML adalah untuk menghindari konflik dengan karakter khusus dalam kode HTML. Contohnya jika kita ingin menampilkan karakter <, >, atau & dalam dokumen HTML, maka kita harus menggunakan entitas HTML, karena karakter tersebut baisanya digunakan dalam sintaks HTML.

```html
<p>&lt; adalah entitas HTML untuk karakter kurang dari (<)</p>
<p>&gt; adalah entitas HTML untuk karakter lebih dari (>)</p>
<p>&amp; adalah entitas HTML untuk karakter dan (&)</p>
```
