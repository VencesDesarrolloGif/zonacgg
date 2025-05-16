<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datos=array();
$total=array();
$dato1=array();
$usuario = $_SESSION ["userLog"]["rol"];
// $log = new KLogger ( "ajaxttraetotalesentidades.log" , KLogger::DEBUG );
$lineanegociogastocosto = $_POST['lineanegociogastocosto'];//1
$acciongastocosto=$_POST['acciongastocosto'];
$entidasgastocosto=$_POST['entidasgastocosto'];
$fechafinal=$_POST['fechafinal'];
$fechainicio=$_POST['fechainicio'];
verificarInicioSesion ($negocio);
if (!empty ($_POST))
{
  try
  { 
    if($lineanegociogastocosto=="TODOS")
    {
      $case=0;
      $lineanegociogastocostoconsulta = $negocio->negocio_obtenerLineadenegociogastocosto($case,1);  // 5

    }else{
      $lineanegociogastocostoconsulta[0]=1;
    }
    for($j=1;$j<=(count($lineanegociogastocostoconsulta));$j++)
    {
      if($lineanegociogastocosto=="TODOS")
          {
            $case=1;
            $lineanegocioconsulta1 = $negocio->negocio_obtenerLineadenegociogastocosto($case,$j);  
            $lineanegocioconsulta=$lineanegocioconsulta1[0]["idLineaNegocio"];
            $Conceptos = $negocio->negocio_obtenerListaClaveClasificacion($lineanegocioconsulta,$usuario);
            $lineanegociogastocosto1=$lineanegocioconsulta;
            // $log->LogInfo("Valor de la variable 1 \$lineanegociogastocosto1: " . var_export ($lineanegociogastocosto1, true));
          }
        else
          {
            $lineanegociogastocosto1=$lineanegociogastocosto;
            $Conceptos = $negocio->negocio_obtenerListaClaveClasificacion($lineanegociogastocosto1,$usuario);
          }
    //   $log->LogInfo("Valor de la variable \$lineanegociogastocosto: " . var_export (count($Conceptos), true));
      for($i=0;$i<(count($Conceptos));$i++)
        {
          $idtipogastocosto=$Conceptos[$i]["idTipoCostoGasto"];
          $descclasi= $Conceptos[$i]["descripcionClasificacion"]; 
          $claveclasi= $Conceptos[$i]["claveClasificacion"];
          $deslineagoc= $Conceptos[$i]["descripcionLineaNegocio"]; 
          if($acciongastocosto==0)
          {
            $totalsumatoria= $negocio->negocio_obtenerTotalGastoCosto($lineanegociogastocosto1,$claveclasi,$entidasgastocosto,
            $acciongastocosto,$fechafinal,$fechainicio);
          }else if($acciongastocosto==1){
            $totalsumatoria= $negocio->negocio_obtenerTotalGastoCosto($lineanegociogastocosto1,$claveclasi,$entidasgastocosto,
            $acciongastocosto,$fechafinal,$fechainicio);
          }else if($acciongastocosto==2){
             $totalsumatoria= $negocio->negocio_obtenerTotalGastoCosto($lineanegociogastocosto1,$claveclasi,$entidasgastocosto,
             $acciongastocosto,$fechafinal,$fechainicio);
          }
          if ($idtipogastocosto=1){
      
            $datos[$i]["costofijo"] = $totalsumatoria[0]["totalsumatoria"]; 
            $datos[$i]["costovariable"]="0";
            $datos[$i]["gastodirecto"]="0";
            $datos[$i]["gastoindirecto"]="0";
            $datos[$i]["totalIva"] = $totalsumatoria[0]["totalIva"];
          }
          else if ($idtipogastocosto=2){
            $datos[$i]["costofijo"] ="0"; 
            $datos[$i]["costovariable"]=$totalsumatoria[0]["totalsumatoria"];
            $datos[$i]["gastodirecto"]="0";
            $datos[$i]["gastoindirecto"]="0";
            $datos[$i]["totalIva"] = $totalsumatoria[0]["totalIva"];
          }
          else if ($idtipogastocosto=3){
            $datos[$i]["costofijo"] ="0"; 
            $datos[$i]["costovariable"]="0";
            $datos[$i]["gastodirecto"]=$totalsumatoria[0]["totalsumatoria"];
            $datos[$i]["gastoindirecto"]="0";
            $datos[$i]["totalIva"] = $totalsumatoria[0]["totalIva"];
          }
          else if ($idtipogastocosto=4){
            $datos[$i]["costofijo"] ="0"; 
            $datos[$i]["costovariable"]="0";
            $datos[$i]["gastodirecto"]="0";
            $datos[$i]["gastoindirecto"]=$totalsumatoria[0]["totalsumatoria"];
            $datos[$i]["totalIva"] = $totalsumatoria[0]["totalIva"];
          }         
        
        $datos[$i]["cancepto"]=$descclasi;
        $datos[$i]["LineaNegocio"]=$deslineagoc;
      }
      $response[$j]["status"] = "success";
      $response[$j]["datos"] = $datos;
      $response[$j]["lineaneg"] = count($lineanegociogastocostoconsulta);
    }
    
  } 
  catch (Exception $e)
  {
    $response ["status"] = "error";
    $response ["message"] =  $e -> getMessage ();
  }       
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>