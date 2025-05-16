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

    echo "<script>alert('Error, numero de empleado inválido');window.close();</script>";
    
    exit;
}

//$log -> LogInfo ("entidadEmpleado ".var_export ($empleadoEntidad, true));
//$log -> LogInfo ("consecutivoEmpleado ".var_export ($empleadoConsecutivo, true));
//$log -> LogInfo ("empleadoTipo ".var_export ($empleadoTipo, true));

$empleado= $negocio -> negocio_obtenerEmpleadoPorId($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$usuario);
$fechaAlta=$empleado[0]["fechaIngresoEmpleado"];

$nombreEmpleado=$empleado[0]["nombreEmpleado"]." ".$empleado[0]["apellidoPaterno"]." ".$empleado[0]["apellidoMaterno"];


$entregas= $negocio -> obtenerUniformesEntregadosByEmpleado($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo);

if (empty ($entregas))
{
    echo "<script>alert('No hay uniformes recibidos actualmente');window.close();</script>";
    
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

$pageCount = $pdf->setSourceFile("../archivos/formatoBajaUniformes.pdf");
$tplIdx = $pdf->importPage(1);

$pdf->addPage();
//$pdf->useTemplate($tplIdx, 5, 0, 200);
$pdf->useTemplate($tplIdx, null, null, null, null, true); 

//$pdf->SetXY(80, 42);


$pdf->SetFont("Arial", 'B',11);

$pdf->Text(63, 31, utf8_decode($empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo));

$pdf->Text(63, 35.5, utf8_decode($fechaAlta));


$pdf->Text(95, 43, utf8_decode($fecha));


$pdf->Text(91, 51, utf8_decode($nombreEmpleado));
//inserto la cabecera poniendo una imagen dentro de una celda
//$pdf->Cell(50,50,$pdf->Image('img/09516003.jpg',10,20,20),1,1,'C');

//$pdf->SetXY(20, 80);

$pdf->SetFont("Arial", 'B',9);



$pdf->Text(90,159, utf8_decode($nombreUsuario." ".$apellidoP." ".$apellidoM));

$x=40;
$y=65;

for($i=0;$i< count($entregas);$i++){
    
    $descripcion=$entregas[$i]["descripcionTipo"];
    $codigo=$entregas[$i]["codigoUniforme"];
    $costo=$entregas[$i]["costoUniforme"];
    $pos = strpos($codigo, '-');
    if ($pos !== false) {
        $talla=substr($codigo, $pos+1,strlen($codigo)-1);
    }else{
        $talla='N/A';
    }
    $estatusInt=$entregas[$i]["estatusUniforme"];

    
    $estatus="";
    switch ($estatusInt) {
        case '0':
            $estatus="BIEN";
            break;
        case '1':
            $estatus="SUCIO";
            break;
        case '2':
            $estatus="MAL ESTADO";
            break;

        case '3':
            $estatus="COBRO";
            break;
    }

    $pdf->Text($x, $y, utf8_decode($descripcion));
    

    $x+=66;    

    $pdf->Text($x, $y, utf8_decode($talla)); 

    $x+=25;    

    $pdf->Text($x, $y, utf8_decode($estatus));     


    if($estatusInt==3){
        $x+=40;
        $pdf->Text($x, $y,utf8_decode("$".number_format((float)$costo, 2, '.', ',')));
        $x-=131;
    }else{
        $x-=91;
    }
    
    $y+=3.8;


    
}




//ESPACIO PARA FECHA Y ENTIDAD

$pdf->Text(55,244, utf8_decode($entidad));



//NOMBRE DEL TESTIGO ES EL NOMBRE DE USUARIO


//NOMBRE DEL EMPLEADO


$pdf->Output();
$response = array("status" => "success");



?>

