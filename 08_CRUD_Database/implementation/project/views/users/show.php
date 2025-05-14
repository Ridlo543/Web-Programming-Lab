<?php require_once 'views/components/header.php'; ?>

<h2>Detail Pengguna</h2>
<p><strong>Nama:</strong> <?= htmlspecialchars($user['name']); ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
<p><strong>Dibuat:</strong> <?= $user['created_at']; ?></p>
<a href="/">Kembali</a>

<?php require_once 'views/components/footer.php'; ?>