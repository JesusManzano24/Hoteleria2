<?php
// controller/LoginAdminController.php
require_once  '../models/Admin.php';

class LoginAdminController
{
    public static function login(): void
    {
        // Devolver siempre JSON
        header('Content-Type: application/json; charset=UTF-8');
        session_start();

        // Leer payload JSON
        $payload = json_decode(file_get_contents('php://input'), true);

        // Validar entrada
        if (empty($payload['correo']) || empty($payload['password'])) {
            echo json_encode(['success' => false, 'error' => 'Faltan correo o contraseña.']);
            exit;
        }

        // Autenticar
        $res = Admin::authenticate($payload['correo'], $payload['password']);

        if (! $res['success']) {
            echo json_encode($res);
            exit;
        }

        // Guardar sesión
        $_SESSION['admin_id'] = $res['admin_id'];

        // Respuesta exitosa
        echo json_encode(['success' => true]);
        exit;
    }
}