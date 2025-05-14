<?php
require_once(__DIR__ . '/../../config/database.php');

class UserService{
    private ?PDO $conexion;

    public function __construct(){
        $this->conexion = getConnection();
    }

    public function getAllUsers(): false|PDOStatement{
        try {
            $sql = "SELECT id, usuario, rol FROM usuarios ORDER BY id DESC";
            return $this->conexion->query($sql);
        } catch (PDOException $e) {
            throw new Exception("Error al cargar los usuarios: " . $e->getMessage());
        }
    }

    public function deleteUser($username): bool{
        try {
            $sql = "DELETE FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$username]);
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar el usuario: " . $e->getMessage());
        }
    }

    public function updateUser($currentUsername, $newUsername, $contrasena): bool{
        try {
            $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET usuario = ?, contrasena = ? WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$newUsername, $hashedPassword, $currentUsername]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    public function updateUserWithoutPassword($userId, $newUsername): bool{
        try {
            $sql = "UPDATE usuarios SET usuario = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$newUsername, $userId]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    public function updatePasswordOnly($userId, $password): bool{
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET contrasena = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$hashedPassword, $userId]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar la contraseña: " . $e->getMessage());
        }
    }

    public function updateUserWithPassword($userId, $newUsername, $password): bool{
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET usuario = ?, contrasena = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$newUsername, $hashedPassword, $userId]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    public function verifyUserExist($usuario): bool{
        try {
            $sql = "SELECT id FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error al verificar el usuario: " . $e->getMessage());
        }
    }

    public function createUser($usuario, $contrasena): bool{
        try {
            $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (usuario, contrasena, rol) VALUES (?, ?, 'usuario')";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$usuario, $hashedPassword]);
        } catch (PDOException $e) {
            throw new Exception("Error al crear el usuario: " . $e->getMessage());
        }
    }

    public function verifyLogin($usuario, $contrasena): false|array{
        try {
            $sql = "SELECT * FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($contrasena, $user['contrasena'])) {
                return [
                    'id' => $user['id'],
                    'usuario' => $user['usuario'],
                    'rol' => $user['rol']
                ];
            }
            return false;
        } catch (PDOException $e) {
            throw new Exception("Error al verificar el login: " . $e->getMessage());
        }
    }
    
    public function getUserByUsername($username): array|false {
        try {
            $sql = "SELECT * FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el usuario: " . $e->getMessage());
        }
    }
}

