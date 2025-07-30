<?php
require '../includes/conexion.php';

// 1) Si piden “?wsdl” devolvemos la definición
/*require_once('WSDLDocument.php');
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

