## 7 Eloquent ORM & Model Relationships

**Penjelasan**:  
Eloquent ORM memungkinkan interaksi dengan database menggunakan sintaks PHP yang ekspresif. Setiap model mewakili tabel, dan relasi seperti **one-to-many** atau **many-to-many** dapat didefinisikan.

**Jenis Relasi**:

- **One-to-One**: Satu baris berhubungan dengan satu baris lain.
- **One-to-Many**: Satu baris berhubungan dengan banyak baris.
- **Many-to-Many**: Banyak baris berhubungan dengan banyak baris melalui tabel pivot.

**Contoh Praktik** (Relasi One-to-Many: User memiliki banyak Post):

1. **Buat Model dan Migrasi untuk User**:

```bash
php artisan make:model User -m
```

2. **Edit Migrasi User** (`database/migrations/xxxx_create_users_table.php`):

```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamps();
});
```

3. **Tambahkan Kolom `user_id` di Migrasi Post**:

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
```

4. **Jalankan Migrasi**:

```bash
php artisan migrate
```

5. **Definisikan Relasi di Model**:

- `app/Models/User.php`:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

- `app/Models/Post.php`:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

6. **Perbarui Controller** (`PostController.php`):

```php
public function index()
{
    $posts = Post::with('user')->get();
    return view('posts.index', compact('posts'));
}
```

7. **Perbarui View** (`posts/index.blade.php`):

```html
@foreach ($posts as $post)
<li>{{ $post->title }} by {{ $post->user->name }}</li>
@endforeach
```

**Penjelasan Kode**:

- `foreignId('user_id')->constrained()`: Menambahkan kolom foreign key yang merujuk ke tabel `users`.
- `hasMany`: Mendefinisikan relasi satu-ke-banyak di model `User`.
- `belongsTo`: Mendefinisikan relasi balik di model `Post`.
- `Post::with('user')`: Eager loading untuk mengurangi query database.

## 11.8 Migration dan Seeding

**Penjelasan**:

- **Migration**: Mengelola skema database (membuat/mengubah tabel).
- **Seeding**: Mengisi database dengan data awal untuk pengujian.

**Contoh Praktik**:

1. **Buat Seeder**:

```bash
php artisan make:seeder PostSeeder
```

2. **Edit Seeder** (`database/seeders/PostSeeder.php`):

```php
namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        Post::create([
            'title' => 'First Post',
            'content' => 'This is the first post.',
            'user_id' => $user->id,
        ]);
    }
}
```

3. **Jalankan Seeder**:

```bash
php artisan db:seed --class=PostSeeder
```

    - Mengisi tabel `users` dan `posts` dengan data dummy.

**Penjelasan Kode**:

- `make:seeder`: Membuat kelas seeder baru.
- `User::create` dan `Post::create`: Menyisipkan data ke tabel.
- `db:seed`: Menjalankan seeder untuk mengisi database.

## 11.9 Form Request Validation

**Penjelasan**:  
Laravel menyediakan **Form Request** untuk validasi data formulir sebelum diproses oleh Controller. Ini memisahkan logika validasi dari Controller untuk kode yang lebih bersih.

**Contoh Praktik**:

1. **Buat Form Request**:

```bash
php artisan make:request StorePostRequest
```

2. **Edit Form Request** (`app/Http/Requests/StorePostRequest.php`):

```php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Izinkan semua pengguna
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'content.required' => 'Konten wajib diisi.',
        ];
    }
}
```

3. **Gunakan di Controller** (`PostController.php`):

```php
public function store(StorePostRequest $request)
{
    Post::create([
        'title' => $request->title,
        'content' => $request->content,
        'user_id' => 1, // Ganti dengan ID pengguna yang sesuai
    ]);
    return redirect()->route('posts.index')->with('success', 'Post created!');
}
```

4. **Perbarui View** (`posts/index.blade.php`):

```html
@if (session('success'))
<div>{{ session('success') }}</div>
@endif @if ($errors->any())
<ul>
  @foreach ($errors->all() as $error)
  <li>{{ $error }}</li>
  @endforeach
</ul>
@endif
<form action="{{ route('posts.store') }}" method="POST">
  @csrf
  <input type="text" name="title" value="{{ old('title') }}" />
  <textarea name="content">{{ old('content') }}</textarea>
  <button type="submit">Add Post</button>
</form>
```

**Penjelasan Kode**:

- `make:request`: Membuat kelas validasi khusus.
- `rules()`: Menentukan aturan validasi (misalnya, `required`, `max:255`).
- `messages()`: Menyesuaikan pesan error.
- `{{ old('title') }}`: Menampilkan input sebelumnya jika validasi gagal.
- `@if ($errors->any())`: Menampilkan pesan error jika validasi gagal.

**Sumber**:

- [Dokumentasi Laravel 12](https://laravel.com/docs/12.x)
- [Tutorial Laravel](https://santrikoding.com)
