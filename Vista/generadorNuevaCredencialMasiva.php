<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
require('../libs/barcode/barcode.inc.php');

// $log = new KLogger ( "generadorCredencialesNuevas.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();

verificarInicioSesion ($negocio);

$entidadCredenciales=$_GET["entidadCredenciales"];
$empleados = $_GET ["empleados"];


if (empty($entidadCredenciales))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar credencial por que no se proporcionó entidad"
    );
    
    echo json_encode ($response);
    
    exit;
}

if (empty($empleados))
{
    $response = array (
        "status" => "error",
        "message" => "No se puede generar credencial por que no se proporcionó ningún empleado"
    );
    
    echo json_encode ($response);
    
    exit;
}

$empleados = json_decode ($empleados);

if (count ($empleados) == 0)
{
        $response = array (
        "status" => "error",
        "message" => "No se puede generar credencial por que no se proporcionó ningún empleado"
    );
    
    echo json_encode ($response);
    
    exit;
}

// $log -> LogInfo ("entidadCredenciales ".var_export ($entidadCredenciales, true));

$empleado= $negocio -> selectEmpleadosByEntidad($entidadCredenciales);
$response["empleado"]= $empleado;
$repse= $negocio -> negocio_obtenerRepse();
$NumAcuerdo = $repse[0]["NumAcuerdo"];
$NumFolioIngreso = $repse[0]["NumFolioIngreso"];

if (empty ($empleado))
{
    $response = array (
        "status" => "error",
        "message" => "El número de empleado proporcionado no se encuentra registrado en el sistema."
    );
    
    echo json_encode ($response);
    
    exit;
}

try{

// $log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));
// $log->LogInfo("Valor de la variable \$empleado empleado: " . var_export ($response["empleado"][0]["apellidoPaterno"], true));
//$log->LogInfo("Valor de la variable \$apellido paterno empleado: " . var_export ($response["empleado"]["apellidoPaterno"], true));
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

//echo “Hoy es:”.$diaSemana; //Imprimimos El día.


// El PDF se debe crear antes de iniciar el ciclo
$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/NC2.pdf");
$tplIdx = $pdf->importPage(1);


// Ponemos las coordenadas iniciales
$left = 33;
$top = 23;
$width = 166;
$height = 57;
$verticalspacer = 4.5;
$contador = 0;

$año_siguiente=date("Y");

for ($i=0; $i< count($response["empleado"]); $i++)
{   
    $apellidoPaterno=$response["empleado"][$i]["apellidoPaterno"];
    $apellidoMaterno=$response["empleado"][$i]["apellidoMaterno"];
    $nombreEmpleado=$response["empleado"][$i]["nombreEmpleado"];
    $empleadoNumeroSeguroSocial=$response["empleado"][$i]["empleadoNumeroSeguroSocial"];
    $rfcEmpleado=$response["empleado"][$i]["rfcEmpleado"];
    $calle = $response["empleado"][$i]["calle"];
    $numeroExterior = $response["empleado"][$i]["numeroExterior"];
    $numeroInterior = $response["empleado"][$i]["numeroInterior"];
    $fechaIngreso= $response["empleado"][$i]["fechaIngresoEmpleado"];
    $curp= $response["empleado"][$i]["curpEmpleado"];
    $puesto=$response["empleado"][$i]["descripcionPuesto"];
    $fotoEmpleado=$response["empleado"][$i]["fotoEmpleado"];
    $fecha2=date("m-d-Y",strtotime($fechaIngreso));
    $fecha3=date('d-m-Y', strtotime($fechaIngreso));
    $diaSemana=utf8_decode(strtoupper(strftime("%A", strtotime($fecha3)) )); 
    $nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha3)) )); // Guardamos el Nombre del día de la semana.
    $dia=strftime("%d", strtotime($fecha3));
    $anio=strftime("%Y", strtotime($fecha3));
    $empleadoEntidad=$response["empleado"][$i]["entidadFederativaId"];
    $empleadoConsecutivo=$response["empleado"][$i]["empleadoConsecutivoId"];
    $empleadoTipo=$response["empleado"][$i]["empleadoCategoriaId"];
    $fotoFirma=$response["empleado"][$i]["fotoFirma"];

    // $log->LogInfo("Valor de la variable \$fotoEmpleado empleado: " . var_export ($fotoEmpleado, true));

    $idEmpleado =  $response["empleado"][$i]["entidadFederativaId"] . "-" . 
        $response["empleado"][$i]["empleadoConsecutivoId"] . "-" .
        $response["empleado"][$i]["empleadoCategoriaId"];
        
    if (!in_array ($idEmpleado, $empleados))
    {
        continue;
    }
    
    // Si se han generado tres credenciales
    if ($contador % 1 == 0)
    {

       // Agregamos una página
        $pdf->addPage('P', 'Letter');
       
    }
    $pdf->Image('../archivos/NCF.jpg',0.2,1,54,86);

