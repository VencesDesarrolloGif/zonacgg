<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

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

$pageCount = $pdf->setSourceFile("../archivos/credencialesv2.pdf");
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

    // $log->LogInfo("Valor de la variable \$fotoEmpleado empleado: " . var_export ($fotoEmpleado, true));

    $idEmpleado =  $response["empleado"][$i]["entidadFederativaId"] . "-" . 
        $response["empleado"][$i]["empleadoConsecutivoId"] . "-" .
        $response["empleado"][$i]["empleadoCategoriaId"];
        
    if (!in_array ($idEmpleado, $empleados))
    {
        continue;
    }
    
    // Si se han generado tres credenciales
    if ($contador % 3 == 0)
    {
        // Reiniciamos las coordenadas a la posición inicial
        $left = 33;
        $top = 23;
        $width = 166;
        $height = 57;
        
        // Agregamos una página
        $pdf->addPage('P', 'Letter');
    }



    // Código de referencia para mostrar un recuadro verde alrededor de la credencial
    // y así poder identificar los limites de los elementos.
    /* */
    //$pdf -> SetDrawColor (255,0,0);
    //$pdf -> Line ($left, $top, $left + $width, $top);
    //$pdf -> Line ($left, $top, $left, $top + $height);

    //$pdf -> Line ($left, $top + $height, $left + $width, $top + $height);
    //$pdf -> Line ($left + $width, $top, $left + $width, $top + $height);
    //$pdf -> SetDrawColor (0,0,0);
    /* */

    $pdf->SetTextColor(0,0,0);

    $pdf->Image('img/Firma3.jpg', $left + 17, $top + 45, 25);
    $pdf->Image('img/Imagen3.jpg', $left + 10, $top + 12, 35);

    $pdf->Image('img/folioGif.jpg', $left + 107, $top + 1, 50);

    $pdf->SetFont("Arial", 'B',11);

    $pdf->SetXY($left, $top + 22);
    $pdf->MultiCell(56,4,utf8_decode($nombreEmpleado),0,'C',0);

    $pdf->SetXY($left, $top + 30);
    $pdf->MultiCell(56,4,utf8_decode($apellidoPaterno)." ".utf8_decode($apellidoMaterno),0,'C',0);

    $pdf->SetFont("Arial", 'B',7);
    $pdf->Text($left + 153, $top + 10.5, $año_siguiente);

    $pdf->useTemplate($tplIdx, 5, null, 200);
    $pdf->SetFont("Arial", '',8);

    //inserto la cabecera poniendo una imagen dentro de una celda
    //$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');

    if ($fotoEmpleado==""){
        $rutaImagen="img/person.png";
    }else{

    $rutaImagen="thumbs/".$fotoEmpleado;

        if (file_exists($rutaImagen)) {
       // echo "El fichero $nombre_fichero existe";

            $rutaImagen="thumbs/".$fotoEmpleado;
        } else {
       // echo "El fichero $nombre_fichero no existe";
            $rutaImagen="img/person.png";
        }
    }

    // $log->LogInfo("Valor de la variable \$rutaImagen2 rutaImagen2: " . var_export ($rutaImagen, true));

    $pdf->Image($rutaImagen, $left + 57, $top + 14,24);

    $pdf->Text($left + 99, $top + 31.5, $empleadoNumeroSeguroSocial);
    $pdf->Text($left + 131.5, $top + 31.5, $curp);
    $pdf->SetFont("Arial", '',6);
    $pdf->Text($left + 96,$top + 36.5,$dia." DE ".$nombreMes." DE ".$anio);

    $pdf->SetFont("Arial", 'B',11);
    $pdf->SetTextColor(244,169,000);

    $pdf->SetXY($left, $top + 38);
    $pdf->MultiCell(55,4,$puesto,0,'C',0);

    $pdf->SetFont("Arial", 'B',11);
    $pdf->SetTextColor(231,037,018);
    $pdf->Text($left + 132, $top + 5.5, $empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo);

    // Incrementamos la posición vertical para la siguiente credencial
    $top += $height + $verticalspacer;
    
    // Incrementamos el contador de credenciales
    $contador ++;
}

// El PDF se finaliza después del ciclo
//$pdf->Output("credenciales/credenciales_" . $entidadCredenciales . ".pdf",'F');
$pdf->Output("credenciales_" . $entidadCredenciales . ".pdf", "D");

//echo "SE GENERARON LAS CREDENCIALES";
}
catch(Exception $e)
    {
        echo "NO SE GENERARON CREDENCIALES";
    }

$response = array("status" => "success");



?>