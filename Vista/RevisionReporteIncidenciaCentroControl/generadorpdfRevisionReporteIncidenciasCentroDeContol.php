<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
use setasign\Fpdi\Fpdi;
require_once('../../libs/fpdi/src/autoload.php');
require('../../libs/fpdf/fpdf.php');
// require('../../libs/fpdi/fpdi.php');
//enviar el usuario para que pueda traer la consulta negocio_obtenerEmpleadoPorId
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
//$log = new KLogger ( "generadorpdfReporteIncidenciasCentroDeContol.log" , KLogger::DEBUG );
$response = array ();
$datos              = array();
$datos1             = array();
$datos2             = array();
$usuario = $_SESSION ["userLog"]["usuario"];
$idIncidencia=$_GET["idIncidencia"];
$IdTablaSupervisor=$_GET["IdTablaSupervisor"];
$NumEmpModalBaja=$_GET["NumEmpModalBaja"];
$contraseniaInsertadaCifrada=$_GET["contraseniaInsertadaCifrada"];

$sql3 = "UPDATE ReporteIncidenciaSupervisoresCentroControl set UsuarioEdicionSupIncidenciaCC='$usuario',FechaEdicionSupIncidenciaCC=now(),EmpleadoEdicionSupIncidenciaCC='$NumEmpModalBaja',ContraseniaEdicionSupIncidenciaCC='$contraseniaInsertadaCifrada',EstatusRevisionIncidenciaCC='3'
        where idSupervisorInciIdenciaCC='$IdTablaSupervisor'";     
    $res3 = mysqli_query($conexion, $sql3);  
if ($res3 !== true) {
    $response["status"] = "error";
    $response["message"]='error al ACTUALIZAR El Reporte De Centro De Control';
    return;
}else{
    $response["status"]= "success";
    $response["message"]='Se ACTUALIZÓ El Reporte De Centro De Control Correctamente';
}

$sql4 = "SELECT count(idSupervisorInciIdenciaCC) as largo from ReporteIncidenciaSupervisoresCentroControl
        where idIncidenciaSupCC='$idIncidencia'
        and EstatusRevisionIncidenciaCC='2'";
     $res4 = mysqli_query($conexion, $sql4);
    while (($reg4 = mysqli_fetch_array($res4, MYSQLI_ASSOC))){
        $datos2[] = $reg4;
    }
    $largoincidencias = $datos2[0]["largo"];
if($largoincidencias =="0"){
    $sql5 = "UPDATE ReporteIncidenciaCentroControl set idEstatusReporteIncidenciaCC='3'
            where idinciIdenciaCC='$idIncidencia'";     
    $res5 = mysqli_query($conexion, $sql5);  
    if ($res5 !== true) {
        $response["status"] = "error";
        $response["message"]='error al ACTUALIZAR El Reporte De Centro De Control';
        return;
    }else{
        $response["status"]= "success";
        $response["message"]='Se ACTUALIZÓ El Reporte De Centro De Control Correctamente';
    }
}

