<?php
declare(strict_types=1);
// Minimal config + DB init + simple auth + CSRF helpers
session_start();

$baseDir = dirname(__DIR__);
$env = [];
$envFile = $baseDir . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2) + [null, null]);
        if ($k) $env[$k] = $v;
    }
}

$dbPath = $env['DB_PATH'] ?? ($baseDir . '/data/database.sqlite');
if (!file_exists(dirname($dbPath))) {
    mkdir(dirname($dbPath), 0777, true);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create tables if not exists
$pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL
);
SQL
);

$pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS posts (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  content TEXT NOT NULL,
  created_at TEXT NOT NULL
);
SQL
);

// Seed default admin if none
$stmt = $pdo->query('SELECT COUNT(*) FROM users');
$count = (int)$stmt->fetchColumn();
if ($count === 0) {
    $password = password_hash('password', PASSWORD_DEFAULT);
    $ins = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $ins->execute(['admin', $password]);
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    return !empty($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function login_user(string $username, string $password): bool
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user'] = $row['username'];
        return true;
    }
    return false;
}

function is_logged_in(): bool
{
    return !empty($_SESSION['user']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: ?route=admin/login');
        exit;
    }
}