$pdf->SetFont("Arial", 'B',7);



//$pdf->useTemplate($tplIdx, 0, 0, 200);

//$pdf->useTemplate($tplIdx, 0, 0, 86);
$pdf->SetFont("Arial", '',7);

//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');

//$rutaImagen="thumbs/".$fotoEmpleado;


    if ($fotoEmpleado==""){
        $rutaImagen="img/person.png";
    }else{

    $rutaImagen="uploads/fotosempleados/".$fotoEmpleado;

        if (file_exists($rutaImagen)) {
       // echo "El fichero $nombre_fichero existe";

            //$rutaImagen="thumbs/".$fotoEmpleado;
            $rutaImagen="uploads/fotosempleados/".$fotoEmpleado;
        } else {
       // echo "El fichero $nombre_fichero no existe";
            $rutaImagen="img/person.png";
        }
    }
//$rutaImagen="uploads/fotosempleados/".$fotoEmpleado;

// $pdf->Text(132, 54.5, $empleadoNumeroSeguroSocial);
// $pdf->Text(164.5, 54.5, $curp);
$pdf->SetFont("Arial", '',7);
// $pdf->Text(129,59.5,$dia." DE ".$nombreMes." DE ".$anio);

$pdf->SetFont("Arial", 'B',8);
$pdf->SetTextColor(29,96,131);

$pdf->SetXY(0.3, 61.5);
$pdf->MultiCell(54, 2, utf8_decode(strtoupper($nombreEmpleado)),0,'C',0);

$pdf->SetXY(0.3, 66);
$pdf->MultiCell(54,2,utf8_decode($apellidoPaterno)." ".utf8_decode($apellidoMaterno),0,'C',0);

$pdf->SetXY(0.3, 70);
//$pdf->SetTextColor(244,169,000);
$pdf->MultiCell(54,2,$puesto,0,'C',0);

//$pdf->Image($rutaImagen,13,28.5,27);

$pdf->Image($rutaImagen,13,28.6,28.2,32);


    //$tplId2 = $pdf->importPage(2);
    $pdf->addPage('P', 'Letter');
    $pdf->Image('../archivos/NCA2.jpg',0.2,0.5,54,86);

$pdf->SetFont("Arial", 'B',6);
$pdf->SetTextColor(255,255,255);
$pdf->Text(44, 84.1, date("Y"));

$pdf->SetFont("Arial", 'B',5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(1, 4.8, "No. de acuerdo:");
$pdf->SetFont("Arial", '',3.7);
$pdf->SetTextColor(0,0,0);
$pdf->Text(0.5, 7.5, $NumAcuerdo);

$pdf->SetFont("Arial", 'B',4.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(38, 4.8, "No. de folio Ingreso:");
$pdf->SetFont("Arial", '',6);
$pdf->SetTextColor(0,0,0);
$pdf->Text(39, 7.5, $NumFolioIngreso);

$pdf->SetFont("Arial", '',11);
$pdf->SetTextColor(0,0,0);
$pdf->Text(20, 12.5, $empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo);


$pdf->SetFont("Arial", '',5.5);
$pdf->SetTextColor(0,0,0);
$pdf->Text(11.3, 16, "DGSP/188-12/2082");
$pdf->Text(41,16,$fecha3);
$pdf->Text(11.3, 20.5, "0439-16");
$pdf->Text(42, 20.5, "4094-16");
$pdf->Text(7, 24.5, $empleadoNumeroSeguroSocial);
$pdf->Text(30, 24.5, $curp);

$pdf->Image('../archivos/supervisor2.jpg',28,26.5,23);

$code='img/barcode/barcode_'.$empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo.'.gif';

new barCodeGenrator('*'.$empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo.'*',1,$code, 120, 100, true);
$pdf->Image($code,10,39,33.5,20);


if($fotoFirma!="")
{
$rutaFirma="uploads/firmas/".$fotoFirma;
//$pdf->Image($rutaFirma,3,24.5,22);
}

    if ($fotoFirma==""){
        $rutaImagen="img/person.png";
    }else{

    $rutaImagen="uploads/firmas/".$fotoFirma;

        if (file_exists($rutaImagen)) {
       // echo "El fichero $nombre_fichero existe";
            $pdf->Image($rutaFirma,3,24.5,22);


        } else {
       // echo "El fichero $nombre_fichero no existe";
            $rutaImagen="img/person.png";
        }
    }


}

// El PDF se finaliza después del ciclo
//$pdf->Output("credenciales/credenciales_" . $entidadCredenciales . ".pdf",'F');
//$pdf->Output("credenciales_" . $entidadCredenciales . ".pdf", "D");

$pdf->Output();



//echo "SE GENERARON LAS CREDENCIALES";
}
catch(Exception $e)
    {
        echo "NO SE GENERARON CREDENCIALES";
    }

$response = array("status" => "success");



?>