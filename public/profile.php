<?php
require_once('../includes/auth.php');
require_once('../includes/conexion.php');
global $conn;
?>

<?php include('../includes/header.php'); ?>

    <div class="container main__container mt-4">
        <h2 class="main__title">Mi Perfil</h2>

        <?php
        try {
            $stmt = $conn->getUserById($_SESSION['id']);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user): ?>
                <div class="card main__card mt-3">
                    <div class="card-body main__card-body">
                        <p class="main__profile-detail"><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                        <p class="main__profile-detail"><strong>Usuario:</strong> <?php echo htmlspecialchars($user['usuario']); ?></p>
                        <p class="main__profile-detail"><strong>Rol:</strong> <?php echo htmlspecialchars($user['rol']); ?></p>
                        <div class="main__profile-actions">
                            <a href="edit_profile.php" class="btn btn-primary main__profile-button">Editar Perfil</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert main__alert main__alert--error alert-danger">Usuario no encontrado.</div>
            <?php endif;
        } catch (PDOException $e) {
            echo "<div class='alert main__alert main__alert--error alert-danger'>Error al cargar el perfil.</div>";
        }
        ?>
    </div>

<?php include('../includes/footer.php'); ?>