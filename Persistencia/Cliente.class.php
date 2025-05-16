<?php
require_once("Class.php");

class Cliente{

	private $visitas;

	public function __construct(){
		$this->visitas=array();
	}

	public function getClientes(){

		try{
			$sql="SELECT * FROM Clientes";
			$res=mysql_query($sql, Conexion::conectar());

			while($reg=mysql_fetch_assoc($res)){
				$this->visitas[]=$reg;
			}

			return $this->visitas;
		} catch (Exception $e){
		echo "ERROR:" . $e->getMessage() ;

		}
	}

	public function addCliente($claveCliente, $nombre, $nombreComercial){
	

			$sql="INSERT INTO Clientes (Id_Cliente, Razon_Social, Nombre_Comercial) VALUES ('$claveCliente', '$nombre','$nombreComercial')" ;

			$res=mysql_query($sql,Conexion::conectar());
			

		
	}
}
?>