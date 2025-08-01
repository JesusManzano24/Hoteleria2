<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Alojamiento</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #0f1c2f;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <img src="../../img/logoprueba.png" alt="Logo" width="100">
        <h1>Crear Nuevo Alojamiento</h1>
        <nav>
            <a href="panelanfitrion.php">Volver al panel</a>
        </nav>
    </header>

    <main class="container">
        <?php if (isset($_SESSION['exito'])): ?>
            <div class="alert alert-success"><?= $_SESSION['exito']; unset($_SESSION['exito']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form action="procesar_alojamiento.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del alojamiento:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="id_tipo_alojamiento">Tipo de alojamiento:</label>
                <select id="id_tipo_alojamiento" name="id_tipo_alojamiento" required>
                    <option value="">Selecciona tipo</option>
                    <?php foreach ($tiposAlojamiento as $tipo): ?>
                        <option value="<?= $tipo['id_tipo_alojamiento'] ?>"><?= $tipo['tipo_nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_estado">Estado del alojamiento:</label>
                <select id="id_estado" name="id_estado" required>
                    <option value="">Selecciona estado</option>
                    <?php foreach ($estadosAlojamiento as $estado): ?>
                        <option value="<?= $estado['id_estado'] ?>"><?= $tipo['nombre_estado'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección completa:</label>
                <textarea id="direccion" name="direccion" rows="2" required></textarea>
            </div>

            <div class="form-group">
                <label for="capacidad">Capacidad (personas):</label>
                <input type="number" id="capacidad" name="capacidad" min="1" required>
            </div>

            <div class="form-group">
                <label for="precio">Precio por noche (MXN):</label>
                <input type="number" id="precio" name="precio" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="latitud">Latitud:</label>
                <input type="text" id="latitud" name="latitud" required placeholder="Ej: 21.16191124">
            </div>

            <div class="form-group">
                <label for="longitud">Longitud:</label>
                <input type="text" id="longitud" name="longitud" required placeholder="Ej: -89.61927418">
            </div>

            <div class="form-group">
                <label for="imagenes">Imágenes del alojamiento (Máx. 5MB c/u):</label>
                <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*">
            </div>

            <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?? '' ?>">

            <button type="submit">Registrar alojamiento</button>
        </form>
    </main>
</body>
</html>