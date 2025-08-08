<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/ws/conexion.php');

class ActualizarUsuarioModel {
    private $pdo;

    public function __construct() {
        $this->pdo = conectar();
    }

    public function obtenerUsuario($id_usuario) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT u.*, r.nombre_rol as rol 
                 FROM usuarios u
                 JOIN roles_usuario r ON u.id_rol = r.id_rol
                 WHERE u.id_usuario = :id_usuario"
            );
            $stmt->execute([':id_usuario' => $id_usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuario: " . $e->getMessage());
        }
    }

    public function actualizarUsuario($datosUsuario) {
        try {
            // Validar datos requeridos
            if (empty($datosUsuario['id_usuario'])) {
                throw new Exception('ID de usuario es requerido');
            }

            // Valor por defecto para tipo
            $tipo = $datosUsuario['tipo'] ?? 'Huesped';
            
            // Mapeo de roles
            $id_rol = match(strtolower($tipo)) {
                'admin' => 1,
                'anfitrion' => 2,
                'huesped' => 3,
                default => throw new Exception('Tipo de usuario inválido')
            };

            $this->pdo->beginTransaction();

            // Construir consulta dinámica
            $updates = ['id_rol = :id_rol'];
            $params = [
                ':id_usuario' => $datosUsuario['id_usuario'],
                ':id_rol' => $id_rol
            ];

            // Campos opcionales
            $campos = [
                'nombre' => ':nombre',
                'correo' => ':correo',
                'telefono' => ':telefono', 
                'genero' => ':genero',
                'origen' => ':origen',
                'fecha_nac' => ':fecha_nac'
            ];

            foreach ($campos as $campo => $param) {
                if (!empty($datosUsuario[$campo])) {
                    $updates[] = "$campo = $param";
                    $params[$param] = $datosUsuario[$campo];
                }
            }

            // Validar correo único
            if (!empty($datosUsuario['correo'])) {
                $stmt = $this->pdo->prepare(
                    'SELECT COUNT(*) FROM usuarios 
                     WHERE correo = :correo AND id_usuario != :id_usuario'
                );
                $stmt->execute([
                    ':correo' => $datosUsuario['correo'],
                    ':id_usuario' => $datosUsuario['id_usuario']
                ]);
                
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception('Este correo ya está registrado');
                }
            }

            // Actualizar contraseña si se proporciona
            if (!empty($datosUsuario['password'])) {
                $updates[] = 'contraseña = :password';
                $params[':password'] = hash('sha512', $datosUsuario['password']);
            }

            $query = "UPDATE usuarios SET " . implode(', ', $updates) . 
                     " WHERE id_usuario = :id_usuario";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);

            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error de base de datos: " . $e->getMessage());
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }
    
    public function obtenerRoles() {
        $stmt = $this->pdo->query("SELECT * FROM roles_usuario");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}