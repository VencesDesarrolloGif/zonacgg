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
$fechamov=$_POST['fechamov'];
$NombreUsuario=$_POST['NombreUsuario'];
$impidlibromovimiento=$_POST['impid'];
$impidlibromovimientoComprobaciones=$_POST['i'];
$idcompro=$_POST['idMovCompro'];
$response["status"] = "success";  

// $log->LogInfo("Valor de la fecha: " . var_export ($_POST, true));

$permitidos= "application/pdf";
$correcto=true;
$num=count($_FILES["fileDocPdfCompro".$impidlibromovimientoComprobaciones]['type']);
for($a=0;$a<$num;$a++){

    $valor=$_FILES["fileDocPdfCompro".$impidlibromovimientoComprobaciones]['type'][$a];


    if($valor!=$permitidos){
        $correcto=false;
        break;
    }

} //$log->LogInfo("Valor de la fecha: " . var_export ($correcto, true));

    if(!$correcto){
      $response["status"] = "error";
      $response ["message"] = "Tipos de arhivos incorrecto o limite excedido";
    }
    else{
        foreach($_FILES["fileDocPdfCompro".$impidlibromovimientoComprobaciones]['tmp_name'] as $key => $tmp_name)
    {
        //Validamos que el archivo exista

        if($_FILES["fileDocPdfCompro".$impidlibromovimientoComprobaciones]["name"][$key]) {
            $filename = $_FILES["fileDocPdfCompro".$impidlibromovimientoComprobaciones]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["fileDocPdfCompro".$impidlibromovimientoComprobaciones]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = 'uploads/archivoComprobaciones/Comprobaciones/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            //$fecha = $_FILE["fechaMovimiento"];
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            
            $dir=opendir($directorio); //Abrimos el directorio de destino
    
            $target_path = $directorio. $idcompro . "_" . $impidlibromovimiento . "_" .$fechamov .".pdf"; //Indicamos la ruta de destino, así como el nombre del archivo
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino
            
            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response ["message"] = "Error al subir archivos";
            }
            closedir($dir); //Cerramos el directorio de destino
        }
    }
}

if( $response["status"] =='success'){
   //   $log->LogInfo("Valor de la fecha: " . var_export ($fecha, true));
    $response["message"]='Archivos subidos correctamente';
}

//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));

echo json_encode($response);

?> 