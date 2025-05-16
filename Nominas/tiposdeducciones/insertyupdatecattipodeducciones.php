<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$accion      = $_POST['accion'];
$descripcion = $_POST['descripcion'];
$id          = $_POST['id'];
$fechainicio = $_POST['fechainicio'];
$fechafin    = $_POST['fechafin'];

//$log = new KLogger("ajax_actualizaCATOTROTIPOPAGO.log", KLogger::DEBUG);
$a = count($descripcion);
if ($accion == 1) {
    for ($i = 0; $i < count($descripcion); $i++) {
        $sum = $i + 1;
        if ($fechafin[$i] === "") {
            $fechafin[$i] = 'null';
            $sql          = "update  catalogo_TipoDeduccion
                    set numTipoDeduccion='" . $id[$i] . "',Descripcion='" . $descripcion[$i] . "',fInicioVig='" . $fechainicio[$i] . "',fFinVig=$fechafin[$i]
                    where IdTipoDeduccion='$sum'";
            // $res = mysqli_query($conexion, $sql);
            //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        } else {
            $sql = "update  catalogo_TipoDeduccion
    set numTipoDeduccion='" . $id[$i] . "',Descripcion='" . $descripcion[$i] . "',fInicioVig='" . $fechainicio[$i] . "',fFinVig='" . $fechafin[$i] . "'
    where IdTipoDeduccion='$sum'";}

        $res = mysqli_query($conexion, $sql);

        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    }}

if ($accion == 2) {
    if (empty($_POST['fechafin'])) {
        $sql = "insert into catalogo_TipoDeduccion(IdTipoDeduccion, numTipoDeduccion, Descripcion, fInicioVig)values('','$id','$descripcion','$fechainicio')";
    } else {
        $sql = "insert into catalogo_TipoDeduccion(IdTipoDeduccion, numTipoDeduccion, Descripcion, fInicioVig, fFinVig)values('','$id','$descripcion','$fechainicio','$fechafin')";}
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($fechafin);
