@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container">
    @if (!$post)
        <div class="card">
            <p>Không tìm thấy bài viết.</p>
            <div class="actions">
                <a class="button secondary" href="{{ route('home') }}">Về trang chủ</a>
            </div>
        </div>
    @else
        <article class="card">
            <p class="subtitle">Bài viết chi tiết</p>
            <h1>{{ $post->title }}</h1>
            <div style="white-space: pre-wrap; margin-top: 16px; color: #334155; line-height: 1.8;">
                {!! nl2br(e($post->content)) !!}
            </div>
            <div class="actions">
                <a class="button secondary" href="{{ route('home') }}">Về trang chủ</a>
            </div>
        </article>
    @endif
</div>
@endsection
