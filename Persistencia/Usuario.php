<?php
require_once ("../libs/logger/KLogger.php");

require_once("Class.php");

Class Usuario{
	//var $nombreUsuarioLogeado;
	var $password;
	var $user; 
	var $usuarios;

	var $logger;

	public function __construct(){
		$this -> logger = new KLogger ("persistencia.log", KLogger::DEBUG);
		$this->usuarios=array();

	}
	//Funcion que busca por usuario y password para
	public function login($user,$password){ logear
		$this -> logger -> LogInfo ("Ejecutando. login en persistencia");
		try{
			$sql="SELECT u.usuario, emp.apellidoPaterno, emp.apellidoMaterno, emp.nombreEmpleado from usuarios u , empleados emp 
			where u.numeroEmpleado= emp.numeroEmpleado AND Usuario='$user' and Contrasenia='$password'";

			$this -> logger -> LogInfo ("Ejecutando SQL: " . $sql);
			$res=mysql_query($sql, Conexion::conectar());

			$this -> logger -> LogInfo ("RES: " . var_export ($res, true));
				
			while(($reg=mysql_fetch_assoc($res))){
				$this -> logger -> LogInfo (var_export ($reg, true));
				$this->usuarios[]=$reg;
			}

			$this -> logger -> LogInfo (var_export ($this -> usuarios, true));
			return $this->usuarios;
		} catch (Exception $e){
			$this -> logger -> LogInfo ("ERROR:" . $e->getMessage() );

		}
	}
}
?>
