<?php require_once 'views/components/header.php'; ?>
<h2>Tambah Pengguna</h2>
<form action="store" method="POST">
    <label>Nama:</label>
    <input type="text" name="name" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <button type="submit">Simpan</button>
</form>
<?php require_once 'views/components/footer.php'; ?>