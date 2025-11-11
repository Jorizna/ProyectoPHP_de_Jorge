<?php
// ==============================
// public/profile.php
// ==============================

session_start();

// ✅ Si el usuario NO está logueado, redirigir al login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

include_once __DIR__ . '/../includes/header.php';
?>

<h2>Perfil del Usuario</h2>

<p><strong>Nombre de usuario:</strong> <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></p>

<p><a href="logout.php">Cerrar sesión</a></p>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>