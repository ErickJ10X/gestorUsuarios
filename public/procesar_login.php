<?php
session_start();
require_once('../src/service/authController.php');
require_once('../includes/funciones.php');
$auth = new AuthService();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php?error=motodo_invalido');
    exit();
}

$usuario = sanitizar($_POST['usuario'] ?? '');
$contrasena = sanitizar($_POST['contrasena'] ?? '');

try {
    if ($auth->login($usuario, $contrasena)) {
        header("Location: index.php");
    } else {
        header("Location: login.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error en la conexión a la base de datos: " . $e->getMessage());
    header("Location: login.php?error=userService");
    exit();
}