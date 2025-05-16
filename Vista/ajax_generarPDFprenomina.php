<?php
session_start();
use setasign\Fpdi\Fpdi;
require_once('../libs/fpdi/src/autoload.php');
require_once ("../libs/logger/KLogger.php");
require('../libs/fpdf/fpdf.php');
require('../libs/fpdi/src/fpdi.php');
require "conexion.php";
require_once ("../libs/phpmailer/class.phpmailer.php");
require_once ("../libs/phpmailer/class.smtp.php");

$listaEntidades= array();
$log = new KLogger ( "generarpdfPRENOMINA.log" , KLogger::DEBUG );
$log -> LogInfo ("_GET ".var_export ($_GET, true));
//$totalesXentidad=$_GET['totalesXentidad'];
$totalesConMonto=$_GET['totalesConMonto'];
$entidades=$_GET['entidades'];
$granTotal=$_GET['granTotal'];
$fecha1=$_GET['fechaConsulta1'];
$fecha2=$_GET['fechaConsulta2'];


    $fecha1explode = explode("-", $fecha1);
        $anio1=$fecha1explode[0];
        $mes1=$fecha1explode[1];
        $dia1=$fecha1explode[2];

    $fecha2explode = explode("-", $fecha2);
        $anio2=$fecha2explode[0];
        $mes2=$fecha2explode[1];
        $dia2=$fecha2explode[2];




// administrativa 

//$totalesXentidadAdmin=$_GET['totalesXentidadAdmin'];
$totalesConMontoAdmin=$_GET['totalesConMontoAdmin'];
$entidadesAdmin=$_GET['entidadesAdmin'];
$granTotalAdmin=$_GET['granTotalAdmin'];

$neto= $granTotal+$granTotalAdmin;

$fecha=date('d-m-Y');

$pdf=new FPDI();
// $pdf->WriteHTML($html);
$pageCount = $pdf->setSourceFile("../archivos/presupuesto.pdf");
$tplIdx = $pdf->importPage(1);
$pdf->AddPage();
$pdf->useTemplate($tplIdx, null, null, null, null, true); 
$pdf->SetFont('Arial','B',9);
$pdf->Text(32, 50.7, utf8_decode($fecha));
//oprativo
$totalesConMontoExplode = explode(",", $totalesConMonto);
// administrativo
$totalesConMontoAdminExplode = explode(",", $totalesConMontoAdmin);

$entidadesExplode = explode(",", $entidades);

$sql = "SELECT idEntidadFederativa,upper(nombreEntidadFederativa) as nombreEntidadFederativa
    FROM entidadesfederativas
    WHERE ";
    for ($a=0; $a < count($entidadesExplode); $a++) { 
        $entidad=$entidadesExplode[$a];
        if ($a==0) {
            $sql.="idEntidadFederativa=$entidad";
        }else{
            $sql.=" OR idEntidadFederativa=$entidad";
        }
    }
