<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.  
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");

$negocio = new Negocio ();
$response = array ();
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajax_insertPeticionAsistenciaMerma.log" , KLogger::DEBUG );
if (!empty ($_POST))
{
//$opcion=$_POST["opcion"];
  $usuario = $_SESSION ["userLog"]["usuario"];
  $empleadoEntidadId=$_POST["empleadoEntidadId"];
  $empleadoConsecutivoId=$_POST["empleadoConsecutivoId"];
  $empleadoTipoId=$_POST["empleadoTipoId"];
  $empleadoPuntoServicioId=$_POST["empleadoPuntoServicioId"];
  $supervisorEntidadId=$_POST["supervisorEntidadId"];
  $supervisorConsecutivoId=$_POST["supervisorConsecutivoId"];
  $supervisorTipoId=$_POST["supervisorTipoId"];
  $incidenciaId=$_POST["incidenciaId"];
  $asistenciaFecha=$_POST["asistenciaFecha"];
  $comentariIncidencia=$_POST["comentariIncidencia"];
  $tipoPeriodo=$_POST["tipoPeriodo"];
  $puestoCubiertoId=$_POST["puestoCubiertoId"];
  $idCliente=$_POST["idCliente"];
  $valordia=$_POST["valordia"];
  $plantilladeservicio=$_POST["plantilladeservicio"];
  $idlineanegocioPunto=$_POST["idlineanegocioPunto"];
  $tipoIncidenciaPeticionM=$_POST["tipoIncidenciaPeticionM"];
  $idPlantillaServicio=$_POST["idPlantillaServicio"];
  $selectMotivoIncidenciaEspecial=$_POST["selectMotivoIncidenciaEspecial"];
  //$log->LogInfo("Valor de _POST" . var_export ($_POST, true));
  try
    {
      $Vigenciaplantilla = $negocio -> consultaVigenciaplantilla($idPlantillaServicio);
      $fecha_actual1 = $asistenciaFecha;
      $Fechaplantilla1 = $Vigenciaplantilla[0]["fechaTerminoPlantilla"]; 
      $fecha_actual = explode('-', $fecha_actual1);
      $fecha_actual_Anio = $fecha_actual[0];
      $fecha_actual_Mes = $fecha_actual[1];
      $fecha_actual_Dia = $fecha_actual[2];
      $Fechaplantilla = explode('-', $Fechaplantilla1);
      $Fechaplantilla_Anio = $Fechaplantilla[0];
      $Fechaplantilla_Mes = $Fechaplantilla[1];
      $Fechaplantilla_Dia = $Fechaplantilla[2];
      if($Fechaplantilla_Anio > $fecha_actual_Anio){
          $CondicionFecha = "1";
      }else{
          if($Fechaplantilla_Mes > $fecha_actual_Mes){
              $CondicionFecha = "1";
          }else{
              if($Fechaplantilla_Dia >= $fecha_actual_Dia){
                  $CondicionFecha = "1"; 
              }else{
                  $CondicionFecha = "0";
              }
          }
      }
      if($CondicionFecha=="1"){
        $negocio -> InsertarPeticioinAsistenciaMerma($usuario,$empleadoEntidadId,$empleadoConsecutivoId,$empleadoTipoId,$empleadoPuntoServicioId,$supervisorEntidadId,$supervisorConsecutivoId,$supervisorTipoId,$incidenciaId,$asistenciaFecha,$comentariIncidencia,$tipoPeriodo,$puestoCubiertoId,$idCliente,$valordia,$plantilladeservicio,$idlineanegocioPunto,$tipoIncidenciaPeticionM,$idPlantillaServicio,$selectMotivoIncidenciaEspecial);      
        $response ["status"] = "success";
        $response ["message"] = "Datos Imss registrados Exitosamente";
      }else{
        $response ["status"] = "error";
        $response ["message"] = "Error en la plantilla seleccionada, Ya culmino la vigencia de esta plantilla"; 
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