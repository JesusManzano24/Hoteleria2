<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/models/crear_usuario_model.php');

class CrearUsuarioController {
    private $model;

    public function __construct() {
        $this->model = new CrearUsuarioModel();
    }

    public function procesarFormulario($datos) {
        try {
            // Procesar con el modelo
            $resultado = $this->model->crearUsuario($datos);
            
            return [
                'success' => true,
                'id_usuario' => $resultado['id_usuario'],
                'message' => 'Usuario creado exitosamente'
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}