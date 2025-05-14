<?php require_once 'views/components/header.php'; ?>

<h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Pengguna</h2>
<form action="/pemweb_crud/update/<?= $user['id']; ?>" method="POST" class="space-y-4 max-w-md">
    <div>
        <label class="block text-gray-700 mb-1">Nama:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-gray-700 mb-1">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Perbarui</button>
</form>

<?php require_once 'views/components/footer.php'; ?>