<?php
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajaxinsertUpdateRepse.log" , KLogger::DEBUG );
$accion    = $_POST['accion'];
$noAcuerdo = $_POST['noAcuerdo'];
$noFolioIn = $_POST['noFolioIn'];
$idRepse   = $_POST['idRepse'];
    // $log->LogInfo("Valor de variable noAcuerdo" . var_export ($noAcuerdo, true));
    // $log->LogInfo("Valor de variable noFolioIn" . var_export ($noFolioIn, true));
    // $log->LogInfo("Valor de variable idRepse" . var_export ($idRepse, true));


if ($accion == 1) {
    for ($i = 0; $i < count($noAcuerdo); $i++) {
        $sql = "UPDATE catalogorepse 
                set NumAcuerdo='" . $noAcuerdo[$i] . "',NumFolioIngreso='" . $noFolioIn[$i] . "' 
                where idRepse='" . $idRepse[$i] . "'"; 
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
         }
    }}

if ($accion == 2) {
    $sql = "insert into catalogorepse(NumAcuerdo, NumFolioIngreso)
            values('" . $noAcuerdo . "','" . $noFolioIn . "')";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
         }
}

