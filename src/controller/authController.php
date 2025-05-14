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
        if (isset($_SESSION['usuario'])) {
            header("Location: /gestorUsuarios/public/index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['usuario'] ?? '';
            $password = $_POST['contrasena'] ?? '';

            try {
                $user = $this->userController->login($username, $password);

                if ($user) {
                    header("Location: /gestorUsuarios/public/index.php");
                    exit;
                }
            } catch (Exception $e) {
                header("Location: /gestorUsuarios/src/view/auth/login.php?error=1&message=" . urlencode($e->getMessage()));
                exit;
            }
        }
    }
    
    public function logout(): void {
        if (!$this->session->isAuthenticated()) {
            header("Location: /gestorUsuarios/src/view/auth/login.php");
            exit;
        }
        
        $this->session->destroy();
        header("Location: /gestorUsuarios/src/view/auth/login.php");
        exit;
    }

    public function register(): void{
        if ($this->session->isAuthenticated()) {
            header("Location: /gestorUsuarios/public/index.php");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['usuario'] ?? '';
            $password = $_POST['contrasena'] ?? '';

            try {
                $this->userController->register($username, $password);
                header("Location: /gestorUsuarios/src/view/auth/login.php?success=registered");
                exit;
            } catch (Exception $e) {
                header("Location: /gestorUsuarios/src/view/auth/register.php?error=1&message=" . urlencode($e->getMessage()));
                exit;
            }
        }
    }

    public function updateProfile(): void{
        if (!$this->session->isAuthenticated()) {
            header("Location: /gestorUsuarios/src/view/auth/login.php");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['usuario'] ?? '';
            $password = $_POST['contrasena'] ?? '';

            try {
                $this->userController->updateProfile($username, $password);
                header("Location: /gestorUsuarios/src/view/user/profile.php?success=updated");
                exit;
            } catch (Exception $e) {
                header("Location: /gestorUsuarios/src/view/user/edit_profile.php?error=1&message=" . urlencode($e->getMessage()));
                exit;
            }
        }
    }

    public function viewProfile(): void{
        if (!$this->session->isAuthenticated()) {
            header("Location: /gestorUsuarios/src/view/auth/login.php");
            exit;
        }
    }
    
    public function viewAdminDashboard(): PDOStatement|false
    {
        if (!$this->session->isAuthenticated()) {
            header("Location: /gestorUsuarios/src/view/auth/login.php");
            exit;
        }
        
        if (!$this->session->isAdmin()) {
            header("Location: /gestorUsuarios/public/index.php?error=unauthorized");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
            $username = $_POST['username'] ?? '';

            try {
                $this->userController->deleteUser($username);
                header("Location: /gestorUsuarios/src/view/admin/dashboard.php?success=deleted");
                exit;
            } catch (Exception $e) {
                header("Location: /gestorUsuarios/src/view/admin/dashboard.php?error=1&message=" . urlencode($e->getMessage()));
                exit;
            }
        }
        
        return $this->userController->getAllUsers();
    }
}

$authController = new AuthController();

