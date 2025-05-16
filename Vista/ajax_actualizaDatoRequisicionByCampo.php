<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

$response = array ();

verificarInicioSesion ($negocio);

if (!empty ($_POST))
{
    //$log = new KLogger ( "ajax_EdicionFechaTerminoServicio.log" , KLogger::DEBUG );


   // $usuario = $_SESSION ["userLog"]["usuario"];

    $campo=getValueFromPost("campo"); 
    $valor=getValueFromPost("valor");
    $servicioPlantillaId=getValueFromPost("servicioPlantillaId"); 
    $fechaTerminoServicio=getValueFromPost("fechaTerminoServicio");
    
    try
    {
        $listaAsignacionesEmpleados= $negocio -> negocio_RevisarElementosAsignadosAEstaPantilla($servicioPlantillaId);
        $ConteoTotalEmpleadosActivos = count($listaAsignacionesEmpleados);
        if($ConteoTotalEmpleadosActivos=="0"){
            $negocio -> actualizarDatosRequisicionByCampo($campo, $valor, $servicioPlantillaId, $fechaTerminoServicio);
            $response ["status"] = "success";
        $response ["message"] = "Edicion finalizada";
        }else{
            $response["status"] = "error";
            $response["message"] = "Esta Plantilla Cuenta Con " . $ConteoTotalEmpleadosActivos . " Elementos Activos Deben Ser Cambiados De Plantilla Para Continuar ";
        }        
        
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>