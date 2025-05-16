<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
//$log = new KLogger("ajax_Consultabusqueda.log", KLogger::DEBUG);
//$log->LogInfo("Valor de la variable EmpleadoExistente: " . var_export ($EmpleadoExistente, true));
$negocio            = new Negocio ();
$response           = array();
$response["status"] = "error";
$datos              = array();
$usuario               = $_SESSION ["userLog"];
$NombreUsuario         = $_SESSION ["userLog"]["nombre"];
$apellidoPaternoUsuario= $_SESSION ["userLog"]["apellidoPaterno"];
$apellidoMaternoUsuario= $_SESSION ["userLog"]["apellidoMaterno"];
$entidad               = $_POST['entidad'];
$consecutivo           = $_POST['consecutivo'];
$categoria             = $_POST['categoria'];
try {
    $EmpleadoExistente = $negocio -> VerificarExistenciaEmpleado($entidad,$consecutivo,$categoria); 
    $ExistenciaDeEmpleado= $EmpleadoExistente[0]['ExistenciaDeEmpleado'];
    $EstatusImss         = $EmpleadoExistente[0]['EstatusImss'];
    $conteofiniquito     = $EmpleadoExistente[0]['conteofiniquito'];
    $estatusFiniquito    = $EmpleadoExistente[0]['estatusFiniquito'];
    
    if($ExistenciaDeEmpleado == "1" && $EstatusImss== "7" && $conteofiniquito!="0" && $estatusFiniquito !="1"){

         $datos = $negocio -> obtenerDatosBusqueda($entidad,$consecutivo,$categoria); 
         $fechaBaja              = $datos[0]["fechaBaja"];
         $nomemp                 = $datos[0]["nomemp"];
         $nombreEntidadFederativa= $datos[0]["nombreEntidadFederativa"];
         $diasDeVacaciones       = $datos[0]["diasDeVacaciones"]; 
         $prestamo1      = $negocio -> Amortizaciones($entidad,$consecutivo,$categoria,$fechaBaja,"1");
         $infonavit1     = $negocio -> Amortizaciones($entidad,$consecutivo,$categoria,$fechaBaja,"2");
         $pension1       = $negocio -> Amortizaciones($entidad,$consecutivo,$categoria,$fechaBaja,"3");
         $fonacot1       = $negocio -> Amortizaciones($entidad,$consecutivo,$categoria,$fechaBaja,"4");
         $Diastrabajados1= $negocio -> Amortizaciones($entidad,$consecutivo,$categoria,$fechaBaja,"5");  
         $Uniformesentregados1 = $negocio -> Amortizaciones($entidad,$consecutivo,$categoria,$fechaBaja,"6");    
         $datos["0"]["Prestamo"]                = $prestamo1["0"]["Prestamo"];
         $datos["0"]["PrestamoFechaCarga"]      = $prestamo1["0"]["FechaHoraCarga"];

         $datos["0"]["Infonavit"]               = $infonavit1["0"]["Infonavit"];
         $datos["0"]["InfonavitFechaCarga"]     = $infonavit1["0"]["FechaHoraCarga"];
    
         $datos["0"]["Pension"]                 = $pension1["0"]["Pension"];
         $datos["0"]["PensionFechaCarga"]       = $pension1["0"]["FechaHoraCarga"];
    
         $datos["0"]["Fonacot"]                 = $fonacot1["0"]["Fonacot"];
         $datos["0"]["FonacotFechaCarga"]       = $fonacot1["0"]["FechaHoraCarga"];

         $datos["0"]["DíasTrabajados"]          = $Diastrabajados1["0"]["DíasTrabajados"]; 
         $datos["0"]["DíasTrabajadosFechaCarga"]= $Diastrabajados1["0"]["FechaHoraCarga"]; 

         $datos["0"]["NombreUsuario"]           = $_SESSION ["userLog"]["nombre"];
         $datos["0"]["apellidoPaternoUsuario"]  = $_SESSION ["userLog"]["apellidoPaterno"];
         $datos["0"]["apellidoMaternoUsuario"]  = $_SESSION ["userLog"]["apellidoMaterno"];

         $datos["0"]["entidad"]    = $entidad;
         $datos["0"]["consecutivo"]= $consecutivo;  
         $datos["0"]["categoria"]  = $categoria;

         $datos["0"]["Uniformesentregados"]     = $Uniformesentregados1["0"]["Uniformesentregados"];
         $datos["0"]["UniformesFechaHoraCarga"] = $Uniformesentregados1["0"]["FechaHoraCarga"];

//$log->LogInfo("Valor de la variable Uniformesentregados: " . var_export ($datos["0"]["Uniformesentregados"], true));
//$log->LogInfo("Valor de la variable UniformesFechaHoraCarga: " . var_export ($datos["0"]["UniformesFechaHoraCarga"], true));

        $response["status"] = "success";
        $response["datos"]  = $datos;

    }else{
      $response["status"]  = "errorempleado";
      $response["menssaje"]= "El empleado no existe, aun no se ha procesado su baja O su finiquito ya fue confirmado";
    } 
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}

echo json_encode($response);
