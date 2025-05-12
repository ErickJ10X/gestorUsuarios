<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
}
include('../includes/header.php');
?>
    <div class="container main__container">
        <div class="row main__row justify-content-center">
            <div class="col-md-6 main__content">
                <form action="procesar_login.php" method="post" class="main__form">
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
                <p class="main__form-register mt-3">¿No tienes cuenta? <a href="register.php" class="main__form-link">Regístrate</a></p>
            </div>
        </div>
    </div>
<?php include('../includes/footer.php'); ?>