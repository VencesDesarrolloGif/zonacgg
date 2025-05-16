<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
//$log = new KLogger("ajaxfiniquitos.log", KLogger::DEBUG);
$response            = array();
$response["status"]  = "error";
$datos               = array();
$fechainicio         = $_POST["fechainicio"];
$fechafin            = $_POST["fechafin"];
$fechafin            = $_POST["fechafin"];
$selperiodofiniquito = $_POST["selperiodofiniquito"];
$entidad             = $_POST["entidad"];
$LineaNegocio        = $_POST["LineaNegocio"];
$rol                 = $_POST["rol"];
try {   
    $sql = " SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
        concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
        catalogopuestos.descripcionPuesto,entidadesfederativas.nombreEntidadFederativa,datosimss.fechaImss,datosimss.fechaBajaImss,finiquitos.fechaAlta,finiquitos.fechaBaja,finiquitos.prestamoFiniquito,finiquitos.infonavitFiniquito,finiquitos.fonacotFiniquito,finiquitos.pensionFiniquito,cuotas_empleados.cuotaDiariaEmpleado,finiquitos.diasTrabajados, finiquitos.separacion, finiquitos.piramidar, finiquitos.antiguedadTotal,finiquitos.diasParaPPVacaciones, finiquitos.diasDeVacaciones,finiquitos.factorPropVacaciones, finiquitos.calculoDiasAguinaldo,finiquitos.factorDiasAguinaldo, finiquitos.propVacaciones,finiquitos.primaVacacionalNeta, finiquitos.proporcionNetaAguinaldo,finiquitos.diasDePago,finiquitos.aumentoGratificacion, finiquitos.calculoBruto, finiquitos.pagoNeto,finiquitos.propVacacionesSA,finiquitos.primaVacacionalSA,finiquitos.propAginaldoSA,finiquitos.diasPagoSA,finiquitos.pagoNetoSA,finiquitos.diferenciaGratificacionSA,finiquitos.ingresoAcumulableSA,finiquitos.limiteInferiorisr,finiquitos.excedenteLimiteSA,finiquitos.tasaAplicable,finiquitos.resultado,finiquitos.cuotaFija,finiquitos.isr,finiquitos.netoAlPago,finiquitos.estatusCargaArchivo,finiquitos.VacacionesPendientes,finiquitos.PrimaVacacionalPendiente,finiquitos.uniformesFiniquito,
            finiquitos.PpPrimaVacacionalPendiente
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
        LEFT JOIN entidadesfederativas
        ON empleados.idEntidadTrabajo=entidadesfederativas.idEntidadFederativa
        where finiquitos.estatusFiniquito=1
        and empleados.tipoPeriodo='$selperiodofiniquito'
        and ((finiquitos.fechaBaja between '$fechainicio' and '$fechafin')";
        if ($rol == "Lider Unidad"){
            $sql.=") and";
            $entidades = explode(",", $entidad);
            $lineasdenegocio = explode(",", $LineaNegocio);
            for($j=0;$j<count($lineasdenegocio);$j++){
                if(!is_array($lineasdenegocio)){
                    $lineanegocioconsulta=$lineasdenegocio;
                }else{
                    $lineanegocioconsulta=$lineasdenegocio[$j];
                } 
                for($i=0;$i<count($entidades);$i++){
                    if(!is_array($entidades)){
                        $entidadparaconsulta=$entidades;
                    }else{
                        $entidadparaconsulta=$entidades[$i];
                    }
                    if(($i==0) && ($j==0)){
                        $sql.=" ((empleados.empleadoLineaNegocioId='$lineanegocioconsulta' and empleados.idEntidadTrabajo='$entidadparaconsulta')";  
                    }else{
                        $sql.=" or (empleados.empleadoLineaNegocioId='$lineanegocioconsulta' and empleados.idEntidadTrabajo='$entidadparaconsulta')";       
                    }
                }
            }
        }
        $sql.=") order by numempleado";
        //$log->LogInfo("Valor desql: " . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;}
    for ($i = 0; $i < count($datos); $i++) {
        $estatuscargaarchuivo=$datos[$i]["cuotaDiariaEmpleado"];
        $prestamoFiniquito=$datos[$i]["prestamoFiniquito"];
        $uniformesFiniquito=$datos[$i]["uniformesFiniquito"];
        $TotalPrestamo = $prestamoFiniquito + $uniformesFiniquito;

        $cuotasinint                     = $datos[$i]["cuotaDiariaEmpleado"];
        $cuota                           = bcdiv($cuotasinint, 1, 2); ////ESTO SERVIRA PARA CORTAR LA CUOTA POR QUE TRAE MAS DE DOS CIFRAS DESPUES DEL PUNTO DECIMAL
        $datos[$i]["descentidadtrabajo"] = "" . $datos[$i]["nombreEntidadFederativa"] . "";
        $datos[$i]["numempleado"]        = "" . $datos[$i]["numempleado"] . "";
        $datos[$i]["fechaBajaImss"]      = "" . $datos[$i]["fechaBaja"] . "";
        $datos[$i]["fechaImss"]          = "" . $datos[$i]["fechaAlta"] . "";
        $datos[$i]["prestamo"]                     = $TotalPrestamo;
        $datos[$i]["infonavit"]                    = "" . $datos[$i]["infonavitFiniquito"] . "";
        $datos[$i]["fonacot"]                      = "" . $datos[$i]["fonacotFiniquito"] . "";
        $datos[$i]["pension"]                      = "" . $datos[$i]["pensionFiniquito"] . "";
        $datos[$i]["cuotaPagadaTurno"]             = "" . $cuota . "";
        $datos[$i]["separacion"]                   = "" . $datos[$i]["separacion"] . "";
        $datos[$i]["piramidar"]                    = "" . $datos[$i]["piramidar"] . "";
        $datos[$i]["diastrabenlaquincena"]         = "" . $datos[$i]["diasTrabajados"] . "";
        $datos[$i]["antiguedadtotal"]              = "" . $datos[$i]["antiguedadTotal"] . "";
        $datos[$i]["diastrabajados"]               = "" . $datos[$i]["diasParaPPVacaciones"] . "";
        $datos[$i]["DiasVacConf"]                  = "" . $datos[$i]["diasDeVacaciones"] . "";
        $datos[$i]["proporcion_de_vacaciones"]     = "" . $datos[$i]["factorPropVacaciones"] . "";
        $datos[$i]["CALCULO DIAS AGUINALDO"]       = "" . $datos[$i]["calculoDiasAguinaldo"] . "";
        $datos[$i]["DIAS AGUINALDO"]               = "" . $datos[$i]["factorDiasAguinaldo"] . "";
        $datos[$i]["propdevacaciones"]             = "" . $datos[$i]["propVacaciones"] . "";
        $datos[$i]["PRIMAVACACAIONALNETA"]         = "" . $datos[$i]["primaVacacionalNeta"] . "";
        $datos[$i]["PROPORCION NETA DE AGUINALDO"] = "" . $datos[$i]["proporcionNetaAguinaldo"] . "";
        $datos[$i]["diasdepago"]                   = "" . $datos[$i]["diasDePago"] . "";
        $datos[$i]["aumentoengratificacion"]       = "" . $datos[$i]["aumentoGratificacion"] . "";
        $datos[$i]["calculobruto"]                 = "" . $datos[$i]["calculoBruto"] . "";
        $datos[$i]["netoAlPago"]                  = "" . round($datos[$i]["netoAlPago"]) . "";
        $datos[$i]["PpPrimaVacacionalPendiente1"]    = "<input class='input-mini' id='PpPrimaVacacionalPendiente1" . $i . "'  value='" . $datos[$i]["PpPrimaVacacionalPendiente"] . "'readonly>";
        $datos[$i]["DiasVacacionesPendiente1"]   = "<input class='input-mini' id='DiasVacacionesPendiente1" . $i . "'  value='" . $datos[$i]["VacacionesPendientes"] . "'readonly>";
        $datos[$i]["pagoneto"]                     = "" . $datos[$i]["pagoNeto"] . "";
        $datos[$i]["editar"]                       = "<i  title='Generar pdf' class='fa fa-file-pdf-o' style='font-size:23px;color:red'    id='btnconfirmar' onclick='reimprimirpdf(\"" . $datos[$i]['numempleado'] . "\",\"" . $datos[$i]['fechaBajaImss'] . "\",\"" . $datos[$i]['fechaImss'] . "\")'></i>";
if($cuotasinint ==0){
        $datos[$i]["comprobacion"]= " <form enctype='multipart/form-data'  name='firmafiniquito" . $i . "'  id='firmafiniquito" . $i . "'>
            <label class='control-label label' for='firmafiniquito" . $i . "[]'>Selecciona archivo: </label>
          <span class='btn btn-success btn-file' >Examinar
            <input type='file' class='btn-success' id='firmafiniquito" . $i . "' name='firmafiniquito" . $i . "[]' multiple='' accept='.pdf' /> 
          </span>
          <button type='button' class='btn btn-primary' onclick='uploadfiniquitofirmado(\"" . $datos[$i]['numempleado'] . "\",\"" . $datos[$i]['fechaBajaImss'] . "\",\"" . $datos[$i]['fechaImss'] . "\",\"" . $i . "\")'>Cargar</button></form>";
      }else {

        $datos[$i]["comprobacion"]= "COMPROBADO";
      }
    }
   // $log->LogInfo("Valor de la variable i:  " . var_export($i, true));
    $response["status"] = "success";
    $response["datos"]  = $datos;
} catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);



