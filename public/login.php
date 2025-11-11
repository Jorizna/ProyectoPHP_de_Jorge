<?php
// ==============================
// public/login.php
// ==============================

session_start();

// ✅ Aseguramos que el array de usuarios exista
if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

$errors = [];
$success = '';

// ✅ Mostrar mensaje si el registro fue correcto
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// ✅ Si el usuario ya está logueado, redirigir al perfil
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

// ✅ Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Todos los campos son obligatorios.';
    } else {
        $found = false;
        foreach ($_SESSION['users'] as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                // ✅ Credenciales válidas → crear sesión
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email']
                ];
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
    <div class="msg-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="msg-error">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
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