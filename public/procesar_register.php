<?php
session_start();
require_once('../includes/conexion.php');
global $conexion;

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (empty($usuario) || empty($contrasena)) {
    header("Location: register.php?error=campos_vacios");
    exit();
}

try {
    $sql = "SELECT id FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario]);

    if ($stmt->fetch()) {
        header("Location: register.php?error=usuario_existente");
        exit();
    }

    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$usuario, $contrasena_hash]);

    $_SESSION['success'] = "¡Registro exitoso! Ahora puedes iniciar sesión.";
    header("Location: login.php");
    exit();

} catch (PDOException $e) {
    header("Location: register.php?error=error_bd");
    exit();
}
