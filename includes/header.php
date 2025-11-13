<?php
// Inicia la sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Definir base URL del proyecto en XAMPP
$base_url = '/mountain-connect/public';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MountainConnect</title>
    <link rel="stylesheet" href="<?= $base_url ?>/../assets/css/style.css">
</head>
<body>
<header>
    <div class="header-container">
        <!-- Logo -->
        <div class="logo">
            <a href="<?= $base_url ?>/index.php">
                <img src="<?= $base_url ?>/../assets/images/logo.png" alt="MountainConnect Logo" height="50">
            </a>
        </div>

        <!-- Título centrado -->
        <div class="header-title">MOUNTAIN CONNECT</div>

        <!-- Navegación -->
        <nav>
            <ul>
                <li><a href="<?= $base_url ?>/index.php">Inicio</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li>
                        <a href="#">Hola, <?= htmlspecialchars($_SESSION['user']['username']) ?></a>
                        <ul class="dropdown">
                            <li><a href="<?= $base_url ?>/profile.php">Mi perfil</a></li>
                            <li><a href="<?= $base_url ?>/routes/list.php">Mis actividades</a></li>
                            <li><a href="<?= $base_url ?>/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    <li><a href="<?= $base_url ?>/routes/create.php">Crear actividad</a></li>
                <?php else: ?>
                    <li><a href="<?= $base_url ?>/login.php">Login</a></li>
                    <li><a href="<?= $base_url ?>/register.php">Registro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
