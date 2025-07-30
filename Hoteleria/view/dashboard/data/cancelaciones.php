<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('../../../ws/conexion.php');
$conn = conectar();

try {
    // Consulta principal para obtener cancelaciones por mes, método de pago y tipo de alojamiento
    $sql = "
        SELECT 
    MONTH(r.fecha_reserva) AS mes,
    mp.nombre_metodo AS metodo_pago,
    ta.tipo_nombre AS tipo_alojamiento,
    COUNT(*) AS cantidad,
    (SELECT COUNT(*) FROM reservas WHERE id_estado_reserva = 2) AS total_general
FROM reservas r
JOIN pagos p ON r.id_reserva = p.id_reserva
JOIN metodos_pago mp ON p.id_metodo = mp.id_metodo
JOIN alojamientos a ON r.id_alojamiento = a.id_alojamiento
JOIN tipos_alojamiento ta ON a.id_tipo_alojamiento = ta.id_tipo_alojamiento
WHERE r.id_estado_reserva = 2
GROUP BY mes, metodo_pago, tipo_alojamiento
ORDER BY mes, metodo_pago, tipo_alojamiento
    ";

    $stmt = $conn->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Procesamiento para gráfica y tabla
    $meses = [];
    $metodos = [];
    $tipos = [];
    $datosCompletos = [];

    foreach ($resultados as $row) {
        $mes = (int)$row['mes'];
        $metodo = $row['metodo_pago'];
        $tipo = $row['tipo_alojamiento'];
        
        if (!in_array($metodo, $metodos)) {
            $metodos[] = $metodo;
        }
        
        if (!in_array($tipo, $tipos)) {
            $tipos[] = $tipo;
        }
        
        $datosCompletos[$mes][$metodo][$tipo] = [
            'cantidad' => $row['cantidad'],
            'porcentaje' => round(($row['cantidad'] / $row['total_general']) * 100, 2)
        ];
    }

    // Preparar datos para Chart.js (versión mejorada)
    $response = [
        'meses' => array_map(function($m) { return "Mes $m"; }, range(1, 12)),
        'datasets' => [],
        'tabla' => []
    ];

    // Colores para los diferentes métodos y tipos
    $colores = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
    $colorIndex = 0;

    foreach ($metodos as $metodo) {
        foreach ($tipos as $tipo) {
            $dataPorMes = [];
            
            for ($mes = 1; $mes <= 12; $mes++) {
                $dataPorMes[] = $datosCompletos[$mes][$metodo][$tipo]['cantidad'] ?? 0;
                
                // Datos para tabla
                if (isset($datosCompletos[$mes][$metodo][$tipo])) {
                    $response['tabla'][] = [
                        'mes' => "Mes $mes",
                        'metodo' => $metodo,
                        'tipo' => $tipo,
                        'cantidad' => $datosCompletos[$mes][$metodo][$tipo]['cantidad'],
                        'porcentaje' => $datosCompletos[$mes][$metodo][$tipo]['porcentaje'] . '%'
                    ];
                }
            }
            
            $response['datasets'][] = [
                'label' => "$metodo - $tipo",
                'data' => $dataPorMes,
                'backgroundColor' => $colores[$colorIndex++ % count($colores)],
                'stack' => 'stack_0'
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
