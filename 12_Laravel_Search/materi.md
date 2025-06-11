# **Materi Praktikum Pemrograman Web Lanjut (Laravel)**

### Topik: Middleware, Authentication, Search, Pagination, dan Optimization

### Middleware

#### Tujuan

Memahami cara kerja middleware sebagai *filter* yang memproses HTTP request sebelum atau sesudah mencapai controller. Middleware berguna untuk otorisasi pengguna, validasi request, logging, proteksi CSRF, dan lainnya.

---

#### Konsep Dasar Middleware

Middleware bekerja seperti lapisan perantara yang menyaring request yang masuk ke aplikasi Laravel. Setiap request akan melewati satu atau lebih middleware sebelum diteruskan ke controller atau ditolak.

Contoh penggunaan middleware:

* Memastikan hanya pengguna yang sudah login yang bisa mengakses halaman tertentu
* Membatasi akses hanya untuk admin
* Menambahkan header tertentu ke response
* Mencatat log setiap request masuk

---

#### Studi Kasus: Proteksi Akses Admin

##### 1. Membuat Middleware Baru

Perintah berikut akan menghasilkan file baru `IsAdmin.php` di folder `app/Http/Middleware/`:

```bash
php artisan make:middleware IsAdmin
```

##### 2. Menulis Logika Middleware

