<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/models/actualizar_usuario_model.php');

class ActualizarUsuarioController {
    private $model;

    public function __construct() {
        $this->model = new ActualizarUsuarioModel();
    }

    public function obtenerUsuario($id_usuario) {
        try {
            $usuario = $this->model->obtenerUsuario($id_usuario);
            $roles = $this->model->obtenerRoles();
            
            return [
                'success' => true,
                'usuario' => $usuario,
                'roles' => $roles
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function actualizarUsuario($datos) {
        try {
            // Validaciones básicas
            if (empty($datos['id_usuario'])) {
                throw new Exception("ID de usuario es requerido");
            }
            
            $actualizado = $this->model->actualizarUsuario($datos);
            
            return [
                'success' => true,
                'message' => 'Usuario actualizado exitosamente'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}