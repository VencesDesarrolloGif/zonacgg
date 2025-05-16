<?php
/**
* @file     download_file.php
* @author   Daniel Martínez <dazenbit@gmail.com>
*
* Este archivo proporciona la funcionalidad para descargar un archivo de los documentos digitalizados
*/
session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

// $log = new KLogger ( "ajax_downloadDocuC.log" , KLogger::DEBUG );

//$log->LogInfo("Valor de la variable id: " . var_export ($id, true));

$documento=$_GET["documento"];



$direccion="C:/wamp/www/zonacgg/Vista/uploads/otrosDocumentos/".$documento.".pdf";


if(strpos($documento, 'cfdiNom')!== false){
	$cads = explode("-", $documento);
	$entidad=substr($cads[0], -2);
	$cliente=$cads[1];
	$nombre= md5($entidad."_".$cliente);
	//$log->LogInfo("Valor de la variable bajas \$cliente: " . var_export ($cliente, true));
	$direccion="C:/wamp/www/zonacgg/Vista/uploads/nomina/".$nombre.".pdf";	
}



if(!file_exists($direccion)){
	echo "<script>alert('Archivo no encontrado');location.href ='/zonacgg/Vista/usuarioLogeado.php'</script>";
	exit;
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$fileinfo = finfo_file($finfo, $direccion);
finfo_close($finfo);      

$size   = filesize($direccion);
header('Content-Description: File Transfer');
header('Content-Type: ' . $fileinfo);
header('Content-Disposition: attachment; filename=documento.pdf'); 
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
readfile($direccion);