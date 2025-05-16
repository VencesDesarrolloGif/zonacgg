<?php
// file: ajax_registrarAsistencia.php

// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo. 
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();

verificarInicioSesion ($negocio);

$response = array ();

if (!empty ($_POST))
{

    // $log = new KLogger ( "ajaxRegistroIncicenciaEspecial.log" , KLogger::DEBUG );
    // datos de entrada por $_POST
    // empleadoEntidadId
    // empleadoConsecutivoId
    // empleadoTipoId
    // empleadoPuntoServicioId
    // supervisorEntidadId
    // supervisorConsecutivoId
    // supervisorTipoId
    // incidenciaId
    // asistenciaFecha (yyyy-mm-dd)
    $empleado ["entidadId"] = getValueFromPost ("empleadoEntidadId");
    $empleado ["consecutivoId"] = getValueFromPost ("empleadoConsecutivoId");
    $empleado ["tipoId"] = getValueFromPost ("empleadoTipoId");
    $empleado ["puntoServicioId"] = getValueFromPost ("empleadoPuntoServicioId");

    $supervisor ["entidadId"] = getValueFromPost ("supervisorEntidadId");
    $supervisor ["consecutivoId"] = getValueFromPost ("supervisorConsecutivoId");
    $supervisor ["tipoId"] = getValueFromPost ("supervisorTipoId");
    $comentariIncidencia=strtoupper(getValueFromPost ("comentariIncidencia"));

    $puntoServicioId=getValueFromPost ("empleadoPuntoServicioId");

    $incidenciaId = getValueFromPost ("incidenciaId");
    $asistenciaFecha = getValueFromPost ("asistenciaFecha");
    $usuarioCapturaAsistencia = $_SESSION ["userLog"]["usuario"];
    $tipoPeriodo=getValueFromPost ("tipoPeriodo");
    $incidenciaPuesto=getValueFromPost("incidenciaPuesto");

    $idCliente=getValueFromPost("idCliente");
    $selplantillaservicioincidencia=getValueFromPost("selplantillaservicioincidencia");
    // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($_POST, true));

  $bandera=true;
    
    try{
if($bandera){




        $requisiciones= $negocio -> getDetalleRequisicionesByPuntoServicioId($puntoServicioId,1,1);
        //$log->LogInfo("Valor de la variable \$requisiciones: " . var_export ($requisiciones, true));
        $puestos=array();
        $descripcionPuesto=array();

        for($i=0; $i<count($requisiciones); $i++){
            $puestos[$i]=$requisiciones[$i]["puestoPlantillaId"];
            $descripcionPuesto[$i]=$requisiciones[$i]["descripcionPuesto"];

       }

       if($idCliente<>13){

            if (in_array($incidenciaPuesto, $puestos)==false) {

                 

                $response ["status"] = "errorCobertura";
                $response ["message"] = "Puesto de cobertura invalido";
                $response["puestosCobertura"]=$descripcionPuesto;


            }else{

                $response = $negocio -> registrarIncidenciaEspecial (
                $empleado, 
                $supervisor, 
                $incidenciaId, 
                $asistenciaFecha, 
                $usuarioCapturaAsistencia,
                $comentariIncidencia,
                $tipoPeriodo, $incidenciaPuesto,$selplantillaservicioincidencia,"");

                
            }
        }else{

            $response = $negocio -> registrarIncidenciaEspecial (
            $empleado, 
            $supervisor, 
            $incidenciaId, 
            $asistenciaFecha, 
            $usuarioCapturaAsistencia,
            $comentariIncidencia,
            $tipoPeriodo, $incidenciaPuesto,$selplantillaservicioincidencia,"");

        }
        }else{
        $response ["status"] = "error";
        //$response ["message"] = $mensaje;
        }
     
     

    }catch(Exception $e){

        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();

    }

   
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>
