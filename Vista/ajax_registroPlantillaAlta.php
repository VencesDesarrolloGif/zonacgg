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
// $log = new KLogger ( "ajaxRegistroPlantillaAlta.log" , KLogger::DEBUG );
   // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
    $usuario = $_SESSION ["userLog"]["usuario"];

    $turnosPorElemento=str_replace('$', '', getValueFromPost("txtCostoTurnoAlta"));

    $TotalFactura = getValueFromPost("txtTotalFacturaAlta");
    if($TotalFactura =="0"){
        $TDiaLunesAlta = "0";
        $TNocheLunesAlta = "0";
        $TDiaMartesAlta = "0";
        $TNochesMartesAlta = "0";
        $TDiaMiercolesAlta = "0";
        $TNocheMiercolesAlta = "0";
        $TDiaJuevesAlta = "0";
        $TNocheJuevesAlta = "0";
        $TNocheViernesAlta = "0";
        $TDiaViernesAlta = "0";
        $TNocheSabadoAlta = "0";
        $TDiaSabadoAlta = "0";
        $TDiaDomingoAlta = "0";
        $TNocheDomingoAlta = "0";
        $TTotalesLunesAlta = "0";
        $TTotalesMartesAlta = "0";
        $TTotalesMiercolesAlta = "0";
        $TTotalesJuevesAlta = "0";
        $TTotalesViernesAlta = "0";
        $TtotalesSabadoAlta = "0";
        $TTotalesDomingoAlta = "0";
    }else{
        $TDiaLunesAlta = getValueFromPost("TDiaLunesAlta");
        $TNocheLunesAlta = getValueFromPost("TNocheLunesAlta");
        $TDiaMartesAlta = getValueFromPost("TDiaMartesAlta");
        $TNochesMartesAlta = getValueFromPost("TNochesMartesAlta");
        $TDiaMiercolesAlta = getValueFromPost("TDiaMiercolesAlta");
        $TNocheMiercolesAlta = getValueFromPost("TNocheMiercolesAlta");
        $TDiaJuevesAlta = getValueFromPost("TDiaJuevesAlta");
        $TNocheJuevesAlta = getValueFromPost("TNocheJuevesAlta");
        $TNocheViernesAlta = getValueFromPost("TNocheViernesAlta");
        $TDiaViernesAlta = getValueFromPost("TDiaViernesAlta");
        $TNocheSabadoAlta = getValueFromPost("TNocheSabadoAlta");
        $TDiaSabadoAlta = getValueFromPost("TDiaSabadoAlta");
        $TDiaDomingoAlta = getValueFromPost("TDiaDomingoAlta");
        $TNocheDomingoAlta = getValueFromPost("TNocheDomingoAlta");
        $TTotalesLunesAlta = getValueFromPost("TTotalesLunesAlta");
        $TTotalesMartesAlta = getValueFromPost("TTotalesMartesAlta");
        $TTotalesMiercolesAlta = getValueFromPost("TTotalesMiercolesAlta");
        $TTotalesJuevesAlta = getValueFromPost("TTotalesJuevesAlta");
        $TTotalesViernesAlta = getValueFromPost("TTotalesViernesAlta");
        $TtotalesSabadoAlta = getValueFromPost("TtotalesSabadoAlta");
        $TTotalesDomingoAlta = getValueFromPost("TTotalesDomingoAlta");
    }
    $datos = array (
    "puntoServicioPlantillaId" =>  getValueFromPost("txtPuntoServicioIdAlta"),
    "puestoPlantillaId" => getValueFromPost("selectPuestoRequisicionAlta"),
    "tipoTurnoPlantillaId" => getValueFromPost("selectTurnoRequisicionAlta"),
    "rolOperativo" => getValueFromPost("rolOpNuevo"),    
    "selectRolOpA" => getValueFromPost("selectRolOpA"),    
    "folio" =>getValueFromPost("txtFolioRequisicionAlta"),
    "fechaInicio" =>getValueFromPost("txtFechaInicioRequisicionAlta"),
    "numeroElementos" =>getValueFromPost("txtNumeroElementosAlta"),
    "turnosPorDia" => getValueFromPost("txtTurnosDiariosAlta"),
    "checkElementos0" => getValueFromPost("checkElementosAlta"),
    "checkLunes0" => getValueFromPost("checkLunesAlta"),
    "checkMartes0" => getValueFromPost("checkMartesAlta"),
    "checkMiercoles0" => getValueFromPost("checkMiercolesAlta"),
    "checkJueves0" => getValueFromPost("checkJuevesAlta"),
    "checkViernes0" => getValueFromPost("checkViernesAlta"),
    "checkSabado0" => getValueFromPost("checkSabadoAlta"),
    "checkDomingo0" => getValueFromPost("checkDomingoAlta"),
    "TDiaLunes0" => $TDiaLunesAlta,
    "TNocheLunes0" => $TNocheLunesAlta,
    "TDiaMartes0" => $TDiaMartesAlta,
    "TNochesMartes0" => $TNochesMartesAlta,
    "TDiaMiercoles0" => $TDiaMiercolesAlta,
    "TNocheMiercoles0" => $TNocheMiercolesAlta,
    "TDiaJueves0" => $TDiaJuevesAlta,
    "TNocheJueves0" => $TNocheJuevesAlta,
    "TNocheViernes0" => $TNocheViernesAlta,
    "TDiaViernes0" => $TDiaViernesAlta,
    "TNocheSabado0" => $TNocheSabadoAlta,
    "TDiaSabado0" => $TDiaSabadoAlta,
    "TDiaDomingo0" => $TDiaDomingoAlta,
    "TNocheDomingo0" => $TNocheDomingoAlta,
    "TTotalesLunes0" => $TTotalesLunesAlta,
    "TTotalesMartes0" => $TTotalesMartesAlta,
    "TTotalesMiercoles0" => $TTotalesMiercolesAlta,
    "TTotalesJueves0" => $TTotalesJuevesAlta,
    "TTotalesViernes0" => $TTotalesViernesAlta,
    "TtotalesSabado0" => $TtotalesSabadoAlta,
    "TTotalesDomingo0" => $TTotalesDomingoAlta,
    "IdClientePunto0" => getValueFromPost("IdClientePunto"),
    "LineaNegocioPlantilla0" => getValueFromPost("LineaNegocioPlantilla"),
    "costoPorTurno" => str_replace(',', '', $turnosPorElemento), 
    "cobraDescanso" => getValueFromPost("diaDescanso"),
    "cobraFestivos" => getValueFromPost("diaFestivo"),
    "cobraDia31" => getValueFromPost("dia31"),  
    "usuarioCapturaPlantilla" => $usuario,
    "estatusPlantilla" => 1,
    "tipoRequisicion"=>getValueFromPost("tipoRequisicion"), 
    "comentarioRequisicion"=>strtoupper(getValueFromPost("txtComentariosRequisicionAlta")),
    "lineaNegocioRequisicion"=>getValueFromPost("txtIdLineaNegocioRequisicionAlta"),
    "costoNetoFactura"=>getValueFromPost("txtTotalFacturaAlta"),
    "recursosMateriales"=>strtoupper(getValueFromPost("txtRecursosMaterialesAlta")),
    "fechaTerminoPlantilla"=>strtoupper(getValueFromPost("txtFechaTerminoRequisicionAlta")),
    "fechaInicioPuntoServicio"=>strtoupper(getValueFromPost("txtFechaInicioPuntoServicioAlta")),
    "fechaTerminoPuntoServicio"=>strtoupper(getValueFromPost("txtFechaTerminoPuntoServicioAlta")),
    "LargotablaHorarios"=>strtoupper(getValueFromPost("LargotablaHorarios")),
 );
 for ($i=0; $i < getValueFromPost("LargotablaHorarios"); $i++) { 
        $datos["idHorario".$i] =  getValueFromPost("idHorario".$i);
    }
    // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
    try
    {
        $negocio -> registroDatosPlantilla($datos);
        
        $response ["status"] = "success";
        $response ["message"] = "Plantilla registrada con éxito";
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

