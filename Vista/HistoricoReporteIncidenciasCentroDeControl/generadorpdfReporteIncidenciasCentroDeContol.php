<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
use setasign\Fpdi\Fpdi;
// require_once('../../libs/Fpdi/src/Fpdi.php');
// require_once('../../libs/Fpdi/Fpdi.php');
require_once('../../libs/fpdf/fpdf.php');
require_once('../../libs/fpdi/src/autoload.php');
// require('../../libs/fpdi/src/Fpdi.php');
// require_once('../../libs/fpdi/src/TcpdfFpdi.php');
//enviar el usuario para que pueda traer la consulta negocio_obtenerEmpleadoPorId
date_default_timezone_set('America/Mexico_City'); //Asignas la zona horaria de tu país.
setlocale(LC_TIME, 'spanish'); //Fijamos el tiempo local
//$log = new KLogger ( "generadorpdfReporteIncidenciasCentroDeContol.log" , KLogger::DEBUG );
$response = array ();
$datos              = array();
$datos1             = array();
$idIncidencia=$_GET["idIncidencia"];

//$log->LogInfo("Valor de la variable idIncidencia " . var_export ($idIncidencia, true));
//echo “Hoy es:”.$diaSemana; //Imprimimos El día.

$sql = "SELECT ri.FolioIncidenciaCC as NumeroFolio,cti.descripcionTipoIncidenciaCC as DescripcionTipoIncidencia, p.descripcionPuesto as PuestoGuardia, concat_ws('-',ri.EmpEntidadIncidenciaCC,ri.EmpConsecutivoIncidenciaCC,ri.EmpCategoriaIncidenciaCC) as NumeroGuardia, concat_ws(' ',e.nombreEmpleado,e.apellidoPaterno,e.apellidoMaterno) as NombreGuardia, ri.ExistePuntoIncidenciaCC as ExistePunto,cps.puntoServicio as PuntoServicioDes, ri.PuntoServicioIncidenciaCC as PuntoServicioText,ri.FechaIncidenciaCC as FechaIncidencia,ef.nombreEntidadFederativa as Lugar,concat_ws('-',emp.entidadFederativaId,emp.empleadoConsecutivoId,emp.empleadoCategoriaId) as NumeroAdmin,concat_ws(' ',emp.nombreEmpleado,emp.apellidoPaterno,emp.apellidoMaterno) as NombreAdmin, cp.descripcionPuesto as PuestoAdmin,ri.TestigoIncidenciaCC,ri.PercataronIncidenciaCC,ri.RecopilacionIncidenciaCC,ri.TareaIncidenciaCC,ri.ResponsabilidadIncidenciaCC,ri.OrdenesIncidenciaCC,ri.EvidenciaIncidenciaCC,ri.SupervisionIncidenciaCC,ri.EmpleadoRegistroIncidenciaCC as NumeroFirma,concat_ws(' ',emp1.nombreEmpleado,emp1.apellidoPaterno,emp1.apellidoMaterno) as NombreFirma,ri.ContraseniaEmpIncidenciaCC as Firma,ri.TestigoIncidenciaCC2,ri.TestigoIncidenciaCC3,ri.TestigoIncidenciaCC4,ri.TestigoIncidenciaCC5,ri.TestigoIncidenciaCC6,ri.TestigoIncidenciaCC7,ri.RecopilacionIncidenciaCC2,ri.RecopilacionIncidenciaCC3,ri.RecopilacionIncidenciaCC4,ri.RecopilacionIncidenciaCC5,ri.RecopilacionIncidenciaCC6,ri.RecopilacionIncidenciaCC7,ri.RecopilacionIncidenciaCC8,ri.RecopilacionIncidenciaCC9,ri.RecopilacionIncidenciaCC10,ri.ResponsabilidadIncidenciaCC2,ri.OrdenesIncidenciaCC2,ri.EvidenciaIncidenciaCC2,ri.SupervisionIncidenciaCC2
    FROM ReporteIncidenciaCentroControl ri 
    LEFT JOIN empleados e ON(ri.EmpEntidadIncidenciaCC=e.entidadFederativaId AND ri.EmpConsecutivoIncidenciaCC=e.empleadoConsecutivoId AND ri.EmpCategoriaIncidenciaCC =e.empleadoCategoriaId)
    LEFT JOIN catalogopuestos p ON(e.empleadoIdPuesto=p.idPuesto)
    LEFT JOIN catalogopuntosservicios cps ON(ri.IdPuntoIncidenciaCC=cps.idPuntoServicio)
    LEFT JOIN entidadesfederativas ef ON(ri.IdEntidadIncidenciaCC=ef.idEntidadFederativa)
    LEFT JOIN empleados emp ON(ri.AdminEntidadIncidenciaCC=emp.entidadFederativaId AND ri.AdminConsecutivoIncidenciaCC=emp.empleadoConsecutivoId AND ri.AdminCategoriaIncidenciaCC =emp.empleadoCategoriaId)
    LEFT JOIN catalogopuestos cp ON(emp.empleadoIdPuesto=cp.idPuesto)
    LEFT JOIN CatalogoTipoIncidenciaCentroC cti ON(cti.idTipoIncidenciaCC=ri.idIncidenciaCC)
    LEFT JOIN empleados emp1 ON(concat_ws('-',emp1.entidadFederativaId,emp1.empleadoConsecutivoId,emp1.empleadoCategoriaId)=ri.EmpleadoRegistroIncidenciaCC)
    WHERE ri.idinciIdenciaCC='$idIncidencia'";
     $res = mysqli_query($conexion, $sql);
    while (($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
        $datos[] = $reg;
    }

$NumeroFirma = $datos[0]["NumeroFirma"];
$NombreFirma = $datos[0]["NombreFirma"];
$Firma = $datos[0]["Firma"];
$NumeroFolio = $datos[0]["NumeroFolio"];
$DescripcionTipoIncidencia = $datos[0]["DescripcionTipoIncidencia"];
$PuestoGuardia= $datos[0]["PuestoGuardia"];
$NumeroGuardia= $datos[0]["NumeroGuardia"];
$NombreGuardia= $datos[0]["NombreGuardia"];
$ExistePunto  = $datos[0]["ExistePunto"];
$PuntoServicioDes = $datos[0]["PuntoServicioDes"];
$PuntoServicioText= $datos[0]["PuntoServicioText"];
$FechaIncidencia  = $datos[0]["FechaIncidencia"];
$Lugar = $datos[0]["Lugar"];
$NumeroAdmin = $datos[0]["NumeroAdmin"];
$NombreAdmin = $datos[0]["NombreAdmin"];
$PuestoAdmin = $datos[0]["PuestoAdmin"];
$PercataronIncidenciaCC = $datos[0]["PercataronIncidenciaCC"];
$TareaIncidenciaCC = $datos[0]["TareaIncidenciaCC"];

$TestigoIncidenciaCC = $datos[0]["TestigoIncidenciaCC"];
$TestigoIncidenciaCC2 = $datos[0]["TestigoIncidenciaCC2"];
$TestigoIncidenciaCC3 = $datos[0]["TestigoIncidenciaCC3"];
$TestigoIncidenciaCC4 = $datos[0]["TestigoIncidenciaCC4"];
$TestigoIncidenciaCC5 = $datos[0]["TestigoIncidenciaCC5"];
$TestigoIncidenciaCC6 = $datos[0]["TestigoIncidenciaCC6"];
$TestigoIncidenciaCC7 = $datos[0]["TestigoIncidenciaCC7"];
$RecopilacionIncidenciaCC = $datos[0]["RecopilacionIncidenciaCC"];
$RecopilacionIncidenciaCC2 = $datos[0]["RecopilacionIncidenciaCC2"];
$RecopilacionIncidenciaCC3 = $datos[0]["RecopilacionIncidenciaCC3"];
$RecopilacionIncidenciaCC4 = $datos[0]["RecopilacionIncidenciaCC4"];
$RecopilacionIncidenciaCC5 = $datos[0]["RecopilacionIncidenciaCC5"];
$RecopilacionIncidenciaCC6 = $datos[0]["RecopilacionIncidenciaCC6"];
$RecopilacionIncidenciaCC7 = $datos[0]["RecopilacionIncidenciaCC7"];
$RecopilacionIncidenciaCC8 = $datos[0]["RecopilacionIncidenciaCC8"];
$RecopilacionIncidenciaCC9 = $datos[0]["RecopilacionIncidenciaCC9"];
$RecopilacionIncidenciaCC10  = $datos[0]["RecopilacionIncidenciaCC10"];
$ResponsabilidadIncidenciaCC = $datos[0]["ResponsabilidadIncidenciaCC"];
$ResponsabilidadIncidenciaCC2= $datos[0]["ResponsabilidadIncidenciaCC2"];
$OrdenesIncidenciaCC      = $datos[0]["OrdenesIncidenciaCC"];
$OrdenesIncidenciaCC2     = $datos[0]["OrdenesIncidenciaCC2"];
$EvidenciaIncidenciaCC    = $datos[0]["EvidenciaIncidenciaCC"];
$EvidenciaIncidenciaCC2   = $datos[0]["EvidenciaIncidenciaCC2"];
$SupervisionIncidenciaCC  = $datos[0]["SupervisionIncidenciaCC"];
$SupervisionIncidenciaCC2 = $datos[0]["SupervisionIncidenciaCC2"];

$TestigoIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TestigoIncidenciaCC);


