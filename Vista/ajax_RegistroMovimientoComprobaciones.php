<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
  session_start ();
  require_once ("../Negocio/Negocio.class.php");
  require_once ("Helpers.php");
  $negocio = new Negocio ();
  $response = array ();
  $idcompro = array();
  $impid                    = $_POST['impid'];
  $inBeneficiarioCompro     = $_POST['inBeneficiarioCompro'];
  $inConceptoCompro         = $_POST['inConceptoCompro'];
  $inNumeroReferenciaCompro = $_POST['inNumeroReferenciaCompro'];
  $inSubTotalCompro         = $_POST['inSubTotalCompro'];
  $inDescuentoCompro        = $_POST['inDescuentoCompro'];
  $inIvaRetenidoCompro      = $_POST['inIvaRetenidoCompro'];
  $inselectIvaCompro        = $_POST['inselectIvaCompro'];
  $inTotalCompro            = $_POST['inTotalCompro'];

  verificarInicioSesion ($negocio);
  if (!empty ($_POST))
    {
//$log = new KLogger ( "ajaxRegistroMovimientoCmprobaciones.log" , KLogger::DEBUG );
  // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($_POST, true));
     // $log->LogInfo("Valor de la variableeeeeeee \$movimientoComprobaciones: " . var_export ($movimientoComprobaciones, true));
     try
      {
        for($i=0;$i<count($inConceptoCompro);$i++)
        {
          //$log -> LogInfo ("valor de i--->". var_export($Registro_MovimientoCobranza,true));
          $Registro_MovimientoComprobaciones = $negocio -> negocio_RegistrarMovimientoComprobacion($impid,$inBeneficiarioCompro[$i],$inConceptoCompro[$i],$inNumeroReferenciaCompro[$i],$inSubTotalCompro[$i],$inDescuentoCompro[$i],$inIvaRetenidoCompro[$i],$inselectIvaCompro[$i],$inTotalCompro[$i]);

           //$log->LogInfo("Valor de la variable \$_POST: " . var_export ($Registro_MovimientoComprobaciones, true));

          $Registro_MovimientoComprobaciones1[$i] = $Registro_MovimientoComprobaciones[0]['idMovimientoCompro'];
        }

       
        $response ["status"] = "success";
        $response ["message"] = "Empleado registrado éxitosamente";
        $response ["idMovimientoCompro"] =$Registro_MovimientoComprobaciones1;
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