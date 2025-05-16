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
//$log = new KLogger ( "ajaxEdicionSueldoEmpleado.log" , KLogger::DEBUG );

    $usuario = $_SESSION ["userLog"]["usuario"];
    $numeroEmpleado=getValueFromPost("numeroEmpleado");   

    $empleadoidd = explode("-", $numeroEmpleado);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];
          

    $datos = array (
        "sueldoEmpleado" => getValueFromPost("sueldoEmpleado"),
        "cuotaDiariaEmpleado" => getValueFromPost("cuotaDiariaEmpleado"),
        "bonoAsistenciaEmpleado" =>getValueFromPost("bonoAsistencia"),
        "bonoPuntualidadEmpleado" =>getValueFromPost("bonoPuntualidad"),
        "lastUserEditedCuota" =>$usuario,
        "empleadoEntidadCuota" =>$empleadoEntidad,
        "empleadoConsecutivoCuota" =>$empleadoConsecutivo,
        "empleadoCategoriaCuota" =>$empleadoCategoria,
      );

    //$log->LogInfo("Valor de la variable \$datos : " . var_export ($datos, true));

    try
    {
        
        $negocio -> updateSueldoEmpleado($datos);
        
        $response ["status"] = "success";
        $response ["message"] = "Edicion finalizada";
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
//$log->LogInfo("Valor de la variable \$response : " . var_export ($response, true));
echo json_encode ($response);
?>