<?php require_once 'views/components/header.php'; ?>

<h2 class="text-2xl font-bold text-gray-800 mb-6">Detail Pengguna</h2>
<div class="bg-white p-6 rounded shadow-md max-w-md">
    <p class="mb-2"><strong>Nama:</strong> <?= htmlspecialchars($user['name']); ?></p>
    <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
    <p class="mb-4"><strong>Dibuat:</strong> <?= $user['created_at']; ?></p>
    <a href="/" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
</div>

<?php require_once 'views/components/footer.php'; ?>