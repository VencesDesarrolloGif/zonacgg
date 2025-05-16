<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);


	// $log = new KLogger ( "ajax_updatePuntoServicio.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));

    $usuario = $_SESSION ["userLog"]["usuario"];
	
	$puntoServicio = array (
	"numeroCentroCosto" => getValueFromPost("txtNumeroCentroE"),
    "puntoServicio" =>  getValueFromPost("txtPuntoServicioE"),
    "idEntidadPunto" => getValueFromPost("entidadEdited"),
    "idClientePunto" => getValueFromPost("clienteE"),
    "direccionPuntoServicio" => strtoupper(getValueFromPost("txtDireccionE")),
    "fechaInicioServicio" => getValueFromPost("txtFechaInicioE"),
    "fechaTerminoServicio" => getValueFromPost("txtFechaTerminoServicioE"),
    "contactoFacturacion" => strtoupper(getValueFromPost("txtContactoFacturacionE")),
    "correoFacturacion" => getValueFromPost("txtCorreoFacturacionE"),
    "telefonoFijoFacturacion" => getValueFromPost("txtTelefonoFijoFacturacionE"),
    "telefonoMovilFacturacion" => getValueFromPost("txtTelefonoMovilFacturacionE"),
    "terminoFacturacion" =>  getValueFromPost("txtTerminosFacturacionE") ,
    "contactoTesoreria" =>  getValueFromPost("txtContactoTesoreriaE") ,
    "correoTesoreria" =>  getValueFromPost("txtCorreoTesoreriaE") ,
    "telefonoFijoTesoreria" =>  getValueFromPost("txtTelefonoFijoTesoreriaE") ,
    "telefonoMovilTesoreria" =>  getValueFromPost("txtTelefonoMovilTesoreriaE") ,
    "contactoOperativo" => getValueFromPost("txtContactoOperativoE") ,
    "correoOperativo" =>  getValueFromPost("txtCorreoOperativoE") ,
    "telefonoFijoOperativo" =>  getValueFromPost("txtTelefonoFijoOperativoE") ,
    "telefonoMovilOperativo" =>  getValueFromPost("txtTelefonoMovilOperativoE") ,
    "idPuntoServicio" =>  getValueFromPost("idPuntoServicio") ,
    //"idBancoM" => getValueFromPost("idBancoM") ,
    "cobraDescansos"=>getValueFromPost("cobraDescansos"),
    "cobraDiaFestivo"=>getValueFromPost("cobraDiaFestivo"),
    "cobra31"=>getValueFromPost("cobra31"),
    "latitudPunto"=>getValueFromPost("txtLatitudE"),
    "longitudPunto"=>getValueFromPost("txtLongitudE"), 
    "turnoFlat"=>getValueFromPost("turnoFlat"),
    "selLineaNegocioEdited"=>getValueFromPost("selLineaNegocioEdited"), 
    "idtxtRegionEdited"=>getValueFromPost("idtxtRegionEdited"),
    "visiblerhEdited"=>getValueFromPost("visiblerhEdited"),
    "cubredescansoEdited"=>getValueFromPost("cubredescansoEdited"),
    "UnidadEdited" => strtoupper(getValueFromPost("txtUnidadE")),
    "DelMunEdited"=>getValueFromPost("selDelMunE"),
    "CpContratoPuntoServicioEdit"=>getValueFromPost("txtCpContratoPuntoServicioEdit"),
    "AsentamientoPuntoServicioEdit"=>getValueFromPost("txtAsentamientoPuntoServicioEdit"),
    "EntidadClientePuntoServicioEdit"=>getValueFromPost("txtEntidadClientePuntoServicioEdit"),
    "MunicipioPuntoServicioEdit"=>getValueFromPost("txtMunicipioPuntoServicioEdit"),
    "ColoniaClientePuntoServicioEdit"=>getValueFromPost("txtColoniaClientePuntoServicioEdit"),
    "CallePrincipalPuntoServicioEdit"=>getValueFromPost("txtCallePrincipalPuntoServicioEdit"),
    "NumeroInteriroPuntoServicioEdit"=>getValueFromPost("txtNumeroInteriroPuntoServicioEdit"),
    "NumeroExteriorPuntoServicioEdit"=>getValueFromPost("txtNumeroExteriorPuntoServicioEdit"),
    "Calle1PuntoServicioEdit"=>getValueFromPost("txtCalle1PuntoServicioEdit"), 
    "Calle2PuntoServicioEdit"=>getValueFromPost("txtCalle2PuntoServicioEdit"),
    "RangoAsisEdit"=>getValueFromPost("txtRangoAsisE"),


   	);
	
		//$log->LogInfo("Valor de la variable \$puntoServicio: " . var_export ($puntoServicio, true));
    try
    {
        $negocio -> updateCatalogopuntosservicios($puntoServicio);
        
        $response ["status"] = "success";
        $response ["message"] = "El punto de servicio fue Editado";
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }

echo json_encode ($response);
?>