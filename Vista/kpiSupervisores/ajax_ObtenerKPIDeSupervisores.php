<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
require_once ("../../Negocio/Negocio.class.php");
require_once ("../Helpers.php");
$negocio = new Negocio ();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
// $log = new KLogger ( "ajax_ObtenerKPIDeSupervisores.log" , KLogger::DEBUG );
try{
    $usuarioid=$_SESSION["userLog"]["usuario"];
    $fechasAsistenciaSupervisores=$_POST["fechasAsistenciaSupervisores"];
    $datos = [];

    $supervisorQuery = " SELECT concat_ws('-',usuario_empleado.entidadEmpleadoUsuario,usuario_empleado.consecutivoEmpleadoUsuario,usuario_empleado.categoriaEmpleadoUsuario) as NumEmpleado,
                                concat_ws(' ',empleados.nombreEmpleado,empleados.apellidoPaterno,empleados.apellidoMaterno) as NombreEmpleado 
                         FROM usuario_empleado
                         LEFT JOIN empleados ON (usuario_empleado.entidadEmpleadoUsuario = empleados.entidadFederativaId AND usuario_empleado.consecutivoEmpleadoUsuario=empleados.empleadoConsecutivoId AND usuario_empleado.categoriaEmpleadoUsuario = empleados.empleadoCategoriaId)
                         WHERE usuario_empleado.usuario='$usuarioid'";
    $res1 = mysqli_query($conexion, $supervisorQuery);
    $supervisores = [];
    while ($reg1 = mysqli_fetch_assoc($res1)) {
        $supervisores[] = $reg1;
    }
    $NumEmpleado   = $supervisores[0]["NumEmpleado"];
    $NombreEmpleado= $supervisores[0]["NombreEmpleado"];
    $datos["numero"] = $NumEmpleado;
    $datos["nombre"] = $NombreEmpleado;

    for($i = 0; $i < count($fechasAsistenciaSupervisores); $i++){        
        $sumaPorcentaje = 0;
        $FechasA = $fechasAsistenciaSupervisores[$i];
        
        $sql2 = "SELECT * 
                 FROM kpigerenter 
                 WHERE  NumSupervisorKpiGR = '$NumEmpleado'
                 AND FechaAsistenciaKpiGR='$FechasA'";  
        
        $res2 = mysqli_query($conexion, $sql2);
        $DatosSupervisores = null;
        while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
            $DatosSupervisores[] = $reg2;
        }
        if($DatosSupervisores == null){
            $PorcentajeKpiSistemaGR = 0;
        }else{
            $PorcentajeKpiSistemaGR = $DatosSupervisores[0]["PorcentajeKpiSistemaGR"];
        }
        $sql3 = "SELECT sum(
                            (SELECT count(idSupervision) AS Total 
                             FROM asistencia_supervisor
                             WHERE concat_ws('-',entidadSupervisor,consecutivoSupervisor,categoriaSupervisor) = '$NumEmpleado'
                             AND fechaAsistenciaSupervisor='$FechasA') 
                 +
                            (SELECT count(idFotoSupervisor) as Total1 
                             FROM FotosSupervisores
                             WHERE idAsistenciaSupervisor = (SELECT idSupervision 
                                                             FROM asistencia_supervisor
                                                             WHERE concat_ws('-',entidadSupervisor,consecutivoSupervisor,categoriaSupervisor) = '$NumEmpleado'
                                                             AND fechaAsistenciaSupervisor='$FechasA'))
                 ) as Total";  
        $res3 = mysqli_query($conexion, $sql3);
        $DatosSupervisiones = null;
        while (($reg3 = mysqli_fetch_array($res3, MYSQLI_ASSOC))){
            $DatosSupervisiones[] = $reg3;
        }
        $Total= $DatosSupervisiones[0]["Total"];
        $sql4 = "SELECT * 
                 FROM Calificacion_Supervisores
                 WHERE NumeroSupervisiones='$Total'";  
        $res4 = mysqli_query($conexion, $sql4);
        $DatosSupervisionesCalif = null;
        while (($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
            $DatosSupervisionesCalif[] = $reg4;
        }
        $calificacionSupervisor = $DatosSupervisionesCalif[0]["Calificacion"];
        $datos[$FechasA]["kpi"] = $PorcentajeKpiSistemaGR;
        $datos[$FechasA]["supervisiones"] = $calificacionSupervisor;

        //tabla calificaciones
        $sql5 = "SELECT 
                     idCalSupervisor,
                     CASE 
                         WHEN NumeroSupervisiones = 4 THEN '4 o más'
                         ELSE CONCAT(NumeroSupervisiones, '')
                     END AS NumeroSupervisiones,
                     Calificacion
                 FROM calificacion_supervisores
                 LIMIT 5";  
        $res5 = mysqli_query($conexion, $sql5);
        $calificaciones = null;
        WHILE (($reg5 = mysqli_fetch_array($res5, MYSQLI_ASSOC))){
            $calificaciones[] = $reg5;
        }
    }
// $log->LogInfo("Valor de la variable response datos: " . var_export ($datos, true));
    $response["resulta"]= $datos;
    $response["calificaciones"]= $calificaciones;
// $log->LogInfo("Valor de la variable response asistencia: " . var_export ($response, true));
}catch( Exception $e ){
    $response["status"]="error";
    $response["error"]="No se puedo obtener Asistencia";
}
echo json_encode($response);
?>