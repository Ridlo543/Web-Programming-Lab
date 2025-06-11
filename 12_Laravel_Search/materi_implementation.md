# BAB 12: Implementasi Autentikasi dan Fungsi Pencarian di Laravel 12

**Tujuan Proyek**:

- Mengimplementasikan autentikasi (login, register, logout) dengan Laravel UI.
- Menambahkan middleware untuk melindungi rute.
- Membuat tabel `posts` untuk pencarian.
- Mengintegrasikan fungsi pencarian dengan Eloquent ORM dan full-text search.
- Menambahkan pagination pada hasil pencarian.
- Mengoptimalkan performa dengan eager loading dan caching.

**Prasyarat**:

- Laravel 12 terinstal.
- Database (,MySQL) terkonfigurasi di `.env`.
- Kode sebelumnya (User model, UserController, views) sudah ada.
- **Bootstrap** dan **jQuery** sudah terintegrasi via CDN.

## Langkah-Langkah Implementasi

### Langkah 1: Instal Laravel UI untuk Autentikasi

**Penjelasan**:  
Laravel UI menyediakan scaffolding untuk autentikasi (login, register, logout) dengan Bootstrap. Kita akan menginstalnya dan mengatur autentikasi.

1. **Instal Laravel UI**:

```bash
composer require laravel/ui
```

- **Penjelasan**: Menginstal paket Laravel UI untuk scaffolding autentikasi.

2. **Buat Scaffolding Autentikasi dengan Bootstrap**:

```bash
php artisan ui bootstrap --auth
```

- **Penjelasan**: Menghasilkan view autentikasi (login, register) dan konfigurasi di `resources/views/auth`.

3. **Instal Dependensi Frontend**:

```bash
npm install && npm run build
```

   - **Penjelasan**: Menginstal dan mengompilasi aset Bootstrap untuk autentikasi.

4. **Jalankan Migrasi untuk Tabel Autentikasi**:
```bash
php artisan migrate
```
   - **Penjelasan**: Memastikan tabel `users` (dari kode sebelumnya) sudah ada di database.

- Pastikan `APP_URL` di `.env` diatur ke `http://localhost:8000`.

### Langkah 2: Perbarui Layout untuk Menampilkan Navigasi Autentikasi

**Penjelasan**:  
Perbarui `app.blade.php` untuk menambahkan navigasi yang menunjukkan status login dan tautan logout/register/login.

1. **Edit `resources/views/layouts/app.blade.php`**:

```html
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <!-- DataTables CSS -->
    <link
        href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"
        rel="stylesheet"
    />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">My App</a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('posts.index') }}">Posts</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link btn btn-link">
                    Logout
                </button>
                </form>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
            @endauth
            </ul>
        </div>
        </div>
    </nav>
    <div class="container mt-4">@yield('content')</div>
    @stack('scripts')
    </body>
</html>
```

- **Penjelasan**:
    - Menambahkan navbar Bootstrap dengan tautan dinamis berdasarkan status autentikasi (`@auth`/`@else`).
    - Menggunakan `@csrf` untuk form logout.
    - Menambahkan meta tag CSRF untuk permintaan AJAX.

**Best Practice**:

- Gunakan direktif Blade `@auth` dan `@guest` untuk mengelola navigasi berdasarkan status login.
- Simpan meta tag CSRF di layout utama untuk mendukung AJAX.

### Langkah 3: Tambahkan Middleware untuk Melindungi Rute

**Penjelasan**:  
Middleware `auth` digunakan untuk membatasi akses ke rute tertentu hanya untuk pengguna yang sudah login.

1. **Perbarui `routes/web.php`**:

```php
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::resource('users', UserController::class)->middleware('auth');
```

- **Penjelasan**:
    - Rute `users` dilindungi dengan middleware `auth`, sehingga hanya pengguna yang login dapat mengaksesnya.
    - Rute `/` diberi nama `home` untuk halaman utama.
    - Rute `posts.index` akan ditambahkan nanti untuk pencarian posting.

**Best Practice**:

- Terapkan middleware `auth` pada rute sensitif seperti manajemen pengguna.
- Gunakan nama rute (`name()`) untuk memudahkan referensi.

### Langkah 4: Buat Tabel dan Model untuk Posts

**Penjelasan**:  
Kita akan membuat tabel `posts` untuk menyimpan posting yang akan dicari, lengkap dengan relasi ke tabel `users`.

1. **Buat Model dan Migrasi untuk Post**:

```bash
php artisan make:model Post -m
```

