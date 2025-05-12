<?php
session_start();
require_once('../includes/conexion.php');
global $conn;

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if (empty($usuario) || empty($contrasena)) {
    header("Location: register.php?error=campos_vacios");
    exit();
}

try {
    $stmt = $conn->verifyUsernameExist($usuario);

    if ($stmt->fetch()) {
        header("Location: register.php?error=usuario_existente");
        exit();
    }

    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $stmt = $conn->createUser($usuario, $contrasena_hash);

    $_SESSION['success'] = "¡Registro exitoso! Ahora puedes iniciar sesión.";
    header("Location: login.php");
    exit();

} catch (PDOException $e) {
    header("Location: register.php?error=error_bd");
    exit();
}
