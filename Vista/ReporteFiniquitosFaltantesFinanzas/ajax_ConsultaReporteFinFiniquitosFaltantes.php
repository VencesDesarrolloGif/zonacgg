<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$total = 0;
// $log = new KLogger ( "ajax_ConsultaReporteFinFiniquitosFaltantes.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));
try {
    $sql = "SELECT concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) as NumeroEmpleado, concat_ws(' ', e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleado,ef.nombreEntidadFederativa,f.netoAlPago
        from finiquitos f
        left join empleados e on (f.entidadEmpFiniquito=e.entidadFederativaId and f.consecutivoEmpFiniquito=e.empleadoConsecutivoId and f.categoriaEmpFiniquito=e.empleadoCategoriaId)
        LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=f.idEntidadTrabajo)
        where f.estatusPagoFiniquito='1' and f.estatusFiniquito='1' and f.EntidadAdminBaja is not null";
    // $sql.= " order by ";
    // $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
        for($i = 0; $i < count($datos); $i++){
            $netoAlPago = $datos[$i]["netoAlPago"];
            $netoAlPagoExplod = explode(".", $netoAlPago);

            if(count($netoAlPagoExplod)==2){
                $datos[$i]["netoAlPago1"] = bcdiv($netoAlPago, '1', 2);
            }else{
                $datos[$i]["netoAlPago1"] = $netoAlPago.'.00';                
            }
            $total += $netoAlPago;
        }
        $j = count($datos);        
        $datos[$j]["NumeroEmpleado"] = "Total";
        $datos[$j]["NombreEmpleado"] = "";
        $datos[$j]["nombreEntidadFederativa"] = "";

        $totalExplod = explode(".", $total);

        if(count($totalExplod)==2){
            $datos[$j]["netoAlPago1"] = bcdiv( $total, '1', 2);
        }else{
            $datos[$i]["netoAlPago1"] = $total.'.00';                
            }
        
        
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
