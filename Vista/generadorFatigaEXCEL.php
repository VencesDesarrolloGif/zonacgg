<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once("../Negocio/Negocio.class.php");
require_once("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');

define ("BOTTOM_MARGIN", 180);


$negocio = new Negocio();
$response = array ();

date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local

verificarInicioSesion ($negocio);
//$log = new KLogger ( "generarFormatoFatiga.log" , KLogger::DEBUG );
//$log->LogInfo("Valor de la variable _GET: " . var_export ($_GET, true));
$usuarioCapturaNombre=$_SESSION ["userLog"]["nombre"];
$usuarioCapturApellidoMaterno=$_SESSION ["userLog"]["apellidoMaterno"];
$usuarioCapturaApellidoPaterno=$_SESSION ["userLog"]["apellidoPaterno"];
$rolUsuario=$_SESSION ["userLog"]["rol"];

$idPuntoServicio=$_GET["idPuntoServicio"];
$idSupervisor=$_GET["idSupervisor"];
$fecha1=$_GET["fecha1"];
$fecha2=$_GET["fecha2"];
$entidadId=$_GET["entidadId"];



if($rolUsuario=="Facturacion"){

    if($idPuntoServicio=="TODOS" && $idSupervisor!="SUPERVISOR"){

        $idSupervisorid = explode("-", $idSupervisor);
        $supervisorEntidad=$idSupervisorid[0];
        $supervisorConsecutivo=$idSupervisorid[1];
        $supervisorTipo=$idSupervisorid[2];

        $listaPuntos= $negocio ->getPuntosServiciosForFatigaForSupervisor($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $fecha1, $fecha2);

        //print_r ($listaPuntos);
    }elseif($idPuntoServicio=="TODOS" && $entidadId!="ENTIDAD FEDERATIVA"){

        $listaPuntos= $negocio ->getPuntosForFatigaByEntidad($entidadId, $fecha1, $fecha2);
    }elseif($idPuntoServicio=="TODOS" && $entidadId=="ENTIDAD FEDERATIVA" && $idSupervisor=="SUPERVISOR"){

        $listaPuntos= $negocio ->getPuntosServicios($fecha1, $fecha2);
    }elseif($idPuntoServicio!="TODOS"){

         $listaPuntos = array (array ( "puntoServicioId" => $idPuntoServicio));

    }


}elseif($rolUsuario=="Supervisor" || $rolUsuario=="Consulta Supervisor"){

    if($idPuntoServicio=="TODOS"){
        
        $idSupervisor=$_SESSION ["userLog"]["empleadoId"];
        $idSupervisoris = explode("-", $idSupervisor);
        $supervisorEntidad=$idSupervisoris[0];
        $supervisorConsecutivo=$idSupervisoris[1];
        $supervisorTipo=$idSupervisoris[2];

        $listaPuntos= $negocio -> getPuntosServiciosForFatigaForSupervisor($supervisorEntidad, $supervisorConsecutivo, $supervisorTipo, $fecha1, $fecha2);
    }else{

        $listaPuntos = array (array ( "puntoServicioId" => $idPuntoServicio));
    }

    
}elseif($rolUsuario=="Analista Asistencia"){
    if($idPuntoServicio=="TODOS"){
        $listaPuntos= $negocio ->getPuntosServicios($fecha1, $fecha2);
    }elseif($idPuntoServicio!="TODOS"){
        
        $listaPuntos = array (array ( "puntoServicioId" => $idPuntoServicio));
    }




}




class PDF extends FPDI
{
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()),0,0,'C');
}
}


$pdf = new PDF();

foreach ($listaPuntos as $item)
{
    $idPuntoServicio = isset ($item ["puntoServicioId"]) ? $item ["puntoServicioId"] : $item ["idPuntoServicio"];

    $pdf = generarPdf (
        $pdf
        , $idPuntoServicio
        , $fecha1
        , $fecha2
        , $usuarioCapturaNombre
        , $usuarioCapturApellidoMaterno
        , $usuarioCapturaApellidoPaterno
        , $negocio
        , $response);
}

$pdf->Output();

