<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_consultadocumentosVacaciones.log" , KLogger::DEBUG );
$fecha1=$_POST["fecha1"];
$fecha2=$_POST["fecha2"];
$fechaInicioasistencia=$_POST["fechaInicioasistencia"];
$usuario=$_SESSION["userLog"];
try {
	$listafoliosVacaciones   = $negocio->getListaDocumentosVacaciones($fecha1,$fecha2);

		for($i=0;$i<count($listafoliosVacaciones);$i++){
			$EntidadEmpleado=$listafoliosVacaciones[$i]["EntidadEmpleado"];
			$ConsecutivoEmpleado=$listafoliosVacaciones[$i]["ConsecutivoEmpleado"];
			$CategoriaEmpleado=$listafoliosVacaciones[$i]["CategoriaEmpleado"];
			$NombreArchivo = $listafoliosVacaciones[$i]["NombreArchivo"];
			$folioVacaciones = $listafoliosVacaciones[$i]["folioVacaciones"];
			$fechaInicioVacaciones = $listafoliosVacaciones[$i]["fechaInicioVacaciones"];
			$opcion1 = "1";
			$opcion2 = "2";
			$listafoliosVacaciones[$i]["NumeroEmpleado"] = $EntidadEmpleado . "-" . $ConsecutivoEmpleado . "-" . $CategoriaEmpleado; 	
			$listafoliosVacaciones[$i]["rutarachivo"]="<img title='Abrir Archivo' src='img/documentosEntregados.png' class='cursorImg' id='btnguardar' onclick=abrirarchivoVacaciones('".$EntidadEmpleado."-".$ConsecutivoEmpleado."-".$CategoriaEmpleado."','".$NombreArchivo."') >"; 
			if($fechaInicioVacaciones<$fechaInicioasistencia){
				$listafoliosVacaciones[$i]["Aceptar"]="Acción No Permitida";   
				$listafoliosVacaciones[$i]["Declinar"]="Acción No Permitida";   
			}else{
				$listafoliosVacaciones[$i]["Aceptar"]="<img title='Aceptar Petición' src='img/confirmarImss.png' class='cursorImg' id='btnguardarAceptar' onclick=ActualizarDeclinarFolioVacaciones('".$fechaInicioVacaciones."','".$folioVacaciones."','".$EntidadEmpleado."','".$ConsecutivoEmpleado."','".$CategoriaEmpleado."','".$opcion1."') >";   
				$listafoliosVacaciones[$i]["Declinar"]="<img title='Declinar Petición' src='img/rechazarImss.png' class='cursorImg' id='btnguardarDeclinar' onclick=ActualizarDeclinarFolioVacaciones('".$fechaInicioVacaciones."','".$folioVacaciones."','".$EntidadEmpleado."','".$ConsecutivoEmpleado."','".$CategoriaEmpleado."','".$opcion2."') >";   
			}
		}
//$log->LogInfo("Valor de la variable listafoliosVacaciones: " . var_export ($listafoliosVacaciones, true));

$response["datos"]=$listafoliosVacaciones;
} catch (Exception $e) {
	$response["status"] = "error";
	$response["error"]  = "No Se Obtuvieron Datos";
}
echo json_encode($response);
