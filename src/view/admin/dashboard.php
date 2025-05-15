<?php
session_start();
require_once(__DIR__ . '/../../controller/authController.php');
require_once(__DIR__ . '/../../util/authGuard.php');

$authGuard = new AuthGuard();
$authGuard->requireAdmin();

include('../templates/header.php');
$authController = new authController();
$stmt = $authController->viewAdminDashboard();
?>

    <div class="container main__container mt-4">
        <h2 class="main__title mb-4">Administración de Usuarios</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert main__alert main__alert--success alert-success">Operación realizada correctamente.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert main__alert main__alert--error alert-danger">
                <?php
                if (isset($_GET['message'])) {
                    echo htmlspecialchars(urldecode($_GET['message']));
                } else {
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
                }
                ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive main__table-container">
            <table class="table main__table table-striped">
                <thead class="table-dark main__table-header">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="main__table-body">
                <?php
                try {
                    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr class="main__table-row">
                            <td class="main__table-cell"><?php echo $user['id']; ?></td>
                            <td class="main__table-cell"><?php echo htmlspecialchars($user['usuario']); ?></td>
                            <td class="main__table-cell">
                            <span class="badge main__badge bg-<?php echo $user['rol'] === 'admin' ? 'danger' : 'primary'; ?>">
                                <?php echo ucfirst($user['rol']); ?>
                            </span>
                            </td>
                            <td class="main__table-cell">
                                <?php if ($user['usuario'] != $_SESSION['usuario'] && $user['rol'] !== 'admin' ): ?>
                                    <form action="/gestorUsuarios/src/view/admin/dashboard.php" method="post" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($user['usuario']); ?>">
                                        <button type="submit" class="btn btn-sm btn-danger main__table-action main__table-action--delete"
                                                onclick="return confirm('¿Eliminar este usuario permanentemente?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                    endwhile;
                } catch (PDOException $e) {
                    echo "<tr><td colspan='4' class='text-danger main__table-error'>Error al cargar usuarios: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include('../templates/footer.php'); ?>
