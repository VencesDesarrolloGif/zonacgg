<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio (); 
$response = array ();
$response ["status"] = "error";
$usuarioLogeado=$_SESSION ["userLog"]["usuario"];
verificarInicioSesion ($negocio);
// $log = new KLogger ( "obtenerLARGORECPTMP.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable entidadUsuario : " . var_export ($entidadUsuario, true)); 
    try{
         $uniformes = $negocio -> obtenerlargorecepcionesTMP($usuarioLogeado);

         $response ["largoRecepcionTMP"] = $uniformes[0]["largo"];
         $response ["status"] = "success";
         $response ["message"] = "Firma generada correctamente"; 

       }catch(Exception $e){
              $response ["status"] = "error";
              $response ["message"] =  $e -> getMessage ();
            }

echo json_encode ($response);
?>
