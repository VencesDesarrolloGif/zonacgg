<?php
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_InsertUpdateDepartamento.log" , KLogger::DEBUG );
$accion    = $_POST['accion'];
$descripcionNivel = $_POST['descripcionNivel'];
$NivelOrg = $_POST['NivelOrg'];
// $log->LogInfo("Valor de variable idRepse" . var_export ($idRepse, true));
if ($accion == 1){
    for ($i = 0; $i < count($NivelOrg); $i++) {
        $sql = "UPDATE catalogo_organigramaniveles 
                SET descripcionNivel='" . $descripcionNivel[$i] . "' 
                WHERE idNivelOrg='" . $NivelOrg[$i] . "'"; 
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
         }
    }}

if ($accion == 2) {
   $idActual = array();
    $sql1 = "SELECT MAX(idNivelOrg) as idnivel
             FROM catalogo_organigramaniveles";
    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
        $idActual[] = $reg1;
    }

    $nuevoID= $idActual[0]['idnivel']+1;
    $sql = "INSERT INTO catalogo_organigramaniveles(idNivelOrg,descripcionNivel)
            VALUES('" . $nuevoID . "','" . $descripcionNivel . "')";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
         }
}

