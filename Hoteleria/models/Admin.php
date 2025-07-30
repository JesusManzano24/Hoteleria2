<?php
// models/Admin.php
require_once '../ws/conexion.php';

class Admin
{
    public static function authenticate(string $correo, string $password): array
    {
        try {
            $conn = conectar(); // Esto devuelve un objeto PDO
            
            $sql = "
                SELECT 
                    id_usuario,
                    `contraseña` AS contrasena,
                    id_rol
                FROM usuarios
                WHERE correo = :correo
                  AND id_rol = 1
                LIMIT 1
            ";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() !== 1) {
                return ['success' => false, 'error' => 'Administrador no encontrado.'];
            }
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashInput = hash('sha512', $password);
            
            // Debug (recomendado)
            error_log("Hash ingresado: $hashInput");
            error_log("Hash en DB: {$user['contrasena']}");
            
            if ($hashInput !== $user['contrasena']) {
                return ['success' => false, 'error' => 'Contraseña incorrecta.'];
            }
            
            return ['success' => true, 'admin_id' => (int)$user['id_usuario']];
            
        } catch (PDOException $e) {
            error_log("Error en Admin::authenticate: " . $e->getMessage());
            return ['success' => false, 'error' => 'Error interno en el servidor.'];
        }
    }
}