$sql = "SELECT ri.FolioIncidenciaCC as NumeroFolio,cti.descripcionTipoIncidenciaCC as DescripcionTipoIncidencia, p.descripcionPuesto as PuestoGuardia, concat_ws('-',ri.EmpEntidadIncidenciaCC,ri.EmpConsecutivoIncidenciaCC,ri.EmpCategoriaIncidenciaCC) as NumeroGuardia, concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreGuardia, ri.ExistePuntoIncidenciaCC as ExistePunto,cps.puntoServicio as PuntoServicioDes, ri.PuntoServicioIncidenciaCC as PuntoServicioText,ri.FechaIncidenciaCC as FechaIncidencia,ef.nombreEntidadFederativa as Lugar,concat_ws('-',emp.entidadFederativaId,emp.empleadoConsecutivoId,emp.empleadoCategoriaId) as NumeroAdmin,concat_ws(' ',emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno) as NombreAdmin, cp.descripcionPuesto as PuestoAdmin,ri.TestigoIncidenciaCC,ri.PercataronIncidenciaCC,ri.RecopilacionIncidenciaCC,ri.TareaIncidenciaCC,ri.ResponsabilidadIncidenciaCC,ri.OrdenesIncidenciaCC,ri.EvidenciaIncidenciaCC,ri.SupervisionIncidenciaCC,ri.EmpleadoRegistroIncidenciaCC as NumeroFirma,concat_ws(' ',emp1.nombreEmpleado,emp1.apellidoPaterno,emp1.apellidoMaterno) as NombreFirma,ri.ContraseniaEmpIncidenciaCC as Firma
    from ReporteIncidenciaCentroControl ri 
    left join empleados e ON(ri.EmpEntidadIncidenciaCC=e.entidadFederativaId and ri.EmpConsecutivoIncidenciaCC=e.empleadoConsecutivoId and ri.EmpCategoriaIncidenciaCC =e.empleadoCategoriaId)
    left join catalogopuestos p ON(e.empleadoIdPuesto=p.idPuesto)
    left join catalogopuntosservicios cps ON(ri.IdPuntoIncidenciaCC=cps.idPuntoServicio)
    left join entidadesfederativas ef ON(ri.IdEntidadIncidenciaCC=ef.idEntidadFederativa)
    left join empleados emp ON(ri.AdminEntidadIncidenciaCC=emp.entidadFederativaId and ri.AdminConsecutivoIncidenciaCC=emp.empleadoConsecutivoId and ri.AdminCategoriaIncidenciaCC =emp.empleadoCategoriaId)
    left join catalogopuestos cp ON(emp.empleadoIdPuesto=cp.idPuesto)
    left join CatalogoTipoIncidenciaCentroC cti ON(cti.idTipoIncidenciaCC=ri.idIncidenciaCC)
    left join empleados emp1 ON(concat_ws('-',emp1.entidadFederativaId,emp1.empleadoConsecutivoId,emp1.empleadoCategoriaId)=ri.EmpleadoRegistroIncidenciaCC)
    where ri.idinciIdenciaCC='$idIncidencia'";
     $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }

$NumeroFirma = $datos[0]["NumeroFirma"];
$NombreFirma = $datos[0]["NombreFirma"];
$Firma = $datos[0]["Firma"];
$NumeroFolio = $datos[0]["NumeroFolio"];
$DescripcionTipoIncidencia = $datos[0]["DescripcionTipoIncidencia"];
$PuestoGuardia = $datos[0]["PuestoGuardia"];
$NumeroGuardia = $datos[0]["NumeroGuardia"];
$NombreGuardia = $datos[0]["NombreGuardia"];
$ExistePunto = $datos[0]["ExistePunto"];
$PuntoServicioDes = $datos[0]["PuntoServicioDes"];
$PuntoServicioText = $datos[0]["PuntoServicioText"];
$FechaIncidencia = $datos[0]["FechaIncidencia"];
$Lugar = $datos[0]["Lugar"];
$NumeroAdmin = $datos[0]["NumeroAdmin"];
$NombreAdmin = $datos[0]["NombreAdmin"];
$PuestoAdmin = $datos[0]["PuestoAdmin"];
$TestigoIncidenciaCC = $datos[0]["TestigoIncidenciaCC"];
$PercataronIncidenciaCC = $datos[0]["PercataronIncidenciaCC"];
$RecopilacionIncidenciaCC = $datos[0]["RecopilacionIncidenciaCC"];
$TareaIncidenciaCC = $datos[0]["TareaIncidenciaCC"];
$ResponsabilidadIncidenciaCC = $datos[0]["ResponsabilidadIncidenciaCC"];
$OrdenesIncidenciaCC = $datos[0]["OrdenesIncidenciaCC"];
$EvidenciaIncidenciaCC = $datos[0]["EvidenciaIncidenciaCC"];
$SupervisionIncidenciaCC = $datos[0]["SupervisionIncidenciaCC"];

$sql1 = "SELECT * from ReporteIncidenciaDocumentosCentroControl
        where idIncidenciaDocCC='$idIncidencia'";
     $res1 = mysqli_query($conexion, $sql1);
    while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
        $datos1[] = $reg1;
    }
    $largoArchivos = count($datos1);
   // $log->LogInfo("Valor de la variable largoArchivos " . var_export ($largoArchivos, true));

