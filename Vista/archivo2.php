<?php
require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();

//verificarInicioSesion ($negocio);

// $log = new KLogger ( "ajaxGeneraTxtAlta.log" , KLogger::DEBUG ); 

$registroPatronal=$_GET["registroPatronal"];

//$usuario = $_SESSION ["userLog"]["usuario"];

$nombre_archivo = "archivosImss/Alta_".$registroPatronal."_".date("Y-m-d_His").".txt" ; 
 
    if(file_exists($nombre_archivo))
    {
        $mensaje = "El Archivo $nombre_archivo se ha modificado";
    }
 
    else
    {
        $mensaje = "El Archivo $nombre_archivo se ha creado";
    }
 
    if($file = fopen($nombre_archivo, "a"))
    {
        $listaEmpleados= $negocio -> obtenerListaEmpleadosSinImssPorRegistroPatronal($registroPatronal);


         $ultimonumeroTxt =$negocio->traerUltimoFolioTxt();

         //$log->LogInfo("************************usuario Genera TXT: " . var_export ($usuario, true));

        $unidad=1;
        $aguinaldo=15/365;
        $lastLine1="*************";
        //$lastLine2="000001";
        $lastLine3="00000";
        $idFormato=9;
   
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {   
            $empleadoId = $listaEmpleados[$i] ["numeroEmpleado"];
            $registroPatronal=$listaEmpleados[$i]["registroPatronal"];
            $empleadoNumeroSeguroSocial=$listaEmpleados[$i]["empleadoNumeroSeguroSocial"];
            $apellidoPaterno=utf8_decode($listaEmpleados[$i]["apellidoPaterno"]);
            $apellidoMaterno=utf8_decode($listaEmpleados[$i]["apellidoMaterno"]);
            $nombreEmpleado=utf8_decode($listaEmpleados[$i]["nombreEmpleado"]);
            $salarioDiario=$listaEmpleados[$i]["salarioDiario"];
            $diasTranscurridos=$listaEmpleados[$i]["diasTranscurridos"];
            $tipoTrabajador=$listaEmpleados[$i]["tipoTrabajador"];
            $idTxtImssDatosImss=$listaEmpleados[$i]["idTxtImssDatosImss"]; // se agrego del catalogo CatalogomovimientoTxtImss
            $fechaImss=$listaEmpleados[$i]["fechaImss"];
            $curpEmpleado="";
            $tipoSal=0;
            $jornada=0;
            $umf="000";
            if($idTxtImssDatosImss == "07" || $idTxtImssDatosImss == 07){ // se agrego del catalogo CatalogomovimientoTxtImss despues de una segunda actualizacion 
                $tipoMov="07";
            }else{
                $tipoMov="08";
            }
            $numguia="00000";

            $empleadoidd = explode("-", $empleadoId);
/*
            $empleadoEntidad=substr($empleadoId, 0,2);
            $empleadoConsecutivo=substr($empleadoId, 3,4);
            $empleadoCategoria=substr($empleadoId, 8,2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];


        




            $emisionAltaImssConfirmada=$listaEmpleados[$i]["emisionAltaImssConfirmada"];

            //$log->LogInfo("Valor de la variable \$emisionAltaImssConfirmada: " . var_export ($emisionAltaImssConfirmada, true));

            if($emisionAltaImssConfirmada==1){
                $datosImss = array (
            "empladoEntidadImss" =>$empleadoEntidad,
            "empleadoConsecutivoImss" => $empleadoConsecutivo,
            "empleadoCategoriaImss" => $empleadoCategoria,
            "empleadoEstatusImss" =>2,
            "folioTxt" =>$ultimonumeroTxt["ultimoFolio"],
            );

            //$log->LogInfo("Valor de la variable \$datosImss: " . var_export ($datosImss, true));

            //$path = $_SERVER["DOCUMENT_ROOT"]; 
 
            if ($diasTranscurridos <= 365) {
                $primaVacacional = 3;
            
            } elseif ($diasTranscurridos >= 366 and $diasTranscurridos <= 730) {
            
                $primaVacacional = 3.5;
            
            } elseif ($diasTranscurridos >= 731 and $diasTranscurridos <= 1095) {
            
                $primaVacacional = 4;
            } elseif ($diasTranscurridos >= 1096 and $diasTranscurridos <= 1460) {
            
                $primaVacacional = 4.5;
            
            } elseif ($diasTranscurridos >= 1461 and $diasTranscurridos <= 1825) {
            
                $primaVacacional = 5;
            
            } elseif ($diasTranscurridos >= 1826 and $diasTranscurridos <= 3650) {
            
                $primaVacacional = 5.5;
            
            } elseif ($diasTranscurridos >= 3651 and $diasTranscurridos <= 5475) {
            
                $primaVacacional = 6;
            
            } elseif ($diasTranscurridos >= 5476 and $diasTranscurridos <= 7300) {
            
                $primaVacacional = 6.5;
            
            } elseif ($diasTranscurridos >= 7301 and $diasTranscurridos <= 9125) {
            
                $primaVacacional = 7;
            
            } elseif ($diasTranscurridos >= 9126 and $diasTranscurridos <= 10950) {
            
                $primaVacacional = 7.5;
            
            } elseif ($diasTranscurridos >= 10951 and $diasTranscurridos <= 12775) {
            
                $primaVacacional = 8;
            
            }
            $factorIntegracion=$unidad+($primaVacacional/365)+$aguinaldo;
            $sbc=number_format($factorIntegracion*$salarioDiario, 2, '.', '');

            //$sbc1=strtr($sbc,".","");

            $sbc1=str_replace('.', '', $sbc);
           // $sbc2=str_pad($sbc1, 6);
            $sbc3=str_pad($sbc1, 6, '0', STR_PAD_LEFT);
            $sbc4=str_pad($sbc3, 12, '0', STR_PAD_RIGHT);

            $fechaImss1= date('d/m/Y',strtotime($fechaImss));
            $fechaImss2=str_replace('/', '', $fechaImss1);
            $codEmpleado=str_replace('-', '', $empleadoId);

            fputs($file,$registroPatronal);
            fputs($file,$empleadoNumeroSeguroSocial);
            fputs($file,str_pad($apellidoPaterno, 27));
            fputs($file,str_pad($apellidoMaterno, 27));
            fputs($file,str_pad($nombreEmpleado, 27)); 
            fputs($file,$sbc4);
            fputs($file,$idTxtImssDatosImss);
            fputs($file,$tipoSal);
            fputs($file,$jornada);
            fputs($file,$fechaImss2);
            fputs($file,str_pad($umf, 5));
            fputs($file,$tipoMov);
            fputs($file,$numguia);
            fputs($file,str_pad($codEmpleado,11));
            fputs($file,str_pad($curpEmpleado,18));
            fputs($file,$idFormato);
            //fputs($file,$path);

            //fputs($file,$empleadoId);

            fputs($file,"\n");


           $negocio -> actualizarEstatusImss($datosImss);


            }



            


        } //termina for

        //$lineas = count(file($nombre_archivo));

        //$lastLine2=str_pad($lineas, 6, '0', STR_PAD_LEFT);

        //fputs($file,str_pad($lastLine1, 56));
        //fputs($file,str_pad($lastLine2, 77));
        //fputs($file,str_pad($lastLine3, 34));
        //fputs($file,$idFormato);


        

        
        //echo "El archivo $archivo contiene $linas lineas";


        

        fclose($file);

        header ("Content-Disposition: attachment; filename=".$nombre_archivo."");
        header ("Content-Type: application/force-download");
        header ("Content-Length: ".filesize($nombre_archivo));
        readfile($nombre_archivo);




 
        //fclose($archivo);
    }







?>