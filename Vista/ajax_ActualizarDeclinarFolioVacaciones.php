<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_ActualizarDeclinarFolioVacaciones.log" , KLogger::DEBUG );

$folioVacaciones=$_POST["Folio"];
$EntidadUsuario=$_POST["EntidadUsuario"];
$ConsecutivoUsuario=$_POST["ConsecutivoUsuario"];
$CartegoriaUsuario=$_POST["CartegoriaUsuario"];
$Opcion=$_POST["Opcion"];
$fechaInicioVacaciones=$_POST["fechaInicioVacaciones"];
$usuario = $_SESSION ["userLog"]["usuario"];

$incidencia["empleadoEntidad"] = $EntidadUsuario;
$incidencia["empleadoConsecutivo"] = $ConsecutivoUsuario;
$incidencia["empleadoTipo"] = $CartegoriaUsuario;
$incidencia["fechaAsistencia"] = $fechaInicioVacaciones;
$incidencia["Folio"] = $folioVacaciones;
		

try {
	if($Opcion=="1"){
		$ActualizaFolioVcaciones = $negocio -> ActualizarFolioVacaciones($incidencia);

	}else{

		$InsertarTablaDeclindado = $negocio -> InsertarFolioVacacionesDeclinadas($incidencia);

        $BorrarAsistenciaByFolio = $negocio -> deleteIncidenciaVacacionesByFolio($incidencia, $folioVacaciones);
    // $log->LogInfo("Valor de EstatusEmpleadoGeo  " . var_export ($EstatusEmpleadoGeo, true));
        

	}
	

//$response["datos"]=$listafoliosVacaciones;
} catch (Exception $e) {
	$response["status"] = "error";
	$response["error"]  = "No Se Obtuvieron Datos";
}
echo json_encode($response);
