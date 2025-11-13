<?php
session_start();
include_once __DIR__ . '/../includes/header.php';
?>

<div class="home-container">
    <h1 class="home-title">🏔️ Bienvenido a <span>MountainConnect</span></h1>
    <p class="home-subtitle">Tu punto de encuentro para amantes de la montaña</p>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="menu-explorar">
            <a href="routes/list.php?tipo=Ruta" class="explore-btn">🗺️ Explorar Rutas</a>
            <a href="routes/list.php?tipo=Ferrata" class="explore-btn">🧗 Explorar Ferratas</a>
            <a href="routes/list.php?tipo=Escalada" class="explore-btn">🧗‍♂️ Explorar Vías de Escalada</a>
        </div>
    <?php else: ?>
        <div class="cards-container">
            <div class="card">
                <h3>🌄 Rutas</h3>
                <p>Descubre senderos y caminos naturales para todos los niveles.</p>
            </div>
            <div class="card">
                <h3>🧗 Ferratas</h3>
                <p>Disfruta de las mejores ferratas equipadas con seguridad y vistas únicas.</p>
            </div>
            <div class="card">
                <h3>🏕️ Escalada</h3>
                <p>Encuentra vías clásicas y deportivas para desafiar tus límites.</p>
            </div>
        </div>

        <div class="cta">
            <p>¿Quieres participar? <a href="login.php">Inicia sesión</a> o <a href="register.php">regístrate</a>.</p>
        </div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="<?= $base_url ?>/../assets/css/pages/home.css">
<?php include_once __DIR__ . '/../includes/footer.php'; ?>