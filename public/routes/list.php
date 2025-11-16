<?php
session_start();
include_once __DIR__ . '/../../includes/header.php';

$tipo = $_GET['tipo'] ?? null;

// Actividades del usuario actual
$user_id = $_SESSION['user']['id'] ?? 0;
$actividades = $_SESSION['actividades'] ?? [];

// Filtrar por usuario
$filtradas = array_filter($actividades, fn($a) => $a['user_id'] == $user_id);

// Filtrar por tipo si viene en la URL
if ($tipo) {
    $filtradas = array_filter($filtradas, fn($a) => $a['tipo'] === $tipo);
}
?>

<link rel="stylesheet" href="../../assets/css/pages/list.css">

<div class="container">
    <h2><?= htmlspecialchars($tipo) ?> creadas</h2>

    <a class="new-btn" href="create.php?tipo=<?= urlencode($tipo) ?>">Crear nueva <?= htmlspecialchars($tipo) ?></a>

    <?php if (!$filtradas): ?>
        <p>No hay actividades creadas.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($filtradas as $a): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($a['nombre']) ?></h3>
                    <p><strong>Dificultad:</strong> <?= htmlspecialchars($a['dificultad']) ?></p>
                    <p><strong>Distancia:</strong> <?= $a['distancia'] ?> km</p>
                    <p><strong>Desnivel:</strong> <?= $a['desnivel'] ?> m</p>
                    <p><strong>Provincia:</strong> <?= $a['provincia'] ?></p>
                    <p><strong>Época:</strong> <?= implode(", ", $a['epoca']) ?></p>

                    <?php if (!empty($a['fotos'])): ?>
                        <div class="gallery">
                            <?php foreach ($a['fotos'] as $f): ?>
                                <img src="../../uploads/photos/<?= htmlspecialchars($f) ?>">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>