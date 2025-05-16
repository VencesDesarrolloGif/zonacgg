<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
 $lista=array();
  $datos=array();
verificarInicioSesion ($negocio);
//$response = array("status" => "success");
$empleado=$_POST["emp"];


//$lblCLienteCaja=$_POST["lblCLienteCaja"];
//$log = new KLogger ( "ajax_Generador.log" , KLogger::DEBUG );
 //$log->LogInfo("Valor de la variable \$_POST: " . var_export ($valorselectorbanco, true));

    
   if (!empty ($_POST))
{
$empleadoidd = explode("-", $empleado);

$entidad=$empleadoidd[0];
$consecutivo=$empleadoidd[1];
$categoria=$empleadoidd[2];

    try
    {
       $lista= $negocio -> negocio_Generador($entidad,$consecutivo,$categoria);
    // $log->LogInfo("Valor de la variable \$_POST: " . var_export ($lista, true));
        $response ["status"] = "success";

        $datos["pdf"]= "<i  title='Generar pdf' class='fa fa-file-pdf-o' style='font-size:30px;color:red;cursor:pointer;' id='btnconfirmar' onclick='visualizarpdf(\"" . $lista[0]['EntidadEmpCaja'] . "\",\"" . $lista[0]['consecutivoEmpCaja'] . "\",\"" . $lista[0]['categoriaEmpCaja'] . "\",\"" . $lista[0]['fechaAutoriza'] . "\",\"" . $lista[0]['idAutCaja'] . "\")'></i>";
       $response ["datos"] = $datos;
       $response ["lista"] = $lista;
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