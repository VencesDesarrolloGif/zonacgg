<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
//$log = new KLogger ( "ajax_DocumentoVehiculo.log" , KLogger::DEBUG );
$response = array ();
$usuario = $_SESSION ["userLog"]["usuario"];
$response["status"] = "success"; 
//$log->LogInfo("Variable pos pos: " . var_export ($_POST, true));
$numeroeconomicobaja=$_POST["numeroeconomicoconsulta"];
//$log->LogInfo("Variable _FILES DocCheques: " . var_export ($_FILES["DocCheques12"], true));
$pdf= "application/pdf";
$png= "image/png";
$jpg= "image/jpeg";
$correcto=true;
$num=1;
$fecha = date("Ymd"); 
//$log->LogInfo("Variable fecha : " . var_export ($fecha, true));
for($a=0;$a<$num;$a++){
    $valorDocFiniquito=$_FILES["DocFiniquito12"]['type'][$a];
    $valorDocCheques=$_FILES["DocCheques12"]['type'][$a];
    if($valorDocFiniquito!=""){
        if($valorDocFiniquito!=$pdf && $valorDocFiniquito!=$png && $valorDocFiniquito!=$jpg){
        $correcto=false;
        break;
        }
    }else if($valorDocCheques!=""){
        if($valorDocCheques!=$pdf && $valorDocCheques!=$png && $valorDocCheques!=$jpg){
        $correcto=false;
        break;
        }
     }/*else if(empty($valorDocFiniquito) && empty($valorDocCheques)){
        $correcto=false;
        break;
    } */   
} //$log->LogInfo("Valor de la fecha: " . var_export ($correcto, true));
    if(!$correcto){
      $response["status"] = "error";
      $response ["message"] = "Solo Acepta Archivos Tipo (.pdf,.png,.jpeg) ";
    }
    else{
        if($valorDocFiniquito!=""){
            foreach($_FILES["DocFiniquito12"]['tmp_name'] as $key => $tmp_name)
            {
            //Validamos que el archivo exista
                if($_FILES["DocFiniquito12"]["name"][$key]) {
                    $DocFiniquito12filename = $_FILES["DocFiniquito12"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $DocFiniquito12source = $_FILES["DocFiniquito12"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                    $DocFiniquito12directorio = 'uploads/ParqueVehicular/DocumentosBajas/DocumentosBajaFiniquitos/'; //Declaramos un  variable con la ruta donde guardaremos  los archivos
                //$fecha = $_FILE["fechaMovimiento"];
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($DocFiniquito12directorio)){
                        mkdir($DocFiniquito12directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    $DocFiniquito12dir=opendir($DocFiniquito12directorio); //Abrimos el directorio de destino
                    $DocFiniquito12target_path = $DocFiniquito12directorio . $numeroeconomicobaja . "_". $fecha . "_" . $DocFiniquito12filename; //Indicamos la ruta de destino, así como el  nombre del archivo
                    $log->LogInfo("Variable DocFiniquito12target_path: " . var_export ($DocFiniquito12target_path, true));
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(!move_uploaded_file($DocFiniquito12source, $DocFiniquito12target_path)) { 
                        $response["status"] = "error";
                        $response ["message"] = "Error al subir archivos";
                    }
                    closedir($DocFiniquito12dir); //Cerramos el directorio de destino
                }
            }
        $bb = $numeroeconomicobaja . "_". $fecha . "_" . $DocFiniquito12filename;
     //   $log->LogInfo("Valor de la bb: " . var_export ($bb, true));
        $response["DocFiniquito"] = $bb;
        }
        if($valorDocCheques!=""){
           
            foreach($_FILES["DocCheques12"]['tmp_name'] as $key => $tmp_name)
            {
            //Validamos que el archivo exista
                if($_FILES["DocCheques12"]["name"][$key]) {
                    $DocCheques12filename = $_FILES["DocCheques12"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $DocCheques12source = $_FILES["DocCheques12"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                    $DocCheques12directorio = 'uploads/ParqueVehicular/DocumentosBajas/DocumentosBajaCheques/'; //Declaramos un  variable con la ruta donde guardaremos  los archivos
                //$fecha = $_FILE["fechaMovimiento"];
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($DocCheques12directorio)){
                        mkdir($DocCheques12directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    $DocCheques12dir=opendir($DocCheques12directorio); //Abrimos el directorio de destino
                    $DocCheques12target_path = $DocCheques12directorio . $numeroeconomicobaja . "_". $fecha . "_" . $DocCheques12filename; //Indicamos la ruta de destino, así como el  nombre del archivo
        //            $log->LogInfo("Variable DocCheques12target_path: " . var_export ($DocCheques12target_path, true));
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(!move_uploaded_file($DocCheques12source, $DocCheques12target_path)) { 
                        $response["status"] = "error";
                        $response ["message"] = "Error al subir archivos";
                    }
                    closedir($DocCheques12dir); //Cerramos el directorio de destino
                }
            }
        $aa = $numeroeconomicobaja . "_". $fecha . "_" . $DocCheques12filename;
        $log->LogInfo("Valor de la aa: " . var_export ($aa, true));
        $response["DocCheque"] = $aa;
        }

    }
    if( $response["status"] =='success'){
        //$log->LogInfo("Valor de la fecha: " . var_export ($fecha, true));
        $response["message"]='Archivos subidos correctamente';
    }
    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
    echo json_encode($response);

?> 