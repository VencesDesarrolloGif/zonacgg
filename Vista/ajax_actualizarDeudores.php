<?php
session_start ();

require_once ("../Negocio/Negocio.class.php");
require_once ("Helpers.php");


    require_once ("../libs/logger/KLogger.php");
    $negocio = new Negocio ();



verificarInicioSesion ($negocio);
	$db_host="localhost";
	$db_name="zonacgg";
	$db_user="root";
	$db_pass="Admin*gif";
    // $log = new KLogger ( "ajaxDeudoresxlsx.log" , KLogger::DEBUG );
    // $log->LogInfo("Valor de la variable _POST: " . var_export ($_POST, true));
    $response = array ();
    $response ["status"] = "correcto";

    include '../simple/simplexlsx.class.php';

    $tipo=$_POST["tipo"];
    if($tipo=="fonacotFQUINCENAL PERIODO"){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Fonacot/".$tipo.$IdArchivo.".xlsx" ); 
    }else if($tipo=="infonavitFQUINCENAL "){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Amortizacion/".$tipo.$IdArchivo.".xlsx" ); 
    }else if($tipo=="pensionFQUINCENAL "){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Pension/".$tipo.$IdArchivo.".xlsx" ); 
    }else if($tipo=="prestamosFQUINCENAL "){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Prestamo/".$tipo.$IdArchivo.".xlsx" ); 
    }else if($tipo=="fonacotFSEMANAL PERIODO"){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Fonacot/".$tipo.$IdArchivo.".xlsx" ); 
    }else if($tipo=="infonavitFSEMANAL "){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Amortizacion/".$tipo.$IdArchivo.".xlsx" ); 
    }else if($tipo=="pensionFSEMANAL "){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Pension/".$tipo.$IdArchivo.".xlsx" ); 
    }else if($tipo=="prestamosFSEMANAL "){
        $idUltimoArchivo = $negocio -> obtenerIdUltimoArchivoDeudoresFini($tipo);
        $IdArchivo = $idUltimoArchivo[0]['contador'];
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/Prestamo/".$tipo.$IdArchivo.".xlsx" ); 
    }else{
        $xlsx = new SimpleXLSX( dirname (__FILE__) ."/uploads/documentosContabilidad/".$tipo.".xlsx" );
    } 
    
    try {
       $conn = new PDO( "mysql:host=$db_host;dbname=$db_name", "$db_user", "$db_pass");
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {

        $response["status"] = "error";
        $response["mensaje"]= $e->getMessage();
    }
    if(strpos($tipo,"prestamosF")!== false)
        $stmt = $conn->prepare( "INSERT INTO prestamo_finiquito (entidadEmpPF, consecutivoEmpPF, categoriaEmpPF, montoPF, FechaCarga, FechaHoraCarga) VALUES (?, ?, ?, ?, now(), now())");
    else if(strpos($tipo,"prestamosN")!== false)
        $stmt = $conn->prepare( "INSERT INTO prestamo_nomina (entidadEmpPN, consecutivoEmpPN, categoriaEmpPN, montoPN) VALUES (?, ?, ?,?)");
    else if(strpos($tipo,"infonavitF")!== false)
        $stmt = $conn->prepare( "INSERT INTO infonavit_finiquito (entidadEmpIF, consecutivoEmpIF, categoriaEmpIF, montoIF, FechaCarga, FechaHoraCarga) VALUES (?, ?, ?, ?, now(), now())");
    else if(strpos($tipo,"fonacotF")!== false)
        $stmt = $conn->prepare( "INSERT INTO fonacot_finiquito (entidadEmpFF, consecutivoEmpFF, categoriaEmpFF, montoFF, FechaCarga, FechaHoraCarga) VALUES (?, ?, ?, ?, now(), now())");
    else if(strpos($tipo,"infonavitN")!== false)
        $stmt = $conn->prepare( "INSERT INTO infonavit_nomina (entidadEmpIN, consecutivoEmpIN, categoriaEmpIN, montoIN, FechaCarga, FechaHoraCarga) VALUES (?, ?, ?, ?, now(), now())");
    else if(strpos($tipo,"fonacotN")!== false)
        $stmt = $conn->prepare( "INSERT INTO fonacot_nomina (entidadEmpFN, consecutivoEmpFN, categoriaEmpFN, montoFN) VALUES (?, ?, ?,?)");
    else if(strpos($tipo,"pensionF")!== false)
        $stmt = $conn->prepare( "INSERT INTO pension_finiquito (entidadEmpPeF, consecutivoEmpPeF, categoriaEmpPeF, montoPeF, FechaCarga, FechaHoraCarga) VALUES (?, ?, ?, ?, now(), now())");
    else if(strpos($tipo, "pensionN")!== false)
        $stmt = $conn->prepare( "INSERT INTO pension_nomina (entidadEmpPeN, consecutivoEmpPeN, categoriaEmpPeN, montoPeN) VALUES (?, ?, ?,?)");    
    else if(strpos($tipo, "AlimentosN")!== false )
        $stmt = $conn->prepare( "INSERT INTO alimentos_nomina (entidadEmpAN, consecutivoEmpAN, categoriaEmpAN, montoAN) VALUES (?, ?, ?,?)");
    else if(strpos($tipo, "pagosN")!== false )
        $stmt = $conn->prepare( "INSERT INTO otrospagos_nomina (entidadEmpOPN, consecutivoEmpOPN, categoriaEmpOPN, montoOPN) VALUES (?, ?, ?,?)");
    $stmt->bindParam( 1, $entidad);
    $stmt->bindParam( 2, $consecuvito);
    $stmt->bindParam( 3, $categoria);  
    $stmt->bindParam( 4, $monto);  

    $val=$xlsx->rows();

    

        foreach ($xlsx->rows() as $fields)
        {
            // $log->LogInfo("Valor de la variable FILAS: " . var_export ($fields, true));             
            if($fields[0]!=''){
                $claveEmpleado = $fields[0];
                 $empleadoidd = explode("-", $claveEmpleado);
/*
           $entidad=substr($claveEmpleado,0,2);
                $consecuvito=substr($claveEmpleado,3,4);
                $categoria=substr($claveEmpleado,8,2); 
*/
        $entidad=$empleadoidd[0];
        $consecuvito=$empleadoidd[1];
        $categoria=$empleadoidd[2];          
                $monto = $fields[2];                             
                $stmt->execute();
                // $log->LogInfo("Valor de la variable FILAS: " . var_export ($stmt, true));
            }
            
        }      
         $stmt2 = $conn->prepare( "INSERT INTO ultimoUpdateDeudores (tipoUpdate, fecha, usuarioCarga) VALUES (?, ?, ?)");
         $fecha= date("Y-m-d");
         $usuario = $_SESSION ["userLog"]["usuario"];
         $tipodeduc= explode(" ", $tipo);
         $tipodeduccion=$tipodeduc[0];
           $stmt2->bindParam( 1, $tipodeduccion);
            $stmt2->bindParam( 2, $fecha);
            $stmt2->bindParam( 3, $usuario);
            $stmt2->execute(); 

            //$log->LogInfo("Valor de la variable FILAS: " . var_export ($stmt, true));


        $response["mensaje"]="Deducción actualizada correctamente";
    

echo json_encode ($response);
