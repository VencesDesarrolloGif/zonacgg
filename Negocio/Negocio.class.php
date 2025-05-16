<?php
require_once dirname(__FILE__) . "/../Persistencia/Persistencia.class.php";
date_default_timezone_set('America/Mexico_City');
class Negocio
{
    public $persistencia;

    public function __construct()
    {
        $this->persistencia = new Persistencia();
    }

    /**
     * Obtiene el catalogo de puestos.
     *
     * @return Una lista de puestos
     */

    public function negocio_login($usuarioCuenta, $usuarioPassword)
    {
        $log = new KLogger ( "negocioSesion.log" , KLogger::DEBUG );

        // Definimos la variable que contendra la respuesta
        $response = array(
            "status"  => "success",
            "message" => "");

        $userLog = array();
        $idsentidades=array();
         $idlineasnegocio=array();

        //$log -> LogInfo ("UsuarioCuenta: " . $usuarioCuenta);
        //$log -> LogInfo ("UsuarioPassword: " . $usuarioPassword);

        // Se realizan las validaciones correspondientes al negocio.

        $userLog = $this->persistencia->login($usuarioCuenta, $usuarioPassword);

       // $log->LogInfo("Valor de la variable \$userLog1: " . var_export ($userLog, true));

        // Si el resultado de login no es null entonces guardamos los datos
        // del usuario en la sesión con el identificador "usuario"
        if ($userLog != null) {
            $userLog = $userLog[0];
            $userLog["lineaNegocioUsuario"]="";

            
            $idUsuario=$userLog["usuarioId"] ;
            $entidadesbyuser = $this->persistencia->entidadesByuser($idUsuario);
            if(count($entidadesbyuser)!=0){
                for($i=0;$i<count($entidadesbyuser);$i++){

                    $idsentidades[]=$entidadesbyuser[$i]["idEntidadEnt"];

                }
                $userLog["entidadFederativaUsuario"]=$idsentidades;
            }

            $sucursalesbyuser = $this->persistencia->sucursalesByuser($idUsuario);
            if(count($sucursalesbyuser)!=0){
                for($i=0;$i<count($sucursalesbyuser);$i++){

                    $idsucursales[]=$sucursalesbyuser[$i]["idSucursalUsr"];

                }
                $userLog["sucursalesUsuario"]=$idsucursales;
            }
            
            $lineasnegociobyuser = $this->persistencia->lineasnegocioByuser($idUsuario);
            if(count($lineasnegociobyuser)!=0){
                for($i=0;$i<count($lineasnegociobyuser);$i++){

                    $idlineasnegocio[]=$lineasnegociobyuser[$i]["idlineaNegocio"];

                }
                $userLog["lineaNegocioUsuario"]=$idlineasnegocio;
            }

            if ($userLog["rol"] == "Supervisor" || $userLog["rol"] == "Guardia" || $userLog["rol"] == "Consulta Supervisor") {
                $userLog["empleadoId"] = $this->persistencia->getSupervisorIdByUsuarioId($userLog["usuario"]);

                //$log->LogInfo("Valor de la variable \$userLogEmpleadoId: " . var_export ($userLog ["empleadoId"], true));
            }

            //$log->LogInfo("Valor de la variable \$userLog: " . var_export ($userLog, true));

            $_SESSION['userLog'] = $userLog;

            //$log->LogInfo("Valor de la variable \$userLog: " . var_export ( $_SESSION ['userLog'], true));

        } else {
            $response["status"]  = "error";
            $response["message"] = "Error de acceso";
        }

        return $response;
    }
    public function obtenerCatalogoPuestoPorTipoPuestoPlantillaReingreso($tipoPuesto, $lineaNegocio)
    {

        //$log = new KLogger ( "negocio_obtenerCatalogoPuestoPorTipoPuesto.log" , KLogger::DEBUG );

        //$log -> LogInfo ("UsuarioCuenta: " . $tipoPuesto);
        //$log -> LogInfo ("UsuarioPassword: " . $tipoPuesto);
        $listaPuestos = array();

        $listaPuestos = $this->persistencia->traeCatalogoPuestosPorTipoPlantillaReingreso($tipoPuesto, $lineaNegocio);

        return $listaPuestos;
    }

    public function obtenerCatalogoPuestoPorTipoPuesto($tipoPuesto, $lineaNegocio)
    {

        //$log = new KLogger ( "negocio_obtenerCatalogoPuestoPorTipoPuesto.log" , KLogger::DEBUG );

        //$log -> LogInfo ("UsuarioCuenta: " . $tipoPuesto);
        //$log -> LogInfo ("UsuarioPassword: " . $tipoPuesto);
        $listaPuestos = array();

        $listaPuestos = $this->persistencia->traeCatalogoPuestosPorTipo($tipoPuesto, $lineaNegocio);

        return $listaPuestos;
    }

    /**
     * Edita la información de un guardia
     *
     * @param guardia Un array con todos los datos del guardia que se quiere editar
     */
    public function editarRegistroGuardia($guardia)
    {
        $this->persistencia->actualizarInformacionGuardia($guardia);
    }

    //Ya fue Modificado
    public function registrarEmpleadoEntrevista($empleado)        
    {

        $log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $log->LogInfo("Valor de la variable empleado: " . var_export ($empleado, true));

        $patronNumeroEmpleado = '/[0-9]{2}+\-+[0-9]{4}+\-+[0-3]{2}/';
        $patronNumeroCtaClave = '/[0-9]{18}/';
        $patronNumeroCta      = '/[0-9]/';
        $patronNSS            = '/[0-9]{11}/';
        $imagen1              ="JPEG";
        $imagen2              ="JPG";
        $imagen3              ="PNG";
        $archivo              ="PDF";
        $usuario              = $empleado["usuarioCapturaEmpleado"];
        $fechaActual = date("Y-m-d");
        $fechaActualIngreso = $empleado["fechaIngresoEmpleado"];
        $conteobaja=0;
       //  
       // $log->LogInfo("Valor de la variable otra fecha ingresada: " . var_export ($empleado["fechaIngresoEmpleado"], true));

// $log->LogInfo("Valor de la variable \$docpermitidos00: " . var_export ($docpermitidos0, true));
        
        if ($empleado["docdigitalizadoo0"] === "" ){
            throw new Exception("Seleccione archivo Aviso Inscripción Imss");
        }
        if($empleado["docdigitalizadoo0"] !=""){
            $docpermitidos00      = explode(".", $empleado["docdigitalizadoo0"]);
            $array0=(count($docpermitidos00)-1);
            $docpermitidos0       = strtoupper($docpermitidos00[$array0]);
            if( $docpermitidos0 != $imagen1 &&  $docpermitidos0 != $imagen2 
                &&  $docpermitidos0 != $imagen3 &&  $docpermitidos0 != $archivo) {
                throw new Exception("Seleccione archivo Aviso Inscripción Imss De Tipo (.JPEG,.JPG,.PNG,.PDF)");
            }
        }
        if ($empleado["docdigitalizadoo1"] === ""){
            throw new Exception("Seleccione archivo Ticket de cuenta ");
        }
        if($empleado["docdigitalizadoo1"] != ""){
            $docpermitidos11      = explode(".", $empleado["docdigitalizadoo1"]);
            $array1=(count($docpermitidos11)-1);
            $docpermitidos1       = strtoupper($docpermitidos11[$array1]);
            if($docpermitidos1 != $imagen1&& $docpermitidos1 != $imagen2 
                && $docpermitidos1 != $imagen3&& $docpermitidos1 != $archivo) {
                throw new Exception("Seleccione archivo Ticket de cuenta De Tipo (.JPEG,.JPG,.PNG,.PDF)");
            }
        }
        if ($empleado["docdigitalizadoo2"] === "" ){
            throw new Exception("Seleccione archivo Cedula sat(R.F.C) ");
        }
        if ($empleado["docdigitalizadoo2"] != "" ){
            $docpermitidos22      = explode(".", $empleado["docdigitalizadoo2"]);
            $array2=(count($docpermitidos22)-1);
            $docpermitidos2       = strtoupper($docpermitidos22[$array2]);
            if ($docpermitidos2 != $imagen1&& $docpermitidos2 != $imagen2
                && $docpermitidos2 != $imagen3 &&$docpermitidos2 != $archivo) {
                throw new Exception("Seleccione archivo Cedula sat(R.F.C) De Tipo (.JPEG,.JPG,.PNG,.PDF)");
            }
        }
        if ($empleado["licenciaConducir"] == 1) {
            if ($empleado["docdigitalizadoo3"] === "" ){
                throw new Exception("Seleccione archivo Licencia Conducir");
            }
            if ($empleado["docdigitalizadoo3"] != "" ){
                $docpermitidos22      = explode(".", $empleado["docdigitalizadoo3"]);
                $array2=(count($docpermitidos22)-1);
                $docpermitidos2       = strtoupper($docpermitidos22[$array2]);
                if ($docpermitidos2 != $imagen1&& $docpermitidos2 != $imagen2
                    && $docpermitidos2 != $imagen3 &&$docpermitidos2 != $archivo) {
                    throw new Exception("Seleccione archivo Licencia Conducir De Tipo (.JPEG,.JPG,.PNG,.PDF)");
                }
            }
        }

        if ($empleado["empleadoConsecutivoId"] == "") {
            throw new Exception("No se ha generado el número de empleado consecutivo, por favor verifique");

        }

        if ($empleado["apellidoPaterno"] == "" && $empleado["apellidoMaterno"] == "") {
            throw new Exception("Ingrese por lo menos un apellido");

        }

        if ($empleado["nombreEmpleado"] == "") {
            throw new Exception("Ingrese el nombre del empleado");

        }

        if ($empleado["empleadoNumeroSeguroSocial"] == "") {
            throw new Exception("El numero de Seguro Social es obligatorio");
        }

        if (preg_match($patronNSS, $empleado["empleadoNumeroSeguroSocial"]) == false) {
            throw new Exception("El numero de Seguro Social solo admite numeros");
        }

        $numeroEmpleadoEdicion = $empleado["entidadFederativaId"] . "-" . $empleado["empleadoConsecutivoId"] . "-" . $empleado["empleadoCategoriaId"];
        $numeroEmpleadoImss = $this->persistencia->obtenerNumeroEmpleadoImss($empleado["empleadoNumeroSeguroSocial"]);
        if (count($numeroEmpleadoImss) != 0) {
            if ($numeroEmpleadoEdicion != $numeroEmpleadoImss[0]["numeroEmpleadoImss"]) {
                throw new Exception("El número de IMSS ya se encuentra registrado en la base con otra persona");
            }
        }

        if ($empleado["empleadoNumeroSeguroSocial"] != "") {
            if (strlen($empleado["empleadoNumeroSeguroSocial"]) < 11) {
                throw new Exception("Hacen falta Digitos en el Numero de Seguro Social ");
            }
            if (strlen($empleado["empleadoNumeroSeguroSocial"]) > 11) {
                throw new Exception("El numero de Seguro Social solo permite ingresar 11 Digitos");
            }
        }

        if (strlen($empleado["banco"]) == "0") {

            throw new Exception("Seleccione el banco");
        }

        if (strlen($empleado["numeroCta"]) == 13) {

            throw new Exception("El numero de cuenta no puede ser de 13 digitos");
        }

        if (strlen($empleado["numeroCta"]) < 10) {
            throw new Exception("El numero de cuenta no puede ser menos de 10 digitos");
        }

        if (preg_match($patronNumeroCta, $empleado["numeroCta"]) == false) {
            throw new Exception("El numero de cuenta solo admite numeros 10");

        }
        //VALIDACIO DE BANCO

        if ($empleado["banco"] == "127" && strlen($empleado["numeroCta"]) != 14) {
            throw new Exception("Numero de cuenta incorrecto para BANCO AZTECA");
        }

        if ($empleado["banco"] == "030" && strlen($empleado["numeroCta"]) != 12) {
            throw new Exception("Numero de cuenta incorrecto para BANCO BAJIO");
        }

        if (($empleado["banco"] == "012" || $empleado["banco"] == "021") && strlen($empleado["numeroCta"]) != 10) {
            if ($empleado["banco"] == "012") {
                throw new Exception("Numero de cuenta incorrecto para BANCO BBVA BANCOMER");
            }

            if ($empleado["banco"] == "021") {
                throw new Exception("Numero de cuenta incorrecto para BANCO HSBC");
            }

        }

        if ($empleado["banco"] == "014" && strlen($empleado["numeroCta"]) != 11) {
            throw new Exception("Numero de cuenta incorrecto para BANCO SANTANDER");
        }

        $numeroCuenta = $this->persistencia->verificarNumeroCuentaDuplicado($empleado["numeroCta"]);
        if ($numeroCuenta != null) {
            throw new Exception("El numero de Cuenta ya esta registrado en la base de datos");
        }

        if (strlen($empleado["numeroCtaClabe"]) != 18) {
            throw new Exception("El número de cuenta clabe debe contener 18 digitos");

        }

        if (preg_match($patronNumeroCtaClave, $empleado["numeroCtaClabe"]) == false) {

            throw new Exception("Formato inválido para número de cuenta clabe");

        }

        $numeroCuentaClabe = $this->persistencia->verificarNumeroCuentaClabeDuplicado($empleado["numeroCtaClabe"]);
        if ($numeroCuentaClabe != null) {
            throw new Exception("El numero de Cuenta clabe ya esta registrado en la base de datos");
        }

        if ($empleado["OpcionTarjetaDeDespensa"] == "0") {
            throw new Exception("Seleccione Si Se Le dará Tarjeta De Despensa Al Empleado");
        }

        if ($empleado["fechaIngresoEmpleado"] == "") {
            throw new Exception("Seleccione fecha de ingreso");
        }
        
        if ($fechaActual != $fechaActualIngreso ){
            throw new Exception("Ingrese La fecha Actual Sin Modificar Su Zona Horaria Del Equipo");
        }
       
       /* $fechaActualNueva = date("Y-m-d");
        if ($empleado["fechaIngresoEmpleado"] < $fechaActualNueva || $empleado["fechaIngresoEmpleado"] > $fechaActualNueva ) {
            throw new Exception("La Fecha de Ingreso NO puede ser menor ni mayor que la fecha actual");
        }*/

        $segundos_por_2dias = 86400 * 2;

        $fechaMaxIngreso = strtotime(date("Y-m-d")) + $segundos_por_2dias;

        $fechaIngreso = strtotime($empleado["fechaIngresoEmpleado"]);

        //$log->LogInfo("Valor de la variable \$fechaMaxIngreso: " . var_export ($fechaMaxIngreso, true));
        //$log->LogInfo("Valor de la variable \$fechaIngreso: " . var_export ($fechaIngreso, true));

        if ($fechaIngreso > $fechaMaxIngreso) {

            throw new Exception("La fecha de ingreso rebasa el limite maximo de fecha");

        }
        if ($empleado["empleadoLineaNegocioId"] == "" or $empleado["empleadoLineaNegocioId"] == "LINEA NEGOCIO") {
            throw new Exception("Seleccione linea de negocio");

        }

        if ($empleado["empleadoLocalizacion"] == "" or $empleado["empleadoIdPuesto"] == "ENTIDAD FEDERATIVA") {
            throw new Exception("Seleccione la entidad federativa de contratación");
        }

        if ($empleado["empleadoIdPuesto"] == "" or $empleado["empleadoIdPuesto"] == "PUESTO") {
            throw new Exception("Seleccione el puesto del empleado");
        }

        if ($empleado["idEntidadTrabajo"] == "" or $empleado["idEntidadTrabajo"] == "ENTIDAD FEDERATIVA") {
            throw new Exception("Seleccione la entidad federativa para laborar");
        }

        if ($empleado["idTipoPuesto"] == "02") {
            $empleado["idEntidadResponsableAsistencia"]   = "";
            $empleado["consecutivoResponsableAsistencia"] = "";
            $empleado["tipoResponsableAsistencia"]        = "";

        }

        if ($empleado["idTipoPuesto"] == "03" and $empleado["responsableAsistencia"] == "RESPONSABLE ASISTENCIA") {

            throw new Exception("Seleccione responsable de asistencia");
        }

        if ($empleado["empleadoIdPuntoServicio"] == "" || $empleado["empleadoIdPuntoServicio"] == "PUNTOS SERVICIOS") {
            throw new Exception("Seleccione punto de servicio");
        }

        if ($empleado["empleadoIdTurno"] == "TURNO") {
            throw new Exception("Seleccione el turno");
        }

        if ($empleado["idTipoPuesto"] != "02") {
            if ($empleado["plantillaservicio"] === "" || $empleado["plantillaservicio"] === "PLANTILLA" || $empleado["plantillaservicio"] === "0") {
                throw new Exception("Seleccione plantilla de servicio");
//falta mandar el parametro para insertar el roloperativo en empleados
            }
        }
        if ($empleado["idRolOpertaivoPorPlantillaAlta"] === "" || $empleado["idRolOpertaivoPorPlantillaAlta"] === "NULL" || $empleado["idRolOpertaivoPorPlantillaAlta"] === NULL || $empleado["idRolOpertaivoPorPlantillaAlta"] === null || $empleado["idRolOpertaivoPorPlantillaAlta"] ==='null') {
            throw new Exception("Actualize el rol operativo de esta plantilla para continuar si ya se hizo favor recargar la pantilla se servicio");
        }
        if ($empleado["licenciaConducir"] == "") {
            throw new Exception("Proporcione si cuenta con licencia de conducir");
        }

        if ($empleado["licenciaConducir"] == 1 ) {
            if( ($empleado["licenciaConducirpermanente"] == 0 ||  $empleado["licenciaConducirpermanente"] == 1) && $empleado["numerolicencia"]==""){
                throw new Exception("Proporcione número licencia de conducir");
            }else if($empleado["licenciaConducirpermanente"] == 0 && $empleado["inpfehavigencialicencia"] == ""){
                throw new Exception("Proporcione fecha vgencia licencia");   
            }
        }

        if ($empleado["empleadoIdGenero"] == "") {
            throw new Exception("Seleccione un Genero");
        }

        if ($empleado["fotoEmpleado"] == "") {
            throw new Exception("Seleccione foto del empleado");
        }

        if ($empleado["tipoPeriodo"] == "") {
            throw new Exception("Seleccione el periodo de pago para el empleado");
        }

        if ($empleado["idTipoPuesto"] == "02" and $empleado["medioInformacionVacanteId"] == "") {
            throw new Exception("Seleccione el medio de información por el que se enteró de la vacante");
        }

        //MENSAJES PARA LOS DATOS NUEVOS DE CARACTERISTICAS FISICAS.........

        if ($empleado["estaturaEmpleado"] == "") {
            throw new Exception("Ingrese estatura en numero decimal ej(1.70)");
        }

        if ($empleado["tallaCEmpleado"] == "") {
            throw new Exception("Ingrese talla en numero entero ej(30)");
        }

        if ($empleado["tallaPEmpleado"] == "") {
            throw new Exception("Ingrese talla en numero entero ej(30)");
        }

        if ($empleado["numCalzadoEmpleado"] == "") {
            throw new Exception("Ingrese numero de calzado en numero decimal ej(27.5)");
        }

        if ($empleado["pesoEmpleado"] == "") {
            throw new Exception("Ingrese peso en numero");
        }


        if (!is_numeric($empleado["estaturaEmpleado"])) {
            throw new Exception("La estatura es incorrecta");
        }

        if (!is_numeric($empleado["tallaCEmpleado"])) {
            throw new Exception("Talla de camisa incorrecta");
        }

        if (!is_numeric($empleado["tallaPEmpleado"])) {
            throw new Exception("Talla de pantalon incorrecta");
        }

        if (!is_numeric($empleado["numCalzadoEmpleado"])) {
            throw new Exception("Numero de calzado incorrecto");
        }

        if (!is_numeric($empleado["pesoEmpleado"])) {
            throw new Exception("Peso de empleado incorrecto");
        }
        if ($empleado["antiguedadVacacionesN"] === "" && $empleado["antiguedadVacacionesS"] === ""){
            throw new Exception("Seleccione Si El Empleado Conserva Antiguedad (Vacaciones Pasadas)");
        }   
        if (($empleado["empleadoLineaNegocioId"] == "1" || $empleado["empleadoLineaNegocioId"] == "2" || $empleado["empleadoLineaNegocioId"] == "3" ||$empleado["empleadoLineaNegocioId"] == "4") && $empleado["idTipoPuesto"] == "03" && $empleado["reclutadorId"] != "otro") {
            $empleado["medioInformacionVacanteId"] = 6;
        }
        if ($empleado["empleadoLineaNegocioId"] == "1" && $empleado["idTipoPuesto"] == "03" && $empleado["reclutadorId"] == "otro") {
            //$empleado["medioInformacionVacanteId"]=7;
            $empleado["reclutadorEntidad"]       = "";
            $empleado["reclutadorConsecutivoId"] = "";
            $empleado["reclutadorTipo"]          = "";

        }
        if ($empleado["empleadoLineaNegocioId"] == "2" && ($empleado["idTipoPuesto"] == "03" || $empleado["reclutadorId"] == "02")) {

            $empleado["reclutadorEntidad"]       = "";
            $empleado["reclutadorConsecutivoId"] = "";
            $empleado["reclutadorTipo"]          = "";

        }

        $segundos_por_dia = 86400;

        $this->persistencia->insertarEmpleadoEntrevista($empleado);

        if ($empleado["empleadoCategoriaId"] == "03") {

            $periodos    = $this->persistencia->getTiposPeriodos();
            $tipoPeriodo = "";
            foreach ($periodos as $periodo) {
                if ($periodo["tipoPeriodoId"] == $empleado["tipoPeriodo"]) {
                    $tipoPeriodo = $periodo["descripcionTipoPeriodo"];
                    //$log->LogInfo("Valor de la variable \$tipoPeriodo: " . var_export ($tipoPeriodo, true));
                }
            }

            $fechasPeriodo = $this->obtenerListaDiasParaAsistencia($tipoPeriodo);
            

            $fechaIngreso = strtotime($empleado["fechaIngresoEmpleado"]);

            $fecha = strtotime($fechasPeriodo[0]["fecha"]);

            $empleado["entidadId"]       = $empleado["entidadFederativaId"];
            $empleado["consecutivoId"]   = $empleado["empleadoConsecutivoId"];
            $empleado["tipoId"]          = $empleado["empleadoCategoriaId"];
            $empleado["puntoServicioId"] = $empleado["empleadoIdPuntoServicio"];

            $supervisor["entidadId"]     = $empleado["idEntidadResponsableAsistencia"];
            $supervisor["consecutivoId"] = $empleado["consecutivoResponsableAsistencia"];
            $supervisor["tipoId"]        = $empleado["tipoResponsableAsistencia"];
            $puestoCubiertoId            = $empleado["empleadoIdPuesto"];

            $i=0;
            while ($fecha < $fechaIngreso) {
                if($i==0){
                    $conteobaja=1;

                }else{
                   $conteobaja=0;   
               }
               $registrado = $this->persistencia->registrarAsistencia(
                $empleado,
                $supervisor,
                11,
                date("Y-m-d", $fecha),
                $usuario,
                "", $tipoPeriodo, $puestoCubiertoId, $empleado["plantillaservicio"],$conteobaja,$empleado["plantillaservicio"]);

               $fecha += $segundos_por_dia;
                  //$log->LogInfo("Valor de la variable \$i: " . var_export ($i, true));
               $i++;

           }

       }

   }

   public function obtenerCatalogoTipoPuesto()
   {
    $listaTipoPuestos = array();

    $listaTipoPuestos = $this->persistencia->traeCatalogoTipoPuestos();

    return $listaTipoPuestos;
}

    /**
     * Verifica que exista una sesión iniciada
     */
    public function verificarInicioSesion()
    {
        $result = false;

        if (isset($_SESSION["userLog"])) {
            $result = true;
        }

        return $result;
    }

    public function obtenerPosiblesJefesPorPuesto($puestoId)
    {
        $result = $this->persistencia->obtenerPosiblesJefesPorPuesto($puestoId);

        return $result;
    }

    public function negocio_verificarDisponibilidadDeNumeroDeEmpleado($numeroEmpleado)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        // Definimos la variable que contendra la respuesta
        $response = array(
            "status"  => "noExiste",
            "message" => "");

        $resEmpleado = array();

        //$log -> LogInfo ("Numero de Empleado: " . $numeroEmpleado);

        // Se realizan las validaciones correspondientes al negocio.

        $resEmpleado = $this->persistencia->verificarDisponibilidadDeNumeroDeEmpleado($numeroEmpleado);

        //$log->LogInfo("Valor de la variable \$resEmpleado: " . var_export ($resEmpleado, true));

        // Si el resultado de login no es null entonces guardamos los datos
        // del usuario en la sesión con el identificador "usuario"
        if ($resEmpleado != null) {
            $response["status"]  = "existe";
            $response["message"] = "El numero de empleado ya esta registrado";
        }

        return $response;
    }

    public function negocio_obtenerListaEntidadesFeferativas()
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listaEntidadesFederativas = array();
        $listaEntidadesFederativas = $this->persistencia->traeCatalogoEntidadesFederativas();
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listaEntidadesFederativas;
    }
    public function negocio_obtenerListaEntidadesFeferativasLU($entidades)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listaEntidadesFederativas = array();
        $listaEntidadesFederativas = $this->persistencia->traeCatalogoEntidadesFederativasLU($entidades);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listaEntidadesFederativas;
    }

    public function negocio_obtenerListaEntidadesFeferativasaLaborar()
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listaEntidadesFederativasaLaborar = array();
        $listaEntidadesFederativasaLaborar = $this->persistencia->traeCatalogoEntidadesFederativasaLaborar();
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listaEntidadesFederativasaLaborar;
    }

        public function getcatalogomunicipios()
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listacatalogomunicipios = array();
        $listacatalogomunicipios = $this->persistencia->traecatalogomunicipios();
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listacatalogomunicipios;
    }

    public function negocio_obtenerListaEntidadesFeferativasParaAlmacen()
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listaEntidadesFederativas = array();
        $listaEntidadesFederativas = $this->persistencia->traeCatalogoEntidadesFederativasParaALmacen();
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listaEntidadesFederativas;
    }

    public function negocio_VerificarNumeroCuentaDuplicado($numeroCuenta)
    {

        //$log = new KLogger ("negocio.log", KLogger::DEBUG);
        $response = array(
            "status"  => "noExiste",
            "message" => "");
        $resEmpleado = array();

        //$log -> LogInfo("NumeroEmpleadoCta" .$numeroCuenta);

        $resEmpleado = $this->persistencia->verificarNumeroCuentaDuplicado($numeroCuenta);
        //$log->LogInfo("Valor de la variable \$resEmpleado: " . var_export ($resEmpleado, true));
        if ($resEmpleado != null) {
            $response["status"]  = "existe";
            $response["message"] = "El número de Cuenta ya esta registrado en la Base de Datos";

        }
        return $response;
    }

    public function negocio_VerificarNumeroCuentaClabeDuplicado($numeroCuentaClave)
    {

        //$log = new KLogger ("negocioVerificarCtaClabeDuplicada.log", KLogger::DEBUG);
        $response = array(
            "status"  => "noExiste",
            "message" => "");
        $resEmpleado = array();

        //$log -> LogInfo("NumeroEmpleadoCtaClave" .$numeroCuentaClave);

        $resEmpleado = $this->persistencia->verificarNumeroCuentaClabeDuplicado($numeroCuentaClave);
        //$log->LogInfo("Valor de la variable \$resEmpleado: " . var_export ($resEmpleado, true));
        if ($resEmpleado != null) {
            $response["status"]  = "existe";
            $response["message"] = "El número de Cuenta clabe ya esta registrado en la Base de Datos";

        }
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
        return $response;

    }

    public function verificarNumeroSeguroSocialDuplicado($numeroSeguroSocial)
    {

        //$log = new KLogger ("negocioVerificarNumeroImss.log", KLogger::DEBUG);
        $response = array(
            "status"  => "noExiste",
            "message" => "");
        $resEmpleado = array();

        //$log -> LogInfo("numeroSeguroSocial" .$numeroSeguroSocial);

        $resEmpleado = $this->persistencia->verificarNumeroSeguroSocialDuplicado($numeroSeguroSocial);
        //$log->LogInfo("Valor de la variable \$resEmpleado: " . var_export ($resEmpleado, true));
        if ($resEmpleado != null) {
            $response["status"]  = "existe";
            $response["message"] = "El número de imss ya esta registrado en la Base de Datos";

        }
        //$log->LogInfo("Valor de la variable \$response: " . var_export ($response, true));
        return $response;

    }

    public function negocio_obtenerListaDepartamentos()
    {

        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaDepartamentos = array();
        $listaDepartamentos = $this->persistencia->traerListaDeDepartamentos();
        //$log->LogInfo("Valor de la variable \$listaDepartamentos: " . var_export ($listaDepartamentos, true));
        return $listaDepartamentos;
    }

    public function negocio_obtenerListaAsuntosPorDepartamento($departamentoId)
    {

        $log          = new KLogger("negocio.log", KLogger::DEBUG);
        $listaAsuntos = array();
        $listaAsuntos = $this->persistencia->traerListaAsuntosPorDepartamento($departamentoId);
        $log->LogInfo("Valor de la variable \$listaAsuntos: " . var_export($listaAsuntos, true));
        return $listaAsuntos;
    }

    public function negocio_obtenerListaIdentificaciones()
    {
        //$log = new KLogger("negocio.log", KLogger::DEBUG);
        $listaIdentificaciones = array();
        $listaIdentificaciones = $this->persistencia->traerListaIdentificaciones();
        //$log -> LogInfo("Valor de array listaIdentificaciones". var_export($listaIdentificaciones, true));
        return $listaIdentificaciones;
    }

    public function registrarVisitante($visitante)
    {
        //$log = new KLogger ( "negocioVisit.log" , KLogger::DEBUG );

        if ($visitante["visitanteApPaterno"] == "" && $visitante["visitanteApMaterno"] == "") {
            throw new Exception("Ingrese por lo menos un apellido");

        }

        if ($visitante["visitanteNombre"] == "") {
            throw new Exception("Ingrese el nombre del visitante");

        }

        if ($visitante["visitanteIdDepto"] == "AREA DE VISITA") {
            throw new Exception("Seleccione el Departamento De visita");
        }
        if ($visitante["visitanteIdAsunto"] == "" || $visitante["visitanteIdAsunto"] == "ASUNTO") {
            throw new Exception("Seleccione Asunto");
        }
        if ($visitante["visitanteIdIdentificacion"] == "IDENTIFICACION") {
            throw new Exception("Seleccione Identificacion");
        }

        //$log->LogInfo("Valor de la variable \$visitante : " . var_export ($visitante, true));

        $this->persistencia->insertarVisitante($visitante);
    }

    public function negocio_obtenerListaDeVisitantesDelDia($inicio, $registrosPorPagina)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaVisitantesDelDia = array();
        $listaVisitantesDelDia = $this->persistencia->traerListaVisitantesDelDia($inicio, $registrosPorPagina);
        //$log -> LogInfo ("listaVisitantesDelDia". var_export($listaVisitantesDelDia,true));
        return $listaVisitantesDelDia;
    }

    public function negocio_traerTotalDeVisitantesDelDia()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $numeroDeVisitantes = 0;
        $numeroDeVisitantes = $this->persistencia->traerTotalDeVisitantes();
        //$log -> LogInfo ("TotalDeVisitantesDelDia". var_export($numeroDeVisitantes,true));
        return $numeroDeVisitantes;
    }

    public function negocio_obtenerUltimoNumeroEmpleado($entidad, $tipo)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $ultimoNumeroEmpleado = "";
        $ultimoNumeroEmpleado = $this->persistencia->traerUltimoNumeroEmpleadoRegistrado($entidad, $tipo);
        //$log -> LogInfo ("negocio_obtenerUltimoNumeroEmpleado". var_export($ultimoNumeroEmpleado,true));
        return $ultimoNumeroEmpleado;

    }

    public function negocio_obtenerCatalogoGeneros()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaGeneros = $this->persistencia->traerListaGeneros();
        //$log -> LogInfo ("negocio_obtenerCatalogoGeneros". var_export($listaGeneros,true));
        return $listaGeneros;

    }

    public function negocio_obtenerListaOficios()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaOficios = $this->persistencia->traerListaOficios();
        //$log -> LogInfo ("negocio_obtenerListaOficios". var_export($listaOficios,true));
        return $listaOficios;

    }
    public function negocio_obtenerListaTipoSangre()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaTipoSangre = $this->persistencia->traerListaTipoSangre();
        //$log -> LogInfo ("negocio_obtenerListaTipoSangre". var_export($listaTipoSangre,true));
        return $listaTipoSangre;

    }
    public function negocio_obtenerListaTurnos()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaTurnos = $this->persistencia->traerListaTurnos();
        //$log -> LogInfo ("negocio_obtenerListaTurnos". var_export($listaTurnos,true));
        return $listaTurnos;

    }

    public function negocio_traerListaVisitantesConDeptoRH()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaVisitantesParaContratacion = $this->persistencia->traerListaVisitantesConDeptoRH();
        //$log -> LogInfo ("negocio_obtenerListaVisitantesParaContratacion". var_export($listaVisitantesParaContratacion,true));
        return $listaVisitantesParaContratacion;

    }

    public function negocio_actualizarEstatusVisitante($visitanteId, $estatusVisitante)
    {

        $this->persistencia->actualizarEstatusVisitante($visitanteId, $estatusVisitante);
    }

    public function negocio_traerListaDocumentos()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaDocumentos = $this->persistencia->traerListaDocumentos();
        //$log -> LogInfo ("negocio_traerListaDocumentos". var_export($listaDocumentos,true));
        return $listaDocumentos;

    }

    public function negocio_registrarEntregaDocumentacion($documentacion)
    {
        //$log = new KLogger ( "negocioRegistrarDocumentacion.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$documentacion : " . var_export ($documentacion, true));

        $this->persistencia->insertarEntregaDocumentos($documentacion);
    }

    public function negocio_traerListaVisitantesConFechaDe($dia, $mes, $anio)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaVisitantesConFechaDe = $this->persistencia->traerListaVisitantesConFechaDe($dia, $mes, $anio);
        //$log->LogInfo("negocio_traerListaVisitantesConFechaDe " . var_export ($listaVisitantesConFechaDe, true));
        return $listaVisitantesConFechaDe;

    }

    public function negocio_traerListaVisitantesConRangoDeFecha($dia1, $mes1, $anio1, $dia2, $mes2, $anio2)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaVisitantesConRangoDeFecha = $this->persistencia->traerListaVisitantesConRangoDeFecha($dia1, $mes1, $anio1, $dia2, $mes2, $anio2);
        //$log->LogInfo("negocio_traerListaVisitantesConRangoDeFecha " . var_export ($listaVisitantesConRangoDeFecha, true));
        return $listaVisitantesConRangoDeFecha;

    }

    public function negocio_ListaTipoMovimientosFinancieros()
    {
        //$log= new KLogger("negocioMovimientosFinancieros.log", KLogger::DEBUG);

        $listaTipoMovimientosFinancieros = $this->persistencia->traerListaTipoMovimientosFinancieros();
        //$log -> LogInfo ("negocio_ListaTipoMovimientosFinancieros". var_export($listaTipoMovimientosFinancieros,true));
        return $listaTipoMovimientosFinancieros;

    }

    public function negocio_ListaEmpresas()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaEmpresas = $this->persistencia->traerListaEmpresas();
        //$log -> LogInfo ("negocio_ListaEmpresas". var_export($listaEmpresas,true));
        return $listaEmpresas;

    }

    public function negocio_ListaBancos()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaBancos = $this->persistencia->traerListaBancos();
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $listaBancos;

    }

    public function negocio_registrarSaldoInicial($saldo)
    {
        //$log = new KLogger ( "negocioregistroSaldoInicial.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$saldo: " . var_export ($saldo, true));
        $this->persistencia->insertarSaldoInicial($saldo);
    }

    public function negocio_consultaFecha()
    {
        //$log = new KLogger ( "negocioFecha.log" , KLogger::DEBUG );

        $fecha = $this->persistencia->traerFecha();

        //$log->LogInfo("Valor de la variable \$fecha : " . var_export ($fecha, true));

        return $fecha;
    }

    public function negocio_ListaTipoTransacciones()
    {
        //$log= new KLogger("negocio_ListaTipoTransacciones.log", KLogger::DEBUG);

        $listaTipoTransacciones = $this->persistencia->traerListaTipoTransaccion();
        //$log -> LogInfo ("negocio_ListaTipoTransacciones". var_export($listaTipoTransacciones,true));
        return $listaTipoTransacciones;

    }

    public function negocio_RegistrarMovimiento($movimiento)
    {
        $archivostr = $movimiento["DocPdf"];
        $archivosf  = substr($archivostr, -4);
        $archivo    = strtolower($archivosf);
        $decimal    = '/^[0-9]+([.])?([0-9]+)?$/';
        $expreg     = '/^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/';
//$log = new KLogger ( "negocioArchivo.log" , KLogger::DEBUG );

//$log->LogInfo("Valor de la variable \$Archivo : " . var_export ($archivostr, true));

        if ($movimiento["fechaMovimiento"] == "") {
            throw new Exception("Ingrese Fecha");
        }
        if ($movimiento["reembolso"] === "1") {
            if ($movimiento["lblCLienteCaja"] === "0") {
                throw new Exception("Verifique El Empleado Encargado");
            }}
            if ($movimiento["lineaNegocio"] === "0") {
                throw new Exception("Seleccione la linea de negocio");
            }
            if ($movimiento["claveClasificacionM"] === "0") {
                throw new Exception("Seleccione clave de clasificacion");
            }
            if ($movimiento["selectTipoDeBanco"] == "0") {
                throw new Exception("Ingrese El Banco");
            }
            if ($movimiento["selectNumCuenta"] === "0") {
                throw new Exception("Ingrese El Numero De Cuenta");
            }
            if ($movimiento["idTipoTransaccionM"] == "TIPO TRANSACCION" || $movimiento["idTipoTransaccionM"] == "0") {
                throw new Exception("Seleccione el tipo de transaccion");
            }
            if ($movimiento["beneficiario"] == "") {
                throw new Exception("Ingrese un Beneficiario");
            }
            if ($movimiento["idDepartamentoM"] === "0") {
                throw new Exception("Seleccione un departamento");
            }
            if ($movimiento["subdepartamento"] == "0") {
                throw new Exception("Ingrese El Sub Departamento");
            }
            if ($movimiento["claveClasificacionM"] != "002-005" || $movimiento["reembolso"] != "0" && $movimiento["claveClasificacionM"] != "004-003") {
                if ($movimiento["idEmpresaM"] == "0") {
                    throw new Exception("Seleccione una empresa");
                }}
                if ($movimiento["claveClasificacionM"] != "002-005" || $movimiento["reembolso"] != "0" && $movimiento["claveClasificacionM"] != "004-003") {
                    if ($movimiento["txtIva"] === "0") {
                        throw new Exception("Elija El Iva");
                    }}
                    if ($movimiento["claveClasificacionM"] != "002-005" || $movimiento["reembolso"] != "0" && $movimiento["claveClasificacionM"] != "004-003") {
                        if ($movimiento["txtSubTotal"] == "" || preg_match($decimal, $movimiento["txtSubTotal"]) == false) {
                            throw new Exception("Verifique El Sub Total");
                        }}
                        if ($movimiento["claveClasificacionM"] != "002-005" || $movimiento["reembolso"] != "0" && $movimiento["claveClasificacionM"] != "004-003") {
                            if ($movimiento["txtDescuento"] == "" || preg_match($decimal, $movimiento["txtDescuento"]) == false) {
                                throw new Exception("Verifique El Descuento");
                            }}
                            if ($movimiento["claveClasificacionM"] != "002-005" || $movimiento["reembolso"] != "0" && $movimiento["claveClasificacionM"] != "004-003") {
                                if ($movimiento["txtIvaRetenido"] == "" || preg_match($decimal, $movimiento["txtIvaRetenido"]) == false) {
                                    throw new Exception("Verifique El Iva Retenido");
                                }}
                                if ($movimiento["reembolso"] === "0") {
                                    if ($movimiento["claveClasificacionM"] === "002-005" || $movimiento["claveClasificacionM"] === "004-003") {
                                        if ($movimiento["monto"] == "" || preg_match($decimal, $movimiento["monto"]) == false) {
                                            throw new Exception("Verifica el Monto Ingresado");
                                        }}}
                                        if ($movimiento["entidad"] === "0" || $movimiento["entidad"] === "ENTIDAD" || $movimiento["entidad"] === "null") {
                                            throw new Exception("Seleccione la entidad");
                                        }
        //$tipoTransaccion = $this->persistencia->getTipoTransaccionById($movimiento["idTipoTransaccionM"]);
                                        if ($movimiento["referencia"] == ""){
                                            throw new Exception("Ingrese El Numero De Referencia");
                                        }
                                        if ($movimiento["referencia"] != ""
                                            && $this->persistencia->existeReferenciaMovimiento($movimiento["referencia"])) {
                                            throw new Exception("El numero de referencia ya se registró previamente");
                                    }
                                    if ($movimiento["concepto"] == "") {
                                        throw new Exception("Ingrese Concepto");
                                    }
                                    if ($archivo == "" || $archivo != ".pdf") {
                                        throw new Exception("Seleccione un Archivo Correcto Tipo .pdf");
                                    }
                                    if ($movimiento["referencia"] != ""
                                        && $this->persistencia->existeReferenciaMovimiento($movimiento["referencia"])) {
                                        throw new Exception("El numero de referencia ya se registró previamente.");
                                }
                                if ($movimiento["idEstatusM"] == "") {
                                    throw new Exception("Error en el estatus del movimiento");
                                }
                                if ($movimiento["impTotalDisponibleCuenta"] < $movimiento["monto"]) {
                                    throw new Exception("No puedes enviar mas dindero del disponible");
                                }
        // $log->LogInfo("Valor de la variable \$Archivo : " . var_export ($archivo, true));
                                $this->persistencia->insertarMovimiento($movimiento);

                                if ($movimiento["reembolso"] === "1") {
            //$entre="entre";
            //quiere decir que el check de reembolso esta activado y por tanto llamar a la funcion que insertara en la otro tabla de la BD
            // $this->persistencia->insertarMovimiento($movimiento);
                                }
                            }
                            public function negocio_traeListaMovimientosPorDiaBanco($dia, $mes, $anio, $idBanco)
                            {
        //$log = new KLogger ( "negocioListaMovimientos.log" , KLogger::DEBUG );
                                $listaMovimientosPorDiaBanco = $this->persistencia->traeListaMovimientosPorDiaBanco($dia, $mes, $anio, $idBanco);
        //$log->LogInfo("negocio_traeListaMovimientosPorDiaBanco " . var_export ($listaMovimientosPorDiaBanco, true));
                                return $listaMovimientosPorDiaBanco;

                            }

                            public function negocio_ListaTipoMovimientosFinancierosSinObligaciones()
                            {
        //$log= new KLogger("negocioMovimientosFinancieros.log", KLogger::DEBUG);

                                $listaTipoMovimientosFinancieros = $this->persistencia->traerListaTipoMovimientosFinancierosSinObligaciones();
        //$log -> LogInfo ("negocio_ListaTipoMovimientosFinancieros". var_export($listaTipoMovimientosFinancieros,true));
                                return $listaTipoMovimientosFinancieros;

                            }

                            public function editarRegistroMovimientoFinanciero($movimiento)
                            {

        //$log= new KLogger("negocioEditarMovimientoFinanciero.log", KLogger::DEBUG);

                                $movimientoActual = $this->persistencia->getMovimientoFinancieroById($movimiento["idMovimiento"]);

                                if ($movimiento["idBancoM"] == "") {
                                    throw new Exception("Seleccione un Banco");

                                }

                                if ($movimiento["fechaMovimiento"] == "") {
                                    throw new Exception("Ingrese Fecha");
                                }

                                if ($movimiento["idTipoMov"] == "" || $movimiento["idTipoMov"] == "TIPO MOVIMIENTO") {
                                    throw new Exception("Seleccione el tipo de Movimiento");
                                }

                                if ($movimiento["idEmpresaM"] == "EMPRESA") {
                                    throw new Exception("Seleccione una empresa");
                                }

                                if ($movimiento["beneficiario"] == "") {
                                    throw new Exception("Ingrese un Beneficiario");

                                }

                                if ($movimiento["concepto"] == "") {
                                    throw new Exception("Ingrese Concepto");
                                }
                                if ($movimiento["idTipoTransaccionM"] == "TIPO TRANSACCION") {
                                    throw new Exception("Seleccione el tipo de transaccion");
                                }
                                if ($movimiento["claveClasificacionM"] == "CLAVES" || $movimiento["claveClasificacionM"] == "") {
                                    throw new Exception("Seleccione clave de clasificacion");
                                }

                                if ($movimiento["idDepartamentoM"] == "DEPARTAMENTO") {
                                    throw new Exception("Seleccione un departamento");
                                }

                                $tipoTransaccion = $this->persistencia->getTipoTransaccionById($movimiento["idTipoTransaccionM"]);

                                $referenciaNueva = $movimiento["referencia"];

                                if ($referenciaNueva == ""
                                    && $tipoTransaccion != null
                                    && $tipoTransaccion["descripcionTransaccion"] == "CHEQUE") {
                                    throw new Exception("El numero de referencia es obligatorio para CHEQUES");
                            }

        // Obtiene la referencia actual del movimiento
                            $referenciaActual = $movimientoActual["referencia"];

        // Verifica que la nueva referencia no se encuentre asignada en otro movimiento.
                            if ($referenciaNueva != ""
                                && $referenciaNueva != $referenciaActual
                                && $this->persistencia->existeReferenciaMovimiento($referenciaNueva)) {
                                throw new Exception("El numero de referencia ya se encuentra asignado a otro movimiento.");
                        }

                        if ($movimiento["monto"] == "") {
                            throw new Exception("Ingrese Monto");
                        }

        //$log->LogInfo("Valor de la variable \$movimiento : " . var_export ($movimiento, true));
                        $this->persistencia->actualizarMovimientoFinanciero($movimiento);
                    }

                    public function editarEstatusMovimientoFinanciero($movimiento)
                    {
        //$log= new KLogger("negocioEditarEstatusMovimientoFinanciero.log", KLogger::DEBUG);
        //$log->LogInfo("Valor de la variable \$movimiento : " . var_export ($movimiento, true));
                        $this->persistencia->actualizarEstatusMovimientoFinanciero($movimiento);
                    }

                    public function negocio_traeListaMovimientosPorDiaStoreProcedure($fecha, $bancoId, $empresaId)
                    {
        //$log = new KLogger ( "negocioListaMovimientosStoreProcedure.log" , KLogger::DEBUG );
                        $listaMovimientosPorDiaBanco = $this->persistencia->traeListaMovimientosPorDiaBancoStoreProcedure($fecha, $bancoId, $empresaId);
        //$log->LogInfo("negocio_traeListaMovimientosPorDiaBanco " . var_export ($listaMovimientosPorDiaBanco, true));
                        return $listaMovimientosPorDiaBanco;

                    }
                    public function negocio_ListaSaldosIncialesDelDiaSistema($dia, $mes, $anio, $empresaId)
                    {
        //$log= new KLogger("negocio_ListaSaldosIncialesDelDiaSistema.log", KLogger::DEBUG);

                        $listaSaldosDiaSistema = $this->persistencia->traerSaldosInicialesSistema($dia, $mes, $anio, $empresaId);
        //$log -> LogInfo ("negocio_ListaSaldosIncialesDelDiaSistema". var_export($listaSaldosDiaSistema,true));
                        return $listaSaldosDiaSistema;

                    }

                    public function negocio_traeListaMovimientosPorPeriodoStoreProcedure($fecha1, $fecha2, $bancoId, $empresaId)
                    {
        //$log = new KLogger ( "negocio_traeListaMovimientosPorPeriodoStoreProcedure.log" , KLogger::DEBUG );
        //$log->LogInfo("fecha1 " . var_export ($fecha1, true));
        //$log->LogInfo("fecha2 " . var_export ($fecha2, true));

                        if ($fecha1 == "") {
                            throw new Exception("Seleccione fecha 1");

                        }
                        if ($fecha2 == "") {
                            throw new Exception("Seleccione fecha 2");

                        }

                        $listaMovimientosPorPeriodoBanco = $this->persistencia->traeListaMovimientosPorPeriodoBancoStoreProcedure($fecha1, $fecha2, $bancoId, $empresaId);
        //$log->LogInfo("negocio_traeListaMovimientosPorPeriodoStoreProcedure " . var_export ($listaMovimientosPorPeriodoBanco, true));
                        return $listaMovimientosPorPeriodoBanco;

                    }

    /**
     * Obtiene la lista de beneficiarios registrados en movimientos registrados en el sistema.
     *
     * Obtiene la lista de beneficiarios registrados en movimientos registrados en el sistema.
     * Esta lista se utiliza para el autocomplete del campo de beneficiario al momento de
     * registrar un nuevo movimiento.
     *
     * @return array con la lista de beneficiarios
     */
    public function obtenerListaBeneficiarios()
    {
        $listaBeneficiarios = $this->persistencia->obtenerListaBeneficiarios();

        return $listaBeneficiarios;
    }

    /**
     * Obtiene la lista de conceptos registrados en movimientos registrados en el sistema.
     *
     * Obtiene la lista de conceptos registrados en movimientos registrados en el sistema.
     * Esta lista se utiliza para el autocomplete del campo de concepto al momento de
     * registrar un nuevo movimiento.
     *
     * @return array con la lista de conceptos
     */
    public function obtenerListaConceptos()
    {
        $listaConceptos = $this->persistencia->obtenerListaConceptos();

        return $listaConceptos;
    }

    public function negocio_insertarActualizarSaldoInicial($fecha, $bancoId, $idEmpresa, $saldo, $usuarioCaptura)
    {
        //$log= new KLogger("negocio_insertarActualizarSaldoInicial.log", KLogger::DEBUG);

        if (is_numeric($saldo)) {

        } else {
            throw new Exception("Ingrese Saldo correctamente(sin comas ni caracteres especiales");
        }

        //$log->LogInfo("fechaSaldo " . var_export ($fecha, true));
        //$log->LogInfo("bancoIdSaldo " . var_export ($bancoId, true));
        //$log->LogInfo("idEmpresaSaldo " . var_export ($idEmpresa, true));
        //$log->LogInfo("saldoInicial " . var_export ($saldo, true));
        //$log->LogInfo("usuarioCaptura " . var_export ($usuarioCaptura, true));

        $this->persistencia->insertaActualizaSaldoInicialProcedure($fecha, $bancoId, $idEmpresa, $saldo, $usuarioCaptura);
    }

    public function negocio_traeListaMovimientosPorDiaGeneralStoreProcedure($fecha, $empresaId)
    {
        //$log = new KLogger ( "negocio_traeListaMovimientosPorDiaGeneralStoreProcedure.log" , KLogger::DEBUG );
        $listaMovimientosPorDiaGeneral = $this->persistencia->traeListaMovimientosPorDiaGeneralStoreProcedure($fecha, $empresaId);
        //$log->LogInfo("negocio_traeListaMovimientosPorDiaGeneralStoreProcedure " . var_export ($listaMovimientosPorDiaGeneral, true));
        return $listaMovimientosPorDiaGeneral;

    }

    public function negocio_traeListaMovimientosPorPeriodoGeneralStoreProcedure($fecha1, $fecha2, $empresaId)
    {
        //$log = new KLogger ( "negocio_traeListaMovimientosPorPeriodoGeneralStoreProcedure.log" , KLogger::DEBUG );
        //$log->LogInfo("fecha1 " . var_export ($fecha1, true));
        //$log->LogInfo("fecha2 " . var_export ($fecha2, true));

        if ($fecha1 == "") {
            throw new Exception("Seleccione fecha 1");

        }
        if ($fecha2 == "") {
            throw new Exception("Seleccione fecha 2");

        }

        $listaMovimientosPorPeriodoGeneral = $this->persistencia->traeListaMovimientosPorPeriodoGeneralStoreProcedure($fecha1, $fecha2, $empresaId);
        //$log->LogInfo("negocio_traeListaMovimientosPorPeriodoGeneralStoreProcedure " . var_export ($listaMovimientosPorPeriodoGeneral, true));
        return $listaMovimientosPorPeriodoGeneral;

    }

    public function negocio_crearTablaTemporal()
    {
        $this->persistencia->crearTablaMovimientosTemp();
    }

    public function registrarMovimientoArchivoBanco($movimiento)
    {
        //$log = new KLogger ( "negocioRegistroMovimientoArchivoBanco.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$movimiento : " . var_export ($movimiento, true));

        return $this->persistencia->insertarMovimientoArchivoBanco($movimiento);
    }

    public function obtenerUsuarioLoggeado()
    {
        return $_SESSION["userLog"];
    }

    public function negocio_insertarMovimientoArchivoBanco($movimiento)
    {
        //$log= new KLogger("negocio_insertarMovimientoArchivoBanco.log", KLogger::DEBUG);

        //$log->LogInfo("Valor de la variable \$movimiento : " . var_export ($movimiento, true));

        return $this->persistencia->insertarMovimientoArchivoBancoStore($movimiento);
    }

    public function negocio_traerListaIngresosEgresos($mes, $anio, $empresaId)
    {
        //$log = new KLogger ( "negocio_traerListaIngresosEgresos.log" , KLogger::DEBUG );
        //$log->LogInfo("mes " . var_export ($mes, true));
        //$log->LogInfo("anio " . var_export ($anio, true));
        //$log->LogInfo("empresa " . var_export ($empresaId, true));

        $listaIngresosEgresos = $this->persistencia->traeIngresosEgresos($mes, $anio, $empresaId);
        //$log->LogInfo("negocio_traerListaIngresosEgresos " . var_export ($listaIngresosEgresos, true));
        return $listaIngresosEgresos;

    }

    public function negocio_traerListaPersonalActivo()
    {
        //$log = new KLogger ( "negocio_traerListaPersonalActivo.log" , KLogger::DEBUG );

        $listaPersonalActivo = $this->persistencia->obtenerListaPersonalActivo();
        //$log->LogInfo("ListaPersonalActivo " . var_export ($listaPersonalActivo, true));
        return $listaPersonalActivo;

    }
    public function negocio_ConsultaPreviaCliente($NumeroCliente)
    {
         $ClientePrevio = $this->persistencia->existeNumeroCliente($NumeroCliente);
        //$log->LogInfo("ListaPersonalActivo " . var_export ($listaPersonalActivo, true));
        return $ClientePrevio;
    }
    public function negocio_registrarCliente($cliente)
    {  

        $patronNumeroClienteNom = '/[0-9]{4}+\-+[0-9]{3}+\-+[0-9]{4}/';
        $patrocp               = '/[0-9]{5}/';
        $patrontelefono         = '/[0-9]{10}/';
        $patronRfcCont = '/[a-zA-Z0-9]{3}+[0-9]{6}+[a-zA-Z0-9]{3}/';
        $patronRfc2 = '/[a-zA-Z]{4}+[0-9]{6}+[a-zA-Z0-9]{3}/';
        $patronCorreo   = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
        //$log = new KLogger ( "negocioRegistroCliente.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$cliente : " . var_export ($cliente, true));

        if ($cliente["claveClienteNomina"] == "") {
            throw new Exception("Por favor ingrese: Numero de cliente proporcionado por nomina");
        }

        if ($this->persistencia->existeNumeroCliente($cliente["claveClienteNomina"])) {
            throw new Exception("El numero de cliente ya se encuantra registrado en la base");
        }

        if ($cliente["claveClienteNomina"] != "") {
            if (preg_match($patronNumeroClienteNom, $cliente["claveClienteNomina"]) == false) {
                throw new Exception("Numero de cliente inválido, verifique formato ####-###-#### ");
            }
        }
        if ($cliente["NumeroContrato"] == "0") {
            throw new Exception("Por favor Seleccione: Número De Contrato");
        }
        if ($cliente["AnexoContrato"] == "LETRAS") {
            throw new Exception("Por favor Seleccione: Anexo Contrato");
        }
        if ($cliente["TipoContrato"] == "0") {
            throw new Exception("Por favor Seleccione: Tipo De Contrato");
        }
        if ($cliente["ObjetoContrato"] == "") {
            throw new Exception("Por favor Ingrese: El Objeto De Contrato");
        }
        if (($cliente["VigenciaAnio"] == "0") && ($cliente["VigenciaMes"] =="0")) {
            throw new Exception("Por favor Seleccione: La Vigencia En Años/Meses Del Contrato");
        }
        if ($cliente["FechaInicioC"] == "") {
            throw new Exception("Por favor Seleccione: Fecha De Inicio Del Contrato");
        }
        if ($cliente["FechafinC"] == "") {
            throw new Exception("Por favor Revise: Revisar Que La vigencia Y La Fecha De Inio Sean Correctas Para generar La Fecha Final En Automatico");
        }
        if ($cliente["Persona"] == "0") {
            throw new Exception("Selecciona Si Es Persona Fisica O Persona Moral");
        }
        if ($cliente["rfcCliente"] == "") {
            throw new Exception("Por favor ingrese: RFC ");
        }
        if (($cliente["Persona"] == "Persona Fisica") && (strlen($cliente["rfcCliente"]) != 13)) {
            throw new Exception("Por favor ingrese: RFC con longitud de 13 caracteres");
        }
        if ($cliente["Persona"] == "Persona Moral" && strlen($cliente["rfcCliente"]) != 12) {
            throw new Exception("Por favor ingrese: RFC con longitud de 12 caracteres");
        }
        if ($cliente["Persona"] == "Persona Fisica" && preg_match($patronRfc2, $cliente["rfcCliente"]) == false) {
            throw new Exception("Formaro rfc inválido para RFC ");
        }
        if ($cliente["Persona"] == "Persona Moral" && preg_match($patronRfcCont, $cliente["rfcCliente"]) == false) {
            throw new Exception("Formaro rfc inválido para RFC ");
        }
        if ($this->persistencia->existeRfcCliente($cliente["rfcCliente"])) {
            throw new Exception("El rfc del cliente ya se encuantra registrado en la base");
        }
        if ($cliente["razonSocial"] == "") {
            throw new Exception("Por favor ingrese: Razon Social");
        }
        if ($cliente["RegistroPatronalC"] == "") {
            throw new Exception("Por favor ingrese: Registro Patronal");
        }
        if ($cliente["nombreComercial"] == "") {
            throw new Exception("Por favor ingrese: Nombre comercial");
        }
        if ($cliente["contactoCliente"] == "") {
            throw new Exception("Por favor ingrese: Nombre del Contacto");
        }
        if ($cliente["telefonoFijoCliente"] == "" and $cliente["telefonoMovilCliente"] == "") {
            throw new Exception("Por favor ingrese por lo menos un numero de contacto");
        }
        if ($cliente["telefonoFijoCliente"] != "" && preg_match($patrontelefono, $cliente["telefonoFijoCliente"]) == false) {
                throw new Exception("Ingresa El Numero Fijo Correctamente ");
        }
        if ($cliente["telefonoMovilCliente"] != "" && preg_match($patrontelefono, $cliente["telefonoMovilCliente"]) == false) {
                throw new Exception("Ingresa El Numero Movil Correctamente ");
        }
        if ($cliente["CpContrato"] == "") {
            throw new Exception("Por favor ingrese: El Codigo Postal");
        }
        if (preg_match($patrocp, $cliente["CpContrato"]) == false) {
                throw new Exception("Formaro Codigo Postal inválido 5 Digitos ");
            }
        if ($cliente["EntidadCliente"] == "0") {
            throw new Exception("Por favor Seleccione: La Entidad O Escoga El Asentamiento");
        }
        if ($cliente["Municipio"] == "0") {
            throw new Exception("Por favor Seleccione: Municipio O Escoga El Asentamiento");
        }
        if ($cliente["ColoniaCliente"] == "0") {
            throw new Exception("Por favor Seleccione: La Colonia O Escoga El Asentamiento");
        }
        if ($cliente["CallePrincipal"] == "") {
            throw new Exception("Por favor Ingrese: La Calle Principal");
        }
        if ($cliente["NumeroInteriro"] == "") {
            throw new Exception("Por favor Ingrese: El Numero Interior");
        }
        if ($cliente["NumeroExterior"] == "") {
            throw new Exception("Por favor Ingrese: El Numero Exterior");
        }
        if ($cliente["Calle1"] == "") {
            throw new Exception("Por favor Ingrese: La Primer Calle Colindante");
        }
        if ($cliente["Calle2"] == "") {
            throw new Exception("Por favor Ingrese: La Segunda Calle Colindante");
        }
        if ($cliente["correoCliente"] == "") {
            throw new Exception("Por favor Ingrese: El Correo Electronico");
        }
        if (preg_match($patronCorreo, $cliente["correoCliente"]) == false) {
            throw new Exception("El formato de correo electronico es incorrecto");
        }
        if ($cliente["MontoContrato"] == "") {
            throw new Exception("Por favor Ingrese: El Monto del Contrato");
        }
        if ($cliente["ArchivoContrato"] == "") {
            throw new Exception("Por favor Adjunte el Contrato En Formato PDF");
        }
        if ($cliente["ArchivoContrato"] == "") {
            throw new Exception("Por favor Adjunte el Contrato En Formato PDF");
        }
        if ($cliente["Persona"] == "0") {
            throw new Exception("Por favor Seleccione: Persona Fisica o Persona Moral");
        }
        if ($cliente["RfcContratante"] == "") {
            throw new Exception("Por favor Ingrese: El RFC Del Contratante");
        }
        if (strlen($cliente["RfcContratante"]) != 13) {
            throw new Exception("Por favor ingrese: RFC con longitud de 13 caracteres");
        }
        if (preg_match($patronRfc2, $cliente["RfcContratante"]) == false) {
            throw new Exception("El formato del RFC del contratante es incorrecto");
        }
        if ($cliente["NombreContratante"] == "") {
            throw new Exception("Por Faver Ingrese: EL/Los Nombres Del Contratante");
        }
        if ($cliente["PrimerApellidoContratante"] == "") {
            throw new Exception("Por Faver Ingrese: El Primer Apellido Del Contratante");
        }
        if ($cliente["CorreoContratante"] == "") {
            throw new Exception("Por Faver Ingrese: El Correo Del Contratante");
        }
        if (preg_match($patronCorreo, $cliente["correoCliente"]) == false) {
            throw new Exception("El formato de correo electronico del Contratante es incorrecto");
        }
        if ($cliente["TelMovilContratante"] == "") {
            throw new Exception("Por Faver Ingrese: El Telefono Del Contratante");
        }
        if (preg_match($patrontelefono, $cliente["TelMovilContratante"]) == false) {
            throw new Exception("El formato del telefono del contratante es incorrecto");
        }

    $this->persistencia->insertarCliente($cliente);
}

public function negocio_obtenerListaClientesActivos()
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $listaClientes = array();
    $listaClientes = $this->persistencia->traeCatalogoClientesActivos();
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $listaClientes;
}
public function negocio_registrarPuntoServicio($puntoServicio)
{
 //$log = new KLogger ( "registropuntoserv.log" , KLogger::DEBUG );
//$log->LogInfo("Valor del formulario" . var_export ($puntoServicio, true));
    $patronCorreo   = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
    $patronTelefono = '/\(+[0-9]{1,4}+\)-+[0-9]{4}+\-+[0-9]{4}/';
    $patrocp               = '/[0-9]{5}/';

    if ($puntoServicio["idClientePunto"] == "CLIENTE") {
        throw new Exception("Por favor seleccione un cliente");
    }

    if ($puntoServicio["numeroCentroCosto"] == "") {
        throw new Exception("Por favor ingrese: Número de Centro de Costo");
    }

    if ($puntoServicio["puntoServicio"] == "") {
        throw new Exception("Por favor ingrese: Nombre del punto de servicio");
    }
//SE MODIFICARON ESTOS DOS PARAMETROS
    if ($puntoServicio["selLineaNegocio"] === "0") {
        throw new Exception("Por favor seleccione: LINEA DE NEGOCIO");
    }

    if ($puntoServicio["idEntidadPunto"] == "0") {
        throw new Exception("Por favor seleccione una entidad federativa");
    }
//"****************************************************************************
    if ($puntoServicio["idClientePunto"] == 43) {//id de cliente de walmart
        
        if ($puntoServicio["selmunicipiowalmrt"] == 0 || $puntoServicio["selmunicipiowalmrt"]=="") {//id de cliente de walmart
        throw new Exception("Por favor seleccione una delegación/municipio");
    }else if($puntoServicio["txtunidad"] == "" ){
        throw new Exception("Por favor ingrese unidad");
    }
    }
    if ($puntoServicio["CpContrato"] == "") {
            throw new Exception("Por favor ingrese: El Codigo Postal");
        }
    if (preg_match($patrocp, $puntoServicio["CpContrato"]) == false) {
            throw new Exception("Formaro Codigo Postal inválido 5 Digitos ");
        }
    if ($puntoServicio["EntidadCliente"] == "0") {
        throw new Exception("Por favor Seleccione: La Entidad O Escoga El Asentamiento");
    }
    if ($puntoServicio["Municipio"] == "0") {
        throw new Exception("Por favor Seleccione: Municipio O Escoga El Asentamiento");
    }
    if ($puntoServicio["ColoniaCliente"] == "0") {
        throw new Exception("Por favor Seleccione: La Colonia O Escoga El Asentamiento");
    }
    if ($puntoServicio["CallePrincipal"] == "") {
        throw new Exception("Por favor Ingrese: La Calle Principal");
    }
    if ($puntoServicio["NumeroInteriro"] == "") {
        throw new Exception("Por favor Ingrese: El Numero Interior");
    }
    if ($puntoServicio["NumeroExterior"] == "") {
        throw new Exception("Por favor Ingrese: El Numero Exterior");
    }
    if ($puntoServicio["Calle1"] == "") {
        throw new Exception("Por favor Ingrese: La Primer Calle Colindante");
    }
    if ($puntoServicio["Calle2"] == "") {
        throw new Exception("Por favor Ingrese: La Segunda Calle Colindante");
    }
/*
    if ($puntoServicio["direccionPuntoServicio"] == "") {
        throw new Exception("Por favor ingrese: Dirección del punto de servicio");
    }
*/
    if ($puntoServicio["latitudPunto"] != "") {
        if (is_numeric($puntoServicio["latitudPunto"]) == false) {
            throw new Exception("Verifique latitud");
        }
    }
    if ($puntoServicio["longitudPunto"] != "") {
        if (is_numeric($puntoServicio["longitudPunto"]) == false) {
            throw new Exception("Verifique longitud");
        }
    }

    if ($puntoServicio["fechaInicioServicio"] == "") {
        throw new Exception("Ingrese Fecha Inicio");
    }
    if ($puntoServicio["fechaTerminoServicio"] == "") {
        throw new Exception("Ingrese Fecha de termino de servicio");
    }

    if ($puntoServicio["contactoTesoreria"] == "" and $puntoServicio["contactoFacturacion"] == "") {
        throw new Exception("Por favor ingrese por lo menos un Contacto Administrativo");

    }

    if ($puntoServicio["contactoFacturacion"] != "") {

        if ($puntoServicio["correoFacturacion"] == "") {
            throw new Exception("Por favor ingrese: Correo de facturación");
        }

        if ($puntoServicio["correoFacturacion"] != "") {

            if (preg_match($patronCorreo, $puntoServicio["correoFacturacion"]) == false) {
                throw new Exception("El formato de correo electronico de facturación es incorrecto");
            }
        }

        if ($puntoServicio["telefonoFijoFacturacion"] == "" and $puntoServicio["telefonoMovilFacturacion"] == "") {
            throw new Exception("Por favor ingrese por lo menos un número de contacto para facturación");
        }

    }
    if ($puntoServicio["terminoFacturacion"] == "") {
        throw new Exception("Por favor ingrese terminos de facturación");

    }
    if ($puntoServicio["contactoTesoreria"] != "") {

        if ($puntoServicio["correoTesoreria"] == "") {
            throw new Exception("Por favor ingrese: Correo de Tesoreria");
        }

        if ($puntoServicio["correoTesoreria"] != "") {

            if (preg_match($patronCorreo, $puntoServicio["correoTesoreria"]) == false) {
                throw new Exception("El formato de correo electronico de Tesoreria es incorrecto");
            }
        }
        if ($puntoServicio["telefonoFijoTesoreria"] == "" and $puntoServicio["telefonoMovilTesoreria"] == "") {
            throw new Exception("Por favor ingrese por lo menos un número de contacto para Tesoreria");
        }

    }

    if ($puntoServicio["contactoOperativo"] == "") {
        throw new Exception("Por favor ingrese contacto operativo");

    }

    if ($puntoServicio["contactoOperativo"] != "") {

        if ($puntoServicio["correoOperativo"] == "") {
            throw new Exception("Por favor ingrese: Correo de Operaciones");
        }

        if ($puntoServicio["correoOperativo"] != "") {

            if (preg_match($patronCorreo, $puntoServicio["correoOperativo"]) == false) {
                throw new Exception("El formato de correo electronico de Operacion es incorrecto");
            }
        }

        if ($puntoServicio["telefonoMovilOperativo"] == "" and $puntoServicio["telefonoFijoOperativo"] == "") {
            throw new Exception("Por favor ingrese por lo menos un número de contacto para Operaciones");
        }

    }

    if ($this->persistencia->existeNumeroCentroCostoCliente($puntoServicio["idClientePunto"], $puntoServicio["numeroCentroCosto"])) {
        throw new Exception("El numero de centro de costo para el cliente seleccionado ya se encuentra registrado en la base");
    }

        //$log = new KLogger ( "negocio_registrarPuntoServicio.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$puntoServicio : " . var_export ($puntoServicio, true));

    $this->persistencia->insertarPuntoServicio($puntoServicio);

}
public function negocio_obtenerUltimoNumeroOrden()
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

    $ultimoNumeroOrden = "";
    $ultimoNumeroOrden = $this->persistencia->traerUltimoNumeroOrden();
        //$log -> LogInfo ("negocio_obtenerUltimoNumeroOrden". var_export($ultimoNumeroOrden,true));
    return $ultimoNumeroOrden;

}

public function negocio_obtenerListaEstatusCartilla()
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listaEstatusCartilla = array();
    $listaEstatusCartilla = $this->persistencia->traeCatalogoEstatusCartilla();
        //$log->LogInfo("Valor de la variable \$listaEstatusCartilla: " . var_export ($listaEstatusCartilla, true));
    return $listaEstatusCartilla;
}

public function negocio_obtenerListaGradoEstudios()
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listaGradoEstudios = array();
    $listaGradoEstudios = $this->persistencia->traeCatalogoGradoEstudios();
        //$log->LogInfo("Valor de la variable \$listaGradoEstudios: " . var_export ($listaGradoEstudios, true));
    return $listaGradoEstudios;
}
public function negocio_obtenerListaEstadoCivil()
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listaEstadoCivil = array();
    $listaEstadoCivil = $this->persistencia->traeCatalogoEstadoCivil();
        //$log->LogInfo("Valor de la variable \$listaEstadoCivil: " . var_export ($listaEstadoCivil, true));
    return $listaEstadoCivil;
}

public function negocio_obtenerListaPaises()
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listaPaises = array();
    $listaPaises = $this->persistencia->traeCatalogoPaises();
        //$log->LogInfo("Valor de la variable \$listaPaises: " . var_export ($listaPaises, true));
    return $listaPaises;
}

public function negocio_registroDatosPersonalesEmpleado($datoPersonalEmpleado)
{
        //$log = new KLogger ( "negocioRegistroDatosPersonales.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$datoPersonalEmpleado : " . var_export ($datoPersonalEmpleado, true));
        //$patronCurp='#^[A-Z]{4}+[0-9]{6}+[A-Z]{6}+[a-z]{2}$#';
    $patronRfcEmpleado = '#^[A-Z]{4}+[0-9]{6}+[A-Z0-9]{3}$#';
    if ($datoPersonalEmpleado["fechaNacimiento"] == "") {
        throw new Exception("Por favor proporcione Fecha de nacimiento");
    }
    if ($datoPersonalEmpleado["paisNacimientoId"] == "SIN PAIS" || $datoPersonalEmpleado["paisNacimientoId"] == "" || $datoPersonalEmpleado["paisNacimientoId"] == NULL || $datoPersonalEmpleado["paisNacimientoId"] == "NULL" || $datoPersonalEmpleado["paisNacimientoId"] == "null" || $datoPersonalEmpleado["paisNacimientoId"] == null || $datoPersonalEmpleado["paisNacimientoId"] == "0") {
        throw new Exception("Seleccione El País De Nacimiento");
    }
    if ($datoPersonalEmpleado["entidadNacimientoId"] == "ENTIDAD FEDERATIVA" || $datoPersonalEmpleado["entidadNacimientoId"] == "" || $datoPersonalEmpleado["entidadNacimientoId"] == "NULL" || $datoPersonalEmpleado["entidadNacimientoId"] == NULL || $datoPersonalEmpleado["entidadNacimientoId"] == "null" || $datoPersonalEmpleado["entidadNacimientoId"] == null) {
        throw new Exception("Seleccione La Entidad De Nacimiento");
    }
    if ($datoPersonalEmpleado["municipioNacimientoId"] == "MUNICIPIOS" || $datoPersonalEmpleado["municipioNacimientoId"] == "" || $datoPersonalEmpleado["municipioNacimientoId"] == "NULL" || $datoPersonalEmpleado["municipioNacimientoId"] == NULL || $datoPersonalEmpleado["municipioNacimientoId"] == "null" || $datoPersonalEmpleado["municipioNacimientoId"] == null || $datoPersonalEmpleado["municipioNacimientoId"] == "0") {
        throw new Exception("Seleccione El Municipio De Nacimiento");
    }
    if ($datoPersonalEmpleado["curpEmpleado"] == "") {
        throw new Exception("El CURP NO Pude Estar Vacio Proporcione CURP (18 Caracteres)");
    }
    if ($datoPersonalEmpleado["curpEmpleado"] != "") {
        if (strlen($datoPersonalEmpleado["curpEmpleado"]) != 18) {
            throw new Exception("El CURP NO Contiene Los (18 Caracteres) Correspondientes");
        }
    }

        /*  if(preg_match($patronCurp,$datoPersonalEmpleado["curpEmpleado"] ) == false)
        {

        throw new Exception("El formato de curp no cumple");

    }*/

    if ($this->persistencia->existeCurpEmpleado($datoPersonalEmpleado["curpEmpleado"])) {
        throw new Exception("El CURP del empleado ya se encuentra registrado en la base de datos");
    }

    if ($datoPersonalEmpleado["rfcEmpleado"] == "") {
        throw new Exception("Proporcione RFC (13 Caracteres)");
    }

    if ($datoPersonalEmpleado["rfcEmpleado"] != "") {
        if (strlen($datoPersonalEmpleado["rfcEmpleado"]) != 13) {
            throw new Exception("RFC inválido");
        }

    }

    if (preg_match($patronRfcEmpleado, $datoPersonalEmpleado["rfcEmpleado"]) == false) {

        throw new Exception("El formato de rfc no cumple");
    }

    if ($this->persistencia->existeRfcEmpleado($datoPersonalEmpleado["rfcEmpleado"])) {
        throw new Exception("El RFC del empleado ya se encuentra registrado en la base de datos");
    }

    if ($datoPersonalEmpleado["estadoCivilId"] == "ESTADO CIVIL") {
        throw new Exception("Seleccione estado civil");
    }
    if ($datoPersonalEmpleado["gradoEstudiosId"] == "GRADO ESTUDIOS") {
        throw new Exception("Seleccione Grado de estudios");
    }

    if ($datoPersonalEmpleado["tipoSangreId"] == "TIPO SANGRE") {
        throw new Exception("Seleccione tipo de sangre");
    }
    if ($datoPersonalEmpleado["oficioId"] == "OFICIO") {
        throw new Exception("Seleccione Oficio");
    }

    if ($datoPersonalEmpleado["estatusCartillaId"] == "") {
        throw new Exception("Seleccione Estatus Cartilla");
    }

    if (($datoPersonalEmpleado["estatusCartillaId"] == 1 || $datoPersonalEmpleado["estatusCartillaId"] == 2 || $datoPersonalEmpleado["estatusCartillaId"] == 5) and $datoPersonalEmpleado["numeroCartilla"] == "") {

        throw new Exception("Proporcione número de cartilla N");

    }

    $this->persistencia->insertarDatosPersonalesEmpleado($datoPersonalEmpleado);
}

public function negocio_obtenerDireccionPorCodigoPostal($codigoPostal)
{
    $listaDirecciones = $this->persistencia->obtenerDireccionPorCodigoPostal($codigoPostal);

    return $listaDirecciones;
}

public function negocio_obtenerListaClientes()
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $listaClientes = array();
    $listaClientes = $this->persistencia->traeCatalogoClientes();
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $listaClientes;
}

public function negocio_traerListaMunicipiosPorEntidad($idEntidad)
{
        //$log = new KLogger ( "negocio_traerListaMunicipiosPorEntidad.log" , KLogger::DEBUG );

    $listaMunicipios = $this->persistencia->obtenerMunicipiosPorEntidad($idEntidad);
        //$log->LogInfo("listaMunicipios " . var_export ($listaMunicipios, true));
    return $listaMunicipios;

}

public function negocio_registroDatosDireccion($datosDireccion)
{
        //$log = new KLogger ( "negocio_registroDatosDireccion.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$datosDireccion : " . var_export ($datosDireccion, true));

    $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

    if ($datosDireccion["idAsentamientoDireccion"] == "") {
        throw new Exception("Seleccione Codigo de postal");
    }

    if ($datosDireccion["calle"] == "") {
        throw new Exception("Proporcione Calle de vivienda");
    }

    if ($datosDireccion["numeroExterior"] == "" and $datosDireccion["numeroInterior"] == "") {
        throw new Exception("Proporcione por lo menos un número Interior o Exterior");
    }

    if ($datosDireccion["telefonoFijoEmpleado"] == "" and $datosDireccion["telefonoMovilEmpleado"] == "") {
        throw new Exception("Proporcione por lo menos un número de contacto");
    }


    if ($datosDireccion["telefonoFijoEmpleado"] != "" and $datosDireccion["telefonoMovilEmpleado"] == "" and (strlen($datosDireccion["telefonoFijoEmpleado"])) != "10") {
        throw new Exception("El numero de telefono fijo debe contener al menos 10 digitos como maximo y 10 digitos como minimo");
    }
    if ($datosDireccion["telefonoFijoEmpleado"] == "" and $datosDireccion["telefonoMovilEmpleado"] != "" and (strlen($datosDireccion["telefonoMovilEmpleado"])) !="10") {
        throw new Exception("El numero de telefono Movil debe contener al menos 10 digitos");
    }
    if ($datosDireccion["telefonoFijoEmpleado"] != "" and $datosDireccion["telefonoMovilEmpleado"] != "" and ((strlen($datosDireccion["telefonoMovilEmpleado"])) !="10" or (strlen($datosDireccion["telefonoFijoEmpleado"])) !="10")) {
        throw new Exception("Los numeros telefonicos deben contener al menos 10 digitos");
    }

    if ($datosDireccion["correoEmpleado"] == "") {
        throw new Exception("Proporcione correo");
    }

    if ($datosDireccion["correoEmpleado"] != "") {

        if (preg_match($patronCorreo, $datosDireccion["correoEmpleado"]) == false) {
            throw new Exception("El formato de correo es incorrecto");
        }

        if ($this->persistencia->existeCorreoEmpleadosR($datosDireccion)) {
            throw new Exception("El correo ingresado ya existe");
        }
    }

    if ($datosDireccion["idUnidadMedicaAsignada"] == "") {
        $this->persistencia->insertarDatosDireccionSinUmf($datosDireccion);

    } else {

        $this->persistencia->insertarDatosDireccion($datosDireccion);

    }
}

public function negocio_obtenerListaParentescos()
{
        //$log = new KLogger ( "negocioParentescos.log" , KLogger::DEBUG );

    $listaParentescos = array();
    $listaParentescos = $this->persistencia->traeCatalogoParentescos();
        //$log->LogInfo("Valor de la variable \$listaParentescos: " . var_export ($listaParentescos, true));
    return $listaParentescos;
}

public function negocio_registroDatosFamiliares($datosFamiliares)
{
        //$log = new KLogger ( "negocio_registroDatosFamiliares.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$datosFamiliares : " . var_export ($datosFamiliares, true));

    if ($datosFamiliares["idParentescoFamiliar"] == 5 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos de la Madre");
    }
    if ($datosFamiliares["idParentescoFamiliar"] == 5 and $datosFamiliares["beneficiario"] == 1 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos de la Madre");
    }
    if ($datosFamiliares["idParentescoFamiliar"] == 4 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos del Padre");
    }
    if ($datosFamiliares["idParentescoFamiliar"] == 4 and $datosFamiliares["beneficiario"] == 1) {
        throw new Exception("Proporcione Datos del Padre");
    }
    if ($datosFamiliares["idParentescoFamiliar"] != 4 and $datosFamiliares["beneficiario"] == 1 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos del Beneficiario");
    }
    if ($datosFamiliares["idParentescoFamiliar"] != 5 and $datosFamiliares["beneficiario"] == 1 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos del Beneficiario");
    }

    $this->persistencia->insertarDatosFamiliares($datosFamiliares);
}

public function negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

    $empleado = array();
    $empleado = $this->persistencia->obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
    return $empleado;
}

public function negocio_obtenerEmpleadoPorNombre($nombre,$usuario)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorNombre.log" , KLogger::DEBUG );

    $listaEmpleados = array();
    $listaEmpleados = $this->persistencia->obtenerEmpleadoPorNombre($nombre,$usuario);
        //$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($listaEmpleados, true));
    return $listaEmpleados;
}

public function negocio_obtenerUmfPorMunicipio($idMunicipio)
{

        //$log = new KLogger ( "negocio_obtenerUmfPorMunicipio.log" , KLogger::DEBUG );
    $listaUmf = $this->persistencia->obtenerUmfPorMunicipio($idMunicipio);

    return $listaUmf;
}

    //FUNCION PARA OBTENER PUNTOS DE SERVICIOS POR ENTIDAD..........SE REALIZARA UNA FUNCION QUE OBTENGA
    //TODOS LOS PUNTOS DE SERVICIOS POR TODAS LAS ENTIDADES

public function negocio_obtenerPuntosServiciosPorEntidad($idEntidad, $estatusPunto,$estatusEmpleadoh)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $listaPuntos = array();
    $listaPuntos = $this->persistencia->obtenerPuntosServiciosPorEntidad($idEntidad, $estatusPunto,$estatusEmpleadoh);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $listaPuntos;
}

public function negocio_registroDatosFamiliaresStore($datosFamiliares)
{
        //$log = new KLogger ( "negocio_registroDatosFamiliaresStore.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$datosFamiliares : " . var_export ($datosFamiliares, true));

    if ($datosFamiliares["idParentescoFamiliar"] == 5 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos de la Madre");
    }
    if ($datosFamiliares["idParentescoFamiliar"] == 5 and $datosFamiliares["beneficiario"] == 1 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos de la Madre (Beneficiaria)");
    }
    if ($datosFamiliares["idParentescoFamiliar"] == 4 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos del Padre");
    }
    if ($datosFamiliares["idParentescoFamiliar"] == 4 and $datosFamiliares["beneficiario"] == 1 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos del Padre (Beneficiario)");
    }
    if ($datosFamiliares["idParentescoFamiliar"] != 4 and $datosFamiliares["beneficiario"] == 1 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos del Beneficiario");
    }
    if ($datosFamiliares["idParentescoFamiliar"] != 5 and $datosFamiliares["beneficiario"] == 1 and $datosFamiliares["nombreFamiliar"] == "") {
        throw new Exception("Proporcione Datos del Beneficiario");
    }

    $this->persistencia->insertarDatosFamiliaresStore($datosFamiliares);
}

public function negocio_registroDatosBeneficiarioStore($datosFamiliares)
{
        //$log = new KLogger ( "negocio_registroDatosBeneficiarioStore.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$datosFamiliares : " . var_export ($datosFamiliares, true));

    $this->persistencia->insertarDatosBeneficiarioStore($datosFamiliares);
}

public function negocio_consultarDocumentoEntregado($idEntidadEmpleado, $cosecutivoEmpleado, $idTipoEmpleado, $idDocumento, $idTipoDocumento, $estatusDocumento)
{

        //$log = new KLogger ("negocioDocumentoEntregado.log", KLogger::DEBUG);

    $empleadoDoc = array();

        // $log -> LogInfo("NumeroEmpleadoCta" .$numeroCuenta);

    $empleadoDoc = $this->persistencia->consultarDocumentoEntregado($idEntidadEmpleado, $cosecutivoEmpleado, $idTipoEmpleado, $idDocumento, $idTipoDocumento, $estatusDocumento);
        //$log->LogInfo("Valor de la variable \$empleadoDoc: " . var_export ($empleadoDoc, true));
    if ($empleadoDoc != null) {
        $response["status"]  = "existe";
        $response["message"] = "Documento Entregado";
        $response["datos"]   = $empleadoDoc;

    } elseif ($empleadoDoc == null) {
        $response["status"]  = "noExiste";
        $response["message"] = "No entrego Documento";

        $response["datos"] = $empleadoDoc;
    }
    return $response;
}

public function consultarDocumentoPendientePorEntregar($idEntidadEmpleado, $cosecutivoEmpleado, $idTipoEmpleado, $idDocumento, $idTipoDocumento)
{

        //$log = new KLogger ("negocioDocumentoEntregado.log", KLogger::DEBUG);

    $empleadoDoc = array();

        // $log -> LogInfo("NumeroEmpleadoCta" .$numeroCuenta);

    $empleadoDoc = $this->persistencia->consultarDocumentoPendientePorEntregar($idEntidadEmpleado, $cosecutivoEmpleado, $idTipoEmpleado, $idDocumento, $idTipoDocumento);
        //$log->LogInfo("Valor de la variable \$empleadoDoc: " . var_export ($empleadoDoc, true));
    if ($empleadoDoc != null) {
        $response["status"]  = "existe";
        $response["message"] = "Documento Entregado";
        $response["datos"]   = $empleadoDoc;

    } elseif ($empleadoDoc == null) {
        $response["status"]  = "noExiste";
        $response["message"] = "No entrego Documento";

        $response["datos"] = $empleadoDoc;
    }
    return $response;
}

public function negocio_registrarDocumentosDigitalizados($documentacion)
{
        //$log = new KLogger ( "negocioRegistrarDocumentosDigitalizados.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$documentacion : " . var_export ($documentacion, true));

    $this->persistencia->insertarDocumentosDigitalizados($documentacion);
}

public function negocio_obtenerDocumentosDigitalizados($empleadoId, $documentoId)
{
    $result = array();

    $iconos = array(
        "image/jpeg"      => "jpg.png",
        "application/pdf" => "pdf.png",
    );

    $documentosDigitalizados = $this->persistencia->obtenerDocumentosDigitalizadosEmpleadoPorDocumentoId(
        $empleadoId["entidadFederativaId"],
        $empleadoId["consecutivo"],
        $empleadoId["categoriaId"],
        $documentoId
    );

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    foreach ($documentosDigitalizados as $documento) {
        if (!file_exists($documento["nombreArchivoGuardado"])) {
            continue;
        }

            // Generamos un idexterno
        $idExterno     = md5($documento["idDocumentoDigitalizado"] . $documento["nombreArchivoGuardado"]);
        $nombreArchivo = $documento["nombreArchivoSeleccionado"];

        $fileinfo = finfo_file($finfo, $documento["nombreArchivoGuardado"]);

        $icono = isset($iconos[$fileinfo]) ? $iconos[$fileinfo] : "unknown.png";

        $result[] = array(
            "id"            => $idExterno,
            "nombreArchivo" => $nombreArchivo,
            "icono"         => $icono,
            "RutaArchivo"         => $documento["nombreArchivoGuardado"],
            "IdTipoArchivo"   => $documento["documentoId"],
            "documentoFechaRegistro"   => $documento["documentoFechaRegistro"],

        );
    }
    finfo_close($finfo);

    return $result;
}

public function negocio_obtenerDocumentoDigitalizado($idexterno)
{
    $documentosDigitalizados = $this->persistencia->obtenerDocumentoDigitalizadaPorIdExterno($idexterno);

    if (count($documentosDigitalizados) == 0) {
        return null;
    }

    $documento = $documentosDigitalizados[0];

    return $documento;
}
public function negocio_obtenerSupervisoresOperativoselectronica()
{
        //$log = new KLogger ( "negocio_obtenerSupervisoresOperativos.log" , KLogger::DEBUG );

    $listaSupervisoresOperativos = array();
    $listaSupervisoresOperativos = $this->persistencia->obtenerSupervisoresOperativoselectronica();
        //$log->LogInfo("Valor de la variable \$listaSupervisoresOperativos: " . var_export ($listaSupervisoresOperativos, true));
    return $listaSupervisoresOperativos;

}
public function negocio_obtenerSupervisoresOperativosTransporte()
{
        //$log = new KLogger ( "negocio_obtenerSupervisoresOperativos.log" , KLogger::DEBUG );

    $listaSupervisoresOperativos = array();
    $listaSupervisoresOperativos = $this->persistencia->obtenerSupervisoresOperativosTransporte();
        //$log->LogInfo("Valor de la variable \$listaSupervisoresOperativos: " . var_export ($listaSupervisoresOperativos, true));
    return $listaSupervisoresOperativos;

}

public function negocio_obtenerSupervisoresOperativos()
{
        //$log = new KLogger ( "negocio_obtenerSupervisoresOperativos.log" , KLogger::DEBUG );

    $listaSupervisoresOperativos = array();
    $listaSupervisoresOperativos = $this->persistencia->obtenerSupervisoresOperativos();
        //$log->LogInfo("Valor de la variable \$listaSupervisoresOperativos: " . var_export ($listaSupervisoresOperativos, true));
    return $listaSupervisoresOperativos;
}

public function negocio_obtenerListaLineaNegocio()
{
        // $log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

    $listaLineaNegocio = array();
    $listaLineaNegocio = $this->persistencia->traeCatalogoLineaNegocio();
        //  $log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
    return $listaLineaNegocio;
}

/*
public function negocio_obteneriva()
{
//$log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

$listadeiva = array();
$listadeiva = $this->persistencia->traeCatalogoobteneriva();
//$log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
return $listadeiva;
}

 */
public function negocio_editarDatosPersonales($empleado)
{
        //$log = new KLogger ( "negocio_editarDatosPersonales.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

        //$patronCurp='#^[A-Z]{4}+[0-9]{6}+[A-Z]{6}+[0-9]{2}$#';
    $patronRfcEmpleado = '#^[A-Z,Ñ]{4}+[0-9]{6}+[A-Z0-9]{3}$#';

    if ($empleado["fechaNacimiento"] == "") {
        throw new Exception("Por favor proporcione Fecha de nacimiento");
    }
    if ($empleado["paisNacimientoId"] == "SIN PAIS" || $empleado["paisNacimientoId"] == "" || $empleado["paisNacimientoId"] == NULL || $empleado["paisNacimientoId"] == "NULL" || $empleado["paisNacimientoId"] == "null" || $empleado["paisNacimientoId"] == null || $empleado["paisNacimientoId"] == "0") {
        throw new Exception("Seleccione El País De Nacimiento");
    }
    if ($empleado["entidadNacimientoId"] == "ENTIDAD FEDERATIVA" || $empleado["entidadNacimientoId"] == "" || $empleado["entidadNacimientoId"] == "NULL" || $empleado["entidadNacimientoId"] == NULL || $empleado["entidadNacimientoId"] == "null" || $empleado["entidadNacimientoId"] == null) {
        throw new Exception("Seleccione La Entidad De Nacimiento");
    }
    if ($empleado["municipioNacimientoId"] == "MUNICIPIOS" || $empleado["municipioNacimientoId"] == "" || $empleado["municipioNacimientoId"] == "NULL" || $empleado["municipioNacimientoId"] == NULL || $empleado["municipioNacimientoId"] == "null" || $empleado["municipioNacimientoId"] == null || $empleado["municipioNacimientoId"] == "0") {
        throw new Exception("Seleccione El Municipio De Nacimiento");
    }
    if ($empleado["curpEmpleado"] == "") {
        throw new Exception("El CURP NO Pude Estar Vacio Proporcione CURP (18 Caracteres)");
    }
    if ($empleado["curpEmpleado"] != "") {
        if (strlen($empleado["curpEmpleado"]) != 18) {
            throw new Exception("El CURP NO Contiene Los (18 Caracteres) Correspondientes");
        }
    }

        /* if(preg_match($patronCurp,$empleado["curpEmpleado"] ) == false)
        {

        throw new Exception("El formato de curp no cumple");

    }*/

    if ($this->persistencia->existeCurpEmpleado($empleado["curpEmpleado"])) {
        $empleadoCurp = $this->persistencia->getEmpleadobyCurp($empleado["curpEmpleado"]);

        $numeroEmpleado = $empleado["empleadoEntidadPersonal"] . "-" . $empleado["empleadoConsecutivoPersonal"] . "-" . $empleado["empleadoCategoriaPersonal"];

            //$log->LogInfo("Valor de la variable \$empleadoCurp : " . var_export ($empleadoCurp, true));
            //$log->LogInfo("Valor de la variable \$numeroEmpleado : " . var_export ($numeroEmpleado, true));

        if ($empleadoCurp["nmeroEmpleado"] != $numeroEmpleado) {
            throw new Exception("El CURP del empleado ya se encuentra registrado en la base de datos");
        }

    }
    $rfc = utf8_decode($empleado["rfcEmpleado"]);

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export (strlen($rfc), true));

    if ($rfc == "") {
        throw new Exception("Proporcione RFC (13 Caracteres)");
    }

    if ($rfc != "") {
        if (strlen($rfc) != 13) {
            throw new Exception("RFC inválido");
        }

    }

    if (preg_match(utf8_decode($patronRfcEmpleado), $rfc) == false) {

        throw new Exception("El formato de rfc no cumple");
    }

    if ($this->persistencia->existeRfcEmpleado($empleado["rfcEmpleado"])) {
        $empleadoRfc    = $this->persistencia->getEmpleadobyRfc($empleado["rfcEmpleado"]);
        $numeroEmpleado = $empleado["empleadoEntidadPersonal"] . "-" . $empleado["empleadoConsecutivoPersonal"] . "-" . $empleado["empleadoCategoriaPersonal"];

            //$log->LogInfo("Valor de la variable \$empleadoRfc : " . var_export ($empleadoRfc, true));
            //$log->LogInfo("Valor de la variable \$numeroEmpleado : " . var_export ($numeroEmpleado, true));

        if ($empleadoRfc["nmeroEmpleado"] != $numeroEmpleado) {
            throw new Exception("El RFC del empleado ya se encuentra registrado en la base de datos");
        }
    }

    if ($empleado["estadoCivilId"] == "ESTADO CIVIL") {
        throw new Exception("Seleccione estado civil");
    }
    if ($empleado["gradoEstudiosId"] == "GRADO ESTUDIOS") {
        throw new Exception("Seleccione Grado de estudios");
    }

    if ($empleado["tipoSangreId"] == "TIPO SANGRE") {
        throw new Exception("Seleccione tipo de sangre");
    }
    if ($empleado["oficioId"] == "OFICIO") {
        throw new Exception("Seleccione Oficio");
    }

    if ($empleado["estatusCartillaId"] == "") {
        throw new Exception("Seleccione Estatus Cartilla");
    }

    if (($empleado["estatusCartillaId"] == 1 || $empleado["estatusCartillaId"] == 2 || $empleado["estatusCartillaId"] == 5) and $empleado["numeroCartilla"] == "") {

        throw new Exception("Proporcione número de cartilla N");

    }

    $this->persistencia->actualizarDatosPersonales($empleado);
}

public function negocio_editarDatosDireccion($datosDireccion)
{
    $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

    if ($datosDireccion["idAsentamientoDireccion"] == "") {
        throw new Exception("Seleccione Codigo de postal");
    }

    if ($datosDireccion["calle"] == "") {
        throw new Exception("Proporcione Calle de vivienda");
    }

    if ($datosDireccion["numeroExterior"] == "" and $datosDireccion["numeroInterior"] == "") {
        throw new Exception("Proporcione por lo menos un número Interior o Exterior");
    }

    if ($datosDireccion["telefonoFijoEmpleado"] == "" and $datosDireccion["telefonoMovilEmpleado"] == "") {
        throw new Exception("Proporcione por lo menos un número de contacto");
    }

    if ($datosDireccion["telefonoFijoEmpleado"] != "" and $datosDireccion["telefonoMovilEmpleado"] == "" and (strlen($datosDireccion["telefonoFijoEmpleado"])) != "10") {
        throw new Exception("El numero de telefono fijo debe contener al menos 10 digitos como maximo y 10 digitos como minimo");
    }
    if ($datosDireccion["telefonoFijoEmpleado"] == "" and $datosDireccion["telefonoMovilEmpleado"] != "" and (strlen($datosDireccion["telefonoMovilEmpleado"])) !="10") {
        throw new Exception("El numero de telefono Movil debe contener al menos 10 digitos");
    }
    if ($datosDireccion["telefonoFijoEmpleado"] != "" and $datosDireccion["telefonoMovilEmpleado"] != "" and ((strlen($datosDireccion["telefonoMovilEmpleado"])) !="10" or (strlen($datosDireccion["telefonoFijoEmpleado"])) !="10")) {
        throw new Exception("Los numeros telefonicos deben contener al menos 10 digitos");
    }

    if ($datosDireccion["correoEmpleado"] == "") {
        throw new Exception("Proporcione correo");
    }

    if ($datosDireccion["correoEmpleado"] != "") {

        if (preg_match($patronCorreo, $datosDireccion["correoEmpleado"]) == false) {
            throw new Exception("El formato de correo es incorrecto");
        }

        if ($this->persistencia->existeCorreoEmpleadosR($datosDireccion)) {
            throw new Exception("El correo ingresado ya existe");
        }
    }

    if ($datosDireccion["idUnidadMedicaAsignada"] == "") {
        $this->persistencia->actualizarDatosDireccionSinUmf($datosDireccion);

    } else {

        $this->persistencia->actualizarDatosDireccion($datosDireccion);

    }

}
// ya fue modificado
public function negocio_editarDatosGenerales($empleado)
{

       // $log = new KLogger ( "negocio_editarDatosGenerales.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado["plantillaserv"], true));

    $patronNumeroEmpleado = '/[0-9]{2}+\-+[0-9]{4}+\-+[0-3]{2}/';
    $patronNumeroCta      = '/[0-9]{10,14}/';
    $patronNumeroCtaClave = '/[0-9]{18}/';
    $patronNumeroCta14    = '/[0-9]{14}/';
    $patronNSS            = '/[0-9]{11}/';

    if ($empleado["apellidoPaterno"] == "" && $empleado["apellidoMaterno"] == "") {
        throw new Exception("Ingrese por lo menos un apellido");

    }

    if ($empleado["nombreEmpleado"] == "") {
        throw new Exception("Ingrese el nombre del empleado");

    }

    if ($empleado["empleadoNumeroSeguroSocial"] == "") {
        throw new Exception("El numero de Seguro Social es obligatorio");
    }

    if (preg_match($patronNSS, $empleado["empleadoNumeroSeguroSocial"]) == false) {
        throw new Exception("El numero de Seguro Social solo admite numeros");

    }

    if ($empleado["empleadoNumeroSeguroSocial"] != "") {
        if (strlen($empleado["empleadoNumeroSeguroSocial"]) < 11) {
            throw new Exception("Hacen falta Digitos en el Numero de Seguro Social ");
        }
        if (strlen($empleado["empleadoNumeroSeguroSocial"]) > 11) {
            throw new Exception("El numero de Seguro Social solo permite ingresar 11 Digitos");
        }
    }

    if (strlen($empleado["numeroCta"]) < 10 || strlen($empleado["numeroCta"]) > 14) {

        throw new Exception("Numero de Cuenta incorrecto");
    }

    if (strlen($empleado["numeroCta"]) == 10 && preg_match($patronNumeroCta, $empleado["numeroCta"]) == false) {
        throw new Exception("El numero de cuenta solo admite numeros");

    }
    if (strlen($empleado["numeroCta"]) == 14 && preg_match($patronNumeroCta14, $empleado["numeroCta"]) == false) {
        throw new Exception("El número de cuenta solo admite numeros");

    }

    if (strlen($empleado["numeroCtaClabe"]) != 18) {
        throw new Exception("El número de cuenta clabe debe contener 18 digitos");

    }

    if (preg_match($patronNumeroCtaClave, $empleado["numeroCtaClabe"]) == false) {

        throw new Exception("Formato inválido para número de cuenta clabe");

    }

    $numeroEmpleadoEdicion = $empleado["entidadFederativaId"] . "-" . $empleado["empleadoConsecutivoId"] . "-" . $empleado["empleadoCategoriaId"];

    $numeroEmpleadoImss = $this->persistencia->obtenerNumeroEmpleadoImss($empleado["empleadoNumeroSeguroSocial"]);
        //$log->LogInfo("Valor de la variable \$numeroEmpleadoImssencontradoPersistencia : " . var_export ($numeroEmpleadoImss, true));

    if (count($numeroEmpleadoImss) != 0) {

        if ($numeroEmpleadoEdicion != $numeroEmpleadoImss[0]["numeroEmpleadoImss"]) {
            throw new Exception("El número de IMSS ya se encuentra registrado en la base con otra persona");
        }
    }

    $numeroEmpleadoCta = $this->persistencia->obtenerNumeroEmpleadoCuenta($empleado["numeroCta"]);

    if (count($numeroEmpleadoCta) != 0) {

        if ($numeroEmpleadoEdicion != $numeroEmpleadoCta[0]["numeroEmpleadoCta"]) {
            throw new Exception("El número de cuenta ya se encuentra registrado en la base con otra persona");
        }
    }

    $numeroEmpleadoCtaClabe = $this->persistencia->obtenerNumeroEmpleadoCuentaClabe($empleado["numeroCtaClabe"]);
        //$log->LogInfo("Valor de la variable \$numeroEmpleadoImssencontradoPersistencia : " . var_export ($numeroEmpleadoImss, true));

    if (count($numeroEmpleadoCtaClabe) != 0) {

        if ($numeroEmpleadoEdicion != $numeroEmpleadoCtaClabe[0]["numeroEmpleadoCtaClabe"]) {
            throw new Exception("El número de cuenta clabe ya se encuentra registrado en la base con otra persona");
        }
    }

    if ($empleado["OpcionTarjetaDeDespensaEdit"] == "0") {
        throw new Exception("Seleccione Si Se Le dará Tarjeta De Despensa Al Empleado");

    }


    if ($empleado["fechaIngresoEmpleado"] == "") {
        throw new Exception("Seleccione fecha de ingreso");

    }


        //validarLineaNegocio

    if ($empleado["empleadoIdPuesto"] == "" || $empleado["empleadoIdPuesto"] == "PUESTO") {
        throw new Exception("Seleccione el puesto del empleado");
    }

    if ($empleado["idEntidadTrabajo"] == "" || $empleado["idEntidadTrabajo"] == "ENTIDAD FEDERATIVA") {
        throw new Exception("Seleccione la entidad federativa para laborar");
    }
    if ($empleado["idTipoPuesto"] == "02") {
        $empleado["idEntidadResponsableAsistencia"]   = "";
        $empleado["consecutivoResponsableAsistencia"] = "";
        $empleado["tipoResponsableAsistencia"]        = "";

    }
    if ($empleado["idTipoPuesto"] == "03" and $empleado["responsableAsistencia"] == "RESPONSABLE ASISTENCIA") {

        throw new Exception("Seleccione responsable de asistencia");
    }

    if ($empleado["empleadoIdPuntoServicio"] == "" || $empleado["empleadoIdPuntoServicio"] == "PUNTOS SERVICIOS") {
        throw new Exception("Seleccione punto de servicio");
    }

    if ($empleado["empleadoIdTurno"] == "TURNO" || $empleado["empleadoIdTurno"] == "0" || $empleado["empleadoIdTurno"] == "") {
        throw new Exception("Seleccione el turno");
    }




    if ($empleado["idTipoPuesto"] != "02") {
        if ($empleado["plantillaserv"] === "" || $empleado["plantillaserv"] === "PLANTILLA" || $empleado["plantillaserv"] === "0" || $empleado["plantillaserv"] ==='null') {
            throw new Exception("Seleccione plantilla de servicio");
        }
    }
    if ($empleado["idRolOpertaivoParaPlantilla"] === "" || $empleado["idRolOpertaivoParaPlantilla"] === "NULL" || $empleado["idRolOpertaivoParaPlantilla"] === NULL || $empleado["idRolOpertaivoParaPlantilla"] === null || $empleado["idRolOpertaivoParaPlantilla"] ==='null') {
            throw new Exception("Actualize el rol operativo de esta plantilla para continuar si ya se hizo favor recargar la pantilla se servicio");
     }

    if ($empleado["licenciaConducirEdited"] == "") {
        throw new Exception("Proporcione si cuenta con licencia de conducir");
    }

    if ($empleado["licenciaConducirEdited"] == 1) {
        if( ($empleado["licenciaConducirpermanenteEdited"] == 0 ||  $empleado["licenciaConducirpermanenteEdited"] == 1) && $empleado["numerolicenciaEdited"]==""){

            throw new Exception("Proporcione numero de licencia");

        }
        else if($empleado["licenciaConducirpermanenteEdited"] == 0 && $empleado["inpfehavigencialicenciaEdited"] == "" ){
            throw new Exception("Proporcione Fecha Vigencia Licencia");
        }
    }
    if ($empleado["estaturaEmpleado"] == "") {
        throw new Exception("Ingrese estatura en numero decimal ej(1.70)");
    }

    if ($empleado["tallaCEmpleado"] == "") {
        throw new Exception("Ingrese talla en numero entero ej(30)");
    }

    if ($empleado["tallaPEmpleado"] == "") {
        throw new Exception("Ingrese talla en numero entero ej(30)");
    }

    if ($empleado["numCalzadoEmpleado"] == "") {
        throw new Exception("Ingrese numero de calzado en numero decimal ej(27.5)");
    }

    if ($empleado["pesoEmpleado"] == "") {
        throw new Exception("Ingrese peso en numero");
    }

    if (!is_numeric($empleado["estaturaEmpleado"])) {
        throw new Exception("La estatura es incorrecta");
    }

    if (!is_numeric($empleado["tallaCEmpleado"])) {
        throw new Exception("Talla de camisa incorrecta");
    }

    if (!is_numeric($empleado["tallaPEmpleado"])) {
        throw new Exception("Talla de pantalon incorrecta");
    }

    if (!is_numeric($empleado["numCalzadoEmpleado"])) {
        throw new Exception("Numero de calzado incorrecto");
    }

    if (!is_numeric($empleado["pesoEmpleado"])) {
        throw new Exception("Peso de empleado incorrecto");
    }

    if ($empleado["empleadoIdGenero"] == "") {
        throw new Exception("Seleccione un Genero");
    }

    if ($empleado["tipoPeriodo"] == "") {
        throw new Exception("Seleccione periodo de pago para el empleado");
    }
    if ($empleado["empleadoLineaNegocioId"] == "1" and $empleado["idTipoPuesto"] == "02" and ($empleado["medioInformacionVacanteId"] == "MEDIO INFORMACIÓN" || $empleado["medioInformacionVacanteId"] == "")) {
        throw new Exception("Seleccione el medio por el que se enteró de la vacante.");
        $empleado["reclutadorEntidad"]       = "";
        $empleado["reclutadorConsecutivoId"] = "";
        $empleado["reclutadorTipo"]          = "";

    }
    if (($empleado["empleadoLineaNegocioId"] == "2" or $empleado["empleadoLineaNegocioId"] == "3" or $empleado["empleadoLineaNegocioId"] == "4") and ($empleado["medioInformacionVacanteId"] == "MEDIO INFORMACIÓN" || $empleado["medioInformacionVacanteId"] == "") and ($empleado["idTipoPuesto"] == "02" || $empleado["idTipoPuesto"] == "03")) {
        throw new Exception("Seleccione el medio por el que se enteró de la vacante.");
        $empleado["medioInformacionVacanteId"] = "7";
    }
    if ($empleado["empleadoLineaNegocioId"] == "1" and $empleado["idTipoPuesto"] == "03" and $empleado["reclutadorId"] != "") {
        $empleado["medioInformacionVacanteId"] = "6";
    }
    if ($empleado["empleadoLineaNegocioId"] == "1" and $empleado["idTipoPuesto"] == "03" and $empleado["reclutadorId"] == "RECLUTADOR") {
        throw new Exception("Seleccione el nombre del reclutador.");

    }
    if ($empleado["empleadoLineaNegocioId"] == "3" and $empleado["idTipoPuesto"] == "03" and $empleado["reclutadorId"] != "") {
        $empleado["medioInformacionVacanteId"] = "6";
    }
    if ($empleado["empleadoLineaNegocioId"] == "3" and $empleado["idTipoPuesto"] == "03" and $empleado["reclutadorId"] == "RECLUTADOR") {
        throw new Exception("Seleccione el nombre del reclutador.");

    }

    $this->persistencia->actualizarDatosGenerales($empleado);
}

public function negocio_obtenerDatosFamiliares($idEntidadEmpleado, $cosecutivoEmpleado, $idTipoEmpleado)
{
        //$log = new KLogger ( "negocio_obtenerDatosFamiliares.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$idEntidadEmpleado: " . var_export ($idEntidadEmpleado, true));
        //$log->LogInfo("Valor de la variable \$cosecutivoEmpleado: " . var_export ($cosecutivoEmpleado, true));
        //$log->LogInfo("Valor de la variable \$idTipoEmpleado: " . var_export ($idTipoEmpleado, true));
    $empleadoFamiliares = array();

    $empleadoFamiliares = $this->persistencia->consultaDatosFamiliaresEmpleado($idEntidadEmpleado, $cosecutivoEmpleado, $idTipoEmpleado);

        //$log->LogInfo("Valor de la variable \$empleadoFamiliares: " . var_export ($empleadoFamiliares, true));
    return $empleadoFamiliares;
}

public function negocio_obtenerListaTipoBaja()
{
        //$log = new KLogger ( "negocio_obtenerListaTipoBaja.log" , KLogger::DEBUG );

    $listaTipoBaja = array();
    $listaTipoBaja = $this->persistencia->traeCatalogoTiposBaja();
        //$log->LogInfo("Valor de la variable \$listaTipoBaja: " . var_export ($listaTipoBaja, true));
    return $listaTipoBaja;
}

public function obtenerCatalogoMotivosBajaPorTipoBaja($tipoBajaId)
{

        //$log = new KLogger ( "obtenerCatalogoMotivosBajaPorTipoBaja.log" , KLogger::DEBUG );

        //$log -> LogInfo ("tipoBajaId: " . $tipoBajaId);

    $listaMotivosBaja = array();


    $listaMotivosBaja = $this->persistencia->traerMotivosBajaPorTipoBaja($tipoBajaId);

    return $listaMotivosBaja;
}




public function negocio_registrarHistoricoBaja($datosBaja,$rolusuario)
{
    //$log = new KLogger ( "negocio_registrarHistoricoBaja.log" , KLogger::DEBUG );
    //$fechaActual = date("Y-m-d");
    if ($datosBaja["fechaIngreso"] > $datosBaja["fechaCausaBaja"] ) {
        throw new Exception("La fecha de baja no puede ser menor a la fecha de ingreso");
    }

    if ($datosBaja["fechaCausaBaja"] == "") {
        throw new Exception("Seleccione fecha de baja");

    }/*if ($datosBaja["fechaCausaBaja"] < $fechaActual) {
        throw new Exception("La fecha de baja no puede sr menor que la fecha actual");

    }*/
    if ($datosBaja["idMotivoBaja"] == "" || $datosBaja["idMotivoBaja"] == "MOTIVO BAJA") {
        throw new Exception("Seleccione el motivo de baja");
    }

    if($rolusuario!="Lider Unidad"){
        $this->persistencia->insertarRegistroBajaHistorico($datosBaja);
    }
    $idPlantillaServicio         = $datosBaja["idPlantillaServicio"];
    $asistenciaFecha             = $datosBaja["fechaCausaBaja"];
    $empleado["entidadId"]       = $datosBaja["empleadoEntidadBaja"];
    $empleado["consecutivoId"]   = $datosBaja["empleadoConsecutivoBaja"];
    $empleado["tipoId"]          = $datosBaja["empleadoCategoriaBaja"];
    $empleado["puntoServicioId"] = $datosBaja["puntoServicioId"];

    if ($datosBaja["empleadoCategoriaBaja"] == "03" || $datosBaja["empleadoCategoriaBaja"] == "02") {

        if($datosBaja["supervisorEntidadBaja"]=="--" || $datosBaja["supervisorConsecutivoBaja"]==false || $datosBaja["supervisorCategoriaBaja"]==""){
            $supervisor["entidadId"] ='09' ;  
            $supervisor["consecutivoId"]='0050';
            $supervisor["tipoId"]  ='02';     
        }else{
            $supervisor["entidadId"]     = $datosBaja["supervisorEntidadBaja"];
            $supervisor["consecutivoId"] = $datosBaja["supervisorConsecutivoBaja"];
            $supervisor["tipoId"]        = $datosBaja["supervisorCategoriaBaja"];
        }
//$log->LogInfo("Valor de la variable \$tipoPeriodo : " . var_export ($supervisor["entidadId"], true));
//$log->LogInfo("Valor de la variable \$tipoPeriodo : " . var_export ($supervisor["consecutivoId"], true));
//$log->LogInfo("Valor de la variable \$tipoPeriodo : " . var_export ($supervisor["tipoId"], true));
        $incidenciaId                = $datosBaja["incidenciaId"];
        $puestoCubiertoId            = $datosBaja["puestoCubiertoId"];

        $roloperativo = $datosBaja["roloperativo"]; 
        $periodos    = $this->persistencia->getTiposPeriodos();
        $tipoPeriodo = "";
        foreach ($periodos as $periodo) {
            if ($periodo["tipoPeriodoId"] == $datosBaja["tipoPeriodo"]) {
                $tipoPeriodo = $periodo["descripcionTipoPeriodo"];
            }
        }

            //$log->LogInfo("Valor de la variable \$tipoPeriodo : " . var_export ($tipoPeriodo, true));
        $conteobaja=1;

        $fechaBaja = strtotime($datosBaja["fechaCausaBaja"]);

        $registrado = $this->persistencia->registrarAsistencia(
            $empleado,
            $supervisor,
            $incidenciaId,
            $datosBaja["fechaCausaBaja"],
            $datosBaja["usuarioCapturaBaja"],
            '', $tipoPeriodo, $puestoCubiertoId,$roloperativo,$conteobaja,$idPlantillaServicio);

            //$log->LogInfo("Valor de la variable \$registrado : " . var_export ($registrado, true));
            //$log->LogInfo("Valor de la variable \$incidenciaId : " . var_export ($incidenciaId, true));

        if ($registrado == true) {

            if ($incidenciaId == 10) {
                    // Mmodificar el valor "QUINCENAL" que se proporciona como parametro
                    // para que pueda ser un valor obtenido en los paramateros del ajax.
                $fechasPeriodo = $this->obtenerListaDiasParaAsistencia($tipoPeriodo);
                    //$log->LogInfo("Valor de la variable \$fechasPeriodo : " . var_export ($fechasPeriodo, true));

                $fechaBaja = strtotime($datosBaja["fechaCausaBaja"]);

                for ($i = 0; $i < count($fechasPeriodo); $i++) {
                    $fecha = strtotime($fechasPeriodo[$i]["fecha"]);
                    if($i==0){
                        $conteobaja=1;
                    }else{
                        $conteobaja=0;
                    }

                    if ($fecha > $fechaBaja) {
                        $registrado1 = $this->persistencia->registrarAsistencia(
                            $empleado,
                            $supervisor,
                            $incidenciaId,
                            date("Y-m-d", $fecha),
                            $datosBaja["usuarioCapturaBaja"],
                            '', $tipoPeriodo, $puestoCubiertoId,$roloperativo,$conteobaja,$idPlantillaServicio);

                        
                    }
                }
                   // $log->LogInfo("Valor de la variable \$registrado1 : " . var_export ($registrado1, true));

                

                

            }

        }
    }           
    $estatusoperaciones=$datosBaja["estatusoperaciones"]; 
    $banderaBetado=$datosBaja["banderaBetado"]; 
    $ComentarioBetado=$datosBaja["ComentarioBetado"]; 
    $registrado1 = $this->persistencia->updateEstatusEmpleadoOperaciones($empleado,$estatusoperaciones, $asistenciaFecha);
    $registrado11 = $this->persistencia->updateEstatusEmpleadoOperacionesBetado($empleado,$banderaBetado,$ComentarioBetado);
    if ($registrado1 == true) {
        $result["status"]  = "success";
        $result["message"] = "";
    }
}

public function negocio_obtenerListaEmpleadosPorEstatus($idEstatus)
{
        //$log = new KLogger ( "negocio_obtenerListaEmpleadosPorEstatus.log" , KLogger::DEBUG );

        //$log -> LogInfo ("idEstatus: " . $idEstatus);

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosPorEstatus($idEstatus);

    return $listaEmpleados;
}

public function negocio_insertarActualizarDatosImss($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $salarioDiario, $fechaImss, $numeroLote, $usuarioCapturaImss, $registroPatronal, $tipoTrabajador)
{
        //$log = new KLogger ( "negocio_insertarActualizarDatosImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($empleadoCategoria, true));
        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($salarioDiario, true));
        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($fechaImss, true));
        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($numeroLote, true));
        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($usuarioCapturaImss, true));
        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($registroPatronal, true));

    $patronNumeroLote = '/[0-9]{8,9}/';
    if ($fechaImss == "") {
        throw new Exception("Ingrese Fecha de Imss");
    }

    if ($numeroLote == "") {
        throw new Exception("Ingrese Numero de Lote");
    }

    if (preg_match($patronNumeroLote, $numeroLote) == false) {

        throw new Exception("Verifique Numero de lote (debe contener 8 o 9 números)");

    }
    if ($salarioDiario == 0) {

        throw new Exception("Ingrese Salario Diario");

    }
    if (is_numeric($salarioDiario)) {

    } else {
        throw new Exception("Verifique salario diario");
    }

    if ($registroPatronal == "" || $registroPatronal == "REGISTRO PATRONAL") {

        throw new Exception("Seleccione registro Patronal");

    }

    if ($tipoTrabajador == "" || $tipoTrabajador == "TIPO TRABAJADOR") {

        throw new Exception("Seleccione tipo de trabajador");

    }

    $this->persistencia->insertarActualizarDatosImss($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $salarioDiario, $fechaImss, $numeroLote, $usuarioCapturaImss, $registroPatronal, $tipoTrabajador);
}

public function negocio_actualizarEstatusEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $estatusEmpleado, $usuarioCaptura, $plantillaTexto)
{

        // $log = new KLogger ( "negocio_actualizarEstatusEmpleadoImss.log" , KLogger::DEBUG );

        // $log->LogInfo("Valor de la variable \$datosDireccion : " . var_export ($datosDireccion, true));

    $this->persistencia->actualizarEstatusEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $estatusEmpleado, $usuarioCaptura, $plantillaTexto);
}
// ya se Modifico
public function actualizarFechaReingreso($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $fechaReingreso, $fechaBaja, $usuarioCaptura, $datos,$fechaingresooculto)
{
        //$log = new KLogger ( "negocio_reingreso.log" , KLogger::DEBUG );
        // $log->LogInfo("Valor de la variable \$datosDireccion : " . var_export ($datosDireccion, true));


    $fechaActual= date("Y-m-d");

    if ($fechaReingreso == "") {
        throw new Exception("Ingrese Fecha de reingreso");
    }
    if($fechaReingreso < $fechaingresooculto){
        throw new Exception("La Fecha De Reingreso Es Mayor A La Fecha De Ingreso Del Empleado");
    }

    if($fechaActual != $fechaReingreso){
        throw new Exception("INGRESE LA FECHA ACTUAL SIN MODIFICAR LA ZONA HORARIA DE SU EQUIPO");
    }

    $segundosX2Dias=86400*2;
    $fechaMaxIngreso=strtotime(date("Y-m-d"))+$segundosX2Dias;
    $fechaIngreso=strtotime($fechaReingreso);

    if($fechaIngreso > $fechaMaxIngreso){
        throw new Exception("LA FECHA DE INGRESO REVASA EL LIMITE MAXIMO DE FECHA");
    }

    if ($datos["idEntidadTrabajo"] == "" or $datos["idEntidadTrabajo"] == "ENTIDAD FEDERATIVA") {
        throw new Exception("Seleccione entidad para laborar");
    }
    if ($datos["empleadoLineaNegocioId"] == "LINEA NEGOCIO" or $datos["empleadoLineaNegocioId"] == "" or $datos["empleadoLineaNegocioId"] == "LiNEA NEGOCIO") {
        throw new Exception("Seleccione una linea de negocio");
    }
    if ($datos["idTipoPuesto"] == "TIPO PUESTO" or $datos["idTipoPuesto"] == "") {
        throw new Exception("Seleccione el tipo de puesto");
    }
    if ($datos["empleadoIdPuesto"] == "PUESTO" or $datos["empleadoIdPuesto"] == "") {
        throw new Exception("Seleccione el puesto");
    }
    if ($datos["empleadoIdPuntoServicio"] == "PUNTOS SERVICIOS" or $datos["empleadoIdPuntoServicio"] == "") {
        throw new Exception("Seleccione punto de servicio");
    }
    if ($datos["empleadoIdTurno"] == "TURNO" or $datos["empleadoIdTurno"] == "") {
        throw new Exception("Seleccione el turno");
    }

    if ($datos["idTipoPuesto"] != "02") {
        if ($datos["plantillaservicioreingreso"] === "" || $datos["plantillaservicioreingreso"] === "PLANTILLA" || $datos["plantillaservicioreingreso"] === "0") {
            throw new Exception("Seleccione plantilla de servicio");
//falta mandar el parametro para insertar el roloperativo en empleados
        }
    }


    if ($datos["tipoPeriodo"] == "PERIODO" or $datos["tipoPeriodo"] == "") {
        throw new Exception("Seleccione periodo");
    }
    
    if ($datos["idTipoPuesto"] == "03" and $datos["supervisorId"] == "RESPONSABLE ASISTENCIA") {
        throw new Exception("Seleccione supervisor");
    }


    if ($datos["bancoreingreso"] === "BANCO"  || $datos["bancoreingreso"] === "0") {
        throw new Exception("Seleccione Banco");
    }

    if ($datos["bancoreingreso"] == "127" && strlen($datos["nocuentareingreso"]) != 14) {
            throw new Exception("Numero de cuenta incorrecto para BANCO AZTECA");
        }

        if ($datos["bancoreingreso"] == "030" && strlen($datos["nocuentareingreso"]) != 12) {
            throw new Exception("Numero de cuenta incorrecto para BANCO BAJIO");
        }

        if (($datos["bancoreingreso"] == "012" || $datos["bancoreingreso"] == "021") && strlen($datos["nocuentareingreso"]) != 10) {
            if ($datos["bancoreingreso"] == "012") {
                throw new Exception("Numero de cuenta incorrecto para BANCO BBVA BANCOMER");
            }

            if ($datos["bancoreingreso"] == "021") {
                throw new Exception("Numero de cuenta incorrecto para BANCO HSBC");
            }

        }

        if ($datos["bancoreingreso"] == "014" && strlen($datos["nocuentareingreso"]) != 11) {
            throw new Exception("Numero de cuenta incorrecto para BANCO SANTANDER");
        }

        
    if ($datos["nocuentareingreso"] === "" ||  strlen($datos["nocuentareingreso"]) < 10 ) {
        throw new Exception("Verifique N° Cuenta");
    }
    if ($datos["cunetaclabereingreso"] === "" ||  strlen($datos["cunetaclabereingreso"]) < 18 ) {
        throw new Exception("Verifique Cuenta Clabe");
    }

    if ($datos["AntiguedadVacacionesReingresoNo"] === "" || $datos["AntiguedadVacacionesReingresoSi"] ==="" ) {
        throw new Exception("Seleccione Si El Empleado Conserva Antiguedad (Vacaciones Pasadas)");
    }

    if ($datos["avisoInscripcion0"] === "" ) {
        throw new Exception("Seleccione archivo Aviso Inscripción Imss");
    }
    if ($datos["avisoInscripcion1"] === "") {
        throw new Exception("Seleccione archivo Ticket de cuenta");
    }
    if ($datos["avisoInscripcion2"] === "") {
        throw new Exception("Seleccione archivo Cedula sat(R.F.C)");
    }
    

    if($datos["valorchecklicenciaRE"] ==1){

        if ($datos["avisoInscripcion3"] === "") {
            throw new Exception("Seleccione archivo LICENCIA DE CONDUCIR");
        }
    }

    $this->persistencia->actualizarFechaReingreso($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $fechaReingreso, $fechaBaja, $usuarioCaptura, $datos);

}

public function negocio_obtenerDatosCuadroAntig($fechaPeriodo1, $fechaPeriodo2)
{
        //$log = new KLogger ( "negocio_obtenerDatosCuadroAntig.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$fechaPeriodo1 : " . var_export ($fechaPeriodo1, true));
        //$log->LogInfo("Valor de la variable \$fechaPeriodo2 : " . var_export ($fechaPeriodo2, true));

    if ($fechaPeriodo1 == "") {
        throw new Exception("Ingrese Fecha Inicio de consulta");
    }
    if ($fechaPeriodo2 == "") {
        throw new Exception("Ingrese Fecha fin de consulta");
    }

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerDatosCuadroAntig($fechaPeriodo1, $fechaPeriodo2);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}

public function negocio_traeCatalogoRegistrosPatronales()
{
        //$log = new KLogger ( "negocio_traeCatalogoRegistrosPatronales.log" , KLogger::DEBUG );

    $listaRegistrosPatronales = array();
    $listaRegistrosPatronales = $this->persistencia->traeCatalogoRegistrosPatronales();
        //$log->LogInfo("Valor de la variable \$listaTipoBaja: " . var_export ($listaRegistrosPatronales, true));
    return $listaRegistrosPatronales;
}

public function negocio_actualizarDatosImssCuadro($datosImss)
{

        //$log = new KLogger ( "negocio_actualizarDatosImssCuadro.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($datosImss, true));

    $this->persistencia->actualizarDatosImssCuadro($datosImss);
}

public function negocio_traeCatalogorTipoTrabajadorImss()
{
        //$log = new KLogger ( "negocio_traeCatalogorTipoTrabajadorImss.log" , KLogger::DEBUG );

    $listaTiposTrabajador = array();
    $listaTiposTrabajador = $this->persistencia->traeCatalogorTipoTrabajadorImss();
        //$log->LogInfo("Valor de la variable \$listaTiposTrabajador: " . var_export ($listaTiposTrabajador, true));
    return $listaTiposTrabajador;
}

public function actualizarFotoEmpleado($empleado)
{

        //$log = new KLogger ( "negocio_actualizarFotoEmpleado.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->actualizarFotoEmpleado($empleado);
}

public function consultaGeneral()
{
        //$log = new KLogger ( "negocioconsultaGeneral.log" , KLogger::DEBUG );

    $listaEmpleados = array();
    $listaEmpleados = $this->persistencia->consultaGeneral();
        //$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($listaEmpleados, true));
    return $listaEmpleados;
}

public function actualizarDatosImss($campo, $valor, $entidadFederativaId, $empleadoConsecutivoId, $empleadoCategoriaId)
{
    if ($campo == "fechaBajaImss") {
        $fechaAlta = $this->persistencia->obtenerFechaAltaImss($entidadFederativaId, $empleadoConsecutivoId, $empleadoCategoriaId);
        if ($fechaAlta > $valor) {
            throw new Exception("La fecha de baja no puede ser menor a la fecha de alta");
        }
    }

    $this->persistencia->actualizarDatosImss($campo, $valor, $entidadFederativaId, $empleadoConsecutivoId, $empleadoCategoriaId);
}

public function insertaDatosImss($datosImss)
{

        //$log = new KLogger ( "negocio_insertaDatosImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$datosImss : " . var_export ($datosImss, true));
    $this->persistencia->insertaDatosImss($datosImss);

}

public function obtenerListaEmpleadosSinImss()
{
        //$log = new KLogger ( "negocio_obtenerListaEmpleadosSinImss.log" , KLogger::DEBUG );

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosSinImss();

    return $listaEmpleados;
}

public function obtenerListaEmpleadosSinImssPorRegistroPatronal($registroPatronal)
{
        //$log = new KLogger ( "negocio_obtenerListaEmpleadosSinImssPorRegistroPatronal.log" , KLogger::DEBUG );

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosSinImssPorRegistroPatronal($registroPatronal);

    return $listaEmpleados;
}

public function actualizarEstatusImss($datosImss)
{

        //$log = new KLogger ( "negocio_actualizarEstatusImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->actualizarEstatusImss($datosImss);
}

public function obtenerListaEmpleadosEnProcesoImss()
{

        //$log = new KLogger ( "negocio_obtenerListaEmpleadosEnProcesoImss.log" , KLogger::DEBUG );

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosEnProcesoImss();
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;

}

public function rechazarEmpleadoImss($datosImss)
{

        //$log = new KLogger ( "negocio_rechazarEmpleadoImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->rechazarEmpleadoImss($datosImss);
}

public function traerUltimoFolioTxt()
{
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

    $numeroFolio = "";
    $numeroFolio = $this->persistencia->traerUltimoFolioTxt();
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
    return $numeroFolio;

}

public function traerUltimoFolioTxtBaja()
{
        //$log= new KLogger("negocioUltimoFolioBaja.log", KLogger::DEBUG);

    $numeroFolio = "";
    $numeroFolio = $this->persistencia->traerUltimoFolioTxtBaja();
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
    return $numeroFolio;

}

public function confirmaAltaImss($datosImss)
{

        //$log = new KLogger ( "negocio_confirmarLoteImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    if ($datosImss["folioTxt"] == "") {
        throw new Exception("Ingrese número de lote proporcionado en el TXT");
    }
    if ($datosImss["numeroLote"] == "") {
        throw new Exception("Ingrese número de lote proporcionado por Imss");
    }

    $this->persistencia->confirmaAltaImss($datosImss);
}

public function reingresarEmpleadoImss($datosImss)
{

        //$log = new KLogger ( "negocio_reingresarEmpleadoImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->reingresarEmpleadoImss($datosImss);
}

public function solicitarBajaImss($datosImss)
{

        //$log = new KLogger ( "negocio_solicitarBajaImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->solicitarBajaImss($datosImss);
}

public function obtenerListaEmpleadosSinBajaImss()
{

        //$log = new KLogger ( "negocio_obtenerListaEmpleadosSinBajaImss.log" , KLogger::DEBUG );

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosSinBajaImss();
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;

}

public function traeCatalogorMotivoBajaImss()
{
        //$log = new KLogger ( "negocio_traeCatalogorMotivoBajaImss" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->traeCatalogorMotivoBajaImss();
        //$log->LogInfo("Valor de la variable \$lista: " . var_export ($lista, true));
    return $lista;
}

public function obtenerListaEmpleadosSinBajaImssPorRegistroPatronal($registroPatronal)
{
    $log = new KLogger("negocio_obtenerListaEmpleadosSinBajaImssPorRegistroPatronal.log", KLogger::DEBUG);

    $listaEmpleados = array();
    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosSinBajaImssPorRegistroPatronal($registroPatronal);
    return $listaEmpleados;
}

public function cambiarEstatusImssProcesoBaja($datosImss)
{

        //$log = new KLogger ( "negocio_cambiarEstatusImssProcesoBaja.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->cambiarEstatusImssProcesoBaja($datosImss);
}

public function obtenerListaEmpleadosEnProcesoBaja()
{
        //$log = new KLogger ( "negocio_obtenerListaEmpleadosEnProcesoBaja.log" , KLogger::DEBUG );

    $listaEmpleados = array();
    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosEnProcesoBaja();
    return $listaEmpleados;
}

public function confirmaBajaImss($datosImss)
{

        //$log = new KLogger ( "negocio_confirmarLoteImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    if ($datosImss["folioTxtBaja"] == "") {
        throw new Exception("Ingrese número de lote proporcionado en el TXT");
    }
    if ($datosImss["numeroLoteBaja"] == "") {
        throw new Exception("Ingrese número de lote proporcionado por Imss");
    }

    $this->persistencia->confirmaBajaImss($datosImss);
}

public function traerCatalogoPuntosServicios()
{
    //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

    $lista = $this->persistencia->traerCatalogoPuntosServicios();
  //  $log -> LogInfo ("$lista". var_export($lista,true));
    return $lista;

}


public function actualizaEstatusPuntoServicio($idPuntoServicio, $esatusPunto, $fechaTerminoServicio)
{

        //$log= new KLogger("negocio_darBajaPuntoServicio.log", KLogger::DEBUG);

        //$log->LogInfo("Valor de la variable \$idPuntoServicio : " . var_export ($idPuntoServicio, true));
        //$log->LogInfo("Valor de la variable \$esatusPunto : " . var_export ($esatusPunto, true));
        //$log->LogInfo("Valor de la variable \$fechaTerminoServicio : " . var_export ($fechaTerminoServicio, true));
    $fechaTermino      = date("Y-m-d", strtotime($fechaTerminoServicio));
    $monthFechaTermino = date("m", strtotime($fechaTerminoServicio));
    $yearFechaTermino  = date("Y", strtotime($fechaTerminoServicio));

    $fechaActual = date("Y-m-d");
    $monthActual = date("m");
    $yearActual  = date("Y");

        //$log->LogInfo("Valor de la variable \$fechaTermino : " . var_export ($fechaTermino, true));
        //$log->LogInfo("Valor de la variable \$monthFechaTermino : " . var_export ($monthFechaTermino, true));
        //$log->LogInfo("Valor de la variable \$yearFechaTermino : " . var_export ($yearFechaTermino, true));

        //$log->LogInfo("Valor de la variable \$fechaActual : " . var_export ($fechaActual, true));
        //$log->LogInfo("Valor de la variable \$monthActual : " . var_export ($monthActual, true));
        //$log->LogInfo("Valor de la variable \$yearActual : " . var_export ($yearActual, true));

    if ($fechaTerminoServicio == "") {
        throw new Exception("Ingrese fecha de termino de servicio");
    }

    if (strtotime($fechaTermino) < strtotime($fechaActual) && $esatusPunto!="0") {

        throw new Exception("La fecha de termino no puede ser menor a la fecha actual");
    }
    if($esatusPunto!="0"){

        if ($yearFechaTermino == $yearActual) {
            if ($monthFechaTermino != $monthActual) {

                throw new Exception("En la fecha de termino el mes no puede ser mayor al mes en curso");

            }

        } else {
            throw new Exception("El año de fecha de termino no puede ser diferente al año en curso");
        }
    }

    $this->persistencia->actualizaEstatusPuntoServicio($idPuntoServicio, $esatusPunto, $fechaTerminoServicio);
}

public function actualizaEstatusPuntoServicioReactivacion($idPuntoServicio, $esatusPunto, $fechaInicioServicio)
{

        //$log= new KLogger("negocio_darBajaPuntoServicio.log", KLogger::DEBUG);

        //$log->LogInfo("Valor de la variable \$idPuntoServicio : " . var_export ($idPuntoServicio, true));
        //$log->LogInfo("Valor de la variable \$esatusPunto : " . var_export ($esatusPunto, true));
        //$log->LogInfo("Valor de la variable \$fechaInicioServicio : " . var_export ($fechaInicioServicio, true));

    if ($fechaInicioServicio == "") {
        throw new Exception("Ingrese fecha de reactivación");
    }

    $this->persistencia->actualizaEstatusPuntoServicioReactivacion($idPuntoServicio, $esatusPunto, $fechaInicioServicio);
}

public function consultaAsentamientos()
{
        //$log = new KLogger ( "negocio_consultaAsentamientos.log" , KLogger::DEBUG );

    $listaEmpleados = array();
    $listaEmpleados = $this->persistencia->consultaAsentamientos();
        //$log->LogInfo("Valor de la variable \$consultaAsentamientos: " . var_export ($listaEmpleados, true));
    return $listaEmpleados;
}

public function obtenerListaEmpleadosPorFechaCaptura($dia, $mes, $anio)
{
        //$log = new KLogger ( "negocio_obtenerListaEmpleadosPorFechaCaptura.log" , KLogger::DEBUG );

    $listaEmpleados = array();
    $listaEmpleados = $this->persistencia->obtenerListaEmpleadosPorFechaCaptura($dia, $mes, $anio);
    return $listaEmpleados;
}

public function traerCatalogoPuntosServiciosByCliente($clienteId)
{
        //$log = new KLogger ( "negocio_traerCatalogoPuntosServiciosByCliente.log" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->traerCatalogoPuntosServiciosByCliente($clienteId);
    return $lista;
}

public function traerCatalogoPuntosServiciosByName($nombrePunto)
{
        //$log = new KLogger ( "negocio_ttraerCatalogoPuntosServiciosByName.log" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->traerCatalogoPuntosServiciosByName($nombrePunto);
    return $lista;
}
// ya fue modificado
public function registroDatosPlantilla($datos)
{
        //$log = new KLogger ( "negocio_registroDatosPlantilla.log" , KLogger::DEBUG ); numeroElementos
    $numeros1 = '/[0-9]/';
    $SumaDeChecks = (($datos["checkLunes0"]) + ($datos["checkMartes0"]) + ($datos["checkMiercoles0"]) + ($datos["checkJueves0"]) + ($datos["checkViernes0"]) + ($datos["checkSabado0"]) + ($datos["checkDomingo0"]));

       // $log->LogInfo("Valor de la variable SumaDeChecks : " . var_export ($SumaDeChecks, true));
    if ($datos["fechaInicio"] == "") {
        throw new Exception("Por favor proporcione fecha de inicio de montaje");
    }
    if ($datos["fechaTerminoPlantilla"] == "") {
        throw new Exception("Proporcione fecha de termino de montaje");
    }
    if ($datos["numeroElementos"] == "" || $datos["numeroElementos"] < "1") {
        throw new Exception("Proporcine El Numero De Elementos, No Debe Ser Menor a Uno");
    }
    if ($datos["tipoTurnoPlantillaId"] == "TURNO" || $datos["tipoTurnoPlantillaId"] == "") {
        throw new Exception("Seleccione el tipo de turno");
    }
    if ($datos["puestoPlantillaId"] == "PUESTO" || $datos["puestoPlantillaId"] == "") {
        throw new Exception("Seleccione un puesto");
    }
    if (($datos["IdClientePunto0"] != "13") && (($datos["LineaNegocioPlantilla0"] == "1") || ($datos["LineaNegocioPlantilla0"] == "3")) ) {
        if ($datos["selectRolOpA"] == "0" || $datos["selectRolOpA"] == "") {
            throw new Exception("Seleccione El Rol Operativo De La Plantilla");
        }
        if($datos["checkElementos0"] == "1"){
            if ($datos["rolOperativo"] == "12x12x6" && $SumaDeChecks!=6) {
                throw new Exception("Marque 6 De Los 7 Dias De La Semana Y Llene Correctamente (Dias Laborables 6)");
            }
            if ($datos["rolOperativo"] == "12x12x5" && $SumaDeChecks!=5) {
                throw new Exception("Marque 5 De Los 7 Dias De La Semana Y Llene Correctamente (Dias Laborables 5)");
            }
            if ($datos["rolOperativo"] == "12x12x3" && $SumaDeChecks!=3) {
                throw new Exception("Marque 3 De Los 7 Dias De La Semana Y Llene Correctamente (Dias Laborables 3)");
            }
            }// Validaciones Para Lunes
            if ($datos["checkLunes0"] == 1 && $datos["TDiaLunes0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Lunes Si No Hay Coloque (0)");
            }
            if ($datos["checkLunes0"] == 1 && $datos["TNocheLunes0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Lunes Si No Hay Coloque (0)");
            }
            if ($datos["lineaNegocioRequisicion"] == 1 && $datos["checkLunes0"] == 1 && (($datos["TTotalesLunes0"] > $datos["turnosPorDia"]) || ($datos["TTotalesLunes0"] < "0"))) {
                throw new Exception("La Suma Del Dia Lunes  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir    x Dia)");
            }// Validaciones Para Martes
            if ($datos["checkMartes0"] == 1 && $datos["TDiaMartes0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Martes Si No Hay Coloque (0)");
            }
            if ($datos["checkMartes0"] == 1 && $datos["TNochesMartes0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Martes Si No Hay Coloque (0)");
            }
            if ($datos["lineaNegocioRequisicion"] == 1 && $datos["checkMartes0"] == 1 && (($datos["TTotalesMartes0"] > $datos["turnosPorDia"]) || ($datos["TTotalesMartes0"] < "0"))) {
                throw new Exception("La Suma Del Dia Martes  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a  Cubrir x Dia)");
            }// Validaciones Para Miercoles
            if ($datos["checkMiercoles0"] == 1 && $datos["TDiaMiercoles0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Miercoles Si No Hay Coloque (0)");
            }
            if ($datos["checkMiercoles0"] == 1 && $datos["TNocheMiercoles0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Miercoles Si No Hay Coloque (0)");
            }
            if ($datos["lineaNegocioRequisicion"] == 1 && $datos["checkMiercoles0"] == 1 && (($datos["TTotalesMiercoles0"] > $datos["turnosPorDia"]) || ($datos["TTotalesMiercoles0"] < "0"))) {
                throw new Exception("La Suma Del Dia Miercoles  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a   Cubrir x Dia)");
            }// Validaciones Para Jueves
            if ($datos["checkJueves0"] == 1 && $datos["TDiaJueves0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Jueves Si No Hay Coloque (0)");
            }
            if ($datos["checkJueves0"] == 1 && $datos["TNocheJueves0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Jueves Si No Hay Coloque (0)");
            }
            if ($datos["lineaNegocioRequisicion"] == 1 && $datos["checkJueves0"] == 1 && (($datos["TTotalesJueves0"] > $datos["turnosPorDia"]) || ($datos["TTotalesJueves0"] < "0"))) {
                throw new Exception("La Suma Del Dia Jueves  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a  Cubrir x Dia)");
            }// Validaciones Para Viernes 
            if ($datos["checkViernes0"] == 1 && $datos["TDiaViernes0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Viernes Si No Hay Coloque (0)");
            }
            if ($datos["checkViernes0"] == 1 && $datos["TNocheViernes0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Viernes Si No Hay Coloque (0)");
            }
            if ($datos["lineaNegocioRequisicion"] == 1 && $datos["checkViernes0"] == 1 && (($datos["TTotalesViernes0"] > $datos["turnosPorDia"]) || ($datos["TTotalesViernes0"] < "0"))) {
                throw new Exception("La Suma Del Dia Viernes  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a     Cubrir x Dia)");
            }// Validaciones Para Sabado
            if ($datos["checkSabado0"] == 1 && $datos["TDiaSabado0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Sabado Si No Hay Coloque (0)");
            }
            if ($datos["checkSabado0"] == 1 && $datos["TNocheSabado0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Sabado Si No Hay Coloque (0)");
            }
            if ($datos["lineaNegocioRequisicion"] == 1 && $datos["checkSabado0"] == 1 && (($datos["TtotalesSabado0"] > $datos["turnosPorDia"]) || ($datos["TtotalesSabado0"] < "0"))) {
                throw new Exception("La Suma Del Dia Sabado  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a  Cubrir x Dia)");
            }// Validaciones Para Domingo
            if ($datos["checkDomingo0"] == 1 && $datos["TDiaDomingo0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Domingo Si No Hay Coloque (0)");
            }
            if ($datos["checkDomingo0"] == 1 && $datos["TNocheDomingo0"] == "") {
                throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Domingo Si No Hay Coloque (0)");
            }
            if ($datos["lineaNegocioRequisicion"] == 1 && $datos["checkDomingo0"] == 1 && (($datos["TTotalesDomingo0"] > $datos["turnosPorDia"]) || ($datos["TTotalesDomingo0"] < "0"))) {
                throw new Exception("La Suma Del Dia Domingo  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a     Cubrir x Dia)");
            }
            if (is_numeric($datos["costoPorTurno"])) {
            }else {
                throw new Exception("Ingrese costo por turno correctamente");
            }
        }
        if (strtotime($datos["fechaTerminoPlantilla"]) > strtotime($datos["fechaTerminoPuntoServicio"])) {
            throw new Exception("La fecha de termino de montaje debe ser menor o igual a la fecha de termino del punto de servicio");
        }
        if (strtotime($datos["fechaInicio"]) > strtotime($datos["fechaTerminoPlantilla"])) {
            throw new Exception("La fecha de inicio de montaje no puede ser mayor a la fecha de termino de montaje");
        }

        $this->persistencia->registroDatosPlantilla($datos);
        $this->persistencia->registroDatosHistoricoCostoPlantillaEdited($datos);

    }

    public function selectPlantillaRequisicion($puntoServicio)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->selectPlantillaRequisicion($puntoServicio);
        return $lista;
    }

    public function selectTipoRequisicion()
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->selectTipoRequisicion();
        return $lista;
    }
    public function selectFolioRequisicion()
    {
        //$log= new KLogger("negocioUltimoFolioBaja.log", KLogger::DEBUG);
        $numeroFolioRequisicion = "";
        $numeroFolioRequisicion = $this->persistencia->selectFolioRequisicion();
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numeroFolioRequisicion;
    }
    public function selectBajasEmpleadosPorFechaCaptura($dia, $mes, $anio)
    {
        //$log = new KLogger ( "negocio_selectBajasEmpleadosPorFechaCaptura" , KLogger::DEBUG );

        $listaEmpleados = array();
        $listaEmpleados = $this->persistencia->selectBajasEmpleadosPorFechaCaptura($dia, $mes, $anio);
        return $listaEmpleados;
    }

    public function selectDatosPuntoServicio($puntoServicio)
    {
        //$log = new KLogger ( "negocio_selectDatosPuntoServicio" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->selectDatosPuntoServicio($puntoServicio);
        return $lista;
    }

    public function selectEmpleadosByEntidad($empleadoEntidad)
    {
        //$log = new KLogger ( "negocio_selectEmpleadosByEntidad.log" , KLogger::DEBUG );

        $empleado = array();
        $empleado = $this->persistencia->selectEmpleadosByEntidad($empleadoEntidad);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
        return $empleado;
    }

    public function actualizarPlantillaAumento($datosPlantilla)
    {

        $this->persistencia->actualizarPlantillaAumento($datosPlantilla);

    }

    public function getServicioPlantillaById($servicioPlantillaId)
    {
        //$log = new KLogger ( "negocio_getServicioPlantillaById.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->getServicioPlantillaById($servicioPlantillaId);
        return $lista;
    }

    public function getServicioPlantilla()
    {
        //$log = new KLogger ( "negocio_getServicioPlantilla.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->getServicioPlantilla();
        return $lista;
    }

    public function getServicioPlantillaPerfil($puestoPlantillaId, $tipoTurnoPlantillaId, $puntoServicioPlantillaId)
    {
        //$log = new KLogger ( "negocio_getServicioPlantillaPerfil.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$puestoPlantillaId: " . var_export ($puestoPlantillaId, true));
        //$log->LogInfo("Valor de la variable \$tipoTurnoPlantillaId: " . var_export ($tipoTurnoPlantillaId, true));
        //$log->LogInfo("Valor de la variable \$generoElementoId: " . var_export ($generoElementoId, true));
        //$log->LogInfo("Valor de la variable \$puntoServicioPlantillaId: " . var_export ($puntoServicioPlantillaId, true));

        $lista = array();
        $lista = $this->persistencia->getServicioPlantillaPerfil($puestoPlantillaId, $tipoTurnoPlantillaId, $puntoServicioPlantillaId);
        return $lista;
    }

    public function insertEmpleadoPlantilla($datos)
    {
        //$log = new KLogger ( "insertEmpleadoPlantilla.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable datos: " . var_export ($datos, true));
        if ($datos["requisicionId"] == "12x12x7"  || $datos["requisicionId"] == "12x12x6" || $datos["requisicionId"] == "12x12x5" || $datos["requisicionId"] == "12x12x3" || $datos["requisicionId"] == "24x24x7" || $datos["requisicionId"] == "12x24x7" || $datos["requisicionId"] == "HORARIO OFICINA" || $datos["requisicionId"] == "NO DEFINIDO") {
            throw new Exception("Reelegir La Plantilla De Servicio Para Actualizar");
        }else{
            $this->persistencia->insertEmpleadoPlantilla($datos);
        }
        
    }

    public function getPlantillas()
    {

        //$log = new KLogger ( "negocio_getPlantillas.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getPlantillas();

        return $lista;
    }

    public function getPlantillaWithElementsAvailable($plantillasList)
    {
        // Recorre los elementos de la lista de plantillas buscando una
        // plantilla que aun tenga elementos por cubrir.
        // Si encuentra una plantilla que tenga elementos por cubrir, termina el ciclo
        // Si todos las plantillas estan cubiertas aun así nos dejará pasar.
        for ($i = 0; $i < count($plantillasList); $i++) {
            $item = $plantillasList[$i];

            if ($item["ElementosAsignados"] < $item["ElementosSolicitados"]) {
                break;
            }
        }

        return $item;
    }

    public function deleteElementFromPlantilla($empleadoEntidadId, $empleadoConsecutivoId, $empleadoCategoriaId)
    {
        $this->persistencia->deleteElementFromPlantilla(
            $empleadoEntidadId,
            $empleadoConsecutivoId,
            $empleadoCategoriaId);
    }

    public function getTiposPeriodos()
    {

        //$log = new KLogger ( "negocio_getTiposPeriodos.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getTiposPeriodos();

        return $lista;
    }

    public function getListaEmpleadosBySupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId)
    {

        //$log = new KLogger ( "negocio_getListaEmpleadosBySupervisor.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getListaEmpleadosBySupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId);

        return $lista;
    }

    public function getCatalogoIncidencias()
    {

        //$log = new KLogger ( "negocio_getCatalogoIncidencias.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getCatalogoIncidencias();

        return $lista;
    }

    /**
     * Registra la asistencia de un empleado
     */
    public function registrarAsistencia(
        $empleado,
        $supervisor,
        $incidenciaId,
        $asistenciaFecha,
        $usuarioCapturaAsistencia,
        $comentariIncidencia, $tipoPeriodo, $puestoCubiertoId, $plantilladeservicio,$idPlantillaServicio) {
        //$log = new KLogger ( "negocio_registrarAsistencia.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable empleado : " . var_export ($empleado, true));
        //$log->LogInfo("Valor de la variable supervisor : " . var_export ($supervisor, true));
        //$log->LogInfo("Valor de la variable incidenciaId : " . var_export ($incidenciaId, true));
        //$log->LogInfo("Valor de la variable asistenciaFecha : " . var_export ($asistenciaFecha, true));
        //$log->LogInfo("Valor de la variable usuarioCapturaAsistencia : " . var_export ($usuarioCapturaAsistencia, true));
        //$log->LogInfo("Valor de la variable comentariIncidencia : " . var_export ($comentariIncidencia, true));
        //$log->LogInfo("Valor de la variable tipoPeriodo : " . var_export ($tipoPeriodo, true));
        //$log->LogInfo("Valor de la variable puestoCubiertoId : " . var_export ($puestoCubiertoId, true));
        //$log->LogInfo("Valor de la variable plantilladeservicio : " . var_export ($plantilladeservicio, true));
        //$log->LogInfo("Valor de la variable idPlantillaServicio : " . var_export ($idPlantillaServicio, true));
        $result          = array();
        $errorValidacion = false;
        $usuario["rol"]="";
        $conteobaja="0";

        // Se deben realizar las siguientes validaciones:
        // Todos los datos de entrada son obligatorios.
        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
        // La fecha de asistencia debe estar dentro del periodo quincenal
        // Qué el empleado exista en el sistema
        // Qué el supervisor exista en el sistema
        // Qué no se haya registrado previamente la asistencia

        // Todos los datos de entrada son obligatorios
        if (empty($empleado) ||
            empty($supervisor) ||
            $incidenciaId == "" ||
            $asistenciaFecha == "" ||
            $usuarioCapturaAsistencia == "" ||
            $tipoPeriodo == "" ||
            $puestoCubiertoId == "" || $puestoCubiertoId == "PUNTOS DE SERVICIOS" ||
            !isset($empleado["entidadId"]) || $empleado["entidadId"] == "" ||
            !isset($empleado["consecutivoId"]) || $empleado["consecutivoId"] == "" ||
            !isset($empleado["tipoId"]) || $empleado["tipoId"] == "" ||
            !isset($empleado["puntoServicioId"]) || $empleado["puntoServicioId"] == "" || $empleado["puntoServicioId"] == "PUNTOS DE SERVICIOS" ||
            !isset($supervisor["entidadId"]) || $supervisor["entidadId"] == "" ||
            !isset($supervisor["consecutivoId"]) || $supervisor["consecutivoId"] == "" ||
            !isset($supervisor["tipoId"]) || $supervisor["tipoId"] == "") {
            $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "No se proporcionaron todos los datos necesarios para el registro de asistencia";
    }

        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
    if (!$errorValidacion) {
        $fecha = date_parse($asistenciaFecha);

        if (!empty($fecha["errors"])) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
        }

        if (!$errorValidacion) {
            $fechaVerificada = $fecha["year"] . "-" . str_pad($fecha["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($fecha["day"], 2, "0", STR_PAD_LEFT);

            if ($fechaVerificada != $asistenciaFecha) {
                $errorValidacion   = true;
                $result["status"]  = "error";
                $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
            }
        }
    }

        // La fecha de asistencia debe estar dentro del periodo quincenal

        // Qué el empleado exista en el sistema
    if (!$errorValidacion) {
        $empleadoObtenido = $this->negocio_obtenerEmpleadoPorId(
            $empleado["entidadId"],
            $empleado["consecutivoId"],
            $empleado["tipoId"],$usuario);

            //$log->LogInfo("Valor de la variable \$empleadoObtenido : " . var_export ($empleadoObtenido, true));
        $estatusEmpleadoOperaciones = $empleadoObtenido[0]["estatusEmpleadoOperaciones"];
            //$log->LogInfo("Valor de la variable \$estatusEmpleadoOperaciones : " . var_export ($estatusEmpleadoOperaciones, true));

        if ($empleadoObtenido == null) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "El empleado no existe";
        }
    }

        // Qué el supervisor exista en el sistema
    if (!$errorValidacion) {
        $supervisorObtenido = $this->negocio_obtenerEmpleadoPorId(
            $supervisor["entidadId"],
            $supervisor["consecutivoId"],
            $supervisor["tipoId"],$usuario);

        if ($supervisorObtenido == null) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "El supervisor no existe";
        }
    }

        // Qué no se haya registrado previamente la asistencia        //
    $registrado = false;

    if (!$errorValidacion) {
        if ($incidenciaId != 10) {
            $registrado = $this->persistencia->registrarAsistencia(
                $empleado,
                $supervisor,
                $incidenciaId,
                $asistenciaFecha,
                $usuarioCapturaAsistencia,
                $comentariIncidencia, $tipoPeriodo, $puestoCubiertoId, $plantilladeservicio,$conteobaja,$idPlantillaServicio);
        } else {

            if ($estatusEmpleadoOperaciones == 1 || $estatusEmpleadoOperaciones == 4) {

                $registrado = $this->persistencia->registrarAsistencia(
                    $empleado,
                    $supervisor,
                    $incidenciaId,
                    $asistenciaFecha,
                    $usuarioCapturaAsistencia,
                    $comentariIncidencia, $tipoPeriodo, $puestoCubiertoId, $plantilladeservicio,1,$idPlantillaServicio);

            } elseif ($estatusEmpleadoOperaciones == 0 || $estatusEmpleadoOperaciones == 3) {

                $result["status"]  = "errorRegistro";
                $result["message"] = "El elemento ya cuenta con un registro previo de baja, la baja que intenta registrar no es válida.";

            }

        }

            //$log->LogInfo("Valor de la variable \$registrado : " . var_export ($registrado, true));

        if ($registrado == true) {

            if ($incidenciaId == 10) {
                    // Mmodificar el valor "QUINCENAL" que se proporciona como parametro
                    // para que pueda ser un valor obtenido en los paramateros del ajax.
                $fechasPeriodo = $this->obtenerListaDiasParaAsistencia($tipoPeriodo);
                    //$log->LogInfo("Valor de la variable \$fechasPeriodo : " . var_export ($fechasPeriodo, true));

                $fechaBaja = strtotime($asistenciaFecha);

                for ($i = 0; $i < count($fechasPeriodo); $i++) {
                    $fecha = strtotime($fechasPeriodo[$i]["fecha"]);
                    
                    if($i==0){
                        $conteobaja=1;
                    }else{
                      $conteobaja=0;   
                  }
               //   $log->LogInfo("Valor de la variable \$fechasPeriodo : " . var_export ($conteobaja, true));
                  if ($fecha == $fechaBaja) {
                    $this->persistencia->BorradoDeRegistros( $empleado,date("Y-m-d", $fecha));
                  }
                  if ($fecha > $fechaBaja) {
                    $this->persistencia->BorradoDeRegistros( $empleado,date("Y-m-d", $fecha));
                    $registrado = $this->persistencia->registrarAsistencia(
                        $empleado,
                        $supervisor,
                        $incidenciaId,
                        date("Y-m-d", $fecha),
                        $usuarioCapturaAsistencia,
                        $comentariIncidencia, $tipoPeriodo, $puestoCubiertoId, $plantilladeservicio,$conteobaja,$idPlantillaServicio);
                  }
            }

            $registrado = $this->persistencia->updateEstatusEmpleadoOperaciones($empleado, 3, $asistenciaFecha);

            if ($registrado == true) {
                $result["status"]  = "success";
                $result["message"] = "";
            }

        } else {

            $diasFestivos = $this->persistencia->getDiasFestivos();

            for ($i = 0; $i < count($diasFestivos); $i++) {

                $fechaDiaFestivo  = $diasFestivos[$i]["fechaDiaFestivo"];
                $motivoDiaFestivo = $diasFestivos[$i]["motivoDiaFestivo"];

                $ddmm                = substr($fechaDiaFestivo, 5, 5);
                $ddmmFechaAsistencia = substr($asistenciaFecha, 5, 5);

                        //$log->LogInfo("recorriendo ddmm: " . var_export ($ddmm, true));
                        //$log->LogInfo("recorriendo ddmmFechaAsistencia: " . var_export ($ddmmFechaAsistencia, true));

                if ($ddmm == $ddmmFechaAsistencia) {

                            //$log->LogInfo("La fecha de registro de asistencia es festivo" . var_export ($ddmmFechaAsistencia, true));
                    $deleteIncidencia = $this->persistencia->deleteTurnoDiaFestivo($empleado, $asistenciaFecha);
                            //$log->LogInfo("deleteIncidencia : " . var_export ($deleteIncidencia, true));

                    if ($incidenciaId == 2 || $incidenciaId == 3 || $incidenciaId == 5 || $incidenciaId == 9 || $incidenciaId == 12) {

                        $this->persistencia->registrarIncidenciaEspecial(
                            $empleado,
                            $supervisor,
                            5,
                            $asistenciaFecha,
                            $usuarioCapturaAsistencia,
                            $motivoDiaFestivo, $tipoPeriodo, $puestoCubiertoId, $plantilladeservicio,$idPlantillaServicio,1);

                    }

                }

            }

            $result["status"]  = "success";
            $result["message"] = "";
        }

    }
            //else
            //{
            //$result ["status"] = "error";
            //$result ["message"] = "No se pudo registrar la asistencia en la base de datos.";
            //}
}
        //$log->LogInfo("Valor de la variable \$result : " . var_export ($result, true));

return $result;
}


public function actualizaFirmaEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $firma)
{
    $this->persistencia->actualizaFirmaEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $firma);
}

public function getDatosPorCliente($idCliente)
{

        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));

    $lista = array();

    $lista = $this->persistencia->getDatosPorCliente($idCliente);

    return $lista;
}

public function getPlantillasByPuntoServiciosCliente($idCliente)
{

        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));

    $lista = array();

    $lista = $this->persistencia->getPlantillasByPuntoServiciosCliente($idCliente);

    return $lista;
}

public function getEmpleadosByPuntoServicio($puntoServicioId)
{

        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));

    $lista = array();

    $lista = $this->persistencia->getEmpleadosByPuntoServicio($puntoServicioId);

    return $lista;
}

public function getDetalleRequisicionesByPuntoServicioId($puntoServicioId,$idPlantillaServicio,$caso)
{
    $lista = array();
    if ($puntoServicioId == "" or $puntoServicioId == "PUNTOS DE SERVICIOS") {
        throw new Exception("Por favor seleccione un punto de servicio");
    }
    $lista = $this->persistencia->getDetalleRequisicionesByPuntoServicioId($puntoServicioId,$idPlantillaServicio,$caso);
    return $lista;
}

public function getElementosAsignadosPlantillaByPuntoServicio($puntoServicioId)
{

        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));

    $lista = array();

    $lista = $this->persistencia->getElementosAsignadosPlantillaByPuntoServicio($puntoServicioId);

    return $lista;
}
public function updateCatalogopuntosservicios($puntoServicio)
{

        // $log = new KLogger("negocio_updateCatalogopuntosservicios.log", KLogger::DEBUG);

          // $log->LogInfo("Valor del array " . var_export($puntoServicio, true));

    $patronCorreo   = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
    $patronTelefono = '/\(+[0-9]{1,4}+\)-+[0-9]{4}+\-+[0-9]{4}/';
    $patrocp               = '/[0-9]{5}/';


    if ($puntoServicio["idClientePunto"] == "CLIENTE") {
        throw new Exception("Por favor seleccione un cliente");
    }

    if ($puntoServicio["numeroCentroCosto"] == "") {
        throw new Exception("Por favor ingrese: Número de Centro de Costo");
    }

    if ($puntoServicio["puntoServicio"] == "") {
        throw new Exception("Por favor ingrese: Nombre del punto de servicio");
    }
    /***se modificaron estos 2 parametros**/  
    if ($puntoServicio["selLineaNegocioEdited"] === "0" || $puntoServicio["selLineaNegocioEdited"] === "") {
        throw new Exception("Por favor seleccione: LINEA DE NEGOCIO");
    }

    if ($puntoServicio["idEntidadPunto"] === "0" || $puntoServicio["idEntidadPunto"] === "") {
        throw new Exception("Por favor seleccione una entidad federativa");
    }

    if (($puntoServicio["idClientePunto"] === "43") && (($puntoServicio["DelMunEdited"] === "") || ($puntoServicio["DelMunEdited"] === "0") || ($puntoServicio["DelMunEdited"] === "null") || ($puntoServicio["DelMunEdited"] === NULL) || ($puntoServicio["DelMunEdited"] === "NULL") || ($puntoServicio["DelMunEdited"] === null))) {
        throw new Exception("Por favor seleccione una Delegacion o Municipio");
    }

    if ($puntoServicio["idClientePunto"] === "43" && $puntoServicio["UnidadEdited"] === "") {
        throw new Exception("Por favor Ingrese La Unidad");
    }
//////////////******************************************************************************//////////////

    if ($puntoServicio["CpContratoPuntoServicioEdit"] == "") {
            throw new Exception("Por favor ingrese: El Codigo Postal");
        }
    if (preg_match($patrocp, $puntoServicio["CpContratoPuntoServicioEdit"]) == false) {
            throw new Exception("Formaro Codigo Postal inválido 5 Digitos ");
        }
    if ($puntoServicio["EntidadClientePuntoServicioEdit"] == "0") {
        throw new Exception("Por favor Seleccione: La Entidad O Escoga El Asentamiento");
    }
    if ($puntoServicio["MunicipioPuntoServicioEdit"] == "0") {
        throw new Exception("Por favor Seleccione: Municipio O Escoga El Asentamiento");
    }
    if ($puntoServicio["ColoniaClientePuntoServicioEdit"] == "0") {
        throw new Exception("Por favor Seleccione: La Colonia O Escoga El Asentamiento");
    }
    if ($puntoServicio["CallePrincipalPuntoServicioEdit"] == "") {
        throw new Exception("Por favor Ingrese: La Calle Principal");
    }
    if ($puntoServicio["NumeroInteriroPuntoServicioEdit"] == "") {
        throw new Exception("Por favor Ingrese: El Numero Interior");
    }
    if ($puntoServicio["NumeroExteriorPuntoServicioEdit"] == "") {
        throw new Exception("Por favor Ingrese: El Numero Exterior");
    }
    if ($puntoServicio["Calle1PuntoServicioEdit"] == "") {
        throw new Exception("Por favor Ingrese: La Primer Calle Colindante");
    }
    if ($puntoServicio["Calle2PuntoServicioEdit"] == "") {
        throw new Exception("Por favor Ingrese: La Segunda Calle Colindante");
    }
    /*if ($puntoServicio["direccionPuntoServicio"] == "") {
        throw new Exception("Por favor ingrese: Dirección del punto de servicio");
    }*/

    if (is_numeric($puntoServicio["latitudPunto"]) == false) {
        throw new Exception("Verifique latitud");
    }

    if (is_numeric($puntoServicio["longitudPunto"]) == false) {
        throw new Exception("Verifique longitud");
    }

    if ($puntoServicio["RangoAsisEdit"] == "") {
        throw new Exception("Por favor Ingrese: El Rango Para La Aplicacion De Asistencia");
    }
    if ($puntoServicio["RangoAsisEdit"] != "") {
        if (is_numeric($puntoServicio["RangoAsisEdit"]) == false) {
            throw new Exception("Verifique El rango SOLO NUMEROS");
        }
    }

    if ($puntoServicio["fechaInicioServicio"] == "" || $puntoServicio["fechaInicioServicio"] == "0000-00-00") {
        throw new Exception("Ingrese Fecha Inicio");
    }
    if ($puntoServicio["fechaTerminoServicio"] == "" || $puntoServicio["fechaTerminoServicio"] == "0000-00-00") {
        throw new Exception("Ingrese Fecha de termino de servicio");
    }

    if ($puntoServicio["contactoTesoreria"] == "" and $puntoServicio["contactoFacturacion"] == "") {
        throw new Exception("Por favor ingrese por lo menos un Contacto Administrativo");

    }

    if ($puntoServicio["contactoFacturacion"] != "") {

        if ($puntoServicio["correoFacturacion"] == "") {
            throw new Exception("Por favor ingrese: Correo de facturación");
        }

        if ($puntoServicio["correoFacturacion"] != "") {

            if (preg_match($patronCorreo, $puntoServicio["correoFacturacion"]) == false) {
                throw new Exception("El formato de correo electronico de facturación es incorrecto");
            }
        }

        if ($puntoServicio["telefonoFijoFacturacion"] == "" and $puntoServicio["telefonoMovilFacturacion"] == "") {
            throw new Exception("Por favor ingrese por lo menos un número de contacto para facturación");
        }

    }
    if ($puntoServicio["terminoFacturacion"] == "") {
        throw new Exception("Por favor ingrese terminos de facturación");

    }
    if ($puntoServicio["contactoTesoreria"] != "") {

        if ($puntoServicio["correoTesoreria"] == "") {
            throw new Exception("Por favor ingrese: Correo de Tesoreria");
        }

        if ($puntoServicio["correoTesoreria"] != "") {

            if (preg_match($patronCorreo, $puntoServicio["correoTesoreria"]) == false) {
                throw new Exception("El formato de correo electronico de Tesoreria es incorrecto");
            }
        }
        if ($puntoServicio["telefonoFijoTesoreria"] == "" and $puntoServicio["telefonoMovilTesoreria"] == "") {
            throw new Exception("Por favor ingrese por lo menos un número de contacto para Tesoreria");
        }

    }

    if ($puntoServicio["contactoOperativo"] == "") {
        throw new Exception("Por favor ingrese contacto operativo");

    }

    if ($puntoServicio["contactoOperativo"] != "") {

        if ($puntoServicio["correoOperativo"] == "") {
            throw new Exception("Por favor ingrese: Correo de Operaciones");
        }

        if ($puntoServicio["correoOperativo"] != "") {

            if (preg_match($patronCorreo, $puntoServicio["correoOperativo"]) == false) {
                throw new Exception("El formato de correo electronico de Operacion es incorrecto");
            }
        }

        if ($puntoServicio["telefonoMovilOperativo"] == "" and $puntoServicio["telefonoFijoOperativo"] == "") {
            throw new Exception("Por favor ingrese por lo menos un número de contacto para Operaciones");
        }

    }

    if ($this->persistencia->existeNumeroCentroCostoCliente($puntoServicio["idClientePunto"], $puntoServicio["numeroCentroCosto"])) {
        $numeroCentroGuardado = $this->persistencia->selectDatosPuntoServicio($puntoServicio["idPuntoServicio"]);

        if ($numeroCentroGuardado[0]["numeroCentroCosto"] != $puntoServicio["numeroCentroCosto"]) {
            throw new Exception("El numero de centro de costo ya se encuentra registrado en la base");
        }

            // $log->LogInfo("Valor de la variable \$numeroCentroGuardado : " . var_export($numeroCentroGuardado, true));

    }

    if ($this->persistencia->existeNombrePuntoServicio($puntoServicio["idClientePunto"], $puntoServicio["puntoServicio"])) {

        $nombrePuntoServicio = $this->persistencia->selectDatosPuntoServicio($puntoServicio["idPuntoServicio"]);

        if ($nombrePuntoServicio[0]["puntoServicio"] != $puntoServicio["puntoServicio"]) {
            throw new Exception("El nombre del punto de servicio ya se encuentra registrado en la base");
        }

    }

    $this->persistencia->updateCatalogopuntosservicios($puntoServicio);
}

public function updateRequisicion($requisicion, $accion)
{
       // $log = new KLogger ( "negocio_updateRequisicion.log" , KLogger::DEBUG );
       // $log->LogInfo("Valor de la idCliente  requisicion: " . var_export ($requisicion, true));
        //$log->LogInfo("Valor de la idCliente  accion: " . var_export ($accion, true));
   $numeros12  = '/[0-9]/';
   $SumaDeChecks = (($requisicion["checkLunes0"]) + ($requisicion["checkMartes0"]) + ($requisicion["checkMiercoles0"]) + ($requisicion["checkJueves0"]) + ($requisicion["checkViernes0"]) + ($requisicion["checkSabado0"]) + ($requisicion["checkDomingo0"]));
        //$log->LogInfo("Valor de la idCliente  SumaDeChecks: " . var_export ($SumaDeChecks, true));
   $a = $requisicion["rolOperativo"];
   $b = $requisicion["CubreDescansoPlantillas0"];
   $c = $requisicion["checkElementos0"];
       // $log->LogInfo("Valor de la rol  : " . var_export ($a, true));
         //$log->LogInfo("Valor de la cubre  : " . var_export ($b, true));
         //$log->LogInfo("Valor de la check  : " . var_export ($c, true));
   if ($requisicion["fechaInicio"] == "" || $requisicion["fechaInicio"] == "0000-00-00") {
    throw new Exception("Proporcione fecha de inicio de plantilla");
}
if ($requisicion["fechaTerminoPlantilla"] == "" || $requisicion["fechaTerminoPlantilla"] == "0000-00-00") {
    throw new Exception("Proporcione fecha de termino de plantilla");
}
if ($requisicion["numeroElementos"] == "" || $requisicion["numeroElementos"] < "1") {
    throw new Exception("Proporcine el numero de elementos No debe ser menor a uno");
}
if ($requisicion["tipoTurnoPlantillaId"] == "TURNO" || $requisicion["tipoTurnoPlantillaId"] == "") {
    throw new Exception("Seleccione el tipo de turno");
}
if ($requisicion["puestoPlantillaId"] == "PUESTO" || $requisicion["puestoPlantillaId"] == "") {
    throw new Exception("Seleccione un puesto");
}
if ($requisicion["turnosPorDia"] == "") {
    throw new Exception("Indique el número de turnos por elemento a cubrir por día");
}
if (($requisicion["IdClientePunto0"] != "2") && (($requisicion["LineaNegocioPlantilla0"] == "1") || ($requisicion["LineaNegocioPlantilla0"] == "3")) ) {
    
    if ($requisicion["IdrolOperativo"] == "0" || $requisicion["IdrolOperativo"] == "") {
        throw new Exception("Seleccione el rol operativo de la plantilla");
    }
    if($requisicion["checkElementos0"] == "1"){
        if ($requisicion["rolOperativo"] == "12x12x6" && $SumaDeChecks!=6) {
            throw new Exception("Marque 6 De Los 7 Dias De La Semana Y Llene Correctamente (Dias Laborables 6)");
        }
        if ($requisicion["rolOperativo"] == "12x12x5" && $SumaDeChecks!=5) {
            throw new Exception("Marque 5 De Los 7 Dias De La Semana Y Llene Correctamente (Dias Laborables 5)");
        }
        if ($requisicion["rolOperativo"] == "12x12x3" && $SumaDeChecks!=3) {
            throw new Exception("Marque 3 De Los 7 Dias De La Semana Y Llene Correctamente (Dias Laborables 3)");
        }
    }// Validaciones Para Lunes
        if ($requisicion["checkLunes0"] == 1 && $requisicion["TDiaLunes0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Lunes Si No Hay Coloque (0)");
        }
        if ($requisicion["checkLunes0"] == 1 && $requisicion["TNocheLunes0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Lunes Si No Hay Coloque (0)");
        }
        if ($requisicion["checkLunes0"] == 1 && (($requisicion["TTotalesLunes0"] > $requisicion["turnosPorDia"]) || ($requisicion["TTotalesLunes0"] < "0"))) {
            throw new Exception("La Suma Del Dia Lunes  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir x Dia)");
        }// Validaciones Para Martes
        if ($requisicion["checkMartes0"] == 1 && $requisicion["TDiaMartes0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Martes Si No Hay Coloque (0)");
        }
        if ($requisicion["checkMartes0"] == 1 && $requisicion["TNochesMartes0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Martes Si No Hay Coloque (0)");
        }
        if ($requisicion["checkMartes0"] == 1 && (($requisicion["TTotalesMartes0"] > $requisicion["turnosPorDia"]) || ($requisicion["TTotalesMartes0"] < "0"))) {
            throw new Exception("La Suma Del Dia Martes  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir x Dia)");
        }// Validaciones Para Miercoles
        if ($requisicion["checkMiercoles0"] == 1 && $requisicion["TDiaMiercoles0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Miercoles Si No Hay Coloque (0)");
        }
        if ($requisicion["checkMiercoles0"] == 1 && $requisicion["TNocheMiercoles0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Miercoles Si No Hay Coloque (0)");
        }
        if ($requisicion["checkMiercoles0"] == 1 && (($requisicion["TTotalesMiercoles0"] > $requisicion["turnosPorDia"]) || ($requisicion["TTotalesMiercoles0"] < "0"))) {
            throw new Exception("La Suma Del Dia Miercoles  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir x Dia)");
        }// Validaciones Para Jueves
        if ($requisicion["checkJueves0"] == 1 && $requisicion["TDiaJueves0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Jueves Si No Hay Coloque (0)");
        }
        if ($requisicion["checkJueves0"] == 1 && $requisicion["TNocheJueves0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Jueves Si No Hay Coloque (0)");
        }
        if ($requisicion["checkJueves0"] == 1 && (($requisicion["TTotalesJueves0"] > $requisicion["turnosPorDia"]) || ($requisicion["TTotalesJueves0"] < "0"))) {
            throw new Exception("La Suma Del Dia Jueves  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir x Dia)");
        }// Validaciones Para Viernes 
        if ($requisicion["checkViernes0"] == 1 && $requisicion["TDiaViernes0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Viernes Si No Hay Coloque (0)");
        }
        if ($requisicion["checkViernes0"] == 1 && $requisicion["TNocheViernes0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Viernes Si No Hay Coloque (0)");
        }
        if ($requisicion["checkViernes0"] == 1 && (($requisicion["TTotalesViernes0"] > $requisicion["turnosPorDia"]) || ($requisicion["TTotalesViernes0"] < "0"))) {
            throw new Exception("La Suma Del Dia Viernes  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir x Dia)");
        }// Validaciones Para Sabado
        if ($requisicion["checkSabado0"] == 1 && $requisicion["TDiaSabado0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Sabado Si No Hay Coloque (0)");
        }
        if ($requisicion["checkSabado0"] == 1 && $requisicion["TNocheSabado0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Sabado Si No Hay Coloque (0)");
        }
        if ($requisicion["checkSabado0"] == 1 && (($requisicion["TtotalesSabado0"] > $requisicion["turnosPorDia"]) || ($requisicion["TtotalesSabado0"] < "0"))) {
            throw new Exception("La Suma Del Dia Sabado  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir x Dia)");
        }// Validaciones Para Domingo
        if ($requisicion["checkDomingo0"] == 1 && $requisicion["TDiaDomingo0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Dia A Cubrir En Domingo Si No Hay Coloque (0)");
        }
        if ($requisicion["checkDomingo0"] == 1 && $requisicion["TNocheDomingo0"] == "") {
            throw new Exception("Proporcone La Cantidad De Turnos De Noche A Cubrir En Domingo Si No Hay Coloque (0)");
        }
        if ($requisicion["checkDomingo0"] == 1 && (($requisicion["TTotalesDomingo0"] > $requisicion["turnosPorDia"]) || ($requisicion["TTotalesDomingo0"] < "0"))) {
            throw new Exception("La Suma Del Dia Domingo  (Turno Dia) Y (Turno Noche)No Debe Ser Menor A Cero(0) Ni Debe Ser Mayor A (Turnos a Cubrir x Dia)");
        }
    }
    if ($requisicion["costoNetoFactura"] == "") {
        throw new Exception("Indique el costo total de factura");
    }

    if (is_numeric($requisicion["costoPorTurno"])) {

    } else {
        throw new Exception("Ingrese costo por turno correctamente");
    }

    if (strtotime($requisicion["fechaInicio"]) < strtotime($requisicion["fechaInicioPuntoServicio"])) {
        throw new Exception("La fecha de montaje del punto de servicio no puede ser menor a la fecha de inicio del punto");
    }
    if (strtotime($requisicion["fechaTerminoPlantilla"]) > strtotime($requisicion["fechaTerminoPuntoServicio"])) {
        throw new Exception("La fecha de termino de montaje no puede ser mayor a la fecha de termino del punto de servicio");
    }
    if (strtotime($requisicion["fechaTerminoPlantilla"]) < strtotime($requisicion["fechaInicio"])) {
        throw new Exception("La fecha de termino de montaje no puede ser menor a la fecha de inicio de montaje");
    }
    $this->persistencia->updateRequisicion($requisicion);
    if ($accion == 1) {
        $this->persistencia->registroDatosHistoricoCostoPlantillaEdited($requisicion);
    }
}

public function getPuntosServiciosSupervisor($entidadSupervisor, $consecutivoSupervisor, $tipoSupervisor)
{

        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));

    $lista = array();

    $lista = $this->persistencia->getPuntosServiciosSupervisor($entidadSupervisor, $consecutivoSupervisor, $tipoSupervisor);

    return $lista;
}

public function getListaEmpleadosBySupervisorPeriodoPuntoServicio($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId, $puntoServicio)
{

        //$log = new KLogger ( "negocio_getListaEmpleadosBySupervisorPeriodoPuntoServicio.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getListaEmpleadosBySupervisorPeriodoPuntoServicio($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId, $puntoServicio);
    return $lista;
        //$log->LogInfo("Valor de la idCliente \$lista : " . var_export ($lista, true));

}

public function print_timestamp($label, $timestamp)
{
    echo "<p>" . $label . " | " . date("Y-m-d H:i:s", $timestamp) . " | " . $timestamp . "</p>";
}

    /**
     * $tipoPeriodo {SEMANAL, CATORCENAL, QUINCENAL}
     
    public function obtenerListaDiasParaAsistencia($tipoPeriodo, $currentTimestamp = null)
    {
        $log = new KLogger("negocio_obtenerListaDiasParaAsistencia.log", KLogger::DEBUG);
        $log->LogInfo("Valor de la idCliente tipoPeriodo : " . var_export ($tipoPeriodo, true));

        $debug            = 0;
        $segundos_por_dia = 86400;

        $dias_semana = array("Dom", "Lun", "Mar", "Miér", "Jue", "Vier", "Sáb");
        $result      = array();

        $tipoPeriodo = strtoupper($tipoPeriodo);

        $configPeriodo           = $this->persistencia->getParametroConfiguracionById("PERIODO_" . $tipoPeriodo);
        $configHoraCierrePeriodo = $this->persistencia->getParametroConfiguracionById("PERIODO_HORA_CIERRE");

        if ($configPeriodo == null) {
            return $result;
        }

        $periodoHoraCierre = "12:00";
        if ($configHoraCierrePeriodo != null) {
            $periodoHoraCierre = $configHoraCierrePeriodo;
        }

        if ($currentTimestamp == null) {
            $currentTimestamp = time();
        }

        $items  = explode(":", $periodoHoraCierre);
        $hora   = $items[0];
        $minuto = $items[1];

        $secondsExtra = $hora * 3600 + $minuto * 60;
        if ($tipoPeriodo == "SEMANAL") {
            $currentDiaSemana = date("w", $currentTimestamp);
            $diff             = $currentDiaSemana - $configPeriodo;
            $day              = $currentTimestamp - ($segundos_por_dia * $diff);
            $limit = mktime(0, 0, 0, date("n", $day), date("d", $day), date("Y", $day));
            $limit += $secondsExtra;

            if ($debug) {
                $log->LogInfo("Valor de la semanal debug : " . var_export ($debug, true));
                echo "CurrentDiaSemana:" . $dias_semana[$currentDiaSemana] . "<br/>";
                echo "ConfigPeriodo:" . $dias_semana[$configPeriodo] . "<br/>";
                $this->print_timestamp("currentTimestamp", $currentTimestamp);
                $this->print_timestamp("day", $day);
                $this->print_timestamp("limit", $limit);
            }

            if ($currentTimestamp < $limit) {
                $day -= 7 * $segundos_por_dia;
            }

            for ($i = $configPeriodo; $i < $configPeriodo + 7; $i++) {
                $result[] = array("fecha" => date("Y-m-d", $day),
                    "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
                $day += $segundos_por_dia;
            }
        } elseif ($tipoPeriodo == "CATORCENAL") {
            $startDay       = $configPeriodo;
            $startTimestamp = strtotime($startDay);
            $endTimestamp   = $startTimestamp + ($segundos_por_dia * 14);
            $limit          = $endTimestamp + $secondsExtra;

            if ($debug) {
                //$this -> print_timestamp ("startDay", $startDay);
                $this->print_timestamp("currentTimestamp", $currentTimestamp);
                $this->print_timestamp("startTimestamp", $startTimestamp);
                $this->print_timestamp("endTimestamp", $endTimestamp);
                $this->print_timestamp("limit", $limit);
            }

            if ($currentTimestamp > $limit) {
                $startDay = date("Y-m-d", $endTimestamp);
                $this->persistencia->saveParametroConfiguracion("PERIODO_" . $tipoPeriodo, $startDay, "Periodo catorcenal. Modificado por sistema");

                $startTimestamp = strtotime($startDay);
                $endtimestamp   = $startTimestamp + ($segundos_por_dia * 14);
            }

            $day = $startTimestamp;
            for ($i = 0; $i < 14; $i++) {
                $result[] = array("fecha" => date("Y-m-d", $day),
                    "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
                $day += $segundos_por_dia;
            }
        } else // Periodo QUINCENAL
        {
            $currentTimestamp -= $secondsExtra;

            $currentDay   = date("j", $currentTimestamp);
            $currentMonth = date("n", $currentTimestamp);
            $currentYear  = date("Y", $currentTimestamp);

            if ($debug) {
                echo "<p>periodoHoraCierre:" . $hora . "--" . $minuto . "</p>";
            }

            $today     = $currentTimestamp; // mktime (0,0,0,$currentMonth, $currentDay, $currentYear);
            $startDay  = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
            $endDay    = mktime(23, 59, 59, $currentMonth, 15, $currentYear);
            $changeDay = $endDay; // + ($segundos_por_dia / 2);

            //$log->LogInfo("Valor de la  \$today : " . var_export (date("Y-m-d",$today), true));

            //$log->LogInfo("Valor de la  \$startDay : " . var_export (date("Y-m-d",$startDay), true));
            //$log->LogInfo("Valor de la  \$endDay : " . var_export (date("Y-m-d",$endDay), true));
            //$log->LogInfo("Valor de la  \$currentDay : " . var_export ($currentDay, true));

            if ($currentDay > 15) {
                $startDay = mktime(0, 0, 0, $currentMonth, 16, $currentYear);
                //$log->LogInfo("Valor de la startDay  \$startDay : " . var_export (date("Y-m-d",$startDay), true));

                $lastDayOfMonth = date("t", $currentTimestamp);

                $endDay = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);

                //$log->LogInfo("Valor de la startDay  \$startDay : " . var_export (date("Y-m-d",$startDay), true));
                //$log->LogInfo("Valor de la endDay  \$endDay : " . var_export (date("Y-m-d",$endDay), true));

                //$startDay += $segundos_por_dia;
                //$endDay += $segundos_por_dia;
            }

            $startDay += ($segundos_por_dia * ($configPeriodo));
            $endDay += ($segundos_por_dia * ($configPeriodo));
            $changeDay = $endDay; // + ($segundos_por_dia / 2);

            //$log->LogInfo("Valor de la startDay con \$startDay : " . var_export (date("Y-m-d",$startDay), true));
            //$log->LogInfo("Valor de la endDay con  \$endDay : " . var_export (date("Y-m-d",$endDay), true));

            if ($debug) {
                $log->LogInfo("Valor de la quincenal debug : " . var_export ($debug, true));
                echo "<p>Valores iniciales del timestamp y dia inicial y dia final del periodo<br/>";
                echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                echo "</p>";
            }
            //$log->LogInfo("Valor de la changeday: " . var_export ($changeDay, true));
            //$log->LogInfo("Valor de la today: " . var_export ($today, true));
            // Ajuste para mostrar el nuevo periodo cuando
            // la fecha actual es mayor que el dia final del periodo
            if ($changeDay < $today) {
                $startDay = $endDay + 1;
                $endDay   = $startDay + ($segundos_por_dia * 10);

                $month = date("n", $endDay);
                $year  = date("Y", $endDay);

                $endDay1 = mktime(23, 59, 59, $month, 1, $year);
                $endDay2 = mktime(23, 59, 59, $month, 15, $year);

                if ($endDay < $endDay1) {
                    $endDay = $endDay1;
                } elseif ($endDay < $endDay2) {
                    $endDay = $endDay2;
                } else {
                    $lastDayOfMonth = date("t", $currentTimestamp);
                    $endDay         = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);
                }

                $endDay += ($segundos_por_dia * ($configPeriodo));
                $changeDay = $endDay + ($segundos_por_dia / 2);

                if ($debug) {
                    echo "<p>Cambio de periodo<br/>";
                    echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                    echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                    echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                    echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                    echo "</p>";
                }
            }

            #echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d", $currentTimestamp) . "<br/>";
            #echo "startDay:" . $startDay . " " . date("Y-m-d", $startDay) . "<br/>";
            #echo "endDay:" . $endDay . " " . date("Y-m-d", $endDay) . "<br/>";

            $day = $startDay;

            //$log->LogInfo("Valor de la day con  \$day : " . var_export (date("Y-m-d",$day), true));

            //$days = ($endDay - $startDay)  / $segundos_por_dia;
            for ($i = date("Y-m-d", $startDay); $i <= date("Y-m-d", $endDay); $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {

                $diaSemana = $dias_semana[date('w', strtotime($i))];
                //$log->LogInfo("Valor diaSemanacon  \$day : " . var_export ($diaSemana, true));

                $result[] = array("fecha" => $i,
                    "leyenda"                 => $diaSemana . "-" . $i, "dia" => $diaSemana . " " . date('d-m', strtotime($i)));

                //$day = date("Y-m-d", strtotime($i ."+ 1 days"));
                //$log->LogInfo("Valor de la day day day con  \$day : " . var_export ($i, true));
                //$log->LogInfo("Valor de result con  \$day : " . var_export ($result, true));

            }

        }

        // $log->LogInfo("Valor de result con  \$result : " . var_export($result, true));
        $log->LogInfo("Valor de la semanal result : " . var_export ($result, true));
        return $result;
    }
*/
    public function obtenerListaDiasParaAsistencia($tipoPeriodo, $currentTimestamp = null)
    {
        $log = new KLogger("negocio_obtenerListaDiasParaAsistencia.log", KLogger::DEBUG);
        $log->LogInfo("Valor de la idCliente tipoPeriodo : " . var_export ($tipoPeriodo, true));

        $debug            = 0;
        $segundos_por_dia = 86400;

        $dias_semana = array("Dom", "Lun", "Mar", "Miér", "Jue", "Vier", "Sáb");
        $result      = array();

        $tipoPeriodo = strtoupper($tipoPeriodo);

        $configPeriodo           = $this->persistencia->getParametroConfiguracionById("PERIODO_" . $tipoPeriodo);
        $configHoraCierrePeriodo = $this->persistencia->getParametroConfiguracionById("PERIODO_HORA_CIERRE");

        if ($configPeriodo == null) {
            return $result;
        }

        $periodoHoraCierre = "13:00";
        if ($configHoraCierrePeriodo != null) {
            $periodoHoraCierre = $configHoraCierrePeriodo;
        }

        if ($currentTimestamp == null) {
            $currentTimestamp = time();
        }
        $log->LogInfo("Valor de variable empleadoEntidad currentTimestamp" . var_export ($currentTimestamp, true));
        $log->LogInfo("Valor de la  currentTimestampy : " . var_export (date("Y-m-d H:i:s",$currentTimestamp), true));

        $items  = explode(":", $periodoHoraCierre);
        $hora   = $items[0];
        $minuto = $items[1];

        $secondsExtra = $hora * 3600 + $minuto * 60;
        if ($tipoPeriodo == "SEMANAL") {
            $currentDiaSemana = date("w", $currentTimestamp);
            $diff             = $currentDiaSemana - $configPeriodo;
            $day              = $currentTimestamp - ($segundos_por_dia * $diff);
            $limit = mktime(0, 0, 0, date("n", $day), date("d", $day), date("Y", $day));
            $limit += $secondsExtra;

            if ($debug) {
                $log->LogInfo("Valor de la semanal debug : " . var_export ($debug, true));
                echo "CurrentDiaSemana:" . $dias_semana[$currentDiaSemana] . "<br/>";
                echo "ConfigPeriodo:" . $dias_semana[$configPeriodo] . "<br/>";
                $this->print_timestamp("currentTimestamp", $currentTimestamp);
                $this->print_timestamp("day", $day);
                $this->print_timestamp("limit", $limit);
            }

            if ($currentTimestamp < $limit) {
                $day -= 7 * $segundos_por_dia;
            }

            for ($i = $configPeriodo; $i < $configPeriodo + 7; $i++) {
                $result[] = array("fecha" => date("Y-m-d", $day),
                    "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
                $day += $segundos_por_dia;
            }
        } elseif ($tipoPeriodo == "CATORCENAL") {
            $startDay       = $configPeriodo;
            $startTimestamp = strtotime($startDay);
            $endTimestamp   = $startTimestamp + ($segundos_por_dia * 14);
            $limit          = $endTimestamp + $secondsExtra;

            if ($debug) {
                //$this -> print_timestamp ("startDay", $startDay);
                $this->print_timestamp("currentTimestamp", $currentTimestamp);
                $this->print_timestamp("startTimestamp", $startTimestamp);
                $this->print_timestamp("endTimestamp", $endTimestamp);
                $this->print_timestamp("limit", $limit);
            }

            if ($currentTimestamp > $limit) {
                $startDay = date("Y-m-d", $endTimestamp);
                $this->persistencia->saveParametroConfiguracion("PERIODO_" . $tipoPeriodo, $startDay, "Periodo catorcenal. Modificado por sistema");

                $startTimestamp = strtotime($startDay);
                $endtimestamp   = $startTimestamp + ($segundos_por_dia * 14);
            }

            $day = $startTimestamp;
            for ($i = 0; $i < 14; $i++) {
                $result[] = array("fecha" => date("Y-m-d", $day),
                    "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
                $day += $segundos_por_dia;
            }
        } else // Periodo QUINCENAL
        {

            $currentTimestamp -= $secondsExtra;
            $log->LogInfo("Valor de variable empleadoEntidad currentTimestampaaaaaaaa" . var_export ($currentTimestamp, true));
        $log->LogInfo("Valor de la  currentTimestampyaaaaaaaa : " . var_export (date("Y-m-d H:i:s",$currentTimestamp), true));
            $currentDay   = date("j", $currentTimestamp);
            $currentMonth = date("n", $currentTimestamp);
            $currentYear  = date("Y", $currentTimestamp);

            if ($debug) {
                echo "<p>periodoHoraCierre:" . $hora . "--" . $minuto . "</p>";
            }

            $today     = $currentTimestamp; // mktime (0,0,0,$currentMonth, $currentDay, $currentYear);
            $startDay  = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
            $endDay    = mktime(23, 59, 59, $currentMonth, 15, $currentYear);
            $changeDay = $endDay; // + ($segundos_por_dia / 2);

            //$log->LogInfo("Valor de la  \$today : " . var_export (date("Y-m-d",$today), true));

            //$log->LogInfo("Valor de la  \$startDay : " . var_export (date("Y-m-d",$startDay), true));
            //$log->LogInfo("Valor de la  \$endDay : " . var_export (date("Y-m-d",$endDay), true));
            //$log->LogInfo("Valor de la  \$currentDay : " . var_export ($currentDay, true));

            if ($currentDay > 15) {
                $startDay = mktime(0, 0, 0, $currentMonth, 16, $currentYear);
                //$log->LogInfo("Valor de la startDay  \$startDay : " . var_export (date("Y-m-d",$startDay), true));

                $lastDayOfMonth = date("t", $currentTimestamp);

                $endDay = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);

                //$log->LogInfo("Valor de la startDay  \$startDay : " . var_export (date("Y-m-d",$startDay), true));
                //$log->LogInfo("Valor de la endDay  \$endDay : " . var_export (date("Y-m-d",$endDay), true));

                //$startDay += $segundos_por_dia;
                //$endDay += $segundos_por_dia;
            }

            $startDay += ($segundos_por_dia * ($configPeriodo));
            $endDay += ($segundos_por_dia * ($configPeriodo));
            $changeDay = $endDay; // + ($segundos_por_dia / 2);

            //$log->LogInfo("Valor de la startDay con \$startDay : " . var_export (date("Y-m-d",$startDay), true));
            //$log->LogInfo("Valor de la endDay con  \$endDay : " . var_export (date("Y-m-d",$endDay), true));

            if ($debug) {
                $log->LogInfo("Valor de la quincenal debug : " . var_export ($debug, true));
                echo "<p>Valores iniciales del timestamp y dia inicial y dia final del periodo<br/>";
                echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                echo "</p>";
            }
            //$log->LogInfo("Valor de la changeday: " . var_export ($changeDay, true));
            //$log->LogInfo("Valor de la today: " . var_export ($today, true));
            // Ajuste para mostrar el nuevo periodo cuando
            // la fecha actual es mayor que el dia final del periodo
            if ($changeDay < $today) {
                $startDay = $endDay + 1;
                $endDay   = $startDay + ($segundos_por_dia * 10);

                $month = date("n", $endDay);
                $year  = date("Y", $endDay);

                $endDay1 = mktime(23, 59, 59, $month, 1, $year);
                $endDay2 = mktime(23, 59, 59, $month, 15, $year);

                if ($endDay < $endDay1) {
                    $endDay = $endDay1;
                } elseif ($endDay < $endDay2) {
                    $endDay = $endDay2;
                } else {
                    $lastDayOfMonth = date("t", $currentTimestamp);
                    $endDay         = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);
                }

                $endDay += ($segundos_por_dia * ($configPeriodo));
                $changeDay = $endDay + ($segundos_por_dia / 2);

                if ($debug) {
                    echo "<p>Cambio de periodo<br/>";
                    echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                    echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                    echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                    echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                    echo "</p>";
                }
            }

            #echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d", $currentTimestamp) . "<br/>";
            #echo "startDay:" . $startDay . " " . date("Y-m-d", $startDay) . "<br/>";
            #echo "endDay:" . $endDay . " " . date("Y-m-d", $endDay) . "<br/>";

            $day = $startDay;

            //$log->LogInfo("Valor de la day con  \$day : " . var_export (date("Y-m-d",$day), true));

            //$days = ($endDay - $startDay)  / $segundos_por_dia;
            for ($i = date("Y-m-d", $startDay); $i <= date("Y-m-d", $endDay); $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {

                $diaSemana = $dias_semana[date('w', strtotime($i))];
                //$log->LogInfo("Valor diaSemanacon  \$day : " . var_export ($diaSemana, true));

                $result[] = array("fecha" => $i,
                    "leyenda"                 => $diaSemana . "-" . $i, "dia" => $diaSemana . " " . date('d-m', strtotime($i)));

                //$day = date("Y-m-d", strtotime($i ."+ 1 days"));
                //$log->LogInfo("Valor de la day day day con  \$day : " . var_export ($i, true));
                //$log->LogInfo("Valor de result con  \$day : " . var_export ($result, true));

            }

        }

        // $log->LogInfo("Valor de result con  \$result : " . var_export($result, true));
        $log->LogInfo("Valor de la semanal result : " . var_export ($result, true));
        return $result;
    }
    public function getListaEmpleadosBySupervisorPeriodoNombre($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId, $nombre)
    {

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoNombre.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getListaEmpleadosBySupervisorPeriodoNombre($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId, $nombre);
        return $lista;
        //$log->LogInfo("Valor de la idCliente \$lista : " . var_export ($lista, true));

    }

    public function getAsistenciaByEmpleadoFecha($fecha, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
    {

        //$log = new KLogger ( "getAsistenciaByEmpleadoFecha.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getAsistenciaByEmpleadoFecha($fecha, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        return $lista;
        //$log->LogInfo("Valor de la idCliente \$lista : " . var_export ($lista, true));

    }

    public function getAsistenciaByEmpleadoPeriodo($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
    {

        //$log = new KLogger ( "negocio_getAsistenciaByEmpleadoPeriodo.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

        $lista = array();

        $lista = $this->persistencia->getAsistenciaByEmpleadoPeriodo($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function updateAsistencia($empleado, $supervisor, $incidenciaId, $asistenciaFecha, $usuarioCapturaAsistencia, $comentarioIncidencia, $tipoPeriodo, $plantilladeservicio)
    {
        $result          = array();
        $errorValidacion = false;
        $usuario["rol"]="";

        // Se deben realizar las siguientes validaciones:
        // Todos los datos de entrada son obligatorios.
        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
        // La fecha de asistencia debe estar dentro del periodo quincenal
        // Qué el empleado exista en el sistema
        // Qué el supervisor exista en el sistema
        // Qué no se haya registrado previamente la asistencia

        // Todos los datos de entrada son obligatorios
        if (empty($empleado) ||
            empty($supervisor) ||
            $incidenciaId == "" ||
            $asistenciaFecha == "" ||
            $usuarioCapturaAsistencia == "" ||
            $usuarioCapturaAsistencia == "" ||
            !isset($empleado["entidadId"]) || $empleado["entidadId"] == "" ||
            !isset($empleado["consecutivoId"]) || $empleado["consecutivoId"] == "" ||
            !isset($empleado["tipoId"]) || $empleado["tipoId"] == "" ||
            !isset($empleado["puntoServicioId"]) || $empleado["puntoServicioId"] == "" ||
            !isset($supervisor["entidadId"]) || $supervisor["entidadId"] == "" ||
            !isset($supervisor["consecutivoId"]) || $supervisor["consecutivoId"] == "" ||
            !isset($supervisor["tipoId"]) || $supervisor["tipoId"] == "") {
            $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "No se proporcionaron todos los datos necesarios para el registro de asistencia";
    }

        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
    if (!$errorValidacion) {
        $fecha = date_parse($asistenciaFecha);

        if (!empty($fecha["errors"])) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
        }

        if (!$errorValidacion) {
            $fechaVerificada = $fecha["year"] . "-" . str_pad($fecha["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($fecha["day"], 2, "0", STR_PAD_LEFT);

            if ($fechaVerificada != $asistenciaFecha) {
                $errorValidacion   = true;
                $result["status"]  = "error";
                $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
            }
        }
    }

        // La fecha de asistencia debe estar dentro del periodo quincenal

        // Qué el empleado exista en el sistema
    if (!$errorValidacion) {
        $empleadoObtenido = $this->negocio_obtenerEmpleadoPorId(
            $empleado["entidadId"],
            $empleado["consecutivoId"],
            $empleado["tipoId"],$usuario);

        if ($empleadoObtenido == null) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "El empleado no existe";
        }
    }

        // Qué el supervisor exista en el sistema
    if (!$errorValidacion) {
        $supervisorObtenido = $this->negocio_obtenerEmpleadoPorId(
            $supervisor["entidadId"],
            $supervisor["consecutivoId"],
            $supervisor["tipoId"],$usuario);

        if ($supervisorObtenido == null) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "El supervisor no existe";
        }
    }

        // Qué no se haya registrado previamente la asistencia        //

    if (!$errorValidacion) {
        $registrado = $this->persistencia->updateAsistencia(
            $empleado,
            $supervisor,
            $incidenciaId,
            $asistenciaFecha,
            $usuarioCapturaAsistencia,
            $comentarioIncidencia, $tipoPeriodo, $plantilladeservicio,0);

        if ($registrado == true) {
            if ($incidenciaId == 10) {
                $registrado = $this->persistencia->updateEstatusEmpleadoOperaciones($empleado, 3, $asistenciaFecha);

                if ($registrado == true) {
                    $result["status"]  = "success";
                    $result["message"] = "";
                }

            } else {
                $result["status"]  = "success";
                $result["message"] = "";
            }

        } else {
            $result["status"]  = "error";
            $result["message"] = "No se pudo editar la asistencia en la base de datos.";
        }
    }

    return $result;
}

public function getListaEmpleadosBySupervisorPeriodoEmpleadoId($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId, $empleado)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getListaEmpleadosBySupervisorPeriodoEmpleadoId($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId, $empleado);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}
public function getEmpleadosEstatusOperaciones($estatusEmpleadoOperaciones,$usuario)
{

        //$log = new KLogger ( "getEmpleadosEstatusOperaciones.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getEmpleadosEstatusOperaciones($estatusEmpleadoOperaciones,$usuario);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}

public function updateEstatusEmpleadoOperaciones($empleado, $estatusId, $asistenciaFecha)
{

    $this->persistencia->updateEstatusEmpleadoOperaciones($empleado, $estatusId, $asistenciaFecha);
}

public function updateEstatusEmpleadoOperacionesActivo($empleado, $estatusId)
{

    $this->persistencia->updateEstatusEmpleadoOperacionesActivo($empleado, $estatusId);
}

public function deleteAsistenciaFromAsistencia($incidencia)
{

        //$log = new KLogger ( "negocio_deleteAsistenciaFromAsistencia.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la  \$result : " . var_export ($incidencia, true));

    $result = array();

    $registrado = $this->persistencia->deleteAsistenciaFromAsistencia($incidencia);

        //$log->LogInfo("Valor de la  \$registrado : " . var_export ($registrado, true));

    if ($registrado == true) {

        $registrado = $this->persistencia->deleteIncidenciasEspecialesByEmpleadoAndFecha($incidencia);

        if ($registrado == true) {

            $result["status"]  = "success";
            $result["message"] = "";

        }

    } else {
        $result["status"]  = "error";
        $result["message"] = "No se pudo editar la asistencia en la base de datos.";
    }
        //$log->LogInfo("Valor de la  \$result : " . var_export ($result, true));
    return $result;
}

public function registrarIncidenciaEspecial(
    $empleado,
    $supervisor,
    $incidenciaId,
    $asistenciaFecha,
    $usuarioCapturaAsistencia,
    $comentariIncidencia, $tipoPeriodo,
    $incidenciaPuesto, $plantilladeservicio,$idPlantillaServicio,$selectMotivoIncidenciaEspecial) {

        //$log = new KLogger ( "negocio_registrarIncidenciaEspecial.log" , KLogger::DEBUG );

    $result          = array();
    $errorValidacion = false;
    $usuario["rol"]="";

        // Se deben realizar las siguientes validaciones:
        // Todos los datos de entrada son obligatorios.
        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
        // La fecha de asistencia debe estar dentro del periodo quincenal
        // Qué el empleado exista en el sistema
        // Qué el supervisor exista en el sistema
        // Qué no se haya registrado previamente la asistencia

        // Todos los datos de entrada son obligatorios
    if (empty($empleado) ||
        empty($supervisor) ||
        $incidenciaId == "" ||
        $asistenciaFecha == "" ||
        $usuarioCapturaAsistencia == "" ||
        $tipoPeriodo == "" ||
        $incidenciaPuesto == "" ||
        $incidenciaPuesto == "PUESTO" ||
        $plantilladeservicio == "0" || $plantilladeservicio == "PLANTILLA" ||
        !isset($empleado["entidadId"]) || $empleado["entidadId"] == "" ||
        !isset($empleado["consecutivoId"]) || $empleado["consecutivoId"] == "" ||
        !isset($empleado["tipoId"]) || $empleado["tipoId"] == "" ||
        !isset($empleado["puntoServicioId"]) || $empleado["puntoServicioId"] == "" ||
        !isset($supervisor["entidadId"]) || $supervisor["entidadId"] == "" ||
        !isset($supervisor["consecutivoId"]) || $supervisor["consecutivoId"] == "" ||
        !isset($supervisor["tipoId"]) || $supervisor["tipoId"] == "") {
        $errorValidacion   = true;
    $result["status"]  = "error";
    $result["message"] = "No se proporcionaron todos los datos necesarios para el registro de asistencia";
}

        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
if (!$errorValidacion) {
    $fecha = date_parse($asistenciaFecha);

    if (!empty($fecha["errors"])) {
        $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
    }

    if (!$errorValidacion) {
        $fechaVerificada = $fecha["year"] . "-" . str_pad($fecha["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($fecha["day"], 2, "0", STR_PAD_LEFT);

        if ($fechaVerificada != $asistenciaFecha) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
        }
    }
}

        // La fecha de asistencia debe estar dentro del periodo quincenal

        // Qué el empleado exista en el sistema
if (!$errorValidacion) {
    $empleadoObtenido = $this->negocio_obtenerEmpleadoPorId(
        $empleado["entidadId"],
        $empleado["consecutivoId"],
        $empleado["tipoId"],$usuario);

    if ($empleadoObtenido == null) {
        $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "El empleado no existe";
    }
}

        // Qué el supervisor exista en el sistema
if (!$errorValidacion) {
    $supervisorObtenido = $this->negocio_obtenerEmpleadoPorId(
        $supervisor["entidadId"],
        $supervisor["consecutivoId"],
        $supervisor["tipoId"],$usuario);

    if ($supervisorObtenido == null) {
        $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "El supervisor no existe";
    }
}

        // Qué no se haya registrado previamente la asistencia        //

if (!$errorValidacion) {

    $registro = $registrado = $this->persistencia->registrarIncidenciaEspecial(
        $empleado,
        $supervisor,
        $incidenciaId,
        $asistenciaFecha,
        $usuarioCapturaAsistencia,
        $comentariIncidencia, $tipoPeriodo, $incidenciaPuesto, $plantilladeservicio,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);

    if ($registro == true) {
        $result["status"]  = "success";
        $result["message"] = "";
    }

}

        //$log->LogInfo("Valor de la  \$result : " . var_export ($result, true));

return $result;
}

public function getCatalogoIncidenciasEspeciales()
{

        //$log = new KLogger ( "negocio_getCatalogoIncidencias.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getCatalogoIncidenciasEspeciales();

    return $lista;
}

public function getTurnosCubiertosByPeriodoFechasAndPuntoServicio(
    $fechaInicial,
    $fechaFinal,
    $puntoServicioId) {
    return $this->persistencia->getTurnosCubiertosByPeriodoFechasAndPuntoServicio($fechaInicial, $fechaFinal, $puntoServicioId);
}

public function getSumaTurnosExtras($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{

        //$log = new KLogger ( "negocio_getSumaTurnosExtras.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

    $lista = array();

    $lista = $this->persistencia->getSumaTurnosExtras($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getSumaDiasFestivos($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{

        //$log = new KLogger ( "negocio_getSumaTurnosExtras.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

    $lista = array();

    $lista = $this->persistencia->getSumaDiasFestivos($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getSumaDiasFestivosFatiga($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio)
{

        //$log = new KLogger ( "negocio_getSumaTurnosExtras.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

    $lista = array();

    $lista = $this->persistencia->getSumaDiasFestivosFatiga($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getSumDescuentos($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{

    $lista = array();

    $lista = $this->persistencia->getSumDescuentos($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);

    return $lista;

}

public function getSumaIncidenciasEspeciales($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{

    $lista = array();

    $lista = $this->persistencia->getSumaIncidenciasEspeciales($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);

    return $lista;

}

public function getTurnosExtras($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{

    $lista = array();

    $lista = $this->persistencia->getTurnosExtras($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);

    return $lista;

}

public function getDescuentos($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{

    $lista = array();

    $lista = $this->persistencia->getDescuentos($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);

    return $lista;

}

public function getIncidenciasEspeciales($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{

        //$log = new KLogger ( "negocio_getDescuentos.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        // $log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

    $lista = array();

    $lista = $this->persistencia->getIncidenciasEspeciales($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getListaEmpleadosPeriodoEmpleadoId($fecha1, $fecha2, $periodoId, $empleado)
{

    $lista = array();
    $lista = $this->persistencia->getListaEmpleadosPeriodoEmpleadoId($fecha1, $fecha2, $periodoId, $empleado);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getListaEmpleadosByPeriodoNombre($fecha1, $fecha2, $periodoId, $nombre)
{

    $lista = array();
    $lista = $this->persistencia->getListaEmpleadosByPeriodoNombre($fecha1, $fecha2, $periodoId, $nombre);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function traerCatalogoPuntosServiciosActivos()
{
        // $log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

    $lista = $this->persistencia->traerCatalogoPuntosServiciosActivos();
        //$log -> LogInfo ("$lista". var_export($lista,true));
    return $lista;

}

public function getListaGeneralEmpleadosBySupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId)
{
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

    $lista = $this->persistencia->getListaGeneralEmpleadosBySupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $periodoId);
        //$log -> LogInfo ("$lista". var_export($lista,true));
    return $lista;

}

public function getListaGeneralEmpleados($fecha1, $fecha2, $periodoId,$tipopuesto)
{
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

    $lista = $this->persistencia->getListaGeneralEmpleados($fecha1, $fecha2, $periodoId,$tipopuesto);
        //$log -> LogInfo ("$lista". var_export($lista,true));
    return $lista;

}

public function getEmpleadosByRangoFechaSupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoIdddd.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getEmpleadosByRangoFechaSupervisor($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo);
    return $lista;
        // $log->LogInfo("Valor de la  \$lista : " . var_export ($fecha1, true));

}

public function getEmpleadosByRangoFecha($fecha1, $fecha2)
{

        //$log = new KLogger ( "gggggggggggggggg.log" , KLogger::DEBUG );
        // $log->LogInfo("Valor de la  \$lista : " . var_export ($fecha1, true));

    $lista = array();

    $lista = $this->persistencia->getEmpleadosByRangoFecha($fecha1, $fecha2);
    return $lista;

}

public function getListaEmpleadosBySupervisorPuntoServicioRangoFecha($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $puntoServicio)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getListaEmpleadosBySupervisorPuntoServicioRangoFecha($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $puntoServicio);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}
public function getListaEmpleadosPuntoServicioRangoFecha($fecha1, $fecha2, $puntoServicio)
{

        // $log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getListaEmpleadosPuntoServicioRangoFecha($fecha1, $fecha2, $puntoServicio);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}

public function getEmpleadoByIdSupervisorRangoFecha($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $empleado)
{
        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getEmpleadoByIdSupervisorRangoFecha($fecha1, $fecha2, $supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $empleado);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}

public function getEmpleadoByIdRangoFecha($fecha1, $fecha2, $empleado)
{

    $log = new KLogger("getListaEmpleadosBySupervisorPeriodoId.log", KLogger::DEBUG);
    $log->LogInfo("Valor de la  \$lista : " . var_export($fecha1, true));

    $lista = array();

    $lista = $this->persistencia->getEmpleadoByIdRangoFecha($fecha1, $fecha2, $empleado);
    return $lista;

}

public function getEmpleadoForFatiga($fecha1, $fecha2, $puntoservicio)
{

    $lista = array();
    $lista = $this->persistencia->getEmpleadoForFatiga($fecha1, $fecha2, $puntoservicio);

    return $lista;

}

public function getAsistenciaByEmpleadoPuntoServicioFatiga($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio)
{

    $lista = array();

    $lista = $this->persistencia->getAsistenciaByEmpleadoPuntoServicioFatiga($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio);
    return $lista;

}

public function getTurnosExtrasFatiga($fecha1, $fecha2, $puntoservicio)
{

    $lista = array();

    $lista = $this->persistencia->getTurnosExtrasFatiga($fecha1, $fecha2, $puntoservicio);

    return $lista;

}

public function getIncrementosPlantillaFatiga($fecha1, $fecha2, $puntoservicio)
{

    $lista = array();

    $lista = $this->persistencia->getIncrementosPlantillaFatiga($fecha1, $fecha2, $puntoservicio);

    return $lista;

}

public function getPlantillasByPuntoServiciosClienteNamePoint($idCliente, $puntoservicio)
{

    $lista = array();

    if ($idCliente == "" || $idCliente == "CLIENTES") {

        $lista = $this->persistencia->getPlantillasByPuntoServiciosNamePoint($puntoservicio);

    } else {

        $lista = $this->persistencia->getPlantillasByPuntoServiciosClienteNamePoint($idCliente, $puntoservicio);

    }

    return $lista;

}
public function getRequisicionesFromVentas($tipoBusquedaPlantilla)
{
    $lista = array();
    $lista = $this->persistencia->getRequisicionesFromVentas($tipoBusquedaPlantilla);
    return $lista;
}
public function getPuntosServicios($fecha1, $fecha2)
{

    $lista = array();

    $lista = $this->persistencia->getPuntosServicios($fecha1, $fecha2);

    return $lista;

}

public function getDetallesRequisiciones($puntoServicioId, $fecha1, $fecha2)
{

        //$log = new KLogger ( "negocio_getDetallesRequisiciones.log" , KLogger::DEBUG );

        //$lista = array ();
    $response = array();

    $lista = $this->persistencia->getDetallesRequisiciones($puntoServicioId, $fecha1, $fecha2);

        //$log -> LogInfo ("negocio_getDetallesRequisiciones". var_export($lista,true));

    for ($i = 0; $i < count($lista); $i++) {

        $puestoId = $lista[$i]["puestoPlantillaId"];

            //$log -> LogInfo ("puestoId:". var_export($puestoId,true));

        $lista[$i]["turnosCubiertos"] = $this->persistencia->getTurnosCubiertosRequisicion($fecha1, $fecha2, $puntoServicioId, $puestoId);

    }

    $response["detalles"] = $lista;

        //$log -> LogInfo ("response:". var_export($response,true));

    return $response;

}

public function deletePuntoServicioSupervisor($supervisor)
{

        //$log = new KLogger ( "negocio_deletePuntoServicioSupervisor.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la  \$result : " . var_export ($supervisor, true));

        //$result = array ();

    $registrado = $this->persistencia->deletePuntoServicioSupervisor($supervisor);

        //$log->LogInfo("Valor de la  \$registrado : " . var_export ($registrado, true));

    if ($registrado == true) {

        return true;

    } else {

        return false;
    }

}

public function getPuntosServiciosSupervisorByNamePunto($entidadSupervisor, $consecutivoSupervisor, $tipoSupervisor, $nombre)
{

    $lista = array();

    $lista = $this->persistencia->getPuntosServiciosSupervisorByNamePunto($entidadSupervisor, $consecutivoSupervisor, $tipoSupervisor, $nombre);

    return $lista;

}

public function getPuntosServiciosByNamePunto($nombre)
{

    $lista = array();

    $lista = $this->persistencia->getPuntosServiciosByNamePunto($nombre);

    return $lista;

}

public function asignacionPuntoServicioASupervisor($datos)
{
        //$log = new KLogger ( "negocioregistroSaldoInicial.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$saldo: " . var_export ($saldo, true));
    $this->persistencia->asignacionPuntoServicioASupervisor($datos);
}

public function getDetalleAsistencia($fecha1, $fecha2,$usuario)
{

    $lista = array();

    $lista = $this->persistencia->getDetalleAsistencia($fecha1, $fecha2,$usuario);

    return $lista;

}

public function getDetalleIncidenciasEspeciales($fecha1, $fecha2,$usuario)
{

    $lista = array();

    $lista = $this->persistencia->getDetalleIncidenciasEspeciales($fecha1, $fecha2,$usuario);

    return $lista;

}
public function getSupervisoresForTransferencia()
{

    $lista = array();

    $lista = $this->persistencia->getSupervisoresForTransferencia();

    return $lista;

}

public function actualizarSupervisor($supervisor1, $supervisor2)
{
    $this->persistencia->actualizarSupervisor($supervisor1, $supervisor2);
}

public function updateEstatusRequisicionesByPunto($puntoSerivicioId, $estatus,$MotivoBaja,$fechaTerminoServicio,$usuario)
{
    $this->persistencia->updateEstatusRequisicionesByPunto($puntoSerivicioId, $estatus,$MotivoBaja,$fechaTerminoServicio,$usuario);
}

public function getPuntosByFechaVencimiento()
{
    $lista = array();
    $lista = $this->persistencia->getPuntosByFechaVencimiento();
    return $lista;
}
public function actualizarDatosPuntoServicioByCampo($campo, $valor, $idPuntoServicio)
{

        //$log = new KLogger ( "negocio_actualizarDatosPuntoServicioByCampo.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$campo : " . var_export ($campo, true));
        //$log->LogInfo("Valor de la variable \$valor : " . var_export ($valor, true));
        //$log->LogInfo("Valor de la variable \$idPuntoServicio : " . var_export ($idPuntoServicio, true));

    if ($campo == "fechaTerminoServicio") {

        $fecha = date_parse($valor);

        $fechaVerificada = $fecha["year"] . "-" . str_pad($fecha["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($fecha["day"], 2, "0", STR_PAD_LEFT);

        if ($fechaVerificada != $valor) {
            throw new Exception("Fecha inválido");
        }

    }

    $this->persistencia->actualizarDatosPuntoServicioByCampo($campo, $valor, $idPuntoServicio);
}

public function updateFechaTerminoRequisiciones($idPuntoServicio, $fechaVencida, $nuevaFecha)
{

    $this->persistencia->updateFechaTerminoRequisiciones($idPuntoServicio, $fechaVencida, $nuevaFecha);
}

public function getRequisicionesByFechaVencimiento($lineanegociooact11,$lineanegociooact22)
{

    $lista = array();

    $lista = $this->persistencia->getRequisicionesByFechaVencimiento($lineanegociooact11,$lineanegociooact22);

    return $lista;

}

public function actualizarDatosRequisicionByCampo($campo, $valor, $servicioPlantillaId, $fechaTerminoServicio)
{

    if ($campo == "fechaTerminoPlantilla") {

        $fecha = date_parse($valor);

        $fechaVerificada = $fecha["year"] . "-" . str_pad($fecha["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($fecha["day"], 2, "0", STR_PAD_LEFT);

        if ($fechaVerificada != $valor) {
            throw new Exception("Fecha inválido");
        }

        if ($fecha > date_parse($fechaTerminoServicio)) {

            throw new Exception("Fecha de termino de requisicion no puede ser mayor a la fecha de termino de punto de servicio, Vaya a la edición del punto de servicio");

        }

    }

    $this->persistencia->actualizarDatosRequisicionByCampo($campo, $valor, $servicioPlantillaId);
}

public function getPuntosServiciosByClienteId($fecha1, $fecha2, $idClientePunto)//, $LineaNegocioRF
{

        //$log = new KLogger ( "negocio_getPuntosServiciosByClienteId.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getPuntosServiciosByClienteId($fecha1, $fecha2, $idClientePunto);//, $LineaNegocioRF

        //$log->LogInfo("Valor de la variable \$lista : " . var_export ($lista, true));

    return $lista;

}

public function getTurnosCubiertosByPlantilla($fecha1, $fecha2, $servicioPlantillaId, $incidenciaPuntoServicio)
{

        //$log = new KLogger ( "negocio_getTurnosCubiertosByPlantilla.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$servicioPlantillaId : " . var_export ($servicioPlantillaId, true));
        //$log->LogInfo("Valor de la  \$incidenciaPuntoServicio : " . var_export ($incidenciaPuntoServicio, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

    $lista = array();

    $lista = $this->persistencia->getTurnosCubiertosByPlantilla($fecha1, $fecha2, $servicioPlantillaId, $incidenciaPuntoServicio);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}
public function getTurnosPagados($fecha1, $fecha2, $idPuntoServicio)
{

        //$log = new KLogger ( "negocio_getSumaTurnosExtras.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

    $lista = array();

    $lista = $this->persistencia->getTurnosPagados($fecha1, $fecha2, $idPuntoServicio);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getAsistenciaByFechaAndPuntoServicio($fecha1, $fecha2, $puntoServicioId)
{

    $lista = array();

    $lista = $this->persistencia->getAsistenciaByFechaAndPuntoServicio($fecha1, $fecha2, $puntoServicioId);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getSumaDiasFestivosByFechaAndPuntoServicio($fecha1, $fecha2, $puntoServicioId)
{

    $lista = array();

    $lista = $this->persistencia->getSumaDiasFestivosByFechaAndPuntoServicio($fecha1, $fecha2, $puntoServicioId);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getTurnosCubiertosByPerfil($fecha1, $fecha2, $puntoServicioId, $puestoId, $rolOperativo)
{

    $lista = array();

    $lista = $this->persistencia->getTurnosCubiertosByPerfil($fecha1, $fecha2, $puntoServicioId, $puestoId, $rolOperativo);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getPuntosServiciosForFatigaForSupervisor($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $fecha1, $fecha2)
{
    $lista = array();

    $lista = $this->persistencia->getPuntosServiciosForFatigaForSupervisor($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $fecha1, $fecha2);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function getPuntosForFatigaByEntidad($idEntidad, $fecha1, $fecha2)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $listaPuntos = array();
    $listaPuntos = $this->persistencia->getPuntosForFatigaByEntidad($idEntidad, $fecha1, $fecha2);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $listaPuntos;
}

public function registroEnvioFatiga($puntoServicioFatigaId, $fechaFatiga1, $fechaFatiga2, $quincenaFatigaId, $usuarioEnvioFatiga)
{
        //$log = new KLogger ( "negocio_registrarAsistencia.log" , KLogger::DEBUG );

    $result = array();

    $registro = $this->persistencia->registroEnvioFatiga($puntoServicioFatigaId, $fechaFatiga1, $fechaFatiga2, $quincenaFatigaId, $usuarioEnvioFatiga);
    if ($registro == true) {
        $result["status"]  = "success";
        $result["message"] = "";
    } else {

        $result["status"]  = "error";
        $result["message"] = "Error en el proceso de envio de fatiga";

    }

    return $result;
}

public function getPuntosServiciosAndResponsables($fecha1, $fecha2)
{

    $lista = array();

    $lista = $this->persistencia->getPuntosServiciosAndResponsables($fecha1, $fecha2);

    return $lista;

}

public function getFatigasEnviadas($puntoServicioFatigaId, $month, $year, $quincena)
{

    $lista = array();

    $lista = $this->persistencia->getFatigasEnviadas($puntoServicioFatigaId, $month, $year, $quincena);
    return $lista;

}
public function getRolesUsuario()
{

    $lista = array();

    $lista = $this->persistencia->getRolesUsuario();
    return $lista;

}

public function newUser($datos)
{
        //$log = new KLogger ( "newUser.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$datos : " . var_export ($datos, true));
 $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

 if ($datos["entidadEmpleadoUsuario"] == "" || $datos["consecutivoEmpleadoUsuario"] == "" || $datos["categoriaEmpleadoUsuario"] == "") {
    throw new Exception("Proporcione número de empleado");
}

if ($datos["apellidoPaterno"] == "" || $datos["apellidoMaterno"] == "" || $datos["nombre"] == "") {
    throw new Exception("Proporcione nombre del nuevo usuario");
}

if ($datos["largotbl"] ==0) {
    throw new Exception("Agregue una Entidad Federativa");
}
if ($datos["largotbllineanegocio"] ==0) {
    throw new Exception("Agregue una Linea de negocio");
}
if ($datos["usuarioRolId"] == "" || $datos["usuarioRolId"] == "Rol") {
    throw new Exception("Seleccione rol de usuario");
}
if ($datos["correoElectronico"] != "") {
    if (preg_match($patronCorreo, $datos["correoElectronico"]) == false) {
        throw new Exception("El formato de correo electrónico es incorrecto");
    }
}
if ($datos["usuario"] == "") {
    throw new Exception("Proporcione un usuario para login");
}
if (strlen($datos["usuario"]) > 10) {
    throw new Exception("El nombre de usuario rebasa el largo permitido (10 caracteres máximo) ");
}

if ($datos["contrasenia"] == "" || $datos["contrasenia2"] == "") {
    throw new Exception("Proporcione contraseña de la cuenta");
}
if ($datos["contrasenia"] != $datos["contrasenia2"]) {
    throw new Exception("Las contraseñas no coinciden");
}

$this->persistencia->newUser($datos);
}

public function asignacionEmpleadoSupervisor($datos)
{

    $this->persistencia->asignacionEmpleadoSupervisor($datos);
}

public function getUsuariosByName($nombre)
{

    $lista = array();

    $lista = $this->persistencia->getUsuariosByName($nombre);
    return $lista;

}
public function bloqueoUsuario($usuarioId)
{

    $this->persistencia->bloqueoUsuario($usuarioId);
}

public function getTabuladorSueldos()
{
    $lista = array();
    $lista = $this->persistencia->getTabuladorSueldos();
    return $lista;
}

public function getDatosTabuladdorByPuntoPuestoRol($datos)
{

    $result = $this->persistencia->getDatosTabuladdorByPuntoPuestoRol($datos);

    return $result;

}

public function insertSueldoAndCuota($datos)
{
        //$log = new KLogger ( "negocio_insertSueldoAndCuota.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$datos : " . var_export ($datos, true));
        //$valor=is_numeric($datos["sueldo"]);
        //$log->LogInfo("Valor de la variable \$valor : " . var_export ($valor, true));

    if (is_numeric($datos["sueldo"]) == false) {
        throw new Exception("Ingrese sueldo correctamente (No se permiten letras)");
    }

    if ($datos["sueldo"] == 0 || $datos["sueldo"] == "") {
        throw new Exception("El valor para el sueldo no puede ser 0");
    }

    $this->persistencia->insertSueldoAndCuota($datos);
}

public function updateSueldoAndCuota($datos)
{

    if (is_numeric($datos["sueldo"]) == false) {
        throw new Exception("Ingrese sueldo correctamente (No se permiten letras)");
    }
    if ($datos["sueldo"] == 0 || $datos["sueldo"] == "") {
        throw new Exception("El valor para el sueldo no puede ser 0");
    }

    $this->persistencia->updateSueldoAndCuota($datos);
}

public function getCuotaDiariaByPerfil($datos)
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

    $cuotaDiaria = "";
    $cuotaDiaria = $this->persistencia->getCuotaDiariaByPerfil($datos);
        //$log -> LogInfo ("negocio_obtenerUltimoNumeroOrden". var_export($ultimoNumeroOrden,true));
    return $cuotaDiaria;

}

public function insertSueldoEmpleado($datos)
{

    $this->persistencia->insertSueldoEmpleado($datos);
}
public function getSueldosEmpleados()
{

    $lista = array();

    $lista = $this->persistencia->getSueldosEmpleados();
    return $lista;

}
public function updateSueldoEmpleado($datos)
{

    if (is_numeric($datos["sueldoEmpleado"]) == false) {
        throw new Exception("Ingrese sueldo correctamente (No se permiten letras)");
    }
    if ($datos["sueldoEmpleado"] == 0 || $datos["sueldoEmpleado"] == "") {
        throw new Exception("El valor para el sueldo no puede ser 0");
    }

    if (is_numeric($datos["bonoAsistenciaEmpleado"]) == false) {
        throw new Exception("Ingrese el monto del bono correctamente (No se permiten letras)");
    }

    if (is_numeric($datos["bonoPuntualidadEmpleado"]) == false) {
        throw new Exception("Ingrese sueldo correctamente (No se permiten letras)");
    }

    $this->persistencia->updateSueldoEmpleado($datos);
}

public function verificarSueldoEmpleado($datos)
{

    $result = $this->persistencia->verificarSueldoEmpleado($datos);

    return $result;

}

public function getTabuladorSueldosByPuntoServicio($puntoServicioName)
{

    $lista = array();

    $lista = $this->persistencia->getTabuladorSueldosByPuntoServicio($puntoServicioName);
    return $lista;

}

public function getCoberturaRangoFecha($fecha1, $fecha2)
{

    $lista = array();

    $lista = $this->persistencia->getCoberturaRangoFecha($fecha1, $fecha2);
    return $lista;

}
public function getCostoTurnoByPuntoIdAndPuestoId($puntoServicioAsistenciaId, $puestoCubiertoId)
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

    $cuotaDiaria = "";
    $cuotaDiaria = $this->persistencia->getCostoTurnoByPuntoIdAndPuestoId($puntoServicioAsistenciaId, $puestoCubiertoId);
        //$log -> LogInfo ("negocio_obtenerUltimoNumeroOrden". var_export($ultimoNumeroOrden,true));
    return $cuotaDiaria;

}
public function getEntidadesCobertura($month, $year)
{

    $lista = array();

    $lista = $this->persistencia->getEntidadesCobertura($month, $year);
    return $lista;

}
public function getClientesCoberturaByEntidad($month, $year, $entidad)
{

    $lista = array();

    $lista = $this->persistencia->getClientesCoberturaByEntidad($month, $year, $entidad);
    return $lista;

}
public function getPuntosCoberturaByCliente($month, $year, $idCliente, $idEntidadFederativa)
{

    $lista = array();

    $lista = $this->persistencia->getPuntosCoberturaByCliente($month, $year, $idCliente, $idEntidadFederativa);
    return $lista;

}
public function getPuestosCoberturaByPunto($month, $year, $idPuntoServicio)
{

    $lista = array();

    $lista = $this->persistencia->getPuestosCoberturaByPunto($month, $year, $idPuntoServicio);
    return $lista;

}
public function getDetallesRequisicionByPuntoServicioIdAndPuesto($puntoServicioId, $puestoId, $fecha1, $fecha2)
{

    $lista = array();

    $lista = $this->persistencia->getDetallesRequisicionByPuntoServicioIdAndPuesto($puntoServicioId, $puestoId, $fecha1, $fecha2);
    return $lista;

}

public function getTurnosPagadosNomina($puntoServicioId, $puestoId, $fecha1, $fecha2)
{
        //$log= new KLogger("negocioUltimoFolioBaja.log", KLogger::DEBUG);

    $turnosPagadosNomina = "";
    $turnosPagadosNomina = $this->persistencia->getTurnosPagadosNomina($puntoServicioId, $puestoId, $fecha1, $fecha2);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
    return $turnosPagadosNomina;

}

public function registroNomina($datos)
{
        $log = new KLogger ( "negocio_registrarAsistencia1233333.log" , KLogger::DEBUG );

    $result          = array();
    $errorValidacion = false;
$log->LogInfo("Valor de la variable datos : " . var_export ($datos, true));
    if (empty($datos)) {
        $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "No se proporcionaron todos los datos necesarios para el registro de nomina";
    }

    if (!$errorValidacion) {

        $registrado = $this->persistencia->registroNomina($datos);

            $log->LogInfo("Valor de la variable \$registrado : " . var_export ($registrado, true));

        if ($registrado == true) {

            $result["status"]  = "success";
            $result["message"] = "";
        }

    }
        $log->LogInfo("Valor de la variable \$result : " . var_export ($result, true));

    return $result;
}
public function getMontoPagadoByPuntoPuestoFecha($puntoServicioId, $puestoId, $fecha1, $fecha2)
{
        //$log= new KLogger("negocioUltimoFolioBaja.log", KLogger::DEBUG);

    $montoPagado = "";
    $montoPagado = $this->persistencia->getMontoPagadoByPuntoPuestoFecha($puntoServicioId, $puestoId, $fecha1, $fecha2);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
    return $montoPagado;

}
public function getEmpleadoByCorreo($correo)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista        = array();
    $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

    if ($correo != "") {
        if (preg_match($patronCorreo, $correo) == false) {
            throw new Exception("El formato de correo electrónico es inválido.");
        }
    }

    if ($correo == "") {

        throw new Exception("Para consultar asistencia debe ingresar el correo electrónico proporcionado en su contratación.");

    }

    $lista = $this->persistencia->getEmpleadoByCorreo($correo);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}
public function getAsistenciaByEmpleadoIdPeriodo($fecha1, $fecha2, $empleadoId)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();

    $date1            = date_parse($fecha1);
    $date2            = date_parse($fecha2);
    $fechaVerificada  = $date1["year"] . "-" . str_pad($date1["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($date1["day"], 2, "0", STR_PAD_LEFT);
    $fechaVerificada2 = $date2["year"] . "-" . str_pad($date2["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($date2["day"], 2, "0", STR_PAD_LEFT);

    if ($empleadoId == "") {
        throw new Exception("Para consultar asistencia debe ingresar el correo electrónico proporcionado en su contratación.");

    }
    if ($fechaVerificada != $fecha1) {
        throw new Exception("La fecha de consulta de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd");

    }

    if ($fechaVerificada2 != $fecha2) {
        throw new Exception("La fecha de consulta de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd");

    }

    $lista = $this->persistencia->getAsistenciaByEmpleadoIdPeriodo($fecha1, $fecha2, $empleadoId);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}

public function insertComentarioGuardia($datosComentario)

{
    $usuario["rol"]="";
    $empleadoObtenido = $this->negocio_obtenerEmpleadoPorId(
        $datosComentario["entidadGuardiaComentario"],
        $datosComentario["consecutivoGuardiaComentario"],
        $datosComentario["categoriaGuardiaComentario"],$usuario);

    if ($empleadoObtenido == null) {
        throw new Exception("El número de empleado no existe en la base de datos.");
    }

    if ($datosComentario["comentario"] == "") {
        throw new Exception("Comentario inválido");
    }
    $this->persistencia->insertComentarioGuardia($datosComentario);

}

public function getComentariosGuardiasByPeriodo($fecha1, $fecha2)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->getComentariosGuardiasByPeriodo($fecha1, $fecha2);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}
public function getComentariosGuardiasByDay($fecha1)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->getComentariosGuardiasByDay($fecha1);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}
public function getEstatusFatiga()
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->getEstatusFatiga();
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}
public function registroRecepcionFatiga(
    $puntoServicioFatigaId,
    $fechaFatiga1,
    $fechaFatiga2,
    $quincenaFatigaId,
    $fechaFatigaRecibida,
    $usuarioRegistroRecepcion
) {

    $this->persistencia->registroRecepcionFatiga(
        $puntoServicioFatigaId,
        $fechaFatiga1,
        $fechaFatiga2,
        $quincenaFatigaId,
        $fechaFatigaRecibida,
        $usuarioRegistroRecepcion
    );

}
public function actualizarEstatusFatiga($estatusFatiga, $fechaFatigaFacturada, $usuarioRegistroFacturacion, $puntoServicioFatigaId, $fecha1, $fecha2)
{

    $this->persistencia->actualizarEstatusFatiga($estatusFatiga, $fechaFatigaFacturada, $usuarioRegistroFacturacion, $puntoServicioFatigaId, $fecha1, $fecha2);

}
public function registroFacturacionFatiga($puntoServicioFatigaId, $fechaFatiga1, $fechaFatiga2, $quincenaFatigaId, $fechaFatigaFacturada, $usuarioRegistroFacturacion)
{

    $this->persistencia->registroFacturacionFatiga($puntoServicioFatigaId, $fechaFatiga1, $fechaFatiga2, $quincenaFatigaId, $fechaFatigaFacturada, $usuarioRegistroFacturacion);

}
public function registroContrarecibo($puntoServicioFatigaId, $fechaFatiga1, $fechaFatiga2, $quincenaFatigaId, $fechaContrarecibo, $usuarioRegistroContrarecibo)
{

    $this->persistencia->registroContrarecibo($puntoServicioFatigaId, $fechaFatiga1, $fechaFatiga2, $quincenaFatigaId, $fechaContrarecibo, $usuarioRegistroContrarecibo);

}
public function actualizarEstatusFatigaContrarecibo($estatusFatiga, $fechaContrarecibo, $usuarioRegistroContrarecibo, $puntoServicioFatigaId, $fecha1, $fecha2)
{

    $this->persistencia->actualizarEstatusFatigaContrarecibo($estatusFatiga, $fechaContrarecibo, $usuarioRegistroContrarecibo, $puntoServicioFatigaId, $fecha1, $fecha2);

}
public function registroUbicacion($datosUbicacion)
{

    $this->persistencia->registroUbicacion($datosUbicacion);

}

public function getUbicacionesGuardiaByFecha($fecha1, $idGuardia)
{

        //$log = new KLogger ( "negocio_obtenerCatalogoPuestoPorTipoPuesto.log" , KLogger::DEBUG );

        //$log -> LogInfo ("UsuarioCuenta: " . $tipoPuesto);
        //$log -> LogInfo ("UsuarioPassword: " . $tipoPuesto);
    $ubicaciones = array();

    $ubicaciones = $this->persistencia->getUbicacionesGuardiaByFecha($fecha1, $idGuardia);

    return $ubicaciones;
}
public function consultarEmpleadoById($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

    $empleado = array();
    $empleado = $this->persistencia->consultarEmpleadoById($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
    return $empleado;
}

public function newUserEmpleado($datos)
{
        //$log = new KLogger ( "newUser.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$datos : " . var_export ($datos, true));
    $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

    if ($datos["entidadEmpleadoUsuario"] == "" || $datos["consecutivoEmpleadoUsuario"] == "" || $datos["categoriaEmpleadoUsuario"] == "") {
        throw new Exception("Proporcione número de empleado");
    }

    if ($datos["apellidoPaterno"] == "" || $datos["nombre"] == "") {
        throw new Exception("Proporcione nombre del nuevo usuario");
    }

    if ($datos["entidadFederativaUsuario"] == "" || $datos["entidadFederativaUsuario"] == "ENTIDAD") {
        throw new Exception("Seleccione Entidad Federativa");
    }

    if ($datos["usuarioRolId"] == "" || $datos["usuarioRolId"] == "ROL") {
        throw new Exception("Seleccione rol de usuario");
    }
    if ($datos["correoElectronico"] != "") {
        if (preg_match($patronCorreo, $datos["correoElectronico"]) == false) {
            throw new Exception("El formato de correo electrónico es incorrecto");
        }
    }

    if ($datos["contrasenia"] == "" || $datos["contrasenia2"] == "") {
        throw new Exception("Proporcione contraseña de la cuenta");
    }
    if ($datos["contrasenia"] != $datos["contrasenia2"]) {
        throw new Exception("Las contraseñas no coinciden");
    }

    $this->persistencia->newUserEmpleado($datos);
}
public function bloqueoCuentaUsuario($usuario)
{
    $this->persistencia->bloqueoCuentaUsuario($usuario);
}
public function restaurarContraseniaByUsuario($usuario, $contrasenia1, $contrasenia2)
{
    $existeUsuario = $this->persistencia->getUser($usuario);

    if (count($existeUsuario) == 0) {

        throw new Exception("El usuario no existe");
    }
    if ($contrasenia1 == "" || $contrasenia2 == "") {
        throw new Exception("Proporcione una nueva contraseña");
    }
    if ($contrasenia1 != $contrasenia2) {
        throw new Exception("Las contraseñas no coinciden");
    }

    $this->persistencia->restaurarContraseniaByUsuario($usuario, $contrasenia1, $contrasenia2);
}

public function getUser($usuario)
{

        //$log = new KLogger ( "negocio_obtenerCatalogoPuestoPorTipoPuesto.log" , KLogger::DEBUG );

        //$log -> LogInfo ("UsuarioCuenta: " . $tipoPuesto);
        //$log -> LogInfo ("UsuarioPassword: " . $tipoPuesto);
    $user = array();

    $user = $this->persistencia->getUser($usuario);

    return $user;
}
public function selectPlantillaRequisicionByIdPuntoAndMonth($puntoServicio, $fecha1, $fecha)
{
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->selectPlantillaRequisicionByIdPuntoAndMonth($puntoServicio, $fecha1, $fecha);
    return $lista;
}

public function updatePuntoServicioFacturacion($puntoServicio)
{
    if ($puntoServicio["centroCostoFacturacion"] == "") {
        throw new Exception("Número de centro de costo inválido");
    }
    if ($puntoServicio["nombrePuntoFacturacion"] == "") {
        throw new Exception("Nombre de punto de servicio inválido");
    }
    $this->persistencia->updatePuntoServicioFacturacion($puntoServicio);
}

public function cierrePeriodo($datos)
{
        $log = new KLogger ( "negocio_cierreQuicenal.log" , KLogger::DEBUG );

    $existeRegistroDatosPeriodo = $this->persistencia->getDatosCierrePeriodoByFechasAndTipoPeriodo($datos["fechaInicioPeriodo"], $datos["fechaTerminoPeriodo"], $datos["periodoId"]);
       // $log -> LogInfo ("existeRegistroDatosPeriod: " . $existeRegistroDatosPeriodo);
    if (count($existeRegistroDatosPeriodo) > 0) {
        $this->persistencia->updateDatosCierrePeriodoByFechas($datos);
    } else {
        $this->persistencia->cierrePeriodo($datos);
    }

}
public function getDatosCierrePeriodoByFechasAndTipoPeriodo($fecha1, $fecha2, $periodoId)
{

    $datosCierrePeriodo = array();
    $datosCierrePeriodo = $this->persistencia->getDatosCierrePeriodoByFechasAndTipoPeriodo($fecha1, $fecha2, $periodoId);

    return $datosCierrePeriodo;
}
public function getModificacionesPostCierre($fechaCierre, $fechaCambioPeriodo, $idTipoPeriodo)
{

    $incidenciasPostCierre = array();
    $incidenciasPostCierre = $this->persistencia->getModificacionesPostCierre($fechaCierre, $fechaCambioPeriodo, $idTipoPeriodo);

    return $incidenciasPostCierre;
}
public function obtenerListaDiasParaCierre($tipoPeriodo, $currentTimestamp = null)
{

        //$log = new KLogger ( "obtenerListaDiasParaCierre.log" , KLogger::DEBUG );

    $debug            = 0;
    $segundos_por_dia = 86400;

    $dias_semana = array("Dom", "Lun", "Mar", "Miér", "Jue", "Vier", "Sáb");
    $result      = array();

    $tipoPeriodo = strtoupper($tipoPeriodo);

    $configPeriodo           = $this->persistencia->getParametroConfiguracionById("PERIODO_" . $tipoPeriodo);
    $configHoraCierrePeriodo = $this->persistencia->getParametroConfiguracionById("PERIODO_HORA_CIERRE");

    if ($configPeriodo == null) {
        return $result;
    }

    $periodoHoraCierre = "00:00";
    if ($configHoraCierrePeriodo != null) {
        $periodoHoraCierre = $configHoraCierrePeriodo;
    }

    if ($currentTimestamp == null) {
        $currentTimestamp = time() - 3 * 24 * 60 * 60;

            //$log->LogInfo("Valor de la  \$currentTimestamp : " . var_export (date("Y-m-d",$currentTimestamp), true));

    }

    $items  = explode(":", $periodoHoraCierre);
    $hora   = $items[0];
    $minuto = $items[1];

    $secondsExtra = $hora * 3600 + $minuto * 60;

    if ($tipoPeriodo == "SEMANAL") {
        $currentDiaSemana = date("w", $currentTimestamp);
        $diff             = $currentDiaSemana - $configPeriodo;
        $day              = $currentTimestamp - ($segundos_por_dia * $diff);

        $limit = mktime(0, 0, 0, date("n", $day), date("d", $day), date("Y", $day));
        $limit += $secondsExtra;

        if ($debug) {
            echo "CurrentDiaSemana:" . $dias_semana[$currentDiaSemana] . "<br/>";
            echo "ConfigPeriodo:" . $dias_semana[$configPeriodo] . "<br/>";
            $this->print_timestamp("currentTimestamp", $currentTimestamp);
            $this->print_timestamp("day", $day);
            $this->print_timestamp("limit", $limit);
        }

        if ($currentTimestamp < $limit) {
            $day -= 7 * $segundos_por_dia;
        }

        for ($i = $configPeriodo; $i < $configPeriodo + 7; $i++) {
            $result[] = array("fecha" => date("Y-m-d", $day),
                "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
            $day += $segundos_por_dia;
        }
    } elseif ($tipoPeriodo == "CATORCENAL") {
        $startDay       = $configPeriodo;
        $startTimestamp = strtotime($startDay);
        $endTimestamp   = $startTimestamp + ($segundos_por_dia * 14);
        $limit          = $endTimestamp + $secondsExtra;

        if ($debug) {
                //$this -> print_timestamp ("startDay", $startDay);
            $this->print_timestamp("currentTimestamp", $currentTimestamp);
            $this->print_timestamp("startTimestamp", $startTimestamp);
            $this->print_timestamp("endTimestamp", $endTimestamp);
            $this->print_timestamp("limit", $limit);
        }

        if ($currentTimestamp > $limit) {
            $startDay = date("Y-m-d", $endTimestamp);
            $this->persistencia->saveParametroConfiguracion("PERIODO_" . $tipoPeriodo, $startDay, "Periodo catorcenal. Modificado por sistema");

            $startTimestamp = strtotime($startDay);
            $endtimestamp   = $startTimestamp + ($segundos_por_dia * 14);
        }

        $day = $startTimestamp;
        for ($i = 0; $i < 14; $i++) {
            $result[] = array("fecha" => date("Y-m-d", $day),
                "leyenda"                 => $dias_semana[$i % 7] . "-" . date("Y-m-d", $day), "dia" => $dias_semana[$i % 7] . " " . date("d-m", $day));
            $day += $segundos_por_dia;
        }
        } else // Periodo QUINCENAL
        {
            $currentTimestamp -= $secondsExtra;

            $currentDay   = date("j", $currentTimestamp);
            $currentMonth = date("n", $currentTimestamp);
            $currentYear  = date("Y", $currentTimestamp);

            if ($debug) {
                echo "<p>periodoHoraCierre:" . $hora . "--" . $minuto . "</p>";
            }

            $today     = $currentTimestamp; // mktime (0,0,0,$currentMonth, $currentDay, $currentYear);
            $startDay  = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
            $endDay    = mktime(23, 59, 59, $currentMonth, 15, $currentYear);
            $changeDay = $endDay; // + ($segundos_por_dia / 2);

            //$log->LogInfo("Valor de la  \$today : " . var_export (date("Y-m-d",$today), true));

            //$log->LogInfo("Valor de la  \$startDay : " . var_export (date("Y-m-d",$startDay), true));
            //$log->LogInfo("Valor de la  \$endDay : " . var_export (date("Y-m-d",$endDay), true));
            //$log->LogInfo("Valor de la  \$currentDay : " . var_export ($currentDay, true));

            if ($currentDay > 15) {
                $startDay = mktime(0, 0, 0, $currentMonth, 16, $currentYear);
                //$log->LogInfo("Valor de la startDay  \$startDay : " . var_export (date("Y-m-d",$startDay), true));

                $lastDayOfMonth = date("t", $currentTimestamp);

                $endDay = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);

                //$log->LogInfo("Valor de la startDay  \$startDay : " . var_export (date("Y-m-d",$startDay), true));
                //$log->LogInfo("Valor de la endDay  \$endDay : " . var_export (date("Y-m-d",$endDay), true));

                //$startDay += $segundos_por_dia;
                //$endDay += $segundos_por_dia;
            }

            $startDay += ($segundos_por_dia * ($configPeriodo));
            $endDay += ($segundos_por_dia * ($configPeriodo));
            $changeDay = $endDay; // + ($segundos_por_dia / 2);

            //$log->LogInfo("Valor de la startDay con \$startDay : " . var_export (date("Y-m-d",$startDay), true));
            //$log->LogInfo("Valor de la endDay con  \$endDay : " . var_export (date("Y-m-d",$endDay), true));

            if ($debug) {
                echo "<p>Valores iniciales del timestamp y dia inicial y dia final del periodo<br/>";
                echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                echo "</p>";
            }

            // Ajuste para mostrar el nuevo periodo cuando
            // la fecha actual es mayor que el dia final del periodo
            if ($changeDay < $today) {
                $startDay = $endDay + 1;
                $endDay   = $startDay + ($segundos_por_dia * 10);

                $month = date("n", $endDay);
                $year  = date("Y", $endDay);

                $endDay1 = mktime(23, 59, 59, $month, 1, $year);
                $endDay2 = mktime(23, 59, 59, $month, 15, $year);

                if ($endDay < $endDay1) {
                    $endDay = $endDay1;
                } elseif ($endDay < $endDay2) {
                    $endDay = $endDay2;
                } else {
                    $lastDayOfMonth = date("t", $currentTimestamp);
                    $endDay         = mktime(23, 59, 59, $currentMonth, $lastDayOfMonth, $currentYear);
                }

                $endDay += ($segundos_por_dia * ($configPeriodo));
                $changeDay = $endDay + ($segundos_por_dia / 2);

                if ($debug) {
                    echo "<p>Cambio de periodo<br/>";
                    echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d H:i:s", $currentTimestamp) . "<br/>";
                    echo "startDay:" . $startDay . " " . date("Y-m-d H:i:s", $startDay) . "<br/>";
                    echo "endDay:" . $endDay . " " . date("Y-m-d H:i:s", $endDay) . "<br/>";
                    echo "changeDay:" . $changeDay . " " . date("Y-m-d H:i:s", $changeDay) . "<br/>";
                    echo "</p>";
                }
            }

            #echo "currentTimestamp:" . $currentTimestamp . " " . date("Y-m-d", $currentTimestamp) . "<br/>";
            #echo "startDay:" . $startDay . " " . date("Y-m-d", $startDay) . "<br/>";
            #echo "endDay:" . $endDay . " " . date("Y-m-d", $endDay) . "<br/>";

            $day = $startDay;

            //$log->LogInfo("Valor de la day con  \$day : " . var_export (date("Y-m-d",$day), true));

            //$days = ($endDay - $startDay)  / $segundos_por_dia;
            for ($i = date("Y-m-d", $startDay); $i <= date("Y-m-d", $endDay); $i = date("Y-m-d", strtotime($i . "+ 1 days"))) {

                $diaSemana = $dias_semana[date('w', strtotime($i))];
                //$log->LogInfo("Valor diaSemanacon  \$day : " . var_export ($diaSemana, true));

                $result[] = array("fecha" => $i,
                    "leyenda"                 => $diaSemana . "-" . $i, "dia" => $diaSemana . " " . date('d-m', strtotime($i)));

                //$day = date("Y-m-d", strtotime($i ."+ 1 days"));
                //$log->LogInfo("Valor de la day day day con  \$day : " . var_export ($i, true));
                //$log->LogInfo("Valor de result con  \$day : " . var_export ($result, true));

            }

        }

        //$log->LogInfo("Valor de result con  \$result : " . var_export ($result, true));

        return $result;
    }
    public function getIncidenciasAlCierre($datos)
    {

        $incidenciasAlCierre = array();
        $incidenciasAlCierre = $this->persistencia->getIncidenciasAlCierre($datos);

        return $incidenciasAlCierre;
    }

    public function registroDiferencias($datos)
    {

        //$log = new KLogger ( "negocio_registrarIncidenciaEspecial.log" , KLogger::DEBUG );

        $result          = array();
        $errorValidacion = false;
        $usuario["rol"]="";

        // Se deben realizar las siguientes validaciones:
        // Todos los datos de entrada son obligatorios.
        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
        // La fecha de asistencia debe estar dentro del periodo quincenal
        // Qué el empleado exista en el sistema
        // Qué el supervisor exista en el sistema
        // Qué no se haya registrado previamente la asistencia

        // Todos los datos de entrada son obligatorios
        if (empty($datos)) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "No se proporcionaron todos los datos necesarios para el registro de diferencias";
        }

        // La fecha de asistencia debe estar dentro del periodo quincenal

        // Qué el empleado exista en el sistema
        if (!$errorValidacion) {
            $empleadoObtenido = $this->negocio_obtenerEmpleadoPorId(
                $datos["incidenciaEmpleadoEntidad"],
                $datos["incidenciaEmpleadoConsecutivo"],
                $datos["incidenciaEmpleadoTipo"],$usuario);

            if ($empleadoObtenido == null) {
                $errorValidacion   = true;
                $result["status"]  = "error";
                $result["message"] = "El empleado no existe";
            }
        }

        // Qué el supervisor exista en el sistema
        if (!$errorValidacion) {
            $supervisorObtenido = $this->negocio_obtenerEmpleadoPorId(
                $datos["incidenciaSupervisorEntidad"],
                $datos["incidenciaSupervisorConsecutivo"],
                $datos["incidenciaSupervisorTipo"],$usuario);

            if ($supervisorObtenido == null) {
                $errorValidacion   = true;
                $result["status"]  = "error";
                $result["message"] = "El supervisor no existe";
            }
        }

        // Qué no se haya registrado previamente la asistencia        //

        if (!$errorValidacion) {

            $registro = $registrado = $this->persistencia->registroDiferencias($datos);

            if ($registro == true) {
                $result["status"]  = "success";
                $result["message"] = "";
            }

        }

        //$log->LogInfo("Valor de la  \$result : " . var_export ($result, true));

        return $result;
    }
    public function getCentroCostoByEntidadTrabajo($entidadTrabajo)
    {

        $result = "";
        $result = $this->persistencia->getCentroCostoByEntidadTrabajo($entidadTrabajo);

        return $result;
    }

    public function getCatalogoMediosInformacion()
    {
        $result = array();

        $result = $this->persistencia->getCatalogoMediosInformacion();

        return $result;

    }

    public function obtenerReclutadoresSeguridadFisica()
    {
        $result = array();

        $result = $this->persistencia->obtenerReclutadoresSeguridadFisica();

        return $result;

    }

    public function actualizarEstatusEmisionAltaImss($datosImss)
    {

        //$log = new KLogger ( "negocio_rechazarEmpleadoImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

        $this->persistencia->actualizarEstatusEmisionAltaImss($datosImss);
    }

    public function actualizarEstatusDefinitivoImss($datosImss)
    {

        //$log = new KLogger ( "negocio_rechazarEmpleadoImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

        if ($datosImss["comentario"] == "") {
            throw new Exception("Escriba comentario respecto al cambio definitivo.");
        }

        $this->persistencia->actualizarEstatusDefinitivoImss($datosImss);
    }
    public function getReclutadoresByLineaNegocioAndMonth($usuario, $month, $puesto)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->getReclutadoresByLineaNegocioAndMonth($usuario, $month, $puesto);
        return $lista;
    }
    public function getElementosByReclutador($reclutadorId, $month)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->getElementosByReclutador($reclutadorId, $month);
        return $lista;
    }
    public function getAltasDelMes($month, $year)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $altasMes = "";
        $altasMes = $this->persistencia->getAltasDelMes($month, $year);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $altasMes;

    }
    public function getBajasDelMes($month, $year)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $bajasMes = "";
        $bajasMes = $this->persistencia->getBajasDelMes($month, $year);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $bajasMes;

    }
    public function getNumeroElementosGif($fecha1, $fecha2)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $numElementosGif = "";
        $numElementosGif = $this->persistencia->getNumeroElementosGif($fecha1, $fecha2);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numElementosGif;

    }

    public function getNumeroElementosPlantilla($fecha1, $fecha2)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $numElementosGif = "";
        $numElementosGif = $this->persistencia->getNumeroElementosPlantilla($fecha1, $fecha2);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numElementosGif;

    }
    public function getAltasDelMesByEntidad($month, $year, $entidadId)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $altasMes = "";
        $altasMes = $this->persistencia->getAltasDelMesByEntidad($month, $year, $entidadId);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $altasMes;

    }
    public function getBajasDelMesByEntidad($month, $year, $entidadId)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $bajasMes = "";
        $bajasMes = $this->persistencia->getBajasDelMesByEntidad($month, $year, $entidadId);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $bajasMes;

    }
    public function getNumeroElementosGifByEntidad($fecha1, $fecha2, $entidadId)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $numElementosGif = "";
        $numElementosGif = $this->persistencia->getNumeroElementosGifByEntidad($fecha1, $fecha2, $entidadId);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numElementosGif;

    }
    public function getNumeroElementosPlantillaByEntidad($fecha1, $fecha2, $entidadId)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $elementosVentas = "";
        $elementosVentas = $this->persistencia->getNumeroElementosPlantillaByEntidad($fecha1, $fecha2, $entidadId);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $elementosVentas;

    }

    public function newProveedor($datos)
    {

        $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

        if ($datos["numeroContableProv"] == "") {
            throw new Exception("Proporcione el numero contable del proveedor");
        }

        if ($datos["nombreProveedor"] == "") {
            throw new Exception("Proporcione el nombre del proveedor");
        }

        if ($datos["rfcProveedor"] == "") {
            throw new Exception("Proporcione el rfc del proveedor");
        }

        if ($datos["contactoProveedor"] == "") {
            throw new Exception("Proporcione el nombre de contacto del proveedor");
        }

        if ($datos["bancoProveedor"] == "") {
            throw new Exception("Proporcione el banco del proveedor");
        }

        if ($datos["correoProveedor"] == "") {
            throw new Exception("Proporcione el correo electronico del proveedor");
        } else {
            if (preg_match($patronCorreo, $datos["correoProveedor"]) == false) {
                throw new Exception("El formato de correo electronico del proveedor es incorrecto");
            }
        }

        if ($datos["telefonoProveedor"] == "") {
            throw new Exception("Proporcione el telefono del proveedor");
        }

        if ($datos["domicilioProveedor"] == "") {
            throw new Exception("Proporcione el domicilio del proveedor");
        }

        $this->persistencia->newProveedor($datos);
    }

    public function obtenerProveedores()
    {

        $lista = array();

        $lista = $this->persistencia->obtenerProveedores();
        return $lista;
    }

    public function negocio_obtenerPuntosServiciosPorEntidadCliente($idEntidad, $idCliente, $fecha1, $fecha2)
    {
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

        $listaPuntos = array();
        $listaPuntos = $this->persistencia->obtenerPuntosServiciosPorEntidadCliente($idEntidad, $idCliente, $fecha1, $fecha2);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
        return $listaPuntos;
    }

    public function getTipoUniformes()
    {
        $lista = array();

        $lista = $this->persistencia->getTipoUniformes();
        return $lista;
    }

    public function generarFactura($folioFactura, $proveedor, $lineaNegocio, $tipoPago, $descripcionPago, $listaUniformes, $totalFactura, $mercanciaEntregada, $facturaPagada, $entidadProducto)
    {

        $anio = DATE('Y');
        if ($mercanciaEntregada == 1) {
            $fechaEntrega = date("Y-m-d");
        } else {
            $fechaEntrega = "";
        }

        if ($facturaPagada == 1) {
            $fechaPago = date("Y-m-d");
        } else {
            $fechaPago = "";
        }

        $this->persistencia->generarFacturaUniforme($folioFactura, $mercanciaEntregada, $fechaEntrega, $tipoPago, $descripcionPago, $totalFactura, $proveedor, $lineaNegocio, $facturaPagada, $fechaPago);

        for ($i = 0; $i < count($listaUniformes); $i++) {

            $idFactura        = $listaUniformes[$i]["idFactura"];
            $claveUniforme    = $listaUniformes[$i]["tipoUniforme"];
            $cantidadUniforme = $listaUniformes[$i]["cantidadUni"];
            $precioUniforme   = $listaUniformes[$i]["precioUni"];

            $this->persistencia->insertarCompraUniformes($idFactura, $claveUniforme, $cantidadUniforme, $precioUniforme);

            $this->persistencia->calcularPromedioCosto($claveUniforme, $anio);

            $this->persistencia->insertarStockUniforme($claveUniforme, $entidadProducto, $cantidadUniforme);

        }

    }

    public function obtenerFacturas()
    {

        $facturas = array();

        $facturas = $this->persistencia->obtenerFacturas();

        for ($i = 0; $i < count($facturas); $i++) {
            $valorEntregada = $facturas[$i]["mercanciaEntregada"];
            $valorPagada    = $facturas[$i]["facturaPagada"];

            if ($valorEntregada == 0) {
                $facturas[$i]["mercanciaEntregada"] = "NO";
            } else {
                $facturas[$i]["mercanciaEntregada"] = "SI";
            }

            if ($valorPagada == 0) {
                $facturas[$i]["facturaPagada"] = "NO";
            } else {
                $facturas[$i]["facturaPagada"] = "SI";
            }

        }

        return $facturas;

    }

    public function obtenerDetalleFactura($idFactura)
    {

        $lista = array();
        $lista = $this->persistencia->obtenerDetalleFactura($idFactura);
        return $lista;

    }

    public function obtenerStatusFactura($idFactura)
    {

        $estado = $this->persistencia->obtenerStatusFactura($idFactura);
        return $estado;
    }

    public function updateFactura($facturaId, $mercanciaEntregada, $facturaPagada)//actualizar facturas
    {
        $statusFactura = $this->persistencia->obtenerStatusFactura($facturaId);
        // if ($mercanciaEntregada == 1) {
            if (($statusFactura["mercanciaEntregada"] == 0 && $mercanciaEntregada == 1) || ($statusFactura["mercanciaEntregada"] == 1 && $mercanciaEntregada == 0)) {
                $dato      = "mercanciaEntregada";
                $datoFecha = "fechaMercanciaEntregada";
                $campoEdicion = "edicionEntregaFactura";
                $this->persistencia->updateFactura($facturaId, $dato, $datoFecha,$mercanciaEntregada,$campoEdicion);
            }
        // }

        // if ($facturaPagada == 1) {
            if (($statusFactura["facturaPagada"] == 0 && $facturaPagada == 1) || ($statusFactura["facturaPagada"] == 1 && $facturaPagada == 0)) {
                $dato      = "facturaPagada";
                $datoFecha = "fechaPagoFactura";
                $campoEdicion = "edicionPagoFactura";
                $this->persistencia->updateFactura($facturaId, $dato, $datoFecha,$facturaPagada,$campoEdicion);
            }
        // }

    }

    public function agregarNuevoUniforme($lineaNegocio, $tipoMercancia, $listaTipos, $descripcionUniforme,$LavanderiaR1,$LavanderiaR2,$LavanderiaR3,$LavanderiaR4,$LavanderiaR5,$LavanderiaR6,$DestruccionR1,$DestruccionR2,$DestruccionR3,$DestruccionR4,$DestruccionR5,$DestruccionR6,$CobroR1,$CobroR2,$CobroR3,$CobroR4,$CobroR5,$CobroR6)
    {

        for ($i = 0; $i < count($listaTipos); $i++) {
            $this->persistencia->agregarNuevoUniforme($lineaNegocio, $tipoMercancia, $listaTipos[$i], $descripcionUniforme,$LavanderiaR1,$LavanderiaR2,$LavanderiaR3,$LavanderiaR4,$LavanderiaR5,$LavanderiaR6,$DestruccionR1,$DestruccionR2,$DestruccionR3,$DestruccionR4,$DestruccionR5,$DestruccionR6,$CobroR1,$CobroR2,$CobroR3,$CobroR4,$CobroR5,$CobroR6);
        }

    }

    public function asignarUniforme($nombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$cantidadUni,$usuarioCaptura,$entidadUsuario,$maxid,$tipoUniforme,$codigoUnif,$talla,$descripcionTipoUnif, $EntidadEmpleadoUSR,$numEmpAlmacen,$FirmaEmpAlmacen,$FirmaGuardia,$NombreEmpAlmacen,$costoIngresado1,$i,$asignacionSup,$sucursalUnifAsigTMP){

     if ($this->persistencia->uniformesPorEntidad($entidadUsuario, $idUniforme, $cantidadUni,$sucursalUnifAsigTMP) == true) {//revisar stock por entidad y sucursal
        
         $this->persistencia->asignarUniforme($nombreGuardia,$idUniforme, $cantidadUni, $empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $usuarioCaptura,$maxid,$codigoUnif,$talla,$descripcionTipoUnif, $EntidadEmpleadoUSR,$numEmpAlmacen,$FirmaEmpAlmacen,$FirmaGuardia,$NombreEmpAlmacen,$costoIngresado1,$tipoUniforme,$i,$asignacionSup,$entidadUsuario,$sucursalUnifAsigTMP);
         
         $this->persistencia->actualizarStock($idUniforme, $cantidadUni, $entidadUsuario,$sucursalUnifAsigTMP);
         if ($tipoUniforme=='5' && $asignacionSup=='0') {
             $this->persistencia->insertDeudasUniforme($nombreGuardia,$empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $idUniforme, $cantidadUni, $usuarioCaptura, $entidadUsuario,$costoIngresado1,$FirmaGuardia,$numEmpAlmacen,$FirmaEmpAlmacen,$NombreEmpAlmacen,$maxid,$descripcionTipoUnif,$sucursalUnifAsigTMP);
         }
        }else {
               throw new Exception("No existe uniforme disponible");
              }
    }

    public function obtenerStockUniforme()
    {
        $lista = array();

        $lista = $this->persistencia->obtenerStockUniforme();
        return $lista;

    }

    public function obtenerAsignaciones()
    {
        $lista = array();

        $lista = $this->persistencia->obtenerAsignaciones();
        return $lista;

    }

    public function getListaEmpleadosNominaPorPuntoServicio($fecha1, $fecha2, $puntoServicioId, $puestoCubierto, $roloperativo)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

        $lista = $this->persistencia->getListaEmpleadosNominaPorPuntoServicio($fecha1, $fecha2, $puntoServicioId, $puestoCubierto, $roloperativo);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $lista;

    }

    public function getAsistenciaByEmpleadoPeriodo2($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto)
    {

        //$log = new KLogger ( "negocio_getAsistenciaByEmpleadoPeriodo.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

        $lista = array();

        $lista = $this->persistencia->getAsistenciaByEmpleadoPeriodo2($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function getSumaDiasFestivos2($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio, $puestoCubierto)
    {

        //$log = new KLogger ( "negocio_getSumaTurnosExtras.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

        $lista = array();

        $lista = $this->persistencia->getSumaDiasFestivos2($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio, $puestoCubierto);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function getSumaTurnosExtrasPorPunto($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto)
    {

        //$log = new KLogger ( "negocio_getSumaTurnosExtras.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

        $lista = array();

        $lista = $this->persistencia->getSumaTurnosExtrasPorPunto($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function getSumDescuentosPorPunto($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto)
    {

        $lista = array();

        $lista = $this->persistencia->getSumDescuentosPorPunto($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto);

        return $lista;

    }

    public function getSumaIncidenciasEspecialesPorPunto($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto)
    {

        $lista = array();

        $lista = $this->persistencia->getSumaIncidenciasEspecialesPorPunto($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicioId, $puestoCubierto);

        return $lista;

    }

    public function getEmpleadosClienteEntidad($idCliente,$fechaPeriodo1,$fechaPeriodo2)
    {

        $lista = array();

        $lista = $this->persistencia->getEmpleadosClienteEntidad($idCliente,$fechaPeriodo1,$fechaPeriodo2);

        return $lista;

    }

    public function consultaGeneralUbi()
    {
        //$log = new KLogger ( "negocioconsultaGeneral.log" , KLogger::DEBUG );

        $lsitaUbicaciones = array();
        $lsitaUbicaciones = $this->persistencia->consultaGeneralUbi();
        //$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($listaEmpleados, true));
        return $lsitaUbicaciones;
    }

    public function negocio_transferirUniformes($entidadUsuario, $entidadDestino, $listaUniformes, $guia, $paqueteria, $observaciones, $usuarioCaptura,$sucursalEnvio,$sucursalOrigen)
    {
        // $log = new KLogger ( "negocio_transferirUniformes.log" , KLogger::DEBUG );
        // $log->LogInfo("Valor de la variable listaUniformes: " . var_export ($listaUniformes, true));
        $this->persistencia->registrarTransferencia($entidadUsuario, $entidadDestino, $guia, $paqueteria, $observaciones, $usuarioCaptura,$sucursalEnvio,$sucursalOrigen);

        for ($i = 0; $i < count($listaUniformes); $i++) {
            if($listaUniformes[$i] != '') {
            // $log->LogInfo("Valor de la variable i: " . var_export ($i, true));
            // $log->LogInfo("Valor de la variable listaUniformes i: " . var_export ($listaUniformes[$i], true));
                $idTransfer       = $listaUniformes[$i]["idTransfer"];
                $claveUniforme    = $listaUniformes[$i]["tipoUniforme"];
                $cantidadUniforme = $listaUniformes[$i]["cantidadUni"];
                $descripcionMercancia = $listaUniformes[$i]["descripcionMercancia"];

                $this->persistencia->insertarDetalleTransferencia($idTransfer, $claveUniforme, $cantidadUniforme);
                $this->persistencia->actualizarStock($claveUniforme, $cantidadUniforme, $entidadUsuario,$sucursalOrigen);
            }
        }

    }

    public function obtenerUniformesPorEntidad($entidad, $tipoUniforme,$sucursalStock)
    {
        $total = 0;

        $total = $this->persistencia->obtenerUniformesPorEntidad($entidad, $tipoUniforme,$sucursalStock);

        return $total;

    }

    public function getTransferGenerales($fecha1, $fecha2, $entidad)
    {
        $transfers = array();
        //$log = new KLogger ( "negocio_transferenciasGenerales.log" , KLogger::DEBUG );

        if ($fecha1 != "" && $fecha2 != "" && $entidad == "00") {
            //$log->LogInfo("Valor de la variable \$fecha2: " . var_export ($fecha2, true));
            $transfers = $this->persistencia->getTransferGeneralesByFecha($fecha1, $fecha2);

        } else if ($fecha1 == "" && $fecha2 == "" && $entidad != "00") {
            $transfers = $this->persistencia->getTransferGeneralesByEntidad($entidad);

        } else if ($fecha1 != "" && $fecha2 != "" && $entidad != "00") {
            $transfers = $this->persistencia->getTransferGeneralesByFechaEntidad($fecha1, $fecha2, $entidad);

        } else if ($fecha1 == "" && $fecha2 == "" && $entidad == "00") {
            $transfers = $this->persistencia->getTransferGenerales();
        }

        return $transfers;
    }

    public function negocio_obtenerFormasDePago()
    {
        $lista = array();

        $lista = $this->persistencia->negocio_obtenerFormasDePago();
        return $lista;

    }

    public function negocio_obtenerPlazosCredito()
    {
        $lista = array();

        $lista = $this->persistencia->negocio_obtenerPlazosCredito();
        return $lista;

    }

    public function obtenerBancosEmpresa()
    {

        $lista = array();

        $lista = $this->persistencia->obtenerBancosEmpresa();
        return $lista;
    }

    public function obtenerCardexEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria)
    {
        $cardex = array();

        $cardex = $this->persistencia->obtenerCardexEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
        return $cardex;
    }

    public function getTiposMercancia()
    {
        $lista = array();

        $lista = $this->persistencia->getTiposMercancia();
        return $lista;
    }

    public function recibirUniformeEmpleado($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$estatusRecibo,$fechaAsignacion,$usuarioCaptura,$entidadUsuario,$codigoUniforme,$talla,$descripcionUni,$montoDur,$NombreEmp,$FirmaEmp,$FirmaGuardia,$orden,$NombreGuardia,$NumeroEmpFirma,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr){
        
        $this->persistencia->recibirUniformeEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $idUniforme, $fechaAsignacion);
        $this->persistencia->actualizarAsignacionesStored($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $fechaAsignacion, $idUniforme, $estatusRecibo, $usuarioCaptura, $entidadUsuario,$codigoUniforme,$talla,$descripcionUni,$montoDur,$NombreEmp,$FirmaEmp,$FirmaGuardia,$orden,$NombreGuardia,$NumeroEmpFirma,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr);
        if($estatusRecibo == 0){
           $this->persistencia->insertarStockUniforme($idUniforme, $entidadUsuario, 1,$sucursalUsr);//VERIFICAR SI SI ES LA SUCURSAL
        }
    }

   /* public function getUniformesRecibidosByFecha1($fecha1, $fecha2, $tipoConsulta)
    {
        $lista = array();

        $lista = $this->persistencia->consultaUniformesRecibidosByFecha1($fecha1, $fecha2, $tipoConsulta);
        return $lista;

    }*/

    public function getUniformesRecibidosByFecha2($fecha1, $fecha2, $tipoConsulta, $entidadConsulta,$sucursalesArreglo)
    {
        $lista = array();

        $lista = $this->persistencia->consultaUniformesRecibidosByFecha2($fecha1, $fecha2, $tipoConsulta, $entidadConsulta,$sucursalesArreglo);
        return $lista;

    }

    public function negocio_obtenerEnvios1()
    {

        $enviosLava = array();

        $enviosLava = $this->persistencia->obtenerEnviosLavanderia1();

        return $enviosLava;

    }

    public function negocio_obtenerEnvios2($entidadUsuario)
    {

        $enviosLava = array();

        $enviosLava = $this->persistencia->obtenerEnviosLavanderia2($entidadUsuario);

        return $enviosLava;

    }

    public function negocio_obtenerDetalleEnvio($idEnvio)
    {

        $lista = array();
        $lista = $this->persistencia->obtenerDetalleEnvio($idEnvio);
        return $lista;

    }

    public function negocio_entradaDelavanderia($folioLavanderia, $entidadRecepcion)
    {
        //$log = new KLogger ( "negocio_entradaDelavanderia.log" , KLogger::DEBUG );
        $listaDetalle = array();
        $entidadEnvio = $this->persistencia->obtenerEntidadEnvio($folioLavanderia);
        //$log->LogInfo("Valor de la variable entidadEnvio: " . var_export ($entidadEnvio, true));
        //$log->LogInfo("Valor de la variable entidadRecepcion: " . var_export ($entidadRecepcion, true));


        for($j=0;$j<count($entidadRecepcion);$j++){
            if(!is_array($entidadRecepcion))
            {
                $entidadRecepcion = $entidadRecepcion[$j]; 
                //$log->LogInfo("Valor de la variable entidadRecepcion: " . var_export ($entidadRecepcion, true));
               if ($entidadEnvio == $entidadRecepcion) 
               {
                    $this->persistencia->recibirUniformesLavanderia($folioLavanderia);
                    $listaDetalle = $this->persistencia->obtenerUniformesByFolio($folioLavanderia);
        
                    for ($i = 0; $i < count($listaDetalle); $i++) {
                        $claveUniforme    = $listaDetalle[$i]["idUniformeSucio"];
                        $cantidadUniforme = $listaDetalle[$i]["cantidadUniEnvio"];
        
                        $this->persistencia->insertarStockUniforme($claveUniforme, $entidadRecepcion, $cantidadUniforme);
                    }
                    $bandera=1;
                }
                else
                {
                    if($bandera!=1){
                        throw new Exception("Entidad de recepción inválida");
                    }
                }
            }
            else
            {
                if ($entidadEnvio == $entidadRecepcion) 
                {
                    $this->persistencia->recibirUniformesLavanderia($folioLavanderia);
                    $listaDetalle = $this->persistencia->obtenerUniformesByFolio($folioLavanderia);
        
                    for ($i = 0; $i < count($listaDetalle); $i++) 
                    {
                        $claveUniforme    = $listaDetalle[$i]["idUniformeSucio"];
                        $cantidadUniforme = $listaDetalle[$i]["cantidadUniEnvio"];
                        $this->persistencia->insertarStockUniforme($claveUniforme, $entidadRecepcion, $cantidadUniforme);
                    }
                } 
                else 
                {
                    throw new Exception("Entidad de recepción inválida");
                }
            }
        }
    }

    public function obtenerStockUniformeEntidad($entidad,$sucArreglo)
    {
        $lista = array();

        $lista = $this->persistencia->obtenerStockUniformeEntidad($entidad,$sucArreglo);
        return $lista;

    }

    public function negocio_obtenerUltimoIdTransfer()
    {

        $valor = $this->persistencia->obtenerIdTransfer();

        return $valor;

    }

    public function negocio_obtenerDetalleTransferencia($idTransferencia)
    {

        $lista = array();
        $lista = $this->persistencia->obtenerDetalleTransferencia($idTransferencia);
        return $lista;

    }

    public function negocio_entradaDeTransferencia($idTransfer, $entidadRecepcion)
    {
        $listaDetalle = array();

        $this->persistencia->recibirUniformesTransfer($idTransfer);
        $listaDetalle = $this->persistencia->obtenerUniformesByTransferencia($idTransfer);

        for ($i = 0; $i < count($listaDetalle); $i++) {
            $claveUniforme    = $listaDetalle[$i]["idUniformeTransfer"];
            $cantidadUniforme = $listaDetalle[$i]["cantidadUniformeTransfer"];

            $this->persistencia->insertarStockUniforme($claveUniforme, $entidadRecepcion, $cantidadUniforme);
        }

    }

    public function negocio_obtenerUltimoFolioEv()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $ultimoFolio = "";
        $ultimoFolio = $this->persistencia->traerUltimoFolioEv();
        //$log -> LogInfo ("negocio_obtenerUltimoNumeroOrden". var_export($ultimoNumeroOrden,true));
        return $ultimoFolio;

    }

    public function obtenerAsignacionesByEmpleado($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado)
    {
        $lista = array();

        $lista = $this->persistencia->obtenerAsignacionesByEmpleado($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado);
        return $lista;

    }

    public function obtenerUniformesEntregadosByEmpleado($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado)
    {
        $lista = array();

        $lista = $this->persistencia->getEntregadosByGuardia($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado);
        return $lista;

    }

    public function negocio_obtenerUniformesByTipo($tipoMerca)
    {
        $lista = array();

        $lista = $this->persistencia->obtenerUniformesByTipo($tipoMerca);
        return $lista;

    }

    public function negocio_registrarEventual($eventual)
    {
        //$log = new KLogger ( "negocioRegistroMovimiento.log" , KLogger::DEBUG );

        if ($eventual["clienteEv"] == "") {
            throw new Exception("Seleccione el cliente");

        }

        if ($eventual["entidadEventual"] == "00") {
            throw new Exception("Seleccione la entidad");

        }

        if ($eventual["direccionEv"] == "") {
            throw new Exception("Ingrese la dirección del servicio");

        }

        if ($eventual["nombreServicio"] == "") {
            throw new Exception("Ingrese el nombre del servicio");
        }

        if ($eventual["fechaInicioEv"] == "") {
            throw new Exception("Ingrese la fecha de inicio");

        }

        if ($eventual["fechaFinEv"] == "") {
            throw new Exception("Ingrese la fecha de termino");

        }

        if (!is_numeric($eventual["numElementosEv"])) {
            throw new Exception("Ingrese la cantidad correcta");
        }

        if ($eventual["puestoEv"] == "00") {
            throw new Exception("Seleccione el puesto");
        }
        if ($eventual["turnoEv"] == "") {
            throw new Exception("Seleccione el turno");
        }

        if ($eventual["numElementosEv"] == "") {
            throw new Exception("Ingrese la cantidad de elementos");
        }

        //$log->LogInfo("Valor de la variable \$movimiento : " . var_export ($movimiento, true));

        $this->persistencia->insertarEventual($eventual);
    }

    public function negocio_traerEventualesTable()
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

        $lista = $this->persistencia->traerEventualesTable();
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $lista;

    }

    public function negocio_actualizarCostoEventual($idServicio, $costopNuevo)
    {
        //$log->LogInfo("Valor de la variable \$movimiento : " . var_export ($movimiento, true));

        $this->persistencia->actualizarCostoEventual($idServicio, $costopNuevo);
    }

    public function selectDatosEventual($idEventual)
    {
        //$log = new KLogger ( "negocio_selectDatosPuntoServicio" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->selectDatosEventual($idEventual);
        return $lista;
    }

    public function negocio_obtenerConsecutivoElementoEv()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $consecutivo = "";
        $consecutivo = $this->persistencia->obtenerConsecutivoElementoEv();
        //$log -> LogInfo ("negocio_obtenerUltimoNumeroOrden". var_export($ultimoNumeroOrden,true));
        return $consecutivo;

    }

    public function negocio_asignarElementoEventual($elemento)
    {
        //$log = new KLogger ( "negocioRegistroMovimiento.log" , KLogger::DEBUG );

        if ($elemento["numeroElemento"] == "") {
            throw new Exception("Ingrese el numero de empleado");

        }

        if ($elemento["nombreElemento"] == "") {
            throw new Exception("Nombre de elemento requerido");

        }

        if ($elemento["apPaternoEv"] == "") {
            throw new Exception("Apellido paterno requerido");

        }

        if ($elemento["apMaternoEv"] == "") {
            throw new Exception("Apellido materno requerido");
        }

        //$log->LogInfo("Valor de la variable \$movimiento : " . var_export ($movimiento, true));

        $this->persistencia->asignarElementoEventual($elemento);
    }

    public function negocio_obtenerAsignadosByEventual($eventual)
    {
        $total = 0;

        $total = $this->persistencia->obtenerAsignadosByEventual($eventual);

        return $total;

    }

    public function negocio_traerElementosByEventual($idEventual)
    {
        //$log = new KLogger ( "negocio_selectDatosPuntoServicio" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->traerElementosByEventual($idEventual);
        return $lista;
    }

    public function negocio_getUsuariosEmpleado($entidad, $consecutivo, $categoria)
    {

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getUsuariosEmpleado($entidad, $consecutivo, $categoria);
        return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

    }

    public function negocio_obtenerFolioPreseleccion()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $ultimoFolio = "";
        $ultimoFolio = $this->persistencia->traerFolioPreseleccion();
        //$log -> LogInfo ("negocio_obtenerUltimoNumeroOrden". var_export($ultimoNumeroOrden,true));
        return $ultimoFolio;

    }

    public function negocio_registrarEmpleadoPreseleccion($datos)
    {
         //$log = new KLogger ( "datosparafoliooooo.log" , KLogger::DEBUG );
       //$log->LogInfo("Valor de la  \$datos : " . var_export ($datos, true));
        $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

        if ($datos["puestoEmp"] == "") {
            throw new Exception("Proporcione el puesto solicitado");
        }

        if ($datos["apPaternoEmp"] == "") {
            throw new Exception("Proporcione el apellido paterno del aspirante");
        }

        if ($datos["apMaternoEmp"] == "") {
            throw new Exception("Proporcione el apellido materno del aspirante");
        }

        if ($datos["nombreEmp"] == "") {
            throw new Exception("Proporcione el nombre del aspirante");
        }

        if ($datos["edadEmp"] == "") {
            throw new Exception("Proporcione la edad del aspirante");
        } else if (!is_numeric($datos["edadEmp"])) {
            throw new Exception("Edad del aspirante inválida");
        }

        if ($datos["pesoEmp"] == "") {
            throw new Exception("Proporcione el peso del aspirante");
        } else if (!is_numeric($datos["pesoEmp"])) {
            throw new Exception("Peso del aspirante inválido");
        }

        if ($datos["estaturaEmp"] == "") {
            throw new Exception("Proporcione la estatura del aspirante");
        } else if (!is_numeric($datos["estaturaEmp"])) {
            throw new Exception("Estatura del aspirante inválida");
        }

        if ($datos["tallaCamisaEmp"] == "") {
            throw new Exception("Proporcione la talla de camisa del aspirante");
        } else if (!is_numeric($datos["tallaCamisaEmp"])) {
            throw new Exception("Talla de camisa inválida");
        }

        if ($datos["tallaPantalonEmp"] == "") {
            throw new Exception("Proporcione la talla de pantalón del aspirante");
        } else if (!is_numeric($datos["tallaPantalonEmp"])) {
            throw new Exception("talla de pantalón inválida");
        }

        if ($datos["numCalzadoEmp"] == "") {
            throw new Exception("Proporcione el número de calzado del aspirante");
        } else if (!is_numeric($datos["numCalzadoEmp"])) {
            throw new Exception("Numero de calzado inválido");
        }

        if ($datos["edoCivilEmp"] == "") {
            throw new Exception("Proporcione el estado civil del aspirante");
        }
        
        if ($datos["sexoEmp"] == "") {
            throw new Exception("Proporcione el género del aspirante");
        }



        if ($datos["tipoSangreEmp"] == "") {
            throw new Exception("Proporcione el tipo de sangre del aspirante");
        }

        if ($datos["fechaNacEmp"] == "") {
            throw new Exception("Proporcione la fecha de nacimiento del aspirante");
        }

        if ($datos["entidadNacEmp"] == "") {
            throw new Exception("Proporcione la entidad de nacimiento del aspirante");
        }

        if ($datos["calleEmp"] == "") {
            throw new Exception("Proporcione la calle del aspirante");
        }

        if ($datos["numeroCEmp"] == "") {
            throw new Exception("Proporcione el número de domicilio del aspirante");
        }

        if ($datos["coloniaEmp"] == "") {
            throw new Exception("Proporcione la colonia del aspirante");
        }

        if ($datos["municipioEmp"] == "") {
            throw new Exception("Proporcione el municipio del aspirante");
        }

        if ($datos["ciudadEmp"] == "") {
            throw new Exception("Proporcione la ciudad del aspirante");
        }

        if ($datos["telFijoEmp"] == "" && $datos["telMovilEmp"] == "") {
            throw new Exception("Proporcione por lo menos un teléfono del aspirante");
        }

        if ($datos["emailEmp"] == "") {
            throw new Exception("Proporcione el correo electronico del aspirante");
        } else {
            if (preg_match($patronCorreo, $datos["emailEmp"]) == false) {
                throw new Exception("El formato de correo electronico del aspirante es incorrecto");
            }
        }

        if ($datos["licenciaEmp"] == 1 && $datos["licenciapermanente"]==0 ) {
            if($datos["numLicenciaPreseleccion"] == ""){throw new Exception("Proporcione N° de licencia");}
            if($datos["fechavigencialicencia"] == ""){throw new Exception("Proporcione Fecha VIGENCIA DE LICENCIA");}    
        }
        if ($datos["licenciaEmp"] == 1 && $datos["licenciapermanente"]==1 ) {
            if($datos["numLicenciaPreseleccion"] == ""){throw new Exception("Proporcione N° de licencia");}
            
        }

        if ($datos["gradoEstudioEmp"] == "") {
            throw new Exception("Proporcione el ultimo grado de estudios del aspirante");
        }

        if ($datos["padreEmp"] == "") {
            throw new Exception("Proporcione el nombre del padre del aspirante");
        }

        if ($datos["madreEmp"] == "") {
            throw new Exception("Proporcione el nombre de la madre del aspirante");
        }

        if ($datos["esposaEmp"] == "") {
            throw new Exception("Proporcione el nombre de la (el) esposa (o) del aspirante");
        }

        if ($datos["nombreR1Emp"] == "" && $datos["nombreR2Emp"] == "") {
            throw new Exception("Proporcione por lo menos una referencia del aspirante");
        }

        if ($datos["nombreR1Emp"] != "" && $datos["telR1Emp"] == "") {
            throw new Exception("Proporcione el teléfono de la referencia 1 del aspirante");
        }

        if ($datos["nombreR2Emp"] != "" && $datos["telR2Emp"] == "") {
            throw new Exception("Proporcione el teléfono de la referencia 2 del aspirante");
        }

        if ($datos["telR2Emp"] != "" && $datos["nombreR2Emp"] == "") {
            throw new Exception("Proporcione el nombre de la referencia 2 del aspirante");
        }

        if ($datos["telR1Emp"] != "" && $datos["nombreR1Emp"] == "") {
            throw new Exception("Proporcione el nombre de la referencia 1 del aspirante");
        }
        if($datos["numempleadopreseleccion"] == "" && $datos["folioempleadopreseleccion"] == ""){
         $this->persistencia->registrarEmpleadoPreseleccion($datos);
     //$log -> LogInfo ("insertar nuevos datos de folio");
     }else if($datos["numempleadopreseleccion"] != "" && $datos["folioempleadopreseleccion"] == ""){
     //$log -> LogInfo ("insertar datos en tbl empleado_preseleccion y actualizar el folio en empleados");
        $this->persistencia->registrarEmpleadoPreseleccion($datos);
        $this->persistencia->updateFolioPreseleccionEmpleado($datos["numempleadopreseleccion"],$datos["folioEmp"]);   

    }else if($datos["numempleadopreseleccion"] != "" && $datos["folioempleadopreseleccion"] != ""){
  //$log -> LogInfo ("actualizar los datos en tbl empleado_preseleccion y actualizar el folio en empleados");
      $this->persistencia->updateDatosEmpleadoPreseleccion($datos);
      $this->persistencia->updateFolioPreseleccionEmpleado($datos["numempleadopreseleccion"],$datos["folioempleadopreseleccion"]); 
  }
}

public function negocio_obtenerAspirante($folio)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

    $aspirante = array();
    $aspirante = $this->persistencia->obtenerAspirante($folio);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
    return $aspirante;
}

public function negocio_actualizaPreseleccion($datos)
{
    $this->persistencia->actualizaPreseleccion($datos);
}

public function negocio_actualizaDireccionPreseleccion($datos)
{
    $this->persistencia->actualizaDireccionPreseleccion($datos);
}

public function negocio_insertarFiniquito($folio)
{
    $lista = $this->persistencia->obtenerEmpleadosBajaFiniquito($folio);
    for ($i = 0; $i < count($lista); $i++) {
        $empleado = $lista[$i];
        $motivo   = $lista[$i]['idMotivoBajaImss'];
        if ($motivo != 'B') {
            $this->persistencia->insertaFiniquitoBaja($empleado, $folio);
        } else {
            $datos111 = array();
            $datos111 = $this->persistencia->obtenerestatusempleadoenhistoricoimssRP($empleado);
            $nuevoRegistro = $datos111[0]["registroMovimiento"];
            $this->persistencia->actualizarDatosImssRegistro($empleado, $nuevoRegistro);
        }
    }
}

public function negocio_obtenerPreseleccionPorNombre($nombre)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorNombre.log" , KLogger::DEBUG );

    $lista = array();
    $lista = $this->persistencia->obtenerPreseleccionPorNombre($nombre);
        //$log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($listaEmpleados, true));
    return $lista;
}

public function negocio_obtenerEmpleadosEma($registro, $fechaPeriodo1, $fechaPeriodo2)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerEmpleadosEma($registro, $fechaPeriodo1, $fechaPeriodo2);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}

public function negocio_obtenerValoresImss($anio)
{

    $valores["uma"]     = $this->persistencia->obtenerUmaImss($anio);
    $valores["tblImss"] = $this->persistencia->obtenerTblImss();
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $valores;
}

public function rechazarBajaImss($datosImss)
{

        //$log = new KLogger ( "negocio_rechazarEmpleadoImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->rechazarBajaImss($datosImss);
}

public function negocio_getRegistrosByCliente($idCliente)
{

    $lista = array();

    $lista = $this->persistencia->getRegistrosByCliente($idCliente);

    return $lista;

}

public function getSueldosEmpleadosAdministrativos()
{
    $lista = array();
    $lista = $this->persistencia->getSueldosEmpleadosAdministrativos();
    return $lista;

}
public function insertarSueldoHistoricoAdministrativos($datos)
{

    $lista = $this->persistencia->insertSueldoHistoricoAdmin($datos);
    return $lista;

        //$this->persistencia->updateSueldoEmpleado($datos);
}

public function getSueldosaConfirmar()
{
    $lista = array();
    $lista = $this->persistencia->getSueldosaConfirmar();
    return $lista;

}
public function confirmarorechazarsueldo($entidadempleado, $consecutivoempleado, $categoriaempleado, $cuotanueva, $sueldonuevo, $idpeticion, $accion, $usuario)
{
    $lista = array();
    $lista = $this->persistencia->confirmarorechazarsueldo($entidadempleado, $consecutivoempleado, $categoriaempleado, $cuotanueva, $sueldonuevo, $idpeticion, $accion, $usuario);
    return $lista;

}

public function gettblhistoricosueldos()
{
    $lista = array();
    $lista = $this->persistencia->gettblhistoricosueldos();
    return $lista;

}
public function gettblhistoricosueldosbyfecha($tipoconsulta, $fechainicio, $fechafin)
{
    $fechainicioo = new DateTime($fechainicio);
    $fechafinn    = new DateTime($fechafin);
    if ($tipoconsulta == "0") {throw new Exception("Seleccione una opción");}
    if ($fechainicio == "") {throw new Exception("Seleccione una fecha 'Del:'");}
    if ($fechafin == "") {throw new Exception("Seleccione una fecha 'Al:'");}
    if ($fechainicioo > $fechafinn) {throw new Exception("La fecha 'Al:' no puede ser menor a la fecha 'Del:'");}
    $lista = array();
    $lista = $this->persistencia->gethistoricosueldobyfecha($tipoconsulta, $fechainicio, $fechafin);
    return $lista;
}

public function negocio_obtenerEmpleadosEmaPunto($puesto, $puntoServicio, $fechaPeriodo1, $fechaPeriodo2, $roloperativo)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerEmpleadosEmaPunto($puesto, $puntoServicio, $fechaPeriodo1, $fechaPeriodo2, $roloperativo);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}

public function negocio_obtenerCostoUniformes($puesto, $puntoServicio, $fechaPeriodo1, $fechaPeriodo2, $roloperativo)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerCostoUniformes($puesto, $puntoServicio, $fechaPeriodo1, $fechaPeriodo2, $roloperativo);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}

public function negocio_obtenerClientesByEntidad($entidad)
{

    $lista = array();

    $lista = $this->persistencia->obtenerClientesByEntidad($entidad);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $lista;
}

public function negocio_traerEntidadesCliente($cliente)
{

    $lista = array();

    $lista = $this->persistencia->traerEntidadesCliente($cliente);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $lista;
}

public function getcatbancos()
{
    $result = array();

    $result = $this->persistencia->getcatbancos();

    return $result;

}

public function negocio_traerEventualesTableSup($supervisor)
{
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

    $lista = $this->persistencia->traerEventualesTableSup($supervisor);
        //$log -> LogInfo ("$lista". var_export($lista,true));
    return $lista;

}

public function negocio_registrarTipoTurno($incidenciaId, $valorTurno, $fechaTurno, $empleado, $puntoServicio)
{
    $tipoT = 0;

    $dato["empleadoEntidad"]     = $empleado["entidadId"];
    $dato["empleadoConsecutivo"] = $empleado["consecutivoId"];
    $dato["empleadoTipo"]        = $empleado["tipoId"];
    $dato["fechaAsistencia"]     = $fechaTurno;

    if ($incidenciaId == '2') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 1;
            break;

            case '2':
            $tipoT = 2;
            break;
        }
    } else if ($incidenciaId == '9') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 3;
            break;

            case '2':
            $tipoT = 4;
            break;
        }
    } else if ($incidenciaId == '5') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 5;
            break;

            case '2':
            $tipoT = 6;
            break;
        }
    } else if ($incidenciaId == '3') {
        $tipoT = 7;
    }
    


    else if ($incidenciaId == '1') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 8;
            break;

            case '2':
            $tipoT = 9;
            break;
        }
    }
    else if ($incidenciaId == '4') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 10;
            break;

            case '2':
            $tipoT = 11;
            break;
        }
    }

    else if ($incidenciaId == '6') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 12;
            break;

            case '2':
            $tipoT = 13;
            break;
        }
    }

    else if ($incidenciaId == '7') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 14;
            break;

            case '2':
            $tipoT = 15;
            break;
        }
    }

    else if ($incidenciaId == '8') {
        switch ($valorTurno) {
            case '1':
            $tipoT = 16;
            break;

            case '2':
            $tipoT = 17;
            break;
        }
    }
    else if ($incidenciaId == '12') {
        $tipoT = 18;
    }

    else if ($incidenciaId == '13') {
        $tipoT = 19;
    }
    $this->persistencia->deleteTipoTurno($dato);
    if ($tipoT != 0) {

        $this->persistencia->registrarTipoTurno($tipoT, $fechaTurno, $empleado, $puntoServicio);
    }
}

public function negocio_deleteTipoTurno($datos)
{

    $this->persistencia->deleteTipoTurno($datos);

}

public function negocio_obtenerTurnoAsistencia($fecha, $empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $puntoServicio,$idplantillaPunto)
{

    $turno = $this->persistencia->obtenerTurnoAsistencia($fecha, $empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $puntoServicio,$idplantillaPunto);
    return $turno;

}
public function negocio_promedioGasto($entidad, $fechaPeriodo1, $fechaPeriodo2)
{
    $log             = new KLogger("negocioGasto.log", KLogger::DEBUG);
    $numeroElementos = $this->persistencia->totalElementosByCliente($entidad, $fechaPeriodo1, $fechaPeriodo2);

    $costo = $this->persistencia->gastoByEntidad($entidad, $fechaPeriodo1, $fechaPeriodo2);

    $promedio = $costo / $numeroElementos;
        //$log->LogInfo("Entidad : " . var_export($entidad, true) . " costo: " . var_export($costo, true) . " Elementos: " . var_export($numeroElementos, true));

    return $promedio;
}

public function negocio_obtenerEmpleadosEva($registro, $fechaPeriodo1, $fechaPeriodo2)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerEmpleadosEva($registro, $fechaPeriodo1, $fechaPeriodo2);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}

public function obtenerempleadosimssphistoricomov($foliotxt, $usuario, $accion, $numeroLote)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerempleadosimssphistoricomov($foliotxt, $accion);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    $aguinaldo = 15 / 365;
    $unidad    = 1;
        //return $listaEmpleados;
    for ($i = 0; $i < count($listaEmpleados); $i++) {
            //datos obtenidos de datosimss
        $estatus           = $listaEmpleados[$i]["empleadoEstatusId"];
        $estatusimss       = $listaEmpleados[$i]["empleadoEstatusImss"];
        $diasTranscurridos = $listaEmpleados[$i]["diasTranscurridos"];
        $salarioDiario     = $listaEmpleados[$i]["salarioDiario"];
        $registroPatronal  = $listaEmpleados[$i]["registroPatronal"];
        $motivoBaja        = $listaEmpleados[$i]["idMotivoBajaImss"];

            //otrafuncion que de los empleados obtenidos anteriormente traer el estatus del movimiento
            // $log = new KLogger("negocio_getestatusultimomov.log", KLogger::DEBUG);

        if ($diasTranscurridos <= 365) {
            $primaVacacional = 3;
        
        } elseif ($diasTranscurridos >= 366 and $diasTranscurridos <= 730) {
        
            $primaVacacional = 3.5;
        
        } elseif ($diasTranscurridos >= 731 and $diasTranscurridos <= 1095) {
        
            $primaVacacional = 4;
        } elseif ($diasTranscurridos >= 1096 and $diasTranscurridos <= 1460) {
        
            $primaVacacional = 4.5;
        
        } elseif ($diasTranscurridos >= 1461 and $diasTranscurridos <= 1825) {
        
            $primaVacacional = 5;
        
        } elseif ($diasTranscurridos >= 1826 and $diasTranscurridos <= 3650) {
        
            $primaVacacional = 5.5;
        
        } elseif ($diasTranscurridos >= 3651 and $diasTranscurridos <= 5475) {
        
            $primaVacacional = 6;
        
        } elseif ($diasTranscurridos >= 5476 and $diasTranscurridos <= 7300) {
        
            $primaVacacional = 6.5;
        
        } elseif ($diasTranscurridos >= 7301 and $diasTranscurridos <= 9125) {
        
            $primaVacacional = 7;
        
        } elseif ($diasTranscurridos >= 9126 and $diasTranscurridos <= 10950) {
        
            $primaVacacional = 7.5;
        
        } elseif ($diasTranscurridos >= 10951 and $diasTranscurridos <= 12775) {
        
            $primaVacacional = 8;
        
        }
            // $listaEmpleadosCuadro[$i]["prima_vacacional"]   = $primaVacacional;
        $factorIntegracion     = $unidad + ($primaVacacional / 365) + $aguinaldo;
        $salarioBaseCotizacion = $factorIntegracion * $salarioDiario;

        if ($estatus == 1) {
                $tipomovimiento = 1; //Alta
            } elseif ($estatus == 2) {
                $tipomovimiento = 3; //Reingreso
            } elseif ($estatus == 0) {
                $tipomovimiento = 2; //Baja
            }

            $listaEmpleadostipomov = $this->persistencia->obtenerestatusempleadoenhistoricoimss($listaEmpleados[$i]);

            if (!empty($listaEmpleadostipomov)) {
                $ultimoestatusmovimiento = $listaEmpleadostipomov[0]["tipoMovimiento"]; //datos obtenidos de historicomovimss

            } else {
                $ultimoestatusmovimiento = 50; //datoficticio solo para que entre a la condicion

            }

            //$log->LogInfo("Valor de la variable ultimo movi " . var_export($dato, true) . "ddd" . var_export($listaEmpleadostipomov, true));

            if ($ultimoestatusmovimiento == 4 || $ultimoestatusmovimiento == 5 || $ultimoestatusmovimiento == 6 || $ultimoestatusmovimiento == 7) {
                //update al ultimo registro de historico imss

                $this->persistencia->actualizahistoricomovimsbyestatus($listaEmpleados[$i], $usuario, $factorIntegracion, $salarioBaseCotizacion, $ultimoestatusmovimiento, $numeroLote);

            } else {
                //si no es estatus 4 insertara un nuevo registro debido a que solo puede haber sido un ingreso o reingreso

                $this->persistencia->insertahistoricoimssmov($listaEmpleados[$i], $tipomovimiento, $usuario, $factorIntegracion, $salarioBaseCotizacion, $numeroLote);
            }
        }
    }
    public function negocio_getIncidenciasAdmin()
    {

        //$log = new KLogger ( "negocio_getCatalogoIncidencias.log" , KLogger::DEBUG );

        $lista = array();

        $lista = $this->persistencia->getIncidenciasAdmin();

        return $lista;
    }

    public function inserthistoricomovporeditsueldooregpatronal($entidademp, $consecutivoemp, $categoriaemp, $tipomovimiento, $salarioDiario, $registroPatronal, $usuario, $fechaingreso, $fechabaja, $factorintegracion, $salariobasecotizacion)
    {

        //$listaEmpleados = array();

        $this->persistencia->inserthistoricomovporeditsueldooregpatronal($entidademp, $consecutivoemp, $categoriaemp, $tipomovimiento, $salarioDiario, $registroPatronal, $usuario, $fechaingreso, $fechabaja, $factorintegracion, $salariobasecotizacion);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

        //return $listaEmpleados;

    }

    public function negocio_getListaEmpleadosAdminGeneral($fecha1, $fecha2, $periodoId, $entidad,$RolUsuario,$opcion,$NombreUsuario, $lineaNegocioUsuario)
    {

        $lista = array();

        $lista = $this->persistencia->getListaEmpleadosAdminGeneral($fecha1, $fecha2, $periodoId, $entidad,$RolUsuario,$opcion,$NombreUsuario, $lineaNegocioUsuario);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function negocio_getAsistenciaByEmpleadoAdmin($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
    {

        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

        $lista = array();

        $lista = $this->persistencia->getAsistenciaByEmpleadoPeriodo($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function negocio_getAdminsByNombre($fecha1, $fecha2, $periodoId, $nombre, $entidad, $RolUsuario, $lineaNegocioUsuario)
    {
        $lista = array();
        $lista = $this->persistencia->getAdminsByNombre($fecha1, $fecha2, $periodoId, $nombre, $entidad, $RolUsuario, $lineaNegocioUsuario);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function negocio_getAdminById($fecha1, $fecha2, $periodoId, $empleado, $entidad, $RolUsuario, $lineaNegocioUsuario)
    {

        $lista = array(); 
        $lista = $this->persistencia->getAdminById($fecha1, $fecha2, $periodoId, $empleado, $entidad, $RolUsuario, $lineaNegocioUsuario);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
        return $lista;

    }

    public function negocio_registroAsistenciaAdmin(
        $empleado,
        $incidenciaId,
        $asistenciaFecha,
        $usuarioCapturaAsistencia,
        $comentariIncidencia, $tipoPeriodo, $puestoCubiertoId,$selplantillaservicioincidencia) {
        //$log = new KLogger ( "negocio_registrarAsistencia.log" , KLogger::DEBUG );

        $result          = array();
        $errorValidacion = false;
        $usuario["rol"]="";
        $conteobaja=0;

        // Se deben realizar las siguientes validaciones:
        // Todos los datos de entrada son obligatorios.
        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
        // La fecha de asistencia debe estar dentro del periodo quincenal
        // Qué el empleado exista en el sistema
        // Qué el supervisor exista en el sistema
        // Qué no se haya registrado previamente la asistencia

        // Todos los datos de entrada son obligatorios
        if (empty($empleado) ||
            $incidenciaId == "" ||
            $asistenciaFecha == "" ||
            $usuarioCapturaAsistencia == "" ||
            $tipoPeriodo == "" ||
            $puestoCubiertoId == "" ||
            !isset($empleado["entidadId"]) || $empleado["entidadId"] == "" ||
            !isset($empleado["consecutivoId"]) || $empleado["consecutivoId"] == "" ||
            !isset($empleado["tipoId"]) || $empleado["tipoId"] == "" ||
            !isset($empleado["puntoServicioId"]) || $empleado["puntoServicioId"] == "") {
            $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "No se proporcionaron todos los datos necesarios para el registro de asistencia";
    }

        // Que la fecha sea una fecha valida en el formato yyyy-mm-dd
    if (!$errorValidacion) {
        $fecha = date_parse($asistenciaFecha);

        if (!empty($fecha["errors"])) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
        }

        if (!$errorValidacion) {
            $fechaVerificada = $fecha["year"] . "-" . str_pad($fecha["month"], 2, "0", STR_PAD_LEFT) . "-" . str_pad($fecha["day"], 2, "0", STR_PAD_LEFT);

            if ($fechaVerificada != $asistenciaFecha) {
                $errorValidacion   = true;
                $result["status"]  = "error";
                $result["message"] = "La fecha de asistencia es incorrecta. La fecha debe estar en el formato yyyy-mm-dd";
            }
        }
    }

        // La fecha de asistencia debe estar dentro del periodo quincenal

        // Qué el empleado exista en el sistema
    if (!$errorValidacion) {
        $empleadoObtenido = $this->negocio_obtenerEmpleadoPorId(
            $empleado["entidadId"],
            $empleado["consecutivoId"],
            $empleado["tipoId"],$usuario);

        $estatusEmpleadoOperaciones = $empleadoObtenido[0]["estatusEmpleadoOperaciones"];

        if ($empleadoObtenido == null) {
            $errorValidacion   = true;
            $result["status"]  = "error";
            $result["message"] = "El empleado no existe";
        }
    }

        // Qué no se haya registrado previamente la asistencia        //
    $registrado = false;

    if (!$errorValidacion) {
        if ($incidenciaId != 10) {
            $registrado = $this->persistencia->registrarAsistenciaAdmin(
                $empleado,
                $incidenciaId,
                $asistenciaFecha,
                $usuarioCapturaAsistencia,
                $comentariIncidencia, $tipoPeriodo, $puestoCubiertoId,$selplantillaservicioincidencia,$conteobaja);
        } else {

            if ($estatusEmpleadoOperaciones == 1 || $estatusEmpleadoOperaciones == 4) {

                $registrado = $this->persistencia->registrarAsistenciaAdmin(
                    $empleado,
                    $incidenciaId,
                    $asistenciaFecha,
                    $usuarioCapturaAsistencia,
                    $comentariIncidencia, $tipoPeriodo, $puestoCubiertoId,$selplantillaservicioincidencia,1);

            } elseif ($estatusEmpleadoOperaciones == 0 || $estatusEmpleadoOperaciones == 3) {

                $result["status"]  = "errorRegistro";
                $result["message"] = "El elemento ya cuenta con un registro previo de baja, la baja que intenta registrar no es válida.";

            }

        }

            //$log->LogInfo("Valor de la variable \$registrado : " . var_export ($registrado, true));

        if ($registrado == true) {

            if ($incidenciaId == 10) {
                    // Mmodificar el valor "QUINCENAL" que se proporciona como parametro
                    // para que pueda ser un valor obtenido en los paramateros del ajax.
                $fechasPeriodo = $this->obtenerListaDiasParaAsistencia($tipoPeriodo);
                    //$log->LogInfo("Valor de la variable \$fechasPeriodo : " . var_export ($fechasPeriodo, true));

                $fechaBaja = strtotime($asistenciaFecha);

                for ($i = 0; $i < count($fechasPeriodo); $i++) {
                    $fecha = strtotime($fechasPeriodo[$i]["fecha"]);
                    if($i==0){
                        $conteobaja=1;
                    }else{
                      $conteobaja=0;   
                  }

                  if ($fecha > $fechaBaja) {
                    $registrado = $this->persistencia->registrarAsistenciaAdmin(
                        $empleado,
                        $incidenciaId,
                        date("Y-m-d",$fecha),
                        $usuarioCapturaAsistencia,
                        $comentariIncidencia,
                        $tipoPeriodo,
                        $puestoCubiertoId
                        ,$selplantillaservicioincidencia,$conteobaja);

                            //$log->LogInfo("Valor de la variable \$registrado : " . var_export ($registrado, true));
                }
            }

            $registrado = $this->persistencia->updateEstatusEmpleadoOperaciones($empleado, 3, $asistenciaFecha);

            if ($registrado == true) {
                $result["status"]  = "success";
                $result["message"] = "";
            }

        } else {

            $diasFestivos = $this->persistencia->getDiasFestivos();

            for ($i = 0; $i < count($diasFestivos); $i++) {

                $fechaDiaFestivo  = $diasFestivos[$i]["fechaDiaFestivo"];
                $motivoDiaFestivo = $diasFestivos[$i]["motivoDiaFestivo"];

                $ddmm                = substr($fechaDiaFestivo, 5, 5);
                $ddmmFechaAsistencia = substr($asistenciaFecha, 5, 5);

                        //$log->LogInfo("recorriendo ddmm: " . var_export ($ddmm, true));
                        //$log->LogInfo("recorriendo ddmmFechaAsistencia: " . var_export ($ddmmFechaAsistencia, true));

                if ($ddmm == $ddmmFechaAsistencia) {

                            //$log->LogInfo("La fecha de registro de asistencia es festivo" . var_export ($ddmmFechaAsistencia, true));
                    $deleteIncidencia = $this->persistencia->deleteTurnoDiaFestivo($empleado, $asistenciaFecha);
                            //$log->LogInfo("deleteIncidencia : " . var_export ($deleteIncidencia, true));

                    if ($incidenciaId == 2 || $incidenciaId == 3 || $incidenciaId == 5 || $incidenciaId == 9 || $incidenciaId == 12) {

                        $this->persistencia->registrarIncidenciaEspecialAdmin(
                            $empleado,
                            5,
                            $asistenciaFecha,
                            $usuarioCapturaAsistencia,
                            $motivoDiaFestivo, $tipoPeriodo, $puestoCubiertoId);

                    }

                }

            }

            $result["status"]  = "success";
            $result["message"] = "";
        }

    }
            //else
            //{
            //$result ["status"] = "error";
            //$result ["message"] = "No se pudo registrar la asistencia en la base de datos.";
            //}
}
        //$log->LogInfo("Valor de la variable \$result : " . var_export ($result, true));

return $result;
}

public function negocio_getListaAdminByFecha($fecha1, $fecha2, $entidad, $periodo,$RolUsuario,$NombreUsuario,$lineaNegocioUsuario)
{

    $lista = array();

    $lista = $this->persistencia->getListaAdminByFechaEntidad($fecha1, $fecha2, $entidad, $periodo,$RolUsuario,$NombreUsuario,$lineaNegocioUsuario);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function negocio_getAdminByRangoFecha($fecha1, $fecha2, $empleado, $entidad, $RolUsuario, $NombreUsuario, $lineaNegocioUsuario)
{

    $lista = array();
    $lista = $this->persistencia->getAdminByRangoFechaEntidad($fecha1, $fecha2, $empleado, $entidad, $RolUsuario, $NombreUsuario, $lineaNegocioUsuario);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function negocio_obtenerValoresImssEma($registro, $mes, $anio)
{
    $valores["uma"]         = $this->persistencia->obtenerUmaImss($anio);
    $valores["primaRiesgo"] = $this->persistencia->obtenerPrimaRT($registro, $mes, $anio);
    $valores["tblImss"]     = $this->persistencia->obtenerTblImss();
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $valores;
}

public function negocio_obtenerValoresImssEmaPunto($anio)
{
    $valores["uma"]     = $this->persistencia->obtenerUmaImss($anio);
    $valores["tblImss"] = $this->persistencia->obtenerTblImss();
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $valores;
}

public function negocio_obtenerPrimaRTEmpleado($registro, $mes, $anio)
{
    $primaRt = $this->persistencia->obtenerPrimaRT($registro, $mes, $anio);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $primaRt;
}

public function negocio_obtenerEntidadesByCliente($entidad)
{

    $lista = array();

    $lista = $this->persistencia->obtenerEntidadesByCliente($entidad);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $lista;
}

public function negocio_getListaEmpleadosByConsulta($fecha1, $fecha2, $periodoId, $entidad, $RolUsuario, $opcion, $NombreUsuario,$lineaNegocioUsuario)
{

    $lista = array();
    $lista = $this->persistencia->getListaEmpleadosAdminGeneral($fecha1, $fecha2, $periodoId, $entidad, $RolUsuario, $opcion, $NombreUsuario,$lineaNegocioUsuario);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}

public function inserupdatemontosfacturacion($fecha1, $fecha2, $monto, $turnosfactu, $llave)
{

        //$listaEmpleados = array();

    $this->persistencia->inserupdatemontosfacturacion($fecha1, $fecha2, $monto, $turnosfactu, $llave);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

        //return $listaEmpleados;

}

public function traedatosmontoturnos($llave, $fechaPeriodo1, $fechaPeriodo2)
{

    $lista = array();

    $lista = $this->persistencia->traedatosmontoturnos($llave, $fechaPeriodo1, $fechaPeriodo2);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $lista;
}

public function actualizarEstatusEmisionBajaImss($datosImss)
{

        //$log = new KLogger ( "negocio_rechazarEmpleadoImss.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$empleado : " . var_export ($empleado, true));

    $this->persistencia->actualizarEstatusEmisionBajaImss($datosImss);
}

public function negocio_getCostoMaximoPunto($fecha1, $fecha2, $idPlantilla)
{
    $costo = $this->persistencia->getCostoMaximoPunto($fecha1, $fecha2, $idPlantilla);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $costo;
}

public function negocio_getSupervisorPunto($servicio)
{
    $sup = $this->persistencia->getSupervisorPunto($servicio);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $sup;
}
public function getPuntosServBySupervisor($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo)
{
        // $log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoIdddd.log" , KLogger::DEBUG );
    $lista = array();
    $lista = $this->persistencia->getPuntosServBySupervisor($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($fecha1, true));
}

public function negocioinsertbanco($idbanco, $descbanco)
{
        //$log = new KLogger ( "negocioRegistrarDocumentosDigitalizados.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$documentacion : " . var_export ($documentacion, true));
    $lista = array();
    $lista = $this->persistencia->negocioinsertbanco($idbanco, $descbanco);
    return $lista;

}

public function negocioinsercuentabancaria($idbanco, $cuenta)
{
        //$log = new KLogger ( "negocioRegistrarDocumentosDigitalizados.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$documentacion : " . var_export ($documentacion, true));
    $lista = array();
    $lista = $this->persistencia->insertcuentabancaria($idbanco, $cuenta);
    return $lista;

}

public function negocio_ListaCuentasBancarias($idbanco)
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

    $listaBancos = $this->persistencia->traerListaCuentasBancarias($idbanco);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
    return $listaBancos;

}

public function negocio_obteneriva()
{
        //$log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

    $listaObtenerIva = array();
    $listaObtenerIva = $this->persistencia->listaObtenerIva();
        //$log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
    return $listaObtenerIva;
}

public function negocio_ListaSubDepartamentos($idDepto)
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);
    $listasubdepartamentos = array();
    $listasubdepartamentos = $this->persistencia->traerListaSubDepartamentos($idDepto);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
    return $listasubdepartamentos;

}

public function negocio_ListaClavesClasificacionesPorTipo($case, $valorClaves, $usuario, $check)
{
        // $log= new KLogger("negocio_ListaClavesClasificaciones.log", KLogger::DEBUG);

    $listaClavesClasificaciones = $this->persistencia->traerListaClavesClasificacionesPorTipo($case, $valorClaves, $usuario, $check);
        // $log -> LogInfo ("negocio_ListaClavesClasificaciones". var_export($usuario,true));
    return $listaClavesClasificaciones;

}

public function negocio_obtenercuentaclabeybanco($cuentaclabe, $lineanegocio)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $datos = array();
    $datos = $this->persistencia->obtenercuentaclabeybanco($cuentaclabe, $lineanegocio);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $datos;
}

public function negocio_obtenerEmpleadoAuthCaja($entidademp, $consecutivo, $categoriaemp)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $datos = array();
    $datos = $this->persistencia->obtenerEmpleadoAuthCaja($entidademp, $consecutivo, $categoriaemp);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $datos;
}

public function negocio_insertAuthCaja($entidademp, $consecutivo, $categoriaemp, $id)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

        //$datos = array();
    $this->persistencia->insertAuthCaja($entidademp, $consecutivo, $categoriaemp, $id);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
        //return $datos;
}
public function negocio_ListaEmpleadosCaja()
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);
    $listaEmpeado = array();
    $listaEmpeado = $this->persistencia->traerListaListaEmpleadosCaja();
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
    return $listaEmpeado;

}
public function negocio_Generador($entidad, $consecutivo, $categoria)
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);
    $listagenerador = array();
    $listagenerador = $this->persistencia->traerListagenerador($entidad, $consecutivo, $categoria);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
    return $listagenerador;

}

public function negocio_RegistrarMovimientoCobranza($movimientocobranza, $usuario)
{
    if ($movimientocobranza["numeroReferencia1"] == ""){
        throw new Exception("Ingrese Un Numero De Referencia");}

        else if ($movimientocobranza["numeroReferencia1"] != ""
            && $this->persistencia->existeReferenciaMovimiento($movimientocobranza["numeroReferencia1"])) {
            throw new Exception("El numero de referencia ya se registró previamente");}
        else{
        // $log= new KLogger("negocio.log", KLogger::DEBUG);
            $idMovCobranzamax = array();
            $idMovCobranzamax = $this->persistencia->insertarMovimientoCobranza($movimientocobranza, $usuario);
        // $log -> LogInfo ("negocio_Movimientocobranza". var_export($movimientocobranza,true));
            return $idMovCobranzamax;
        }
    }
    public function negocio_RegistrarMovimientoCobranza1($Registro_MovimientoCobranza, $ImpFactura, $SelectPeriodoFac, $Ejercicio, $SelectPeriodoCo, $selectLineaNegocio, $selectEntidades, $txtSubTotal, $txtDescuento, $txtIva, $IvaCalculado, $Total)
    {
        // $log= new KLogger("negocio.log", KLogger::DEBUG);

        $this->persistencia->insertarMovimientoCobranza1($Registro_MovimientoCobranza, $ImpFactura, $SelectPeriodoFac, $Ejercicio, $SelectPeriodoCo, $selectLineaNegocio, $selectEntidades, $txtSubTotal, $txtDescuento, $txtIva, $IvaCalculado, $Total);
        // $log -> LogInfo ("negocio_Movimientocobranza". var_export($movimientocobranza,true));

    }

    public function negocio_obtenerTotalEntidadcobro($idEntidad, $ejercicio, $mes, $lineanegocio, $accion)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listatotales = array();
        $listatotales = $this->persistencia->obtenerTotalEntidadcobro($idEntidad, $ejercicio, $mes, $lineanegocio, $accion);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listatotales;
    }

    public function negocio_RegistrarMovimientoComprobacion($impid,$inBeneficiarioCompro,$inConceptoCompro,$inNumeroReferenciaCompro,
      $inSubTotalCompro,$inDescuentoCompro,$inIvaRetenidoCompro,$inselectIvaCompro,$inTotalCompro)
    {
        $idMovComprobaMax = array();
        //$log->LogInfo("Valor de la variable \$Archivo : " . var_export ($movimientoComprobaciones, true));
        $idMovComprobaMax = $this->persistencia->insertarMovimientoComprobacion($impid,$inBeneficiarioCompro,$inConceptoCompro,$inNumeroReferenciaCompro,$inSubTotalCompro,$inDescuentoCompro,$inIvaRetenidoCompro,$inselectIvaCompro,$inTotalCompro);
        
        return $idMovComprobaMax;
    }

    public function negocio_obtenerEmpleadoFini($empleadoId)
    {
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

        $empleado = array();
        $empleado = $this->persistencia->obtenerEmpleadoFini($empleadoId);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
        return $empleado;
    }

    public function actualizarEstatuCargaArchivo($numempelado, $fechabaja, $fechaalta)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaGeneros = $this->persistencia->actualizarEstatuCargaArchivo($numempelado, $fechabaja, $fechaalta);
        //$log -> LogInfo ("negocio_obtenerCatalogoGeneros". var_export($listaGeneros,true));
        return $listaGeneros;

    }
    public function negocio_ListaCuentasBancos()
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaBancos = $this->persistencia->ListaCuentasBancos();
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $listaBancos;

    }

    public function negocio_ListaSaldosPorCuentas($idbanco, $idnumcuenta)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);
        $listasaldosporcuenta = array();
        $listasaldosporcuenta = $this->persistencia->saldosporcuentasbancarias($idbanco, $idnumcuenta);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $listasaldosporcuenta;

    }

    public function negocio_ListaMontosPorCuentas($numcuenta)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);
        $listamontosporcuenta = array();
        $listamontosporcuenta = $this->persistencia->montoporcuentasbancarias($numcuenta);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $listamontosporcuenta;

    }

    public function negocio_cargosiniciales($idbanco)
    {
        //$log= new KLogger("negocioListaSaldosDia.log", KLogger::DEBUG);

        $listaSaldosDia = $this->persistencia->traerSaldosIniciales($idbanco);
        //$log -> LogInfo ("negocio_ListaSaldosIncialesDelDia". var_export($listaSaldosDia,true));
        return $listaSaldosDia;

    }

    public function negocio_obtenerhistoricoedicion($usuario)
    {
        //   $log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listahistoricoedit = array();
        //   $log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($usuario, true));
        $listahistoricoedit = $this->persistencia->traelistahistoricoedicion($usuario);
        return $listahistoricoedit;
    }
    public function negocio_actualizarhistoricoedicion($idEdicion, $usuario)
    {
        //  $log = new KLogger ( "negocioedicion.log" , KLogger::DEBUG );

        $actuallistahistoricoedit = array();

        //  $log->LogInfo("Valor de la variable \$actuallistahistoricoedit: " . var_export ($idEdicion, true));

        $actuallistahistoricoedit = $this->persistencia->actualizarlistahistoricoedicion($idEdicion, $usuario);
        return $actuallistahistoricoedit;
    }

    public function negocio_ObtenerTotalDisponible($idbanco)
    {
        //$log= new KLogger("negocioListaSaldosDia.log", KLogger::DEBUG);

        $totalDisponible = $this->persistencia->traerTotalDisponible($idbanco);
        //$log -> LogInfo ("negocio_ListaSaldosIncialesDelDia". var_export($listaSaldosDia,true));
        return $totalDisponible;

    }
//////////////////////////////////////////********************************PARA EL MODULO DE CONTRATACIONES********************************//////////////////////////////////////////

    public function getplantillasparaselectorcontrataciones($puestoPlantillaId, $tipoTurnoPlantillaId, $puntoServicioPlantillaId)
    {
        //$log = new KLogger ( "negocio_getServicioPlantillaPerfil.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$puestoPlantillaId: " . var_export ($puestoPlantillaId, true));
        //$log->LogInfo("Valor de la variable \$tipoTurnoPlantillaId: " . var_export ($tipoTurnoPlantillaId, true));
        //$log->LogInfo("Valor de la variable \$generoElementoId: " . var_export ($generoElementoId, true));
        //$log->LogInfo("Valor de la variable \$puntoServicioPlantillaId: " . var_export ($puntoServicioPlantillaId, true));

        $lista = array();
        $lista = $this->persistencia->getplantillasparaselectorcontrataciones($puestoPlantillaId, $tipoTurnoPlantillaId, $puntoServicioPlantillaId);
        return $lista;
    }

    public function negocio_insertLibroSaldos($selectTipoDeBanco, $selectNumCuenta)
    {
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );
        //$datos = array();
        $this->persistencia->insertLibroSaldos($selectTipoDeBanco, $selectNumCuenta);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
        //return $datos;
    }

    public function negocio_traedatosservplantillasbyidpuntoserv($idpuntoserv,$idpuesto)
    {
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );
        //$datos = array();
        $lista = array();
        $lista = $this->persistencia->traedatosservplantillasbyidpuntoserv($idpuntoserv,$idpuesto);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
        //return $datos;
        return $lista;
    }
    public function negocio_insertLibroSaldosMovimientos($selectTipoDeBanco,$selectNumCuenta,$monto,$Case )
    {
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );
        //$datos = array();
        $this->persistencia->insertLibroSaldosMovimientos($selectTipoDeBanco,$selectNumCuenta,$monto,$Case);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
        //return $datos;
    }

    public function negocio_callProcedureInserSaldoInicialDiario($idbanco, $idnumcuenta)
    {
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );
        //$datos = array();
        $this->persistencia->callProcedureInserSaldoInicialDiario($idbanco, $idnumcuenta);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
        //return $datos;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function negocioinserempresa($empresa)
    {
        //    $log = new KLogger ( "negocioRegistrarDocumentosDigitalizados.log" , KLogger::DEBUG );

        $lista = $this->persistencia->insertempresa($empresa);
        // $log->LogInfo("Valor de la variable \$lista : " . var_export ($lista, true));

    }

    public function negocio_mostrarempresas()
    {
        //   $log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listaempresas = array();
        //   $log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($usuario, true));
        $listaempresas = $this->persistencia->traelistaempresas();
        return $listaempresas;
    }

    public function negocio_activarDesactivarEmpresa($idempresa, $valorupdate)
    {
        $this->persistencia->activarDesactivarEmpresa($idempresa, $valorupdate);
    }

    public function negocio_RegistrarMovimientoTransferencia($movimientotransferencia)
    {
//$log = new KLogger ( "negocioArchivo.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$Archivo : " . var_export ($archivostr, true));
        $decimaltransferencia = '/^[0-9]+([.])?([0-9]+)?$/';
        if ($movimientotransferencia["selbancoOrigen"] == "0") {
            throw new Exception("Ingrese El Banco De Origen");
        }
        if ($movimientotransferencia["selnumcuentaOrigen"] === "0") {
            throw new Exception("Ingrese El Numero De Cuenta Origen");
        }
        if ($movimientotransferencia["saldoDisponibleOrigen"] === "" || $movimientotransferencia["saldoDisponibleOrigen"] == 0) {
            throw new Exception("No Cuenta Con Saldo En Este Numero De Cuenta Origen");
        }
        if ($movimientotransferencia["selBancoDestino"] === "0") {
            throw new Exception("Ingrese El Banco De Destino");
        }
        if ($movimientotransferencia["selnumCuentaDestino"] == "0") {
            throw new Exception("Ingrese El Numero De Cuenta Destino");
        }
        if ($movimientotransferencia["saldoDestino"] === "" ||
            preg_match($decimaltransferencia, $movimientotransferencia["saldoDestino"]) == false) {
            throw new Exception("Ingrese El Monto a Transferir Correcto");
    }
    if ($movimientotransferencia["numeroFolio"] == "") {
        throw new Exception("Ingrese El Numero De Folio");
    }
    if ($movimientotransferencia["selnumcuentaOrigen"] === $movimientotransferencia["selnumCuentaDestino"]) {
        throw new Exception("No Puedes Realizar Una Transferencia Al Mismo Numero De Cuenta");
    }
    if ($movimientotransferencia["saldoDisponibleOrigen"] < $movimientotransferencia["saldoDestino"]) {
        throw new Exception("No Puedes Enviar Mas Dinero Del Disponible");
    }
        // $log->LogInfo("Valor de la variable \$Archivo : " . var_export ($archivo, true));
    $this->persistencia->insertarMovimientotransferencia($movimientotransferencia);
}

public function negocio_obtenerFiniquitoPorConfirmar($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria)
{

    $lista = array();

    $lista = $this->persistencia->obtenerFiniquitoPorConfirmar($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));
    return $lista;
}

public function negocio_obtenerListaClaveClasificacion($lineanegociogastocosto, $usuario)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listaConceptos = array();
    $listaConceptos = $this->persistencia->traeCatalogoClaveClasificacion($lineanegociogastocosto, $usuario);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $listaConceptos;
}
public function negocio_obtenerTotalGastoCosto($lineanegociogastocosto, $claveclasi, $entidasgastocosto,
    $acciongastocosto, $fechafinal, $fechainicio) {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listatotalesgastocosto = array();
    $listatotalesgastocosto = $this->persistencia->obtenerTotalGastoCosto($lineanegociogastocosto, $claveclasi, $entidasgastocosto,
        $acciongastocosto, $fechafinal, $fechainicio);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $listatotalesgastocosto;
}

public function getTabuladorSueldosPlantillasinactivas()
{
    $lista = array();
    $lista = $this->persistencia->getTabuladorSueldosPlantillasinactivas();
    return $lista;
}
public function getTabuladorSueldosByPuntoServicioplantillasinactivas($puntoServicioName)
{

    $lista = array();

    $lista = $this->persistencia->getTabuladorSueldosByPuntoServicioplantillasinactivas($puntoServicioName);
    return $lista;

}
public function activar_plantilla_PuntoServicio($flagactivacion, $idpuntoservicio, $idplantilla)
{
    $tipodeactivacion = $this->persistencia->activar_plantilla_PuntoServicio($flagactivacion, $idpuntoservicio, $idplantilla);
    return $tipodeactivacion;
}

public function negocio_RegistrarMovimientoCargo($movimientoCargo)
{
    $archivostrCargo = $movimientoCargo["DocPdfCargo"];
    $archivosfCargo  = substr($archivostrCargo, -4);
    $archivoCargo    = strtolower($archivosfCargo);
    $decimalCargo    = '/^[0-9]+([.])?([0-9]+)?$/';
        //      $log = new KLogger ( "negocioArchivo.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la variable \$Archivo : " . var_export ($archivostr, true));

    if ($movimientoCargo["fechaMovimientoCargo"] == "") {
        throw new Exception("Ingrese Fecha");
    }
    if ($movimientoCargo["lineaNegocioCargo"] === "0") {
        throw new Exception("Seleccione la linea de negocio");
    }
    if ($movimientoCargo["claveClasificacionMCargo"] === "0") {
        throw new Exception("Seleccione clave de clasificacion");
    }
    if ($movimientoCargo["selectTipoDeBancoCargo"] == "0") {
        throw new Exception("Ingrese El Banco");
    }
    if ($movimientoCargo["selectNumCuentaCargo"] === "0") {
        throw new Exception("Ingrese El Numero De Cuenta");
    }
    if ($movimientoCargo["idTipoTransaccionMCargo"] == "TIPO TRANSACCION" || $movimientoCargo["idTipoTransaccionMCargo"] == "0") {
        throw new Exception("Seleccione el tipo de transaccion");
    }
    if ($movimientoCargo["empresaCargo"] == "0") {
        throw new Exception("Ingrese La Empresa");
    }
    if ($movimientoCargo["beneficiarioCargo"] == "") {
        throw new Exception("Ingrese un Beneficiario");
    }
    if ($movimientoCargo["txtSubTotalCargo"] == "" || preg_match($decimalCargo, $movimientoCargo["txtSubTotalCargo"]) == false) {
        throw new Exception("Verifique El Sub Total");
    }
    if ($movimientoCargo["txtDescuentoCargo"] == "" || preg_match($decimalCargo, $movimientoCargo["txtDescuentoCargo"]) == false) {
        throw new Exception("Verifique El Descuento");
    }
    if ($movimientoCargo["txtIvaCargo"] === "0") {
        throw new Exception("Elija El Iva");
    }
    if ($movimientoCargo["txtIvaRetenidoCargo"] == "" || preg_match($decimalCargo, $movimientoCargo["txtIvaRetenidoCargo"]) == false) {
        throw new Exception("Verifique El Iva Retenido");
    }
    if ($movimientoCargo["entidadCargo"] === "0" || $movimientoCargo["entidadCargo"] === "ENTIDAD") {
        throw new Exception("Seleccione la entidad");
    }
    if ($movimientoCargo["referenciaCargo"] == ""){
        throw new Exception("Ingrese El Numero De Referencia Del Movimiento");
    }
    if ($movimientoCargo["referenciaCargo"] != ""
        && $this->persistencia->existeReferenciaMovimiento($movimientoCargo["referenciaCargo"])) {
        throw new Exception("El numero de referencia ya se registró previamente");
}
if ($movimientoCargo["conceptoCargo"] == "") {
    throw new Exception("Ingrese Concepto");
}
if ($archivoCargo == "" || $archivoCargo != ".pdf") {
    throw new Exception("Seleccione un Archivo Correcto Tipo .pdf");
}
if ($movimientoCargo["referenciaCargo"] != ""
    && $this->persistencia->existeReferenciaMovimiento($movimientoCargo["referenciaCargo"])) {
    throw new Exception("El numero de referencia ya se registró previamente.");
}
if ($movimientoCargo["idEstatusMCargo"] == "") {
    throw new Exception("Error en el estatus del movimiento");
}
        // $log->LogInfo("Valor de la variable \$Archivo : " . var_export ($archivo, true));
$this->persistencia->insertarMovimientoCargo($movimientoCargo);
}

public function negocio_obtenerClavesComprobacione($usuario)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $claves = array();
    $claves = $this->persistencia->obtenerClavesComprobacione($usuario);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $claves;
}

public function negocio_RegionesPorLineaNegocio($idlineanegocio,$idEntidad,$accion)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $regiones = array();
    $regiones = $this->persistencia->RegionesPorLineaNegocio($idlineanegocio,$idEntidad,$accion);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $regiones;
}

public function negocio_obtenerlistasolicitudpago($usuario,$usuario1)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listasolicitud = array();
    $listasolicitud = $this->persistencia->listaSolicitudpago($usuario,$usuario1);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $listasolicitud;
}

public function negocio_actualizartablasolicitudepago($estatus,$accion,$usuario)
{
        //  $log = new KLogger ( "negocioedicion.log" , KLogger::DEBUG );

    $actualtablasolicitudepago = array();

        //  $log->LogInfo("Valor de la variable \$actuallistahistoricoedit: " . var_export ($idEdicion, true));

    $actualtablasolicitudepago= $this->persistencia->actualizartablasolicitudepago($estatus,$accion,$usuario);
    return $actualtablasolicitudepago;
}


public function negocio_getcatbancosSolicitudPago($ctaclabe)
{
        //  $log = new KLogger ( "negocioedicion.log" , KLogger::DEBUG );

    $banco = array();

        //  $log->LogInfo("Valor de la variable \$actuallistahistoricoedit: " . var_export ($idEdicion, true));

    $banco= $this->persistencia->getcatbancosSolicitudPago($ctaclabe);
    return $banco;
}


public function negocio_getlistaClavesSolicitudPago($lineanegocio)
{
        //  $log = new KLogger ( "negocioedicion.log" , KLogger::DEBUG );

    $listaclaves = array();

        //  $log->LogInfo("Valor de la variable \$actuallistahistoricoedit: " . var_export ($idEdicion, true));

    $listaclaves= $this->persistencia->getlistaClavesSolicitudPago($lineanegocio);
    return $listaclaves;
}

public function negocio_TraeUltimoId()
{
        //  $log = new KLogger ( "negocioedicion.log" , KLogger::DEBUG );

    $ultimiId = array();

        //  $log->LogInfo("Valor de la variable \$actuallistahistoricoedit: " . var_export ($idEdicion, true));

    $ultimiId= $this->persistencia->getUltimoId();
    return $ultimiId;
}
public function negocio_InsertSolicitudPago($formulario,$usuario)
{
        //  $log = new KLogger ( "negocioedicion.log" , KLogger::DEBUG );
        // $ultimiId = array();
        //  $log->LogInfo("Valor de la variable \$actuallistahistoricoedit: " . var_export ($idEdicion, true));
    $this->persistencia->InsertSolicitudPago($formulario,$usuario);
       // return $ultimiId;
}

public function negocio_obtenerultimoid()
{
    $obtultimoid = array();

    $obtultimoid = $this->persistencia->obtenerultimoid();

    return $obtultimoid;
}

public function negocio_obtenerlistacomprobaciones($accioncomprobacionesdeabonos,$lineanegociocomprobacionesdeabonos,$entidadescomprobacionesdeabonos,$fechafinalcomprobacionesdeabonos,$fechainiciocomprobacionesdeabonos)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listacomprobaciones = array();
    $listacomprobaciones = $this->persistencia->traelistacomprobaciones($accioncomprobacionesdeabonos,$lineanegociocomprobacionesdeabonos,$entidadescomprobacionesdeabonos,$fechafinalcomprobacionesdeabonos,$fechainiciocomprobacionesdeabonos);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $listacomprobaciones;
}
public function negocio_actualizartablalibromovimiento($idmovimiento,$accionSoli)
{
    $this->persistencia->actualizartablalibromovimiento($idmovimiento,$accionSoli);
}

public function negocio_obteneridlineanegocio($usuario,$usuarioentidad)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $obteneridlineanegocio = array();
    $obteneridlineanegocio = $this->persistencia->obteneridlineanegocio($usuario,$usuarioentidad);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $obteneridlineanegocio;
}

public function negocio_obtenerlistacomprobacionesconysinsolicitud($caso,$usuarioentidad,$idlinea,$usuario1)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

          //$log->LogInfo("Valor de la variables" . var_export ($caso, true).var_export ($usuario, true).var_export ($usuarioentidad, true));

    $listacomprobacionesconysinsolicitud = array();
    $listacomprobacionesconysinsolicitud = $this->persistencia->listacomprobacionesconysinsolicitud($caso,$usuarioentidad,$idlinea,$usuario1);
    
    return $listacomprobacionesconysinsolicitud;
}

public function negocio_Actualizarestatuscomprobacion($idlibromovimientos,$casoactulizar)
{
    $this->persistencia->Actualizarestatuscomprobacion($idlibromovimientos,$casoactulizar);
}
public function negocio_obtenertamañoporid($id,$idtipo)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
    $tamañoid = array();
    $tamañoid = $this->persistencia->traelistaporid($id,$idtipo);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $tamañoid;
}
public function negocio_obtenerLineadenegociogastocosto($case,$j)
{ 
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
    $listalineanegociogastocosto = array();
    $listalineanegociogastocosto = $this->persistencia->traerlineanegociogastocosto($case,$j);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $listalineanegociogastocosto;
}



public function negocio_actulizartblAsistenciaAPlicodiferencias($datos)
{ 
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        //$listalineanegociogastocosto = array();
    $listalineanegociogastocosto = $this->persistencia->actulizartblAsistenciaAPlicodiferencias($datos);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        //return $listalineanegociogastocosto;
}


public function getDeducciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$case)
{ 
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
    $deducciones = array();
    $deducciones = $this->persistencia->getDeducciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$case);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $deducciones;
}

public function negocio_ValidacionReferenciaComprobaciones($numreferencia)
{
    
    if ($this->persistencia->existeReferenciaMovimiento($numreferencia)) {
        throw new Exception("");}  
    }

    public function getcatplacas()
    {
        $resultado = array();

        $resultado = $this->persistencia->getcatalogoplacas();

        return $resultado;

    }

    public function negocio_ListaModalidasPlacas($idPlacas)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaPlacas = $this->persistencia->traerListaModalidesPlacas($idPlacas);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $listaPlacas;

    }

    public function negocio_DatoEstructuraPlacas($idmodalidadplacas)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $EstructuraPlacas = $this->persistencia->traerEstructuraDePlacas($idmodalidadplacas);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $EstructuraPlacas;

    }

    public function getcatMarcas($valorselectorTipoDeVehiculo)
    {
        $Marca = array();

        $Marca = $this->persistencia->getcatalogomarcas($valorselectorTipoDeVehiculo);

        return $Marca;

    }

    public function negocio_ListaModelosxMarca($idMarca)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $listaMarca = $this->persistencia->traerListaModeloXMarca($idMarca);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $listaMarca;

    }

    public function getcatTipoDeVehiculos()
    {
        $tipoVehiculo = array();

        $tipoVehiculo = $this->persistencia->getcatalogotipovehiculos();

        return $tipoVehiculo;

    }

    public function registrarVehiculo($Rvehiculo)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->insertarRegistroDeVehiculos($Rvehiculo);
    }


    public function updateBajas_Uniformes_envioLavanderia($idIncrementUniformes,$ultimofolio,$iteracion,$entidadEnvio,$sucursalEnvio)
    {
        //$tipoVehiculo = array();
        $cantidadUniformes=1;
        $this->persistencia->updateBajas_Uniformes_envioLavanderia($idIncrementUniformes);
        if($iteracion==0){
            $this->persistencia->enviarLavanderia($ultimofolio, $entidadEnvio,$sucursalEnvio);

        }
        $this->persistencia->insertarDetalleLavanderia($ultimofolio, $idIncrementUniformes, $cantidadUniformes);

        //return $tipoVehiculo;
    }

    

    public function getcatColores($caso)
    {
        $Color = array();

        $Color = $this->persistencia->getcatalogoColores($caso);

        return $Color;

    }



    public function negocio_consultaultimofolioenviarLavanderia()
    {
        $ultimoFolio = array();

        $ultimoFolio = $this->persistencia->consultaultimofolioenviarLavanderia();
        return $ultimoFolio;

    }

    public function negocio_consultaFoliosdeUniformesEnviadosLavan($entidadUsuario,$sucursalesArreglo)
    {

        $FoliosEnviosLava = array();

        $FoliosEnviosLava = $this->persistencia->consultaFoliosdeUniformesEnviadosLavan($entidadUsuario,$sucursalesArreglo);

        return $FoliosEnviosLava;

    }
    public function negocio_consultaDetallesEnvioLavanderia($folio)
    {

        $detalleUniformes= array();

        $detalleUniformes = $this->persistencia->consultaDetallesEnvioLavanderia($folio);

        return $detalleUniformes;

    }
    public function negocio_UpdateFolioRecibidoFromLavanderia($folio,$costoNotaFactura,$folioRecibidoLavan)
    {

        
        $this->persistencia->UpdateFolioRecibidoFromLavanderia($folio,$costoNotaFactura,$folioRecibidoLavan);
    }

    public function negocio_RecepcionAStockFromLavanderia($idsUniformes,$usuarioEntidad,$idunicoBajaUniforme)
    {

        
        $this->persistencia->RecepcionAStockFromLavanderia($idsUniformes,$usuarioEntidad,$idunicoBajaUniforme);
    }
    public function negocio_DestruccionFromLavanderia($idunicoBajaUniforme)
    {

        
        $this->persistencia->DestruccionFromLavanderia($idunicoBajaUniforme);
    }
    public function negocio_ReturnConsultaRecibidos($idunicoBajaUniforme)
    {

        
        $this->persistencia->ReturnConsultaRecibidos($idunicoBajaUniforme);
    }

    public function getnumeco()
    {
        $numeco = array();
        $numeco = $this->persistencia->getnumeroeconomico();

        return $numeco;

    }

    public function getcatTarjeta()
    {
        $TarjetaCirculacion = array();

        $TarjetaCirculacion = $this->persistencia->getcatalogoTarjetaCierculacion();

        return $TarjetaCirculacion;

    }
    public function getcatmotor()
    {
        $motor = array();

        $motor = $this->persistencia->getcatalogoNumMotor();

        return $motor;

    }

    public function getCatalogEstadoVehiculo()
    {
        $Evehiculo = array();

        $Evehiculo = $this->persistencia->getcatalogoEstadovehiculo();

        return $Evehiculo;

    }

    public function getCatalogoAseguradora()
    {
        $Aseguradora = array();

        $Aseguradora = $this->persistencia->getcatalogoAseguradorid();

        return $Aseguradora;

    }

    public function getcatTipoDeCobertura()
    {
        $tipocobertura = array();

        $tipocobertura = $this->persistencia->getcatalogotipoCoberturas();

        return $tipocobertura;

    }
    public function registrarDatosGenerasPoliza($DatosPoliza,$idVehiculoR)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->insertarDatosGenerasPoliza($DatosPoliza,$idVehiculoR);
    }
    public function registrarAccesoriosVehiculo($AccesorosVehiculos,$idVehiculoaccesoriosR)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->insertarAccesoriosVehiculo($AccesorosVehiculos,$idVehiculoaccesoriosR);
    }

    public function getCatalogCilindros()
    {
        $Evehiculo = array();

        $Evehiculo = $this->persistencia->getcatalogoCilindrosVehiculos();

        return $Evehiculo;

    }

    public function getdatosvehiuclares($consultavehicular,$valordelcampodeconsulta)
    {
        $datosvehiculo = array();

        $datosvehiculo = $this->persistencia->getdatosdelvehiculo($consultavehicular,$valordelcampodeconsulta);

        return $datosvehiculo;

    }


    public function negocio_getrolUsuariosEmpleado($usuario)
    {
        $datosvehiculo = array();

        $datosvehiculo = $this->persistencia->getrolUsuariosEmpleado($usuario);

        return $datosvehiculo;

    }

    public function negocio_obtenerFolioPreseleccionReingreso($curpBusqueda,$numeroAfiliacionImss)
    {
        //$log = new KLogger("negocio.log", KLogger::DEBUG);
        $datosEMpleadoPreseleccion = array();
        $datosEMpleadoPreseleccion = $this->persistencia->obtenerFolioPreseleccionReingreso($curpBusqueda,$numeroAfiliacionImss);
        //$log -> LogInfo("Valor de array listaIdentificaciones". var_export($listaIdentificaciones, true));
        return $datosEMpleadoPreseleccion;
    }

    public function negocio_obtenerCatalogo_Rgn()
    {
        // $log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

        $catRgn = array();
        $catRgn = $this->persistencia->traeCatalogorgn();
        //  $log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
        return $catRgn;
    }

    public function negocio_obtenerCatalogo_Proveedor()
    {
        // $log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

        $Proveedor = array();
        $Proveedor = $this->persistencia->traeCatalogoProveedor();
        //  $log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
        return $Proveedor;
    }

    public function negocio_obtenerCatalogo_Analista()
    {
        // $log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

        $Analista = array();
        $Analista = $this->persistencia->traeCatalogoAnalista();
        //  $log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
        return $Analista;
    }

    public function negocio_obtenerCatalogo_Canal()
    {
        // $log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

        $Canal = array();
        $Canal = $this->persistencia->traeCatalogoCanal();
        //  $log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
        return $Canal;
    }

    public function obtenerCatalogoAbecedario()
    {
        // $log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

        $abc = array();
        $abc = $this->persistencia->traeCatalogoCatalogoAbecedario();
        //  $log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
        return $abc;
    }

    public function negocio_MaterialxLetra($selectLetraInicial)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $regiones = array();
        $regiones = $this->persistencia->Obtener_MaterialxLetra($selectLetraInicial);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $regiones;
    }
    public function negocio_Costomaterial($selectMaterial)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $CostoMaterial = array();
        $CostoMaterial = $this->persistencia->Obtener_CostoMaterial($selectMaterial);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $CostoMaterial;
    }

    public function negocio_registrarNuevaSucursal($NuevaSucursal)
    {
        $this->persistencia->insertarNuevaSucursal($NuevaSucursal);
    }


    public function traerCatalogoVehiculos($casoVehiculo)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $listavehicular = $this->persistencia->obtenerCatalogoVehiculos($casoVehiculo);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $listavehicular;
    }
    public function negocio_registrarAsignacion($NuevaAsignacion)
    {
        $this->persistencia->insertarNuevaAsignacion($NuevaAsignacion);
    }

    public function negocio_registrarreasignacion($NuevaReasignacion)
    {
        $this->persistencia->UpdateReasignacion($NuevaReasignacion);
    }


    public function negocio_InsertarEnHistorico($numeroeconomico,$CuentaConGifHistorico)
    {
        $this->persistencia->InsertarEnHistorico($numeroeconomico,$CuentaConGifHistorico);
    }

    public function HistoricoEdiconVehiculo($VehiculoHistoricoEdicion)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->InsertarHistoricoEdiconVehiculo($VehiculoHistoricoEdicion);
    }

    public function ActualizarVehiculo($EdicionVehiculo)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->updateEdicionVehiculo($EdicionVehiculo);
    }


    public function negocio_obtenerUsuariosEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

        $UserByEmpleado = $this->persistencia->obtenerUsuariosEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $UserByEmpleado;

    }
    public function negocio_obtenerEntidadesByIdUser($usuarioId)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

        $EnitidadesByUser = $this->persistencia->obtenerEntidadesByIdUser($usuarioId);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $EnitidadesByUser;

    }
    public function negocio_EliminarEntidadUSer($idusuario,$identidad)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $respuesta =$this->persistencia->EliminarEntidadUSer($idusuario,$identidad);
        return $respuesta;
    }
    public function negocio_EliminarLineaNegocioUSer($idusuario,$idlineanegocio)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $respuesta =$this->persistencia->EliminarLineaNegocioUSer($idusuario,$idlineanegocio);
        return $respuesta;
    }

    public function negocio_addEntidadUSer($idusuario,$identidad)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $respuesta =$this->persistencia->addEntidadUSer($idusuario,$identidad);
        return $respuesta;
    }

    public function negocio_addLineaNegocioUSer($idusuario,$idlineanegocio)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $respuesta =$this->persistencia->addLineaNegocioUSer($idusuario,$idlineanegocio);
        return $respuesta;
    }
    public function DarDeBajaVehiculo($usuarioCapturaBaja,$numeroeconomicoBaja,$selMotivoBaja1,$selMotivoSiniestro1,$numeroeconomicoconsulta1,$numeroPlacas1,$inpNumeroDeSerie1,$ComentariosBaja1,$DocFiniquitoHiden,$DocChequesHiden)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->UpdateBajaVehiculo($usuarioCapturaBaja,$numeroeconomicoBaja,$selMotivoBaja1,$selMotivoSiniestro1,$numeroeconomicoconsulta1,$numeroPlacas1,$inpNumeroDeSerie1,$ComentariosBaja1,$DocFiniquitoHiden,$DocChequesHiden);
    }

    public function getMotivoBaja($TipoSelector)
    {
        $resultado = array();

        $resultado = $this->persistencia->getCatalagoMotivoBaja($TipoSelector);

        return $resultado;

    }

    public function negocio_MotivoBajaSiniestro($selMotivoBaja1)
    {
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

        $MotivoSiniestro = $this->persistencia->traerMotivoBajaSiniestro($selMotivoBaja1);
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
        return $MotivoSiniestro;

    }

    public function ReingresarVehiculo($usuarioCapturareingreso,$numeroeconomicoReingreso2,$selMotivoReingreso2,$selMotivoSiniestro2,$numeroPlacas2,$inpNumeroDeSerie2,$ComentariosReingreso)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->UpdateReingresarVehiculo($usuarioCapturareingreso,$numeroeconomicoReingreso2,$selMotivoReingreso2,$selMotivoSiniestro2,$numeroPlacas2,$inpNumeroDeSerie2,$ComentariosReingreso);
    }

    public function traerCatalogoVehiculosasignados($entidadesusuario,$nombreusuario)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $listavehiculoAsignado = $this->persistencia->CatalogoVehiculosasignados($entidadesusuario,$nombreusuario);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $listavehiculoAsignado; //tus putas marranadas no sirven asi 
    }
    public function TraerDocLicencia($empleadoentidad,$empleadoConsecutivo,$empleadoCategoria)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $DocLicencia = $this->persistencia->TraerDocLicenciaLista($empleadoentidad,$empleadoConsecutivo,$empleadoCategoria);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $DocLicencia; //tus putas marranadas no sirven asi 
    }
    public function TraerDocTalon($NumeroEconomico)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $TalonVer = $this->persistencia->TraerDocTalonVerificacion($NumeroEconomico);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $TalonVer; //tus putas marranadas no sirven asi 
    }

    public function traerCatalogoVehiculosVerificacion($entidadesusuarioVerificacion,$nombreusuarioVerificacion,$fecha,$consulta,$color,$year1,$RolUsuarioVerificacion)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $listavehiculoVerificacion = $this->persistencia->CatalogoVehiculosVerificacion($entidadesusuarioVerificacion,$nombreusuarioVerificacion,$fecha,$consulta,$color,$year1,$RolUsuarioVerificacion);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $listavehiculoVerificacion;
    }

    public function getTurnosCubiertosByPeriodoFechasAndPuntoServicioconteo(
        $fecha,$puntoServicioId) {
        return $this->persistencia->getTurnosCubiertosByPeriodoFechasAndPuntoServicioconteo($fecha, $puntoServicioId);
    }

    public function getTurnosdeDiaoNoche($fecha, $puntoServicioId,$diaonoche) {
        return $this->persistencia->getTurnosdeDiaoNoche($fecha, $puntoServicioId,$diaonoche);
    }

    public function getBajasPorDias($fecha, $puntoServicioId,$opcion) {
        return $this->persistencia->getBajasPorDias($fecha, $puntoServicioId,$opcion);
    }
    public function negocio_obtenerListaClientesConteo($opcion,$idcliente)
    {
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

        $listaClientes = array();
        $listaClientes = $this->persistencia->traeCatalogoClientesconteo($opcion,$idcliente);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
        return $listaClientes;
    }

    

    public function RegistrarVerificacionVehiuclar($VerificacionesVehiculares)
    {
        //$log = new KLogger ( "negocio_registrarEmpleadoEntrevista.log" , KLogger::DEBUG );
        $this->persistencia->insertarRegistroDeVerificacionesVehiculares($VerificacionesVehiculares);
    }

    public function getultimadeduccionsubida($tipo)
    {
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

        $ultimadeduccion = array();
        $ultimadeduccion = $this->persistencia->getultimadeduccionsubida($tipo);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
        return $ultimadeduccion;
    }

    public function traerlistalicencias($entidadesusuarioLicencia,$nombreusuarioLicencia,$consulta,$RolUsuarioLicencia)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $ListaLicencias = $this->persistencia->ListaLicenciasEmpleados($entidadesusuarioLicencia,$nombreusuarioLicencia,$consulta,$RolUsuarioLicencia);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $ListaLicencias;
    }

    public function traerlistaTarjetasC($entidadesusuarioTarjetaC,$nombreusuarioTarjetaC,$consulta,$RolUsuarioTarjetaC)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $ListaTarjetasC = $this->persistencia->ListaTarjetaCVehiculos($entidadesusuarioTarjetaC,$nombreusuarioTarjetaC,$consulta,$RolUsuarioTarjetaC);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $ListaTarjetasC;
    }
    public function traerlistaPolizaV($entidadesusuarioPoliza,$nombreusuarioPoliza,$consulta,$RolUsuarioPoliza)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $ListaPolizas = $this->persistencia->ListaPolizaV($entidadesusuarioPoliza,$nombreusuarioPoliza,$consulta,$RolUsuarioPoliza);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $ListaPolizas;
    }

    public function getincidenciaspordiabycliente($idcliente,$fechadia,$usuario) {
        return $this->persistencia->getincidenciaspordiabycliente($idcliente,$fechadia,$usuario);
    }

    public function getincidenciasturnosdia($idcliente,$fechadia,$accion,$usuario) {
        return $this->persistencia->getincidenciasturnosdia($idcliente,$fechadia,$accion,$usuario);
    }

    public function traerlistaEdicionVehiculo($consulta,$FechaInicial,$FechaFinal)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $ListaEdicionVehiculos = $this->persistencia->listaEdicionVehiculo($consulta,$FechaInicial,$FechaFinal);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $ListaEdicionVehiculos;
    }

    public function traerlistaAsignacionVehiculo($consulta,$FechaInicial,$FechaFinal)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $ListaAsignacionVehiculos = $this->persistencia->listaAsignacionVehiculo($consulta,$FechaInicial,$FechaFinal);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $ListaAsignacionVehiculos;
    }

    public function traerHistoricoVerificacionVehiculo($consulta,$FechaInicial,$FechaFinal)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);
        $ListaHVerifiacionVehiculos = $this->persistencia->listaHistoricoVerifiacionVehiculo($consulta,$FechaInicial,$FechaFinal);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $ListaHVerifiacionVehiculos;
    }

    public function getEmpleadosEstatusOperacionesConCondiciones($usuario,$FechaInicio,$FechaFinal)
    {

        //$log = new KLogger ( "getEmpleadosEstatusOperaciones.log" , KLogger::DEBUG );

        $lista1 = array();

        $lista1 = $this->persistencia->TraerEmpleadosEstatusOperacionesConCondiciones($usuario,$FechaInicio,$FechaFinal);
        return $lista1;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

    }

    public function obtenerfecha($FechaDiaActual)
    {
        //$log = new KLogger ( "getEmpleadosEstatusOperaciones.log" , KLogger::DEBUG );
        $fechao = array();
        $fechao = $this->persistencia->Traerobtenerfecha($FechaDiaActual);
        return $fechao;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

    }

    
    public function consultaturnosdiaonochebyplantillaservicio($asistenciaFecha, $plantilladeservicio, $valordia,$puntoServicioId, $puestoCubiertoId,$idPlantillaServicio,$opcion)
    {
        //$log = new KLogger ( "negocio_getListaEmpleadosBySupervisorPeriodoPuntoServicio.log" , KLogger::DEBUG );
        $turnos = array();
        $turnos = $this->persistencia->consultaturnosdiaonochebyplantillaservicio($asistenciaFecha, $plantilladeservicio, $valordia,$puntoServicioId, $puestoCubiertoId,$idPlantillaServicio,$opcion);
        return $turnos;
        //$log->LogInfo("Valor de la idCliente \$turnos : " . var_export ($turnos, true));

    }

    public function negocio_ObtenerCantidadEmleadosPlantilla($idPuntosDeServicio,$idPlantilla)
    {
        // $log = new KLogger ( "negocio_obtenerListaLineaNegocio.log" , KLogger::DEBUG );

        $ListaCantidadEmpleados = array();
        $ListaCantidadEmpleados = $this->persistencia->ObtenerCantidadEmleadosPlantilla($idPuntosDeServicio,$idPlantilla);
        //  $log->LogInfo("Valor de la variable \$listaLineaNegocio: " . var_export ($listaLineaNegocio, true));
        return $ListaCantidadEmpleados;
    }
    public function getEstatusEmpleadoXFecha($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria)
    {
        $EstatusEmpFecha = array();

        $EstatusEmpFecha = $this->persistencia->ObtenerEstatusEmpleadoXFecha($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);

        return $EstatusEmpFecha;

    }

    public function PeticionIncidenciaEspecial(
        $empleado,
        $supervisor,
        $incidenciaId,
        $asistenciaFecha,
        $usuarioCapturaAsistencia,
        $comentariIncidencia, $tipoPeriodo,
        $incidenciaPuesto, $plantilladeservicio,$idPlantillaServicio,$selectMotivoIncidenciaEspecial) {
        $result          = array();
        $errorValidacion = false;
        if (empty($empleado) ||
            empty($supervisor) ||
            $incidenciaId == "" ||
            $asistenciaFecha == "" ||
            $usuarioCapturaAsistencia == "" ||
            $tipoPeriodo == "" ||
            $incidenciaPuesto == "" ||
            $incidenciaPuesto == "PUESTO" ||
            $plantilladeservicio == "0" || $plantilladeservicio == "PLANTILLA" ||
            !isset($empleado["entidadId"]) || $empleado["entidadId"] == "" ||
            !isset($empleado["consecutivoId"]) || $empleado["consecutivoId"] == "" ||
            !isset($empleado["tipoId"]) || $empleado["tipoId"] == "" ||
            !isset($empleado["puntoServicioId"]) || $empleado["puntoServicioId"] == "" ||
            !isset($supervisor["entidadId"]) || $supervisor["entidadId"] == "" ||
            !isset($supervisor["consecutivoId"]) || $supervisor["consecutivoId"] == "" ||
            !isset($supervisor["tipoId"]) || $supervisor["tipoId"] == "") {
            $errorValidacion   = true;
        $result["status"]  = "error";
        $result["message"] = "No se proporcionaron todos los datos necesarios para el registro de asistencia";
    }
    if (!$errorValidacion) {
        $registro = $registrado = $this->persistencia->registrarPeticionIncidenciaEspecial(
            $empleado,
            $supervisor,
            $incidenciaId,
            $asistenciaFecha,
            $usuarioCapturaAsistencia,
            $comentariIncidencia, $tipoPeriodo, $incidenciaPuesto, $plantilladeservicio,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);
        if ($registro == true) {
            $result["status"]  = "success";
            $result["message"] = "Tu peticion de incidencia especial sera procesada una vez confirmada se contabilizara tu incidencia";
        }else{
          $result["status"]  = "errorbd";
          $result["message"] = "Error en BD no administrado";
      }
  }
  return $result;
}



public function getPeticionesIncidenciasEspeciales()
{
    $lista = array();
    $lista = $this->persistencia->getPeticionesIncidenciasEspeciales();
    return $lista;

}


public function confirmarorechazarpeticionincidencia($idpeticion, $accion)
{
    $lista = array();
    $lista = $this->persistencia->confirmarorechazarpeticionincidencia($idpeticion, $accion);
    return $lista;

}


public function insertandupdatefolioincapacidad($folioIncapacidad,$asistenciaFecha,$fechafinalincidencia,$empleado,$tipoIncapacidad,$diasIncapacidad,$opcion)
{
        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));
    $lista = array();
    $lista = $this->persistencia->insertandupdatefolioincapacidad($folioIncapacidad,$asistenciaFecha,$fechafinalincidencia,$empleado,$tipoIncapacidad,$diasIncapacidad,$opcion);

    return $lista;
}

public function negocio_obtenerPalabraAntisonante($palabraAntisonante)
{
    $CatalogoPalabra = array();
    $CatalogoPalabra = $this->persistencia->obtenerCatalogoPalabraAntisonante($palabraAntisonante);
    return $CatalogoPalabra;
}


public function deleteIncidenciaIncapacidadByFolio($incidencia,$incidenciaId, $folioincapacidad)
{

        //$log = new KLogger ( "negocio_deleteAsistenciaFromAsistencia.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la  \$result : " . var_export ($incidencia, true));

    $result = array();

    $registrado = $this->persistencia->deleteIncidenciaIncapacidadByFolio($incidencia,$incidenciaId, $folioincapacidad);

        //$log->LogInfo("Valor de la  \$registrado : " . var_export ($registrado, true));

    if ($registrado == true) {

        $registrado = $this->persistencia->deleteIncidenciasEspecialesByEmpleadoAndFecha($incidencia);

        if ($registrado == true) {

            $result["status"]  = "success";
            $result["message"] = "";

        }

    } else {
        $result["status"]  = "error";
        $result["message"] = "No se pudo editar la asistencia en la base de datos.";
    }
        //$log->LogInfo("Valor de la  \$result : " . var_export ($result, true));
    return $result;
    
}

public function getListaDocumentosIncapacidadByFechaquincena($fecha1,$fecha2,$opcion,$usuario)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listafolios = array();
    $listafolios = $this->persistencia->getListaDocumentosIncapacidadByFechaquincena($fecha1,$fecha2,$opcion,$usuario);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $listafolios;
}

public function negocio_obtenerclaveEntidadCurp($idEntidad)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $listaEntidadesFederativas = array();
    $listaEntidadesFederativas = $this->persistencia->traeCatalogoEntidadesclaveEntidadCurp($idEntidad);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $listaEntidadesFederativas;
}

public function negocio_ObtenerDatosPersonalesYCurp()
{
        //$log = new KLogger ( "negocio_traerListaMunicipiosPorEntidad.log" , KLogger::DEBUG );

    $listadatoscurp = $this->persistencia->ObtenerDatosPersonalesYCurp();
        //$log->LogInfo("listaMunicipios " . var_export ($listaMunicipios, true));
    return $listadatoscurp;

}


 public function negocio_obtenerLineasNegocioByIdUser($usuarioId)
    {
        //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

        $EnitidadesByUser = $this->persistencia->obtenerLineasNegocioByIdUser($usuarioId);
        //$log -> LogInfo ("$lista". var_export($lista,true));
        return $EnitidadesByUser;

    }

    public function negocio_MunicipiosByEntidad($idEntidad)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $regiones = array();
    $regiones = $this->persistencia->MunicipiosByEntidad($idEntidad);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $regiones;
}

public function getestatusPeticionesincidenciaespecial($incidencia)
    {
        $EstatusPIE = array();

        $EstatusPIE = $this->persistencia->ObtenerestatusPeticionesincidenciaespecial($incidencia);

        return $EstatusPIE;

    }


/*public function gettblhistoricoIncidencias($fechainicio,$fechafin,$accion) 
{
    $lista = array();
    if($accion=="2"){

        $fechainicioo = new DateTime($fechainicio);
        $fechafinn    = new DateTime($fechafin);

        if ($fechainicio == "") {throw new Exception("Seleccione una fecha 'Del:'");}
        if ($fechafin == "") {throw new Exception("Seleccione una fecha 'Al:'");}
        if ($fechainicioo > $fechafinn) {throw new Exception("La fecha 'Al:' no puede ser menor a la fecha 'Del:'");}

        $lista = $this->persistencia->obtenertblhistoricoIncidencias($fechainicio,$fechafin,$accion);
    }else{
        $lista = $this->persistencia->obtenertblhistoricoIncidencias($fechainicio,$fechafin,$accion);
    }
    return $lista;
}

public function obtenerCatalogoPeriodosAnuales()
    {
        $ListaP = array();
        $ListaP = $this->persistencia->traeCatalogoPeriodosAnuales();
        return $ListaP;
    }*/

    public function gettblhistoricoIncidencias($fechainicio,$fechafin,$accion) 
{
    $lista = array();
    if($accion=="2"){

        $fechainicioo = new DateTime($fechainicio);
        $fechafinn    = new DateTime($fechafin);

        if ($fechainicio == "") {throw new Exception("Seleccione una fecha 'Del:'");}
        if ($fechafin == "") {throw new Exception("Seleccione una fecha 'Al:'");}
        if ($fechainicioo > $fechafinn) {throw new Exception("La fecha 'Al:' no puede ser menor a la fecha 'Del:'");}

        $lista = $this->persistencia->obtenertblhistoricoIncidencias($fechainicio,$fechafin,$accion);
    }else{
        $lista = $this->persistencia->obtenertblhistoricoIncidencias($fechainicio,$fechafin,$accion);
    }
    return $lista;
}

public function obtenerCatalogoPeriodosAnuales($FechaPeriodo)
    {
        $ListaP = array();
        $ListaP = $this->persistencia->traeCatalogoPeriodosAnuales($FechaPeriodo);
        return $ListaP;
    }


public function obtenerListaHistoricoAL()
{

    $ListaHistoricoAL = array();
    $ListaHistoricoAL = $this->persistencia->GetListaHistoricoAL();
     return $ListaHistoricoAL;
}

public function ActualizarFiniquitoPiramidado1($entidademp,$consecutivoemp,$categoriaemp,$netoAlPago,$netoAlPagocalculado)
{

    $ActFiniquitoP1 = array();
    $ActFiniquitoP1 = $this->persistencia->UPDATEFiniquitoPiramidado1($entidademp,$consecutivoemp,$categoriaemp,$netoAlPago,$netoAlPagocalculado);
     return $ActFiniquitoP1;
}

public function obtenerListaFiniquitosNeg()
{

    $ListaFiniquitosNeg = array();
    $ListaFiniquitosNeg = $this->persistencia->GetListaFiniquitosNegativos();
     return $ListaFiniquitosNeg;
}


public function ActualizarFiniquitoPiramidadoMonto($entidademp,$consecutivoemp,$categoriaemp,$MontoAcuerdo)
{

    $ActFiniquitoMonto = array();
    $ActFiniquitoMonto = $this->persistencia->UPDATEFiniquitoPiramidadoMonto($entidademp,$consecutivoemp,$categoriaemp,$MontoAcuerdo);
     return $ActFiniquitoMonto;
}

public function insertarFalioVacaciones($inpdiasvacaciones,$inpFoliovacaciones,$RolOperativoVacaciones,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$nomenclaturaIncidencia,$peridosVacaciones,$primerfecha,$usuarioCapturaAsistencia,$NombreTempArchivo)
{
        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));
    $lista = array();
    $lista = $this->persistencia->insertarFolioVacaciones1($inpdiasvacaciones,$inpFoliovacaciones,$RolOperativoVacaciones,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$nomenclaturaIncidencia,$peridosVacaciones,$primerfecha,$usuarioCapturaAsistencia,$NombreTempArchivo);

    return $lista;
}


public function UpdateAsistenciaFolioVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$empleadoPuntoServicioId,$inpFoliovacaciones,$asistenciaFecha,$AnioAniversario)
{
 $this->persistencia->UpdateAsistenciaFolioVacaciones1($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$empleadoPuntoServicioId,$inpFoliovacaciones,$asistenciaFecha,$AnioAniversario);
}

public function negocio_GetEntidadesUser($entidadConsulta)
    {
        //   $log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaentidades = array();
        //   $log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($usuario, true));
        $listaentidades = $this->persistencia->obtenerListaEntidadesUsuarios($entidadConsulta);
        return $listaentidades;
    }

    public function obtenerflujo($usuario)
{

    $ListaFlujo = array();
    $ListaFlujo = $this->persistencia->GetListaFlujo($usuario);
     return $ListaFlujo;
}

public function InsertarHistorico($entidad,$consecutivo,$categoria,$nomemp,$nombreEntidadFederativa,$prestamo,$PrestamoFechaCarga,$infonavit,$InfonavitFechaCarga,$fonacot,$FonacotFechaCarga,$pension,$PensionFechaCarga,$diastrabajados,$DíasTrabajadosFechaCarga,$diasDeVacaciones,$netoAlPago,$EstatusNegociacion,$usuario)
{

    $HistoricosCorreos = array();
    $HistoricosCorreos = $this->persistencia->InsertarHistoricoCoorreo($entidad,$consecutivo,$categoria,$nomemp,$nombreEntidadFederativa,$prestamo,$PrestamoFechaCarga,$infonavit,$InfonavitFechaCarga,$fonacot,$FonacotFechaCarga,$pension,$PensionFechaCarga,$diastrabajados,$DíasTrabajadosFechaCarga,$diasDeVacaciones,$netoAlPago,$EstatusNegociacion,$usuario);
     return $HistoricosCorreos;
}

public function ConsultaHistoricoEstatusFiniquito($fechainicio,$fechafin)
{

    $ConsultaHistoricosCorreos = array();
    $ConsultaHistoricosCorreos = $this->persistencia->GetConsultaHistoricoEstatusFiniquito($fechainicio,$fechafin);
     return $ConsultaHistoricosCorreos;
}

    public function VerificarExistenciaEmpleado($entidad,$consecutivo,$categoria)
{

    $ExisEmp = array();
    $ExisEmp = $this->persistencia->GetExistenciaEmpleado($entidad,$consecutivo,$categoria);
     return $ExisEmp;
}

public function obtenerDatosBusqueda($entidad,$consecutivo,$categoria)
{

    $ListaBusqueda = array();
    $ListaBusqueda = $this->persistencia->GetListaBusqueda($entidad,$consecutivo,$categoria);
     return $ListaBusqueda;
}

public function obtenerListaAcuerdos()
{

    $ListaAcuerdos = array();
    $ListaAcuerdos = $this->persistencia->GetListaAcuerdos();
     return $ListaAcuerdos;
}

public function obtenerListaHistoricoFiniquitosDG()
{

    $ListaFiniquitoDG = array();
    $ListaFiniquitoDG = $this->persistencia->GetListaHistoricoFiniquitosDG();
     return $ListaFiniquitoDG;
}

public function obtenerListaDiasTrabajados()
{

    $ObTListaDias = array();
    $ObTListaDias = $this->persistencia->GetListaDiasTrabajados();
     return $ObTListaDias;
}

public function ActualizarFiniquitoPiramidadoDG($entidademp,$consecutivoemp,$categoriaemp,$netoAlPago,$opcion,$MontoAcordadoCalculado)
{

    $ActFiniquitoDG = array();
    $ActFiniquitoDG = $this->persistencia->UPDATEFiniquitoPiramidadoDG($entidademp,$consecutivoemp,$categoriaemp,$netoAlPago,$opcion,$MontoAcordadoCalculado);
     return $ActFiniquitoDG;
}

public function ActualizarDiasTrabajados($entidadempleado,$consecutivoemp,$categoriaemp,$DiasTrabajados1)
{

    $ActFiniquitoDG = array();
    $ActFiniquitoDG = $this->persistencia->UPDATEDiasTrabajados($entidadempleado,$consecutivoemp,$categoriaemp,$DiasTrabajados1);
     return $ActFiniquitoDG;
}



public function obtenerDiasDeVacaciones($AnioAntiguedad,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId)
    {
    //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
       // $AnioAntiguedad = "4";
        $DiasVacaciones = array();

        if($AnioAntiguedad>0){
            for($i=0; $i<$AnioAntiguedad; $i++){
                $Dias = $i+1;
             $DiasVacaciones[$i] = $this->persistencia->traeDiasVacacionesAntiguedad($Dias);
            }
        }
        $DiasVacaciones[$AnioAntiguedad] = $this->persistencia->traeDiasVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
        //$log->LogInfo("Valor de la variable DiasVacaciones3: " . var_export ($DiasVacaciones1, true));
        //$DiasVacaciones=array_merge($DiasVacaciones1, $DiasVacaciones2);
        return $DiasVacaciones;
    }


    public function obtenerFechaAltaEmpleado($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId)
    {
        $Fecha = array();
        $Fecha = $this->persistencia->TraerFechaAltaEmpleado($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
        return $Fecha;
    }

    public function obtenerFechaAltaEmpleadosTotales()
    {
        $Fecha = array();
        $Fecha = $this->persistencia->TraerFechaAltaEmpleadosTotales();
        return $Fecha;
    }

    public function UpdateAsistenciaAniversario($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria,$Aniversario,$FechaSiguente,$FechaAnterior)
    { 
        $Fecha = $this->persistencia->ActualizarAsistenciaAniversario($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria,$Aniversario,$FechaSiguente,$FechaAnterior);
    }

    public function ObtenerTotalDeDiasVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$Aniversario)
    {
        $DiasVac = array();
        $DiasVac = $this->persistencia->TotalDeDiasVacaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$Aniversario);
        return $DiasVac;
    }

    public function ObtenerDiasCorrespondientesALAniversario($Aniversario)
    {
        $DiasAni = array();
        $DiasAni = $this->persistencia->TraerDiasCorrespondientesALAniversario($Aniversario);
        return $DiasAni;
    }

    public function ObtenerRevisionFechaInsertada($DateVacaciones,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId)
    {
        $RevisionFechaInsertada = array();
        $RevisionFechaInsertada = $this->persistencia->getRevisionFechaInsertada($DateVacaciones,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
        return $RevisionFechaInsertada;
    }

    public function obtenerFolioVacaciones($incidencia)
    {
        $FolioVacacionesDelete = array();
        $FolioVacacionesDelete = $this->persistencia->getFolioVacaciones($incidencia);
        return $FolioVacacionesDelete;
    }

    public function deleteIncidenciaVacacionesByFolio($incidencia, $folioVacaciones)
    {
        //$log = new KLogger ( "negocio_deleteAsistenciaFromAsistencia.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la  \$result : " . var_export ($incidencia, true));
    $result = array();
    $registrado = $this->persistencia->BorrarIncidenciaVacacionesByFolio($incidencia, $folioVacaciones);
    if ($registrado == true) {

        $registrado1 = $this->persistencia->deleteIncidenciasEspecialesByEmpleadoAndFecha($incidencia);

        if ($registrado1 == true) {

            $result["status"]  = "success";
            $result["message"] = "";

        }

    } else {
        $result["status"]  = "error";
        $result["message"] = "No se pudo editar la asistencia en la base de datos.";
    }
        //$log->LogInfo("Valor de la  \$result : " . var_export ($result, true));
    return $result;
    
}
public function Amortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,$caso)
{
    $Amortizacion = array();
    $Amortizacion = $this->persistencia->GetAmortizaciones($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito,$fechaBaja,$caso);
     return $Amortizacion;
}

public function getListaDocumentosVacaciones($fecha1,$fecha2)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $ListaVacaPeticion = array();
    $ListaVacaPeticion = $this->persistencia->obtenerListaDocumentosVacaciones($fecha1,$fecha2);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $ListaVacaPeticion;
}

public function ActualizarFolioVacaciones($incidencia)
    { 
        $Fecha = $this->persistencia->UpdateFolioVacaciones($incidencia);
    }

public function InsertarFolioVacacionesDeclinadas($incidencia)
    { 
        $Fecha = $this->persistencia->InsertFolioVacacionesDeclinadas($incidencia);
    }

public function getListaReporteVacaciones($usuario)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $ListaVacaPeticion = array();
    $ListaVacaPeticion = $this->persistencia->obtenerListaReporteVacaciones($usuario);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $ListaVacaPeticion;
}

public function GetDatosEmpleadoFiniquito($folio)
{
    $opcion ="2";
    $ListaDatosEmpleados = array();
    $ListaDatosEmpleados = $this->persistencia->obtenerEmpleadosBajaFiniquito($folio);
    return $ListaDatosEmpleados;

}

public function UpdateDatosImssCampoFiniquito($EstatusFiniquito,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId)
{
    $this->persistencia->ActualizarDatosImssCampoFiniquito($EstatusFiniquito,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
}

public function getListaConfirmacionVacacionesFini($fechaInicioDiasVacacionesLab,$fechaTerminoDisasVacacionesLab,$caso)
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $ListaVacaConfirmacion = array();
    $ListaVacaConfirmacion = $this->persistencia->obtenerListaConfirmacionVacacionesFini($fechaInicioDiasVacacionesLab,$fechaTerminoDisasVacacionesLab,$caso);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $ListaVacaConfirmacion;
}
public function UpdateFiniquitoVacacionesPendientes($entidad,$consecutivo,$tipo,$TotalDias,$contraseniaInsertadaCifrada,$NumEmpModalVacFin,$usuarioCapturaVac)
    {    
        $this->persistencia->ActualizarFiniquitoVacacionesPendientes($entidad,$consecutivo,$tipo,$TotalDias,$contraseniaInsertadaCifrada,$NumEmpModalVacFin,$usuarioCapturaVac);
    }

public function UpdateFiniquitoCreacionPdfAutomatico1($entidademp,$consecutivoemp,$categoriaemp)
    {    
        $this->persistencia->ActualizarFiniquitoCreacionPdfAutomatico($entidademp,$consecutivoemp,$categoriaemp);
    }

public function GetDiasTrabajados($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaBaja)
{
    $Amortizacion = array();
    $Amortizacion = $this->persistencia->obtenerDiasTrabajados($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaBaja);
     return $Amortizacion;
}

public function obtenerisrmensual($ingresoacumulablesa)
{

    $ibtenerIsrMensual = array();
    $ibtenerIsrMensual = $this->persistencia->Getisrmensual($ingresoacumulablesa);
     return $ibtenerIsrMensual;
}

public function UpdateFiniquitosDiasTrabajados($diasdepago,$calculobruto,$pagoneto,$diaspagosa,$pagonetosa,$diferenciagratificacionsa,$ingresoacumulablesa,$limiteinferior,$excedenteLimitesa,$sobreexcedenteliminferior,$resultado,$cuotaqryfloat,$isr,$netoalpago,$entidadempleado,$consecutivoemp,$categoriaemp)
{

   $this->persistencia->ActualizarFiniquitosDiasTrabajados($diasdepago,$calculobruto,$pagoneto,$diaspagosa,$pagonetosa,$diferenciagratificacionsa,$ingresoacumulablesa,$limiteinferior,$excedenteLimitesa,$sobreexcedenteliminferior,$resultado,$cuotaqryfloat,$isr,$netoalpago,$entidadempleado,$consecutivoemp,$categoriaemp);
}

public function ActualizarFiniquitoLaborales($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$FechaAltaEmpleadoLaborales)
{
    $this->persistencia->updateFiniquitoLaborales($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$FechaAltaEmpleadoLaborales);

}

public function ConsultaDiasFestivos()
{
    $ListaConsultaDiasFestivos = array();
    $ListaConsultaDiasFestivos = $this->persistencia->GetConsultaDiasFestivos();
     return $ListaConsultaDiasFestivos;
}


public function ObtenerEmpleadosConVacacionesPendientes($OpcionBusqueda)
{

    $EmpleadosVacacionesP = array();
    $EmpleadosVacacionesP = $this->persistencia->GetEmpleadosConVacacionesPendientes($OpcionBusqueda);
     return $EmpleadosVacacionesP;
}

public function obtenerFechaAltaEmpleadoTablaEmpleados($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId)
    {
        $FechaTablaEmpleados = array();
        $FechaTablaEmpleados = $this->persistencia->TraerFechaAltaEmpleadoTablaEmpleados($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
        return $FechaTablaEmpleados;
    }

public function InsertDiasVacacionesPendientes($EmpleadoCategoria,$EmpleadoConsecutivo,$EmpleadoTipo,$FechaVacaciones,$usuarioCapturaVacaciones,$Comentario,$aniversario)
{
    $this->persistencia->InsertarDiasVacacionesPendientes($EmpleadoCategoria,$EmpleadoConsecutivo,$EmpleadoTipo,$FechaVacaciones,$usuarioCapturaVacaciones,$Comentario,$aniversario);
}

public function InsertDiasVacacionesPendientesOtrasEmpresas($EmpleadoCategoria,$EmpleadoConsecutivo,$EmpleadoTipo,$usuarioCapturaVacaciones,$Comentario,$vacacionesConfirmadasOtrasEmp)
{
    $VacPendientes = $this->persistencia->InsertarDiasVacacionesPendientesOtrasEmpresas($EmpleadoCategoria,$EmpleadoConsecutivo,$EmpleadoTipo,$usuarioCapturaVacaciones,$Comentario,$vacacionesConfirmadasOtrasEmp);
}

public function InsertConfirmacionRevisionVacacionesPendientes($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito)
{
    $ConfirmacionVac = $this->persistencia->InsertarConfirmacionRevisionVacacionesPendientes($entidadEmpFiniquito,$consecutivoEmpFiniquito,$categoriaEmpFiniquito);
}

public function ObtenerDiasCorrespondientesAOtrasEmpresas($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId)
    {
        $DiasAni = array();
        $DiasAni = $this->persistencia->getDiasCorrespondientesAOtrasEmpresas($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
        return $DiasAni;
    }

public function ObtenerSalarioActual()
    {
        $SalarioActua = array();
        $SalarioActua = $this->persistencia->GetSalarioActual();
        return $SalarioActua;
    }

public function ObtenerEstatusPAgo($entidadempDeu,$consecutivoempDeu,$categoriaempDeu)
    {
        $EstPago = array();
        $EstPago = $this->persistencia->GetObtenerEstatusPAgo($entidadempDeu,$consecutivoempDeu,$categoriaempDeu);
        return $EstPago;
    }


    public function updateDatosDeuda($NombreTempArchivo,$numeroEmpleado)
{
 $this->persistencia->ActualizarDatosDeuda($NombreTempArchivo,$numeroEmpleado);
}

public function obtenerListaAdeudosEmpleados($FechaInicioAdeudo,$FechaFinAdeudo,$Caso)
{

    $ListaHistoricoAdeudos = array();
    $ListaHistoricoAdeudos = $this->persistencia->GetListaAdeudosEmpleados($FechaInicioAdeudo,$FechaFinAdeudo,$Caso);
     return $ListaHistoricoAdeudos;
}

public function UpdateListaAdeudosEmpleados($IdEmpleado)
{

    $ListaHistoricoAdeudos = $this->persistencia->ActualizarListaAdeudosEmpleados($IdEmpleado);
}

public function GetConsultaSueldoEmpleadoBaja($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId)
{

    $lista = array();

    $lista = $this->persistencia->TraerConsultaSueldoEmpleadoBaja($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $lista;
}

public function getElemetosXReclutador()
{
    $elementosXReclutador = array();

    $elementosXReclutador = $this->persistencia->TraerElementosXReclutador();

    return $elementosXReclutador;
}

public function getIndiceRotacionGeneral()
{
    $IndiceRot = array();

    $IndiceRot = $this->persistencia->TraerIndiceRotacionGeneral();

    return $IndiceRot;
}

public function ObtenerFiniquitosPrecesados($fechainicio,$fechafin)
    {
        $TableParaComplementos = array();
        $TableParaComplementos = $this->persistencia->GetFiniquitosPrecesados($fechainicio,$fechafin);
        return $TableParaComplementos;
    }

public function UpdateFiniquitoComplemento($montoSolicitadoC,$FolioFiniquito,$numEmpleadoComp)
    {
        $this->persistencia->actualizarFiniquitoParaComplemento($montoSolicitadoC,$FolioFiniquito,$numEmpleadoComp);
    }

public function ObtenerAltasDelMes($month, $year, $lineaNegocio)
    {
        $altasMesGrafica = "";
        $altasMesGrafica = $this->persistencia->getAltasDelMesGrafica($month, $year, $lineaNegocio);
        return $altasMesGrafica;
    }

public function ObtenerBajasDelMes($month, $year, $lineaNegocio)
    {
        $bajasMesGrafica = "";
        $bajasMesGrafica = $this->persistencia->getBajasDelMesGrafica($month, $year, $lineaNegocio);
        return $bajasMesGrafica;
    }

public function ObtenerNumeroElementosPlantilla($fecha1, $fecha2,$lineaNegocio)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);
        $numElementosGifGrafica = "";
        $numElementosGifGrafica = $this->persistencia->getNumeroElementosPlantillaGrafica($fecha1, $fecha2,$lineaNegocio);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numElementosGifGrafica;

    }

public function ObtenerNumeroElementosGif($fecha1, $fecha2, $lineaNegocio)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);

        $numElementosGifGraficas = "";
        $numElementosGifGraficas = $this->persistencia->getNumeroElementosGifGrafica($fecha1, $fecha2, $lineaNegocio);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numElementosGifGraficas;

    }
public function ObtenerReclutadoresByLineaNegocioAndMonth($lineaNegocio, $month, $puesto)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );
        $listaREclutadoresGrafica = array();
        $listaREclutadoresGrafica = $this->persistencia->ObtenerReclutadoresByLineaNegocioAndMonthGrafica($lineaNegocio, $month, $puesto);
        return $listaREclutadoresGrafica;
    }

public function ObtenerElementosByReclutador($reclutadorId, $month)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $listaElementosGrafica = array();
        $listaElementosGrafica = $this->persistencia->ObtenerElementosByReclutadorGrafica($reclutadorId, $month);
        return $listaElementosGrafica;
    }

public function ListaReclutadoresByLineaNegocioAndMonth($lineaNegocio, $month, $puesto)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $listaCompletaGrafica = array();
        $listaCompletaGrafica = $this->persistencia->ListaCompletaReclutadoresByLineaNegocioAndMonth($lineaNegocio, $month, $puesto);
        return $listaCompletaGrafica;
    }

    public function ListaElementosByReclutador($reclutadorId, $month)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );
        $listaXReclutador = array();
        $listaXReclutador = $this->persistencia->ListaCompletaElementosByReclutador($reclutadorId, $month);
        return $listaXReclutador;
    }

    public function obtenerListaFiniquitosCOmp()
    {

        $ListafiniquitosCo = array();
        $ListafiniquitosCo = $this->persistencia->GetListaFiniquitosCOmp();
         return $ListafiniquitosCo;
    }

    public function UpdateFiniquitoSolicitudComplemento($numempleado,$folioBaja,$CantidadComplemento,$opcion)
    {
        $this->persistencia->actualizarFiniquitoSolicitudComplemento($numempleado,$folioBaja,$CantidadComplemento,$opcion);
    }

    public function obtenerListaFiniquitosCompPorPagar()
    {

        $ListafiniquitosComplemetoPorPagar = array();
        $ListafiniquitosComplemetoPorPagar = $this->persistencia->GetListaFiniquitosCompPorPagar();
         return $ListafiniquitosComplemetoPorPagar;
    }
    public function UpdateFiniquitoComplementoPagado($numempleado,$folioBaja,$CantidadComplemento)
    {
        $this->persistencia->actualizareFiniquitoComplementoPagado($numempleado,$folioBaja,$CantidadComplemento);
    }
    public function obtenerListaHistoricoComp()
    {

        $ListaHistoricoMovimientosComp = array();
        $ListaHistoricoMovimientosComp = $this->persistencia->GetListaHistoricoComp();
         return $ListaHistoricoMovimientosComp;
    }

    public function obtenerIncidenciasXdiaXcliente($idcliente,$fechadia,$usuario) {
        return $this->persistencia->getIncidenciasXdiaXcliente($idcliente,$fechadia,$usuario);
    }

public function obtenerIncidenciasdeTurnosDia($idcliente,$fechadia,$accion,$usuario) {
        return $this->persistencia->getIncidenciasdeTurnosDia($idcliente,$fechadia,$accion,$usuario);
    }

    public function getDiasSolicitados($PlantillaId,$turnoDiaC,$turnoNocheC)
    {

    $lista = array();
    $lista = $this->persistencia->ObtenerDiasSolicitados($PlantillaId,$turnoDiaC,$turnoNocheC);
    return $lista;
    }
    public function GetDatosPlantillasPorPunto($puntoServicioId)
    {

    $lista = array();
    $lista = $this->persistencia->ObteneDatosPlantillasPorPunto($puntoServicioId);
    return $lista;
    }


public function obtenerEntidadesXCliente($ClienteElegido,$casoXgerente,$regionGerente,$LineaNegocioElegida)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaEntidadesXCliente = array();
        $listaEntidadesXCliente = $this->persistencia->getEntidadesXCliente($ClienteElegido,$casoXgerente,$regionGerente,$LineaNegocioElegida);
        //$log->LogInfo("Valor de la variable \$obtenerEntidadesXCliente: " . var_export ($obtenerEntidadesXCliente, true));
        return $listaEntidadesXCliente;
    }
public function obtenerPuntoXentidadCliente($EntidadElegida,$ClienteElegido,$lineaNegocio,$valorgifTipo)
{
    $listaPSxEC = array();
    $listaPSxEC = $this->persistencia->getPuntoXentidadCliente($EntidadElegida,$ClienteElegido,$lineaNegocio,$valorgifTipo);
    return $listaPSxEC;
}

public function obtenerSupervisoresXLinea($LineaNegocioElegida,$valorgifTipo,$tipoBusqueda,$entidadElegida)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaSupervisoresXlinea = array();
        $listaSupervisoresXlinea = $this->persistencia->getSupervisoresXLinea($LineaNegocioElegida,$valorgifTipo,$tipoBusqueda,$entidadElegida);
        //$log->LogInfo("Valor de la variable \$obtenerSupervisoresXLinea: " . var_export ($obtenerSupervisoresXLinea, true));
        return $listaSupervisoresXlinea;
    }

public function obtenerClienteXLinea($LineaNegocioElegida,$valorgifTipo,$casoXgerente,$regionGerente)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $obtenerClienteXLinea = array();
        $obtenerClienteXLinea = $this->persistencia->getClientesXLinea($LineaNegocioElegida,$valorgifTipo,$casoXgerente,$regionGerente);
        //$log->LogInfo("Valor de la variable \$obtenerClienteXLinea: " . var_export ($obtenerClienteXLinea, true));
        return $obtenerClienteXLinea;
    }

    public function obtenerEntidadSupervisor($supervisorElegido,$LineaElegida,$valorgifTipo)
    {
        $listaEntidadSupervisor = array();
        $listaEntidadSupervisor = $this->persistencia->getEntidadSupervisor($supervisorElegido,$LineaElegida,$valorgifTipo);
        return $listaEntidadSupervisor;
    }

    public function obtenerLineasDeNegocio()
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaLineasNegocio = array();
        $listaLineasNegocio = $this->persistencia->getLineasDeNegocio();
        //$log->LogInfo("Valor de la variable \$obtenerLineasDeNegocio: " . var_export ($obtenerLineasDeNegocio, true));
        return $listaLineasNegocio;
    }

    public function ObtenerPuntosParaGeo()
    {
        $PuntosGeo = array();
        $PuntosGeo = $this->persistencia->GetPuntosParaGeo();
        return $PuntosGeo;
    }
    public function ObtenerEstatusEmpeladoGeo($numeroEmpleado)
    {
        $StatusEmpleGeo = array();
        $StatusEmpleGeo = $this->persistencia->GetEstatusEmpeladoGeo($numeroEmpleado);
        return $StatusEmpleGeo;
    }


public function ObtenerNumeroElementosGifSoloGif($fecha1, $fecha2, $lineaNegocio, $opcion,$entidadGif,$pservicioGif)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);
    $numElementosGifGraficasSoloGif = "";
    $numElementosGifGraficasSoloGif = $this->persistencia->getNumeroElementosGifGraficaSoloGif($fecha1, $fecha2, $lineaNegocio,$opcion,$entidadGif,$pservicioGif);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numElementosGifGraficasSoloGif;
    }

public function entidadesPuntoServicioGif($merma)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $EntidadesPuntoSGif = array();
        $EntidadesPuntoSGif = $this->persistencia->getEntidadesPSGif($merma);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $EntidadesPuntoSGif;
    }

    public function entidadesReclutadorSup($merma)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $EntidadesReclutadorSup = array();
        $EntidadesReclutadorSup = $this->persistencia->entidadesReclutadorSup($merma);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $EntidadesReclutadorSup;
    }

    public function PuntoServicioGifXentidad($entidadElegidaGif)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $PuntoSGifXEnt = array();
        $PuntoSGifXEnt = $this->persistencia->getPuntoServicioGifXentidad($entidadElegidaGif);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $PuntoSGifXEnt;
    }

    public function obtenerIdClientePorPunto($idpuntoservicio)
    {
        $ListaIdCLienbte = array();
        $ListaIdCLienbte = $this->persistencia->getIdClientePorPunto($idpuntoservicio);
        return $ListaIdCLienbte;
    }

    public function InsertarPeticioinAsistenciaMerma($usuario,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$empleadoPuntoServicioId,$supervisorEntidadId,$supervisorConsecutivoId,$supervisorTipoId,$incidenciaId,$asistenciaFecha,$comentariIncidencia,$tipoPeriodo,$puestoCubiertoId,$idCliente,$valordia,$plantilladeservicio,$idlineanegocioPunto,$tipoIncidenciaPeticionM,$idPlantillaServicio,$selectMotivoIncidenciaEspecial)
    {
        $this->persistencia->InsertPeticioinAsistenciaMerma($usuario,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$empleadoPuntoServicioId,$supervisorEntidadId,$supervisorConsecutivoId,$supervisorTipoId,$incidenciaId,$asistenciaFecha,$comentariIncidencia,$tipoPeriodo,$puestoCubiertoId,$idCliente,$valordia,$plantilladeservicio,$idlineanegocioPunto,$tipoIncidenciaPeticionM,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);
    }
    public function ObtenerPeticionesM($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha)
    {
        $pertM = array();
        $pertM = $this->persistencia->getPeticionesM($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha);
        return $pertM;
    }

    public function obtenerListaPeticionesAsistencia()
{

    $obtenerlistaPeticionesAsis = array();
    $obtenerlistaPeticionesAsis = $this->persistencia->getListaPeticionesAsistencia();
     return $obtenerlistaPeticionesAsis;
}

public function PuntoServicioGifXentidadMerma($entidadElegidaGif)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $PuntoSGifXEntMerma = array();
        $PuntoSGifXEntMerma = $this->persistencia->getPuntoServicioGifXentidadMerma($entidadElegidaGif);
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $PuntoSGifXEntMerma;
    }

public function ObtenerNumeroElementosGifSoloGifMerma($fecha1, $fecha2, $lineaNegocio, $opcion,$entidadGif,$pservicioGif)
    {
        //$log= new KLogger("negocioUltimoFolio.log", KLogger::DEBUG);
    $numElementosGifGraficasSoloGifMerma = "";
    $numElementosGifGraficasSoloGifMerma = $this->persistencia->getNumeroElementosGifGraficaSoloGifMerma($fecha1, $fecha2, $lineaNegocio,$opcion,$entidadGif,$pservicioGif);
        //$log -> LogInfo ("numeroFolio". var_export($numeroFolio,true));
        return $numElementosGifGraficasSoloGifMerma;
    }

    public function obtenerListaPeticionesAsistenciaParaMErma($fechaInicioPeriodo,$fechaTerminoPeriodo,$caso)
{

    $obtenerlistaPeticionesAsisPAraMerma = array();
    $obtenerlistaPeticionesAsisPAraMerma = $this->persistencia->getListaPeticionesAsistenciaParaMerma($fechaInicioPeriodo,$fechaTerminoPeriodo,$caso);
     return $obtenerlistaPeticionesAsisPAraMerma;
}

public function ActualizarEstatusPeticionMerma($EmpEntidadM,$EmpConsecutivoM,$EmpCategoriaM,$idPuntoServicioM,$idIncidenciaM,$FechaDelRegistro,$Comentario,$Opcion)
    {
        $ListaIdCLienbte = array();
        $ListaIdCLienbte = $this->persistencia->updateEstatusPeticionMerma($EmpEntidadM,$EmpConsecutivoM,$EmpCategoriaM,$idPuntoServicioM,$idIncidenciaM,$FechaDelRegistro,$Comentario,$Opcion);
        return $ListaIdCLienbte;
    }

public function obtenerListaEstatusPeticionesAsistenciaParaMErma($usuario,$CasoBusqueda,$fechaMermaInicio,$fechaMermaFin)
{

    $obtenerEstlistaPeticionesAsisPAraMerma = array();
    $obtenerEstlistaPeticionesAsisPAraMerma = $this->persistencia->getListaEstatusPeticionesAsistenciaParaMerma($usuario,$CasoBusqueda,$fechaMermaInicio,$fechaMermaFin);
     return $obtenerEstlistaPeticionesAsisPAraMerma;
}

 public function ActualizareRegistroPeticionMerma1($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$valordia,$usuario)
    {
        $pertM = $this->persistencia->UpdateRegistroPeticionMerma1($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$valordia,$usuario);
    }


public function getTurnosCubiertoSeparadosXPuntos($i, $puntoServicioId) {
    return $this->persistencia->ObtenerTurnosCubiertoSeparadosXPuntos($i, $puntoServicioId);
}

public function ListaReclutadoresByEntidad($lineaNegocio, $month, $puesto, $entidadTrabajoRS)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $listaCompletaGrafica = array();
        $listaCompletaGrafica = $this->persistencia->ListaCompletaReclutadoresByEntidad($lineaNegocio, $month, $puesto, $entidadTrabajoRS);
        return $listaCompletaGrafica;
    }
 public function ElementosByReclutadorEntidad($reclutadorId, $month)
    {
        //$log = new KLogger ( "ElementosByReclutadorEntidad.log" , KLogger::DEBUG );
        $listaXReclutador = array();
        $listaXReclutador = $this->persistencia->obtenerElementosByReclutadorEntidad($reclutadorId, $month);
        return $listaXReclutador;
    }

public function ObtenerReclutadoresMP($lineaNegocio, $month, $puesto,$selectEntidad)
    {
        //$log = new KLogger ( "ObtenerReclutadoresMP.log" , KLogger::DEBUG );
        $listaREclutadoresGrafica = array();
        $listaREclutadoresGrafica = $this->persistencia->ObtenerReclutadoresquinceMP($lineaNegocio, $month, $puesto,$selectEntidad);
        return $listaREclutadoresGrafica;
    }

public function ObtenerElementos15MP($reclutadorId, $month)
    {
        //$log = new KLogger ( "ObtenerElementos15MP.log" , KLogger::DEBUG );
        $listaElementosGrafica = array();
        $listaElementosGrafica = $this->persistencia->getElementos15MP($reclutadorId, $month);
        return $listaElementosGrafica;
    }

public function obtenerDetalleRequisicionesByPuntoServicioId($puntoServicioId,$tipoBusqueda,$lineaNegocioElegido,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente)
{
    $lista = array();
    if($tipoBusqueda!="1" && $tipoBusqueda!="2" && $tipoBusqueda!="3" && $tipoBusqueda!="5" && $tipoBusqueda!="6")
    {
     if($puntoServicioId == "" or $puntoServicioId == "PUNTOS DE SERVICIOS")
       {
         throw new Exception("Por favor seleccione un punto de servicio");
       }
    }
    $lista = $this->persistencia->obtenerDetalleRequisicionesByPuntoServicioIdPer($puntoServicioId,$tipoBusqueda,$lineaNegocioElegido,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente);
    return $lista;
}

public function obtenerTurnosCubiertosByPeriodoFechasAndPuntoServicio($fechaInicial,$fechaFinal,$puntoServicioId,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$lineaNegocioElegido,$clienteElegidoGral) 
{
    return $this->persistencia->obtenerTurnosCubiertosByPeriodoFechasAndPuntoServicioPer($fechaInicial, $fechaFinal, $puntoServicioId,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$lineaNegocioElegido,$clienteElegidoGral);
}

public function datosPlantillasPorPunto($puntoServicioId,$tipoBusqueda,$lineaNegocioElegido,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente)
    {
     $listaDatosPlantilla = array();
     $listaDatosPlantilla = $this->persistencia->datosPlantillasPorPuntoPer($puntoServicioId,$tipoBusqueda,$lineaNegocioElegido,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente);
     return $listaDatosPlantilla;
    }

public function DiasSolicitados($PlantillaId,$turnoDiaC,$turnoNocheC)
    {
     $listaDiasSol = array();
     $listaDiasSol = $this->persistencia->ObtenerDiasSolicitadosPER($PlantillaId,$turnoDiaC,$turnoNocheC);
     return $listaDiasSol;
    }

 public function TurnosCubiertoSeparadosXPuntos($i, $puntoServicioId,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$lineaNegocioElegido,$clienteElegidoGral,$casoXgerente,$regionGerente)
 {
  return $this->persistencia->TurnosCubiertosSeparadosXPuntos($i, $puntoServicioId,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$lineaNegocioElegido,$clienteElegidoGral,$casoXgerente,$regionGerente);
 }

public function obtenerPuntoXentidadSupervisor($EntidadElegida,$supervisorele,$lineaNegocio,$clienteElegidoSupervisor,$valorgifTipo)
{
    $listaPSxS = array();
    $listaPSxS = $this->persistencia->getPuntoXentidadSupervisor($EntidadElegida,$supervisorele,$lineaNegocio,$clienteElegidoSupervisor,$valorgifTipo);
    return $listaPSxS;
}

public function getTurnosCubiertosRegiones($fechaInicial,$fechaFinal) {
    return $this->persistencia->obtenerTurnosCubiertosRegiones($fechaInicial, $fechaFinal);
}

public function ObtenerRegionesTotales($LineaNegocioRegiones,$i,$casoConsulta,$entidadregion)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ListaRegionesTotales = array();
    $ListaRegionesTotales = $this->persistencia->GetRegionesTotales($LineaNegocioRegiones,$i,$casoConsulta,$entidadregion);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ListaRegionesTotales;
}

public function obtenerClienteXSupervisor($EntidadElegida,$supervisorele,$lineaNegocio,$valorgifTipo)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaClientesXSupervisor = array();
        $listaClientesXSupervisor = $this->persistencia->getClientesXSupervisor($EntidadElegida,$supervisorele,$lineaNegocio,$valorgifTipo);
        //$log->LogInfo("Valor de la variable \$obtenerClienteXSupervisor: " . var_export ($obtenerClienteXSupervisor, true));
        return $listaClientesXSupervisor;
    }

public function ObtenerElementosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas,$TipoEmp,$casoGif)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ListaCoberturaGeneral = array();
    $ListaCoberturaGeneral = $this->persistencia->GetElementosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas,$TipoEmp,$casoGif);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ListaCoberturaGeneral;
}
public function ObtenerPuntosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ListaCoberturaGeneralPuntos = array();
    $ListaCoberturaGeneralPuntos = $this->persistencia->GetPuntosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ListaCoberturaGeneralPuntos;
}
public function ObtenerIdPuntosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ListaCoberturaGeneralPuntos = array();
    $ListaCoberturaGeneralPuntos = $this->persistencia->GetIdPuntosPorRegion($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ListaCoberturaGeneralPuntos;
}

public function ObtenerElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo,$entidadregion,$casoConsulta,$casoFechas)
{
       // $log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ListaElementosXRol = array();
    $ListaElementosXRol = $this->persistencia->GetElementosPorRolOperativo($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$rolOperativo,$entidadregion,$casoConsulta,$casoFechas);
       // $log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ListaElementosXRol;
}
public function ObtenerRegionesTotalesSelect($selLineaNegocioRegiones,$selRegiones)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ListaRegionesTotales = array();
    $ListaRegionesTotales = $this->persistencia->GetRegionesTotalesSelect($selLineaNegocioRegiones,$selRegiones);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ListaRegionesTotales;
}

public function obtenerTurnoCubiertosIncidenciasEspecialesXDia($fechaInicial,$fechaFinal,$puntoServicioId) {
    return $this->persistencia->getTurnoCubiertosIncidenciasEspecialesXDia($fechaInicial, $fechaFinal, $puntoServicioId);
}

public function obtenerEntidadGeneral($valorgifTipo,$Linea)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaEntidadGeneral = array();
        $listaEntidadGeneral = $this->persistencia->getEntidadGeneral($valorgifTipo,$Linea);
        //$log->LogInfo("Valor de la variable \$obtenerEntidadGeneral: " . var_export ($obtenerEntidadGeneral, true));
        return $listaEntidadGeneral;
    }

 public function TurnosCubiertoIncidenciasSeparadosXPuntos($i,$puntoServicioId,$lineaNegocioElegido,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente){
  return $this->persistencia->TurnosCubiertosIncidenciasSeparadosXPuntos($i,$puntoServicioId,$lineaNegocioElegido,$tipoBusqueda,$clienteElegido,$entidadElegida,$supervisorElegido,$clienteElegidoSuperv,$clienteElegidoGral,$casoXgerente,$regionGerente);
 }

 public function ObtenerAsistenciaIncidencaMismoDia($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha)
    {
        $AsisIncMismoDia = array();
        $AsisIncMismoDia = $this->persistencia->GetAsistenciaIncidencaMismoDia($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha);
        return $AsisIncMismoDia;
    }

public function ObetenerRegionesXlinea($lineaNegocio)
    {
     //$log= new KLogger("ObetenerRegionesXlinea.log", KLogger::DEBUG);
     $ListaRegiones = "";
     $ListaRegiones = $this->persistencia->getRegionesXlinea($lineaNegocio);
     //$log -> LogInfo ("ObetenerRegionesXlinea". var_export($ObetenerRegionesXlinea,true));
     return $ListaRegiones;
    }

public function ObetenerEntidadesXRegion($lineaNegocio,$idregion)
    {
        //$log= new KLogger("ObetenerEntidadesXRegion.log", KLogger::DEBUG);
        $ListaEntXRegion = "";
        $ListaEntXRegion = $this->persistencia->getEntidadesXRegion($lineaNegocio,$idregion);
        //$log -> LogInfo ("ObetenerEntidadesXRegion". var_export($ObetenerEntidadesXRegion,true));
        return $ListaEntXRegion;
    }

public function ConteoElementosPorRegión($totalEntidadesXRegion,$lineaNegocio,$fecha1,$fecha2)
    {
        //$log= new KLogger("ConteoElementosPorRegión.log", KLogger::DEBUG);
        $ListaConteo = "";
        $ListaConteo = $this->persistencia->getConteoElementosPorRegión($totalEntidadesXRegion,$lineaNegocio,$fecha1,$fecha2);
        //$log -> LogInfo ("ConteoElementosPorRegión". var_export($ConteoElementosPorRegión,true));
        return $ListaConteo;
    }

    public function obtenerClienteXEntidad($LineaNegocioElegida,$EntidadElegida)
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
        $listaSupervisoresXlinea = array();
        $listaSupervisoresXlinea = $this->persistencia->getClientesXEntidad($LineaNegocioElegida,$EntidadElegida);
        //$log->LogInfo("Valor de la variable \$obtenerClienteXEntidad: " . var_export ($obtenerClienteXEntidad, true));
        return $listaSupervisoresXlinea;
    }
    public function getTTipoTurnoCurbierto($i, $puntoServicioId) {
    return $this->persistencia->ObtenerTTipoTurnoCurbierto($i, $puntoServicioId);
}
//supervisor
public function obtenerTurnosXdiaDePuntosDelSupervisor($lineaNegocioElegido,$supervisorElegido)
{
    $lista = array();
    $lista = $this->persistencia->obtenerTurnosXdiaDePuntosDelSupervisorPer($lineaNegocioElegido,$supervisorElegido);
    return $lista;
}

public function  obtenerTurnosCubiertosByFechas($fechaInicial, $fechaFinal,$supervisorElegido,$lineaNegocioElegido) 
{
    return $this->persistencia-> obtenerTurnosCubiertosByFechas($fechaInicial, $fechaFinal,$supervisorElegido,$lineaNegocioElegido);;
}

public function ObtenervehiculosRegiones($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $listaVehiculosRegiones = array();
    $listaVehiculosRegiones = $this->persistencia->GetvehiculosRegiones($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $listaVehiculosRegiones;
}

public function obtenerTurnosdePlantillas($supervisorNumero,$tipoBusqueda,$lineaNegocioElegido)
{
 $listaturnos = array();
 $listaturnos = $this->persistencia->getTurnosdePlantillas($supervisorNumero,$tipoBusqueda,$lineaNegocioElegido);
 return $listaturnos;
}

public function DatosPlantillas($supervisorNumero,$tipoBusqueda,$lineaNegocioElegido)
{
 $listaDatosPlantilla = array();
 $listaDatosPlantilla = $this->persistencia->obtenerDatosPlantillas($supervisorNumero,$tipoBusqueda,$lineaNegocioElegido);
 return $listaDatosPlantilla;
}

public function TurnosCubiertosXPuntos($supervisorNumero,$i,$tipoBusqueda,$lineaNegocioElegido)
 {
  return $this->persistencia->ObtenerTurnosCubiertosXPuntos($supervisorNumero,$i,$tipoBusqueda,$lineaNegocioElegido);
 }

public function TurnosCubiertosIncidencias($supervisorNumero,$i,$lineaNegocioElegido,$tipoBusqueda)
 {
  return $this->persistencia->ObtenerTurnosCubiertosIncidencias($supervisorNumero,$i,$lineaNegocioElegido,$tipoBusqueda);
 }

 public function ObtenerNumeroElementosVentas($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ListaELementosVentasRegiones = array();
    $ListaELementosVentasRegiones = $this->persistencia->GetNumeroElementosVentas($listaRegiones,$totalEntidadesPorRegion,$LineaNegocioRegiones,$fechaInicial,$fechaFinal,$entidadregion,$casoConsulta,$casoFechas);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ListaELementosVentasRegiones;
}
public function ObtenerEspacioPlantillaDisminuir($servicioPlantillaId)
    {
        //$log = new KLogger ( "negocio_getServicioPlantillaById.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->GetEspacioPlantillaDisminuir($servicioPlantillaId);
        return $lista;
    }
public function ObetenerDescasnoFatigaXPunto($i, $puntoServicioId) {
    return $this->persistencia->GetDescasnoFatigaXPunto($i, $puntoServicioId);
}
//empieza permanencia
public function obtenerempleadosPermanencia($fechai,$fechaf,$lineaNeg,$tipoBusquedaPermanencia)
{
    $EmpleadosParaObtenerPermanencia = array();
    $EmpleadosParaObtenerPermanencia = $this->persistencia->GetempleadosPermanencia($fechai,$fechaf,$lineaNeg,$tipoBusquedaPermanencia);
     return $EmpleadosParaObtenerPermanencia;
}

public function obtenerSupervisorPorEmpleado($idpuntoServicio)
{
    $SupervisorXEmp = array();
    $SupervisorXEmp = $this->persistencia->getSupervisorPorEmpleado($idpuntoServicio);
     return $SupervisorXEmp;
}

public function obtenerTotalEmpleados($lineaNeg)
{
    $TotalEmpleados = array();
    $TotalEmpleados = $this->persistencia->GetTotalEmpleados($lineaNeg);
     return $TotalEmpleados;
}


public function obtenerCoberturaXEmp($fechaIngresoEmp,$fechaBajaEmp,$NumeroEmp)
{
    $TotalCoberturaEmp = array();
    $TotalCoberturaEmp = $this->persistencia->GetCoberturaXEmp($fechaIngresoEmp,$fechaBajaEmp,$NumeroEmp);
     return $TotalCoberturaEmp;
}

public function getDatosEmpBaja($empleadoidd,$usuariorol)
{
    $lista = array();
    $lista = $this->persistencia->obtenerDatosEmpBaja($empleadoidd,$usuariorol);
    return $lista;
}

public function InsertarRegistoArchivoBajaEmpleado($MotivoBaja,$especifiqueMotivo1,$empleadoEntidadFirma,$empleadoConsecutivoFirma,$empleadoCategoriaFirma,$FirmaInterna,$asistenciaFecha,$FechaBajaEmpModal,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$usuarioRegistroFirma,$NombreEmpleado,$Estado,$PuntoServicio,$Cliente,$NombreSupervisor,$ModuloBaja,$FirmaInternaGuardiaRh,$banderaBetadoAsistencia,$ComentarioBetadoAsistencia)
    {
        $this->persistencia->InsertRegistoArchivoBajaEmpleado($MotivoBaja,$especifiqueMotivo1,$empleadoEntidadFirma,$empleadoConsecutivoFirma,$empleadoCategoriaFirma,$FirmaInterna,$asistenciaFecha,$FechaBajaEmpModal,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$usuarioRegistroFirma,$NombreEmpleado,$Estado,$PuntoServicio,$Cliente,$NombreSupervisor,$ModuloBaja,$FirmaInternaGuardiaRh);
        $empleado["entidadId"]       = $empleadoEntidadId;
        $empleado["consecutivoId"]   = $empleadoConsecutivoId;
        $empleado["tipoId"]          = $empleadoTipoId;
        $this->persistencia->updateEstatusEmpleadoOperacionesBetado($empleado,$banderaBetadoAsistencia,$ComentarioBetadoAsistencia);
    }

 public function actualizarBorrarArchivoBajaEmpleado($numeroEmpleado,$fechaBaja,$caso,$usuarioProcesarBaja)
    {
        $pertM = $this->persistencia->UpdateDeleteArchivosBajaEmpleado($numeroEmpleado,$fechaBaja,$caso,$usuarioProcesarBaja);
    }

    public function getListaArchivosBajasEmp()
{
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

    $ListaVacaPeticion = array();
    $ListaVacaPeticion = $this->persistencia->obtenerListaArchivosBajasEmp();
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
    return $ListaVacaPeticion;
}

public function obtenerListaReportesDocumentos($FechaInicioDoc,$FechaFinDoc)
{

    $listaReportesDocumentos = array();
    $listaReportesDocumentos = $this->persistencia->GetListaReportesDocumentos($FechaInicioDoc,$FechaFinDoc);
     return $listaReportesDocumentos;
}

public function obtenerHistoricoAlm($tipo,$estatusEmpleado,$fechaconsultaInicial,$fechaconsultaFin)
{
    $ListaHisAlm = array();
    $ListaHisAlm = $this->persistencia->GetHistoricoAlm($tipo,$estatusEmpleado,$fechaconsultaInicial,$fechaconsultaFin);
     return $ListaHisAlm;
}

public function obtenerCantidadStock($uniformeSeleccionado,$EntidadSeleccionada,$sucursalSeleccionada)
    {
        $cantidadUniStock = array();
        //   $log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($usuario, true));
        $cantidadUniStock = $this->persistencia->getCantidadStock($uniformeSeleccionado,$EntidadSeleccionada,$sucursalSeleccionada);
        return $cantidadUniStock;
    }

public function GetPreguntasPorCasos($caso,$pregunta1,$pregunta2)
{
        //$log = new KLogger ( "negocio_traerListaMunicipiosPorEntidad.log" , KLogger::DEBUG );
    $ListaPreguntas = $this->persistencia->ObtenerPreguntasPorCasos($caso,$pregunta1,$pregunta2);
        //$log->LogInfo("listaMunicipios " . var_export ($listaMunicipios, true));
    return $ListaPreguntas;

}

public function RegistrarFirmaElectronica($idEntidadEmpleadoFirma,$consecutivoEmpleadoFirma,$tipoResponsableEmpleadoFirma,$selPreguntaUnoFirma,$impPrimerPregunta,$selPreguntaDosFirma,$impSegundaPregunta,$selPreguntaTresFirma,$impTerceraPregunta,$ContraseniaFirma,$usuarioRegistroFirma)
    {
        $this->persistencia->InsertFirmaElectronica($idEntidadEmpleadoFirma,$consecutivoEmpleadoFirma,$tipoResponsableEmpleadoFirma,$selPreguntaUnoFirma,$impPrimerPregunta,$selPreguntaDosFirma,$impSegundaPregunta,$selPreguntaTresFirma,$impTerceraPregunta,$ContraseniaFirma,$usuarioRegistroFirma);
    }

public function RevisionRegistroPrevioDeFirma($idEntidadEmpleadoFirma,$consecutivoEmpleadoFirma,$tipoResponsableEmpleadoFirma)
{
    $RevisionFirma = array();
    $RevisionFirma = $this->persistencia->RevisionRegistroPrevioDeFirma1($idEntidadEmpleadoFirma,$consecutivoEmpleadoFirma,$tipoResponsableEmpleadoFirma);
    return $RevisionFirma;

}

     public function InsertTMP($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $idUniforme, $cantidadUni, $usuarioCaptura, $entidadUniforme,$idTipoMercans,$costoIngresado1,$sucursalSeleccionada)
    {
       // if ($this->persistencia->uniformesPorEntidad($entidadUniforme, $idUniforme, $cantidadUni) == true) {
            $this->persistencia->InsertTMPPer($idUniforme, $cantidadUni, $empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $usuarioCaptura,$entidadUniforme,$idTipoMercans,$costoIngresado1,$sucursalSeleccionada);
         /*   } else {
                throw new Exception("No existe uniforme disponible");
            }*/
    }

public function obtenerAsignacionesByEmpleadotmp($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado,$orden)
    {
        $lista = array();
        $lista = $this->persistencia->getAsignacionesByEmpleadotmp($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado,$orden);
        return $lista;
    }

public function getDatosFirmaAlmacenada($numeroEmpleado)
{
        //$log = new KLogger ( "negocio_traerListaMunicipiosPorEntidad.log" , KLogger::DEBUG );

    $ListaDatosGuardadosFirma = $this->persistencia->ObtenerDatosFirmaAlmacenada($numeroEmpleado);
        //$log->LogInfo("listaMunicipios " . var_export ($listaMunicipios, true));
    return $ListaDatosGuardadosFirma;

}

public function restaurarContraseniaFrimaElectronicaint($contrasenia,$entidadEmpleadoFirma, $consecutivoEmpleadoFirma, $tipoEmpleadoFirma)
{
    $this->persistencia->restaurarContraseniaFrimaElectronicaint1($contrasenia,$entidadEmpleadoFirma, $consecutivoEmpleadoFirma, $tipoEmpleadoFirma);
}

public function eliminarTMP($usuario)
{
 $this->persistencia->eliminarTMPPer($usuario);
}

public function obtenerMaxId()
{
 $maxid = array();
 $maxid = $this->persistencia->getMaxId();
 return $maxid;
}

public function obtenerAsignacionesTemporales($NumeroEmpleado,$usuarioCaptura)
{
 $AsigTMP = array();
 $AsigTMP = $this->persistencia->getAsignacionesTemporales($NumeroEmpleado,$usuarioCaptura);
 return $AsigTMP;
}

public function getFirmaSolicitada($NumEmpModal, $constraseniaFirma)
{

    $FirmaEmp = array();
    $FirmaEmp = $this->persistencia->obtenerFirmaSolicitada($NumEmpModal, $constraseniaFirma);
    return $FirmaEmp;
}
public function negocio_obtenerEmpleadoPorIdFirmaBaja($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

    $empleado = array();
    $empleado = $this->persistencia->obtenerEmpleadoPorIdFirmaBaja($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
    return $empleado;
}

public function obtenerOrdenesbyEMp($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria)
{
 $ListaOrdenes = array();
 $ListaOrdenes = $this->persistencia->getOrdenesbyEMp($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
  return $ListaOrdenes;
}

public function obtenerInfoAsigXEmp($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{
 $empleadoInfoAsig = array();
 $empleadoInfoAsig = $this->persistencia->getInfoAsigXEmp($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
 return $empleadoInfoAsig;
}

public function getDatosEmpBajaFolioBaja($empleadoidd)
{
    $lista = array();
    $lista = $this->persistencia->obtenerDatosEmpBajaFolioBaja($empleadoidd);
    return $lista;
}

public function getDatosEmpBajaFolioBajaHistorico($empleadoidd,$fechaSolicitud)
{
    $lista = array();
    $lista = $this->persistencia->obtenerDatosEmpBajaFolioBajaHistorico($empleadoidd,$fechaSolicitud);
    return $lista;
}
 
 public function ConsultaUniformesAsig($usuarioCaptura)
    {
     $lista = array();
     $lista = $this->persistencia->ConsultaUniformesAsigPer($usuarioCaptura);
     return $lista;
    }

 public function EliminarUltimoReg($usuarioCaptura)
    {
        $lista = $this->persistencia->EliminarUltimoRegPer($usuarioCaptura);
    }

public function obtenerUniformesEntregadosByEmpleadoHistorico($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado,$tipoMovimiento)
    {
        $lista = array();

        $lista = $this->persistencia->getEntregadosByGuardiaHistorico($entidadEmpleado, $consecutivoEmpleado, $categoriaEmpleado,$tipoMovimiento);
        return $lista;

    }

public function insertDatosAlmFin($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria)
{
 $this->persistencia->insertDatosAlmFinPER($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
}

public function obtenerIdUsuarioLogeado($usuarioId)
    {
        $IdUsuLogeado = array();

        $IdUsuLogeado = $this->persistencia->getSupervisorIdByUsuarioId($usuarioId);
        return $IdUsuLogeado;

    }
public function negocio_obtenerListaEntidadesFeferativasFirma()
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listaEntidadesFederativas = array();
        $listaEntidadesFederativas = $this->persistencia->traeCatalogoEntidadesFederativasFrima();
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listaEntidadesFederativas;
    }

public function insertRecepcionTMP($idUniforme,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$estatusRecepcion,$entidadUsuario,$usuarioCaptura,$fechaAsignacion,$tipoMerca,$monto,$idUniformeSupervisor,$porcentajeCobro,$coberturaEmpleado,$costoActualUniforme,$sucursalUsuario)
{
 $this->persistencia->insertRecepcionTMPPER($idUniforme,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$estatusRecepcion,$entidadUsuario,$usuarioCaptura,$fechaAsignacion,$tipoMerca,$monto,$idUniformeSupervisor,$porcentajeCobro,$coberturaEmpleado,$costoActualUniforme,$sucursalUsuario);
}

public function obtenerUniformeARecibir($usuarioLogeado)
    {
     $listaUnifARecibir = array();
     $listaUnifARecibir = $this->persistencia->obtenerUniformeARecibirPER($usuarioLogeado);
     //$log->LogInfo("Valor de la variable \$listaUnifARecibir: " . var_export ($listaUnifARecibir, true));
     return $listaUnifARecibir;
    }

public function eliminarRecpUniTMP($usuario)
{
 $this->persistencia->eliminarRecpUniTMPPer($usuario);
}

public function obtenerUnifAsigDeuda()
    {
     $uniformesDeudaAsig = array();
     $uniformesDeudaAsig = $this->persistencia->obtenerUnifAsigDeudaPER();
     //$log->LogInfo("Valor de la variable \$uniformesDeudaAsig: " . var_export ($uniformesDeudaAsig, true));
     return $uniformesDeudaAsig;
    }

public function actualizarestatusdeudaUniformes($entidadEmpDeudaU,$consecutivoEmpDeudaU,$categoriaEmpDeudaU,$idDeudaUni)
{
    $this->persistencia->actualizarestatusdeudaUniformesPER($entidadEmpDeudaU,$consecutivoEmpDeudaU,$categoriaEmpDeudaU,$idDeudaUni);
}

public function InsertDeudaDesdeRecepcion($NombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme, $cantidadUni,$usuarioCaptura,$entidadUsuario,$montoDur,$FirmaGuardia,$NumeroEmpFirma,$FirmaEmp,$NombreEmp,$orden,$descripcionUni,$fechaAsignacion,$fechaRecepcionTMP,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr)
{
 $this->persistencia->insertDeudasUniformeRecepcion($NombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme, $cantidadUni,$usuarioCaptura,$entidadUsuario,$montoDur,$FirmaGuardia,$NumeroEmpFirma,$FirmaEmp,$NombreEmp,$orden,$descripcionUni,$fechaAsignacion,$fechaRecepcionTMP,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr);
}

public function obtenercontraseniaEmpAsignacion($UsuarioEmpleado)
    {
        $datosContrasenia = array();
        $datosContrasenia = $this->persistencia->getUser($UsuarioEmpleado);
        return $datosContrasenia;
    }

public function obtenerEntidadTrabajoEmpleadoQueAsigna($numEmpAlmacen){
 $numeroEMPalm = array();
 $numeroEMPalm = $this->persistencia->obtenerEntidadTrabajoEmpleadoQueAsignaPER($numEmpAlmacen);
 return $numeroEMPalm;
}

public function obtenerEmpleadosProcesoFiniquitoParaAlmacen($usuario)
{

    $empeldosFiniquitos = array();
    $empeldosFiniquitos = $this->persistencia->getEmpleadosProcesoFiniquitoParaAlmacen($usuario);
    return $empeldosFiniquitos;
}

public function obtenerDeudaCalzado($entidadEmpDeuda, $consecutivoEmpDeuda, $categoriaEmpDeuda,$idDeudaUni)
    {
     $listacalzadodeuda = array();
     $listacalzadodeuda = $this->persistencia->obtenerDeudaCalzadoPEr($entidadEmpDeuda, $consecutivoEmpDeuda, $categoriaEmpDeuda,$idDeudaUni);
     return $listacalzadodeuda;
    }


    public function negocio_obtenerEstatusEmpladoParaFirmaFniquitoUni($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

    $empleado = array();
    $empleado = $this->persistencia->getEstatusEmpladoParaFirmaFniquitoUni($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
    return $empleado;
}

public function InsertdeudaDirectaFiniquito($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$TotalACobro)
{
 $this->persistencia->InsertdeudaDirectaFiniquitoPER($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$TotalACobro);
}

public function InserthistoricoBajasDirectasAlm($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$empleadoEntidadGuardia,$empleadoConsecutivoGuardia,$empleadoCategoriaGuardia,$FirmaEmp)
{
 $this->persistencia->InserthistoricoBajasDirectasAlmPER($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$empleadoEntidadGuardia,$empleadoConsecutivoGuardia,$empleadoCategoriaGuardia,$FirmaEmp);
}

public function negocio_consultarDatosFiniquito($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$montoDur,$valRsi)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );
    $TotalACobro = array();
   $TotalACobro =$this->persistencia->consultarDatosFiniquitoUpdate($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$montoDur,$valRsi);
   return $TotalACobro;
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
}
public function obtenerlargorecepcionesTMP($usuarioLogeado)
{
    $largoR = array();
    $largoR = $this->persistencia->obtenerlargorecepcionesTMPPERLARGOPER($usuarioLogeado);
    return $largoR;
}

public function obtenerUnifPagadosBYcontabilidad()
    {
     $uniformespagadosContabilidad = array();
     $uniformespagadosContabilidad = $this->persistencia->obtenerUnifPagadosBYcontabilidadPER();
     //$log->LogInfo("Valor de la variable \$uniformespagadosContabilidad: " . var_export ($uniformespagadosContabilidad, true));
     return $uniformespagadosContabilidad;
    }


public function restaurarContraseniaOaraGuardia($contrasenia,$usuarioGuardia,$correo)
{
    $this->persistencia->restauracionContraseniaOaraGuardia($contrasenia,$usuarioGuardia,$correo);
}

public function consultacatalogoUniformesSolicitud(){
    $uniformes = array();
    $uniformes = $this->persistencia->consultacatalogoUniformesSolicitudPER();
    return $uniformes;
}

public function insertsolicitudUniforme($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$tipouniSolicitud,$cantidadsolicitud){
 $this->persistencia->insertsolicitudUniformePER($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$tipouniSolicitud,$cantidadsolicitud);
}

public function obtenerSolicitudUniforme()
{
    $ListaSolUni = array();
    $ListaSolUni = $this->persistencia->GetSolicitudUniforme();
     return $ListaSolUni;
}


public function obtenerUniformesParaRecibir($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria)
    {
        $uniformeRecib = array();
        $uniformeRecib = $this->persistencia->obtenerUniformesParaRecibirPER($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
        return $uniformeRecib;
    }

public function ConfirmarManualmenteSolicitud($idSolicitudUniforme){
 $this->persistencia->ConfirmarManualmenteSolicitudPER($idSolicitudUniforme);
}

public function datosEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$Usuario){
 //$log = new KLogger ( "datosEmpleado.log" , KLogger::DEBUG );
 $empleado = array();
 $empleado = $this->persistencia->datosEmpleadoPER($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$Usuario);
 return $empleado;
 //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
}

public function stockSupervisor($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria){
 //$log = new KLogger ( "datosEmpleado.log" , KLogger::DEBUG );
 $empleado = array();
 $empleado = $this->persistencia->stockSupervisorPER($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
 return $empleado;
 //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
}

public function ObtenerEmpleadoestabetado($entidadempDeu,$consecutivoempDeu,$categoriaempDeu)
    {
        $getbetado = array();
        $getbetado = $this->persistencia->GetEmpleadoestabetado($entidadempDeu,$consecutivoempDeu,$categoriaempDeu);
        return $getbetado;
    }

public function getDatosEmpleadoVetado($empleadoidd)
{
    $lista = array();
    $lista = $this->persistencia->obtenerDatosEmpleadoVetado($empleadoidd);
    return $lista;
}
 
public function obtenerUniformesElegidos($idcheckUniforme){
 $AsigTMP = array();
 $AsigTMP = $this->persistencia->obtenerUniformesElegidosPER($idcheckUniforme);
 return $AsigTMP;
}

    public function asignarUniformeSupervisor($nombreGuardia,$empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$cantidadUni,$usuarioCaptura,$entidadUniforme,$maxid,$tipoUniforme,$codigoUnif,$talla,$descripcionTipoUnif, $EntidadEmpleadoUSR,$numEmpAlmacen,$FirmaEmpAlmacen,$FirmaGuardia,$NombreEmpAlmacen,$costoIngresado1,$idcheckUniforme,$cantidadUniINICIAL,$rolUsuario){
        
         $this->persistencia->asignarUniformeSupervisorPER($nombreGuardia,$idUniforme, $cantidadUni, $empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $usuarioCaptura,$maxid,$codigoUnif,$talla,$descripcionTipoUnif, $EntidadEmpleadoUSR,$numEmpAlmacen,$FirmaEmpAlmacen,$FirmaGuardia,$NombreEmpAlmacen,$costoIngresado1,$tipoUniforme,$entidadUniforme,$rolUsuario);
         
         $this->persistencia->actualizarStockSupervisor($costoIngresado1,$idcheckUniforme,$cantidadUni,$cantidadUniINICIAL);

         if ($tipoUniforme=='5') {
             $this->persistencia->insertDeudasUniforme($nombreGuardia,$empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $idUniforme, $cantidadUni, $usuarioCaptura, $entidadUniforme,$costoIngresado1,$FirmaGuardia,$numEmpAlmacen,$FirmaEmpAlmacen,$NombreEmpAlmacen,$maxid,$descripcionTipoUnif);
         }
      
    }

public function obtenerPuntosServSup($Usuario){
 //$log = new KLogger ( "obtenerPuntosServSup.log" , KLogger::DEBUG );
 $empleado = array();
 $empleado = $this->persistencia->obtenerPuntosServSupPER($Usuario);
 return $empleado;
 //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
}

public function datosEmpleadoXSup($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$PuntosServ){
 //$log = new KLogger ( "datosEmpleadoXSup.log" , KLogger::DEBUG );
 $empleado = array();
 $empleado = $this->persistencia->datosEmpleadoXSupPER($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$PuntosServ);
 return $empleado;
 //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
}

public function getPlantillasByPuntoServiciosntidades($clientes,$entidades)
{

        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));

    $lista = array();

    $lista = $this->persistencia->ObtenerPlantillasByPuntoServiciosEntidades($clientes,$entidades);

    return $lista;
}

public function obtenerUniformesParaPlantilla($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria){
        $uniformeRecibDePlantilla = array();
        $uniformeRecibDePlantilla = $this->persistencia->obtenerUniformesParaPlantillaPER($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
        return $uniformeRecibDePlantilla;
    }

public function obtenerCardexSupPlantilla($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria){
        $cardexSupPlantilla = array();
        $cardexSupPlantilla = $this->persistencia->obtenerCardexSupPlantillaPER($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria);
        return $cardexSupPlantilla;
    }

public function recibirUniformeEmpleadoPlantilla($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria,$idUniforme,$estatusRecibo,$fechaAsignacion,$usuarioCaptura,$entidadUsuario,$codigoUniforme,$talla,$descripcionUni,$montoDur,$NombreEmp,$FirmaEmp,$FirmaGuardia,$orden,$NombreGuardia,$NumeroEmpFirma,$idUniformeSup,$cantidadUniformeSup,$estatusImssemp,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado,$sucursalUsr){

     $this->persistencia->recibirUniformeSupPlantilla($idUniformeSup,$cantidadUniformeSup,$montoDur,$estatusImssemp,$estatusRecibo,$porcentajeCobrado,$precioDelUniforme,$coberturaEmpleado);
     $this->persistencia->insertBajasEHistorico($empleadoEntidad, $empleadoConsecutivo, $empleadoCategoria, $fechaAsignacion, $idUniforme, $estatusRecibo, $usuarioCaptura, $entidadUsuario,$codigoUniforme,$talla,$descripcionUni,$montoDur,$NombreEmp,$FirmaEmp,$FirmaGuardia,$orden,$NombreGuardia,$NumeroEmpFirma,$sucursalUsr);
     if($estatusRecibo == 0) {
         $this->persistencia->insertarStockUniformeDesdeSUP($idUniforme, $entidadUsuario, 1,$sucursalUsr);
       }
    }

public function obtenerDatosUniformeSupervisor($idUniformeSup){
        $infUnif = array();
        $infUnif = $this->persistencia->obtenerDatosUniformeSupervisorPER($idUniformeSup);
        return $infUnif;
    }

public function obtenerListaHistoricoAsignacionesSup($Nosupervisor,$tipoBusqueda)
{

    $historicoListaHistAsigSup = array();
    $historicoListaHistAsigSup = $this->persistencia->obtenerListaHistoricoAsignacionesSupPER($Nosupervisor,$tipoBusqueda);
     return $historicoListaHistAsigSup;
}


public function negocio_obtenerRepse()
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

    $ORepse = array();
    $ORepse = $this->persistencia->obtenerRepse();
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
    return $ORepse;
}

public function TraerTiposContratosClientes()
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

    $listaBancos = $this->persistencia->GetTiposContratosClientes();
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
    return $listaBancos;

}

public function negocio_TraerEntidades()
{
        //$log= new KLogger("negocio.log", KLogger::DEBUG);

    $listantidades = $this->persistencia->GetEntidades();
        //$log -> LogInfo ("negocio_ListaBancos". var_export($listaBancos,true));
    return $listantidades;

}

public function negocio_TraerMunicipiosCliente($txtEntidadCliente)
{
    $listamunicipio = $this->persistencia->ObtenerMunicipiosCliente($txtEntidadCliente);

    return $listamunicipio;
}

public function negocio_TraerColoniasCliente($txtMunicipio)
{
    $lsyacolonia = $this->persistencia->ObtenerColoniasCliente($txtMunicipio);

    return $lsyacolonia;
}

public function obtenerCatalogoContratosDeClientes()
{
 $ListaContratos = array();
 $ListaContratos = $this->persistencia->obtenerLisCatalogoContratosDeClientesPER();
 return $ListaContratos;
}

public function updateContratosClientes($descContrato,$idContrato,$i,$usuario)
{
 $this->persistencia->updateContratosClientesPER($descContrato,$idContrato,$i,$usuario);
}

public function insertContrato($descContrato,$usuario)
{
 $this->persistencia->insertContratoPER($descContrato,$usuario);
}

public function insertOpinionInfonavit($registro,$mes,$anio,$nombrearchivo)
{
 $this->persistencia->insertOpinionInfonavitPER($registro,$mes,$anio,$nombrearchivo);
}

public function insertOpinionIMSS($mes,$anio,$nombrearchivo)
{
 $this->persistencia->insertOpinionIMSSPER($mes,$anio,$nombrearchivo);
}


public function consultaPDF($registro,$mes,$anio)
{
 $listaPDf = array();
 $listaPDf = $this->persistencia->consultaPDFPER($registro,$mes,$anio);
 return $listaPDf;
}

public function consultaPDFIMSS($mes,$anio)
{
 $listaPDfimss = array();
 $listaPDfimss = $this->persistencia->consultaPDFPERIMSS($mes,$anio);
 return $listaPDfimss;
}

public function DetalleTrabajadores($fechaInicio,$fechaFin)
{
 $detalleTrabajadores = array();
 $detalleTrabajadores = $this->persistencia->DetalleTrabajadoresPER($fechaInicio,$fechaFin);
     return $detalleTrabajadores;
}

public function DetalleContrato($fechaInicio,$fechaFin,$usuario)
{
 $empleadosContxCliente = array();
 $empleadosContxCliente = $this->persistencia->DetalleContratoPER($fechaInicio,$fechaFin,$usuario);
     return $empleadosContxCliente;
}

public function empleadosContrato($idCliente,$fechaInicio,$fechaFin)
{
 $detalleContrato = array();
 $detalleContrato = $this->persistencia->empleadosContratoPERSISTENCIA($idCliente,$fechaInicio,$fechaFin);
     return $detalleContrato;
}

public function infoDetalleSujetoObligado()
{
 $detalleSujetoOb = array();
 $detalleSujetoOb = $this->persistencia->infoDetalleSujetoObligadoPER();
     return $detalleSujetoOb;
}

public function registrosPatronalesSujetoObligado()
{
 $registrosPatronalesSujetoOb = array();
 $registrosPatronalesSujetoOb = $this->persistencia->registrosPatronalesSujetoObligadoPERSISTENCIA();
     return $registrosPatronalesSujetoOb;
}

public function infoEscrituraPublica($fechaFin)
{
 $infoEscrituraP = array();
 $infoEscrituraP = $this->persistencia->infoEscrituraPublicaPER($fechaFin);
 return $infoEscrituraP;
}

public function obtenerRepse1()
{
 $getrepse = array();
 $getrepse = $this->persistencia->obtenerRepsePER();
 return $getrepse;
}

public function puntoservYCoberturaMaximaXemp($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaIngreso,$fechaBaja)
{
 $puntoServYCobXemp = array();
 $puntoServYCobXemp = $this->persistencia->puntoservYCoberturaMaximaXempPERSISTENCIA($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaIngreso,$fechaBaja);
     return $puntoServYCobXemp;
}

public function infoPSyContratoXEmp($idPuntoServ)
{
 $infoPSContrato = array();
 $infoPSContrato = $this->persistencia->infoPSyContratoXEmpPERSISTENCIA($idPuntoServ);
     return $infoPSContrato;
}

public function negocio_TraerDatosClientesPorClave($claveNomina,$NumeroEditarCliente,$AnexoEditarCliente,$Tipo)
{
    $DatosClientePorclave = $this->persistencia->ObtenerDatosClientesPorClave($claveNomina,$NumeroEditarCliente,$AnexoEditarCliente,$Tipo);

    return $DatosClientePorclave;
}

public function negocio_UpdateContratosCLientes($cliente)
    {  

        $patronNumeroClienteNom = '/[0-9]{4}+\-+[0-9]{3}+\-+[0-9]{3}/';
        $patrocp               = '/[0-9]{5}/';
        $patrontelefono         = '/[0-9]{10}/';
        $patronRfcCont = '/[a-zA-Z0-9]{3}+[0-9]{6}+[a-zA-Z0-9]{3}/';
        $patronRfc2 = '/[a-zA-Z]{4}+[0-9]{6}+[a-zA-Z0-9]{3}/';
        $patronCorreo   = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
        $log = new KLogger ( "negocioRegistroCliente.log" , KLogger::DEBUG );

        $log->LogInfo("Valor de la variable cliente : " . var_export ($cliente, true));
        if( $cliente["BanderaCliente"] == "4"){
            $REvisionSiExiseContrato = $this->persistencia->ObtenerDatosClientesPorClave($cliente["NumeroClienteEditarCliente"],$cliente["NumeroEditarCliente"],$cliente["AnexoEditarCliente"],"0");
            $LargoRevision = count($REvisionSiExiseContrato);
            if ($LargoRevision!="0") {
                throw new Exception("Por favor Seleccione: El Numero Y Anexo Del Contrato Ya Existe Con Este Cliente");
            }
        }
       
        if (($cliente["BanderaCliente"] == "1" || $cliente["BanderaCliente"] == "4") && $cliente["NumeroEditarCliente"] == "0") {
            throw new Exception("Por favor Seleccione: Número De Contrato");
        }
        if (($cliente["BanderaCliente"] == "1" || $cliente["BanderaCliente"] == "4") && $cliente["AnexoEditarCliente"] == "LETRAS") {
            throw new Exception("Por favor Seleccione: Anexo Contrato");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["TipoEditarCliente"] == "0") {
            throw new Exception("Por favor Seleccione: Tipo De Contrato");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["ObjetoEditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: El Objeto De Contrato");
        }
        if (($cliente["BanderaCliente"] == "1" || $cliente["BanderaCliente"] == "4") && ($cliente["VigenciaAnioEditarCliente"] == "0") && ($cliente["VigenciaMesEditarCliente"] =="0")) {
            throw new Exception("Por favor Seleccione: La Vigencia En Años/Meses Del Contrato");
        }
        if (($cliente["BanderaCliente"] == "1" || $cliente["BanderaCliente"] == "4") && $cliente["FechaInicioEditarCliente"] == "") {
            throw new Exception("Por favor Seleccione: Fecha De Inicio Del Contrato");
        }
        if (($cliente["BanderaCliente"] == "1" || $cliente["BanderaCliente"] == "4") && $cliente["FechafinEditarCliente"] == "") {
            throw new Exception("Por favor Revise: Revisar Que La vigencia Y La Fecha De Inio Sean Correctas Para generar La Fecha Final En Automatico");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["RegistroPatronalEditarCliente"] == "") {
            throw new Exception("Por favor ingrese: Registro Patronal");
        }
        if ($cliente["BanderaCliente"] == "5" && $cliente["NombreContactoEditarCliente"] == "") {
            throw new Exception("Por favor ingrese: Nombre De Contacto");
        }
        if ($cliente["BanderaCliente"] == "5" && $cliente["TelefonoFijoEditarCliente"] == "" and $cliente["TelefonoMovilEditarCliente"] == "") {
            throw new Exception("Por favor ingrese por lo menos un numero de contacto");
        }
        if ($cliente["BanderaCliente"] == "5" && $cliente["TelefonoFijoEditarCliente"] != "" && preg_match($patrontelefono, $cliente["TelefonoFijoEditarCliente"]) == false) {
                throw new Exception("Ingresa El Numero Fijo Correctamente ");
        }
        if ($cliente["BanderaCliente"] == "5" && $cliente["TelefonoMovilEditarCliente"] != "" && preg_match($patrontelefono, $cliente["TelefonoMovilEditarCliente"]) == false) {
                throw new Exception("Ingresa El Numero Movil Correctamente ");
        }
        if ($cliente["CpContratoEditarCliente"] == "") {
            throw new Exception("Por favor ingrese: El Codigo Postal  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if (preg_match($patrocp, $cliente["CpContratoEditarCliente"]) == false) {
                throw new Exception("Formaro Codigo Postal inválido 5 Digitos ");
            }
        if ($cliente["EntidadEditarCliente"] == "0") {
            throw new Exception("Por favor Seleccione: La Entidad O Escoga El Asentamiento  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["MunicipioEditarCliente"] == "0") {
            throw new Exception("Por favor Seleccione: Municipio O Escoga El Asentamiento  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["ColoniaEditarCliente"] == "0") {
            throw new Exception("Por favor Seleccione: La Colonia O Escoga El Asentamiento  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["CallePrincipalEditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: La Calle Principal  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["NumeroInteriroEditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: El Numero Interior  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["NumeroExteriorEditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: El Numero Exterior  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["Calle1EditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: La Primer Calle Colindante  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["Calle2EditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: La Segunda Calle Colindante  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["BanderaCliente"] == "5" &&$cliente["CorreoEditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: El Correo Electronico  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["BanderaCliente"] == "5" && preg_match($patronCorreo, $cliente["CorreoEditarCliente"]) == false) {
            throw new Exception("El formato de correo electronico es incorrecto  (Estos datos Deben Ser Modificados Desde La Edicion Del Cliente)");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["MontotxtCorreoEditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: El Monto del Contrato");
        }
        if (($cliente["BanderaCliente"] == "1" || $cliente["BanderaCliente"] == "4") && $cliente["ArchivoContrato"] == "") {
            throw new Exception("Por favor Adjunte el Contrato En Formato PDF");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["RfcContratantetxtCorreoEditarCliente"] == "") {
            throw new Exception("Por favor Ingrese: El RFC Del Contratante");
        }
        if ($cliente["BanderaCliente"] != "5" && strlen($cliente["RfcContratantetxtCorreoEditarCliente"]) != 13) {
            throw new Exception("Por favor ingrese: RFC con longitud de 12 caracteres");
        }
        if ($cliente["BanderaCliente"] != "5" && preg_match($patronRfc2, $cliente["RfcContratantetxtCorreoEditarCliente"]) == false) {
            throw new Exception("El formato del RFC del contratante es incorrecto");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["NombreContratantetxtCorreoEditarCliente"] == "") {
            throw new Exception("Por Faver Ingrese: EL/Los Nombres Del Contratante");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["PrimerApellidoContratantetxtCorreoEditarCliente"] == "") {
            throw new Exception("Por Faver Ingrese: El Primer Apellido Del Contratante");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["CorreoContratantetxtCorreoEditarCliente"] == "") {
            throw new Exception("Por Faver Ingrese: El Correo Del Contratante");
        }
        if ($cliente["BanderaCliente"] != "5" && preg_match($patronCorreo, $cliente["CorreoContratantetxtCorreoEditarCliente"]) == false) {
            throw new Exception("El formato de correo electronico del Contratante es incorrecto");
        }
        if ($cliente["BanderaCliente"] != "5" && $cliente["TelMovilContratantetxtCorreoEditarCliente"] == "") {
            throw new Exception("Por Faver Ingrese: El Telefono Del Contratante");
        }
        if ($cliente["BanderaCliente"] != "5" && preg_match($patrontelefono, $cliente["TelMovilContratantetxtCorreoEditarCliente"]) == false) {
            throw new Exception("El formato del telefono del contratante es incorrecto");
        }

    $this->persistencia->ActualizarInsertarContratosClientes($cliente);
}

public function negocio_RevisarElementosActivosEnELPunto($idPuntoServicio)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ElementosActivos = array();
    $ElementosActivos = $this->persistencia->RevisarElementosActivosEnELPunto($idPuntoServicio);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ElementosActivos;
}

public function getEmpleadoByCorreoParaFirma($correo)
{

        //$log = new KLogger ( "getListaEmpleadosBySupervisorPeriodoId.log" , KLogger::DEBUG );

    $lista        = array();
    $patronCorreo = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';

    if ($correo != "") {
        if (preg_match($patronCorreo, $correo) == false) {
            throw new Exception("El formato de correo electrónico es inválido.");
        }
    }

    if ($correo == "") {

        throw new Exception("Para consultar asistencia debe ingresar el correo electrónico proporcionado en su contratación.");

    }

    $lista = $this->persistencia->getEmpleadoByCorreoParaFirmaInterna($correo);
    return $lista;
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));

}

public function obtenerSupervisoresXLineaNegocio($LineaNegocioElegida,$noSupervisor,$caso,$entidades){
        $listaSupervisoresXlineanEG = array();
        $listaSupervisoresXlineanEG = $this->persistencia->obtenerSupervisoresXLineaNegocioPERSISTENCIA($LineaNegocioElegida,$noSupervisor,$caso,$entidades);
        return $listaSupervisoresXlineanEG;
    }

public function ObtenerPSxSup($lineaNegocio,$fechaInicio,$fechaFin,$entidad,$noSupervisor){
    $ListaPSTotales = array();
    $ListaPSTotales = $this->persistencia->ObtenerPSxSupPERSISTENCIA($lineaNegocio,$fechaInicio,$fechaFin,$entidad,$noSupervisor);
    return $ListaPSTotales;
}
public function ObtenerPSxSupCompleta($lineaNegocio,$fechaInicio,$fechaFin,$listaEntidades,$noSupervisor){
    $ListaPSTotalesComp = array();
    $ListaPSTotalesComp = $this->persistencia->ObtenerPSxSupCompletaPERSISTENCIA($lineaNegocio,$fechaInicio,$fechaFin,$listaEntidades,$noSupervisor);
    return $ListaPSTotalesComp;
}

public function ObtenerINFOEntidadesSup($noSupervisor,$fechaInicio,$fechaFin){
    $ListaEntTotales = array();
    $ListaEntTotales = $this->persistencia->ObtenerINFOEntidadesSupPERSISTENCIA($noSupervisor,$fechaInicio,$fechaFin);
    return $ListaEntTotales;
}

public function ObtenerElementosVentasXPS($puntoS,$fechaInicio,$fechaFin){
    $elementosventasXps = array();
    $elementosventasXps = $this->persistencia->ObtenerElementosVentasXPSPERSISTENCIA($puntoS,$fechaInicio,$fechaFin);
    return $elementosventasXps;
}

public function ObtenerFuerzaOperativa($entidad,$noSupervisor,$lineaNegocio,$fechaInicio,$fechaFin){
    $ListaFO = array();
    $ListaFO = $this->persistencia->ObtenerFuerzaOperativaPERSISTENCIA($entidad,$noSupervisor,$lineaNegocio,$fechaInicio,$fechaFin);
    return $ListaFO;
}

public function ObtenerFuerzaOperativaPS($puntoS,$lineaNegocio,$fechaInicio,$fechaFin){
    $ListaFOPs = array();
    $ListaFOPs = $this->persistencia->ObtenerFuerzaOperativaPSPERSISTENCIA($puntoS,$lineaNegocio,$fechaInicio,$fechaFin);
    return $ListaFOPs;
}

public function ObtenerFuerzaCubre($entidad,$noSupervisor,$lineaNegocio,$fechaInicio,$fechaFin){
    $fuerzaCubre = array();
    $fuerzaCubre = $this->persistencia->ObtenerFuerzaCubrePERSISTENCIA($entidad,$noSupervisor,$lineaNegocio,$fechaInicio,$fechaFin);
    return $fuerzaCubre;
}

public function ObtenerTurnosMerma($entidad,$lineaNegocio,$fechaInicio,$fechaFin,$noSupervisor){
    $ListaMerma = array();
    $ListaMerma = $this->persistencia->ObtenerTurnosMermaPERSISTENCIA($entidad,$lineaNegocio,$fechaInicio,$fechaFin,$noSupervisor);
    return $ListaMerma;
}

public function ElementosPorRolOperativo($entidad,$lineaNegocio,$DescripcionRolOp,$fechaInicio,$fechaFin,$noSupervisor){

    $ListaElementosXRol = array();
    $ListaElementosXRol = $this->persistencia->ElementosPorRolOperativoPERSISTENCIA($entidad,$lineaNegocio,$DescripcionRolOp,$fechaInicio,$fechaFin,$noSupervisor);
    return $ListaElementosXRol;
}

public function ElementosPorRolOperativoPs($puntoS,$lineaNegocio,$DescripcionRolOp,$fechaInicio,$fechaFin){
    $ListaElementosXRolPS = array();
    $ListaElementosXRolPS = $this->persistencia->ElementosPorRolOperativoPsPERSISTENCIA($puntoS,$lineaNegocio,$DescripcionRolOp,$fechaInicio,$fechaFin);
    return $ListaElementosXRolPS;
}

public function plantillasXPunto($puntoServicioId,$fechaInicio,$fechaFin){
    $plantillas = array();
    $plantillas = $this->persistencia->plantillasXPuntoPERSISTENCIA($puntoServicioId,$fechaInicio,$fechaFin);
    return $plantillas;
}

public function diasSolicitadosXSup($PlantillaId,$turnoDiaC,$turnoNocheC){
 $diasSoli = array();
 $diasSoli = $this->persistencia->diasSolicitadosPERSISTENCIA($PlantillaId,$turnoDiaC,$turnoNocheC);
 return $diasSoli;
}

public function vehiculosAsignadosXSup($entidad,$fechaInicio,$fechaFin,$noSupervisor){
    $vehiculosSup = array();
    $vehiculosSup = $this->persistencia->vehiculosAsignadosXSupPERSISTENCIA($entidad,$fechaInicio,$fechaFin,$noSupervisor);
    return $vehiculosSup;
}

public function infoPSxSup($puntoS){
    $infoPuntos = array();
    $infoPuntos = $this->persistencia->infoPSxSupPERSISTENCIA($puntoS);
    return $infoPuntos;
}

public function coberturaXPS($puntoS,$fechaInicio,$fechaFin){
    $CoberturaPS = array();
    $CoberturaPS = $this->persistencia->coberturaXPSPERSISTENCIA($puntoS,$fechaInicio,$fechaFin);
    return $CoberturaPS;
}

public function negocio_obtenerAmortizacionEmpleadosEva($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria, $fechaPeriodo1, $fechaPeriodo2)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerAmortizacionEmpleadosEva($empladoEntidad,$empleadoConsecutivo,$empleadoCategoria, $fechaPeriodo1, $fechaPeriodo2);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}

public function obtenerCatalogoTipoTurnos()
    {
        $listaTipoTurnos = array();
        $listaTipoTurnos = $this->persistencia->getCatalogoTipoTurnos();
        return $listaTipoTurnos;
    }
public function obtenerRolesOperativos($TipoTurno)
{
 $listarolesOperativos = array();
 $listarolesOperativos = $this->persistencia->getRolesOperativos($TipoTurno);
 return $listarolesOperativos;
}

public function obtenerEntidadesDeRegiionXentTrabajo($LineaNegocio,$entidadGerente){
        $listaSupervisoresXlineanEG = array();
        $listaSupervisoresXlineanEG = $this->persistencia->obtenerEntidadesDeRegiionXentTrabajoPERSISTENCIA($LineaNegocio,$entidadGerente);
        return $listaSupervisoresXlineanEG;
    }

public function insertRolOperativo($idTipoT,$descContrato,$usuario)
{
 $this->persistencia->insertarRolOperativo($idTipoT,$descContrato,$usuario);
}

public function obtenerRegionGerente($LineaNegocio,$entidadGerente){
        $listaSupervisoresXlineanGR = array();
        $listaSupervisoresXlineanGR = $this->persistencia->obtenerRegionGerentePERSISTENCIA($LineaNegocio,$entidadGerente);
        return $listaSupervisoresXlineanGR;
    }

public function obtenerIdRolesOperativos($PlantillaIdRol)
{
 $listarolesOperativosid = array();
 $listarolesOperativosid = $this->persistencia->GetIdRolesOperativos($PlantillaIdRol);
 return $listarolesOperativosid;
}

public function obtenerUltimaEscrituraPublica(){

 //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );
 $listaLineasNegocio = array();
 $listaLineasNegocio = $this->persistencia->obtenerUltimaEscrituraPublicaPERSISTENCIA();
 //$log->LogInfo("Valor de la variable \$obtenerLineasDeNegocio: " . var_export ($obtenerLineasDeNegocio, true));
 return $listaLineasNegocio;
}

public function ObtenerPlantillaParaAdmin($tipoTurnoPlantillaId,$puntoServicioPlantillaId)
    {
        //$log = new KLogger ( "negocio_selectPlantillaRequisicion.log" , KLogger::DEBUG );

        $lista = array();
        $lista = $this->persistencia->GetPlantillaParaAdmin($tipoTurnoPlantillaId,$puntoServicioPlantillaId);
        return $lista;
    }

public function updateDatosEscrituraPublica($RepresentanteLegal,$AdministradorUnico,$NumeroEscritura,$NombreNotarioPublico,$NumeroNotarioPublico,$FechaEscrituraPublica,$FolioMercantil,$nombreDocumento){
 
 $this->persistencia->updateDatosEscrituraPublicaPERSISTENCIA($RepresentanteLegal,$AdministradorUnico,$NumeroEscritura,$NombreNotarioPublico,$NumeroNotarioPublico,$FechaEscrituraPublica,$FolioMercantil,$nombreDocumento);
}

public function obtenerMaxIdEscrituraP(){
   $noIdEscritura = array();
   $noIdEscritura = $this->persistencia->obtenerMaxIdEscrituraPersistencia();
   return $noIdEscritura;
}

public function GetCierrePeridoParaBtnBorrar()
{
    $fechaCierreEm = array();
    $fechaCierreEm = $this->persistencia->ObtenerCierrePeridoParaBtnBorrar();
    return $fechaCierreEm;

}

public function obtenerRolesOperativosExistentes(){
    $ListaRolesOperativos = array();
    $ListaRolesOperativos = $this->persistencia->obtenerRolesOperativosExistentesPERSISTENCIA();
    return $ListaRolesOperativos;
}

public function negocio_obtenerSupervisoresXPuntoFati($idClientePunto,$rangoFecha1,$rangoFecha2)
{
        //$log = new KLogger ( "negocio_obtenerSupervisoresOperativos.log" , KLogger::DEBUG );

    $listaSupervisoresOperativosFat = array();
    $listaSupervisoresOperativosFat = $this->persistencia->getSupervisoresXPuntoFati($idClientePunto,$rangoFecha1,$rangoFecha2);
        //$log->LogInfo("Valor de la variable \$listaSupervisoresOperativos: " . var_export ($listaSupervisoresOperativos, true));
    return $listaSupervisoresOperativosFat;
}

public function consultaRepse(){
    $repse = array();
    $repse = $this->persistencia->consultaRepsePERSISTENCIA();
    return $repse;
}

public function eliminarRepse($idRep){
    $this->persistencia->eliminarRepsePERSISTENCIA($idRep);
}

public function updateRepse($noAcuerdo,$noFolioIn,$idRepse){
    $this->persistencia->updateRepsePERSISTENCIA($noAcuerdo,$noFolioIn,$idRepse);
}

public function insertRepse($noAcuerdo,$noFolioIn,$nombreDocumento){
    $this->persistencia->insertRepsePERSISTENCIA($noAcuerdo,$noFolioIn,$nombreDocumento);
}

public function obtenerUniformesParaFiniq()
{
    $ListaHistoricoUniParaFini = array();
    $ListaHistoricoUniParaFini = $this->persistencia->GetUniformesParaFiniq();
     return $ListaHistoricoUniParaFini;
}

public function obtenerIncapacidadesDetalleTrab($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaIngreso,$fechaBaja)
{
 $incapacidades = array();
 $incapacidades = $this->persistencia->obtenerIncapacidadesDetalleTrabPERSISTENCIA($entidadFederativaId,$empleadoConsecutivoId,$empleadoCategoriaId,$fechaIngreso,$fechaBaja);
     return $incapacidades;
}

public function obtenerRFCSujetoObligado()
{
 $rfcSujetoOb = array();
 $rfcSujetoOb = $this->persistencia->obtenerRFCSujetoObligadoPERSISTENCIA();
     return $rfcSujetoOb;
}

public function obtenerCoberturaXEmpLaborales($FechaAlta,$FechaBaja,$entidadEmpAlm,$ConsecutivoEmpAlm,$CategoriaEmpAlm)
{
    $TotalCoberturaEmpLaborales = array();
    $TotalCoberturaEmpLaborales = $this->persistencia->GetCoberturaXEmpLab($FechaAlta,$FechaBaja,$entidadEmpAlm,$ConsecutivoEmpAlm,$CategoriaEmpAlm);
     return $TotalCoberturaEmpLaborales;
}

public function obtenerIDrangoCobertura($cobertura)
{
    $idrango = array();
    $idrango = $this->persistencia->obtenerIDrangoCoberturaPERSISTENCIA($cobertura);
     return $idrango;
}

public function obtenerPorcentajesXUniformeyTipoRecepcion($columnaAConsultar,$idUniforme)
{
    $porcentajeCobro = array();
    $porcentajeCobro = $this->persistencia->obtenerPorcentajesXUniformeyTipoRecepcionPERSISTENCIA($columnaAConsultar,$idUniforme);
     return $porcentajeCobro;
}

public function obtenerSalarioActualContyrato()
{
    $salario = array();
    $salario = $this->persistencia->obtenerSalarioActualContyratoPERSISTENCIA();
     return $salario;
}

public function obtenerUltimorepse(){
 $docRepse = array();
 $docRepse = $this->persistencia->obtenerUltimorepsePERSISTENCIA();
 return $docRepse;
}

public function obtenerIdUltimoArchivoDeudoresFini($documento)
{
    $UltimoIdArchDeuFin = array();
    $UltimoIdArchDeuFin = $this->persistencia->GetIdUltimoArchivoDeudoresFini($documento);
     return $UltimoIdArchDeuFin;
}

public function GuardarIdUltimoArchivoDeudoresFini($documento,$target_file,$NombreCompuesto,$NombreOriginal)
{
    $this->persistencia->AlmacenarIdUltimoArchivoDeudoresFini($documento,$target_file,$NombreCompuesto,$NombreOriginal);
}

public function obtenerRegistroPatronalXempleado($empleadoEntidad, $empleadoConsecutivo,$empleadoTipo)
{
    $registroPatronal = array();
    $registroPatronal = $this->persistencia->obtenerRegistroPatronalXempleadoPERSISTENCIA($empleadoEntidad, $empleadoConsecutivo,$empleadoTipo);
    return $registroPatronal;
}

public function ObtenerPeticionesCap($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha)
    {
        $pertCapacita = array();
        $pertCapacita = $this->persistencia->getPeticionesCapacitacion($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha);
        return $pertCapacita;
    }

public function  negocio_registrarpeticionCapacitacion($DatosCapacitacion)
{
 $this->persistencia->registrarpeticionCapacitacion($DatosCapacitacion);
}

public function ActualizarPeticionCapacitacion($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$EstatusCap,$usuario)
{
    $pertM = $this->persistencia->UpdatePeticionCapacitacion($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$EstatusCap,$usuario);
}

public function ActualizarCampoCapacitacionEnAsistencia($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$comentariIncidencia)
{
    $pertM = $this->persistencia->UpdateCampoCapacitacionEnAsistencia($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$asistenciaFecha,$comentariIncidencia);
}

  public function obtenerListaPeticionesCapacitacionParaCerrar()
{
    $obtenerlistaPeticionesCapParaCerrar = array();
    $obtenerlistaPeticionesCapParaCerrar = $this->persistencia->getListaPeticionesCapacitacionParaCerrar();
     return $obtenerlistaPeticionesCapParaCerrar;
}

public function obtenerEstatusOperaciones($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId){
    $obtenerSO = array();
    $obtenerSO = $this->persistencia->obtenerEstatusOperacionesPersistencia($empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId);
    return $obtenerSO;
}


public function consultaRegistrosPatronales($idCliente,$fechaPeriodo1,$fechaPeriodo2){
        $lista = array();
        $lista = $this->persistencia->consultaRegistrosPatronalesPER($idCliente,$fechaPeriodo1,$fechaPeriodo2);
        return $lista;
    }

public function consultaRegistrosPatronalesInfonavit($mesPost,$anioPost){
        $lista = array();
        $lista = $this->persistencia->consultaRegistrosPatronalesInfonavitPER($mesPost,$anioPost);
        return $lista;
    }

public function negocio_verificarIutTarjetaDespensa($idEndidadFederativaContratacion)
{
    $SiguenteIut = array();
        $SiguenteIut = $this->persistencia->verificarIutDeTarjetaDespensa($idEndidadFederativaContratacion);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
        return $SiguenteIut;
}

public function negocio_ObtenerLaSiguienteTarjetaDeDespensa($IdTarjetaDespensa,$idEndidadFederativaContratacion,$ComentarioIut,$contraseniaBajaTarjeta,$NumEmpBajaTarjeta,$usuario)
{
    $SiguenteIut = array();
        $SiguenteIut = $this->persistencia->ObtenerLaSiguienteTarjetaDeDespensa($IdTarjetaDespensa,$idEndidadFederativaContratacion,$ComentarioIut,$contraseniaBajaTarjeta,$NumEmpBajaTarjeta,$usuario);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
        return $SiguenteIut;
}

public function UpdateBajaTarjetaDespensa($NumEmpModal, $constraseniaFirma,$ComentarioBajaTarjeta,$txtnumeroIutEdited,$usuario)
{
    $this->persistencia->ActualizarBajaTarjetaDespensa($NumEmpModal, $constraseniaFirma,$ComentarioBajaTarjeta,$txtnumeroIutEdited,$usuario);
}

public function consultaEstatusTarjeta($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria){
        $lista = array();
        $lista = $this->persistencia->consultaEstatusTarjetaPERSISTENCIA($empleadoEntidad,$empleadoConsecutivo,$empleadoCategoria);
        return $lista;
    }

public function ActualizarTarjetaDespensa($numempleadoFirmahiddenRh,$FirmaInterna,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$usuarioRegistroFirma)
    {
        $this->persistencia->updateTarjetaDespensa($numempleadoFirmahiddenRh,$FirmaInterna,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$usuarioRegistroFirma);
    }


public function consultaDocumentoSAT($anioPost,$mesPost,$documento){
        $lista = array();
        $lista = $this->persistencia->consultaDocumentoSATPersistencia($anioPost,$mesPost,$documento);
        return $lista;
    }

/////////////////// Carga Cambio Sucursales y Datos Fiscales T/////////////////////////////////////////

public function getSucursalesIngresadas($EndidadFederativa)
    {
        $sucuarsales = array();
        $sucuarsales = $this->persistencia->obtenerSucursalesIngresadas($EndidadFederativa);
        return $sucuarsales;
    }

public function negocio_CargarSelectoresDatosFiscales($Caso)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $CargaSel = array();
    $CargaSel = $this->persistencia->CargarSelectoresDatosFiscales($Caso);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $CargaSel;
}

public function negocio_CargarMunicipiosPorEntidad($EntidadDatosFiscales)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $CargaSel = array();
    $CargaSel = $this->persistencia->CargarMunicipiosPorEntidad($EntidadDatosFiscales);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $CargaSel;
}

public function negocio_CargarLocalidadPorMunicipio($MunicipioDatosFiscales)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $CargaSel = array();
    $CargaSel = $this->persistencia->CargarLocalidadPorMunicipio($MunicipioDatosFiscales);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $CargaSel;
}

public function negocio_ObtenerCpFiscal($LocalidadDatosFiscales)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $CargaSel = array();
    $CargaSel = $this->persistencia->ObtenerCpFiscal($LocalidadDatosFiscales);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $CargaSel;
}

public function negocio_ObtenerEmpleadoSiExisteParaDatosFiscales($FolioPreseleccionDatosFiscales)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $CargaSel = array();
    $CargaSel = $this->persistencia->ObtenerEmpleadoSiExisteParaDatosFiscales($FolioPreseleccionDatosFiscales);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $CargaSel;
}

public function negocio_ObtenerEmpleadoYaHaSidoRegistradoDatosFiscales($datosEmpleado)
{
        //$log = new KLogger ( "negocio_obtenerPuntosServiciosPorEntidad.log" , KLogger::DEBUG );

    $CargaSel = array();
    $CargaSel = $this->persistencia->ObtenerEmpleadoYaHaSidoRegistradoDatosFiscales($datosEmpleado);
        //$log->LogInfo("Valor de la variable \$listaPuntos: " . var_export ($listaPuntos, true));
    return $CargaSel;
}
public function negocio_insertaDatosFiscales($datosFiscales)
{
    $this->persistencia->insertaDatosFiscales($datosFiscales);

}
public function negocio_ActualizarDatosFiscales($datosFiscales)
{
    $this->persistencia->ActualizarDatosFiscales($datosFiscales);

}

public function getDatosFiscalesGeneralTemporal($numeroEmpleado)
{

    $FirmaEmp = array();
    $FirmaEmp = $this->persistencia->ObtenerDatosFiscalesGeneralTemporal($numeroEmpleado);
    return $FirmaEmp;  
}

 public function negocio_obtenerListaSucursalesinternas()
    {
        //$log = new KLogger ( "negocio.log" , KLogger::DEBUG );

        $listaEntidadesFederativas = array();
        $listaEntidadesFederativas = $this->persistencia->traeListaSucursalesinternas();
        //$log->LogInfo("Valor de la variable \$listaEntidadesFederativas: " . var_export ($listaEntidadesFederativas, true));
        return $listaEntidadesFederativas;
    }

public function negocio_obtenerDatosEmpleadoNomina($NumeroempleadoOr)
{
        //$log = new KLogger ( "negocio_obtenerEmpleadoPorId.log" , KLogger::DEBUG );

    $NumEmpNom = array();
    $NumEmpNom = $this->persistencia->obtenerDatosEmpleadoNomina($NumeroempleadoOr);
        //$log->LogInfo("Valor de la variable \$empleado: " . var_export ($empleado, true));
    return $NumEmpNom;
}

public function obtenerChecksDocumentos($empleado)
    {
        $result = array();
        $result = $this->persistencia->getChecksDocumentos($empleado);
        return $result;

    }

public function negocio_DeleteEntregaDocumentacion($documentacion)
    {
        //$log = new KLogger ( "negocioRegistrarDocumentacion.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la variable \$documentacion : " . var_export ($documentacion, true));

        $this->persistencia->DeleteEntregaDocumentacion($documentacion );
    }

 public function consultaVigenciaplantilla($idPlantillaServicio)
    {
        //$log = new KLogger ( "negocio_getListaEmpleadosBySupervisorPeriodoPuntoServicio.log" , KLogger::DEBUG );
        $turnos = array();
        $turnos = $this->persistencia->getVigenciaplantilla($idPlantillaServicio);
        return $turnos;
        //$log->LogInfo("Valor de la idCliente \$turnos : " . var_export ($turnos, true));

    }

public function ActualizarBajaPlantilla($servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$usuario,$idMoivoBajaForzada)
    {
        $this->persistencia->UpdateBajaPlantilla($servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$usuario,$idMoivoBajaForzada);
    }

public function updateRequisicionCosto($usuario,$servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$TotalFacturaEdited,$CostoTurnoEdited)
{
       // $log = new KLogger ( "negocio_updateRequisicion.log" , KLogger::DEBUG );
       // $log->LogInfo("Valor de la idCliente  requisicion: " . var_export ($requisicion, true));
    $this->persistencia->ActualizarRequisicionCosto($usuario,$servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$TotalFacturaEdited,$CostoTurnoEdited);
}

public function ObtenerRequisicionesByFechaVencimientoXMes($FechaActual)
{

    $lista = array();

    $lista = $this->persistencia->getRequisicionesByFechaVencimientoXMes($FechaActual);

    return $lista;

}

public function getDetalleRequisicionesByPuntoServicioIdFATIGA($puntoServicioId,$fechaInicial,$fechaFinal,$caso)
{
    $lista = array();
    if ($puntoServicioId == "" or $puntoServicioId == "PUNTOS DE SERVICIOS") {
        throw new Exception("Por favor seleccione un punto de servicio");
    }
    $lista = $this->persistencia->obtenerDetalleRequisicionesByPuntoServicioIdFATIGA($puntoServicioId,$fechaInicial,$fechaFinal,$caso);
    return $lista;
}

public function GetDatosPlantillasPorPuntoFATIGA($puntoServicioId,$fechaInicial, $fechaFinal)
    {

    $lista = array();
    $lista = $this->persistencia->ObteneDatosPlantillasPorPuntoFATIGA($puntoServicioId,$fechaInicial, $fechaFinal);
    return $lista;
    }

public function ActualizarReplicacionPlantilla($txtTotalFacturaReplicacionplantilla,$txtCostoTurnoReplicacionplantilla,$FechaMontajeReplicacionplantilla,$servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$usuario,$idPuntoServicio)
    {
        $this->persistencia->UpdateReplicacionPlantilla($txtTotalFacturaReplicacionplantilla,$txtCostoTurnoReplicacionplantilla,$FechaMontajeReplicacionplantilla,$servicioPlantillaId,$contraseniaInsertadaCifrada,$NumEmpModalBaja,$usuario,$idPuntoServicio);
    }
//carga reporte detalle facturacion
public function TurnosCubiertoXPs($i, $puntoServicioId)
 {
  return $this->persistencia->TurnosCubiertoXPsPersistencia($i, $puntoServicioId);
 }

public function TurnosCubiertoIncidenciasSeparadosXPS($i,$puntoServicioId,$idClientePunto){
  return $this->persistencia->TurnosCubiertoIncidenciasSeparadosXPSPersistencia($i,$puntoServicioId,$idClientePunto);
 }


public function getTurnosCubiertos($fecha1, $fecha2, $puntoServicioId, $puestoId, $rolOperativo){

    $lista = array();
    $lista = $this->persistencia->getTurnosCubiertos($fecha1, $fecha2, $puntoServicioId, $puestoId, $rolOperativo);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}


public function obtenerCatalogoMotivoBajaForzada()
 {
     $ListaMotivos = array();
     $ListaMotivos = $this->persistencia->getCatalogoMotivoBajaForzada();
     return $ListaMotivos;
 }


public function negocio_RevisarElementosAsignadosAEstaPantilla($servicioPlantillaId)
{
        //$log = new KLogger ( "negocioClientes.log" , KLogger::DEBUG );

    $ElementosActivos = array();
    $ElementosActivos = $this->persistencia->RevisarElementosAsignadosAEstaPantilla($servicioPlantillaId);
        //$log->LogInfo("Valor de la variable \$listaClientes: " . var_export ($listaClientes, true));
    return $ElementosActivos;
}

public function obtenerBancoByClabe($idClabeBanco)
{
    $banco = array();
    $banco = $this->persistencia->obtenerBancoByClabePER($idClabeBanco);
    return $banco;
}

//carga reporte detalle facturacion

public function registrarBeneficiarios($Entidad,$Consecutivo,$Tipo,$parentescoB,$nombreB,$porcentajeB,$usuario,$i,$idBeneficiario){
    $this->persistencia->insertBeneficiarios($Entidad,$Consecutivo,$Tipo,$parentescoB,$nombreB,$porcentajeB,$usuario,$i,$idBeneficiario);
}

public function consultarBeneficiarios($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo)
{
    $beneficiarios = array();
    $beneficiarios = $this->persistencia->obtenerBeneficiariosXEmp($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);
    return $beneficiarios;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////

public function negocio_obtenerSupervisoresOperativosXNoEmpleado($usuario)
{
        //$log = new KLogger ( "negocio_obtenerSupervisoresOperativosXNoEmpleado.log" , KLogger::DEBUG );

    $listaSupervisoresOperativos = array();
    $listaSupervisoresOperativos = $this->persistencia->obtenerSupervisoresOperativosXNoEmpleado($usuario);
        //$log->LogInfo("Valor de la variable \$listaSupervisoresOperativos: " . var_export ($listaSupervisoresOperativos, true));
    return $listaSupervisoresOperativos;
}

public function insertandupdatefolioincapacidadAdmin($folioIncapacidad,$asistenciaFecha,$fechafinalincidencia,$empleado,$tipoIncapacidad,$diasIncapacidad,$opcion)
{
        //$log = new KLogger ( "negocio_getDatosPorCliente.log" , KLogger::DEBUG );
        //$log->LogInfo("Valor de la idCliente \$idCliente : " . var_export ($idCliente, true));
    $lista = array();
    $lista = $this->persistencia->insertandupdatefolioincapacidadAdmimn($folioIncapacidad,$asistenciaFecha,$fechafinalincidencia,$empleado,$tipoIncapacidad,$diasIncapacidad,$opcion);

    return $lista;
}

public function getGerenteSup($gerenteEntidad, $gerenteConsecutivo, $gerenteCategoria){
    $nombreGerente = array();
    $nombreGerente = $this->persistencia->obtenerGerenteSup($gerenteEntidad, $gerenteConsecutivo, $gerenteCategoria);
    return $nombreGerente;
}

public function CatalogoDepartamentosNegocio(){
    $lista = $this->persistencia->CatalogoDepartamentos();
    return $lista;
}

public function traerCatalogoPuntosServiciosConOpciones($banderaBusquedaPuntos)
{
    //$log= new KLogger("negocio_traerCatalogoPuntosServicios.log", KLogger::DEBUG);

    $lista = $this->persistencia->getCatalogoPuntosServiciosConOpciones($banderaBusquedaPuntos);
  //  $log -> LogInfo ("$lista". var_export($lista,true));
    return $lista;

}

public function ConsultaDescansosDisponibles($idPlantillaServicio)
    {
        //$log = new KLogger ( "negocio_getListaEmpleadosBySupervisorPeriodoPuntoServicio.log" , KLogger::DEBUG );
        $Descansosdisponibles = array();
        $Descansosdisponibles = $this->persistencia->ConsultaDescansosDisponibles($idPlantillaServicio);
        return $Descansosdisponibles;
        //$log->LogInfo("Valor de la idCliente \$turnos : " . var_export ($turnos, true));

    }
public function ConsultaTurnosCubiertosDiaYNoche($idPlantillaServicio,$asistenciaFecha,$FechaFin)
    {
        //$log = new KLogger ( "negocio_getListaEmpleadosBySupervisorPeriodoPuntoServicio.log" , KLogger::DEBUG );
        $DescansosCubiertos = array();
        $DescansosCubiertos = $this->persistencia->ConsultaTurnosCubiertosDiaYNoche($idPlantillaServicio,$asistenciaFecha,$FechaFin);
        return $DescansosCubiertos;
        //$log->LogInfo("Valor de la idCliente \$turnos : " . var_export ($turnos, true));
    }

public function getcatalogoMotivoIncidenciasEspeciales()
{

        //$log = new KLogger ( "negocio_getCatalogoIncidencias.log" , KLogger::DEBUG );

    $lista = array();

    $lista = $this->persistencia->getcatalogoMotivoIncidenciasEspeciales();

    return $lista;
}

 public function getAsistenciaApp($fecha1, $fecha2, $numeroEmpleado)
{
        
    $lista = array();
    $lista = $this->persistencia->getAsistenciaApp($fecha1, $fecha2, $numeroEmpleado);
    return $lista;

}

// calculo diferencias:
public function negocio_obtenerEmpleadosEmaHP($registro, $fechaPeriodo1, $fechaPeriodo2,$lineaNeg,$tipoEmp)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerEmpleadosEmaHP($registro, $fechaPeriodo1, $fechaPeriodo2,$lineaNeg,$tipoEmp);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}

public function negocio_obtenerEmpleadosEvaHP($registro, $fechaPeriodo1, $fechaPeriodo2,$lineaNeg,$tipoEmp)
{

    $listaEmpleados = array();

    $listaEmpleados = $this->persistencia->obtenerEmpleadosEvaHP($registro, $fechaPeriodo1, $fechaPeriodo2,$lineaNeg,$tipoEmp);
        //$log->LogInfo("Valor de la variable \$listaEmpleados : " . var_export ($listaEmpleados, true));

    return $listaEmpleados;
}



////////////////////////////////////////// se reutilizan las consultas por separados ya que se necesitan hacer camnbiso y no se sabe cuanto sformularios se verian efectados es para fatiga /////////////////////////

public function getDetalleRequisicionesByPuntoServicioIdParaFatiga($puntoServicioId,$IdPlantillaServ,$caso)
{
    $lista = array();
    if ($puntoServicioId == "" or $puntoServicioId == "PUNTOS DE SERVICIOS") {
        throw new Exception("Por favor seleccione un punto de servicio");
    }
    $lista = $this->persistencia->getDetalleRequisicionesByPuntoServicioIdParaFatiga($puntoServicioId,$IdPlantillaServ,$caso);
    return $lista;
}

public function getTurnosCubiertosByPeriodoFechasAndPuntoServicioParaFatiga($fechaInicial,$fechaFinal,$puntoServicioId,$IdPlantillaServ) {
    return $this->persistencia->getTurnosCubiertosByPeriodoFechasAndPuntoServicioParaFatiga($fechaInicial, $fechaFinal, $puntoServicioId,$IdPlantillaServ);
}

public function obtenerTurnoCubiertosIncidenciasEspecialesXDiaParaFatiga($fechaInicial,$fechaFinal,$puntoServicioId,$IdPlantillaServ) {
    return $this->persistencia->getTurnoCubiertosIncidenciasEspecialesXDiaParaFatiga($fechaInicial, $fechaFinal, $puntoServicioId,$IdPlantillaServ);
}

public function GetDatosPlantillasPorPuntoParaFatiga($puntoServicioId,$IdPlantillaServ)
{

    $lista = array();
    $lista = $this->persistencia->ObteneDatosPlantillasPorPuntoParaFatiga($puntoServicioId,$IdPlantillaServ);
    return $lista;
}

public function getDiasSolicitadosParaFatiga($PlantillaId,$turnoDiaC,$turnoNocheC)
{

    $lista = array();
    $lista = $this->persistencia->ObtenerDiasSolicitadosParaFatiga($PlantillaId,$turnoDiaC,$turnoNocheC);
    return $lista;
}

public function getTurnosCubiertoSeparadosXPuntosParaFatiga($i, $puntoServicioId,$IdPlantillaServ) {
    return $this->persistencia->ObtenerTurnosCubiertoSeparadosXPuntosParaFatiga($i, $puntoServicioId,$IdPlantillaServ);
}

    public function getTTipoTurnoCurbiertoParaFatiga($i, $puntoServicioId,$IdPlantillaServ) {
    return $this->persistencia->ObtenerTTipoTurnoCurbiertoParaFatiga($i, $puntoServicioId,$IdPlantillaServ);
}

public function getTurnosExtrasFatigaPlantilla($fecha1, $fecha2, $puntoservicio,$idplantillaPunto)
{

    $lista = array();

    $lista = $this->persistencia->getTurnosExtrasFatigaPlantilla($fecha1, $fecha2, $puntoservicio,$idplantillaPunto);

    return $lista;

}

public function getEmpleadoForFatigaPorPlantilla($fecha1, $fecha2, $puntoservicio,$idplantillaPunto)
{

    $lista = array();
    $lista = $this->persistencia->getEmpleadoForFatigaPorPlantilla($fecha1, $fecha2, $puntoservicio,$idplantillaPunto);

    return $lista;

}

public function getAsistenciaByEmpleadoPuntoServicioFatigaPorPlantilla($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio,$idplantillaPunto)
{

    $lista = array();

    $lista = $this->persistencia->getAsistenciaByEmpleadoPuntoServicioFatigaPorPlantilla($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio,$idplantillaPunto);
    return $lista;

}
public function getSumaDiasFestivosFatigaPorPlantilla($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio,$idplantillaPunto)
{

        //$log = new KLogger ( "negocio_getSumaTurnosExtras.log" , KLogger::DEBUG );

        //$log->LogInfo("Valor de la  \$fecha1 : " . var_export ($fecha1, true));
        //$log->LogInfo("Valor de la  \$fecha2 : " . var_export ($fecha2, true));
        //$log->LogInfo("Valor de la  \$empleadoEntidad : " . var_export ($empleadoEntidad, true));
        //$log->LogInfo("Valor de la  \$empleadoConsecutivo : " . var_export ($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la  \$empleadoTipo : " . var_export ($empleadoTipo, true));

    $lista = array();

    $lista = $this->persistencia->getSumaDiasFestivosFatigaPorPlantilla($fecha1, $fecha2, $empleadoEntidad, $empleadoConsecutivo, $empleadoTipo, $puntoServicio,$idplantillaPunto);
        //$log->LogInfo("Valor de la  \$lista : " . var_export ($lista, true));
    return $lista;

}



///////////////////////////////////////////////////////////////////7//////// se finalizan las consultas reutilizadas para fatiga  ///////////////////////////////////////////////////////////////////////////////////












} // Termina la clase Negocios