<?php

session_start();
$usuario = $_SESSION;
if ($usuario == null) {

    header("Location: ../login/login.html");
} else {

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
include '../encabezado.html';
?>
  </head>
  <body><div class="container" align="center"><h1>Subsidio Anual</h1></div>
     <div id="errorMsgtblsalarios" name="errorMsgtblsalarios"> </div>
    <div style="margin-top: 2%"></div>

        <div class="container top-buffer-submenu vertical-buffer">

    <div id="datos" >
             </div>
                <div id="datos2" >
             </div>

        </div>
        <input id="inpaccion" type="hidden" value="Editar">
        <div class="container top-buffer-submenu vertical-buffer">
<button  id="btneditar"  class="btn btn-warning" onclick="editar()">Editar <span class="glyphicon glyphicon-pencil"></span></button>
<button  id="btnguardar" disabled='true' class="btn btn-success" onclick="guardar()">Guardar</button>
<button  id="btnagregar"  class="btn btn-default" onclick="agregarfila()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
</div>
      <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
      <style type="text/css"></style>
      <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css"><!--el que guss ocupa-->
      <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
      <link href="../../Vista/css/login.css" rel="stylesheet">
      <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
      <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
      <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
      <script src="subsidioAnual.js"></script>
  </body>
</html>

