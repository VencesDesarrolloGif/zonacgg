<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start ();
require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
require_once("../libs/logger/KLogger.php");
$negocio = new Negocio (); 
$response = array ();
$response ["status"] = "error";
$usuario = $_SESSION ["userLog"];
verificarInicioSesion ($negocio);
//$log = new KLogger ( "ajaxNewTipoUniforme.log" , KLogger::DEBUG );
if (!empty ($_POST)){    
    $listaTipos= array();
    $usuarioCaptura=$_SESSION ["userLog"]["usuario"];
    			
    $entidadFederativa=getValueFromPost("entidadFederativa");
    $lineaNegocio=getValueFromPost("lineaNegocio");
    $tipoMercancia=getValueFromPost("tipoMerca");
    $descripcionUniforme=getValueFromPost("descripcionUniforme");
    $codigoUniforme=getValueFromPost("codigoUniforme");
    $talla1=getValueFromPost("talla1");    
    $talla2=getValueFromPost("talla2");
    $tallaMedia=getValueFromPost("tallaMedia");   
    $intervalo= getValueFromPost("intervalo");
    // $sucursal=$_POST['sucursalNM'];
    $LavanderiaR1=$_POST['LavanderiaR1'];
    $LavanderiaR2=$_POST['LavanderiaR2'];
    $LavanderiaR3=$_POST['LavanderiaR3'];
    $LavanderiaR4=$_POST['LavanderiaR4'];
    $LavanderiaR5=$_POST['LavanderiaR5'];
    $LavanderiaR6=$_POST['LavanderiaR6'];
    $DestruccionR1=$_POST['DestruccionR1'];
    $DestruccionR2=$_POST['DestruccionR2'];
    $DestruccionR3=$_POST['DestruccionR3'];
    $DestruccionR4=$_POST['DestruccionR4'];
    $DestruccionR5=$_POST['DestruccionR5'];
    $DestruccionR6=$_POST['DestruccionR6'];
    $CobroR1=$_POST['CobroR1'];
    $CobroR2=$_POST['CobroR2'];
    $CobroR3=$_POST['CobroR3'];
    $CobroR4=$_POST['CobroR4'];
    $CobroR5=$_POST['CobroR5'];
    $CobroR6=$_POST['CobroR6'];
    
    try{        
        $ban=0;
        $listaTiposUni = $negocio -> getTipoUniformes();
        for($j=0;$j<count($listaTiposUni);$j++){
            $tipoUni=$listaTiposUni[$j]["codigoUniforme"];
            $tipoUniSinTalla=substr($tipoUni, 0, strlen($codigoUniforme));
            if(strnatcasecmp($tipoUniSinTalla, $codigoUniforme) == 0){
                $ban=1;
                break;
            }
        }
        if($ban==0){
            if($entidadFederativa != 0){
                if($entidadFederativa<10){
                    $entidadFederativa="0".$entidadFederativa;
                }
                $codigoUniforme=$codigoUniforme.$entidadFederativa;
            }
            if($talla1!=0 && $talla2!=0 && $tallaMedia == 1){
                $talla=$talla1;
                for($i=0; $talla <= $talla2; $i++){
                    $listaTipos[$i]=$codigoUniforme."-".$talla;
                    $talla+=0.5; 
                }
            }else if($talla1!=0 && $talla2!=0 && $tallaMedia == 2){
                $talla=$talla1;
                for($i=0; $talla <= $talla2; $i++){
                    $listaTipos[$i]=$codigoUniforme."-".$talla;
                    $talla+=$intervalo;
                }
            }else if($tallaMedia==0){
                $listaTipos[0]=$codigoUniforme;
            }
            //$log->LogInfo("Valor de la variable listaTipos: " . var_export ($listaTipos, true));
            $negocio -> agregarNuevoUniforme($lineaNegocio,$tipoMercancia,$listaTipos, $descripcionUniforme,$LavanderiaR1,$LavanderiaR2,$LavanderiaR3,$LavanderiaR4,$LavanderiaR5,$LavanderiaR6,$DestruccionR1,$DestruccionR2,$DestruccionR3,$DestruccionR4,$DestruccionR5,$DestruccionR6,$CobroR1,$CobroR2,$CobroR3,$CobroR4,$CobroR5,$CobroR6);
            $response ["status"] = "success";
            $response ["message"] = "La mercancia fue agregada con éxito ";
            //$log->LogInfo("Valor de la variable \$datos: " . var_export ($datos, true));
        }else{
            $response ["status"] = "error";
            $response ["message"] = "El codigo ya existe ";
        }         
    }catch (Exception $e){
        $response ["status"] = "error";
        $response ["message"] =  $e -> getMessage ();
    }
}
echo json_encode ($response);
?> 