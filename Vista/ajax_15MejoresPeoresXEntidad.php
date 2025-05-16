<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajaxObtenerReclutadores.log" , KLogger::DEBUG );
		$month=getValueFromPost("month");
        $tipo=getValueFromPost("tipo");
        $selectEntidad=getValueFromPost("selectEntidad");

        if($tipo=="1"){
            $puesto=46;
        }else{
            $puesto=6;
        }
        $lineaNegocio=1;
		
	try{
        $listaEmpleados= $negocio -> ObtenerReclutadoresMP($lineaNegocio, $month,$puesto, $selectEntidad);
		//$listaEmpleados= $negocio -> ObtenerNombreReclutador($lineaNegocio, $month,$puesto, $selectEntidad);
        $elementosReclutados="";
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {   //$numeroEmpleadoNOM = $listaEmpleados[$i] ["numeroEmpleadoNombre"];
            $numeroEmpleado = $listaEmpleados[$i] ["NumeroReclutador"];
           //$nombreEmpleado = $listaEmpleados[$i] ["nombreEmpleado"];
           //$fechaIngresoEmpleado = $listaEmpleados[$i] ["fechaIngresoEmpleado"];
            $elementosReclutados= $negocio -> ObtenerElementos15MP($numeroEmpleado, $month);
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

            if($indiceRotacion==0){

                $indiceRotacion1=0;
            }else{
                $indiceRotacion1=(intval($indiceRotacion)/intval(count($elementosReclutados)))*100;
            }
            if($indiceProductividad==0){            
                $indiceProductividad1=0;
            }else{

                $indiceProductividad1=(intval($indiceProductividad)/$plantilla)*100;
            }
            $listaEmpleados[$i]["numeroElementosReclutados"]=$numeroElementosReclutados; 
            $listaEmpleados[$i]["numeroElementosActivos"]=$numeroElementosActivos; 
            $listaEmpleados[$i]["numeroElementosInactivos"]=$numeroElementosInactivos; 
            $listaEmpleados[$i]["indiceRotacion"]=$indiceRotacion1."%"; 
            $listaEmpleados[$i]["indiceProductividad"]=$indiceProductividad1."%"; 
        }       
		// $log->LogInfo("Valor de la variable listaEmpleados punto: " . var_export ($listaEmpleados, true));
		$response["data"]= $listaEmpleados;
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener Empleados";
	}
echo json_encode($response);
?>