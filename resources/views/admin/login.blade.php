@extends('layouts.app')

@section('title', 'Đăng nhập Admin')

@section('content')
<div class="container">
    <div class="card form-card">
        <p class="subtitle">Quản trị viên</p>
        <h1 class="site-title">Đăng nhập</h1>

        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="post" class="form-grid" action="{{ route('admin.login.submit') }}">
            @csrf
            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" autocomplete="username">
            </label>
            <label>
                Password
                <input type="password" name="password" autocomplete="current-password">
            </label>
            <div class="actions">
                <button type="submit">Đăng nhập</button>
                <a class="button secondary" href="{{ route('home') }}">Về trang chủ</a>
            </div>
        </form>

        <p class="notice">Sử dụng tài khoản admin để quản lý bài viết.</p>
    </div>
</div>
@endsection
