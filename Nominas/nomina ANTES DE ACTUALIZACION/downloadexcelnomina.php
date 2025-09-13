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
    $tiponomina               = $_GET["tiponomina"];
    $periodonomina            = $_GET["periodonomina"];
    $fechahoy                 = date("Y-m-d");
    $qryrangodediastrabajados = "SELECT * from periodos
                                            left join aniosperiodos on periodos.IdPeriodo=aniosperiodos.IdPeriodo
                                            left join rangoperiodos on rangoperiodos.IdAnio=aniosperiodos.IdAnio
                                        WHERE periodos.IdPeriodo=$periodonomina
                                        AND '$fechahoy' BETWEEN rangoperiodos.FechaInicioP AND rangoperiodos.FechaFinP";
    $resqryrango   = mysqli_query($conexion, $qryrangodediastrabajados);
    $datosqryrango = array();
    while (($regqry = mysqli_fetch_array($resqryrango, MYSQLI_ASSOC))) {
        $datosqryrango[] = $regqry;}
    $rangoFechaInicioP = $datosqryrango[0]["FechaInicioP"];
    $rangoFechaFinP    = $datosqryrango[0]["FechaFinP"];
    $IdRango           = $datosqryrango[0]["IdRango"];

    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                    empleados.entidadFederativaId,empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                    entidadesfederativas.nombreEntidadFederativa,empleados.empleadoNumeroSeguroSocial,
                    empleados.numeroCta,empleados.numeroCtaClabe,catalogopuestos.descripcionPuesto,datosimss.fechaImss,
                    datosimss.fechaBajaImss,empleados.tipoPeriodo,empleados.empleadoEstatusId
           from  empleados
                LEFT JOIN datosimss
                ON datosimss.empladoEntidadImss=empleados.entidadFederativaId
                AND datosimss.empleadoConsecutivoImss=empleados.empleadoConsecutivoId
                AND datosimss.empleadoCategoriaImss=empleados.empleadoCategoriaId
                LEFT JOIN  catalogopuestos ON empleados.empleadoIdPuesto=catalogopuestos.idPuesto
                LEFT JOIN entidadesfederativas
                ON empleados.idEntidadTrabajo=entidadesfederativas.idEntidadFederativa
                left join finiquitos
                on empleados.entidadFederativaId=finiquitos.entidadEmpFiniquito
                and empleados.empleadoConsecutivoId=finiquitos.consecutivoEmpFiniquito
                and empleados.empleadoCategoriaId=finiquitos.categoriaEmpFiniquito";
    if ($tiponomina == 1) {$sql .= " where (empleados.empleadoEstatusId=1 or  empleados.empleadoEstatusId=2 or (empleados.empleadoEstatusId=0 and fechaBajaEmpleado between '$rangoFechaInicioP' and  '$rangoFechaFinP'  and finiquitos.estatusFiniquito='0'))
                 and empleados.tipoPeriodo='$periodonomina' group by numempleado ";}
    if ($tiponomina == 2) {$sql .= " where  (empleados.empleadoEstatusId=1 or empleados.empleadoEstatusId=2)
        and empleados.tipoPeriodo='$periodonomina' group by numempleado";}
    if ($tiponomina == 3) {$sql .= " where (empleados.empleadoEstatusId=0 and fechaBajaEmpleado between '$rangoFechaInicioP' and  '$rangoFechaFinP' or( finiquitos.estatusFiniquito='0'))
                 and empleados.tipoPeriodo='$periodonomina'
                 ";}
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;}
    for ($i = 0; $i < count($datos); $i++) {
        $tipodeperiodo       = $datos[$i]["tipoPeriodo"]; //para hacer el calculo conforme a su tipo de periodo
        $entidadFederativa   = $datos[$i]["entidadFederativaId"];
        $empleadoConsecutivo = $datos[$i]["empleadoConsecutivoId"];
        $empleadoCategoria   = $datos[$i]["empleadoCategoriaId"];
        $cuentaclabe         = $datos[$i]["numeroCtaClabe"];
        $idbanco             = substr($cuentaclabe, 0, 3);
        ////////////////////////////////////////////////////////////PARA TRAER EL BANCO ASIGNADO A  CADA EMPLEADO////////////////////////////////////////////////
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

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudainfonavit = "SELECT * FROM infonavit_nomina
                                where idIN=(select max(idIN)
                                                from infonavit_nomina
                                                where entidadEmpIN='$entidadFederativa'
                                                and consecutivoEmpIN='$empleadoConsecutivo'
                                                and categoriaEmpIN='$empleadoCategoria')";
        $resqrydeudainfona  = mysqli_query($conexion, $qrydeudainfonavit);
        $datodeudainfonavit = array();
        while (($resqrydeudainfonavit = mysqli_fetch_array($resqrydeudainfona, MYSQLI_ASSOC))) {
            $datodeudainfonavit[] = $resqrydeudainfonavit;}
        $conteodeudainfonavit = count($datodeudainfonavit);
        if ($conteodeudainfonavit != 0) {
            $montoinfonavit = $datodeudainfonavit[0]["montoIN"];
        } else { $montoinfonavit = "0";}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudafonacot = "SELECT * FROM fonacot_nomina
                                where idFN=(select max(idFN)
                                                from fonacot_nomina
                                                where entidadEmpFN='$entidadFederativa'
                                                and consecutivoEmpFN='$empleadoConsecutivo'
                                                and categoriaEmpFN='$empleadoCategoria')";
        $resqrydeudafona  = mysqli_query($conexion, $qrydeudafonacot);
        $datodeudafonacot = array();
        while (($resqrydeudafonavit = mysqli_fetch_array($resqrydeudafona, MYSQLI_ASSOC))) {
            $datodeudafonacot[] = $resqrydeudafonavit;}
        $conteodeudafonacot = count($datodeudafonacot);
        if ($conteodeudafonacot != 0) {
            $montofonacot = $datodeudafonacot[0]["montoFN"];
        } else { $montofonacot = "0";}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudapension = "SELECT * FROM pension_nomina
                                where idPeN=(select max(idPeN)
                                                from pension_nomina
                                                where entidadEmpPeN='$entidadFederativa'
                                                and consecutivoEmpPeN='$empleadoConsecutivo'
                                                and categoriaEmpPeN='$empleadoCategoria')";
        $resqrydeudapension = mysqli_query($conexion, $qrydeudapension);
        $datodeudapension   = array();
        while (($resqrydeudapen = mysqli_fetch_array($resqrydeudapension, MYSQLI_ASSOC))) {
            $datodeudapension[] = $resqrydeudapen;}
        $conteodeudapension = count($datodeudapension);
        if ($conteodeudapension != 0) {
            $montopension = $datodeudapension[0]["montoPeN"];
        } else { $montopension = "0";}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudaprestamo = "SELECT * FROM prestamo_nomina
                                where idPN=(select max(idPN)
                                                from prestamo_nomina
                                                where entidadEmpPN='$entidadFederativa'
                                                and consecutivoEmpPN='$empleadoConsecutivo'
                                                and categoriaEmpPN='$empleadoCategoria')";
        $resqrydeudaprestamo = mysqli_query($conexion, $qrydeudaprestamo);
        $datodeudaprestamo   = array();
        while (($resqrydeudapres = mysqli_fetch_array($resqrydeudaprestamo, MYSQLI_ASSOC))) {
            $datodeudaprestamo[] = $resqrydeudapres;
        }
        $conteodeudaprestamo = count($datodeudaprestamo);
        if ($conteodeudaprestamo != 0) {
            $montoprestamo = $datodeudaprestamo[0]["montoPN"];
        } else { $montoprestamo = "0";}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudaalimentos = "SELECT * FROM alimentos_nomina
                                where idAN=(select max(idAN)
                                                from alimentos_nomina
                                                where entidadEmpAN='$entidadFederativa'
                                                and consecutivoEmpAN='$empleadoConsecutivo'
                                                and categoriaEmpAN='$empleadoCategoria')";
        $resqrydeudaalimento = mysqli_query($conexion, $qrydeudaalimentos);
        $datodeudaalimentos  = array();
        while (($resqrydeudaalimen = mysqli_fetch_array($resqrydeudaalimento, MYSQLI_ASSOC))) {
            $datodeudaalimentos[] = $resqrydeudaalimen;}
        $conteodeudaalimento = count($datodeudaalimentos);
        if ($conteodeudaalimento != 0) {
            $montoalimento = $datodeudaalimentos[0]["montoAN"];
        } else { $montoalimento = "0";}
//juntando los arrays de las consultar para poderlos imprimir en el excel
        $datos[$i]["banco"]     = $descbanco;
        $datos[$i]["infonavit"] = $montoinfonavit;
        $datos[$i]["fonacot"]   = $montofonacot;
        $datos[$i]["pension"]   = $montopension;
        $datos[$i]["prestamo"]  = $montoprestamo;
        $datos[$i]["alimentos"] = $montoalimento;

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