<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Mendapatkan semua user
    public function all()
    {
        $statement = $this->pdo->query("SELECT * FROM users");
        return $statement->fetchAll();
    }

    // Mendapatkan user berdasarkan ID
    public function find($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $statement->execute([$id]);
        return $statement->fetch();
    }

    // Membuat user baru
    public function create($data)
    {
        $statement = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        return $statement->execute([$data['name'], $data['email']]);
    }

    // Memperbarui user
    public function update($id, $data)
    {
        $statement = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $statement->execute([$data['name'], $data['email'], $id]);
    }

    // Menghapus user
    public function delete($id)
    {
        $statement = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $statement->execute([$id]);
    }
}
