<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_uploadICSOE.log" , KLogger::DEBUG );
$response= array();
$anioElegido =$_POST["anioICSOE"];
$cuatrimestre=$_POST["cuatrimestre"];
$valorAct    =$_POST["valorAct"];
$response["status"] = "success";
$permitidos="application/pdf";
$correcto=true;
$valor=$_FILES["archivoICSOE"]['type'][0];
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

if($valor!=$permitidos){
   $correcto=false;
}

if(!$correcto){
    $response["status"] = "error";
    $response["message"]= "Tipo de arhivo incorrecto";
}else{
    $hoy = getdate();

    foreach($_FILES["archivoICSOE"]['tmp_name'] as $key => $tmp_name){
         if($_FILES["archivoICSOE"]["name"][$key]){
            $filename  = $_FILES["archivoICSOE"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source    = $_FILES["archivoICSOE"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio= "../uploads/DocumentosICSOE/"; //Declaramos un  variable con la ruta donde guardaremos los archivos

            if(!file_exists($directorio)){
               mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino

            $sql = "SELECT ifnull(max(idArchivoICSOE),0) as idICSOE FROM documentos_ICSOE";      
            
            $res = mysqli_query($conexion, $sql);
            while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
                $datos[] = $reg;
            }

            $idarchivo=$datos[0]["idICSOE"]+1;
            $nombrearchivo='ICSOE_'.$cuatrimestre.$anioElegido.'_'.$idarchivo;
          
            $target_path = $directorio.'/'.$nombrearchivo.".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo

           if(!move_uploaded_file($source, $target_path)){ 
               $response["status"] = "error";
               $response["message"]= "Error al subir archivos";
           }
           closedir($dir);//Cerramos el directorio de destino
        }
    }
   
    $sql1= "INSERT INTO documentos_ICSOE (NombreArchivoICSOE,FechaCargaArchivoICSOE)
           VALUES('$nombrearchivo',now())";      
        
    $res = mysqli_query($conexion, $sql1);
}

if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}

echo json_encode($response);
?> 