$res = mysqli_query($conexion, $sql);
while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
    $listaEntidades[] = $reg;
}
$y=66.1;
$yAdmin=66.1; 
for($i=0; $i < count($listaEntidades); $i++){
    $iteracionFinal=$i+1;
    $entidad=$listaEntidades[$i]["nombreEntidadFederativa"];
    $idEntidadFederativa=$listaEntidades[$i]["idEntidadFederativa"];
    // operacion operativsa para pdf /////////////////////////////////////////
    $montoOriginal=$totalesConMontoExplode[$i];
    $montoExplod = explode(".", $montoOriginal);

    if(count($montoExplod)==1){
      $monto=$montoOriginal.".00";
    }else{
        $monto=bcdiv($montoOriginal, '1', 2);
    }
    $granTotalExplod = explode(".", $granTotal);
    if(count($granTotalExplod)==1){
        $granTotalDec=$granTotal.".00";
    }else{
        $granTotalDec=bcdiv($granTotal, '1', 2);
    }
    $largoMonto=strlen($monto);
    $granTotalDecLent=strlen($granTotalDec);
    $y+=5;
    for($b=1; $b <= $largoMonto; $b++) { 
        $c=($b*2)/1;
        $numero= substr($monto, -$b, 1);
        $xMonto= 121.5-$c;
        $pdf->Text($xMonto, $y, utf8_decode($numero));
    } 
    if($iteracionFinal==count($listaEntidades)){
       $y+=10.7;
        for($f=1; $f <= $granTotalDecLent; $f++) { 
            $g=($f*2)/1.1;
            $numero= substr($granTotalDec, -$f, 1); 
            $xMonto= 121.5-$g;
            $pdf->Text($xMonto, $y, utf8_decode($numero));
        }
    }
    //////////////////////////////////////////////////////////////////////////////////
    /// operacion Administrativas para pdf ///////////////////////////////////////////
    $montoOriginalAdmin=$totalesConMontoAdminExplode[$i];
    $montoExplodAdmin = explode(".", $montoOriginalAdmin);

    if(count($montoExplodAdmin)==1){
      $montoAdmin=$montoOriginalAdmin.".00";
    }else{
        $montoAdmin=bcdiv($montoOriginalAdmin, '1', 2);
    }
    $granTotalExplodAdmin = explode(".", $granTotalAdmin);
    if(count($granTotalExplodAdmin)==1){
        $granTotalDecAdmin=$granTotalAdmin.".00";
    }else{
        $granTotalDecAdmin=bcdiv($granTotalAdmin, '1', 2);
    }
    $largoMontoAdmin=strlen($montoAdmin);
    $granTotalDecLentAdmin=strlen($granTotalDecAdmin);
    $yAdmin+=5;
    for($bb=1; $bb <= $largoMontoAdmin; $bb++) { 
        $cc=($bb*2)/1;
        $numeroAdmin= substr($montoAdmin, -$bb, 1);
        $xMontoAdmin= 155.5-$cc;
        $pdf->Text($xMontoAdmin, $yAdmin, utf8_decode($numeroAdmin));
    } 
    if($iteracionFinal==count($listaEntidades)){
       $yAdmin+=10.7;
        for($ff=1; $ff <= $granTotalDecLentAdmin; $ff++) { 
            $gg=($ff*2)/1.1;
            $numeroAdmin= substr($granTotalDecAdmin, -$ff, 1);
            $xMontoAdmin= 155.5-$gg;
            $pdf->Text($xMontoAdmin, $yAdmin, utf8_decode($numeroAdmin));
        }


    $netoExplode = explode(".", $neto);
    if(count($netoExplode)==1){
        $netoDec=$neto.".00";
    }else{
        $netoDec=bcdiv($neto, '1', 2);
    }

        $largoNeto=strlen($netoDec);
        $yAdmin+=4.9;
        for($zz=1; $zz <= $largoNeto; $zz++) { 
            $yy=($zz*2)/1;
            $numeroNeto= substr($netoDec, -$zz, 1);
            $xMontoNeto= 155.9-$yy;
            $pdf->Text($xMontoNeto, $yAdmin, utf8_decode($numeroNeto));
        }
        // $pdf->Text($xMontoAdmin, $yAdmin, utf8_decode($neto));
    }
    //////////////////////////////////////////////////////////////////////////////////
    // insercion general en la base de datos y fin del proceso///////
// falta generar la comnsulta o en si defecto mandarle el id del cierre de esta quincena se puso 123 temporalmente
    $sql2 ="INSERT INTO presupuesto_nomina(idEntidad,montoOperativo,montoAdmin,fechaCierreNomina,granTotalOperativo,granTotalAdmin,fechaPeriodoInicio,fechaPeriodofin) VALUES ('$idEntidadFederativa',$monto,$montoAdmin,now(),$granTotalDec,$granTotalDecAdmin,'$fecha1','$fecha2')";
    $log -> LogInfo ("sql2 ".var_export ($sql2, true));
    $res2 = mysqli_query($conexion, $sql2);
}
$pdfdoc = $pdf->Output("", "S"); 

// $pdflisto = chunk_split(base64_encode($pdfdoc));
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->Host       = 'smtp.office365.com';
$mail->Port       = 587;
$mail->SMTPAuth   = true;
$mail->Username   = 'registros@gifseguridad.com.mx';
$mail->Password   = 'Har00112';
$mail->SMTPSecure = 'tls';
$mail->From       = 'registros@gifseguridad.com.mx';
$mail->FromName   = 'Soporte Grupo Gif Seguridad';
// $mail->AddAddress('desarrollo@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION
// $mail->AddAddress('roberto.vences@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION
$mail->AddAddress('rodolfo.gonzalez@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION
$mail->AddAddress('yazmin.gonzalez@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION
$mail->AddAddress('rafael.rosas@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION
$mail->AddAddress('jose.leon@gifseguridad.com.mx'); //ANEXAR AL CARGAR EN PRODUCCION
$mail->IsHTML(true); // Set email format to HTML
$mail->Subject = utf8_decode('Presupuesto de nomina');
$mail->Body    = utf8_decode('<span>Buenas tardes</span><br><br>
                              <span>Se adjunta presupuesto correspondiente al periodo del '.$dia1.'-'.$mes1.'-'.$anio1.' al ' .$dia2.'-'.$mes2.'-'.$anio2.'.</span><br><br>
                              <span>Saludos.</span>');
$mail->AddStringAttachment($pdfdoc, 'presupuestoNomina.pdf', 'base64', 'application/pdf');// attachment

if (!$mail->Send()) {
    $response["status"]  = "error";
    $response["message"] = $mail->ErrorInfo;
    // $log->LogInfo("Valor de la variable fsdgfdgsfgdfgdfg: " . var_export ($response, true));
}

// $pdf->Output();

// $directorio = 'uploads/DocFirmadoEntregaUniformes/aaa';
// $pdf->Output(__DIR__ . '/invoice#12.pdf', 'F');
?>