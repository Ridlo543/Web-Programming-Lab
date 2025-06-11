@extends('layouts.app') @section('title', 'Posts') @section('content')
<h1>Posts</h1>

<!-- Form Pencarian -->
<form method="GET" action="{{ route('posts.index') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search posts..."
            value="{{ $search ?? '' }}" />
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
{{ $posts->appends(['search' => $search])->links('pagination::bootstrap-5') }} @endsection
