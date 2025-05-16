<?php
require "../conexion/conexion.php";
require_once("../logger/KLogger.php");
// $log = new KLogger ( "ajax_InsertUpdateDepartamento.log" , KLogger::DEBUG );
$accion    = $_POST['accion'];
$descripcion = $_POST['descripcion'];
$idDepartamento = $_POST['idDepartamento'];
$lineaNeg = $_POST['lineaNegocio'];
$categoria = $_POST['categoria'];

// $log->LogInfo("Valor de variable idRepse" . var_export ($idRepse, true));
if ($accion == 1){
    for ($i = 0; $i < count($idDepartamento); $i++) {
        $sql = "UPDATE catalogo_organigramadepartamentos 
                SET descripcionDepartamento='" . $descripcion[$i] . "' 
                WHERE idDepartamentoOrg='" . $idDepartamento[$i] . "'"; 
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
         }
    }}

if ($accion == 2){//agregar

    $idActual = array();
    $sql1 = "SELECT IFNULL(MAX(idDepartamentoOrg),0) as idnivel
             FROM catalogo_organigramadepartamentos";
    $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
        $idActual[] = $reg1;
    }

    $nuevoID= $idActual[0]['idnivel']+1;

    $sql = "INSERT INTO catalogo_organigramadepartamentos(idDepartamentoOrg,descripcionDepartamento,lineaNegocio,categoria)
            VALUES('" . $nuevoID . "','" . $descripcion . "','" . $lineaNeg . "','" . $categoria . "')";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
         }
}