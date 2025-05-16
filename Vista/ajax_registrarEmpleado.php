<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php"); 
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio (); 
$response = array ();
$response ["status"] = "error";
verificarInicioSesion ($negocio);
   // $log = new KLogger ( "ajaxRegistroEmpleado.log" , KLogger::DEBUG );
   // $log->LogInfo("Valor de la variable poos: " . var_export ($_POST, true));
   // $log->LogInfo("Valor de la variable _FILES: " . var_export ($_FILES, true));
if (!empty ($_POST)){
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
	$idFotoEmpleado = getValueFromPost ("idFotoEmpleado");
	$selplantillaservicio = getValueFromPost("plantillaservicioingreso");
	$target_dir = dirname (__FILE__) . 
        DIRECTORY_SEPARATOR . "uploads" . 
        DIRECTORY_SEPARATOR . "fotosempleados" . 
        DIRECTORY_SEPARATOR;
	$target_file = $target_dir . $idFotoEmpleado;
	if (!file_exists ($target_file))
	{
		$idFotoEmpleado = "";
	}
     $empleadoResAsistencia = getValueFromPost("dirigente");
   if($empleadoResAsistencia=="0" || $empleadoResAsistencia=="null" || $empleadoResAsistencia=="NULL" || $empleadoResAsistencia=="" || $empleadoResAsistencia==null || $empleadoResAsistencia==NULL || $empleadoResAsistencia=="NO APLICA"){
        $idEntidadResponsableAsistencia="";
        $consecutivoResponsableAsistencia="";
        $tipoResponsableAsistencia="";
    }else{ 
        $empleadoisAsistenciaR = explode("-", $empleadoResAsistencia);
        $idEntidadResponsableAsistencia=$empleadoisAsistenciaR[0];
        $consecutivoResponsableAsistencia=$empleadoisAsistenciaR[1];
        $tipoResponsableAsistencia=$empleadoisAsistenciaR[2];
    }
    $empleadoReclutador = getValueFromPost("selectReclutador");
    if($empleadoReclutador=="0" || $empleadoReclutador=="null" || $empleadoReclutador=="NULL" || $empleadoReclutador=="" || $empleadoReclutador==null || $empleadoReclutador==NULL || $empleadoReclutador=="otro" ){
        $reclutadorEntidad="";
        $reclutadorConsecutivoId="";
        $reclutadorTipo="";
    }else{
        $Reclutador = explode("-", $empleadoReclutador);
        $reclutadorEntidad=$Reclutador[0];
        $reclutadorConsecutivoId=$Reclutador[1];
        $reclutadorTipo=$Reclutador[2];
    }

    $apellidoPaternoEmpleado= $_POST['apellidoPaternoEmpleado'];
    $apellidoMaternoEmpleado= $_POST['apellidoMaternoEmpleado'];
    $nombreEmpleado= $_POST['nombreEmpleado'];

    $apellidoPaternoEmpleado = str_replace(
    array('ñ','Ñ'),
    array('Ñ','Ñ'),
    $apellidoPaternoEmpleado);

    $apellidoMaternoEmpleado = str_replace(
    array('ñ','Ñ'),
    array('Ñ','Ñ'),
    $apellidoMaternoEmpleado);

    $nombreEmpleado = str_replace(
    array('ñ','Ñ'),
    array('Ñ','Ñ'),
    $nombreEmpleado);

	$empleado = array (
    "entidadFederativaId" => getValueFromPost("numeroEmpleadoEntidad"),
    "empleadoConsecutivoId" => getValueFromPost("numeroEmpleadoConsecutivo"),
    "empleadoCategoriaId" => getValueFromPost("numeroEmpleadoTipo"),
    "apellidoPaterno" =>strtoupper($apellidoPaternoEmpleado),
    "apellidoMaterno" =>strtoupper($apellidoMaternoEmpleado),
    "nombreEmpleado" => strtoupper($nombreEmpleado),
    "claveINE" => getValueFromPost("claveINE"),
    "fechaIngresoEmpleado" => getValueFromPost("fechaIngreso"),
    //NUEVOS CAMPOS PARA CARACTERISTICAS..
    "tesEmpleado" => getValueFromPost("tesEmpleado"),
    "estaturaEmpleado" => getValueFromPost("estaturaEmpleado"),
    "tallaCEmpleado" => getValueFromPost("tallaCEmpleado"),
    "tallaPEmpleado" => getValueFromPost("tallaPEmpleado"),
    "numCalzadoEmpleado" => getValueFromPost("numCalzadoEmpleado"),    
    "pesoEmpleado" => getValueFromPost("pesoEmpleado"),    
    "empleadoLocalizacion" => getValueFromPost("idEndidadFederativa"),
    "empleadoIdPuesto" => getValueFromPost("puesto"),
    "empleadoIdPuntoServicio" =>getValueFromPost("selectPuntoServicio"),
    "empleadoIdTurno" => getValueFromPost("tipoTurno"),
	"empleadoIdGenero" => getValueFromPost("genero"),
	"empleadoIdOficio" => getValueFromPost("oficio"),
	"empleadoIdTipoSangre" => getValueFromPost("tipoSangre"),
	"empleadoNumeroSeguroSocial" => getValueFromPost("numeroSeguroSocial"),
	"numeroCta" => getValueFromPost("txtNumeroCta"),
    "numeroCtaClabe" => getValueFromPost("txtCtaClabe"),
    "NumeroTarjetaDespensa" => getValueFromPost("txtTjDespensa"),
	"NumeroIutTarjetaDespensa" => getValueFromPost("txtnumeroIut"),
	"idTipoPuesto" => getValueFromPost("tipoPuesto"),
	"idEntidadResponsableAsistencia" => $idEntidadResponsableAsistencia,
	"consecutivoResponsableAsistencia" => $consecutivoResponsableAsistencia,
	"tipoResponsableAsistencia" => $tipoResponsableAsistencia,
	"fotoEmpleado" => $idFotoEmpleado,
    "empleadoLineaNegocioId" => getValueFromPost("selectLineaNegocio"),
    "idEntidadTrabajo" => getValueFromPost("selectEndidadFederativaLabor"),
    "usuarioCapturaEmpleado" => $usuarioCaptura,
    "tipoPeriodo" => getValueFromPost("periodo"),
    "clienteId" => getValueFromPost("txtClienteId"),
    "responsableAsistencia" => getValueFromPost("dirigente"),
    "medioInformacionVacanteId" => getValueFromPost("selectMedioInformacion"),
    "reclutadorId" => getValueFromPost("selectReclutador"),
    "reclutadorEntidad" => $reclutadorEntidad,
    "reclutadorConsecutivoId" => $reclutadorConsecutivoId,
    "reclutadorTipo" => $reclutadorTipo,
    "banco" => getValueFromPost("selbanco"),
    "plantillaservicio" => getValueFromPost("selplantillaservicio"),
    "docdigitalizadoo0" => getValueFromPost("docdigitalizadoo0"),
    "docdigitalizadoo1" => getValueFromPost("docdigitalizadoo1"),
    "docdigitalizadoo2" => getValueFromPost("docdigitalizadoo2"),
    "docdigitalizadoo3" => getValueFromPost("docdigitalizadoo3"), 
    "folioConsulta" => getValueFromPost("folioConsulta"),
    "licenciaConducir" => getValueFromPost("licenciaConducir"),
    "antiguedadVacacionesN" => getValueFromPost("antiguedadVacacionesN"),
    "antiguedadVacacionesS" => getValueFromPost("antiguedadVacacionesS"),
    "numerolicencia" => getValueFromPost("numerolicencia"),
    "inpfehavigencialicencia" => getValueFromPost("inpfehavigencialicencia"),
    "licenciaConducirpermanente" => getValueFromPost("licenciaConducirpermanente"),
    "idRolOpertaivoPorPlantillaAlta" => getValueFromPost("idRolOpertaivoPorPlantillaAlta"),
    "roloperativoTexto" => getValueFromPost("roloperativoTexto"),
    "OpcionTarjetaDeDespensa" => getValueFromPost("OpcionTarjetaDeDespensa"),
    "txtnumeroFirmaempleado" => getValueFromPost("txtnumeroFirmaempleado"),
    "ContraseniaFirmaemp" => getValueFromPost("ContraseniaFirmaemp"),
    "txtnumeroIut" => getValueFromPost("txtnumeroIut"), 
    "ContraseniaAltEmpleado" => getValueFromPost("ContraseniaAltEmpleado"), 
    "NumeroAltEmpleado" => getValueFromPost("NumeroAltEmpleado"), 
    "txtContactoGifR" => getValueFromPost("txtContactoGifR"),
    "txtCorreoGifR" => strtolower(getValueFromPost("txtCorreoGifR")),
    "horarioAlta" => getValueFromPost("horarioAlta"),
    "gerenteSup" => getValueFromPost("gerenteRegSup"),

    );
    $datosCuota = array (
    "puntoServicio" => getValueFromPost("selectPuntoServicio"),
    "puestoId" => getValueFromPost("puesto"),
    "rolId" => getValueFromPost("tipoTurno"),
    ); 
    try{
        $negocio -> registrarEmpleadoEntrevista($empleado);
        $datos = array (
        "requisicionId" => $selplantillaservicio,
        "empleadoEntidadPlantilla" => $empleado["entidadFederativaId"],
        "empleadoConsecutivoPlantilla" => $empleado["empleadoConsecutivoId"],
        "empleadoCategoriaPlantilla" => $empleado["empleadoCategoriaId"],
        );
            $negocio -> insertEmpleadoPlantilla($datos);
            $response ["status"] = "success";
            $response ["message"] = "Empleado registrado éxitosamente";
        if($empleado["idTipoPuesto"]=='03')
        {
            $itemSalario = $negocio -> getCuotaDiariaByPerfil($datosCuota);
            if($itemSalario!=""){
                $datosEmpleadoCuota = array (
                    "sueldoEmpleado" => $itemSalario["sueldo"],
                    "cuotaDiariaEmpleado" => $itemSalario["cuotaDiaria"],
                    "empleadoEntidadCuota" => $empleado["entidadFederativaId"],
                    "empleadoConsecutivoCuota" => $empleado["empleadoConsecutivoId"],
                    "empleadoCategoriaCuota" => $empleado["empleadoCategoriaId"],
                    "bonoAsistenciaEmpleado" => "0",
                    "bonoPuntualidadEmpleado" => "0",
                    "usuarioCapturaCuota" => $usuarioCaptura,
                );
                $negocio->insertSueldoEmpleado($datosEmpleadoCuota);
            }
        }
        $response ["status"] = "success";
        $response ["message"] = "Empleado registrado éxitosamente";
    } catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>