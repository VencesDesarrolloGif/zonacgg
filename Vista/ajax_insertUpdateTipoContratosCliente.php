<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio            = new Negocio ();
$response           = array();

// $log = new KLogger ( "ajaxinsertUpdateContratosCliente.log" , KLogger::DEBUG );
$accion    = $_POST['accion'];
$descContrato = $_POST['descContrato'];
$idContrato = $_POST['idContrato'];
$usuario = $_SESSION ["userLog"]["usuario"];
// $log->LogInfo("Valor de variable _SESSION" . var_export ($_SESSION, true));
//$log->LogInfo("Valor de variable descContrato" . var_export ($descContrato, true));
//$log->LogInfo("Valor de variable idContrato" . var_export ($idContrato, true));

try {
    if ($accion == 1) {
    for ($i = 0; $i < count($idContrato); $i++) {

            $UPDATE = $negocio->updateContratosClientes($descContrato,$idContrato,$i,$usuario);
            $response ["status"] = "success";
        }
        }else if ($accion == 2) {
            $INSERT = $negocio->insertContrato($descContrato,$usuario);
    }
    }catch(Exception $e){
           $response["status"] = "error";
       }
    // $log->LogInfo("Valor de response" . var_export ($response, true));
echo json_encode($response);
?>

