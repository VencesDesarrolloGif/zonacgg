<?php
session_start ();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_EliminarDocSAT.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
$response = array();
$datos = array();
$response["status"] = "success";
$idDocumento =$_POST["idDocumento"];
$opcion =$_POST["opcion"];
$nombreDocSAT =$_POST["nombreDocSAT"];
$usuario = $_SESSION ["userLog"]["usuario"];

    try{
        if ($opcion=='1'){
            $sql = "UPDATE catalogoDeclaracionISR
                    SET estatusDecISR='0', fechaEliminadoDecISR=now(),USReliminaDecISR='$usuario'
                    WHERE idDecISR=$idDocumento";
        }if ($opcion=='2'){
            $sql = "UPDATE catalogoDeclaracionIVA
                    SET estatusDecIVA='0', fechaEliminadoDecIVA=now(),USReliminaDecIVA='$usuario'
                    WHERE idDecIVA=$idDocumento";
        }if ($opcion=='3'){
            $sql = "UPDATE catalogoPagosISR
                    SET estatusDocPagoISR='0', fechaEliminadoPagoISR=now(),USReliminaPagoISR='$usuario'
                    WHERE idPagoISR=$idDocumento";
        }if ($opcion=='4'){
            $sql = "UPDATE catalogoPagosIVA
                    SET estatusDocPagoIVA='0', fechaEliminadoPagoIVA=now(),USReliminaPagoIVA='$usuario'
                    WHERE idPagoIVA=$idDocumento";
        }if ($opcion=='5'){
            $sql = "UPDATE catalogoOpinionSAT
                    SET estatusDocOpinionSAT='0', fechaEliminadoOpinionSAT=now(),USReliminaOpinionSAT='$usuario'
                    WHERE idOpinionSAT=$idDocumento";
        }if ($opcion=='6'){
            $sql = "UPDATE catalogoConstanciaSituacionFiscal
                    SET estatusDocConstanciaSitFis='0', fechaEliminadoConstanciaSitFis=now(),USReliminaConstanciaSitFis='$usuario'
                    WHERE idConstanciaSitFis=$idDocumento";
        }if ($opcion=='7'){
            $sql = "UPDATE catalogoAFFIDAVIT
                    SET estatusDocAFFIDAVIT='0', fechaEliminadoAFFIDAVIT=now(),USReliminaAFFIDAVIT='$usuario'
                    WHERE idAFFIDAVIT=$idDocumento";
        }
        $res = mysqli_query($conexion, $sql);

        if ($res !== true) {
            $response["status"] = "error";
            $response["mensaje"]= 'error al eliminar documento';
            return;
        }else{
            $response["mensaje"]='Documento eliminado correctmente';
            if ($opcion=='1') {
                unlink("../uploads/DeclaracionISR/". $nombreDocSAT."");
            }if ($opcion=='2') {
                unlink("../uploads/DeclaracionIVA/". $nombreDocSAT."");
            }if ($opcion=='3') {
                unlink("../uploads/PagosISR/". $nombreDocSAT."");
            }if ($opcion=='4') {
                unlink("../uploads/PagosIVA/". $nombreDocSAT."");
            }if ($opcion=='5') {
                unlink("../uploads/OpinionSAT/". $nombreDocSAT."");
            }if ($opcion=='6') {
                unlink("../uploads/ConstanciaDeSituacionFiscal/". $nombreDocSAT."");
            }if ($opcion=='7') {
                unlink("../uploads/AFFIDAVIT/". $nombreDocSAT."");
            }
        }

    }catch(PDOException $e){
        $response["status"] = "error";
        $response["mensaje"]= "error de conexion a la BD";
    }
echo json_encode ($response);