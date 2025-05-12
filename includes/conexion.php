<?php
require_once(__DIR__ . '/../config/database.php');

try {
    $databaseURI = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4";
    $pdoOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    $conexion = new PDO($databaseURI, DB_USER, DB_PASS, $pdoOptions);
} catch (PDOException $e) {
    die("Error en la conexion: ".$e->getMessage());
}