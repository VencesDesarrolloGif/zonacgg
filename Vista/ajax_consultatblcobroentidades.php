<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datos=array();
$total=array();
$dato1=array();
// $log = new KLogger ( "ajaxttraetotalesentidades.log" , KLogger::DEBUG );
$ejercicio  = $_POST['ejercicio'];
$lineanegocio  = $_POST['lineanegocio'];
$accion=$_POST['accion'];
//$log->LogInfo("Valor de la variable \$datastring: " . var_export ($datastring1, true));
verificarInicioSesion ($negocio);
$meses=12;//12 son los meses que existen en un año
if (!empty ($_POST))
{
    try
    {
        $Entidades = $negocio->negocio_obtenerListaEntidadesFeferativas();        
            for($i=0;$i<(count($Entidades)-2);$i++){
                $idEntidad=$Entidades[$i]["idEntidadFederativa"];
                $descEntidad= $Entidades[$i]["nombreEntidadFederativa"];  
                for($j=0;$j<$meses;$j++){
                    $mes=($j+1);
                    $total= $negocio->negocio_obtenerTotalEntidadcobro($idEntidad,$ejercicio,$mes,$lineanegocio,$accion);
                    if($total[0]["total"]==null){
                        $dato1[$j]="0";

                    }else{
                        $totalarr=round($total[0]["total"],2);
                        $dato1[$j]=$totalarr;
                    }
                }
                $datos[$i]["enero"]      = $dato1[0];  
                $datos[$i]["febrero"]    = $dato1[1];
                $datos[$i]["marzo"]      = $dato1[2];
                $datos[$i]["abril"]      = $dato1[3];
                $datos[$i]["mayo"]       = $dato1[4];
                $datos[$i]["junio"]      = $dato1[5];
                $datos[$i]["julio"]      = $dato1[6];
                $datos[$i]["agosto"]     = $dato1[7];
                $datos[$i]["septiembre"] = $dato1[8];
                $datos[$i]["octubre"]    = $dato1[9];
                $datos[$i]["noviembre"]  = $dato1[10];
                $datos[$i]["diciembre"]  = $dato1[11];
                $datos[$i]["descEntidad"]= $descEntidad;  
            }
            $response ["status"] = "success";
            $response ["datos"] = $datos; 
    } 
    catch (Exception $e)
    {
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }       
}
else
{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}

echo json_encode ($response);
?>