<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
require "conexion.php";
$response = array("status" => "success");
// $log = new KLogger ( "ajaxObtenerVehiculosAsignados.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de _SESSION" . var_export ($_SESSION, true));
// $entidadesusuario=$_SESSION ["userLog"]["entidadFederativaUsuario"];
$nombreusuario=$_SESSION ["userLog"]["usuario"];


$rolusr=$_SESSION ["userLog"]["rol"];
$usuarioId=$_SESSION['userLog']['usuarioId'];
$regionUsr          = array();
$entidades          = array();

if ($rolusr=="Gerente Regional") {


    $sql1 = "SELECT idRegionI,idLineaNegocioRUR  
             FROM relacionusuarios_regiones
             WHERE idUsuario='$usuarioId'";

             $res1 = mysqli_query($conexion, $sql1);
             while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                     $regionUsr[] = $reg1;
             }

             $idRegion= $regionUsr[0]["idRegionI"];
         $idLnGR= $regionUsr[0]["idLineaNegocioRUR"];

         $sql2 ="SELECT idEntidadI
                 FROM index_regiones ir
                 LEFT JOIN entidadesfederativas ef on (ef.idEntidadFederativa=ir.idEntidadI)
                 WHERE ir.idRegionI='$idRegion'
                 AND ir.idLineaNegI='$idLnGR'";

          $res2 = mysqli_query($conexion, $sql2);
          while (($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
              $entidades[] = $reg2;
          }

          for ($i = 0; $i < count($entidades); $i++) {
            $entidadesRegion[] = $entidades[$i]['idEntidadI'];  // Guardamos solo los idSucursalUsr
            }

        $entidadesusuario = implode(',', $entidadesRegion);
  }else{
        $entidadesusuarioLic = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32'];
        $entidadesusuario = implode(',', $entidadesusuarioLic);

  } 

	try{
		$listaVehiculosAsignados= $negocio -> traerCatalogoVehiculosasignados($entidadesusuario,$nombreusuario);
    // $listaVehiculosAsignados=array_merge($listaVehiculosAsignados);// merge sirve para eliminar los campos vacion y hacer el consecutivo del array
// $log->LogInfo("Valor de listaVehiculosAsignados" . var_export ($listaVehiculosAsignados, true));
// $log->LogInfo("Valor de COUNT" . var_export (count($listaVehiculosAsignados), true));

    for ($i = 0; $i < count($listaVehiculosAsignados); $i++)
        {
          $NumeroEconomico1 = count($listaVehiculosAsignados[$i]);

          // for ($j = 0; $j < $NumeroEconomico1; $j++){
              $NumeroEconomico = $listaVehiculosAsignados[$i]["NumeroEconomico"];
              $Placas = $listaVehiculosAsignados[$i]["Placas"];
              $Marca = $listaVehiculosAsignados[$i]["Marca"];
              $Modelo = $listaVehiculosAsignados[$i]["Modelo"];
              $ColorVehiculo = $listaVehiculosAsignados[$i]["ColorVehiculo"];
              $AnioVehuiculo = $listaVehiculosAsignados[$i]["AnioVehuiculo"];
              $Cilindrada = $listaVehiculosAsignados[$i]["Cilindrada"];
              $ColorEngomado = $listaVehiculosAsignados[$i]["ColorEngomado"];
              $nombreEntidadF = $listaVehiculosAsignados[$i]["nombreEntidadF"];
              $empleadoentidad = $listaVehiculosAsignados[$i]["empleadoentidad"];
              $empleadoConsecutivo = $listaVehiculosAsignados[$i]["empleadoConsecutivo"];
              $empleadoCategoria = $listaVehiculosAsignados[$i]["empleadoCategoria"];
              $nombreConGIf = $listaVehiculosAsignados[$i]["nombreConGIf"];
              $apellidoPConGif = $listaVehiculosAsignados[$i]["apellidoPConGif"];
              $apellidoMConGIf = $listaVehiculosAsignados[$i]["apellidoMConGIf"];
              $NombreSinGif = $listaVehiculosAsignados[$i]["NombreSinGif"]; 
              $apellidoPSinGifS = $listaVehiculosAsignados[$i]["apellidoPSinGifS"];
              $apellidoMSinGif = $listaVehiculosAsignados[$i]["apellidoMSinGif"]; 
              $EstatusConGif = $listaVehiculosAsignados[$i]["EstatusConGif"];
              $EstatusSinGif = $listaVehiculosAsignados[$i]["EstatusSinGif"];
              $DescripcionLineaNegocio = $listaVehiculosAsignados[$i]["DescripcionLineaNegocio"];
              $Numeropoliza = $listaVehiculosAsignados[$i]["Numeropoliza"];
              $FotoPoliza = $listaVehiculosAsignados[$i]["FotoPoliza"];
              $FotoTarjetaC = $listaVehiculosAsignados[$i]["FotoTarjetaC"];
              
              $listaVehiculosAsignados[$i]["verificacion"] = "Sin Verificacion por El Momento";
              $casopoliza =1;
              $casotarjeta =2;
              $casotalon =3;
              $casoLicencia =4;

              //*********************** Documetno De La Poliza**************************************
              if($FotoPoliza!=""){
              $listaVehiculosAsignados[$i]["Poliza"] =("<div id='verpdfvehiculos' title='Abrir Archivo' class='fa fa-file-pdf-o' style= 'font-size:30px;color:red;cursor:pointer;' onclick='cargarpdfVehiculos1(\"" . $casopoliza . "\",\"" . $FotoPoliza . "\");'> </div>");
              }else{
                 $listaVehiculosAsignados[$i]["Poliza"] ="Sin Foto Poliza";
              }
              //***********************Documento De La Tarjeta De Circulación***********************
              if($FotoTarjetaC!=""){
                //$log->LogInfo("Valor de FotoTarjetaC" . var_export ($FotoTarjetaC, true));
                $listaVehiculosAsignados[$i]["Tarjeta"] =("<div id='verpdfvehiculos' title='Abrir Archivo' class='fa fa-file-pdf-o' style= 'font-size:30px;color:red;cursor:pointer;' onclick='cargarpdfVehiculos1(\"" . $casotarjeta . "\",\"" . $FotoTarjetaC . "\");'> </div>");
              }else{
                $listaVehiculosAsignados[$i]["Tarjeta"] = "Sin Foto Tarjeta De Circulación";
              }
              //************************Documento Talón De Verificación*********************************
              $DocLicencia= $negocio -> TraerDocTalon($NumeroEconomico);
              $NombreTalon=$DocLicencia[0]["NombreTalon"];
              if($NombreTalon != null && $NombreTalon != "null" && $NombreTalon != NULL){
                 $listaVehiculosAsignados[$i]["verificacion"] =("<div id='verpdfvehiculos' title='Abrir Archivo' class='fa fa-file-pdf-o' style= 'font-size:30px;color:red;cursor:pointer;' onclick='cargarpdfVehiculos1(\"" . $casotalon . "\",\"" . $NombreTalon . "\");'> </div>");
              }else{
                $listaVehiculosAsignados[$i]["verificacion"] = "Sin Verificacion por El Momento";
              }
              //*************************Documento DE Licencia******************************************
              if($empleadoentidad != null && $empleadoentidad != "null" && $empleadoentidad != NULL){
                $DocLicencia= $negocio -> TraerDocLicencia($empleadoentidad,$empleadoConsecutivo,$empleadoCategoria);
                $RutaLicencia = $DocLicencia[0]["RutaLicencia"];
                $explodeRuta = explode("\\", $RutaLicencia);
                $conteoRuta = count($explodeRuta)-1;
                $NombreLicencia =$explodeRuta[$conteoRuta];
                $listaVehiculosAsignados[$i]["Licencia"] =("<div id='verpdfvehiculos' title='Abrir Archivo' class='fa fa-file-pdf-o' style= 'font-size:30px;color:red;cursor:pointer;' onclick='cargarpdfVehiculos1(\"" . $casoLicencia . "\",\"" . $NombreLicencia . "\");'> </div>");
              }else{
                $DocLicencia= $negocio -> TraerDocLicencia("09","0350","02");
                $RutaLicencia = $DocLicencia[0]["RutaLicencia"];
                $explodeRuta = explode("\\", $RutaLicencia);
                $conteoRuta = count($explodeRuta)-1;
                $NombreLicencia =$explodeRuta[$conteoRuta];
                $listaVehiculosAsignados[$i]["Licencia"] =("<div id='verpdfvehiculos' title='Abrir Archivo' class='fa fa-file-pdf-o' style= 'font-size:30px;color:red;cursor:pointer;' onclick='cargarpdfVehiculos1(\"" . $casoLicencia . "\",\"" . $NombreLicencia . "\");'> </div>");
               // $listaVehiculosAsignados[$i]["Licencia"] = "Sin Licencia Por el Momento";
              }
              //*****************************Empleado Asignado ********************************************
              if($EstatusConGif=='ACTIVO'){
                 $listaVehiculosAsignados[$i]["empleadoasignado"] = ($empleadoentidad . "-" . $empleadoConsecutivo . "-" . $empleadoCategoria . " " .  $nombreConGIf . " " . $apellidoPConGif . " " . $apellidoMConGIf);
              }else{//Si el empleado asignado no pertenece a gif se le asignara el del parque vehicular 
                  $listaVehiculosAsignados[$i]["empleadoasignado"] = ("09" . "-" . "0350" . "-" . "02" . " " .  "RICARDO" . " " . "ROSAS" . " " . "ORTIZ");
            }
          // }// primer for
        } // Segundo for(i)
		$response["data"]= $listaVehiculosAsignados;
	} 
	catch( Exception $e ){
	$response["status"]="error";
	$response["error"]="No se pudo obtener lista de puntos de servicio";
	}
echo json_encode($response);
?>