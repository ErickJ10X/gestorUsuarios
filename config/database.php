<?php
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'gestor_de_usuarios';

function getConnection(){
    try {
        $databaseURI = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        return new PDO($databaseURI, DB_USER, DB_PASS, $pdoOptions);
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}