2. **Edit File Migrasi** (`database/migrations/xxxx_create_posts_table.php`):

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

- **Penjelasan**:
    - Tabel `posts` memiliki kolom `title`, `content`, dan `user_id` sebagai foreign key.
    - `onDelete('cascade')` memastikan posting dihapus jika pengguna terkait dihapus.

3. **Jalankan Migrasi**:

```bash
php artisan migrate
```

4. **Buat Model Post** (`app/Models/Post.php`):

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

5. **Perbarui Model User untuk Relasi** (`app/Models/User.php`):

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'phone_number', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

- **Penjelasan**:
    - Menambahkan relasi `hasMany` di `User` untuk mengaitkan pengguna dengan banyak posting.
    - Relasi `belongsTo` di `Post` menghubungkan posting ke pengguna.

**Best Practice**:

- Gunakan `$fillable` untuk mencegah mass assignment vulnerability.
- Definisikan relasi di model untuk memudahkan query.

### Langkah 5: Buat Controller untuk Posts

**Penjelasan**:  
Buat `PostController` untuk menangani pencarian posting dengan Eloquent ORM dan pagination.

1. **Buat Controller**:

```bash
php artisan make:controller PostController
```

2. **Edit `app/Http/Controllers/PostController.php`**:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $posts = Cache::remember('posts_search_' . md5($search), 60, function () use ($search) {
            return Post::query()
                ->when($search, function ($query, $search) {
                    return $query->where('title', 'like', "%{$search}%")
                                ->orWhere('content', 'like', "%{$search}%");
                })
                ->with('user') // Eager loading
                ->latest()
                ->paginate(10);
        });

        return view('posts.index', compact('posts', 'search'));
    }
}
```

- **Penjelasan**:
    - Menggunakan `Cache::remember` untuk menyimpan hasil pencarian selama 60 detik.
    - `when($search, ...)` menerapkan pencarian hanya jika parameter `search` ada.
    - `with('user')` melakukan eager loading untuk mengurangi query N+1.
    - `paginate(10)` membatasi hasil menjadi 10 per halaman.
    - `latest()` mengurutkan berdasarkan `created_at` (terbaru).

**Best Practice**:

- Gunakan eager loading (`with`) untuk mengoptimalkan performa.
- Cache hasil query untuk mengurangi beban database.

### Langkah 6: Buat View untuk Pencarian Posts

**Penjelasan**:  
Buat view untuk menampilkan daftar posting dengan form pencarian dan pagination.

1. **Buat `resources/views/posts/index.blade.php`**:

```html
@extends('layouts.app') @section('title', 'Posts') @section('content')
<h1>Posts</h1>

<!-- Form Pencarian -->
<form method="GET" action="{{ route('posts.index') }}" class="mb-3">
    <div class="input-group">
    <input
        type="text"
        name="search"
        class="form-control"
        placeholder="Search posts..."
        value="{{ $search ?? '' }}"
    />
    <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<!-- Tabel Posts -->
