<?php
// Iniciamos la sesión. session_start(); debe realizarse en cada archivo.
// Y debe ser la primer linea en el archivo.
session_start();
require "../conexion/conexion.php";
require_once "../../libs/logger/KLogger.php";
$response = array();
//$response["status"] = "error";
$datos = array();
$inp   = $_POST["inprfc"];
//$raxon = $_POST["inprfcc"];

echo json_encode($inp);
//se reciben de una por una
