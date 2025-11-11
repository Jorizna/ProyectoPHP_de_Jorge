<?php
// Comprueba sesión y redirige al login si no hay usuario
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
if (empty($_SESSION['user_id'])) {
// Ajusta la ruta si tu proyecto está en otra carpeta
header('Location: /mountain-connect/public/login.php');
exit;
}