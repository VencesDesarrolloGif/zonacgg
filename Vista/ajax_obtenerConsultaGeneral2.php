<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require_once ("../libs/Classes/PHPExcel.php");

$negocio = new Negocio();

verificarInicioSesion ($negocio);
// $log = new KLogger ( "ajaxReporteGeneral2.log" , KLogger::DEBUG );

$response = array("status" => "success");

try{

	$objPHPExcel = new PHPExcel();
  
  $serialnumber=0;
  //Set header with temp array
  $tmparray =array("Sr.Number","Employee Login","Employee Name");
  //take new main array and set header array in it.
  $sheet =array($tmparray);

	$listaEmpleados= $negocio -> consultaGeneral();
	$response["listaEmpleados"]= $listaEmpleados;
	//$log->LogInfo("Valor de la variable \$ResponselistaEmpleados: " . var_export ($response, true));
  // $log->LogInfo("Valor de la variable \$listaEmpleados: " . var_export ($listaEmpleados, true));
	  $tmparray =array("#Empleado","Ap. Paterno", "Ap. Materno");
  //take new main array and set header array in it.
  $sheet =array($tmparray);

	for ($i = 0; $i < count($listaEmpleados); $i++)
        {

    $tmparray =array();

    $numeroEmpleado = $listaEmpleados[$i]["numeroEmpleado"];
    array_push($tmparray,$numeroEmpleado);

    $apellidoPaterno = $listaEmpleados[$i] ["apellidoPaterno"];
    array_push($tmparray,$apellidoPaterno);   

    $apellidoMaterno = $listaEmpleados[$i] ["apellidoMaterno"];
    array_push($tmparray,$apellidoMaterno);  

    $numeroCtaClabe = $listaEmpleados[$i] ["numeroCtaClabe"];
    array_push($tmparray,$numeroCtaClabe);  

    $codigoPostalUnidad = $listaEmpleados[$i] ["codigoPostalUnidad"];
    array_push($tmparray,$codigoPostalUnidad);   

    $fechaIngreso = $listaEmpleados[$i] ["fechaIngreso"];
    array_push($tmparray,$fechaIngreso);

    array_push($sheet,$tmparray);

	

        }



        
   header('Content-type: application/vnd.ms-excel');
   header('Content-Disposition: attachment; filename="name.xlsx"');
  $worksheet = $objPHPExcel->getActiveSheet();


  foreach($sheet as $row => $columns) {
    foreach($columns as $column => $data) {
        $worksheet->setCellValueByColumnAndRow($column, $row + 1, $data);


        //$worksheet->setCellValueExplicitByColumnAndRow($column, $row + 1, $data, PHPExcel_Cell_DataType::TYPE_DATE);

        //$log->LogInfo("Valor de la variable \$column: " . var_export ($column, true));
        //$log->LogInfo("Valor de la variable \$row: " . var_export ($row, true));
        //$log->LogInfo("Valor de la variable \$data: " . var_export ($data, true));


    }
  }

  //make first row bold
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
//exit;





} 
catch( Exception $e )
{
	$response["status"]="error";
	$response["error"]="No se puedo obtener reporte";
}

echo json_encode($response);

?>