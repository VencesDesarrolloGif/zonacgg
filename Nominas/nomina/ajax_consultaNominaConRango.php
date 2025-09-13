<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$datos                    = array();
$response                 = array();
$response["status"]       = "error";
$tiponomina               = $_POST["tiponomina"];
$periodonomina            = $_POST["periodonomina"];
$fechahoy                 = $_POST['fechahoy'];
// $fechahoy                 = date("Y-m-d");

    $qryrangodediastrabajados = "SELECT * 
                                 FROM periodos
                                 LEFT JOIN aniosperiodos on periodos.IdPeriodo=aniosperiodos.IdPeriodo
                                 LEFT JOIN rangoperiodos on rangoperiodos.IdAnio=aniosperiodos.IdAnio
                                 WHERE periodos.IdPeriodo=$periodonomina
                                 AND '$fechahoy' BETWEEN rangoperiodos.FechaInicioP AND rangoperiodos.FechaFinP";

    $resqryrango   = mysqli_query($conexion, $qryrangodediastrabajados);
    $datosqryrango = array();

    while (($regqry= mysqli_fetch_array($resqryrango, MYSQLI_ASSOC))) {
        $datosqryrango[] = $regqry;
    
    }
    
    $rangoFechaInicioP = $datosqryrango[0]["FechaInicioP"];
    $rangoFechaFinP    = $datosqryrango[0]["FechaFinP"];
    $IdRango           = $datosqryrango[0]["IdRango"];
    $idanio            = $datosqryrango[0]["IdAnio"];

    $log               = new KLogger("ajax_nomina.log", KLogger::DEBUG);
    $qryconteo         = "SELECT count(*) conteo
                          FROM rangoperiodos
                          WHERE idAnio=$idanio";
    
    $resqryrango       = mysqli_query($conexion, $qryconteo);
    $datosqryconteo    = array();

    while(($regqrycount = mysqli_fetch_array($resqryrango, MYSQLI_ASSOC))) {
           $datosqryconteo[] = $regqrycount;
    }

    $qryconteo2      = "SELECT * 
                        FROM rangoperiodos
                        WHERE idAnio=$idanio ";
    
    $resqryrango2    = mysqli_query($conexion, $qryconteo2);
    $datosqryconteo2 = array();
    while (($regqrycount2 = mysqli_fetch_array($resqryrango2, MYSQLI_ASSOC))) {
            $datosqryconteo2[] = $regqrycount2;
    }

    for ($i = 0; $i < $datosqryconteo[0]["conteo"]; $i++) {
        if ($IdRango == $datosqryconteo2[$i]["IdRango"]) {
            $numerodesemanaoquincena = $i + 1;
            break;
        }
    }

