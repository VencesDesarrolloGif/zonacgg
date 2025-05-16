<?php

session_start();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

$response = array ();

verificarInicioSesion($negocio);


	// $log = new KLogger ( "ajaxActualizarMovimientoFinanciero.log" , KLogger::DEBUG );

    $usuario = $_SESSION ["userLog"]["usuario"];
	
	$movimiento = array (
	"fechaMovimiento" => getValueFromPost("fechaEdited"),
    "idBancoM" =>  getValueFromPost("bancoEdited"),
    "beneficiario" => strtoupper(getValueFromPost("txtbeneficiarioEdited")),
    "concepto" => strtoupper(getValueFromPost("txtConceptoEdited")),
    "idTipoTransaccionM" => getValueFromPost("selectTipoTransaccionEdited"),
    "claveClasificacionM" => getValueFromPost("claveClasificacionEdited"),
    "idDepartamentoM" => getValueFromPost("selectTipoDeptoEdited"),
    "referencia" => strtoupper(getValueFromPost("txtreferenciaEdited")),
    "idEstatusM" => getValueFromPost("idEstatusM"),
    "idEmpresaM" => getValueFromPost("selectEmpresaEdited"),
    "monto" => getValueFromPost("txtmontoEdited"),
    "usuarioCaptura" => $usuario,
    "idTipoMov" =>  getValueFromPost("tipoMovimientoEdited") ,
    "idMovimiento" => getValueFromPost("idMovimiento") ,
    //"idBancoM" => getValueFromPost("idBancoM") ,
   	);



	
		// $log->LogInfo("Valor de la variable \$movimiento: " . var_export ($movimiento, true));
    try
    {
        $negocio -> editarRegistroMovimientoFinanciero($movimiento);
        
        $response ["status"] = "success";
        $response ["message"] = "Movimiento Editado";
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }

echo json_encode ($response);
?>