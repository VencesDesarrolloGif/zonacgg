<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";

$response                      = array();
$datos                         = array();
$datosfiscales                 = array();
$datosselectoresfrmsucur       = array();
$datostblfraccionprimariesgo   = array();
$datosselectoresfraccionyclase = array();
$idempresa                     = $_POST['idempresa'];
$IdRegistroPatronal            = $_POST['IdRegistroPatronal'];
$idsucursal                    = $_POST['idsucursal'];
$accion                        = $_POST['accion'];

if ($accion == 0) {
    $sql0    = "SELECT * FROM empresa";
    $ressql0 = mysqli_query($conexion, $sql0);
    while (($reg = mysqli_fetch_array($ressql0, MYSQLI_ASSOC))) {
        $datos[] = $reg;}}
if ($accion == 1) {
    $sql = "select distinct(crp.idcatalogoRegistrosPatronales),
        em.razonSocial, em.calleEmpresa,em.numExteriorEmpresa,em.numInteriorEmpresa,
        em.coloniaEmpresa,em.rfc,em.delegacionMuEmpresa,em.telefonoEmpresa,em.codPostalEmpresa,
        em.nombreRLEmpresa,em.apPaternoRLEmpresa,em.apMaternoRLEmpresa

 from empresa em
 left join sucursal suc on (em.idEmpresa=suc.idEmpresaSuc)
left join catalogoregistrospatronales crp
 on(crp.idcatalogoRegistrosPatronales=suc.IdRegistroPatronal)
                where idEmpresa='$idempresa';";
    $ressql = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($ressql, MYSQLI_ASSOC))) {
        $datosfiscales[] = $reg;}
}
if ($accion == 2) {
    $sql2 = "SELECT * FROM sucursal
                WHERE IdRegistroPatronal='$IdRegistroPatronal'";
    $ressql2 = mysqli_query($conexion, $sql2);
    while (($reg = mysqli_fetch_array($ressql2, MYSQLI_ASSOC))) {
        $datos[] = $reg;}}
if ($accion == 3) {
    $sql3 = "SELECT * FROM sucursal
                WHERE IdSuc='$idsucursal'";
    $ressql3 = mysqli_query($conexion, $sql3);
    while (($reg = mysqli_fetch_array($ressql3, MYSQLI_ASSOC))) {
        $datos[]               = $reg;
        $cp                    = $datos[0]["CodigoPostal"];
        $idfracciondelselector = $datos[0]["idFraccion"];}
    $sql4 = "SELECT *
                FROM asentamientos a
                    left join catalogotiposasentamientos cta on (a.asentamientoTipo=cta.idTipoAsentamiento)
                    left join catalogomunicipios cm on (a.municipioAsentamiento=cm.idMunicipio)
                    left join entidadesfederativas ef on (ef.idEntidadFederativa=cm.idEstado)
                where a.codigoPostalAsentamiento='$cp'";
    $ressql4 = mysqli_query($conexion, $sql4);
    while (($reg = mysqli_fetch_array($ressql4, MYSQLI_ASSOC))) {
        $datosselectoresfrmsucur[] = $reg;}
    $sql5 = "SELECT *
                FROM tablacuotariesgos
                    left join fracciongiro
                    on tablacuotariesgos.idRiesgo=fracciongiro.idRiesgo
                where fracciongiro.idFraccion='$idfracciondelselector'";
    $ressql5 = mysqli_query($conexion, $sql5);
    while (($reg = mysqli_fetch_array($ressql5, MYSQLI_ASSOC))) {
        $datosselectoresfraccionyclase[] = $reg;}}
if ($accion == 4) {
    $sql6 = "SELECT * FROM primariesgotrabajo
where idRegistro='$IdRegistroPatronal'";
    $ressql6 = mysqli_query($conexion, $sql6);
    while (($reg = mysqli_fetch_array($ressql6, MYSQLI_ASSOC))) {
        $datostblfraccionprimariesgo[] = $reg;}}
$response["datos"]                          = $datos;
$response["datosfiscales"]                  = $datosfiscales;
$response["datosparaselectoresfrmsucursal"] = $datosselectoresfrmsucur;
$response["datostblfraccionprimariesgo"]    = $datostblfraccionprimariesgo;
$response["datosselectoresfraccionyclase"]  = $datosselectoresfraccionyclase;
//$response["cppppp"]        = $cp;
echo json_encode($response);
//echo ($IdRegistroPatronal)
