<?php
session_start();
require_once(__DIR__ . '/../../controller/authController.php');
require_once(__DIR__ . '/../../util/authGuard.php');

$authGuard = new AuthGuard();
$authGuard->requireNoAuth();

include('../templates/header.php');
$authController = new AuthController();
$authController->register();
?>

    <div class="container main__container mt-5">
        <div class="row main__row justify-content-center">
            <div class="col-md-6 main__content">
                <h2 class="main__title mb-4">Registro de Usuario</h2>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert main__alert main__alert--error alert-danger">
                        <?php
                        if (isset($_GET['message'])) {
                            echo htmlspecialchars(urldecode($_GET['message']));
                        } elseif ($_GET['error'] == 'usuario_existente') {
                            echo "El nombre de usuario ya está en uso.";
                        } else {
                            echo "Error en el registro.";
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <form action="/gestorUsuarios/src/view/auth/register.php" method="post" class="main__form">
                    <div class="mb-3 main__form-group">
                        <label for="nombre" class="form-label main__form-label">Nombre:</label>
                        <input type="text" class="form-control main__form-input" name="nombre" required>
                    </div>
                    <div class="mb-3 main__form-group">
                        <label for="apellido" class="form-label main__form-label">Apellido:</label>
                        <input type="text" class="form-control main__form-input" name="apellido" required>
                    </div>
                    <div class="mb-3 main__form-group">
                        <label for="usuario" class="form-label main__form-label">Nombre de Usuario:</label>
                        <input type="text" class="form-control main__form-input" name="usuario" required>
                    </div>
                    <div class="mb-3 main__form-group">
                        <label for="email" class="form-label main__form-label">Email:</label>
                        <input type="email" class="form-control main__form-input" name="email" required>
                    </div>
                    <div class="mb-3 main__form-group">
                        <label for="contrasena" class="form-label main__form-label">Contraseña: (mínimo 8 caracteres, al menos una letra mayuscula, una letra minuscula, un numero y un caracter especial)</label>
                        <input type="password" class="form-control main__form-input" name="contrasena" required>
                    </div>
                    <div class="mb-3 main__form-group">
                        <label for="confirmar_contrasena" class="form-label main__form-label">Confirmar Contraseña:</label>
                        <input type="password" class="form-control main__form-input" name="confirmar_contrasena" required>
                    </div>

                    <button type="submit" class="btn btn-primary main__form-button">Registrarse</button>
                </form>

                <p class="main__form-login mt-3">¿Ya tienes cuenta? <a href="/gestorUsuarios/src/view/auth/login.php" class="main__form-link">Inicia Sesión</a></p>
            </div>
        </div>
    </div>

<?php include('../templates/footer.php'); ?>
