<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

//$log = new KLogger ( "ajax_getEmpleadoByCorreo.log" , KLogger::DEBUG );

$response = array("status" => "success");



            $correo=getValueFromPost("correo");
            //$log->LogInfo("Valor de variable de empleado correo" . var_export ($correo, true));
        
try{

    //$listaEmpleados= $negocio -> getListaEmpleadosPeriodoEmpleadoId($fecha1, $fecha2,$periodoId, $empleado);
    $listaEmpleados= $negocio -> getEmpleadoByCorreo($correo);
    
    for ($i = 0; $i < count($listaEmpleados); $i++)
    {
        
        $numeroEmpleado=$listaEmpleados[$i]["numeroEmpleado"];

        $empleadoidd = explode("-", $numeroEmpleado);

        $empleadoEntidadId=$empleadoidd[0];
        $empleadoConsecutivoId=$empleadoidd[1];
        $empleadoTipoId=$empleadoidd[2];

        $tipoPeriodo=$listaEmpleados[$i]["tipoPeriodo"];
        $descripcionTipoPeriodo=$listaEmpleados[$i]["descripcionTipoPeriodo"];
        $idTipoPuesto=$listaEmpleados[$i]["idTipoPuesto"];

        $diasAsistencia= $negocio -> obtenerListaDiasParaAsistencia ($descripcionTipoPeriodo);
        
        $fecha1=$diasAsistencia[0]["fecha"];
        $fecha2=$diasAsistencia[count($diasAsistencia)-1]["fecha"];
        //$log->LogInfo("Valor de variable de diasAsistencia correo" . var_export ($diasAsistencia, true));
        //$log->LogInfo("Valor de variable de diasAsistencia fecha1" . var_export ($fecha1, true));
        //$log->LogInfo("Valor de variable de diasAsistencia fecha2" . var_export ($fecha2, true));


        //$listaEmpleados [$i]["asistencia"] = $negocio -> getAsistenciaByEmpleadoPeriodo ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["asistencia"] = $negocio -> getAsistenciaByEmpleadoIdPeriodo ($fecha1, $fecha2, $numeroEmpleado);
        $listaEmpleados [$i]["turnosExtras"] = $negocio -> getSumaTurnosExtras ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["descuentos"] = $negocio -> getSumDescuentos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["incidenciasEspeciales"] = $negocio -> getSumaIncidenciasEspeciales ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
        $listaEmpleados [$i]["diasFestivos"] = $negocio -> getSumaDiasFestivos ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId);
    }

    $response["listaEmpleados"]= $listaEmpleados;
    //$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($response, true));

} 
catch( Exception $e )
{
    $response["status"]="error";
    $response["error"]="No se puedo obtener consulta";
    $response ["message"] =  $e -> getMessage ();
}



echo json_encode($response);

?>