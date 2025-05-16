<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajax_crearZip.log" , KLogger::DEBUG ); 
// Obtenemos los datos del empleado
$response = array ();
$documento=$_POST['tipo'];
if($documento=='sua'){
  $registro=$_POST['registro'];
  $mes=   $_POST['mes'];
    $anio   =$_POST['anio'];
}else if($documento=='nomina'){
$entidad=$_POST['entidad'];
  $cliente=$_POST['cliente'];
  $mescfdi=$_POST['mesCFDI'];
  $aniocfdi=$_POST['anioCFDI'];
}else{
  $entidad=$_POST['entidad'];
  $cliente=$_POST['cliente'];
}
$response["status"] = "success";
if($documento=='nomina'){ 
    $directorio="C:/wamp/www/zonacgg/Vista/uploads/nomina/".$cliente."_".$mescfdi."_".$aniocfdi."";
    $rutaYnombre = $directorio."/documento.zip";
    if(file_exists($rutaYnombre)) {
        unlink($rutaYnombre);
    }
}else if($documento=='sua'){
    $directorio="C:/wamp/www/zonacgg/Vista/uploads/documentosContabilidad/pagoSua/".$registro.$mes.$anio."";
}else if($documento=='afil'){
    $directorio="C:/wamp/www/zonacgg/Vista/uploads/otrosDocumentos/AFIL06/".$entidad."_".$cliente."";
}else if($documento=='dc3'){
    $directorio="C:/wamp/www/zonacgg/Vista/uploads/otrosDocumentos/DC-3/".$entidad."_".$cliente."";
}
//$log->LogInfo("Valor de la variable zip: " . var_export ($directorio, true));
if(file_exists($directorio)){

//$log->LogInfo("Valor de la variable documentos: " . var_export (in_array($permitidos,$_FILES["docuNomina"]['type']), true));
    try{
        $zip = new ZipArchive();
        $zip->open($directorio."/documento.zip", ZipArchive::CREATE);      
        $options = array('add_path' => 'archivos/','remove_path', 'remove_all_path' => TRUE);
        $zip->addGlob($directorio."/*.pdf", 0, $options); 
        $zip->addGlob($directorio."/*.xml", 0, $options); 
        $zip->addGlob($directorio."/*.zip", 0, $options); 
        $zip->addGlob($directorio."/*.rar", 0, $options); 
        $zip->addGlob($directorio."/*.SUA", 0, $options); 
        $zip->addGlob($directorio."/*.SUA", 0, $options); 
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