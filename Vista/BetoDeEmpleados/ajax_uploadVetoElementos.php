<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
//$log = new KLogger ( "ajax_uploadICSOE.log" , KLogger::DEBUG );
$response= array();
$NumeroEmpleado     = $_POST["NumeroEmpleado"];
$empleadoIdd = explode("-", $NumeroEmpleado);
$entidadFederativaId=$empleadoIdd[0];
$empleadoConsecutivoId=$empleadoIdd[1];
$empleadoCategoriaId=$empleadoIdd[2];
$NombrEmpelado      = $_POST["NombrEmpelado"];
$ComentarioVeto     = $_POST["ComentarioVeto"];
$archivoVeto        = $_POST["archivoVeto"];
$ComentarioArchivo  = $_POST["ComentarioArchivo"];
$Condicion          = $_POST["Condicion"];
$response["status"] = "success";
$permitidos         = "application/pdf";
$permitidos1        = "image/jpeg";
$permitidos2        = "image/png";
$usuarioCaptura     =$_SESSION ["userLog"]["usuario"];
$correcto=true;
//$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable _SESSION: " . var_export ($_SESSION, true));
//$log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));

$valor=$_FILES["archivoVetoEmpleado"]['type'][0];
//$log->LogInfo("Valor de la variable valor: " . var_export ($valor, true));
if($Condicion== "1"){

    if($valor!=$permitidos && $valor!=$permitidos1 && $valor!=$permitidos2){
        $correcto=false;
    }
    if(!$correcto){
            $response["status"] = "error";
            $response["message"]= "Tipo de arhivo incorrecto";
    }else{
        $hoy = getdate();
        foreach($_FILES["archivoVetoEmpleado"]['tmp_name'] as $key => $tmp_name){
            if($_FILES["archivoVetoEmpleado"]["name"][$key]){
                $filename  = $_FILES["archivoVetoEmpleado"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source    = $_FILES["archivoVetoEmpleado"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
                $directorio= "../uploads/ArchivosElementosVetados/"; //Declaramos un  variable con la ruta donde guardaremos los archivos
    
                if(!file_exists($directorio)){
                   mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
                }
                $dir=opendir($directorio); //Abrimos el directorio de destino
                //$log->LogInfo("Valor de la variable valor: " . var_export ($valor, true));
                $ExtencionLargo = explode("/", $_FILES["archivoVetoEmpleado"]["type"][0]);
                $Extencion= $ExtencionLargo[1];
                $nombrearchivo="Vetado_".$NumeroEmpleado;
                $target_path = $directorio.'/'.$nombrearchivo; //Indicamos la ruta de destino, así como el nombre del archivo
                if(!move_uploaded_file($source, $target_path)){ 
                    $response["status"] = "error";
                    $response["message"]= "Error al subir archivos";
                }
                closedir($dir);//Cerramos el directorio de destino
            }
        }
    }
    $ComentarioArchivo = "";
}else{
    $Extencion ="";
    $nombrearchivo="";
}

    $sql1= "INSERT INTO VetoEmpledos (EntidadVetoEMp, ConsecutivoVetoEMp, CategoriaVetoEMp, RutaArchivoVetoEMp, ExtencionVetoEMp, ComentarioVetoEmp, UsuarioVetoEMp, FechacreacionVetoEMp, ProcedenciaVetoEmp)
           VALUES('$entidadFederativaId','$empleadoConsecutivoId','$empleadoCategoriaId','$nombrearchivo','$Extencion','$ComentarioArchivo','$usuarioCaptura',now(),'Laborales')";      
    $res = mysqli_query($conexion, $sql1);
       //$log->LogInfo("Ejecutando consulta  sql1: " . $sql1);
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='Ocurrio un error al registrar el veto';
        return;
    }else{
        $response ["status"] = "success";
        $response ["message"] = "Empleado Vetado éxitosamente";
    }
    $sql = "UPDATE empleados set EstatusReingreso='0',MotivoReingreso='$ComentarioVeto'
            where entidadFederativaId='$entidadFederativaId' 
            and empleadoConsecutivoId='$empleadoConsecutivoId' 
            and empleadoCategoriaId='$empleadoCategoriaId'";
    //$log->LogInfo("Ejecutando consulta  sql: " . $sql);
    $res = mysqli_query($conexion, $sql);  
    if ($res !== true) {
        $response["status"] = "error";
        $response["message"]='Ocurrio Un Error Al Vetar Al Elemento.';
        return;
    }else{
        $response ["status"] = "success";
        $response ["message"] = "Empleado registrado éxitosamente";
    }

if( $response["status"] =='success'){
    $response["message"]='Empleado Vetado Exitosamente';
}

echo json_encode($response);
?> 