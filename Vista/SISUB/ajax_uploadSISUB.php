<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_uploadSISUB.log" , KLogger::DEBUG );
$response= array();
$cuatrimestre=$_POST["cuatrimestre"];
$valorAct    =$_POST["valorAct"];
$anio    =$_POST["anio"];
$response["status"] = "success";
$permitidos="application/pdf";
$correcto=true;
$valor=$_FILES["archivoSISUB"]['type'][0];
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

if($valor!=$permitidos){
   $correcto=false;
}

if(!$correcto){
    $response["status"] = "error";
    $response["message"]= "Tipo de arhivo incorrecto";
}else{
    $hoy = getdate();

    foreach($_FILES["archivoSISUB"]['tmp_name'] as $key => $tmp_name){
         if($_FILES["archivoSISUB"]["name"][$key]){
            $filename  = $_FILES["archivoSISUB"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source    = $_FILES["archivoSISUB"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio= "../uploads/DocumentosSISUB/"; //Declaramos un  variable con la ruta donde guardaremos los archivos

            if(!file_exists($directorio)){
               mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino

            $sql = "SELECT ifnull(max(idArchivoSISUB),0) as idSISUB FROM documentos_SISUB";      
            
            $res = mysqli_query($conexion, $sql);
            while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
                $datos[] = $reg;
            }

            $idarchivo=$datos[0]["idSISUB"]+1;
            $nombrearchivo='SISUB_'.$cuatrimestre.$anio.'_'.$idarchivo;
          
            $target_path = $directorio.'/'.$nombrearchivo.".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo

           if(!move_uploaded_file($source, $target_path)){ 
               $response["status"] = "error";
               $response["message"]= "Error al subir archivos";
           }
           closedir($dir);//Cerramos el directorio de destino
        }
    }
   
    $sql1= "INSERT INTO documentos_SISUB (NombreArchivoSISUB,FechaCargaArchivoSISUB)
           VALUES('$nombrearchivo',now())";      
        
    $res = mysqli_query($conexion, $sql1);
}

if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}

echo json_encode($response);
?> 