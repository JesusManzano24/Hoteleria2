<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Llamar al controlador
require_once __DIR__ . '/../controller/RegistroController.php';
RegistroController::registrar();
?>


