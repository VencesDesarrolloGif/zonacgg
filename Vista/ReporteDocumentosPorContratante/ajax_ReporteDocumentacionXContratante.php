<?php
session_start();
require_once("../../libs/logger/KLogger.php"); 
require "../conexion.php";
// $log = new KLogger("ajax_ReporteDocumentacionXContratante.log", KLogger::DEBUG);
$response = array();
$response["status"]= "error";
$catalogoDoc= array();
$contratantesAltas = array();
$contratantesBajas = array();
$conteoContratadosActivos= array();
$conteoContratadosBajas  = array();
$conteoDocumentosActivos = array();
$conteoDocumentosBajas   = array();
$FechaInicioDoc= $_POST["FechaInicioConsultaDocCont"];
$FechaFinDoc   = $_POST["FechaFinConsultaDocCont"];

try {

    $sql = "SELECT idDocumento,nombreDocumento 
            FROM catalogodocumentos";
    $res = mysqli_query($conexion, $sql);

    while($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
          $catalogoDoc[]=$reg;
    }

    $sql0 = "SELECT distinct e.NumEmpleadoFirmaAltaEMp,
                concat_ws(' ', ee.apellidoPaterno, ee.apellidoMaterno, ee.nombreEmpleado) as nombreContratante,
                cee.descripcionEstatusEmpleado,
                ee.idEntidadTrabajo,
                ef.nombreEntidadFederativa
             FROM empleados e
             LEFT JOIN empleados ee ON (e.NumEmpleadoFirmaAltaEMp=concat_ws('-',ee.entidadFederativaId,ee.empleadoConsecutivoId,ee.empleadoCategoriaId))
             LEFT JOIN entidadesfederativas ef ON (ef.idEntidadFederativa=ee.idEntidadTrabajo)
             LEFT JOIN catalogoestatusempleados cee ON (cee.estatusEmpleadoId=ee.empleadoEstatusId)
             WHERE (((e.empleadoEstatusId='1' OR e.empleadoEstatusId='2') AND e.fechaIngresoEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE) or (e.empleadoEstatusId='0' AND e.fechaBajaEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE))))
             AND e.NumEmpleadoFirmaAltaEMp IS NOT NULL";

    $res0 = mysqli_query($conexion, $sql0);

    while($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
          $contratantesAltas[]=$reg0;
          $contratantesBajas[]=$reg0;
    }

    for($i=0; $i < count($contratantesAltas); $i++){ 

        $noContratante = $contratantesAltas[$i]["NumEmpleadoFirmaAltaEMp"]; 
        
        $sql1 = "SELECT count(entidadFederativaId) as conteoXContratanteAltas
                 FROM empleados e
                 WHERE ((e.empleadoEstatusId='1' or e.empleadoEstatusId='2') AND e.fechaIngresoEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE))
                 AND NumEmpleadoFirmaAltaEMp='$noContratante'";
        $res1 = mysqli_query($conexion, $sql1);
        while($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC)) {
              $conteoContratadosActivos[] = $reg1;
        }
        $contratantesAltas[$i]["contratados"] = $conteoContratadosActivos[$i]["conteoXContratanteAltas"];

        $sql2 = "SELECT count(entidadFederativaId) as conteoXContratanteBajas
                 FROM empleados e
                 WHERE (e.empleadoEstatusId='0' AND e.fechaBajaEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE))
                 AND NumEmpleadoFirmaAltaEMp='$noContratante'";
        $res2 = mysqli_query($conexion, $sql2);
        while($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC)) {
              $conteoContratadosBajas[] = $reg2;
        }
        $contratantesBajas[$i]["contratados"] = $conteoContratadosBajas[$i]["conteoXContratanteBajas"];

        for ($j=0; $j < count($catalogoDoc); $j++) { 
            $conteoDocumentosActivos=[];
            $conteoDocumentosBajas=[];
            $idDoc    = $catalogoDoc[$j]["idDocumento"]; 
            $nombreDoc= $catalogoDoc[$j]["nombreDocumento"]; 

            $sql3 = "SELECT idDocumento
                     FROM empleados e
                     LEFT JOIN empleadosregistrodocumentacion erd on (erd.idEntidadEmpladoDocumento=e.entidadFederativaId and erd.empleadoConsecutivoDocumento=e.empleadoConsecutivoId and erd.empleadoTipoDocumento=e.empleadoCategoriaId)
                     WHERE (e.empleadoEstatusId='1' or e.empleadoEstatusId='2') AND e.fechaIngresoEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE)
                     AND e.NumEmpleadoFirmaAltaEMp IS NOT NULL
                     AND erd.idDocumento='$idDoc'
                     AND e.NumEmpleadoFirmaAltaEMp='$noContratante'
                     group by idDocumento,entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId";
            $res3 = mysqli_query($conexion, $sql3);
            while($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC)) {
                  $conteoDocumentosActivos[] = $reg3;
            }

            if($conteoDocumentosActivos=='') {
               $contratantesAltas[$i][$nombreDoc] = '0';
            }else{
                $contratantesAltas[$i][$nombreDoc] = count($conteoDocumentosActivos);
            }

            $sql4 = "SELECT idDocumento
                     FROM empleados e
                     LEFT JOIN empleadosregistrodocumentacion erd on (erd.idEntidadEmpladoDocumento=e.entidadFederativaId and erd.empleadoConsecutivoDocumento=e.empleadoConsecutivoId and erd.empleadoTipoDocumento=e.empleadoCategoriaId)
                     WHERE (e.empleadoEstatusId='0' AND e.fechaBajaEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE))
                     AND e.NumEmpleadoFirmaAltaEMp IS NOT NULL
                     AND erd.idDocumento='$idDoc'
                     AND e.NumEmpleadoFirmaAltaEMp='$noContratante'
                     group by idDocumento,entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId";
            $res4 = mysqli_query($conexion, $sql4);
            while($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC)) {
                  $conteoDocumentosBajas[] = $reg4;
            }

            if($conteoDocumentosBajas==''){
                $contratantesBajas[$i][$nombreDoc] = '0';
            }else{
                $contratantesBajas[$i][$nombreDoc] = count($conteoDocumentosBajas);
            }
        }//for j
    }//for i
    $response["catalogoDoc"]= $catalogoDoc;
    $response["contratantesAltas"]= $contratantesAltas;
    $response["contratantesBajas"]= $contratantesBajas;
    $response["status"] = "success"; 
    // $log->LogInfo("Valor de la variable response: " . var_export ($response, true));                                                                      
}catch(Exception $e) {
       $response["mensaje"]= "Error al Consultar Adeudos Empleados";
      }
echo json_encode($response);
