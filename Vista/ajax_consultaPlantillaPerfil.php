<?php

session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");


$negocio= new Negocio();

verificarInicioSesion ($negocio);

$response = array();

if(!empty ($_POST))
{
	//$log = new KLogger ( "ajaxObtenerPlantillasPerfil.log" , KLogger::DEBUG );
    
    $puestoPlantillaId=getValueFromPost("puestoPlantillaId");
    $tipoTurnoPlantillaId=getValueFromPost("tipoTurnoPlantillaId");    
    $puntoServicioPlantillaId=getValueFromPost("puntoServicioPlantillaId");
	
    
    //$log->LogInfo("Valor de la variable \$puestoPlantillaId: " . var_export ($puestoPlantillaId, true));
    //$log->LogInfo("Valor de la variable \$tipoTurnoPlantillaId: " . var_export ($tipoTurnoPlantillaId, true));
    //$log->LogInfo("Valor de la variable \$generoElementoId: " . var_export ($generoElementoId, true));
    //$log->LogInfo("Valor de la variable \$puntoServicioPlantillaId: " . var_export ($puntoServicioPlantillaId, true));

    try{

        $lista = $negocio -> getServicioPlantillaPerfil($puestoPlantillaId, $tipoTurnoPlantillaId, $puntoServicioPlantillaId);

        

        //$log->LogInfo("Valor de la variable \$lista: " . var_export ($lista, true));
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));


        $noRegistros=count($lista);
        //$log->LogInfo("Valor de la variable \$noRegistros: " . var_export ($noRegistros, true));


        if($noRegistros==0){

            $response ["message"] = "¡OPS!: No hay una plantilla definida para este punto de servicio, se recomienda asignar al nuevo elemento en puntos de servicios que correspondan a GIF";
            $response ["status"] = "success";
            $response ["confirm"] = "0";
        }
        else 
        {
            // Recorre los elementos de la lista de plantillas buscando una
            // plantilla que aun tenga elementos por cubrir.
            // Si encuentra una plantilla que tenga elementos por cubrir, termina el ciclo
            // Si todos las plantillas estan cubiertas aun así nos dejará pasar.
            for ($i = 0; $i < count($lista); $i++)
            {
                $item = $lista [$i];

                if ($item ["ElementosAsignados"] < $item ["ElementosSolicitados"])
                {
                    break;
                }
            }

            if ($item["ElementosAsignados"] < $item ["ElementosSolicitados"])
            {
                $response ["confirm"] = "2";
                $response ["status"] = "success";
            }
            else
            {
                $response ["message"] = "¡ATENCION!: La contratación de este nuevo elemento rebasaría la plantilla autorizada,por lo cual NO podrá ser contratado"; //¿desea continuar con la contratación de este elemento? ";
                $response ["status"] = "success";
                $response ["confirm"] = "1";
            }
        }

    }
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] = "No se pudieron obtener Datos";
    }
}

echo json_encode ($response);
?>


