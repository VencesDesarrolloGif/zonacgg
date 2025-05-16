<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger ( "ajax_aplicarSueldosGeneral.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
$usuario = $_SESSION ["userLog"]["usuario"];
$data=$_POST["data"]; 
try {
    $aguinaldo = 15 / 365;
    $unidad    = 1;
    $datos     = array();

    for ($i = 0; $i < count($data); $i++){
        $entidadFederativaId=$data[$i]["entidadFederativaIdArray"];
        $empleadoConsecutivoId=$data[$i]["empleadoConsecutivoIdArray"];
        $empleadoCategoriaId=$data[$i]["empleadoCategoriaIdArray"];
        $fechaIngresoEmpleado=$data[$i]["fechaIngresoEmpleadoArray"];
        $registroPatronal=$data[$i]["registroPatronalArray"];
        $diasTranscurridos=$data[$i]["diasTranscurridosArray"];
        $numeroLote=$data[$i]["numeroLoteArray"];
        $fechaImss=$data[$i]["fechaImssArray"];
        $salarioDiario=$data[$i]["nuevoSueldoArray"];

        if ($diasTranscurridos <= 365) {
            $primaVacacional = 3;
        
        } elseif ($diasTranscurridos >= 366 and $diasTranscurridos <= 730) {
        
            $primaVacacional = 3.5;
        
        } elseif ($diasTranscurridos >= 731 and $diasTranscurridos <= 1095) {
        
            $primaVacacional = 4;
        } elseif ($diasTranscurridos >= 1096 and $diasTranscurridos <= 1460) {
        
            $primaVacacional = 4.5;
        
        } elseif ($diasTranscurridos >= 1461 and $diasTranscurridos <= 1825) {
        
            $primaVacacional = 5;
        
        } elseif ($diasTranscurridos >= 1826 and $diasTranscurridos <= 3650) {
        
            $primaVacacional = 5.5;
        
        } elseif ($diasTranscurridos >= 3651 and $diasTranscurridos <= 5475) {
        
            $primaVacacional = 6;
        
        } elseif ($diasTranscurridos >= 5476 and $diasTranscurridos <= 7300) {
        
            $primaVacacional = 6.5;
        
        } elseif ($diasTranscurridos >= 7301 and $diasTranscurridos <= 9125) {
        
            $primaVacacional = 7;
        
        } elseif ($diasTranscurridos >= 9126 and $diasTranscurridos <= 10950) {
        
            $primaVacacional = 7.5;
        
        } elseif ($diasTranscurridos >= 10951 and $diasTranscurridos <= 12775) {
        
            $primaVacacional = 8;
        
        }
        $factorintegracion     = $unidad + ($primaVacacional / 365) + $aguinaldo;
        $salariobasecotizacion = $factorintegracion * $salarioDiario;

        $sql2 = "SELECT  LPAD(IF(MAX( folioTxt ) IS NULL , 1, MAX( folioTxt ) + 1 ), 4, 0)  AS 'ultimoFolio' from datosImss";
        $res2 = mysqli_query($conexion, $sql2);
        while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
            $datos[] = $reg2;
        }
        $NuevoFolio=$datos[0]["ultimoFolio"];
        $AnioActual = date('Y');
        $NuevoLote = "MODSAL".$AnioActual;

        $sql = "UPDATE datosimss set salarioDiario='$salarioDiario',idMotivoBajaImss='B',empleadoEstatusImss='3',emisionAltaImssConfirmada='1',SueldoAnual='$AnioActual',folioTxt='$NuevoFolio',numeroLote='$NuevoLote'
                where empladoEntidadImss='$entidadFederativaId' 
                and empleadoConsecutivoImss='$empleadoConsecutivoId' 
                and empleadoCategoriaImss='$empleadoCategoriaId'";
        $res = mysqli_query($conexion, $sql);  
        if ($res !== true) {
            $response["status"] = "error";
            $response["message"]='Ocurrio Un Error Al Actualizar Datos De Imss.';
            return;
        }else{
            $response ["status"] = "success";
            $response ["message"] = "Datos De Imss registrados éxitosamente";
        }
        $sql1= "INSERT INTO historicomovimientosimss (empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento, tipoMovimiento, fechaMovimiento, sdiMovimiento, FIntegracionMovimiento, SBCMovimiento, fechaAlta, registroMovimiento, usuarioEdicion, estatusmov, loteImss)
           VALUES('$entidadFederativaId','$empleadoConsecutivoId','$empleadoCategoriaId','4',now(),'$salarioDiario','$factorintegracion','$salariobasecotizacion','$fechaImss','$registroPatronal','$usuario','1','$NuevoLote')";      
            $res1 = mysqli_query($conexion, $sql1);
               // $log->LogInfo("Ejecutando consulta  sql1: " . $sql1);
            if ($res1 !== true) {
                $response["status"] = "error";
                $response["message"]='Ocurrio un error al registrar el Historico De Movimientos De imss';
                return;
            }else{
                $response ["status"] = "success";
                $response ["message"] = "Registro de Historico De Movimientos De Imss éxitosamente";
            }
        
        if( $response["status"] =='success'){
            $response["message"]='Sueldos Registrados Exitosamente';
        }
            }  
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
