<?php
session_start();
include_once __DIR__ . '/../../includes/header.php';

// Aseguramos el array
$_SESSION['actividades'] ??= [];

$errors = [];
$success = '';
$provincias = ['Madrid', 'Cataluña', 'Valencia', 'Andalucia', 'Aragón', 'Galicia', 'Asturias'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //vakidación de datos
    $data = [
        'tipo' => $_POST['tipo'] ?? '',
        'nombre' => trim($_POST['nombre'] ?? ''),
        'dificultad' => $_POST['dificultad'] ?? '',
        'distancia' => $_POST['distancia'] ?? '',
        'desnivel' => $_POST['desnivel'] ?? '',
        'duracion' => $_POST['duracion'] ?? '',
        'provincia' => $_POST['provincia'] ?? '',
        'epoca' => $_POST['epoca'] ?? [],
        'descripcion' => trim($_POST['descripcion'] ?? ''),
        'nivel_tecnico' => $_POST['nivel_tecnico'] ?? '',
        'nivel_fisico' => $_POST['nivel_fisico'] ?? '',
    ];

    $obligatorios = ['tipo', 'nombre', 'dificultad', 'provincia'];
    foreach ($obligatorios as $campo) {
        if ($data[$campo] === '') {
            $errors[] = "El campo '$campo' es obligatorio.";
        }
    }

    if (empty($data['epoca'])) {
        $errors[] = 'Selecciona al menos una época recomendada.';
    }

    //procesamiento de fotos
    $fotos_guardadas = [];

    if (!empty($_FILES['fotos']['name'][0])) {

        foreach ($_FILES['fotos']['tmp_name'] as $i => $tmp) {

            $nombre_original = $_FILES['fotos']['name'][$i];
            $tipo_mime = mime_content_type($tmp);
            $tamano = $_FILES['fotos']['size'][$i];

            if (!in_array($tipo_mime, ['image/jpeg', 'image/png'])) {
                $errors[] = "Archivo no permitido: $nombre_original";
                continue;
            }

            if ($tamano > 2 * 1024 * 1024) {
                $errors[] = "La imagen $nombre_original supera los 2MB.";
                continue;
            }

            $ext = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $nuevo = uniqid('img_') . ".$ext";
            $destino = __DIR__ . '/../../uploads/photos/' . $nuevo;

            if (move_uploaded_file($tmp, $destino)) {
                $fotos_guardadas[] = $nuevo;
            }
        }
    }

    //guardado de la actividad
    if (!$errors) {
        $data['id'] = count($_SESSION['actividades']) + 1;
        $data['user_id'] = $_SESSION['user']['id'] ?? 0;
        $data['fotos'] = $fotos_guardadas;

        $_SESSION['actividades'][] = $data;
        $success = "Actividad creada correctamente.";
    }
}
?>

<link rel="stylesheet" href="../../assets/css/pages/create.css">

<div class="form-container">
    <h2>Crear Actividad</h2>

    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="error">
            <?php foreach ($errors as $e): ?>
                <p><?= $e ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <label>Tipo:</label>
        <select name="tipo" required>
            <option value="">-- Selecciona --</option>
            <option>Ruta</option>
            <option>Ferrata</option>
            <option>Escalada</option>
        </select>

        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Dificultad:</label>
        <select name="dificultad" required>
            <option value="">-- Selecciona --</option>
            <option>Fácil</option>
            <option>Moderada</option>
            <option>Difícil</option>
            <option>Muy Difícil</option>
        </select>

        <label>Distancia (km):</label>
        <input type="number" name="distancia" step="0.1">

        <label>Desnivel (m):</label>
        <input type="number" name="desnivel">

        <label>Duración (h):</label>
        <input type="number" name="duracion" step="0.1">

        <label>Provincia:</label>
        <select name="provincia" required>
            <option value="">-- Selecciona --</option>
            <?php foreach ($provincias as $p): ?>
                <option><?= $p ?></option>
            <?php endforeach; ?>
        </select>

        <label>Épocas recomendadas:</label>
        <div class="checkbox-group">
            <label><input type="checkbox" name="epoca[]" value="Primavera"> Primavera</label>
            <label><input type="checkbox" name="epoca[]" value="Verano"> Verano</label>
            <label><input type="checkbox" name="epoca[]" value="Otoño"> Otoño</label>
            <label><input type="checkbox" name="epoca[]" value="Invierno"> Invierno</label>
        </div>

        <label>Descripción:</label>
        <textarea name="descripcion"></textarea>

        <label>Nivel técnico (1-5):</label>
        <input type="number" name="nivel_tecnico" min="1" max="5">

        <label>Nivel físico (1-5):</label>
        <input type="number" name="nivel_fisico" min="1" max="5">

        <label>Fotos:</label>
        <input type="file" name="fotos[]" multiple>

        <button type="submit">Guardar</button>
    </form>
</div>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>