<?php

$DB_HOST = "localhost";     
$DB_USER = "root";           
$DB_PASS = "";               
$DB_NAME = "mountain-connect"; 


//ajustes generales del sitio
$site_name = "MountainConnect";
$base_url  = "http://localhost/mountain-connect/"; 

// inicio de sesión 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>