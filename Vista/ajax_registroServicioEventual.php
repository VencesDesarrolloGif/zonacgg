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

    

//$log = new KLogger ( "ajaxRegistroEventual.log" , KLogger::DEBUG );

    $usuario = $_SESSION ["userLog"]["usuario"];

    $servEventual = array (
        "folioEv" => getValueFromPost("txtFolioEv"),
        "idEventual" => getValueFromPost("txtIdEventual"),
        "clienteEv" => getValueFromPost("selectClienteEv"),
        "entidadEventual" =>  getValueFromPost("selectEntidadEv"),
        "direccionEv" =>  getValueFromPost("txtDireccionEv"),
        "nombreServicio" => strtoupper(getValueFromPost("txtNombreServicio")),
        "fechaInicioEv" => strtoupper(getValueFromPost("txtFechaInicioEventual")),
        "fechaFinEv" => getValueFromPost("txtFechaFinEventual"),
        "puestoEv" => getValueFromPost("selectPuestoEv"),
        "turnoEv" => getValueFromPost("selectTurnoEv"),
        "numElementosEv" => getValueFromPost("txtNElementos"),
        "usuarioCaptura" => $usuario,
        "lineaNegocio" => 1,        
    
    );



     
    try
    {
        $negocio -> negocio_registrarEventual($servEventual);
        
        $response ["status"] = "success";
        $response ["message"] = "Servicio registrado con exito";
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