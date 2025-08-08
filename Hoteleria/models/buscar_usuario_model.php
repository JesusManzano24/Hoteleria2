<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/ws/conexion.php');

class BuscarUsuarioModel {
    private $pdo;

    public function __construct() {
        $this->pdo = conectar();
    }

    public function buscarPorCorreo($correo) {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT u.*, r.nombre_rol as rol 
                 FROM usuarios u
                 JOIN roles_usuario r ON u.id_rol = r.id_rol
                 WHERE u.correo = :correo"
            );
            $stmt->execute([':correo' => $correo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            throw new Exception("Error al buscar usuario: " . $e->getMessage());
        }
    }
}