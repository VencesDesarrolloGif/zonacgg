<?php
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
// $log = new KLogger ( "save.log" , KLogger::DEBUG );

if (isset($GLOBALS["HTTP_RAW_POST_DATA"])) {

  $imageData=$GLOBALS['HTTP_RAW_POST_DATA'];
  //$numeroEmpleado=$GLOBALS['HTTP_RAW_POST_DATA'];

  // $log -> LogInfo ("imageData ".var_export ($imageData, true));

  $filteredData=substr($imageData, strpos($imageData, ",")+1);



  // $log -> LogInfo ("filteredData ".var_export ($filteredData, true));

  $unencodedData=base64_decode($filteredData);
  // $log -> LogInfo ("unencodedData ".var_export ($unencodedData, true));

  $fp = fopen('uploads/firmas/file.png', 'wb' );
  fwrite( $fp, $unencodedData);
  fclose( $fp );

}
?>