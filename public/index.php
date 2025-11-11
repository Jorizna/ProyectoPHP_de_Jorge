<?php
session_start();
include_once __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <h1>🏔️ Bienvenido a MountainConnect</h1>
    <p>Explora rutas, ferratas y vías de escalada de la comunidad montañera.</p>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="menu-explorar">
            <a href="routes/list.php?tipo=Ruta">🗺️ Explorar Rutas</a><br>
            <a href="routes/list.php?tipo=Ferrata">🧗 Explorar Ferratas</a><br>
            <a href="routes/list.php?tipo=Escalada">🧗‍♂️ Explorar Vías de Escalada</a>
        </div>
    <?php else: ?>
        <p>Por favor, <a href="login.php">inicia sesión</a> o <a href="register.php">regístrate</a> para crear y ver actividades.</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>