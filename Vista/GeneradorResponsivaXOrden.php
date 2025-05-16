<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
//$log = new KLogger ( "generadorResponsivaXOrden.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de variable de empleadoId que viene de nombreEmpleadoG" . var_export ($nombreEmpleadoG, true));
$negocio = new Negocio();
$response = array ();
verificarInicioSesion ($negocio);
$empleadoEntidad    =$_GET["entidadEmpleado"];
$empleadoConsecutivo=$_GET["consecutivoEmpleado"];
$empleadoTipo       =$_GET["tipoEmpleado"];
$orden              =$_GET["noordenID"];
$entidadCod         =$_SESSION ["userLog"]["entidadFederativaUsuario"];

if($entidadCod=='09'){
   $entidad="MEXICO, CDMX";
  }

if(empty($empleadoEntidad) || empty ($empleadoConsecutivo) || empty ($empleadoTipo)){
   $response = array ("status" => "error", "message" => "No se puede generar la responsiva por que no se proporcionó un número de empleado válido.");
   echo json_encode ($response);
   exit;
  }

$asignaciones= $negocio -> obtenerAsignacionesByEmpleadotmp($empleadoEntidad,$empleadoConsecutivo, $empleadoTipo,$orden);
    $nombreEmpleadoG = $asignaciones[0]["nombreHA"];
    $fecha = $asignaciones[0]["fechaAsignacionHis"];
    $nombreCompEmp = $asignaciones[0]["nombreEmpAlm"];
    $firmaEmpAlmacenpdf=$asignaciones[0]["firmaEmpAlmacen"];
    $firmaGuardiapdf   =$asignaciones[0]["firmaGuardia"];
    //$monto   =$asignaciones[0]["montoDeudaHA"];//poner cantidad
    $entidad =$_SESSION ["userLog"]["nombreEntidad"];



date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
//echo “Hoy es:”.$diaSemana; //Imprimimos El día.
//$fecha=date("Y")."-".date("m")."-".date("d");
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha));
$anio=strftime("%Y", strtotime($fecha));

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/formatoAltaUniformes.pdf");//se declara la ubicacion del pdf
$tplIdx = $pdf->importPage(1);
$pdf->addPage();
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',11);
$pdf->Text(170, 50, utf8_decode($empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo));
$pdf->SetFont("Arial", 'B',10);
$x=35;
$y=74;

for($i=0;$i< count($asignaciones);$i++){

    $talla = $asignaciones[$i]["tallaUniforme"];
    $descripcion=$asignaciones[$i]["descripcionUnif"];
    $cantidad=$asignaciones[$i]["cantidadUniformeHis"];
    /*$pos = strpos($codigo, '-');
    if($pos !== false){
        $talla=substr($codigo, $pos+1,strlen($codigo)-1);
      }else{
            $talla='N/A';
           }*/

    $pdf->Text($x, $y, utf8_decode($descripcion));
    $x+=80;
    $pdf->Text($x, $y, utf8_decode($cantidad));
    $x+=27;
    $pdf->Text($x, $y, utf8_decode($talla));        
    $x-=107;
    $y+=4.3;
}
//ESPACIO PARA FECHA Y ENTIDAD
$pdf->Text(42,225, utf8_decode($entidad));
$pdf->Text(83,225, utf8_decode($dia."         ".$nombreMes."                     ".$anio));
//NOMBRE DEL TESTIGO ES EL NOMBRE DE USUARIO
$pdf->Text(45,250, utf8_decode($firmaEmpAlmacenpdf));
$pdf->Text(48,245, utf8_decode($nombreCompEmp));
//NOMBRE DEL EMPLEADO
$pdf->Text(130,250, utf8_decode($firmaGuardiapdf));
$pdf->Text(133,245, utf8_decode($nombreEmpleadoG));
$pdf->Output();
$response = array("status" => "success");
?>

