<?php
require_once('../models/CrearAlojamientoModel.php');

session_start();

// Validar parámetros
if (empty($_GET['id']) || empty($_GET['img'])) {
    header("HTTP/1.0 404 Not Found");
    exit;
}

$idAlojamiento = (int)$_GET['id'];
$nombreImagen = basename($_GET['img']);
$rutaImagen = "../uploads/imagenes/$idAlojamiento/$nombreImagen";  // Ruta modificada

// Verificar que la imagen exista y pertenezca al usuario
$model = new CrearAlojamientoModel();
if ($model->validarImagen($idAlojamiento, $nombreImagen, $_SESSION['id_usuario'] ?? 0) && file_exists($rutaImagen)) {
    $tipo = mime_content_type($rutaImagen);
    header("Content-Type: $tipo");
    readfile($rutaImagen);
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}