<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_consultaAchivosBajaEmpleados.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable usuario: " . var_export ($usuario, true));
try {
	$listaArchivosBajaEmpleados   = $negocio->getListaArchivosBajasEmp();
		for($i=0;$i<count($listaArchivosBajaEmpleados);$i++){
			$FechaAcpetacion=$listaArchivosBajaEmpleados[$i]["FechaAcpetacion"];
			$fechaSolicitud=$listaArchivosBajaEmpleados[$i]["fechaSolicitud"];
			$NumeroEmpleado=$listaArchivosBajaEmpleados[$i]["NumeroEmpleado"];
			$NombreArchivoBaja=$listaArchivosBajaEmpleados[$i]["NombreArchivoBaja"];
			$ModuloBaja=$listaArchivosBajaEmpleados[$i]["ModuloBaja"]; 
			$rolUsuario=$listaArchivosBajaEmpleados[$i]["rolUsuario"];
			$NombreArchivoBaja=$listaArchivosBajaEmpleados[$i]["NombreArchivoBaja"];
			$rolconvertido = strtr($rolUsuario, " ", "-");
			 
			if(($FechaAcpetacion=="" || $FechaAcpetacion== null || $FechaAcpetacion=="null" || $FechaAcpetacion==NULL || $FechaAcpetacion=="NULL") && $ModuloBaja!="RH"){
				$listaArchivosBajaEmpleados[$i]["EstatusArchivoBaja"]="<span style = 'color:red'>En Espera De Aceptación</span>";
			}else if(($FechaAcpetacion=="" || $FechaAcpetacion== null || $FechaAcpetacion=="null" || $FechaAcpetacion==NULL || $FechaAcpetacion=="NULL") && $ModuloBaja=="RH"){
				$listaArchivosBajaEmpleados[$i]["EstatusArchivoBaja"]="<span style = 'color:blue'>Baja Procesada Desde RH</span>";
			}else{
				$listaArchivosBajaEmpleados[$i]["EstatusArchivoBaja"]="<span style = 'color:blue'>Baja Aceptada</span>";
			}
			$listaArchivosBajaEmpleados[$i]["rutarachivo"]="<img title='Abrir Archivo' src='img/documentosEntregados.png' class='cursorImg' id='btnguardar' onclick=abrirarchivoRegistroBaja('".$NumeroEmpleado."','".$rolconvertido."','".$NombreArchivoBaja."','".$fechaSolicitud."') >";

			} 
//	$log->LogInfo("Valor de la variable listaArchivosBajaEmpleados: " . var_export ($listaArchivosBajaEmpleados, true));
	$response["datos"]=$listaArchivosBajaEmpleados;
} catch (Exception $e) {
	$response["status"] = "error";
	$response["error"]  = "No Se Obtuvieron Datos";
}
echo json_encode($response);
?>
