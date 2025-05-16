<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
require "conexion.php";
//$log = new KLogger ( "ajaxObtenerVehiculosVerificacion.log" , KLogger::DEBUG );
// $entidadesusuarioPoliza=$_SESSION ["userLog"]["entidadFederativaUsuario"];
// $log->LogInfo("Valor de la variable RolUsuarioVerificacion " . var_export ($RolUsuarioVerificacion, true));
$response = array("status" => "success");
$consulta=$_POST['consulta'];
$nombreusuarioPoliza=$_SESSION ["userLog"]["usuario"];
$rolusr=$_SESSION ["userLog"]["rol"];

$usuarioId=$_SESSION['userLog']['usuarioId'];
$regionUsr          = array();
$entidades          = array();

try{

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

        $entidadesusuarioPoliza = implode(',', $entidadesRegion);
  }else{
        $entidadesusuarioLic = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32'];
        $entidadesusuarioPoliza = implode(',', $entidadesusuarioLic);

  } 
//ACTUALIZAR PERSISTENCIA**********************************************************************************************
  $listapoliza= $negocio -> traerlistaPolizaV($entidadesusuarioPoliza,$nombreusuarioPoliza,$consulta,$rolusr);
  $listapoliza=array_merge($listapoliza);// merge sirve para eliminar los campos vacion y hacer el consecutivo del array
 // $log->LogInfo("Valor de la variable listalicenciatotal " . var_export ($listalicenciatotal, true));
  for ($i = 0; $i < count($listapoliza); $i++)
    {
      $listapoliza[$i]["NumeroEconomico"];
      $listapoliza[$i]["Placas"];
      $listapoliza[$i]["LineaNegocio"];
      $listapoliza[$i]["EntidadFederativa"];
      $listapoliza[$i]["Marca"];
      $listapoliza[$i]["Modelo"];
      $FechaPoliza = $listapoliza[$i]["FechaPoliza"];
      $listapoliza[$i]["Aseguradora"];
      $NumeroPoliza = $listapoliza[$i]["NumeroPoliza"];
    
    if($FechaPoliza == "" || $FechaPoliza == "null" || $FechaPoliza == "NULL" || $FechaPoliza == null || $FechaPoliza == NULL){
        $listapoliza[$i]["FechaPoliza"] ="Sin Fecha Agregada Aun";
        //$listalicenciatotal[$i]["FechaVigenciaLicencia"]="Sin Datos De Licencia";
      }
    if($NumeroPoliza== "" || $NumeroPoliza == "null" || $NumeroPoliza == "NULL" || $NumeroPoliza == null || $NumeroPoliza == NULL){
      $listapoliza[$i]["NumeroPoliza"] = " ";
    }
    else{
      $listapoliza[$i]["NumeroPoliza"] =$NumeroPoliza; // $poliza = "\"" . $webos. "\""; 
    }

    } // for I
  $response["data"]= $listapoliza;
}catch( Exception $e )
  {
  $response["status"]="error";
  $response["error"]="No se pudo obtener lista de las Polizas de Los vehiculos";
  }
echo json_encode($response);
?> 