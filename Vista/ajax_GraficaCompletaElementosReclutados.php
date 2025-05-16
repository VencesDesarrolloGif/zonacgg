<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);

$response = array("status" => "success");
		// $log = new KLogger ( "ajaxGrafCom.log" , KLogger::DEBUG );
		$month=getValueFromPost("month");
        $tipo=getValueFromPost("tipo");
        if($tipo=="1"){
            $puesto=46;
        }else{
            $puesto=6;
        }
        $lineaNegocio=1;
		
	try{
		$listaEmpleados= $negocio -> ListaReclutadoresByLineaNegocioAndMonth($lineaNegocio, $month,$puesto);
        $elementosReclutados="";
	       
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {   
            $numeroEmpleado = $listaEmpleados[$i] ["numeroEmpleado"];
            $nombreEmpleado = $listaEmpleados[$i] ["nombreEmpleado"];
            
            $elementosReclutados= $negocio -> ListaElementosByReclutador($numeroEmpleado, $month);

            $numeroElementosReclutados=count($elementosReclutados);
            $plantilla=40;
            $numeroElementosActivos=0;
            $numeroElementosInactivos=0;
            $indiceRotacion=0;
            $indiceRotacion1=0;
            $indiceProductividad=0;
            $indiceProductividad1=0;

            for($j=0; $j < $numeroElementosReclutados; $j++){

                $estatusEmpleado=$elementosReclutados[$j]["empleadoEstatusId"];

                if($estatusEmpleado==1){
                    $numeroElementosActivos=$numeroElementosActivos+1;
                }else{
                    $numeroElementosInactivos=$numeroElementosInactivos+1;
                }
            }
            $indiceRotacion=$numeroElementosReclutados-$numeroElementosInactivos;
            $indiceProductividad=$numeroElementosReclutados-$numeroElementosInactivos;
            $listaEmpleados[$i]["numeroElementosReclutados"]=$numeroElementosReclutados; 
            $listaEmpleados[$i]["numeroElementosActivos"]=$numeroElementosActivos; 
            $listaEmpleados[$i]["numeroElementosInactivos"]=$numeroElementosInactivos;

            $aaa ="<font size=1 >$nombreEmpleado</font>";
            $listaEmpleados[$i]["numeroEmpleado1"] =$aaa; 
        }
		$response["data"]= $listaEmpleados;
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
	}
// $log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));
echo json_encode($response);
?>