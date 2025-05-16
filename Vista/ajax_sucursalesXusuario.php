<?php
session_start();
require "conexion.php";
require_once("../libs/logger/KLogger.php");
$response = array("status" => "success");
$sucursales = array ();
$entidades = array ();
$sucursalesActuales = array();
$entidadesActuales = array();
$sucursalesDisponibles = array();
$response["sucursalesDisponibles"]= 0;

		$log = new KLogger ( "ajax_sucursalesXusuario.log" , KLogger::DEBUG );
		// $log->LogInfo("Valor de variable de empleadoId que viene de post" . var_export ($_POST, true));

	$usuario=$_POST['usuario'];	
	try{

		$sql1 = "SELECT idEntidadEnt,nombreEntidadFederativa ,idEntidadFederativa
				 FROM entidadesusuario eu
				 LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=eu.idEntidadEnt
				 WHERE idUsuarioEnt='$usuario'";

		$res1 = mysqli_query($conexion, $sql1);
   		while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
   		       $entidades[] = $reg1;
   		}

		if(count($entidades) != 0) {

			foreach ($entidades as $entidad) {
			    $entidadesActuales[] = $entidad['idEntidadFederativa'];  // Guardamos solo los idSucursalUsr
			}

			$entidadesArreglo = implode(',', $entidadesActuales);

			$sql = "SELECT idSucursalUsr,nombreSucursal,nombreEntidadFederativa
				FROM sucursalesusuario su
				LEFT JOIN sucursalesinternas si on si.idSucursalI=su.idSucursalUsr
				LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=si.idEntidadPerteneciente
				WHERE idUsuarioSuc='$usuario'";

   			$res = mysqli_query($conexion, $sql);
   			while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
   			       $sucursales[] = $reg;
   			    }
			$response["sucursales"]= $sucursales;

			foreach ($sucursales as $sucursal) {
		    	$sucursalesActuales[] = $sucursal['idSucursalUsr'];  // Guardamos solo los idSucursalUsr
			}

			if(count($sucursales)!=0) {
				foreach ($sucursales as $sucursal) {
				    $sucursalesActuales[] = $sucursal['idSucursalUsr'];  // Guardamos solo los idSucursalUsr
				}
				$sucursalesArreglo = implode(',', $sucursalesActuales);

				$sql2 = "SELECT idSucursalI,nombreSucursal, nombreEntidadFederativa
							 FROM sucursalesinternas si
							 LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=si.idEntidadPerteneciente
							 where idEntidadPerteneciente IN($entidadesArreglo)
							 and idSucursalI NOT IN ($sucursalesArreglo)";

				$res2 = mysqli_query($conexion, $sql2);
	   			while(($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
	   			       $sucursalesDisponibles[] = $reg2;
	   			    }
			}else{
				$sql2 = "SELECT idSucursalI,nombreSucursal, nombreEntidadFederativa
						 FROM sucursalesinternas si
						 LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=si.idEntidadPerteneciente
						 where idEntidadPerteneciente IN($entidadesArreglo)";

				$res2 = mysqli_query($conexion, $sql2);
		   		while(($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
		   		       $sucursalesDisponibles[] = $reg2;
		   		    }
			}
		}
		/*else{


		}*/


		

		/*asi funciona
		//SUCURSALES POR USUARIO
		$sql = "SELECT idSucursalUsr,nombreSucursal,nombreEntidadFederativa
				FROM sucursalesusuario su
				LEFT JOIN sucursalesinternas si on si.idSucursalI=su.idSucursalUsr
				LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=si.idEntidadPerteneciente
				WHERE idUsuarioSuc='$usuario'";

   		$res = mysqli_query($conexion, $sql);
   		while(($reg = mysqli_fetch_array($res, MYSQLI_ASSOC))){
   		       $sucursales[] = $reg;
   		    }
		$response["sucursales"]= $sucursales;

		foreach ($sucursales as $sucursal) {
		    $sucursalesActuales[] = $sucursal['idSucursalUsr'];  // Guardamos solo los idSucursalUsr
		}
		$sucursalesArreglo = implode(',', $sucursalesActuales);

		if (count($sucursales) != 0) {//si tiene sucursales

			$sql1 = "SELECT distinct ef.idEntidadFederativa
					 FROM sucursalesusuario su
					 LEFT JOIN sucursalesinternas si on si.idSucursalI=su.idSucursalUsr
					 LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=si.idEntidadPerteneciente
					 WHERE idUsuarioSuc='$usuario'";

			$res1 = mysqli_query($conexion, $sql1);
   			while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
   			       $entidades[] = $reg1;
   			    }

	   		foreach ($entidades as $entidad) {
			    $entidadesActuales[] = $entidad['idEntidadFederativa'];  // Guardamos solo los idSucursalUsr
			}
			$entidadesArreglo = implode(',', $entidadesActuales);

			if (count($entidades) != 0) {

				$sql2 = "SELECT idSucursalI,nombreSucursal, nombreEntidadFederativa
						 FROM sucursalesinternas si
						 LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=si.idEntidadPerteneciente
						 where idEntidadPerteneciente IN($entidadesArreglo)
						 and idSucursalI NOT IN ($sucursalesArreglo)";

				$res2 = mysqli_query($conexion, $sql2);
	   			while(($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
	   			       $sucursalesDisponibles[] = $reg2;
	   			    }
	   		}
   		}else{// no trae sucursales
   			$sql1 = "SELECT idEntidadFederativa 
					 FROM entidadesusuario eu
					 LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=eu.idEntidadEnt
					 WHERE idUsuarioEnt='$usuario'";

			$res1 = mysqli_query($conexion, $sql1);
   			while(($reg1 = mysqli_fetch_array($res1, MYSQLI_ASSOC))){
   			       $entidades[] = $reg1;
   			}

   			foreach ($entidades as $entidad) {
			    $entidadesActuales[] = $entidad['idEntidadFederativa'];  // Guardamos solo los idSucursalUsr
			}
			$entidadesArreglo = implode(',', $entidadesActuales);

			if (count($entidades) != 0) {

				$sql2 = "SELECT idSucursalI,nombreSucursal, nombreEntidadFederativa
						 FROM sucursalesinternas si
						 LEFT JOIN entidadesfederativas ef on ef.idEntidadFederativa=si.idEntidadPerteneciente
						 where idEntidadPerteneciente IN($entidadesArreglo)";

				$res2 = mysqli_query($conexion, $sql2);
	   			while(($reg2 = mysqli_fetch_array($res2, MYSQLI_ASSOC))){
	   			       $sucursalesDisponibles[] = $reg2;
	   			    }
	   		}
   		}*/



		// for($i=0; $i < count($entidades); $i++){ 

			// }
		$response["sucursalesDisponibles"]= $sucursalesDisponibles;

		$log->LogInfo("Valor de variable de empleadoId que viene de response" . var_export ($response, true));
		// $log->LogInfo("Valor de variable de empleadoId que viene de entidades" . var_export ($entidades, true));
		// $log->LogInfo("Valor de variable de empleadoId que viene de sql2" . var_export ($sql2, true));
		// $log->LogInfo("Valor de variable de empleadoId que viene de sucursalesDisponibles" . var_export ($sucursalesDisponibles, true));
	}catch( Exception $e ){$response["status"]="error";$response["error"]="No se puedo obtener Empleado";}
echo json_encode($response);
?>