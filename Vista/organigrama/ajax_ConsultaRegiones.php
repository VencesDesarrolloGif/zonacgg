<?php
session_start();
require "../conexion.php";
require_once ("../../libs/logger/KLogger.php");
date_default_timezone_set('America/Mexico_City');
$response = array();
$response["status"] = "error";
$log = new KLogger ("ajax_ConsultaRegiones.log" , KLogger::DEBUG );
$entidad = $_SESSION["userLog"]["entidadFederativaUsuario"][0];

    $log->LogInfo("Valor de variable session" . var_export ($_SESSION, true));


try {
    $sql = " SELECT * 
             FROM catalogo_organigramaniveles
             ORDER BY idNivelOrg";
    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
           $catalogoNiveles[] = $reg;
    }
    $response["niveles"]  = $catalogoNiveles;
    $log->LogInfo("Valor de variable catalogoNiveles" . var_export ($catalogoNiveles, true));

    // RELACIONES DEPARTAMENTOS NIVELES Y DEPARTAMENTO A CARGO

    $sql1 = "SELECT cdn.idRelacionDN, cdn.idDepartamento,cod.descripcionDepartamento, cdn.idNivel, cdn.departamentoACargo,coda.descripcionDepartamento as DepartamentoACargo,descripcionNivel
             FROM relaciondepartamentosniveles cdn
             LEFT JOIN catalogo_organigramaniveles con ON (con.idNivelOrg=cdn.idNivel)
             LEFT JOIN catalogo_organigramadepartamentos cod ON (cod.idDepartamentoOrg=cdn.idDepartamento)
             LEFT JOIN catalogo_organigramadepartamentos coda ON (coda.idDepartamentoOrg=cdn.departamentoACargo)";
            
    $res1 = mysqli_query($conexion, $sql1);

    while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           $datos1[] = $reg1;
    }
    $response["relacionDepartamentosNivelesYaCargo"]  = $datos1;


    for ($i=0; $i < count($catalogoNiveles); $i++){ 

        $idNivel= $catalogoNiveles[$i]["idNivelOrg"];
        $nombreNivel= $catalogoNiveles[$i]["descripcionNivel"];
        $depa= $catalogoNiveles[$i]["descripcionNivel"];




        $organigrama[$i]["idNivel"]=$idNivel;
        $organigrama[$i]["nombreNivel"]=$nombreNivel;
        $organigrama[$i]["departamento"]=$nombreNivel;
    }






    $response["status"] = "success";
}catch(Exception $e){
       $response["message"] = "Error al iniciar sesion";
}
echo json_encode($response);