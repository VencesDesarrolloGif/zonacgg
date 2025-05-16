<?php
session_start();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
// $log=new KLogger("ajas_ConsultaPermanencia.log", KLogger::DEBUG);
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
$response = array();
$response["status"] = "error";

try {
    $fechai = getValueFromPost ("fechai");
    $fechaf = getValueFromPost ("fechaf");
    $lineaNeg = getValueFromPost ("lineaNeg");
    $tipoBusquedaPermanencia = getValueFromPost ("tipoBusquedaPermanencia");

    $empleados = $negocio -> obtenerempleadosPermanencia($fechai,$fechaf,$lineaNeg,$tipoBusquedaPermanencia);
    $TotalEmpleados= count($empleados);
    $diasDePermanenciaRequeridos = $TotalEmpleados*90;

    for ($i = 0; $i < $TotalEmpleados; $i++) {  
         
        $Estatus= $empleados[$i]["empleadoEstatus"];    
        $fechaIngresoEmp= $empleados[$i]["fechaIngresoEmpleado"];    
        $fechaBajaEmp= $empleados[$i]["fechaBajaEmpleado"];    
        $NumeroEmp= $empleados[$i]["NumeroEmpleado"];    
        $idpuntoServicio= $empleados[$i]["idPS"];    

       $nombreSupervisor = $negocio -> obtenerSupervisorPorEmpleado($idpuntoServicio);
       $noSup = count($nombreSupervisor);
       //$log->LogInfo("Valor de la variable noSup: " . var_export ($noSup, true));     
      // $Name = $nombreSupervisor[0]["SupervisorNombre"];
//$log->LogInfo("Valor de la variable response: " . var_export ($response, true));     

       if ($noSup=="0") {
        $empleados[$i]["NoSupervisor"]="SIN SUPERVISOR ASIGNADO";
        $empleados[$i]["SupervisorNombre"]="SIN SUPERVISOR ASIGNADO";
       }else{
       $empleados[$i]["NoSupervisor"]=$nombreSupervisor[0]["NoSupervisor"];
       $empleados[$i]["SupervisorNombre"]=$nombreSupervisor[0]["SupervisorNombre"];
     }

        if($Estatus== '0' ){
           $empleados[$i]["empleadoEstatus"]= "<label style='color:red'> BAJA </label>";
          }
        
        if($Estatus== "1" ){
           $empleados[$i]["empleadoEstatus"]= "<label style='color:green'> ACTIVO </label>";
          }

        if($Estatus== "2" ){
           $empleados[$i]["empleadoEstatus"]= "<label style='color:blue'> REINGRESO </label>";
          }

        if($fechaBajaEmp== "" || $fechaBajaEmp=="0000-00-00" || $fechaBajaEmp=="null" || $fechaBajaEmp==null || $fechaBajaEmp=="NULL" || $fechaBajaEmp==NULL){
           $empleados[$i]["fechaBajaEmpleado"]="<label style='color:green'> - </label>";
           $empleados[$i]["fechaBajaEmpleado1"]="-";
           $fechaBajaEmp = date('Y-m-d');
          }else{
                $empleados[$i]["fechaBajaEmpleado1"]="";
               }  
        $coberturaXEmpleado = $negocio -> obtenerCoberturaXEmp($fechaIngresoEmp,$fechaBajaEmp,$NumeroEmp);
        $empleados[$i]["cobertura"]=$coberturaXEmpleado[0]["TOTAL"];
    }

    $response["diasPermanenciaRequerida"]=$diasDePermanenciaRequeridos;
    $response["status"] = "success";
    $response["datos"]  = $empleados;

// $log->LogInfo("Valor de la variable response: " . var_export ($response, true));     
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
