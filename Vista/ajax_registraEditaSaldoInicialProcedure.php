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


// $log = new KLogger ( "ajaxRegistraEditaSaldoInicial.log" , KLogger::DEBUG );
   
   $usuario = $_SESSION ["userLog"]["usuario"];
    
   $fecha=getValueFromPost("fechaSaldoInicial");
   $bancoId=getValueFromPost("idBancoSaldoInicial");
   $idEmpresa=getValueFromPost("idEmpresaSaldoIncial");
   $saldo=getValueFromPost("saldoInicial");

     // $log->LogInfo("Valor de la variable \$fecha: " . var_export ($fecha, true));
     // $log->LogInfo("Valor de la variable \$bancoId: " . var_export ($bancoId, true));
     // $log->LogInfo("Valor de la variable \$idEmpresa: " . var_export ($idEmpresa, true));
     // $log->LogInfo("Valor de la variable \$saldo: " . var_export ($saldo, true));
     // $log->LogInfo("Valor de la variable \$usuario: " . var_export ($usuario, true));
    try
    {
        $negocio -> negocio_insertarActualizarSaldoInicial($fecha, $bancoId, $idEmpresa, $saldo, $usuario);
        
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