<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = limpiar_dato($_POST['username'] ?? '');
    $email = limpiar_dato($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $nivel_experiencia = limpiar_dato($_POST['nivel_experiencia'] ?? '');
    $especialidad = limpiar_dato($_POST['especialidad'] ?? '');
    $provincia = limpiar_dato($_POST['provincia'] ?? '');

    if ($username === '' || $email === '' || $password === '' || $confirm === '') {
        $errors[] = 'Todos los campos obligatorios deben completarse.';
    } elseif (!validar_email($email)) {
        $errors[] = 'El formato del email no es válido.';
    } elseif ($password !== $confirm) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    foreach ($_SESSION['users'] as $u) {
        if ($u['email'] === $email) {
            $errors[] = 'Ya existe un usuario con ese correo electrónico.';
            break;
        }
    }

    if (empty($errors)) {
        $_SESSION['users'][] = [
            'id' => count($_SESSION['users']) + 1,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'nivel_experiencia' => $nivel_experiencia,
            'especialidad' => $especialidad,
            'provincia' => $provincia
        ];

        $_SESSION['success'] = 'Registro correcto. Ya puedes iniciar sesión.';
        header('Location: /mountain-connect/public/login.php');
        exit;
    }
}

include_once __DIR__ . '/../includes/header.php';
?>

<h2>Registro</h2>

<?php if (!empty($errors)): ?>
    <div class="msg-error">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= limpiar_dato($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="">
    <label>Nombre de usuario:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <label>Nivel de experiencia:</label><br>
    <select name="nivel_experiencia" required>
        <option value="">Selecciona...</option>
        <option value="Principiante">Principiante</option>
        <option value="Intermedio">Intermedio</option>
        <option value="Avanzado">Avanzado</option>
        <option value="Experto">Experto</option>
    </select><br><br>

    <label>Especialidad:</label><br>
    <input type="text" name="especialidad" placeholder="Ej: senderismo, escalada..." required><br><br>

    <label>Provincia:</label><br>
    <select name="provincia" required>
        <option value="">Selecciona provincia...</option>
        <option value="Madrid">Madrid</option>
        <option value="Barcelona">Barcelona</option>
        <option value="Valencia">Valencia</option>
        <option value="Sevilla">Sevilla</option>
        <option value="Granada">Granada</option>
        <option value="Zaragoza">Zaragoza</option>
        <option value="Asturias">Asturias</option>
    </select><br><br>

    <button type="submit">Registrarse</button>
</form>

<p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>