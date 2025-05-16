<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";

$razonSocial        = $_POST['inprazonsocialnuevaempresa'];
$nombreRepLegal     = $_POST['inpnombrereplegalempresa'];
$apellidoPatRepLegal= $_POST['inpapepaternoreplegalempresa'];
$apellidoMatRepLegal= $_POST['inpapematernoreplegalempresa'];
$rfcEmpresa         = $_POST['inprfnuevoempresa'];
$cpEmpresa          = $_POST['inpcodigopostalnuevoempresa'];
$municipioEmpresa   = $_POST['inpdelmunnuevaempresa'];
$coloniaEmpresa     = $_POST['inpcolonianuevaempresa'];
$calleEmpresa       = $_POST['inpcallenuevaempresa'];
$numIntEmpresa      = $_POST['inpnuminteriornuevaempresa'];
$numExtEmpresa      = $_POST['inpnumexteriornuevaempresa'];
$telefonoEmpresa    = $_POST['inptelefononuevaempresa'];


$response           = array();
$response["status"] = "error";
//$datos              = array();
//$log = new KLogger("ajaxNewEmpresa.log", KLogger::DEBUG);
try {


    $sql = "INSERT INTO empresa(calleEmpresa, razonSocial, rfc, numExteriorEmpresa, numInteriorEmpresa, coloniaEmpresa, delegacionMuEmpresa, telefonoEmpresa, codPostalEmpresa, nombreRLEmpresa, apPaternoRLEmpresa, apMaternoRLEmpresa) values('$calleEmpresa','$razonSocial','$rfcEmpresa','$numExtEmpresa','$numIntEmpresa','$coloniaEmpresa','$municipioEmpresa','$telefonoEmpresa','$cpEmpresa','$nombreRepLegal','$apellidoPatRepLegal','$apellidoMatRepLegal')";

    //$log->LogInfo("Ejecutando New Empresa como: " . var_export ($sql, true));


    $res = mysqli_query($conexion, $sql);

    $response["status"] = "success";    

} catch (Exception $e) {

    $response["message"] = $e.getMessage();

}

echo json_encode($response);
