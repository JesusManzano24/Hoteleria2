<?php
// models/Admin.php
require_once __DIR__ . '/../ws/conexion.php';

class Admin
{
    public static function authenticate(string $correo, string $password): array
    {
        try {
            error_log("Conectando a la base de datos...");
            $conn = conectar();
            
            // Consulta segura con parámetros
            $sql = "SELECT id_usuario, contraseña AS contrasena 
                    FROM usuarios 
                    WHERE correo = :correo 
                    AND id_rol = 1 
                    LIMIT 1";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                error_log("Usuario no encontrado o no es administrador");
                return [
                    'success' => false, 
                    'error' => 'Administrador no encontrado'
                ];
            }
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashInput = hash('sha512', $password);
            
            // Comparación segura de hashes
            if (!hash_equals($user['contrasena'], $hashInput)) {
                error_log("Contraseña incorrecta");
                return [
                    'success' => false, 
                    'error' => 'Contraseña incorrecta'
                ];
            }
            
            return [
                'success' => true, 
                'admin_id' => (int)$user['id_usuario']
            ];
            
        } catch (PDOException $e) {
            error_log("Error DB: " . $e->getMessage());
            return [
                'success' => false, 
                'error' => 'Error de base de datos'
            ];
        } catch (Throwable $e) {
            error_log("Error inesperado: " . $e->getMessage());
            return [
                'success' => false, 
                'error' => 'Error interno'
            ];
        }
    }
}