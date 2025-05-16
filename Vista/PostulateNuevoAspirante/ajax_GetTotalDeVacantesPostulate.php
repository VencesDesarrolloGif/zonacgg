<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_GetTotalDeVacantesPostulate.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
try {
    $Entidad = $_POST["SelEntidadALaborar"];
    $Puesto = $_POST["SelectPuestoPostulate"];
    $sql = "SELECT 
    (SELECT sum(sp.numeroElementos) as ElementosTotales 
        from catalogopuntosservicios cps
        left join servicios_plantillas sp ON (cps.idPuntoServicio=sp.puntoServicioPlantillaId)
        where cps.esatusPunto ='1'
        and estatusPlantilla='1'
        and numeroElementos>0
        and cps.puntoServicio NOT LIKE 'MER%' 
        AND cps.puntoServicio NOT LIKE '%INCAPACIDAD%'
        AND cps.puntoServicio NOT LIKE 'CON%'
        and cps.idEntidadPunto='$Entidad'
        and sp.puestoPlantillaId='$Puesto') -
        (select sum(cps.esatusPunto) as ElementosTotales 
        from catalogopuntosservicios cps
        left join servicios_plantillas sp ON (cps.idPuntoServicio=sp.puntoServicioPlantillaId)
        left join plantilla p ON(p.requisicionId=sp.servicioPlantillaId)
        left join empleados e ON(p.empleadoEntidadPlantilla=e.entidadFederativaId and p.empleadoConsecutivoPlantilla=e.empleadoConsecutivoId and e.empleadoCategoriaId =p.empleadoCategoriaPlantilla)
        where cps.esatusPunto ='1'
        and sp.estatusPlantilla='1'
        and sp.numeroElementos>0
        and (e.empleadoEstatusId='1' or e.empleadoEstatusId='2')
        and cps.puntoServicio NOT LIKE 'MER%' 
        AND cps.puntoServicio NOT LIKE '%INCAPACIDAD%'
        AND cps.puntoServicio NOT LIKE 'CON%'
        and cps.idEntidadPunto='$Entidad'
        and e.empleadoIdPuesto='$Puesto') as TotalVacantes";    

    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
    //$log->LogInfo("Valor de la variable response " . var_export ($response, true));
}catch (Exception $e) {
    $response["mensaje"] = "Error al Obtener Matrices";
}
echo json_encode($response);
