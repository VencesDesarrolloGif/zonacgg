<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$log = new KLogger ( "ajax_obtenerEmpleadosSPF.log" , KLogger::DEBUG );
$response = array("status" => "success");
$listaEmpleadosSPF= array();

try{
    $sql = "SELECT concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) as numeroEmpleado,
    			   concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as nombreEmpleado,
    			   cln.descripcionLineaNegocio,
    			   f.fechaAlta,
    			   f.fechaBaja,
    			   f.idFiniquito,
    			   f.netoAlPago,
                   ef.nombreEntidadFederativa,
                   cp.descripcionPuesto,
                   ctp.descripcionCategoria,f.nombreFiniquitoFirmado
    		FROM finiquitos f
    		LEFT JOIN empleados e ON (e.entidadFederativaId=f.entidadEmpFiniquito and e.empleadoConsecutivoId=f.consecutivoEmpFiniquito and e.empleadoCategoriaId=f.categoriaEmpFiniquito)
    		LEFT JOIN datosimss di ON (e.entidadFederativaId=di.empladoEntidadImss and e.empleadoConsecutivoId=di.empleadoConsecutivoImss and e.empleadoCategoriaId=di.empleadoCategoriaImss)
    		LEFT JOIN catalogolineanegocio cln ON (cln.idLineaNegocio=e.empleadoLineaNegocioId)
            LEFT JOIN entidadesfederativas ef ON (ef.idEntidadFederativa=f.idEntidadTrabajo)
            LEFT JOIN catalogopuestos cp ON (cp.idPuesto=f.idPuesto)
            LEFT JOIN catalogocategoriastipopuestos ctp ON (ctp.idCategoria=f.idTipoEmpleado)
    		WHERE estatusPagoFiniquito='3'
    		ORDER BY f.fechaBaja";

$log->LogInfo("Valor de la variable sql: " . var_export ($sql, true));
    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
          $listaEmpleadosSPF[] = $reg;
    }
$log->LogInfo("Valor de la variable listaEmpleados: " . var_export ($listaEmpleadosSPF, true));

    for ($i=0; $i < count($listaEmpleadosSPF); $i++) { 
        $listaEmpleadosSPF[$i]["abrirPdf"] = "<i  title='Generar pdf' class='fa fa-file-pdf-o' style='font-size:40px;color:red;cursor: pointer'    id='btnAbrirPdfGestion' onclick='abrirPdfFiniquitoFinanzas(\"" . $listaEmpleadosSPF[$i]['nombreFiniquitoFirmado'] . "\")'></i>";

        $listaEmpleadosSPF[$i]["cehcaCreado"] = "<input type='checkbox' id=checkSPF".$i." name=checkSPF".$i." value=".$listaEmpleadosSPF[$i]['idFiniquito'].">";
    	$netoAlPago = $listaEmpleadosSPF[$i]["netoAlPago"];
        $netoAlPagoExplod = explode(".", $netoAlPago);

        if(count($netoAlPagoExplod)==1){
          $netoAlPago1=$netoAlPago.".00";

        }else{
            $netoAlPago1=$netoAlPago;
        }
        $listaEmpleadosSPF[$i]["netoAlPago"]=$netoAlPago1;
    }
	$response["listaEmpleadosSPF"]= $listaEmpleadosSPF;
} 
catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);
?>