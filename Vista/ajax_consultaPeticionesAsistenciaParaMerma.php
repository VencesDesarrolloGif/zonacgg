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
$fechaInicioPeriodo= $_POST["fechaInicioPeriodo"];
$fechaTerminoPeriodo= $_POST["fechaTerminoPeriodo"];
$caso= $_POST["caso"];
//$log = new KLogger ( "ajax_consultaPeticionesAsistenciaParaMerma.log" , KLogger::DEBUG );
try {
    $datos = $negocio -> obtenerListaPeticionesAsistenciaParaMErma($fechaInicioPeriodo,$fechaTerminoPeriodo,$caso);
    for($i=0; $i<count($datos);$i++){
    	$tipoIncidenciaPeticionM = $datos[$i]["tipoIncidenciaPeticionM"];
        $Incidencia = $datos[$i]["Incidencia"];
    	$IncidenciaE = $datos[$i]["IncidenciaE"];
        if($tipoIncidenciaPeticionM == "Incidencia_Especial"){
             $datos[$i]["IncidenciaFinal"] = $IncidenciaE;
        }else{
             $datos[$i]["IncidenciaFinal"] = $Incidencia ;
        }
    	$EmpEntidadM = $datos[$i]["EmpEntidadM"];
		$EmpConsecutivoM = $datos[$i]["EmpConsecutivoM"];
		$EmpCategoriaM = $datos[$i]["EmpCategoriaM"];
		$idPuntoServicioM = $datos[$i]["idPuntoServicioM"];
		$SupEntidadM = $datos[$i]["SupEntidadM"];
		$SupConsecutivoM = $datos[$i]["SupConsecutivoM"];
		$SupCategoriaM = $datos[$i]["SupCategoriaM"];
		$idIncidenciaM = $datos[$i]["idIncidenciaM"];
		$FechaDelRegistro = $datos[$i]["FechaDelRegistro"];
		$tipoPeriodo = $datos[$i]["tipoPeriodo"];
		$IdTipoPuestoM = $datos[$i]["IdTipoPuestoM"];
		$idCLienteM = $datos[$i]["idCLienteM"];
    	$TipoTurno1 = $datos[$i]["TipoTurno"]; 
		$idPlantillaServicioM = $datos[$i]["idPlantillaServicioM"];
		$idLineaNegocioM = $datos[$i]["idLineaNegocioM"];
		$Comentario1 = $datos[$i]["Comentario"];
		$tipoIncidenciaPeticionM = $datos[$i]["tipoIncidenciaPeticionM"];
		$idPlantillaEmp = $datos[$i]["idPlantillaEmp"];
		$Comentario22= trim($Comentario1);
		$Comentario23= preg_replace("/[\r\n]+/", "\n", $Comentario22);
		$Comentario2= preg_replace("/\s+/", ' ', $Comentario23);
		$Comentario = str_replace(" 	", "$", $Comentario2);
		$resultado = str_replace(" ", "$", $Comentario);
		$idPlantillaServicioM1 = str_replace(" ", "$", $idPlantillaServicioM);
    	if($TipoTurno1=="0"){
    		$datos[$i]["TipoTurno1"] = "Turno Dia-Noche(24X24)";
    	}else if ($TipoTurno1=="1"){
    		$datos[$i]["TipoTurno1"] = "Turno Dia(12X12)";
    	}else{
    		$datos[$i]["TipoTurno1"] = "Turno Noche(12X12)";
    	}
    	$datos[$i]["Aceptar"] = "<img style='width: 40%' title='Se Registrara La Asistencia Solicitada' src='img/confirmarImss.png' class='cursorImg' onclick=ConfirmarPeticion('$EmpEntidadM','$EmpConsecutivoM','$EmpCategoriaM','$idPuntoServicioM','$SupEntidadM','$SupConsecutivoM','$SupCategoriaM','$idIncidenciaM','$FechaDelRegistro','$resultado','$tipoPeriodo','$IdTipoPuestoM','$idCLienteM','$TipoTurno1','$idPlantillaServicioM1','$idLineaNegocioM','$tipoIncidenciaPeticionM','$idPlantillaEmp')>";
    	$datos[$i]["Declinar"] = "<img style='width: 40%' title='Se Cancelara La Peticion Solicitada' src='img/cancelar.png' class='cursorImg' onclick=DeclinarPeticion('$EmpEntidadM','$EmpConsecutivoM','$EmpCategoriaM','$idPuntoServicioM','$idIncidenciaM','$FechaDelRegistro',0)>";
    }
    $response["status"] = "success";
    $response["datos"]  = $datos;
 //   $response["datos1"]  = $datos1;
    } catch (Exception $e) {
       $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
