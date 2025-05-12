<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Usuarios</title>
</head>
<body>
<header class="bg-primary text-white p-3">
    <div class="container">
        <h1>Gestor de Usuarios</h1>
        <nav>
            <a href="/gestorUsuarios/public/index.php">Inicio</a>
            <?php if (isset($_SESSION['usuario'])): ?>
                <a href="/gestorUsuarios/public/profile.php">Perfil</a>
                <?php if ($_SESSION['rol'] === 'admin'): ?>
                    <a href="/gestorUsuarios/public/admin/users.php">Admin</a>
                <?php endif; ?>
                <a href="/gestorUsuarios/public/logout.php">Salir</a>
            <?php else: ?>
                <a href="/gestorUsuarios/public/login.php">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container mt-4">