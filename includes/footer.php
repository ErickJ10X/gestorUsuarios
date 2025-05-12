</main>
<footer class="bg-dark text-white p-3 mt-5">
    <div class="container text-center">
        <p>&copy; <?php echo date('Y'); ?> Gestor de Usuarios. Todos los derechos reservados.</p>
        <?php if (isset($_SESSION['usuario'])): ?>
            <small>Conectado como: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></small>
        <?php endif; ?>
    </div>
</footer>

</body>
</html>