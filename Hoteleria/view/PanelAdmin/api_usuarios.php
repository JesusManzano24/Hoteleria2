<?php
// Limpiar buffer
ob_start();

// Headers para JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Ruta absoluta al modelo
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/models/listar_usuarios_model.php');

try {
    $model = new ListarUsuariosModel();
    $usuarios = $model->obtenerTodosUsuarios();
    
    ob_end_clean();
    
    echo json_encode([
        'status' => 'success',
        'data' => $usuarios
    ]);
    exit;

} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}