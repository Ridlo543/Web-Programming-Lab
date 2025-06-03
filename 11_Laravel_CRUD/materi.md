# **Pengenalan Laravel Framework 12**


## **Apa itu Laravel?**

**Laravel** adalah sebuah **framework PHP modern** yang dirancang untuk mempermudah dan mempercepat proses pembuatan aplikasi web, baik yang berskala kecil maupun besar. Laravel menggunakan arsitektur **MVC (Model-View-Controller)**, yang membantu pengembang memisahkan logika bisnis, tampilan antarmuka, dan pengelolaan data menjadi bagian yang terstruktur dan rapi.

Laravel pertama kali dirilis oleh **Taylor Otwell** pada tahun 2011 dan sejak saat itu terus berkembang hingga versi terbaru (Laravel 12).



### **Fitur Utama Laravel**

Laravel dirancang dengan pendekatan **"developer-first"**, artinya framework ini berusaha menyederhanakan proses coding tanpa mengorbankan fleksibilitas dan kekuatan sistem. Berikut adalah beberapa fitur kunci Laravel yang sangat membantu dalam pengembangan web:



#### 1. **Routing yang Elegan**

Laravel menyediakan sistem routing yang sangat mudah digunakan dan dibaca. Kamu bisa mendefinisikan URL dan logika yang dijalankan hanya dengan satu baris kode di `routes/web.php`.

Contoh:

```php
Route::get('/home', [HomeController::class, 'index']);
```

Routing Laravel juga mendukung:

* Route Group
* Route Middleware
* Route Prefix & Namespace
* Named Routes
* Route Caching untuk performa



#### 2. **Eloquent ORM (Object Relational Mapping)**

Eloquent adalah sistem ORM bawaan Laravel yang memungkinkan kamu berinteraksi dengan database menggunakan sintaks PHP yang ekspresif.

Contoh:

```php
$users = User::where('status', 'active')->get();
```

Fitur Eloquent:

* Relasi antar tabel (One to Many, Many to Many, dsb.)
* Query Builder
* Soft Deletes
* Mutators & Accessors



#### 3. **Blade Templating Engine**

Blade adalah template engine Laravel yang memungkinkan kamu menulis HTML + PHP dengan cara yang rapi dan efisien.

Contoh:

```blade
<h1>{{ $title }}</h1>

@foreach ($posts as $post)
    <p>{{ $post->content }}</p>
@endforeach
```

Keunggulan Blade:

* Template inheritance (`@extends`, `@section`)
* Komponen Blade (`<x-alert>`)
* Kondisi dan perulangan sederhana



#### 4. **Middleware, Queue, Event Broadcasting**

* **Middleware**: Menyaring request HTTP sebelum mencapai controller, berguna untuk autentikasi, logging, dsb.
* **Queue**: Memproses tugas-tugas berat (seperti kirim email, generate laporan) secara asynchronous.
* **Event Broadcasting**: Menghubungkan Laravel dengan front-end secara real-time (dengan WebSocket).



#### 5. **Built-in Security & Authentication**

Laravel menyediakan:

* Sistem login dan register bawaan (Jetstream/Breeze)
* Proteksi CSRF (Cross-Site Request Forgery)
* Hashing password menggunakan Bcrypt atau Argon2
* Guard dan Role Permission
* Token-based API authentication (Sanctum, Passport)



#### 6. **Artisan Command Line Interface (CLI)**

Laravel menyediakan tool command line bernama **Artisan** untuk mempercepat proses development:

Contoh perintah:

```bash
php artisan make:controller PostController
php artisan migrate
php artisan route:list
```

Fitur Artisan:

* Membuat model, controller, migration, seeder
* Menjalankan server lokal
* Custom command (bisa bikin sendiri)



## **Kelebihan Laravel Dibanding Framework Lain**

### 1. **Struktur Proyek yang Bersih dan Rapi**

Laravel memaksa kamu menulis kode dengan cara yang terstruktur sesuai standar MVC, memudahkan kolaborasi tim dan pemeliharaan jangka panjang.

### 2. **Dokumentasi Resmi yang Lengkap**

