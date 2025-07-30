<?php
header('Content-Type: application/json');
require_once('../../../ws/conexion.php');
$conn = conectar(); // ✅ Esto te da una instancia de PDO


$sql = "SELECT 
    u.genero,
    u.origen,
    u.fecha_nac,
    COUNT(c.id_compartido) AS veces_compartido
FROM compartidos c
JOIN usuarios u ON c.id_usuario = u.id_usuario
GROUP BY u.id_usuario
ORDER BY veces_compartido DESC
LIMIT 10";

$result = $conn->query($sql);

$labels = [];
$valores = [];

$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $label = "{$row['genero']} | {$row['origen']} | " . substr($row['fecha_nac'], 0, 4);
    $labels[] = $label;
    $valores[] = (int)$row['veces_compartido'];
}

echo json_encode(['labels' => $labels, 'valores' => $valores]);
