<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /gestorUsuarios/public/login.php");
    exit();
}

require_once(__DIR__ . '/../../includes/conexion.php');
global $conn;

$id = $_GET['id'] ?? 0;

if ($id == $_SESSION['id']) {
    header("Location: /gestorUsuarios/public/admin/dashboard.php?error=no_self_delete");
    exit();
}

try {
    $conn->deleteUser($id);
    header("Location: /gestorUsuarios/public/admin/dashboard.php?success=1");
    exit();
} catch (PDOException $e) {
    header("Location: /gestorUsuarios/public/admin/dashboard.php?error=delete_failed&message=" . urlencode($e->getMessage()));
    exit();
}
