<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio); 
//$log = new KLogger ( "ajax_CargaDePdfFirmado.log" , KLogger::DEBUG );
$response = array ();
$empleadoEntidadId = getValueFromPost ("empleadoEntidadId");
$empleadoConsecutivoId = getValueFromPost ("empleadoConsecutivoId");
$empleadoTipoId = getValueFromPost ("empleadoTipoId");
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));
$response["status"] = "success";
//se declaran los archivos que se van a permitir al momento de cargar el pdf
$permitidospdf= "application/pdf";
$permitidosjpeg= "image/jpeg";
$permitidospng= "application/png";
$permitidospng1= "image/png";
$permitidosjpg= "application/jpg";
$correcto=true;

$idorden= $negocio -> obtenerMaxId();
$maxid= $idorden["idMax"]+1;

$num=count($_FILES["btnExaminar"]['type']);
for($a=0;$a<$num;$a++){

    $valor=$_FILES["btnExaminar"]['type'][$a];
    
    if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
       $correcto=false;
       break;
      }
   }
if(!$correcto){
   $response["status"] = "error";
   $response ["message"] = "Tipo de archivo incorrecto";
  }else{
     //   $extencionDoc= explode("/", $_FILES["btnExaminar"]['type'][0]);    
      //  $extencionArchivooriginal=$extencionDoc[1];
         foreach($_FILES["btnExaminar"]['tmp_name'] as $key => $tmp_name){
           //Validamos que el archivo exista
           if($_FILES["btnExaminar"]["name"][$key]){
              $filename = $_FILES["btnExaminar"]["name"][$key]; //Obtenemos el nombre original del archivo
              $source = $_FILES["btnExaminar"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
              $directorio = 'uploads/DocFirmadoEntregaUniformes/'.$empleadoEntidadId."-".$empleadoConsecutivoId."-".$empleadoTipoId."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
              if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                   }
              $dir=opendir($directorio); //Abrimos el directorio de destino
              $target_path = $directorio.'/'."Orden_".$maxid; //Indicamos la ruta de destino, así como el nombre del archivo
              //Movemos y validamos que el archivo se haya cargado correctamente
              //El primer campo es el origen y el segundo el destino
              if(!move_uploaded_file($source, $target_path)){ 
                 $response["status"] = "error";
                 $response ["message"] = "Error al subir archivos De Vacaciones";
                }
               closedir($dir); //Cerramos el directorio de destino
           }
         }
         $response ["message"] = "Archivo Subido Correctamente";
         $NombreTempArchivo ="Uniformes_".$maxid;
       }
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);
?> 