<?php
require_once __DIR__ . '/../ws/wshoteleria.php';

class LoginUsuario
{
    public static function autenticar(string $email, string $password): array
    {
        $conn = conectar();

        $sql = "SELECT id_usuario, id_rol, contraseña AS contrasena 
                FROM usuarios 
                WHERE correo = :correo 
                LIMIT 1";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':correo' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ['success' => false, 'error' => 'Correo o contraseña inválidos.'];
        }

        $hashInput = hash('sha512', $password);

        if ($hashInput !== $user['contrasena']) {
            return ['success' => false, 'error' => 'Correo o contraseña inválidos.'];
        }

        return [
            'success' => true,
            'user_id' => (int)$user['id_usuario'],
            'user_role' => (int)$user['id_rol']
        ];
    }
}
