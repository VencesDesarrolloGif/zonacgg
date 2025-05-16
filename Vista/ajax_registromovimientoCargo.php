<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";

$negocio = new Negocio();

$response = array();

verificarInicioSesion($negocio);

if (!empty($_POST)) {
//$log = new KLogger ( "ajaxRegistroMovimiento.log" , KLogger::DEBUG );

    $usuario = $_SESSION["userLog"]["usuario"];

    $movimientoCargo = array(
        "fechaMovimientoCargo"          => getValueFromPost("fechaMovimientoCargo"),
        "idEmpresaMCargo"               => 1,
        "txtSubTotalCargo"              => getValueFromPost("txtSubTotalCargo"),
        //  "reembolso" => getValueFromPost("reembolso"),
        //  "lblCLienteCaja" => getValueFromPost("lblCLienteCaja"),
        "lineaNegocioCargo"             => getValueFromPost("selectLineaNegocioCargo"),
        "empresaCargo"             => getValueFromPost("empresaCargo"),
        "txtDescuentoCargo"             => getValueFromPost("txtDescuentoCargo"),
        "selectTipoDeBancoCargo"        => getValueFromPost("selectTipoDeBancoCargo"),
        "txtIvaCargo"                   => getValueFromPost("txtIvaCargo"),
        "selectNumCuentaCargo"          => getValueFromPost("selectNumCuentaCargo"),
        "txtIvaRetenidoCargo"           => getValueFromPost("txtIvaRetenidoCargo"),
        "idTipoTransaccionMCargo"       => getValueFromPost("tipoTransaccionCargo"),
        "beneficiarioCargo"             => strtoupper(getValueFromPost("txtbeneficiarioCargo")),
        "entidadCargo"                  => getValueFromPost("selectEntidadesCargo"),
        "idEstatusMCargo"               => 2,
        "idDepartamentoMCargo"          => 30,
        "claveClasificacionMCargo"      => getValueFromPost("claveClasificacionCargo"),
        "subdepartamentoCargo"          => 26,
        "conceptoCargo"                 => strtoupper(getValueFromPost("txtConceptoCargo")),
        "referenciaCargo"               => strtoupper(getValueFromPost("numeroReferenciaCargo")),
        "DocPdfCargo"                   => getValueFromPost("DocPdfCargo"),
        "idBancoMCargo"                 => getValueFromPost("idbancoCargo"),
        "montoCargo"                    => getValueFromPost("montoCargo"),
        "usuarioCaptura"                => $usuario,
        "idTipoMov"                     => getValueFromPost("idTipoMov"),
    );
    // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($movimiento, true));

    //$log->LogInfo("Valor de la variable \$montoFormato: " . var_export ($montoFormato, true));
    try
    {
        $negocio->negocio_RegistrarMovimientoCargo($movimientoCargo);

        $response["status"]  = "success";
        $response["message"] = "Registro de Movimiento Realizado Correctamente";
    } catch (Exception $e) {
        $response["status"]  = "error";
        $response["message"] = $e->getMessage();
    }
} else {
    $response["status"]  = "error";
    $response["message"] = "No se proporcionaron datos";
}

echo json_encode($response);
