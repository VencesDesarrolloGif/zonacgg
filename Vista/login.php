<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start (); 
require "conexion.php";
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$log = new KLogger ( "ajaxLogin.log" , KLogger::DEBUG );
if (!empty ($_POST))
{
    // $log->LogInfo("Valor de la variable ip: " . var_export ($ip, true));    
    // $log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));

    // Obtenemos los datos que llegan como parametros
    $usuarioCuenta = $_POST ["usuario"];
    $usuarioPassword = md5($_POST ["pass"]);
    $negocio = new Negocio();
    
    $response = $negocio-> negocio_login ($usuarioCuenta, $usuarioPassword);


    if ($response ["status"] == "success")
    {
        header ("Location:usuarioLogeado.php");
    }
    else
    {
        $errorMsg = $response ["message"];
        header ("Location: http://38.110.58.228//zonacgg/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    }
}
else{
    header ("Location: http://38.110.58.228//zonacgg/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
}
?>