try {
    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                    empleados.entidadFederativaId,empleados.empleadoConsecutivoId,empleados.empleadoCategoriaId,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                    entidadesfederativas.nombreEntidadFederativa,empleados.empleadoNumeroSeguroSocial,
                    empleados.numeroCta,empleados.numeroCtaClabe,catalogopuestos.descripcionPuesto,datosimss.fechaImss,
                    datosimss.fechaBajaImss,empleados.tipoPeriodo,empleados.empleadoEstatusId,empleados.idTipoPuesto,datosimss.salarioDiario
            FROM  empleados
            LEFT JOIN datosimss
            ON datosimss.empladoEntidadImss=empleados.entidadFederativaId
            AND datosimss.empleadoConsecutivoImss=empleados.empleadoConsecutivoId
            AND datosimss.empleadoCategoriaImss=empleados.empleadoCategoriaId
            LEFT JOIN  catalogopuestos ON empleados.empleadoIdPuesto=catalogopuestos.idPuesto
            LEFT JOIN entidadesfederativas
            ON empleados.idEntidadTrabajo=entidadesfederativas.idEntidadFederativa
            left join finiquitos ON empleados.entidadFederativaId=finiquitos.entidadEmpFiniquito AND empleados.empleadoConsecutivoId=finiquitos.consecutivoEmpFiniquito AND empleados.empleadoCategoriaId=finiquitos.categoriaEmpFiniquito";

    if ($tiponomina == 1){
        $sql .= " WHERE (empleados.empleadoEstatusId=1 or  empleados.empleadoEstatusId=2 or (empleados.empleadoEstatusId=0 AND fechaBajaEmpleado between '$rangoFechaInicioP' AND  '$rangoFechaFinP'  AND finiquitos.estatusFiniquito='0'))
                 AND empleados.tipoPeriodo='$periodonomina' group by numempleado ";
    }
    
    if ($tiponomina == 2) {
        $sql .= " WHERE  (empleados.empleadoEstatusId=1 or empleados.empleadoEstatusId=2)
        AND empleados.tipoPeriodo='$periodonomina' group by numempleado";
    }
    
    if ($tiponomina == 3) {
        $sql .= " WHERE (empleados.empleadoEstatusId=0 AND fechaBajaEmpleado between '$rangoFechaInicioP' AND  '$rangoFechaFinP' or( finiquitos.estatusFiniquito='0'))
                 AND empleados.tipoPeriodo='$periodonomina'
                 ";
    }
    
    // $log->LogInfo("Valor de la variable sql:  " . var_export($sql, true));
    $res = mysqli_query($conexion, $sql);
    
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;
    }
    
    // $log->LogInfo("Valor de la variable datos:  " . var_export($datos, true));
    for ($i = 0; $i < count($datos); $i++) {
        $tipodeperiodo       = $datos[$i]["tipoPeriodo"]; //para hacer el calculo conforme a su tipo de periodo
        $entidadFederativa   = $datos[$i]["entidadFederativaId"];
        $empleadoConsecutivo = $datos[$i]["empleadoConsecutivoId"];
        $empleadoCategoria   = $datos[$i]["empleadoCategoriaId"];
        $fechainicio         = $datos[$i]["fechaImss"];
        $cuentaclabe         = $datos[$i]["numeroCtaClabe"];
        $idbanco             = substr($cuentaclabe, 0, 3);
        $tiporol             = $datos[$i]["idTipoPuesto"];
        $salariodiario       = $datos[$i]["salarioDiario"];
        //consulta para los turnos de todos los empleados
        $sqlasistoperativa = "SELECT a. empleadoEntidad,
                                     a.empleadoConsecutivo,
                                     a.empleadoTipo,
                                     ifnull(SUM(ci.valorAsistencia),0 )as turnos
                              FROM asistencia a
                              LEFT JOIN  catalogoincidencias ci on (ci.incidenciaId=a.incidenciaAsistenciaId)
                              WHERE a.fechaAsistencia BETWEEN '$rangoFechaInicioP' AND '$rangoFechaFinP'
                              AND a.empleadoEntidad='$entidadFederativa'
                              AND a.empleadoConsecutivo='$empleadoConsecutivo'
                              AND a.empleadoTipo='$empleadoCategoria'";

        $resqryasistenciaoper = mysqli_query($conexion, $sqlasistoperativa);
        $datosasistencia      = array();

        while (($resqryasistencioperativa = mysqli_fetch_array($resqryasistenciaoper, MYSQLI_ASSOC))) {
                $datosasistencia[] = $resqryasistencioperativa;
        }
        
        $datoasistencia = $datosasistencia[0]["turnos"];
        // $log->LogInfo("Valor de la variable qry:  " . var_export($sqlasistoperativa, true));
        ////////////////////////////////////////////////////////////PARA TRAER EL BANCO ASIGNADO A  CADA EMPLEADO////////////////////////////////////////////////
        $qrybanco = "SELECT  * 
                     FROM bancos_empresa
                     WHERE idCuentaBanco=$idbanco";

        $resqrybanco = mysqli_query($conexion, $qrybanco);
        $datobanco   = array();

        while (($resqryban = mysqli_fetch_array($resqrybanco, MYSQLI_ASSOC))) {
                $datobanco[] = $resqryban;
        }


        $conteobancos = count($datobanco);
        if ($conteobancos != 0) {
            $descbanco = $datobanco[0]["nombreBanco"];
        } else { 
            $descbanco = "SIN DESCRIPCIÓN";
        }
        //$log->LogInfo("Valor de la variable qry:  " . var_export($descbanco, true));
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudainfonavit = "SELECT * 
                              FROM infonavit_nomina
                              WHERE idIN=(SELECT max(idIN)
                                          FROM infonavit_nomina
                                          WHERE entidadEmpIN  ='$entidadFederativa'
                                          AND consecutivoEmpIN='$empleadoConsecutivo'
                                          AND categoriaEmpIN  ='$empleadoCategoria')";

        $resqrydeudainfona  = mysqli_query($conexion, $qrydeudainfonavit);
        $datodeudainfonavit = array();

        while (($resqrydeudainfonavit = mysqli_fetch_array($resqrydeudainfona, MYSQLI_ASSOC))) {
                $datodeudainfonavit[] = $resqrydeudainfonavit;
        }
        $conteodeudainfonavit = count($datodeudainfonavit);
        
        if ($conteodeudainfonavit != 0) {
            $montoinfonavit = $datodeudainfonavit[0]["montoIN"];
        } else {
             $montoinfonavit = "0";
        }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudafonacot = "SELECT * 
                            FROM fonacot_nomina
                            WHERE idFN=(select max(idFN)
                                                FROM fonacot_nomina
                                                WHERE entidadEmpFN='$entidadFederativa'
                                                AND consecutivoEmpFN='$empleadoConsecutivo'
                                                AND categoriaEmpFN='$empleadoCategoria')";
        $resqrydeudafona  = mysqli_query($conexion, $qrydeudafonacot);
        $datodeudafonacot = array();
        while (($resqrydeudafonavit = mysqli_fetch_array($resqrydeudafona, MYSQLI_ASSOC))) {
            $datodeudafonacot[] = $resqrydeudafonavit;}
        $conteodeudafonacot = count($datodeudafonacot);
        if ($conteodeudafonacot != 0) {
            $montofonacot = $datodeudafonacot[0]["montoFN"];
        } else { $montofonacot = "0";}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudapension = "SELECT * FROM pension_nomina
                                WHERE idPeN=(select max(idPeN)
                                                FROM pension_nomina
                                                WHERE entidadEmpPeN='$entidadFederativa'
                                                AND consecutivoEmpPeN='$empleadoConsecutivo'
                                                AND categoriaEmpPeN='$empleadoCategoria')";
        $resqrydeudapension = mysqli_query($conexion, $qrydeudapension);
        $datodeudapension   = array();
        while (($resqrydeudapen = mysqli_fetch_array($resqrydeudapension, MYSQLI_ASSOC))) {
            $datodeudapension[] = $resqrydeudapen;}
        $conteodeudapension = count($datodeudapension);
        if ($conteodeudapension != 0) {
            $montopension = $datodeudapension[0]["montoPeN"];
        } else { $montopension = "0";}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudaprestamo = "SELECT * FROM prestamo_nomina
                                WHERE idPN=(select max(idPN)
                                                FROM prestamo_nomina
                                                WHERE entidadEmpPN='$entidadFederativa'
                                                AND consecutivoEmpPN='$empleadoConsecutivo'
                                                AND categoriaEmpPN='$empleadoCategoria')";
        $resqrydeudaprestamo = mysqli_query($conexion, $qrydeudaprestamo);
        $datodeudaprestamo   = array();
        while (($resqrydeudapres = mysqli_fetch_array($resqrydeudaprestamo, MYSQLI_ASSOC))) {
            $datodeudaprestamo[] = $resqrydeudapres;
        }
        $conteodeudaprestamo = count($datodeudaprestamo);
        if ($conteodeudaprestamo != 0) {
            $montoprestamo = $datodeudaprestamo[0]["montoPN"];
        } else { $montoprestamo = "0";}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $qrydeudaalimentos = "SELECT * FROM alimentos_nomina
                                WHERE idAN=(select max(idAN)
                                                FROM alimentos_nomina
                                                WHERE entidadEmpAN='$entidadFederativa'
                                                AND consecutivoEmpAN='$empleadoConsecutivo'
                                                AND categoriaEmpAN='$empleadoCategoria')";
        $resqrydeudaalimento = mysqli_query($conexion, $qrydeudaalimentos);
        $datodeudaalimentos  = array();
        while (($resqrydeudaalimen = mysqli_fetch_array($resqrydeudaalimento, MYSQLI_ASSOC))) {
            $datodeudaalimentos[] = $resqrydeudaalimen;}
        $conteodeudaalimento = count($datodeudaalimentos);
        if ($conteodeudaalimento != 0) {
            $montoalimento = $datodeudaalimentos[0]["montoAN"];
        } else { $montoalimento = "0";}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////CALCULO DE SUELDO POR EMPLEADO CONFORME A SUS DIAS TRABAJADOS//////////
        $sueldo = ($salariodiario * $datoasistencia);

        $datos[$i]["alimentos"] = $montoalimento;
        $datos[$i]["prestamo"]  = $montoprestamo;
        $datos[$i]["pension"]   = $montopension;
        $datos[$i]["fonacot"]   = $montofonacot;
        $datos[$i]["infonavit"] = $montoinfonavit;
        $datos[$i]["banco"]     = $descbanco;
        //$log->LogInfo("Valor de la variable cuenta:  " . var_export($cuenta, true));
        $datos[$i]["turnos trabajados"] = $datoasistencia;
        $datos[$i]["sueldo"]            = $sueldo;
        //$datos[$i]["tipo de rol"]       = $tiporol;

    }

    ////////////////////formato a las fechas de inicio y fin del periodo/////////////////////
    $fechainicio       = new DateTime($rangoFechaInicioP);
    $fechainicioformat = date_format($fechainicio, 'd-m-Y');
    $fechafin          = new DateTime($rangoFechaFinP);
    $fechafinformat    = date_format($fechafin, 'd-m-Y');
    ////////////////////////////////////////////////////////////////////////////////////////
    $response["status"]             = "success";
    $response["fechainicio"]        = $fechainicioformat;
    $response["fechafin"]           = $fechafinformat;
    $response["idrango"]            = $IdRango;
    $response["idanio"]             = $idanio;
    $response["numsemanaoquincena"] = $numerodesemanaoquincena;
    //$response["sabados y domingos hasta el dia de hoy"] = $aux;

    $response["datos"] = $datos;
// $log->LogInfo("Valor de la variable response:  " . var_export($response, true));
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
