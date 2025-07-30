<?php
require_once('../models/CrearAlojamientoModel.php');

class CrearAlojamientoController {
    private $model;
    private $uploadPath = '../assets/uploads/';
    private $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    private $maxFileSize = 5 * 1024 * 1024; // 5MB

    public function __construct() {
        $this->model = new CrearAlojamientoModel();
        $this->initializeUploadDirectory();
    }

    private function initializeUploadDirectory() {
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
            // Archivo .htaccess para seguridad
            file_put_contents($this->uploadPath . '.htaccess', "Deny from all");
        }
    }

    public function mostrarFormulario() {
        $this->startSession();
        
        // Obtener datos necesarios para la vista si es necesario
        $data = [
            'tiposAlojamiento' => $this->model->obtenerTiposAlojamiento(),
            'estadosAlojamiento' => $this->model->obtenerEstadosAlojamiento()
        ];
        
        include('../views/panelanfi/crear_alojamiento.php');
    }

    public function procesarFormulario() {
        $this->startSession();
        
        if (!$this->validarCamposRequeridos()) {
            header("Location: crear_alojamiento.php");
            exit;
        }

        $datosAlojamiento = $this->prepararDatosAlojamiento();

        try {
            $idAlojamiento = $this->model->crearAlojamiento($datosAlojamiento);
            
            if (!$idAlojamiento) {
                throw new Exception("Error al registrar el alojamiento");
            }

            $this->procesarImagenes($idAlojamiento);
            
            $_SESSION['exito'] = "Alojamiento registrado correctamente con ID: $idAlojamiento";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            error_log('Error en CrearAlojamientoController: ' . $e->getMessage());
        }

        header("Location: crear_alojamiento.php");
        exit;
    }

    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function validarCamposRequeridos() {
        $camposRequeridos = [
            'nombre', 'descripcion', 'id_tipo_alojamiento', 
            'id_estado', 'direccion', 'capacidad', 
            'precio', 'latitud', 'longitud'
        ];

        foreach ($camposRequeridos as $campo) {
            if (empty($_POST[$campo])) {
                $_SESSION['error'] = "El campo $campo es requerido";
                return false;
            }
        }
        return true;
    }

    private function prepararDatosAlojamiento() {
        return [
            'id_usuario' => $_SESSION['id_usuario'] ?? 1,
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion']),
            'id_tipo_alojamiento' => intval($_POST['id_tipo_alojamiento']),
            'id_estado' => intval($_POST['id_estado']),
            'direccion' => trim($_POST['direccion']),
            'capacidad' => intval($_POST['capacidad']),
            'precio' => floatval($_POST['precio']),
            'latitud' => floatval($_POST['latitud']),
            'longitud' => floatval($_POST['longitud'])
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
        // Validar tamaño
        if ($_FILES['imagenes']['size'][$key] > $this->maxFileSize) {
            return false;
        }

        // Validar extensión
        $extension = strtolower(pathinfo($_FILES['imagenes']['name'][$key], PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            return false;
        }

        // Validar tipo MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['imagenes']['tmp_name'][$key]);
        finfo_close($finfo);
        
        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];

        return in_array($mime, $allowedMimeTypes);
    }

    private function generarNombreArchivo($key) {
        $extension = pathinfo($_FILES['imagenes']['name'][$key], PATHINFO_EXTENSION);
        return uniqid() . '.' . strtolower($extension);
    }
}