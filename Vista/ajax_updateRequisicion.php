<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();  
$response = array();
verificarInicioSesion($negocio);
$usuario = $_SESSION["userLog"]["usuario"];
//$log = new KLogger("ajax_updateRequisicion.log", KLogger::DEBUG);
$usuario            = $_SESSION["userLog"]["usuario"];
$punto              = getValueFromPost("txtPuntoServicioIdEdited");
$costoTurno         = str_replace('$', '', getValueFromPost("txtCostoTurnoEdited"));
$costoTurnoAnterior = getValueFromPost("txtCostoTurnoEditedAnterior");
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$requisicion = array(
    "puntoServicioPlantillaId"       => getValueFromPost("txtIdRequisicion"),
    "puestoPlantillaId"         => getValueFromPost("selectPuestoRequisicionEdited"),
    "tipoTurnoPlantillaId"      => getValueFromPost("selectTurnoRequisicionEdited"),
    "rolOperativo"              => getValueFromPost("rolOpEdit"),
    "IdrolOperativo"              => getValueFromPost("selectRolOpE"),
    "fechaInicio"               => getValueFromPost("txtFechaInicioRequisicionEdited"), 
    "numeroElementos"           => getValueFromPost("txtNumeroElementosEdited"),
    "turnosPorDia"              => getValueFromPost("txtTurnosDiariosEdited"),
    "checkElementos0"           => getValueFromPost("checkElementosEdit"),
    "checkLunes0"               => getValueFromPost("checkLunesEdit"),
    "checkMartes0"              => getValueFromPost("checkMartesEdit"),
    "checkMiercoles0"           => getValueFromPost("checkMiercolesEdit"),
    "checkJueves0"              => getValueFromPost("checkJuevesEdit"),
    "checkViernes0"             => getValueFromPost("checkViernesEdit"), 
    "checkSabado0"              => getValueFromPost("checkSabadoEdit"),
    "checkDomingo0"             => getValueFromPost("checkDomingoEdit"),
    "TDiaLunes0"                => getValueFromPost("TDiaLunesEdit"),
    "TNocheLunes0"              => getValueFromPost("TNocheLunesEdit"),
    "TDiaMartes0"               => getValueFromPost("TDiaMartesEdit"),
    "TNochesMartes0"            => getValueFromPost("TNochesMartesEdit"),
    "TDiaMiercoles0"            => getValueFromPost("TDiaMiercolesEdit"),
    "TNocheMiercoles0"          => getValueFromPost("TNocheMiercolesEdit"),
    "TDiaJueves0"               => getValueFromPost("TDiaJuevesEdit"),
    "TNocheJueves0"             => getValueFromPost("TNocheJuevesEdit"),
    "TNocheViernes0"            => getValueFromPost("TNocheViernesEdit"),
    "TDiaViernes0"              => getValueFromPost("TDiaViernesEdit"),
    "TNocheSabado0"             => getValueFromPost("TNocheSabadoEdit"),
    "TDiaSabado0"               => getValueFromPost("TDiaSabadoEdit"),
    "TDiaDomingo0"              => getValueFromPost("TDiaDomingoEdit"),
    "TNocheDomingo0"            => getValueFromPost("TNocheDomingoEdit"),
    "TTotalesLunes0"            => getValueFromPost("TTotalesLunesEdit"),
    "TTotalesMartes0"           => getValueFromPost("TTotalesMartesEdit"),
    "TTotalesMiercoles0"        => getValueFromPost("TTotalesMiercolesEdit"),
    "TTotalesJueves0"           => getValueFromPost("TTotalesJuevesEdit"),
    "TTotalesViernes0"          => getValueFromPost("TTotalesViernesEdit"),
    "TtotalesSabado0"           => getValueFromPost("TtotalesSabadoEdit"),
    "TTotalesDomingo0"          => getValueFromPost("TTotalesDomingoEdit"),
    "CubreDescansoPlantillas0"  => getValueFromPost("CubreDescansoPlantillas"),
    "LineaNegocioPlantilla0"    => getValueFromPost("LineaNegocioPlantilla"),
    "IdClientePunto0"           => getValueFromPost("IdClientePunto"),
    "costoPorTurno"             => str_replace(',', '', $costoTurno),
    "cobraDescanso"             => getValueFromPost("diaDescanso"),
    "cobraFestivos"             => getValueFromPost("diaFestivo"),
    "cobraDia31"                => getValueFromPost("dia31"),
    "comentarioRequisicion"     => strtoupper(getValueFromPost("txtComentariosRequisicionEdited")),
    "recursosMateriales"        => strtoupper(getValueFromPost("txtRecursosMaterialesEdited")),
    "fechaTerminoPlantilla"     => getValueFromPost("txtFechaTerminoRequisicionEdited"),
    "costoNetoFactura"          => getValueFromPost("txtTotalFacturaEdited"),
    "fechaInicioPuntoServicio"  => getValueFromPost("txtFechaInicioPuntoServicioEdited"),
    "fechaTerminoPuntoServicio" => getValueFromPost("txtFechaTerminoPuntoServicioEdited"),
    "IdPuntoServicio"           => getValueFromPost("txtPuntoServicioIdEdited"),
    "usuarioCapturaPlantilla"   => $usuario,
);
//$log->LogInfo("Valor de la variable \$requisicion: " . var_export ($requisicion, true));
if ($costoTurno == $costoTurnoAnterior) {
    $accion = 0;
} else {
    $accion = 1;
}
try
{
    $negocio->updateRequisicion($requisicion, $accion);
    $response["status"]  = "success";
    $response["message"] = "La requisicion fue editada";

} catch (Exception $e) {
    $response["status"]  = "error";
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
