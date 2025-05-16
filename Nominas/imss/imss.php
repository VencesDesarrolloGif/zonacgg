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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <head>
    <?php
include '../encabezado.html';
?>

  </head>
  <body>
    <div class="container" align="center"><h1>Imss</h1></div>

     <div id="errorMsgtblsalarios" name="errorMsgtblsalarios"> </div>
    <div style="margin-top: 2%;"></div>

        <div >

    <div id="datos" >
             </div>


        </div>

        <input id="inpaccion" type="hidden" value="Editar">
        <div >
<button  id="btneditar"  class="btn btn-warning" onclick="editar()">Editar <span class="glyphicon glyphicon-pencil"></span></button>
<button  id="btnguardar" disabled='true' class="btn btn-success" onclick="guardar()">Guardar</button>
<button  id="btnagregar"  class="btn btn-default" onclick="agregarfila()"><span class="glyphicon glyphicon-plus"></span>Agregar</button>
</div>

<!--PARA LA LISTA DESPLEGABLE
<div class="btn-group">
  <div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle"
            data-toggle="dropdown">
      Botón Desplegable
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      <li><a href="#">Enlace #1</a></li>
      <li><a href="#">Enlace #2</a></li>
    </ul>
  </div>
</div>-->
      <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
      <style type="text/css"></style>
      <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css"><!--el que guss ocupa-->
      <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
      <link href="../../Vista/css/login.css" rel="stylesheet">
      <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
      <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
      <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
      <script src="imss.js"></script>
  </body>
</html>

