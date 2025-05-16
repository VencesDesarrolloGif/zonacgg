
<?php

require_once("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio();

$registroPatronal="A8367674109";

	try{

		//Creamos el archivo datos.txt
//ponemos tipo 'a' para añadir lineas sin borrar
$file=fopen("archivo.txt","w") or die("Problemas");
  //vamos añadiendo el contenido

  
		

		$listaEmpleados= $negocio -> obtenerListaEmpleadosSinImssPorRegistroPatronal($registroPatronal);
        $unidad=1;
        $aguinaldo=15/365;
   
        for ($i = 0; $i < count($listaEmpleados); $i++)
        {   
            $empleadoId = $listaEmpleados[$i] ["numeroEmpleado"];
            $registroPatronal=$listaEmpleados[$i]["registroPatronal"];
            $empleadoNumeroSeguroSocial=$listaEmpleados[$i]["empleadoNumeroSeguroSocial"];
            $apellidoPaterno=$listaEmpleados[$i]["apellidoPaterno"];
            $apellidoMaterno=$listaEmpleados[$i]["apellidoMaterno"];
            $nombreEmpleado=$listaEmpleados[$i]["nombreEmpleado"];
            $salarioDiario=$listaEmpleados[$i]["salarioDiario"];
            $diasTranscurridos=$listaEmpleados[$i]["diasTranscurridos"];
            $tipoTrabajador=$listaEmpleados[$i]["tipoTrabajador"];
            $fechaImss=$listaEmpleados[$i]["fechaImss"];
            $curpEmpleado=$listaEmpleados[$i]["curpEmpleado"];
            $tipoSal=0;
            $jornada=0;
            $umf="000";
            $tipoMov="08";
            $numguia="00000";
            $idFormato=1;



            if ($diasTranscurridos<=365){
                $primaVacacional=1.5;

             }elseif ($diasTranscurridos>=366 and $diasTranscurridos<=730) {

            $primaVacacional=2;
            
            }elseif ($diasTranscurridos>=731 and $diasTranscurridos<=1095) {

                $primaVacacional=2.5;
            }elseif ($diasTranscurridos>=1096 and $diasTranscurridos<=1460) {

                $primaVacacional=3;
            
            }elseif ($diasTranscurridos>=1461 and $diasTranscurridos<=1825) {

                $primaVacacional=3.5;
            
            }elseif ($diasTranscurridos>=1826 and $diasTranscurridos<=3650) {

                $primaVacacional=3.5;
            
            }elseif ($diasTranscurridos>=1827 and $diasTranscurridos<=5475) {

                $primaVacacional=4;
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
            fputs($file,$tipoTrabajador);
            fputs($file,$tipoSal);
            fputs($file,$jornada);
            fputs($file,$fechaImss2);
            fputs($file,str_pad($umf, 5));
            fputs($file,$tipoMov);
            fputs($file,$numguia);
            fputs($file,str_pad($codEmpleado,11));
            fputs($file,str_pad($curpEmpleado,19));
            fputs($file,$idFormato);

            //fputs($file,$empleadoId);

            fputs($file,"\n");
        }

        

        fclose($file);
        
		

	} 
	catch( Exception $e )
	{
	echo "error";
	}










?>