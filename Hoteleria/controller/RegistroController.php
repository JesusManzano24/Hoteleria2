<?php
// controller/RegistroController.php
require_once __DIR__ . '/../models/RegistroUsuario.php';

class RegistroController
{
    public static function registrar()
    {
        // Solo aceptar POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'error' => 'Método no permitido'
            ]);
            exit;
        }

        // Obtener solo datos POST (ya no necesitamos FILES)
        $data = $_POST;

        // Llamar al modelo pasando solo $data
        $resultado = RegistroUsuario::crear($data);

        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($resultado);
    }
}

// Ejecutar solo si es llamado directamente
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    RegistroController::registrar();
}