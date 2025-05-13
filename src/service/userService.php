<?php
require_once(__DIR__ . '/../../config/database.php');

class userService{
    private ?PDO $conexion;

    public function __construct(){
        $this->conexion = getConnection();
    }

    public function getAllUsers(): false|PDOStatement{
        try {
            $sql = "SELECT id, usuario, rol FROM usuarios ORDER BY id DESC";
            return $this->conexion->query($sql);
        } catch (PDOException $e) {
            die("Error al cargar los usuarios: " . $e->getMessage());;
        }
    }

    public function deleteUser($username): bool{
        try {
            $sql = "DELETE FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$username]);;
        } catch (PDOException $e) {
            die("Error al eliminar el usuario: " . $e->getMessage());
        }
    }

    public function updateUser($usuario, $contrasena): bool{
        try {
            $sql = "SELECT id FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario]);
            $user = $stmt->fetch();
            if ($user) {
                $sql = "UPDATE usuarios SET usuario = ?, contrasena = ? WHERE id = ?";
                $stmt = $this->conexion->prepare($sql);
                return $stmt->execute([$usuario, $contrasena, $user['id']]);
            }
            return false;
        } catch (PDOException $e) {
            die("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    public function verifyUserExist($usuario): bool{
        try {
            $sql = "SELECT id FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario]);
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            die("Error al verificar el usuario: " . $e->getMessage());
        }

    }

    public function createUser($usuario, $contrasena): bool{
        try {
            $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
            return $stmt->execute([$usuario, $contrasena]);
        } catch (PDOException $e) {
            die("Error al crear el usuario: " . $e->getMessage());
        }
    }

    public function verifyLogin($usuario, $contrasena): false|array{
        try {
            $sql = "SELECT * FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario]);
            $user = $stmt->fetch();

            if ($user && password_verify($contrasena, $user['contrasena'])) {
                return [
                    'usuario' => $user['usuario'],
                    'rol' => $user['rol']
                ];
            }
            return false;
        } catch (PDOException $e) {
            die("Error al verificar el usuario: " . $e->getMessage());
        }
    }
}