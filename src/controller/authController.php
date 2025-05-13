<?php
include_once(__DIR__ . '/../util/session.php');
require_once(__DIR__ . '/userController.php');
class AuthController {
    private Session $session;
    private UserController $userController;

    public function __construct(){
        $this->session = new Session();
        $this->userController = new UserController();
    }

    public function login(): void {
        if ($this->session->isAuthenticated()) {
            header("Location: " . __DIR__ . "/../../public/index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['usuario'] ?? '';
            $password = $_POST['contrasena'] ?? '';

            try {
                $user = $this->userController->login($username, $password);

                if ($user) {
                    $this->session->set('user', $user);
                    header("Location: " . __DIR__ . "/../../public/index.php");
                    exit;
                } else {
                    echo "<script>alert('Usuario o contraseña incorrectos');</script>";
                }
            } catch (Exception $e) {
                echo "<script>alert('" . $e->getMessage() . "');</script>";
            }
        }
    }
    public function logout(): void {
        if (!$this->session->isAuthenticated()) {
            header("Location: http://localhost/gestorUsuarios/src/view/auth/login.php");
            exit;
        }
    }

    public function register(): void{
        if ($this->session->isAuthenticated()) {
            header("Location: ".__DIR__."/../../public/index.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                $this->userController->register($username, $password);
                header("Location: ".__DIR__."/../view/auth/login.php");
                exit;
            } catch (Exception $e) {
                echo "<script>alert('".$e->getMessage()."');</script>";
            }
        }
    }

    public function updateProfile(): void{
        if (!$this->session->isAuthenticated()) {
            header("Location: ".__DIR__."/../../public/index.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            try {
                $this->userController->updateProfile($username, $password);
            } catch (Exception $e) {
                echo "<script>alert('".$e->getMessage()."');</script>";
            }
        }
    }

    public function viewProfile(): void{
        if (!$this->session->isAuthenticated()) {
            header("Location: ".__DIR__."/../../public/index.php");
            exit;
        }
    }
    public function viewAdminDashboard(): PDOStatement
    {
        if (!$this->session->isAuthenticated()) {
            header("Location: ".__DIR__."/../../public/index.php");
            exit;
        }
        if (!$this->session->isAdmin()) {
            header("Location: ".__DIR__."/../../public/index.php");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';

            try {
                $this->userController->deleteUser($username);
                return $this->userController->getAllUsers();
            } catch (Exception $e) {
                echo "<script>alert('".$e->getMessage()."');</script>";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $users = $this->userController->getAllUsers();
            if ($users) {
                return $users;
            } else {
                echo "<script>alert('No hay usuarios registrados');</script>";
            }
        }
        return $this->userController->getAllUsers();
    }
}
$authController = new AuthController();