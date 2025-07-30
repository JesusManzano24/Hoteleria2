<?php
session_start();
include("../includes/header.php");
include("../controllers/PanelAnfitrionController.php");

$hoteles = obtenerHotelesDelAnfitrion($_SESSION['usuario_id']);
?>

<h2>Panel del anfitrión</h2>
<a href="nuevo_hotel.php" class="btn">Añadir nuevo hotel</a>

<div class="hoteles-panel">
  <?php foreach ($hoteles as $hotel): ?>
    <div class="hotel-item">
      <h3><?= $hotel['nombre'] ?></h3>
      <p><?= $hotel['ciudad'] ?> — $<?= $hotel['precio'] ?> por noche</p>
      <a href="reservas_hotel.php?id=<?= $hotel['id'] ?>" class="btn-small">Ver reservas</a>
      <a href="editar_hotel.php?id=<?= $hotel['id'] ?>" class="btn-small edit">Editar</a>
    </div>
  <?php endforeach; ?>
</div>

<?php include("../includes/footer.php"); ?>