$explodeNumeroFolio = explode(" ", $NumeroFolio);
$folio1 = $explodeNumeroFolio[0];
$folio2 = $explodeNumeroFolio[1];
$Tipoinc = $PuestoGuardia." GIF ".$NumeroGuardia;
$Tipoinc1=substr($Tipoinc, 0,25);
$Tipoinc2=substr($Tipoinc, 25,50);
if($ExistePunto=="1"){
    $punto = $PuntoServicioDes;
}else{
    $punto = $PuntoServicioText;
}
$punto1=substr($punto, 0,25);
$punto2=substr($punto, 25,50);
$explodeFechaIncidencia = explode('-', $FechaIncidencia);
$dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$anio = $explodeFechaIncidencia[0];
$mes = $explodeFechaIncidencia[1];
$dia = $explodeFechaIncidencia[2];
$dia1 = $dias[(date('N', strtotime($FechaIncidencia))) - 1];
$Fecha = $dia1 ." ".$dia." de ".$meses[$mes-1]. " del ".$anio;

$TestigoIncidenciaCC1=substr($TestigoIncidenciaCC, 0,107);
$TestigoIncidenciaCC2=substr($TestigoIncidenciaCC, 107,107);

$PercataronIncidenciaCC1=substr($PercataronIncidenciaCC, 0,107);
$PercataronIncidenciaCC2=substr($PercataronIncidenciaCC, 107,107);
$PercataronIncidenciaCC3=substr($PercataronIncidenciaCC, 214,107);

$RecopilacionIncidenciaCC1=substr($RecopilacionIncidenciaCC, 0,107);
$RecopilacionIncidenciaCC2=substr($RecopilacionIncidenciaCC, 107,107);
$RecopilacionIncidenciaCC3=substr($RecopilacionIncidenciaCC, 214,107);
$RecopilacionIncidenciaCC4=substr($RecopilacionIncidenciaCC, 321,107);
$RecopilacionIncidenciaCC5=substr($RecopilacionIncidenciaCC, 428,107);
$RecopilacionIncidenciaCC6=substr($RecopilacionIncidenciaCC, 535,107);
$RecopilacionIncidenciaCC7=substr($RecopilacionIncidenciaCC, 642,107);
$RecopilacionIncidenciaCC8=substr($RecopilacionIncidenciaCC, 749,107);
$RecopilacionIncidenciaCC9=substr($RecopilacionIncidenciaCC, 856,107);
$RecopilacionIncidenciaCC10=substr($RecopilacionIncidenciaCC, 963,107);
$RecopilacionIncidenciaCC11=substr($RecopilacionIncidenciaCC, 1070,107);
$RecopilacionIncidenciaCC12=substr($RecopilacionIncidenciaCC, 1177,107);
$RecopilacionIncidenciaCC13=substr($RecopilacionIncidenciaCC, 1284,107);
$RecopilacionIncidenciaCC14=substr($RecopilacionIncidenciaCC, 1391,107);

$ResponsabilidadIncidenciaCC1=substr($ResponsabilidadIncidenciaCC, 0,107);
$ResponsabilidadIncidenciaCC2=substr($ResponsabilidadIncidenciaCC, 107,107);
$ResponsabilidadIncidenciaCC3=substr($ResponsabilidadIncidenciaCC, 214,107);
$ResponsabilidadIncidenciaCC4=substr($ResponsabilidadIncidenciaCC, 321,107);
$ResponsabilidadIncidenciaCC5=substr($ResponsabilidadIncidenciaCC, 428,107);
$ResponsabilidadIncidenciaCC6=substr($ResponsabilidadIncidenciaCC, 535,107);

$OrdenesIncidenciaCC1=substr($OrdenesIncidenciaCC, 0,107);
$OrdenesIncidenciaCC2=substr($OrdenesIncidenciaCC, 107,107);
$OrdenesIncidenciaCC3=substr($OrdenesIncidenciaCC, 214,107);
$OrdenesIncidenciaCC4=substr($OrdenesIncidenciaCC, 321,107);
$OrdenesIncidenciaCC5=substr($OrdenesIncidenciaCC, 428,107);
$OrdenesIncidenciaCC6=substr($OrdenesIncidenciaCC, 535,107);

$EvidenciaIncidenciaCC1=substr($EvidenciaIncidenciaCC, 0,107);
$EvidenciaIncidenciaCC2=substr($EvidenciaIncidenciaCC, 107,107);
$EvidenciaIncidenciaCC3=substr($EvidenciaIncidenciaCC, 214,107);
$EvidenciaIncidenciaCC4=substr($EvidenciaIncidenciaCC, 321,107);
$EvidenciaIncidenciaCC5=substr($EvidenciaIncidenciaCC, 428,107);
$EvidenciaIncidenciaCC6=substr($EvidenciaIncidenciaCC, 535,107);

