<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_consultadocumentosIncapacidad.log" , KLogger::DEBUG );
$fecha1=$_POST["fecha1"];
$fecha2=$_POST["fecha2"]; 
$opcion=$_POST["opcion"];
$usuario=$_SESSION["userLog"];
$datos = array();
$datosFalsos  = array('0' => ".",'1' => "..");
// $datosFalsos  = array('1' => "..");
// $listafoliosincapacidades = array();
try {
	$listafoliosincapacidades   = $negocio->getListaDocumentosIncapacidadByFechaquincena($fecha1,$fecha2,$opcion,$usuario); 
	// $log->LogInfo("Valor de la variable listafoliosincapacidades: " . var_export ($listafoliosincapacidades, true));

	if(count($listafoliosincapacidades)!=0){
		for($i=0;$i<count($listafoliosincapacidades);$i++){
			$folioIncapacidad=$listafoliosincapacidades[$i]["folioIncapacidad"];
			$tipoIncapacidad=$listafoliosincapacidades[$i]["tipoIncapacidad"];
			$entidadempleadoInc=$listafoliosincapacidades[$i]["entidadempleadoInc"];
			$consecutivoempleadoInc=$listafoliosincapacidades[$i]["consecutivoempleadoInc"];
			$categoriaEmpleadoInc=$listafoliosincapacidades[$i]["categoriaEmpleadoInc"];
			$fechaInicioIncapacidad=$listafoliosincapacidades[$i]["fechaInicioIncapacidad"];
			$fechaFInIncapacidad=$listafoliosincapacidades[$i]["fechaFInIncapacidad"];
			$apellidomaterno=$listafoliosincapacidades[$i]["apellidoMaterno"];
			$apellidopaterno=$listafoliosincapacidades[$i]["apellidoPaterno"];
			$nombreempleado=$listafoliosincapacidades[$i]["nombreEmpleado"];
			$diasIncapacidad=$listafoliosincapacidades[$i]["diasIncapacidad"];
			$nombresupervisor=$listafoliosincapacidades[$i]["nombreEmpleadosupervisor"]." ".$listafoliosincapacidades[$i]["apellidoPaternosupervisor"]." ".$listafoliosincapacidades[$i]["apellidoMaternosupervisor"];
			$registroPatronal=$listafoliosincapacidades[$i]["registroPatronal"];

			if($tipoIncapacidad==1){
				$tipoIncapacidad="Enfermedad General";
			}else if($tipoIncapacidad==2){
				$tipoIncapacidad="Riesgo de Trabajo";
			}else if($tipoIncapacidad==3){
				$tipoIncapacidad="Maternidad";
			}

			// $log->LogInfo("Valor de la variable respuesta: " . var_export (scandir("uploads/DocumentosIncapacidad/". $entidadempleadoInc."-". $consecutivoempleadoInc."-". $categoriaEmpleadoInc."/"), true));
			if(file_exists("uploads/DocumentosIncapacidad/". $entidadempleadoInc."-". $consecutivoempleadoInc."-". $categoriaEmpleadoInc."/")) {
				$a_eliminar=  scandir("uploads/DocumentosIncapacidad/". $entidadempleadoInc."-". $consecutivoempleadoInc."-". $categoriaEmpleadoInc."/");
			}else if(!file_exists("uploads/DocumentosIncapacidad/". $entidadempleadoInc."-". $consecutivoempleadoInc."-". $categoriaEmpleadoInc."/")) {
				$a_eliminar = $datosFalsos;
			}
			// $log->LogInfo("Valor de la variable respuesta: " . var_export ($a_eliminar, true));
			$archivoEnfermedadGeneral=$folioIncapacidad."_INC-1_".$fechaInicioIncapacidad."_".$fechaFInIncapacidad;
			$archivoRiesgotrabajo=$folioIncapacidad."_INC-2_".$fechaInicioIncapacidad."_".$fechaFInIncapacidad;
			$archivost7=$folioIncapacidad."_ST7_2_".$fechaInicioIncapacidad."_".$fechaFInIncapacidad;
			$archivost2=$folioIncapacidad."_ST2-2_".$fechaInicioIncapacidad."_".$fechaFInIncapacidad;
			$archivomaternidad=$folioIncapacidad."_INC-3_".$fechaInicioIncapacidad."_".$fechaFInIncapacidad;
			$archivoDictamen=$folioIncapacidad."_DICTAMEN-2_".$fechaInicioIncapacidad."_".$fechaFInIncapacidad;
			$j=0;
			foreach($a_eliminar as $elemento) {
				$path = pathinfo($elemento); // con esto obtengo el nombre del archivo sin extension.
				switch ($path['filename']) {
					case  $archivoEnfermedadGeneral:
					$tipoarchivo="Incapacidad enfermedad general";
					break;
					case  $archivoRiesgotrabajo:
					$tipoarchivo="Incapacidad riesgo de trabajo";
					break;
					case  $archivost7:
					$tipoarchivo="ST-7";
					break;
					case  $archivost2:
					$tipoarchivo="ST-2";
					break;
					case  $archivomaternidad:
					$tipoarchivo="Incapacidad maternidad";
					break;
					case  $archivoDictamen:
					$tipoarchivo="Dictamen ST-7";
					break;
					default: $tipoarchivo="";
				}
					
					
				if($path['filename'] == $archivoEnfermedadGeneral || $path['filename'] == $archivoRiesgotrabajo ||$path['filename'] == $archivost7 ||$path['filename'] == $archivost2 || $path['filename'] == $archivomaternidad || $path['filename'] == $archivoDictamen) {
 				//unlink("uploads/DocumentosIncapacidad/". $incidencia["empleadoEntidad"]."-". $incidencia["empleadoConsecutivo"]."-". $incidencia["empleadoTipo"]."/".$elemento."");
					$basename=$path["basename"];
					$datos[$i][$j]["numeroempleado"]=$entidadempleadoInc."-".$consecutivoempleadoInc."-".$categoriaEmpleadoInc;
					$datos[$i][$j]["nombreempleado"]=$nombreempleado." ".$apellidopaterno." ".$apellidomaterno;
					$datos[$i][$j]["registroPatronal"]=$registroPatronal;
					$datos[$i][$j]["nombresupervisor"]=$nombresupervisor;
					$datos[$i][$j]["folioincapacidad"]=$folioIncapacidad;
					$datos[$i][$j]["tipoIncapacidad"]=$tipoIncapacidad;
					$datos[$i][$j]["diasIncapacidad"]=$diasIncapacidad;
					$datos[$i][$j]["fechaInicioIncapacidad"]=$fechaInicioIncapacidad;
					$datos[$i][$j]["fechaFInIncapacidad"]=$fechaFInIncapacidad; 
					$datos[$i][$j]["tipoarchivo"]=$tipoarchivo;
					$datos[$i][$j]["rutarachivo"]="<img title='Abrir Archivo' src='img/documentosEntregados.png' class='cursorImg' id='btnguardar' onclick=abrirarchivo('".$entidadempleadoInc."-".$consecutivoempleadoInc."-".$categoriaEmpleadoInc."','".$basename."') >";  
					$j++; 
				}
			}
		}
	}else {
	$datos[0][0]["rutarachivo"]="";   
	$datos[0][0]["folioincapacidad"]="";
	$datos[0][0]["fechaInicioIncapacidad"]="";
	$datos[0][0]["fechaFInIncapacidad"]="";
	$datos[0][0]["numeroempleado"]="";
	$datos[0][0]["nombreempleado"]="";
	$datos[0][0]["diasIncapacidad"]="";
	$datos[0][0]["nombresupervisor"]="";
	$datos[0][0]["tipoIncapacidad"]="";
	$datos[0][0]["tipoarchivo"]="";
	$datos[0][0]["registroPatronal"]="";
}

$response["datos"]=$datos;
} catch (Exception $e) {
	$response["status"] = "error";
	$response["error"]  = "No Se Obtuvieron Datos";
}

	//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
	$aa = $response["datos"];
	$bb=array_merge($aa);
	$response["datos"] = $bb;
	//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));


echo json_encode($response);
