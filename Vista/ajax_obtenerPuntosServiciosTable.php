<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio); 
$response = array("status" => "success");
// $log = new KLogger ( "ajaxObtenerPuntosServiciosTable.log" , KLogger::DEBUG );	

// $log->LogInfo("Valor de variable _POST" . var_export ($_POST, true));  

try{
      $banderaBusquedaPuntos=$_POST["banderaBusquedaPuntos"];
      if($banderaBusquedaPuntos != "" && $banderaBusquedaPuntos != null && $banderaBusquedaPuntos != "null" && $banderaBusquedaPuntos != "undefined" && $banderaBusquedaPuntos != "NULL" && $banderaBusquedaPuntos != NULL){
            $listaPuntos= $negocio -> traerCatalogoPuntosServiciosConOpciones($banderaBusquedaPuntos);
      }else{
	     $listaPuntos= $negocio -> traerCatalogoPuntosServicios();
      }
            // $log->LogInfo("Valor de variable lista1" . var_export ($listaPuntos, true));  
      for ($i = 0; $i < count($listaPuntos); $i++)
      {   
            $idPuntoServicio = $listaPuntos[$i] ["idPuntoServicio"];
            $numeroCentroCosto = $listaPuntos[$i] ["numeroCentroCosto"];
            $numeroOrden = $listaPuntos[$i] ["numeroOrden"];
            $puntoServicio = $listaPuntos[$i] ["puntoServicio"];
            $razonSocial = $listaPuntos[$i] ["razonSocial"];
            $nombreEntidadFederativa = $listaPuntos[$i] ["nombreEntidadFederativa"];
            $esatusPunto = $listaPuntos[$i] ["esatusPunto"];
            $fechaInicioServicio = $listaPuntos[$i] ["fechaInicioServicio"];
            $fechaTerminoServicio = $listaPuntos[$i] ["fechaTerminoServicio"];



            $contactoFacturacion = $listaPuntos[$i] ["contactoFacturacion"];
            $telefonoFijoFacturacion = $listaPuntos[$i] ["telefonoFijoFacturacion"];
            $telefonoMovilFacturacion = $listaPuntos[$i] ["telefonoMovilFacturacion"];
            $correoFacturacion = $listaPuntos[$i] ["correoFacturacion"];

            $contactoTesoreria = $listaPuntos[$i] ["contactoTesoreria"];
            $telefonoFijoTesoreria = $listaPuntos[$i] ["telefonoFijoTesoreria"];
            $telefonoMovilTesoreria = $listaPuntos[$i] ["telefonoMovilTesoreria"];
            $correoTesoreria = $listaPuntos[$i] ["correoTesoreria"];

            $contactoOperativo = $listaPuntos[$i] ["contactoOperativo"];
            $telefonoFijoOperativo = $listaPuntos[$i] ["telefonoFijoOperativo"];
            $telefonoMovilOperativo = $listaPuntos[$i] ["telefonoMovilOperativo"];
            $correoOperativo = $listaPuntos[$i] ["correoOperativo"];
            $terminoFacturacion = $listaPuntos[$i] ["terminoFacturacion"];
            $idClientePunto = $listaPuntos[$i] ["idClientePunto"];
            $idEntidadPunto = $listaPuntos[$i] ["idEntidadPunto"];
            $cobraDescansos= $listaPuntos[$i]["cobraDescansos"];
            $cobraDiaFestivo= $listaPuntos[$i]["cobraDiaFestivo"];
            $cobra31= $listaPuntos[$i]["cobra31"];
            $latitudPunto= $listaPuntos[$i]["latitudPunto"];
            $longitudPunto= $listaPuntos[$i]["longitudPunto"];
            
            $nombrePuntoFacturacion= $listaPuntos[$i]["nombrePuntoFacturacion"];
            $centroCostoFacturacion= $listaPuntos[$i]["centroCostoFacturacion"];
            $turnoFlat= $listaPuntos[$i]["turnosFlat"];

            $visiblerh= $listaPuntos[$i]["visiblerh"];

            $cubredescanso= $listaPuntos[$i]["cubredescanso"];
            
            $descripcionLineaNegocio= $listaPuntos[$i]["descripcionLineaNegocio"];  
            $municipiodelegacion= $listaPuntos[$i]["municipiodelegacion"];
            $unidad= $listaPuntos[$i]["unidad"];

            $idLineanNegocio=$listaPuntos[$i]["idLineaNegocioPunto"];

            $direccionPuntoServicio = $listaPuntos[$i] ["direccionPuntoServicio"];
            $nombreAsentamiento = $listaPuntos[$i]["nombreAsentamiento"];
            $nombreMunicipio = $listaPuntos[$i]["nombreMunicipio"];
            $nombreEntidadFederativa = $listaPuntos[$i]["nombreEntidadFederativa"];
            $CodigoPostalPuntoS = $listaPuntos[$i]["CodigoPostalPuntoS"];
            $AsentamientoPuntoS = $listaPuntos[$i]["AsentamientoPuntoS"]; 
            $EntidadPuntoS = $listaPuntos[$i]["EntidadPuntoS"];
            $MunicipioPuntoS = $listaPuntos[$i]["MunicipioPuntoS"];
            $ColoniaPuntoS = $listaPuntos[$i]["ColoniaPuntoS"];
            $CallePrincipaPuntoS = $listaPuntos[$i]["CallePrincipaPuntoS"];
            $NumeroExteriorPuntoS = $listaPuntos[$i]["NumeroExteriorPuntoS"];
            $NumeroInterirPuntoS = $listaPuntos[$i]["NumeroInterirPuntoS"]; 
            $PrimerCallePuntoS = $listaPuntos[$i]["PrimerCallePuntoS"]; 
            $SegundaCallePuntoS = $listaPuntos[$i]["SegundaCallePuntoS"];
            $RangoAsistencia = $listaPuntos[$i]["RangoAsistencia"];


            if($CodigoPostalPuntoS == "NULL" || $CodigoPostalPuntoS == "null" || $CodigoPostalPuntoS == NULL || $CodigoPostalPuntoS == null || $CodigoPostalPuntoS == ""){
                  $listaPuntos[$i]["direccionPuntoServicio1"] = $direccionPuntoServicio; 
            }else{
                  $listaPuntos[$i]["direccionPuntoServicio1"] = "".$CallePrincipaPuntoS." ".$NumeroExteriorPuntoS.", ".$nombreAsentamiento.", ".$CodigoPostalPuntoS." ".$nombreMunicipio.", ".$nombreEntidadFederativa."";
            }
 

            if($listaPuntos[$i]["idIncrementRegionPuntoServ"]==null){ 
                  $idIncrementRegionPuntoServ="";
            }else{$idIncrementRegionPuntoServ=$listaPuntos[$i]["idIncrementRegionPuntoServ"];}
            if($listaPuntos[$i]["idRegionI"]==null){
                  $idRegionI="";
            }else{$idRegionI=$listaPuntos[$i]["idRegionI"];}
            if($listaPuntos[$i]["DescripcionI"]==null){
                  $DescripcionI="";
            }else{$DescripcionI=$listaPuntos[$i]["DescripcionI"];}
			
            if($esatusPunto==1){
			$listaPuntos[$i]["accion_baja_punto"] ="<a href='javascript:mostrarModalTerminoServicio(\"" . $idPuntoServicio . "\",\"".$puntoServicio."\");'>ACTIVO/DAR BAJA<img src='img/Ok-icon1.png'></a>";
            }else{
			$listaPuntos[$i]["accion_baja_punto"] ="<a href='javascript:mostrarModalReactivacionPuntoServicio(\"" . $idPuntoServicio . "\",\"".$puntoServicio."\");'>INACTIVO/REACTIVAR<img src='img/cancel.png'></a>";
            }
		$listaPuntos[$i]["accion_ver_plantilla"] = "<a href='javascript:mostrarModalPlantilla(\"" . $idPuntoServicio . "\",\"".$razonSocial."\",\"".$puntoServicio."\",\"".$cobraDescansos."\",\"".$cobraDiaFestivo."\",\"".$cobra31."\",\"".$fechaInicioServicio."\",\"".$fechaTerminoServicio."\",\"".$descripcionLineaNegocio."\",\"".$idLineanNegocio."\",\"".$idClientePunto."\");'>Ver Plantilla</a>";
			
            $listaPuntos[$i] ["accion_edita_punto"] ="<a href='javascript:modalEditarPunto( ". $RangoAsistencia .",". $idPuntoServicio .",".$idClientePunto.",\"".$numeroCentroCosto."\" ,\"".$puntoServicio."\" ,\"".$idEntidadPunto
            	."\" ,\"".$direccionPuntoServicio."\",\"".$fechaInicioServicio."\",\"".$fechaTerminoServicio."\",\"".$contactoFacturacion."\" ,\"".$telefonoFijoFacturacion."\" ,\"".$telefonoMovilFacturacion
            	."\",\"".$correoFacturacion."\"  ,\"".$terminoFacturacion."\" ,\"".$contactoTesoreria."\" ,\"".$correoTesoreria."\" ,\"".$telefonoFijoTesoreria."\",\"".$telefonoMovilTesoreria
            	."\",\"".$contactoOperativo."\",\"".$correoOperativo."\",\"".$telefonoFijoOperativo."\",\"".$telefonoMovilOperativo."\",\"".$cobraDescansos."\",\"".$cobraDiaFestivo."\",\"".$cobra31."\",\"".$latitudPunto."\",\"".$longitudPunto."\",\"".$turnoFlat."\",\"".$idLineanNegocio."\", \"".$idIncrementRegionPuntoServ."\",\"".$idRegionI."\",\"".$DescripcionI."\", \"".$nombreEntidadFederativa."\", \"".$visiblerh."\",\"".$cubredescanso."\",\"".$municipiodelegacion."\",\"".$unidad."\",\"".$CodigoPostalPuntoS."\",\"".$AsentamientoPuntoS."\",\"".$EntidadPuntoS."\",\"".$MunicipioPuntoS."\",\"".$ColoniaPuntoS."\",\"".$CallePrincipaPuntoS."\",\"".$NumeroExteriorPuntoS."\",\"".$NumeroInterirPuntoS."\",\"".$PrimerCallePuntoS."\",\"".$SegundaCallePuntoS."\");'><img src='img/edit.png'></a>";
            
            $listaPuntos[$i] ["accion_edita_punto_facturacion"]="<a href='javascript:modalEditarPuntoFacturacion( ". $idPuntoServicio .",".$idClientePunto.",\"".$numeroCentroCosto."\" ,\"".$puntoServicio."\" ,\"".$idEntidadPunto
                  ."\",\"".$fechaInicioServicio."\",\"".$fechaTerminoServicio."\",\"".$razonSocial."\",\"".$nombrePuntoFacturacion."\",\"".$centroCostoFacturacion."\");'><img src='img/edit.png'></a>";	
      }
     // $log->LogInfo("Valor de listaPuntos" . var_export ($listaPuntos, true));
	$response["data"]= $listaPuntos;
	//$log->LogInfo("Valor de variable de response" . var_export ($response, true));	
		//$log->LogInfo("Valor de la variable \$response punto: " . var_export ($response, true));
} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se pudo obtener lista de puntos de servicio";
}

echo json_encode($response);

?> 