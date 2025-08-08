<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hoteleria/ws/conexion.php');

class EliminarUsuarioModel {
    private $pdo;

    public function __construct() {
        $this->pdo = conectar();
    }

    public function eliminarUsuario($id_usuario) {
        try {
            $this->pdo->beginTransaction();

            // Verificar si el usuario existe primero
            $stmt = $this->pdo->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = :id");
            $stmt->execute([':id' => $id_usuario]);
            
            if (!$stmt->fetch()) {
                throw new Exception("El usuario no existe");
            }

            // Eliminar usuario
            $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
            $stmt->execute([':id' => $id_usuario]);

            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Error al eliminar usuario: " . $e->getMessage());
        }
    }
}