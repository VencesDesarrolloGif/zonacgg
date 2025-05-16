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
//$log = new KLogger ( "ajaxSolicitaReingresoImss.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable \$datosImss: " . var_export ($datosImss, true));
    $usuario = $_SESSION ["userLog"]["usuario"]; 
    $empleadoId=getValueFromPost("numeroEmpleado");
    $empleadoIdd = explode("-", $empleadoId);
    $entidadFederativaId=$empleadoIdd[0];
    $empleadoConsecutivoId=$empleadoIdd[1];
    $empleadoCategoriaId=$empleadoIdd[2];
    $datosImss= array (
        "empladoEntidadImss" =>$entidadFederativaId,
        "empleadoConsecutivoImss" => $empleadoConsecutivoId,
        "empleadoCategoriaImss" => $empleadoCategoriaId,
        "empleadoEstatusImss" => getValueFromPost("empleadoEstatusImss"),
        "folioTxt" => getValueFromPost("folioTxt"),
        "numeroLote" => getValueFromPost("numeroLote"),
        "fechaImss" => getValueFromPost("fechaImss"),
        "salario" => getValueFromPost("SalarioDiarioReingreso"),
        "bandera" => getValueFromPost("BanderaReingreso"),
    );
    try
    {
        $negocio -> reingresarEmpleadoImss($datosImss);
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