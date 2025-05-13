<?php require_once 'views/components/header.php'; ?>

<h2>Daftar Pengguna</h2>
<a href="create" class="btn">Tambah Pengguna</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id']; ?></td>
                <td><?= htmlspecialchars($user['name']); ?></td>
                <td><?= htmlspecialchars($user['email']); ?></td>
                <td>
                    <a href="show/<?= $user['id']; ?>">Lihat</a> |
                    <a href="edit/<?= $user['id']; ?>">Edit</a> |
                    <a href="delete/<?= $user['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require_once 'views/components/footer.php'; ?>