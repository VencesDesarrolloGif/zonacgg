<?php
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio (); 
$response = array ();
$response ["status"] = "error";
verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxTransferenciaUniforme.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

if (!empty ($_POST)){
    
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    $entidadDestino=getValueFromPost("entidad");
    $listaUniformes=getValueFromPost("listaUniformes");      
    $guia=getValueFromPost("nGuia");
    $paqueteria=getValueFromPost("paqueteria");
    $observaciones=getValueFromPost("observaciones");
    $entidadUsuario=$_SESSION ["userLog"]["entidadFederativaUsuario"];
    $entidadUsuario1=count($entidadUsuario);
    $sucursalEnvio=getValueFromPost("sucursalElegida");

    $entidadparaconsulta="09";
    $sucursalUsr="8";
    //hacer una mejora que consulte que si tiene el privilegio de

    if($entidadparaconsulta != '09') {
        $response ["status"] = "error";
        $response ["message"] = "Usuario no autorizado";
    }else{
        try{
            $negocio -> negocio_transferirUniformes($entidadparaconsulta,$entidadDestino,$listaUniformes,$guia,$paqueteria,$observaciones,$usuarioCaptura,$sucursalEnvio,$sucursalUsr);
            $response ["status"] = "success";
            $response ["message"] = "Transferencia enviada";
        }catch (Exception $e){
            $response ["status"] = "error";
            $response ["message"] =  $e -> getMessage ();
        }//catch
    }//else entidad consulta
}//empty post
else{    
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>