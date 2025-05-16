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
$usuario = $_SESSION ["userLog"]["usuario"];
$valor=$_FILES["documentoCargadoSATEdit"]['type'][0];
$permitidospdf = "application/pdf";
$correcto=true;
    
if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
   $correcto=false;
}

if(!$correcto){
   $response["status"]  = "error";
   $response ["mensaje"]= "Tipos De Arhivo Incorrecto O Limite Excedido Revise El Documento Nuevamente";
}else{
      
      $extencionArchivo= explode("/", $_FILES["documentoCargadoSATEdit"]['type'][0]);    
      $extencionArchivooriginal=$extencionArchivo[1];

      foreach($_FILES["documentoCargadoSATEdit"]['tmp_name'] as $key => $tmp_name){ 
      
           if($_FILES["documentoCargadoSATEdit"]["name"][$key]) {
              $source  = $_FILES["documentoCargadoSATEdit"]["tmp_name"][$key]; 

              if($opcion=='1'){
                 $directorio='../uploads/DeclaracionISR/'; 
                 $nombreDocumento ="DeclaracionISR_".$mesDocSAT."_".$anioDocSAT.".".$extencionArchivooriginal;
              }if($opcion=='2'){
                 $directorio='../uploads/DeclaracionIVA/'; 
                 $nombreDocumento ="DeclaracionIVA_".$mesDocSAT."_".$anioDocSAT.".".$extencionArchivooriginal;
              }if($opcion=='3'){
                 $directorio='../uploads/PagosISR/'; 
                 $nombreDocumento ="PagosISR_".$mesDocSAT."_".$anioDocSAT.".".$extencionArchivooriginal;
              }if($opcion=='4'){
                 $directorio='../uploads/PagosIVA/'; 
                 $nombreDocumento ="PagosIVA_".$mesDocSAT."_".$anioDocSAT.".".$extencionArchivooriginal;
              }if($opcion=='5'){
                 $directorio='../uploads/OpinionSAT/'; 
                 $nombreDocumento ="OpinionSAT_".$mesDocSAT."_".$anioDocSAT.".".$extencionArchivooriginal;
              }if($opcion=='6'){
                 $directorio='../uploads/ConstanciaDeSituacionFiscal/'; 
                 $nombreDocumento ="ConstanciaDeSituacionFiscal_".$mesDocSAT."_".$anioDocSAT.".".$extencionArchivooriginal;
              }if($opcion=='7'){
                 $directorio='../uploads/AFFIDAVIT/'; 
                 $nombreDocumento ="AFFIDAVIT_".$mesDocSAT."_".$anioDocSAT.".".$extencionArchivooriginal;
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
            $sql = "UPDATE catalogoDeclaracionISR SET fechaEditDecISR=now(),USReditaDecISR='$usuario'
                    WHERE idDecISR=$idDocumento";
         }if($opcion=='2'){
            $sql = "UPDATE catalogoDeclaracionIVA SET fechaEditDecIVA=now(),USReditaDecIVA='$usuario'
                    WHERE idDecIVA=$idDocumento";
         }if($opcion=='3'){
            $sql = "UPDATE catalogoPagosISR SET fechaEditPagoISR=now(),USReditaPagoISR='$usuario'
                    WHERE idPagoISR=$idDocumento";
         }if($opcion=='4'){
            $sql = "UPDATE catalogoPagosIVA SET fechaEditPagoIVA=now(),USReditaPagoIVA='$usuario'
                    WHERE idPagoIVA=$idDocumento";
         }if($opcion=='5'){
            $sql = "UPDATE catalogoOpinionSAT SET fechaEditOpinionSAT=now(),USReditaOpinionSAT='$usuario'
                    WHERE idOpinionSAT=$idDocumento";
         }if($opcion=='6'){
            $sql = "UPDATE catalogoConstanciaSituacionFiscal SET fechaEditConstanciaSitFis=now(),USReditaConstanciaSitFis='$usuario'
                    WHERE idConstanciaSitFis=$idDocumento";
         }if($opcion=='7'){
            $sql = "UPDATE catalogoAFFIDAVIT SET fechaEditAFFIDAVIT=now(),USReditaAFFIDAVIT='$usuario'
                    WHERE idAFFIDAVIT=$idDocumento";
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

