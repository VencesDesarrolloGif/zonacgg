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
//$log = new KLogger ( "ajaxActualizaEstatusOperativo.log" , KLogger::DEBUG );
 

    $empleadoId=getValueFromPost("numeroEmpleado");
    $tipoPeriodo=getValueFromPost("descripcionTipoPeriodo");
    $fechaBajaOperaciones=getValueFromPost("fechaBajaOperaciones");

  //  $log->LogInfo("Valor de la variable \$numeroEmpleado : " . var_export ($empleadoId, true));
  //  $log->LogInfo("Valor de la variable \$tipoPeriodo : " . var_export ($tipoPeriodo, true));

    $fechasPeriodo = $negocio -> obtenerListaDiasParaAsistencia ($tipoPeriodo);
  //  $log->LogInfo("Valor de la variable \$fechasPeriodo : " . var_export ($fechasPeriodo, true));

    $empleadoidd = explode("-", $empleadoId);
/*
   $empleadoEntidad=substr($empleadoId, 0,2);
  $empleadoConsecutivo=substr($empleadoId, 3,4);
  $empleadoCategoria=substr($empleadoId, 8,2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];

  

    $empleado ["entidadId"] = $empleadoEntidad;
    $empleado ["consecutivoId"] = $empleadoConsecutivo;
    $empleado ["tipoId"] = $empleadoCategoria;

    $incidencia["empleadoEntidad"]= $empleadoEntidad;
    $incidencia["empleadoConsecutivo"]= $empleadoConsecutivo;
    $incidencia["empleadoTipo"]= $empleadoCategoria;
    $incidencia["usuario"]= $_SESSION ["userLog"]["usuario"];

    $fechaBaja = strtotime ($fechaBajaOperaciones);

    try
    {

    $negocio -> updateEstatusEmpleadoOperacionesActivo ($empleado, 4);

    for ($i = 0; $i < count ($fechasPeriodo); $i++)
    {
        $fecha = strtotime ($fechasPeriodo[$i]["fecha"]);

        if ($fecha >= $fechaBaja)
            {
                             
                $incidencia["fechaAsistencia"]= date("Y-m-d", $fecha);
    //            $log->LogInfo("Valor de la variable incidencia : " . var_export ($incidencia, true));
                $negocio -> deleteAsistenciaFromAsistencia ($incidencia);
                            //$log->LogInfo("Valor de la variable \$registrado : " . var_export ($registrado, true));
            }
    }
        
        $response ["status"] = "success";
        $response ["message"] = "movimiento Exitoso";
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