</main>
<footer class="footer">
    <div class="footer__container container">
        <p class="footer__copyright">&copy; <?php echo date('Y'); ?> Gestor de Usuarios.</p>
        <?php if (isset($_SESSION['usuario'])): ?>
            <small class="footer__user">Conectado como: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></small>
        <?php endif; ?>
    </div>
</footer>
</body>
</html>