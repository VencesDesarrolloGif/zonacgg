<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
//require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio (); 

$response = array ();

verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxRegistroSueldoEmpleado.log" , KLogger::DEBUG );

if (!empty ($_POST))
{

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
        "usuarioCapturaCuota" =>$usuario,
        "empleadoEntidadCuota" =>$empleadoEntidad,
        "empleadoConsecutivoCuota" =>$empleadoConsecutivo,
        "empleadoCategoriaCuota" =>$empleadoCategoria,
      );
     //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));
    try
    {
        $negocio -> insertSueldoEmpleado($datos);
        
        $response ["status"] = "success";
        $response ["message"] = "Sueldo registrado éxitosamente";
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