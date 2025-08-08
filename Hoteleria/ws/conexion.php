<?php
function conectar(): PDO {
    try {
        $conexion = new PDO(
            'mysql:host=localhost;port=3306;dbname=hoteleria;charset=utf8', 
            'root', 
            ''
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $conexion;
    } catch (PDOException $e) {
        // Lanzar excepción en lugar de morir
        throw new Exception('Error de conexión: ' . $e->getMessage());
    }
}

