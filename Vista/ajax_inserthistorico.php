<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");
$negocio = new Negocio ();
$response = array ();
$datos=array();
$tipobanco=array();
// $log = new KLogger ( "ajaxinsertarhistorico.log" , KLogger::DEBUG );

$usuario = $_SESSION ["userLog"]["rol"];
verificarInicioSesion ($negocio);
// $log->LogInfo("Valor de la variable usuario: " . var_export ($usuario, true));

if (empty ($_POST))
{
    try 
    {
        $datos1 = $negocio->negocio_obtenerhistoricoedicion($usuario);
            for($i=0;$i<(count($datos1));$i++){    
               $cuentaclabestr= $datos1[$i]["empleadoNumeroCtaClabeE"];
               $cuentaclabe=substr($cuentaclabestr,0,3);
                $tipobanco = $negocio->negocio_obtenercuentaclabeybanco($cuentaclabe,1);// se le manda 1 ya que solo utilizaremos el banco
                $datos[$i]["numempleado"]   =$datos1[$i]["numeroempleado"];  
                $datos[$i]["fecha"]         =$datos1[$i]["empleadoFechaCapturaE"];
                if(count($tipobanco)!=1){
                    $datos[$i]["banco"]         =$tipobanco["bancos"]["nombreBanco"];
                }else{
                     $datos[$i]["banco"]         ="No existe Banco";}
                $datos[$i]["numcuenta"]     =$datos1[$i]["empleadoNumeroCtaE"]; 
                $datos[$i]["numcuentaActual"]  =$datos1[$i]["empleadoNumeroCtaEActual"]; 
                $datos[$i]["numcuentaclabe"]=$datos1[$i]["empleadoNumeroCtaClabeE"]; 
                $datos[$i]["numcuentaclabeActual"]=$datos1[$i]["empleadoNumeroCtaClabeEActual"]; 
                // $datos[$i]["fechaInsertEdicion"]=$datos1[$i]["fechaInsertEdicion"]; ya nadamas para insertar

                $datos[$i]["correo"]        =$datos1[$i]["correoEmpleadoEdited"]; 
                $datos[$i]["periodo"]       =$datos1[$i]["descripcionTipoPeriodo"];
            if ($datos1[$i]["empleadoEstatusIdE"]==0){
                $datos[$i]["fechabaja"]=$datos1[$i]["empleadoFechaBajaE"];
            }else if ($datos1[$i]["empleadoEstatusIdE"]==2){
                $datos[$i]["fechabaja"]     = "Reingreso";
            }else if ($datos1[$i]["empleadoEstatusIdE"]==1){
                $datos[$i]["fechabaja"]     = "activo";
            }
            if ($datos1[$i]["empleadoEstatusIdE"]==0){
                $datos[$i]["fechareingreso"]=" Baja";
            }else if ($datos1[$i]["empleadoEstatusIdE"]==2){
                $datos[$i]["fechareingreso"]=$datos1[$i]["empleadoFechaIngresoE"];
            }else if ($datos1[$i]["empleadoEstatusIdE"]==1){
                $datos[$i]["fechareingreso"]     = "activo";
            }
            if($_SESSION ["userLog"]["usuario"]==="trejou" || $_SESSION ["userLog"]["rol"]==="Analista Asistencia")
            {
                $datos[$i]["check"]         ="<img src='img/ok.png' id='imgcheck' name='imgcheck' value='0' style='cursor:pointer'
                                             onclick='datochecado(\"" . $datos1[$i]['idEdicion'] . "\");'></img>";
            }else{$datos[$i]["check"]="";}
            if($_SESSION ["userLog"]["rol"]==="Analista Asistencia"){
                    $datos[$i]["fechaconfirmacion"]=$datos1[$i]['fechaConfirmacion'];
            }else{$datos[$i]["fechaconfirmacion"]="";}
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