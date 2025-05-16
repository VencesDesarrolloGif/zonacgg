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
//$log = new KLogger ( "ajaxRegistroMovimiento.log" , KLogger::DEBUG );


  
    $usuario = $_SESSION ["userLog"]["usuario"];

    $movimiento = array (
    "fechaMovimiento" => getValueFromPost("fechaMovimiento"),
    "idEmpresaM" => getValueFromPost("empresa"),
    "txtSubTotal" => getValueFromPost("txtSubTotal"),   
    "reembolso" => getValueFromPost("reembolso"),
    "lblCLienteCaja" => getValueFromPost("lblCLienteCaja"),
    "lineaNegocio" => getValueFromPost("selectLineaNegocio"),
    "txtDescuento" => getValueFromPost("txtDescuento"),
    "selectTipoDeBanco" => getValueFromPost("selectTipoDeBanco"),
    "txtIva" => getValueFromPost("txtIva"),
    "selectNumCuenta" => getValueFromPost("selectNumCuenta"),
    "txtIvaRetenido" => getValueFromPost("txtIvaRetenido"),
    "idTipoTransaccionM" => getValueFromPost("tipoTransaccion"),
    "beneficiario" => strtoupper(getValueFromPost("txtbeneficiario")),
    "entidad" => getValueFromPost("selectEntidades"),
    "idEstatusM" => 3,
    "idDepartamentoM" => getValueFromPost("departamento"),
    "claveClasificacionM" => getValueFromPost("claveClasificacion"),
    "subdepartamento" => getValueFromPost("subdepartamento"),
    "concepto" => strtoupper(getValueFromPost("txtConcepto")),
    "referencia" => strtoupper(getValueFromPost("numeroReferencia")),
    "DocPdf" => getValueFromPost("DocPdf"),
    "idBancoM" =>  getValueFromPost("idbanco"),
    "monto" => getValueFromPost("monto"),
    "usuarioCaptura" => $usuario,
    "idTipoMov" =>  getValueFromPost("idTipoMov") ,
    "impBusqueda" =>  getValueFromPost("impBusqueda") ,
    "impTotalDisponible" =>  getValueFromPost("impTotalDisponible") ,
    "impTotalDisponibleCuenta" =>  getValueFromPost("impTotalDisponibleCuenta") ,

    
    
        );
     // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($movimiento, true));




     //$log->LogInfo("Valor de la variable \$montoFormato: " . var_export ($montoFormato, true));
    try
    {
        $negocio -> negocio_RegistrarMovimiento($movimiento);


    
        $response ["status"] = "success";
        $response ["message"] = "Movimiento registrado éxitosamente";
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