$TestigoIncidenciaCC2 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TestigoIncidenciaCC2);

$TestigoIncidenciaCC3 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TestigoIncidenciaCC3);

$TestigoIncidenciaCC4 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TestigoIncidenciaCC4);

   $TestigoIncidenciaCC5 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TestigoIncidenciaCC5);

   $TestigoIncidenciaCC6 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TestigoIncidenciaCC6);

   $TestigoIncidenciaCC7 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TestigoIncidenciaCC7);

   $PercataronIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $PercataronIncidenciaCC);

   $RecopilacionIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC);

   $RecopilacionIncidenciaCC2 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC2);

   $RecopilacionIncidenciaCC3 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC3);

   $RecopilacionIncidenciaCC4 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC4);

   $RecopilacionIncidenciaCC5 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC5);

   $RecopilacionIncidenciaCC6 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC6);

   $RecopilacionIncidenciaCC7 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC7);

   $RecopilacionIncidenciaCC8 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC8);

   $RecopilacionIncidenciaCC9 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC9);

   $RecopilacionIncidenciaCC10 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $RecopilacionIncidenciaCC10);

   $TareaIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $TareaIncidenciaCC);

   $ResponsabilidadIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $ResponsabilidadIncidenciaCC);

   $ResponsabilidadIncidenciaCC2 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $ResponsabilidadIncidenciaCC2);

   $OrdenesIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $OrdenesIncidenciaCC);

   $OrdenesIncidenciaCC2 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $OrdenesIncidenciaCC2);

   $EvidenciaIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $EvidenciaIncidenciaCC);

   $EvidenciaIncidenciaCC2 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $EvidenciaIncidenciaCC2);

   $SupervisionIncidenciaCC = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $SupervisionIncidenciaCC);

   $SupervisionIncidenciaCC2 = str_replace(
   array('Á','À','Â','Ä','á','à','ä','â','ª','É','È','Ê','Ë','é','è','ë','ê','Í','Ì','Ï','Î','í','ì','ï','î','Ó','Ò','Ö','Ô','ó','ò','ö','ô','Ú','Ù','Û','Ü','ú','ù','ü','û'),
   array('A','A','A','A','a','a','a','a','a','E','E','E','E','e','e','e','e','I','I','I','I','i','i','i','i','O','O','O','O','o','o','o','o','U','U','U','U','u','u','u','u'),
   $SupervisionIncidenciaCC2);

