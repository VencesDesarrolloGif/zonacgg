<?php

function verificarInicioSesion ($negocio)
{
    if (!$negocio -> verificarInicioSesion ())
    {
        $response ["status"] = "error";
        $response ["message"] = "No autorizado";
        
        echo json_encode ($response);
        exit;
    }
}


function getValueFromPost ($index)
{
    return (isset ($_POST [$index])) ? $_POST [$index] : "";
}


?>