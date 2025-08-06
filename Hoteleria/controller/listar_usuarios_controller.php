<?php
require_once(__DIR__ . '../models/listar_usuarios_model.php');

class ListarUsuariosController {
    private $model;

    public function __construct() {
        $this->model = new ListarUsuariosModel();
        session_start();
    }

    public function mostrarUsuarios() {
        try {
            $usuarios = $this->model->obtenerTodosUsuarios();
            
            // Mostrar la vista directamente
            $this->renderizarVista($usuarios);
            
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: PanelAdministrador.php");
            exit;
        }
    }

    private function renderizarVista($usuarios) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8" />
            <title>Panel del Administrador</title>
            <link rel="stylesheet" href="../../css/styles.css" />
            <link rel="stylesheet" href="../../css/footer.css" />
            <style>
                .tabla-usuarios {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }
                .tabla-usuarios th, .tabla-usuarios td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                .tabla-usuarios th {
                    background-color: #0f1c2f;
                    color: white;
                }
                .tabla-usuarios tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                .error-message {
                    color: red;
                    padding: 10px;
                    margin: 20px 0;
                    border: 1px solid red;
                    background-color: #ffeeee;
                }
            </style>
        </head>
        <body>
            <header>
                <img src="../../img/logoprueba.png" alt="Logo de LuminusCreaCode" width="100" />
                <h2>Panel del Administrador</h2>
                <nav>
                    <a href="crear_Usuario.html">Crear Usuario</a>
                    <a href="eliminar_Usuario.html">Eliminar Usuario</a>
                    <a href="actualizar_Usuario.html">Actualizar Usuario</a>
                    <a href="buscar_Usuario.html">Buscar Usuario</a>
                </nav>
            </header>

            <main>
                <section>
                    <h3>Todos los usuarios Existentes</h3>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error-message"><?= $_SESSION['error'] ?></div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    
                    <table class="tabla-usuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Rol</th>
                                <th>Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                    <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                    <td><?= htmlspecialchars($usuario['telefono'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($usuario['rol']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($usuario['fecha_registro'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
            </main>
            
            <footer class="site-footer">
                <div class="footer-content">
                    <p class="footer-title"><strong>O también puedes escribirnos a:</strong></p>
                    <p class="footer-contact">Email: <a href="mailto:soporte@luminuscreacode.com" class="footer-link">soporte@luminuscreacode.com</a></p>
                    <p class="footer-contact">Teléfono: <a href="tel:+529991410909" class="footer-link">+52 9991410909</a></p>
                    <p class="footer-address">Dirección: Mérida, Yucatán, México</p>
                </div>
            </footer>
        </body>
        </html>
        <?php
    }
}