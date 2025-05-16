<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
//$log = new KLogger ( "ajaxinsertUpdateRepse.log" , KLogger::DEBUG );
$accion    = $_POST['accion'];
$noAcuerdo = $_POST['noAcuerdo'];
$noFolioIn = $_POST['noFolioIn'];
$idRepse   = $_POST['idRepse'];
//$log->LogInfo("Valor de variable noAcuerdo" . var_export ($noAcuerdo, true));
//$log->LogInfo("Valor de variable noFolioIn" . var_export ($noFolioIn, true));
//$log->LogInfo("Valor de variable idRepse" . var_export ($idRepse, true));

if ($accion == 1) {
    for ($i = 0; $i < count($noAcuerdo); $i++) {
        $repse = $negocio->updateRepse($noAcuerdo[$i],$noFolioIn[$i],$idRepse[$i]);
    }
}

if ($accion == 2) {
    $repse = $negocio->insertRepse($noAcuerdo,$noFolioIn);
}

