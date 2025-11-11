<?php
// ==============================
// public/logout.php
// ==============================

session_start();

// ✅ Eliminar solo la sesión del usuario
unset($_SESSION['user']);

// ✅ Redirigir al inicio
header('Location: index.php');
exit;
