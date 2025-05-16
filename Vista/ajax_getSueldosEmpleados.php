<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);

$response = array("status" => "success");

    //$log = new KLogger ( "ajax_getSueldosEmpleados.log" , KLogger::DEBUG );
    //$estatusEmpleado=getValueFromPost("estatusEmpleado");

    try{
        
        $lista= $negocio -> getSueldosEmpleados();
        //$log->LogInfo("Valor de variable de lista:" . var_export ($lista, true));
   
        for ($i = 0; $i < count($lista); $i++)
        {   
            $numeroEmpleado = $lista[$i] ["numeroEmpleado"];
            $nombreEmpleado = $lista[$i] ["nombreEmpleado"];
            $fechaIngresoEmpleado = $lista[$i] ["fechaIngresoEmpleado"];
            $descripcionEstatusEmpleado = $lista[$i] ["descripcionEstatusEmpleado"];
            $descripcionPuesto = $lista[$i] ["descripcionPuesto"];
            $descripcionTurno = $lista[$i] ["descripcionTurno"];
            $puntoServicio = strtoupper($lista[$i] ["puntoServicio"]);
            $nombreEntidadFederativa = $lista[$i] ["nombreEntidadFederativa"];
            $sueldoEmpleado = $lista[$i] ["sueldoEmpleado"];
            $cuotaDiaria = $lista[$i] ["cuotaDiaria"];
            $bonoAsistencia = $lista[$i] ["bonoAsistencia"];
            $bonoPuntualidad = $lista[$i] ["bonoPuntualidad"];
            $entidadFederativaId = $lista[$i] ["entidadFederativaId"];
            $empleadoConsecutivoId = $lista[$i] ["empleadoConsecutivoId"];
            $empleadoCategoriaId = $lista[$i] ["empleadoCategoriaId"];

             $lienaNegocio = $lista[$i] ["empleadoLineaNegocioId"];
            $lista[$i]["edicion"] ="<img src='img/edit.png' class='cursorImg' onclick='showModalEdicionSueldo(\"".$numeroEmpleado."\",\"".$nombreEmpleado."\",\"".$fechaIngresoEmpleado."\",\"".$descripcionPuesto."\",\"".$descripcionTurno."\",\"".$puntoServicio."\",\"".$nombreEntidadFederativa."\",\"".$sueldoEmpleado."\",\"".$bonoAsistencia."\",\"".$bonoPuntualidad."\",\"".$cuotaDiaria."\",\"".$lienaNegocio."\");'>";
        }
        
        $response["data"]= $lista;
        //$log->LogInfo("Valor de variable de lista2:" . var_export ($lista, true));

        //$log->LogInfo("Valor de variable de estatusEmpleado que viene de form" . var_export ($estatusEmpleado, true));
        //$log->LogInfo("Valor de la variable \$response requisiciones: " . var_export ($response, true));
    } 
    catch( Exception $e )
    {
    $response["status"]="error";
    $response["error"]="No se pudo obtener lista de sueldos de empleados";
    }

echo json_encode($response);

?>