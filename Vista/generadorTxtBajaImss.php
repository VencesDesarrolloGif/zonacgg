<?php
require_once "../Negocio/Negocio.class.php";
require_once "Helpers.php";
require_once "../libs/logger/KLogger.php";
$negocio = new Negocio();

// $log = new KLogger("ajaxGeneradorBaja.log", KLogger::DEBUG);

$registroPatronal = $_GET["registroPatronal"];

$nombre_archivo = "archivosImss/Baja_" . $registroPatronal . "_" . date("Y-m-d_His") . ".txt";

if (file_exists($nombre_archivo)) {
    $mensaje = "El Archivo $nombre_archivo se ha modificado";
} else {
    $mensaje = "El Archivo $nombre_archivo se ha creado";
}

if ($file = fopen($nombre_archivo, "a")) {
    $listaEmpleados = $negocio->obtenerListaEmpleadosSinBajaImssPorRegistroPatronal($registroPatronal);

    $ultimonumeroTxt = $negocio->traerUltimoFolioTxtBaja();

    // $log->LogInfo("Valor de la variable \$ultimonumeroTxt: " . var_export($ultimonumeroTxt, true));
    $idFormato = 9;
    $tipoMov   = "02";
    $numguia   = "00000";
    $filler    = "000000000000000";
    $filler2   = " ";

    for ($i = 0; $i < count($listaEmpleados); $i++) {
        $empleadoId                 = $listaEmpleados[$i]["numeroEmpleado"];
        $registroPatronal           = $listaEmpleados[$i]["registroPatronal"];
        $empleadoNumeroSeguroSocial = $listaEmpleados[$i]["empleadoNumeroSeguroSocial"];
        $apellidoPaterno            = utf8_decode($listaEmpleados[$i]["apellidoPaterno"]);
        $apellidoMaterno            = utf8_decode($listaEmpleados[$i]["apellidoMaterno"]);
        $nombreEmpleado             = utf8_decode($listaEmpleados[$i]["nombreEmpleado"]);
        $fechaBajaImss              = $listaEmpleados[$i]["fechaBajaImss"];

        $motivoBaja = $listaEmpleados[$i]["idMotivoBajaImss"];

        if ($motivoBaja === "B") {
            $motivoBaja = 2;
        } else {
            $motivoBaja = $motivoBaja;
        }
          $empleadoidd = explode("-", $empleadoId);
/*
        $empleadoEntidad           = substr($empleadoId, 0, 2);
        $empleadoConsecutivo       = substr($empleadoId, 3, 4);
        $empleadoCategoria         = substr($empleadoId, 8, 2);
*/
        $empleadoEntidad=$empleadoidd[0];
        $empleadoConsecutivo=$empleadoidd[1];
        $empleadoCategoria=$empleadoidd[2];
        $emisionBajaImssConfirmada = $listaEmpleados[$i]["emisionBajaConfirmada"];
        if ($emisionBajaImssConfirmada == 1) {
            $datosImss = array(
                "empladoEntidadImss"      => $empleadoEntidad,
                "empleadoConsecutivoImss" => $empleadoConsecutivo,
                "empleadoCategoriaImss"   => $empleadoCategoria,
                "empleadoEstatusImss"     => 6,
                "folioTxtBaja"            => $ultimonumeroTxt["ultimoFolio"],
            );
            //$log->LogInfo("Valor de la variable \$datosImss: " . var_export ($datosImss, true));
            //$path = $_SERVER["DOCUMENT_ROOT"];
            $fechaImss1  = date('d/m/Y', strtotime($fechaBajaImss));
            $fechaImss2  = str_replace('/', '', $fechaImss1);
            $codEmpleado = str_replace('-', '', $empleadoId);

            fputs($file, $registroPatronal);
            fputs($file, $empleadoNumeroSeguroSocial);
            fputs($file, str_pad($apellidoPaterno, 27));
            fputs($file, str_pad($apellidoMaterno, 27));
            fputs($file, str_pad($nombreEmpleado, 27));
            fputs($file, $filler);
            fputs($file, $fechaImss2);
            fputs($file, str_pad($filler2, 5));
            fputs($file, $tipoMov);
            fputs($file, $numguia);
            fputs($file, str_pad($codEmpleado, 10));
            fputs($file, $motivoBaja);
            fputs($file, str_pad($filler2, 18));
            fputs($file, $idFormato);
            fputs($file, "\n");
            //$negocio -> negocio_insertarFiniquito($listaEmpleados[$i],$ultimonumeroTxt["ultimoFolio"]);
            $negocio->cambiarEstatusImssProcesoBaja($datosImss);
        }
    }

    fclose($file);
    header("Content-Disposition: attachment; filename=" . $nombre_archivo . "");
    header("Content-Type: application/force-download");
    header("Content-Length: " . filesize($nombre_archivo));
    readfile($nombre_archivo);

    //fclose($archivo);
}
