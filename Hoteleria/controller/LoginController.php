<?php
// controller/LoginController.php
require_once __DIR__ . '/../models/LoginUsuario.php';

class LoginController
{
    public static function handleRequest(): void
    {
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido', 405);
            }

            // Manejar acción específica para admin
            if (isset($_GET['action']) && $_GET['action'] === 'admin') {
                self::handleAdminLogin();
                return;
            }

            // Login normal
            self::handleRegularLogin();
            
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private static function handleAdminLogin(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Datos JSON inválidos', 400);
        }

        $email = trim($input['correo'] ?? '');
        $password = trim($input['password'] ?? '');

        if (empty($email) || empty($password)) {
            throw new Exception('Correo y contraseña son requeridos', 400);
        }

        $result = LoginUsuario::autenticar($email, $password);
        
        if (!$result['success']) {
            throw new Exception($result['error'], 401);
        }

        // Verificar que sea admin (rol 1)
        if ($result['user_role'] != 1) {
            throw new Exception('Acceso solo para administradores', 403);
        }

        session_start();
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_role'] = $result['user_role'];

        echo json_encode([
            'success' => true,
            'redirect' => '/Hoteleria/view/admin/dashboard.html'
        ]);
    }

    private static function handleRegularLogin(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        if (empty($email) || empty($password)) {
            throw new Exception('Debes ingresar correo y contraseña', 400);
        }

        $result = LoginUsuario::autenticar($email, $password);
        
        if (!$result['success']) {
            throw new Exception($result['error'], 401);
        }

        session_start();
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_role'] = $result['user_role'];

        echo json_encode([
            'success' => true,
            'redirect' => self::getRedirectPath($result['user_role'])
        ]);
    }

    private static function getRedirectPath(int $role): string
    {
        switch ($role) {
            case 1: return '/Hoteleria/view/admin/dashboard.html';
            case 2: return '/Hoteleria/view/crudalojamientos/crud_alojamientos.html';
            case 3: return '/Hoteleria/view/alojamientos/alojamientos.html';
            default: throw new Exception('Rol no válido', 403);
        }
    }
}

// Ejecutar el controlador
LoginController::handleRequest();