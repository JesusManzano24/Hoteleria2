<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/models/eliminar_usuario_model.php');

class EliminarUsuarioController {
    private $model;

    public function __construct() {
        $this->model = new EliminarUsuarioModel();
    }

    public function eliminarUsuario($id_usuario) {
        try {
            if (empty($id_usuario)) {
                throw new Exception("ID de usuario es requerido");
            }

            $eliminado = $this->model->eliminarUsuario($id_usuario);
            
            return [
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}