<?php
require_once(__DIR__ . '/../../config/database.php');

class UserService{
    private ?PDO $conexion;
    private const MAX_USERS_RESULT = 1000; // Constante para limitar resultados

    public function __construct(){
        $this->conexion = getConnection();
    }

    public function getAllUsers(): false|PDOStatement{
        try {
            $sql = "SELECT id, usuario, rol FROM usuarios ORDER BY id DESC LIMIT " . self::MAX_USERS_RESULT;
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt;
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

    public function updateUser($name, $surname, $username, $email, $password, $userId): bool{
        try {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, usuario = ?, email = ?, contrasena = ? WHERE id = ?";
                $stmt = $this->conexion->prepare($sql);
                return $stmt->execute([$name, $surname, $username, $email, $hashedPassword, $userId]);
            } else {
                $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, usuario = ?, email = ? WHERE id = ?";
                $stmt = $this->conexion->prepare($sql);
                return $stmt->execute([$name, $surname, $username, $email, $userId]);
            }
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    public function verifyUserAndEmailExist($username, $email, $excludeUserId = null): array {
        try {
            $sql = "SELECT usuario, email FROM usuarios WHERE (usuario = ? OR email = ?)";
            $params = [$username, $email];
            
            if ($excludeUserId !== null) {
                $sql .= " AND id != ?";
                $params[] = $excludeUserId;
            }
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            
            $result = [
                'usernameExists' => false,
                'emailExists' => false
            ];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row['usuario'] === $username) {
                    $result['usernameExists'] = true;
                }
                if ($row['email'] === $email) {
                    $result['emailExists'] = true;
                }
            }
            
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Error al verificar usuario y email: " . $e->getMessage());
        }
    }

    public function verifyUserExist($usuario): bool{
        try {
            $sql = "SELECT COUNT(id) AS count FROM usuarios WHERE usuario = ? LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            throw new Exception("Error al verificar el usuario: " . $e->getMessage());
        }
    }

    public function verifyEmailExist($email): false|PDOStatement{
        try {
            $sql = "SELECT email FROM usuarios WHERE email = ? LIMIT 1";
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
            $sql = "SELECT id, usuario, contrasena, rol FROM usuarios WHERE usuario = ? LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$usuario]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($contrasena, $user['contrasena'])) {
                if (password_needs_rehash($user['contrasena'], PASSWORD_DEFAULT)) {
                    $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
                    $sql = "UPDATE usuarios SET contrasena = ? WHERE id = ?";
                    $stmt = $this->conexion->prepare($sql);
                    $stmt->execute([$hashedPassword, $user['id']]);
                }
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
            $sql = "SELECT nombre, apellido, usuario, email, rol FROM usuarios WHERE usuario = ? LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el usuario: " . $e->getMessage());
        }
    }

    public function getUserById($userId): array|false {
        try {
            $sql = "SELECT nombre, apellido, usuario, email, rol FROM usuarios WHERE id = ? LIMIT 1";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener el usuario por ID: " . $e->getMessage());
        }
    }

    public function registerAccessAttempt($ip,$username,$success): bool {
        try {
            $sql = "INSERT INTO access_logs (ip,username,result) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([$ip, $username, $success]);
        } catch (PDOException $e) {
            throw new Exception("Error al registrar el intento de acceso: " . $e->getMessage());
            return false;
        }
    }
}

