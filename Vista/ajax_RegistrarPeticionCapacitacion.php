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
//$log = new KLogger ( "ajaxRegistroHistoricoBaja.log" , KLogger::DEBUG );
    $usuario = $_SESSION ["userLog"]["usuario"];

    $DatosCapacitacion= array (
    "asistenciaFecha" => strtoupper(getValueFromPost("asistenciaFecha")),
    "puestoCubiertoId" => getValueFromPost("puestoCubiertoId"),
    "empleadoEntidadId" =>getValueFromPost("empleadoEntidadId"),
    "empleadoConsecutivoId" =>getValueFromPost("empleadoConsecutivoId"), 
    "empleadoTipoId" =>getValueFromPost("empleadoTipoId"), 
    "empleadoPuntoServicioId" => getValueFromPost("empleadoPuntoServicioId"),
    "supervisorEntidadId" => getValueFromPost("supervisorEntidadId"),
    "supervisorConsecutivoId" => getValueFromPost("supervisorConsecutivoId"),
    "supervisorTipoId" => getValueFromPost("supervisorTipoId"),
    "plantilladeservicio" => strtoupper(getValueFromPost("plantilladeservicio")),
    "idPlantillaServicio" => strtoupper(getValueFromPost("idPlantillaServicio")),
    "usuario" =>$usuario);
    $idPlantillaServicio=getValueFromPost("idPlantillaServicio");//is¨Planyilla
    $asistenciaFecha=getValueFromPost("asistenciaFecha");//is¨Planyilla
   // $log->LogInfo("Valor de la variable \$datosBaja: " . var_export ($datosBaja, true));
    try
    {
        $Vigenciaplantilla = $negocio -> consultaVigenciaplantilla($idPlantillaServicio);
        $fecha_actual1 = $asistenciaFecha;
        $Fechaplantilla1 = $Vigenciaplantilla[0]["fechaTerminoPlantilla"]; 
        $fecha_actual = explode('-', $fecha_actual1);
        $fecha_actual_Anio = $fecha_actual[0];
        $fecha_actual_Mes = $fecha_actual[1];
        $fecha_actual_Dia = $fecha_actual[2];
        $Fechaplantilla = explode('-', $Fechaplantilla1);
        $Fechaplantilla_Anio = $Fechaplantilla[0];
        $Fechaplantilla_Mes = $Fechaplantilla[1];
        $Fechaplantilla_Dia = $Fechaplantilla[2];
        if($Fechaplantilla_Anio > $fecha_actual_Anio){
            $CondicionFecha = "1";
        }else{
            if($Fechaplantilla_Mes > $fecha_actual_Mes){
                $CondicionFecha = "1";
            }else{
                if($Fechaplantilla_Dia >= $fecha_actual_Dia){
                    $CondicionFecha = "1";
                }else{
                    $CondicionFecha = "0";
                }
            }
        }
        if($CondicionFecha=="1"){
            $negocio -> negocio_registrarpeticionCapacitacion($DatosCapacitacion);
            $response ["status"] = "success";
            $response ["message"] = "Registro De Incidencia Para Capacitación Realizada Con Exitó";
        }else{
            $response ["status"] = "error";
            $response ["message"] = "Error en la plantilla seleccionada, Ya culmino la vigencia de esta plantilla"; 
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