$sql1 = "SELECT * 
         FROM ReporteIncidenciaDocumentosCentroControl
         WHERE idIncidenciaDocCC='$idIncidencia'";
    
    $res1 = mysqli_query($conexion, $sql1);
    
    while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
           $datos1[] = $reg1;
    }

$largoArchivos = count($datos1);
$explodeNumeroFolio = explode(" ", $NumeroFolio);
$folio1  = $explodeNumeroFolio[0];
$folio2  = $explodeNumeroFolio[1];
$Tipoinc = $PuestoGuardia." GIF ".$NumeroGuardia;
$Tipoinc1=substr($Tipoinc, 1,25);
$Tipoinc2=substr($Tipoinc, 25,50);

if($ExistePunto=="1"){
   $punto = $PuntoServicioDes;
}else{
   $punto = $PuntoServicioText;
}

$punto1=substr($punto, 1,25);
$punto2=substr($punto, 25,50);
$explodeFechaIncidencia = explode('-', $FechaIncidencia);
$dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
$meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$anio = $explodeFechaIncidencia[0];
$mes  = $explodeFechaIncidencia[1];
$dia  = $explodeFechaIncidencia[2];
$dia1 = $dias[(date('N', strtotime($FechaIncidencia))) - 1];
$Fecha= $dia1 ." ".$dia." de ".$meses[$mes-1]. " del ".$anio;

