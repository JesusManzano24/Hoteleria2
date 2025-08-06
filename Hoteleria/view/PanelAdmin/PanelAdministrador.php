<?php
require_once(__DIR__ . '/controllers/listar_usuarios_controller.php');

$controller = new ListarUsuariosController();
$controller->mostrarUsuarios();