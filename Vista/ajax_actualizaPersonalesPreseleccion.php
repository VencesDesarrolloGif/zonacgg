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

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxRegistroEmpleado.log" , KLogger::DEBUG );
  

if (!empty ($_POST))
{
    

    // Creo que hace falta considerar el campo: Puesto que provienen del formulario.
    // Y hace falta que el formulario envie la foto del empleado.
    // el campo numeroSeguroSocial no se utiliza en persistencia.
    
    
    $empleado = array (
    "folio" => strtoupper(getValueFromPost("folioConsulta")),
    "apellidoPaterno" => strtoupper(getValueFromPost("apellidoPaternoEmpleado")),
    "apellidoMaterno" =>strtoupper( getValueFromPost("apellidoMaternoEmpleado")),
    "nombreEmpleado" => strtoupper(getValueFromPost("nombreEmpleado")),
    


    );
    
    
     
    try
    {

        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
        $negocio -> negocio_actualizaPreseleccion($empleado);
       
        $response ["status"] = "success";
        $response ["message"] = "Empleado registrado éxitosamente";

        
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
