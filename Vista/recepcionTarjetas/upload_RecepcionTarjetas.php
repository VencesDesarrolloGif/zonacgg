<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
$log = new KLogger ( "ajax_RecepcionTarjetas.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));
// $log->LogInfo("Valor de la variable sql: " . $sql);
$response= array();
$datos4  = array();
$datos5  = array();
$datos7  = array();//para errores
$datos9  = array();//para errores
$response["status"] = "success";
$usuario   =$_SESSION ["userLog"]["usuario"];
$noPedido  =$_POST["txtNoPedido"];
$matriz    =$_POST["selectMatrizRecepcion"];
$noEmpleado=$_POST["noEmpleado"];
$fechaRecepcion=$_POST["inpFechaRecep"];
$firmaEmpleado =$_POST["firmaEmpleado"];
$nombreDocExcel='pedido_'.$noPedido.".xlsx";

if($_FILES["documentoDePedido"]["type"][0]=="image/png"){
   $nombreHojaPedido='hojaPedido_'.$noPedido.".png";
}

if($_FILES["documentoDePedido"]["type"][0]=="image/jpeg"){
   $nombreHojaPedido='hojaPedido_'.$noPedido.".jpeg";
}

if($_FILES["documentoDePedido"]["type"][0]=="application/pdf"){
   $nombreHojaPedido='hojaPedido_'.$noPedido.".pdf";
}

$sql = "insert into archivosExcelTarjetas(nombreArchivo, FechaCargaArchivo) 
        values ('$nombreDocExcel', now())";
    $res = mysqli_query($conexion, $sql); 
    
if($res !== true){
   $response["status"] ="error";
   $response["mensaje"]='error al guardar el archivo Excel';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
   return;
}else{

    foreach($_FILES["excelTarjetas"]['tmp_name'] as $key => $tmp_name){
       
        if($_FILES["excelTarjetas"]["name"][$key]){
            $filename= $_FILES["excelTarjetas"]["name"][$key]; 
            $source  = $_FILES["excelTarjetas"]["tmp_name"][$key];      
            $directorio= "../uploads/ExcelTarjetas/";
    
            if(!file_exists($directorio)){
               mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");     
            }

            $dir = opendir($directorio); //Abrimos el directorio de destino
            $target_path = $directorio.'/'.$nombreDocExcel; //Indicamos la ruta de destino, así como el nombre del archivo
    
            if(!move_uploaded_file($source, $target_path)){ 
               $response["status"] = "error";
               $response["mensaje"]= "Error al guardar excel en carpeta";

                $sql7 = "SELECT max(idArchivosExcelTarjeta) as idInsertado
                         FROM archivosexceltarjetas";

                $res7=mysqli_query($conexion, $sql7);
                        while(($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))){
                             $datos7[] = $reg7;
                        }
                if(count($datos7) == '' || count($datos7) == '0'){
                   $response["status"] ="error";
                   $response["mensaje"]='error al consultar maxid archivo excel carpeta';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
                   return;
                }else{
                      $idInsertadoExcel = $datos7[0]["idInsertado"]; 
                      $sql8 = "delete from archivosExcelTarjetas
                               where idArchivosExcelTarjeta='$idInsertadoExcel'";
     
                      $res8 = mysqli_query($conexion, $sql8);
                }
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
            return;
            }//ifmove
          closedir($dir);//Cerramos el directorio de destino
      }//if FILES
    }//foreach
}//else guardar excel

//AQUI SE GUARDA LA INFO DE LA HOJA DE PEDIDO/////////////////////////

$sql2 = "insert into hojaPedido(nombreDocHojaPed,FechaCargaDocHojaPed) 
         values ('$nombreHojaPedido',now())";

$res2 = mysqli_query($conexion, $sql2);  
    
