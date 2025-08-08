<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/ws/conexion.php');

class CrearUsuarioModel {
    private $pdo;

    public function __construct() {
        $this->pdo = conectar();
    }

    public function crearUsuario($datosUsuario) {
        try {
            // Validar datos requeridos
            if (empty($datosUsuario['tipo']) || empty($datosUsuario['nombre']) || 
                empty($datosUsuario['correo']) || empty($datosUsuario['password'])) {
                throw new Exception('Faltan campos obligatorios');
            }

            // Validar formato de email
            if (!filter_var($datosUsuario['correo'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Formato de correo inválido');
            }

            // Mapeo de roles
            switch (strtolower($datosUsuario['tipo'])) {
                case 'admin': $id_rol = 1; break;
                case 'anfitrion': $id_rol = 2; break;
                case 'huesped': $id_rol = 3; break;
                default: throw new Exception('Tipo de usuario inválido');
            }

            // Hash de contraseña (SHA512 como en tu ejemplo)
            $password_hash = hash('sha512', $datosUsuario['password']);

            // Iniciar transacción
            $this->pdo->beginTransaction();

            // Verificar si el correo ya existe
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE correo = :correo');
            $stmt->execute([':correo' => $datosUsuario['correo']]);
            
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Este correo ya está registrado');
            }

            // Insertar nuevo usuario
            $stmt = $this->pdo->prepare(
                'INSERT INTO usuarios 
                (id_rol, nombre, correo, telefono, contraseña, genero, origen, fecha_nac, fecha_registro) 
                VALUES 
                (:id_rol, :nombre, :correo, :telefono, :password, :genero, :origen, :fecha_nac, NOW())'
            );

            $stmt->execute([
                ':id_rol' => $id_rol,
                ':nombre' => $datosUsuario['nombre'],
                ':correo' => $datosUsuario['correo'],
                ':telefono' => $datosUsuario['telefono'] ?? null,
                ':password' => $password_hash,
                ':genero' => $datosUsuario['genero'] ?? null,
                ':origen' => $datosUsuario['origen'] ?? null,
                ':fecha_nac' => $datosUsuario['fecha_nac'] ?? null
            ]);

            $id_usuario = $this->pdo->lastInsertId();
            $this->pdo->commit();

            return [
                'success' => true,
                'id_usuario' => $id_usuario
            ];

        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw new Exception('Error en la base de datos: ' . $e->getMessage());
        } catch (Exception $e) {
            if (isset($this->pdo) && $this->pdo->inTransaction()) {
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