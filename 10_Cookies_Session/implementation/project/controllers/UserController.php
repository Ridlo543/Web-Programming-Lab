<?php

require_once 'models/User.php';

class UserController
{
    private $user;

    public function __construct($pdo)
    {
        $this->user = new User($pdo);
    }

    // GET
    // Menampilkan daftar user
    public function index()
    {
        $users = $this->user->all();
        require_once 'views/users/index.php';
    }

    // GET
    // Menampilkan form tambah user
    public function create()
    {
        require_once 'views/users/create.php';
    }

    // POST
    // Menyimpan user baru
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'email' => htmlspecialchars($_POST['email'])
            ];

            if ($this->user->create($data)) {
                header('Location: /pemweb_crud');
            } else {
                echo "Gagal menyimpan data.";
            }
        }
    }

    // GET
    // Menampilkan form edit user
    public function edit($id)
    {
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/edit.php';
        } else {
            echo "user tidak ditemukan.";
        }
    }

    // POST
    // Memperbarui user
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'email' => htmlspecialchars($_POST['email'])
            ];

            if ($this->user->update($id, $data)) {
                header('Location: /pemweb_crud');
            } else {
                echo "Gagal memperbarui data.";
            }
        }
    }

    // POST
    // Menghapus user
    public function delete($id)
    {
        if ($this->user->delete($id)) {
            header('Location: /pemweb_crud');
        } else {
            echo "Gagal menghapus data.";
        }
    }

    // GET
    // Menampilkan detail user
    public function show($id)
    {
        $user = $this->user->find($id);
        if ($user) {
            require_once 'views/users/show.php';
        } else {
            echo "user tidak ditemukan.";
        }
    }
}
