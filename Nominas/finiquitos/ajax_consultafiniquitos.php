<?php
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$response           = array();
$response["status"] = "error";
$datos              = array();
try {
    $log = new KLogger("ajax_Consultafiniquitos.log", KLogger::DEBUG);
    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                     catalogopuestos.descripcionPuesto,entidadesfederativas.nombreEntidadFederativa,datosimss.fechaImss,datosimss.fechaBajaImss,finiquitos.fechaAlta,finiquitos.fechaBaja,
                     finiquitos.prestamoFiniquito,finiquitos.infonavitFiniquito,finiquitos.fonacotFiniquito,finiquitos.pensionFiniquito,cuotas_empleados.cuotaDiariaEmpleado,
                     finiquitos.diasTrabajados, finiquitos.separacion, finiquitos.piramidar , finiquitos.antiguedadTotal,
                     finiquitos.diasParaPPVacaciones, finiquitos.diasDeVacaciones,finiquitos.factorPropVacaciones, finiquitos.calculoDiasAguinaldo,
                    finiquitos.factorDiasAguinaldo, finiquitos.propVacaciones,
                     finiquitos.primaVacacionalNeta, finiquitos.proporcionNetaAguinaldo,finiquitos.diasDePago,
                     finiquitos.aumentoGratificacion, finiquitos.calculoBruto, finiquitos.pagoNeto,finiquitos.propVacacionesSA,finiquitos.primaVacacionalSA,
                     finiquitos.propAginaldoSA,finiquitos.diasPagoSA,finiquitos.pagoNetoSA,finiquitos.diferenciaGratificacionSA,finiquitos.ingresoAcumulableSA,finiquitos.limiteInferiorisr,
                     finiquitos.excedenteLimiteSA,finiquitos.tasaAplicable,finiquitos.resultado,finiquitos.cuotaFija,finiquitos.isr,finiquitos.netoAlPago,finiquitos.VacacionesPendientes,finiquitos.PrimaVacacionalPendiente,
                     finiquitos.PpPrimaVacacionalPendiente, datosimss.salarioDiario
            FROM  finiquitos
            LEFT JOIN  empleados
            ON finiquitos.entidadEmpFiniquito=empleados.entidadFederativaId
            AND finiquitos.consecutivoEmpFiniquito=empleados.empleadoConsecutivoId
            AND finiquitos.categoriaEmpFiniquito=empleados.empleadoCategoriaId
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
            LEFT JOIN entidadesfederativas
            ON empleados.idEntidadTrabajo=entidadesfederativas.idEntidadFederativa
            where finiquitos.estatusFiniquito=0";
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;}
    $log->LogInfo("Valor de la variable datos:  " . var_export($datos, true));

    for ($i = 0; $i < count($datos); $i++) {
        $fechbaja                                  = $datos[$i]["fechaBajaImss"];
        $fechingreso                               = $datos[$i]["fechaImss"];
        $cuotasinint                               = $datos[$i]["cuotaDiariaEmpleado"];
        $salarioDiario = $datos[$i]["salarioDiario"];
        $fechainicioimss1=$datos[$i]["fechaAlta"];
        $fechainicioimssexplode = explode("-", $fechainicioimss1);
        $fechainicioimssanio = $fechainicioimssexplode[0];
        $fechainicioimssmes = $fechainicioimssexplode[1];
        $fechainicioimssdia = $fechainicioimssexplode[2];
        $FechaAltaImss = $fechainicioimssdia . "-" . $fechainicioimssmes . "-" . $fechainicioimssanio;

        $numempleadoooo=$datos[$i]["numempleado"];
        $fechaTerminoimss1=$datos[$i]["fechaBaja"];
        $fechaTerminoimssExplode = explode("-", $fechaTerminoimss1);
        $fechaTerminoimssanio = $fechaTerminoimssExplode[0];
        $fechaTerminoimssmes = $fechaTerminoimssExplode[1];
        $fechaTerminoimssdia = $fechaTerminoimssExplode[2];
        $FechaBajaImss = $fechaTerminoimssdia . "-" . $fechaTerminoimssmes . "-" . $fechaTerminoimssanio;

        $log->LogInfo("Valor de la variable salarioDiario:  " . var_export($salarioDiario, true));
        $log->LogInfo("Valor de la variable fechainicioimss1:  " . var_export($fechainicioimss1, true));
        $log->LogInfo("Valor de la variable fechaTerminoimss1:  " . var_export($fechaTerminoimss1, true));
        $log->LogInfo("Valor de la variable numempleadoooo:  " . var_export($numempleadoooo, true));

        $cuota                                     = bcdiv($cuotasinint, 1, 2); ////ESTO SERVIRA PARA CORTAR LA CUOTA POR QUE TRAE MAS DE DOS CIFRAS DESPUES DEL PUNTO DECIMAL
        $datos[$i]["descentidadtrabajo"]           = "" . $datos[$i]["nombreEntidadFederativa"] . "";
        $datos[$i]["numempleado"]                  = "" . $datos[$i]["numempleado"] . "<input class='input-small' type='hidden' id='hdnnumempleado" . $i . "'  value='" . $datos[$i]["numempleado"] . "'readonly>";
        $datos[$i]["fechaImss"]                    = "<input class='input-small' id='fechainicioimss" . $i . "'  value='" . $FechaAltaImss . "'readonly>";
        $datos[$i]["fechaBajaImss"]                = "<input class='input-small' id='fechabajaimss" . $i . "'  value='" . $FechaBajaImss . "'readonly>";
        $datos[$i]["prestamo"]                     = "<input class='input-mini' id='prestamo" . $i . "' value='" . $datos[$i]["prestamoFiniquito"] . "'readonly>";
        $datos[$i]["infonavit"]                    = "<input class='input-mini' id='infonavit" . $i . "' value='" . $datos[$i]["infonavitFiniquito"] . "'readonly>";
        $datos[$i]["fonacot"]                      = "<input class='input-mini' id='fonacot" . $i . "' value='" . $datos[$i]["fonacotFiniquito"] . "'readonly>";
        $datos[$i]["pension"]                      = "<input class='input-mini' id='pension" . $i . "' value='" . $datos[$i]["pensionFiniquito"] . "'readonly>";
        $datos[$i]["cuotaPagadaTurno"]             = "<input class='input-mini' id='cuotaint" . $i . "'  value='" . $cuota . "'readonly>";
        $datos[$i]["separacion"]                   = "<input class='input-mini' id='separacion" . $i . "' value='" . $datos[$i]["separacion"] . "'readonly>";
        $datos[$i]["piramidar"]                    = "<input class='input-mini' id='piramidar" . $i . "' value='" . $datos[$i]["piramidar"] . "'readonly>";
        $datos[$i]["diastrabenlaquincena"]         = "<input class='input-mini' id='diastrabajadosenrangodelaultimaquincenaint" . $i . "' value='" . $datos[$i]["diasTrabajados"] . "'readonly>";
        $datos[$i]["antiguedadtotal"]              = "<input class='input-mini' id='antiguedadtotal" . $i . "' value='" . $datos[$i]["antiguedadTotal"] . "'readonly>";
        $datos[$i]["diastrabajados"]               = "<input class='input-mini' id='diasparappdevacaciones" . $i . "'  value='" . $datos[$i]["diasParaPPVacaciones"] . "'readonly>";
        $datos[$i]["DiasVacConf"]                  = "<input class='input-mini' id='diasdevacaciones" . $i . "'  value='" . $datos[$i]["diasDeVacaciones"] . "'readonly>";
        $datos[$i]["proporcion_de_vacaciones"]     = "<input class='input-mini' id='propdevaccpnvert" . $i . "'  value='" . $datos[$i]["factorPropVacaciones"] . "'readonly>";
        $datos[$i]["CALCULO DIAS AGUINALDO"]       = "<input class='input-mini' id='calculodiasaguinaldo" . $i . "'  value='" . $datos[$i]["calculoDiasAguinaldo"] . "'readonly>";
        $datos[$i]["DIAS AGUINALDO"]               = "<input class='input-mini' id='diasdeaguinaldo" . $i . "'   value='" . $datos[$i]["factorDiasAguinaldo"] . "'readonly> ";
        $datos[$i]["propdevacaciones"]             = "<input class='input-mini' id='propvacaciones" . $i . "'  value='" . $datos[$i]["propVacaciones"] . "'readonly>";
        $datos[$i]["PRIMAVACACAIONALNETA"]         = "<input class='input-mini' id='primavacacionalnetaredondeada" . $i . "'  value='" . $datos[$i]["primaVacacionalNeta"] . "'readonly>";
        $datos[$i]["PpPrimaVacacionalPendiente1"]    = "<input class='input-mini' id='PpPrimaVacacionalPendiente1" . $i . "'  value='" . $datos[$i]["PpPrimaVacacionalPendiente"] . "'readonly>";
        $datos[$i]["PROPORCION NETA DE AGUINALDO"] = "<input class='input-mini' id='proporcionnetaaguinaldo" . $i . "' value='" . $datos[$i]["proporcionNetaAguinaldo"] . "'readonly>";
        $datos[$i]["diasdepago"]                   = "<input class='input-mini' id='diasdepago" . $i . "' value='" . $datos[$i]["diasDePago"] . "'readonly>";
        $datos[$i]["aumentoengratificacion"]       = "<input class='input-mini' id='aumentoengratificacion" . $i . "' value='" . $datos[$i]["aumentoGratificacion"] . "'readonly>";
        $datos[$i]["calculobruto"]                 = "<input class='input-mini' id='calculobruto" . $i . "' value='" . $datos[$i]["calculoBruto"] . "'readonly>";
        $datos[$i]["pagoneto"]                     = "<input class='input-mini' id='pagoneto" . $i . "' value='" . $datos[$i]["pagoNeto"] . "'readonly>";
        $datos[$i]["propVacacionesSA"]             = "<input class='input-mini' id='propvacacionessa" . $i . "' value='" . $datos[$i]["propVacacionesSA"] . "'readonly>";
        $datos[$i]["primaVacacionalSA"]            = "<input class='input-mini' id='primavacacionalsa" . $i . "' value='" . $datos[$i]["primaVacacionalSA"] . "'readonly>";
        $datos[$i]["propAginaldoSA"]               = "<input class='input-mini' id='propaguinaldosa" . $i . "' value='" . $datos[$i]["propAginaldoSA"] . "'readonly>";
        $datos[$i]["diasPagoSA"]                   = "<input class='input-mini' id='diaspagosa" . $i . "' value='" . $datos[$i]["diasPagoSA"] . "'readonly>";
        $datos[$i]["pagoNetoSA"]                   = "<input class='input-mini' id='pagonetosa" . $i . "' value='" . $datos[$i]["pagoNetoSA"] . "'readonly>";
        $datos[$i]["diferenciaGratificacionSA"]    = "<input class='input-mini' id='diferenciagratificacionsa" . $i . "' value='" . $datos[$i]["diferenciaGratificacionSA"] . "'readonly>";
        $datos[$i]["ingresoAcumulableSA"]          = "<input class='input-mini' id='ingresoacumulablesa" . $i . "' value='" . $datos[$i]["ingresoAcumulableSA"] . "'readonly>";
        $datos[$i]["limiteInferiorisr"]            = "<input class='input-mini' id='limiteinferiorisr" . $i . "' value='" . $datos[$i]["limiteInferiorisr"] . "'readonly>";
        $datos[$i]["excedenteLimiteSA"]            = "<input class='input-mini' id='excedenteLimitesa" . $i . "' value='" . $datos[$i]["excedenteLimiteSA"] . "'readonly>";
        $datos[$i]["tasaAplicable"]                = "<input class='input-mini' id='tasaaplicable" . $i . "' value='" . $datos[$i]["tasaAplicable"] . "'readonly>";
        $datos[$i]["resultado"]                    = "<input class='input-mini' id='resultado" . $i . "' value='" . $datos[$i]["resultado"] . "'readonly>";
        $datos[$i]["cuotaFija"]                    = "<input class='input-mini' id='cuotafija" . $i . "' value='" . $datos[$i]["cuotaFija"] . "'readonly>";
        $datos[$i]["isr"]                          = "<input class='input-mini' id='isr" . $i . "' value='" . $datos[$i]["isr"] . "'readonly>";
        $datos[$i]["netoAlPago"]                   = "<input class='input-mini' id='netoalpago" . $i . "' value='" . $datos[$i]["netoAlPago"] . "'readonly>";
        $datos[$i]["VacacionesPendientes"]         = "<input class='input-mini' id='netoalpago" . $i . "' value='" . $datos[$i]["VacacionesPendientes"] . "'readonly>";
        $datos[$i]["PrimaVacacionalPendiente"]     = "<input class='input-mini' id='netoalpago" . $i . "' value='" . $datos[$i]["PrimaVacacionalPendiente"] . "'readonly>";
        
        $datos[$i]["editar"]                       = "<img title='Editar' src='img/edit.png' class='cursorImg'   id='btnrditar' onclick='editar($i)'>
                                                      <img style='width: 34%' title='Guardar' src='img/save.png' class='cursorImg' id='btnguardar' onclick='guardar($i,$salarioDiario)'>";
        $datos[$i]["comprobacion"]="N.A";
        }
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
