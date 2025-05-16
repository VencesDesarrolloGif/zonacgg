<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_ConsultaElementosVetadosHistorico.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _POST " . var_export ($_POST, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $sql = "SELECT concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as NumeroEmpleado,concat_ws(' ',e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado) as NombreEmpleado,e.MotivoReingreso as MotivoVeto,v.ProcedenciaVetoEmp as ProcedenciaVeto,v.RutaArchivoVetoEMp as RutaArchivo,v.ExtencionVetoEMp as Extencion,v.ComentarioVetoEmp as ComentarioArchivo
        from empleados e
        left join vetoempledos v ON(e.entidadFederativaId=v.EntidadVetoEMp and e.empleadoConsecutivoId=v.ConsecutivoVetoEMp and e.empleadoCategoriaId=v.CategoriaVetoEMp)
        where e.EstatusReingreso='0'";     
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $ProcedenciaVeto = $datos[$i]["ProcedenciaVeto"];
        if($ProcedenciaVeto ==""){
            $datos[$i]["procedencia"] = "Supervisor";
            $datos[$i]["Archivo"] = "Sin Información";
        }else{
            $datos[$i]["procedencia"] = $ProcedenciaVeto;
            $RutaArchivo = $datos[$i]["RutaArchivo"];
            if($RutaArchivo ==""){
                $ComentarioArchivo = $datos[$i]["ComentarioArchivo"];
                $datos[$i]["Archivo"] = $ComentarioArchivo;
            }else{
                $Extencion = $datos[$i]["Extencion"];
                $datos[$i]["Archivo"]="<img style='width: 45%' title='Betar Al Empleado'src='img/pdf.jpg' class='cursorImg' id='btnRechazar' onclick=abrirPdfVetado('$RutaArchivo','$Extencion')>";
            }

        }
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
