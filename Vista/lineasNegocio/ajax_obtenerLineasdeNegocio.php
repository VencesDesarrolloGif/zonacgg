<?php
session_start();
require "../conexion.php"; 
require_once "../../libs/logger/KLogger.php";
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
}
$response = array("status" => "success");
//$log = new KLogger ( "ajax_obtenerLineasdeNegocio.log" , KLogger::DEBUG );

   try {

      $sql = "SELECT idLineaNegocio, descripcionLineaNegocio
              FROM catalogolineanegocio";

            //$this -> logger -> LogInfo ("ejecutando getLineasDeNegocio en persistencia". $sql);
             $res = mysqli_query($conexion, $sql);
            while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
                $LineasNeg[] = $reg;
            }
    $response["datos"] = $LineasNeg;
    
   // $log->LogInfo("Valor de LineasNegocio" . var_export ($response, true));
   } 
	catch (Exception $e) {
	    $response["status"] = "error";
	    $response["error"]  = "No se puedo obtener lista de Marcas";
	}
echo json_encode($response);
