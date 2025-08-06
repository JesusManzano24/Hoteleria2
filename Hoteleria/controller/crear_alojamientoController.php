<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$modelPath = $root . '/Hoteleria/models/crear_alojamiento.php';

if (!file_exists($modelPath)) {
    die("Error: El archivo del modelo no se encontró en: " . $modelPath);
}

require_once $modelPath;

class CrearAlojamientoController {
    private $model;
    private $uploadPath;
    
    public function __construct() {
        $root = $_SERVER['DOCUMENT_ROOT'];
        $this->uploadPath = $root . '/Hoteleria/assets/uploads/';
        $this->model = new CrearAlojamientoModel();
        session_start();
    }

    public function procesarFormulario() {
        if (!$this->validarCampos()) {
            $_SESSION['error'] = "Por favor complete todos los campos requeridos";
            header("Location: crear_alojamiento.html");
            exit;
        }

        $datos = $this->prepararDatos();

        try {
            $idAlojamiento = $this->model->crearAlojamiento($datos);
            $this->procesarImagenes($idAlojamiento);
            $_SESSION['exito'] = "Alojamiento creado exitosamente!";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header("Location: crear_alojamiento.html");
        exit;
    }

    private function validarCampos() {
        $camposRequeridos = [
            'nombre', 'descripcion', 'id_tipo_alojamiento', 
            'id_estado', 'direccion', 'capacidad', 
            'precio', 'latitud', 'longitud'
        ];

        foreach ($camposRequeridos as $campo) {
            if (empty($_POST[$campo])) {
                return false;
            }
        }
        return true;
    }

    private function prepararDatos() {
        return [
            'id_usuario' => $_SESSION['id_usuario'] ?? 1, 
            'nombre' => htmlspecialchars(trim($_POST['nombre'])),
            'descripcion' => htmlspecialchars(trim($_POST['descripcion'])),
            'id_tipo_alojamiento' => (int)$_POST['id_tipo_alojamiento'],
            'id_estado' => (int)$_POST['id_estado'],
            'direccion' => htmlspecialchars(trim($_POST['direccion'])),
            'capacidad' => (int)$_POST['capacidad'],
            'precio' => (float)$_POST['precio'],
            'latitud' => (float)$_POST['latitud'],
            'longitud' => (float)$_POST['longitud']
        ];
    }

    private function procesarImagenes($idAlojamiento) {
        if (empty($_FILES['imagenes'])) {
            return;
        }

        $carpetaAlojamiento = $this->uploadPath . $idAlojamiento . '/';
        $this->crearCarpetaAlojamiento($carpetaAlojamiento);

        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['imagenes']['error'][$key] !== UPLOAD_ERR_OK) {
                continue;
            }

            if (!$this->validarArchivo($key)) {
                continue;
            }

            $nombreArchivo = $this->generarNombreArchivo($key);
            $rutaDestino = $carpetaAlojamiento . $nombreArchivo;

            if (move_uploaded_file($tmp_name, $rutaDestino)) {
                $this->model->guardarImagen($idAlojamiento, $nombreArchivo);
            }
        }
    }

    private function crearCarpetaAlojamiento($path) {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    private function validarArchivo($key) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $tamañoMaximo = 5 * 1024 * 1024; // 5MB

        // Validar tamaño
        if ($_FILES['imagenes']['size'][$key] > $tamañoMaximo) {
            return false;
        }

        // Validar extensión
        $extension = strtolower(pathinfo($_FILES['imagenes']['name'][$key], PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionesPermitidas)) {
            return false;
        }

        return true;
    }

    private function generarNombreArchivo($key) {
        $extension = pathinfo($_FILES['imagenes']['name'][$key], PATHINFO_EXTENSION);
        return uniqid() . '.' . strtolower($extension);
    }
}