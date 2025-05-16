<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);

//$log = new KLogger ( "ajaxRegistroPlantilla.log" , KLogger::DEBUG );

//$log->LogInfo("Valor de la variable \$_POST: " . var_export ($_POST, true));

if (!empty ($_POST))
{
    $usuario = $_SESSION ["userLog"]["usuario"];

    $turnosPorElemento=str_replace('$', '', getValueFromPost("txtCostoTurno"));

    $datos = array (
    "puntoServicioPlantillaId" =>  getValueFromPost("txtPuntoServicioIdRequisicion"),
    "puestoPlantillaId" => getValueFromPost("selectPuestoRequisicion"),
    "tipoTurnoPlantillaId" => getValueFromPost("selectTurnoRequisicion"),
    "rolOperativo" => getValueFromPost("rolOperativoNuevo"),    
    "folio" =>getValueFromPost("txtFolioRequisicion"),
    "fechaInicio" =>getValueFromPost("txtFechaInicioRequisicion"),
    "numeroElementos" =>getValueFromPost("txtNumeroElementos"),
    "turnosPorDia" => getValueFromPost("txtTurnosDiarios"),
    "checkElementos0" => getValueFromPost("checkElementosNuevo"),
    "checkLunes0" => getValueFromPost("checkLunes"),
    "checkMartes0" => getValueFromPost("checkMartes"),
    "checkMiercoles0" => getValueFromPost("checkMiercoles"),
    "checkJueves0" => getValueFromPost("checkJueves"),
    "checkViernes0" => getValueFromPost("checkViernes"),
    "checkSabado0" => getValueFromPost("checkSabado"),
    "checkDomingo0" => getValueFromPost("checkDomingo"),
    "TDiaLunes0" => getValueFromPost("TDiaLunes"),
    "TNocheLunes0" => getValueFromPost("TNocheLunes"),
    "TDiaMartes0" => getValueFromPost("TDiaMartes"),
    "TNochesMartes0" => getValueFromPost("TNochesMartes"),
    "TDiaMiercoles0" => getValueFromPost("TDiaMiercoles"),
    "TNocheMiercoles0" => getValueFromPost("TNocheMiercoles"),
    "TDiaJueves0" => getValueFromPost("TDiaJueves"),
    "TNocheJueves0" => getValueFromPost("TNocheJueves"),
    "TNocheViernes0" => getValueFromPost("TNocheViernes"),
    "TDiaViernes0" => getValueFromPost("TDiaViernes"),
    "TNocheSabado0" => getValueFromPost("TNocheSabado"),
    "TDiaSabado0" => getValueFromPost("TDiaSabado"),
    "TDiaDomingo0" => getValueFromPost("TDiaDomingo"),
    "TNocheDomingo0" => getValueFromPost("TNocheDomingo"),
    "TTotalesLunes0" => getValueFromPost("TTotalesLunes"),
    "TTotalesMartes0" => getValueFromPost("TTotalesMartes"),
    "TTotalesMiercoles0" => getValueFromPost("TTotalesMiercoles"),
    "TTotalesJueves0" => getValueFromPost("TTotalesJueves"),
    "TTotalesViernes0" => getValueFromPost("TTotalesViernes"),
    "TtotalesSabado0" => getValueFromPost("TtotalesSabado"),
    "TTotalesDomingo0" => getValueFromPost("TTotalesDomingo"),
    "IdClientePunto0" => getValueFromPost("idClientePunto"),
    "LineaNegocioPlantilla0" => getValueFromPost("txtLineaNegocioPlantilla"),
    "costoPorTurno" => str_replace(',', '', $turnosPorElemento), 
    "cobraDescanso" => getValueFromPost("diaDescanso"),
    "cobraFestivos" => getValueFromPost("diaFestivo"),
    "cobraDia31" => getValueFromPost("dia31"),
    "usuarioCapturaPlantilla" => $usuario,
    "estatusPlantilla" => 1,
    "tipoRequisicion"=>getValueFromPost("tipoRequisicion"),
    "comentarioRequisicion"=>strtoupper(getValueFromPost("txtComentariosRequisicion")),
    "lineaNegocioRequisicion"=>getValueFromPost("txtLineaNegocioPlantilla"),
    "costoNetoFactura"=>getValueFromPost("txtTotalFactura"),
    "recursosMateriales"=>strtoupper(getValueFromPost("txtRecursosMateriales")),
    "fechaTerminoPlantilla"=>strtoupper(getValueFromPost("txtFechaTerminoRequisicion")),
    "fechaInicioPuntoServicio"=>getValueFromPost("txtFechaInicioPuntoServicioRequisicion"),
    "fechaTerminoPuntoServicio"=>getValueFromPost("txtFechaTerminoPuntoServicioRequisicion"),
 );
  //   $log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));

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

