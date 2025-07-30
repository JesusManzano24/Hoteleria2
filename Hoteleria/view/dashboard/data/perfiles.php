<?php
header('Content-Type: application/json');
require_once('../../../ws/conexion.php');
$conn = conectar(); // ✅ Esto te da una instancia de PDO


$sql = "SELECT 
    u.id_usuario,
    u.genero,
    u.origen,
    COUNT(r.id_reserva) AS total_reservas,
    AVG(a.precio) AS precio_promedio,
    AVG(servicios_por_aloja.total_servicios) AS servicios_promedio
FROM usuarios u
JOIN reservas r ON u.id_usuario = r.id_usuario
JOIN alojamientos a ON r.id_alojamiento = a.id_alojamiento
JOIN (
    SELECT id_alojamiento, COUNT(*) AS total_servicios
    FROM alojamiento_servicio
    GROUP BY id_alojamiento
) AS servicios_por_aloja ON a.id_alojamiento = servicios_por_aloja.id_alojamiento
GROUP BY u.id_usuario
HAVING servicios_promedio > 3 AND precio_promedio > (
    SELECT AVG(precio) FROM alojamientos
)
ORDER BY servicios_promedio DESC";

$result = $conn->query($sql);
$data = [];

$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $data[] = [
        'genero' => $row['genero'],
        'origen' => $row['origen'],
        'reservas' => (int)$row['total_reservas'],
        'precio' => round((float)$row['precio_promedio'], 2),
        'servicios' => round((float)$row['servicios_promedio'], 2),
    ];
}

echo json_encode($data);
