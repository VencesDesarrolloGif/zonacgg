<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_insertarTarjetaPatronal.log" , KLogger::DEBUG );
$response= array();
$datos   = array();
$FechaExpedicionAdd = $_POST['FechaExpedicionAdd'];
$FechaFinVigenciaAdd= $_POST['FechaFinVigenciaAdd'];
$registroPatronal   = $_POST['registroPatronal'];
$idTarjetaActiva    = $_POST['idTarjetaActiva'];
$caso = $_POST['caso'];
$valor=$_FILES["documentoCargadoTarjetaPatronalAdd"]['type'][0];
$permitidospdf= "application/pdf";
$permitidos1  = "image/jpeg";
$permitidos2  = "image/png";
$correcto=true;
$usuario =$_SESSION['userLog'];
 // $log->LogInfo("Valor de variable _SESSION" . var_export ($_SESSION, true));

if($caso=='2') {
   $comentario = $_POST['comentario'];
}
try {

    $sql1="SELECT ifnull(max(idTarjetasPatronales)+1,1) as ultimoID 
            FROM catalogotarjetaspatronales";

            $res1 = mysqli_query($conexion, $sql1);

            while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                    $datos[] = $reg1;
                 }
    
    $idTarjetaPatronal=$datos[0]["ultimoID"];

    if($valor!=$permitidospdf && $valor!=$permitidos1 && $valor!=$permitidos2){
       $correcto=false;
    }

    if(!$correcto){
        $response["status"]  = "error";
        $response ["mensaje"]= "Tipos De Arhivo Incorrecto O Limite Excedido Revise El Documento Nuevamente";
        return;
    }else{
        $extencionArchivo= explode("/", $_FILES["documentoCargadoTarjetaPatronalAdd"]['type'][0]);    
        $extencionArchivooriginal=$extencionArchivo[1];
    }

    foreach($_FILES["documentoCargadoTarjetaPatronalAdd"]['tmp_name'] as $key => $tmp_name){ 
          
           if($_FILES["documentoCargadoTarjetaPatronalAdd"]["name"][$key]) {
              $source = $_FILES["documentoCargadoTarjetaPatronalAdd"]["tmp_name"][$key]; 

                 $directorio='../../vista/uploads/TarjetaPatronal/'; 

              if(!file_exists($directorio)){
                  mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
              }
                
              $nombreDoc=$registroPatronal."_".$idTarjetaPatronal.".".$extencionArchivooriginal;

              $dir=opendir($directorio);
              $target_path=$directorio.'/'.$nombreDoc; 
              
              if(!move_uploaded_file($source, $target_path)){ 
                  $response["status"]  = "error";
                  $response ["mensaje"]= "Error al subir archivo SAT";
                  return;
              }
             closedir($dir); //Cerramos el directorio de destino
            }
    }//termina foreach


    $sql="INSERT INTO catalogotarjetaspatronales(registroPatronalTarjeta,fechaExpedicion,fechaFinVigencia,fechaCargaTarjetaPatronal,nombreDocumento,estatusEliminadoTarjetasPatronales,usuarioCreacion";

        if ($caso=='2') {
            $sql.=",comentarioEdicion";
        }
          $sql.=")VALUES ('$registroPatronal','$FechaExpedicionAdd','$FechaFinVigenciaAdd' , now(), '$nombreDoc','0','$usuario'";

        if ($caso=='2') {
            $sql.=",'$comentario'";
        }

        $sql.=")";

        $res = mysqli_query($conexion, $sql);

        if($res !== true) {
           $response["mensaje"]= 'error al insertar documento';
           $response["status"] = "error";
           return;
        }else{
             $response["status"] = "success";
             $response["mensaje"]= 'Se inserto Correctamente';
        }

    if($caso==2){
        $sql2="UPDATE catalogotarjetaspatronales 
               SET estatusEliminadoTarjetasPatronales ='1', fechaEliminacionTarjetasPatronales=now(), comentarioEdicion='eliminado por creación de tarjeta patronal', usuarioEdit='$usuario'
               WHERE idTarjetasPatronales = '$idTarjetaActiva'";

        $res2 = mysqli_query($conexion, $sql2);

        if($res2 !== true) {
           $response["mensaje"]= "error al actualizar tarjeta patronal";
           $response["status"] = "error";
           return;
        }else{
              $response["status"] = "success";
              $response["mensaje"]= "INFORMACIÓN GUARDADA CORRECTAMENTE";
             }  
    }
         
}catch(Exception $e) {
       $response["mensaje"] = "Error al insertar tarjeta patronal";
       $response["status"] = "error";
}
echo json_encode($response);