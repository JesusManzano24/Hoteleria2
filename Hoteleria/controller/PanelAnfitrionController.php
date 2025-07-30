<?php
include("../includes/db.php");

// Hoteles que pertenecen al anfitrión actual
function obtenerHotelesDelAnfitrion($anfitrion_id) {
  global $conn;
  $anfitrion_id = mysqli_real_escape_string($conn, $anfitrion_id);
  $query = "SELECT * FROM hoteles WHERE creador_id = '$anfitrion_id'";
  $result = mysqli_query($conn, $query);

  $hoteles = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $hoteles[] = $row;
  }
  return $hoteles;
}
if (isset($_POST['registrar_hotel'])) {
  include("../includes/db.php");
  session_start();

  $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
  $ciudad = mysqli_real_escape_string($conn, $_POST['ciudad']);
  $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
  $precio = mysqli_real_escape_string($conn, $_POST['precio']);
  $anfitrion_id = $_SESSION['usuario_id'];

  // Guardar imagen
  $imagen = $_FILES['imagen']['name'];
  $ruta_temp = $_FILES['imagen']['tmp_name'];
  $destino = "../assets/images/" . $imagen;
  move_uploaded_file($ruta_temp, $destino);

  $query = "INSERT INTO hoteles (nombre, ciudad, descripcion, precio, imagen, creador_id) 
            VALUES ('$nombre', '$ciudad', '$descripcion', '$precio', '$imagen', '$anfitrion_id')";

  if (mysqli_query($conn, $query)) {
    $_SESSION['mensaje'] = "Hotel registrado correctamente.";
    header("Location: ../views/anfitrion.php");
  } else {
    $_SESSION['mensaje'] = "Error al registrar hotel: " . mysqli_error($conn);
    header("Location: ../views/nuevo_hotel.php");
  }
}function obtenerReservasPorHotel($hotel_id, $anfitrion_id) {
  global $conn;
  $hotel_id = mysqli_real_escape_string($conn, $hotel_id);
  $anfitrion_id = mysqli_real_escape_string($conn, $anfitrion_id);

  // Verificar propiedad del hotel
  $verif = mysqli_query($conn, "SELECT * FROM hoteles WHERE id='$hotel_id' AND creador_id='$anfitrion_id'");
  if (mysqli_num_rows($verif) == 0) {
    return [];
  }

  $query = "SELECT r.*, u.nombre AS cliente 
            FROM reservas r 
            INNER JOIN usuarios u ON r.usuario_id = u.id
            WHERE r.hotel_id = '$hotel_id'
            ORDER BY r.fecha_entrada ASC";

  $result = mysqli_query($conn, $query);

  $reservas = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $reservas[] = $row;
  }
  return $reservas;
}