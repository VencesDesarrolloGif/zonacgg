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
//$log = new KLogger ( "ajaxTransferencia.log" , KLogger::DEBUG );


    $usuario = $_SESSION ["userLog"]["usuario"];


    $supervisor1= getValueFromPost("supervisor1");
    $supervisor2= getValueFromPost("supervisor2");

        $supervisorEntidad=substr($supervisor1, 0,2);
        $supervisorConsecutivo=substr($supervisor1, 3,4);
        $supervisorTipo=substr($supervisor1, 8,2);

    

     //$log->LogInfo("Valor de la variable \$supervisor1: " . var_export ($supervisor1, true));
     //$log->LogInfo("Valor de la variable \$supervisor2: " . var_export ($supervisor2, true));
    try
    {
        //$negocio -> negocio_editarDatosDireccion($datosDireccion);

    $puntos = $negocio -> getPuntosServiciosSupervisor($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo);

            $supervisor1= array (
            "idEntidadResponsableAsistencia" =>substr(getValueFromPost("supervisor1"),0,2),
            "consecutivoResponsableAsistencia" =>substr(getValueFromPost("supervisor1"),3,4),
            "tipoResponsableAsistencia" => substr(getValueFromPost("supervisor1"),8,2),
            );

            $supervisor2 = array (
             "idEntidadResponsableAsistencia" => substr(getValueFromPost("supervisor2"),0,2),
             "consecutivoResponsableAsistencia" => substr(getValueFromPost("supervisor2"),3,4),
             "tipoResponsableAsistencia" => substr(getValueFromPost("supervisor2"),8,2),

            );

    $negocio -> actualizarSupervisor($supervisor1, $supervisor2);

    //$log->LogInfo("Valor de la variable \$puntos: " . var_export ($puntos, true));

        for ($i=0 ; $i< count($puntos); $i++){


            $datos= array (
            "supervisorEntidad" =>substr(getValueFromPost("supervisor2"),0,2),
            "supervisorConsecutivo" =>substr(getValueFromPost("supervisor2"),3,4),
            "supervisorTipo" => substr(getValueFromPost("supervisor2"),8,2),
            "puntoServicioId" => $puntos[$i]["puntoServicioId"],
            "usuarioAsigna" => $usuario,
            );

            $supervisor = array (
             "supervisorEntidad" => substr(getValueFromPost("supervisor1"),0,2),
             "supervisorConsecutivo" => substr(getValueFromPost("supervisor1"),3,4),
             "supervisorTipo" => substr(getValueFromPost("supervisor1"),8,2),
             "puntoServicioId" => $puntos[$i]["puntoServicioId"],
            );



            $negocio -> asignacionPuntoServicioASupervisor($datos);
            
            //$log->LogInfo("Valor de la variable \$asignacion: " . var_export ($asignacion, true));
            $negocio -> deletePuntoServicioSupervisor($supervisor);
    

        }

        //$log->LogInfo("Valor de la variable \$puntos: " . var_export ($puntos, true));
        
        $response ["status"] = "success";
        $response ["message"] = "Transferencia éxitosa";
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