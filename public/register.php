<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Registro de Usuario</h2>

                <!-- Mostrar errores -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">
                        <?php
                        if ($_GET['error'] == 'usuario_existente') {
                            echo "El nombre de usuario ya está en uso.";
                        } else {
                            echo "Error en el registro.";
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <form action="procesar_register.php" method="post">
                    <div class="mb-3">
                        <label for="usuario">Nombre de Usuario:</label>
                        <input type="text" class="form-control" name="usuario" required>
                    </div>

                    <div class="mb-3">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" class="form-control" name="contrasena" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </form>

                <p class="mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia Sesión</a></p>
            </div>
        </div>
    </div>

<?php include('../includes/footer.php'); ?>