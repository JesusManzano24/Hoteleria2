<?php
session_start();
header('Content-Type: application/json');
include("../includes/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Debes iniciar sesión.']);
    exit;
}

// Consulta para obtener los alojamientos del usuario logueado
$sql = "SELECT a.*, t.nombre AS tipo_alojamiento, e.nombre AS estado 
        FROM alojamientos a
        JOIN tipos_alojamiento t ON a.id_tipo_alojamiento = t.id_tipo
        JOIN estados_alojamiento e ON a.id_estado = e.id_estado
        WHERE a.id_usuario = ? ORDER BY a.id_alojamiento DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();

$alojamientos = [];

while ($row = $result->fetch_assoc()) {
    $alojamientos[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($alojamientos);
?>
