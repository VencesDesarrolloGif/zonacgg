<?php
session_start();
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
$negocio  = new Negocio();
$response = array();
verificarInicioSesion($negocio);
$usuario = $_SESSION["userLog"];
echo json_encode($usuario);
