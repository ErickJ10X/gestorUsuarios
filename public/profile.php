<?php
require_once('../includes/auth.php');
require_once('../includes/conexion.php');
global $conexion;
?>

<?php include('../includes/header.php'); ?>

    <div class="container mt-4">
        <h2>Mi Perfil</h2>

        <?php
        try {
            $sql = "SELECT id,usuario,rol FROM usuarios WHERE id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$_SESSION['id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user): ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($user['usuario']); ?></p>
                        <p><strong>Rol:</strong> <?php echo htmlspecialchars($user['rol']); ?></p>
                        <a href="edit_profile.php" class="btn btn-primary">Editar Perfil</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">Usuario no encontrado.</div>
            <?php endif;
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error al cargar el perfil.</div>";
        }
        ?>
    </div>

<?php include('../includes/footer.php'); ?>