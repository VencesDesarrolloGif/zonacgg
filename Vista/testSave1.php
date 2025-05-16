<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

// $log = new KLogger ( "generadorFirma.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();



$entidadEmpleado=$_GET["numeroEmpleado"];
$canvasData=$_GET["canvasData"];

if (empty($entidadEmpleado))

{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar credencial por que no se puede guardar credencial."
    );
    
    echo json_encode ($response);
    
    exit;
}

// $log -> LogInfo ("entidadEmpleado ".var_export ($entidadEmpleado, true));
// $log -> LogInfo ("canvasData ".var_export ($canvasData, true));
        

        $filteredData=substr($canvasData, strpos($canvasData, ",")+1);
        $unencodedData=base64_decode($filteredData);
        $fp = fopen('uploads/firmas/hola.png', 'wb' );
        fwrite( $fp, $unencodedData);
        fclose( $fp );


?>