if($res2 !== true){
   $response["status"] ="error";
   $response["mensaje"]='error al insertar hoja de pedido';
   unlink($directorio.'/'.$nombreDocExcel);//eliminados el documento excel creado arriba

    $sql7 = "SELECT max(idArchivosExcelTarjeta) as idInsertado
             FROM archivosexceltarjetas";

    $res7=mysqli_query($conexion, $sql7);
    while(($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))){
           $datos7[] = $reg7;
    }
        
    if(count($datos7) == '' || count($datos7) == '0'){
       $response["status"] ="error";
       $response["mensaje"]='error al consultar maxid archivo excel bd hoja pedido';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
       return;
    }else{
         $idInsertadoExcel = $datos7[0]["idInsertado"]; 
       
         $sql8 = "delete from archivosExcelTarjetas
                  where idArchivosExcelTarjeta='$idInsertadoExcel'";

         $res8 = mysqli_query($conexion, $sql8);
    }
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
  return;
}
else{
    foreach($_FILES["documentoDePedido"]['tmp_name'] as $key => $tmp_name){
        
        if($_FILES["documentoDePedido"]["name"][$key]){
           $filename  = $_FILES["documentoDePedido"]["name"][$key]; //Obtenemos el nombre original del archivo
           $sourcehp    = $_FILES["documentoDePedido"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo          
           $directoriohp= "../uploads/HojasPedidoTarjetas/"; //Declaramos un  variable con la ruta donde guardaremos los archivos

           if(!file_exists($directoriohp)){
              mkdir($directoriohp, 0777) or die("No se puede crear el directoriohp de extracci&oacute;n");     
           }
           $dir=opendir($directoriohp); //Abrimos el directoriohp de destino
           $target_path = $directoriohp.'/'.$nombreHojaPedido; //Indicamos la ruta de destino, así como el nombre del archivo

            if(!move_uploaded_file($sourcehp, $target_path)){ 
                $response["status"] = "error";
                $response["mensaje"]= "Error al guardar hoja de pedido en carpeta";
                unlink($directorio.'/'.$nombreDocExcel);//eliminados el documento excel creado arriba

                $sql7 = "SELECT max(idArchivosExcelTarjeta) as idInsertado
                         FROM archivosexceltarjetas";

                $res7=mysqli_query($conexion, $sql7);
                    while(($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))){
                           $datos7[] = $reg7;
                    }
                   
                if(count($datos7) == '' || count($datos7) == '0'){
                  $response["status"] ="error";
                  $response["mensaje"]='error al consultar maxid archivo excel en carpeta hoja pedido';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
                  return;
                }else{
                    $idInsertadoExcel = $datos7[0]["idInsertado"]; 
                      
                    $sql8 = "delete from archivosExcelTarjetas
                             where idArchivosExcelTarjeta='$idInsertadoExcel'";
                    $res8 = mysqli_query($conexion, $sql8);
                }
                //borrar tambien el pedido
                $sql9= "SELECT max(idHojaPedido) as idHojaPedidoInsertado
                         FROM hojapedido";
                        
                        $res9=mysqli_query($conexion, $sql9);
                        while(($reg9 = mysqli_fetch_array($res9, MYSQLI_ASSOC))){
                               $datos9[] = $reg9;
                        }

                if(count($datos9) == '' || count($datos9) == '0'){
                    $response["status"] ="error";
                    $response["mensaje"]='error al consultar maxid hojapedido en carpeta hojaPedido';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
                    return;
                }else{//eliminar de la bd info de la hoja de pedido
                      $idInsertadoHP = $datos9[0]["idHojaPedidoInsertado"]; 
                      $sql10 = "delete from hojapedido
                                where idHojaPedido='$idInsertadoHP'";
                      $res10 = mysqli_query($conexion, $sql10);
                }
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
                return;
            }//if move ERROR
          closedir($dir);//Cerramos el directoriohp de destino
        }//IF FILES
    }//foreach
}//else

