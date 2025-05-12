<?php
session_start();
require_once('../includes/conexion.php');
require_once('../includes/funciones.php');
global $conexion;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php?error=motodo_invalido');
    exit();
}

$usuario = sanitizar($_POST['usuario'] ?? '');
$contrasena = sanitizar($_POST['contrasena'] ?? '');

if (empty($usuario) || empty($contrasena)) {
    header("Location: login.php?error=campos_vacios");
    exit();
}

try {

    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contrasena, $user['contrasena'])) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['rol'] = $user['rol'];

        header("Location: index.php");
    } else {
        header("Location: login.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error en la conexión a la base de datos: " . $e->getMessage());
    header("Location: login.php?error=conexion");
    exit();
}