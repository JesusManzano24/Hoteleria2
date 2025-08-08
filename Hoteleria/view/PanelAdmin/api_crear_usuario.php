<?php
// Limpiar buffers
while (ob_get_level()) ob_end_clean();
ob_start();

// Configurar cabeceras
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    // Incluir controlador con ruta absoluta
    require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/controller/crear_usuario_controller.php');
    
    // Obtener datos JSON
    $json = file_get_contents('php://input');
    if (!$json) {
        throw new Exception('No se recibieron datos');
    }
    
    $datos = json_decode($json, true);
    if (!$datos) {
        throw new Exception('Datos JSON no válidos');
    }

    // Procesar solicitud
    $controller = new CrearUsuarioController();
    $resultado = $controller->procesarFormulario($datos);
    
    // Enviar respuesta
    ob_end_clean();
    http_response_code($resultado['success'] ? 200 : 400);
    echo json_encode($resultado);
    exit;

} catch (Exception $e) {
    ob_end_clean();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
    exit;
}