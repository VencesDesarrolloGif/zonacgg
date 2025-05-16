<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_ActualizarAnivrsariosEmpleados.log" , KLogger::DEBUG );
try {
    $obtenerFechaIngreso = $negocio->obtenerFechaAltaEmpleadosTotales();
    $largoEmpleados = count($obtenerFechaIngreso);//==1646
    $fechaactual = date('Y-m-d'); // Fecha Actual
    $fechaactualMas1 = strtotime ('+1 year' , strtotime($fechaactual)); //Se añade un año mas
    $fechaactualMas1 = date ('Y-m-d',$fechaactualMas1);// Se da formato a la fecha


    for($i=0; $i<$largoEmpleados; $i++){
    //$log->LogInfo("Valor de i" . var_export ($i, true));
    //$log->LogInfo("Valor de i" . var_export ($i, true));
        $empladoEntidad = $obtenerFechaIngreso[$i]["empladoEntidad"];
        $empleadoConsecutivo = $obtenerFechaIngreso[$i]["empleadoConsecutivo"];
        $empleadoCategoria = $obtenerFechaIngreso[$i]["empleadoCategoria"];
        $FechaAltaEmpleadoEmpleados = $obtenerFechaIngreso[$i]["FechaAltaEmpleadoEmpleados"];
        // $log->LogInfo("Valor de FechaAltaEmpleadoEmpleados" . var_export ($FechaAltaEmpleadoEmpleados, true));

        if($FechaAltaEmpleadoEmpleados<"2014-01-01"){
        $FechaAltaEmpleado = $obtenerFechaIngreso[$i]["FechaAltaEmpleadoEmpleados"];
        }else{
        $FechaAltaEmpleado = $obtenerFechaIngreso[$i]["FechaAltaEmpleado"];
        }
        // $log->LogInfo("Valor de FechaAltaEmpleado" . var_export ($FechaAltaEmpleado, true));
        // $log->LogInfo("Valor de empladoEntidad" . var_export ($empladoEntidad, true));
        // $log->LogInfo("Valor de empleadoConsecutivo" . var_export ($empleadoConsecutivo, true));
        // $log->LogInfo("Valor de empleadoCategoria" . var_export ($empleadoCategoria, true));

        for($j=0; $j<18; $j++){
            $Aniversario=$j+1;
            $Aniversario1=$j+2;
            if($j==0){
                $FechaSiguente = strtotime ('+2 year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
                $FechaSiguente = date ('Y-m-d',$FechaSiguente);// Se da formato a la fecha
            }else{
                $FechaSiguente = strtotime ('+ '. $Aniversario1 .' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
                $FechaSiguente = date ('Y-m-d',$FechaSiguente);// Se da formato a la fecha
            }
            if($j==0){
                $FechaAnterior = strtotime ('+1 year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
                $FechaAnterior = date ('Y-m-d',$FechaAnterior);// Se da formato a la fecha
                //$FechaAnterior = $FechaAltaEmpleado;
            }else{
                $FechaAnterior = strtotime ('+ '. $Aniversario .' year' , strtotime($FechaAltaEmpleado)); //Se añade un año mas
                $FechaAnterior = date ('Y-m-d',$FechaAnterior);// Se da formato a la fecha
            }
            if($FechaSiguente < $fechaactualMas1){
                //$log->LogInfo("Valor de empladoEntidad" . var_export ($empladoEntidad, true));
                //$log->LogInfo("Valor de empleadoConsecutivo" . var_export ($empleadoConsecutivo, true));
                //$log->LogInfo("Valor de empleadoCategoria" . var_export ($empleadoCategoria, true));
                //$log->LogInfo("Valor de Aniversario" . var_export ($Aniversario, true));

                $updateAniversario = $negocio->UpdateAsistenciaAniversario($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria,$Aniversario,$FechaSiguente,$FechaAnterior);//actualizar el campo de aniversarios en asistencia 
            }  
        }
    }






    
}catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No Se Obtuvieron Puestos";
}
echo json_encode($response);
