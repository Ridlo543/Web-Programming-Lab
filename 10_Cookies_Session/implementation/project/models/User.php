<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $statement = $this->pdo->query("SELECT * FROM users");
        return $statement->fetchAll();
    }

    public function find($id) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function findByEmail($email) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $statement->execute([$email]);
        return $statement->fetch();
    }

    public function findByToken($token) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE remember_token = ?");
        $statement->execute([$token]);
        return $statement->fetch();
    }

    public function create($data) {
        $statement = $this->pdo->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        return $statement->execute([
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?";
        $params = [$data['name'], $data['email'], $data['phone'] ?? null];

        if (!empty($data['password'])) {
            $sql .= ", password = ?";
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = ?";
        $params[] = $id;

        $statement = $this->pdo->prepare($sql);
        return $statement->execute($params);
    }

    public function updateToken($id, $token) {
        $statement = $this->pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
        return $statement->execute([$token, $id]);
    }

    public function delete($id) {
        $statement = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $statement->execute([$id]);
    }
}