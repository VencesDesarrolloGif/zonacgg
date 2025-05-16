<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
// $log = new KLogger("ajax_ConsultaEmpleadosConVacacionesPendientes.log", KLogger::DEBUG);
$OpcionBusqueda=$_POST["OpcionBusqueda"];
try {
    $datos = $negocio -> ObtenerEmpleadosConVacacionesPendientes($OpcionBusqueda); 
    // $log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));

   for ($i = 0; $i < count($datos); $i++) {
   
        $entidadEmpFiniquito     = $datos[$i]["entidadFederativaId"];
        $consecutivoEmpFiniquito = $datos[$i]["empleadoConsecutivoId"];
        $categoriaEmpFiniquito   = $datos[$i]["empleadoCategoriaId"];
        $nombreEmpleado     = $datos[$i]["nombreEmpleado"];
        $apellidoPaterno = $datos[$i]["apellidoPaterno"];
        $apellidoMaterno   = $datos[$i]["apellidoMaterno"];
        $NumeroEmpleado = $entidadEmpFiniquito . "-" .  $consecutivoEmpFiniquito . "-" . $categoriaEmpFiniquito;
        $NombreEmpleado = $nombreEmpleado . " " .  $apellidoPaterno . " " . $apellidoMaterno;
        $datos[$i]["NumeroEmpleado"] = $NumeroEmpleado;
        $datos[$i]["NombreEmpleado"] = $NombreEmpleado;

        $datos[$i]["editarVacaciones"]="<img style='width: 15%'title='Editar Registro Vacaciones' src='img/editIcon.png' class='cursorImg' id='VacacionesP' onclick=registrarVacacionesPendientes('$entidadEmpFiniquito','$consecutivoEmpFiniquito','$categoriaEmpFiniquito')>";

        $datos[$i]["EmpleadoRevisado"]="<img style='width: 15%'title='Confirmar Revisión' src='img/confirmarImss.png' class='cursorImg' id='VacacionesP' onclick=RegistrarRevisionEmpleado('$entidadEmpFiniquito','$consecutivoEmpFiniquito','$categoriaEmpFiniquito')>";
    } 
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
