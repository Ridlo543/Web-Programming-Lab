<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Sederhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-4 py-8">
        <nav class="mb-6">
            <ul class="flex space-x-4">
                <li><a href="/pemweb_crud" class="text-blue-500 hover:underline">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/pemweb_crud/logout" class="text-red-500 hover:underline">Logout (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="/pemweb_crud/login" class="text-blue-500 hover:underline">Login</a></li>
                    <li><a href="/pemweb_crud/register" class="text-blue-500 hover:underline">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>