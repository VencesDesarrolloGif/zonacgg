<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
include '../../simple/simplexlsx.class.php';
require "../conexion.php";
// $log = new KLogger ( "ajax_insertarsucursal.log" , KLogger::DEBUG );
$response = array ();
$datos = array ();
$response["status"] = "success";
$sucursal=$_POST["sucursal"];
$usuario = $_SESSION ["userLog"]["usuario"];

    try{
        $sql = "UPDATE sucursalesInternas
                SET usuarioBaja='$usuario', fechaBaja=now(),estatusSucursalI='0'
                WHERE idSucursalI='$sucursal'";

        $res = mysqli_query($conexion, $sql);

        if ($res !== true) {
            $response["status"] = "error";
            $response["mensaje"]='error al dar de baja nueva sucursal ';
            return;
        }else{
            $response["mensaje"]='Sucursal dada de baja correctamente';
        }

    }catch(PDOException $e){
        $response["status"] = "error";
        $response["mensaje"]= "error de conexion a la BD";
    }

    
echo json_encode ($response);