function generarPdf (
    $pdf
    , $idPuntoServicio
    , $fecha1
    , $fecha2
    , $usuarioCapturaNombre
    , $usuarioCapturApellidoMaterno
    , $usuarioCapturaApellidoPaterno
    , $negocio
    , $response)
    {
        $nombreMes1=utf8_decode(strtoupper(strftime("%B", strtotime($fecha1)) )); // Guardamos el Nombre del día de la semana.
        $nombreMes2=utf8_decode(strtoupper(strftime("%B", strtotime($fecha2)) )); // Guardamos el Nombre del día de la semana.


        $pageCount = $pdf->setSourceFile("../archivos/formatoFatiga.pdf");
        $tplIdx = $pdf->importPage(1);

        //$requisicion = $negocio -> selectPlantillaRequisicion($idPuntoServicio);
        $requisicion=$negocio -> selectPlantillaRequisicionByIdPuntoAndMonth($idPuntoServicio, $fecha1, $fecha2);

        $turnosTotales = 0;
        $totalTurnosExtras = 0;
        $cobraDescansos=0;
        $cobraDiaFestivo=0;
        $cobra31=0;
        global $initialY;
        $initialY = drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);
        $initialY += 10;

        $y = drawTablaFatiga ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion, $turnosTotales, $cobraDescansos, $cobraDiaFestivo, $cobra31);
        $Yexplode = explode("?", $y);
        $y = $Yexplode[0];
        $turnosTotales = $Yexplode[1];
        $y2 = drawIncidencias ($pdf, $y, $fecha1, $fecha2, $idPuntoServicio,$tplIdx, $nombreMes1, $nombreMes2, $requisicion, $totalTurnosExtras, $cobraDescansos, $cobraDiaFestivo, $cobra31);
        $Y2explode = explode("?", $y2);
        $y = $Y2explode[0];
        $totalTurnosExtras = $Y2explode[1];
        $totalTurnos = $turnosTotales + $totalTurnosExtras;



        $y= drawFirmas ($pdf, $y, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion, $totalTurnos,$cobraDescansos, $cobraDiaFestivo, $cobra31);

        drawObservaciones ($pdf, $y, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion, $totalTurnos,$cobraDescansos, $cobraDiaFestivo, $cobra31);

        drawRecursosMateriales ($pdf, $requisicion);

        return $pdf;
    }

function drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31)
{

    global $negocio;    
    $pdf->addPage('L', 'Letter');
    $pdf->useTemplate($tplIdx, 5, null, 210);

    //$pdf->SetFont("Arial", 'B',14);
    //$pdf->Text(65, 20, "FORMATO ENTRAGA DE DOCUMENTOS" );
    $pdf->SetFont("Arial", 'B',10);
     //$pdf->Text(33, 72, utf8_decode($nombreCompleto) );
     //$pdf->Text(165, 37, $empleadoEntidad."-".$empleadoConsecutivo."-". $empleadoTipo );
     //$pdf->SetFont("Arial", 'B',9);
     //$fecha=date('d-m-Y');
    $datosPuntoServicio= $negocio->selectDatosPuntoServicio($idPuntoServicio);
    $responseDatosPuntoServicio["datosPuntoServicio"]= $datosPuntoServicio;


    $cliente=$datosPuntoServicio[0]["razonSocial"];
    $direccionFiscal=$datosPuntoServicio[0]["direccionFiscalCliente"];
    $nombreComercial=$datosPuntoServicio[0]["nombreComercial"];
    $rfcCliente=$datosPuntoServicio[0]["rfcCliente"];
    $direccionPuntoServicio=$datosPuntoServicio[0]["direccionPuntoServicio"];
    $fechaInicioServicio=$datosPuntoServicio[0]["fechaInicioServicio"];
    $puntoServicio=$datosPuntoServicio[0]["puntoServicio"];
    $numeroCentroCosto=$datosPuntoServicio[0]["numeroCentroCosto"];

    $contactoOperativo=$datosPuntoServicio[0]["contactoOperativo"];
    $telefonoFijoOperativo=$datosPuntoServicio[0]["telefonoFijoOperativo"];
    $telefonoMovilOperativo=$datosPuntoServicio[0]["telefonoMovilOperativo"];
    $correoOperativo=$datosPuntoServicio[0]["correoOperativo"];
    $terminoFacturacion=$datosPuntoServicio[0]["terminoFacturacion"];

    $cobraDescansos=$datosPuntoServicio[0]["cobraDescansos"];
    $cobraDiaFestivo=$datosPuntoServicio[0]["cobraDiaFestivo"];
    $cobra31=$datosPuntoServicio[0]["cobra31"];


    $pdf->SetFont("Arial", 'B',9);

    //$pdf->MultiCell(165, 3.5, utf8_decode(strtoupper($usuarioCapturaNombre." ".$usuarioCapturaApellidoPaterno." ".$usuarioCapturApellidoMaterno)), 0, 'C');

    $largoPuntoServicio=strlen($puntoServicio);
    $largoCliente=strlen($cliente);

    if($largoPuntoServicio < 30)
    {

        $pdf->SetXY(28, 20);
        $pdf->MultiCell(55, 3, utf8_decode(strtoupper($puntoServicio)), 0, 'L');
    }else{
        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY(28, 18);
        $pdf->MultiCell(55, 3, utf8_decode(strtoupper($puntoServicio)), 0, 'L');
    }

    if($largoCliente < 30)
    {

        $pdf->SetXY(28, 25);
        $pdf->MultiCell(55, 3, utf8_decode(strtoupper($cliente)), 0, 'L');
    }else{
        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY(28, 25);
        $pdf->MultiCell(55, 2, utf8_decode(strtoupper($cliente)), 0, 'L');
    }

    $pdf->SetXY(90, 20);
    $pdf->MultiCell(35, 3.5, utf8_decode(strtoupper($numeroCentroCosto)), 0, 'L');

    $pdf->SetXY(28, 30);
    $pdf->MultiCell(50, 3.5, utf8_decode(strtoupper("Del ".$fecha1." al ".$fecha2)), 0, 'L');

    //$pdf->SetXY(28, 35);
    //$pdf->MultiCell(50, 3.5, utf8_decode(strtoupper($cobraDescansos)), 0, 'L');

    if($nombreMes1!=$nombreMes2){
        $pdf->SetXY(90, 25);
        $pdf->MultiCell(50, 3.5, $nombreMes1."-".$nombreMes2, 0, 'L');
    }else{
        $pdf->SetXY(90, 25);
        $pdf->MultiCell(50, 3.5, $nombreMes1, 0, 'L');
    }

    $dias=0;

    for($j=$fecha1;$j<=$fecha2;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){
        $dias=$dias+1;

    }

    $pdf->SetXY(90, 30);
    $pdf->MultiCell(50, 3.5, $dias, 0, 'L');

    return drawPlantilla ($pdf, $requisicion,$cobraDescansos);
}

