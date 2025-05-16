<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio); 
//$log = new KLogger ( "ajax_GuardarDocEscrituraPublica.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
//$log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable file: " . var_export ($_FILES, true));

$response = array ();
$response["status"]   = "success";
$RepresentanteLegal   = getValueFromPost ("RepresentanteLegal");
$AdministradorUnico   = getValueFromPost ("AdministradorUnico");
$NumeroEscritura      = getValueFromPost ("NumeroEscritura");
$NombreNotarioPublico = getValueFromPost ("NombreNotarioPublico");
$NumeroNotarioPublico = getValueFromPost ("NumeroNotarioPublico");
$FechaEscrituraPublica= getValueFromPost ("FechaEscrituraPublica");
$FolioMercantil       = getValueFromPost ("FolioMercantil");
$casoDocumento                 = getValueFromPost ("casoDocumento");
$nombreDocumentoPasado= getValueFromPost ("nombreDocumento");
$anioActual = date('Y');
$mesActual  = date('m');

$permitidospdf = "application/pdf";
$permitidosjpeg= "image/jpeg";
$permitidospng = "application/png";
$permitidospng1= "image/png";
$permitidosjpg = "application/jpg";
$correcto=true;

if ($casoDocumento=='1') {
    // code...
$num=count($_FILES["documentoCargado"]['type']);
for($a=0;$a<$num;$a++){
    
    $valor=$_FILES["documentoCargado"]['type'][$a];
        if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
            $correcto=false;
            break;
        }
    }//termina for

    if(!$correcto){
        $response["status"] = "error";
        $response ["message"] = "Tipos De Arhivo Incorrecto O Limite Excedido Revise El Documento Nuevamente";
    }else{
          $idEscrituraPublica = $negocio->obtenerMaxIdEscrituraP();
          $idActual =$idEscrituraPublica[0]["idEscrituraActual"];
          $idNuevo =$idActual + '1';
          $extencionArchivo= explode("/", $_FILES["documentoCargado"]['type'][0]);    
          $extencionArchivooriginal=$extencionArchivo[1];
          foreach($_FILES["documentoCargado"]['tmp_name'] as $key => $tmp_name){
                if($_FILES["documentoCargado"]["name"][$key]) {//Validamos que el archivo exista
                   $filename  = $_FILES["documentoCargado"]["name"][$key]; //Obtenemos el nombre original del archivo
                   $source    = $_FILES["documentoCargado"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                   $directorio= 'uploads/documentosEscrituraPublica/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    //Validamos si la ruta de destino existe, en caso de no existir la creamos
                 if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                 $dir=opendir($directorio); //Abrimos el directorio de destino
                 $target_path = $directorio.'/'."EscrituraPublica_".$idNuevo."_".$anioActual."_".$mesActual.".".$extencionArchivooriginal; //Indicamos la ruta de destino, así como el nombre del archivo
                 //Movemos y validamos que el archivo se haya cargado correctamente
                 //El primer campo es el origen y el segundo el destino
                 if(!move_uploaded_file($source, $target_path)) { 
                     $response["status"] = "error";
                     $response ["message"] = "Error al subir archivo de escritura publica";
                 }
                closedir($dir); //Cerramos el directorio de destino
                }
         }//termina foreach
         $response ["message"] = "Archivo Subido Correctamente";
         $nombreDocumento ="EscrituraPublica_".$idNuevo."_".$anioActual."_".$mesActual.".".$extencionArchivooriginal;
        }//termina else
    }else{//casoDocumento0 no se agrego un archivo entonces guardar con el nombre anterior
        $nombreDocumento =$nombreDocumentoPasado;

    }
    $escrituraPublica = $negocio->updateDatosEscrituraPublica($RepresentanteLegal,$AdministradorUnico,$NumeroEscritura,$NombreNotarioPublico,$NumeroNotarioPublico,$FechaEscrituraPublica,$FolioMercantil,$nombreDocumento);// se inserta ya que no se deben sobreescribir los datos
//REVISAR QUE FUNCIONE
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

echo json_encode($response);
?> 