Setiap fitur Laravel memiliki dokumentasi yang mudah dipahami, bahkan untuk pemula. Lihat di [https://laravel.com/docs](https://laravel.com/docs)

### 3. **Dukungan Komunitas Besar**

Dengan jutaan pengguna di seluruh dunia, kamu bisa dengan mudah menemukan tutorial, forum, package tambahan, dan bantuan dari komunitas.

### 4. **Ekosistem Laravel yang Luas**

Laravel tidak berdiri sendiri. Ia hadir dengan berbagai tool pelengkap:

* **Jetstream / Breeze**: Autentikasi modern
* **Sanctum / Passport**: API authentication
* **Laravel Livewire**: Membuat UI interaktif tanpa JavaScript
* **Laravel Mix / Vite**: Pengelolaan asset modern (JS, CSS)
* **Laravel Horizon**: Monitoring antrian queue
* **Laravel Nova**: Admin panel siap pakai (berbayar)

## 2. Instalasi dan Konfigurasi Laravel 12

Laravel 12 adalah versi terbaru dari framework Laravel, dan untuk dapat menjalankannya dengan baik, kamu perlu memenuhi beberapa **prasyarat teknis**, lalu melakukan **instalasi** dan **konfigurasi awal proyek**.



### Prasyarat Sistem

Sebelum menginstal Laravel, pastikan kamu sudah menyiapkan lingkungan kerja dengan spesifikasi berikut:

| Komponen         | Keterangan                                                                 |
|------------------|------------------------------------------------------------------------------|
| PHP              | Versi **8.2 atau lebih tinggi** (Laravel 12 tidak mendukung PHP versi lama) |
| Composer         | Dependency manager untuk PHP (mengelola package Laravel dan library lain)   |
| MySQL/PostgreSQL | Database engine yang digunakan (default: MySQL)                             |
| Node.js + NPM    | Untuk mengelola asset frontend (JS, CSS, Vite, Tailwind, dll)               |
| Web Server       | Bisa menggunakan Apache, Nginx, Laravel Valet, atau Artisan Serve           |


> **Catatan**: Untuk pengembangan lokal, cukup menggunakan Artisan (`php artisan serve`) tanpa harus setup server Apache/Nginx.



### Langkah Instalasi Laravel 12

#### 1. **Membuat Proyek Laravel Baru**

Buka terminal dan jalankan perintah:

```bash
composer create-project laravel/laravel:^12.0 nama-proyek
```

* `composer`: Perintah utama untuk mengelola dependency PHP
* `create-project`: Digunakan untuk membuat proyek baru
* `laravel/laravel:^12.0`: Memastikan kamu menggunakan versi Laravel 12
* `nama-proyek`: Nama folder atau proyekmu

#### 2. **Masuk ke Direktori Proyek**

```bash
cd nama-proyek
```

#### 3. **Menjalankan Server Laravel**

Laravel menyediakan server development bawaan:

```bash
php artisan serve
```

> Defaultnya, aplikasi akan dapat diakses melalui:
> `http://127.0.0.1:8000` atau `http://localhost:8000`



### Konfigurasi Awal Laravel

Laravel menggunakan file `.env` (environment file) untuk menyimpan konfigurasi yang **sensitif** dan **berubah-ubah** tergantung lingkungan (dev, staging, production).

#### File `.env`

Beberapa hal yang biasa dikonfigurasi:

* Nama aplikasi
* Mode aplikasi (debug / production)
* Database
* Mail server
* Key app

Contoh bagian penting dari file `.env`:

```env
APP_NAME=Laravel12App
APP_ENV=local
APP_KEY=base64:xxxxxxxxxxxxxx
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12db
DB_USERNAME=root
DB_PASSWORD=
```



### Konfigurasi Koneksi Database

Laravel menggunakan **Eloquent ORM** untuk koneksi dan manajemen database. Secara default, Laravel mendukung:

* MySQL
* PostgreSQL
* SQLite
* SQL Server

Pastikan database yang dimaksud sudah dibuat di sistem MySQL-mu. Misalnya, buat database `laravel12db` lewat phpMyAdmin atau CLI:

```sql
CREATE DATABASE laravel12db;
```



### Menjalankan Migrasi Default

Setelah database dikonfigurasi, jalankan migrasi awal Laravel untuk membuat struktur tabel-tabel default (seperti `users`, `password_resets`, `failed_jobs`, dll):

```bash
php artisan migrate
```

Jika berhasil, Laravel akan mengeluarkan pesan seperti:

```
Migrating: 2024_01_01_000000_create_users_table
Migrated:  2024_01_01_000000_create_users_table (12ms)
```



### Tes Awal Laravel

Setelah semua langkah selesai:

1. Jalankan `php artisan serve` (jika belum).
2. Buka browser ke `http://127.0.0.1:8000`
3. Kamu akan melihat tampilan **Laravel Welcome Page**.



### Tips Tambahan Setelah Instalasi

* **Generate App Key** (kalau belum otomatis):

  ```bash
  php artisan key:generate
  ```

* **Instalasi Frontend (opsional)**:
  Laravel kini menggunakan **Vite**:

  ```bash
  npm install
  npm run dev
  ```

* **Cek versi Laravel**:

  ```bash
  php artisan --version
  ```

## 3. **MVC Architecture di Laravel**

Laravel dibangun menggunakan **arsitektur MVC** (Model-View-Controller), yang memisahkan tanggung jawab aplikasi web ke dalam tiga bagian utama. Tujuannya adalah untuk menjaga **struktur kode tetap bersih, modular, dan mudah dikelola**, terutama pada proyek skala besar atau yang dikerjakan tim.

### Apa itu MVC?

| Komponen   | Tugas Utama                                 | Dalam Laravel                    |
|------------|----------------------------------------------|----------------------------------|
| Model      | Mengelola data, komunikasi dengan database   | Eloquent ORM (`app/Models`)      |
| View       | Menampilkan data ke user (UI)                | Blade Template (`resources/views`) |
| Controller | Mengatur alur logika dan permintaan user     | (`app/Http/Controllers`)         |
   |


### Alur Kerja MVC di Laravel

Mari kita uraikan alur `User Request → Route → Controller → Model (opsional) → View → User` menjadi langkah konkret:

#### 1. **User Request**

Pengguna mengakses URL (misal: `http://localhost/posts`) melalui browser. Permintaan dikirim ke Laravel.

#### 2. **Route**

File `routes/web.php` mencocokkan URL dengan **controller** yang sesuai:

```php
Route::get('/posts', [PostController::class, 'index']);
```

Artinya, saat user mengakses `/posts`, Laravel akan menjalankan method `index()` di `PostController`.

#### 3. **Controller**

Di dalam `app/Http/Controllers/PostController.php`, method `index()` berisi logika aplikasi:

```php
public function index() {
    $posts = Post::all(); // Memanggil model
    return view('posts.index', compact('posts')); // Mengirim data ke view
}
```

Controller bertugas sebagai **jembatan** antara data (model) dan tampilan (view).

#### 4. **Model (Opsional)**

Model berada di folder `app/Models/Post.php` dan mewakili tabel `posts` di database:

```php
class Post extends Model
{
    protected $fillable = ['title', 'content'];
}
```

Model menggunakan **Eloquent ORM** untuk query database secara OOP:

```php
$posts = Post::all();
```

#### 5. **View**

View adalah file Blade (`resources/views/posts/index.blade.php`) yang menampilkan data kepada pengguna:

```blade
<h1>Daftar Postingan</h1>
@foreach ($posts as $post)
    <h3>{{ $post->title }}</h3>
    <p>{{ $post->content }}</p>
@endforeach
```

#### 6. **User**

Pengguna melihat hasil akhir di browser.


### Contoh Struktur Proyek Laravel (Sederhana)

```
app/
├── Http/
│   └── Controllers/
│       └── PostController.php  ← logika aplikasi
├── Models/
│   └── Post.php                ← representasi data
resources/
└── views/
    └── posts/
        └── index.blade.php     ← tampilan
routes/
└── web.php                     ← rute URL
```



### Analogi Sederhana

Bayangkan kamu memesan makanan di restoran:

* **View**: Pelayan membawa menu ke kamu (tampilan).
* **Controller**: Pelayan menerima pesananmu dan mengirimnya ke dapur (logika).
* **Model**: Dapur memasak berdasarkan bahan dan resep (data/database).


### Manfaat MVC di Laravel

1. **Pemeliharaan Mudah**: Kode terbagi jelas antara data, tampilan, dan logika.
2. **Skalabilitas**: Mempermudah menambahkan fitur tanpa merusak bagian lain.
3. **Tim Developer**: Developer backend bisa fokus di Controller/Model, frontend di View.
4. **Reusability**: Model dan View bisa digunakan ulang di berbagai bagian.



Jika kamu ingin saya bantu buatkan **contoh CRUD lengkap berbasis MVC di Laravel 12** (beserta controller, model, view, dan routing), tinggal bilang saja! Bisa juga saya bantu dengan ilustrasi diagram MVC atau animasi alurnya.


Berikut penjelasan **lebih detail dan menyeluruh** mengenai:

## 4. **Routing di Laravel**

**Routing** adalah fondasi penting dalam Laravel. Setiap permintaan (request) dari pengguna diarahkan ke rute (route) yang menentukan **apa yang harus dilakukan** — bisa menjalankan fungsi, memanggil controller, atau menampilkan view.


### **File Routing**

Laravel memisahkan rute ke dalam beberapa file di direktori `routes/`:

| File                  | Kegunaan                                                                |
|-----------------------|-------------------------------------------------------------------------|
| `routes/web.php`      | Untuk rute yang melayani halaman web biasa (menggunakan session/cookie) |
| `routes/api.php`      | Untuk rute REST API (stateless)                                         |
| `routes/console.php`  | Untuk command-line routes (Artisan commands)                            |
| `routes/channels.php` | Untuk broadcasting (websockets)                                         |


Untuk aplikasi web biasa, kamu akan banyak bekerja di **`web.php`**.



### **Contoh Routing Dasar**

#### Route dengan Closure (fungsi anonim)

```php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'Halaman About';
});
```

* `Route::get()` → menangani HTTP GET
* `'/'` → URL yang diakses
* `function () { ... }` → logika yang dijalankan ketika URL tersebut diakses



### **Route ke Controller**

Routing bisa diarahkan langsung ke controller, alih-alih menggunakan closure. Ini pendekatan yang lebih **terstruktur** dan **mudah di-maintain**.

```php
Route::get('/contact', [ContactController::class, 'index']);
```

* `ContactController` harus ada di folder `app/Http/Controllers`
* Method `index()` di dalam controller tersebut akan dijalankan

**Contoh Controller:**

```php
class ContactController extends Controller
{
    public function index() {
        return view('contact');
    }
}
```

### **Route dengan Parameter**

Laravel mendukung parameter pada URL untuk menangani data dinamis.

```php
Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});
```

* `{id}` adalah parameter dinamis
* `$id` akan berisi nilai dari URL, misalnya `/user/5` → `$id = 5`

#### Parameter Optional:

```php
Route::get('/user/{name?}', function ($name = 'Guest') {
    return "Hello, " . $name;
});
```

Tambahkan `?` di dalam `{}` agar parameter jadi opsional, dan beri nilai default di fungsi.



### **Route dengan Validasi Parameter (Route Constraints)**

Laravel bisa memvalidasi parameter secara langsung:

```php
Route::get('/user/{id}', function ($id) {
    return "User ID: $id";
})->where('id', '[0-9]+');
```

> Hanya menerima angka untuk `{id}`



### **Named Route**

Memberi nama pada route memudahkan pemanggilan di template atau redirect:

```php
Route::get('/profile', [UserController::class, 'show'])->name('user.profile');
```

Lalu di blade:

```blade
<a href="{{ route('user.profile') }}">Lihat Profil</a>
```



### **Route Grouping**

Mengelompokkan banyak route sekaligus berdasarkan middleware, prefix, dsb.

```php
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/users', [AdminController::class, 'users']);
});
```


### **Ringkasan Jenis HTTP Method di Routing**

| Method      | Digunakan untuk           | Contoh Laravel                      |
|-------------|--------------------------|-----------------------------------|
| `GET`       | Menampilkan data          | `Route::get()`                    |
| `POST`      | Menyimpan data            | `Route::post()`                   |
| `PUT/PATCH` | Mengupdate data           | `Route::put()` / `Route::patch()`|
| `DELETE`    | Menghapus data            | `Route::delete()`                 |
| `ANY`       | Menangani semua metode    | `Route::any()`                    |
| `MATCH`     | Menangani metode tertentu | `Route::match(['get', 'post'])`  |


### Cek Semua Route

Untuk melihat semua route yang sudah didefinisikan:

```bash
php artisan route:list
```

Akan menampilkan daftar lengkap route: URL, method, controller, middleware, dsb.

## 5. **Models, Controllers, dan Actions di Laravel**

Tiga komponen inti dari arsitektur MVC Laravel adalah **Model**, **Controller**, dan **Action (method di controller)**. Mereka bekerja sama untuk mengelola alur data, logika bisnis, dan tampilan.



### **Model di Laravel**

**Model** adalah representasi dari tabel di database dan bagian dari **Eloquent ORM** Laravel. Dengan model, kamu bisa membaca, menulis, dan memanipulasi data dalam bentuk **OOP (Object-Oriented Programming)**.

#### Membuat Model

```bash
php artisan make:model Post -m
```

* `Post` → Nama model (harus huruf besar awal)
* `-m` → Sekaligus membuat file migrasi (`database/migrations/xxxx_create_posts_table.php`)

#### File Model

File model disimpan di `app/Models/Post.php`. Contoh isi model:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content'];
}
```

* `protected $fillable` digunakan untuk mengatur field mana yang bisa diisi secara massal (mass assignment).
* Laravel secara otomatis menghubungkan model `Post` ke tabel `posts`.

> **Konvensi Laravel**: Model `Post` → Tabel `posts`, Model `UserProfile` → Tabel `user_profiles`


### **Controller di Laravel**

**Controller** adalah pusat logika aplikasi. Ia menerima request dari route, memproses data (jika perlu melalui model), dan mengembalikan response (biasanya view atau JSON).

#### Membuat Controller

```bash
php artisan make:controller PostController
```

* File akan dibuat di: `app/Http/Controllers/PostController.php`


### **Actions di Controller**

Action adalah **method** dalam controller yang menangani satu unit logika, seperti:

| Method         | Kegunaan                    |
|----------------|-----------------------------|
| `index()`      | Menampilkan semua data      |
| `show($id)`    | Menampilkan detail data     |
| `create()`     | Menampilkan form input data |
| `store()`      | Menyimpan data baru         |
| `edit($id)`    | Menampilkan form edit data  |
| `update($id)`  | Menyimpan perubahan data    |
| `destroy($id)` | Menghapus data              |


#### Contoh: `PostController.php`

```php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // GET /posts
    public function index() {
        $posts = Post::all(); // Mengambil semua data dari tabel posts
        return view('posts.index', compact('posts')); // Mengirim ke view
    }

    // GET /posts/{id}
    public function show($id) {
        $post = Post::findOrFail($id); // Ambil data berdasarkan id, atau error 404
        return view('posts.show', compact('post'));
    }

    // GET /posts/create
    public function create() {
        return view('posts.create');
    }

    // POST /posts
    public function store(Request $request) {
        // Validasi dan simpan data
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        Post::create($validated);

        return redirect('/posts')->with('success', 'Post berhasil disimpan!');
    }

    // GET /posts/{id}/edit
    public function edit($id) {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    // PUT /posts/{id}
    public function update(Request $request, $id) {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $post->update($validated);

        return redirect('/posts')->with('success', 'Post berhasil diperbarui!');
    }

    // DELETE /posts/{id}
    public function destroy($id) {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect('/posts')->with('success', 'Post berhasil dihapus!');
    }
}
```



### **Integrasi Model, Controller, dan Routing**

#### Routing ke Controller:

```php
use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/create', [PostController::class, 'create']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);
```

> Laravel juga menyediakan route **resourceful** yang otomatis memetakan semua ini:

```php
Route::resource('posts', PostController::class);
```


### Tips Pengujian

* Jalankan `php artisan migrate` untuk membuat tabel.
* Tambahkan data dummy di seeder atau langsung dari form.
* Tes semua route di browser atau dengan Postman.

## 6. **Blade Templating di Laravel**

### Apa itu Blade?

**Blade** adalah engine templating bawaan Laravel yang memungkinkan kamu membuat tampilan (view) dinamis dengan sintaks yang bersih, cepat, dan elegan. Blade memadukan HTML dan kode PHP dengan cara yang lebih rapi dibandingkan PHP biasa.

> File Blade diakhiri dengan ekstensi: `.blade.php`



## Struktur Dasar Blade

### Layout Utama (Master Layout)

Blade mendukung layout dan inheritance, seperti konsep template di banyak framework front-end.

#### Contoh: `resources/views/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <h1>My Blog</h1>
    </header>

    <div class="content">
        @yield('content')
    </div>

    <footer>
        <p>&copy; 2025 My Laravel Blog</p>
    </footer>
