<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_getPeticionesincidenciasEspeciales.log" , KLogger::DEBUG );
try {
    $lista = $negocio->getPeticionesIncidenciasEspeciales();
    for ($i = 0; $i < count($lista); $i++) {
        $numeroEmpleado= $lista[$i]["numeroempleado"];
        $nombreempleado= $lista[$i]["nombreempleado"];
        $puestoempleado= $lista[$i]["descripcionPuesto"];
        $puntoservicio=$lista[$i]["nombrepuntoservicio"];
        $roloperativo=$lista[$i]["roloperativoincidencia"];
        $descripcionincidenciaespecial= $lista[$i]["descripcionincidenciaespecial"];
        $fechaincidencia= $lista[$i]["Fechadeincidencia"];
        $supervisor=$lista[$i]["nombresupervisor"];
        $idPeticionIncidencia=$lista[$i]["idPeticionIncidencia"]; 
        
       

       
        $edicion = $lista[$i]["edicion"]               = "&nbsp; <img src='img/cancelar.png' title='CANCELAR' class='cursorImg' onclick='confirmarocancelarPeticionIncidenciaEspecial(\"" . $idPeticionIncidencia . "\",0);'>
          &nbsp;&nbsp;&nbsp; <img src='img/Ok-icon1.png' title='CONFIRMAR' class='cursorImg' onclick='confirmarocancelarPeticionIncidenciaEspecial(\"" . $idPeticionIncidencia . "\",1);'>";
    }
    $response["data"] = $lista;
    //$log->LogInfo("Valor de variable de lista2:" . var_export ($lista, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se pudo obtener lista de sueldos de empleados";
}
echo json_encode($response);
