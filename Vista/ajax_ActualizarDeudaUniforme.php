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
$usuario = $_SESSION ["userLog"]["usuario"];
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_ActualizarDeudaUniforme.log" , KLogger::DEBUG );
$entidadEmpDeudaU=getValueFromPost("entidadEmpDeudaU");
$consecutivoEmpDeudaU=getValueFromPost("consecutivoEmpDeudaU");
$categoriaEmpDeudaU=getValueFromPost("categoriaEmpDeudaU");
$idDeudaUni=getValueFromPost("idDeudaUni");
    //$log->LogInfo("Valor de la variable entidadEmpDeudaU: " . var_export ($entidadEmpDeudaU, true));
    //$log->LogInfo("Valor de la variable consecutivoEmpDeudaU: " . var_export ($consecutivoEmpDeudaU, true));
    //$log->LogInfo("Valor de la variable categoriaEmpDeudaU: " . var_export ($categoriaEmpDeudaU, true));

     try{
         $negocio -> actualizarestatusdeudaUniformes($entidadEmpDeudaU,$consecutivoEmpDeudaU,$categoriaEmpDeudaU,$idDeudaUni);
          $response ["status"] = "success";

        } 
    catch(Exception $e){
          $response ["status"] = "error";
          $response ["message"] =  $e -> getMessage ();
         }    
echo json_encode ($response);
?>
