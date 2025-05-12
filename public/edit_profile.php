<?php
require_once('../includes/auth.php');
require_once('../includes/conexion.php');
global $conexion;

try {
    $sql = "SELECT usuario FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$_SESSION['id']]);
    $current_user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al cargar datos: " . $e->getMessage());
}
?>

<?php include('../includes/header.php'); ?>

    <div class="container mt-4">
        <h2>Editar Perfil</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Perfil actualizado correctamente.</div>
        <?php endif; ?>

        <form action="procesar_edit_profile.php" method="post">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de Usuario:</label>
                <input type="text" class="form-control" name="usuario"
                       value="<?php echo htmlspecialchars($current_user['usuario']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Nueva Contraseña (dejar en blanco para no cambiar):</label>
                <input type="password" class="form-control" name="contrasena">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

<?php include('../includes/footer.php'); ?>