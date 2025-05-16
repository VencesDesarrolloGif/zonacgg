<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$messages = array ();
verificarInicioSesion ($negocio);
$usuario = $_SESSION ["userLog"]["usuario"];

// $log = new KLogger ( "ajaxActualizaFechaReingreso.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable POST : " . var_export ($_POST, true));
if (!empty ($_POST))
{
    $empleadoId=getValueFromPost("numeroEmpleado");
    $empleadoidd = explode("-", $empleadoId);
    $empleadoEntidad=$empleadoidd[0];
    $empleadoConsecutivo=$empleadoidd[1];
    $empleadoCategoria=$empleadoidd[2];
    $fechaReingreso=getValueFromPost("fechaReingreso");
    $fechaingresooculto=getValueFromPost("fechaingresooculto");
    $fechaBaja=getValueFromPost("fechaBaja");
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    $idEntidadTrabajo=getValueFromPost("idEntidadTrabajo");
    $supervisorId=getValueFromPost("supervisor");
    $empleadoIdPuntoServicio=getValueFromPost("empleadoIdPuntoServicio");
    $puestoCubiertoId=getValueFromPost("empleadoIdPuesto");
    $rolId=getValueFromPost("empleadoIdTurno");
    $idTipoPuesto = getValueFromPost("idTipoPuesto");

    if($supervisorId=="NO APLICA" || $supervisorId =="RESPONSABLE ASISTENCIA"){
    	$supervisorEntidad=null;
    	$supervisorConsecutivo=null;
    	$supervisorCategoria=null;

    }else{
    	$supervisorIdd = explode("-", $supervisorId);
    	$supervisorEntidad=$supervisorIdd[0];
    	$supervisorConsecutivo=$supervisorIdd[1];
    	$supervisorCategoria=$supervisorIdd[2];
    }
 	
    $roloperativoplantillaserv=getValueFromPost("plantillaservicioreingreso");
    $plantillaservicioreingresoText=getValueFromPost("plantillaservicioreingresoText");
  	$datos=array (
        "idEntidadTrabajo" => getValueFromPost("idEntidadTrabajo"),
        "empleadoLineaNegocioId" => getValueFromPost("empleadoLineaNegocioId"),
        "idTipoPuesto" => getValueFromPost("idTipoPuesto"),
        "empleadoIdPuesto" => getValueFromPost("empleadoIdPuesto"),
        "idEntidadResponsableAsistencia" => $supervisorEntidad,
        "consecutivoResponsableAsistencia" => $supervisorConsecutivo,
        "tipoResponsableAsistencia" => $supervisorCategoria,
        "empleadoIdPuntoServicio" => $empleadoIdPuntoServicio,
        "supervisorId" => $supervisorId,
        "empleadoIdTurno" => getValueFromPost("empleadoIdTurno"),
        "idClientePunto" => getValueFromPost("idClientePunto"),
        "empleadoIdGenero" => getValueFromPost("empleadoIdGenero"),
        "tipoPeriodo" => getValueFromPost("tipoPeriodo"),
        "entidadId" => $empleadoEntidad,
        "consecutivoId" =>$empleadoConsecutivo,
        "tipoId" => $empleadoCategoria,
        "plantillaservicioreingreso" => $roloperativoplantillaserv,
        "bancoreingreso" => getValueFromPost("bancoreingreso"),
        "nocuentareingreso" =>  getValueFromPost("nocuentareingreso"),
        "cunetaclabereingreso" =>   getValueFromPost("cunetaclabereingreso"), 
        "avisoInscripcion0" =>  getValueFromPost("avisoInscripcion0"), 
        "avisoInscripcion1" =>  getValueFromPost("avisoInscripcion1"), 
        "avisoInscripcion2" =>  getValueFromPost("avisoInscripcion2"),         
        "avisoInscripcion3" =>  getValueFromPost("avisoInscripcion3"), 
        "valorchecklicenciaRE" =>  getValueFromPost("valorchecklicenciaRE"), 
        "numLicencia" =>  getValueFromPost("numLicencia"), 
        "fechavigenciaLicencia" =>  getValueFromPost("fechavigenciaLicencia"), 
        "AntiguedadVacacionesReingresoNo" =>  getValueFromPost("AntiguedadVacacionesReingresoNo"), 
        "AntiguedadVacacionesReingresoSi" =>  getValueFromPost("AntiguedadVacacionesReingresoSi"), 
        "horarioReingreso" =>  getValueFromPost("horarioReingreso"), 
        "NumeroFirmReingreso" =>  getValueFromPost("NumeroFirmReingreso"), 
        "contraseniaFirmReingreso" =>  getValueFromPost("contraseniaFirmReingreso"), 
        "gerenteReingreso" =>  getValueFromPost("gerenteReingreso"),
    );
    $empleado=array(
        "entidadId"=>$empleadoEntidad,
        "consecutivoId"=>$empleadoConsecutivo,
        "tipoId"=>$empleadoCategoria,
        "puntoServicioId"=>$empleadoIdPuntoServicio,
    );

    $supervisor=array(
        "entidadId"=>$supervisorEntidad,
        "consecutivoId"=>$supervisorConsecutivo,
        "tipoId"=>$supervisorCategoria,
    );
    
    $datosCuota = array (
        "puntoServicio" => $empleadoIdPuntoServicio,
        "puestoId" => $puestoCubiertoId,
        "rolId" => $rolId,
    );
    
    $datosEmpleado = array (
        "empleadoEntidadCuota" => $empleadoEntidad,
        "empleadoConsecutivoCuota" => $empleadoConsecutivo,
        "empleadoCategoriaCuota" => $empleadoCategoria,
    );
    try 
    {
        $negocio -> deleteElementFromPlantilla ( $empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
        if($datos["idTipoPuesto"]=='03'and $datos["empleadoLineaNegocioId"]==1 and $puestoCubiertoId != "" and $puestoCubiertoId != "PUESTO" and $rolId != "" and $rolId != "TURNO"){
            $itemSalario = $negocio -> getCuotaDiariaByPerfil($datosCuota);
            $existe = $negocio -> verificarSueldoEmpleado($datosEmpleado);
            $datosEmpleadoCuota = array (
                "sueldoEmpleado" => $itemSalario["sueldo"],
                "cuotaDiariaEmpleado" => $itemSalario["cuotaDiaria"],
                "empleadoEntidadCuota" => $empleadoEntidad,
                "empleadoConsecutivoCuota" => $empleadoConsecutivo,
                "empleadoCategoriaCuota" => $empleadoCategoria,
                "bonoAsistenciaEmpleado" => "0",
                "bonoPuntualidadEmpleado" => "0",
                "usuarioCapturaCuota" => $usuario,
                "lastUserEditedCuota" => $usuario,
            );
            if($itemSalario!="" && $existe==""){
                $negocio->insertSueldoEmpleado($datosEmpleadoCuota);
            }elseif($itemSalario!="" && $existe<>""){
                $negocio ->updateSueldoEmpleado($datosEmpleadoCuota);
            }
        }
        $datosR = array (); 
        $datosR ["requisicionId"] = $roloperativoplantillaserv;
        $datosR ["empleadoEntidadPlantilla"] = $empleadoEntidad;
        $datosR ["empleadoConsecutivoPlantilla"] = $empleadoConsecutivo;
        $datosR ["empleadoCategoriaPlantilla"] = $empleadoCategoria;
        $negocio -> insertEmpleadoPlantilla ($datosR);
        $negocio -> actualizarFechaReingreso($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $fechaReingreso, $fechaBaja, $usuarioCaptura, $datos,$fechaingresooculto);
        if($datos["idTipoPuesto"]=='03')
        {
            // Se realiza la asignación del elemento en la plantilla
            $periodos =$negocio -> getTiposPeriodos ();
            $tipoPeriodo = "";
            foreach ($periodos as $periodo)
            {
                if ($periodo ["tipoPeriodoId"] == $datos["tipoPeriodo"])
                {
                    $tipoPeriodo = $periodo ["descripcionTipoPeriodo"];
                }
            }
            $fechasPeriodo = $negocio -> obtenerListaDiasParaAsistencia ($tipoPeriodo);
            $fecha = $fechasPeriodo[0]["fecha"];
            while ($fecha<$fechaReingreso) {
                $registrado = $negocio-> registrarAsistencia (
                $empleado, 
                $supervisor, 
                11, 
                $fecha, 
                $usuarioCaptura,
                "", $tipoPeriodo, $puestoCubiertoId,$plantillaservicioreingresoText,$roloperativoplantillaserv);
                $fecha = date("Y-m-d", strtotime($fecha ."+ 1 days"));
            }
            $response ["status"] = "success";
            $response ["message"] = "Empleado registrado éxitosamente";
        }else{
            $response ["status"] = "success";
            $response ["message"] = "Empleado editado";
        }
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

$response ["messages"] = $messages;
echo json_encode ($response);
?>

