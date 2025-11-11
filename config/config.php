<?php
// ----------------------------------------------------------------------
// CONFIGURACIÓN GENERAL DEL PROYECTO
// ----------------------------------------------------------------------

// 1. Datos de conexión a la base de datos
// Guarda aquí las credenciales que usará PHP para conectarse a MySQL
$DB_HOST = "localhost";      // Servidor (normalmente localhost)
$DB_USER = "root";           // Usuario (por defecto en XAMPP)
$DB_PASS = "";               // Contraseña (vacía por defecto)
$DB_NAME = "mountain-connect"; // Nombre de tu base de datos

// 2. Conexión a la base de datos
// (Aquí normalmente se crea la conexión con mysqli o PDO)
// Ejemplo conceptual:
// $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// 3. Comprobación de errores de conexión
// if ($conn->connect_error) {
//     die("Error de conexión: " . $conn->connect_error);
// }

// 4. Ajustes generales del sitio
$site_name = "MountainConnect";
$base_url  = "http://localhost/mountain-connect/"; // Ajusta a tu entorno local

// 5. Inicio de sesión (opcional, según tu flujo)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ----------------------------------------------------------------------
// FIN DE CONFIGURACIÓN
// ----------------------------------------------------------------------
?>º