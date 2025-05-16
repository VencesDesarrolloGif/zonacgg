<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
//$usuario = array ();
//$log = new KLogger ( "ajaxRegistroCobranza.log" , KLogger::DEBUG );

$fechaMovimiento  = $_POST['fechaMovimiento'];
$SelecCliente  = $_POST['SelecCliente'];
$SelectPeriodoCo  = $_POST['SelectPeriodoCo'];
$empresa  = $_POST['empresa'];
$tipoTransaccion = $_POST['tipoTransaccion'];
$numeroReferencia1  = $_POST['numeroReferencia1'];
$selectTipoDeBanco  = $_POST['selectTipoDeBanco'];
$selectNumCuenta  = $_POST['selectNumCuenta'];

$ImpFactura  = $_POST['infactura'];
$SelectPeriodoFac  = $_POST['inpidperiodofac'];
$selectLineaNegocio  = $_POST['inpidlineanegocio'];
$selectEntidades  = $_POST['inentidad'];
$txtSubTotal  = $_POST['insubtotal'];
$txtDescuento  = $_POST['indescuento'];
$txtIva  = $_POST['intasaiva'];
$IvaCalculado  = $_POST['intotaliva'];
$Total  = $_POST['intotal'];
$Ejercicio = $_POST['inpidejerciciofac'];
// $log = new KLogger ( "ajaxRegistroMovimientoCobraaanzaa.log" , KLogger::DEBUG );

verificarInicioSesion ($negocio);

if (!empty ($_POST))
{
    $usuario = $_SESSION ["userLog"]["usuario"];
//$log->LogInfo("Valor de la variable \$datastring: " . var_export ($_SESSION ["userLog"]["usuario"], true));
    $movimientocobranza = array (
    "fechaMovimiento" => $fechaMovimiento,
    "SelecCliente" => $SelecCliente,
    "SelectPeriodoCo" => $SelectPeriodoCo,
    "empresa" => $empresa,
    "tipoTransaccion" => $tipoTransaccion,
    "numeroReferencia1" =>$numeroReferencia1,
    "selectTipoDeBanco" => $selectTipoDeBanco,
    "selectNumCuenta" => $selectNumCuenta,
// "tabla" => getValueFromPost("tabla"),
    );
    //  $log -> LogInfo ("ajax_Movimientocobranza". var_export($movimientocobranza,true));
    //$log = new KLogger ( "ajaxRegistroMovimientoCobraaanzaa.log" , KLogger::DEBUG );
    try
    {
        $Registro_MovimientoCobranza = $negocio->negocio_RegistrarMovimientoCobranza($movimientocobranza,$usuario);
        $Registro_MovimientoCobranza1=$Registro_MovimientoCobranza[0]['idMovCobranza'];  
        //$log -> LogInfo ("ajax_Movimientocobranza". var_export($Registro_MovimientoCobranza,true));
       // $log -> LogInfo ("contador". var_export($contador,true));
        for($i=0;$i<count($SelectPeriodoFac);$i++){
            //$log -> LogInfo ("valor de i--->". var_export($Registro_MovimientoCobranza,true));
            $Registro_MovimientoCobranza = $negocio->negocio_RegistrarMovimientoCobranza1($Registro_MovimientoCobranza1,$ImpFactura[$i],$SelectPeriodoFac[$i],$Ejercicio[$i],$SelectPeriodoCo,$selectLineaNegocio[$i],$selectEntidades[$i],$txtSubTotal[$i],$txtDescuento[$i],$txtIva[$i],$IvaCalculado[$i],$Total[$i]);
        }

        $response ["status"] = "success";
        $response ["message"] = "Registo Realizado Éxitosamente";
        $response ["Registromov"] =$Registro_MovimientoCobranza1; 
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