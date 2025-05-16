<?php
session_start();

require_once "../../Negocio/Negocio.class.php";
require_once "../../Vista/Helpers.php";
require_once "../../libs/logger/KLogger.php";
require_once "../../libs/Classes/PHPExcel.php";
require "../conexion/conexion.php";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Nomina.xls"');
header('Cache-Control: max-age=0');
?>
<html>
<head>
    <meta http-equiv="content-type" content="application/vnd.ms-excel;" charset="UTF-8">
<meta charset="UTF-8">
  <title>Nomina</title>
  <style type="text/css">
    .text{
  mso-number-format:"\@";/*force text*/
    }
  </style>
</head>
<body>
<table  border='1' class='table table-bordered' id='nomina' name='nomina'>
    <thead>
        <th>Número empleado</th><th>Nombre</th><th>Puesto</th><th>Entidad</th><th>Fecha ingreso imss</th>
        <th>Número seguro social</th><th>Número cuenta</th><th>Número cuenta clabe</th><th>Banco</th>
        <th>Infonavit</th><th>Fonacot</th><th>Pensión</th><th>prestamo</th><th>Alimentos</th>
    </thead>
<tbody>

<?php
if (!empty($_GET)) {
    $datos                    = array();
    $rango               = $_GET["rango"];
    $periodo            = $_GET["periodo"];
  //$log = new KLogger ( "downloadexcelhistorico.log" , KLogger::DEBUG );
     // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($movimiento, true));  
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
 // $log->LogInfo("Valor de la variable sql:  " . var_export($sql, true)); 
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
    for ($i = 0; $i < count($datos); $i++) {
        $numeroEmpleado  = $datos[$i]["numempleado"];
        $nombre          = utf8_decode($datos[$i]["nombreempleado"]);
        $puesto          = utf8_decode($datos[$i]["descripcionPuesto"]);
        $entidad         = $datos[$i]["nombreEntidadFederativa"];
        $fechaingreso    = utf8_decode($datos[$i]["fechaImss"]);
        $numsegurosocial = utf8_decode($datos[$i]["empleadoNumeroSeguroSocial"]);
        $numcuenta       = utf8_decode($datos[$i]["numeroCta"]);
        $cuentaclabe     = $datos[$i]["numeroCtaClabe"];
        $banco           = utf8_decode($datos[$i]["banco"]);
        $infonavit       = $datos[$i]["infonavit"];
        $fonacot         = $datos[$i]["fonacot"];
        $pension         = $datos[$i]["pension"];
        $prestamo        = $datos[$i]["prestamo"];
        $alimentos       = $datos[$i]["alimentos"];

        echo ("<tr><td class='text'>" . $numeroEmpleado . "</td><td class='text'>" . $nombre . "</td><td class='text'>" . $puesto . "</td>");
        echo ("<td >" . $entidad . "</td><td class='text'>" . $fechaingreso . "</td><td class='text'>" . $numsegurosocial . "</td>");
        echo ("<td class='text'>" . $numcuenta . "</td><td class='text'>" . $cuentaclabe . "</td><td class='text'>" . $banco . "</td>");
        echo ("<td class='text'>" . $infonavit . "</td><td class='text'>" . $fonacot . "</td><td class='text'>" . $pension . "</td>");
        echo ("<td class='text'>" . $prestamo . "</td><td class='text'>" . $alimentos . "</td>");

    }
}

?>
</tbody></table>
</body>
</html>