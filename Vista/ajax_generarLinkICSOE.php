<?php
session_start ();
require_once ("../libs/logger/KLogger.php");
require "conexion.php";
// $log = new KLogger ( "ajax_generarLinkICSOE.log" , KLogger::DEBUG );
// Obtenemos los datos del empleado
$response= array ();
$cuatrimestre =$_POST['cuatrimestre'];
$anio=$_POST['anio'];
$response["status"] = "success";
$datos = array();

//SISUB_012022_1
$nombreDocumento="ICSOE_".$cuatrimestre.$anio;

 $sql = "SELECT * 
            FROM documentos_ICSOE
            WHERE NombreArchivoICSOE LIKE '%$nombreDocumento%'
            ORDER BY idArchivoICSOE DESC
            LIMIT 1";      
            
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }
    if(count($datos)==1) {
        $nombredocumento=$datos[0]["NombreArchivoICSOE"];
        $directorio="uploads/DocumentosICSOE/".$nombredocumento."";
        $response["datos"]  = $nombredocumento;

}else{
    $response["status"] = "error";
    $response["message"] = "No hay archivos para descargar";
}

//$log->LogInfo("Valor de la variable zip: " . var_export ($zip, true));

echo json_encode($response);

?> 