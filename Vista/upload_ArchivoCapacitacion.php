<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
// $log = new KLogger ( "ajax_uploadpdf.log" , KLogger::DEBUG );
$response = array ();
$usuario = $_SESSION ["userLog"]["nombre"];
$response["status"] = "success";  
// $log->LogInfo("Valor de _FILES " . var_export ($_FILES, true));
$archivomodulo1 = $_FILES["archivomodulo1"]["name"]["0"];
$archivomodulo2 = $_FILES["archivomodulo2"]["name"]["0"];
$archivomodulo3 = $_FILES["archivomodulo3"]["name"]["0"];
$archivomodulo4 = $_FILES["archivomodulo4"]["name"]["0"];
$archivomodulo5 = $_FILES["archivomodulo5"]["name"]["0"];

if($archivomodulo1 != "" && $archivomodulo1 != "null" && $archivomodulo1 != null && $archivomodulo1 != NULL && $archivomodulo1 != "NULL"){
    foreach($_FILES["archivomodulo1"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["archivomodulo1"]["name"][$key]) {
            $source1 = $_FILES["archivomodulo1"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio1 = 'uploads/archivosCapacitaciones/Modulo1/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
    //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio1)){
                mkdir($directorio1, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir1=opendir($directorio1); //Abrimos el directorio de destino
            $target_path1 = $directorio1 . "Modulo1.pdf";
            if(!move_uploaded_file($source1, $target_path1)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir1); //Cerramos el directorio de destino 
        }
    }
}
if($archivomodulo2 != "" && $archivomodulo2 != "null" && $archivomodulo2 != null && $archivomodulo2 != NULL && $archivomodulo2 != "NULL"){
    foreach($_FILES["archivomodulo2"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["archivomodulo2"]["name"][$key]) {
            $source2 = $_FILES["archivomodulo2"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            $directorio2 = 'uploads/archivosCapacitaciones/Modulo2/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
    //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio2)){
                mkdir($directorio2, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir2=opendir($directorio2); //Abrimos el directorio de destino
            $target_path2 = $directorio2 . "Modulo2.pdf";
            if(!move_uploaded_file($source2, $target_path2)){ 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir2); //Cerramos el directorio de destino 
        }
    }
}
if($archivomodulo3 != "" && $archivomodulo3 != "null" && $archivomodulo3 != null && $archivomodulo3 != NULL && $archivomodulo3 != "NULL"){
    foreach($_FILES["archivomodulo3"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["archivomodulo3"]["name"][$key]) {
            $source3 = $_FILES["archivomodulo3"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio3 = 'uploads/archivosCapacitaciones/Modulo3/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio3)){
                mkdir($directorio3, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir3=opendir($directorio3); //Abrimos el directorio de destino
            $target_path3 = $directorio3 . "Modulo3.pdf";
            if(!move_uploaded_file($source3, $target_path3)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir3); //Cerramos el directorio de destino
        }
    }
} 
if($archivomodulo4 != "" && $archivomodulo4 != "null" && $archivomodulo4 != null && $archivomodulo4 != NULL && $archivomodulo4 != "NULL"){
    foreach($_FILES["archivomodulo4"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["archivomodulo4"]["name"][$key]) {
            $source4 = $_FILES["archivomodulo4"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            $directorio4 = 'uploads/archivosCapacitaciones/Modulo4/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio4)){
                mkdir($directorio4, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir4=opendir($directorio4); //Abrimos el directorio de destino
            $target_path4 = $directorio4. "Modulo4.pdf";
            if(!move_uploaded_file($source4, $target_path4)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir4); //Cerramos el directorio de destino
        }
    } 
}
if($archivomodulo5 != "" && $archivomodulo5 != "null" && $archivomodulo5 != null && $archivomodulo5 != NULL && $archivomodulo5 != "NULL"){
    foreach($_FILES["archivomodulo5"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista
        if($_FILES["archivomodulo5"]["name"][$key]) {
            $source5 = $_FILES["archivomodulo5"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio5 = 'uploads/archivosCapacitaciones/Modulo5/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio5)){
                mkdir($directorio5, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            $dir5=opendir($directorio5); //Abrimos el directorio de destino
            $target_path5 = $directorio5 . "Modulo5.pdf";
            if(!move_uploaded_file($source5, $target_path5)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir5); //Cerramos el directorio de destino 
        }
    }   
}
if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}else{
    $response["message"]='Error Al Subir Archivos De Capacitacion';
}
echo json_encode($response);

?> 