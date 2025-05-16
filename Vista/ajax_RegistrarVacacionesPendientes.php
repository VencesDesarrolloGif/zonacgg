<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_RegistrarVacacionesPendientes.log" , KLogger::DEBUG );

$vacacionesConfirmadasOtrasEmp=$_POST["DisVacacionesAceptadasOtrasE"];
$NumeroEmpleado=$_POST["NumeroEmpleado"];
$opcion=$_POST["opcion"];
$usuarioCapturaVacaciones = $_SESSION ["userLog"]["usuario"];
$Comentario = "Registro Desde Vacaciones Pendientes Por Ajuste";

$EmpleadoExplode = explode("-", $NumeroEmpleado);
$EmpleadoCategoria = $EmpleadoExplode[0];
$EmpleadoConsecutivo = $EmpleadoExplode[1];
$EmpleadoTipo = $EmpleadoExplode[2];

//$log->LogInfo("Valor de _POST" . var_export ($_POST, true));

try {
    if($opcion==1){
        $aniversario=$_POST["idSelector"];
        $vacacionesConfirmadas=$_POST["DiasVacacionesConfirmadas"];
        $fecharegistroVacaciones=$_POST["fecharegistroVacaciones"];
        $FechaExplode = explode("-", $fecharegistroVacaciones);
        $anio = $FechaExplode[0];
        $mes = $FechaExplode[1];
        $dia = $FechaExplode[2];
        for ($i = 0; $i < $vacacionesConfirmadas; $i++) {
            $NuevoDia = $dia+$i;
            $FechaVacaciones = strtotime ('+'.$NuevoDia.' day' , strtotime($fecharegistroVacaciones)); //Se añade un año mas
            $FechaVacaciones = date ('Y-m-d',$FechaVacaciones);// Se da formato a la fecha
            $DiasTrabajados  = $negocio -> InsertDiasVacacionesPendientes($EmpleadoCategoria,$EmpleadoConsecutivo,$EmpleadoTipo,$FechaVacaciones,$usuarioCapturaVacaciones,$Comentario,$aniversario);
        }
        $DiasTrabajados  = $negocio -> InsertDiasVacacionesPendientesOtrasEmpresas($EmpleadoCategoria,$EmpleadoConsecutivo,$EmpleadoTipo,$usuarioCapturaVacaciones,$Comentario,$vacacionesConfirmadasOtrasEmp);
    }else{
        $DiasTrabajados  = $negocio -> InsertDiasVacacionesPendientesOtrasEmpresas($EmpleadoCategoria,$EmpleadoConsecutivo,$EmpleadoTipo,$usuarioCapturaVacaciones,$Comentario,$vacacionesConfirmadasOtrasEmp);
    }
    $response["status"] = "success";
    $response["message"] = "Vacaciones Pendientes Registradas Correcatamente";

    } catch (Exception $e) {
       $response["message"] = "No Fue Posible Registrar Las Vacaciones Pendientes";}
echo json_encode($response);