$pdf = new FPDI();
$pageCount= $pdf->setSourceFile("../uploads/DocumentosReporteIncidenciaCentroControl/Documento_Reporte_Incidencia_CentroDeControl_2022.pdf");
$tplIdx   = $pdf->importPage(1);
$size = $pdf->getTemplateSize($tplIdx);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial", 'B', 14);
$pdf->Text(50, 150, utf8_decode("INCIDENCIA CON ". $PuestoGuardia ));
$pdf->Text(50, 155, utf8_decode("(".$punto.")"));
$pdf->SetFont("Arial", 'B', 9);
$pdf->Text(72, 202, utf8_decode($folio1));
$pdf->Text(80, 206, utf8_decode($folio2));
$pdf->Text(118, 203, utf8_decode($NumeroAdmin));

$tplIdx = $pdf->importPage(2);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial",'B',15);
$pdf->SetLeftMargin(73);

if($TestigoIncidenciaCC!=""){
   $pdf->SetY(81.5);
   $pdf->MultiCell(126,4.7,"*");//testigo1
}if($TestigoIncidenciaCC2!=""){
    $pdf->SetY(85.5);
    $pdf->MultiCell(126,4.7,"*");//testigo2
}if($TestigoIncidenciaCC3!=""){
   $pdf->SetY(89.5);
   $pdf->MultiCell(126,4.7,"*");//testigo3
}if($TestigoIncidenciaCC4!=""){
   $pdf->SetY(93.5);
   $pdf->MultiCell(126,4.7,"*");//testigo4
}if($TestigoIncidenciaCC5!=""){
   $pdf->SetY(97.5);
   $pdf->MultiCell(126,4.7,"*");//testigo5
}if($TestigoIncidenciaCC6!=""){
   $pdf->SetY(101.5);
   $pdf->MultiCell(126,4.7,"*");//testigo6
}if($TestigoIncidenciaCC7!=""){
   $pdf->SetY(110.5);
   $pdf->MultiCell(126,4.7,"*");//testigo7
}

if($PercataronIncidenciaCC!=""){
   $pdf->SetY(110);
   $pdf->MultiCell(126,4.7,"*");//
}

$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(97.5, 26, utf8_decode($Tipoinc1));
$pdf->Text(97.5, 28, utf8_decode($Tipoinc2));
$pdf->Text(157.5, 26, utf8_decode($punto1));
$pdf->Text(157.5, 28, utf8_decode($punto2));
$pdf->SetFont("Arial", 'B', 9);
$pdf->Text(81.5, 33.5, utf8_decode($Fecha));
$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(154.5, 33.5, utf8_decode($Lugar));
$pdf->Text(83, 41.5, utf8_decode($NombreAdmin));
$pdf->Text(156, 41.5, utf8_decode($PuestoAdmin));
$pdf->SetLeftMargin(78);
$pdf->SetRightMargin(12);
$pdf->SetY(80);
$pdf->MultiCell(126,5,$TestigoIncidenciaCC);
$pdf->SetY(84);
$pdf->MultiCell(126,4.5,$TestigoIncidenciaCC2);
$pdf->SetY(88);
$pdf->MultiCell(126,4.5,$TestigoIncidenciaCC3);
$pdf->SetY(92);
$pdf->MultiCell(126,4.5,$TestigoIncidenciaCC4);
$pdf->SetY(96);
$pdf->MultiCell(126,4.5,$TestigoIncidenciaCC5);
$pdf->SetY(100);
$pdf->MultiCell(126,4.5,$TestigoIncidenciaCC6);
$pdf->SetY(104);
$pdf->MultiCell(126,4.5,$TestigoIncidenciaCC7);
$pdf->SetY(109.5);
$pdf->MultiCell(126,4,$PercataronIncidenciaCC);


