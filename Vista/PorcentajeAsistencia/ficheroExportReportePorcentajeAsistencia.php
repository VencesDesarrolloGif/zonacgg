<?php
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ( "descargaFicheroExcel.log" , KLogger::DEBUG );
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=ReportePorcentajeAsistencia.xls");
header("Pragma: no-cache");
header("Expires: 0");

$datosPost=$_POST['datos_TablaHiddenPorcentajeAsis'];

//$log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable datosPost: " . var_export ($datosPost, true));
echo utf8_decode($datosPost);
?>