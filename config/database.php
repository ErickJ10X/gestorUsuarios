<?php
function getConnection() {
    $host = 'localhost';
    $dbname = 'gestor_de_usuarios';
    $username = 'root';
    $password = '';
    
    try {
        $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
