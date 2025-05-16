<?php
session_start();

require_once ("../../libs/logger/KLogger.php");
require "../conexion.php";
require_once ("../../libs/Classes/PHPExcel.php");

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// $log = new KLogger ( "consultaGeneralEmpleadosPorFechas.log" , KLogger::DEBUG );
// $->LogInfo("Valor de la variable post " . var_export ($_POST, true));
// $log->LogInfo("Valor de la variable get " . var_export ($_GET, true));
?>
<html>
<head>
  <title>Mi primera página con estilo</title>
  <style type="text/css">
    .text{
  mso-number-format:"\@";/*force text*/
    }
  </style>
</head>
<body>

<table border='1' class='table table-bordered' id='reporteGeneralExport' name='reporteGeneralExport'><thead><th>#Empleado</th><th>apellidoPaterno</th><th>apellidoMaterno</th><th>Nombre</th><th>fechaIngreso</th><th>fechaBaja</th><th>Puesto</th><th>TipoPuesto</th><th>TipoTurno</th><th>Rol Operativo</th><th>Entidad Laboral</th><th>Punto Servicio</th><th>IdPlantilla</th><th>Cliente</th><th>Sexo</th><th>EstatusEmpleado</th><th>#Supervisor</th><th>Nombre Supervisor</th><th>Region</th><th>Gerente Regional</th><th>Linea Negocio Empleado</th></thead><tbody>

<?php
$FechaInicialReportePorFechas=$_GET["FechaInicialReportePorFechas"];
$FechaFinalReportePorFechas=$_GET["FechaFinalReportePorFechas"];

$sql = "SELECT concat_ws('-',e.entidadFederativaId,e.empleadoConsecutivoId,e.empleadoCategoriaId) as numeroEmpleado,e.apellidoPaterno,e.apellidoMaterno,e.nombreEmpleado,e.fechaIngresoEmpleado as fechaIngreso,e.fechaBajaEmpleado as fechaBaja, cp.descripcionPuesto as Puesto,ctp.descripcionCategoria as TipoPuesto,ct.descripcionTurno as TipoTurno,e.roloperativo as RolOperativo,el.nombreEntidadFederativa as entidadLaboral,cps.puntoServicio,cac.razonSocial as cliente,cg.descripcionGenero as Sexo,cee.descripcionEstatusEmpleado as EstatusEmpleado,concat_ws('-',r.entidadFederativaId,r.empleadoConsecutivoId,r.empleadoCategoriaId) as numeroSupervisor,concat_ws(' ',r.apellidoPaterno,r.apellidoMaterno,r.nombreEmpleado) as nombreSupervisor,reg.DescripcionI as Region,pl.requisicionId as plantillaId,ln.descripcionLineaNegocio as lineanegocio
    FROM empleados e 
    left join catalogopuestos cp on (e.empleadoIdPuesto=cp.idPuesto)
    left join catalogolineanegocio ln on (e.empleadoLineaNegocioId=ln.idLineaNegocio)
    left join catalogocategoriastipopuestos ctp on (e.idTipoPuesto=ctp.idCategoria)
    left join catalogoturnos ct on (e.empleadoIdTurno=ct.idTipoTurno)
    left join entidadesfederativas el ON (e.idEntidadTrabajo = el.idEntidadFederativa)
    left join catalogopuntosservicios cps on (cps.idPuntoServicio=e.empleadoIdPuntoServicio)
    left join catalogoclientes cac on (cps.idClientePunto=cac.idCliente)
    left join catalogogenero cg ON (e.empleadoIdGenero = cg.idGenero)
    left join catalogoestatusempleados cee ON (e.empleadoEstatusId = cee.estatusEmpleadoId)
    left join empleados r on (r.entidadFederativaId=e.idEntidadResponsableAsistencia and r.empleadoConsecutivoId=e.consecutivoResponsableAsistencia and r.empleadoCategoriaId=e.tipoResponsableAsistencia)
    left join index_regiones reg ON (e.idEntidadTrabajo = reg.idEntidadI and e.empleadoLineaNegocioId=reg.idLineaNegI)
    left join plantilla pl on (pl.empleadoEntidadPlantilla=e.entidadFederativaId and pl.empleadoConsecutivoPlantilla=e.empleadoConsecutivoId and pl.empleadoCategoriaPlantilla=e.empleadoCategoriaId)
    where ((e.empleadoEstatusId=1 or e.empleadoEstatusId=2) or
        (e.empleadoEstatusId=0 and e.fechaBajaEmpleado between CAST('$FechaInicialReportePorFechas' AS DATE) and CAST('$FechaFinalReportePorFechas' AS DATE)))
    order by numeroEmpleado;";   
