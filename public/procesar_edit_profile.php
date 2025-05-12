<?php
session_start();
require_once('../includes/auth.php');
require_once('../includes/conexion.php');
global $conn;

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

try {
    $stmt_check = $conn->verifyUserExist($usuario, $_SESSION['id'] ?? 0);

    if ($stmt_check->fetch()) {
        header("Location: edit_profile.php?error=usuario_existente");
        exit();
    }

    if (!empty($contrasena)) {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt= $conn->updatePassword($_SESSION['id'], $contrasena_hash);
    } else {
        $stmt = $conn->updateUsername($_SESSION['id'], $usuario);
    }

    $_SESSION['usuario'] = $usuario;
    header("Location: edit_profile.php?success=1");
    exit();

} catch (PDOException $e) {
    header("Location: edit_profile.php?error=bd");
    exit();
}
