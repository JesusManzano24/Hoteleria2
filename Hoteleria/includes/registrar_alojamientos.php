<?php
session_start();
include("../includes/conexion.php");

// Validar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión para realizar esta acción");
}

// Validar campos del formulario
$camposRequeridos = ['nombre', 'descripcion', 'id_tipo_alojamiento', 'id_estado', 
                    'direccion', 'capacidad', 'precio', 'latitud', 'longitud'];

foreach ($camposRequeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        die("El campo $campo es requerido");
    }
}

// Preparar datos
$datos = [
    'id_usuario' => $_SESSION['id_usuario'],
    'nombre' => trim($_POST['nombre']),
    'descripcion' => trim($_POST['descripcion']),
    'id_tipo' => intval($_POST['id_tipo_alojamiento']),
    'id_estado' => intval($_POST['id_estado']),
    'direccion' => trim($_POST['direccion']),
    'capacidad' => intval($_POST['capacidad']),
    'precio' => floatval($_POST['precio']),
    'latitud' => floatval($_POST['latitud']),
    'longitud' => floatval($_POST['longitud'])
];

// Insertar en la base de datos
$sql = "INSERT INTO alojamientos (id_usuario, nombre, id_tipo_alojamiento, direccion, descripcion, precio, capacidad, latitud, longitud, id_estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("isisssddii", 
        $datos['id_usuario'],
        $datos['nombre'],
        $datos['id_tipo'],
        $datos['direccion'],
        $datos['descripcion'],
        $datos['precio'],
        $datos['capacidad'],
        $datos['latitud'],
        $datos['longitud'],
        $datos['id_estado']
    );
    
    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "Alojamiento registrado correctamente";
    } else {
        $_SESSION['mensaje_error'] = "Error al registrar el alojamiento: " . $stmt->error;
    }
    $stmt->close();
} else {
    $_SESSION['mensaje_error'] = "Error en la preparación: " . $conn->error;
}

$conn->close();
header("Location: ../pages/gestion_alojamientos.php");
exit();
?>