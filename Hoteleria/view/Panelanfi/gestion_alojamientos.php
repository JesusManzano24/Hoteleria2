<?php
session_start();
require_once("../includes/conexion.php");

// Mensajes de retroalimentación
$mensajeExito = $_SESSION['mensaje_exito'] ?? '';
$mensajeError = $_SESSION['mensaje_error'] ?? '';
unset($_SESSION['mensaje_exito']);
unset($_SESSION['mensaje_error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alojamientos</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/alojamientos.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <main class="container">
        <h1>Gestión de Alojamientos</h1>
        
        <!-- Mensajes de retroalimentación -->
        <?php if ($mensajeExito): ?>
            <div class="alert alert-success"><?= $mensajeExito ?></div>
        <?php endif; ?>
        
        <?php if ($mensajeError): ?>
            <div class="alert alert-danger"><?= $mensajeError ?></div>
        <?php endif; ?>

        <!-- Formulario de registro -->
        <section class="card">
            <h2>Registrar Nuevo Alojamiento</h2>
            <form id="form-alojamiento" action="../php/registrar_alojamiento.php" method="POST">
                <!-- Campos del formulario -->
                <div class="form-group">
                    <label for="nombre">Nombre del alojamiento:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                
                <!-- Más campos... -->
                
                <button type="submit" class="btn btn-primary">Registrar Alojamiento</button>
            </form>
        </section>

        <!-- Listado de alojamientos -->
        <section class="card">
            <h2>Mis Alojamientos</h2>
            <div id="lista-alojamientos">
                <!-- Contenido cargado por JavaScript -->
                <p>Cargando alojamientos...</p>
            </div>
        </section>
    </main>

    <?php include('../includes/footer.php'); ?>

    <script src="../js/alojamientos.js"></script>
</body>
</html>