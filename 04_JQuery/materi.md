# Praktikum Pemrograman Web 4: jQuery

jQuery adalah pustaka/library JavaScript yang mempermudah manipulasi DOM, penanganan event, animasi, dan AJAX. Dalam bab ini, kita akan membahas konsep-konsep inti jQuery yang relevan untuk praktikum Web Programming.

# Daftar Isi

1. [Pengenalan jQuery dan Cara Instalasi](#1-pengenalan-jquery-dan-cara-instalasi)
2. [Selektor jQuery](#2-selektor-jquery)
3. [Manipulasi DOM](#3-manipulasi-dom)
4. [Event Handling dengan jQuery](#4-event-handling-dengan-jquery)
5. [Efek dan Animasi](#5-efek-dan-animasi)
6. [Pengelolaan Kelas CSS](#6-pengelolaan-kelas-css)
7. [Traversing DOM](#7-traversing-dom)
8. [Penggunaan Method Chaining](#8-penggunaan-method-chaining)
9. [Debugging Dasar dengan Console](#9-debugging-dasar-dengan-console)
10. [Kesimpulan](#10-kesimpulan)
11. [Referensi](#11-referensi)

## 1. Pengenalan jQuery dan Cara Instalasi

### 1.1 Apa itu jQuery?

jQuery adalah library JavaScript yang ringan, cepat, dan kaya fitur yang menyederhanakan manipulasi HTML DOM, penanganan event, animasi, dan interaksi AJAX. Diperkenalkan pada tahun 2006, jQuery masih menjadi salah satu library JavaScript paling populer karena kemudahannya dalam:

- Menulis kode JavaScript yang lebih sederhana
- Menangani perbedaan antar browser
- Memilih dan memanipulasi elemen DOM dengan mudah
- Menciptakan efek dan animasi tanpa kompleksitas

Prinsip dasar jQuery adalah "Write less, do more" (Tulis lebih sedikit, lakukan lebih banyak).

### 1.2 Cara Instalasi jQuery

Ada dua cara utama untuk menginstal jQuery:

#### 1.2.1 Menggunakan CDN (Content Delivery Network)

```html
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>

<!-- atau jQuery versi spesifik seperti 2.2.4 untuk kompatibilitas -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
```

**Keuntungan menggunakan CDN:**

- Kemungkinan caching oleh browser user jika mereka sudah mengunjungi situs lain yang menggunakan jQuery dari CDN yang sama
- Tidak perlu menyimpan file jQuery di server
- Mengurangi beban server

#### 1.2.2 Mengunduh dan Menggunakan File Lokal

1. Unduh jQuery dari [situs resmi jQuery](https://jquery.com/download/)
2. Simpan file jQuery di direktori proyek
3. Sertakan file dengan tag script:

```html
<script src="js/jquery-3.6.0.min.js"></script>
```

**Keuntungan menggunakan file lokal:**

- Website masih berfungsi meskipun tanpa koneksi internet (untuk pengembangan lokal)
- Tidak tergantung pada layanan pihak ketiga atau CDN
- Kontrol penuh terhadap versi jQuery yang digunakan

### 1.3 Sintaks Dasar jQuery

Sintaks dasar jQuery adalah: `$(selector).action()`

- `$` adalah simbol yang mendefinisikan jQuery
- `selector` adalah perintah untuk "mencari" elemen HTML
- `action()` adalah aksi yang akan dilakukan pada elemen tersebut

#### 1.3.1 Document Ready

Struktur dasar yang digunakan dalam jQuery:

```javascript
// Versi lengkap
$(document).ready(function () {
  // Kode jQuery di sini
  // Dijalankan setelah dokumen HTML sepenuhnya dimuat
});

// Versi singkat (shorthand)
$(function () {
  // Kode jQuery di sini
  // Fungsi yang sama dengan di atas
});
```

Fungsi document ready sangat penting karena:

- Mencegah kode jQuery dieksekusi sebelum dokumen selesai dimuat
- Memastikan semua elemen DOM tersedia saat jQuery mencoba mengaksesnya

---

## 2. Selektor jQuery

Selektor adalah cara untuk memilih dan memanipulasi elemen HTML, dan merupakan salah satu kekuatan utama jQuery.

### 2.1 Jenis-jenis Selektor

#### 2.1.1 Selektor Elemen (Tag)

Memilih semua elemen dengan tag tertentu.

```javascript
$("p"); // Memilih semua elemen paragraf
$("div"); // Memilih semua elemen div
$("h1"); // Memilih semua heading 1
```

#### 2.1.2 Selektor ID

Memilih elemen dengan ID tertentu. ID harus unik dalam dokumen.

```javascript
$("#header"); // Memilih elemen dengan id="header"
$("#content"); // Memilih elemen dengan id="content"
```

#### 2.1.3 Selektor Class

Memilih semua elemen dengan class tertentu.

```javascript
$(".highlight"); // Memilih semua elemen dengan class="highlight"
$(".btn"); // Memilih semua elemen dengan class="btn"
```

#### 2.1.4 Selektor Kombinasi

Kombinasi beberapa selektor untuk lebih spesifik.

```javascript
$("p.intro"); // Semua paragraf dengan class="intro"
$("div#content"); // Div dengan id="content"
$("ul li"); // Semua elemen li dalam ul
$("ul > li"); // Semua elemen li yang merupakan anak langsung dari ul
$("h1, h2, h3"); // Semua h1, h2, dan h3
```

#### 2.1.5 Selektor Atribut

Memilih elemen berdasarkan atribut.

```javascript
$("[href]"); // Elemen dengan atribut href
$("[href='#']"); // Elemen dengan href="#"
$("[href^='https']"); // Elemen dengan href yang dimulai dengan "https"
$("[href$='.pdf']"); // Elemen dengan href yang berakhiran ".pdf"
$("input[type='text']"); // Input dengan type="text"
```

#### 2.1.6 Selektor Posisi

Memilih elemen berdasarkan posisinya.

```javascript
$("tr:first"); // Baris pertama dalam tabel
$("tr:last"); // Baris terakhir dalam tabel
$("li:even"); // Elemen li dengan indeks genap (0, 2, 4, ...)
$("li:odd"); // Elemen li dengan indeks ganjil (1, 3, 5, ...)
$("p:eq(1)"); // Paragraf kedua (indeks 1)
$("tr:gt(2)"); // Baris dengan indeks lebih dari 2
$("tr:lt(2)"); // Baris dengan indeks kurang dari 2
```

---

## 3. Manipulasi DOM

jQuery menyediakan metode yang memudahkan untuk mengubah elemen HTML dan kontennya.

- **Mengubah Teks**: `text()`, `html()`
- **Mengubah Atribut**: `attr()`
- **Mengubah CSS**: `css()`

### 3.1 Mengambil dan Mengubah Konten

#### 3.1.1 Mendapatkan dan Mengubah Teks

```javascript
// Mendapatkan teks
var teks = $("#elemen").text();

// Mengubah teks
$("#elemen").text("Teks baru");
```

`text()` hanya menangani teks biasa, tanpa menerjemahkan tag HTML.

#### 3.1.2 Mendapatkan dan Mengubah HTML

```javascript
// Mendapatkan konten HTML
var html = $("#elemen").html();

// Mengubah konten HTML
$("#elemen").html("<strong>Konten baru</strong>");
```

`html()` dapat memuat dan menafsirkan tag HTML.

#### 3.1.3 Mendapatkan dan Mengubah Nilai Input

```javascript
// Mendapatkan nilai dari input
var nilai = $("#input-username").val();

// Mengubah nilai input
$("#input-username").val("john_doe");
```

### 3.2 Menambah dan Menghapus Elemen

#### 3.2.1 Menambah Elemen

```javascript
// Menambahkan konten di akhir elemen yang dipilih
$("#div1").append("<p>Paragraf baru di akhir</p>");

// Menambahkan konten di awal elemen yang dipilih
$("#div1").prepend("<p>Paragraf baru di awal</p>");

// Menambahkan konten sebelum elemen yang dipilih
$("#div1").before("<h2>Judul sebelum div</h2>");

// Menambahkan konten setelah elemen yang dipilih
$("#div1").after("<h2>Judul setelah div</h2>");
```

#### 3.2.2 Menghapus Elemen

```javascript
// Menghapus elemen dan anak-anaknya
$("#div1").remove();

// Menghapus anak-anak elemen tapi menyimpan elemen itu sendiri
$("#div1").empty();

// Menghapus elemen dengan filter (opsional)
$("p").remove(".test, .demo"); // Menghapus p dengan class test atau demo
```

### 3.3 Manipulasi Atribut

```javascript
// Mendapatkan nilai atribut
var target = $("a").attr("target");

// Menetapkan nilai atribut
$("a").attr("target", "_blank");

// Menetapkan beberapa atribut sekaligus
$("a").attr({
  href: "https://www.example.com",
  target: "_blank",
  title: "Contoh Website",
});

// Menghapus atribut
$("a").removeAttr("target");
```

### 3.4 Manipulasi CSS

```javascript
// Mendapatkan property CSS
var color = $("#div1").css("color");

// Menetapkan satu property CSS
$("#div1").css("color", "blue");

// Menetapkan beberapa property CSS
$("#div1").css({
  color: "blue",
  "font-size": "16px",
  "background-color": "#f0f0f0",
  padding: "10px",
});
```

### Contoh

```html
<div id="kotak">Kotak</div>
<script>
  $(document).ready(function () {
    $("#kotak").html("<strong>Kotak Baru</strong>");
    $("#kotak").attr("title", "Kotak Interaktif");
    $("#kotak").css("background-color", "yellow");
  });
</script>
```

---

## 4. Event Handling dengan jQuery

jQuery menyediakan method sederhana untuk menangani event seperti klik, hover, dll.

- `click()`: Klik elemen.
- `hover()`: Mouse masuk/keluar.
- `keyup()`: Tombol dilepas.
- dan banyak lagi.

### 4.1 Jenis-jenis Event

#### 4.1.1 Event Mouse

```javascript
// Klik pada elemen
$("#btn").click(function () {
  alert("Button diklik!");
});

// Double klik
$("#btn").dblclick(function () {
  alert("Double klik!");
});

// Mouse masuk ke elemen
$("#box").mouseenter(function () {
  $(this).css("background-color", "lightblue");
});

// Mouse keluar dari elemen
$("#box").mouseleave(function () {
  $(this).css("background-color", "white");
});

// Kombinasi mouseenter dan mouseleave
$("#box").hover(
  function () {
    // mouseenter
    $(this).css("background-color", "lightblue");
  },
  function () {
    // mouseleave
    $(this).css("background-color", "white");
  }
);
```

#### 4.1.2 Event Keyboard

```javascript
// Ketika tombol ditekan
$("#input").keydown(function () {
  console.log("Tombol ditekan");
});

// Ketika tombol dilepas
$("#input").keyup(function () {
  console.log("Tombol dilepas: " + $(this).val());
});

// Ketika tombol ditekan (character)
$("#input").keypress(function (event) {
  console.log("Karakter: " + String.fromCharCode(event.which));
});
```

#### 4.1.3 Event Form

```javascript
// Ketika form disubmit
$("#myForm").submit(function (event) {
  event.preventDefault(); // Mencegah pengiriman form
  console.log("Form disubmit");
});

// Ketika input berubah
$("#dropdown").change(function () {
  console.log("Nilai dipilih: " + $(this).val());
});

// Ketika input mendapat fokus
$("#input").focus(function () {
  $(this).css("background-color", "lightyellow");
});

// Ketika input kehilangan fokus
$("#input").blur(function () {
  $(this).css("background-color", "white");
});
```

#### 4.1.4 Event Dokumen/Window

```javascript
// Ketika halaman selesai dimuat
$(document).ready(function () {
  console.log("Dokumen siap");
});

// Ketika ukuran window berubah
$(window).resize(function () {
  console.log(
    "Window diubah ukurannya: " + $(window).width() + "x" + $(window).height()
  );
});

// Ketika halaman di-scroll
$(window).scroll(function () {
  console.log("Scrolled to: " + $(window).scrollTop());
});
```

### 4.2 Metode Event Handling

#### 4.2.1 Metode .on()

`.on()` adalah metode yang fleksibel untuk menangani event.

```javascript
// Sintaks dasar
$(selector).on(event, handler);

// Contoh
$("#btn").on("click", function () {
  alert("Button diklik!");
});

// Multiple events dengan handler yang sama
$("#btn").on("mouseenter mouseleave", function () {
  $(this).toggleClass("hover");
});

// Multiple events dengan handler berbeda
$("#btn").on({
  click: function () {
    alert("Diklik!");
  },
  mouseenter: function () {
    $(this).addClass("hover");
  },
  mouseleave: function () {
    $(this).removeClass("hover");
  },
});
```

### Contoh

```html
<button id="tombol">Klik Saya</button>
<input id="input" type="text" placeholder="Ketik di sini" />
<script>
  $(document).ready(function () {
    $("#tombol").click(function () {
      alert("Tombol diklik!");
    });
    $("#input").keyup(function () {
      console.log($(this).val());
    });
  });
</script>
```

---

## 5. Efek dan Animasi

jQuery menawarkan efek visual seperti menyembunyikan, menampilkan, dan animasi.

- `show()` / `hide()`: Tampilkan/sembunyikan.
- `fadeIn()` / `fadeOut()`: Efek pudar.
- `slideDown()` / `slideUp()`: Efek geser.
- `animate()`: Animasi kustom.

### 5.1 Efek Dasar

#### 5.1.1 Show dan Hide

```javascript
// Menampilkan elemen
$("#elemen").show();

// Menyembunyikan elemen
$("#elemen").hide();

// Toggle (beralih) antara tampil dan sembunyi
$("#elemen").toggle();

// Dengan durasi (millisecond)
$("#elemen").show(1000); // Animasi selama 1 detik
$("#elemen").hide("slow"); // Preset: "slow", "fast", atau millisecond
$("#elemen").toggle("fast");
```

#### 5.1.2 Fade

```javascript
// Memudar masuk (dari transparan ke terlihat)
$("#elemen").fadeIn();

// Memudar keluar (dari terlihat ke transparan)
$("#elemen").fadeOut();

// Toggle fade
$("#elemen").fadeToggle();

// Mengubah opacity ke nilai tertentu
$("#elemen").fadeTo("slow", 0.5); // 50% opacity
```

#### 5.1.3 Slide

```javascript
// Slide ke bawah (menampilkan elemen)
$("#elemen").slideDown();

// Slide ke atas (menyembunyikan elemen)
$("#elemen").slideUp();

// Toggle slide
$("#elemen").slideToggle();
```

### 5.2 Kontrol Animasi

```javascript
// Menghentikan semua animasi
$("#elemen").stop();

// Menghentikan animasi saat ini, tapi tetap menjalankan yang berada dalam antrian
$("#elemen").stop(false, false);

// Menghentikan animasi saat ini dan mengosongkan antrian animasi
$("#elemen").stop(true, false);

// Menghentikan animasi saat ini, melompat ke akhir, dan mengosongkan antrian
$("#elemen").stop(true, true);
```

### Contoh

```html
<div id="kotak" style="width:100px;height:100px;background:blue;"></div>
<button id="tombol">Toggle</button>
<script>
  $(document).ready(function () {
    $("#tombol").click(function () {
      $("#kotak").slideToggle(500); // Geser dalam 500ms
    });
  });
</script>
```

---

## 6. Pengelolaan Kelas CSS

jQuery mempermudah pengelolaan kelas CSS.

- `addClass()`: Tambah kelas.
- `removeClass()`: Hapus kelas.
- `toggleClass()`: Tambah/hapus kelas secara bergantian.
- dan lainnya.

### Contoh

```html
<style>
  .highlight {
    background-color: yellow;
  }
</style>
<p id="teks">Teks Biasa</p>
<button id="tombol">Toggle Highlight</button>
<script>
  $(document).ready(function () {
    $("#tombol").click(function () {
      $("#teks").toggleClass("highlight");
    });
  });
</script>
```

---

## 7. Traversing DOM

Traversing memungkinkan navigasi antar elemen DOM.

- `parent()`: Elemen induk.
- `children()`: Elemen anak.
- `siblings()`: Elemen saudara.
- `find()`: Cari elemen di dalam.

### Contoh

```html
<div id="container">
  <p>Satu</p>
  <p>Dua</p>
</div>
<script>
  $(document).ready(function () {
    $("#container").children().css("color", "red");
    $("#container").find("p:first").text("Pertama");
  });
</script>
```

---

## 9. Penggunaan Method Chaining

Method chaining memungkinkan pemanggilan berantai dalam satu baris.

### Contoh

```html
<p id="teks">Halo</p>
<script>
  $(document).ready(function () {
    $("#teks")
      .text("Selamat Datang")
      .css("color", "green")
      .addClass("highlight");
  });
</script>
```

---

## 10. Debugging Dasar dengan Console

Gunakan `console.log()` untuk memeriksa nilai atau melacak eksekusi.

### Contoh

```html
<button id="tombol">Klik</button>
<script>
  $(document).ready(function () {
    $("#tombol").click(function () {
      console.log("Tombol diklik pada: ", new Date());
    });
  });
</script>
```
