<?php
require 'conexion.php';

// 1) Si piden “?wsdl” devolvemos la definición

/*
require_once('WSDLDocument.php');
try {
    $wsdl = new WSDLDocument("ServicioWebEcomerce", 
    "http://localhost/Hoteleria/ws/wshoteleria.php", 
    "http://localhost/Hoteleria/ws");
    echo $wsdl->SaveXml();
} catch (Exception $e) {
    echo $e->getMessage();
}*/
    

// 2) Clase con solo el método TestConexion
class ServicioWebEcomerce
{
    
    /**
     * @param string $nombre
     * @return string
     */
    public function TestConexion($nombre)
    {
        return "Hola " . $nombre . ", te conectaste con éxito al WS";
    }
    
    private function Loguin($correo, $pass)
    {
        try {
            $sql = Conexion::conectar()->prepare('SELECT id_rol, nombre, contraseña, id_usuario FROM usuarios WHERE correo = :correo');
            $sql->execute([':correo' => $correo]);
            $resultado = $sql->fetch();

            if ($resultado) {
                if (password_verify($pass, $resultado["contraseña"])) {
                    return "Succes|Se encontró el usuario: " . $resultado["nombre"] . "|id_rol:" . $resultado["id_rol"] . "|id_usuario:" . $resultado["id_usuario"];
                } else {
                    return "Error|Contraseña incorrecta";
                }
            } else {
                return "Error|Correo no registrado";
            }
        } catch (Exception $e) {
            return "Error|Error en la base de datos: " . $e->getMessage();
        }
    }

