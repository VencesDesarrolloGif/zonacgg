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

    

//$log = new KLogger ( "ajaxAsignacionEventual.log" , KLogger::DEBUG );

    $usuario = $_SESSION ["userLog"]["usuario"];

    $elementoEv = array (
        "idServicio" => getValueFromPost("txtIdServicioEv"),
        "numeroElemento" => getValueFromPost("txtNumEmpleadoEv"),
        "consecutivoElemento" => getValueFromPost("txtConsecutivoEl"),
        "nombreElemento" =>  getValueFromPost("txtNombreElementoEv"),
        "apPaternoEv" =>  getValueFromPost("txtApPaternoEv"),
        "apMaternoEv" => strtoupper(getValueFromPost("txtApMaternoEv")),            
    
    );


    //$log->LogInfo("Valor de la variable \$elementoEv : " . var_export ($elementoEv, true));
     
    try
    {
        $negocio -> negocio_asignarElementoEventual($elementoEv);
        
        $response ["status"] = "success";
        $response ["message"] = "Elemento asignado con éxito";
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