<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "conexion.php";
require_once "../libs/logger/KLogger.php";

$response           = array();
$response["status"] = "error";
$datos              = array();
try {
  //  $log = new KLogger("ajax_finiquito.log", KLogger::DEBUG);
    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                    empleados.entidadFederativaId,empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                     catalogopuestos.descripcionPuesto,datosimss.fechaImss,datosimss.fechaBajaImss,datosimss.salarioDiario,cuotas_empleados.cuotaDiariaEmpleado,empleados.tipoPeriodo
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
            where finiquitos.estatusFiniquito=0;";
    $res = mysqli_query($conexion, $sql);
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
        //OBTENEMOS EL SALARIO DIARIO PARA HACER LOS CALCULOS DE S.A.
        $salDiario                   = $datos[$i]["salarioDiario"];
        $cuotaint                    = (float) $cuotastr;
        $salarioint                  = (float) $salDiario; //cortar a 2 decimales para el calculo
        $cuotafloat                  = bcdiv($cuotaint, 1, 2);
        $salariofloat                = bcdiv($salarioint, 1, 2);
        $datetime1                   = new DateTime($fechainicio);
        $datetime2                   = new DateTime($fechafin);
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
                break;}
        // $log->LogInfo("Valor de la variable fila:  " . var_export($fila, true));
        $qryrangodediastrabajados = "SELECT *
                                        from periodos
                                            left join aniosperiodos on periodos.IdPeriodo=aniosperiodos.IdPeriodo
                                            left join rangoperiodos on rangoperiodos.IdAnio=aniosperiodos.IdAnio
                                        WHERE periodos.IdPeriodo=$tipodeperiodo
                                        AND '$fechafin' BETWEEN rangoperiodos.FechaInicioP AND rangoperiodos.FechaFinP";
        $resqryrango   = mysqli_query($conexion, $qryrangodediastrabajados);
        $datosqryrango = array();
        while (($regqry = mysqli_fetch_array($resqryrango, MYSQLI_ASSOC))) {
            $datosqryrango[] = $regqry;}
        $rangoFechaInicioP         = $datosqryrango[0]["FechaInicioP"];
        $rangoFechaFinP            = $datosqryrango[0]["FechaFinP"];
        $qrydiastrabenultimaquince = " SELECT (ifnull(sum(ci.valorAsistencia),0)) as diastrabajados,ci.nomenclaturaIncidencia,ci.descripcionIncidencia
                                            FROM  asistencia a
                                            LEFT JOIN  catalogoincidencias ci ON (ci.incidenciaId=a.incidenciaAsistenciaId)
                                        WHERE a.fechaAsistencia BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND a.empleadoEntidad=      '$entidadFederativa'
                                        AND a.empleadoConsecutivo=  '$empleadoConsecutivo'
                                        and a.empleadoTipo=         '$empleadoCategoria' ";
        $resqrydiastrab   = mysqli_query($conexion, $qrydiastrabenultimaquince);
        $datosqrydiastrab = array();
        while (($regqrydiastrabultquinc = mysqli_fetch_array($resqrydiastrab, MYSQLI_ASSOC))) {
            $datosqrydiastrab[] = $regqrydiastrabultquinc;}
        $diastrabajadosenrangodelaultimaquincenastr = $datosqrydiastrab[0]["diastrabajados"];
        $diastrabajadosenrangodelaultimaquincenaint = (int) $diastrabajadosenrangodelaultimaquincenastr;

//CONSULTA PARA SACAR LOS TURNOS EXTRAS O INCIDENCIAS ESPECIALES
//PRUEBAS EN SERVIDOR LOCAL PARA SUBIR EL CAMBIO

/*
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
        $turnosExtraenrangodelaultimaquincenastr = $datosqryTurnosExtra[0]["diastrabajados"];
        $turnosExtraenrangodelaultimaquincenaint = (int) $turnosExtraenrangodelaultimaquincenastr;
        if ($i == 1) {
            $log->LogInfo("Valor de la variable turnosExtra:  " . var_export($qryturnosExtraultimaquince, true));
        }

        $diastrabajadosenrangodelaultimaquincenaint = $turnosExtraenrangodelaultimaquincenaint + $diastrabajadosenrangodelaultimaquincenaint;*/

