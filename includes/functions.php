<?php
function validar_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function verificar_sesion_activa(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        header('Location: /mountain-connect/public/login.php');
        exit;
    }
}

function limpiar_dato(string $texto): string
{
    return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
}
