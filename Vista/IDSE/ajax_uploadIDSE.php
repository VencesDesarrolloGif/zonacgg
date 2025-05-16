<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_uploadIDSE.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

$response= array();
$response["status"] = "success";
$regPat =$_POST["regPatIDSE"];
$anioActual=$_POST["anioActual"];
$mesIDSE    =$_POST["mesIDSE"];
$tipoDoc   =$_POST["tipoDoc"];
$permitidos="application/pdf";
$usuario = $_SESSION ["userLog"]["usuario"];

$correcto=true;
$valor=$_FILES["archivoIDSE"]['type'][0];

if($valor!=$permitidos){
   $correcto=false;
}

if(!$correcto){
    $response["status"] = "error";
    $response["mensaje"]= "Tipo de arhivo incorrecto";
}else{
    $hoy = getdate();

    foreach($_FILES["archivoIDSE"]['tmp_name'] as $key => $tmp_name){
        if($_FILES["archivoIDSE"]["name"][$key]){
            $filename  = $_FILES["archivoIDSE"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source    = $_FILES["archivoIDSE"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo   

            if($tipoDoc==1){
                $directorio= "../uploads/DocumentosIDSEEMA/";
                $nombrearchivo='IDSE_EMA_'.$regPat.'_'.$mesIDSE.$anioActual.'.pdf';
            } 

            if($tipoDoc==2){
               $directorio= "../uploads/DocumentosIDSEEBA/";
               $nombrearchivo='IDSE_EBA_'.$regPat.'_'.$mesIDSE.$anioActual.'.pdf';
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
        $sql= "INSERT INTO IDSE_EMA(NombreArchivoIDSEEMA,FechaCargaArchivoIDSEEMA,USRCargaIDSEEMA)
                VALUES('$nombrearchivo',now(),'$usuario')";
    } 

    if($tipoDoc==2){
        $sql= "INSERT INTO IDSE_EBA(NombreArchivoIDSEEBA,FechaCargaArchivoIDSEEBA,USRCargaIDSEEBA)
                VALUES('$nombrearchivo',now(),'$usuario')";
    }     
        // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
}
if( $response["status"] =='success'){
    $response["mensaje"]='Archivos subidos correctamente';
}
echo json_encode($response);
?> 