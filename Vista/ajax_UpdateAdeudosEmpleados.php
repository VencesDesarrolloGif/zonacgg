<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("ajax_UpdateAdeudosEmpleados.log", KLogger::DEBUG);

$negocio           = new Negocio ();
$response          = array();
$response["status"]= "error";
$datos             = array();
$IdEmpleado = $_POST["IdEmpleado"];

//$log->LogInfo("Valor de la variable $_POST: " . var_export ($_POST, true));

try {
    $datos = $negocio -> UpdateListaAdeudosEmpleados($IdEmpleado);

        for ($i = 0; $i < count($datos); $i++) {
        
        $DeudaEmpN = $datos[$i]["DeudaEmpleado"];
        $NombreArchivo = $datos[$i]["NombreArchivo"];
        $NumeroEmpleado = $datos[$i]["NumeroEmpleado"];

        $datos[$i]["DeudaEmpleado1"] = ($DeudaEmpN*(-1));


         $datos[$i]["rutarachivo"]="<img title='Abrir Archivo' src='img/documentosEntregados.png' class='cursorImg' id='btnguardar' onclick=abrirarchivoAdeudosEmpleados('".$NombreArchivo."','".$NumeroEmpleado."') >";   
        }      
        
//$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
                                                                              
    $response["status"] = "success";
    $response["datos"]  = $datos;
}catch (Exception $e) {
    $response["mensaje"]= "Error al Consultar Adeudos Empleados";}
echo json_encode($response);
