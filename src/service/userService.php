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

    public function updateUserWithoutPassword($name,$surname,$username,$email,$userId): bool{
        try {
            $sql = "UPDATE usuarios SET nombre = ?,apellido = ?, usuario = ?, email = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$name,$surname,$username,$email,$userId]);
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    public function updateUserWithPassword($name,$surname,$username,$email,$password,$userId): bool{
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, usuario = ?, email=?, contrasena = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$name,$surname,$username,$email,$hashedPassword,$userId]);
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

    public function verifyEmailExist($email): false|PDOStatement{
        try {
            $sql = "SELECT email FROM usuarios WHERE email = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$email]);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error al verificar el email: " . $e->getMessage());
        }
    }

    public function createUser($name,$surname,$username,$email,$password): bool{
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nombre,apellido,usuario,email,contrasena) VALUES (?,?,?,?,?)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$name,$surname,$username,$email, $hashedPassword]);
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
            $sql = "SELECT nombre,apellido,usuario,email,rol FROM usuarios WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el usuario: " . $e->getMessage());
        }
    }
}
