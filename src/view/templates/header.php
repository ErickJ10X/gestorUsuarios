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
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/gestorUsuarios/public/assets/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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
                        <a href="/gestorUsuarios/src/view/user/profile.php" class="header__menu-link">Perfil</a>
                    </li>
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                        <li class="header__menu-item">
                            <a href="/gestorUsuarios/src/view/admin/dashboard.php" class="header__menu-link header__menu-link--admin">Admin Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li class="header__menu-item">
                        <a href="/gestorUsuarios/src/view/auth/logout.php" class="header__menu-link header__menu-link--logout">Salir</a>
                    </li>
                <?php else: ?>
                    <li class="header__menu-item">
                        <a href="/gestorUsuarios/src/view/auth/login.php" class="header__menu-link header__menu-link--login">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<main class="main">
