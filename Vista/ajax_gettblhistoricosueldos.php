<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "respuestasesion.log" , KLogger::DEBUG );
   //$log->LogInfo("Valor de variable desession:" . var_export ($a, true));
try {
    $lista = $negocio->gettblhistoricosueldos();
    //$log->LogInfo("Valor de variable de lista:" . var_export ($lista, true));
    for ($i = 0; $i < count($lista); $i++) {
        $FechaIngresoActual        = $lista[$i]["FechaIngresoActual"];
        $FechaBajaActual        = $lista[$i]["FechaBajaActual"];
        $FechaIngresoEmpN         = $lista[$i]["FechaIngresoEmpN"];
        $FechaBajaEmpN       = $lista[$i]["FechaBajaEmpN"];
        $FechaIngresoEmpEdit     = $lista[$i]["FechaIngresoEmpEdit"];
        $FechaBajaEmpEit         = $lista[$i]["FechaBajaEmpEit"];
        if($FechaIngresoEmpN !="0"){
            $lista[$i]["FechaIngreso"] = $FechaIngresoEmpN;
            $lista[$i]["FechaBaja"] = $FechaBajaEmpN;
        }else{
            if($FechaIngresoEmpEdit!="0"){
                $lista[$i]["FechaIngreso"] = $FechaIngresoEmpEdit;
                $lista[$i]["FechaBaja"] = $FechaBajaEmpEit;
            }else{
                $lista[$i]["FechaIngreso"] = $FechaIngresoActual;
                $lista[$i]["FechaBaja"] = $FechaBajaActual;
            }
        }
    }
    $response["data"] = $lista;
 
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo obtener lista de sueldos de empleados";
}
echo json_encode($response);