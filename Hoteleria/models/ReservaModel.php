<?php
require_once("../includes/db.php");

class ReservaModel {

  public static function crearReserva($usuario_id, $hotel_id, $entrada, $salida) {
    global $conn;
    $query = "INSERT INTO reservas (usuario_id, hotel_id, fecha_entrada, fecha_salida)
              VALUES ('$usuario_id', '$hotel_id', '$entrada', '$salida')";
    return mysqli_query($conn, $query);
  }

  public static function obtenerPorUsuario($usuario_id) {
    global $conn;
    $query = "SELECT r.*, h.nombre AS hotel_nombre, h.ciudad
              FROM reservas r
              INNER JOIN hoteles h ON r.hotel_id = h.id
              WHERE r.usuario_id = '$usuario_id'
              ORDER BY r.fecha_entrada ASC";
    return mysqli_query($conn, $query);
  }

  public static function obtenerPorHotel($hotel_id) {
    global $conn;
    $query = "SELECT r.*, u.nombre AS cliente
              FROM reservas r
              INNER JOIN usuarios u ON r.usuario_id = u.id
              WHERE r.hotel_id = '$hotel_id'
              ORDER BY r.fecha_entrada ASC";
    return mysqli_query($conn, $query);
  }
}