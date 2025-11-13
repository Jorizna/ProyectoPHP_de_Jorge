<?php
session_start();
include_once __DIR__ . '/../../includes/header.php';

// Inicializar array único para todas las actividades
if (!isset($_SESSION['actividades']) || !is_array($_SESSION['actividades'])) {
    $_SESSION['actividades'] = [];
}

$errors = [];
$success = '';
$provincias = ['Madrid', 'Barcelona', 'Valencia', 'Granada', 'Zaragoza', 'Sevilla', 'Asturias'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $dificultad = $_POST['dificultad'] ?? '';
    $distancia = $_POST['distancia'] ?? '';
    $desnivel = $_POST['desnivel'] ?? '';
    $duracion = $_POST['duracion'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $epoca = $_POST['epoca'] ?? [];
    $descripcion = trim($_POST['descripcion'] ?? '');
    $nivel_tecnico = $_POST['nivel_tecnico'] ?? '';
    $nivel_fisico = $_POST['nivel_fisico'] ?? '';
    $fotos_guardadas = [];

    if ($tipo === '' || $nombre === '' || $dificultad === '' || $provincia === '' || empty($epoca)) {
        $errors[] = 'Completa todos los campos obligatorios.';
    }

    // Subida de fotos
    if (isset($_FILES['fotos']) && $_FILES['fotos']['error'][0] !== 4) {
        foreach ($_FILES['fotos']['tmp_name'] as $i => $tmp_name) {
            $nombre_original = $_FILES['fotos']['name'][$i];
            $tipo_mime = mime_content_type($tmp_name);
            $tamano = $_FILES['fotos']['size'][$i];

            if (!in_array($tipo_mime, ['image/jpeg', 'image/png', 'image/jpg'])) {
                $errors[] = "El archivo {$nombre_original} no es válido.";
                continue;
            }
            if ($tamano > 2 * 1024 * 1024) {
                $errors[] = "El archivo {$nombre_original} supera los 2MB.";
                continue;
            }

            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $nombre_nuevo = uniqid('act_', true) . '.' . $extension;
            $ruta_destino = __DIR__ . '/../../uploads/photos/' . $nombre_nuevo;

            if (move_uploaded_file($tmp_name, $ruta_destino)) {
                $fotos_guardadas[] = $nombre_nuevo;
            } else {
                $errors[] = "Error al subir la imagen {$nombre_original}.";
            }
        }
    }

    if (empty($errors)) {
        $_SESSION['actividades'][] = [
            'id' => count($_SESSION['actividades']) + 1,
            'user_id' => $_SESSION['user']['id'] ?? 0, // ← Guardar usuario
            'tipo' => $tipo,
            'nombre' => $nombre,
            'dificultad' => $dificultad,
            'distancia' => $distancia,
            'desnivel' => $desnivel,
            'duracion' => $duracion,
            'provincia' => $provincia,
            'epoca' => $epoca,
            'descripcion' => $descripcion,
            'nivel_tecnico' => $nivel_tecnico,
            'nivel_fisico' => $nivel_fisico,
            'fotos' => $fotos_guardadas
        ];
        $success = "✅ $tipo creada correctamente.";
    }
}
?>

<div class="container">
    <h2>➕ Crear nueva actividad</h2>

    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Tipo de actividad:</label>
        <select name="tipo" required>
            <option value="">-- Selecciona --</option>
            <option value="Ruta">Ruta</option>
            <option value="Ferrata">Ferrata</option>
            <option value="Escalada">Vía de Escalada</option>
        </select><br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Dificultad:</label>
        <select name="dificultad" required>
            <option value="">-- Selecciona --</option>
            <option value="Fácil">Fácil</option>
            <option value="Moderada">Moderada</option>
            <option value="Difícil">Difícil</option>
            <option value="Muy Difícil">Muy Difícil</option>
        </select><br><br>

        <label>Distancia (km):</label>
        <input type="number" name="distancia" step="0.1"><br><br>

        <label>Desnivel (m):</label>
        <input type="number" name="desnivel"><br><br>

        <label>Duración (h):</label>
        <input type="number" name="duracion" step="0.1"><br><br>

        <label>Provincia:</label>
        <select name="provincia" required>
            <option value="">-- Selecciona --</option>
            <?php foreach ($provincias as $p) echo "<option>" . htmlspecialchars($p) . "</option>"; ?>
        </select><br><br>

        <label>Época recomendada:</label><br>
        <label><input type="checkbox" name="epoca[]" value="Primavera"> Primavera</label>
        <label><input type="checkbox" name="epoca[]" value="Verano"> Verano</label>
        <label><input type="checkbox" name="epoca[]" value="Otoño"> Otoño</label>
        <label><input type="checkbox" name="epoca[]" value="Invierno"> Invierno</label><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion" rows="4"></textarea><br><br>

        <label>Nivel técnico (1-5):</label>
        <input type="number" name="nivel_tecnico" min="1" max="5"><br><br>

        <label>Nivel físico (1-5):</label>
        <input type="number" name="nivel_fisico" min="1" max="5"><br><br>

        <label>Fotos (opcional):</label>
        <input type="file" name="fotos[]" multiple accept=".jpg,.jpeg,.png"><br><br>

        <button type="submit">💾 Guardar</button>
    </form>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>
<link rel="stylesheet" href="<?= $base_url ?>/../assets/css/pages/login.css">