$res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $empleados[] = $reg;
    }
$sql1 = "SELECT concat_ws(' ',usuarios.apellidoPaterno,usuarios.apellidoMaterno,usuarios.nombre) as NombreGerente,DescripcionI
    from usuarios
    left join entidadesusuario on (usuarios.usuarioId=entidadesusuario.idUsuarioEnt)
    left join index_regiones on (index_regiones.idEntidadI=entidadesusuario.idEntidadEnt and index_regiones.idLineaNegI='1')
    LEFT JOIN usuario_empleado usremp on (usuarios.usuario=usremp.usuario)
    left join empleados emp on (usremp.entidadEmpleadoUsuario=emp.entidadFederativaId and usremp.consecutivoEmpleadoUsuario=emp.empleadoConsecutivoId and usremp.categoriaEmpleadoUsuario=emp.empleadoCategoriaId)
    where usuarioRolId='38'
    and emp.empleadoEstatusId!=0
    and idUsuarioEnt is not null";   
        $res1 = mysqli_query($conexion, $sql1);
        while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
            $regional[] = $reg1;
        }
        for ($i = 0; $i < count($empleados); $i++)
        {   
            $numeroEmpleado = $empleados[$i] ["numeroEmpleado"];
            $apellidoPaterno= utf8_decode($empleados[$i] ["apellidoPaterno"]);
            $apellidoMaterno= utf8_decode($empleados[$i] ["apellidoMaterno"]);
            $nombreEmpleado = utf8_decode($empleados[$i] ["nombreEmpleado"]);
            $fechaIngreso = $empleados[$i] ["fechaIngreso"];
            $fechaBaja = $empleados[$i] ["fechaBaja"];
            $Puesto = $empleados[$i] ["Puesto"];
            $TipoPuesto= $empleados[$i]["TipoPuesto"];
            $TipoTurno = $empleados[$i] ["TipoTurno"];
            $RolOperativo = $empleados[$i] ["RolOperativo"];
            $entidadLaboral=utf8_decode(strtoupper($empleados[$i]["entidadLaboral"]));
            $puntoServicio = utf8_decode($empleados[$i] ["puntoServicio"]);
            $plantillaId = $empleados[$i] ["plantillaId"];
            $nombreCliente = utf8_decode($empleados[$i] ["cliente"]);
            $Sexo = $empleados[$i] ["Sexo"];            
            $EstatusEmpleado = $empleados[$i] ["EstatusEmpleado"];
            $numeroSupervisor = $empleados[$i] ["numeroSupervisor"];
            $nombreSupervisor = $empleados[$i] ["nombreSupervisor"];
            $Region = $empleados[$i] ["Region"];
            $lineanegocio = $empleados[$i] ["lineanegocio"];
            for ($j = 0; $j < count($regional); $j++)
            {
                $RegionRegional = $regional[$j]["DescripcionI"];
                if($RegionRegional==$Region){
                    $Regional = $regional[$j]["NombreGerente"];
                    $j = count($regional);       
                }else{
                    $Regional = "Sin Regional";
                }
            }

            echo("<tr><td>".$numeroEmpleado."</td><td>".$apellidoPaterno."</td><td>".$apellidoMaterno."</td><td>".$nombreEmpleado."</td><td>".$fechaIngreso."</td><td>".$fechaBaja."</td><td>".$Puesto."</td><td>".$TipoPuesto."</td><td>".$TipoTurno."</td><td>".$RolOperativo."</td><td>".$entidadLaboral."</td><td>".$puntoServicio."</td><td>".$plantillaId."</td><td>".$nombreCliente."</td><td>".$Sexo."</td><td>".$EstatusEmpleado."</td><td>".$numeroSupervisor."</td><td>".$nombreSupervisor."</td><td>".$Region."</td><td>".$Regional."</td><td>".$lineanegocio."</td></tr>");
        }

?>

</tbody></table>
</body>
</html>