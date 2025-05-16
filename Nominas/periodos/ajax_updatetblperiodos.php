<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$response       = array();
$datos          = array();
$editfecha      = $_POST['editfecha'];
$diaspagoedit   = $_POST['diaspagoedit'];
$idrango        = $_POST['idrango'];
$idanio         = $_POST['idanio'];
$log            = new KLogger("ajax_updatetblrangoperiodos.log", KLogger::DEBUG);
$anio           = date($editfecha);
$anioinsert     = new DateTime($anio);
$anioinsertsolo = $anioinsert->format('Y');
$mescomparacion = $anioinsert->format('m');
$diacomparacion = $anioinsert->format('d');
/*if ($mescomparacion == '01' && $diacomparacion == '01') {
$response["status"] = "success";
} else {
$response["status"] = "notsuccess";
}*/

if ($diaspagoedit == 15) {
    $iteracion = 24;
} else {
    $iteracion = 52;
}

//for ($i = 1; $anioinsertsolo == $fechs; $i++) { bucle comparando el año

$fecha = date($editfecha);
$fechs = $anioinsertsolo;
for ($i = 0; $i < $iteracion; $i++) {
//bucle tomando en cuenta la iteracion
    $idrango    = $idrango;
    $nuevafecha = strtotime('+' . ($diaspagoedit - 1) . ' day', strtotime($fecha));
    $nuevafecha = date('Y-m-d', $nuevafecha);
    if ($i % 2 == 0 && $mescomparacion == '01' && $diacomparacion == '01' && $diaspagoedit == 15) {
        $mesFecha       = new DateTime($fecha);
        $mes            = $mesFecha->format('m');
        $first_of_month = mktime(0, 0, 0, $mes, 1, $anioinsertsolo);
        $maxdays        = date('t', $first_of_month);
        $fecharmada     = $anioinsertsolo . '-' . $mes . '-' . $maxdays;
        $nuevafecha     = $fecharmada;
    }
    $sql4 = "update  rangoperiodos
                    set  FechaInicioP='$fecha', FechaFinP='$nuevafecha'
                    where IdRango=$idrango
                    and IdAnio=$idanio";
    $ressql4 = mysqli_query($conexion, $sql4);

    //$log->LogInfo("Valor de la variable fecha:  " . var_export($fecha, true));
    //$log->LogInfo("Valor de la variable nuevafecha:  " . var_export($nuevafecha, true));
    //$log->LogInfo("Valor de la variable idrango:  " . var_export($idrango, true));

    $idrango    = ($idrango + 1);
    $nuevafecha = strtotime('+' . (1) . ' day', strtotime($nuevafecha));
    $nuevafecha = date('Y-m-d', $nuevafecha);
    $fech       = new DateTime($nuevafecha);
    $fechs      = $fech->format('Y');
    $fecha      = $nuevafecha;
}
$response["status"] = "success";
echo json_encode($editfecha);
