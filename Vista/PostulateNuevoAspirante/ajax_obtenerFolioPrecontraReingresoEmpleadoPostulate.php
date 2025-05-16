<?php
// session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
//$log = new KLogger ( "ajax_obtenerFolioPrecontraReingresoEmpleadoPostulate.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
if(!empty ($_POST)){
    $curp = $_POST["curp"];
    $numafiliacionimss = $_POST["numafiliacionimss"];
    $folioPreseleccion = $_POST["folioPreseleccion"];
    $caso = $_POST["caso"];
    try {
        if($folioPreseleccion == "0"){
            $sql = "SELECT concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as numempleado,e.empleadoNumeroSeguroSocial,dp.curpEmpleado,dp.rfcEmpleado,e.foliopreseleccion,ep.folioPreseleccion as foliotblempleadopreseleccion,e.foliopreseleccion
                FROM empleados e
                LEFT JOIN datospersonales dp
                ON( e.entidadFederativaId=dp.empleadoEntidadPersonal and e.empleadoConsecutivoId=dp.empleadoConsecutivoPersonal and e.empleadoCategoriaId=dp.empleadoCategoriaPersonal)
                LEFT JOIN empleados_preseleccion ep on(e.empleadoNumeroSeguroSocial=ep.nImssPreseleccion)";
                if($caso =="1"){
                    $sql.=" WHERE dp.curpEmpleado='$curp'";
                }else{
                    $sql.=" WHERE e.empleadoNumeroSeguroSocial='$numafiliacionimss'";
                }
            $res = mysqli_query($conexion, $sql);
            while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                $datos[] = $reg;
            }
            if(count($datos)==0){
                $response = array("status" => "sinDatos");
            }else{
                $response["status"]= "success";
                $response["datosEmpleado"]= $datos;
            } 
        }else{
            $sql = "SELECT p.idPreseleccion,p.folioPreseleccion,p.puestoPreseleccion,p.nombrePreseleccion,p.apPaternoPreseleccion,p.apMaternoPreseleccion,p.edadPreseleccion,p.edoCivilPreseleccion,p.pesoPreseleccion,p.estaturaPreseleccion,p.tallaCamisaPreseleccion,p.tallaPantalonPreseleccion,p.numCalzadoPreseleccion,p.generoPreseleccion,p.tipoSangrePreseleccion,p.fechaNacPreseleccion,p.entidadNacPreseleccion,p.cpPreseleccion,p.callePreseleccion,p.numeroPreseleccion,p.coloniaPreseleccion,p.municipioPreseleccion,p.ciudadPreseleccion,p.telFijoPreseleccion,p.telMovilPreseleccion,p.emailPreseleccion,p.infonavitPreseleccion,p.fonacotPreseleccion,p.cartillaPreseleccion,p.licenciaPreseleccion,p.nImssPreseleccion,p.nombreE1Preseleccion,p.fecha1E1Preseleccion,p.fecha2E1Preseleccion,p.telefonoE1Preseleccion,p.causaE1Preseleccion,p.nombreE2Preseleccion,p.fecha1E2Preseleccion,p.fecha2E2Preseleccion,p.telefonoE2Preseleccion,p.causaE2Preseleccion,p.personasACargoPreseleccion,p.gradoEPreseleccion,p.cursoEspecialPreseleccion,p.enfermedadPreseleccion,p.padrePreseleccion,p.madrePreseleccion,p.esposaPreseleccion,p.ben1Preseleccion,p.ben2Preseleccion,p.ben3Preseleccion,p.ben4Preseleccion,p.ben5Preseleccion,p.nombreR1Preseleccion,p.telefonoR1,p.nombreR2,p.telefonoR2,p.reclutadorPreseleccion,ce.descripcionEstadoCivil as edoCivil,cg.descripcionGenero as generoPre,cs.tipoSangre as tipoSangre,ef.nombreEntidadFederativa as entidadPre,cge.descripcionGradoEstudios as gradoEstudios,p.numlicenciapreseleccion,p.fechapreseleccion,p.fechavigencialicencia,p.fechavigencialicencia,p.licenciapermanente,p.idEntidadALaborar,p.idPuestoSeleccionado
                FROM empleados_preseleccion p
                LEFT JOIN catalogoestadocivil ce ON (p.edoCivilPreseleccion=ce.idEstadoCivil)
                LEFT JOIN catalogogenero cg ON (p.generoPreseleccion=cg.idGenero)
                LEFT JOIN catalogotiposangre cs ON (p.tipoSangrePreseleccion=cs.idTipoSangre)
                LEFT JOIN entidadesfederativas ef ON (p.entidadNacPreseleccion=ef.idEntidadFederativa)
                LEFT JOIN catalogogradoestudios cge ON (p.gradoEPreseleccion=cge.idGradoEstudios)
                WHERE p.folioPreseleccion = '$folioPreseleccion'";
            $res = mysqli_query($conexion, $sql);
            while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
                $datos[] = $reg;
            }
            $response["status"]= "success";
            $response["datosAspitante"]= $datos;
            
        }
    //$log->LogInfo("Valor de la variable response " . var_export ($response, true));
    }catch (Exception $e) {
        $response["mensaje"] = "Error al Obtener Matrices";}
}
echo json_encode($response);
