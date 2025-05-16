<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "conexion.php";
require_once "../libs/logger/KLogger.php";
$response           = array();
$listaELementosSinCuota           = array();
$response["status"] = "error";
$folioTxtBaja       = $_POST["folioTxtBaja"]; // deshabilitar este folio cuando se ejecute el calculo del finiquito manulamente 
//$DiasVacacionesLaborales  = $_POST["DiasVacaciones"];
$datos              = array();
try {
    // $log = new KLogger("ajax_CalculoFiniquito.log", KLogger::DEBUG);
    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                    empleados.entidadFederativaId,empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                     catalogopuestos.descripcionPuesto,datosimss.fechaImss,datosimss.fechaBajaImss,datosimss.salarioDiario,cuotas_empleados.cuotaDiariaEmpleado,empleados.tipoPeriodo,
                     datosimss.CreacionFiniquito,finiquitos.DiasTotalesVacLaborales,finiquitos.diasTrabajados,finiquitos.piramidar,finiquitos.MontoAcordado,finiquitos.estatusFiniquitoPiramidar,
                     finiquitos.folioBajaImss,finiquitos.EstatusDiasTrabajados,finiquitos.uniformesFiniquito
            FROM  finiquitos
             left join  empleados ON finiquitos.entidadEmpFiniquito=empleados.entidadFederativaId
            and finiquitos.consecutivoEmpFiniquito=empleados.empleadoConsecutivoId
            and finiquitos.categoriaEmpFiniquito=empleados.empleadoCategoriaId
                LEFT JOIN datosimss ON datosimss.empladoEntidadImss=empleados.entidadFederativaId
            AND datosimss.empleadoConsecutivoImss=empleados.empleadoConsecutivoId
            AND datosimss.empleadoCategoriaImss=empleados.empleadoCategoriaId
                LEFT JOIN cuotas_empleados ON cuotas_empleados.empleadoEntidadCuota=finiquitos.entidadEmpFiniquito
            AND cuotas_empleados.empleadoConsecutivoCuota=finiquitos.consecutivoEmpFiniquito
            AND cuotas_empleados.empleadoCategoriaCuota=finiquitos.categoriaEmpFiniquito
                LEFT JOIN  catalogopuestos ON empleados.empleadoIdPuesto=catalogopuestos.idPuesto
            where finiquitos.estatusFiniquito=0";
    if ($folioTxtBaja != 0) {
        $sql .= " AND datosimss.folioTxtBaja='$folioTxtBaja'";}

    $res = mysqli_query($conexion, $sql);
//$this -> logger -> LogInfo ("Ejecutando SQL obtenerDiasTrabajados: " . $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }
    for ($i = 0; $i < count($datos); $i++) {
        $tipodeperiodo       = $datos[$i]["tipoPeriodo"]; //para hacer el calculo conforme a su tipo de periodo
        $entidadFederativa   = $datos[$i]["entidadFederativaId"];
        $empleadoConsecutivo = $datos[$i]["empleadoConsecutivoId"];
        $empleadoCategoria   = $datos[$i]["empleadoCategoriaId"];
        $fechainicio         = $datos[$i]["fechaImss"];
        $fechafin            = $datos[$i]["fechaBajaImss"];
        $cuotastr            = $datos[$i]["cuotaDiariaEmpleado"];
        $CreacionFiniquito   = $datos[$i]["CreacionFiniquito"];
        $diasTrabajados112   = $datos[$i]["diasTrabajados"];
        $piramidar           = $datos[$i]["piramidar"];
        $MontoAcordado       = $datos[$i]["MontoAcordado"];
        $EstatusDiasTrabajados = $datos[$i]["EstatusDiasTrabajados"];
        $uniformesFiniquito = $datos[$i]["uniformesFiniquito"];
        $estatusFiniquitoPiramidar   = $datos[$i]["estatusFiniquitoPiramidar"];
        if($diasTrabajados112 == "" || $diasTrabajados112 == NULL || $diasTrabajados112 == null || $diasTrabajados112 == "null" || $diasTrabajados112 == "NULL"){
            $diasTrabajados11 ="0";
        }else{
            $diasTrabajados11 = $diasTrabajados112;
        }
        $DiasVacacionesLaborales1 = $datos[$i]["DiasTotalesVacLaborales"];
        if($DiasVacacionesLaborales1 =="" || $DiasVacacionesLaborales1 ==NULL || $DiasVacacionesLaborales1 ==null || $DiasVacacionesLaborales1 =="null" || $DiasVacacionesLaborales1 =="NULL"){
            $DiasVacacionesLaborales = "0";
        }else{
            $DiasVacacionesLaborales = $DiasVacacionesLaborales1;

        }

        //OBTENEMOS EL SALARIO DIARIO PARA HACER LOS CALCULOS DE S.A.
        $salDiario                   = $datos[$i]["salarioDiario"];
        $cuotaint                    = (float) $cuotastr;
        $salarioint                  = (float) $salDiario; //cortar a 2 decimales para el calculo
        $cuotafloat                  = bcdiv($cuotaint, 1, 2);
        $salariofloat                = bcdiv($salarioint, 1, 2);
        $datetime1                   = new DateTime($fechainicio);
        $datetime2                   = new DateTime($fechafin);
        $Fecha1Explode = explode("-", $fechafin);// Se anexo para cuando dan de calcula el finiquito en un año diferente del que se dio de baja
        $anioFecha1Explode=$Fecha1Explode[0];
        $ejercicio                   = date('Y'); //sacando el puro anio en el que estamos actualmente
        $anioejer                    = $ejercicio . "-01-01"; //fecha que servira para calcular dias aguinaldo
        $anioejerc                   = new DateTime($anioejer);
        $diastrabajados              = $datetime1->diff($datetime2);
        $dtstr                       = $diastrabajados->format('%R%a');
        $aniosdetrabajo              = $diastrabajados->format('%y'); //ANIOS DE TRABAJO///////////////////////////////////////////////////////
        $dtstring                    = substr($dtstr, 1);
        $antiguedadtotal             = (int) $dtstring;
        $antiguedad                  = (int) $dtstring;
        $datos[$i]["diastrabajados"] = $antiguedad;
        $anio                        = 365;
        $dias1anio                   = $anio;
        $dias2anio                   = $anio * 2;
        $dias3anio                   = $anio * 3;
        $dias4anio                   = $anio * 4;
        $dias5anio                   = $anio * 5;
        $dias6anio                   = $anio * 6;
        $dias7anio                   = $anio * 7;
        $dias8anio                   = $anio * 8;
        $dias9anio                   = $anio * 9;
        $dias10anio                  = $anio * 10;
        $dias11anio                  = $anio * 11;
        $dias12anio                  = $anio * 12;
        $dias13anio                  = $anio * 13;
        $dias14anio                  = $anio * 14;
        $dias15anio                  = $anio * 15;
        $dias16anio                  = $anio * 16;
        $dias17anio                  = $anio * 17;
        $dias18anio                  = $anio * 18;
        $dias19anio                  = $anio * 19;
        $aniobajadelempleadostr                  = new DateTime($fechafin);
        $aniobajadelempleado= $aniobajadelempleadostr->format('Y');
     //$log->LogInfo("Valor de la variable ejercicio  " . var_export($a, true) );
        if ($antiguedadtotal == 0) {
            $antiguedad      = 1;
            $antiguedadtotal = 1;}
        switch ($antiguedad) {
            case ($antiguedad >= 1 && $antiguedad <= $anio):
                $fila = 1;
                break;
            case ($antiguedad > $anio && $antiguedad <= $dias2anio):
                $fila = 2;
                break;
            case ($antiguedad > $dias2anio && $antiguedad <= $dias3anio):
                $fila = 3;
                break;
            case ($antiguedad > $dias3anio && $antiguedad <= $dias4anio):
                $fila = 4;
                break;
            case ($antiguedad > $dias4anio && $antiguedad <= $dias5anio):
                $fila = 5;
                break;
            case ($antiguedad > $dias5anio && $antiguedad <= $dias6anio):
                $fila = 6;
                break;
            case ($antiguedad > $dias6anio && $antiguedad <= $dias7anio):
                $fila = 7;
                break;
            case ($antiguedad > $dias7anio && $antiguedad <= $dias8anio):
                $fila = 8;
                break;
            case ($antiguedad > $dias8anio && $antiguedad <= $dias9anio):
                $fila = 9;
                break;
            case ($antiguedad > $dias9anio && $antiguedad <= $dias10anio):
                $fila = 10;
                break;
            case ($antiguedad > $dias10anio && $antiguedad <= $dias11anio):
                $fila = 11;
                break;
            case ($antiguedad > $dias11anio && $antiguedad <= $dias12anio):
                $fila = 12;
                break;
            case ($antiguedad > $dias12anio && $antiguedad <= $dias13anio):
                $fila = 13;
                break;
            case ($antiguedad > $dias13anio && $antiguedad <= $dias14anio):
                $fila = 14;
                break;
            case ($antiguedad > $dias14anio && $antiguedad <= $dias15anio):
                $fila = 15;
                break;
            case ($antiguedad > $dias15anio && $antiguedad <= $dias16anio):
                $fila = 16;
                break;
            case ($antiguedad > $dias16anio && $antiguedad <= $dias17anio):
                $fila = 17;
                break;
            case ($antiguedad > $dias17anio && $antiguedad <= $dias18anio):
                $fila = 18;
                break;
            case ($antiguedad > $dias18anio && $antiguedad <= $dias19anio):
                $fila = 19;
                break;}
        // $log->LogInfo("Valor de la variable CreacionFiniquito:  " . var_export($CreacionFiniquito, true));
         //$log->LogInfo("Valor de la variable DiasVacacionesLaborales:  " . var_export($DiasVacacionesLaborales, true));


        $qryrangodediastrabajados = "SELECT *
                                        from periodos
                                            left join aniosperiodos on periodos.IdPeriodo=aniosperiodos.IdPeriodo
                                            left join rangoperiodos on rangoperiodos.IdAnio=aniosperiodos.IdAnio
                                        WHERE periodos.IdPeriodo=$tipodeperiodo
                                        AND '$fechafin' BETWEEN rangoperiodos.FechaInicioP AND rangoperiodos.FechaFinP";

     //    $log->LogInfo("Valor de la variable qryrangodediastrabajados:  " . var_export($qryrangodediastrabajados, true));


        $resqryrango   = mysqli_query($conexion, $qryrangodediastrabajados);
        $datosqryrango = array();
        while (($regqry = mysqli_fetch_array($resqryrango, MYSQLI_ASSOC))) {
            $datosqryrango[] = $regqry;}
        $rangoFechaInicioP         = $datosqryrango[0]["FechaInicioP"];
        $rangoFechaFinP            = $datosqryrango[0]["FechaFinP"];
        //////////////// consulta para revisar si el empleado se dio de baja despues del cierre pero antes del cambio de periodo /////////////////////////
        $qryperiodocierre = "SELECT * FROM cierresperiodos
                                where fechaInicioPeriodo=(select max(fechaInicioPeriodo) from cierresperiodos)
                                and periodoId='$tipodeperiodo'";
                                
        $rescierreperiodo   = mysqli_query($conexion, $qryperiodocierre);
        //$this -> logger -> LogInfo ("Ejecutando SQL qryperiodocierre: " . $qryperiodocierre);
        $datoscierreperiodo = array();
        while (($regquyperiodocierre = mysqli_fetch_array($rescierreperiodo, MYSQLI_ASSOC))) {
        $datoscierreperiodo[]       = $regquyperiodocierre;}
        $fechaCierrePeriodo         = $datoscierreperiodo[0]["fechaCierrePeriodo"];
        $explodeFEchaCierrep        = explode(" ", $fechaCierrePeriodo);
        $FechaPeriodoCierre         = $explodeFEchaCierrep[0]; 
        $HoraPeriodoCierre          = $explodeFEchaCierrep[1]; 
        $fechaTerminoPeriodo        = $datoscierreperiodo[0]["fechaTerminoPeriodo"];
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if($EstatusDiasTrabajados!="1"){

      if($fechafin >= $FechaPeriodoCierre && $fechafin <= $fechaTerminoPeriodo){//$fechafin(pertenece a la fecha baja de imss) 
        $diastrabajadosenrangodelaultimaquincenaint=0;
      }else{
        //////////////////////// Se calculan los dias de asistencia trabajados en la quincena facturables sin contar los  descasnos ////////////////////////////////// 

        $qrydiastrabenultimaquince = " SELECT (ifnull(sum(ci.valorAsistencia),0)) as diastrabajados,ci.nomenclaturaIncidencia,ci.descripcionIncidencia
                                            FROM  asistencia a
                                            LEFT JOIN  catalogoincidencias ci ON (ci.incidenciaId=a.incidenciaAsistenciaId)
                                        WHERE a.fechaAsistencia BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND a.empleadoEntidad=      '$entidadFederativa'
                                        AND a.empleadoConsecutivo=  '$empleadoConsecutivo'
                                        and a.empleadoTipo=         '$empleadoCategoria'
                                        and ci.incidenciaId !='1'
                                        and ci.incidenciaId !='14' ";
        $resqrydiastrab   = mysqli_query($conexion, $qrydiastrabenultimaquince);
        $datosqrydiastrab = array();
        while (($regqrydiastrabultquinc = mysqli_fetch_array($resqrydiastrab, MYSQLI_ASSOC))) {
            $datosqrydiastrab[] = $regqrydiastrabultquinc;}


        $diastrabajadosenrangodelaultimaquincenastr = $datosqrydiastrab[0]["diastrabajados"];
        $diastrabajadosenrangodelaultimaquincenaint = (int) $diastrabajadosenrangodelaultimaquincenastr;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////// Se calculan los dias de Capacitacion en caso de tener se evaluan para ver si se pagan condicion es minimo 5 dias trabajados//////////////////// 

        $qrydiasCapacitacion = "SELECT (ifnull(sum(ci.valorAsistencia),0)) as diastrabajados,ci.nomenclaturaIncidencia,ci.descripcionIncidencia
                                            FROM  asistencia a
                                            LEFT JOIN  catalogoincidencias ci ON (ci.incidenciaId=a.incidenciaAsistenciaId)
                                        WHERE a.fechaAsistencia BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND a.empleadoEntidad=      '$entidadFederativa'
                                        AND a.empleadoConsecutivo=  '$empleadoConsecutivo'
                                        and a.empleadoTipo=         '$empleadoCategoria'
                                        and a.incidenciaAsistenciaId='14'";
        $resqryDiasCap   = mysqli_query($conexion, $qrydiasCapacitacion);
        $datosqrydiasCapacitacion = array();
        while (($regqrydiastrabultquinc = mysqli_fetch_array($resqryDiasCap, MYSQLI_ASSOC))) {
            $datosqrydiasCapacitacion[] = $regqrydiastrabultquinc;}


        $DiasCapacitacionUltimaQuincenaStr = $datosqrydiasCapacitacion[0]["diastrabajados"];
        $DiasUltimaQuincenaInt = (int) $DiasCapacitacionUltimaQuincenaStr;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //////////////////////// Se calculan los dias de incidencais especiales trabajados en la quincena facturables //////////////////////////////////////// 
        //CONSULTA PARA SACAR LOS TURNOS EXTRAS O INCIDENCIAS ESPECIALES
        //PRUEBAS EN SERVIDOR LOCAL PARA SUBIR EL CAMBIO
        $qryturnosExtraultimaquince = " SELECT (ifnull(sum(ci.valorIncidenciaEspecial),0)) as diastrabajados
                                             FROM incidenciasespeciales ie
                                            LEFT JOIN  catalogoincidenciasespeciales ci ON (ie.incidenciaId=ci.incidenciaEspecialId)
                                        WHERE ie.incidenciaFecha BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND ie.incidenciaEmpleadoEntidad=      '$entidadFederativa'
                                        AND ie.incidenciaEmpleadoConsecutivo=  '$empleadoConsecutivo'
                                        and ie.incidenciaEmpleadoTipo=         '$empleadoCategoria' ";
        $resqryTurnosExtra   = mysqli_query($conexion, $qryturnosExtraultimaquince);
       
        $datosqryTurnosExtra = array(); 
        while (($regqryTurnosEUQ = mysqli_fetch_array($resqryTurnosExtra, MYSQLI_ASSOC))) {
            $datosqryTurnosExtra[] = $regqryTurnosEUQ;}
        $turnosExtraenrangodelaultimaquincenastr    = $datosqryTurnosExtra[0]["diastrabajados"];
        $turnosExtraenrangodelaultimaquincenaint    = (int) $turnosExtraenrangodelaultimaquincenastr;
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////Se Suman Ambas Para La Condicion Si Se Pagan Descansos ////////////////////////////////////////////////
        $diastrabajadosenrangodelaultimaquincenaint = $turnosExtraenrangodelaultimaquincenaint + $diastrabajadosenrangodelaultimaquincenaint;
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
            //condicion si los dias trabajados enrtre la quincena es menor a seis no se pagaran los descansos
        if ($diastrabajadosenrangodelaultimaquincenaint > 5) {
            //////////////////////////////////// Calculo De Asistencia Con Descansos //////////////////////////////////////////////////////////////
            $qrydiastrabenultimaquince = "SELECT (ifnull(sum(ci.valorAsistencia),0)) as diastrabajados,ci.nomenclaturaIncidencia,ci.descripcionIncidencia
                                            FROM  asistencia a
                                            LEFT JOIN  catalogoincidencias ci ON (ci.incidenciaId=a.incidenciaAsistenciaId)
                                        WHERE a.fechaAsistencia BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND a.empleadoEntidad=      '$entidadFederativa'
                                        AND a.empleadoConsecutivo=  '$empleadoConsecutivo'
                                        and a.empleadoTipo=         '$empleadoCategoria'";
            $resqrydiastrab   = mysqli_query($conexion, $qrydiastrabenultimaquince);
            $datosqrydiastrab = array();
            while (($regqrydiastrabultquinc = mysqli_fetch_array($resqrydiastrab, MYSQLI_ASSOC))) {
                $datosqrydiastrab[] = $regqrydiastrabultquinc;}
            $diastrabajadosenrangodelaultimaquincenastr = $datosqrydiastrab[0]["diastrabajados"];
            $diastrabajadosenrangodelaultimaquincenaint = (int) $diastrabajadosenrangodelaultimaquincenastr;
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //////////////////////////////////////////////Calculo De Incidencias Especiales //////////////////////////////////////////////////////////////
            //CONSULTA PARA SACAR LOS TURNOS EXTRAS O INCIDENCIAS ESPECIALES
            $qryturnosExtraultimaquince = "SELECT (ifnull(sum(ci.valorIncidenciaEspecial),0)) as diastrabajados
                                             FROM incidenciasespeciales ie
                                            LEFT JOIN  catalogoincidenciasespeciales ci ON (ie.incidenciaId=ci.incidenciaEspecialId)
                                        WHERE ie.incidenciaFecha BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND ie.incidenciaEmpleadoEntidad=      '$entidadFederativa'
                                        AND ie.incidenciaEmpleadoConsecutivo=  '$empleadoConsecutivo'
                                        and ie.incidenciaEmpleadoTipo=         '$empleadoCategoria' ";
            $resqryTurnosExtra   = mysqli_query($conexion, $qryturnosExtraultimaquince);
            $datosqryTurnosExtra = array();
            while (($regqryTurnosEUQ = mysqli_fetch_array($resqryTurnosExtra, MYSQLI_ASSOC))) {
                $datosqryTurnosExtra[] = $regqryTurnosEUQ;}
            $turnosExtraenrangodelaultimaquincenastr    = $datosqryTurnosExtra[0]["diastrabajados"];
            $turnosExtraenrangodelaultimaquincenaint    = (int) $turnosExtraenrangodelaultimaquincenastr;
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            /////////////////////// Suma De Ambos Calculos Y No Se agregan los dias de Capacitacion ya que la consulta es general y ahi vienen anexados///////////////////
            $diastrabajadosenrangodelaultimaquincenaint = $turnosExtraenrangodelaultimaquincenaint + $diastrabajadosenrangodelaultimaquincenaint;
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }else if ($diastrabajadosenrangodelaultimaquincenaint == '5') {
            $diasTotales = $diastrabajadosenrangodelaultimaquincenaint;
            $diastrabajadosenrangodelaultimaquincenaint = $diasTotales + $DiasUltimaQuincenaInt; // Se Suman los Dias De Capacitacino En Caso de Tener Ya Que tiene Mas o igual A 5 Dias Trabajados
        }
        if ($diastrabajadosenrangodelaultimaquincenaint < 0) {
            $diastrabajadosenrangodelaultimaquincenaint = 0;
        }
      }
    }else{
        $diastrabajadosenrangodelaultimaquincenaint=$diasTrabajados11;
    }

        $qryantiguedad = "SELECT * FROM antiguedad
                            WHERE IdAntiguedad=$fila";
        
        $res1   = mysqli_query($conexion, $qryantiguedad);
        $datos1 = array();
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
            $datos1[] = $reg1;
        }
        if ($antiguedad > $anio) {
            $antiguedad = $antiguedad - $anio;
        }
        if($ejercicio>$anioFecha1Explode){
            $calculodiasaguinaldo = $antiguedad;
        }else{
            if ($anioejerc < $datetime1) {
                $calculodiasaguinaldo = $antiguedad;
            } else {
                $calculodiasaguinal       = $anioejerc->diff($datetime2);
                $calculodiasaguinalstr    = $calculodiasaguinal->format('%R%a');
                $calculodiasaguinalstring = substr($calculodiasaguinalstr, 1);
                $calculodiasaguinaldo     = (int) $calculodiasaguinalstring;
            }
        }
/////PARA TRAER VALORES DE INFONAVIT //////////////////////////////
        $qrydeudainfonavit = "SELECT * FROM infonavit_finiquito
                                where idIF=(select max(idIF)
                                from infonavit_finiquito
                                where entidadEmpIF='$entidadFederativa'
                                and consecutivoEmpIF='$empleadoConsecutivo'
                                and categoriaEmpIF='$empleadoCategoria')";
        $resqrydeudainfona  = mysqli_query($conexion, $qrydeudainfonavit);
        $datodeudainfonavit = array();
        while (($resqrydeudainfonavit = mysqli_fetch_array($resqrydeudainfona, MYSQLI_ASSOC))) {
            $datodeudainfonavit[] = $resqrydeudainfonavit;
        }
        $conteodeudainfonavit = count($datodeudainfonavit);
        if ($conteodeudainfonavit != 0) {
            $montoinfonavit = $datodeudainfonavit[0]["montoIF"];
        } else { $montoinfonavit = 0;}
///////////////////////////////////////////////////////////////////////
        /////PARA TRAER VALORES DE PRESTAMO FINIQUITOS //////////////////////////////
        $qryprestamoinfonavit = "SELECT * FROM prestamo_finiquito
                                where idPF=(select max(idPF) from prestamo_finiquito
                                where entidadEmpPF='$entidadFederativa'
                                and consecutivoEmpPF='$empleadoConsecutivo'
                                and categoriaEmpPF='$empleadoCategoria')";
        $resqryprestamoinfiona = mysqli_query($conexion, $qryprestamoinfonavit);
        $datoprestamoinfonavit = array();
        while (($resprestamoinfonavit = mysqli_fetch_array($resqryprestamoinfiona, MYSQLI_ASSOC))) {
            $datoprestamoinfonavit[] = $resprestamoinfonavit;
        }
        $conteoprestamo = count($datoprestamoinfonavit);
        if ($conteoprestamo != 0) {
            $montoprestamoinfonavit = $datoprestamoinfonavit[0]["montoPF"];
        } else { $montoprestamoinfonavit = 0;}
        ///////////////////////////////////////////////////////////////////////
        /////PARA TRAER VALORES DE fonacot //////////////////////////////
        $qryprestamofonacot = "SELECT * FROM fonacot_finiquito
                                where idFF=(select max(idFF) from fonacot_finiquito
                                where entidadEmpFF='$entidadFederativa'
                                and consecutivoEmpFF='$empleadoConsecutivo'
                                and categoriaEmpFF='$empleadoCategoria')";
        $resqryprestamofona  = mysqli_query($conexion, $qryprestamofonacot);
        $datoprestamofonacot = array();
        while (($resprestamofona = mysqli_fetch_array($resqryprestamofona, MYSQLI_ASSOC))) {
            $datoprestamofonacot[] = $resprestamofona;
        }
        $conteoprestamofona = count($datoprestamofonacot);
        if ($conteoprestamofona != 0) {
            $montoprestamofonacot = $datoprestamofonacot[0]["montoFF"];
        } else { $montoprestamofonacot = 0;}
        ///////////////////////////////////////////////////////////////////////
        /////PARA TRAER VALORES DE INFONAVIT //////////////////////////////
        $qrydeudaprestamo = "SELECT * FROM pension_finiquito
                                where idPeF=(select max(idPeF) from pension_finiquito
                                where entidadEmpPeF='$entidadFederativa'
                                and consecutivoEmpPeF='$empleadoConsecutivo'
                                and categoriaEmpPeF='$empleadoCategoria')";
        $resqrydeudaprestamo = mysqli_query($conexion, $qrydeudaprestamo);
        $datodeudaprestamo   = array();
        while (($resdeudaprestamo = mysqli_fetch_array($resqrydeudaprestamo, MYSQLI_ASSOC))) {
            $datodeudaprestamo[] = $resdeudaprestamo;
        }
        $conteodeudapension = count($datodeudaprestamo);
        if ($conteodeudapension != 0) {
            $montopension = $datodeudaprestamo[0]["montoPeF"];
        } else { $montopension = 0;}
        /////////////////////////VACACIONES////////////////////////////////////////////


        if ($antiguedadtotal > $anio) {
            $antiguedadd = ($antiguedadtotal - ($aniosdetrabajo * $anio));
        }else{
            $antiguedadd = $antiguedadtotal;
        }
    /* $log->LogInfo("Valor de la variable antiguedadtotal  " . var_export($antiguedadtotal, true) );
     $log->LogInfo("Valor de la variable anio  " . var_export($anio, true) );
     $log->LogInfo("Valor de la variable aniosdetrabajo  " . var_export($aniosdetrabajo, true) );
     $log->LogInfo("Valor de la variable antiguedadd  " . var_export($antiguedadd, true) );*/

        $DiasVacUltAniversario= $datos1[0]["DiasVacConf"];
        $ProporcionVacXantiguedad= $datos1[0]["DiasVacConf"];// proporcion de vacaciones segun antiguedad para realiza el llenado del pdf finiquito 
        if($CreacionFiniquito=="2"){// condicion para colocar dias de vacaciones si viene de laborales o directo
            $diasparavacio                 = ($antiguedadd / $anio);//Saca la proporcion de vacaciones por los años trabajados
            $TotalDiasVacaciones11= $DiasVacacionesLaborales;
            $DiasVacacionesUltimoAniversario= $datos1[0]["DiasVacConf"];
            if($TotalDiasVacaciones11<$DiasVacacionesUltimoAniversario){
                $explodeDias = explode(".", $diasparavacio);
                $DiasVacUltAniversario=$explodeDias["0"] ; //Para Vacaciones ultim oaniversario
                $RestaVacacionesPendientes = $TotalDiasVacaciones11;//para obtener lo sdias de vacaciones de deuda y los de el ultimo aniversario

            }else{
            $RestaVacacionesPendientes     = $TotalDiasVacaciones11 - $DiasVacacionesUltimoAniversario;//para obtener lo sdias de vacaciones de deuda y los de el ultimo aniversario
            }
            if($RestaVacacionesPendientes<"0"){
                $RestaVacacionesPendientes="0";
            }



            ////////// se realizan las operaciones para el calculo bruto en general /////////////////////
            $propdevac                     = $diasparavacio * $ProporcionVacXantiguedad;// obtiene la proporcion por dias de vacaciones 
            $propdevaccpnvert              = bcdiv($propdevac, 1, 2);// obtiene la proporcion de dias de vacaciones a dos digitos ejemplo 0.00
            $propvacacionesinredondear     = $propdevaccpnvert * $cuotafloat;// dividir por dias de vacaciones antes y despues del ultimo aniversario
            $propvacaciones                = round($propvacacionesinredondear, 2);
            $proporcionvacacionesUltimoAniver = $propvacaciones; 
            $primavacacionalneta           = ($propvacaciones * 0.25);// prima vacacional igual entre dos 
            $primavacacionalnetaredondeada = round($primavacacionalneta, 2);
            $PimaVacacionalNetaUltimoAniversario = $primavacacionalnetaredondeada;

            ///////////////////////////////////////////////////////////////////////////////////////////
            //////////// Se realizan las operaciones para las vacaiones Pendientes ////////////////////

            $ProporcionVacacionesPendientes0  = $RestaVacacionesPendientes * $cuotafloat; // proporcion de vacaciones pendientes 
            $ProporcionVacacionesPendientes00  = round($ProporcionVacacionesPendientes0, 2);
            $ProporcionVacacionesPendientes    = $ProporcionVacacionesPendientes00;

            $PrimaVacacionesPendientes0       = ($ProporcionVacacionesPendientes * 0.25); // prima vacacional de vacaciones pendientes
            $PrimaVacacionesPendientes00 = round($PrimaVacacionesPendientes0, 2);
            $PrimaVacacionesPendientes    = $PrimaVacacionesPendientes00;

            //////////////////////////////////////Dias De Vacaciones pendientes/////////////////////////////////////////////////////
            $diasVacacionesPendientes      = $RestaVacacionesPendientes; 
        }else{
            $TotalDiasVacaciones11= $datos1[0]["DiasVacConf"];
            $diasparavacio                 = ($antiguedadd / $anio);//Saca la proporcion de vacaciones por los años trabajados         
            $propdevac                     = $diasparavacio * $TotalDiasVacaciones11;// obtiene la proporcion por dias de vacaciones 
            $propdevaccpnvert              = bcdiv($propdevac, 1, 2);// obtiene la proporcion de dias de vacaciones a dos digitos ejemplo 0.00
            $propvacacionesinredondear     = $propdevaccpnvert * $cuotafloat;// dividir por dias de vacaciones antes y despues del ultimo aniversario
            $propvacaciones                = round($propvacacionesinredondear, 2);
            $proporcionvacacionesUltimoAniver = $propvacaciones;
            $primavacacionalneta           = ($propvacaciones * 0.25);// prima vacacional igual entre dos 
            $primavacacionalnetaredondeada = round($primavacacionalneta, 2);
            $PimaVacacionalNetaUltimoAniversario = $primavacacionalnetaredondeada;
            $diasVacacionesPendientes      ="0"; 
            $PrimaVacacionesPendientes     ="0"; 
            $ProporcionVacacionesPendientes="0";
        }
        
        /////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////AGUINALDO///////////////////////////////////////////
        $diasdepago                          = $diastrabajadosenrangodelaultimaquincenaint * $cuotafloat;
        $diasdevacaciones                    = $DiasVacUltAniversario;
        $diasdeaguinaldoperiodico            = (($calculodiasaguinaldo * $datos1[0]["DiasAguinaldoConf"]) / $anio);
        $diasdeaguinaldo                     = bcdiv($diasdeaguinaldoperiodico, 1, 2);
//////solo aplica por que pagan el aguinaldo antes del 20 de diciembre y estos elementos enseguida se dan de baja y en el finiquito vulve a calcular la proporcion de aguinaldo siendo que ya fue depositado
        $rangoNoCalculoAguinaldoinicio=$aniobajadelempleado . "-12-15";
        $rangoNoCalculoAguinaldofin=$aniobajadelempleado . "-12-31";
        if($fechafin>=$rangoNoCalculoAguinaldoinicio  && $fechafin<=$rangoNoCalculoAguinaldofin  ){$diasdeaguinaldo=0;}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $proporcionnetaaguinaldosinredondear = ($cuotafloat * $diasdeaguinaldo);
        $proporcionnetaaguinaldo             = round($proporcionnetaaguinaldosinredondear, 2);
        //////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////CALCULO BRUTO//////////////////////////////////////////////////
        $aummentoengratificacion = 0; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $prestamo1                = $montoprestamoinfonavit; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $infonavit               = $montoinfonavit; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $fonacot                 = $montoprestamofonacot; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $separacion              = 0; ///Estos datos queda pendiente
        $calculobruto = ($propvacaciones + $primavacacionalnetaredondeada + $diasdepago + $proporcionnetaaguinaldo + $aummentoengratificacion + $ProporcionVacacionesPendientes + $PrimaVacacionesPendientes);//percepciones
        $uniformesFiniquito1          = (float) $uniformesFiniquito;//deduccion de almacen
        $prestamo = ($prestamo1 + $uniformesFiniquito1);
        if($estatusFiniquitoPiramidar=="3" || $estatusFiniquitoPiramidar=="5"){
            $SumDeducciones          = ($prestamo + $infonavit + $fonacot + $separacion + $montopension + $MontoAcordado);//deducciones
            $resta =  $SumDeducciones - $calculobruto;
            $calculobruto = $calculobruto + $resta;
        }
        $pagoneto                = ($calculobruto - $prestamo - $infonavit - $fonacot - $separacion - $montopension);//deducciones

        
         /*   $log->LogInfo("Valor de la variable propvacaciones:  " . var_export($propvacaciones, true));
            $log->LogInfo("Valor de la variable primavacacionalnetaredondeada:  " . var_export($primavacacionalnetaredondeada, true));
            $log->LogInfo("Valor de la variable diasdepago:  " . var_export($diasdepago, true));
            $log->LogInfo("Valor de la variable proporcionnetaaguinaldo:  " . var_export($proporcionnetaaguinaldo, true));
            $log->LogInfo("Valor de la variable aummentoengratificacion:  " . var_export($aummentoengratificacion, true));
            $log->LogInfo("Valor de la variable calculobruto:  " . var_export($calculobruto, true));
            $log->LogInfo("Valor de la variable prestamo:  " . var_export($prestamo, true));
            $log->LogInfo("Valor de la variable infonavit:  " . var_export($infonavit, true));
            $log->LogInfo("Valor de la variable fonacot:  " . var_export($fonacot, true));
            $log->LogInfo("Valor de la variable separacion:  " . var_export($separacion, true));
            $log->LogInfo("Valor de la variable pagoneto:  " . var_export($pagoneto, true));   */

        //PARA CALCULO S.A.

        $propvacacionesinredondear2           = $propdevaccpnvert * $salariofloat;
        $propvacaciones2                      = round($propvacacionesinredondear2, 2);
        $primavacacionalneta2                 = ($propvacaciones2 * 0.25);
        $primavacacionalnetaredondeada2       = round($primavacacionalneta2, 2);
        $diasdepago2                          = $diastrabajadosenrangodelaultimaquincenaint * $salariofloat;
        $proporcionnetaaguinaldosinredondear2 = ($salariofloat * $diasdeaguinaldo);
        $proporcionnetaaguinaldo2             = round($proporcionnetaaguinaldosinredondear2, 2);
        $pagoneto2                            = ($propvacaciones2 + $primavacacionalnetaredondeada2 + $proporcionnetaaguinaldo2 + $diasdepago2);
        $diferenciaagratificacion2            = ($calculobruto - $pagoneto2);
        $ingresosacumulables2                 = ($propvacaciones2 + $proporcionnetaaguinaldo2 + $diasdepago2 + $diferenciaagratificacion2);

     
        if($estatusFiniquitoPiramidar=="3" || $estatusFiniquitoPiramidar=="5"){
            $SumDeducciones          = ($prestamo + $infonavit + $fonacot + $separacion + $montopension + $MontoAcordado);//deducciones
            $ingresosacumulables2 =  $ingresosacumulables2 + $SumDeducciones;
        }

        //////////////////////////////////////////////////////////////////////////////////////////////
        //$log->LogInfo("Valor de la variable entidadFederativa:  " . var_export($entidadFederativa, true));
        //$log->LogInfo("Valor de la variable empleadoConsecutivo:  " . var_export($empleadoConsecutivo, true));
        //$log->LogInfo("Valor de la variable empleadoCategoria:  " . var_export($empleadoCategoria, true));
        //$log->LogInfo("Valor de la variable limiteeeeeeeeee:  " . var_export($ingresosacumulables2, true));
        //Decalras la variable piramidal en cero para la incercion de la tabla en la base de datos 
        $piramidarinicio =0;
        $qryrangodelimiteinferior = "SELECT * FROM isrmensual
                                        where  $ingresosacumulables2 >=limiteInferior  and   $ingresosacumulables2<=limiteSuperior";

        $resqryrangolim          = mysqli_query($conexion, $qryrangodelimiteinferior);

        $datosqryrangolimitesisr = array();
        while (($regqry = mysqli_fetch_array($resqryrangolim, MYSQLI_ASSOC))) {
            $datosqryrangolimitesisr[] = $regqry;}

        $limiteinferior               = $datosqryrangolimitesisr[0]["limiteInferior"];
        $limitesuperior               = $datosqryrangolimitesisr[0]["limiteSuperior"];
        $sobreexcedenteliminferior    = $datosqryrangolimitesisr[0]["sobreExcedenteLimInferior"];
        $cuotafijaqry                 = $datosqryrangolimitesisr[0]["cuotaFija"];
        $cuotaqryfloat                = (float) $cuotafijaqry;
        $excedentesobrelimiteinferior = ($ingresosacumulables2 - $limiteinferior);
        $resultado2                   = (($excedentesobrelimiteinferior * $sobreexcedenteliminferior) / 100);
        $resultadoo                   = bcdiv($resultado2, 1, 2);
        $resultado                    = (float) $resultadoo;
        $isrsa                        = ($resultado + $cuotaqryfloat);
        $isr                          = round($isrsa, 0);
        $netoalpagosa                 = ($pagoneto - $isr);
        if($estatusFiniquitoPiramidar=="3" || $estatusFiniquitoPiramidar=="5"){
            $netoalpagosa                 = $pagoneto;
            $diferenciaagratificacion2 =  $diferenciaagratificacion2 + $isr;
            $calculobruto =  $calculobruto + $isr;
        }
        /*$uniformesFiniquito1          = (float) $uniformesFiniquito;
        $netoalpagosa1 = (($netoalpagosa) - $uniformesFiniquito1);
        $netoalpago                   = round($netoalpagosa1, 0);*/
        $netoalpago                   = round($netoalpagosa, 0);



        $query_update                 = "UPDATE finiquitos SET pensionFiniquito=" . $montopension . ",prestamoFiniquito=" . $prestamo . ",infonavitFiniquito=" . $infonavit . ",fonacotFiniquito=" . $fonacot . "";
        $query_update .= ",antiguedadTotal=" . $antiguedadtotal . ",diasParaPPVacaciones=" . $antiguedadd . ",factorPropVacaciones=" . $propdevaccpnvert . "";
        $query_update .= ",calculoDiasAguinaldo=" . $calculodiasaguinaldo . ",separacion=" . $separacion . ",diasDeVacaciones=" . $diasdevacaciones . "";
        $query_update .= ",factorDiasAguinaldo=" . $diasdeaguinaldo . ",propVacaciones=" . $proporcionvacacionesUltimoAniver . ",primaVacacionalNeta=" . $PimaVacacionalNetaUltimoAniversario . "";
        $query_update .= ",proporcionNetaAguinaldo=" . $proporcionnetaaguinaldo . ",diasDePago=" . $diasdepago . ",aumentoGratificacion=" . $aummentoengratificacion . "";
        $query_update .= ",calculoBruto=" . $calculobruto . ",pagoNeto=" . $pagoneto . ",propVacacionesSA=" . $propvacaciones2 . ",diasTrabajados =" . $diastrabajadosenrangodelaultimaquincenaint . ",primaVacacionalSA=" . $primavacacionalnetaredondeada2 . "";
        $query_update .= ",propAginaldoSA=" . $proporcionnetaaguinaldo2 . ",diasPagoSA=" . $diasdepago2 . ",pagoNetoSA=" . $pagoneto2 . ",diferenciaGratificacionSA=" . $diferenciaagratificacion2 . "";
        $query_update .= ",ingresoAcumulableSA=" . $ingresosacumulables2 . ",limiteInferiorisr=" . $limiteinferior . ",excedenteLimiteSA=" . $excedentesobrelimiteinferior . "";
        $query_update .= ",fechaAlta='" . $fechainicio . "',fechaBaja='" . $fechafin . "'";
        if($estatusFiniquitoPiramidar == "5" || $estatusFiniquitoPiramidar=="3"){
            $query_update .= ",estatusFiniquito='1'";
        }
        $query_update .= ",tasaAplicable=" . $sobreexcedenteliminferior . ",resultado=" . $resultado . ",cuotaFija=" . $cuotafijaqry . ",isr=" . $isr . ",netoAlPago=" . $netoalpago . ",VacacionesPendientes=" . $diasVacacionesPendientes . ",PrimaVacacionalPendiente=" . $PrimaVacacionesPendientes . ",ProporcionVacPorAntig=" . $ProporcionVacXantiguedad . ",PpPrimaVacacionalPendiente=" . $ProporcionVacacionesPendientes . "
        WHERE entidadEmpFiniquito='" . $entidadFederativa . "' AND consecutivoEmpFiniquito='" . $empleadoConsecutivo . "' AND categoriaEmpFiniquito='" . $empleadoCategoria . "' AND estatusFiniquito=0";
       //  $log->LogInfo("Valor de la variable query:  " . var_export($query_update, true));
        $exUpdate = mysqli_query($conexion, $query_update);
        if ($exUpdate != true) {
            $response["mensaje"] = "Falló la actualización";                
        }
    
    }
    //$log->LogInfo("Valor de la variable qry:  " . var_export($datos, true));
    $response["status"] = "success";
    // $response["datos"]  = $datosMostrar;
} catch (Exception $e) {
    $response["mensaje"] = "Error en Exception";}




echo json_encode($response);
