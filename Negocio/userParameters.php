<?php
require_once ("../libs/logger/KLogger.php");

require_once("../Persistencia/Usuario.php");

function negocio_login ($usuarioCuenta, $usuarioPassword)
{
    $log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    // Definimos la variable que contendra la respuesta
    $response = array (
        "status" => "success",
        "message" => "");


    $log -> LogInfo ("UsuarioCuenta: " . $usuarioCuenta);
    $log -> LogInfo ("UsuarioPassword: " . $usuarioPassword);

    // Se realizan las validaciones correspondientes al negocio.



    // Se accede a persistencia
    $usuario=new Usuario();

    $user=$usuario->login($usuarioCuenta, $usuarioPassword);

    $log->LogInfo("Valor de la variable \$user: " . var_export ($user, true));

    // Si el resultado de login no es null entonces guardamos los datos
    // del usuario en la sesión con el identificador "usuario"
    if ($user != null)
    {
        $_SESSION ['usuario'] = $user[0];
    }
    else
    {
        $response ["status"] = "error";
        $response ["message"] = "Error de acceso";
    }

    return $response;
}
?>
