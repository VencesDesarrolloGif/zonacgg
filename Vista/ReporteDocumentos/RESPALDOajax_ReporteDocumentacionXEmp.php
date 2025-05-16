<?php
session_start();
require_once("../../libs/logger/KLogger.php");
require "../conexion.php";
// $log = new KLogger("ajax_ReporteDocumentacion.log", KLogger::DEBUG);
$response = array();
$response["status"]= "error";
$nombreDocumentos= array();
$docDigitalizados= array();
$datosEmpleado= array();
$docCargados  = array();
$conteoDoc    = array();
$nombreEF     = array();
$conteoEmpXEntidad = array();
$busqueda      = $_POST["tipoDeBusqueda"];
$FechaInicioDoc= $_POST["FechaInicioConsultaDoc"];
$FechaFinDoc   = $_POST["FechaFinConsultaDoc"];

try {

    $sql = "SELECT idDocumento,nombreDocumento 
            FROM catalogodocumentos";
    $res = mysqli_query($conexion, $sql);

    while($reg = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
          $nombreDocumentos[]=$reg;
    }

    $sql3="SELECT idEntidadFederativa,nombreEntidadFederativa 
           FROM entidadesfederativas
           WHERE idEntidadFederativa!='33' AND idEntidadFederativa!='50'";
    $res3 = mysqli_query($conexion, $sql3);

    while($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC)) {
          $nombreEF[]=$reg3;
    }

    $largo = count($nombreEF);
    $nombreEF[$largo]["idEntidadFederativa"]= $largo;
    $nombreEF[$largo]["nombreEntidadFederativa"]= "Total";
    $response["entidades"]=$nombreEF;

    $totallEmpleados='0';

    for($z=0; $z < count($nombreEF); $z++){ 

        $idEF= $nombreEF[$z]["idEntidadFederativa"]; 
        // $conteoDoc="";

        $sql7 = "SELECT ifnull(count(concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId)),0) as noemp
                 FROM empleados e
                 WHERE (((e.empleadoEstatusId='1' or e.empleadoEstatusId='2') AND e.fechaIngresoEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE) or (e.empleadoEstatusId='0' AND e.fechaBajaEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE))))
                 AND idEntidadTrabajo='$idEF'";

        $res7 = mysqli_query($conexion, $sql7);

        while($reg7 = mysqli_fetch_array($res7, MYSQLI_ASSOC)) {
              $conteoEmpXEntidad[]=$reg7;
        }

        $response["entidades"][$z]["empleadosCount"]= $conteoEmpXEntidad[$z]["noemp"];

        if($z == $largo) {
           $response["entidades"][$largo]["empleadosCount"]=$totallEmpleados;
        }else{
              $totallEmpleados=$conteoEmpXEntidad[$z]["noemp"] + $totallEmpleados;
        }

        for($y=0; $y < count($nombreDocumentos); $y++){ 
            // $log->LogInfo("Valor de la variable y: " . var_export ($y, true));
            $conteoDoc='';
            if($z!=$largo){

                $idDocConteo = $nombreDocumentos[$y]["idDocumento"]; 

                $sql0 = "SELECT *
                         FROM empleados e
                         LEFT JOIN empleadosregistrodocumentacion erd on (erd.idEntidadEmpladoDocumento=e.entidadFederativaId AND erd.empleadoConsecutivoDocumento=e.empleadoConsecutivoId AND erd.empleadoTipoDocumento=e.empleadoCategoriaId)

                         LEFT JOIN empleados ea  ON(e.entidadFederativaId=ea.entidadFederativaId AND e.empleadoConsecutivoId=ea.empleadoConsecutivoId AND e.empleadoCategoriaId = ea.empleadoCategoriaId AND ea.idEntidadTrabajo='$idEF')
                         
                         WHERE (((e.empleadoEstatusId='1' or e.empleadoEstatusId='2') AND e.fechaIngresoEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE) or (e.empleadoEstatusId='0' AND e.fechaBajaEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE))))
                         AND erd.idDocumento='$idDocConteo'
                         AND ea.idEntidadTrabajo='$idEF'
                         group by erd.idEntidadEmpladoDocumento,erd.empleadoConsecutivoDocumento,erd.empleadoTipoDocumento";

                $res0 = mysqli_query($conexion, $sql0);

                while($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC)) {
                   $conteoDoc[]=$reg0;
                }

                if($conteoDoc=='') {
                    $response["entidades"][$z][$idDocConteo] = '0';
                    $b='0';
                }else{
                     $response["entidades"][$z][$idDocConteo] = count($conteoDoc);
                     $b = count($conteoDoc);
                    // $response["entidades"][$z][$idDocConteo]=$conteoDoc[$y][$idEF];
                }

                if($z=="0"){
                    $response["entidades"][$largo][$idDocConteo]="0";
                }

                $a = $response["entidades"][$largo][$idDocConteo];
                // $b = $conteoDoc[$y][$idEF];

                $response["entidades"][$largo][$idDocConteo]= $a+$b;
            }else{
                $response["entidades"][$z][$idDocConteo] = $response["entidades"][$largo][$idDocConteo];
            }
        }//for "y" Documentos
    }
    // datos del empleado
    $sql1 = "SELECT e.entidadFederativaId,
                    e.empleadoConsecutivoId,
                    e.empleadoCategoriaId,
                    concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as noemp,
                    concat_ws(' ', e.apellidoPaterno, e.apellidoMaterno, e.nombreEmpleado) as NombreEmpleado,
                    cee.descripcionEstatusEmpleado as EstatusEmpleado,
                    ifnull(e.NumEmpleadoFirmaAltaEMp,'SIN INFORMACIÓN') noContratante,
                    if(concat_ws(' ', ee.apellidoPaterno, ee.apellidoMaterno, ee.nombreEmpleado)='','SIN INFORMACIÓN',concat_ws(' ', ee.apellidoPaterno, ee.apellidoMaterno, ee.nombreEmpleado)) as nombreContratante
             FROM empleados e
             LEFT JOIN catalogoestatusempleados cee on (cee.estatusEmpleadoId=e.empleadoEstatusId)
             LEFT JOIN empleados ee on (e.NumEmpleadoFirmaAltaEMp=concat_ws('-',ee.entidadFederativaId,ee.empleadoConsecutivoId,ee.empleadoCategoriaId))
             WHERE (((e.empleadoEstatusId='1' or e.empleadoEstatusId='2') AND e.fechaIngresoEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE) or (e.empleadoEstatusId='0' AND e.fechaBajaEmpleado BETWEEN CAST('$FechaInicioDoc' AS DATE) AND CAST('$FechaFinDoc' AS DATE))))
             ORDER BY e.entidadFederativaId";
    $res1 = mysqli_query($conexion, $sql1);

    while($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC)) {
          $datosEmpleado[] = $reg1;
    }

    $conteoEmpleadosGeneral= count($datosEmpleado);

    for($i = 0; $i < count($datosEmpleado); $i++){
        $idEntidadEmpladoDocumento   = $datosEmpleado[$i]["entidadFederativaId"]; 
        $empleadoConsecutivoDocumento= $datosEmpleado[$i]["empleadoConsecutivoId"]; 
        $empleadoTipoDocumento       = $datosEmpleado[$i]["empleadoCategoriaId"]; 

        for($j = 0; $j < count($nombreDocumentos); $j++){
            $docCargados="";
            // informacion de documentos por empleado
            $idDoc = $nombreDocumentos[$j]['idDocumento'];
            $sql2 = "SELECT e.entidadFederativaId,
                            e.empleadoConsecutivoId,
                            e.empleadoCategoriaId,
                            e.apellidoPaterno,
                            e.apellidoMaterno,
                            e.nombreEmpleado,
                            e.empleadoEstatusId,
                            ifnull(count(erd1.idTipoDocumento) ,0)as Original,
                            ifnull((erd1.idEstatusDocumentos),'SN') as EstatusOriginal,
                            ifnull(count(erd21.idTipoDocumento) ,0)as Copia,
                            ifnull((erd21.idEstatusDocumentos),'SN') as EstatusCopia,
                            ifnull(count(edd.tipoDocumentoId) ,0)as OriginalD,
                            ifnull(edd.documentoEstatusId,0) as EstatusOriginalD,
                            ifnull(count(edd2.tipoDocumentoId) ,0)as CopiaD,
                            ifnull(edd2.documentoEstatusId,0) as EstatusCopiaD,
                            edd.nombreArchivoGuardado as DocumentoOriginal,
                            edd2.nombreArchivoGuardado as DocumentoCopia,
                            max(edd.idDocumentoDigitalizado) as MaxOriginal
                     FROM empleados e
                     LEFT JOIN empleadosregistrodocumentacion erd1 ON( e.entidadFederativaId=erd1.idEntidadEmpladoDocumento AND e.empleadoConsecutivoId=erd1.empleadoConsecutivoDocumento AND e.empleadoCategoriaId=erd1.empleadoTipoDocumento AND erd1.idDocumento='$idDoc'  AND erd1.idTipoDocumento='1')
                     LEFT JOIN empleadosregistrodocumentacion erd21 ON( e.entidadFederativaId=erd21.idEntidadEmpladoDocumento AND e.empleadoConsecutivoId=erd21.empleadoConsecutivoDocumento AND e.empleadoCategoriaId=erd21.empleadoTipoDocumento AND erd21.idDocumento='$idDoc'  AND erd21.idTipoDocumento='2')
                     LEFT JOIN empleadosdocumentos edd on (e.entidadFederativaId=edd.empleadoEntidadFederativaId AND e.empleadoConsecutivoId=edd.empleadoConsecutivo AND e.empleadoCategoriaId=edd.empleadoCategoriaId AND edd.documentoId='$idDoc'  AND edd.tipoDocumentoId='1' AND edd.idDocumentoDigitalizado=(select max(idDocumentoDigitalizado) FROM empleadosdocumentos WHERE empleadoEntidadFederativaId='$idEntidadEmpladoDocumento' AND empleadoConsecutivo='$empleadoConsecutivoDocumento' AND empleadoCategoriaId='$empleadoTipoDocumento' AND documentoId='$idDoc'))
                     LEFT JOIN empleadosdocumentos edd2 on (e.entidadFederativaId=edd2.empleadoEntidadFederativaId AND e.empleadoConsecutivoId=edd2.empleadoConsecutivo AND e.empleadoCategoriaId=edd2.empleadoCategoriaId AND edd2.documentoId='$idDoc'  AND edd2.tipoDocumentoId='2' AND edd2.idDocumentoDigitalizado=(select max(idDocumentoDigitalizado) FROM empleadosdocumentos WHERE empleadoEntidadFederativaId='$idEntidadEmpladoDocumento' AND empleadoConsecutivo='$empleadoConsecutivoDocumento' AND empleadoCategoriaId='$empleadoTipoDocumento' AND documentoId='$idDoc'))
                     WHERE e.entidadFederativaId='$idEntidadEmpladoDocumento'
                     AND e.empleadoConsecutivoId='$empleadoConsecutivoDocumento'
                     AND e.empleadoCategoriaId='$empleadoTipoDocumento'";

            $res2 = mysqli_query($conexion, $sql2);

            while($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC)) {
                $docCargados[] = $reg2;
            }

            $OriginalD= $docCargados[0]["OriginalD"];
            $CopiaD   = $docCargados[0]["CopiaD"];
            $Original = $docCargados[0]["Original"];
            $Copia    = $docCargados[0]["Copia"];
            $EstatusOriginal  = $docCargados[0]["EstatusOriginal"];
            $EstatusCopia     = $docCargados[0]["EstatusCopia"];
            $EstatusOriginalD = $docCargados[0]["EstatusOriginalD"];
            $EstatusCopiaD    = $docCargados[0]["EstatusCopiaD"];
            $DocumentoOriginal= $docCargados[0]["DocumentoOriginal"];
            $DocumentoCopia   = $docCargados[0]["DocumentoCopia"];
            $nombreDocumentoConsultado= $nombreDocumentos[$j]["nombreDocumento"];

            if($OriginalD=='0' && $CopiaD=='0'){
                if($Original=="1" && $Copia=="1"){
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="ORIGINAL Y COPIA";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]=$EstatusOriginal;
                }else if($Original=="1" && $Copia=="0"){
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="ORIGINAL";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]=$EstatusOriginal;
                }else if($Original=="0" && $Copia=="1"){
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="COPIA";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]=$EstatusCopia;
                }else{
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="NO ENTREGADO";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]="Sn";
                }
            }else{
                if($OriginalD=='1'){
                    $nombreDoc = explode("documentosdigitalizados", $DocumentoOriginal);
                    $nombreDocFinal1=$nombreDoc[1];
                    $nombreDocFinalSinDiagonal= explode("\\", $nombreDocFinal1);
                    $nombreDocFinal=$nombreDocFinalSinDiagonal[1];
                }else{
                    $nombreDoc = explode("documentosdigitalizados", $DocumentoCopia);
                    $nombreDocFinal1=$nombreDoc[1];
                    $nombreDocFinalSinDiagonal= explode("\\", $nombreDocFinal1);
                    $nombreDocFinal=$nombreDocFinalSinDiagonal[1];
                }

                if($Original=="1" && $Copia=="1"){
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="<img style='width: 50%' title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirDocEmpaaaaa('$nombreDocFinal')><br><label>ORIGINAL Y COPIA</label>";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]=$EstatusOriginal;
                }else if($Original=="1" && $Copia=="0"){
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="<img style='width: 50%' title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirDocEmpaaaaa('$nombreDocFinal')><br><label>ORIGINAL</label>";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]=$EstatusOriginal;
                }else if($Original=="0" && $Copia=="1"){
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="<img style='width: 50%' title='Abrir Documento' src='img/pdf.png' class='cursorImg' id='btnAbrirDoc' onclick=btnAbrirDocEmpaaaaa('$nombreDocFinal')><br><label>COPIA</label>";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]=$EstatusCopia;
                }else{
                    $datosEmpleado[$i]["$nombreDocumentoConsultado"]="NO ENTREGADO";
                    $datosEmpleado[$i]["status$nombreDocumentoConsultado"]="Sn";
                }          
            }
        }
    }
    $response["status"] = "success"; 
    $response["nombreDocumentos"]= $nombreDocumentos;
    $response["datosEmpleado"]= $datosEmpleado;
    // $log->LogInfo("Valor de la variable response: " . var_export ($response, true));                                                                      
}catch(Exception $e) {
       $response["mensaje"]= "Error al Consultar Adeudos Empleados";
      }
echo json_encode($response);
