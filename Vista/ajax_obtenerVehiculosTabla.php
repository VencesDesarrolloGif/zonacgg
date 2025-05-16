<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajaxObtenerVehiculos.log" , KLogger::DEBUG );
$casoVehiculo=$_POST['casoVehiculo'];
//$log->LogInfo("Valor de casoVehiculo" . var_export ($casoVehiculo, true));
if(!empty ($_POST))
{
	try{
		$listaVehiculos= $negocio -> traerCatalogoVehiculos($casoVehiculo);  
        for ($i = 0; $i < count($listaVehiculos); $i++)
        {
          
            $idvehiculo = $listaVehiculos[$i] ["idvehiculo"]; 
            $numeroplacas = $listaVehiculos[$i] ["numeroplacas"];
            $Marca = $listaVehiculos[$i] ["Marca"];
            $Modelo = $listaVehiculos[$i] ["Modelo"];
            $ColorVehiculo = $listaVehiculos[$i] ["ColorVehiculo"];
            $anioVehuiculo = $listaVehiculos[$i] ["anioVehuiculo"];
            $celindradas = $listaVehiculos[$i] ["celindradas"];
            $nombreEntidadF = $listaVehiculos[$i] ["nombreEntidadF"];
            $empleadoentidad = $listaVehiculos[$i]["empleadoentidad"];
            $empleadoConsecutivo = $listaVehiculos[$i] ["empleadoConsecutivo"];
            $empleadoCategoria = $listaVehiculos[$i] ["empleadoCategoria"];
            $NombreSinGif = $listaVehiculos[$i] ["NombreSinGif"];
            $apellidoPSinGifS = $listaVehiculos[$i] ["apellidoPSinGifS"];
            $apellidoMSinGif = $listaVehiculos[$i] ["apellidoMSinGif"];
            $nombreConGIf = $listaVehiculos[$i] ["nombreConGIf"];
            $apellidoPConGif = $listaVehiculos[$i] ["apellidoPConGif"];
            $apellidoMConGIf = $listaVehiculos[$i] ["apellidoMConGIf"];
            $LineaNegocio = $listaVehiculos[$i] ["LineaNegocio"];
            $EstatusVehiculo = $listaVehiculos[$i] ["EstatusVehiculo"];

            if($EstatusVehiculo=="1"){
              $listaVehiculos[$i] ["EstatusVehiculo"]="ACTIVO";
            }else{
              $listaVehiculos[$i] ["EstatusVehiculo"]="BAJA";
            }
            

           if($listaVehiculos[$i]["Asignacion"]==null && $listaVehiculos[$i]["AsignacionSinGif"]==null){
                  $caso=1;
                  if($EstatusVehiculo=="1"){
                    $listaVehiculos[$i]["Asignacion"] = "<a href='javascript:modalAsignarEmpleado(\"" . $idvehiculo . "\",\"" . $numeroplacas . "\",\"" . $caso . "\");'>Asignar</a>";
                  }else{
                    $listaVehiculos[$i]["Asignacion"] = "EL Vehiculo No Puede Ser Asignado Al Estar Dado De Baja";
                  }
                  
                  $listaVehiculos[$i]["NumeroEmpleado"]  ="No Asignado";    
            }else{
                  $caso=2;
                  if ($listaVehiculos[$i] ["Asignacion"]!=null && $listaVehiculos[$i] ["EstatusConGif"]=="ACTIVO"){
                      $listaVehiculos[$i]["NumeroEmpleado"]  = ($empleadoentidad . "-" . $empleadoConsecutivo . "-" . $empleadoCategoria . " " .  $nombreConGIf . " " . $apellidoPConGif . " " . $apellidoMConGIf);
                  }else{
                        $listaVehiculos[$i]["NumeroEmpleado"]  = ($NombreSinGif . " " . $apellidoPSinGifS . " " . $apellidoMSinGif);
                  }
                  if($EstatusVehiculo=="1"){
                  $listaVehiculos[$i]["Asignacion"] = "<a href='javascript:modalAsignarEmpleado(\"" . $idvehiculo . "\",\"" . $numeroplacas . "\",\"" . $caso . "\");'>Reasignar</a>";
                }else{
                  $listaVehiculos[$i]["Asignacion"] = "EL Vehiculo No Puede Ser Reasignado Al Estar Dado De Baja";
                }

                    
            }
      }
        
    //    $log->LogInfo("Valor de listaVehiculos" . var_export ($listaVehiculos, true));
        
		$response["data"]= $listaVehiculos;
	} 
	catch( Exception $e )
	{
	$response["status"]="error";
	$response["error"]="No se pudo obtener lista de puntos de servicio";
	}
}

echo json_encode($response);

?>