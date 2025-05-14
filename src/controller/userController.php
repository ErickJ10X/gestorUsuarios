<?php
require_once(__DIR__.'/../service/userService.php');
include_once(__DIR__.'/../util/session.php');

class UserController{
    private UserService $userService;
    private Session $session;
    
    public function __construct(){
        $this->userService = new UserService();
        $this->session = new Session();
    }

    public function login($username, $password): array|bool {
        if (empty($username) || empty($password)) {
            throw new Exception("El nombre de usuario y la contraseña son obligatorios");
        }

        $user = $this->userService->verifyLogin($username, $password);

        if (!$user) {
            throw new Exception("Nombre de usuario o contraseña incorrectos");
        }

        $_SESSION['id'] = $user['id'];
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        
        $this->session->set('id', $user['id']);
        $this->session->set('usuario', $user['usuario']);
        $this->session->set('rol', $user['rol']);
        
        return $user;
    }

    public function register($username, $password): void{
        if (empty($username) || empty($password)) {
            throw new Exception("El nombre de usuario y la contraseña son obligatorios");
        }

        if ($this->userService->verifyUserExist($username)) {
            throw new Exception("El nombre de usuario ya existe");
        }
        $this->userService->createUser($username, $password);
    }

    public function updateProfile($username, $password): void{
        if (empty($username)) {
            throw new Exception("El nombre de usuario es obligatorio");
        }

        $currentUsername = $_SESSION['usuario'];
        $userId = $_SESSION['id'];

        if ($username !== $currentUsername && $this->userService->verifyUserExist($username)) {
            throw new Exception("El nombre de usuario ya existe");
        }

        if ($username !== $currentUsername && !empty($password)) {
            $this->userService->updateUserWithPassword($userId, $username, $password);
        } else if ($username !== $currentUsername) {
            $this->userService->updateUserWithoutPassword($userId, $username);
        } else if (!empty($password)) {
            $this->userService->updatePasswordOnly($userId, $password);
        } else {
            throw new Exception("No se han realizado cambios");
        }
        
        if ($username !== $currentUsername) {
            $_SESSION['usuario'] = $username;
            $this->session->set('usuario', $username);
        }
    }
    
    public function deleteUser($username): void{
        if (empty($username)) {
            throw new Exception("El nombre de usuario es obligatorio");
        }
        
        if ($username === $this->session->get('usuario')) {
            throw new Exception("No puedes eliminar tu propio usuario");
        }
        
        if (!$this->userService->verifyUserExist($username)) {
            throw new Exception("El usuario no existe");
        }
        
        $this->userService->deleteUser($username);
    }
    
    public function getAllUsers(): false|PDOStatement{
        return $this->userService->getAllUsers();
    }
}
