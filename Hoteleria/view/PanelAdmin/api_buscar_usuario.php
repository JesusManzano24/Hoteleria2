<?php
// Configuración inicial
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

try {
    require_once $_SERVER['DOCUMENT_ROOT'].'/Hoteleria/controller/buscar_usuario_controller.php';
    
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception("Método no permitido", 405);
    }

    $correo = $_GET['correo'] ?? null;
    
    $controller = new BuscarUsuarioController();
    $resultado = $controller->buscarUsuario($correo);
    
    http_response_code($resultado['success'] ? 200 : 404);
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