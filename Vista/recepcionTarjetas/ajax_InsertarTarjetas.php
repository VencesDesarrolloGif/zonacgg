<?php
session_start ();
require_once ("../../libs/logger/KLogger.php");
include '../../simple/simplexlsx.class.php';
require "../conexion.php";
// $log = new KLogger ( "ajax_insertarTarjetas.log" , KLogger::DEBUG );
$response = array ();
$datos = array ();
$datos10 = array ();
$response["status"] = "success";
$noPedido=$_POST["noPedido"];
$matriz  =$_POST["matriz"];
$db_host="localhost";
$db_name="zonacgg";
$db_user="root";
$db_pass="Admin*gif";
$xlsx = new SimpleXLSX( "../uploads/ExcelTarjetas/pedido_".$noPedido.".xlsx" );
$estatusTarjetaExcel='1';
$bandera='1';
    
$sql = "SELECT ifnull(count(IdPedidoT),0) as existePedido,IdPedidoT
        FROM pedidotarjetas
        WHERE NumeroPedido=$noPedido";

$res = mysqli_query($conexion, $sql);
        while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
               $datos[] = $reg;
        }  

if($datos[0]["existePedido"] == '' || $datos[0]["existePedido"] == '0'){
   $response["status"] ="error";
   $response["mensaje"]='error al cargarPedido ajax_insertarTarjetas';
 // $log->LogInfo("Valor de la variable responsePEIDOD: " . var_export ($response, true));             

   return;
}else{
    $idpedido=$datos[0]["IdPedidoT"];
   
    try{
        $conn = new PDO( "mysql:host=$db_host;dbname=$db_name", "$db_user", "$db_pass");
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        $response["status"] = "error";
        $response["mensaje"]= "error de conexion a la BD";
    }

    $stmt = $conn->prepare( "INSERT INTO tarjetadespensa(IdPedido, idIutTarjeta, numeroTarjeta, idEstatusTarjeta,idMatrizAsiganda) 
                             VALUES ($idpedido, ?, ?,$estatusTarjetaExcel,$matriz)");
    $stmt->bindParam(1, $iutTarjetaExcel);
    $stmt->bindParam(2, $noTarjetaExcel);  

    $val=$xlsx->rows();

    foreach ($xlsx->rows() as $fields){

      if($bandera=="1"){

        if($fields[0]!=''){

            $iutTarjetaExcel=$fields[0];
            $noTarjetaExcel =$fields[1]; 

            $sql10 = "SELECT ifnull(count(IdTarjetaDespensa),0) as totaliut 
                      FROM tarjetadespensa
                      WHERE idIutTarjeta='$iutTarjetaExcel'";

            $res10 = mysqli_query($conexion, $sql10);
            while(($reg10 = mysqli_fetch_array($res10, MYSQLI_ASSOC))){
                   $datos10[] = $reg10;
            }  

            if($datos10[0]["totaliut"] == '0'){//si no se repite el numero IUT con alguno que no este en la base

                $expresionNoT = '/[0-9]{16}/';
                $expresionIUT = '/[a-zA-Z0-9]{12}/';

                if(preg_match($expresionIUT, $iutTarjetaExcel) == false) {
                    $response["status"] = "error";
                    $response["mensaje"]= "el numero IUT debe contener exactamente 12 caracteres de los cuales deben ser numeros y letras, por favor valide los IUT ingresados en el documento excel";
                    $bandera='0';
                }

                if(preg_match($expresionNoT, $noTarjetaExcel) == false) {
                    $response["status"] = "error";
                    $response["mensaje"]= "el numero de tarjeta debe contener exactamente 16 caracteres de los cuales deben ser solo numeros, por favor valide los numeros de tarjeta ingresados en el documento excel";
                    $bandera='0';
                }
               
            }else{
                $response["status"] = "error";
                $response["mensaje"]= "En el documento excel cargado hay un numero IUT que ya fue cargado abteriormente";
                $bandera='0';
            }  
        }else{
            $response["status"] = "error";
            $response["mensaje"]= "error en el documento excel cargado, las columnas no puede estar vacia";
        }
      }
    }//for each   

    if ($bandera=='1'){
        
            foreach($xlsx->rows() as $fields){

                if($fields[0]!=''){

                    $iutTarjetaExcel=$fields[0];
                    $noTarjetaExcel =$fields[1]; 
                    $stmt->execute();
                    $response["status"] = "success";
                    $response["mensaje"]= "informacion cargada correctamente";
                }   
            }

    }else{
 // $log->LogInfo("Valor de la variable response: " . var_export ($response, true));             
        exit();
    }

 // $log->LogInfo("Valor de la variable responsefin: " . var_export ($response, true));             

} 
echo json_encode ($response);
