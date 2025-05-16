<?php
session_start ();
require_once("../../Negocio/Negocio.class.php");
require_once("../../Vista/Helpers.php");
require_once ("../../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajax_uploadfiniquitofirmado.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$response   = array ();
$numempelado=$_POST['numempelado'];
$fechabaja  =$_POST['fechabaja'];
$fechaalta  =$_POST['fechaalta'];
$i          =$_POST['i'];    
$response["status"] = "success";
$permitidos= "application/pdf";
$correcto=true;
//$log->LogInfo("Valor de la variable i: " . var_export ($_FILES["firmafiniquito".$i], true));
$num=count($_FILES["firmafiniquito".$i]['type']);
for($a=0;$a<$num;$a++){
    $valor=$_FILES["firmafiniquito".$i]['type'][$a];
    //$log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
    if($valor!=$permitidos){
        $correcto=false;
        break;
    }
}
if(!$correcto){
    $response["status"]     = "error";
    $response ["message"]   = "Tipos de arhivos incorrecto o limite excedido";
}else{
    foreach($_FILES["firmafiniquito".$i]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["firmafiniquito".$i]["name"][$key]) {
            $filename   = $_FILES["firmafiniquito".$i]["name"][$key]; //Obtenemos el nombre original del archivo
            $source     = $_FILES["firmafiniquito".$i]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = '../../Vista/uploads/finiquitosfirmados/'.$numempelado."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $target_path = $directorio.'/'.$numempelado.'_'.$fechaalta.'_'.$fechabaja.".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"]  = "error";
                $response["message"] = "Error al subir archivos";
            }
            closedir($dir); //Cerramos el directorio de destino
        }
    }
}
if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
$negocio -> actualizarEstatuCargaArchivo($numempelado, $fechabaja, $fechaalta);
}
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
echo json_encode($response);

?> 
