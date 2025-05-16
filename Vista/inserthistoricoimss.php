<?php
//session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";

require "../Nominas/conexion/conexion.php";

//$negocio = new Negocio();

//verificarInicioSesion($negocio);

$response = array("status" => "success");

/*
if(!empty ($_POST))
{
 */

/*empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento,
tipoMovimiento, fechaMovimiento, sdiMovimiento, FIntegracionMovimiento, SBCMovimiento, fechaAlta,  registroMovimiento)*/

//$log = new KLogger("ajaxObtenerEmpleadosPorEstatus.log", KLogger::DEBUG);

try {

    $sql = "select di.empladoEntidadImss ,di.empleadoConsecutivoImss ,di.empleadoCategoriaImss,

                di.fechaImss,di.fechaBajaImss,di.salarioDiario,datediff(now(), di.fechaImss) as diasTranscurridos, e.empleadoNumeroSeguroSocial,
                di.salarioDiario, di.registroPatronal
                from datosimss di
                left join empleados e on (di.empladoEntidadImss=e.entidadFederativaId and
                di.empleadoConsecutivoImss=e.empleadoConsecutivoId
                and di.empleadoCategoriaImss=e.empleadoCategoriaId)";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }
    $aguinaldo = 15 / 365;
    $unidad    = 1;

    for ($i = 0; $i <= count($datos); $i++) {
        $diasTranscurridos = $datos[$i]["diasTranscurridos"];
        $salarioDiario     = $datos[$i]["salarioDiario"];

        if ($diasTranscurridos <= 365) {
            $primaVacacional = 1.5;

        } elseif ($diasTranscurridos >= 366 and $diasTranscurridos <= 730) {

            $primaVacacional = 2;

        } elseif ($diasTranscurridos >= 731 and $diasTranscurridos <= 1095) {

            $primaVacacional = 2.5;
        } elseif ($diasTranscurridos >= 1096 and $diasTranscurridos <= 1460) {

            $primaVacacional = 3;

        } elseif ($diasTranscurridos >= 1461 and $diasTranscurridos <= 1825) {

            $primaVacacional = 3.5;

        } elseif ($diasTranscurridos >= 1826 and $diasTranscurridos <= 3650) {

            $primaVacacional = 3.5;

        } elseif ($diasTranscurridos >= 1827 and $diasTranscurridos <= 5475) {

            $primaVacacional = 4;
        }
//$listaEmpleadosCuadro[$i] ["prima_vacacional"]= $primaVacacional;
        $factorIntegracion = $unidad + ($primaVacacional / 365) + $aguinaldo;
        $salarioBaseCot    = $factorIntegracion * $salarioDiario;

        $sql2 = "INSERT INTO historicomovimientosimss(empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento,tipoMovimiento, fechaMovimiento,
                                                        sdiMovimiento,FIntegracionMovimiento, SBCMovimiento, fechaAlta,registroMovimiento,estatusmov,fechaBaja)
 VALUES('" . $datos[$i]["empladoEntidadImss"] . "','" . $datos[$i]["empleadoConsecutivoImss"] . "','" . $datos[$i]["empleadoCategoriaImss"] . "',1,now(),
        '$salarioDiario','$factorIntegracion',$salarioBaseCot,'" . $datos[$i]["fechaImss"] . "','" . $datos[$i]["registroPatronal"] . "',1";

        if ($datos[$i]["fechaBajaImss"] == "") {
            $sql2 .= ",null)";
        } else { $sql2 .= ",'" . $datos[$i]["fechaBajaImss"] . "')";}

        $res2 = mysqli_query($conexion, $sql2);
        //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
        // $log->LogInfo("Valor de la variable \$response punto: " . var_export($sql2, true));

    }
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo obtener Empleados";
}
/*
}
 */

echo json_encode($response);

/*$listaEmpleadosCuadro[$i] ["prima_vacacional"]= $primaVacacional;
$listaEmpleadosCuadro[$i] ["factor_integracion"]= $unidad+($primaVacacional/365)+$aguinaldo;
$listaEmpleadosCuadro[$i] ["sbc"]= $listaEmpleadosCuadro[$i] ["factor_integracion"]*$salarioDiario;*/
