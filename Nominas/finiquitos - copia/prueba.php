<?php

$fecha = date('Y-m-j');
for ($i = 1; $i <= 365; $i++) {
    $nuevafecha = strtotime('+' . 15 . ' day', strtotime($fecha));
    $nuevafecha = date('Y-m-j', $nuevafecha);
    // echo $nuevafecha . "->";

    $fech             = new DateTime($nuevafecha);
    $fechs            = $fech->format('Y');
    $fechaconsecutiva = date(" Y", strtotime("$fechs +1 year"));
    if ($fechs < $fechaconsecutiva) {

        echo $nuevafecha . "->";
        $fecha = $nuevafecha;
    }
}
