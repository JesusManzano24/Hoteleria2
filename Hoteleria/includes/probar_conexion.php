<?php
include("conexion.php"); // Asegúrate de que ruta sea correcta

$resultado = $conn->query("SHOW TABLES");

if ($resultado) {
  echo "Conexión exitosa. Tablas disponibles:";
  while ($tabla = $resultado->fetch_array()) {
    echo "<br> - " . $tabla[0];
  }
} else {
  echo "Conectó pero no pudo consultar la base de datos.";
}
?>