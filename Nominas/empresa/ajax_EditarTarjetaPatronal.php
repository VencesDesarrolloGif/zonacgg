<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ("ajax_EditarTarjetaPatronal.log" , KLogger::DEBUG);
$response = array();
$fechaExpedicion  = $_POST["fechaExpedicion"];
$fechaFinVigencia = $_POST["fechaFinVigencia"];
$registroPatronal = $_POST["registroPatronal"];
$idTPEdit   = $_POST["idTPEdit"];
$tipoEdicion= $_POST["tipoEdicion"];
$caso = $_POST["caso"];
$usuario =$_SESSION['userLog'];

if($tipoEdicion=='2'){
   $comentario     = $_POST["comentario"];
   $idTarjetaActiva= $_POST["idTarjetaActiva"];
}

if($caso==1){//cuando carga un documento
   $valor=$_FILES["documentoCargadoTarjetaPatronal"]['type'][0];
   $permitidospdf = "application/pdf";
   $permitidos1 = "image/jpeg";
   $permitidos2 = "image/png";
   $correcto=true;
    // $log->LogInfo("Valor de variable valor" . var_export ($valor, true));
    
    if($valor!=$permitidospdf && $valor!=$permitidos1 && $valor!=$permitidos2){
       $correcto=false;
    }
    
    if(!$correcto){
        $response["status"]  = "error";
        $response ["mensaje"]= "Tipos De Arhivo Incorrecto O Limite Excedido Revise El Documento Nuevamente";
        return;
    }else{
        $extencionArchivo= explode("/", $_FILES["documentoCargadoTarjetaPatronal"]["type"][0]);    
        $extencionArchivooriginal=$extencionArchivo[1];
        $nombreDoc = $registroPatronal."_".$idTPEdit.".".$extencionArchivooriginal;
    }

    foreach($_FILES["documentoCargadoTarjetaPatronal"]["tmp_name"] as $key => $tmp_name){ 
        
        if($_FILES["documentoCargadoTarjetaPatronal"]["name"][$key]){
           $source = $_FILES["documentoCargadoTarjetaPatronal"]["tmp_name"][$key]; 
           $directorio="../../vista/uploads/TarjetaPatronal/"; 

           if(!file_exists($directorio)){
              mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
           }
           $dir = opendir($directorio);
           $target_path=$directorio."/".$nombreDoc; 
           
           if(!move_uploaded_file($source, $target_path)){ 
              $response["status"]  = "error";
              $response ["mensaje"]= "Error al subir archivo SAT";
              return;
           }
          closedir($dir); //Cerramos el directorio de destino
        }
    }//termina foreach
}
    $sql="UPDATE catalogotarjetaspatronales 
          SET fechaExpedicion ='$fechaExpedicion',
              fechaFinVigencia='$fechaFinVigencia',
              fechaEdicionTarjetaPatronal=now(),
              usuarioEdit='$usuario'";

              if($caso==1){
                 $sql.=" ,nombreDocumento='$nombreDoc'";
              }
              if($tipoEdicion==2){
                 $sql.=" ,comentarioEdicion='$comentario'";
              }

        $sql.=" WHERE idTarjetasPatronales = '$idTPEdit'";
        // $log->LogInfo("Valor de variable $sql" . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);

        if ($res !== true) {
            $response["mensaje"]= "error al eliminar documento";
            $response["status"] = "error";
            return;
        }else{
             $response["status"] = "success";
             $response["mensaje"]= "INFORMACIÓN GUARDADA CORRECTAMENTE";
         }

         if($tipoEdicion==2) {

            $sql1="UPDATE catalogotarjetaspatronales 
                   SET estatusEliminadoTarjetasPatronales ='1',comentarioEdicion='eliminado por actualizacion de tarjeta patronal',usuarioEdit='$usuario',fechaEliminacionTarjetasPatronales=now()
                   WHERE idTarjetasPatronales = '$idTarjetaActiva'";

                $res1 = mysqli_query($conexion, $sql1);

                  if($res1 !== true) {
                      $response["mensaje"]= "error al actualizar tarjeta patronal";
                      $response["status"] = "error";
                      return;
                  }else{
                       $response["status"] = "success";
                       $response["mensaje"]= "INFORMACIÓN GUARDADA CORRECTAMENTE";
                  }
         }
//$log->LogInfo("Valor de variable $response" . var_export ($response, true));
echo json_encode($response);