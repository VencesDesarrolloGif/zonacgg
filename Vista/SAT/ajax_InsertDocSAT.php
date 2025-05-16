<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ("ajax_InsertDocSAT.log" , KLogger::DEBUG );
$response = array();
$opcion= $_POST['opcion'];
$anioDocSAT= $_POST['anioDocSAT'];
$mesDocSAT = $_POST['mesDocSAT'];
$usuario = $_SESSION ["userLog"]["usuario"];
$valor=$_FILES["documentoCargadoSAT"]['type'][0];
$permitidospdf = "application/pdf";
$correcto=true;

if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
   $correcto=false;
}

if(!$correcto){
    $response["status"]  = "error";
    $response ["message"]= "Tipos De Arhivo Incorrecto O Limite Excedido Revise El Documento Nuevamente";
}else{
      $extencionArchivo= explode("/", $_FILES["documentoCargadoSAT"]['type'][0]);    
      $extencionArchivooriginal=$extencionArchivo[1];

      foreach($_FILES["documentoCargadoSAT"]['tmp_name'] as $key => $tmp_name){ 
          
           if($_FILES["documentoCargadoSAT"]["name"][$key]) {
              $source = $_FILES["documentoCargadoSAT"]["tmp_name"][$key]; 

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
                  $response ["message"]= "Error al subir archivo SAT";
                  return;
              }
             closedir($dir); //Cerramos el directorio de destino
            }
      }//termina foreach

      if($opcion=='1'){
         $sql = "INSERT INTO catalogoDeclaracionISR(nombreDocDecISR,mesDecISR,anioDecISR,fechaCargaDecISR,estatusDecISR,USRCargaDecISR)
                 VALUES('$nombreDocumento','$mesDocSAT','$anioDocSAT',now(),'1','$usuario')";
      }if($opcion=='2'){
         $sql = "INSERT INTO catalogoDeclaracionIVA(nombreDocDecIVA,mesDecIVA,anioDecIVA,fechaCargaDecIVA,estatusDecIVA,USRCargaDecIVA)
                 VALUES('$nombreDocumento','$mesDocSAT','$anioDocSAT',now(),'1','$usuario')";
      }if($opcion=='3'){
         $sql = "INSERT INTO catalogoPagosISR(nombreDocPagoISR,mesPagoISR,anioPagoISR,fechaCargaPagoISR,estatusDocPagoISR,USRCargaPagoISR)
                 VALUES('$nombreDocumento','$mesDocSAT','$anioDocSAT',now(),'1','$usuario')";
      }if($opcion=='4'){
         $sql = "INSERT INTO catalogoPagosIVA(nombreDocPagoIVA,mesPagoIVA,anioPagoIVA,fechaCargaPagoIVA,estatusDocPagoIVA,USRCargaPagoIVA)
                 VALUES('$nombreDocumento','$mesDocSAT','$anioDocSAT',now(),'1','$usuario')";
      }if($opcion=='5'){
         $sql = "INSERT INTO catalogoOpinionSAT(nombreDocOpinionSAT,mesOpinionSAT,anioOpinionSAT,fechaCargaOpinionSAT,estatusDocOpinionSAT,USRCargaOpinionSAT)
                 VALUES('$nombreDocumento','$mesDocSAT','$anioDocSAT',now(),'1','$usuario')";
      }if($opcion=='6'){
         $sql = "INSERT INTO catalogoConstanciaSituacionFiscal(nombreDocConstanciaSitFis,mesConstanciaSitFis,anioConstanciaSitFis,fechaCargaConstanciaSitFis,estatusDocConstanciaSitFis,USRCargaConstanciaSitFis)
                 VALUES('$nombreDocumento','$mesDocSAT','$anioDocSAT',now(),'1','$usuario')";
      }if($opcion=='7'){
         $sql = "INSERT INTO catalogoAFFIDAVIT(nombreDocAFFIDAVIT,mesAFFIDAVIT,anioAFFIDAVIT,fechaCargaAFFIDAVIT,estatusDocAFFIDAVIT,USRCargaAFFIDAVIT)
                 VALUES('$nombreDocumento','$mesDocSAT','$anioDocSAT',now(),'1','$usuario')";
      }
      // $log->LogInfo("Valor de variable sql" . var_export ($sql, true));

         $res = mysqli_query($conexion, $sql);

         if($res !== true){
            $response["status"] ="error";
            $response["mensaje"]="error al guardar Documento SAT";
         }else{
               $response["mensaje"]= "Archivo Subido Correctamente";
               $response["status"] = "success";
         }
}//termina else
      // $log->LogInfo("Valor de variable response" . var_export ($response, true));

echo json_encode($response);
?> 

