<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
// $log = new KLogger ( "ajax_obtenerEmpleadosSPF.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable listaEmpleados: " . var_export ($sql, true));
$response = array("status" => "success");
$listaEmpleadosConFolio= array();

try{

 $sql = "SELECT concat_ws('-',f.entidadEmpFiniquito,f.consecutivoEmpFiniquito,f.categoriaEmpFiniquito) as numeroEmpleado,
        			   concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as nombreEmpleado,
        			   cln.descripcionLineaNegocio,
        			   di.fechaImss,
        			   di.fechaBajaImss,
        			   f.idFiniquito,
                 f.netoAlPago,
                 f.folioSPF,
                 ef.nombreEntidadFederativa,
                 cp.descripcionPuesto,
                 ctp.descripcionCategoria,
                 f.idBanco,
                 f.numeroCuenta,
                 f.numeroCuentaClave
        		FROM finiquitos f
        		LEFT JOIN empleados e ON (e.entidadFederativaId=f.entidadEmpFiniquito and e.empleadoConsecutivoId=f.consecutivoEmpFiniquito and e.empleadoCategoriaId=f.categoriaEmpFiniquito)
        		LEFT JOIN datosimss di ON (e.entidadFederativaId=di.empladoEntidadImss and e.empleadoConsecutivoId=di.empleadoConsecutivoImss and e.empleadoCategoriaId=di.empleadoCategoriaImss)
        		LEFT JOIN catalogolineanegocio cln ON (cln.idLineaNegocio=e.empleadoLineaNegocioId)
            LEFT JOIN entidadesfederativas ef ON (ef.idEntidadFederativa=f.idEntidadTrabajo)
            LEFT JOIN catalogopuestos cp ON (cp.idPuesto=f.idPuesto)
            LEFT JOIN catalogocategoriastipopuestos ctp ON (ctp.idCategoria=f.idTipoEmpleado)
        		WHERE estatusPagoFiniquito='4'
        		ORDER BY di.fechaBajaImss";

    $res = mysqli_query($conexion, $sql);
    while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
          $listaEmpleadosConFolio[] = $reg;
    }
for ($i = 0; $i < count($listaEmpleadosConFolio); $i++) {
        
        $idFiniquito    = $listaEmpleadosConFolio[$i]["idFiniquito"];
        $numeroEmpleado = $listaEmpleadosConFolio[$i]["numeroEmpleado"];
        $nombreEmpleado = $listaEmpleadosConFolio[$i]["nombreEmpleado"];
        $folioSPF       = $listaEmpleadosConFolio[$i]["folioSPF"];

        $netoAlPago = $listaEmpleadosConFolio[$i]["netoAlPago"];
        $netoAlPagoExplod = explode(".", $netoAlPago);

        if(count($netoAlPagoExplod)==1){
          $netoAlPago1=$netoAlPago.".00";

        }else{
            $netoAlPago1=$netoAlPago;
        }

        $netoAlPago1 = "$".$netoAlPago1;

        $listaEmpleadosConFolio[$i]["netoAlPago"]=$netoAlPago1;
        $rechazarbajaimss = $listaEmpleadosConFolio[$i]["eliminarFolio"] = "<a href='javascript:eliminarFolioEmpleado(\"" . $idFiniquito . "\",\"" . $numeroEmpleado . "\",\"" . $nombreEmpleado . "\",\"" . $folioSPF . "\");'><img src='img/cancel.png' /></a>";
        
        $regresarALU = $listaEmpleadosConFolio[$i]["errorCuenta"] = "<a href='javascript:eliminarEmpError(\"" . $idFiniquito . "\",\"" . $numeroEmpleado . "\",\"" . $nombreEmpleado . "\");'><img src='img/cancel.png' /></a>";
    }
	$response["data"]= $listaEmpleadosConFolio;
} 
catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se puedo obtener consulta";
}
echo json_encode($response);
?>