</body>
</html>
```

* `@yield('title')` dan `@yield('content')` adalah **slot** untuk diisi oleh child template.



### Menggunakan Layout

#### Contoh: `resources/views/home.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2>Selamat Datang di Laravel 12</h2>
    <p>Ini adalah halaman beranda.</p>
@endsection
```

* `@extends('layouts.app')` → Menggunakan layout utama
* `@section('title', '...')` → Mengisi konten di slot `@yield('title')`
* `@section('content') ... @endsection` → Mengisi konten utama halaman



## Menampilkan Data

Blade secara otomatis akan **escape** data agar aman dari XSS:

```blade
<h2>{{ $post->title }}</h2>
<p>{{ $post->content }}</p>
```

Jika ingin menampilkan HTML asli (tidak di-escape), gunakan:

```blade
{!! $post->content !!}
```

> Hati-hati menggunakan `{!! !!}` karena bisa dieksploitasi jika kontennya tidak divalidasi!



## Loop dan Logika

### Perulangan (Loop)

```blade
@foreach ($posts as $post)
    <h3>{{ $post->title }}</h3>
@endforeach
```

Blade juga menyediakan:

```blade
@for ($i = 0; $i < 5; $i++)
    <p>Nomor ke-{{ $i }}</p>
@endfor

@while (true)
    {{-- berhenti dengan break --}}
