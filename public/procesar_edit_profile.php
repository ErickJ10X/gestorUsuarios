<?php
session_start();
require_once('../includes/auth.php');
require_once('../includes/conexion.php');
global $conexion;

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

try {
    $sql_check = "SELECT id FROM usuarios WHERE usuario = ? AND id != ?";
    $stmt_check = $conexion->prepare($sql_check);
    $stmt_check->execute([$usuario, $_SESSION['id']]);

    if ($stmt_check->fetch()) {
        header("Location: edit_profile.php?error=usuario_existente");
        exit();
    }

    if (!empty($contrasena)) {
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET usuario = ?, contrasena = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuario, $contrasena_hash, $_SESSION['id']]);
    } else {
        $sql = "UPDATE usuarios SET usuario = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$usuario, $_SESSION['id']]);
    }

    $_SESSION['usuario'] = $usuario;
    header("Location: edit_profile.php?success=1");
    exit();

} catch (PDOException $e) {
    header("Location: edit_profile.php?error=bd");
    exit();
}
