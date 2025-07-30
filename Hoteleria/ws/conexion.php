
<?php
function conectar(): PDO {
    try {
        $conexion = new PDO('mysql:host=localhost;port=3306;dbname=hoteleria', 'root', '');
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("SET NAMES utf8");
        return $conexion;
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
}