//condicion si los dias trabajados enrtre la quincena es menor a seis no se pagaran los descansos
        if ($diastrabajadosenrangodelaultimaquincenaint < 6) {
            $qrydiastrabenultimaquince = "SELECT (ifnull(sum(ci.valorAsistencia),0)) as diastrabajados,ci.nomenclaturaIncidencia,ci.descripcionIncidencia
                                            FROM  asistencia a
                                            LEFT JOIN  catalogoincidencias ci ON (ci.incidenciaId=a.incidenciaAsistenciaId)
                                        WHERE a.fechaAsistencia BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND a.empleadoEntidad=      '$entidadFederativa'
                                        AND a.empleadoConsecutivo=  '$empleadoConsecutivo'
                                        and a.empleadoTipo=         '$empleadoCategoria'
                                            and ci.incidenciaId !=1";

            $resqrydiastrab   = mysqli_query($conexion, $qrydiastrabenultimaquince);
            $datosqrydiastrab = array();
            while (($regqrydiastrabultquinc = mysqli_fetch_array($resqrydiastrab, MYSQLI_ASSOC))) {
                $datosqrydiastrab[] = $regqrydiastrabultquinc;}
            $diastrabajadosenrangodelaultimaquincenastr = $datosqrydiastrab[0]["diastrabajados"];
            $diastrabajadosenrangodelaultimaquincenaint = (int) $diastrabajadosenrangodelaultimaquincenastr;

            //CONSULTA PARA SACAR LOS TURNOS EXTRAS O INCIDENCIAS ESPECIALES

         /*   $qryturnosExtraultimaquince = "SELECT (ifnull(sum(ci.valorIncidenciaEspecial),0)) as diastrabajados
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
            $turnosExtraenrangodelaultimaquincenastr = $datosqryTurnosExtra[0]["diastrabajados"];
            $turnosExtraenrangodelaultimaquincenaint = (int) $turnosExtraenrangodelaultimaquincenastr;

            $diastrabajadosenrangodelaultimaquincenaint = $turnosExtraenrangodelaultimaquincenaint + $diastrabajadosenrangodelaultimaquincenaint;*/
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
        if ($anioejerc < $datetime1) {
            $calculodiasaguinaldo = $antiguedad;
        } else {
            $calculodiasaguinal       = $anioejerc->diff($datetime2);
            $calculodiasaguinalstr    = $calculodiasaguinal->format('%R%a');
            $calculodiasaguinalstring = substr($calculodiasaguinalstr, 1);
            $calculodiasaguinaldo     = (int) $calculodiasaguinalstring;}
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
        } else { $antiguedadd = $antiguedadtotal;}
        $diasparavacio                 = ($antiguedadd / $anio);
        $propdevac                     = $diasparavacio * $datos1[0]["DiasVacConf"];
        $propdevaccpnvert              = bcdiv($propdevac, 1, 2);
        $propvacacionesinredondear     = $propdevaccpnvert * $cuotafloat;
        $propvacaciones                = round($propvacacionesinredondear, 2);
        $primavacacionalneta           = ($propvacaciones * 0.25);
        $primavacacionalnetaredondeada = round($primavacacionalneta, 2);
        /////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////AGUINALDO///////////////////////////////////////////
        $diasdepago                          = $diastrabajadosenrangodelaultimaquincenaint * $cuotafloat;
        $diasdevacaciones                    = $datos1[0]["DiasVacConf"];
        $diasdeaguinaldoperiodico            = (($calculodiasaguinaldo * $datos1[0]["DiasAguinaldoConf"]) / $anio);
        $diasdeaguinaldo                     = bcdiv($diasdeaguinaldoperiodico, 1, 2);
        $proporcionnetaaguinaldosinredondear = ($cuotafloat * $diasdeaguinaldo);
        $proporcionnetaaguinaldo             = round($proporcionnetaaguinaldosinredondear, 2);
        //////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////CALCULO BRUTO//////////////////////////////////////////////////
        $aummentoengratificacion = 0; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $prestamo                = $montoprestamoinfonavit; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $infonavit               = $montoinfonavit; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $fonacot                 = $montoprestamofonacot; ///Estos datos tendran que ser consultados en la tabla especificada aun no creada donde se subiran estos datos por medio de un excel
        $separacion              = 0; ///Estos datos queda pendiente
        $calculobruto            = ($propvacaciones + $primavacacionalnetaredondeada + $diasdepago + $proporcionnetaaguinaldo + $aummentoengratificacion);
        $pagoneto                = ($calculobruto - $prestamo - $infonavit - $fonacot - $separacion - $montopension);
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
        //////////////////////////////////////////////////////////////////////////////////////////////
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
        $netoalpago                   = round($netoalpagosa, 0);
        $query_update                 = "UPDATE finiquitos SET pensionFiniquito=" . $montopension . ",prestamoFiniquito=" . $prestamo . ",infonavitFiniquito=" . $infonavit . ",fonacotFiniquito=" . $fonacot . "";
        $query_update .= ",antiguedadTotal=" . $antiguedadtotal . ",diasParaPPVacaciones=" . $antiguedadd . ",factorPropVacaciones=" . $propdevaccpnvert . "";
        $query_update .= ",calculoDiasAguinaldo=" . $calculodiasaguinaldo . ",separacion=" . $separacion . ",diasDeVacaciones=" . $diasdevacaciones . "";
        $query_update .= ",factorDiasAguinaldo=" . $diasdeaguinaldo . ",propVacaciones=" . $propvacaciones . ",primaVacacionalNeta=" . $primavacacionalnetaredondeada . "";
        $query_update .= ",proporcionNetaAguinaldo=" . $proporcionnetaaguinaldo . ",diasDePago=" . $diasdepago . ",aumentoGratificacion=" . $aummentoengratificacion . "";
        $query_update .= ",calculoBruto=" . $calculobruto . ",pagoNeto=" . $pagoneto . ",propVacacionesSA=" . $propvacaciones2 . ",diasTrabajados =" . $diastrabajadosenrangodelaultimaquincenaint . ",primaVacacionalSA=" . $primavacacionalnetaredondeada2 . "";
        $query_update .= ",propAginaldoSA=" . $proporcionnetaaguinaldo2 . ",diasPagoSA=" . $diasdepago2 . ",pagoNetoSA=" . $pagoneto2 . ",diferenciaGratificacionSA=" . $diferenciaagratificacion2 . "";
        $query_update .= ",ingresoAcumulableSA=" . $ingresosacumulables2 . ",limiteInferiorisr=" . $limiteinferior . ",excedenteLimiteSA=" . $excedentesobrelimiteinferior . "";
        $query_update .= ",tasaAplicable=" . $sobreexcedenteliminferior . ",resultado=" . $resultado . ",cuotaFija=" . $cuotafijaqry . ",isr=" . $isr . ",netoAlPago=" . $netoalpago . "
        WHERE entidadEmpFiniquito='" . $entidadFederativa . "' AND consecutivoEmpFiniquito='" . $empleadoConsecutivo . "' AND categoriaEmpFiniquito='" . $empleadoCategoria . "'";
        $exUpdate = mysqli_query($conexion, $query_update);
        if ($exUpdate != true) {
            $response["mensaje"] = "Falló la actualización";
        }

