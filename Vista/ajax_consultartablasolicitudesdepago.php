<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datossoli=array();
$usuario = $_SESSION ["userLog"]["usuario"];
$usuario1 = $_SESSION ["userLog"]["rol"];
// $log = new KLogger ( "ajaxinsertarhistorico.log" , KLogger::DEBUG );
// $log->LogInfo("Valor de la variable \$datastring: " . var_export ($_SESSION, true));
verificarInicioSesion ($negocio);
if (empty ($_POST)){
    
    try{  
        if($usuario1==="Comprobacion Regional" || $usuario1==="Gerente Regional"){   
            $autorizado1=2;
            $declinado1=3;
            $cancelado1=4;
        }else if($usuario1==="Finanzas"){       
            $autorizado1=0;
            $declinado1=6;
            $cancelado1=7;
        }
        
        $datos1 = $negocio->negocio_obtenerlistasolicitudpago($usuario,$usuario1);
        
        for($i=0;$i<(count($datos1));$i++){    
                $datossoli[$i]["estatusdescripcion"]=$datos1[$i]["estatusdescripcion"];
                $datossoli[$i]["lineanegocio"]      =$datos1[$i]["lineanegocio"];
                $datossoli[$i]["fechasolicitud"]    =$datos1[$i]["fechasolicitud"]; 
                $datossoli[$i]["numeroempleado"]    =$datos1[$i]["numeroempleado"]; 
                $datossoli[$i]["beneficiario"]      =$datos1[$i]["beneficiario"]; 
                $datossoli[$i]["entidad"]           =$datos1[$i]["entidad"]; 
                $datossoli[$i]["concepto"]          =$datos1[$i]["concepto"]; 

                $total1=$datos1[$i]["total"];

                $totalExplod = explode(".", $total1);

                if(count($totalExplod)==1){
                  $total=$total1.".00";

                }else{
                    $total=$total1;

                } 

                $datossoli[$i]["total"]      =$total; 
                $datossoli[$i]["autorizado"] ="<img href='#contenedorFinanzas' data-toggle='tab' style='cursor: pointer' src='img/confirmarImss.png' id='imgautorizado' name='imgautorizado' width='25' value='0'  onclick='datochecadoSolicituddepago(
                                                    \"" . $datos1[$i]['idsolicitudpago'] . "\",\"" . $autorizado1 . "\",
                                                    \"" . $datos1[$i]['beneficiario'] . "\",\"" . $datos1[$i]['concepto'] . "\",
                                                    \"" . $datos1[$i]['idempresa'] . "\",\"" . $datos1[$i]['idtipotransaccion'] . "\",
                                                    \"" . $datos1[$i]['idlineanegocio'] . "\",
                                                    \"" . $datos1[$i]['claveclasificacion'] . "\",
                                                    \"" . $datos1[$i]['identidad'] . "\",
                                                    \"" . $total . "\",
                                                    \"" . $datos1[$i]['descripcionclaveclasi'] . "\",\"" . $datos1[$i]['banco'] . "\",
                                                    \"" . $datos1[$i]['cuenta'] . "\",\"" . $datos1[$i]['cuentaclave'] . "\"); consultarDepartamentos();'></img>";
                
                $datossoli[$i]["declinado"]="<img style='cursor: pointer' src='img/alert.png' id='imgdeclinado' name='imgdeclinado'  width='25' value='0' 
                                                    onclick='datochecadoSolicituddepago(\"" . $datos1[$i]['idsolicitudpago'] . "\",\"" . $declinado1 . "\");'></img>";
                
                $datossoli[$i]["cancelado"]="<img style='cursor: pointer' src='img/rechazarImss.png' id='imgcancelado' name='imgcancelado'  width='25' value='0' 
                                                    onclick='datochecadoSolicituddepago(\"" . $datos1[$i]['idsolicitudpago'] . "\",\"" . $cancelado1 . "\");'></img>";                                    
        }
            $response ["status"] = "success";
            $response ["datos"] = $datossoli; 
    } 
    catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }       
}
else{
    $response ["status"] = "error";
    $response ["message"] = "No se proporcionaron datos";
}
echo json_encode ($response);
?>