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
	
		//$log = new KLogger ( "ajaxObtenerReclutadores.log" , KLogger::DEBUG );
		$month=getValueFromPost("month");
        $tipo=getValueFromPost("tipo");
        $usuario= $_SESSION ["userLog"];
        if($tipo=="1"){
            $puesto=46;
        }else{
            $puesto=6;
        }
        //$lineaNegocio=1;
		
	try{
		

		$listaEmpleados= $negocio -> getReclutadoresByLineaNegocioAndMonth($usuario, $month,$puesto);
        $elementosReclutados="";
	       
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {   
            $numeroEmpleado = $listaEmpleados[$i] ["numeroEmpleado"];
            $nombreEmpleado = $listaEmpleados[$i] ["nombreEmpleado"];
            $fechaIngresoEmpleado = $listaEmpleados[$i] ["fechaIngresoEmpleado"];
            $elementosReclutados= $negocio -> getElementosByReclutador($numeroEmpleado, $month);

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

            //$log->LogInfo("Valor de la variable \$numeroEmpleado:" . var_export ($numeroEmpleado, true));
            //$log->LogInfo("Valor de la variable \$numeroElementosReclutados:" . var_export ($numeroElementosReclutados, true));
            //$log->LogInfo("Valor de la variable \$numeroElementosActivos:" . var_export ($numeroElementosActivos, true));
            //$log->LogInfo("Valor de la variable \$numeroElementosInactivos:" . var_export ($numeroElementosInactivos, true));


            $indiceRotacion=$numeroElementosReclutados-$numeroElementosInactivos;
            $indiceProductividad=$numeroElementosReclutados-$numeroElementosInactivos;
            //$log->LogInfo("Valor de la variable \$indiceProductividad:" . var_export ($indiceProductividad, true));

            if($indiceRotacion==0){
                $indiceRotacion1=0;
            }else{
                $indiceRotacion1=round((intval($indiceRotacion)/intval(count($elementosReclutados)))*100);

            }

            if($indiceProductividad==0){
                
                $indiceProductividad1=0;

            }else{

                $indiceProductividad1=(intval($indiceProductividad)/$plantilla)*100;
                //$log->LogInfo("Valor de la variable \$indiceProductividad1:" . var_export ($indiceProductividad1, true));

            }

            $listaEmpleados[$i]["numeroElementosReclutados"]=$numeroElementosReclutados; 
            $listaEmpleados[$i]["numeroElementosActivos"]=$numeroElementosActivos; 
            $listaEmpleados[$i]["numeroElementosInactivos"]=$numeroElementosInactivos; 
            $listaEmpleados[$i]["indiceRotacion"]=$indiceRotacion1."%"; 
            $listaEmpleados[$i]["indiceProductividad"]=$indiceProductividad1."%"; 

            //$log->LogInfo("Valor de la variable \$elementosReclutados:" . var_export ($elementosReclutados, true));

        }
        
		$response["data"]= $listaEmpleados;

		//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
	}
/*
}
*/
//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));

echo json_encode($response);

?>