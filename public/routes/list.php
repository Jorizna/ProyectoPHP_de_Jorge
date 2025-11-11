<?php
session_start();
include_once __DIR__ . '/../../includes/header.php';

$tipo = $_GET['tipo'] ?? 'Ruta'; // Por defecto Rutas
$actividades = $_SESSION['actividades'] ?? [];
$filtradas = array_filter($actividades, fn($a) => $a['tipo'] === $tipo);
?>

<div class="container">
    <h2>📋 <?= htmlspecialchars($tipo) ?> creadas</h2>

    <p><a href="create.php?tipo=<?= urlencode($tipo) ?>">➕ Crear nueva <?= htmlspecialchars($tipo) ?></a></p>

    <?php if (empty($filtradas)): ?>
        <p>No hay <?= strtolower($tipo) ?> todavía.</p>
    <?php else: ?>
        <div class="routes-grid">
            <?php foreach ($filtradas as $r): ?>
                <div class="route-card">
                    <h3><?= htmlspecialchars($r['nombre']) ?></h3>
                    <p><strong>Dificultad:</strong> <?= htmlspecialchars($r['dificultad']) ?></p>
                    <p><strong>Distancia:</strong> <?= htmlspecialchars($r['distancia']) ?> km</p>
                    <p><strong>Provincia:</strong> <?= htmlspecialchars($r['provincia']) ?></p>

                    <?php if (!empty($r['fotos'])): ?>
                        <div class="gallery">
                            <?php foreach ($r['fotos'] as $foto): ?>
                                <img src="../../uploads/photos/<?= htmlspecialchars($foto) ?>" alt="foto de <?= htmlspecialchars($r['nombre']) ?>">
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <em>Sin fotos</em>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.container { max-width: 900px; margin: auto; padding: 1rem; }
.routes-grid { display: flex; flex-wrap: wrap; gap: 1.5rem; }
.route-card { border: 1px solid #ccc; border-radius: 1rem; padding: 1rem; width: 250px; background: #f9f9f9; }
.route-card img { width: 100%; height: 150px; object-fit: cover; border-radius: 0.5rem; }
</style>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>