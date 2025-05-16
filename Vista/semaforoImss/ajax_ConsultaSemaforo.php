<?php
session_start();
header('Content-Type: application/json');
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response= array();
$listaRegistrosPatronales= array();
$response["status"] = "error";
$log = new KLogger ( "ajax_ConsultaSemaforo.log" , KLogger::DEBUG );

$data = json_decode(file_get_contents('php://input'), true);
// $anio = $data['anio'];
$anio=date("Y");
try{
    // $anio=$_POST['anio'];
    $icsoe = array();
    $datosICSOE = array();

    $sisub = array();
    $datosSISUB = array();

    $movimientos = array();
    $datosMovimientos = array();

    $docOpImss = array();
    $datosDocOpImss = array();

    $docXMLImss = array();
    $datosXMLImss = array();

    $docXMLInfonavit = array();
    $datosXMLInfonavit = array();

    for($a = 0; $a < 4; $a++) {

        if($a==0) {
            $datosICSOE["nombreDocumentoCuatri"]="ICSOE";
            $datosSISUB["nombreDocumentoCuatri"]="SISUB";
        }else{
            $cuatrimestre = '0' . $a;
            $nombreDocumentoICSOE = "ICSOE_" . $cuatrimestre . $anio;

            $sqlICSOE = "SELECT NombreArchivoICSOE 
                    FROM documentos_ICSOE
                    WHERE NombreArchivoICSOE LIKE '%$nombreDocumentoICSOE%'
                    ORDER BY idArchivoICSOE DESC
                    LIMIT 1"; 
    
            $resICSOE = mysqli_query($conexion, $sqlICSOE);
            $idCuatrimestre = '';
            
            switch ($a) {
                case 1: $idCuatrimestre = 'cuatrimestreUno'; break;
                case 2: $idCuatrimestre = 'cuatrimestreDos'; break;
                case 3: $idCuatrimestre = 'cuatrimestreTres'; break;
            }
            
            if($regICSOE = mysqli_fetch_array($resICSOE, MYSQLI_ASSOC)) {           
                $nombreDocICSOE = $regICSOE["NombreArchivoICSOE"];            
                $datosICSOE[$idCuatrimestre]="<div style='text-align: center;'>" .
                                                "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocICSOE' onclick=abrirDocICSOE('$nombreDocICSOE')>".
                                            "</div>";
            } else {
                $datosICSOE[$idCuatrimestre]="<div style='text-align: center;'>" .
                                                "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                             "</div>";
            }
        
            $nombreDocumentoSISUB = "SISUB_" . $cuatrimestre . $anio;

            $sqlSISUB = "SELECT NombreArchivoSISUB 
                         FROM documentos_sisub
                         WHERE NombreArchivoSISUB LIKE '%$nombreDocumentoSISUB%'
                         ORDER BY idArchivoSISUB DESC
                         LIMIT 1"; 
    
            $resSISUB = mysqli_query($conexion, $sqlSISUB);

            If($regSISUB = mysqli_fetch_array($resSISUB, MYSQLI_ASSOC)) {           
               $nombreDocSISUB = $regSISUB["NombreArchivoSISUB"];            
               $datosSISUB[$idCuatrimestre]="<div style='text-align: center;'>" .
                                                "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocSISUB' onclick=abrirDocSISUB('$nombreDocSISUB')>".
                                            "</div>";
            }else {
                $datosSISUB[$idCuatrimestre]="<div style='text-align: center;'>" .
                                                "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                             "</div>";
            }
        }//ELSE A=0
    }//*for a CUTRIMESTRES
    
    for ($b=0; $b <= 12; $b++){

        if ($b<10) {
            $mes='0'.$b; 
        }else{
            $mes=$b;
        }

        //!EMPIEZA MOVIMIENTOS
        if($b==0){
            $datosMovimientos[$b] ='MOVIMIENTOS';
            $datosDocOpImss[$b]   ='OPINION DE CUMPLIMIENTO IMSS';
            $datosXMLImss[$b]     ='XML IMSS';
            $datosXMLInfonavit[$b]='XML INFONAVIT';

        }else{
            $nombrearchivoMovimientos='movimiento_'.$b.$anio;
            $sqlMovimientos = "SELECT NombreArchivoMov 
                               FROM documentos_movimientos
                               WHERE NombreArchivoMov LIKE '%$nombrearchivoMovimientos%'
                               ORDER BY idArchivoMov DESC
                               LIMIT 1"; 
    
            $resMovimientos = mysqli_query($conexion, $sqlMovimientos);

            If($regMovimientos = mysqli_fetch_array($resMovimientos, MYSQLI_ASSOC)) {           
               $nombreDocMovimientos = $regMovimientos["NombreArchivoMov"];            
               $datosMovimientos[$b]=  "<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocMovimientos' onclick=abrirDocMovimientos('$nombreDocMovimientos')>".
                                                    "</div>";
            }else {
                $datosMovimientos[$b]="<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                    "</div>";
            }
            //!EMPIEZA OPINION IMSS       
            $sqlDocOpImss = "SELECT nombreDocOpinionImss 
                             FROM catalogo_opinioncumplimientos_imss
                             WHERE mesOpImss= '$mes'
                             AND añoOpImss  = '$anio'
                             ORDER BY idOpinionCumplimientoImss DESC
                             LIMIT 1"; 
    
            $resDocOpImss = mysqli_query($conexion, $sqlDocOpImss);

            If($regDocOpImss = mysqli_fetch_array($resDocOpImss, MYSQLI_ASSOC)) {           
               $nombreDocOpImss = $regDocOpImss["nombreDocOpinionImss"];            
               $datosDocOpImss[$b]=  "<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocOpIMSS' onclick=abrirDocOpIMSS('$anio','$mes','$nombreDocOpImss')>".
                                                    "</div>";
            }else {
                $datosDocOpImss[$b]="<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                    "</div>";
            }
            //!EMPIEZA XML IMSS
            $nameArchivoXMLImss='XML_IMSS'.$mes.$anio;

            $sqlXMLImss = "SELECT NombreArchivoXMLImss 
                               FROM xml_imss
                               WHERE NombreArchivoXMLImss LIKE '%$nameArchivoXMLImss%'
                               ORDER BY idArchivoXMLImss DESC
                               LIMIT 1"; 
    
            $resXMLIMSS = mysqli_query($conexion, $sqlXMLImss);

            If($regXMLImss = mysqli_fetch_array($resXMLIMSS, MYSQLI_ASSOC)) {           
               $nombreDocXMLImss = $regXMLImss["NombreArchivoXMLImss"];            
               $datosXMLImss[$b]=  "<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocXMLImss' onclick=abrirDocXMLIMSS('$nombreDocXMLImss')>".
                                                    "</div>";
            }else {
                $datosXMLImss[$b]="<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                    "</div>";
            }
        
            //!EMPIEZA XML INFONAVIT
        
            $nameArchivoXMLInfonavit='XML_Infonavit'.$mes.$anio;

            $sqlXMLInfonavit = "SELECT NombreArchivoXMLInfonavit 
                               FROM xml_infonavit
                               WHERE NombreArchivoXMLInfonavit LIKE '%$nameArchivoXMLInfonavit%'
                               ORDER BY idArchivoXMLInfonavit DESC
                               LIMIT 1"; 
    
            $resXMLInfonavit = mysqli_query($conexion, $sqlXMLInfonavit);

            If($regXMLInfonavit = mysqli_fetch_array($resXMLInfonavit, MYSQLI_ASSOC)) {           
               $nombreDocXMLInfonavit = $regXMLInfonavit["NombreArchivoXMLInfonavit"];            
               $datosXMLInfonavit[$b]=  "<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocXMLInfonavit' onclick=abrirDocXMLINFONAVIT('$nombreDocXMLInfonavit')>".
                                                    "</div>";
            }else {
                $datosXMLInfonavit[$b]="<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                    "</div>";
            }
        }//else
    }//* FOR B MESES

    $sqlRegistrosPatronales="SELECT idcatalogoRegistrosPatronales 
                             FROM catalogoregistrospatronales
                             ORDER BY idcatalogoRegistrosPatronales";

    $resConsultaRegPat = mysqli_query($conexion, $sqlRegistrosPatronales);

    while (($reg = mysqli_fetch_array($resConsultaRegPat, MYSQLI_ASSOC))) {
        $listaRegistrosPatronales[] = $reg;
    }
    // $log->LogInfo("Valor de la variable listaRegistrosPatronales " . var_export ($listaRegistrosPatronales, true));
    $mesSeleccionado = $data['mes'];
    // $mesSeleccionado = $_POST['mes'];

    for($c=0; $c < count($listaRegistrosPatronales); $c++){
        
        $registroPatronal=$listaRegistrosPatronales[$c]["idcatalogoRegistrosPatronales"]; 

        // ! IDSE EBA
        $nameArchivoIDSEEBA='IDSE_EBA_'.$registroPatronal.'_'.$mesSeleccionado.$anio;
        
        $sqlIdseEBA  = "SELECT NombreArchivoIDSEEBA 
                        FROM idse_eba
                        WHERE NombreArchivoIDSEEBA LIKE '%$nameArchivoIDSEEBA%'
                        ORDER BY idArchivoIDSEEBA DESC
                        LIMIT 1"; 
    
        $resIdseEBA = mysqli_query($conexion, $sqlIdseEBA);

        If ($regIdseEBA = mysqli_fetch_array($resIdseEBA, MYSQLI_ASSOC)) {           
            $nombreDocIdseEBA = $regIdseEBA["NombreArchivoIDSEEBA"];            
            $listaRegistrosPatronales[$c]["idseEBA"]=  "<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocIDSEEBA' onclick=abrirDocIDSEEBA('$nombreDocIdseEBA')>".
                                                    "</div>";
        }else {
            $listaRegistrosPatronales[$c]["idseEBA"]="<div style='text-align: center;'>" .
                                                    "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                "</div>";
        }

        // ! IDSE EMA
        $nameArchivoIDSEEMA='IDSE_EMA_'.$registroPatronal.'_'.$mesSeleccionado.$anio;
        
        $sqlIdseEMA  = "SELECT NombreArchivoIDSEEMA 
                        FROM idse_ema
                        WHERE NombreArchivoIDSEEMA LIKE '%$nameArchivoIDSEEMA%'
                        ORDER BY idArchivoIDSEEMA DESC
                        LIMIT 1"; 
    
        $resIdseEMA = mysqli_query($conexion, $sqlIdseEMA);

        If ($regIdseEMA = mysqli_fetch_array($resIdseEMA, MYSQLI_ASSOC)) {           
            $nombreDocIdseEMA = $regIdseEMA["NombreArchivoIDSEEMA"];            
            $listaRegistrosPatronales[$c]["idseEMA"]=  "<div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocIDSEEMA' onclick=abrirDocIDSEEMA('$nombreDocIdseEMA')>".
                                                    "</div>";
        }else {
            $listaRegistrosPatronales[$c]["idseEMA"]="<div style='text-align: center;'>" .
                                                    "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                "</div>";
        }

        //!EMPIEZA OPINION Infonavit       
        $sqlDocOpInfonavit =   "SELECT nombreDocOpinionInf 
                                FROM catalogo_opinioncumplimientos_infonavit
                                WHERE mesOpInf= '$mesSeleccionado'
                                AND añoOpImss = '$anio'
                                ORDER BY idOpinionCumplimientoInfonavit DESC
                                LIMIT 1"; 

        $resDocOpInfonavit = mysqli_query($conexion, $sqlDocOpInfonavit);     

        If( $regDocOpInfonavit = mysqli_fetch_array($resDocOpInfonavit, MYSQLI_ASSOC)) {           
            $nombreDocOpInfonavit = $regDocOpInfonavit["nombreDocOpinionInf"];            
            $listaRegistrosPatronales[$c]["opInfonavit"]=  "<div style='text-align: center;'>" .
                                                                "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocIDSEEMA' onclick=abrirDocIDSEEMA('$nombreDocIdseEMA')>".
                                                            "</div>";
        } else{
                $listaRegistrosPatronales[$c]["opInfonavit"]="<div style='text-align: center;'>" .
                                                                "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                            "</div>";
        }
        
        //TODO:EMPIEZA PAGO SUA  
        $carpeta=$registroPatronal.$mesSeleccionado.$anio; 
        $ruta="../uploads/documentosContabilidad/pagoSua/".$carpeta;

        if (is_dir($ruta)) {

            //!RESUMEN LIQUIDACION       
            $sqlDocResumenLiquidacion ="SELECT nombreDocresumenLiquidacion 
                                        FROM resumenliquidacion
                                        WHERE mesresumenLiquidacion= '$mesSeleccionado'
                                        AND anioresumenLiquidacion = '$anio'
                                        and regPatronalresumenLiquidacion='$registroPatronal'"; 

            $resDocResumenLiquidacion = mysqli_query($conexion, $sqlDocResumenLiquidacion);     

            If( $regDocResumenLiquidacion = mysqli_fetch_array($resDocResumenLiquidacion, MYSQLI_ASSOC)) {           
                $nombreDocResumenLiquidacion = $regDocResumenLiquidacion["nombreDocresumenLiquidacion"];  

                $listaRegistrosPatronales[$c]["resumenLiquidacion"]="<div style='text-align: center;'>" .
                                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocResumenLiquidacion' onclick=abrirDocSUA('$nombreDocResumenLiquidacion','$carpeta')>".
                                                                    "</div>";
            } else{
                    $listaRegistrosPatronales[$c]["resumenLiquidacion"]="<div style='text-align: center;'>" .
                                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                        "</div>";
            }
    // $log->LogInfo("Valor de la variable listaRegistrosPatronalesaaaaaaaaaaaaaaaa " . var_export ($listaRegistrosPatronales, true));

            //!EMPIEZA LINEA DE CAPTURA

            $sqlDocLineaCaptura ="SELECT nombreDocLineaCapturaSUA 
                                        FROM catalogolineacapturasua
                                        WHERE mesLineaCapturaSUA= '$mesSeleccionado'
                                        AND anioLineaCapturaSUA = '$anio'
                                        AND regPatronalLineaCapturaSUA='$registroPatronal'"; 

            $resDocLineaCaptura = mysqli_query($conexion, $sqlDocLineaCaptura);     

            If( $regDocLineaCaptura = mysqli_fetch_array($resDocLineaCaptura, MYSQLI_ASSOC)) {           
                $nombreDocLineaCapturaSUA = $regDocLineaCaptura["nombreDocLineaCapturaSUA"];  
                $listaRegistrosPatronales[$c]["LineaCaptura"]="<div style='text-align: center;'>" .
                                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocLineaCaptura' onclick=abrirDocSUA('$nombreDocLineaCapturaSUA','$carpeta')>".
                                                                    "</div>";
            } else{
                    $listaRegistrosPatronales[$c]["LineaCaptura"]="<div style='text-align: center;'>" .
                                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                        "</div>";
            }

            //!EMPIEZA PUNTO SUA

            $sqlDocPuntoSUA  = "SELECT nombreDocPuntoSUA 
                                FROM catalogopuntosua
                                WHERE mesPuntoSUA= '$mesSeleccionado'
                                AND anioPuntoSUA = '$anio'
                                AND regPatronalPuntoSUA='$registroPatronal'"; 

            $resDocPuntoSUA = mysqli_query($conexion, $sqlDocPuntoSUA);     

            If( $regDocPuntoSUA = mysqli_fetch_array($resDocPuntoSUA, MYSQLI_ASSOC)) {           
                $nombreDocPuntoSUA = $regDocPuntoSUA["nombreDocPuntoSUA"];  
                $listaRegistrosPatronales[$c]["PuntoSUA"]="<div style='text-align: center;'>" .
                                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocPuntoSUA' onclick=abrirDocSUA('$nombreDocPuntoSUA','$carpeta')>".
                                                                    "</div>";
            } else{
                    $listaRegistrosPatronales[$c]["PuntoSUA"]="<div style='text-align: center;'>" .
                                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                        "</div>";
            }

            $archivoPago=$ruta."/Pago.pdf";

            if (file_exists($archivoPago)) {
                $log->LogInfo("Valor de la variable archivoPago " . var_export ($archivoPago, true));
                $listaRegistrosPatronales[$c]["PagoSUA"]="<div style='text-align: center;'>" .
                                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocSUA' onclick=abrirDocSUA('Pago.pdf','$carpeta')>".
                                                                    "</div>";
            } else {
                $listaRegistrosPatronales[$c]["PagoSUA"]  ="<div style='text-align: center;'>" .
                                                                "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                            "</div>";
            }

            $archivoInfonavit=$ruta."/Infonavit.pdf";

            if (file_exists($archivoInfonavit)) {
                $log->LogInfo("Valor de la variable archivoInfonavit " . var_export ($archivoInfonavit, true));
                $listaRegistrosPatronales[$c]["infonavit"]="<div style='text-align: center;'>" .
                                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocSUA' onclick=abrirDocSUA('Infonavit.pdf','$carpeta')>".
                                                                    "</div>";
            } else {
                    $listaRegistrosPatronales[$c]["infonavit"]="<div style='text-align: center;'>" .
                                                                    "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                "</div>";
            }

            $archivoImss=$ruta."/Imss.pdf";

            if (file_exists($archivoImss)) {
                $log->LogInfo("Valor de la variable archivoImss " . var_export ($archivoImss, true));
                $listaRegistrosPatronales[$c]["imss"]="<div style='text-align: center;'>" .
                                                                        "<img style='width: 2rem'; title='CARGADO' src='img/confirmarImss.png' class='cursorImg' id='btnAbrirDocSUA' onclick=abrirDocSUA('Imss.pdf','$carpeta')>".
                                                                    "</div>";
            } else {

                    $listaRegistrosPatronales[$c]["imss"]=" <div style='text-align: center;'>" .
                                                                "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                            "</div>";
            }
        }//?if existe carpeta
        else{
            $listaRegistrosPatronales[$c]["resumenLiquidacion"]="<div style='text-align: center;'>" .
                                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                        "</div>";
            $listaRegistrosPatronales[$c]["LineaCaptura"]="<div style='text-align: center;'>" .
                                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                        "</div>";
            $listaRegistrosPatronales[$c]["PuntoSUA"]="<div style='text-align: center;'>" .
                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                        "</div>";
            $listaRegistrosPatronales[$c]["PagoSUA"]="<div style='text-align: center;'>" .
                                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                        "</div>";
            $listaRegistrosPatronales[$c]["infonavit"]="<div style='text-align: center;'>" .
                                                                            "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                                        "</div>";
            $listaRegistrosPatronales[$c]["imss"]=" <div style='text-align: center;'>" .
                                                        "<img style='width: 2rem'; title='SIN CARGA' src='img/eliminar.png' class='cursorImg'".
                                                    "</div>";
        }
    }//for c
    
    
    $icsoe[] = $datosICSOE;
    $sisub[] = $datosSISUB;
    $movimientos[]= $datosMovimientos;
    $docOpImss[]  = $datosDocOpImss;
    $docXMLImss[]  = $datosXMLImss;
    $docXMLInfonavit[]  = $datosXMLInfonavit;

    $response["status"]= "success";
    $response["icsoe"] = $icsoe;
    $response["sisub"] = $sisub;
    $response["movimientos"]= $movimientos;
    $response["docOpImss"]  = $docOpImss;
    $response["docXMLImss"]  = $docXMLImss;
    $response["docXMLInfonavit"]  = $docXMLInfonavit;
    $response["docRegPat"]  = $listaRegistrosPatronales;

    // $log->LogInfo("Valor de la variable response " . var_export ($response, true));
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);