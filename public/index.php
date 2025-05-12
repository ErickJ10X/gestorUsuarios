<?php
session_start();
require_once('../includes/conexion.php');
?>

<?php include('../includes/header.php'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <h1 class="mb-4">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="lead">Has iniciado sesión correctamente.</p>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="profile.php" class="btn btn-primary">
                                    <i class="bi bi-person-circle"></i> Ver mi perfil
                                </a>
                                <a href="logout.php" class="btn btn-outline-danger">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <h1 class="mb-4">Bienvenido</h1>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <p class="lead">Por favor ingrese a su cuenta</p>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="login.php" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                                </a>
                                <a href="register.php" class="btn btn-outline-primary">
                                    <i class="bi bi-person-plus"></i> Registrarse
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php include('../includes/footer.php'); ?>