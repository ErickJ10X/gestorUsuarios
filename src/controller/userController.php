<?php
require_once(__DIR__.'/../service/userService.php');
include_once(__DIR__.'/../util/session.php');

class userController{
    private UserService $userService;
    private session $session;
    public function __construct(){
        $this->userService = new UserService();
        $this->session = new Session();
    }

    public function login($username, $password): void {
        if (empty($username) || empty($password)) {
            throw new Exception("El nombre de usuario y la contraseña son obligatorios");
        }

        if (!$this->userService->verifyUserExist($username)) {
            throw new Exception("El nombre de usuario no existe");
        }

        $user = $this->userService->verifyLogin($username, $password);

        if (!$user) {
            throw new Exception("La contraseña es incorrecta");
        }

        $this->session->set('username', $user['usuario']);
        $this->session->set('rol', $user['rol']);
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
        if (empty($username) || empty($password)) {
            throw new Exception("El nombre de usuario y la contraseña son obligatorios");
        }

        if ($this->userService->verifyUserExist($username)) {
            throw new Exception("El nombre de usuario ya existe");
        }

        $this->userService->updateUser($username, $password);
        $this->session->set('username', $username);
    }
    public function deleteUser($username): void{
        $this->userService->deleteUser($username);
    }
    public function getAllUsers(): false|PDOStatement{
        return $this->userService->getAllUsers();
    }
}

