<?php
require_once ("Negocio/Negocio.class.php");

$negocio = new Negocio ();

//$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (0,0,0,12,30,2016));

//$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (0,0,0,10,30,2016));
//$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("SEMANAL", mktime (0,0,0,7,14,2016));

//$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (23,45,0,7,14,2016));
//$diasAsistencia2 = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (11,59,0,7,15,2016));
//$diasAsistencia3 = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (13,05,0,7,15,2016));
//$diasAsistencia4 = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (12,45,0,8,13,2016));

//$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (23,45,0,7,30,2016));
//$diasAsistencia2 = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (11,59,0,7,31,2016));
//$diasAsistencia3 = $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL", mktime (13,05,0,7,31,2016));

/*
 * Pruebas para el periodo semana
 * 2016-07-14
$periodo = "SEMANAL";
$timestamp01 =  mktime (23,45,0,7,13,2016);
$timestamp02 =  mktime (11,59,0,7,14,2016);
$timestamp03 =  mktime (13,05,0,7,14,2016);

$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ($periodo, $timestamp01);
$diasAsistencia2 = $negocio -> obtenerListaDiasParaAsistencia ($periodo,$timestamp02);
$diasAsistencia3 = $negocio -> obtenerListaDiasParaAsistencia ($periodo,$timestamp03);
 */

/*
 * Pruebas para el periodo catorcenal
 * 2016-07-14
 */
$periodo = "QUINCENAL";
$prueba = 1;

if ($prueba == 1)
{
$timestamp01 =  mktime (23,45,0,7,15,2016);
$timestamp02 =  mktime (11,59,0,7,16,2016);
$timestamp03 =  mktime (13,05,0,7,16,2016);
}
else if ($prueba == 2)
{
$timestamp01 =  mktime (23,45,0,7,31,2016);
$timestamp02 =  mktime (11,59,0,8,1,2016);
$timestamp03 =  mktime (13,05,0,8,1,2016);
}

$diasAsistencia = $negocio -> obtenerListaDiasParaAsistencia ($periodo, $timestamp01);
$diasAsistencia2 = $negocio -> obtenerListaDiasParaAsistencia ($periodo,$timestamp02);
$diasAsistencia3 = $negocio -> obtenerListaDiasParaAsistencia ($periodo,$timestamp03);


echo "<table width='100%'><tr>";
echo "<td valign='top'>" . date("Y-m-d H:i:s", $timestamp01) . "<pre>";
print_r ($diasAsistencia);
echo "</pre></td>";
echo "<td valign='top'>" . date("Y-m-d H:i:s", $timestamp02) . "<pre>";
print_r ($diasAsistencia2);
echo "</pre></td>";
echo "<td valign='top'>" . date("Y-m-d H:i:s", $timestamp03) . "<pre>";
print_r ($diasAsistencia3);
echo "</pre></td>";
//print_r ($diasAsistencia4);
echo "</tr></table>";
?>
