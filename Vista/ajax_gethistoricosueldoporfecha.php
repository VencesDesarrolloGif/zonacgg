<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();

verificarInicioSesion($negocio);
$response = array("status" => "success");
$tipoconsulta=$_POST["tipoconsulta"];
$fechainicio=$_POST["fechainicio"];
$fechafin=$_POST["fechafin"];
try {
    $lista = $negocio->gettblhistoricosueldosbyfecha($tipoconsulta,$fechainicio,$fechafin);
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
    //$log->LogInfo("Valor de variable de lista2:" . var_export ($lista, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = $e->getMessage();
}
echo json_encode($response);