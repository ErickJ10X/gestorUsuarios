<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: /gestorUsuarios/public/login.php");
    exit();
}

require_once(__DIR__ . '/../../includes/conexion.php');
global $conexion;
require_once(__DIR__ . '/../../includes/header.php');
?>

    <div class="container mt-4">
        <h2 class="mb-4">Administración de Usuarios</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Operación realizada correctamente.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php
                switch ($_GET['error']) {
                    case 'no_self_delete':
                        echo "No puedes eliminarte a ti mismo.";
                        break;
                    case 'delete_failed':
                        echo "Error al eliminar usuario: " . ($_GET['message'] ?? '');
                        break;
                    default:
                        echo "Error desconocido.";
                }
                ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                try {
                    $sql = "SELECT id, usuario, rol FROM usuarios ORDER BY id DESC";
                    $stmt = $conexion->query($sql);

                    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['usuario']); ?></td>
                            <td>
                            <span class="badge bg-<?php echo $user['rol'] === 'admin' ? 'danger' : 'primary'; ?>">
                                <?php echo ucfirst($user['rol']); ?>
                            </span>
                            </td>
                            <td>
                                <?php if ($_SESSION['rol'] === 'admin' && $user['rol'] !== 'admin'): ?>
                                    <a href="/gestorUsuarios/public/admin/delete_user.php?id=<?php echo $user['id']; ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Eliminar este usuario permanentemente?')">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                    endwhile;
                } catch (PDOException $e) {
                    echo "<tr><td colspan='4' class='text-danger'>Error al cargar usuarios: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include(__DIR__ . '/../../includes/footer.php'); ?>