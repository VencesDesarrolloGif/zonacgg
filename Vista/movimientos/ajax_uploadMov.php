<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_uploadMov.log" , KLogger::DEBUG );
$response= array();
$mes=$_POST["mes"];
// $valorAct    =$_POST["valorAct"];
$anio    =$_POST["anio"];
$response["status"] = "success";
$correcto=true;
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
// $log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));
// $valor=$_FILES["archivoMov"]['type'][0];

/*
$permitidos="application/pdf";
if($valor!=$permitidos){
   $correcto=false;
}
if(!$correcto){
    $response["status"] = "error";
    $response["message"]= "Tipo de arhivo incorrecto";
}else{*/
    $hoy = getdate();

    foreach($_FILES["archivoMov"]['tmp_name'] as $key => $tmp_name){
         if($_FILES["archivoMov"]["name"][$key]){
            $filename  = $_FILES["archivoMov"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source    = $_FILES["archivoMov"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio= "../uploads/movimientos/"; //Declaramos un  variable con la ruta donde guardaremos los archivos

            if(!file_exists($directorio)){
               mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino

            $sql = "SELECT ifnull(max(idarchivoMov),0) as idMov 
                    FROM documentos_movimientos";      
            
            $res = mysqli_query($conexion, $sql);
            while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
                $datos[] = $reg;
            }

            $idarchivo=$datos[0]["idMov"]+1;
            $nombrearchivo='movimiento_'.$mes.$anio;
          
            $target_path = $directorio.'/'.$nombrearchivo.".zip"; //Indicamos la ruta de destino, así como el nombre del archivo

           if(!move_uploaded_file($source, $target_path)){ 
               $response["status"] = "error";
               $response["message"]= "Error al subir archivos";
           }
           closedir($dir);//Cerramos el directorio de destino
        }
    }
   
    $sql1= "INSERT INTO documentos_movimientos(NombrearchivoMov,FechaCargaarchivoMov)
            VALUES('$nombrearchivo',now())";      
        
    $res = mysqli_query($conexion, $sql1);
// }

if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}

echo json_encode($response);
?> 