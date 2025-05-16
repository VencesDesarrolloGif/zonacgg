<?php
	$db_host="localhost";
	$db_name="prueba";
	$db_user="root";
	$db_pass="";
    include 'simplexlsx.class.php';
    $xlsx = new SimpleXLSX( 'dicumento.xlsx' );
    try {
       $conn = new PDO( "mysql:host=$db_host;dbname=$db_name", "$db_user", "$db_pass");
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $stmt = $conn->prepare( "INSERT INTO pruebaxlsx(nombre,edad,puesto) VALUES (?, ?, ?)");
    $stmt->bindParam( 1, $rank);
    $stmt->bindParam( 2, $country);
    $stmt->bindParam( 3, $population);
    foreach ($xlsx->rows() as $fields)
    {
        $rank = $fields[0];
        $country = $fields[1];
        $population = $fields[2];        
        $stmt->execute();
    }
