<?php
session_start();
require_once("../libs/logger/KLogger.php"); 
require "conexion.php";
// $log = new KLogger("ajax_consultaGerenteRegional.log", KLogger::DEBUG);
$response = array();
$response["status"]= "error";


$entLaborar= $_POST["entLaborar"]; 
$lineaNeg= $_POST["lineaNeg"]; 
$region= array();
$entidades= array();
$gerentesRegionales= array();

try {

    $sql = "SELECT idRegionI 
            FROM index_regiones
            WHERE idEntidadI='$entLaborar'
            AND idLineaNegI='$lineaNeg'";

    $res = mysqli_query($conexion, $sql);
    while($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
          $region[]=$reg;
    }

    $idRegion=$region[0]["idRegionI"];

    $sql1 = "SELECT idEntidadI 
             FROM index_regiones
             WHERE idRegionI='$idRegion'
             AND idLineaNegI='$lineaNeg'";

    $res1 = mysqli_query($conexion, $sql1);
    while($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC)) {
          $entidades[]=$reg1;
    }


    $sql2 = "SELECT concat_ws('-',entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId) as numeroEmpleado,
                    concat_ws(' ',nombreEmpleado,apellidoPaterno,apellidoMaterno) as nombreEmpleado 
             FROM empleados
             WHERE empleadoIdPuesto=42
             AND (empleadoEstatusId=1 OR empleadoEstatusId=2)
             AND";

            for($i=0; $i < count($entidades); $i++){ 
                $entidad=$entidades[$i]["idEntidadI"];
                if($i==0){
                    $sql2.=" (idEntidadTrabajo='$entidad'";
                }else{
                    $sql2.=" OR idEntidadTrabajo='$entidad'";
                }
            }
    $sql2.=")";

    $res2 = mysqli_query($conexion, $sql2);
    while($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC)) {
          $gerentesRegionales[]=$reg2;
    }

        $response["datos"] = $gerentesRegionales;  
        $response["status"] = "success";
    // $log->LogInfo("Valor de la variable sql2: " . var_export ($sql2, true));                                                                      
}catch(Exception $e) {
    $response["mensaje"]= "Error al Consultar Estatus Del Empleado";
}
echo json_encode($response);
