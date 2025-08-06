<?php
// Usamos $_SERVER['DOCUMENT_ROOT'] para obtener la ruta absoluta desde la raíz del servidor
$root = $_SERVER['DOCUMENT_ROOT'];
$controllerPath = $root . '/Hoteleria/controller/crear_alojamientoController.php';

// Verificamos si el archivo existe antes de requerirlo
if (!file_exists($controllerPath)) {
    die("Error: El archivo del controlador no se encontró en: " . $controllerPath);
}

require_once $controllerPath;

$controller = new CrearAlojamientoController();
$controller->procesarFormulario();