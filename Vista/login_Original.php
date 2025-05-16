<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
// $log = new KLogger ( "ajaxLogin.log" , KLogger::DEBUG );
if (!empty ($_POST))
{

    // Obtenemos los datos que llegan como parametros
    $usuarioCuenta = $_POST ["usuario"];
    $usuarioPassword = md5($_POST ["pass"]);
    
    

    $negocio = new Negocio();
    
   // $log->LogInfo("Valor de la variable \$usuarioCuenta: " . var_export ($usuarioCuenta, true));    
   // $log->LogInfo("Valor de la variable \$usuarioPassword: " . var_export ($usuarioPassword, true));

    $response = $negocio-> negocio_login ($usuarioCuenta, $usuarioPassword);


    //$entidadesbyuser = $negocio-> negocio_lentidadesByuser($usuarioCuenta, $usuarioPassword);
    // $log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));

    if ($response ["status"] == "success")
    {
        header ("Location:usuarioLogeado.php");

    }
    else
    {
        $errorMsg = $response ["message"];
        include ("form_Login.php");
    }
}
else
{
    include ("form_Login.php");
}
?>