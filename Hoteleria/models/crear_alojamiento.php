<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$conexionPath = $root . '/../ws/wshoteleria.php';

if (!file_exists($conexionPath)) {
    die("Error: El archivo de conexión no se encontró en: " . $conexionPath);
}

class CrearAlojamientoModel {
    private $pdo;

    public function __construct() {
        $this->pdo = conectar();
    }

    public function crearAlojamiento($datos) {
        try {
            $sql = "INSERT INTO alojamientos 
                    (id_usuario, nombre, id_tipo_alojamiento, direccion, descripcion, precio, capacidad, latitud, longitud, id_estado)
                    VALUES (:id_usuario, :nombre, :tipo, :direccion, :descripcion, :precio, :capacidad, :latitud, :longitud, :estado)";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $datos['id_usuario'],
                ':nombre' => $datos['nombre'],
                ':tipo' => $datos['id_tipo_alojamiento'],
                ':direccion' => $datos['direccion'],
                ':descripcion' => $datos['descripcion'],
                ':precio' => $datos['precio'],
                ':capacidad' => $datos['capacidad'],
                ':latitud' => $datos['latitud'],
                ':longitud' => $datos['longitud'],
                ':estado' => $datos['id_estado']
            ]);
            
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error al crear alojamiento: " . $e->getMessage());
        }
    }

    public function guardarImagen($idAlojamiento, $nombreArchivo) {
        try {
            $sql = "INSERT INTO imagenes (id_alojamiento, url_imagen) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$idAlojamiento, $nombreArchivo]);
        } catch (PDOException $e) {
            throw new Exception("Error al guardar imagen: " . $e->getMessage());
        }
    }
}