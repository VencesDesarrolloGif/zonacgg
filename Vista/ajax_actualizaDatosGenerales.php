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
if (!empty ($_POST))
{
    // $log = new KLogger ( "ajaxActualizaDatosGenerales.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
    $usuario = $_SESSION ["userLog"]["usuario"];
    $fotoEmpleado=getValueFromPost ("idFotoEmpleadoEdited");
    $puntoServicioConsultaSend=getValueFromPost("puntoServicioConsultaSend");
    $puestoConsultaSend=getValueFromPost("puestoConsultaSend");
    $dirigenteEdited1 = getValueFromPost("dirigenteEdited");
	if($dirigenteEdited1 =="" || $dirigenteEdited1=="0" || $dirigenteEdited1==null || $dirigenteEdited1==NULL || $dirigenteEdited1=="null" || $dirigenteEdited1=="NULL" || $dirigenteEdited1=="NO APLICA" || $dirigenteEdited1=="RESPONSABLE ASISTENCIA"){
		$idEntidadResponsableAsistencia="";
		$consecutivoResponsableAsistencia="";
		$tipoResponsableAsistencia="";
	}else{
		$dirigenteEdited = explode("-", $dirigenteEdited1);
		$idEntidadResponsableAsistencia=$dirigenteEdited[0];
		$consecutivoResponsableAsistencia=$dirigenteEdited[1];
		$tipoResponsableAsistencia=$dirigenteEdited[2];
	}
	$selectReclutadorEdited1 = getValueFromPost("selectReclutadorEdited");
	if($selectReclutadorEdited1 =="" || $selectReclutadorEdited1=="0" || $selectReclutadorEdited1==null || $selectReclutadorEdited1==NULL || $selectReclutadorEdited1=="null" || $selectReclutadorEdited1=="NULL" || $selectReclutadorEdited1=="NO APLICA" || $selectReclutadorEdited1=="RECLUTADOR" ){
		$reclutadorEntidad="";
		$reclutadorConsecutivoId="";
		$reclutadorTipo="";
	}else{
		$selectReclutadorEdited = explode("-", $selectReclutadorEdited1);
		$reclutadorEntidad=$selectReclutadorEdited[0];
		$reclutadorConsecutivoId=$selectReclutadorEdited[1];
		$reclutadorTipo=$selectReclutadorEdited[2];
	}

    $apellidoPaternoEmpleadoEdited= $_POST['apellidoPaternoEmpleadoEdited'];
    $apellidoMaternoEmpleadoEdited= $_POST['apellidoMaternoEmpleadoEdited'];
    $nombreEmpleadoEdited= $_POST['nombreEmpleadoEdited'];

    $apellidoPaternoEmpleadoEdited = str_replace(
    array('ñ','Ñ'),
    array('Ñ','Ñ'),
    $apellidoPaternoEmpleadoEdited);

    $apellidoMaternoEmpleadoEdited = str_replace(
    array('ñ','Ñ'),
    array('Ñ','Ñ'),
    $apellidoMaternoEmpleadoEdited);

    $nombreEmpleadoEdited = str_replace(
    array('ñ','Ñ'),
    array('Ñ','Ñ'),
    $nombreEmpleadoEdited);

    $empleado = array (
    "entidadFederativaId" => getValueFromPost("numeroEmpleadoEntidadEdited"),
    "empleadoConsecutivoId" => getValueFromPost("numeroEmpleadoConsecutivoEdited"),
    "empleadoCategoriaId" => getValueFromPost("numeroEmpleadoTipoEdited"),
    "apellidoPaterno" =>strtoupper($apellidoPaternoEmpleadoEdited),
    "apellidoMaterno" =>strtoupper($apellidoMaternoEmpleadoEdited),
    "nombreEmpleado" => strtoupper($nombreEmpleadoEdited),
    "fechaIngresoEmpleado" => getValueFromPost("fechaIngresoEdited"),
    "empleadoIdPuesto" => getValueFromPost("puestoEdited"),
    "empleadoIdPuntoServicio" =>getValueFromPost("puntoServicio"),
    "empleadoIdTurno" => getValueFromPost("tipoTurnoEdited"),
    "tesEmpleado" => getValueFromPost("tesEdited"),
    "estaturaEmpleado" => getValueFromPost("estaturaEmpleadoEdited"),
    "tallaCEmpleado" => getValueFromPost("tallaCEmpleadoEdited"),
    "tallaPEmpleado" => getValueFromPost("tallaPEmpleadoEdited"),
    "numCalzadoEmpleado" => getValueFromPost("numEmpleadoEdited"),    
    "pesoEmpleado" => getValueFromPost("pesoEmpleadoEdited"),
    "empleadoIdGenero" => getValueFromPost("generoEdited"),  
    "claveINE" => getValueFromPost("claveINE"),  
    "empleadoNumeroSeguroSocial" => getValueFromPost("numeroSeguroSocialEdited"),
    "bancoEdit" => getValueFromPost("selBancoEdit"),
    "numeroCta" => getValueFromPost("txtNumeroCtaEdited"),
    "numeroCtaClabe" => getValueFromPost("txtCtaClabeEdited"),
    "OpcionTarjetaDeDespensaEdit" => getValueFromPost("OpcionTarjetaDeDespensaEdit"),
    "IutDespensa" => getValueFromPost("txtnumeroIutEdited"),
    "txtnumeroFirmaempleadoEdit" => getValueFromPost("txtnumeroFirmaempleadoEdit"),
    "ContraseniaFirmaempEdit" => getValueFromPost("ContraseniaFirmaempEdit"),
    "curpEmpleado" => strtoupper(getValueFromPost("txtCurpEdited")),
    "rfcEmpleado" => strtoupper(getValueFromPost("txtRfcEdited")),
    "fechaBajaEmpleado" => getValueFromPost("txtfechaBajaEmpleado"),
    "idTipoPuesto" => getValueFromPost("tipoPuestoEdited"),
    "idEntidadTrabajo" => getValueFromPost("idEndidadFederativaEdited"),
    "idEndidadFederativaLocalizacion" => getValueFromPost("idEndidadFederativaParaSucursalEdited"),
    "idEntidadResponsableAsistencia" => $idEntidadResponsableAsistencia,
    "consecutivoResponsableAsistencia" =>$consecutivoResponsableAsistencia,
    "tipoResponsableAsistencia" => $tipoResponsableAsistencia,
    "empleadoLineaNegocioId" => getValueFromPost("selectLineaNegocioEdited"),
    "fotoEmpleado" => getValueFromPost ("idFotoEmpleadoEdited"),
    "tipoPeriodo" => getValueFromPost ("periodoEdited"),
    "clienteId" => getValueFromPost ("txtClienteIdEdited"),
    "responsableAsistencia" => getValueFromPost ("dirigenteEdited"),
    "userEdited" => $usuario,
    "medioInformacionVacanteId" => getValueFromPost("selectMedioInformacionEdited"),
    "reclutadorId" => getValueFromPost("selectReclutadorEdited"),
    "reclutadorEntidad" => $reclutadorEntidad,
    "reclutadorConsecutivoId" => $reclutadorConsecutivoId,
    "reclutadorTipo" => $reclutadorTipo,
    "plantillaserv" => getValueFromPost("selplantillaserv"),
    "licenciaConducirEdited" => getValueFromPost("licenciaConducirEdited"),
    "numerolicenciaEdited" => getValueFromPost("numerolicenciaEdited"),
    "inpfehavigencialicenciaEdited" => getValueFromPost("inpfehavigencialicenciaEdited"),
    "idRolOpertaivoParaPlantilla" => getValueFromPost("idRolOpertaivoPorPlantilla"),
    "plantillaText" => getValueFromPost("plantillaText"),
    "licenciaConducirpermanenteEdited" => getValueFromPost("licenciaConducirpermanenteEdited"),
    "ContactoGif" => getValueFromPost("ContactoGif"),
    "CorreoGif" => strtolower(getValueFromPost("CorreoGif")),
    "banderaCambioRP" => getValueFromPost("banderaCambioRP"),
    "rpNuevo" => getValueFromPost("rpNuevo"),
    "selHorarioCons" => getValueFromPost("selHorarioCons"),
    "gerenteRegSupEdit" => getValueFromPost("gerenteRegSupEdit"),    
    );
    $datosCuota = array ( 
    "puntoServicio" => getValueFromPost("puntoServicio"),
    "puestoId" => getValueFromPost("puestoEdited"), 
    "rolId" => getValueFromPost("tipoTurnoEdited"),
    );
    $datosEmpleado = array (
    "empleadoEntidadCuota" => getValueFromPost("numeroEmpleadoEntidadEdited"),
    "empleadoConsecutivoCuota" => getValueFromPost("numeroEmpleadoConsecutivoEdited"),
    "empleadoCategoriaCuota" => getValueFromPost("numeroEmpleadoTipoEdited"),
    );
    try 
    {
        $negocio -> deleteElementFromPlantilla( $empleado["entidadFederativaId"],$empleado["empleadoConsecutivoId"],$empleado ["empleadoCategoriaId"]);
        $negocio -> negocio_editarDatosGenerales($empleado);
        if ($fotoEmpleado <> ""){
            $negocio ->actualizarFotoEmpleado($empleado);
        }
        $datos = array ();
        $datos ["requisicionId"] = $empleado ["plantillaserv"];
        $datos ["empleadoEntidadPlantilla"] = $empleado["entidadFederativaId"];
        $datos ["empleadoConsecutivoPlantilla"] = $empleado["empleadoConsecutivoId"];
        $datos ["empleadoCategoriaPlantilla"] = $empleado ["empleadoCategoriaId"];
        // Se realiza la asignación del elemento en la plantilla
        $negocio -> insertEmpleadoPlantilla ($datos);    
        if($empleado["idTipoPuesto"]=='02'){
            $response ["status"] = "success";
            $response ["message"] = "Empleado editado";
        }else{ // termina edicion si el elemento es administrativo de la linea de negocio SF               
            $itemSalario = $negocio -> getCuotaDiariaByPerfil($datosCuota);
            $existe = $negocio -> verificarSueldoEmpleado($datosEmpleado);
            if($empleado["empleadoIdPuesto"]<>$puestoConsultaSend or $empleado["empleadoIdPuntoServicio"]<>$puntoServicioConsultaSend)
            {
                if($itemSalario!="" && $existe==""){
                    $datosEmpleadoCuota = array (
                        "sueldoEmpleado" => $itemSalario["sueldo"],
                        "cuotaDiariaEmpleado" => $itemSalario["cuotaDiaria"],
                        "empleadoEntidadCuota" => $empleado["entidadFederativaId"],
                        "empleadoConsecutivoCuota" => $empleado["empleadoConsecutivoId"],
                        "empleadoCategoriaCuota" => $empleado["empleadoCategoriaId"],
                        "bonoAsistenciaEmpleado" => "0",
                        "bonoPuntualidadEmpleado" => "0",
                        "usuarioCapturaCuota" => $usuario,
                    );
                     $negocio->insertSueldoEmpleado($datosEmpleadoCuota);
                }elseif($itemSalario!="" && $existe<>""){
                    $datosEmpleadoCuota = array (
                        "sueldoEmpleado" => $itemSalario["sueldo"],
                        "cuotaDiariaEmpleado" => $itemSalario["cuotaDiaria"],
                        "empleadoEntidadCuota" => $empleado["entidadFederativaId"],
                        "empleadoConsecutivoCuota" => $empleado["empleadoConsecutivoId"],
                        "empleadoCategoriaCuota" => $empleado["empleadoCategoriaId"],
                        "bonoAsistenciaEmpleado" => "0",
                        "bonoPuntualidadEmpleado" => "0",
                        "lastUserEditedCuota" => $usuario,
                    );
                    $negocio ->updateSueldoEmpleado($datosEmpleadoCuota);
                }
            }
            $response ["status"] = "success";
            $response ["message"] = "Empleado registrado éxitosamente";
        }
    }catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
$response ["messages"] = $messages;
echo json_encode ($response);
?>