if($RecopilacionIncidenciaCC!=""){
   $tplIdx = $pdf->importPage(3);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(52);
   $pdf->MultiCell(126,4.7,"*");//parrafo1

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(50.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC);

}if($RecopilacionIncidenciaCC2!=""){
   $tplIdx = $pdf->importPage(4);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC2);
 }
 if($RecopilacionIncidenciaCC3!=""){
   $tplIdx = $pdf->importPage(5);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC3);
 }
 if($RecopilacionIncidenciaCC4!=""){
   $tplIdx = $pdf->importPage(6);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC4);
 }
 if($RecopilacionIncidenciaCC5!=""){
   $tplIdx = $pdf->importPage(7);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC5);
 }
 if($RecopilacionIncidenciaCC6!=""){
   $tplIdx = $pdf->importPage(8);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC6);
 }
 if($RecopilacionIncidenciaCC7!=""){
   $tplIdx = $pdf->importPage(9);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC7);
 }
 if($RecopilacionIncidenciaCC8!=""){
   $tplIdx = $pdf->importPage(10);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC8);
 }
 if($RecopilacionIncidenciaCC9!=""){
   $tplIdx = $pdf->importPage(11);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC9);
 }
 if($RecopilacionIncidenciaCC10!=""){
   $tplIdx = $pdf->importPage(12);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$RecopilacionIncidenciaCC10);
 }
 if($RecopilacionIncidenciaCC10!=""){
   $tplIdx = $pdf->importPage(13);
   $pdf->addPage('P','Letter');
   $pdf->useTemplate($tplIdx, null, null, null, null, true);
   $pdf->SetFont("Arial",'B',15);
   $pdf->SetLeftMargin(73);
   $pdf->SetY(48);
   $pdf->MultiCell(126,4.7,"*");//parrafo2

   $pdf->SetFont("Arial",'B',7);
   $pdf->Text(97.5,26,utf8_decode($Tipoinc1));
   $pdf->Text(97.5,28,utf8_decode($Tipoinc2));
   $pdf->Text(157.5,26,utf8_decode($punto1));
   $pdf->Text(157.5,28,utf8_decode($punto2));
   $pdf->SetFont("Arial",'B',9);
   $pdf->Text(81.5,33.5, utf8_decode($Fecha));
   $pdf->SetFont("Arial",'B',7.3);
   $pdf->Text(154.5,33.5,utf8_decode($Lugar));
   $pdf->Text(83, 41.5,utf8_decode($NombreAdmin));
   $pdf->Text(156,41.5,utf8_decode($PuestoAdmin));
   $pdf->SetLeftMargin(78);
   $pdf->SetRightMargin(12);
   $pdf->SetY(46.5);
   $pdf->MultiCell(126,4.7,$TareaIncidenciaCC);
 }


$tplIdx = $pdf->importPage(14);
$pdf->addPage('P', 'Letter');
$pdf->useTemplate($tplIdx, null, null, null, null, true);
$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(97.5, 26, utf8_decode($Tipoinc1));
$pdf->Text(97.5, 28, utf8_decode($Tipoinc2));
$pdf->Text(157.5, 26, utf8_decode($punto1));
$pdf->Text(157.5, 28, utf8_decode($punto2));
$pdf->SetFont("Arial", 'B', 9);
$pdf->Text(81.5, 33.5, utf8_decode($Fecha));
$pdf->SetFont("Arial", 'B', 7);
$pdf->Text(154.5, 33.5, utf8_decode($Lugar));
$pdf->Text(83, 41.5, utf8_decode($NombreAdmin));
$pdf->Text(156, 41.5, utf8_decode($PuestoAdmin));
$pdf->SetFont("Arial",'B',15);
$pdf->SetLeftMargin(68);

