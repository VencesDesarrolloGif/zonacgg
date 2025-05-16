<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
  session_start ();
  require_once ("../Negocio/Negocio.class.php");
  require_once ("Helpers.php");
  $negocio = new Negocio ();
  $response = array ();
  $idcompro = array();
  $numreferencia = $_POST['numreferencia'];
  verificarInicioSesion ($negocio);
  if (!empty ($_POST))
    {
     try
      {
        $Registro_MovimientoComprobaciones = $negocio -> negocio_ValidacionReferenciaComprobaciones($numreferencia);
        
        $response ["status"] = "success";
        $response ["message"] = "Referencia Agregada Exitosamente";
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