<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$response = array("status" => "success");
$log = new KLogger ( "ajax_getTransferenciasByFechaEntidad.log" , KLogger::DEBUG );
$fecha1=$_POST["fechaConsulta1"];
$fecha2=$_POST["fechaConsulta2"];
$entidad=$_POST["entidadConsulta"];
$lista = array ();
	try{
			$sql="SELECT t.idTransferencia,
						 t.fechaTransferenciaEnvio,
						 t.fechaTransferenciaRecepcion,
    					 t.nGuiaTransferencia,
    					 t.proveedorPaqueteria,
    					 t.observacionesTransferencia,
    					 t.usuarioTransferencia,
    					 cet.estatusTransfer,
    					 ef.nombreEntidadFederativa as entidadDestino,
    					 t.entidadDestino as identidadDestino,
    					 si.nombreSucursal,
    					 t.sucursalDestino,
    					 si.nombreSucursal,
    					 t.observacionRechazoTransferencia,
    					 rt.DescripcionMotivoRT as motivoRechazoTransferencia
    			  FROM transferencias_uniformes t
    			  LEFT JOIN entidadesfederativas ef ON (t.entidadDestino=ef.idEntidadFederativa)
    			  LEFT JOIN catalogoestatustransferencias cet ON (t.idEstatusTransfer=cet.idEstatusTransfer)
    			  LEFT JOIN sucursalesinternas si on (si.idSucursalI=t.sucursalDestino)
    			  LEFT JOIN catalogoestatusmotivorechazotransferencia rt on (rt.idMotivoRT=t.motivoRechazoTransferencia)"; //ASI SE QUEDA SI ES GENERAL SIN FECHAS

			if ($fecha1 != "" && $fecha2 != "" && $entidad == "00"){//GENERAL X FECHAS
        	    $sql .= " WHERE t.fechaTransferenciaEnvio BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE)";
        	} else if ($fecha1 == "" && $fecha2 == "" && $entidad != "00"){//POR ENTIDAD
        	    $sql .= " WHERE t.entidadDestino='$entidad'
        	    		  ORDER BY t.fechaTransferenciaEnvio DESC";
        	} else if ($fecha1 != "" && $fecha2 != "" && $entidad != "00"){ // POR ENTIDAD Y FECHAS
        	    $sql .= " WHERE t.fechaTransferenciaEnvio BETWEEN CAST('$fecha1' AS DATE) and CAST('$fecha2' AS DATE) AND t.entidadDestino='$entidad'";
        	} 

        	$res = mysqli_query($conexion, $sql);
   			while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
   		    	   $lista[] = $reg;
   			}

			for($i = 0; $i < count($lista); $i++){
				$idTransfer = $lista[$i] ["idTransferencia"];										
				$lista[$i]["ver_detalle"] = "<a href='javascript:mostrarModalDetalleTransfer(\"" . $idTransfer . "\");'>Ver Detalle</a>";				
			}
			$response["data"]= $lista;
			$log->LogInfo("Valor de la variable response : " . var_export ($response, true));
	}catch( Exception $e ){
		$response["status"]="error";
		$response["error"]="No se pudo obtener detalle de asistencia";
	}
echo json_encode($response);
?>