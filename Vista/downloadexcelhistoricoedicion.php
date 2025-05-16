<?php
session_start();

require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
require_once "../libs/Classes/PHPExcel.php";
require_once "conexion.php";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Historico_edicion.xls"');
header('Cache-Control: max-age=0');
$usuario = $_SESSION ["userLog"]["rol"];
$negocio = new Negocio ();
?>
<html>
<head>
    <meta http-equiv="content-type" content="application/vnd.ms-excel;" charset="UTF-8">
<meta charset="UTF-8">
  <title>Historico Edicion</title>
  <style type="text/css">
    .text{
  mso-number-format:"\@";/*force text*/
    }
  </style>
</head>
<body>
<table  border='1' class='table table-bordered' id='HistoricoEdicion' name='HistoricoEdicion'>
    <thead>
        <th>Número Empleado</th><th>Fecha Edición</th><th>Fecha Confirmación</th><th>N° De Cuenta</th><th>N° De Cuenta Clabe</th><th>Banco</th>
        <th>Correo</th><th>Periodo</th><th>Fecha Baja</th><th>Fecha De Reingreso</th>
    </thead>
<tbody>

<?php

    $datos= array();
 // $log = new KLogger ( "downloadexcelhistorico.log" , KLogger::DEBUG );
     // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($movimiento, true));  
  $sql = "SELECT concat_ws('-',emp.entidadFederativaEmpleadoEdited,emp.consecutivoEmpleadoEdited,emp.categoriaEmpleadoEdited) 
                     numeroempleado,emp.empleadoFechaCapturaE,emp.idEdicion,
                     emp.empleadoNumeroCtaE,emp.empleadoNumeroCtaClabeE,dir.correoEmpleadoEdited,catperi.descripcionTipoPeriodo,emp.status_checked,
                     emp.empleadoFechaIngresoE,emp.empleadoFechaBajaE,emp.empleadoEstatusIdE,fechaConfirmacion
                     from empleadosedited emp  
                     left join directorioedited dir
                     on emp.idEdicion=dir.idEdicion
                     left join catalogotipoperiodo catperi
                     on catperi.tipoPeriodoId = emp.idtipoperiodo";

                if($usuario==="Contrataciones"){
                    $sql .=" where emp.status_checked='0'";

                }else if($usuario==="Analista Asistencia"){
                        $sql .=" where emp.status_checked='1'";
                    }


//  $log->LogInfo("Valor de la variable sql:  " . var_export($sql, true)); 
    $res = mysqli_query($conexion,$sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))) {
        $datos[] = $reg;}
  
    for ($i = 0; $i < count($datos); $i++) {

        $numeroempleado  = $datos[$i]["numeroempleado"];
        $empleadoFechaCapturaE          = utf8_decode($datos[$i]["empleadoFechaCapturaE"]);
        $empleadoNumeroCtaE          = utf8_decode($datos[$i]["empleadoNumeroCtaE"]);
        $cuentaclabestr     = $datos[$i]["empleadoNumeroCtaClabeE"];
        $cuentaclabe=substr($cuentaclabestr,0,3);
        $tipobanco = $negocio->negocio_obtenercuentaclabeybanco($cuentaclabe,1);// se le manda 1 ya que solo utilizaremos el banco
            if(count($tipobanco)!=1){
                $datos[$i]["banco"]=$tipobanco["bancos"]["nombreBanco"];
            }else
            {
            $datos[$i]["banco"]="No existe Banco";}
        $descripcionBanco=  utf8_decode($datos[$i]["banco"]);
        $correoEmpleadoEdited    = utf8_decode($datos[$i]["correoEmpleadoEdited"]);
        $descripcionTipoPeriodo = utf8_decode($datos[$i]["descripcionTipoPeriodo"]);
        $empleadoFechaBajaE       = utf8_decode($datos[$i]["empleadoFechaBajaE"]);
        $empleadoFechaIngresoE       = utf8_decode($datos[$i]["empleadoFechaIngresoE"]);

        if ($datos[$i]["empleadoEstatusIdE"]==0){
                $empleadoFechaBajaE =$datos[$i]["empleadoFechaBajaE"];
            }else if ($datos[$i]["empleadoEstatusIdE"]==2){
                $empleadoFechaBajaE      = "Reingreso";
            }else if ($datos[$i]["empleadoEstatusIdE"]==1){
                $empleadoFechaBajaE      = "activo";
            }
            if ($datos[$i]["empleadoEstatusIdE"]==0){
                $empleadoFechaIngresoE=" Baja";
            }else if ($datos[$i]["empleadoEstatusIdE"]==2){
                $empleadoFechaIngresoE=$datos[$i]["empleadoFechaIngresoE"];
            }else if ($datos[$i]["empleadoEstatusIdE"]==1){
                $empleadoFechaIngresoE     = "activo";
            }

if($_SESSION ["userLog"]["rol"]==="Analista Asistencia"){
                    $fechaconfirmacion=$datos[$i]['fechaConfirmacion'];
            }else{$fechaconfirmacion="";}



        echo ("<tr><td class='text'>" . $numeroempleado . "</td><td class='text'>" . $empleadoFechaCapturaE . "</td>   <td class='text'>" . $fechaconfirmacion . "</td><td class='text'>" . $empleadoNumeroCtaE . "</td>");
        echo ("<td class='text'>" . $cuentaclabestr . "</td><td class='text'>" . $descripcionBanco . "</td><td class='text'>" . $correoEmpleadoEdited . "</td>");
        echo ("<td class='text'>" . $descripcionTipoPeriodo . "</td><td class='text'>" . $empleadoFechaBajaE . "</td><td class='text'>" . $empleadoFechaIngresoE . "</td>");


    }


?>
</tbody></table>
</body>
</html>