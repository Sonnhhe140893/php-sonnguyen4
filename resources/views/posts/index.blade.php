@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('title', 'Mini CMS')

@section('content')
<div class="container">
    <header class="page-header">
        <div>
            <p class="subtitle">Mini CMS</p>
            <h1 class="site-title">Bài viết mới nhất</h1>
        </div>
        <a class="button secondary" href="{{ route('admin.login') }}">Đăng nhập Admin</a>
    </header>

    @if ($posts->isEmpty())
        <div class="card">
            <p>Chưa có bài viết nào. Hãy đăng nhập để tạo bài viết mới.</p>
        </div>
    @endif

    @foreach ($posts as $post)
        <article class="card">
            <h2><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
            <p>{{ Str::limit($post->content, 200, '...') }}</p>
            <div class="actions">
                <a class="button" href="{{ route('posts.show', $post) }}">Xem chi tiết</a>
            </div>
        </article>
    @endforeach

    <div class="actions">
        {{ $posts->links() }}
    </div>

    <footer>
       Sơnnguyen4 - {{ date('Y') }}
    </footer>
</div>
@endsection
