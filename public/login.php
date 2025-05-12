<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
}
include('../includes/header.php');
?>
    <form action="procesar_login.php" method="post">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
<?php include('../includes/footer.php'); ?>