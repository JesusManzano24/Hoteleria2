<?php
// controller/LoginController.php
require_once __DIR__ . '/../models/LoginUsuario.php';


class LoginController
{
    public static function login(): void
    {
        session_start();

        // Solo aceptamos POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Hoteleria/view/Login/login.html');
            exit;
        }

        // 1) Leer y validar campos
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        if ($email === '' || $password === '') {
            $msg = 'Debes ingresar correo y contraseña.';
            header('Location: /Hoteleria/view/Login/login.html?error=' . urlencode($msg));
            exit;
        }

        // 2) Autenticación con el modelo
        $res = LoginUsuario::autenticar($email, $password);
        if (!$res['success']) {
            header('Location: /Hoteleria/view/Login/login.html?error=' . urlencode($res['error']));
            exit;
        }

        // 3) Guardar datos en sesión y redirigir
        $_SESSION['user_id'] = $res['user_id'];
        $_SESSION['user_role'] = $res['user_role'];

        switch ($_SESSION['user_role']) {
            case 1:
                header('Location: /Hoteleria/view/dashboard/dashboard.html');
                break;
            case 2:
                header('Location: /Hoteleria/view/crudalojamientos/crud_alojamientos.html');
                break;
            case 3:
                header('Location: /Hoteleria/view/alojamientos/alojamientos.html');
                break;
            default:
                $msg = 'Rol no autorizado.';
                header('Location: /Hoteleria/view/Login/login.html?error=' . urlencode($msg));
                break;
        }
        exit;
    }
}