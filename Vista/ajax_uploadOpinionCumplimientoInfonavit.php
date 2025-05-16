<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajax_uploadOpinionInf.log" , KLogger::DEBUG );
$response= array();
$registro=$_POST["registro"];
$mes=$_POST["mes"];
$valorAct=$_POST["valorAct"];
$response["status"] = "success";
$permitidos= "application/pdf";
$correcto=true;
//$log->LogInfo("Valor de la variable valorAct: " . var_export ($valorAct, true));

$valor=$_FILES["archivoOpinionInfonavit"]['type'][0];
    //$log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
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
    foreach($_FILES["archivoOpinionInfonavit"]['tmp_name'] as $key => $tmp_name)
    {
        if($_FILES["archivoOpinionInfonavit"]["name"][$key]) {
            $filename = $_FILES["archivoOpinionInfonavit"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["archivoOpinionInfonavit"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = "uploads/DocumentosOpinionCumplimiento/Infonavit/".$registro.$mes.$anio."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $nombrearchivo="opinionInfonavit".$mes.$anio;
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
if ($valorAct==0) {
        $empleado= $negocio -> insertOpinionInfonavit($registro,$mes,$anio,$nombrearchivo);
    }
}

if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}

echo json_encode($response);

?> 