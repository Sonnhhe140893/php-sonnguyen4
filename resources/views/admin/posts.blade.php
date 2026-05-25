@extends('layouts.app')

@section('title', 'Admin - Quản lý bài viết')

@section('content')
<div class="container">
    <header class="page-header">
        <div>
            <p class="subtitle">Bảng điều khiển</p>
            <h1 class="site-title">Quản lý bài viết</h1>
            <p class="notice">Đang đăng nhập dưới tên {{ session('admin_name') ?? session('admin_email') }}</p>
        </div>
        <div>
            <a class="button secondary" href="{{ route('home') }}">Xem site</a>
            <form method="post" action="{{ route('admin.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="button secondary">Đăng xuất</button>
            </form>
        </div>
    </header>

    @if (session('success'))
        <div class="alert" style="background:#d1fae5; color:#065f46; border-color:#a7f3d0;">
            {{ session('success') }}
        </div>
    @endif

    <section class="card form-card">
        <h2>Tạo bài mới</h2>
        <form method="post" class="form-grid" action="{{ route('admin.posts.store') }}">
            @csrf
            <label>
                Tiêu đề
                <input type="text" name="title" placeholder="Tiêu đề bài viết" value="{{ old('title') }}">
            </label>
            <label>
                Nội dung
                <textarea name="content" placeholder="Nội dung bài viết">{{ old('content') }}</textarea>
            </label>
            <div class="actions">
                <button type="submit">Tạo mới</button>
            </div>
        </form>
    </section>

    <section>
        <h2>Danh sách bài viết</h2>
        @forelse ($posts as $post)
            <div class="card">
                <form method="post" class="form-grid" action="{{ route('admin.posts.update', $post) }}">
                    @csrf
                    @method('PUT')
                    <label>
                        Tiêu đề
                        <input type="text" name="title" value="{{ old('title', $post->title) }}">
                    </label>
                    <label>
                        Nội dung
                        <textarea name="content">{{ old('content', $post->content) }}</textarea>
                    </label>
                    <div class="actions">
                        <button type="submit">Lưu</button>
                    </div>
                </form>
                <form method="post" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Xóa bài viết này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button secondary">Xóa</button>
                </form>
            </div>
        @empty
            <div class="card">
                <p>Chưa có bài viết nào.</p>
            </div>
        @endforelse
    </section>

    <div class="actions">
        {{ $posts->links() }}
    </div>
</div>
@endsection
