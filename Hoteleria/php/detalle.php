<?php
include("../includes/header.php");
include("../controllers/HotelController.php");

if (isset($_GET['id'])) {
  $hotel = obtenerHotelPorId($_GET['id']);
}
?>

<div class="detalle-hotel">
  <h2><?= $hotel['nombre'] ?></h2>
  <img src="../assets/images/<?= $hotel['imagen'] ?>" alt="<?= $hotel['nombre'] ?>">
  <p><?= $hotel['descripcion'] ?></p>
  <p><strong>Ubicación:</strong> <?= $hotel['ciudad'] ?></p>
  <p><strong>Precio por noche:</strong> $<?= $hotel['precio'] ?></p>

  <form method="POST" action="../controllers/ReservaController.php">
    <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">
    
    <label>Fecha de entrada:</label>
    <input type="date" name="fecha_entrada" required>

    <label>Fecha de salida:</label>
    <input type="date" name="fecha_salida" required>

    <button type="submit" name="reservar">Reservar ahora</button>
  </form>
</div>

<?php include("../includes/footer.php"); ?>