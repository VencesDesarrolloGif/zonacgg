<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_InsertDocSATEdit.log" , KLogger::DEBUG );
$response = array();
$opcion= $_POST['opcion'];
$anioDocSAT= $_POST['anioDocSAT'];
$mesDocSAT = $_POST['mesDocSAT'];
$idDocumento=$_POST['idDocumento'];
$regPat=$_POST['regPat'];
$nombreCarpeta=$_POST['nombreCarpeta'];
$usuario = $_SESSION ["userLog"]["usuario"];
$valor=$_FILES["documentoCargadoEditEdit"]['type'][0];
$permitidos = "application/x-zip-compressed";
$permitidos1= "application/octet-stream";
$permitidos2= "application/pdf";
$correcto=true;
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
    
if(($valor!=$permitidos && $valor!=$permitidos1) && $opcion=='1'){
   $correcto=false;
}

if(($opcion=='2' || $opcion=='3') && $valor!=$permitidos2){
   $correcto=false;
}

if(!$correcto){
   $response["status"]  = "error";
   $response ["mensaje"]= "Tipos De Arhivo Incorrecto O Limite Excedido Revise El Documento Nuevamente";
}else{
      if($_FILES["documentoCargadoEditEdit"]['type'][0]== $permitidos){
                $extencion = ".zip";
      }else if($_FILES["documentoCargadoEditEdit"]['type'][0]== $permitidos1){
          $extencion = ".rar";
      }else if($_FILES["documentoCargadoEditEdit"]['type'][0]== $permitidos2){
          $extencion = ".pdf";
      }

      foreach($_FILES["documentoCargadoEditEdit"]['tmp_name'] as $key => $tmp_name){ 
      
            if($_FILES["documentoCargadoEditEdit"]["name"][$key]) {
              $source = $_FILES["documentoCargadoEditEdit"]["tmp_name"][$key]; 

              if($opcion=='1'){
                 $directorio="../uploads/documentosContabilidad/pagoSua/".$nombreCarpeta; 
                 $nombreDocumento ='PuntoSUA'.$extencion;

              }if($opcion=='2'){

                 $directorio='../uploads/DocumentosIDSEEMA/'; 
                 $nombreDocumento ="IDSE_EMA_".$regPat."_".$mesDocSAT.$anioDocSAT.$extencion;

              }if($opcion=='3'){
                 $directorio='../uploads/DocumentosIDSEEBA/'; 
                 $nombreDocumento ="IDSE_EbA_".$regPat."_".$mesDocSAT.$anioDocSAT.$extencion;
              }
               if(!file_exists($directorio)){
                  mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
               }
               $dir=opendir($directorio);
               $target_path=$directorio.'/'.$nombreDocumento; 

               if(!move_uploaded_file($source, $target_path)){ 
                  $response["status"]  = "error";
                  $response["mensaje"]= "Error al subir archivo";
                  return;
               }
               closedir($dir); //Cerramos el directorio de destino
           }
         }//termina foreach

         if($opcion=='1'){
            $sql = "UPDATE catalogoPuntoSUA SET fechaEditPuntoSUA=now(),USReditaPuntoSUA='$usuario'
                    WHERE idPuntoSUA=$idDocumento";
         }if($opcion=='2'){//ema
            $sql = "UPDATE IDSE_EMA SET fechaEditIDSEEMA=now(),USReditaIDSEEMA='$usuario'
                    WHERE idArchivoIDSEEMA=$idDocumento";
         }if($opcion=='3'){//eba
            $sql = "UPDATE IDSE_EBA SET fechaEditIDSEEBA=now(),USReditaIDSEEBA='$usuario'
                    WHERE idArchivoIDSEEBA=$idDocumento";
         }
         $res = mysqli_query($conexion, $sql);

         if($res !== true){
            $response["status"] ="error";
            $response["mensaje"]="error al actualizar documento SAT";
            return;
         }else{
               $response["mensaje"]= "Archivo editado Correctamente";
               $response["status"] = "success";
         }
}//termina else
echo json_encode($response);
?> 

