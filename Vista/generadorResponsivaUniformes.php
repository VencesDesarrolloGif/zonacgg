<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');




//$log = new KLogger ( "generarCartaPatronal.log" , KLogger::DEBUG );

$negocio = new Negocio();
$response = array ();

verificarInicioSesion ($negocio);

$empleadoEntidad=$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo=$_GET["tipoEmpleado"];

$nombreUsuario = $_SESSION ["userLog"]["nombre"];
$apellidoP = $_SESSION ["userLog"]["apellidoPaterno"];
$apellidoM = $_SESSION ["userLog"]["apellidoMaterno"];
$entidadCod = $_SESSION ["userLog"]["entidadFederativaUsuario"];
$entidad = $_SESSION ["userLog"]["nombreEntidad"];
$usuario=$_SESSION ["userLog"];

if($entidadCod=='09'){
    $entidad="MEXICO, CDMX";
}




if (empty($empleadoEntidad)
    || empty ($empleadoConsecutivo)
    || empty ($empleadoTipo))
{

    $response = array (
        "status" => "error",
        "message" => "No se puede generar la responsiva por que no se proporcionó un número de empleado válido."
    );
    
    echo json_encode ($response);
    
    exit;
}

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));

$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);


$nombreEmpleado=$empleado[0]["nombreEmpleado"]." ".$empleado[0]["apellidoPaterno"]." ".$empleado[0]["apellidoMaterno"];


$asignaciones= $negocio -> obtenerAsignacionesByEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);

if (empty ($asignaciones))
{
    echo "<script>alert('No hay asignaciones disponibles');window.close();</script>";
    
    exit;
}

//$log->LogInfo("Valor de la variable \$response empleado: " . var_export ($response, true));
//$log->LogInfo("Valor de la variable \$empleado empleado: " . var_export ($response["empleado"][0]["apellidoPaterno"], true));
//$log->LogInfo("Valor de la variable \$apellido paterno empleado: " . var_export ($response["empleado"]["apellidoPaterno"], true));
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

//echo “Hoy es:”.$diaSemana; //Imprimimos El día.
$fecha=date("Y")."-".date("m")."-".date("d");

$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha));
$anio=strftime("%Y", strtotime($fecha));


//$fecha2=date("m-d-Y",strtotime($fechaIngreso));

//$nombreMunicipio =  $response["empleado"][0]["nombreMunicipio"].",".$response["empleado"][0]["nombreEntidadFederativa"];

//$fecha4=date('d-m-Y', strtotime(getdate()));

$pdf = new FPDI();

$pageCount = $pdf->setSourceFile("../archivos/formatoAltaUniformes.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage();
//$pdf->useTemplate($tplIdx, 5, 0, 200);
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',11);

//$pdf->SetXY(80, 42);
$pdf->Text(170, 50, utf8_decode($empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo));

$pdf->SetFont("Arial", 'B',10);
//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');

//$pdf->SetXY(20, 80);
$x=35;
$y=74;

for($i=0;$i< count($asignaciones);$i++){

    $cantidad=$asignaciones[$i]["cantidadUniforme"];
    $descripcion=$asignaciones[$i]["descripcionTipo"];
    $codigo=$asignaciones[$i]["codigoUniforme"];
    $pos = strpos($codigo, '-');
    if ($pos !== false) {
        $talla=substr($codigo, $pos+1,strlen($codigo)-1);
    }else{
        $talla='N/A';
    }

    $pdf->Text($x, $y, utf8_decode($descripcion));
    

    $x+=80;

    $pdf->Text($x, $y, utf8_decode($cantidad));

    $x+=27;

    $pdf->Text($x, $y, utf8_decode($talla));        

    $x-=107;
    $y+=4.3;
    
}

//ESPACIO PARA FECHA Y ENTIDAD

$pdf->Text(48,225, utf8_decode($entidad));

$pdf->Text(83,225, utf8_decode($dia."         ".$nombreMes."                     ".$anio));


//NOMBRE DEL TESTIGO ES EL NOMBRE DE USUARIO
$pdf->Text(45,250, utf8_decode($nombreUsuario." ".$apellidoP." ".$apellidoM));

//NOMBRE DEL EMPLEADO

$pdf->Text(135,250, utf8_decode($nombreEmpleado));

$pdf->Output();
$response = array("status" => "success");



?>

