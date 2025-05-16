<?php
require_once "../libs/logger/KLogger.php";
include_once '../simple/xlsxwriter.class.php';

if (!empty($_GET)) {
    $opcion = $_GET["option"];    
    $periodo = $_GET["periodo"];
    $conn   = mysqli_connect("localhost", "root", "Admin*gif", "zonacgg");
    mysqli_query($conn, "SET NAMES 'UTF8'");
    //$log = new KLogger ( "ajaxEmpleagosPrestamo.log" , KLogger::DEBUG );
    if ($opcion == '21') {
        $sql = "select concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) as numeroEmpleado,concat_ws(' ',e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado) as nombreEmpleado from finiquitos f LEFT JOIN empleados e ON (f.entidadEmpFiniquito=e.entidadFederativaId AND f.consecutivoEmpFiniquito=e.empleadoConsecutivoId AND f.categoriaEmpFiniquito=e.empleadoCategoriaId) WHERE f.estatusFiniquito=0 AND e.tipoPeriodo=".$periodo;
    } else if ($opcion == "31") {
        $sql = "select concat_ws('-',entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId) as numeroEmpleado,concat_ws(' ',apellidoPaterno,apellidoMaterno,nombreEmpleado) as nombreElemento FROM empleados WHERE (empleadoEstatusId=1 OR empleadoEstatusId=2) AND tipoPeriodo=".$periodo;
    }
    $result = mysqli_query($conn, $sql);
   // $log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
    if (mysqli_num_rows($result) > 0) {
        $filename = "empleados.xlsx";
        header('Content-disposition: attachment; filename="' . XLSXWriter::sanitize_filename($filename) . '"');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        //$log->LogInfo("Valor de la variable result: " . var_export ($result, true));
        $writer = new XLSXWriter();
        //$writer->writeSheetHeader('Sheet1', $header);
        // $writer->writeSheetHeader('hoja1', $header);
        $array = array();
        while ($row = mysqli_fetch_array($result)) {
            $array[0] = $row[0];
            $array[1] = $row[1];

            //$log->LogInfo("Valor de la variable reg: " . var_export ($reg, true));
            $writer->writeSheetRow('hoja1', $array);
        }        

        //$writer->writeSheet($array,'Sheet1', $header);//or write the whole sheet in 1 call

        $writer->writeToStdOut();
        //$writer->writeToFile('example.xlsx');
        //echo $writer->writeToString();
        exit(0);
    } else {
        echo ("<script type='text/javascript'>alert('No hay empleados para finiquito');setTimeout(function(){window.location='/zonacgg/Vista/usuarioLogeado.php';},2000);</script>");
    }
    //$log = new KLogger ( "ajaxDeudoresxlsx.log" , KLogger::DEBUG );

}