function drawPlantilla ($pdf, $requisicion, $cobraDescansos)
{
    global $negocio;

    $totalFacturar=0;
    $turnosXMes=0;
    $totalElementos=0;
    $turnosTotalesDiarios=0;
    $y=18;

    $perfiles="PERFIL:";

    $turnosTotalesMes=0;

    //Consultar plantilla

    $response["requisicion"]= $requisicion;
    //echo $responseEmpleadoDocumento;
    if (empty ($requisicion))
    {
        $y=$y+7;

        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY(145, $y);
        $pdf->MultiCell(30, 7, "NO HAY ELEMENTOS SOLICITADOS", 0, 1);
        $y=$y+7;
        $pdf->SetXY(145, $y);
        //$pdf->MultiCell(30, 7, "TURNOS X MES: ".$turnosTotalesDiarios*30, 0, 1);

        //$y=$y+7;
        //$pdf->SetXY(145, $y);
        //$pdf->MultiCell(30, 7, "Cobra descansos".$cobraDescansos, 0, 1);

        $pdf->SetFont("Arial", '',8);
    }


    // Dibuja la tabla de puestos que corresponde a la plantilla
    for ($i=0; $i< count($response["requisicion"]); $i++)
    {
       //echo $response["documentos"][$i]["nombreDocumento"]."</br>";
        $servicioPlantillaId=$response["requisicion"][$i]["servicioPlantillaId"];
        //$descripcionTurno=$response["contactoOperativo"][$i]["contactoOperativo"];

        $descripcionPuesto=$response["requisicion"][$i]["descripcionPuesto"];
        $descripcionTurno=$response["requisicion"][$i]["descripcionTurno"];        
        $numeroElementos=$response["requisicion"][$i]["numeroElementos"];
        $turnosPorDia=$response["requisicion"][$i]["turnosPorDia"];
        $costoPorTurno=$response["requisicion"][$i]["costoPorTurno"];
        $costoPorElemento=$costoPorTurno*30;
        $costoPorMes=($costoPorTurno*30)*$numeroElementos;

        $cobraDescanso=$response["requisicion"][$i]["cobraDescanso"];
        $cobraFestivos=$response["requisicion"][$i]["cobraFestivos"];
        $cobraDia31=$response["requisicion"][$i]["cobraDia31"];
        $costoNetoFactura1=$response["requisicion"][$i]["costoNetoFactura"];
        $costoNetoFactura = round($costoNetoFactura1, 2);

        $subtotal=$costoNetoFactura/1.16;
        $iva=$subtotal*0.16;
        $total=$subtotal+$iva;
        $totalFacturar=$totalFacturar+$total;

        $totalElementos=$totalElementos+$numeroElementos;
        //$turnosXMes=$turnosXMes+$turnosPorDia;

        $turnosTotalesDiarios=$turnosTotalesDiarios+$turnosPorDia;

        if($cobraDescanso==1){
            $cobraDescanso="SE COBRA";
        }else{
            $cobraDescanso="NO SE COBRA";
        }
        if($cobraFestivos==1){
            $cobraFestivos="SE COBRA";
        }else{
            $cobraFestivos="NO SE COBRA";
        }
        if($cobraDia31==1){
            $cobraDia31="SE COBRA";
        }else{
            $cobraDia31="NO SE COBRA";
        }

        $comentarioRequisicion=$response["requisicion"][$i]["comentarioRequisicion"];


        $perfiles=$perfiles." ".$response["requisicion"][$i]["comentarioRequisicion"].",";

        /*
        $pdf->SetFont("Arial", '',4);
        $pdf->SetXY(233, $y);
        $pdf->MultiCell(12, 7, $cobraDescanso, 0, 1);

        $pdf->SetXY(245, $y);
        $pdf->MultiCell(12.4, 7, $cobraFestivos, 0, 1);

        $pdf->SetFont("Arial", '',3);
        $pdf->SetXY(257.5, $y);
        $pdf->MultiCell(9.5, 7, $cobraDia31, 0, 1);
        */

        //$pdf->SetFont("Arial", '',6);
        //$pdf->SetXY(165.4, $y);
        //$pdf->MultiCell(14.6, 7, "$".number_format((float)$costoPorMes, 2, '.', ','), 1, 1);

        //$pdf->SetXY(180, $y);
        //$pdf->MultiCell(12, 7, "$".number_format((float)$iva, 2, '.', ','), 1, 1);

        //$pdf->SetXY(192.2, $y);
        //$pdf->MultiCell(15.8, 7, "$".number_format((float)$total, 2, '.', ','), 1, 1);
    }

        $y=$y+7;

        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY(145, $y);
        $pdf->MultiCell(30, 7, $totalElementos. " ELEMENTO(S)", 0, 1);
        $y=$y+7;
        $pdf->SetXY(145, $y);
        //$pdf->MultiCell(30, 7, "TURNOS X MES: ".$turnosTotalesDiarios*30, 0, 1);

        //$y=$y+7;
        //$pdf->SetXY(145, $y);
        //$pdf->MultiCell(30, 7, "Cobra descansos".$cobraDescansos, 0, 1);

    $pdf->SetFont("Arial", '',8);

    return $y;
}

