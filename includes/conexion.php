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
class conexion
{
    private $conexion;

    public function __construct(){
        $databaseURI = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        $conexion = new PDO($databaseURI, DB_USER, DB_PASS, $pdoOptions);
        $this->conexion = new PDO($databaseURI, DB_USER, DB_PASS, $pdoOptions);
    }

    public function getAllUser(){
        $sql = "SELECT id, usuario, rol FROM usuarios ORDER BY id DESC";
        return $this->conexion->query($sql);
    }

    public function deleteUser($id){
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getUserById($id){
        $sql = "SELECT id, usuario, rol FROM usuarios WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$id]);
        return $stmt;
    }

    public function verifyUsernameExist($usuario){
        $sql = "SELECT id FROM usuarios WHERE usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario]);
        return $stmt;
    }
    public function updatePassword($id, $contrasena){
        $sql = "UPDATE usuarios SET contrasena = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$contrasena, $id]);
    }

    public function updateUsername($id, $usuario){
        $sql = "UPDATE usuarios SET usuario = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$usuario, $id]);
    }

    public function verifyUserExist($usuario,$id){
        $sql = "SELECT id FROM usuarios WHERE usuario = ? AND id != ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario, $id]);
        return $stmt;
    }

    public function createUser($usuario, $contrasena){
        $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        return $stmt->execute([$usuario, $contrasena]);
    }

    public function login($usuario, $contrasena){
        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            return $user;
        }
        return false;
    }
}
$conn = new conexion();