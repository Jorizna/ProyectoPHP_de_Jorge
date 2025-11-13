<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

// Aseguramos el array de usuarios
if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

$errors = [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);

if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = limpiar_dato($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Todos los campos son obligatorios.';
    } elseif (!validar_email($email)) {
        $errors[] = 'El formato del email no es válido.';
    } else {
        $found = false;
        foreach ($_SESSION['users'] as $u) {
            if ($u['email'] === $email && $u['password'] === $password) {
                $_SESSION['user'] = $u;
                $found = true;
                break;
            }
        }

        if ($found) {
            header('Location: profile.php');
            exit;
        } else {
            $errors[] = 'Email o contraseña incorrectos.';
        }
    }
}

include_once __DIR__ . '/../includes/header.php';
?>

<h2>Iniciar Sesión</h2>

<?php if ($success): ?>
    <div class="msg-success"><?= limpiar_dato($success) ?></div>
<?php endif; ?>

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
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Entrar</button>
</form>

<p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>