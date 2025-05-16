<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_uploadXML.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

$response= array();
$response["status"] = "success";
$anioActual=$_POST["anioActual"];
$mesXML    =$_POST["mesXML"];
$tipoDoc   =$_POST["tipoDoc"];
$permitidos = "application/x-zip-compressed";
$permitidos1= "application/octet-stream";

$correcto=true;
$valor=$_FILES["archivoXML"]['type'][0];

if($valor!=$permitidos && $valor!=$permitidos1){
   $correcto=false;
}

if(!$correcto){
    $response["status"] = "error";
    $response["mensaje"]= "Tipo de arhivo incorrecto";
}else{
    $hoy = getdate();

    foreach($_FILES["archivoXML"]['tmp_name'] as $key => $tmp_name){
        if($_FILES["archivoXML"]["name"][$key]){
            $filename  = $_FILES["archivoXML"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source    = $_FILES["archivoXML"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo   

            if($_FILES["archivoXML"]['type'][0]== $permitidos){
                $extencion = ".zip";
            }else if($_FILES["archivoXML"]['type'][0]== $permitidos1){
                $extencion = ".rar";
            }

            if($tipoDoc==1){
                $directorio= "../uploads/DocumentosXMLIMSS/";
                $nombrearchivo='XML_IMSS'.$mesXML.$anioActual.$extencion;
            } 

            if($tipoDoc==2){
               $directorio= "../uploads/DocumentosXMLINFONAVIT/";
               $nombrearchivo='XML_INFONAVIT'.$mesXML.$anioActual.$extencion;
            }       

            if(!file_exists($directorio)){
               mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }

            
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $target_path = $directorio.'/'.$nombrearchivo; //Indicamos la ruta de destino, así como el nombre del archivo

           if(!move_uploaded_file($source, $target_path)){ 
               $response["status"] = "error";
               $response["mensaje"]= "Error al subir archivos";
           }
           closedir($dir);//Cerramos el directorio de destino
        }
    }
   
    if($tipoDoc==1){
        $sql= "INSERT INTO XML_IMSS(NombreArchivoXMLImss,FechaCargaArchivoXMLImss)
                VALUES('$nombrearchivo',now())";
    } 

    if($tipoDoc==2){
        $sql= "INSERT INTO XML_INFONAVIT(NombreArchivoXMLInfonavit,FechaCargaArchivoXMLInfonavit)
                VALUES('$nombrearchivo',now())";
    }     
        // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
}
if( $response["status"] =='success'){
    $response["mensaje"]='Archivos subidos correctamente';
}
echo json_encode($response);
?> 