<?php
session_start();
require "../conexion.php";
require_once("../../libs/logger/KLogger.php");
$clientesAsignados = array();
$datos = array();
$datos1 = array();
$response = array("status" => "success");
$log = new KLogger ( "ajax_AsignarClienteaUsuario.log" , KLogger::DEBUG );

try {
    // $log->LogInfo("Valor de la variable _SESSION " . var_export ($_SESSION, true));
    $usuarioC= $_POST['usuarioC'];
    $cliente = $_POST['cliente'];
    $lineaNegocio = $_POST['lineaNegocio'];
    $usuarioLog=$_SESSION['userLog']['usuario'];

    if($cliente=="TODOS"){
        //hacer consulta de todos los clientes
        $sql0 = "SELECT idClienteRUC
                 FROM relacionUsuarios_clientes ruc
                 LEFT JOIN catalogoclientes cc on cc.idCliente=ruc.idClienteRUC
                 WHERE ruc.idUsuarioRUC='$usuarioC'
                 AND idLineaNegocioRUC='$lineaNegocio'
                 ORDER BY cc.razonSocial";    

        $res0 = mysqli_query($conexion, $sql0);
        while (($reg0 = mysqli_fetch_array($res0, MYSQLI_ASSOC))){
            $clientesAsignados[] = $reg0;
        }
    $log->LogInfo("Valor de la variable sql0 " . var_export ($sql0, true));
    $log->LogInfo("Valor de la variable clientesAsignados " . var_export ($clientesAsignados, true));

        if ($clientesAsignados!=NULL && $clientesAsignados!="NULL"){

            $sql1 = "SELECT idCliente,razonSocial
                     FROM catalogoclientes";

            $clientesTotalesAsignados=count($clientesAsignados);
            for($i=0; $i < $clientesTotalesAsignados; $i++){ 
            
                $clienteI= $clientesAsignados[$i]["idClienteRUC"];
                $suma= $i+1;

                if($i==0){
                   $sql1.=" WHERE (";
                }

                $sql1.="idCliente!=$clienteI";

                if($suma==$clientesTotalesAsignados) {
                   $sql1.=")";
                }else{
                   $sql1.=" AND ";
                }
            }//for i

            $res1 = mysqli_query($conexion, $sql1);
            while (($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
                $datos[] = $reg1;
            }

            if($datos!=NULL && $datos!="NULL") {
                
                $listaClientesParaAsignar=count($datos);

                for($j=0; $j < $listaClientesParaAsignar; $j++){

                    $cliente= $datos[$j]["idCliente"];

                    $sql = "INSERT INTO relacionUsuarios_clientes(idUsuarioRUC, idClienteRUC, usrLogRUC, fechaCreacionRUC, idLineaNegocioRUC) VALUES($usuarioC,$cliente,'$usuarioLog',now(),$lineaNegocio)";    

                    $res = mysqli_query($conexion, $sql);
                }
            }//if null datos
        }//if null clientes ya asignados
        else{//else null
            $sql11 = "SELECT idCliente
                      FROM catalogoclientes";
    $log->LogInfo("Valor de la variable sql11 " . var_export ($sql11, true));

            $res11 = mysqli_query($conexion, $sql11);
            while (($reg11 = mysqli_fetch_array($res11, MYSQLI_ASSOC))){
                $datos1[] = $reg11;
            }

            for($z=0; $z < count($datos1); $z++){ 
            
                $cliente= $datos1[$z]["idCliente"];

                $sql = "INSERT INTO relacionUsuarios_clientes(idUsuarioRUC, idClienteRUC, usrLogRUC, fechaCreacionRUC, idLineaNegocioRUC) VALUES($usuarioC,$cliente,'$usuarioLog',now(),$lineaNegocio)";   

                    $res = mysqli_query($conexion, $sql);
                $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));

            }//for i
        }//else null
    }else{
          $sql = "INSERT INTO relacionUsuarios_clientes(idUsuarioRUC, idClienteRUC, usrLogRUC, fechaCreacionRUC, idLineaNegocioRUC) VALUES($usuarioC,$cliente,'$usuarioLog',now(),$lineaNegocio)";     
          $res = mysqli_query($conexion, $sql);
    }
        // $log->LogInfo("Valor de la variable sql " . var_export ($sql, true));
} catch (Exception $e) {
    $response["status"] = "error";
    $response["error"]  = "No se puedo obtener lista de datos";
}
echo json_encode($response);
