<?php
    session_start();
    require "../conexion.php";
    $response = array();
    $datos    = array();

    $qry = mysqli_query($conexion, "SELECT idPuntoServicio,puntoServicio,if(esatusPunto ='1','ACTIVO','INACTIVO') as Estatus,fechaInicioServicio,fechaTerminoServicio,usuarioCapturaPunto,latitudPunto,longitudPunto from catalogopuntosservicios");

    while (($regg = mysqli_fetch_array($qry, MYSQLI_ASSOC))) {
        $datos[] = $regg;
    }

    $response["datos"] = $datos;
    echo json_encode($response);
