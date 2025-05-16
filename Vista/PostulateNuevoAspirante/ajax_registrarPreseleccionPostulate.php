<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
$log = new KLogger ( "ajax_registrarPreseleccionPostulate.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));

$response = array();
$datos    = array();
$response["status"] = "error";
try{     
    $folioEmp = $_POST["txtFolioSolicitudPostulate"];
    $puestoEmp = $_POST["empPuestoPostulate"];
    $apPaternoEmp =$_POST["empApPaternoPostulate"];
    $apMaternoEmp = $_POST["empApMaternoPostulate"];
    $nombreEmp = $_POST["empNombrePostulate"];
    $edadEmp = $_POST["empEdadPostulate"];
    $pesoEmp = $_POST["empPesoPostulate"];
    $estaturaEmp = $_POST["empEstaturaPostulate"];
    $tallaCamisaEmp = $_POST["empTallaCamisaPostulate"];
    $tallaPantalonEmp = $_POST["empTallaPantalonPostulate"];
    $numCalzadoEmp = $_POST["empNumCalzadoPostulate"];
    $edoCivilEmp = $_POST["selectEmpCivilPostulate"];
    $sexoEmp = $_POST["selectEmpSexoPostulate"];
    $tipoSangreEmp = $_POST["selectEmpTipoSangrePostulate"];
    $fechaNacEmp = $_POST["empFechaNacPostulate"];
    $entidadNacEmp = $_POST["selectEmpEntidadPostulate"];
    $codPostalEmp = $_POST["empCodPostalPostulate"];
    $calleEmp = $_POST["empCallePostulate"];
    $numeroCEmp = $_POST["empNumeroCPostulate"];
    $coloniaEmp = $_POST["empColoniaPostulate"];
    $municipioEmp = $_POST["empMunicipioPostulate"];
    $ciudadEmp = $_POST["empCiudadPostulate"];
    $telFijoEmp = $_POST["empTelFijoPostulate"];
    $telMovilEmp = $_POST["empTelMovilPostulate"];
    $emailEmp = $_POST["empEmailPostulate"];
    $infonavitEmp = $_POST["infonavitPostulate"];
    $fonacotEmp = $_POST["fonacotPostulate"];
    $cartillaEmp = $_POST["cartillaPostulate"];
    $licenciaEmp = $_POST["licenciaPostulate"];
    $nImssEmp = $_POST["empImssPostulate"];
    $nombreE1Emp = $_POST["empNombreUEPostulate"];
    $fecha1E1Emp = $_POST["empFecha1E1Postulate"];
    $fecha2E1Emp = $_POST["empFecha2E1Postulate"];
    $telE1Emp = $_POST["empTelE1Postulate"];
    $causaSepE1Emp = $_POST["empCausaSepE1Postulate"];
    $nombreE2Emp = $_POST["empNombreEAPostulate"];
    $fecha1E2Emp = $_POST["empFecha1E2Postulate"];
    $fecha2E2Emp = $_POST["empFecha2E2Postulate"];
    $telE2Emp = $_POST["empTelE2Postulate"];
    $causaSepE2Emp = $_POST["empCausaSepE2Postulate"];
    $personasCargoEmp = $_POST["personasPostulate"];
    $gradoEstudioEmp = $_POST["selectEmpEstudioPostulate"];
    $cursoEspecialEmp = $_POST["empCursoEspecialPostulate"];
    $enfermedadEmp = $_POST["empEnfermedadPostulate"];
    $padreEmp = $_POST["empPadrePostulate"];
    $madreEmp = $_POST["empMadrePostulate"];
    $esposaEmp = $_POST["empEsposaPostulate"];
    $hijo1Emp = $_POST["empHijo1Postulate"];
    $hijo2Emp = $_POST["empHijo2Postulate"];
    $hijo3Emp = $_POST["empHijo3Postulate"];
    $hijo4Emp = $_POST["empHijo4Postulate"];
    $hijo5Emp = $_POST["empHijo5Postulate"];
    $nombreR1Emp = $_POST["empNombreR1Postulate"];
    $telR1Emp = $_POST["empTelR1Postulate"];
    $nombreR2Emp = $_POST["empNombreR2Postulate"];
    $telR2Emp = $_POST["empTelR2Postulate"];
    $reclutadorEmp = "";
    $numempleadopreseleccion = $_POST["numempleadopreseleccionPostulate"];
    $folioempleadopreseleccion = $_POST["folioempleadopreseleccionPostulate"];  
    $numLicenciaPreseleccion = $_POST["numLicenciaPreseleccionPostulate"];
    $fechavigencialicencia = $_POST["fechavigencialicenciaPostulate"]; 
    $licenciapermanente = $_POST["licenciapermanentePostulate"];
    $SelEntidadALaborar = $_POST["SelEntidadALaborar"];
    $SelectPuestoPostulate = $_POST["SelectPuestoPostulate"];
    $log->LogInfo("Valor de la variable SelEntidadALaborar: " . var_export ($SelEntidadALaborar, true));


    $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
    if ($SelEntidadALaborar == "0" || $SelEntidadALaborar == 0 || $SelEntidadALaborar == "ESTADO" || $SelEntidadALaborar == null) {
        $response["message"] = "Seleccione La Entidad Donde Desea Laborar";
    }elseif ($SelectPuestoPostulate == "0" || $SelectPuestoPostulate == 0 || $SelectPuestoPostulate == "PUESTO" || $SelectPuestoPostulate == null) {
        $response["message"] = "Seleccione El Puesto Qued Desea";
    }else if ($puestoEmp == "") {
        $response["message"] = "Proporcione el puesto solicitado";
    }else if($apPaternoEmp == "") {
        $response["message"] = "Proporcione el apellido paterno del aspirante";
    }else if($apMaternoEmp == "") {
        $response["message"] = "Proporcione el apellido materno del aspirante";
    }else if($nombreEmp == "") {
        $response["message"] = "Proporcione el nombre del aspirante";
    }else if($edadEmp == "") {
        $response["message"] = "Proporcione la edad del aspirante";
    } else if(!is_numeric($edadEmp)) {
        $response["message"] = "Edad del aspirante inválida";
    }else if($pesoEmp == "") {
        $response["message"] = "Proporcione el peso del aspirante";
    }else if(!is_numeric($pesoEmp)) {
        $response["message"] = "Peso del aspirante inválido";
    }else if($estaturaEmp == "") {
        $response["message"] = "Proporcione la estatura del aspirante";
    }else if(!is_numeric($estaturaEmp)) {
        $response["message"] = "Estatura del aspirante inválida";
    }else if($tallaCamisaEmp == "") {
        $response["message"] = "Proporcione la talla de camisa del aspirante";
    } else if (!is_numeric($tallaCamisaEmp)) {
        $response["message"] = "Talla de camisa inválida";
    }else if($tallaPantalonEmp == "") {
        $response["message"] = "Proporcione la talla de pantalón del aspirante";
    } else if (!is_numeric($tallaPantalonEmp)) {
        $response["message"] = "talla de pantalón inválida";
    }else if($numCalzadoEmp == "") {
        $response["message"] = "Proporcione el número de calzado del aspirante";
    } else if (!is_numeric($numCalzadoEmp)) {
        $response["message"] = "Numero de calzado inválido";
    }else if($edoCivilEmp == "") {
        $response["message"] = "Proporcione el estado civil del aspirante";
    }else if($sexoEmp == "") {
        $response["message"] = "Proporcione el género del aspirante";
    }else if($tipoSangreEmp == "") {
        $response["message"] = "Proporcione el tipo de sangre del aspirante";
    }else if($fechaNacEmp == "") {
        $response["message"] = "Proporcione la fecha de nacimiento del aspirante";
    }else if($entidadNacEmp == "") {
        $response["message"] = "Proporcione la entidad de nacimiento del aspirante";
    }else if($calleEmp == "") {
        $response["message"] = "Proporcione la calle del aspirante";
    }else if($numeroCEmp == "") {
        $response["message"] = "Proporcione el número de domicilio del aspirante";
    }else if($coloniaEmp == "") {
        $response["message"] = "Proporcione la colonia del aspirante";
    }else if($municipioEmp == "") {
        $response["message"] = "Proporcione el municipio del aspirante";
    }else if($ciudadEmp == "") {
        $response["message"] = "Proporcione la ciudad del aspirante";
    }else if($telFijoEmp == "" && $telMovilEmp == "") {
        $response["message"] = "Proporcione por lo menos un teléfono del aspirante";
    }else if($emailEmp == "") {
        $response["message"] = "Proporcione el correo electronico del aspirante";
    }else if (preg_match($patronCorreo, $emailEmp) == false) {
        $response["message"] = "El formato de correo electronico del aspirante es incorrecto";
    }else if($licenciaEmp == 1 && $licenciapermanente==0 && $numLicenciaPreseleccion == "") {
        $response["message"] = "Proporcione N° de licencia";
    }else if($licenciaEmp == 1 && $licenciapermanente==0 && $fechavigencialicencia == "") {
        $response["message"] = "Proporcione Fecha VIGENCIA DE LICENCIA";
    }else if($licenciaEmp == 1 && $licenciapermanente==1 && $numLicenciaPreseleccion == ""){
        $response["message"] = "Proporcione N° de licencia";
    }else if($gradoEstudioEmp == "") {
        $response["message"] = "Proporcione el ultimo grado de estudios del aspirante";
    }else if($padreEmp == "") {
        $response["message"] = "Proporcione el nombre del padre del aspirante";
    }else if($madreEmp == "") {
        $response["message"] = "Proporcione el nombre de la madre del aspirante";
    }else if($esposaEmp == "") {
        $response["message"] = "Proporcione el nombre de la (el) esposa (o) del aspirante";
    }else if($nombreR1Emp == "" && $nombreR2Emp == "") {
        $response["message"] = "Proporcione por lo menos una referencia del aspirante";
    }else if($nombreR1Emp != "" && $telR1Emp == "") {
        $response["message"] = "Proporcione el teléfono de la referencia 1 del aspirante";
    }else if($nombreR2Emp != "" && $telR2Emp == "") {
        $response["message"] = "Proporcione el teléfono de la referencia 2 del aspirante";
    }else if($telR2Emp != "" && $nombreR2Emp == "") {
        $response["message"] = "Proporcione el nombre de la referencia 2 del aspirante";
    }else if($telR1Emp != "" && $nombreR1Emp == "") {
        $response["message"] = "Proporcione el nombre de la referencia 1 del aspirante";
    }else{
        // $log->LogInfo("Valor de la variable folioempleadopreseleccion: " . var_export ($folioempleadopreseleccion, true));
        // $log->LogInfo("Valor de la variable numempleadopreseleccion: " . var_export ($numempleadopreseleccion, true));

        if($folioempleadopreseleccion == ""){
            $sql = "INSERT INTO empleados_preseleccion VALUES (NULL,'$folioEmp','$puestoEmp','$nombreEmp','$apPaternoEmp','$apMaternoEmp','$edadEmp','$edoCivilEmp','$pesoEmp','$estaturaEmp','$tallaCamisaEmp','$tallaPantalonEmp','$numCalzadoEmp','$sexoEmp','$tipoSangreEmp','$fechaNacEmp','$entidadNacEmp','$codPostalEmp','$calleEmp','$numeroCEmp','$coloniaEmp','$municipioEmp','$ciudadEmp','$telFijoEmp','$telMovilEmp','$emailEmp','$infonavitEmp','$fonacotEmp','$cartillaEmp','$licenciaEmp','$nImssEmp','$nombreE1Emp',";
            if($fecha1E1Emp==""){ 
                $sql .= " null,";
            }else{
                $sql .= " '$fecha1E1Emp',";
            }
            if($fecha2E1Emp==""){ 
                $sql .= " null,";
            }else{
                $sql .= " '$fecha2E1Emp',";
            }   
            $sql .= "'$telE1Emp','$causaSepE1Emp','$nombreE2Emp',";
            if($fecha1E2Emp==""){ 
                $sql .= " null,";
            }else{
                $sql .= " '$fecha1E2Emp',";
            }
            if($fecha2E2Emp==""){ 
                $sql .= " null,";
            }else{
                $sql .= " '$fecha2E2Emp',";
            }
            $sql .= " '$telE2Emp','$causaSepE2Emp','$personasCargoEmp','$gradoEstudioEmp','$cursoEspecialEmp','$enfermedadEmp','$padreEmp','$madreEmp','$esposaEmp','$hijo1Emp','$hijo2Emp','$hijo3Emp','$hijo4Emp','$hijo5Emp','$nombreR1Emp','$telR1Emp','$nombreR2Emp','$telR2Emp','$reclutadorEmp' ";
            if($licenciapermanente==0){
                $sql.=" , '$licenciapermanente','$numLicenciaPreseleccion',";
                if($fechavigencialicencia==""){ 
                    $sql .= " null, NOW()";
                }else{
                    $sql .= " '$fechavigencialicencia' , NOW()";
                }
            }else{
                $sql.=" , '$licenciapermanente',NULL,NULL, NOW()";
            }
            $sql.=" , '$SelEntidadALaborar','$SelectPuestoPostulate')";
// $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
            $res = mysqli_query($conexion, $sql);  
            if ($res !== true) {
                $response["status"] = "error";
                $response["message"]='Error Al Registrar Al Empleado';
                return;
            }else{
                $response ["status"] = "success";
                $response ["message"] = $nombreEmp.$apPaternoEmp." fué registrado en preselección con éxito ";
            }
        }if($numempleadopreseleccion != ""){
            if($folioempleadopreseleccion != ""){
                $folioEmpAEnviar = $folioempleadopreseleccion;
            }else{
                $folioEmpAEnviar = $folioEmp;
            }
            $array = explode("-", $numempleadopreseleccion);
            $entidad=$array[0];
            $consecutivo=$array[1];
            $categoria=$array[2];

            $sql1 = "UPDATE empleados
                set foliopreseleccion='$folioEmpAEnviar'
                where entidadFederativaId='$entidad'
                and empleadoConsecutivoId='$consecutivo'
                and empleadoCategoriaId='$categoria'";
// $log->LogInfo("Valor de la variable sql1: " . var_export ($sql1, true));
            $res1 = mysqli_query($conexion, $sql1);  
            if ($res1 !== true) {
                $response["status"] = "error";
                $response["message"]='Error Al Actualizar Al Empleado';
                return;
            }else{
                $response ["status"] = "success";
                $response ["message"] = $nombreEmp.$apPaternoEmp." fué registrado en preselección con éxito ";
            }

        }if($folioempleadopreseleccion != ""){
            $sql2 = "UPDATE empleados_preseleccion 
            SET puestoPreseleccion='$puestoEmp',nombrePreseleccion='$nombreEmp',apPaternoPreseleccion ='$apPaternoEmp',apMaternoPreseleccion='$apMaternoEmp',edadPreseleccion='$edadEmp',edoCivilPreseleccion='$edoCivilEmp',pesoPreseleccion='$pesoEmp',estaturaPreseleccion='$estaturaEmp',tallaCamisaPreseleccion='$tallaCamisaEmp',tallaPantalonPreseleccion='$tallaPantalonEmp',numCalzadoPreseleccion='$numCalzadoEmp',generoPreseleccion='$sexoEmp',tipoSangrePreseleccion='$tipoSangreEmp',fechaNacPreseleccion='$fechaNacEmp',entidadNacPreseleccion='$entidadNacEmp',cpPreseleccion='$codPostalEmp',callePreseleccion='$calleEmp',numeroPreseleccion='$numeroCEmp',coloniaPreseleccion='$coloniaEmp',municipioPreseleccion='$municipioEmp',ciudadPreseleccion='$ciudadEmp',telFijoPreseleccion='$telFijoEmp',telMovilPreseleccion='$telMovilEmp',emailPreseleccion='$emailEmp',infonavitPreseleccion='$infonavitEmp',fonacotPreseleccion='$fonacotEmp',cartillaPreseleccion='$cartillaEmp',licenciaPreseleccion='$licenciaEmp',nImssPreseleccion='$nImssEmp',nombreE1Preseleccion='$nombreE1Emp',";
            if($fecha1E1Emp==""){
                $sql2 .= " fecha1E1Preseleccion=null ,";
            }else{
                $sql2 .= " fecha1E1Preseleccion='$fecha1E1Emp',";
            }
            if($fecha2E1Emp==""){
                $sql2 .= " fecha2E1Preseleccion=null ,";
            }else{
                $sql2 .= " fecha2E1Preseleccion='$fecha2E1Emp',";
            }
            
            $sql2 .= " telefonoE1Preseleccion='$telE1Emp',causaE1Preseleccion='$causaSepE1Emp',nombreE2Preseleccion='$nombreE2Emp',";
            if($fecha1E2Emp==""){
                $sql2 .= " fecha1E2Preseleccion=null ,";
            }else{
                $sql2 .= " fecha1E2Preseleccion='$fecha1E2Emp',";
            }
            if($fecha2E2Emp==""){
                $sql2 .= " fecha2E2Preseleccion=null ,";
            }else{
                $sql2 .= " fecha2E2Preseleccion='$fecha2E2Emp',";
            }
            $sql2 .= " telefonoE2Preseleccion='$telE2Emp',causaE2Preseleccion='$causaSepE2Emp',personasACargoPreseleccion='$personasCargoEmp',gradoEPreseleccion='$gradoEstudioEmp',cursoEspecialPreseleccion='$cursoEspecialEmp',enfermedadPreseleccion='$enfermedadEmp',padrePreseleccion='$padreEmp',madrePreseleccion='$madreEmp',esposaPreseleccion='$esposaEmp',ben1Preseleccion='$hijo1Emp',ben2Preseleccion='$hijo2Emp',ben3Preseleccion='$hijo3Emp',ben4Preseleccion='$hijo4Emp',ben5Preseleccion='$hijo5Emp',nombreR1Preseleccion='$nombreR1Emp',telefonoR1='$telR1Emp',nombreR2='$nombreR2Emp',telefonoR2='$telR2Emp',licenciapermanente='$licenciapermanente',numlicenciapreseleccion='$numLicenciaPreseleccion',";
            if($fechavigencialicencia == ""){
                $sql2 .= " fechavigencialicencia=null ,";
            }else{
                $sql2 .= " fechavigencialicencia='$fechavigencialicencia', ";
            }
            $sql2 .= " fechapreseleccion=NOW(),idEntidadALaborar='$SelEntidadALaborar',idPuestoSeleccionado='$SelectPuestoPostulate'
                        WHERE folioPreseleccion='$folioempleadopreseleccion'";
// $log->LogInfo("Valor de la variable sql2: " . var_export ($sql2, true));
            $res2 = mysqli_query($conexion, $sql2);  
            if ($res2 !== true) {
                $response["status"] = "error";
                $response["message"]='Error Al Actualizar Al Empleado';
                return;
            }else{
                $response ["status"] = "success";
                $response ["message"] = $nombreEmp.$apPaternoEmp." fué registrado en preselección con éxito ";
            }
        }
    }
}catch (Exception $e) {
    $response["status"] = "error";
    $response["message"] = "Error al Registrar Matriz";
}
echo json_encode($response);
?> 