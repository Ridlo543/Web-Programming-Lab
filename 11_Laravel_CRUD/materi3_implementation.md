# Implementasi CRUD dengan Laravel 12 Menggunakan Yajra DataTables, Bootstrap, dan jQuery

## Prasyarat

- **Laravel 12** sudah terinstal (lihat Bab 11.2 untuk instalasi).
- **PHP ≥ 8.2**, **Composer**, dan database (misalnya, MySQL).
- **Bootstrap 5** untuk styling dan **jQuery** untuk interaksi frontend.
- **Yajra DataTables** untuk tabel interaktif.
- **Pengetahuan dasar** tentang Laravel (MVC, Blade, Eloquent).

## Langkah-Langkah Implementasi CRUD

### Langkah 1: Perbarui Migrasi untuk Menambahkan Kolom `phone_number`

1. **Buat Migrasi Baru**:

```bash
php artisan make:migration add_phone_number_to_users_table
```

2. **Edit File Migrasi** (misalnya, `database/migrations/xxxx_add_phone_number_to_users_table.php`):

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });
    }
};
```

3. **Jalankan Migrasi**:

```bash
php artisan migrate
```

- **Penjelasan**: Perintah ini menambahkan kolom `phone_number` ke tabel `users`. Kolom ini bersifat `nullable` agar tidak wajib diisi.

**Best Practicenya**:

- Gunakan migrasi terpisah untuk perubahan skema agar mudah dilacak.
- Tambahkan `nullable()` untuk kolom opsional guna menghindari error pada data yang sudah ada.

### Langkah 2: Instal dan Konfigurasi Yajra DataTables

**Penjelasan**:  
Yajra DataTables digunakan untuk membuat tabel interaktif dengan fitur seperti pencarian, pengurutan, dan paginasi. Kita akan mengintegrasikannya dengan Laravel.

1. **Instal Yajra DataTables**:

```bash
composer require yajra/laravel-datatables-oracle:"^12.0"
```

atau

```bash
composer require yajra/laravel-datatables:"^12.0"
```

- **Penjelasan**: Menginstal paket Yajra DataTables versi terbaru yang kompatibel dengan Laravel 12.

2. **Tambahkan Service Provider** (opsional, biasanya otomatis):
   Edit `config/app.php` dan pastikan provider berikut ada di bagian `providers`:

```php
Yajra\DataTables\DataTablesServiceProvider::class,
```

3. **Publikasikan Konfigurasi** (opsional):

```bash
php artisan vendor:publish --provider="Yajra\DataTables\DataTablesServiceProvider"
```

- **Penjelasan**: Menyalin file konfigurasi DataTables ke `config/datatables.php` (opsional, gunakan default jika tidak perlu kustomisasi).

### Langkah 3: Siapkan Dependensi Frontend (Bootstrap dan jQuery)

**Penjelasan**:  
Bootstrap digunakan untuk styling, dan jQuery digunakan oleh DataTables untuk interaksi AJAX.

1. **Instal Bootstrap dan jQuery via CDN**:
   Edit file layout utama (`resources/views/layouts/app.blade.php`) untuk menyertakan CDN:

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <div class="container mt-4">@yield('content')</div>
    @stack('scripts')
  </body>
</html>
```

2. **Kompilasi Aset (Opsional)**:
   Jika menggunakan Vite untuk aset lokal:

```bash
npm install bootstrap@5.3.3 jquery
npm run build
```

- **Penjelasan**: Menginstal Bootstrap dan jQuery sebagai dependensi lokal (opsional jika menggunakan CDN).

### Langkah 4: Buat Model dan Konfigurasi

**Penjelasan**:  
Model `User` sudah ada di Laravel (default untuk autentikasi). Kita perlu memperbarui model untuk mendukung kolom tambahan `phone_number`.