function drawTablaFatiga ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion, $turnosTotales, $cobraDescansos, $cobraDiaFestivo, $cobra31)
{
    global $initialY;
    global $negocio;
    $y = $initialY;

    //ENCABEZADO DE TABLA
    $pdf->SetFont("Arial", 'B',8);

    $pdf->SetXY(2, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(18, 4.8,utf8_decode("No.EMPL."), 1, 'L', TRUE);

    $pdf->SetXY(20, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(40, 4.8,utf8_decode("NOMBRE"), 1, 'L', TRUE);

    $pdf->SetXY(60, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(25, 4.8,utf8_decode("PUESTO"), 1, 'L', TRUE);

    $pdf->SetXY(85, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(15, 4.8,utf8_decode("TURNO"), 1, 'L', TRUE);

    $pdf->SetXY(100, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(15.3, 4.8,utf8_decode("ROL"), 1, 'L', TRUE);

    $pdf->SetXY(115.3, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(45, 4.8,utf8_decode("SUPERVISOR"), 1, 'L', TRUE);

    $x=151;

    for($j=$fecha1;$j<=$fecha2;$j = date("Y-m-d", strtotime($j ."+ 1 days"))){

        $fechaExplode = explode("-", $j);
        $dia=$fechaExplode[2];


        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY($x, $y);
        $pdf->SetFillColor(201,194,194);
        $pdf->MultiCell(7.1, 5,$dia, 1, 'L', TRUE);
        $x= $x+7;

    }

        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY($x, $y);
        $pdf->SetFillColor(201,194,194);
        $pdf->MultiCell(7.1, 4.8,"T.Q", 1, 'L', TRUE);
        $x= $x+7;

        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY($x, $y);
        $pdf->SetFillColor(201,194,194);
        $pdf->MultiCell(7.1, 4.8,"D.F", 1, 'L', TRUE);
        $x= $x+7;

        $pdf->SetFont("Arial", 'B',6);
        $pdf->SetXY($x, $y);
        $pdf->SetFillColor(201,194,194);
        $pdf->MultiCell(7.1, 4.8,"Total", 1, 'L', TRUE);
        $x= $x+7;
    //FIN DE ENCABEZADO
    // GENERACION DE TABLA DE EMPLEADOS EN FATIGA
    $y += 5;

    $listaEmpleados= $negocio -> getEmpleadoForFatiga($fecha1, $fecha2,$idPuntoServicio);

    $subtotalTurnos=0;
    $turnosNetos=0;

    $totalTurnosFestivos=0;


    for ($k = 0; $k < count($listaEmpleados); $k++){
        $turnos31=0;
        $totalTurnosFestivos=0;

        // Verifica que no hayamos excedido el margen inferior
        // Si lo excedimos, creamos una nuava página
        if ($y > BOTTOM_MARGIN){
            drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);
            $y = $initialY;
        }

        $numeroEmpleado = $listaEmpleados [$k]["numeroEmpleado"];
        $nombreEmpleado = $listaEmpleados [$k]["nombreEmpleado"];
        $empleadoEntidadId = $listaEmpleados [$k]["entidadFederativaId"];
        $empleadoConsecutivoId = $listaEmpleados [$k]["empleadoConsecutivoId"];
        $empleadoTipoId = $listaEmpleados [$k]["empleadoCategoriaId"];
        $descripcionPuesto = $listaEmpleados [$k]["descripcionPuesto"];
        $descripcionTurno = $listaEmpleados [$k]["descripcionTurno"];
        $roloperativo = $listaEmpleados [$k]["roloperativo"];
        $nombresupervisor = $listaEmpleados [$k]["nombresupervisor"];

        $listaEmpleados [$k]["diasFestivosTrabajados"]= $negocio -> getSumaDiasFestivosFatiga ($fecha1, $fecha2, $empleadoEntidadId, $empleadoConsecutivoId, $empleadoTipoId,$idPuntoServicio);

        $turnosDiasFestivosEmpleado=$listaEmpleados[$k]["diasFestivosTrabajados"]["diasFestivos"];

        $totalTurnosFestivos=$totalTurnosFestivos+ $turnosDiasFestivosEmpleado;

        $pdf->SetFont("Arial", 'B',7);
        $pdf->SetXY(2, $y);

        $pdf->MultiCell(18, 6,$numeroEmpleado, 1, 'L');

        if(strlen($nombreEmpleado)>=24){
        $pdf->SetXY(20, $y);
        $pdf->MultiCell(40, 3,utf8_decode($nombreEmpleado), 1, 'L');
        }else{
        $pdf->SetXY(20, $y);
        $pdf->MultiCell(40,6,utf8_decode($nombreEmpleado), 1, 'L');
        }

        if(strlen($descripcionPuesto)>=24){
            $pdf->SetXY(60, $y);
            $pdf->MultiCell(25, 3,utf8_decode($descripcionPuesto), 1, 'L');
        }else{
            $pdf->SetXY(60, $y);
            $pdf->MultiCell(25,3,utf8_decode($descripcionPuesto), 1, 'L');
        }
        if($descripcionTurno=="NO DEFINIDO"){
            $pdf->SetXY(85, $y);
            $pdf->MultiCell(15, 3,utf8_decode($descripcionTurno), 1, 'L');
        }
        else{
            $pdf->SetXY(85, $y);
            $pdf->MultiCell(15,6,utf8_decode($descripcionTurno), 1, 'L');
        }

        // if(strlen($roloperativo)>=24){
        //     $pdf->SetXY(100, $y);
        //     $pdf->MultiCell(15.3, 3,utf8_decode($roloperativo), 1, 'L');
        // }
        // else{
        //     $pdf->SetXY(100, $y);
        //     $pdf->MultiCell(15.3,6,utf8_decode($roloperativo), 1, 'L');
        // }
         if($roloperativo=="NO DEFINIDO" || $roloperativo=="HORARIO OFICINA"){
            $pdf->SetXY(100, $y);
            $pdf->MultiCell(15.3, 3,utf8_decode($roloperativo), 1, 'L');
        }else{
            $pdf->SetXY(100, $y);
            $pdf->MultiCell(15.3,6,utf8_decode($roloperativo), 1, 'L');
        }

        if(strlen($nombresupervisor)>=24){
            $pdf->SetXY(115.3, $y);
            $pdf->MultiCell(35.5, 3,utf8_decode($nombresupervisor), 1, 'L');
        }
        else{
            $pdf->SetXY(115.3, $y);
            $pdf->MultiCell(35.5,6,utf8_decode($nombresupervisor), 1, 'L');
        }
        


         $x1=151;

        $listaEmpleados [$k]["asistencia"] = $negocio -> getAsistenciaByEmpleadoPuntoServicioFatiga($fecha1,$fecha2, $empleadoEntidadId, $empleadoConsecutivoId,$empleadoTipoId, $idPuntoServicio);


        $turnosPeriodo=0;
        $descansos=0;
        $sumaDias31=0;

        for($l=$fecha1;$l<=$fecha2;$l = date("Y-m-d", strtotime($l ."+ 1 days"))){

            if(array_key_exists($l,$listaEmpleados[$k]["asistencia"])){

                $incidencia= $listaEmpleados [$k]["asistencia"][$l]["nomenclaturaIncidencia"];

            if($incidencia=="ING" || $incidencia=="B" || $incidencia=="V/D" || $incidencia=="INC" || $incidencia=="PER" || $incidencia=="F" || $incidencia=="V/D2"){

                    $incidencia="";
                    $pdf->SetXY($x1, $y);
                    $valorTurno=$listaEmpleados [$k]["asistencia"][$l]["valorCobertura"];
                    $pdf->MultiCell(7.1, 6,$incidencia, 1, 'C');
                    $x1=$x1+7;

            }else if ($incidencia=="DT12" ){
                    $valorTurno=$listaEmpleados [$k]["asistencia"][$l]["valorCobertura"];
                    $incidencia="1";
                    $pdf->SetXY($x1, $y);
                    $pdf->SetFillColor(250,250,0);
                    $pdf->MultiCell(7.1, 6,$incidencia, 1, 'C',true);
                    $x1=$x1+7;
            }
            else if ($incidencia=="V/P" ){
                    $valorTurno=$listaEmpleados [$k]["asistencia"][$l]["valorCobertura"];
                    $incidencia="1";
                    $pdf->SetXY($x1, $y);
                    $pdf->SetFillColor(83,129,54);
                    $pdf->MultiCell(7.1, 6,$incidencia, 1, 'C',true);
                    $x1=$x1+7;
            }
            else if ($incidencia=="DES" ){


                    $pdf->SetXY($x1, $y);
                    $pdf->SetFillColor(250,250,0);
                    $pdf->MultiCell(7.1, 6,$incidencia, 1, 'C',true);
                    $x1=$x1+7;
                    if($cobraDescansos==1){
                    $valorTurno=1;
                    }else{
                    $valorTurno=$listaEmpleados [$k]["asistencia"][$l]["valorCobertura"];
                    }
            }else if ($incidencia=="1" || $incidencia=="2" ){
                    $valorTurno=$listaEmpleados [$k]["asistencia"][$l]["valorCobertura"];
                    $pdf->SetXY($x1, $y);
                    $pdf->MultiCell(7.1, 6,$incidencia, 1, 'C');
                    $x1=$x1+7;
            }else if ($incidencia=="V/P2"){

                    $incidencia="2";
                    $valorTurno=$listaEmpleados [$k]["asistencia"][$l]["valorCobertura"];
                    $pdf->SetXY($x1, $y);
                    $pdf->SetFillColor(83,129,54);
                    $pdf->MultiCell(7.1, 6,$incidencia, 1, 'C',true);
                    $x1=$x1+7;
            }


            }else{

                $incidencia="";
                $pdf->SetXY($x1, $y);
                $pdf->MultiCell(7.1, 6,$incidencia, 1, 'C');
                $x1=$x1+7;
                $valorTurno=0;

            }

            $dia= substr($l, 8);


            if($dia==31){

                $turnos31=$turnos31+$valorTurno;
            }

           $turnosPeriodo=$turnosPeriodo+$valorTurno;



            } //termina for


            if($cobra31==0){

                $turnosPeriodo=$turnosPeriodo-$turnos31;
            }

            $pdf->SetXY($x1, $y);
            $pdf->MultiCell(7.1, 6,$turnosPeriodo, 1, 'C');

            $x1=$x1+7;

            $pdf->SetXY($x1, $y);
                //$pdf->SetFillColor(153,255,100);
                $pdf->MultiCell(7.1, 6,$turnosDiasFestivosEmpleado, 1, 'C');
                $x1=$x1+7;

            $pdf->SetXY($x1, $y);


            if($cobraDiaFestivo==1){

                $turnosTotalesEmpleado=$turnosPeriodo+$turnosDiasFestivosEmpleado ;

                $pdf->MultiCell(7.1, 6,$turnosTotalesEmpleado , 1, 'C');

            }else{
                $turnosTotalesEmpleado=$turnosPeriodo;
                $pdf->MultiCell(7.1, 6,$turnosTotalesEmpleado, 1, 'C');

            }


            $x1=$x1+7;

            $y=$y+6;

            $subtotalTurnos=$subtotalTurnos + $turnosPeriodo;

            $turnosTotales=$turnosTotales+$turnosTotalesEmpleado;


    } // for $listaEmpleados


    $listaTurnosCubiertos = $negocio -> getTurnosCubiertosByPeriodoFechasAndPuntoServicio ($fecha1, $fecha2, $idPuntoServicio);

    $x2=151;

            $pdf->SetXY(2, $y);
            //$pdf->SetFillColor(153,255,100);
            $pdf->MultiCell(149, 6,"TOTAL DE TURNOS", 1, 'C');

        for($p=$fecha1;$p<=$fecha2;$p = date("Y-m-d", strtotime($p ."+ 1 days"))){

        if(array_key_exists($p,$listaTurnosCubiertos))
        {

            $pdf->SetXY($x2, $y);
            //$pdf->SetFillColor(153,255,100);
            $pdf->MultiCell(7.1, 6,$listaTurnosCubiertos[$p]["cantidadTurnos"], 1, 'C');
            $x2=$x2+7;
            //$y=$y+6;
        }else{

            $pdf->SetXY($x2, $y);
            //$pdf->SetFillColor(153,255,100);
            $pdf->MultiCell(7.1, 6,"", 1, 'C');
            $x2=$x2+7;

        }
    }

    $pdf->SetXY($x2, $y);
    //$pdf->SetFillColor(153,255,100);
    $pdf->MultiCell(7.1, 6,$subtotalTurnos, 1, 'C');
    $x2=$x2+7;


    $pdf->SetXY($x2, $y);
    //$pdf->SetFillColor(153,255,100);
    $pdf->MultiCell(7.1, 6,$totalTurnosFestivos, 1, 'C');

    $x2=$x2+7;

    $pdf->SetXY($x2, $y);
    //$pdf->SetFillColor(153,255,100);
    $pdf->MultiCell(7.1, 6,$turnosTotales, 1, 'C');


    return $y."?".$turnosTotales;

}
function drawIncidencias ($pdf, $y, $fecha1, $fecha2, $idPuntoServicio,$tplIdx, $nombreMes1, $nombreMes2, $requisicion, $totalTurnosExtras, $cobraDescansos, $cobraDiaFestivo, $cobra31)
{
    global $initialY;
    global $negocio;

    // Incrementa en 25 la posición en Y desde la última posición
    // para evitar sobreposiciones
    $y += 10;

    // Verifica que no hayamos excedido el margen inferior
    // Si lo excedimos, creamos una nuava página
    if ($y > BOTTOM_MARGIN)
    {
        drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);

        $y = $initialY;
    }

    $lista= $negocio -> getTurnosExtrasFatiga($fecha1,$fecha2, $idPuntoServicio);

    if(count($lista)!=0){

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(10, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(18, 6,"No. EMPL.", 1, 'L', TRUE);

    $pdf->SetXY(28, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(50, 6,"NOMBRE", 1, 'L', TRUE);

    $pdf->SetXY(78, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(18, 6,"FECHA", 1, 'L', TRUE);

    $pdf->SetXY(96, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(90, 6,"COMENTARIO", 1, 'L',TRUE);

    $y=$y+6;
    $totalTurnosExtras=0;
    // Dibuja la lista de incidencias
    for ($z=0; $z< count($lista); $z++)
    {

        $totalTurnosExtras=$totalTurnosExtras+1;

        // Verifica que no hayamos excedido el margen inferior
        // Si lo excedimos, creamos una nuava página
        if ($y > BOTTOM_MARGIN)
        {
            drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);

            $y = $initialY;
        }

        $numeroEmpleado=$lista[$z]["numeroEmpleado"];
        $nombreEmpleado=$lista[$z]["nombreEmpleado"];
        $incidenciaFecha=$lista[$z]["incidenciaFecha"];
        $incidenciaComentario=$lista[$z]["incidenciaComentario"];

        $pdf->SetXY(10, $y);
        $pdf->MultiCell(18, 6,$numeroEmpleado, 1, 'L');


        $pdf->SetXY(28, $y);
        $pdf->MultiCell(50, 3, utf8_decode($nombreEmpleado), 1, 'B');
        //$pdf->Cell(40,6, utf8_decode($nombreEmpleado),1,1,'L');

        $pdf->SetXY(78, $y);
        $pdf->MultiCell(18, 6,$incidenciaFecha, 1, 'L');

        if($incidenciaComentario==""){
            $incidenciaComentario="SIN COMENTARIO";

        }
        $pdf->SetXY(96, $y);
        $pdf->MultiCell(90, 3,$incidenciaComentario, 1, 'C');


        $y=$y+6;

    }

        $pdf->SetXY(96, $y);
        $pdf->MultiCell(90, 6,"TOTAL TURNOS EXTRAS: ". $totalTurnosExtras, 1, 'C');

    }

// for $lista
   return $y."?".$totalTurnosExtras;

}

function drawFirmas ($pdf, $y, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion, $totalTurnos,$cobraDescansos, $cobraDiaFestivo, $cobra31)
{
    global $initialY;

    // Incrementa en 25 la posición en Y desde la última posición
    // para evitar sobreposiciones
    $y += 10;

    // Verifica que no hayamos excedido el margen inferior
    // Si lo excedimos, creamos una nuava página
    if ($y > BOTTOM_MARGIN)
    {
        drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);

        $y = $initialY;
    }
    // Dibuja el espacio para la firmas
    // Supervisor Gif y Jefe de seguridad.


    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(110, $y);
    $pdf->MultiCell(60, 4, utf8_decode("TOTAL DE TURNOS:" . $totalTurnos), 1, 'C');

    $y=$y+10;

    if ($y > BOTTOM_MARGIN)
    {
        drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);

        $y = $initialY;
    }

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(60, 4, utf8_decode("SUPERVISOR GIF:"), 1, 'C');

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(60, 4, utf8_decode("JEFE DE SEGURIDAD:"), 1, 'C');
         
    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(110,$y+18);
    $pdf->MultiCell(60, 4, utf8_decode("GERENTE REGIONAL:"), 1, 'C');

    $y=$y+4;

    if ($y > BOTTOM_MARGIN)
    {
        drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);

        $y = $initialY;
    }

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(50, $y);
    $pdf->MultiCell(60, 10, "", 1, 1);

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(170, $y);
    $pdf->MultiCell(60, 10, "", 1, 1);

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(110, $y+18);
    $pdf->MultiCell(60, 20, "", 1, 1);
    $y=$y+4;

    return $y;

}
function drawObservaciones ($pdf, $y, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion, $totalTurnos, $cobraDescansos, $cobraDiaFestivo, $cobra31)
{

    global $initialY;
    global $negocio;

    // Incrementa en 25 la posición en Y desde la última posición
    // para evitar sobreposiciones
    $y += 10;

    // Verifica que no hayamos excedido el margen inferior
    // Si lo excedimos, creamos una nuava página
    if ($y > BOTTOM_MARGIN)
    {
        drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);

        $y = $initialY;
    }

    $listaIncremetosPlantilla= $negocio -> getIncrementosPlantillaFatiga($fecha1, $fecha2, $idPuntoServicio);

    if(count($listaIncremetosPlantilla)!=0){

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(15.2, $y);
    $pdf->SetFillColor(201,194,194);
    $pdf->MultiCell(250, 6,"OBSERVACIONES:", 1, 'C', TRUE);

    $y=$y+6;

    // Dibuja la lista de incidencias
    for ($z=0; $z< count($listaIncremetosPlantilla); $z++)
    {

        // Verifica que no hayamos excedido el margen inferior
        // Si lo excedimos, creamos una nuava página
        if ($y > BOTTOM_MARGIN)
        {
            drawEncabezado ($pdf, $tplIdx, $idPuntoServicio, $fecha1, $fecha2, $nombreMes1, $nombreMes2, $requisicion,$cobraDescansos, $cobraDiaFestivo, $cobra31);

            $y = $initialY;
        }

        $numeroElementos=$listaIncremetosPlantilla[$z]["numeroElementos"];
        $fechaInicio=$listaIncremetosPlantilla[$z]["fechaInicio"];

        $pdf->SetXY(15.2, $y);
        $pdf->MultiCell(250, 6,"INCREMENTO DE " .$numeroElementos." ELEMENTO(S) A PARTIR DEL ".$fechaInicio. " POR ORDEN DEL CLIENTE", 1, 'L');

        $y=$y+6;
    }

    }

// for $lista
   return $y;

}

function drawRecursosMateriales ($pdf, $requisicion)
{
    //if($i==count($response["requisicion"])-1){
    //$pdf->SetXY(143.5, $y+7);
    //$pdf->MultiCell(64.5, 7, "TOTAL PRESUPUESTADO A FACTURAR $".number_format((float)$totalFacturar, 2, '.', ','), 1, 1);
    $recursosMateriales="OBSERVACIONES:";
    for ($i = 0; $i < count ($requisicion); $i++)
    {
        $recursosMateriales .=" ".$requisicion[$i]["recursosMateriales"]."";
    }

    $pdf->SetFont("Arial", '',8);
    $pdf->SetXY(15.2, 170);
    $pdf->MultiCell(250, 20, "", 1, 1);

    $pdf -> Text (16,175,"OBSERVACIONES:");

    //$pdf->SetXY(15.2, 180);
    //$pdf->MultiCell(250, 10, utf8_decode("TERMINO FACTURACÓN: " .$terminoFacturacion), 1, 1);
}

?>
