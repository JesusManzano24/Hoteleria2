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
class Conexion{

    public static function conectar() {
        try {
            $conexion = new PDO('mysql:host=sql104.infinityfree.com;port=3306;dbname=if0_39521767_hoteleria', 'if0_39521767', 'yi9lsMYhL7KV7');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->exec("SET NAMES utf8");
            return $conexion;
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }
}




