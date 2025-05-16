<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
include '../../simple/simplexlsx.class.php';
require "../conexion.php";
 // $log = new KLogger ( "ajax_ActivarSucursal.log" , KLogger::DEBUG );
$response = array ();
$datos = array ();
$response["status"] = "success";
$sucursal=$_POST["sucursal"];
$usuario = $_SESSION ["userLog"]["usuario"];

    try{
        $sql = "UPDATE sucursalesInternas
                SET usuarioEdit='$usuario', fechaEdit=now(),estatusSucursalI='1'
                WHERE idSucursalI='$sucursal'";

        $res = mysqli_query($conexion, $sql);

        if ($res !== true) {
            $response["status"] = "error";
            $response["mensaje"]='error al reactivar sucursal ';
            return;
        }else{
            $response["mensaje"]='Sucursal reactivada correctamente';
        }

    }catch(PDOException $e){
        $response["status"] = "error";
        $response["mensaje"]= "error de conexion a la BD";
    }

    
echo json_encode ($response);
