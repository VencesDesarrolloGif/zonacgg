<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
/*

rfc                         = $("#inprfnuevoempresa").val();
cp                          = $("#inpcodigopostalnuevoempresa").val();
delemunicipio               = $("#inpdelmunnuevaempresa").val();
colonia                     = $("#inpcolonianuevaempresa").val();
calle                       = $("#inpcallenuevaempresa").val();
numerointerior              = $("#inpnuminteriornuevaempresa").val();
numeroexterior              = $("#inpnumexteriornuevaempresa").val();*/
$razonsocial        = $_POST['inprazonsocialnuevaempresa'];
$nombrereplegal     = $_POST['inpnombrereplegalempresa'];
$apepaternoreplegal = $_POST['inpapepaternoreplegalempresa'];
$apematernoreplegal = $_POST['inpapematernoreplegalempresa'];
$rfc                = $_POST['inprfnuevoempresa'];
$cp                 = $_POST['inpcodigopostalnuevoempresa'];
$delemunicipio      = $_POST['inpdelmunnuevaempresa'];
$colonia            = $_POST['inpcolonianuevaempresa'];
$calle              = $_POST['inpcallenuevaempresa'];
$numerointerior     = $_POST['inpnuminteriornuevaempresa'];
$numeroexterior     = $_POST['inpnumexteriornuevaempresa'];
$numerotelefonico   = $_POST['inptelefononuevaempresa'];

$response           = array();
$response["status"] = "error";
$datos              = array();

try {

    $sql = "INSERT INTO empresa(idEmpresa, calleEmpresa,razonSocial,rfc,numExteriorEmpresa,numInteriorEmpresa, coloniaEmpresa, delegacionMuEmpresa, telefonoEmpresa, codPostalEmpresa,nombreRLEmpresa,apPaternoRLEmpresa, apMaternoRLEmpresa)values('','$calle','$razonsocial','$rfc','$numeroexterior','$numerointerior','$colonia','$delemunicipio','$numerotelefonico','$cp','$nombrereplegal','$apepaternoreplegal','$apematernoreplegal')";

    $res = mysqli_query($conexion, $sql);

    $response["status"] = "success";
    //$response["datos"]  = $datos;

} catch (Exception $e) {

    $response["message"] = "Error al iniciar sesion";

}

echo json_encode($response);