@endwhile
```

### Kondisi

```blade
@if ($user->isAdmin())
    <p>Selamat datang, Admin!</p>
@elseif ($user->isGuest())
    <p>Silakan login untuk lanjut.</p>
@else
    <p>Selamat datang, pengguna!</p>
@endif
```

Blade juga mendukung:

```blade
@isset($title)
    <h1>{{ $title }}</h1>
@endisset

@empty($posts)
    <p>Belum ada postingan.</p>
@endempty
```



## Komponen dan Include

### Include View

```blade
@include('partials.navbar')
```

Artinya, file `resources/views/partials/navbar.blade.php` akan disisipkan.

### Komponen Blade (v12+ Modern)

Laravel 12 juga mendukung **komponen** seperti ini:

```blade
<x-alert type="success" message="Data berhasil disimpan!" />
```

Komponen ini bisa didefinisikan di `app/View/Components/Alert.php` dan view-nya di `resources/views/components/alert.blade.php`.



## Blade Directive Khusus

| Directive         | Fungsi                                    |
|-------------------|-------------------------------------------|
| `@csrf`           | Menyisipkan token keamanan CSRF           |
| `@method('PUT')`  | Digunakan untuk spoof HTTP method di form |
| `@error('field')` | Menampilkan error validasi                 |
| `@auth`, `@guest` | Mengecek autentikasi pengguna              |


#### Contoh penggunaan form:

```blade
<form method="POST" action="/posts">
    @csrf
    <input type="text" name="title">
    <button type="submit">Simpan</button>
