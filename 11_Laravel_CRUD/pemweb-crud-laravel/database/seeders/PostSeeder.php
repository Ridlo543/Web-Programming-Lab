<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
        Post::create([
            'title' => 'cek Post',
            'content' => '3 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '4 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '5 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '6 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '7 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '8 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '9 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '10 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '11Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '12 Another post with different content.',
            'user_id' => $user->id,
        ]);
        Post::create([
            'title' => 'cek Post',
            'content' => '13 Another post with different content.',
            'user_id' => $user->id,
        ]);
    }
}
