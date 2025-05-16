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


// $log = new KLogger ( "ajaxRegistrarSaldoInicial.log" , KLogger::DEBUG );
    
    $saldo = array (
    
    "fechaSaldoInicial" => getValueFromPost("fechaSaldoInicial"),
    "idBancoSaldoInicial" => getValueFromPost("idBancoSaldoInicial"),
    "saldoInicial" => getValueFromPost("saldoInicial"),
    );

     // $log->LogInfo("Valor de la variable \$saldo: " . var_export ($saldo, true));
    try
    {
        $negocio -> negocio_registrarSaldoInicial($saldo);
        
        $response ["status"] = "success";
        $response ["message"] = "Saldo registrado éxitosamente";
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