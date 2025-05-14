<?php
session_start();
require_once(__DIR__ . '/../../controller/authController.php');
require_once(__DIR__ . '/../../util/authGuard.php');
require_once(__DIR__ . '/../../service/userService.php');

$authGuard = new AuthGuard();
$authGuard->requireAuth();
$authController = new authController();

include('../templates/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $authController->updateProfile();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="container main__container mt-4">
    <h2 class="main__title">Editar Perfil</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert main__alert main__alert--success alert-success">Perfil actualizado correctamente.</div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert main__alert main__alert--error alert-danger">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert main__alert main__alert--error alert-danger">
            <?php echo isset($_GET['message']) ? htmlspecialchars($_GET['message']) : 'Error al actualizar el perfil.'; ?>
        </div>
    <?php endif; ?>

    <?php
    try {
        $userService = new UserService();
        $user = $userService->getUserByUsername($_SESSION['usuario']);

        if ($user): ?>
            <form action="/gestorUsuarios/src/view/user/edit_profile.php" method="post" class="main__form">
                <div class="mb-3 main__form-group">
                    <label for="nombre" class="form-label main__form-label">Nombre:</label>
                    <input type="text" class="form-control main__form-input" name="nombre"
                           value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                </div>
                <div class="mb-3 main__form-group">
                    <label for="apellido" class="form-label main__form-label">Apellido:</label>
                    <input type="text" class="form-control main__form-input" name="apellido"
                           value="<?php echo htmlspecialchars($user['apellido']); ?>" required>
                </div>
                <div class="mb-3 main__form-group">
                    <label for="usuario" class="form-label main__form-label">Nombre de Usuario:</label>
                    <input type="text" class="form-control main__form-input" name="usuario"
                           value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>" required>
                </div>
                <div class="mb-3 main__form-group">
                    <label for="email" class="form-label main__form-label">Email:</label>
                    <input type="email" class="form-control main__form-input" name="email"
                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3 main__form-group">
                    <label for="contrasena" class="form-label main__form-label">Nueva Contraseña (dejar en blanco para
                        no
                        cambiar):</label>
                    <input type="password" class="form-control main__form-input" name="contrasena">
                </div>

                <button type="submit" class="btn btn-primary main__form-button">Guardar Cambios</button>
                <a href="/gestorUsuarios/src/view/user/profile.php" class="btn btn-secondary">Cancelar</a>
            </form>

        <?php else: ?>
            <div class="alert main__alert main__alert--error alert-danger">Usuario no encontrado.</div>
        <?php endif;
    } catch (PDOException $e) {
        echo "
    <div class='alert main__alert main__alert--error alert-danger'>Error al cargar el perfil: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    ?>
</div>

<?php include('../templates/footer.php'); ?>
