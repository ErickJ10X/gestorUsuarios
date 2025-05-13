<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include('../templates/header.php');
global $authController;
$authController->register();
?>;

    <div class="container main__container mt-5">
        <div class="row main__row justify-content-center">
            <div class="col-md-6 main__content">
                <h2 class="main__title mb-4">Registro de Usuario</h2>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert main__alert main__alert--error alert-danger">
                        <?php
                        if ($_GET['error'] == 'usuario_existente') {
                            echo "El nombre de usuario ya está en uso.";
                        } else {
                            echo "Error en el registro.";
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <form action="../../../public/procesar_register.php" method="post" class="main__form">
                    <div class="mb-3 main__form-group">
                        <label for="usuario" class="form-label main__form-label">Nombre de Usuario:</label>
                        <input type="text" class="form-control main__form-input" name="usuario" required>
                    </div>

                    <div class="mb-3 main__form-group">
                        <label for="contrasena" class="form-label main__form-label">Contraseña:</label>
                        <input type="password" class="form-control main__form-input" name="contrasena" required>
                    </div>

                    <button type="submit" class="btn btn-primary main__form-button">Registrarse</button>
                </form>

                <p class="main__form-login mt-3">¿Ya tienes cuenta? <a href="login.php" class="main__form-link">Inicia Sesión</a></p>
            </div>
        </div>
    </div>

<?php include('../templates/footer.php'); ?>