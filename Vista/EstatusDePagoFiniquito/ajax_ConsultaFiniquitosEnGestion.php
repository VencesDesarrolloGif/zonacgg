<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
if (!isset($_SESSION["userLog"])) {
    header ("Location: https://zonagifseguridad.com.mx//zonagif/Vista/LoginSuperUsuario/form_LoginSuperUsuario.php");
    exit;
} 
$response           = array();
$response["status"] = "error";
$datos              = array();
$log = new KLogger ( "ajax_ConsultaFiniquitosEnGestion.log" , KLogger::DEBUG );
$log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
//$log->LogInfo("Valor de la variable response " . var_export ($response, true));

try {
    $sql = "SELECT f.idFiniquito as idFiniquito ,concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) as NumeroEmpleado, concat_ws(' ', e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreEmpleado,f.fechaAlta as FechaAlta, f.fechaBaja as FechaBaja,concat_ws('-',ee.entidadFederativaId,ee.empleadoConsecutivoId,ee.empleadoCategoriaId) as NumerodminBaja, concat_ws(' ', ee.nombreEmpleado,ee.apellidoPaterno,ee.apellidoMaterno) as NombreAdminBaja,d.fechaImss as FechaImssAlta,d.fechaBajaImss as FechaImssBaja,f.estatusPagoFiniquito,ef.nombreEntidadFederativa
        from finiquitos f
        left join empleados e on (f.entidadEmpFiniquito=e.entidadFederativaId and f.consecutivoEmpFiniquito=e.empleadoConsecutivoId and f.categoriaEmpFiniquito=e.empleadoCategoriaId)
        left join empleados ee on (f.EntidadAdminBaja=ee.entidadFederativaId and f.ConsecutivoAdminBaja=ee.empleadoConsecutivoId and f.CategoriaAdminBaja=ee.empleadoCategoriaId)
        left join datosimss d on (f.entidadEmpFiniquito=d.empladoEntidadImss and f.consecutivoEmpFiniquito=d.empleadoConsecutivoImss and f.categoriaEmpFiniquito=d.empleadoCategoriaImss)
        LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=f.idEntidadTrabajo)
        where (f.estatusPagoFiniquito = '1' or f.estatusPagoFiniquito = '2') AND f.estatusFiniquito='1' AND ( ";

        for($i=0;$i<count($_SESSION["userLog"]['entidadFederativaUsuario']);$i++){
            if(!is_array($_SESSION["userLog"]['entidadFederativaUsuario'])){
                $entidadparaconsulta=$_SESSION["userLog"]['entidadFederativaUsuario'];
            }else{
                $entidadparaconsulta=$_SESSION["userLog"]['entidadFederativaUsuario'][$i];
            }
            if($i==0){
                $sql.=" (f.idEntidadTrabajo='$entidadparaconsulta')";  
            }else{
                $sql.=" or (f.idEntidadTrabajo='$entidadparaconsulta')";       
            }
        }$sql.=" ) ";     
    
        $res = mysqli_query($conexion, $sql);
        while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
            $datos[] = $reg;
        }
    for($i = 0; $i < count($datos); $i++){
        $datos[$i]["abrirPdf"] = "<i  title='Generar pdf' class='fa fa-file-pdf-o' style='font-size:40px;color:red'    id='btnAbrirPdfGestion' onclick='abrirPdfFiniquitoLider(\"" . $datos[$i]['NumeroEmpleado'] . "\",\"" . $datos[$i]['FechaBaja'] . "\",\"" . $datos[$i]['FechaAlta'] . "\")'></i>";

        $datos[$i]["checkvarios"]="<input type='checkbox' id=".$datos[$i]['NumeroEmpleado'] ."_".$i."  name=".$datos[$i]['NumeroEmpleado'] ."_".$i." value='".$datos[$i]['NumeroEmpleado'] ."_".$i."'  empleadoFechaBaja='".$datos[$i]['FechaBaja'] ."' empleadoFechaAlta='".$datos[$i]['FechaAlta']  ."' numeroEmpleado='".$datos[$i]['NumeroEmpleado'] ."'>";

        $datos[$i]["cargarArchivo"]="<img src='img/upload.png' width='40' onclick='abrirModalCargarArchivoGestionFiniquito(\"" . $datos[$i]['NumeroEmpleado'] . "\",\"" . $datos[$i]['idFiniquito'] . "\",\"" . $datos[$i]['FechaBaja'] . "\",\"" . $datos[$i]['FechaAlta'] . "\",\"" . $datos[$i]['estatusPagoFiniquito'] . "\")'>";
    }
    $response["status"]= "success";
    $response["datos"] = $datos;
}catch (Exception $e) {
    $response["mensaje"] = "Error al iniciar sesion";}
echo json_encode($response);
