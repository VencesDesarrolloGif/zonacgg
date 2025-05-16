<?php
    require_once ("../libs/logger/KLogger.php");
	$db_host="localhost";
	$db_name="zonagif";
	$db_user="root";
	$db_pass="";

    $response = array ();
    $response ["status"] = "correcto";

    include '../simple/simplexlsx.class.php';

    //$tipo=$_POST["tipo"];

    $xlsx = new SimpleXLSX( "historico2.xlsx" );
    $log = new KLogger ( "CARGA MASIVA EXCEL.log" , KLogger::DEBUG );
    //$log->LogInfo("Valor de la variable tipo: " . var_export ($tipo, true));
    try {
       $conn = new PDO( "mysql:host=$db_host;dbname=$db_name", "$db_user", "$db_pass");
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {

        $response["status"] = "error";
        $response["mensaje"]= $e->getMessage();
    }

        $stmt = $conn->prepare( "INSERT INTO historicomovimientosimss (empEntidadMovimiento, EmpConsecutivoMovimiento, empCategoriaMovimiento, tipoMovimiento, fechaMovimiento, sdiMovimiento, FIntegracionMovimiento, SBCMovimiento, fechaAlta, fechaBaja, registroMovimiento, usuarioEdicion, estatusmov, loteImss) VALUES (?, ?, ?,?, ?, ?,?, ?, ?,?, ?, ?,?, ?)");
  
    $stmt->bindParam( 1, $entidad);
   
    $stmt->bindParam( 2, $consecuvito);
    $stmt->bindParam( 3, $categoria);  
     $stmt->bindParam( 4, $claveE2);
     $stmt->bindParam( 5, $claveE3);
     $stmt->bindParam( 6, $claveE4);
     $stmt->bindParam( 7, $claveE5);
     $stmt->bindParam( 8, $claveE6);
     $stmt->bindParam( 9, $claveE7);
     $stmt->bindParam( 10, $claveE8);
     $stmt->bindParam( 11, $claveE9);
     $stmt->bindParam( 12, $claveE10);
     $stmt->bindParam( 13, $claveE11);
     $stmt->bindParam( 14, $claveE12);
   

      

    $val=$xlsx->rows();

    

        foreach ($xlsx->rows() as $fields)
        {
            $log->LogInfo("Valor de la variable FILAS: " . var_export ($fields, true));             
            if($fields[0]!=''){
                $claveE1 = $fields[0];

    $entidad=substr($claveE1,0,2);
    $consecuvito=substr($claveE1,3,4);
    $categoria=substr($claveE1,8,2); 
                $claveE2 = $fields[1];
                $claveE3 = $fields[2];
                $claveE4 = $fields[3];
                $claveE5 = $fields[4];
                $claveE6 = $fields[5];
                $claveE7 = $fields[6];
                $claveE8 = $fields[7];
                $claveE9 = $fields[8];
                $claveE10 = $fields[9];
                $claveE11 = $fields[10];
                $claveE12 = $fields[11];
               
                      // $log->LogInfo("Valor de la variable " . var_export ($consecuvito, true));                       
                $stmt->execute();
             
            }
            
        }         
        $response["mensaje"]="Datos insertados correctamente";
    

echo json_encode ($response);
