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
    <link rel="stylesheet" href="/gestorUsuarios/public/assets/style.css">
</head>
<body>
<header class="header">
    <div class="header__container container">
        <h1 class="header__title">Gestor de Usuarios</h1>

        <nav class="header__nav">
            <ul class="header__menu">
                <li class="header__menu-item">
                    <a href="/gestorUsuarios/public/index.php" class="header__menu-link">Inicio</a>
                </li>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="header__menu-item">
                        <a href="/gestorUsuarios/public/profile.php" class="header__menu-link">Perfil</a>
                    </li>
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <li class="header__menu-item">
                            <a href="/gestorUsuarios/public/admin/dashboard.php" class="header__menu-link header__menu-link--admin">Admin Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li class="header__menu-item">
                        <a href="/gestorUsuarios/public/logout.php" class="header__menu-link header__menu-link--logout">Salir</a>
                    </li>
                <?php else: ?>
                    <li class="header__menu-item">
                        <a href="/gestorUsuarios/public/login.php" class="header__menu-link header__menu-link--login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main class="main">