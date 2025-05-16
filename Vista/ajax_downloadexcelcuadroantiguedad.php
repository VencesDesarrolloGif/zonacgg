<?php

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
include_once '../simple/xlsxwriter.class.php';

if (!empty($_GET)) {

    $fechainicio = $_GET["finicio"];
    $fechafin    = $_GET["ffin"];

    $conn = mysqli_connect("localhost", "root", "Admin*gif", "zonacgg");
    mysqli_query($conn, "SET NAMES 'UTF8'");
    // $log = new KLogger("AJAX_DOWNLOADeXCEL.log", KLogger::DEBUG);

    $sql = " SELECT concat_ws('-',di.empladoEntidadImss, di.empleadoConsecutivoImss, di.empleadoCategoriaImss) as numeroEmpleadoC,
                concat_ws(' ', e.apellidoPaterno, e.apellidoMaterno, e.nombreEmpleado) as nombreCompletoC,
                di.fechaImss, di.salarioDiario ,datediff(now(), di.fechaImss) as diasTranscurridos, e.empleadoNumeroSeguroSocial,
                di.salarioDiario, di.registroPatronal, cee.descripcionEstatusEmpleado,   hmi.fechaBaja,hmi.fechaAlta,cm.descMovimientoImss, hmi.fechaMovimiento,hmi.registroMovimiento,hmi.sdiMovimiento,hmi.FIntegracionMovimiento,hmi.SBCMovimiento,hmi.usuarioEdicion,di.empleadoEstatusImss,cc.razonSocial,hmi.loteImss
               from datosimss di
                left join empleados e on (di.empladoEntidadImss=e.entidadFederativaId and
                di.empleadoConsecutivoImss=e.empleadoConsecutivoId
                and di.empleadoCategoriaImss=e.empleadoCategoriaId)
                left join catalogoestatusempleados cee on  (cee.estatusEmpleadoId=e.empleadoEstatusId)
                LEFT JOIN historicomovimientosimss hmi
                ON(e.entidadFederativaId=hmi.empEntidadMovimiento and e.empleadoConsecutivoId=hmi.EmpConsecutivoMovimiento And e.empleadoCategoriaId=hmi.empCategoriaMovimiento)
                left join catalogo_movimientosimss cm
                on(hmi.tipoMovimiento=cm.idTipoMovimiento)
                left join catalogopuntosservicios cps
                on(e.empleadoIdPuntoServicio=cps.idPuntoServicio)
                left join catalogoclientes cc
                on(cps.idClientePunto=cc.idCliente)
                where di.fechaImss between '$fechainicio' AND '$fechafin'
                AND hmi.estatusmov=1";

    $result = mysqli_query($conn, $sql);
//$log->LogInfo("Valor de la variable result: " . var_export ($result, true));

    if (mysqli_num_rows($result) > 0) {
        $filename = "Historico_CuadroAntiguedad.xlsx";
        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $header = array(
            'NÚMERO DE EMPLEADO'      => 'string',
            'NOMBRE'                   => 'string',
            'ESTATUS'                  => 'string',
            'REGISTRO PATRONAL'        => 'string',
            'FECHA INGRESO'            => 'string',
            'FECHA BAJA'               => 'string',
            'DESCRIPCIÓN MOVIMIENTO'  => 'string',
            'FECHA DE MOVIMIENTO'      => 'string',
            'USUARIO MOVIMIENTO'       => 'string',
            'IMSS'                     => 'string',
            'SALARIO DIARIO'           => 'string',
            'PRIMA VACACIONAL'         => 'string',
            'FACTOR INTEGRACION'       => 'string',
            'SALARIO BASE COTIZACIÓN' => 'string',
            'CLIENTE'                  => 'string',
            'LOTE IMSS'                => 'string',

        );

        //$log->LogInfo("Valor de la variable result: " . var_export ($result, true));
        $writer = new XLSXWriter();
        //$writer->writeSheetHeader('Sheet1', $header);
        $writer->writeSheetHeader('hoja1', $header);
        $array     = array();
        $array1    = array();
        $aguinaldo = 15 / 365;
        $unidad    = 1;

        while ($row = mysqli_fetch_array($result)) {
            $array[0]  = $row[0];
            $array[1]  = $row[1];
            $array[2]  = $row[8];
            $array[3]  = $row[13];
            $array[4]  = $row[10];
            $array[5]  = $row[9];
            $array[6]  = $row[11];
            $array[7]  = $row[12];
            $array[8]  = $row[17];
            $array[9]  = $row[5];
            $array[10] = $row[14];

            $array1[0] = $row[4]; //ARRAY1 QUE TOMA DIAS TRABAJADOS PARA EL CALCULO DE PRIMAVACACIONAL
            //CONDICIONES PARA SABER QUE PORCENTAJE DE PRIMA VACACIONAL LE CORRESPONDE AL EMPLEADO SIRVE SOLO PARA IMPRIMIRLO EN EL EXCEL
            if ($array1[0] <= 365) {
                $array[11] = 1.5; //primavacacional

            } elseif ($array1[0] >= 366 and $array1[0] <= 730) {

                $array[11] = 2;

            } elseif ($array1[0] >= 731 and $array1[0] <= 1095) {

                $array[11] = 2.5;
            } elseif ($array1[0] >= 1096 and $array1[0] <= 1460) {

                $array[11] = 3;

            } elseif ($array1[0] >= 1461 and $array1[0] <= 1825) {

                $array[11] = 3.5;

            } elseif ($array1[0] >= 1826 and $array1[0] <= 3650) {

                $array[11] = 3.5;

            } elseif ($array1[0] >= 1827 and $array1[0] <= 5475) {

                $array[11] = 4;
            }
            $array[12] = $row[15];

            $array[13] = $row[16]; //salario base cotizacion
            $array[14] = $row[19];
            $array[15] = $row[20];
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //$log->LogInfo("Valor de la variable row: " . var_export($array[0], true));
            $writer->writeSheetRow('hoja1', $array);

        }
        ;
        //$writer->writeSheet($array,'Sheet1', $header);//or write the whole sheet in 1 call
        $writer->writeToStdOut();
        //$writer->writeToFile('example.xlsx');
        //echo $writer->writeToString();
        exit(0);
    } else {
        //echo ("<script type='text/javascript'>alert('No hay empleados para finiquito');setTimeout(function(){window.location='/zonagif/Vista/usuarioLogeado.php';},100);</script>");
        //echo ("<script type='text/javascript'>alert('$fechainicio');setTimeout(function(){window.location='/zonagif/Vista/usuarioLogeado.php';},100);</script>");
    }
//$log = new KLogger ( "ajaxDeudoresxlsx.log" , KLogger::DEBUG );
}
