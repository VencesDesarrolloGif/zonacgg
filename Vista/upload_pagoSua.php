<?php
session_start ();
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require "conexion.php";
require_once ("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion($negocio);
// $log = new KLogger ( "ajax_uploadSua.log" , KLogger::DEBUG ); 
// $log->LogInfo("Valor de la variable files: " . var_export ($_FILES, true));
// $log->LogInfo("Valor de la variable post: " . var_export ($_POST, true));
$response= array();
$datos   = array();
$datoslc = array();
$usuario = $_SESSION ["userLog"]["usuario"];
$registro=$_POST["registro"];
$mes =$_POST["mes"];
$anio=$_POST["anio"];
$caso=$_POST["caso"];
$idInput=$_POST["idInput"];
// $log->LogInfo("Valor de la variable caso " . var_export ($caso, true));
$response["status"] = "success";
$i=0;
// $i=$caso;
$permitidos = "application/pdf";
$permitidos1= "application/x-zip-compressed";
$permitidos2= "application/octet-stream";
$correcto=true;

// $num=count($_FILES["pagoSua"]['type']);

// for($a=0;$a<$num;$a++){
    $valor=$_FILES[$idInput]['type'][0];
    //$log->LogInfo("Valor de la variable tipo: " . var_export ($valor, true));
    if($valor!=$permitidos && $valor!=$permitidos1 && $valor!=$permitidos2){
        $correcto=false;
    }
// }

if(!$correcto){
    $response["status"]  = "error";
    $response ["message"]= "Tipos de arhivos incorrecto o limite excedido";
}else{
    $hoy = getdate();
    foreach($_FILES[$idInput]['tmp_name'] as $key => $tmp_name){

        if($_FILES[$idInput]["name"][$key]) {
            $filename = $_FILES[$idInput]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES[$idInput]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
            $directorio = "uploads/documentosContabilidad/pagoSua/".$registro.$mes.$anio."/"; //Declaramos un  variable con la ruta donde guardaremos los archivos

            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }

            if($_FILES[$idInput]['type'][0]== $permitidos){
                $extencion = ".pdf";
            }else if($_FILES[$idInput]['type'][0]== $permitidos1){
                $extencion = ".zip";
            }else if($_FILES[$idInput]['type'][0]== $permitidos2){
                $extencion = ".rar";
            }

            $dir=opendir($directorio); //Abrimos el directorio de destino

            if($caso==0){
                $nombrearchivo='Imss'.$extencion;
            }else if($caso==1){
                $nombrearchivo='Infonavit'.$extencion;
            }else if($caso==2){
                    $nombrearchivo='Pago'.$extencion;
            }else if($caso==3){ //punto sua

                $sql = "SELECT ifnull(count(idPuntoSUA),0) as existeDoc,idPuntoSUA
                        FROM catalogoPuntoSUA
                        WHERE regPatronalPuntoSUA='$registro'
                        AND anioPuntoSUA='$anio'
                        AND mesPuntoSUA='$mes'";      
    
                        $res = mysqli_query($conexion, $sql);
                        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                            $datos[] = $reg;
                        }

                    // $nombrearchivo='PuntoSUA.zip';
                    $nombrearchivo="PuntoSUA.SUA";

                    $existeDoc = $datos[0]["existeDoc"]; 

                    if ($existeDoc!='0' && $existeDoc!='null' && $existeDoc!='NULL' && $existeDoc!=null && $existeDoc!=NULL && $existeDoc!='') {
                        $idPSUA = $datos[0]["idPuntoSUA"]; 
                        $sql1 = "UPDATE catalogoPuntoSUA SET fechaEditPuntoSUA=now(),USReditaPuntoSUA='$usuario'
                                 WHERE idPuntoSUA='$idPSUA'";
                    }else{
                        $sql1 = "INSERT INTO catalogoPuntoSUA(nombreDocPuntoSUA,regPatronalPuntoSUA,mesPuntoSUA,anioPuntoSUA,fechaCargaPuntoSUA,estatusDocPuntoSUA,USRCargaPuntoSUA)
                            VALUES('$nombrearchivo','$registro','$mes','$anio',now(),'1','$usuario')";
                    }
                    
                    $res1 = mysqli_query($conexion, $sql1);

                    if($res1 !== true){
                       $response["status"] ="error";
                       $response["mensaje"]="error al guardar Documento Punto SUA";
                    }else{
                          $response["mensaje"]= "Archivo Subido Correctamente";
                          $response["status"] = "success";
                    }
            }else if($caso==4){//linea de captura

                $sqllc = "SELECT ifnull(count(idLineaCapturaSUA),0) as existeDocLC,idLineaCapturaSUA
                          FROM catalogoLineaCapturaSUA
                          WHERE regPatronalLineaCapturaSUA='$registro'
                          AND anioLineaCapturaSUA='$anio'
                          AND mesLineaCapturaSUA='$mes'";      
    
                        $reslc = mysqli_query($conexion, $sqllc);
                        while (($reglc = mysqli_fetch_array($reslc, MYSQLI_ASSOC))){
                            $datoslc[] = $reglc;
                        }

                    $nombrearchivo='LineaCaptura'.$extencion;

                    $existeDocLC = $datoslc[0]["existeDocLC"]; 

                    if ($existeDocLC!='0' && $existeDocLC!='null' && $existeDocLC!='NULL' && $existeDocLC!=null && $existeDocLC!=NULL && $existeDocLC!='') {
                        $idLineaCaptura = $datoslc[0]["idLineaCapturaSUA"]; 
                        $sql2 = "UPDATE catalogoLineaCapturaSUA SET fechaEditLineaCapturaSUA=now(),USReditaLineaCapturaSUA='$usuario'
                                 WHERE idLineaCapturaSUA='$idLineaCaptura'";
                    }else{
                          $sql2 = "INSERT INTO catalogoLineaCapturaSUA(nombreDocLineaCapturaSUA,regPatronalLineaCapturaSUA,mesLineaCapturaSUA,anioLineaCapturaSUA,fechaCargaLineaCapturaSUA,estatusDocLineaCapturaSUA,USRCargaLineaCapturaSUA)
                             VALUES('$nombrearchivo','$registro','$mes','$anio',now(),'1','$usuario')";
                    }
                    
                    $res1 = mysqli_query($conexion, $sql2);

                    if($res1 !== true){
                       $response["status"] ="error";
                       $response["mensaje"]="error al guardar Documento Punto SUA";
                    }else{
                          $response["mensaje"]= "Archivo Subido Correctamente";
                          $response["status"] = "success";
                    }
            }else if($caso==5){//resumen de liquidacion

                $sqlrl = "SELECT ifnull(count(idresumenLiquidacion),0) as existeDocRL,idresumenLiquidacion
                          FROM resumenLiquidacion
                          WHERE regPatronalresumenLiquidacion='$registro'
                          AND anioresumenLiquidacion='$anio'
                          AND mesresumenLiquidacion='$mes'";      
    
                        $resrl = mysqli_query($conexion, $sqlrl);
                        while(($regrl = mysqli_fetch_array($resrl, MYSQLI_ASSOC))){
                            $datosrl[] = $regrl;
                        }

                    $nombrearchivo='ResumenLiquidacion'.$extencion;

                    $existeDocRL = $datosrl[0]["existeDocRL"]; 

                    if ($existeDocRL!='0' && $existeDocRL!='null' && $existeDocRL!='NULL' && $existeDocRL!=null && $existeDocRL!=NULL && $existeDocRL!='') {
                        $idResumenL = $datosrl[0]["idresumenLiquidacion"]; 
                        $sql21 = "UPDATE resumenLiquidacion SET fechaEditresumenLiquidacion=now(),USReditaresumenLiquidacion='$usuario'
                                 WHERE idresumenLiquidacion='$idResumenL'";
                    }else{
                          $sql21 = "INSERT INTO resumenLiquidacion(nombreDocresumenLiquidacion,regPatronalresumenLiquidacion,mesresumenLiquidacion,anioresumenLiquidacion,fechaCargaresumenLiquidacion,estatusDocresumenLiquidacion,USRCargaresumenLiquidacion)
                             VALUES('$nombrearchivo','$registro','$mes','$anio',now(),'1','$usuario')";
                    }
                    // $log->LogInfo("Valor de la variable sql21 " . var_export ($sql21, true));
                    
                    $resrl2 = mysqli_query($conexion, $sql21);

                    if($resrl2 !== true){
                       $response["status"] ="error";
                       $response["mensaje"]="error al guardar Documento resumen liquidacion";
                    }else{
                          $response["mensaje"]= "Archivo Subido Correctamente";
                          $response["status"] = "success";
                    }
            }

            $target_path = $directorio.'/'.$nombrearchivo; //Indicamos la ruta de destino, así como el nombre del archivo
            $i++;

            if(!move_uploaded_file($source, $target_path)) { 
                $response["status"] = "error";
                $response["message"]= "Error al subir archivos";
            }
            closedir($dir);//Cerramos el directorio de destino
        }
    }
}
if( $response["status"] =='success'){
    $response["message"] ='Archivos subidos correctamente';
}

echo json_encode($response);

?> 