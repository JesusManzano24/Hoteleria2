<?php
// controller/LoginAdminController.php

// --- PASO 1: Limpieza inicial de buffers ---
while (ob_get_level() > 0) {
    ob_end_clean();
}

// --- PASO 2: Configuración de errores ---
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/login_errors.log');

// --- PASO 3: Verificar si ya se enviaron headers ---
if (headers_sent($filename, $linenum)) {
    // Registrar el problema pero NO intentar enviar más headers
    error_log("ERROR CRÍTICO: Headers ya enviados en $filename:$linenum");
    // Simplemente terminar la ejecución
    exit;
}

// --- PASO 4: Incluir dependencias ---
require_once __DIR__ . '/../models/Admin.php';

class LoginAdminController
{
    public static function login(): void
    {
        // --- PASO 5: Limpieza adicional antes de cualquier operación ---
        if (ob_get_length()) ob_clean();
        
        // --- PASO 6: Establecer headers ---
        header('Content-Type: application/json; charset=UTF-8');
        
        try {
            // --- PASO 7: Verificar método HTTP ---
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido', 405);
            }
            
            // --- PASO 8: Leer y validar input ---
            $jsonInput = file_get_contents('php://input');
            
            if (empty($jsonInput)) {
                throw new Exception('No se recibieron datos', 400);
            }
            
            $payload = json_decode($jsonInput, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('JSON inválido: ' . json_last_error_msg(), 400);
            }
            
            if (empty($payload['correo']) || empty($payload['password'])) {
                throw new Exception('Faltan correo o contraseña', 400);
            }
            
            // --- PASO 9: Autenticar ---
            $result = Admin::authenticate($payload['correo'], $payload['password']);
            
            // --- PASO 10: Manejar resultado ---
            if ($result['success']) {
                // Iniciar sesión solo si no se han enviado headers
                if (!headers_sent()) {
                    session_start();
                    $_SESSION['admin_id'] = $result['admin_id'];
                    $_SESSION['admin_email'] = $payload['correo'];
                }
                
                echo json_encode([
                    'success' => true,
                    'redirect' => '../../view/dashboard/dashboard.html'
                ]);
            } else {
                echo json_encode($result);
            }
            
        } catch (Throwable $e) {
            // --- PASO 11: Manejar errores sin headers ---
            $response = [
                'success' => false,
                'error' => 'Error interno: ' . $e->getMessage()
            ];
            
            if (!headers_sent()) {
                http_response_code(500);
            }
            
            echo json_encode($response);
        }
        
        exit;
    }
}

// --- PASO 12: Ejecutar el controlador de forma segura ---
try {
    LoginAdminController::login();
} catch (Throwable $e) {
    // Respuesta de último recurso si todo falla
    $response = [
        'success' => false,
        'error' => 'Error crítico: ' . $e->getMessage()
    ];
    
    if (!headers_sent()) {
        header('Content-Type: application/json; charset=UTF-8');
    }
    
    echo json_encode($response);
}