Buka file `app/Http/Middleware/IsAdmin.php` dan ubah fungsi `handle` menjadi seperti berikut:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Memastikan pengguna sudah login dan merupakan admin
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Jika tidak memenuhi syarat, redirect ke halaman utama
        return redirect('/');
    }
}
```


#### 3. Registrasi Middleware di Laravel 12

Di Laravel 12, middleware **tidak lagi didaftarkan melalui `Kernel.php`**, tapi langsung melalui:

##### a. **Route Middleware**

Langsung deklarasikan middleware di `routes/web.php` seperti ini:

```php
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin');
    });
});
```

Atau untuk route tunggal:

```php
Route::get('/admin', function () {
    return view('admin');
})->middleware(\App\Http\Middleware\IsAdmin::class);
```

---

#### .4 Global Middleware

Jika kamu ingin menerapkan middleware secara global (untuk semua request), kamu bisa menambahkannya melalui **Service Provider** seperti `App\Providers\AppServiceProvider`.

Contoh:

```php
public function boot(): void
{
    app('router')->pushMiddlewareToGroup('web', \App\Http\Middleware\IsAdmin::class);
}
```

Namun pendekatan ini lebih jarang digunakan dan hanya jika memang semua route harus difilter.

---

### Kesimpulan

| Versi Laravel | Cara Registrasi Middleware                              |
| ------------- | ------------------------------------------------------- |
| ≤ Laravel 10  | `app/Http/Kernel.php` → `$routeMiddleware`              |
| ≥ Laravel 11  | Langsung di `routes/*.php` atau melalui ServiceProvider |

---

#### Catatan Penting

* Middleware bisa digunakan di route, controller, atau group route
* Laravel juga memiliki middleware bawaan seperti `auth`, `guest`, `throttle`, dan lainnya
* Middleware bisa digunakan untuk mengubah response (misalnya menambahkan header)


Berikut adalah penjelasan mendalam mengenai **Authentication menggunakan Auth Facade (untuk Web)** dan **Laravel Sanctum (untuk API)** berdasarkan Laravel versi terbaru:

---

## 2. Authentication (Auth Facade dan Laravel Sanctum)

### Tujuan

Mahasiswa diharapkan memahami dan dapat menerapkan sistem autentikasi pengguna di Laravel baik untuk **aplikasi web berbasis session** maupun **aplikasi berbasis API menggunakan token**.

---

### A. Auth Facade (Autentikasi Web Berbasis Session)

#### Deskripsi

Laravel menyediakan autentikasi berbasis session secara built-in. Fitur ini cocok untuk aplikasi berbasis web yang mengandalkan form login/logout biasa. Auth ini bekerja dengan menyimpan informasi login di session server-side.

#### Langkah-Langkah

1. **Instalasi Laravel UI**
   Laravel UI adalah package resmi dari Laravel untuk menghasilkan *scaffolding* halaman autentikasi (login, register, dll).

   ```bash
   composer require laravel/ui
   ```

2. **Generate UI + Auth Scaffolding**
   Gunakan Bootstrap dan generate auth:

   ```bash
   php artisan ui bootstrap --auth
   npm install && npm run dev
   ```

3. **Migrasi Database**
   Jalankan migrasi untuk membuat tabel `users` dan tabel-tabel lain yang diperlukan:

   ```bash
   php artisan migrate
   ```

4. **Uji di Browser**
   Jalankan server:

   ```bash
   php artisan serve
   ```

   Lalu buka `http://localhost:8000`, kamu akan menemukan halaman login dan register.

#### Catatan

* Auth session secara default menggunakan middleware `auth`
* Untuk membatasi akses halaman:

  ```php
  Route::get('/dashboard', function () {
      return view('dashboard');
  })->middleware('auth');
  ```

---

### B. Laravel Sanctum (Autentikasi API berbasis Token)

#### Deskripsi

Laravel Sanctum adalah package Laravel untuk autentikasi token API yang ringan dan simpel. Cocok untuk SPA (Single Page Application), mobile app, atau REST API.

Sanctum menggunakan **token berbasis database** dan mendukung **multiple token per user**.

#### Langkah-Langkah

1. **Instalasi Sanctum**

   ```bash
   composer require laravel/sanctum
   ```

2. **Publikasi dan Migrasi**
   Publikasikan konfigurasi dan migrasi tabel `personal_access_tokens`:

   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

3. **Konfigurasi Model User**
   Tambahkan trait `HasApiTokens` pada model `User`:

   ```php
   use Laravel\Sanctum\HasApiTokens;

   class User extends Authenticatable
   {
       use HasApiTokens, HasFactory, Notifiable;
       // ...
   }
   ```

4. **Membuat Endpoint Login API**
   Tambahkan route di `routes/api.php`:

   ```php
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Hash;
   use App\Models\User;

   Route::post('/login', function (Request $request) {
       $user = User::where('email', $request->email)->first();

       if (! $user || ! Hash::check($request->password, $user->password)) {
           return response()->json(['error' => 'Invalid credentials'], 401);
       }

       return $user->createToken('token')->plainTextToken;
   });
   ```

5. **Endpoint yang Butuh Autentikasi Token**
   Tambahkan route dengan middleware `auth:sanctum`:

   ```php
   Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
       return $request->user();
   });
   ```

6. **Testing Token API**

   * Gunakan Postman:

     * POST ke `/api/login` dengan body: `{ "email": "...", "password": "..." }`
     * Akan mendapatkan token.
     * Gunakan token tersebut di header untuk endpoint selanjutnya:

       ```
       Authorization: Bearer <token>
       ```

#### Catatan

* Sanctum menyimpan token di tabel `personal_access_tokens`
* Token dapat dicabut/dihapus
* Tidak seperti `Passport`, Sanctum tidak menggunakan OAuth full stack, sehingga lebih ringan dan sederhana

---

### Perbandingan Singkat

| Fitur       | Auth Facade (Session) | Laravel Sanctum (API Token) |
| ----------- | --------------------- | --------------------------- |
| Basis       | Session               | Token                       |
| Cocok untuk | Web (form login)      | SPA, Mobile App, REST API   |
| Middleware  | `auth`                | `auth:sanctum`              |
| Penyimpanan | Session (server-side) | Token (database)            |
| Kelebihan   | Mudah untuk web       | Ringan, sederhana untuk API |


Berikut adalah penjelasan yang lebih lengkap dan terstruktur mengenai:

---

## 3. Query Builder dan ORM untuk Pencarian (Search)

### Tujuan

Memahami dan mempraktikkan teknik pencarian data dari database menggunakan pendekatan **Eloquent ORM** dan **Query Builder** di Laravel. Fokus utamanya adalah mencari berdasarkan teks yang diketikkan pengguna.

---

### A. Dasar Pencarian Data

Dalam Laravel, pencarian data biasanya dilakukan dengan:

* **`LIKE` operator** dari SQL
* Digunakan pada satu atau lebih kolom, seperti `title` atau `body`
* Diterapkan melalui Eloquent ORM atau Query Builder

---

### B. Studi Kasus: Pencarian Artikel pada Tabel `posts`

#### Struktur tabel posts (sebagai contoh)

| Kolom       | Tipe      |
| ----------- | --------- |
| id          | integer   |
| title       | string    |
| body        | text      |
| created\_at | timestamp |
| updated\_at | timestamp |

Model: `Post`

---

### C. Implementasi Pencarian Menggunakan Eloquent ORM

#### 1. Route

Tambahkan route untuk pencarian pada file `routes/web.php`:

```php
use App\Http\Controllers\PostController;

Route::get('/search', [PostController::class, 'search'])->name('posts.search');
```

---

#### 2. Controller

Buat method `search` di dalam `PostController.php`:

```php
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        $results = Post::where('title', 'like', "%{$query}%")
                       ->orWhere('body', 'like', "%{$query}%")
                       ->get();

        return view('search.results', compact('results', 'query'));
    }
}
```

**Penjelasan:**

* `input('q')` mengambil input pencarian dari URL (misalnya `/search?q=laravel`)
* `like "%{$query}%"` berarti mencari teks yang mengandung query, bukan yang eksak
* `orWhere` digunakan untuk mencari di lebih dari satu kolom
* Hasil pencarian dikirim ke view melalui variabel `results`

---

#### 3. View: resources/views/search/results.blade.php

```blade
<h1>Hasil Pencarian untuk: "{{ $query }}"</h1>

@if($results->count())
    <ul>
        @foreach($results as $post)
            <li>
                <strong>{{ $post->title }}</strong><br>
                {{ Str::limit($post->body, 100) }}
            </li>
        @endforeach
    </ul>
@else
    <p>Tidak ada hasil yang ditemukan untuk "{{ $query }}".</p>
@endif
```

---

#### 4. Form Pencarian

Form ini bisa diletakkan di layout atau halaman mana pun:

```blade
<form action="{{ route('posts.search') }}" method="GET">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari artikel...">
    <button type="submit">Cari</button>
</form>
```

---

#W# D. Implementasi Alternatif dengan Query Builder

Jika tidak ingin menggunakan Eloquent, bisa menggunakan `DB::table()`:

```php
use Illuminate\Support\Facades\DB;

$results = DB::table('posts')
            ->where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%")
            ->get();
```

---

#### E. Validasi Input (Opsional tapi Direkomendasikan)

Sebelum mengeksekusi query, ada baiknya validasi input agar tidak kosong:

```php
$request->validate([
    'q' => 'required|string|min:2'
]);
```

Letakkan validasi ini sebelum `$query = $request->input('q');`.

---

#### F. Rangkuman

| Komponen      | Fungsi Utama                                          |
| ------------- | ----------------------------------------------------- |
| Route         | Menyediakan endpoint pencarian                        |
| Controller    | Mengambil input, menjalankan query, dan kirim ke view |
| View          | Menampilkan hasil pencarian                           |
| Form          | Memberikan input untuk mencari                        |
| Eloquent ORM  | Mencari menggunakan `Model::where()`                  |
| Query Builder | Mencari menggunakan `DB::table()->where()`            |


## 4. Full-text Search (MySQL)

### Tujuan

Memahami dan mempraktikkan penggunaan **Full-text Search** di Laravel menggunakan MySQL untuk meningkatkan efisiensi dan akurasi pencarian teks. Dibandingkan pencarian dengan `LIKE`, full-text search jauh lebih cepat dan mampu memberikan hasil yang lebih relevan.

---

## A. Konsep Full-text Search

Full-text search adalah fitur pencarian teks penuh pada kolom tertentu di MySQL. Fitur ini bekerja lebih efisien daripada wildcard (`LIKE %text%`) karena menggunakan indeks dan algoritma pencocokan khusus.

Kelebihannya:

* Lebih cepat, terutama untuk data dalam jumlah besar
* Mendukung pencarian boolean (`+`, `-`, `*`, `"..."`, dll)
* Bisa mencari frasa atau kata yang mirip secara semantik (dengan konfigurasi tertentu)

## C. Langkah Praktik Full-text Search di Laravel

### 1. Menambahkan Index Full-text

Jika kamu sudah memiliki tabel `posts`, tambahkan full-text index:

```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('posts', function (Blueprint $table) {
    $table->fullText(['title', 'body']);
});
```

Tambahkan kode ini ke dalam migration baru dengan perintah:

```bash
php artisan make:migration add_fulltext_index_to_posts
```

Setelah itu jalankan:

```bash
php artisan migrate
```

### 2. Query Full-text Search Menggunakan Eloquent

```php
use App\Models\Post;
use Illuminate\Http\Request;

public function search(Request $request)
{
    $query = $request->input('q');

    $results = Post::whereRaw(
        "MATCH(title, body) AGAINST(? IN BOOLEAN MODE)",
        [$query]
    )->get();

    return view('search.results', compact('results', 'query'));
}
```

**Penjelasan**:

* `MATCH(title, body)` menyatakan kolom mana yang dicari
* `AGAINST(? IN BOOLEAN MODE)` adalah mode pencarian yang lebih fleksibel, mendukung operator seperti `+`, `-`, `*`, dll

### 3. Contoh Pencarian dengan Boolean Mode

| Query Input     | Artinya                                              |
| --------------- | ---------------------------------------------------- |
| `laravel`       | Cari kata “laravel” di kolom title/body              |
| `+php +laravel` | Hanya hasil yang mengandung **kedua** kata           |
| `laravel -vue`  | Hasil yang mengandung “laravel” **tapi tidak** “vue” |
| `"php laravel"` | Cari frasa **eksak** “php laravel”                   |

---

## D. View dan Form (Sama seperti pencarian biasa)

Form pencarian tetap sama:

```blade
<form action="{{ route('posts.search') }}" method="GET">
    <input type="text" name="q" placeholder="Cari..." value="{{ request('q') }}">
    <button type="submit">Cari</button>
</form>
```

Tampilan hasil juga bisa menggunakan view `resources/views/search/results.blade.php` seperti sebelumnya.

---

## E. Catatan Penting

* Jika full-text search tidak mengembalikan hasil, periksa apakah data sudah ada di database.
* MySQL default hanya akan mencocokkan kata minimal 3 karakter.
* Pastikan tidak menggunakan `LIKE` bersamaan dalam query full-text karena akan menonaktifkan optimasi.

---

## F. Perbandingan Like vs Full-text

| Metode    | Kecepatan | Akurasi | Mendukung Boolean | Cocok Untuk               |
| --------- | --------- | ------- | ----------------- | ------------------------- |
| `LIKE`    | Lambat    | Rendah  | Tidak             | Pencarian sederhana       |
| Full-text | Cepat     | Tinggi  | Ya                | Data besar, hasil relevan |

Berikut adalah materi lengkap mengenai:

---

## 5. Pagination (Segmentasi Hasil Pencarian)

### Tujuan

Menerapkan sistem **pembagian halaman (pagination)** pada hasil pencarian agar data tidak ditampilkan sekaligus. Pagination meningkatkan performa tampilan dan memberikan pengalaman pengguna yang lebih baik ketika data yang dicari berjumlah banyak.

---

## A. Konsep Pagination di Laravel

Laravel menyediakan metode `paginate()` dan `simplePaginate()` yang bekerja langsung dengan **Eloquent ORM** dan **Query Builder**. Saat digunakan, Laravel otomatis menangani logika offset dan limit SQL serta menyediakan navigasi halaman di sisi view.

---

## B. Implementasi dengan Eloquent ORM

### 1. Controller

Misalnya dalam `PostController.php`:

```php
use App\Models\Post;
use Illuminate\Http\Request;

public function search(Request $request)
{
    $query = $request->input('q');

    $results = Post::where('title', 'like', "%{$query}%")
                   ->orWhere('body', 'like', "%{$query}%")
                   ->paginate(10); // 10 hasil per halaman

    return view('search.results', compact('results', 'query'));
}
```

### Penjelasan:

* `paginate(10)` akan mengambil maksimal 10 data per halaman.
* Laravel akan otomatis membaca parameter `?page=2`, `?page=3`, dst.

---

## C. View Blade

### 2. Tampilkan Hasil dan Link Navigasi

Pada `resources/views/search/results.blade.php`:

```blade
<h1>Hasil Pencarian untuk: "{{ $query }}"</h1>

@if($results->count())
    <ul>
        @foreach($results as $post)
            <li>
                <strong>{{ $post->title }}</strong><br>
                {{ Str::limit($post->body, 100) }}
            </li>
        @endforeach
    </ul>

    <!-- Link navigasi halaman -->
    {{ $results->withQueryString()->links() }}
@else
    <p>Tidak ditemukan hasil untuk "{{ $query }}".</p>
@endif
```

### Penjelasan:

* `withQueryString()` memastikan parameter pencarian `q` tetap ada saat pindah halaman.
* `links()` menampilkan link halaman: 1, 2, 3, dst.
* Untuk gaya tampilan, Laravel menggunakan Bootstrap jika disiapkan (bisa diatur di `AppServiceProvider`).

---

## D. Query Builder dengan Pagination

Jika kamu menggunakan Query Builder biasa:

```php
use Illuminate\Support\Facades\DB;

$results = DB::table('posts')
             ->where('title', 'like', "%{$query}%")
             ->orWhere('body', 'like', "%{$query}%")
             ->paginate(10);
```

Sama seperti Eloquent, hasilnya bisa ditampilkan dengan `@foreach` dan `{{ $results->links() }}`.

---

## E. Menyesuaikan Tampilan Pagination

Laravel menyediakan beberapa opsi kustomisasi:

```php
{{ $results->onEachSide(2)->links() }}
```

Atau untuk menggunakan tampilan Bootstrap 5 (jika diaktifkan):

```php
use Illuminate\Pagination\Paginator;

public function boot()
{
    Paginator::useBootstrapFive();
}
```

Letakkan kode tersebut di dalam `AppServiceProvider::boot()`.

---

## F. Kesimpulan

| Fitur               | Deskripsi                                           |
| ------------------- | --------------------------------------------------- |
| `paginate(10)`      | Membatasi hasil per halaman                         |
| `links()`           | Menampilkan navigasi halaman                        |
| `withQueryString()` | Menjaga parameter URL saat pindah halaman           |
| `onEachSide(2)`     | Menampilkan 2 halaman di kiri dan kanan nomor aktif |


Baik, berikut adalah versi **materi ulang yang lebih lengkap dan lebih detail** untuk:

---

# 6. Performance Optimization

## Tujuan

Meningkatkan performa aplikasi Laravel dengan berbagai teknik optimasi yang dapat **mengurangi jumlah query ke database**, **menghemat penggunaan memori**, serta **mempercepat waktu eksekusi** dalam aplikasi skala kecil maupun besar.

---

## A. Eager Loading

### Apa Itu?

Eager loading adalah teknik untuk **mengambil data relasi model sekaligus dalam satu query besar**, daripada membiarkan Laravel mengambil data relasi satu per satu dalam loop (lazy loading). Teknik ini penting untuk mencegah **N+1 query problem**.

### Contoh Masalah: Lazy Loading

```php
$posts = Post::all(); // Mengambil semua post (1 query)

foreach ($posts as $post) {
    echo $post->category->name; // Setiap iterasi menghasilkan 1 query tambahan
}
```

Jika ada 100 post, maka akan terjadi **1 + 100 query**.

### Solusi: Eager Loading

```php
$posts = Post::with('category', 'author')->get();
```

* `with()` akan mengambil semua relasi `category` dan `author` dalam **1 query tambahan untuk tiap relasi**, bukan per item.
* Total query hanya 1 (post) + 1 (category) + 1 (author) = 3 query, meskipun ada ratusan post.

### Kapan Digunakan?

* Saat menampilkan data relasi dalam tampilan atau loop.
* Saat menggunakan banyak relasi yang saling terhubung.

---

## B. Cache dengan Cache Facade

### Apa Itu?

Cache menyimpan hasil pemrosesan atau query agar tidak perlu diulang dalam waktu tertentu. Laravel menyediakan **Cache Facade** untuk caching data ke memori, file, atau sistem lain seperti Redis.

### Contoh Penggunaan:

```php
use Illuminate\Support\Facades\Cache;

$posts = Cache::remember('posts.all', 60, function () {
    return Post::all(); // Akan disimpan dalam cache selama 60 menit
});
```

**Penjelasan:**

* `'posts.all'` adalah key untuk cache.
* `60` adalah waktu simpan (menit).
* Fungsi dalam callback hanya dijalankan jika cache belum ada atau sudah kadaluarsa.

### Manfaat:

* Mengurangi beban database jika data jarang berubah.
* Meningkatkan kecepatan respon terutama untuk halaman yang banyak dibuka (homepage, statistik, dsb).

### Kapan Digunakan?

* Untuk menyimpan hasil query besar.
* Untuk endpoint yang sering diakses tapi jarang berubah.

---

## C. Lazy Collection

### Apa Itu?

Lazy Collection adalah fitur Laravel untuk **memproses data satu per satu langsung dari database tanpa memuat semua data ke memori sekaligus**. Cocok untuk aplikasi yang menangani **data dalam jumlah besar** (ribuan atau jutaan baris).

### Contoh Penggunaan:

```php
Post::cursor()->each(function ($post) {
    // Proses setiap post satu per satu
    // Misalnya kirim email, ekspor ke file, dll
});
```

**Perbedaan:**

* `Post::all()` → akan mengambil semua data sekaligus dan menyimpannya dalam memori (berisiko overload).
* `Post::cursor()` → hanya mengambil satu baris pada satu waktu secara efisien (menggunakan generator di level PHP).

### Manfaat:

* Hemat memori dan lebih stabil pada proses besar.
* Cocok digunakan untuk command-line task atau background jobs.

---

## Ringkasan Teknik Optimasi

| Teknik              | Tujuan                                       | Waktu Tepat Digunakan                             |
| ------------------- | -------------------------------------------- | ------------------------------------------------- |
| **Eager Loading**   | Hindari query berulang (N+1 problem)         | Saat menampilkan relasi model di halaman          |
| **Caching**         | Simpan hasil query agar tidak dihitung ulang | Untuk data yang jarang berubah dan sering diakses |
| **Lazy Collection** | Proses data besar tanpa memory overload      | Untuk background task, ekspor, pemrosesan masif   |

Berikut adalah **daftar referensi lengkap** seluruh materi dalam format daftar link:

---

## Referensi

### Middleware

* [https://laravel.com/docs/12.x/middleware](https://laravel.com/docs/12.x/middleware)
* [https://laravel.com/docs/12.x/middleware#registering-middleware](https://laravel.com/docs/12.x/middleware#registering-middleware)
* [https://laravel.com/docs/12.x/middleware#assigning-middleware-to-routes](https://laravel.com/docs/12.x/middleware#assigning-middleware-to-routes)

### Authentication (Auth Facade & Sanctum)

* [https://laravel.com/docs/12.x/ui](https://laravel.com/docs/12.x/ui)
* [https://laravel.com/docs/12.x/authentication](https://laravel.com/docs/12.x/authentication)
* [https://laravel.com/docs/12.x/sanctum](https://laravel.com/docs/12.x/sanctum)

### Query Builder & ORM untuk Search

* [https://laravel.com/docs/12.x/queries](https://laravel.com/docs/12.x/queries)
* [https://laravel.com/docs/12.x/eloquent#retrieving-models](https://laravel.com/docs/12.x/eloquent#retrieving-models)
* [https://laravel.com/docs/12.x/queries#where-clauses](https://laravel.com/docs/12.x/queries#where-clauses)

### Full-text Search

* [https://laravel.com/docs/12.x/queries#raw-expressions](https://laravel.com/docs/12.x/queries#raw-expressions)
* [https://laravel.com/docs/12.x/migrations#index-methods](https://laravel.com/docs/12.x/migrations#index-methods)
* [https://dev.mysql.com/doc/refman/8.0/en/fulltext-search.html](https://dev.mysql.com/doc/refman/8.0/en/fulltext-search.html)

### Pagination

* [https://laravel.com/docs/12.x/pagination](https://laravel.com/docs/12.x/pagination)
* [https://laravel.com/docs/12.x/pagination#displaying-pagination-results](https://laravel.com/docs/12.x/pagination#displaying-pagination-results)

### Performance Optimization

* [https://laravel.com/docs/12.x/eloquent-relationships#eager-loading](https://laravel.com/docs/12.x/eloquent-relationships#eager-loading)
* [https://laravel.com/docs/12.x/cache](https://laravel.com/docs/12.x/cache)
* [https://laravel.com/docs/12.x/collections#lazy-collections](https://laravel.com/docs/12.x/collections#lazy-collections)