1. **Edit Model User** (`app/Models/User.php`):

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
```

- **Penjelasan**:
  - `$fillable`: Menentukan kolom yang dapat diisi secara massal (mass assignment).
  - `$hidden`: Menyembunyikan kolom sensitif seperti `password` dari output JSON.

**Best Practice**:

- Selalu tentukan `$fillable` untuk mencegah mass assignment vulnerability.
- Gunakan `$hidden` untuk data sensitif agar tidak terekspos di API atau view.

### Langkah 5: Buat Controller untuk CRUD

**Penjelasan**:  
Buat `UserController` untuk menangani operasi CRUD: menampilkan daftar (index), membuat (create/store), memperbarui (edit/update), dan menghapus (destroy).

1. **Buat Controller**:

```bash
php artisan make:controller UserController
```

2. **Edit Controller** (`app/Http/Controllers/UserController.php`):

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar pengguna dengan DataTables
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'phone_number']);
            return DataTables::of($users)
                ->addColumn('action', function ($user) {
                    return '
                        <a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-primary">Edit</a>
                        <form action="' . route('users.destroy', $user->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users.index');
    }

    // Menampilkan form tambah pengguna
    public function create()
    {
        return view('users.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Menampilkan form edit pengguna
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Memperbarui pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
```

- **Penjelasan**:
  - `index`: Menangani permintaan AJAX untuk DataTables dan mengembalikan view `users.index`.
  - `create`: Menampilkan form untuk menambah pengguna.
  - `store`: Menyimpan pengguna baru dengan validasi dan hashing password.
  - `edit`: Menampilkan form edit untuk pengguna tertentu.
  - `update`: Memperbarui data pengguna dengan validasi.
  - `destroy`: Menghapus pengguna.
  - `Hash::make`: Mengenkripsi password untuk keamanan.
  - `DataTables::of`: Mengatur data untuk tabel interaktif dengan kolom aksi (Edit/Delete).

**Best Practice**:

- Gunakan **route model binding** (`User $user`) untuk mengambil model secara otomatis.
- Selalu hash password dengan `Hash::make`.
- Gunakan `validate` untuk memastikan input valid sebelum diproses.

### Langkah 6: Buat Rute untuk CRUD

**Penjelasan**:  
Definisikan rute untuk semua operasi CRUD di `routes/web.php`.

1. **Edit File Rute** (`routes/web.php`):

```php
<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);
```

atau

```php
<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
```

- **Penjelasan**:
  - `Route::resource`: Membuat rute RESTful untuk `index`, `create`, `store`, `edit`, `update`, `destroy`.
  - Rute yang dihasilkan:
    - GET `/users` → `index`
    - GET `/users/create` → `create`
    - POST `/users` → `store`
    - GET `/users/{user}/edit` → `edit`
    - PUT/PATCH `/users/{user}` → `update`
    - DELETE `/users/{user}` → `destroy`

**Best Practice**:

- Gunakan `Route::resource` untuk rute RESTful agar kode lebih ringkas.
- Beri nama rute secara otomatis dengan `resource` untuk konsistensi.

### Langkah 7: Buat View untuk CRUD

**Penjelasan**:  
Buat view untuk menampilkan daftar pengguna, form tambah, dan form edit menggunakan Blade, Bootstrap, dan DataTables.

1. **Buat View Index** (`resources/views/users/index.blade.php`):

```html
@extends('layouts.app') @section('title', 'Users') @section('content')
<div class="d-flex justify-content-between mb-3">
  <h1>Users</h1>
  <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table id="users-table" class="table table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone Number</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

@push('scripts')
<script>
  $(document).ready(function() {
      $('#users-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route('users.index') }}',
          columns: [
              { data: 'id', name: 'id' },
              { data: 'name', name: 'name' },
              { data: 'email', name: 'email' },
              { data: 'phone_number', name: 'phone_number' },
              { data: 'action', name: 'action', orderable: false, searchable: false }
          ]
      });
  });
</script>
@endpush @endsection
```

- **Penjelasan**:
  - `@extends('layouts.app')`: Menggunakan layout utama.
  - `DataTable`: Menginisialisasi DataTables dengan AJAX untuk mengambil data dari rute `users.index`.
  - `columns`: Menentukan kolom yang ditampilkan, termasuk kolom `action` untuk tombol Edit/Delete.
  - `@push('scripts')`: Menyisipkan script jQuery ke layout.

2. **Buat View Create** (`resources/views/users/create.blade.php`):

```html
@extends('layouts.app') @section('title', 'Add User') @section('content')
<h1>Add User</h1>

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<form action="{{ route('users.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input
      type="text"
      name="name"
      id="name"
      class="form-control"
      value="{{ old('name') }}"
    />
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input
      type="email"
      name="email"
      id="email"
      class="form-control"
      value="{{ old('email') }}"
    />
  </div>
  <div class="mb-3">
    <label for="phone_number" class="form-label">Phone Number</label>
    <input
      type="text"
      name="phone_number"
      id="phone_number"
      class="form-control"
      value="{{ old('phone_number') }}"
    />
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" id="password" class="form-control" />
  </div>
  <div class="mb-3">
    <label for="password_confirmation" class="form-label"
      >Confirm Password</label
    >
    <input
      type="password"
      name="password_confirmation"
      id="password_confirmation"
      class="form-control"
    />
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
```

