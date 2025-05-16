<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
include '../../simple/simplexlsx.class.php';
require "../conexion.php";
// $log = new KLogger ( "ajax_insertarsucursal.log" , KLogger::DEBUG );
$response = array ();
$datos = array ();
$response["status"] = "success";
$entidad =$_POST["entidad"];
$sucursal=$_POST["sucursalNueva"];
$usuario = $_SESSION ["userLog"]["usuario"];

    try{
        $sql = "INSERT INTO sucursalesInternas(idEntidadPerteneciente,nombreSucursal,usuarioCreacion,fechaCreacion,estatusSucursalI)
                VALUES('$entidad','$sucursal','$usuario',now(),'1')";

        $res = mysqli_query($conexion, $sql);

        if ($res !== true) {
            $response["status"] = "error";
            $response["mensaje"]='error al guardar nueva sucursal ';
            return;
        }else{
            $response["mensaje"]='Sucursal agregada correctamente';
        }

    }catch(PDOException $e){
        $response["status"] = "error";
        $response["mensaje"]= "error de conexion a la BD";
    }

    
echo json_encode ($response);
