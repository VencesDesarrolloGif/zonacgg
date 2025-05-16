<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$response = array();
//$response["status"] = "error";
$datos    = array();
$idrango  = $_POST["idrango"];
$accion   = $_POST["accion"];
$periodo   = $_POST["periodo"];
$nomina   = $_POST["nomina"];
$fechahoy = date("Y-m-d");
$msg      = "";

try {
    // $sql.=" where  empleados.tipoPeriodo='$periodonomina'";
    //$log = new KLogger("ajax_cierreNomina.log", KLogger::DEBUG);

    ////////////////////////////////////////////////////////////PARA TRAER EL BANCO ASIGNADO A  CADA EMPLEADO////////////////////////////////////////////////
    if ($accion == 1) {
        $qrycrnom = " Select * from cierresnomina
                        where rangoPeriodo='$idrango'";
        $resqrycrnom = mysqli_query($conexion, $qrycrnom);
        $datocrnom   = array();
        while (($exeqrycrnom = mysqli_fetch_array($resqrycrnom, MYSQLI_ASSOC))) {
            $datocrnom[] = $exeqrycrnom;}
        $conteoqry = count($datocrnom);
        if ($conteoqry != 0) {
            $msg = "error";

        }
    }
    if ($accion == 2) {
        //$log->LogInfo("Valor de la variable nomina:  " . var_export($nomina, true));

        for($i=0;$i< count($nomina);$i++){
            $entidadNomina=$nomina[$i]['entidadFederativaId'];
            $consecutivoNomina=$nomina[$i]['empleadoConsecutivoId'];
            $categoriaNomina=$nomina[$i]['empleadoCategoriaId'];
            $infonavit=$nomina[$i]['infonavit'];
            $fonacot=$nomina[$i]['fonacot'];
            $pension=$nomina[$i]['pension'];
            $prestamo=$nomina[$i]['prestamo'];
            $alimentos=$nomina[$i]['alimentos'];
            $sueldo=$nomina[$i]['sueldo'];
            $sql="insert into nominageneral values(NULL,'$entidadNomina','$consecutivoNomina','$categoriaNomina','$infonavit','$fonacot','$pension','$prestamo','$alimentos','$sueldo','$idrango','$periodo')";
            //$log->LogInfo("Valor de la variable sql:  " . var_export($sql, true));
            $ressql = mysqli_query($conexion, $sql);
        }


        $qryinscrnom       = "insert into cierresnomina(idCierre, fechaCierre, rangoPeriodo) 
                   values('','$fechahoy','$idrango')";
        $resqryinsertcrnom = mysqli_query($conexion, $qryinscrnom);
        $msg               = "bien";
    }
    // $log->LogInfo("Valor de la variable :  " . var_export($datobanco, true));
    $response["msgerror"] = $msg;
} catch (Exception $e) {
    $response["mensaje"] = "Error al cerrar periodo";}
echo json_encode($response);
