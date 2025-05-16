<?php
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$response           = array();
$response["status"] = "error";
$Fecha              = $_POST['fecha'];
$Movimiento         = $_POST['movimiento'];

try {
    $sql = "DELETE FROM diasfestivos
             where fechaDiaFestivo = '$Fecha'
             and motivoDiaFestivo = '$Movimiento'"; 
             $res = mysqli_query($conexion, $sql);
             $response["status"] = "success";

   }catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";
    }
echo json_encode($response);