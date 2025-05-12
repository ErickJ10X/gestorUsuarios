<?php
require_once('../includes/auth.php');
require_once('../includes/conexion.php');
global $conn;

try {

    $stmt=$conn->getUserById($_SESSION['id']);
    $current_user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar datos: " . $e->getMessage());
}
?>

<?php include('../includes/header.php'); ?>

    <div class="container main__container mt-4">
        <h2 class="main__title">Editar Perfil</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert main__alert main__alert--success alert-success">Perfil actualizado correctamente.</div>
        <?php endif; ?>

        <form action="procesar_edit_profile.php" method="post" class="main__form">
            <div class="mb-3 main__form-group">
                <label for="usuario" class="form-label main__form-label">Nombre de Usuario:</label>
                <input type="text" class="form-control main__form-input" name="usuario"
                       value="<?php echo htmlspecialchars($current_user['usuario']); ?>" required>
            </div>

            <div class="mb-3 main__form-group">
                <label for="contrasena" class="form-label main__form-label">Nueva Contraseña (dejar en blanco para no cambiar):</label>
                <input type="password" class="form-control main__form-input" name="contrasena">
            </div>

            <button type="submit" class="btn btn-primary main__form-button">Guardar Cambios</button>
        </form>
    </div>

<?php include('../includes/footer.php'); ?>