<?php
class Post
{
    public ?int $id;
    public string $title;
    public string $content;
    public string $created_at;

    public function __construct(?int $id, string $title, string $content, string $created_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
    }

    public static function fromRow(array $row): self
    {
        return new self((int)$row['id'], $row['title'], $row['content'], $row['created_at']);
    }
}
