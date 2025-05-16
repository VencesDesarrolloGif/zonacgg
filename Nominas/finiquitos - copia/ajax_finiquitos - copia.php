<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";

$seldescripcionperiodo = $_POST["seldescripcionperiodo"];
$selanioperiodo        = $_POST["selanioperiodo"];
$response              = array();
$response["status"]    = "error";
$datos                 = array();
try {
    $log = new KLogger("ajax_diastrabajados.log", KLogger::DEBUG);
    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                empleados.entidadFederativaId,empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                     catalogopuestos.descripcionPuesto,datosimss.fechaImss,datosimss.fechaBajaImss,cuotas_empleados.cuotaDiariaEmpleado,empleados.tipoPeriodo
            FROM  finiquitos
            left join  empleados
            ON finiquitos.entidadEmpFiniquito=empleados.entidadFederativaId
            and finiquitos.consecutivoEmpFiniquito=empleados.empleadoConsecutivoId
            and finiquitos.categoriaEmpFiniquito=empleados.empleadoCategoriaId
            LEFT JOIN datosimss
            ON datosimss.empladoEntidadImss=empleados.entidadFederativaId
            AND datosimss.empleadoConsecutivoImss=empleados.empleadoConsecutivoId
            AND datosimss.empleadoCategoriaImss=empleados.empleadoCategoriaId
            LEFT JOIN cuotas_empleados
            ON cuotas_empleados.empleadoEntidadCuota=finiquitos.entidadEmpFiniquito
            AND cuotas_empleados.empleadoConsecutivoCuota=finiquitos.consecutivoEmpFiniquito
            AND cuotas_empleados.empleadoCategoriaCuota=finiquitos.categoriaEmpFiniquito
            LEFT JOIN  catalogopuestos
            ON empleados.empleadoIdPuesto=catalogopuestos.idPuesto
            where finiquitos.estatusFiniquito=0;";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }
    for ($i = 0; $i < count($datos); $i++) {
        $tipodeperiodo               = $datos[$i]["tipoPeriodo"]; //para hacer el calculo conforme a su tipo de periodo
        $entidadFederativa           = $datos[$i]["entidadFederativaId"];
        $empleadoConsecutivo         = $datos[$i]["empleadoConsecutivoId"];
        $empleadoCategoria           = $datos[$i]["empleadoCategoriaId"];
        $fechainicio                 = $datos[$i]["fechaImss"];
        $fechafin                    = $datos[$i]["fechaBajaImss"];
        $cuotastr                    = $datos[$i]["cuotaDiariaEmpleado"];
        $cuotaint                    = (float) $cuotastr; //cortar a 2 decimales para el calculo
        $cuotafloat                  = bcdiv($cuotaint, 1, 2);
        $datetime1                   = new DateTime($fechainicio);
        $datetime2                   = new DateTime($fechafin);
        $ejercicio                   = date('Y'); //sacando el puro anio en el que estamos actualmente
        $anioejer                    = $ejercicio . "-01-01"; //fecha que servira para calcular dias aguinaldo
        $anioejerc                   = new DateTime($anioejer);
        $diastrabajados              = $datetime1->diff($datetime2);
        $dtstr                       = $diastrabajados->format('%R%a');
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
        switch ($antiguedad) {
            case ($antiguedad >= 1 && $antiguedad <= $anio):

                $fila = 1;
                break;
            case ($antiguedad > $anio && $antiguedad <= $dias2anio):
                $fila = 2; ///faltan los casos del 2-10
                break;
            case ($antiguedad > $dias2anio && $antiguedad <= $dias3anio):
                $fila = 3;
            case ($antiguedad > $dias3anio && $antiguedad <= $dias4anio):
                $fila = 4;
            case ($antiguedad > $dias4anio && $antiguedad <= $dias5anio):
                $fila = 5;
            case ($antiguedad > $dias5anio && $antiguedad <= $dias6anio):
                $fila = 6;
            case ($antiguedad > $dias6anio && $antiguedad <= $dias7anio):
                $fila = 7;
            case ($antiguedad > $dias7anio && $antiguedad <= $dias8anio):
                $fila = 8;
            case ($antiguedad > $dias8anio && $antiguedad <= $dias9anio):
                $fila = 9;
            case ($antiguedad > $dias9anio && $antiguedad <= $dias10anio):
                $fila = 10;

        }
        
        $qryrangodediastrabajados = "SELECT * FROM rangoperiodos
                                    WHERE IdAnio=$selanioperiodo
                                    AND '$fechafin' BETWEEN FechaInicioP AND FechaFinP";
        $resqryrango   = mysqli_query($conexion, $qryrangodediastrabajados);
        $datosqryrango = array();
        while (($regqry = mysqli_fetch_array($resqryrango, MYSQLI_ASSOC))) {
            $datosqryrango[] = $regqry;
        }
        $rangoFechaInicioP         = $datosqryrango[0]["FechaInicioP"];
        $rangoFechaFinP            = $datosqryrango[0]["FechaFinP"];
        $qrydiastrabenultimaquince = " SELECT sum(ci.valorAsistencia)AS diastrabajados,ci.nomenclaturaIncidencia,ci.descripcionIncidencia
                                        FROM asistencia a
                                        LEFT JOIN  catalogoincidencias ci ON (ci.incidenciaId=a.incidenciaAsistenciaId)
                                        WHERE
                                        a.fechaAsistencia BETWEEN CAST('$rangoFechaInicioP' AS DATE) AND CAST('$rangoFechaFinP' AS DATE)
                                        AND a.empleadoEntidad=      '$entidadFederativa'
                                        AND a.empleadoConsecutivo=  '$empleadoConsecutivo'
                                        and a.empleadoTipo=         '$empleadoCategoria'";
        $resqrydiastrab   = mysqli_query($conexion, $qrydiastrabenultimaquince);
        $datosqrydiastrab = array();
        while (($regqrydiastrabultquinc = mysqli_fetch_array($resqrydiastrab, MYSQLI_ASSOC))) {
            $datosqrydiastrab[] = $regqrydiastrabultquinc;
        }
        $diastrabajadosenrangodelaultimaquincenastr = $datosqrydiastrab[0]["diastrabajados"];
        $diastrabajadosenrangodelaultimaquincenaint = (int) $diastrabajadosenrangodelaultimaquincenastr;
        $qryantiguedad                              = "SELECT * FROM antiguedad
                                                        WHERE IdAntiguedad=$fila";
        $res1   = mysqli_query($conexion, $qryantiguedad);
        $datos1 = array();
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))) {
            $datos1[] = $reg1;
        }
        if ($antiguedad > $anio) {
            $antiguedad = $antiguedad - $anio;
        }if ($anioejerc < $datetime1) {
            $calculodiasaguinaldo = $antiguedad;
        } else {
            $calculodiasaguinal       = $anioejerc->diff($datetime2);
            $calculodiasaguinalstr    = $calculodiasaguinal->format('%R%a');
            $calculodiasaguinalstring = substr($calculodiasaguinalstr, 1);
            $calculodiasaguinaldo     = (int) $calculodiasaguinalstring;}
