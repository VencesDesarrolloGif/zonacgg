<?php
session_start();
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxObtenerVehiculosVerificacion.log" , KLogger::DEBUG );
$response = array("status" => "success");
$consulta=$_POST['consulta'];
$FechaInicial=$_POST['FechaInicial'];
$FechaFinal=$_POST['FechaFinal'];


// $log->LogInfo("Valor de la variable RolUsuarioVerificacion " . var_export ($RolUsuarioVerificacion, true));

try{
  $ListaVerifiacionDeVehiculo= $negocio -> traerHistoricoVerificacionVehiculo($consulta,$FechaInicial,$FechaFinal);
  $ListaVerifiacionDeVehiculo=array_merge($ListaVerifiacionDeVehiculo);// merge sirve para eliminar los campos vacion y hacer el consecutivo del array
  //$log->LogInfo("Valor de la variable listalicenciatotal " . var_export ($listalicenciatotal, true));
  for ($i = 0; $i < count($ListaVerifiacionDeVehiculo); $i++)
    {
      $idVerificacionV = $ListaVerifiacionDeVehiculo[$i]["idVerificacionV"];
      $idVehiculoAVerificar = $ListaVerifiacionDeVehiculo[$i]["idVehiculoAVerificar"];
      $PlacasVerificacion = $ListaVerifiacionDeVehiculo[$i]["PlacasVerificacion"];
      $idColorEngomadoVerificacion = $ListaVerifiacionDeVehiculo[$i]["idColorEngomadoVerificacion"];
      $VerificacionConstante = $ListaVerifiacionDeVehiculo[$i]["VerificacionConstante"];
      $CalendarioNormal = $ListaVerifiacionDeVehiculo[$i]["CalendarioNormal"];
      $MontoVerificacion = $ListaVerifiacionDeVehiculo[$i]["MontoVerificacion"];
      $SeVerificoATiempo = $ListaVerifiacionDeVehiculo[$i]["SeVerificoATiempo"];
      $PrimerSemestreDeVerificacion = $ListaVerifiacionDeVehiculo[$i]["PrimerSemestreDeVerificacion"];
      $SegundoSemestreDeVerificacion = $ListaVerifiacionDeVehiculo[$i]["SegundoSemestreDeVerificacion"];
      $Usuarioverificacion = $ListaVerifiacionDeVehiculo[$i]["Usuarioverificacion"];
      $FechaInsertVerificacion = $ListaVerifiacionDeVehiculo[$i]["FechaInsertVerificacion"];
      $FechaInicioVerificacion = $ListaVerifiacionDeVehiculo[$i]["FechaInicioVerificacion"];
      $FechaFinalVerificacion = $ListaVerifiacionDeVehiculo[$i]["FechaFinalVerificacion"];
      $SePagoMulta = $ListaVerifiacionDeVehiculo[$i]["SePagoMulta"];
      $MontoMulta = $ListaVerifiacionDeVehiculo[$i]["MontoMulta"];
      $FolioMulta = $ListaVerifiacionDeVehiculo[$i]["FolioMulta"];
      $FotoTalonVerificacion = $ListaVerifiacionDeVehiculo[$i]["FotoTalonVerificacion"];
      $FotoMultaVerificacion = $ListaVerifiacionDeVehiculo[$i]["FotoMultaVerificacion"];
      $PorQueNoPagoMulta = $ListaVerifiacionDeVehiculo[$i]["PorQueNoPagoMulta"];
      $Comentarios = $ListaVerifiacionDeVehiculo[$i]["Comentarios"];

      if($VerificacionConstante == "0"){
        $ListaVerifiacionDeVehiculo[$i]["VerificacionConstante"] = "No, Este Vehiculo Fue Confirmado Para NO Recibir Verificaciones";
        $ListaVerifiacionDeVehiculo[$i]["SeVerificoATiempo"] = " ";
        $ListaVerifiacionDeVehiculo[$i]["SePagoMulta"] = " ";
        $ListaVerifiacionDeVehiculo[$i]["CalendarioNormal"] = " ";
      }else{
        $ListaVerifiacionDeVehiculo[$i]["VerificacionConstante"] = "Si, Será Para Verificación Constante";
      }
      if($SeVerificoATiempo == "0" && $VerificacionConstante == "1"){
        $ListaVerifiacionDeVehiculo[$i]["SeVerificoATiempo"] = "No, Se Verificó Despues de la fecha final";
      }else if($SeVerificoATiempo == "1" && $VerificacionConstante == "1"){
        $ListaVerifiacionDeVehiculo[$i]["SeVerificoATiempo"] = "Si, Se Verificó En Tiempo Y Forma";
      }
      if($SePagoMulta=="0" && $VerificacionConstante == "1"){
        $ListaVerifiacionDeVehiculo[$i]["SePagoMulta"] = "No Realizó Pagó De Multa";
      }else if($SePagoMulta=="1" && $VerificacionConstante == "1"){
        $ListaVerifiacionDeVehiculo[$i]["SePagoMulta"] = "Si, Se Realizó Un Pago De Multa";
      }
      if($CalendarioNormal =="0" && $VerificacionConstante == "1"){
        $ListaVerifiacionDeVehiculo[$i]["CalendarioNormal"] = "No, Se Utilizó Una Fecha Diferente";
      }else if($CalendarioNormal =="1" && $VerificacionConstante == "1"){
        $ListaVerifiacionDeVehiculo[$i]["CalendarioNormal"] = "Si, Se Utilizó El Calendario Normal";
      }
      if($PrimerSemestreDeVerificacion == "1" && $SegundoSemestreDeVerificacion == "0"){
        $ListaVerifiacionDeVehiculo[$i]["SemestreVerificacion"] = "Primer Semestre";
      }else{
        if($PrimerSemestreDeVerificacion == "0" && $SegundoSemestreDeVerificacion == "1"){
          $ListaVerifiacionDeVehiculo[$i]["SemestreVerificacion"] = "Segundo Semestre";
        }else{
          $ListaVerifiacionDeVehiculo[$i]["SemestreVerificacion"] = "Este Vehiculo No Se Verifica";
        }
      }     
    } // for I
  $response["data"]= $ListaVerifiacionDeVehiculo;
}catch( Exception $e )
  {
  $response["status"]="error";
  $response["error"]="No se pudo obtener lista de las verificaciones de los vehiculos";
  }
echo json_encode($response);
?>