$SupervisionIncidenciaCC1=substr($SupervisionIncidenciaCC, 0,107);
$SupervisionIncidenciaCC2=substr($SupervisionIncidenciaCC, 107,107);
$SupervisionIncidenciaCC3=substr($SupervisionIncidenciaCC, 214,107);
$SupervisionIncidenciaCC4=substr($SupervisionIncidenciaCC, 321,107);
$SupervisionIncidenciaCC5=substr($SupervisionIncidenciaCC, 428,107);
$SupervisionIncidenciaCC6=substr($SupervisionIncidenciaCC, 535,107);

$TareaIncidenciaCC1=substr($TareaIncidenciaCC, 0,107);
$TareaIncidenciaCC2=substr($TareaIncidenciaCC, 107,107);

$pdf = new FPDI();
$pageCount = $pdf->setSourceFile("../uploads/DocumentosReporteIncidenciaCentroControl/Documento_Reporte_Incidencia_CentroDeControl_2022.pdf");
$tplIdx = $pdf->importPage(1);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial", 'B', 14);

$pdf->Text(50, 150, utf8_decode("INCIDENCIA CON ". $PuestoGuardia ));
$pdf->Text(50, 155, utf8_decode("(".$punto.")"));
$pdf->SetFont("Arial", 'B', 9);
$pdf->Text(72, 202, utf8_decode($folio1));
$pdf->Text(80, 206, utf8_decode($folio2));
$pdf->Text(118, 203, utf8_decode($NumeroGuardia));

$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);

$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(97.5, 24, utf8_decode($Tipoinc1));
$pdf->Text(97.5, 28, utf8_decode($Tipoinc2));
$pdf->Text(157.5, 24, utf8_decode($punto1));
$pdf->Text(157.5, 28, utf8_decode($punto2));
$pdf->SetFont("Arial", 'B', 9);
$pdf->Text(81.5, 33.5, utf8_decode($Fecha));
$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(154.5, 33.5, utf8_decode($Lugar));
$pdf->Text(83, 41.5, utf8_decode($NombreAdmin));
$pdf->Text(156, 41.5, utf8_decode($PuestoAdmin));


$pdf->Text(78, 82.5, utf8_decode($TestigoIncidenciaCC1));
$pdf->Text(78, 86.5, utf8_decode($TestigoIncidenciaCC2));

$pdf->Text(78, 91.5, utf8_decode($PercataronIncidenciaCC1));
$pdf->Text(78, 95.5, utf8_decode($PercataronIncidenciaCC2));
$pdf->Text(78, 99.5, utf8_decode($PercataronIncidenciaCC3));

$pdf->Text(78, 104, utf8_decode($RecopilacionIncidenciaCC1));
$pdf->Text(78, 109, utf8_decode($RecopilacionIncidenciaCC2));
$pdf->Text(78, 114, utf8_decode($RecopilacionIncidenciaCC3));
$pdf->Text(78, 119, utf8_decode($RecopilacionIncidenciaCC4));
$pdf->Text(78, 124, utf8_decode($RecopilacionIncidenciaCC5));
$pdf->Text(78, 129, utf8_decode($RecopilacionIncidenciaCC6));
$pdf->Text(78, 134, utf8_decode($RecopilacionIncidenciaCC7));
$pdf->Text(78, 139, utf8_decode($RecopilacionIncidenciaCC8));
$pdf->Text(78, 144, utf8_decode($RecopilacionIncidenciaCC9));
$pdf->Text(78, 149, utf8_decode($RecopilacionIncidenciaCC10));
$pdf->Text(78, 154, utf8_decode($RecopilacionIncidenciaCC11));
$pdf->Text(78, 159, utf8_decode($RecopilacionIncidenciaCC12));
$pdf->Text(78, 164, utf8_decode($RecopilacionIncidenciaCC13));
$pdf->Text(78, 169, utf8_decode($RecopilacionIncidenciaCC14));

$pdf->Text(78, 173.5, utf8_decode($TareaIncidenciaCC1));
$pdf->Text(78, 177.5, utf8_decode($TareaIncidenciaCC2));

$tplIdx = $pdf->importPage(3);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(97.5, 24, utf8_decode($Tipoinc1));
$pdf->Text(97.5, 28, utf8_decode($Tipoinc2));
$pdf->Text(157.5, 24, utf8_decode($punto1));
$pdf->Text(157.5, 28, utf8_decode($punto2));
$pdf->SetFont("Arial", 'B', 9);
$pdf->Text(81.5, 33.5, utf8_decode($Fecha));
$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(154.5, 33.5, utf8_decode($Lugar));
$pdf->Text(83, 41.5, utf8_decode($NombreAdmin));
$pdf->Text(156, 41.5, utf8_decode($PuestoAdmin));

