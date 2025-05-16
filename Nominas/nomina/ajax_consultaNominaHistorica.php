<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$response                 = array();
$response["status"]       = "success";
$datos                    = array();
$rango               = $_POST["rango"];
$periodo            = $_POST["periodo"];
//$log = new KLogger("ajax_busquedaNomina.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable rango y periodo:  " . var_export($rango, true)." --- ". var_export($periodo, true));
try {
    $sql = "SELECT concat(e.entidadFederativaId,'-',e.empleadoConsecutivoId,'-',e.empleadoCategoriaId)AS numempleado,
                   e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId,
                    concat(e.apellidoPaterno,' ',e.apellidoMaterno,' ',e.nombreEmpleado) AS nombreempleado,
                    ef.nombreEntidadFederativa,e.empleadoNumeroSeguroSocial,
                    e.numeroCta,e.numeroCtaClabe,cp.descripcionPuesto,di.fechaImss,
                    di.fechaBajaImss,e.tipoPeriodo,e.empleadoEstatusId,e.idTipoPuesto,di.salarioDiario
                    ,ng.infonavitNom as infonavit,ng.fonacotNom as fonacot,ng.pensionNom as pension,ng.prestamoNom as prestamo,ng.alimentosNom as alimentos,
                    ng.sueldoNom as sueldo
                     FROM empleados e 
                     LEFT JOIN datosimss di ON(di.empladoEntidadImss=e.entidadFederativaId AND di.empleadoConsecutivoImss=e.empleadoConsecutivoId
                        AND di.empleadoCategoriaImss=e.empleadoCategoriaId)
                    LEFT JOIN nominageneral ng ON (e.entidadFederativaId=ng.empEntidadNomina AND e.empleadoConsecutivoId=ng.empConsecutivoNomina
                        AND e.empleadoCategoriaId=ng.empTipoNomina) 
                    LEFT JOIN  catalogopuestos cp ON (e.empleadoIdPuesto=cp.idPuesto)
                    LEFT JOIN entidadesfederativas ef ON (e.idEntidadTrabajo=ef.idEntidadFederativa)
            WHERE ng.numRango='$rango' AND ng.idPeriodoNom='$periodo'";

  //$log->LogInfo("Valor de la variable sql:  " . var_export($sql, true));
    
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;}
    
    for($i=0;$i<count($datos);$i++){
        $cuentaclabe = $datos[$i]["numeroCtaClabe"];
        $idbanco= substr($cuentaclabe, 0, 3);

        $qrybanco = "SELECT  * FROM bancos_empresa
                    where idCuentaBanco=$idbanco";
        $resqrybanco = mysqli_query($conexion, $qrybanco);
        $datobanco   = array();
        while (($resqryban = mysqli_fetch_array($resqrybanco, MYSQLI_ASSOC))) {
            $datobanco[] = $resqryban;}
        $conteobancos = count($datobanco);
        if ($conteobancos != 0) {
            $descbanco = $datobanco[0]["nombreBanco"];
        } else { $descbanco = "SIN DESCRIPCIÓN";}
        $datos[$i]["banco"]     = $descbanco;
    }
    $response["datos"] = $datos;

} catch (Exception $e) {
    $response["status"] = "error";
    $response["mensaje"] = "Error: ".$e.getMessage();

}



echo json_encode($response);
