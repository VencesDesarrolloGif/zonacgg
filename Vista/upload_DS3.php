<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion($negocio);

// $log = new KLogger ( "ajax_uploadNomina.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$response = array ();

$entidad=$_POST['entidad'];
$cliente=$_POST['cliente'];

$response["status"] = "success";

$i=0;
$permitidos= "application/pdf";
$correcto=true;

$num=count($_FILES["docuC3"]['type']);
for($a=0;$a<$num;$a++){
    $valor=$_FILES["docuC3"]['type'][$a];
    //$log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
    if($valor!=$permitidos){
        $correcto=false;
        break;
    }
}

if(!$correcto){
    $response["status"] = "error";
    $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
}else{

    foreach($_FILES["docuC3"]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista

        if($_FILES["docuC3"]["name"][$key]) {
            $filename = $_FILES["docuC3"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["docuC3"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = 'uploads/otrosDocumentos/DC-3/'.$entidad."_".$cliente."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
            
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }


            
            $dir=opendir($directorio); //Abrimos el directorio de destino

            $target_path = $directorio.'/DC3_'.$i.".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
            
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            $i++;
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir); //Cerramos el directorio de destino
        }
    }
}

if( $response["status"] =='success'){
    $response["message"]='Archivos subidos correctamente';
}

echo json_encode($response);

?> 