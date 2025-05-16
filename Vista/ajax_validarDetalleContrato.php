<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
// $log = new KLogger("ajax_validarDetalleContrato.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable idContratoCliente: " . var_export ($idContratoCliente, true));
$response= array();
$response["status"]= "error";
$numEmpModaldc=$_POST['NumEmpModaldc'];
$contraseniaInsertadaCifrada=$_POST['contraseniaInsertadaCifrada'];
$usuario = $_SESSION['userLog']['usuario'];
$idContratoCliente=$_POST['idContratoCliente'];

try{

   $sql ="UPDATE contratosclientes
          SET estatusValidacion='1',
              fechaValidacion =now(),
              usrValidacion='$usuario',
              noEmpFirmaValidacion='$numEmpModaldc',
              pwdFirmaValidacion='$contraseniaInsertadaCifrada'
          WHERE idContratoCliente='$idContratoCliente'";//agregar fecha de visualizacion del pdf

   $res = mysqli_query($conexion, $sql);
   $response["status"] = "success";
   $response["mensaje"]= "estatus revision actualizado";
}catch (Exception $e) {
   $response["mensaje"]= "Error al actualizar estatus revision de contrato";
}
echo json_encode($response);