$sql4= "SELECT ifnull(max(idArchivosExcelTarjeta),0) as idExcel
        FROM archivosexceltarjetas";

        $res4 = mysqli_query($conexion, $sql4);
        while(($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
            $datos4[] = $reg4;
        }  

if(count($datos4) == '' || count($datos4) == '0'){
   $response["status"] ="error";
   $response["mensaje"]='error al consultar id de archivo excel';
   unlink($directorio.'/'.$nombreDocExcel);//eliminados el documento excel creado arriba

    $sql7 = "SELECT max(idArchivosExcelTarjeta) as idInsertado
             FROM archivosexceltarjetas";

    $res7=mysqli_query($conexion, $sql7);
        while(($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))){
               $datos7[] = $reg7;
        }
       
    if(count($datos7) == '' || count($datos7) == '0'){
      $response["status"] ="error";
      $response["mensaje"]='error al consultar maxid archivo excel4';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
      return;
    }else{
        $idInsertadoExcel = $datos7[0]["idInsertado"]; 
          
        $sql8 = "delete from archivosExcelTarjetas
                 where idArchivosExcelTarjeta='$idInsertadoExcel'";
        $res8 = mysqli_query($conexion, $sql8);
    }
    //borrar tambien el pedido
    $sql9= "SELECT max(idHojaPedido) as idHojaPedidoInsertado
             FROM hojapedido";
            
    $res9=mysqli_query($conexion, $sql9);
        while(($reg9 = mysqli_fetch_array($res9, MYSQLI_ASSOC))){
               $datos9[] = $reg9;
        }

    if(count($datos9) == '' || count($datos9) == '0'){
        $response["status"] ="error";
        $response["mensaje"]='error al consultar maxid hojapedido en DOC hojaPedido4';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
        return;
    }else{//eliminar de la bd info de la hoja de pedido
            $idInsertadoHP = $datos9[0]["idHojaPedidoInsertado"]; 
            $sql10 = "delete from hojapedido
                      where idHojaPedido='$idInsertadoHP'";
            $res10 = mysqli_query($conexion, $sql10);
         }
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
  return;
}
else{
    $sql5 = "SELECT ifnull(max(idHojaPedido),0) as idPedido
             FROM hojapedido";

    $res5 = mysqli_query($conexion, $sql5);
        while (($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC))){
               $datos5[] = $reg5;
       }

    if(count($datos5) == '' || count($datos5) == '0'){
        $response["status"] ="error";
        $response["mensaje"]='error consultar id de archivo pedido';
        unlink($directorio.'/'.$nombreDocExcel);//eliminados el documento excel creado arriba
        unlink($directoriohp.'/'.$nombreHojaPedido);//eliminados el documento excel creado arriba

        $sql7 = "SELECT max(idArchivosExcelTarjeta) as idInsertado
                 FROM archivosexceltarjetas";

        $res7=mysqli_query($conexion, $sql7);
        while(($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC))){
               $datos7[] = $reg7;
        }
                   
        if(count($datos7) == '' || count($datos7) == '0'){
          $response["status"] ="error";
          $response["mensaje"]='error al consultar maxid archivo excel5';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
          return;
        }else{
            $idInsertadoExcel = $datos7[0]["idInsertado"]; 
              
            $sql8 = "delete from archivosExcelTarjetas
                     where idArchivosExcelTarjeta='$idInsertadoExcel'";
            $res8 = mysqli_query($conexion, $sql8);
        }
        //borrar tambien el pedido
        $sql9= "SELECT max(idHojaPedido) as idHojaPedidoInsertado
                 FROM hojapedido";
                
                $res9=mysqli_query($conexion, $sql9);
                while(($reg9 = mysqli_fetch_array($res9, MYSQLI_ASSOC))){
                       $datos9[] = $reg9;
                }

        if(count($datos9) == '' || count($datos9) == '0'){
            $response["status"] ="error";
            $response["mensaje"]='error al consultar maxid hojapedido en DOC hojaPedido5';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
            return;
        }else{//eliminar de la bd info de la hoja de pedido
                $idInsertadoHP = $datos9[0]["idHojaPedidoInsertado"]; 
                $sql10 = "delete from hojapedido
                          where idHojaPedido='$idInsertadoHP'";
                $res10 = mysqli_query($conexion, $sql10);
               }
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
      return;
    }else{
        $idExcel = $datos4[0]["idExcel"]; 
        $idHojaPedido = $datos5[0]["idPedido"]; 
             
        $sql6 = "insert into pedidotarjetas(NumeroPedido, IDMatrizEntrega,idArchivoExcel,idHojaPedido, FechaEntrega, usuarioRegistro,FechaRegistro,NumeroEmpFirmaPedido,ContraseniaEmpFirmaPedido) 
                 values ('$noPedido','$matriz','$idExcel','$idHojaPedido','$fechaRecepcion','$usuario',now(),'$noEmpleado',MD5('$firmaEmpleado'))";
$log->LogInfo("Valor de la variable sql6: " . $sql6);
            
                $res6 = mysqli_query($conexion, $sql6);  

             if($res6 !== true){
                $response["status"] ="error";
                $response["mensaje"]='error al insertar pedido';
$log->LogInfo("Valor de la variable response: " . var_export ($response, true));
                return;
             }
    }
}  
echo json_encode($response);
?> 