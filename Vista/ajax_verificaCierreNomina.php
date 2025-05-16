<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "conexion.php";
require_once "../libs/logger/KLogger.php";
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();
verificarInicioSesion ($negocio);

//$log = new KLogger ( "cierreNomina.log" , KLogger::DEBUG );
$periodo=$_POST['periodo'];
$response           = array();
$response["status"] = "success";
try {
    $fechaActual=DATE('Y-m-d');        
    //$log->LogInfo("Valor de la variable fechaActual:  " . var_export($fechaActual, true));
    $sql = "SELECT *from periodos
                                        left join aniosperiodos on periodos.IdPeriodo=aniosperiodos.IdPeriodo
                                        left join rangoperiodos on rangoperiodos.IdAnio=aniosperiodos.IdAnio
                                    WHERE periodos.IdPeriodo='$periodo' 
                                    AND '$fechaActual' BETWEEN rangoperiodos.FechaInicioP AND rangoperiodos.FechaFinP";
    //$log->LogInfo("Valor de la variable sql:  " . var_export($sql, true));
    $res   = mysqli_query($conexion, $sql);
    $datos = array();
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }
    $rangoActual         = $datos[0]["IdRango"];   
    $sql1 = "SELECT rangoPeriodo FROM cierresnomina WHERE idCierre= (SELECT ifnull(MAX(cn.idCierre),0) FROM cierresnomina cn LEFT JOIN rangoperiodos rp ON 
                 (cn.rangoPeriodo=rp.IdRango) LEFT JOIN aniosperiodos ap ON (rp.IdAnio=ap.IdAnio) WHERE ap.IdPeriodo='$periodo')";
    $res1   = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($res1) > 0) {
        $datos1 = array();
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
            $datos1[] = $reg1;
        }
        $rangoCierre         = $datos1[0]["rangoPeriodo"]; 
    }else{
        $rangoCierre         = 0;
    }
        
    if($rangoActual==$rangoCierre){
        $response["status"] = "error";
        $response["mensaje"] = "El periodo actual ha sido cerrado";
    //$log->LogInfo("Valor de la variable qry:  " . var_export($datos, true));    
    // $response["datos"]  = $datosMostrar;
    }
} catch (Exception $e) {
    $response["mensaje"] = "Error en Exception";
}
echo json_encode($response);