    private function InsertarUsuario($id_rol, $nombre, $correo, $contraseña, $telefono, $genero, $origen, $fecha_nac)
    {
        try {
            $sql = Conexion::conectar()->prepare('
                INSERT INTO usuarios (id_rol, nombre, correo, contraseña, telefono, genero, origen, fecha_nac, fecha_registro)
                VALUES (:id_rol, :nombre, :correo, :pass, :telefono, :genero, :origen, :fecha_nac, NOW())
            ');

            $hashedPass = password_hash($contraseña, PASSWORD_DEFAULT);

            $sql->execute([
                ':id_rol' => $id_rol,
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':pass' => $hashedPass,
                ':telefono' => $telefono,
                ':genero' => $genero,
                ':origen' => $origen,
                ':fecha_nac' => $fecha_nac
            ]);

            return "Succes|Usuario registrado correctamente";
        } catch (Exception $e) {
            return "Error|Error al registrar: " . $e->getMessage();
        }
    }


    /**
     * @param string $correo
     * @param string $contraseña
     * @return string
     */
    public function Login($correo, $contraseña)
    {
        $respuesta = $this->Loguin($correo, $contraseña);
        $partes = explode("|", $respuesta);

        if ($partes[0] === "Succes") {
            $mensaje = $partes[1];
            $idRol = isset($partes[2]) ? explode(":", $partes[2])[1] : "0";
            $idUsuario = isset($partes[3]) ? explode(":", $partes[3])[1] : "0";
            return '{"Codigo":"01","Mensaje":"' . $mensaje . '","id_rol":"' . $idRol . '","id_usuario":"' . $idUsuario .'"}';
        } else {
            return '{"Codigo":"00","Mensaje":"' . $partes[1] . '"}';
        }
    }

    /**
     * @param int $id_rol
     * @param string $nombre
     * @param string $correo
     * @param string $contraseña
     * @param string $telefono
     * @param string $genero
     * @param string $origen
     * @param string $fecha_nac
     * @return string
     */
    public function RegistrarUsuario($id_rol, $nombre, $correo, $contraseña, $telefono, $genero, $origen, $fecha_nac)
    {
        $respuesta = $this->InsertarUsuario($id_rol, $nombre, $correo, $contraseña, $telefono, $genero, $origen, $fecha_nac);
        $partes = explode("|", $respuesta);

        if ($partes[0] === "Succes") {
            return '{"Codigo":"01","Mensaje":"' . $partes[1] . '"}';
        } else {
            return '{"Codigo":"00","Mensaje":"' . $partes[1] . '"}';
        }
    }

    /**
     * @param int $id_usuario
     * @return string
    */
    public function ObtenerPerfil($id_usuario)
    {
        try {
        $sql = Conexion::conectar()->prepare('SELECT nombre, correo, telefono, genero, origen, fecha_nac FROM usuarios WHERE id_usuario = :id');
        $sql->execute([':id' => $id_usuario]);
        $usuario = $sql->fetch();

        if ($usuario) {
            return '{"Codigo":"01","Mensaje":"Perfil obtenido","nombre":"' . $usuario['nombre'] .
                   '","correo":"' . $usuario['correo'] .
                   '","telefono":"' . $usuario['telefono'] .
                   '","genero":"' . $usuario['genero'] .
                   '","origen":"' . $usuario['origen'] .
                   '","fecha_nac":"' . $usuario['fecha_nac'] . '"}';
        } else {
            return '{"Codigo":"00","Mensaje":"Usuario no encontrado"}';
        }
    } catch (Exception $e) {
        return '{"Codigo":"00","Mensaje":"Error en la base de datos: ' . $e->getMessage() . '"}';
    }
    }

    /**
     * @return string
    */
    public function ObtenerCategorias()
    {
        try {
            $sql = Conexion::conectar()->prepare('SELECT id_tipo_alojamiento, tipo_nombre FROM tipos_alojamiento');
            $sql->execute();
            $categorias = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($categorias) {
                return json_encode([
                    "Codigo" => "01",
                    "Mensaje" => "Categorías obtenidas",
                    "categorias" => $categorias
                ]);
            } else {
                return json_encode([
                    "Codigo" => "00",
                    "Mensaje" => "No hay categorías registradas"
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                "Codigo" => "00",
                "Mensaje" => "Error en la base de datos: " . $e->getMessage()
            ]);
        }
    }



    /**
    * @param int $id_categoria
    * @return string
    */
    public function ObtenerProductosCat($id_categoria)
    {
        try {
            $sql = Conexion::conectar()->prepare('
                SELECT id_alojamiento, nombre, id_tipo_alojamiento, direccion, precio FROM alojamientos
                WHERE id_tipo_alojamiento = :id_categoria
            ');
            $sql->execute([':id_categoria' => $id_categoria]);
            $alojamientocat = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($alojamientocat) {
                return json_encode([
                    "Codigo" => "01",
                    "Mensaje" => "Alojamientos por categoría obtenidos",
                    "Alojamientoscat" => $alojamientocat
                ]);
            } else {
                return json_encode([
                    "Codigo" => "00",
                    "Mensaje" => "No se encontraron productos para esta categoría"
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                "Codigo" => "00",
                "Mensaje" => "Error en la base de datos: " . $e->getMessage()
            ]);
        }
    }




    /**
    * @param int $id_aloj
    * @return string
    */
    public function ObtenerDetalleProductos($id_aloj)
    {
        try {
            $sql = Conexion::conectar()->prepare('
                SELECT id_alojamiento, id_usuario, nombre, id_tipo_alojamiento, direccion, descripcion, precio, capacidad, id_estado FROM alojamientos
                WHERE id_alojamiento = :id_aloj
            ');
            $sql->execute([':id_aloj' => $id_aloj]);
            $alojamiento = $sql->fetchAll(PDO::FETCH_ASSOC);

            if ($alojamiento) {
                return json_encode([
                    "Codigo" => "01",
                    "Mensaje" => "Alojamiento obtenido",
                    "Alojamiento" => $alojamiento
                ]);
            } else {
                return json_encode([
                    "Codigo" => "00",
                    "Mensaje" => "No se encontró el alojamiento"
                ]);
            }
        } catch (Exception $e) {
            return json_encode([
                "Codigo" => "00",
                "Mensaje" => "Error en la base de datos: " . $e->getMessage()
            ]);
        }
    }









}



// 3) Arrancamos el servidor SOAP



try {
    $server = new SoapServer("hoteleria.wsdl", array('cache_wsdl' => WSDL_CACHE_NONE));
    $server->setClass("ServicioWebEcomerce");
    //$server->addFunction("TestConexion");
    //$server->addFunction("Timbrar");
    //$server->addFunction("Cancelar"); 
    $server->handle();
} catch (SOAPFault $f) {
    print $f->faultstring;
}

