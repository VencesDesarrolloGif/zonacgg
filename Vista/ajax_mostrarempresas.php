<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$accion=$_POST["accion"];
$idempresa=$_POST["idempresa"];
$valorupdate=$_POST["valorupdate"];
//$usuario = $_SESSION ["userLog"]["rol"];
//$log = new KLogger ( "ajaxinsertarhistorico.log" , KLogger::DEBUG );
verificarInicioSesion ($negocio);
//$log->LogInfo("Valor de la variable \$datastring: " . var_export ($_SESSION, true));
    try
    {
        $response ["status"] = "success";
        if($accion==0){
            $listaempresas = $negocio->negocio_mostrarempresas();  
            $response ["datos"] = $listaempresas; 
        }elseif($accion==1){
            $negocio->negocio_activarDesactivarEmpresa($idempresa,$valorupdate);
        }
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }       


echo json_encode ($response);
?>