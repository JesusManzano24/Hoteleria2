<?php
// Configuración inicial
ini_set('display_errors', 0);
ini_set('log_errors', 1);
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// Función para manejar errores
function jsonError($message, $code = 500) {
    http_response_code($code);
    die(json_encode([
        'success' => false,
        'message' => $message
    ]));
}

// Manejar errores fatales
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== null) {
        jsonError('Error fatal: ' . $error['message']);
    }
});

try {
    // Incluir controlador
    require_once $_SERVER['DOCUMENT_ROOT'].'/Hoteleria/controller/actualizar_usuario_controller.php';
    
    // Solo aceptar POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonError("Método no permitido", 405);
    }

    // Obtener datos JSON
    $json = file_get_contents('php://input');
    if (!$json) {
        jsonError("No se recibieron datos");
    }

    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        jsonError("JSON inválido: " . json_last_error_msg());
    }

    // Procesar la solicitud
    $controller = new ActualizarUsuarioController();
    $result = $controller->actualizarUsuario($data);

    // Respuesta exitosa
    http_response_code(200);
    echo json_encode($result);
    exit;

} catch (Exception $e) {
    jsonError($e->getMessage());
}