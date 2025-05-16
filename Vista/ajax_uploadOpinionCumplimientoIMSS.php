<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajax_uploadOpinionIMSS.log" , KLogger::DEBUG );
$response= array();
$mes=$_POST["mes"];
$response["status"] = "success";
$permitidos= "application/pdf";
$correcto=true;
//$log->LogInfo("Valor de la variable files: " . var_export ($_FILES, true));

$valor=$_FILES["archivoOpinionIMSS"]['type'][0];
    if($valor!=$permitidos){
        $correcto=false;

    }

if(!$correcto){
    $response["status"] = "error";
    $response ["message"] = "Tipo de arhivo incorrecto";
}else{
    $hoy = getdate();
    $anio=$hoy["year"];
        //Validamos que el archivo exista
    foreach($_FILES["archivoOpinionIMSS"]['tmp_name'] as $key => $tmp_name)
    {
        if($_FILES["archivoOpinionIMSS"]["name"][$key]) {
            $filename = $_FILES["archivoOpinionIMSS"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["archivoOpinionIMSS"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = "uploads/DocumentosOpinionCumplimiento/Imss/".$mes.$anio."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $nombrearchivo="opinionIMSS".$mes.$anio;
            $target_path = $directorio.'/'.$nombrearchivo.".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response["message"] = "Error al subir archivos";
            }
            closedir($dir);//Cerramos el directorio de destino
        }
    }
        $empleado= $negocio -> insertOpinionIMSS($mes,$anio,$nombrearchivo);
}



if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}

echo json_encode($response);

?> 