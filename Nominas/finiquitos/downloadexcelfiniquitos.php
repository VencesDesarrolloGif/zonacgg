<?php
require_once "../../libs/logger/KLogger.php";
include_once '../../simple/xlsxwriter.class.php';

if (!empty($_GET)) {
    $opcion      = $_GET["option"];
    $fechainicio = $_GET["finicio"];
    $fechafin    = $_GET["ffin"];
    $periodo     = $_GET["periodo"];

    //$accion  = $_GET["accion"];
    $entidad = $_GET["entidad"];

     $conn = mysqli_connect("localhost", "root", "Admin*gif", "zonacgg");
    mysqli_query($conn, "SET NAMES 'UTF8'");
    //  $log = new KLogger("ajaxfiniquitoexcel.log", KLogger::DEBUG);

    $sql = "SELECT concat(empleados.entidadFederativaId,'-',empleados.empleadoConsecutivoId,'-',empleados.empleadoCategoriaId)AS numempleado,
                    concat(empleados.apellidoPaterno,' ',empleados.apellidoMaterno,' ',empleados.nombreEmpleado) AS nombreempleado,
                     catalogopuestos.descripcionPuesto,entidadesfederativas.nombreEntidadFederativa,datosimss.fechaImss,datosimss.fechaBajaImss,
                     finiquitos.prestamoFiniquito,finiquitos.infonavitFiniquito,finiquitos.fonacotFiniquito,finiquitos.pensionFiniquito,cuotas_empleados.cuotaDiariaEmpleado,
                    finiquitos.diasTrabajados, finiquitos.separacion, finiquitos.antiguedadTotal,
                     finiquitos.diasParaPPVacaciones, finiquitos.diasDeVacaciones,finiquitos.factorPropVacaciones, finiquitos.calculoDiasAguinaldo,
                      finiquitos.factorDiasAguinaldo, finiquitos.propVacaciones,
                     finiquitos.primaVacacionalNeta, finiquitos.proporcionNetaAguinaldo,finiquitos.diasDePago,
                     finiquitos.aumentoGratificacion, finiquitos.calculoBruto, finiquitos.pagoNeto,finiquitos.propVacacionesSA,finiquitos.primaVacacionalSA,
                     finiquitos.propAginaldoSA,finiquitos.diasPagoSA,finiquitos.pagoNetoSA,finiquitos.diferenciaGratificacionSA,finiquitos.ingresoAcumulableSA,finiquitos.limiteInferiorisr,
                     finiquitos.excedenteLimiteSA,finiquitos.tasaAplicable,finiquitos.resultado,finiquitos.cuotaFija,finiquitos.isr,finiquitos.netoAlPago
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
            ON empleados.idEntidadTrabajo=entidadesfederativas.idEntidadFederativa";

    if ($opcion == 0) {

        $sql .= " WHERE finiquitos.estatusFiniquito=0";

    } elseif ($opcion == 1) {
        $sql .= " where finiquitos.estatusFiniquito=1
            and datosimss.fechaBajaImss between '$fechainicio' and '$fechafin'
            and empleados.tipoPeriodo=$periodo";

    } /*else if ($opcion == 1 && $accion == 0) {
    $sql .= " where finiquitos.estatusFiniquito=1
    and datosimss.fechaBajaImss between '$fechainicio' and '$fechafin'
    and empleados.tipoPeriodo=$periodo
    and empleados.idEntidadTrabajo='$entidad'";
    } else if ($opcion == 0 && $accion == 0) {
    echo ("<script type='text/javascript'>alert('No hay empleados para descragar excel de finiquito');setTimeout(function(){window.location='/zonacgg/Vista/usuarioLogeado.php';},100);</script>");
    //echo ("<script type='text/javascript'>alert('$fechainicio');setTimeout(function(){window.location='/zonacgg/Vista/usuarioLogeado.php';},100);</script>");
    return 0;
    }*/
    // $log->LogInfo("Valor de la variable sql: " . var_export($sql, true));
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $filename = "finiquitos.xlsx";
        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $header = array(
            'NÚMERO DE EMPLEADO'             => 'string',
            'NOMBRE'                          => 'string',
            'PUESTO'                          => 'string',
            'ENTIDAD'                         => 'string',
            'FECHA INGRESO IMSS'              => 'string',
            'FECHA BAJA IMSS'                 => 'string',
            'PRESTAMO'                        => 'string',
            'INFONAVIT'                       => 'string',
            'FONACOT'                         => 'string',
            'PENSIÓN'                        => 'string',
            'CUOTA'                           => 'string',
            'DIAS TRABAJADOS'                 => 'string',
            'SEPARACIÓN'                     => 'string',
            'ANTIGÜEDAD TOTAL'               => 'string',
            'DIAS PARA PP DE VACACIONES'      => 'string',
            'DIAS DE VACACIONES'              => 'string',
            'F.PROPORCION DE VACACIONES'      => 'string',
            'CALCULO DIAS AGUINALDO'          => 'string',
            'DIAS DE AGUINALDO'               => 'string',
            'PROPORCION DE VACACIONES'        => 'string',
            'PRIMA VACACIONAL NETA'           => 'string',
            'PROPORCION NETA AGUINALDO'       => 'string',
            'DIAS DE PAGO'                    => 'string',
            'AUMENTO EN GRATIFICACION'        => 'string',
            'CALCULO BRUTO'                   => 'string',
            'PAGO NETO'                       => 'string',
            'PROPORCION VACACIONES $'         => 'string',
            'PRIMA VACACIONAL $'              => 'string',
            'PROPORCION AGUINALDO $'          => 'string',
            'DIAS DE PAGO $'                  => 'string',
            'PAGO NETO 3'                     => 'string',
            'DIFERENCIA A GRATIFICACION'      => 'string',
            'INGRESOS ACUMULABLES'            => 'string',
            'LIMITE INFERIOR'                 => 'string',
            'EXCEDENTE SOBRE LIMITE INFERIOR' => 'string',
            'TASA APLICABLE DEL LIMITE'       => 'string',
            'RESULTADO'                       => 'string',
            'CUOTA FIJA'                      => 'string',
            'ISR'                             => 'string',
            'NETO AL PAGO'                    => 'string',

        );

        //$log->LogInfo("Valor de la variable result: " . var_export ($result, true));
        $writer = new XLSXWriter();
        //$writer->writeSheetHeader('Sheet1', $header);
        $writer->writeSheetHeader('hoja1', $header);
        $array = array();
        while ($row = mysqli_fetch_array($result)) {
            $array[0]  = $row[0];
            $array[1]  = $row[1];
            $array[2]  = $row[2];
            $array[3]  = $row[3];
            $array[4]  = $row[4];
            $array[5]  = $row[5];
            $array[6]  = $row[6];
            $array[7]  = $row[7];
            $array[8]  = $row[8];
            $array[9]  = $row[9];
            $array[10] = $row[10];
            $array[11] = $row[11];
            $array[12] = $row[12];
            $array[13] = $row[13];
            $array[14] = $row[14];
            $array[15] = $row[15];
            $array[16] = $row[16];
            $array[17] = $row[17];
            $array[18] = $row[18];
            $array[19] = $row[19];
            $array[20] = $row[20];
            $array[21] = $row[21];
            $array[22] = $row[22];
            $array[23] = $row[23];
            $array[24] = $row[24];
            $array[25] = $row[25];
            $array[26] = $row[26];
            $array[27] = $row[27];
            $array[28] = $row[28];
            $array[29] = $row[29];
            $array[30] = $row[30];
            $array[31] = $row[31];
            $array[32] = $row[32];
            $array[33] = $row[33];
            $array[34] = $row[34];
            $array[35] = $row[35];
            $array[36] = $row[36];
            $array[37] = $row[37];
            $array[38] = $row[38];
            $array[39] = $row[39];

            //$log->LogInfo("Valor de la variable reg: " . var_export ($reg, true));
            $writer->writeSheetRow('hoja1', $array);
        }
        ;
        //$writer->writeSheet($array,'Sheet1', $header);//or write the whole sheet in 1 call
        $writer->writeToStdOut();
        //$writer->writeToFile('example.xlsx');
        //echo $writer->writeToString();
        exit(0);
    } else {
        echo ("<script type='text/javascript'>alert('No hay empleados para finiquito');setTimeout(function(){window.location='/zonacgg/Vista/usuarioLogeado.php';},100);</script>");
        //echo ("<script type='text/javascript'>alert('$fechainicio');setTimeout(function(){window.location='/zonacgg/Vista/usuarioLogeado.php';},100);</script>");
    }
//$log = new KLogger ( "ajaxDeudoresxlsx.log" , KLogger::DEBUG );
}
