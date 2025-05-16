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
    $datos = $negocio -> obtenerListaFiniquitosCOmp();


    for ($i = 0; $i < count($datos); $i++) {
  
       
        $numempleado          = $datos[$i]["numempleado"];
        $folioBajaImss        = $datos[$i]["folioBajaImss"];
        $CantidadComplemento  = $datos[$i]["CantidadComplemento"];
        $opcion1="1";
        $opcion2="2";      
          
        $datos[$i]["AceptarComplemento"] = "<img style='width: 15%' title='Aceptar' src='img/confirmarImss.png' class='cursorImg' onclick=AceptarDeclinarPeticion('$numempleado','$folioBajaImss','$CantidadComplemento',$opcion1)>";

        $datos[$i]["DeclinarComplemento"] = "<img style='width: 15%' title='Rechazar' src='img/rechazarImss.png' class='cursorImg' onclick=AceptarDeclinarPeticion('$numempleado','$folioBajaImss','$CantidadComplemento',$opcion2)>";                                       
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
