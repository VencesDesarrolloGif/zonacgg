<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.


require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

$response = array ();


//$log = new KLogger ( "ajax_registroComentarioGuardia.log" , KLogger::DEBUG );


if (!empty ($_POST))
{   

    
    $numeroEmpleado=getValueFromPost("numeroEmpleado");
    $supervisorId=getValueFromPost("supervisorId");
    //$log->LogInfo("Valor de la variable \$numeroEmpleado: " . var_export ($numeroEmpleado, true));
    //$log->LogInfo("Valor de la variable \$supervisorId: " . var_export ($supervisorId, true));

    $empleadoEntidadId = substr($numeroEmpleado, 0,2);
    $empleadoConsecutivoId = substr($numeroEmpleado, 3,4);
    $empleadoTipoId = substr($numeroEmpleado, 8,2);

    $supervisorEntidadGuardia = substr($supervisorId, 0,2);
    $supervisorConsecutivoGuardia = substr($supervisorId, 3,4);
    $supervisorCategoriaGuardia = substr($supervisorId, 8,2);
 
    $datosComentario= array (
    "entidadGuardiaComentario" =>$empleadoEntidadId,
    "consecutivoGuardiaComentario" => $empleadoConsecutivoId,
    "categoriaGuardiaComentario" => $empleadoTipoId,
    "supervisorEntidadGuardia" => $supervisorEntidadGuardia,
    "supervisorConsecutivoGuardia" => $supervisorConsecutivoGuardia,
    "supervisorCategoriaGuardia" => $supervisorCategoriaGuardia,
    "comentario" =>strtoupper(getValueFromPost("comentario")),
    );

     //$log->LogInfo("Valor de la variable \$datosComentario: " . var_export ($datosComentario, true));
    try
    {
        $negocio -> insertComentarioGuardia($datosComentario);
        
        $response ["status"] = "success";
        $response ["message"] = "Comentario enviado.";
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