$pdf->Text(73, 95, utf8_decode($ResponsabilidadIncidenciaCC1));
$pdf->Text(73, 100, utf8_decode($ResponsabilidadIncidenciaCC2));
$pdf->Text(73, 105, utf8_decode($ResponsabilidadIncidenciaCC3));
$pdf->Text(73, 110, utf8_decode($ResponsabilidadIncidenciaCC4));
$pdf->Text(73, 115, utf8_decode($ResponsabilidadIncidenciaCC5));
$pdf->Text(73, 120, utf8_decode($ResponsabilidadIncidenciaCC6));

$pdf->Text(73, 126, utf8_decode($OrdenesIncidenciaCC1));
$pdf->Text(73, 131, utf8_decode($OrdenesIncidenciaCC2));
$pdf->Text(73, 136, utf8_decode($OrdenesIncidenciaCC3));
$pdf->Text(73, 141, utf8_decode($OrdenesIncidenciaCC4));
$pdf->Text(73, 146, utf8_decode($OrdenesIncidenciaCC5));
$pdf->Text(73, 151, utf8_decode($OrdenesIncidenciaCC6));

$pdf->Text(73, 157, utf8_decode($EvidenciaIncidenciaCC1));
$pdf->Text(73, 162, utf8_decode($EvidenciaIncidenciaCC2));
$pdf->Text(73, 167, utf8_decode($EvidenciaIncidenciaCC3));
$pdf->Text(73, 172, utf8_decode($EvidenciaIncidenciaCC4));
$pdf->Text(73, 177, utf8_decode($EvidenciaIncidenciaCC5));
$pdf->Text(73, 182, utf8_decode($EvidenciaIncidenciaCC6));

$pdf->Text(73, 188, utf8_decode($SupervisionIncidenciaCC1));
$pdf->Text(73, 193, utf8_decode($SupervisionIncidenciaCC2));
$pdf->Text(73, 198, utf8_decode($SupervisionIncidenciaCC3));
$pdf->Text(73, 203, utf8_decode($SupervisionIncidenciaCC4));
$pdf->Text(73, 208, utf8_decode($SupervisionIncidenciaCC5));
$pdf->Text(73, 213, utf8_decode($SupervisionIncidenciaCC6));

$pdf->SetFont("Arial", 'B', 8);
$pdf->Text(80, 227.5, utf8_decode($Firma));
$pdf->Text(85, 232, utf8_decode($NombreFirma));

for ($i=0; $i < $largoArchivos; $i++) { 
    $Pagina = 4+$i;
    $tplIdx = $pdf->importPage($Pagina);
    $pdf->addPage('P', 'Letter');
    $pdf->useTemplate($tplIdx, null, null, null, null, true);
    $pdf->SetFont("Arial", 'B', 7);
    $pdf->Text(97.5, 24, utf8_decode($Tipoinc1));
    $pdf->Text(97.5, 28, utf8_decode($Tipoinc2));
    $pdf->Text(157.5, 24, utf8_decode($punto1));
    $pdf->Text(157.5, 28, utf8_decode($punto2));
    $pdf->SetFont("Arial", 'B', 9);
    $pdf->Text(81.5, 33.5, utf8_decode($Fecha));
    $pdf->SetFont("Arial", 'B', 7);
    $pdf->Text(154.5, 33.5, utf8_decode($Lugar));
    $pdf->Text(83, 41.5, utf8_decode($NombreAdmin));
    $pdf->Text(156, 41.5, utf8_decode($PuestoAdmin));
    $NombreDocIncidenciaCC = $datos1[$i]["NombreDocIncidenciaCC"];
    $TipoDescripcionIncidenciaCC = $datos1[$i]["TipoDescripcionIncidenciaCC"];
    $rutaFirma="../uploads/DocumentosReporteIncidenciaCentroControl/".$NombreDocIncidenciaCC;
    $pdf->SetFont("Arial", 'B', 15);
    $pdf->Text(70, 55, utf8_decode($TipoDescripcionIncidenciaCC));
    $pdf->Image($rutaFirma,40,70,150);
}
$pdf->Output();
$response = array("status" => "success");



?>

