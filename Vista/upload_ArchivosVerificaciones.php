<?php

session_start ();

require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");

$negocio = new Negocio();
verificarInicioSesion($negocio);
// Obtenemos los datos del empleado
//$log = new KLogger ( "ajax_DocumentosVerifiaciones.log" , KLogger::DEBUG );
$response = array ();
$usuario = $_SESSION ["userLog"]["usuario"];
$response["status"] = "success"; 
//$log->LogInfo("Variable pos pos: " . var_export ($_POST, true));
//$log->LogInfo("Variable checkSePagoMulta: " . var_export ($checkSePagoMulta, true));
$pdf= "application/pdf";
$png= "image/png";
$jpg= "image/jpeg";
$correcto=true;
$num=1;
$fecha = date("Ymd"); 
for($a=0;$a<$num;$a++){
    $ValorFototalnVer=$_FILES["FototalnVer"]['type'][$a];
    $ValorFormatoMulta=$_FILES["FormatoMulta"]['type'][$a];

    if($ValorFototalnVer!=""){
        $inpNumroEcoVehiculoVerificacion=$_POST["inpNumroEcoVehiculoVerificacion"];
//$log->LogInfo("Variable ValorFototalnVer : " . var_export ($ValorFototalnVer, true));
        if($ValorFototalnVer!=$png && $ValorFototalnVer!=$jpg && $ValorFototalnVer!=$pdf){
        $correcto=false;
        break;
        }
    }else if($ValorFormatoMulta!=""){
        $inpNumroEcoVehiculoVerificacion=$_POST["inpNumroEcoVehiculoVerificacion"];
        if($ValorFormatoMulta!=$pdf && $ValorFormatoMulta!=$png && $ValorFormatoMulta!=$jpg){
        $correcto=false;
        break;
        }
     }   
} //$log->LogInfo("Valor de la fecha: " . var_export ($correcto, true));
    if(!$correcto){
      $response["status"] = "error";
      $response ["message"] = "Solo Acepta Archivos Tipo (.png,.jpeg,.pdf) ";
    }
    else{
        if($ValorFototalnVer!=""){
            foreach($_FILES["FototalnVer"]['tmp_name'] as $key => $tmp_name)
            {
            //Validamos que el archivo exista
                if($_FILES["FototalnVer"]["name"][$key]) {
                    $FototalnVerfilename = $_FILES["FototalnVer"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $FototalnVersource = $_FILES["FototalnVer"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                    $FototalnVerdirectorio = 'uploads/ParqueVehicular/DocumentosVerificaciones/TalonesVerificaciones/'; //Declaramos un  variable con la ruta donde guardaremos  los archivos
                //$fecha = $_FILE["fechaMovimiento"];
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($FototalnVerdirectorio)){
                        mkdir($FototalnVerdirectorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    $FototalnVerdir=opendir($FototalnVerdirectorio); //Abrimos el directorio de destino
                    $FototalnVertarget_path = $FototalnVerdirectorio . $inpNumroEcoVehiculoVerificacion . "_". $fecha . "_" . $FototalnVerfilename; //Indicamos la ruta de destino, así como el  nombre del archivo
                   // $log->LogInfo("Variable FototalnVertarget_path: " . var_export ($FototalnVertarget_path, true));
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(!move_uploaded_file($FototalnVersource, $FototalnVertarget_path)) { 
                        $response["status"] = "error";
                        $response ["message"] = "Error al subir archivos";
                    }
                    closedir($FototalnVerdir); //Cerramos el directorio de destino
                }
            }
        $bb = $inpNumroEcoVehiculoVerificacion . "_". $fecha . "_" . $FototalnVerfilename;
       // $log->LogInfo("Valor de la bb: " . var_export ($bb, true));
        $response["DocVerificacion"] = $bb;
        }
        if($ValorFormatoMulta!=""){
           
            foreach($_FILES["FormatoMulta"]['tmp_name'] as $key => $tmp_name)
            {
            //Validamos que el archivo exista
                if($_FILES["FormatoMulta"]["name"][$key]) {
                    $FormatoMultafilename = $_FILES["FormatoMulta"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $FormatoMultasource = $_FILES["FormatoMulta"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                    $FormatoMultadirectorio = 'uploads/ParqueVehicular/DocumentosVerificaciones/DocumentosMultas/'; //Declaramos un  variable con la ruta donde guardaremos  los archivos
                //$fecha = $_FILE["fechaMovimiento"];
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($FormatoMultadirectorio)){
                        mkdir($FormatoMultadirectorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                    }
                    $FormatoMultadir=opendir($FormatoMultadirectorio); //Abrimos el directorio de destino
                    $FormatoMultatarget_path = $FormatoMultadirectorio . $inpNumroEcoVehiculoVerificacion . "_". $fecha . "_" . $FormatoMultafilename; //Indicamos la ruta de destino, así como el  nombre del archivo
                  //  $log->LogInfo("Variable FormatoMultatarget_path: " . var_export ($FormatoMultatarget_path, true));
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(!move_uploaded_file($FormatoMultasource, $FormatoMultatarget_path)) { 
                        $response["status"] = "error";
                        $response ["message"] = "Error al subir archivos";
                    }
                    closedir($FormatoMultadir); //Cerramos el directorio de destino
                }
            }
        $aa = $inpNumroEcoVehiculoVerificacion . "_". $fecha . "_" . $FormatoMultafilename;
      //  $log->LogInfo("Valor de la aa: " . var_export ($aa, true));
        $response["DocMulta"] = $aa;
        }

    }
    if( $response["status"] =='success'){
        //$log->LogInfo("Valor de la fecha: " . var_export ($fecha, true));
        $response["message"]='Archivos subidos correctamente';
    }
    //$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
    echo json_encode($response);

?> 