</form>
```



## Bonus: Komentar di Blade

```blade
{{-- Ini adalah komentar Blade --}}
```

Komentar ini tidak akan muncul di output HTML, berbeda dengan `<!-- komentar HTML -->`.



## Kesimpulan

Blade adalah sistem templating yang:

* Sangat **terintegrasi** dengan Laravel
* Mendukung **layout inheritance** dan **komponen**
* Punya sintaks **ringan, ekspresif**, dan mudah dibaca




# Referensi
Berikut adalah **referensi resmi dan relevan** yang digunakan sebagai dasar materi Laravel 12 yang telah dijelaskan:



## **Referensi Utama**

### **Laravel Official Documentation**

🔗 [https://laravel.com/docs](https://laravel.com/docs)

Dokumentasi ini selalu diperbarui setiap rilis Laravel terbaru dan mencakup semua aspek:

* Instalasi: `https://laravel.com/docs/12.x/installation`
* Routing: `https://laravel.com/docs/12.x/routing`
* Controllers: `https://laravel.com/docs/12.x/controllers`
* Models & Eloquent ORM: `https://laravel.com/docs/12.x/eloquent`
* Views & Blade: `https://laravel.com/docs/12.x/blade`
* Validation: `https://laravel.com/docs/12.x/validation`
* Artisan CLI: `https://laravel.com/docs/12.x/artisan`




