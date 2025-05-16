<?php
session_start();
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajaxeliminarTarjetaPatronal.log" , KLogger::DEBUG );
$response = array();
$idTP = $_POST['idTP'];
$usuario =$_SESSION['userLog'];

try {
     $sql="UPDATE catalogotarjetaspatronales 
           SET estatusEliminadoTarjetasPatronales='1',fechaEliminacionTarjetasPatronales=now(),usuarioEdit='$usuario'
           WHERE idTarjetasPatronales = '$idTP'";

// $log->LogInfo("Valor de variable sql" . var_export ($sql, true));

        $res = mysqli_query($conexion, $sql);

        if ($res !== true) {
            $response["mensaje"]= 'error al eliminar documento';
            $response["status"] = "error";
            return;
        }else{
             $response["status"] = "success";
             $response["mensaje"]= 'Se Eliminó Correctamente';
         }
         
   }catch(Exception $e) {
          $response["mensaje"] = "Error al eliminar tarjeta patronal";
          $response["status"] = "error";
    }
echo json_encode($response);