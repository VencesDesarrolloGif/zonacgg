<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$log = new KLogger ( "ajax_CargarArchivoEditComprobantePago.log" , KLogger::DEBUG );
$response = array("status" => "success");
$idFiniquito = $_POST['idFiniquito'];
$nameDocumentEdit = $_POST['nameDocumentEdit'];

$NumEmpModalFirmaEdit = $_POST['NumEmpModalFirmaEdit'];
$constraseniaFirmaEdit = $_POST['constraseniaFirmaEdit'];

$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));

try{
    $permitidospdf= "application/pdf";
    $permitidosjpeg= "image/jpeg";
    $permitidospng= "application/png";
    $permitidospng1= "image/png";
    $permitidosjpg= "application/jpg";
    $correcto=true;
    $num=count($_FILES["archivoEditComprobantePago"]['type']);

    for($a=0;$a<$num;$a++){
        $valor=$_FILES["archivoEditComprobantePago"]['type'][$a];
        if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
            $correcto=false;
            break;
        }
    }
    if(!$correcto){
        $response["status"]  = "error";
        $response ["message"]= "Tipos de archivo incorrecto o limite excedido revise el documento nuevamente";
    }else{
        $documento = explode(".", $nameDocumentEdit);
        $nombreSinExtencion=$documento[0];
        // $log->LogInfo("Valor de la variable nombreSinExtencion: " . var_export ($nombreSinExtencion, true));
        $extencionArchivo= explode("/", $_FILES["archivoEditComprobantePago"]['type'][0]);    
        $extencionArchivooriginal=$extencionArchivo[1];

        foreach($_FILES["archivoEditComprobantePago"]['tmp_name'] as $key => $tmp_name){

            if($_FILES["archivoEditComprobantePago"]["name"][$key]){
                $filename = $_FILES["archivoEditComprobantePago"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["archivoEditComprobantePago"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio = '../uploads/comprobantesPagoFiniquitos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                }
                $nombreNuevoDocEdit='edit_'.$nombreSinExtencion.'.'.$extencionArchivooriginal;
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'.$nombreNuevoDocEdit; //Indicamos la ruta de destino, así como el nombre del archivo
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(!move_uploaded_file($source, $target_path)) { 
                    $response["status"] = "error";
                    $response ["message"] = "Error al subir archivos De comprobacion";
                }
                closedir($dir); //Cerramos el directorio de destino
            }
        }
        $response ["message"] = "Archivo Subido Correctamente";
        // $NombreTempArchivo ="FF_".$idFiniquito."_".$NumeroEmpleado."_".$fechaAlta."_".$fechaBaja.".".$extencionArchivooriginal;
        
        $sql1 ="UPDATE finiquitos
                SET nameDocComprobante='$nombreNuevoDocEdit', 
                    estatusEditDocComprobante='1',
                    fechaEditDocComprobante=now(),
                    noEmpEdit ='$NumEmpModalFirmaEdit',
                    pwdUserEdit='$constraseniaFirmaEdit'
                WHERE idFiniquito='$idFiniquito'";
        $res = mysqli_query($conexion, $sql1);
$log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true));

    }
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo actualizar comprobante";
}
echo json_encode($response);
?>