/////PARA TRAER VALORES DE INFONAVIT //////////////////////////////
        $qrydeudainfonavit = "SELECT * FROM infonavit_finiquito
                                where entidadEmpIF='$entidadFederativa'
                                and consecutivoEmpIF='$empleadoConsecutivo'
                                and categoriaEmpIF='$empleadoCategoria'";
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
                                where entidadEmpPF='$entidadFederativa'
                                and consecutivoEmpPF='$empleadoConsecutivo'
                                and categoriaEmpPF='$empleadoCategoria'";
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
                                where entidadEmpFF='$entidadFederativa'
                                and consecutivoEmpFF='$empleadoConsecutivo'
                                and categoriaEmpFF='$empleadoCategoria'";
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

        /////////////////////////VACACIONES////////////////////////////////////////////
        $diasparavacio                 = ($antiguedad / $anio);
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
        $pagoneto                = ($calculobruto - $prestamo - $infonavit - $fonacot - $separacion);
        //////////////////////////////////////////////////////////////////////////////////////////////
        $datos[$i]["numempleado"]                  = "<input class='input-small' id='numempleado" . $i . "' value='" . $entidadFederativa . '-' . $empleadoConsecutivo . '-' . $empleadoCategoria . "'readonly>";
        $datos[$i]["diastrabenlaquincena"]         = "<input class='input-mini' id='diastrabajadosenrangodelaultimaquincenaint" . $i . "' value='" . $diastrabajadosenrangodelaultimaquincenaint . "'readonly>";
        $datos[$i]["PRIMAVACACAIONALNETA"]         = "<input class='input-mini' id='primavacacionalnetaredondeada" . $i . "'  value='" . $primavacacionalnetaredondeada . "'readonly>";
        $datos[$i]["PROPORCION NETA DE AGUINALDO"] = "<input class='input-mini' id='proporcionnetaaguinaldo" . $i . "' value='" . $proporcionnetaaguinaldo . "'readonly>";
        $datos[$i]["aumentoengratificacion"]       = "<input class='input-mini' id='aumentoengratificacion" . $i . "' value='" . $aummentoengratificacion . "'readonly>";
        $datos[$i]["CALCULO DIAS AGUINALDO"]       = "<input class='input-mini' id='calculodiasaguinaldo" . $i . "'  value='" . $calculodiasaguinaldo . "'readonly>";
        $datos[$i]["DiasVacConf"]                  = "<input class='input-mini' id='diasdevacaciones" . $i . "'  value='" . $diasdevacaciones . "'readonly>";
        $datos[$i]["fechaImss"]                    = "<input class='input-small' id='fechainicioimss" . $i . "'  value='" . $fechainicio . "'readonly>";
        $datos[$i]["proporcion_de_vacaciones"]     = "<input class='input-mini' id='propdevaccpnvert" . $i . "'  value='" . $propdevaccpnvert . "'readonly>";
        $datos[$i]["DIAS AGUINALDO"]               = "<input class='input-mini' id='diasdeaguinaldo" . $i . "'   value='" . $diasdeaguinaldo . "'readonly> ";
        $datos[$i]["antiguedadtotal"]              = "<input class='input-mini' id='antiguedadtotal" . $i . "' value='" . $antiguedadtotal . "'readonly>";
        $datos[$i]["fechaBajaImss"]                = "<input class='input-small' id='fechabajaimss" . $i . "'  value='" . $fechafin . "'readonly>";
        $datos[$i]["diastrabajados"]               = "<input class='input-mini' id='diastrabajados" . $i . "'  value='" . $antiguedad . "'readonly>";
        $datos[$i]["propdevacaciones"]             = "<input class='input-mini' id='propvacaciones" . $i . "'  value='" . $propvacaciones . "'readonly>";
        $datos[$i]["calculobruto"]                 = "<input class='input-mini' id='calculobruto" . $i . "' value='" . $calculobruto . "'readonly>";
        $datos[$i]["diasdepago"]                   = "<input class='input-mini' id='diasdepago" . $i . "' value='" . $diasdepago . "'readonly>";
        $datos[$i]["separacion"]                   = "<input class='input-mini' id='separacion" . $i . "' value='" . $separacion . "'readonly>";
        $datos[$i]["infonavit"]                    = "<input class='input-mini' id='infonavit" . $i . "' value='" . $infonavit . "'readonly>";
        $datos[$i]["cuotaPagadaTurno"]             = "<input class='input-mini' id='cuotaint" . $i . "'  value='" . $cuotafloat . "'readonly>";
        $datos[$i]["prestamo"]                     = "<input class='input-mini' id='prestamo" . $i . "' value='" . $prestamo . "'readonly>";
        $datos[$i]["pagoneto"]                     = "<input class='input-mini' id='pagoneto" . $i . "' value='" . $pagoneto . "'readonly>";
        $datos[$i]["fonacot"]                      = "<input class='input-mini' id='fonacot" . $i . "' value='" . $fonacot . "'readonly>";
        $datos[$i]["editar"]                       = "<a class='label label-warning'  id='btnrditar' onclick='editar($i)'>Editar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='label label-primary'  id='btnrditar' onclick='guardar($i)'>Guardar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='label label-success'  id='btnrditar' onclick='confirmar($i)'>Confirmar</a>";
    }
    //$log->LogInfo("Valor de la variable qry:  " . var_export($datos, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["message"] = "Error al iniciar sesion";}
echo json_encode($response);
