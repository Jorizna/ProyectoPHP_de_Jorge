<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

$_SESSION['users'] ??= [];

$errores = [];
$correcto = $_SESSION['correcto'] ?? '';
unset($_SESSION['correcto']);

// Si ya está logueado el usuario, se le redirige
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = limpiar_dato($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errores[] = 'Todos los campos son obligatorios.';
    } elseif (!validar_email($email)) {
        $errores[] = 'El formato del email no es válido.';
    } else {

        // Buscar usuario
        foreach ($_SESSION['users'] as $u) {
            if ($u['email'] === $email && $u['password'] === $password) {
                $_SESSION['user'] = $u;
                header('Location: profile.php');
                exit;
            }
        }

        $errores[] = 'Email o contraseña incorrectos.';
    }
}

include_once __DIR__ . '/../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/pages/login.css">

<div class="form-container">
    <h2>Iniciar Sesión</h2>

    <?php if ($correcto): ?>
        <div class="msg-correcto"><?= limpiar_dato($correcto) ?></div>
    <?php endif; ?>

    <?php if ($errores): ?>
        <div class="msg-error">
            <?php foreach ($errores as $e): ?>
                <p><?= limpiar_dato($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>