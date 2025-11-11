<?php
// Header sencillo y dinámico
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MountainConnect</title>
    <link rel="stylesheet" href="/mountain-connect/assets/css/style.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0
        }

        header {
            background: #2c3e50;
            color: #fff;
            padding: 12px
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 12px
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .brand img {
            height: 48px
        }

        nav {
            margin-top: 8px
        }

        nav a {
            color: #fff;
            margin-right: 12px;
            text-decoration: none
        }

        nav a:hover {
            text-decoration: underline
        }

        main {
            padding: 18px;
            max-width: 1000px;
            margin: 0 auto
        }

        .msg-success {
            color: green
        }

        .msg-error {
            color: #b00020
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="brand">
                <img src="/mountain-connect/assets/images/logo.png" alt="Logo">
                <h1 style="margin:0;font-size:20px">MountainConnect</h1>
            </div>
            <nav>
                <a href="/mountain-connect/public/index.php">Inicio</a>
                <a href="/mountain-connect/public/routes/list.php">Rutas</a>
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <span style="color:#fff">Hola, <?= htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="/mountain-connect/public/profile.php">Perfil</a>
                    <a href="/mountain-connect/public/logout.php">Cerrar sesión</a>
                <?php else: ?>
                    <a href="/mountain-connect/public/register.php">Registro</a>
                    <a href="/mountain-connect/public/login.php">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main>