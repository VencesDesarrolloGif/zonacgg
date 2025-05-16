<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_consultaReporteVacaciones.log" , KLogger::DEBUG );
$usuario=$_SESSION["userLog"];
//$log->LogInfo("Valor de la variable usuario: " . var_export ($usuario, true));
try {
	$listaReporteVacaciones   = $negocio->getListaReporteVacaciones($usuario);  
		for($i=0;$i<count($listaReporteVacaciones);$i++){
			$nombreEmpleado=$listaReporteVacaciones[$i]["nombreEmpleado"];
			$apellidoPaterno=$listaReporteVacaciones[$i]["apellidoPaterno"];
			$apellidoMaterno=$listaReporteVacaciones[$i]["apellidoMaterno"];
			$EntidadEmpleado=$listaReporteVacaciones[$i]["empleadoEntidad"];
			$ConsecutivoEmpleado=$listaReporteVacaciones[$i]["empleadoConsecutivo"];  
			$CategoriaEmpleado=$listaReporteVacaciones[$i]["empleadoTipo"];
			$NombreArchivo = $listaReporteVacaciones[$i]["NombreArchivo"];
			$StatusFolio = $listaReporteVacaciones[$i]["StatusFolio"];
			$folioVacaciones = $listaReporteVacaciones[$i]["folioVacaciones"];
			$TipoVacaciones = $listaReporteVacaciones[$i]["TipoVacaciones"];
			$TipoVacaciones1 = $listaReporteVacaciones[$i]["TipoVacaciones1"];
			$Aniversario = $listaReporteVacaciones[$i]["Aniversario"];
			$VacacionesTomadas = $listaReporteVacaciones[$i]["VacacionesTomadas"];
			$fechaAsistencia = $listaReporteVacaciones[$i]["fechaAsistencia"];
			$usuarioCapturaAsistencia = $listaReporteVacaciones[$i]["usuarioCapturaAsistencia"];
			$listaReporteVacaciones[$i]["NumeroEmpleado"] = $EntidadEmpleado . "-" . $ConsecutivoEmpleado . "-" . $CategoriaEmpleado;
			$listaReporteVacaciones[$i]["NombreEmpleado"] = $nombreEmpleado . " " . $apellidoPaterno . " " . $apellidoMaterno;
			if($folioVacaciones =="" || $folioVacaciones =="null" || $folioVacaciones ==null || $folioVacaciones =="NULL"){
				$listaReporteVacaciones[$i]["folioVacaciones"] = "Sin Folio Registrado";
				if($TipoVacaciones1 =="5"){
					$listaReporteVacaciones[$i]["TipoVacaciones"] = "V/P";
				}else if($TipoVacaciones1 =="6"){
					$listaReporteVacaciones[$i]["TipoVacaciones"] = "V/D";
				}else if($TipoVacaciones1 =="12"){
					$listaReporteVacaciones[$i]["TipoVacaciones"] = "V/P2";
				}else{
					$listaReporteVacaciones[$i]["TipoVacaciones"] = "V/D2";
				}
				if($Aniversario =="" || $Aniversario =="null" || $Aniversario ==null || $Aniversario =="NULL"){
					$Aniversario="SinConteo";
				}
				$listaReporteVacaciones[$i]["PeriodoVacaciones"] = "Aniversario".$Aniversario;
				$listaReporteVacaciones[$i]["diasVacaciones"] = $VacacionesTomadas;
				$listaReporteVacaciones[$i]["fechaInicioVacaciones"] = $fechaAsistencia;
				$listaReporteVacaciones[$i]["NumbreUsuario"] = $usuarioCapturaAsistencia;
				$listaReporteVacaciones[$i]["fechaInsertVacaciones"] = $fechaAsistencia;
				$listaReporteVacaciones[$i]["Descripcion"] = "Sin Petición Registrada";
				$listaReporteVacaciones[$i]["rutarachivo"]="Sin Archivo Registrado";
			}else{
				$explodeNombreArchivo = explode(" ", $NombreArchivo);
				$largoNombre = count($explodeNombreArchivo);
				if($largoNombre!="1"){
					$nombre1 = $explodeNombreArchivo[0];
					$nombre2 = $explodeNombreArchivo[1];
				}
				$caso1="1";
				$caso2="2";
				if($StatusFolio==="3"){
					$listaReporteVacaciones[$i]["rutarachivo"]="El Archivo Fue Eliminado";
				}else{
					if($largoNombre=="1"){
						$listaReporteVacaciones[$i]["rutarachivo"]="<img title='Abrir Archivo' src='img/documentosEntregados.png' class='cursorImg' id='btnguardar' onclick=abrirarchivoReporteVacaciones('".$EntidadEmpleado."-".$ConsecutivoEmpleado."-".$CategoriaEmpleado."','".$NombreArchivo."','".$caso1."','".$caso1."') >";
					}else{
						$listaReporteVacaciones[$i]["rutarachivo"]="<img title='Abrir Archivo' src='img/documentosEntregados.png' class='cursorImg' id='btnguardar' onclick=abrirarchivoReporteVacaciones('".$EntidadEmpleado."-".$ConsecutivoEmpleado."-".$CategoriaEmpleado."','".$nombre1."','".$nombre2."','".$caso2."') >";
					}
				} 
			}
		}
$response["datos"]=$listaReporteVacaciones;
} catch (Exception $e) {
	$response["status"] = "error";
	$response["error"]  = "No Se Obtuvieron Datos";
}
echo json_encode($response);
