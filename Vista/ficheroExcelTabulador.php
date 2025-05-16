<?php
$accion=$_GET["accion"];
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");
if($accion==1){
echo utf8_decode($_POST['datos_tabulador']);
}else if($accion==2){
echo utf8_decode($_POST['datos_tabuladorplnatillasinactivas']);
}
?>