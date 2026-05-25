<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    public function showLogin(): View
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.posts');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            session([
                'admin_logged_in' => true,
                'admin_email' => $user->email,
                'admin_name' => $user->name,
            ]);

            return redirect()->route('admin.posts');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => 'Đăng nhập không thành công. Email hoặc mật khẩu sai.']);
    }

    public function logout(): RedirectResponse
    {
        session()->forget(['admin_logged_in', 'admin_email', 'admin_name']);

        return redirect()->route('home');
    }

    public function adminIndex(): View
    {
        $this->ensureAdmin();

        $posts = Post::latest()->paginate(20);

        return view('admin.posts', compact('posts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        Post::create($data);

        return redirect()->route('admin.posts')->with('success', 'Bài viết đã được tạo.');
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $post->update($data);

        return redirect()->route('admin.posts')->with('success', 'Bài viết đã được cập nhật.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->ensureAdmin();

        $post->delete();

        return redirect()->route('admin.posts')->with('success', 'Bài viết đã được xóa.');
    }

    protected function ensureAdmin(): void
    {
        if (!session('admin_logged_in')) {
            redirect()->route('admin.login')->send();
        }
    }
}
