<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajax_crearZip.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$response= array ();
$registro=$_POST['registro'];
$mes     =$_POST['mes'];
$anio    =$_POST['anio'];

$response["status"] = "success";
$directorio="C:/wamp/www/zonacgg/Vista/uploads/DocumentosOpinionCumplimiento/Infonavit/".$registro.$mes.$anio."";
if(file_exists($directorio)){
    try{
        $zip = new ZipArchive();
        $zip->open($directorio."/documento.zip", ZipArchive::CREATE);      
        $options = array('add_path' => 'archivos/','remove_path', 'remove_all_path' => TRUE);
        $zip->addGlob($directorio."/*.pdf", 0, $options); 
        //$log->LogInfo("Valor de la variable zip: " . var_export ($zip, true));   
        $zip->close();
    }catch(Exception $e){
        $response["status"] = "error";
        $response["message"] = $e.getMessage();
    }
}else{
    $response["status"] = "error";
    $response["message"] = "No hay archivos para descargar";
}

//$log->LogInfo("Valor de la variable zip: " . var_export ($zip, true));

echo json_encode($response);

?> 