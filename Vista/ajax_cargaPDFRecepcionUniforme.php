<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
//$log = new KLogger ( "generarpdfRecp.log" , KLogger::DEBUG );
$negocio = new Negocio();
$response = array ();
verificarInicioSesion ($negocio);
$usuario = $_SESSION ["userLog"]["usuario"];
$nombreUsuario = $_SESSION ["userLog"]["nombre"];
$apellidoP = $_SESSION ["userLog"]["apellidoPaterno"];
$apellidoM = $_SESSION ["userLog"]["apellidoMaterno"];
$empleadoEntidad=$_GET["empleadoEntidad"];
$empleadoConsecutivo=$_GET["empleadoConsecutivo"];
$empleadoTipo=$_GET["empleadoCategoria"];
$fechaAlta=$_GET["fechaIngresoEmpleado"];
$apellidoPaterno=$_GET["apellidoPaterno"];
$apellidoMaterno=$_GET["apellidoMaterno"];
$entidad = $_SESSION ["userLog"]["nombreEntidad"];
$caso=$_GET["caso"];
$nombre1=$_GET["nombre1"];
$nombre2=$_GET["nombre2"];
$nombre3=$_GET["nombre3"];
$nombre4=$_GET["nombre4"];
$NombreEncargado=$_GET["NombreEncargado"];
$FirmaEncargado=$_GET["FirmaEncargado"];
$tipoMovimiento=$_GET["tipoMovimiento"];
$NombreEncargado1 = strtr($NombreEncargado, "-", " ");
if ($caso==1) {
    $nombreEmpleado=$nombre1." ".$apellidoPaterno." ".$apellidoMaterno;
}else if ($caso==2) {
    $nombreEmpleado=$nombre1." ".$nombre2." ".$apellidoPaterno." ".$apellidoMaterno;
}else if ($caso==3) {
    $nombreEmpleado=$nombre1." ".$nombre2." ".$nombre3." ".$apellidoPaterno." ".$apellidoMaterno;
}else if ($caso==4) {
    $nombreEmpleado=$nombre1." ".$nombre2." ".$nombre3." ".$nombre4." ".$apellidoPaterno." ".$apellidoMaterno;
}

//$log -> LogInfo ("nombreEmpleado ".var_export ($nombreEmpleado, true));
//$log -> LogInfo ("caso ".var_export ($caso, true));
$entregas= $negocio -> obtenerUniformesEntregadosByEmpleadoHistorico($empleadoEntidad, $empleadoConsecutivo, $empleadoTipo,$tipoMovimiento);
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../archivos/formatoBajaUniformes.pdf");
$tplIdx = $pdf->importPage(1);
$pdf->addPage();
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont("Arial", 'B',11);
$pdf->Text(63, 31, utf8_decode($empleadoEntidad."-".$empleadoConsecutivo."-".$empleadoTipo));
$pdf->Text(63, 35.5, utf8_decode($fechaAlta));

$pdf->Text(91, 51, utf8_decode($nombreEmpleado));
$pdf->SetFont("Arial", 'B',9);
//$pdf->Text(90,159, utf8_decode($nombreUsuario." ".$apellidoP." ".$apellidoM));
$pdf->Text(92,156, utf8_decode($NombreEncargado1));
$pdf->Text(90,159, utf8_decode($FirmaEncargado));

$x=40;
$y=65;
for($i=0;$i< count($entregas);$i++){
    $fecha = $entregas[$i]["fechaRecibidoHis"];
    $descripcion=$entregas[$i]["descripcionTipo"];
    $codigo=$entregas[$i]["codigoUniforme"];
    $costo=$entregas[$i]["montoDeudaHA"];
    $pos = strpos($codigo, '-');
    if ($pos !== false) {
        $talla=substr($codigo, $pos+1,strlen($codigo)-1);
    }else{
        $talla='N/A';
    }
    $estatusInt=$entregas[$i]["estatusUniformeRecibido"];
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
    //if($estatusInt==3){
        $x+=40;
        $pdf->Text($x, $y,utf8_decode("$".number_format((float)$costo, 2, '.', ',')));
        $x-=131;
   // }else{

      //  $x-=91;
   // }
    $y+=3.8;
}
$nombreMes=utf8_decode(strtoupper(strftime("%B", strtotime($fecha)) )); // Guardamos el Nombre del día de la semana.
$dia=strftime("%d", strtotime($fecha));
$anio=strftime("%Y", strtotime($fecha));
$pdf->Text(95, 43, utf8_decode($fecha));//se trae la ultima fecha de recepcion
//ESPACIO PARA FECHA Y ENTIDAD
$pdf->Text(46,244, utf8_decode($entidad));
$pdf->Text(87,244, utf8_decode($dia."          ".$nombreMes."                     ".$anio));

$pdf->Output();
$response = array("status" => "success");



?>

