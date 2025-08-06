<?php
// Usar ruta absoluta desde el directorio raíz
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/ws/conexion.php');

class ListarUsuariosModel {
    private $pdo;

    public function __construct() {
        $this->pdo = conectar();
    }

    public function obtenerTodosUsuarios() {
        try {
            $query = "SELECT u.*, r.nombre_rol as rol 
          FROM usuarios u
          JOIN roles_usuario r ON u.id_rol = r.id_rol
          ORDER BY u.id_usuario ASC";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener usuarios: " . $e->getMessage());
        }
    }
}