/*
$datosMostrar = array();
$datosMostrar[$i]['PROPORCION VACACIONES $']             = $propvacaciones2;
$datosMostrar[$i]['PRIMA VACACIONAL $']                  = $primavacacionalnetaredondeada2;
$datosMostrar[$i]['PROPORCION  AGUINALDO $']             = $proporcionnetaaguinaldo2;
$datosMostrar[$i]['DIAS DE PAGO S.A.']                   = $diasdepago2;
$datosMostrar[$i]['PAGO NETO S.A']                       = $pagoneto2;
$datosMostrar[$i]['DIFERENCIA A GRATIFICACION S.A']      = $diferenciaagratificacion2;
$datosMostrar[$i]['INGRESOS ACUMULABLES S.A']            = $ingresosacumulables2;
$datosMostrar[$i]['LIMITE INFERIOR']                     = $limiteinferior;
$datosMostrar[$i]['TASA APLICABLE DEL LIMITE']           = $sobreexcedenteliminferior;
$datosMostrar[$i]['EXCEDENTE SOBRE LIMITE INFERIOR S.A'] = $excedentesobrelimiteinferior;
$datosMostrar[$i]['RESULTADO S.A']                       = $resultado;
$datosMostrar[$i]['CUOTA FIJA S.A']                      = $cuotafijaqry;
$datosMostrar[$i]['ISR S.A']                             = $isr;
$datosMostrar[$i]['NETO AL PAGO S.A']                    = $netoalpago;
$datosMostrar[$i]['pagoneto']     = $pagoneto;
$datosMostrar[$i]['calculobruto'] = $calculobruto;*/
    }
    //$log->LogInfo("Valor de la variable qry:  " . var_export($datos, true));
    $response["status"] = "success";
    // $response["datos"]  = $datosMostrar;
} catch (Exception $e) {
    $response["mensaje"] = "Error en Exception";}
echo json_encode($response);
