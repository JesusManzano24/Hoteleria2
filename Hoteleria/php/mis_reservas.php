<?php
include("../includes/header.php");
include("../controllers/ReservaController.php");
session_start();

$reservas = obtenerReservasDelUsuario($_SESSION['usuario_id']);
?>

<h2>Mis reservas</h2>
<div class="reservas-contenedor">
  <?php
  if (count($reservas) > 0) {
    foreach ($reservas as $reserva) {
      echo "<div class='reserva'>";
      echo "<h3>" . $reserva['hotel_nombre'] . "</h3>";
      echo "<p><strong>Entrada:</strong> " . $reserva['fecha_entrada'] . "</p>";
      echo "<p><strong>Salida:</strong> " . $reserva['fecha_salida'] . "</p>";
      echo "<p><strong>Ciudad:</strong> " . $reserva['ciudad'] . "</p>";
      echo "</div>";
    }
  } else {
    echo "<p>No tienes reservas registradas.</p>";
  }
  ?>
</div>

<?php include("../includes/footer.php"); ?>