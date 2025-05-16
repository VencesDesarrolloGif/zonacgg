<?php

//$response = array();
//$datos    = array();
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$descripcion      = $_POST['descripcion'];
$id               = $_POST['id'];
$idconceptosat    = $_POST['idconceptosat'];
$fechainicio      = $_POST['fechainicio'];
$fechafin         = $_POST['fechafin'];
$formula          = $_POST['formula'];
$ditinctcolumntbl = $_POST['distinctcolumn'];
$accion           = $_POST["accion"];
$formulacompleta  = $_POST['formulacompleta'];
$usuario          = $_SESSION['userLog'];

$formulacioncompletastring = implode(",", $formulacompleta);
$log                       = new KLogger("ajax_actualizaPercepciones.log", KLogger::DEBUG);
$log->LogInfo("Valor de la variable formulacionstring:  " . var_export($formulacioncompletastring, true));
//$a   = count($descripcion);
if ($accion == 1) {
    for ($i = 0; $i < count($descripcion); $i++) {
        $sum = $i + 1;
        if ($fechafin[$i] === "") {
            $fechafin[$i] = 'null';
            $sql          = "update  catalogo_TipoPercepcion
                    set numTipoPercepcion='" . $id[$i] . "',Descripcion='" . $descripcion[$i] . "',fInicioVig='" . $fechainicio[$i] . "',fFinVig='" . $fechafin[$i] . "'
                    ,IdTipoPercepcionSat='" . $idconceptosat[$i] . "' where IdTipoPercepcion='$sum'";
            // $res = mysqli_query($conexion, $sql);

        } else {
            $sql = "update  catalogo_TipoPercepcion
    set numTipoPercepcion='" . $id[$i] . "',Descripcion='" . $descripcion[$i] . "',fInicioVig='" . $fechainicio[$i] . "',fFinVig='" . $fechafin[$i] . "',IdTipoPercepcionSat='" . $idconceptosat[$i] . "' where IdTipoPercepcion='$sum'";}
        $res = mysqli_query($conexion, $sql);
        //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    }
} else if ($accion == 2) {

    if (empty($_POST['fechafin'])) {
        $sql = "insert into catalogo_TipoPercepcion(IdTipoPercepcion, numTipoPercepcion, Descripcion, IdTipoPercepcionSat,fInicioVig)values('','$id','$descripcion','$idconceptosat','$fechainicio')";
    } else {
        $sql = "insert into catalogo_TipoPercepcion(IdTipoPercepcion, numTipoPercepcion, Descripcion, IdTipoPercepcionSat,fInicioVig, fFinVig)values('','$id','$descripcion','$idconceptosat','$fechainicio','$fechafin')";
    }
    $res = mysqli_query($conexion, $sql);
} else if ($accion == 3) {
    $sql = "update catalogo_tipopercepcion set ";
    if ($ditinctcolumntbl == 1) {
        $sql .= "importeTotalTP='$formula',importeTotalfrmcadena='$formulacioncompletastring',UserEdit='$usuario',FechEdit=now() where numTipoPercepcion='$id'";
    } else if ($ditinctcolumntbl == 2) {
        $sql .= "grabadoISRTP='$formula',grabadoISRfrmcadena='$formulacioncompletastring',UserEdit='$usuario',FechEdit=now()  where numTipoPercepcion='$id'";
    } else if ($ditinctcolumntbl == 3) {
        $sql .= "excentoISRTP='$formula',excentoISRfrmcadena='$formulacioncompletastring',UserEdit='$usuario',FechEdit=now() where numTipoPercepcion='$id'";
    } else if ($ditinctcolumntbl == 4) {
        $sql .= "grabadoIMSSTP='$formula',grabadoIMSSfrmcadena='$formulacioncompletastring',UserEdit='$usuario',FechEdit=now() where numTipoPercepcion='$id'";
    } else if ($ditinctcolumntbl == 5) {
        $sql .= "excentoIMSSTP='$formula',excentoIMSSfrmcadena='$formulacioncompletastring',UserEdit='$usuario',FechEdit=now()  where numTipoPercepcion='$id'";}
    //$log->LogInfo("Valor de la variable query:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
}
echo json_encode($usuario);
