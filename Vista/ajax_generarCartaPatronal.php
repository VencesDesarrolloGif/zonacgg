<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

$negocio = new Negocio ();

$response = array ();

verificarInicioSesion ($negocio);



if (!empty ($_POST))
{
//$log = new KLogger ( "ajaxGenerarCartaPatronal.log" , KLogger::DEBUG );


    $apellidoPaterno=getValueFromPost("apellidoPaternoEmpleado");
    $apellidoMaterno=getValueFromPost("apellidoMaternoEmpleado");
    $nombreEmpleado=getValueFromPost("nombreEmpleado");




     //$log->LogInfo("Valor de la variable \$cartapatronal: " . var_export ($apellidoPaterno, true));
     //$log->LogInfo("Valor de la variable \$cartapatronal: " . var_export ($apellidoMaterno, true));
     //$log->LogInfo("Valor de la variable \$cartapatronal: " . var_export ($nombreEmpleado, true));
    try
    {

        $pdf = new FPDI();

        $pageCount = $pdf->setSourceFile("../archivos/cartapatronalblanco2.pdf");
        $tplIdx = $pdf->importPage(1);

        $pdf->addPage();
        $pdf->useTemplate($tplIdx, 5, 0, 200);
        $pdf->SetFont("Arial", '',12);
        $pdf->Cell(300,500,$nombreEmpleado,0);


        $pdf->Output();

        
        $response ["status"] = "success";
        $response ["message"] = "Se genero Documento";
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