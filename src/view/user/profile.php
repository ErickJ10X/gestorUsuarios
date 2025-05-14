<?php
session_start();
require_once(__DIR__ . '/../../controller/authController.php');
require_once(__DIR__ . '/../../service/userService.php');
require_once(__DIR__ . '/../../util/authGuard.php');

$authGuard = new AuthGuard();
$authGuard->requireAuth();

include('../templates/header.php');
$authController->viewProfile();
?>

    <div class="container main__container mt-4">
        <h2 class="main__title">Mi Perfil</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert main__alert main__alert--success alert-success">
                <?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Operación exitosa.'; ?>
            </div>
        <?php endif; ?>

        <?php
        try {
            $userService = new UserService();
            $user = $userService->getUserByUsername($_SESSION['usuario']);

            if ($user): ?>
                <div class="card main__card mt-3">
                    <div class="card-body main__card-body">
                        <p class="main__profile-detail">
                            <strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                        <p class="main__profile-detail">
                            <strong>Usuario:</strong> <?php echo htmlspecialchars($user['usuario']); ?></p>
                        <p class="main__profile-detail">
                            <strong>Rol:</strong> <?php echo htmlspecialchars($user['rol']); ?></p>
                        <div class="main__profile-actions">
                            <a href="/gestorUsuarios/src/view/user/edit_profile.php" class="btn btn-primary main__profile-button">Editar Perfil</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert main__alert main__alert--error alert-danger">Usuario no encontrado.</div>
            <?php endif;
        } catch (PDOException $e) {
            echo "<div class='alert main__alert main__alert--error alert-danger'>Error al cargar el perfil: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
    </div>

<?php include('../templates/footer.php'); ?>

