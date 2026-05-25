<?php
class User
{
    public ?int $id;
    public string $username;
    public string $password;

    public function __construct(?int $id, string $username, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function fromRow(array $row): self
    {
        return new self((int)$row['id'], $row['username'], $row['password']);
    }
}