- **Penjelasan**:
  - `@csrf`: Menambahkan token CSRF untuk keamanan form.
  - `{{ old('name') }}`: Menampilkan input sebelumnya jika validasi gagal.
  - Bootstrap classes (`form-control`, `mb-3`) untuk styling.

3. **Buat View Edit** (`resources/views/users/edit.blade.php`):

```html
@extends('layouts.app') @section('title', 'Edit User') @section('content')
<h1>Edit User</h1>

@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<form action="{{ route('users.update', $user->id) }}" method="POST">
  @csrf @method('PUT')
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input
      type="text"
      name="name"
      id="name"
      class="form-control"
      value="{{ old('name', $user->name) }}"
    />
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input
      type="email"
      name="email"
      id="email"
      class="form-control"
      value="{{ old('email', $user->email) }}"
    />
  </div>
  <div class="mb-3">
    <label for="phone_number" class="form-label">Phone Number</label>
    <input
      type="text"
      name="phone_number"
      id="phone_number"
      class="form-control"
      value="{{ old('phone_number', $user->phone_number) }}"
    />
  </div>
  <div class="mb-3">
    <label for="password" class="form-label"
      >Password (leave blank to keep unchanged)</label
    >
    <input type="password" name="password" id="password" class="form-control" />
  </div>
  <div class="mb-3">
    <label for="password_confirmation" class="form-label"
      >Confirm Password</label
    >
    <input
      type="password"
      name="password_confirmation"
      id="password_confirmation"
      class="form-control"
    />
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
  <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
```

- **Penjelasan**:
  - `@method('PUT')`: Menentukan metode HTTP untuk update (karena form HTML hanya mendukung GET/POST).
  - `old('name', $user->name)`: Menampilkan nilai lama atau nilai dari model jika validasi gagal.

**Best Practice**:

- Gunakan `@csrf` dan `@method` untuk keamanan dan RESTful routing.
- Tampilkan pesan error dengan `$errors->any()` untuk UX yang lebih baik.
- Gunakan `old()` untuk mempertahankan input pengguna saat validasi gagal.

### Langkah 8: Tambahkan Seeder untuk Data Dummy

**Penjelasan**:  
Tambahkan data dummy untuk menguji CRUD.

1. **Buat Seeder**:

```bash
php artisan make:seeder UserSeeder
```

2. **Edit Seeder** (`database/seeders/UserSeeder.php`):

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Ridlo',
            'email' => 'ridlo@example.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Salsa',
            'email' => 'salsa@example.com',
            'phone_number' => '089876543210',
            'password' => Hash::make('password'),
        ]);
    }
}

```

3. **Jalankan Seeder**:

```bash
php artisan db:seed --class=UserSeeder
```

- **Penjelasan**: Menambahkan dua pengguna ke tabel `users`.

**Best Practice**:

- Gunakan `Hash::make` untuk mengenkripsi password di seeder.
- Tambahkan data dummy yang realistis untuk pengujian.

### Langkah 9: Uji Aplikasi

1. **Jalankan Server**:

```bash
php artisan serve
```

2. **Akses Aplikasi**:

- Buka `http://localhost:8000/users` untuk melihat daftar pengguna.
- Klik "Add User" untuk membuat pengguna baru.
- Uji fitur edit dan delete melalui tombol di tabel.

3. **Uji Validasi**:

- Coba kirim form tanpa mengisi `name` atau `email` untuk melihat pesan error.
- Coba masukkan email yang sudah ada untuk menguji aturan `unique`.

<!-- ## Tugas Praktikum

1. Implementasikan CRUD untuk tabel `users` sesuai langkah di atas.
2. Tambahkan kolom `role` (admin/user) ke tabel `users` dan tampilkan di DataTables.
3. Buat validasi tambahan untuk `phone_number` (misalnya, hanya angka dan panjang tertentu).
4. Tambahkan fitur pencarian dan filter berdasarkan `role` di DataTables. -->

## Sumber

- [Dokumentasi Laravel 12](https://laravel.com/docs/12.x)
- [Yajra DataTables](https://yajrabox.com/docs/laravel-datatables)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3)
