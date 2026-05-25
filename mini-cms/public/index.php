<?php
require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/Models/Post.php';
require_once __DIR__ . '/../src/Repositories/PostRepository.php';

$postRepo = new PostRepository($pdo);

$route = $_GET['route'] ?? 'home';

if ($route === 'home') {
    $page = max(1, (int)($_GET['page'] ?? 1));
    $result = $postRepo->paginate($page, 5);
    $posts = $result['data'];
    require __DIR__ . '/../views/home.php';
    exit;
}

if ($route === 'post') {
    $id = (int)($_GET['id'] ?? 0);
    $post = $postRepo->find($id);
    require __DIR__ . '/../views/post.php';
    exit;
}

// Admin: login + CRUD
if ($route === 'admin/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf'] ?? null;
        if (!verify_csrf($token)) {
            $error = 'Invalid CSRF token';
        } else {
            $u = $_POST['username'] ?? '';
            $p = $_POST['password'] ?? '';
            if (login_user($u, $p)) {
                header('Location: ?route=admin/posts');
                exit;
            }
            $error = 'Login failed';
        }
    }
    require __DIR__ . '/../views/admin/login.php';
    exit;
}

if ($route === 'admin/posts') {
    require_login();
    // Handle actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf'] ?? null;
        if (!verify_csrf($token)) {
            $msg = 'Invalid CSRF token';
        } else {
            if (isset($_POST['create'])) {
                $title = trim($_POST['title'] ?? '');
                $content = trim($_POST['content'] ?? '');
                if ($title) $postRepo->create($title, $content);
            }
            if (isset($_POST['update'])) {
                $id = (int)($_POST['id'] ?? 0);
                $postRepo->update($id, $_POST['title'] ?? '', $_POST['content'] ?? '');
            }
            if (isset($_POST['delete'])) {
                $id = (int)($_POST['id'] ?? 0);
                $postRepo->delete($id);
            }
        }
        header('Location: ?route=admin/posts');
        exit;
    }

    $page = max(1, (int)($_GET['page'] ?? 1));
    $result = $postRepo->paginate($page, 20);
    $posts = $result['data'];
    require __DIR__ . '/../views/admin/posts.php';
    exit;
}

// Unknown route
http_response_code(404);
echo 'Not Found';
