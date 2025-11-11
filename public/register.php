<?php
// ==============================
// public/register.php
// ==============================

// 1️⃣ Iniciar la sesión
session_start();

// 2️⃣ Asegurar que el array de usuarios exista
if (!isset($_SESSION['users']) || !is_array($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

// 3️⃣ Variables auxiliares
$errors = [];
$success = '';

// 4️⃣ Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Validaciones básicas
    if ($username === '' || $email === '' || $password === '' || $confirm === '') {
        $errors[] = 'Todos los campos son obligatorios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El formato del email no es válido.';
    } elseif ($password !== $confirm) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    // Verificar que el email no esté repetido
    foreach ($_SESSION['users'] as $u) {
        if ($u['email'] === $email) {
            $errors[] = 'Ya existe un usuario con ese correo electrónico.';
            break;
        }
    }

    // Si no hay errores → registrar usuario
    if (empty($errors)) {
        $_SESSION['users'][] = [
            'id' => count($_SESSION['users']) + 1,
            'username' => $username,
            'email' => $email,
            // En esta fase sin base de datos ni hash
            'password' => $password
        ];

        // Guardar mensaje de éxito para mostrar en login
        $_SESSION['success'] = 'Registro correcto. Ya puedes iniciar sesión.';
        header('Location: /mountain-connect/public/login.php');
        exit;
    }
}

// 5️⃣ Incluir el header
include_once __DIR__ . '/../includes/header.php';
?>

<h2>Registro</h2>

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
    <label>Nombre de usuario:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required><br><br>

    <label>Contraseña:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Confirmar contraseña:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Registrarse</button>
</form>

<p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>