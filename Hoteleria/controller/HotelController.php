<?php
require_once("../models/HotelModel.php");

function mostrarHoteles() {
  $result = HotelModel::obtenerTodos();
  while ($hotel = mysqli_fetch_assoc($result)) {
    echo "<div class='hotel'>";
    echo "<h3>" . $hotel['nombre'] . "</h3>";
    echo "<p>" . $hotel['descripcion'] . "</p>";
    echo "<a href='detalle.php?id=" . $hotel['id'] . "'>Ver más</a>";
    echo "</div>";
  }
}

function obtenerHotelPorId($id) {
  return HotelModel::obtenerPorId($id);
}