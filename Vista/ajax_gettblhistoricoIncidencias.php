<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();
verificarInicioSesion($negocio);
$response = array("status" => "success");
//$log = new KLogger ( "ajax_gethistoricoincidenciaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.log" , KLogger::DEBUG );
$fechainicio=$_POST["fechainicio"]; 
$fechafin=$_POST["fechafin"];
$accion=$_POST["accion"];

try {
   
$lista = $negocio->gettblhistoricoIncidencias($fechainicio,$fechafin,$accion);


 //   $log->LogInfo("Valor de variable de lista:" . var_export ($lista, true));
    for ($i = 0; $i < count($lista); $i++) {
        
        $FechaEdicionIncidencia = $lista[$i]["FechaEdicionIncidencia"];
        $UsuarioEdicionIncidencia       = $lista[$i]["UsuarioEdicionIncidencia"];        
        $AccionPeticionDG     = $lista[$i]["AccionPeticionDG"];
        $FechaAccionDG     = $lista[$i]["FechaAccionDG"];        
        $AccionUsuario         = $lista[$i]["AccionUsuario"];        
        $FechaAccionUsuario        = $lista[$i]["FechaAccionUsuario"];        
        $UsuarioAccion         = $lista[$i]["UsuarioAccion"];

        if($FechaEdicionIncidencia== null || $FechaEdicionIncidencia== NULL || $FechaEdicionIncidencia== "null" || $FechaEdicionIncidencia== "NULL" || $FechaEdicionIncidencia== ""){
            $lista[$i]["FechaEdicionIncidencia"] = "Sin Fecha De Edición";
        }
       
        if($UsuarioEdicionIncidencia== null || $UsuarioEdicionIncidencia== NULL || $UsuarioEdicionIncidencia== "null" || $UsuarioEdicionIncidencia== "NULL" || $UsuarioEdicionIncidencia== ""){
            $lista[$i]["UsuarioEdicionIncidencia"] = "Sin Edición";
}
           if($AccionPeticionDG==0 || $AccionPeticionDG== null || $AccionPeticionDG== NULL || $AccionPeticionDG== "null" || $AccionPeticionDG== "NULL" || $AccionPeticionDG== ""){
             $lista[$i]["AccionPeticionDG"] = "En proceso";
            }

             elseif ($AccionPeticionDG==1 ) {
                $lista[$i]["AccionPeticionDG"] = "Aceptada";
                }

                elseif ($AccionPeticionDG==2 ) {
                     $lista[$i]["AccionPeticionDG"] = "Rechazada";
                }
                        
            if( $FechaAccionDG== null || $FechaAccionDG== NULL || $FechaAccionDG== "null" || $FechaAccionDG== "NULL" || $FechaAccionDG== ""){
            $lista[$i]["FechaAccionDG"] = "En proceso";
        }


            if ($AccionUsuario== 0 || $AccionUsuario== null || $AccionUsuario== NULL || $AccionUsuario== "null" || $AccionUsuario== "NULL" || $AccionUsuario== "") {
                $lista[$i]["AccionUsuario"] = "Sin Acción";
                # code...
            }
            elseif ($AccionUsuario== 1) {
                $lista[$i]["AccionUsuario"] = "Petición eliminada";
                # code...
            }

            if ($FechaAccionUsuario==0 ) {
                $lista[$i]["FechaAccionUsuario"] = "Sin Acción";

                # code...
            }
            
            if ($UsuarioAccion== null || $UsuarioAccion== NULL || $UsuarioAccion== "null" || $UsuarioAccion== "NULL" || $UsuarioAccion== "") {
                $lista[$i]["UsuarioAccion"] = "Sin Acción";

                # code...
            }
       }//este for
    $response["data"] = $lista;
 
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = $e->getMessage();
}
  // $log->LogInfo("Valor de variable response:" . var_export ($response, true));

echo json_encode($response);