<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Author</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($posts as $post)
    <tr>
        <td>{{ $post->id }}</td>
        <td>{{ $post->title }}</td>
        <td>{{ Str::limit($post->content, 50) }}</td>
        <td>{{ $post->user->name }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="4">No posts found.</td>
    </tr>
    @endforelse
    </tbody>
</table>

<!-- Pagination -->
{{ $posts->appends(['search' => $search])->links('pagination::bootstrap-5')
}} @endsection
```

- **Penjelasan**:
    - Form pencarian mengirim parameter `search` via GET.
    - `Str::limit` membatasi panjang konten untuk tampilan.
    - `$posts->appends(['search' => $search])` mempertahankan parameter pencarian di pagination.
    - Menggunakan komponen pagination Bootstrap 5.

**Best Practice**:

- Gunakan `Str::limit` untuk mencegah tampilan konten yang terlalu panjang.
- Gunakan `appends` untuk mempertahankan parameter query di pagination.

### Langkah 7: Tambahkan Full-Text Search

**Penjelasan**:  
Untuk pencarian yang lebih akurat, tambahkan indeks full-text pada kolom `title` dan `content` (khususnya untuk MySQL).

1. **Buat Migrasi untuk Indeks Full-Text**:

```bash
php artisan make:migration add_fulltext_index_to_posts
```

2. **Edit Migrasi** (`database/migrations/xxxx_add_fulltext_index_to_posts.php`):

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->fullText(['title', 'content']);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropFullText(['title', 'content']);
        });
    }
};
```

3. **Jalankan Migrasi**:

```bash
php artisan migrate
```

4. **Perbarui `PostController` untuk Full-Text Search**:

```php
public function index(Request $request)
{
    $search = $request->query('search');

    $posts = Cache::remember('posts_search_' . md5($search), 60, function () use ($search) {
        return Post::query()
            ->when($search, function ($query, $search) {
                return $query->whereFullText(['title', 'content'], $search)
                            ->orWhere('title', 'like', "%{$search}%")
                            ->orWhere('content', 'like', "%{$search}%");
            })
            ->with('user')
            ->latest()
            ->paginate(10);
    });

    return view('posts.index', compact('posts', 'search'));
}
```

- **Penjelasan**:
    - `whereFullText` menggunakan indeks full-text untuk pencarian lebih akurat.
    - Fallback ke `like` untuk kompatibilitas jika full-text tidak didukung.

**Best Practice**:

- Gunakan `whereFullText` hanya pada database yang mendukung (MySQL/MariaDB).
- Kombinasikan dengan `like` untuk fleksibilitas.

### Langkah 8: Tambahkan Data Dummy untuk Pengujian

**Penjelasan**:  
Buat seeder untuk mengisi tabel `posts` dengan data dummy.

1. **Buat Seeder**:

```bash
php artisan make:seeder PostSeeder
```

2. **Edit `database/seeders/PostSeeder.php`**:

```php
<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone_number' => '081234567890',
                'password' => Hash::make('password'),
            ]
        );

        Post::create([
            'title' => 'First Post',
            'content' => 'This is the content of the first post.',
            'user_id' => $user->id,
        ]);

        Post::create([
            'title' => 'Second Post',
            'content' => 'Another post with different content.',
            'user_id' => $user->id,
        ]);
    }
}
```

3. **Jalankan Seeder**:

```bash
php artisan db:seed --class=PostSeeder
```

- **Penjelasan**:
    - `firstOrCreate` memastikan pengguna ada sebelum membuat posting.
    - Menambahkan dua posting untuk pengujian pencarian.

**Best Practice**:

- Gunakan `firstOrCreate` untuk menghindari duplikasi data.
- Hash password di seeder untuk keamanan.

### Langkah 9: Optimasi Performa

**Penjelasan**:  
Optimalkan performa dengan eager loading dan caching.

1. **Eager Loading**:

- Sudah diterapkan dengan `with('user')` di `PostController` untuk mengurangi query N+1.

2. **Caching**:

- Sudah menggunakan `Cache::remember` untuk menyimpan hasil pencarian.

3. **Indeks Database**:

- Indeks full-text sudah ditambahkan pada `title` dan `content`.
- Tambahkan indeks pada `user_id` jika diperlukan:

```bash
php artisan make:migration add_index_to_posts_user_id
```

- Edit migrasi:

```php
Schema::table('posts', function (Blueprint $table) {
    $table->index('user_id');
});
```

- Jalankan:
```bash
php artisan migrate
```

**Best Practice**:

- Gunakan eager loading untuk relasi yang sering diakses.
- Terapkan caching untuk query berulang, tetapi atur waktu kadaluarsa yang wajar (misalnya, 60 detik).

### Langkah 10: Uji Aplikasi

**Penjelasan**:  
Uji semua fitur untuk memastikan autentikasi dan pencarian berfungsi.

1. **Jalankan Server**:

   ```bash
   php artisan serve
   ```

2. **Uji Autentikasi**:

   - Buka `http://localhost:8000/register` dan buat akun baru.
   - Login di `http://localhost:8000/login`.
   - Akses `http://localhost:8000/users` (harus login).
   - Logout melalui tautan di navbar.

3. **Uji Pencarian**:

   - Buka `http://localhost:8000/posts`.
   - Masukkan kata kunci (misalnya, "first") di form pencarian.
   - Pastikan hasil muncul dan pagination berfungsi.
   - Uji tanpa kata kunci untuk melihat semua posting.


## Sumber

- [Dokumentasi Laravel 12](https://laravel.com/docs/12.x)
- [Laravel UI](https://github.com/laravel/ui)
- [Yajra DataTables](https://yajrabox.com/docs/laravel-datatables)

Materi ini memberikan panduan langkah demi langkah untuk mengimplementasikan autentikasi dan pencarian di Laravel 12, dengan fokus pada kode yang dapat diedit ulang dan performa optimal. Mahasiswa dapat mengembangkan aplikasi ini lebih lanjut dengan menambahkan fitur seperti CRUD untuk posting.
