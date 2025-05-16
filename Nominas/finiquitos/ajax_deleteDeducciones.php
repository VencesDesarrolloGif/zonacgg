<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/phpmailer/class.phpmailer.php";
require_once "../../libs/logger/KLogger.php";
$response = array();
//$response["status"] = "error";
$numempleado    = $_POST["numempleado"];
$empleadoidd = explode("-", $numempleado);
/*
$entidademp     = substr($numempleado, 0, 2);
$consecutivoemp = substr($numempleado, 3, 4);
$categoriaemp   = substr($numempleado, 8, 2);

*/
    $entidademp=$empleadoidd[0];
    $consecutivoemp=$empleadoidd[1];
    $categoriaemp=$empleadoidd[2];  

$sql0 = "DELETE from infonavit_finiquito
where entidadEmpIF='$entidademp '
and consecutivoEmpIF='$consecutivoemp'
and categoriaEmpIF='$categoriaemp';";
$res0 = mysqli_query($conexion, $sql0);

$sql1 = "DELETE from prestamo_finiquito
where entidadEmpPF='$entidademp '
and consecutivoEmpPF='$consecutivoemp'
and categoriaEmpPF='$categoriaemp';";
$res1 = mysqli_query($conexion, $sql1);

$sql2 = "DELETE from fonacot_finiquito
where entidadEmpFF='$entidademp '
and consecutivoEmpFF='$consecutivoemp'
and categoriaEmpFF='$categoriaemp';";
$res2 = mysqli_query($conexion, $sql2);

$sql3 = "DELETE from pension_finiquito
where entidadEmpPeF='$entidademp '
and consecutivoEmpPeF='$consecutivoemp'
and categoriaEmpPeF='$categoriaemp';";
$res3 = mysqli_query($conexion, $sql3);

$sql4 = "DELETE from diastrabajados
where EntidadEmpDT='$entidademp '
and ConsecutivoEmpDT='$consecutivoemp'
and CategoriaEmpDT='$categoriaemp';";
$res4 = mysqli_query($conexion, $sql4);

$sql5 = "DELETE from uniformes_finiquitos
where entidadUniF='$entidademp '
and consecutivoUniF='$consecutivoemp'
and categoriaUniF='$categoriaemp';";
$res5 = mysqli_query($conexion, $sql5);

echo json_encode($response);
