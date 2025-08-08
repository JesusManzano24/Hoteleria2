<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/Hoteleria/controller/eliminar_usuario_controller.php';
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método no permitido", 405);
    }

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (empty($data['id_usuario'])) {
        throw new Exception("ID de usuario no proporcionado");
    }

    $controller = new EliminarUsuarioController();
    $resultado = $controller->eliminarUsuario($data['id_usuario']);
    
    http_response_code($resultado['success'] ? 200 : 400);
    echo json_encode($resultado);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
    exit;
}