<?php
echo "Ruta actual: " . __DIR__; // muestra desde dónde estás ejecutando

// Verificar y luego incluir
$conexionPath = "../includes/conexion.php";

if (file_exists($conexionPath)) {
  echo "<br>✅ Archivo encontrado.";
  include($conexionPath);
} else {
  echo "<br>❌ Archivo NO encontrado.";
  exit;
}

// Ejecutar consulta si la conexión existe
if (isset($conn)) {
  $resultado = $conn->query("SHOW TABLES");

  if ($resultado) {
    echo "<br><br>Conexión exitosa. Tablas disponibles:";
    while ($tabla = $resultado->fetch_array()) {
      echo "<br> - " . $tabla[0];
    }
  } else {
    echo "<br>Conectó pero no pudo consultar la base de datos.";
  }
} else {
  echo "<br>❌ No se pudo establecer la conexión.";
}
?>