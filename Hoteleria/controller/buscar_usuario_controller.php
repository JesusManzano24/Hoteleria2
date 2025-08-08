<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/models/buscar_usuario_model.php');

class BuscarUsuarioController {
    private $model;

    public function __construct() {
        $this->model = new BuscarUsuarioModel();
    }

    public function buscarUsuario($correo) {
        try {
            if (empty($correo)) {
                throw new Exception("Correo electrónico es requerido");
            }

            $usuario = $this->model->buscarPorCorreo($correo);
            
            if (!$usuario) {
                throw new Exception("Usuario no encontrado");
            }

            return [
                'success' => true,
                'usuario' => $usuario
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}