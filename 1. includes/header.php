// ---------------------------
// includes/header.php
// ---------------------------
<?php
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
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header>
<h1>MountainConnect</h1>
<nav>
<a href="/index.php">Inicio</a> |
<a href="/routes/list.php">Rutas</a> |
<?php if (!empty($_SESSION['user_id'])): ?>
<a href="/profile.php">Perfil</a> |
<a href="/logout.php">Cerrar sesión</a>
<?php else: ?>
<a href="/register.php">Registro</a> |
<a href="/login.php">Login</a>
<?php endif; ?>
</nav>
</header>
<hr>
<main>