<?php
// models/RegistroUsuario.php
require_once __DIR__ . '/../ws/conexion.php';

class RegistroUsuario
{
    public static function crear(array $data): array
    {
        try {
            // Obtener conexión PDO
            $conn = conectar();

            // Mapeo seguro de datos
            $tipo = $data['tipo'] ?? '';
            $nombre = $data['nombre'] ?? '';
            $correo = $data['correo'] ?? '';
            $password = $data['password'] ?? '';
            $telefono = $data['telefono'] ?? '';
            $genero = $data['genero'] ?? '';
            $origen = $data['origen'] ?? '';
            $fecha_nac = $data['fecha_nac'] ?? '';
            $fecha_registro = $data['fecha_registro'] ?? date('Y-m-d H:i:s');

            // Validación básica
            if (empty($tipo) || empty($nombre) || empty($correo) || empty($password) || empty($telefono)) {
                throw new Exception('Faltan campos obligatorios');
            }

            // Validar formato de email
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Formato de correo inválido');
            }

            // Mapeo de roles (case-insensitive)
            switch (strtolower($tipo)) {
                case 'admin': $id_rol = 1; break;
                case 'anfitrion': $id_rol = 2; break;
                case 'huesped': $id_rol = 3; break;
                default: throw new Exception('Tipo de usuario inválido');
            }

            // Hash de contraseña
            $password_hash = hash('sha512', $password);

            // Iniciar transacción
            $conn->beginTransaction();

            // Verificar si ya existe el correo
            $stmt = $conn->prepare('SELECT COUNT(*) FROM usuarios WHERE correo = :correo');
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Este correo ya está registrado');
            }

            // Insertar nuevo usuario
            $stmt = $conn->prepare(
                'INSERT INTO usuarios 
                (id_rol, nombre, correo, telefono, contraseña, genero, origen, fecha_nac, fecha_registro) 
                VALUES 
                (:id_rol, :nombre, :correo, :telefono, :password, :genero, :origen, :fecha_nac, :fecha_registro)'
            );

            $stmt->execute([
                ':id_rol' => $id_rol,
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':telefono' => $telefono,
                ':password' => $password_hash,
                ':genero' => $genero,
                ':origen' => $origen,
                ':fecha_nac' => $fecha_nac,
                ':fecha_registro' => $fecha_registro
            ]);

            $id_usuario = $conn->lastInsertId();
            $conn->commit();

            return [
                'success' => true,
                'id_usuario' => $id_usuario
            ];

        } catch (PDOException $e) {
            // Revertir en caso de error
            if (isset($conn) && $conn->inTransaction()) {
                $conn->rollBack();
            }
            return [
                'success' => false,
                'error' => 'Error en la base de datos: ' . $e->getMessage()
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}