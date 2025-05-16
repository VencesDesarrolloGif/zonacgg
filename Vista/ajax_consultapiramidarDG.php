<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$usuario = $_SESSION ["userLog"]["usuario"];
    $opcion1 = "1";
    $opcion2 = "2";
    $montofalso ="0";
 
try {
    $datos = $negocio -> obtenerListaAcuerdos();


    for ($i = 0; $i < count($datos); $i++) {
  
        $fechaBajaImss     = $datos[$i]["fechaBajaImss"];
        $fechingresoImss   = $datos[$i]["fechaImss"];
        $MontoAcordado     = $datos[$i]["MontoAcordado"];
        $netoAlPago        = $datos[$i]["netoAlPago"];
        $numempleado       = $datos[$i]["numempleado"];      
        $folioBajaImss     = $datos[$i]["folioBajaImss"];      
        $netoalpagopositivo     = abs($netoAlPago);     
        $MontoAcordadoCalculado = $netoalpagopositivo + $MontoAcordado;     
        $datos[$i]["Acción"] = 
"<img style='width: 15%' title='Aceptar' src='img/confirmarImss.png' class='cursorImg' id='btnconfirmar' onclick=confirmarbtn('$folioBajaImss','$numempleado','$netoAlPago',$opcion1,$MontoAcordadoCalculado,'" . $fechaBajaImss . "','" . $fechingresoImss . "')>
 <img style='width: 15%' title='Rechazar' src='img/rechazarImss.png' class='cursorImg' id='btnrechazar' onclick=confirmarbtn('$folioBajaImss','$numempleado','$netoAlPago',$opcion2,$montofalso,'" . $fechaBajaImss . "','" . $fechingresoImss . "')>";                                               
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
