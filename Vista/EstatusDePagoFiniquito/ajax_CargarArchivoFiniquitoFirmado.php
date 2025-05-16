<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
} 
$log = new KLogger ( "ajax_CargarArchivoFiniquitoFirmado.log" , KLogger::DEBUG );
$response = array("status" => "success");
$NumeroEmpleado = $_POST['numempleado'];
$idFiniquito = $_POST['idFiniquito'];
$fechaAlta = $_POST['fechaAlta'];
$fechaBaja = $_POST['fechaBaja'];
// $log->LogInfo("Valor de la variable numeroFolioSPF: " . var_export ($numeroFolioSPF, true));

$noEmp = $_POST['noEmp'];
$firmaEmp = $_POST['firmaEmp'];


try{
    $permitidospdf= "application/pdf";
    $permitidosjpeg= "image/jpeg";
    $permitidospng= "application/png";
    $permitidospng1= "image/png";
    $permitidosjpg= "application/jpg";
    $correcto=true;

    $num=count($_FILES["archivoGestionFini"]['type']);
    for($a=0;$a<$num;$a++){
        $valor=$_FILES["archivoGestionFini"]['type'][$a];
        if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
            $correcto=false;
            break;
        }
    }
    if(!$correcto){
        $response["status"]  = "error";
        $response ["message"]= "Tipos De Arhivos Finiquitos Firmados Incorrecto O Limite Excedido Revise El Documento Nuevamente";
    }else{
        $extencionArchivo= explode("/", $_FILES["archivoGestionFini"]['type'][0]);    
        $extencionArchivooriginal=$extencionArchivo[1];
        foreach($_FILES["archivoGestionFini"]['tmp_name'] as $key => $tmp_name){

            if($_FILES["archivoGestionFini"]["name"][$key]){
                $filename = $_FILES["archivoGestionFini"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["archivoGestionFini"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio = '../uploads/finiquitosFirmadosParaPago/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                }

                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'."FF_".$idFiniquito."_".$NumeroEmpleado."_".$fechaAlta."_".$fechaBaja.".".$extencionArchivooriginal; //Indicamos la ruta de destino, así como el nombre del archivo
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(!move_uploaded_file($source, $target_path)) { 
                    $response["status"] = "error";
                    $response ["message"] = "Error al subir archivos De Vacaciones";
                }
                closedir($dir); //Cerramos el directorio de destino
            }
        }
        $response ["message"] = "Archivo Subido Correctamente";
        $NombreTempArchivo ="FF_".$idFiniquito."_".$NumeroEmpleado."_".$fechaAlta."_".$fechaBaja.".".$extencionArchivooriginal;
        
        $sql1 ="UPDATE finiquitos
                SET nombreFiniquitoFirmado='$NombreTempArchivo', 
                    estatusPagoFiniquito='3',
                    noEmpDocFiniquitoFirmado='$noEmp',
                    pwdEmpDocFiniquitoFirmado='$firmaEmp'
                WHERE idFiniquito='$idFiniquito'";
$log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true));
                
        $res = mysqli_query($conexion, $sql1);
    }
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo eliminar folio";
}
echo json_encode($response);
?>