if($ResponsabilidadIncidenciaCC!=""){
   $pdf->SetY(91);
   $pdf->MultiCell(126,4.7,"*");//Responsabilidad1
}if($ResponsabilidadIncidenciaCC2!=""){
    $pdf->SetY(106);
    $pdf->MultiCell(126,4.7,"*");//Responsabilidad2
}

if($OrdenesIncidenciaCC!=""){
   $pdf->SetY(122);
   $pdf->MultiCell(126,4.7,"*");//Ordenes1
}if($OrdenesIncidenciaCC2!=""){
    $pdf->SetY(137);
    $pdf->MultiCell(126,4.7,"*");//Ordenesfo2
}

if($EvidenciaIncidenciaCC!=""){
   $pdf->SetY(153.5);
   $pdf->MultiCell(126,4.7,"*");//Evidencia1
}if($EvidenciaIncidenciaCC2!=""){
    $pdf->SetY(168.5);
    $pdf->MultiCell(126,4.7,"*");//Evidencia2
}

if($SupervisionIncidenciaCC!=""){
   $pdf->SetY(184.5);
   $pdf->MultiCell(126,4.7,"*");//Supervision1
}if($SupervisionIncidenciaCC2!=""){
    $pdf->SetY(199.5);
    $pdf->MultiCell(126,4.7,"*");//Supervision2
}

$pdf->SetLeftMargin(73);
$pdf->SetRightMargin(12);
$pdf->SetFont("Arial", 'B', 7.3);
$pdf->SetY(90);
$pdf->MultiCell(126,4.3,$ResponsabilidadIncidenciaCC);
$pdf->SetY(105);
$pdf->MultiCell(126,4.3,$ResponsabilidadIncidenciaCC2);
$pdf->SetY(121);
$pdf->MultiCell(126,4.3,$OrdenesIncidenciaCC);
$pdf->SetY(136);
$pdf->MultiCell(126,4.3,$OrdenesIncidenciaCC2);
$pdf->SetY(152.5);
$pdf->MultiCell(126,4.3,$EvidenciaIncidenciaCC);
$pdf->SetY(167.5);
$pdf->MultiCell(126,4.3,$EvidenciaIncidenciaCC2);
$pdf->SetY(183.5);
$pdf->MultiCell(126,4.3,$SupervisionIncidenciaCC);
$pdf->SetY(198.5);
$pdf->MultiCell(126,4.3,$SupervisionIncidenciaCC2);
$pdf->Text(82, 227.5, utf8_decode($Firma));
$pdf->Text(90, 232, utf8_decode($NombreFirma));

for($i=0; $i < $largoArchivos; $i++) { 
    $Pagina = 15+$i;
    $tplIdx = $pdf->importPage($Pagina);
    $pdf->addPage('P', 'Letter');
    $pdf->useTemplate($tplIdx, null, null, null, null, true);
    $pdf->SetFont("Arial", 'B', 7);
    $pdf->Text(97.5,26, utf8_decode($Tipoinc1));
    $pdf->Text(97.5,28, utf8_decode($Tipoinc2));
    $pdf->Text(157.5,26, utf8_decode($punto1));
    $pdf->Text(157.5,28, utf8_decode($punto2));
    $pdf->SetFont("Arial", 'B', 9);
    $pdf->Text(81.5,33.5, utf8_decode($Fecha));
    $pdf->SetFont("Arial", 'B', 7);
    $pdf->Text(154.5,33.5, utf8_decode($Lugar));
    $pdf->Text(83, 41.5, utf8_decode($NombreAdmin));
    $pdf->Text(156,41.5, utf8_decode($PuestoAdmin));
    $NombreDocIncidenciaCC = $datos1[$i]["NombreDocIncidenciaCC"];
    $TipoDescripcionIncidenciaCC = $datos1[$i]["TipoDescripcionIncidenciaCC"];
    $rutaFirma="../uploads/DocumentosReporteIncidenciaCentroControl/".$NombreDocIncidenciaCC;
    $pdf->SetFont("Arial", 'B', 15);
    $pdf->Text(70, 55, utf8_decode($TipoDescripcionIncidenciaCC));
    $pdf->Image($rutaFirma,45,60,100);
}
$pdf->Output();
$response = array("status" => "success");
?>