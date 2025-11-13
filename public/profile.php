<?php
require_once __DIR__ . '/../includes/functions.php';
verificar_sesion_activa();
include_once __DIR__ . '/../includes/header.php';

$user = $_SESSION['user'];
?>

<div class="profile-container">
    <div class="profile-card">
        <h2>👤 Perfil de <?= limpiar_dato($user['username']) ?></h2>

        <div class="profile-info">
            <p><strong>Nombre de usuario:</strong> <?= limpiar_dato($user['username']) ?></p>
            <p><strong>Email:</strong> <?= limpiar_dato($user['email']) ?></p>
            <p><strong>Nivel de experiencia:</strong> <?= limpiar_dato($user['nivel_experiencia'] ?? 'No indicado') ?></p>
            <p><strong>Especialidad:</strong> <?= limpiar_dato($user['especialidad'] ?? 'No indicada') ?></p>
            <p><strong>Provincia:</strong> <?= limpiar_dato($user['provincia'] ?? 'No indicada') ?></p>
        </div>

        <div class="profile-actions">
            <a href="/mountain-connect/public/routes/list.php?user=<?= limpiar_dato($user['id']) ?>" class="btn">📋 Mis actividades</a>
            <a href="/mountain-connect/public/routes/create.php" class="btn">➕ Crear nueva actividad</a>
            <a href="/mountain-connect/public/logout.php" class="btn btn-danger">🚪 Cerrar sesión</a>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= $base_url ?>/../assets/css/pages/profile.css">
<?php include_once __DIR__ . '/../includes/footer.php'; ?>