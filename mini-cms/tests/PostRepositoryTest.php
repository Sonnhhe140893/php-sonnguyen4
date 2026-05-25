<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Repositories/PostRepository.php';

class PostRepositoryTest extends TestCase
{
    public function testCreateAndFind()
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, content TEXT, created_at TEXT)');

        $repo = new PostRepository($pdo);
        $id = $repo->create('Hello', 'Content');
        $this->assertIsInt($id);
        $post = $repo->find($id);
        $this->assertNotNull($post);
        $this->assertEquals('Hello', $post['title']);
    }
}
