<?php
session_start();
require_once(__DIR__ . '/../../controller/authController.php');
require_once(__DIR__ . '/../../util/authGuard.php');

$authGuard = new AuthGuard();
$authGuard->requireNoAuth();
$authController = new authController();
$authController->login();

include('../templates/header.php');
?>
    <div class="container main__container">
        <div class="row main__row justify-content-center">
            <div class="col-md-6 main__content">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert main__alert main__alert--error alert-danger">
                        <?php echo isset($_GET['message']) ? htmlspecialchars(urldecode($_GET['message'])) : 'Credenciales incorrectas. Por favor, inténtalo de nuevo.'; ?>
                    </div>
                <?php endif; ?>
                
                <form action="/gestorUsuarios/src/view/auth/login.php" method="post" class="main__form">
                    <div class="mb-3 main__form-group">
                        <label for="usuario" class="form-label main__form-label">Usuario</label>
                        <input type="text" class="form-control main__form-input" name="usuario" placeholder="Usuario" required>
                    </div>
                    <div class="mb-3 main__form-group">
                        <label for="contrasena" class="form-label main__form-label">Contraseña</label>
                        <input type="password" class="form-control main__form-input" name="contrasena" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary main__form-button">Iniciar Sesión</button>
                </form>
                <p class="main__form-register mt-3">¿No tienes cuenta? <a href="/gestorUsuarios/src/view/auth/register.php" class="main__form-link">Regístrate</a></p>
            </div>
        </div>
    </div>
<?php include('../templates/footer.php'); ?>
