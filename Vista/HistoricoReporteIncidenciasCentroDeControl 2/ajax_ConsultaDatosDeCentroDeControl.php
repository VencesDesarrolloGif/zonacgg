<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "ajax_ConsultaDatosDeCentroDeControl.log" , KLogger::DEBUG );
$idIncidencia = $_POST ["idIncidencia"];
try {
        $sql = "SELECT ti.descripcionTipoIncidenciaCC as DescripcionTipoIncidencia,ri.ExistePuntoIncidenciaCC as Existepunto,ifnull(cps.puntoServicio,0) as PuntoServicio,ri.PuntoServicioIncidenciaCC as PuntoServicioText,concat_ws('-',ri.EmpEntidadIncidenciaCC,ri.EmpConsecutivoIncidenciaCC,ri.EmpCategoriaIncidenciaCC) as NumeroEmpleado,concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno ) as NombreEmpelado,concat_ws('-',ri.AdminEntidadIncidenciaCC,ri.AdminConsecutivoIncidenciaCC,ri.AdminCategoriaIncidenciaCC) as NumeroAdmin,concat_ws(' ',ee.nombreEmpleado,ee.apellidoPaterno,ee.apellidoMaterno ) as NombreAdmin,ri.TestigoIncidenciaCC as Testigo1,ri.TestigoIncidenciaCC2 as Testigo2,ri.TestigoIncidenciaCC3 as Testigo3,ri.TestigoIncidenciaCC4 as Testigo4,ri.TestigoIncidenciaCC5 as Testigo5,ri.TestigoIncidenciaCC6 as Testigo6,ri.TestigoIncidenciaCC7 as Testigo7,ri.PercataronIncidenciaCC as Percataron,ri.RecopilacionIncidenciaCC as Recopilacion1,ri.RecopilacionIncidenciaCC2 as Recopilacion2,ri.RecopilacionIncidenciaCC3 as Recopilacion3,ri.RecopilacionIncidenciaCC4 as Recopilacion4,ri.RecopilacionIncidenciaCC5 as Recopilacion5,ri.RecopilacionIncidenciaCC6 as Recopilacion6,ri.RecopilacionIncidenciaCC7 as Recopilacion7,ri.RecopilacionIncidenciaCC8 as Recopilacion8,ri.RecopilacionIncidenciaCC9 as Recopilacion9,ri.RecopilacionIncidenciaCC10 as Recopilacion10,ri.TareaIncidenciaCC as Tarea,ri.ResponsabilidadIncidenciaCC as Responsabilidad1,ri.ResponsabilidadIncidenciaCC2 as Responsabilidad2,ri.OrdenesIncidenciaCC as Ordenes1,ri.OrdenesIncidenciaCC2 as Ordenes2,ri.EvidenciaIncidenciaCC as Evidencia1,ri.EvidenciaIncidenciaCC2 as Evidencia2,ri.SupervisionIncidenciaCC as Supervisiones1,ri.SupervisionIncidenciaCC2 as Supervisiones2
            from ReporteIncidenciaCentroControl ri
            left join CatalogoTipoIncidenciaCentroC ti ON (ri.idIncidenciaCC=ti.idTipoIncidenciaCC)
            left join empleados e ON (e.entidadFederativaId=ri.EmpEntidadIncidenciaCC and e.empleadoConsecutivoId=ri.EmpConsecutivoIncidenciaCC and e.empleadoCategoriaId=ri.EmpCategoriaIncidenciaCC)
            left join empleados ee ON (ee.entidadFederativaId=ri.AdminEntidadIncidenciaCC and ee.empleadoConsecutivoId=ri.AdminConsecutivoIncidenciaCC and ee.empleadoCategoriaId=ri.AdminCategoriaIncidenciaCC)
            left join catalogopuntosservicios cps ON (cps.idPuntoServicio=ri.IdPuntoIncidenciaCC)
            where ri.idinciIdenciaCC='$idIncidencia'";
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    //$idIncidencia      = $datos[$i]["idIncidencia"];
    $LargoTestigos = 0; 
    $Testigo1                   = $datos[0]["Testigo1"];
    $Testigo2                   = $datos[0]["Testigo2"];
    $Testigo3                   = $datos[0]["Testigo3"];
    $Testigo4                   = $datos[0]["Testigo4"];
    $Testigo5                   = $datos[0]["Testigo5"];
    $Testigo6                   = $datos[0]["Testigo6"];
    $Testigo7                   = $datos[0]["Testigo7"];

    if($Testigo1!="" && $Testigo1!="null" && $Testigo1!=null && $Testigo1!="NULL" && $Testigo1!=NULL && $Testigo1!="undefined"){
        $LargoTestigos = $LargoTestigos +1;
    }
    if($Testigo2!="" && $Testigo2!="null" && $Testigo2!=null && $Testigo2!="NULL" && $Testigo2!=NULL && $Testigo2!="undefined"){
        $LargoTestigos = $LargoTestigos +1;
    }
    if($Testigo3!="" && $Testigo3!="null" && $Testigo3!=null && $Testigo3!="NULL" && $Testigo3!=NULL && $Testigo3!="undefined"){
        $LargoTestigos = $LargoTestigos +1;
    }
    if($Testigo4!="" && $Testigo4!="null" && $Testigo4!=null && $Testigo4!="NULL" && $Testigo4!=NULL && $Testigo4!="undefined"){
        $LargoTestigos = $LargoTestigos +1;
    }
    if($Testigo5!="" && $Testigo5!="null" && $Testigo5!=null && $Testigo5!="NULL" && $Testigo5!=NULL && $Testigo5!="undefined"){
        $LargoTestigos = $LargoTestigos +1;
    }
    if($Testigo6!="" && $Testigo6!="null" && $Testigo6!=null && $Testigo6!="NULL" && $Testigo6!=NULL && $Testigo6!="undefined"){
        $LargoTestigos = $LargoTestigos +1;
    }
    if($Testigo7!="" && $Testigo7!="null" && $Testigo7!=null && $Testigo7!="NULL" && $Testigo7!=NULL && $Testigo7!="undefined"){
        $LargoTestigos = $LargoTestigos +1;
    }
    $LargoRecopilacion = 0; 
    $Recopilacion1              = $datos[0]["Recopilacion1"];
    $Recopilacion2              = $datos[0]["Recopilacion2"];
    $Recopilacion3              = $datos[0]["Recopilacion3"];
    $Recopilacion4              = $datos[0]["Recopilacion4"];
    $Recopilacion5              = $datos[0]["Recopilacion5"];
    $Recopilacion6              = $datos[0]["Recopilacion6"];
    $Recopilacion7              = $datos[0]["Recopilacion7"];
    $Recopilacion8              = $datos[0]["Recopilacion8"];
    $Recopilacion9              = $datos[0]["Recopilacion9"];
    $Recopilacion10             = $datos[0]["Recopilacion10"];
    if($Recopilacion1!="" && $Recopilacion1!="null" && $Recopilacion1!=null && $Recopilacion1!="NULL" && $Recopilacion1!=NULL && $Recopilacion1!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion2!="" && $Recopilacion2!="null" && $Recopilacion2!=null && $Recopilacion2!="NULL" && $Recopilacion2!=NULL && $Recopilacion2!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion3!="" && $Recopilacion3!="null" && $Recopilacion3!=null && $Recopilacion3!="NULL" && $Recopilacion3!=NULL && $Recopilacion3!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion4!="" && $Recopilacion4!="null" && $Recopilacion4!=null && $Recopilacion4!="NULL" && $Recopilacion4!=NULL && $Recopilacion4!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion5!="" && $Recopilacion5!="null" && $Recopilacion5!=null && $Recopilacion5!="NULL" && $Recopilacion5!=NULL && $Recopilacion5!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion6!="" && $Recopilacion6!="null" && $Recopilacion6!=null && $Recopilacion6!="NULL" && $Recopilacion6!=NULL && $Recopilacion6!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion7!="" && $Recopilacion7!="null" && $Recopilacion7!=null && $Recopilacion7!="NULL" && $Recopilacion7!=NULL && $Recopilacion7!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion8!="" && $Recopilacion8!="null" && $Recopilacion8!=null && $Recopilacion8!="NULL" && $Recopilacion8!=NULL && $Recopilacion8!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion9!="" && $Recopilacion9!="null" && $Recopilacion9!=null && $Recopilacion9!="NULL" && $Recopilacion9!=NULL && $Recopilacion9!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    if($Recopilacion10!="" && $Recopilacion10!="null" && $Recopilacion10!=null && $Recopilacion10!="NULL" && $Recopilacion10!=NULL && $Recopilacion10!="undefined"){
        $LargoRecopilacion = $LargoRecopilacion +1;
    }
    $LargoResponsabilidad = 0;
    $Responsabilidad1           = $datos[0]["Responsabilidad1"];
    $Responsabilidad2           = $datos[0]["Responsabilidad2"];
    if($Responsabilidad1!="" && $Responsabilidad1!="null" && $Responsabilidad1!=null && $Responsabilidad1!="NULL" && $Responsabilidad1!=NULL && $Responsabilidad1!="undefined"){
        $LargoResponsabilidad = $LargoResponsabilidad +1;
    }
    if($Responsabilidad2!="" && $Responsabilidad2!="null" && $Responsabilidad2!=null && $Responsabilidad2!="NULL" && $Responsabilidad2!=NULL && $Responsabilidad2!="undefined"){
        $LargoResponsabilidad = $LargoResponsabilidad +1;
    }
    $LargoOrdenes = 0;
    $Ordenes1                   = $datos[0]["Ordenes1"];
    $Ordenes2                   = $datos[0]["Ordenes2"];
    if($Ordenes1!="" && $Ordenes1!="null" && $Ordenes1!=null && $Ordenes1!="NULL" && $Ordenes1!=NULL && $Ordenes1!="undefined"){
        $LargoOrdenes = $LargoOrdenes +1;
    }
    if($Ordenes2!="" && $Ordenes2!="null" && $Ordenes2!=null && $Ordenes2!="NULL" && $Ordenes2!=NULL && $Ordenes2!="undefined"){
        $LargoOrdenes = $LargoOrdenes +1;
    }
    $LargoEvidencia = 0;
    $Evidencia1             = $datos[0]["Evidencia1"];
    $Evidencia2             = $datos[0]["Evidencia2"];
    if($Evidencia1!="" && $Evidencia1!="null" && $Evidencia1!=null && $Evidencia1!="NULL" && $Evidencia1!=NULL && $Evidencia1!="undefined"){
        $LargoEvidencia = $LargoEvidencia +1;
    }
    if($Evidencia2!="" && $Evidencia2!="null" && $Evidencia2!=null && $Evidencia2!="NULL" && $Evidencia2!=NULL && $Evidencia2!="undefined"){
        $LargoEvidencia = $LargoEvidencia +1;
    }

    $LargoSupervisiones = 0;
    $Supervisiones1             = $datos[0]["Supervisiones1"];
    $Supervisiones2             = $datos[0]["Supervisiones2"];
    if($Supervisiones1!="" && $Supervisiones1!="null" && $Supervisiones1!=null && $Supervisiones1!="NULL" && $Supervisiones1!=NULL && $Supervisiones1!="undefined"){
        $LargoSupervisiones = $LargoSupervisiones +1;
    }
    if($Supervisiones2!="" && $Supervisiones2!="null" && $Supervisiones2!=null && $Supervisiones2!="NULL" && $Supervisiones2!=NULL && $Supervisiones2!="undefined"){
        $LargoSupervisiones = $LargoSupervisiones +1;
    }
    $Existepunto             = $datos[0]["Existepunto"];
    if($Existepunto=="1" || $Existepunto==1){
        $datos[0]["PuntoServicioActual"]= $datos[0]["PuntoServicio"];
    }else{
        $datos[0]["PuntoServicioActual"]= $datos[0]["PuntoServicioText"];
    }
    $datos[0]["LargoTestigos"]= $LargoTestigos;
    $datos[0]["LargoRecopilacion"]= $LargoRecopilacion;
    $datos[0]["LargoResponsabilidad"]= $LargoResponsabilidad;
    $datos[0]["LargoOrdenes"]= $LargoOrdenes;
    $datos[0]["LargoEvidencia"]= $LargoEvidencia;
    $datos[0]["LargoSupervisiones"]= $LargoSupervisiones;

    $response["status"]= "success";

    $log->LogInfo("Valor de la variable datos " . var_export ($datos, true));
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);


