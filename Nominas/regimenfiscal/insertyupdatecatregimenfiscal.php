<?php

//$response = array();
//$datos    = array();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$accion      = $_POST['accion'];
$descripcion = $_POST['descripcion'];
$personaf    = $_POST['personaf'];
$personam    = $_POST['personam'];
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
            $sql          = "update  catalogo_RegimenFiscal
                    set numTipoRegimenF='" . $id[$i] . "',Descripcion='" . $descripcion[$i] . "',fInicioVig='" . $fechainicio[$i] . "',fFinVig=$fechafin[$i],PersonaF='" . $personaf[$i] . "',PersonaM='" . $personam[$i] . "'
                    where IdTipoRegimenF='$sum'";
            // $res = mysqli_query($conexion, $sql);
            //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
        } else {
            $sql = "update  catalogo_RegimenFiscal
    set numTipoRegimenF='" . $id[$i] . "',Descripcion='" . $descripcion[$i] . "',fInicioVig='" . $fechainicio[$i] . "',fFinVig='" . $fechafin[$i] . "',PersonaF='" . $personaf[$i] . "',PersonaM='" . $personam[$i] . "'
    where IdTipoRegimenF='$sum'";}

        $res = mysqli_query($conexion, $sql);

        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    }}

if ($accion == 2) {
    if (empty($_POST['fechafin'])) {
        $sql = "insert into catalogo_RegimenFiscal(IdTipoRegimenF, numTipoRegimenF, Descripcion, PersonaF, PersonaM, fInicioVig)values('','$id','$descripcion','$personaf','$personam','$fechainicio')";
    } else {
        $sql = "insert into catalogo_RegimenFiscal(IdTipoRegimenF, numTipoRegimenF, Descripcion, PersonaF, PersonaM, fInicioVig, fFinVig)values('','$id','$descripcion','$personaf','$personam','$fechainicio','$fechafin')";}
    // $log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($fechafin);
