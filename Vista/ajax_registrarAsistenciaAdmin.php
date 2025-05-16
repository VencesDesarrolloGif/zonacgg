<?php
// file: ajax_registrarAsistencia.php

// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

verificarInicioSesion ($negocio);

$response = array ();

if (!empty ($_POST))
{

    //$log = new KLogger ( "ajaxRegistroAsistencia.log" , KLogger::DEBUG );
    // datos de entrada por $_POST
    // empleadoEntidadId
    // empleadoConsecutivoId
    // empleadoTipoId
    // empleadoPuntoServicioId
    // supervisorEntidadId
    // supervisorConsecutivoId
    // supervisorTipoId
    // incidenciaId
    // asistenciaFecha (yyyy-mm-dd)
    $empleado ["entidadId"] = getValueFromPost ("empleadoEntidadId");
    $empleado ["consecutivoId"] = getValueFromPost ("empleadoConsecutivoId");
    $empleado ["tipoId"] = getValueFromPost ("empleadoTipoId");
    $empleado ["puntoServicioId"] = getValueFromPost ("puntoServicio");

    $comentariIncidencia=strtoupper(getValueFromPost ("comentariIncidencia"));

    $incidenciaId = getValueFromPost ("incidenciaId");
    $asistenciaFecha = getValueFromPost ("asistenciaFecha");
    $usuarioCapturaAsistencia = $_SESSION ["userLog"]["usuario"];
    $tipoPeriodo=getValueFromPost ("tipoPeriodo");
    $puestoCubiertoId=getValueFromPost("puestoCubiertoId");
    $puntoServicioId=getValueFromPost ("puntoServicio");
    $selplantillaservicioincidencia=getValueFromPost ("selplantillaservicioincidencia");

    


    //$log->LogInfo("Valor de la variable \$valordia: " . var_export ($valordia, true));

    //$verificaIncidencia= $negocio -> getAsistenciaByEmpleadoFecha($asistenciaFecha, $empleado ["entidadId"], $empleado ["consecutivoId"],$empleado ["tipoId"]);
    //$log->LogInfo("Valor de la variable \$verificaIncidencia: " . var_export ($verificaIncidencia, true));

    try{
        
        
    //$log->LogInfo("Valor de la variable \$puestos: " . var_export ($puestos, true));
            $response = $negocio -> negocio_registroAsistenciaAdmin (
            $empleado,             
            $incidenciaId, 
            $asistenciaFecha, 
            $usuarioCapturaAsistencia,
            $comentariIncidencia,
            $tipoPeriodo, $puestoCubiertoId,$selplantillaservicioincidencia);

            $fechasPeriodo = $negocio -> obtenerListaDiasParaAsistencia ($tipoPeriodo);
             // Recupera la lista de asistencias del empleado por todo el periodo
            $response ["asistencia"] =  $negocio -> getAsistenciaByEmpleadoPeriodo ($fechasPeriodo[0]["fecha"], 
            $fechasPeriodo[count($fechasPeriodo) - 1]["fecha"], 
            $empleado["entidadId"], 
            $empleado ["consecutivoId"], 
            $empleado ["tipoId"]);

    }catch(Exception $e){

        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();

    }

}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
//$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
echo json_encode ($response);
?>
