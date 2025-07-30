<?php
require_once("../includes/db.php");

class UsuarioModel {

  public static function registrar($nombre, $email, $password, $rol) {
    global $conn;
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $rol = mysqli_real_escape_string($conn, $rol);

    $query = "INSERT INTO usuarios (nombre, email, password, rol)
              VALUES ('$nombre', '$email', '$password', '$rol')";
    return mysqli_query($conn, $query);
  }

  public static function autenticar($email, $password) {
    global $conn;
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $query = "SELECT * FROM usuarios WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    return mysqli_fetch_assoc($result);
  }

  public static function obtenerPorId($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM usuarios WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
  }
}