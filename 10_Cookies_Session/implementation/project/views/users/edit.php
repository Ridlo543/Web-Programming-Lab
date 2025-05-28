<?php
require_once 'views/components/header.php';
require_once 'models/Auth.php';
$auth = new Auth($pdo);
?>

<h2 class="text-2xl font-bold mb-6">Edit Pengguna</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/pemweb_crud/update/<?= $user['id']; ?>" method="POST" class="space-y-4 max-w-md">
    <input type="hidden" name="csrf_token" value="<?= $auth->generateCsrfToken(); ?>">
    <div>
        <label class="block mb-1">Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? $user['name']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? $user['email']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block mb-1">Nomor Telepon:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($old['phone'] ?? $user['phone']); ?>" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: 081234567890">
    </div>
    <div>
        <label class="block mb-1">Kata Sandi Baru (kosongkan jika tidak diubah):</label>
        <input type="password" name="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbarui</button>
</form>

<?php require_once 'views/components/footer.php'; ?>