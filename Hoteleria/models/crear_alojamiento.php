<?php
require_once('../ws/conexion.php');

class CrearAlojamientoModel {
    private $pdo;

    public function __construct() {
        $this->pdo = conectar();
    }

    public function crearAlojamiento($data) {
        $sql = "INSERT INTO alojamientos 
                (id_usuario, nombre, id_tipo_alojamiento, direccion, descripcion, precio, capacidad, latitud, longitud, id_estado)
                VALUES (:id_usuario, :nombre, :tipo, :direccion, :descripcion, :precio, :capacidad, :latitud, :longitud, :estado)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $data['id_usuario'],
            ':nombre' => $data['nombre'],
            ':tipo' => $data['id_tipo_alojamiento'],
            ':direccion' => $data['direccion'],
            ':descripcion' => $data['descripcion'],
            ':precio' => $data['precio'],
            ':capacidad' => $data['capacidad'],
            ':latitud' => $data['latitud'],
            ':longitud' => $data['longitud'],
            ':estado' => $data['id_estado']
        ]);
        
        return $this->pdo->lastInsertId();
    }

    public function guardarImagen($idAlojamiento, $nombreArchivo) {
        $sql = "INSERT INTO imagenes_alojamiento (id_alojamiento, ruta_imagen) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$idAlojamiento, $nombreArchivo]);
    }

    public function obtenerTiposAlojamiento() {
        $stmt = $this->pdo->query("SELECT * FROM tipos_alojamiento");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstadosAlojamiento() {
        $stmt = $this->pdo->query("SELECT * FROM estados_alojamiento");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validarImagen($idAlojamiento, $nombreImagen, $idUsuario) {
        $sql = "SELECT 1 FROM imagenes_alojamiento i 
                JOIN alojamientos a ON i.id_alojamiento = a.id_alojamiento
                WHERE i.id_alojamiento = ? AND i.ruta_imagen = ? AND a.id_usuario = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$idAlojamiento, $nombreImagen, $idUsuario]);
        return $stmt->fetch() !== false;
    }
}