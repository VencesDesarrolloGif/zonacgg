<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajaxinsertRepse.log" , KLogger::DEBUG );
$noAcuerdo= getValueFromPost ("noAcuerdo");
$noFolioIn= getValueFromPost ("noFolioIn");

//$log->LogInfo("Valor de la variable file: " . var_export ($_FILES, true));
//$log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));

$anioActual = date('Y');
$mesActual  = date('m');

$permitidospdf = "application/pdf";
$permitidosjpeg= "image/jpeg";
$permitidospng = "application/png";
$permitidospng1= "image/png";
$permitidosjpg = "application/jpg";
$correcto=true;

$num=count($_FILES["documentoCargadoAgregar"]['type']);

for($a=0;$a<$num;$a++){
    $valor=$_FILES["documentoCargadoAgregar"]['type'][$a];
    
    if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
       $correcto=false;
       break;
    }
}//termina for

if(!$correcto){
   $response["status"]  = "error";
   $response ["message"]= "Tipos De Arhivo Incorrecto O Limite Excedido Revise El Documento Nuevamente";
}else{
      $idRepse = $negocio->obtenerUltimorepse();
      $idActual= $idRepse[0]["idRepse"];
      $idNuevo = $idActual + '1';

      $extencionArchivo= explode("/", $_FILES["documentoCargadoAgregar"]['type'][0]);    
      $extencionArchivooriginal=$extencionArchivo[1];

    foreach($_FILES["documentoCargadoAgregar"]['tmp_name'] as $key => $tmp_name){
            
        if($_FILES["documentoCargadoAgregar"]["name"][$key]) {//Validamos que el archivo exista
           $filename= $_FILES["documentoCargadoAgregar"]["name"][$key]; //Obtenemos el nombre original del archivo
           $source  = $_FILES["documentoCargadoAgregar"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
           $directorio='uploads/documentosREPSE/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
               mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $target_path=$directorio.'/'."Repse_".$idNuevo."_".$anioActual."_".$mesActual.".".$extencionArchivooriginal; //Indicamos la ruta de destino, así como el nombre del archivo
            $nombreDocumento ="Repse_".$idNuevo."_".$anioActual."_".$mesActual.".".$extencionArchivooriginal;

             //Movemos y validamos que el archivo se haya cargado correctamente
             //El primer campo es el origen y el segundo el destino
            if(!move_uploaded_file($source, $target_path)){ 
               $response["status"]  = "error";
               $response ["message"]= "Error al subir archivo REPSE";
            }
            closedir($dir); //Cerramos el directorio de destino
        }
    }//termina foreach
    $repse = $negocio->insertRepse($noAcuerdo,$noFolioIn,$nombreDocumento);
    $response ["message"] = "Archivo Subido Correctamente";
}//termina else
   
echo json_encode($response);
?> 

