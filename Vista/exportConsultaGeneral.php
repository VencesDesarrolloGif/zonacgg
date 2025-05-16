<?php
session_start();

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once ("../libs/logger/KLogger.php");
require_once ("../libs/Classes/PHPExcel.php");

$negocio = new Negocio();
verificarInicioSesion ($negocio);

$empleados= $negocio -> consultaGeneral();
    
        $objPHPExcel = new PHPExcel();                                               //creando un objeto excel
        
        $objPHPExcel->getProperties()->setCreator("iiTze");   //propiedades
        $objPHPExcel->setActiveSheetIndex(0);                                 //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Hoja1");           //título de la hoja 1

        $objPHPExcel->getActiveSheet()->setCellValue('A1', '#Empleado');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Ap. Paterno');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Ap. Materno');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Nombre(s)');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FechaIngreso');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'RFC');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'CURP');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Num. Imss');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Num. Cta');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Num. Cta Clabe');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Puesto');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Tipo Puesto');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Turno');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Sexo');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'Estatus');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'Fecha Baja');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'Edo. Civil');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', 'Fecha Nac');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', 'Pais Nac.');
        $objPHPExcel->getActiveSheet()->setCellValue('T1', 'Nacionalidad');
        $objPHPExcel->getActiveSheet()->setCellValue('U1', 'Entidad Nac.');
        $objPHPExcel->getActiveSheet()->setCellValue('V1', 'Municipio Nac.');
        $objPHPExcel->getActiveSheet()->setCellValue('W1', 'Grado Estudios');
        $objPHPExcel->getActiveSheet()->setCellValue('X1', 'Estatus Cartilla');
        $objPHPExcel->getActiveSheet()->setCellValue('Y1', 'Num. Cartilla');
        $objPHPExcel->getActiveSheet()->setCellValue('Z1', 'Oficio');
        $objPHPExcel->getActiveSheet()->setCellValue('AA1', 'Tipo Sangre');
        $objPHPExcel->getActiveSheet()->setCellValue('AB1', 'Calle Vivienda');
        $objPHPExcel->getActiveSheet()->setCellValue('AC1', 'NUm. Ext.');
        $objPHPExcel->getActiveSheet()->setCellValue('AD1', 'Num. Int.');
        $objPHPExcel->getActiveSheet()->setCellValue('AE1', 'Colonia');
        $objPHPExcel->getActiveSheet()->setCellValue('AF1', 'Municipio');
        $objPHPExcel->getActiveSheet()->setCellValue('AG1', 'Entidad Federativa');
        $objPHPExcel->getActiveSheet()->setCellValue('AH1', 'CP');
        $objPHPExcel->getActiveSheet()->setCellValue('AI1', 'Tel. Fijo');
        $objPHPExcel->getActiveSheet()->setCellValue('AJ1', 'Tel. Movil');
        $objPHPExcel->getActiveSheet()->setCellValue('AK1', 'Correo');
        $objPHPExcel->getActiveSheet()->setCellValue('AL1', 'UMF');

 
        //llenando celdas
        $column = 0;
        $row = 2;
        foreach ($empleados as $record)
        {
                foreach ($record as $value)
                {
                    // Manejar la columna de fecha
                    if ($column == 4)
                    {
                        $value = PHPExcel_Shared_Date::stringToExcel($value);                            
                    }

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $value);
                    
                    $column++;
                }
                $column = 0;
                $row++;
        }
        
        
        // Poniendo la columna E con formato de fecha
       $objPHPExcel->getActiveSheet()
            ->getStyle('E2:E' . ($row + 1))
            ->getNumberFormat()
            ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
            
 
        //poniendo en negritas la fila de los títulos
        $styleArray = array('font' => array('bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('A1:AL1')-> applyFromArray($styleArray);  
 
        //poniendo columnas con tamaño auto según el contenido, asumiendo N como la última
        for ($i = 'A'; $i<= 'Z'; $i++)
                $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true); 
 
        //código de exportar (ver artículo antes mencionado)
       
       




header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
 


?>