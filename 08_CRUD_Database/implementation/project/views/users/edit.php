<?php require_once 'views/components/header.php'; ?>
<h2>Edit Pengguna</h2>
<form action="update/<?= $user['id']; ?>" method="POST">
    <label>Nama:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
    <button type="submit">Perbarui</button>
</form>
<?php require_once 'views/components/footer.php'; ?>