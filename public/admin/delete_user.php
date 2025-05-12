<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /gestorUsuarios/public/login.php");
    exit();
}

require_once(__DIR__ . '/../../includes/conexion.php');
global $conexion;

$id = $_GET['id'] ?? 0;

if ($id == $_SESSION['id']) {
    header("Location: /gestorUsuarios/public/admin/users.php?error=no_self_delete");
    exit();
}

try {
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id]);

    header("Location: /gestorUsuarios/public/admin/users.php?success=1");
    exit();
} catch (PDOException $e) {
    header("Location: /gestorUsuarios/public/admin/users.php?error=delete_failed&message=" . urlencode($e->getMessage()));
    exit();
}
