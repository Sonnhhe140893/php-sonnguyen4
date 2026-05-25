<?php
class PostRepository
{
    public PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function paginate(int $page = 1, int $perPage = 5): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare('SELECT * FROM posts ORDER BY id DESC LIMIT ? OFFSET ?');
        $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = (int)$this->pdo->query('SELECT COUNT(*) FROM posts')->fetchColumn();
        return ['data' => $data, 'total' => $total, 'page' => $page, 'perPage' => $perPage];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posts WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(string $title, string $content): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO posts (title, content, created_at) VALUES (?, ?, ?)');
        $now = (new DateTime())->format(DateTime::ATOM);
        $stmt->execute([$title, $content, $now]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, string $title, string $content): bool
    {
        $stmt = $this->pdo->prepare('UPDATE posts SET title = ?, content = ? WHERE id = ?');
        return $stmt->execute([$title, $content, $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
