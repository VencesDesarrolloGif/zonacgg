<?php

class Conexion{

	public static function conectar(){
		
			$conn=mysql_connect("localhost","dbo", "dbo");
			mysql_select_db("dbo");
			//mysql_query("SET NAMES 'UTF8'");

		return $conn;
		

	}
}


?>
