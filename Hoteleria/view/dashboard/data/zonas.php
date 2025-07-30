<?php
header('Content-Type: application/json');
require_once('../../../ws/conexion.php');
$conn = conectar(); // ✅ Esto te da una instancia de PDO

$sql = "SELECT 
    a.direccion,
    MONTH(r.fecha_inicio) AS mes,
    COUNT(*) AS total_reservas_efectivas
FROM reservas r
JOIN alojamientos a ON r.id_alojamiento = a.id_alojamiento
JOIN estados_reserva er ON r.id_estado_reserva = er.id_estado_reserva
WHERE er.nombre_estado IN ('Confirmada', 'Completada')
GROUP BY a.direccion, mes
ORDER BY a.direccion, mes";

$result = $conn->query($sql);

$zonas = [];
$colores = ['#e6194b','#3cb44b','#ffe119','#4363d8','#f58231','#911eb4','#46f0f0','#f032e6'];

$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $zona = $row['direccion'];
    $mes = (int)$row['mes'];
    $total = (int)$row['total_reservas_efectivas'];

    if (!isset($zonas[$zona])) {
        $zonas[$zona] = array_fill(1, 12, 0);
    }
    $zonas[$zona][$mes] = $total;
}

$output = [];
$i = 0;
foreach ($zonas as $zona => $valores) {
    $output[] = [
        'nombre' => $zona,
        'valores' => array_values($valores),
        'color' => $colores[$i % count($colores)],
    ];
    $i++;
}

echo json_encode(['meses' => range(1, 12), 'zonas' => $output]);
