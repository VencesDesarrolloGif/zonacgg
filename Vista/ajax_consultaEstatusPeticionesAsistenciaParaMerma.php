<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaEstutuspeticionParaMerma.log" , KLogger::DEBUG );
$usuario = $_SESSION ["userLog"];
$CasoBusqueda = $_POST["CasoBusqueda"];
$fechaMermaInicio = $_POST["fechaMermaInicio"];
$fechaMermaFin = $_POST["fechaMermaFin"];

//$log->LogInfo("Valor de usuario" . var_export ($usuario, true));

try {
    $datos = $negocio -> obtenerListaEstatusPeticionesAsistenciaParaMErma($usuario,$CasoBusqueda,$fechaMermaInicio,$fechaMermaFin);
    for($i=0; $i<count($datos);$i++){
    	$EstatusP = $datos[$i]["EstatusP"];
        $TipoTurno1 = $datos[$i]["TipoTurno"];
        $tipoIncidenciaPeticionM = $datos[$i]["tipoIncidenciaPeticionM"];
        $Incidencia = $datos[$i]["Incidencia"];
    	$IncidenciaE = $datos[$i]["IncidenciaE"];
        if($tipoIncidenciaPeticionM == "Incidencia_Especial"){
             $datos[$i]["IncidenciaFinal"] = $IncidenciaE;
        }else{
             $datos[$i]["IncidenciaFinal"] = $Incidencia; 
        }
		if($EstatusP == "1"){
			$datos[$i]["EstatusPeticion"] = "<font color='blue'>En Espera</font>";
			$datos[$i]["ComentarioDecline"] = "Esperando...";
		}else if($EstatusP == "2"){
			$datos[$i]["EstatusPeticion"] = "<font color='green'>Aceptada</font>";
			$datos[$i]["ComentarioDecline"] = "Solicitud Registrada En Asistencia";
		}else if($EstatusP == "3"){
			$datos[$i]["EstatusPeticion"] = "<font color='red'>Declinada Por Analista</font>";
		}else if($EstatusP == "4"){
			$datos[$i]["EstatusPeticion"] = "<font color='red'>Declinada Por Supervisor</font>";
		}else if($EstatusP == "5"){
            $datos[$i]["EstatusPeticion"] = "<font color='red'>Declinada Por Supervisor</font>";
        }

		if($TipoTurno1=="0"){
    		$datos[$i]["TipoTurno1"] = "Turno Dia-Noche(24X24)";
    	}else if ($TipoTurno1=="1"){
    		$datos[$i]["TipoTurno1"] = "Turno Dia(12X12)";
    	}else{
    		$datos[$i]["TipoTurno1"] = "Turno Noche(12X12)";
    	}
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
 //   $response["datos1"]  = $datos1;
    } catch (Exception $e) {
       $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
