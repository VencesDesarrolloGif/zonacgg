<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_RegistrarPagoPorFolio.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable numeroFolioSPF: " . var_export ($numeroFolioSPF, true));
$response = array("status" => "success");
$numeroFolioSPF = $_POST['folioSPF'];
$numeroFolioComprobantePago = $_POST['folioComprobante'];
$usuario=$_SESSION['userLog']['usuario'];
$listaIdFiniquitos= array();

try{
    $permitidospdf= "application/pdf";
    $permitidosjpeg= "image/jpeg";
    $permitidospng= "application/png";
    $permitidospng1= "image/png";
    $permitidosjpg= "application/jpg";
    $correcto=true;

    $num=count($_FILES["docComprobante"]['type']);
    for($a=0;$a<$num;$a++){
        $valor=$_FILES["docComprobante"]['type'][$a];
        if($valor!=$permitidospdf && $valor!=$permitidosjpeg && $valor!=$permitidospng && $valor!=$permitidospng1 && $valor!=$permitidosjpg){
            $correcto=false;
            break;
        }
    }
    if(!$correcto){
        $response["status"]  = "error";
        $response ["message"]= "Tipos De Arhivos comprobante de pago incorrecto O Limite Excedido Revise El Documento Nuevamente";
    }else{
        $extencionArchivo= explode("/", $_FILES["docComprobante"]['type'][0]);    
        $extencionArchivooriginal=$extencionArchivo[1];
        foreach($_FILES["docComprobante"]['tmp_name'] as $key => $tmp_name){
            if($_FILES["docComprobante"]["name"][$key]){
                $filename = $_FILES["docComprobante"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["docComprobante"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio = '../uploads/comprobantesPagoFiniquitos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos

                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
                }

                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'."Folio_".$numeroFolioSPF."_Comprobante_".$numeroFolioComprobantePago.".".$extencionArchivooriginal; 
                if(!move_uploaded_file($source, $target_path)) { 
                    $response["status"] = "error";
                    $response ["message"] = "Error al subir archivos De Vacaciones";
                    return;
                }
                closedir($dir); //Cerramos el directorio de destino
            }
        }
        if($response["status"] != "error"){        
            $sql = "SELECT idFiniquito
                FROM finiquitos
                WHERE folioSPF='$numeroFolioSPF'";

            $res = mysqli_query($conexion, $sql);
            while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                $listaIdFiniquitos[] = $reg;
            }

            $sql1 ="UPDATE finiquitos
                SET folioComprobante='$numeroFolioComprobantePago', 
                    fechaPagoComprobante=now(),
                    nameDocComprobante='$NombreTempArchivo',
                    estatusPagoFiniquito='5'
                WHERE folioSPF='$numeroFolioSPF'";
            $res = mysqli_query($conexion, $sql1);
            if ($res !== true) {
                $response["status"] = "error";
                $response["message"]='Error al subir archivos De Vacaciones';
                return;
            }else{
                for($b=0; $b < count($listaIdFiniquitos); $b++) { 
                    $idFiniquito= $listaIdFiniquitos[$b]["idFiniquito"];
                    $sql2 ="INSERT INTO historicomovimientosFiniquitosPago(idFiniquito,idEstatusActual,idEstatusNuevo,fechamovimiento,usuarioMovimiento) VALUES ($idFiniquito,'4','5',now(),'$usuario')";
                    $res2 = mysqli_query($conexion, $sql2);
                    if ($res2 !== true) {
                        $response["status"] = "error";
                        $response["message"]='Error al subir archivos De Vacaciones';
                        return;
                    }
                }
                $response ["message"] = "Archivo Subido Correctamente";
                $NombreTempArchivo ="Folio_".$numeroFolioSPF."_Comprobante_".$numeroFolioComprobantePago.".".$extencionArchivooriginal;
            }
        }    
    }
}catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo eliminar folio";
}
echo json_encode($response);
?>