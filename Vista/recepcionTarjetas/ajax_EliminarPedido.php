<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger ( "ajax_EliminarPedido.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable pedidoExist: " . var_export ($pedidoExist, true));
$response= array();
$datos= array();
$datosExcel= array();
$datosHp= array();
$response["status"] = "success";
$pedido=$_POST["pedido"];
$directorio= "../uploads/ExcelTarjetas/";
$directoriohp= "../uploads/HojasPedidoTarjetas/"; 
$nombreDocExcel='pedido_'.$pedido.".xlsx";
$nombreDocHP='hojaPedido_'.$pedido.".";

$sql= "SELECT pt.IdPedidoT,pt.idArchivoExcel,pt.idHojaPedido,hp.nombreDocHojaPed
       FROM pedidotarjetas pt
       LEFT JOIN hojapedido hp on (pt.idHojaPedido=hp.idHojaPedido)
       WHERE pt.NumeroPedido='$pedido'";   

     $res = mysqli_query($conexion, $sql);
         while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
             $datos[] = $reg;
         }  

 $pedidoExist=count($datos);
    if ($pedidoExist !='0'){
        
        $idPedido = $datos[0]["IdPedidoT"];
        
        $sql1= "DELETE FROM pedidotarjetas
                WHERE IdPedidoT='$idPedido'"; 

                $res1 = mysqli_query($conexion, $sql1);  

                if($res1 !== true){
                    $response["status"] ="error";
                    $response["mensaje"]='error en ajax_eliminarPedido,al eliminar pedido';
                    return;
                }else{
                    $response["status"] ="success";
                    $response["mensaje"]='pedido eliminado correctamente';   
                }
    }else{
        $response["status"] = "error";
        $response["mensaje"]='error en ajax_eliminarPedido, consultaPEDIDO';
    }  

$sql4= "SELECT idArchivosExcelTarjeta
        FROM archivosexceltarjetas
        where nombreArchivo= '$nombreDocExcel'";   

        $res4 = mysqli_query($conexion, $sql4);
            while(($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
                $datosExcel[] = $reg4;
        }

        $excelExist=count($datosExcel);

        if($excelExist == '0'){
           $response["status"] ="error";
           $response["mensaje"]='error en ajax_eliminarPedido,al consultar excel bd';
        }else{
            $idDocExcel  = $datosExcel[0]["idArchivosExcelTarjeta"];
            
            $sql2= "DELETE FROM archivosexceltarjetas
                    WHERE idArchivosExcelTarjeta='$idDocExcel'";

                    $res2 = mysqli_query($conexion, $sql2); 

                    if($res2 !== true){
                       $response["status"] ="error";
                       $response["mensaje"]='error en ajax_eliminarPedido,al eliminar de bd el excel';
                    }
        }

$sql5= "SELECT idHojaPedido,nombreDocHojaPed 
        FROM hojapedido
        WHERE nombreDocHojaPed LIKE '%$nombreDocHP%'";   
        

        $res5 = mysqli_query($conexion, $sql5);
            while(($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC))){
                $datosHp[] = $reg5;
        }

        $hojaPedidoExist=count($datosHp);

        if($hojaPedidoExist == '0'){
           $response["status"] ="error";
           $response["mensaje"]='error en ajax_eliminarPedido,al consultar hoja de pedido bd';
        }else{
            $idHojaPedido  = $datosHp[0]["idHojaPedido"];
            $nombreDocHPConExtension = $datosHp[0]["nombreDocHojaPed"];
            
            $sql6= "DELETE FROM hojapedido
                    WHERE idHojaPedido='$idHojaPedido'";
                    $res6 = mysqli_query($conexion, $sql6); 

                    if($res6 !== true){
                        $response["status"] ="error";
                        $response["mensaje"]='error en ajax_eliminarPedido,al eliminar de bd hoja de pedido';
                        return;
                    }else{
                        unlink($directorio.'/'.$nombreDocExcel);//eliminados el documento excel creado arriba
                        unlink($directoriohp.'/'.$nombreDocHPConExtension);//eliminados el documento excel creado arriba
                        $response["status"] = "success";
                        $response["mensaje"]= 'Se elimino correctamente todos los datos del pedido, debido a un error con el documento excel';
                    }
                }
if( $response["status"] =='success'){
    $response["mensaje"]='Archivos eliminados correctamente';
}

echo json_encode($response);
?> 