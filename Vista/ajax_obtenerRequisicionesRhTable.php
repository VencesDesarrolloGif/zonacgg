<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

/*
if(!empty ($_POST))
{
*/
    
        //$log = new KLogger ( "ajaxObtenerRequisicionesTable.log" , KLogger::DEBUG );
        //$estatusEmpleado=getValueFromPost("estatusEmpleado");

    try{
        

        $lista= $negocio -> getServicioPlantilla();
   
        for ($i = 0; $i < count($lista); $i++)
        {   
            $descripcionPuesto = $lista[$i] ["descripcionPuesto"];
            $descripcionTurno = $lista[$i] ["descripcionTurno"];            
            $puntoServicio = $lista[$i] ["puntoServicio"];
            $comentarioRequisicion = $lista[$i] ["comentarioRequisicion"];
            $nombreEntidadFederativa = $lista[$i] ["nombreEntidadFederativa"];
            $direccionPuntoServicio = $lista[$i] ["direccionPuntoServicio"];
            $fechaInicio = $lista[$i] ["fechaInicio"];
            $ElementosSolicitados = $lista[$i] ["ElementosSolicitados"];
            $ElementosAsignados = $lista[$i] ["ElementosAsignados"];
            $ElementosEnPuntoServicio = $lista[$i] ["ElementosEnPuntoServicio"];
            $diferencia = $lista[$i] ["diferencia"];
            $razonSocial = $lista[$i] ["razonSocial"];
            $idPuntoServicio = $lista[$i] ["idPuntoServicio"];


            
            //$lista[$i]["diferencia"]=abs($elementosContratados-$numeroElementos);

        }
        
        $response["data"]= $lista;

        //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
        

        //$log->LogInfo("Valor de la variable \$response requisiciones: " . var_export ($response, true));

    } 
    catch( Exception $e )
    {
    $response["status"]="error";
    $response["error"]="No se pudo obtener lista de requisiciones";
    }
/*
}
*/

echo json_encode($response);

?>