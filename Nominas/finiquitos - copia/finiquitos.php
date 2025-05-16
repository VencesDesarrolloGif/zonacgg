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
<div align="center">
    <div id="msgerrorfiniquitos"> </div>
    <fieldset>
      <h1>Finiquitos</h1>
    </fieldset>
       <div class="container" align="center" id="selectoresrango" style="display: block;">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-4">
        <label class="control-label">Inicio de consulta:</label>
         <input class="form-control" type="date" id="iniciodeconsultafiniquitos" name="iniciodeconsultafiniquitos">
      </div>
      <div class="col-md-4">
        <label class="control-label">fin de consulta:</label>
     <input class="form-control" type="date" id="finconsultafiniquitos" name="finconsultafiniquitos">
      </div>
    </div>
 <div class="clearfix">
    <div class="pull-center">
    <br>
      <div id="muestraselectoresperiodo" style="display: block;">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-4">
            <label class="control-label">Periodo:</label>
            <select class="form-control" id="seldescripcionperiodo" name="seldescripcionperiodo"></select>
          </div>
          <div class="col-md-4">
            <label class="control-label">Descripción de dias de pago:</label>
            <select class="form-control" id="selanioperiodo" name="selanioperiodo"></select>
          </div>
        </div>
        <button  id="btnbuscarfiniquitosporperiodo"  class="btn btn-default" onclick="calcularfiniquito();">Calcular<span class="  glyphicon glyphicon-search"></span></button>
      </div>
        <button  id="btnbuscarfiniquitosporperiodo"  class="btn btn-default" onclick="buscarporrangofechasfiniquitos();">Buscar<span class="  glyphicon glyphicon-search"></span></button>
  </div>
</div>
  </div>
<br>
<div id="muestratabladeconsultaporfechas" style="display :block">
  <section>
      <table id="tablaempleadosbajasfiniquitos" class="tablaRH" width="100%">
        <thead>
          <tr>
            <th>Número empleado</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Faecha ingreso imss</th>
            <th>Fecha baja imss</th>
          </tr>
        </thead>
        <tbody>
      </table>
    </section>
    </div>
    <div id="muestratblfiniquitoscalculados" style="display :block">
      <section>
      <table id="tablaempleadosbajasfiniquitoscalculados" class="tablaRH" width="100%">
        <thead>
          <tr>
            <th>Número empleado</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Faecha ingreso imss</th>
            <th>Fecha baja imss</th>
            <th>Prestamo</th>
            <th>Infonavit</th>
            <th>Fonacot</th>
            <th>Cuota</th>
            <th>Dias trabajados</th>
            <th>Separación</th>
             <th>Antiguedad total</th>
            <th>Dias para pp de vacaciones</th>
            <th>Dias de vacaciones</th>
            <th>Proporcion de vacaciones </th>
            <th>Calculo dias aguinaldo</th>
            <th>Dias de aguinaldo</th>
            <th>Proporcion de vacaciones</th>
             <th>Prima vacacional neta</th>
              <th>Proporcion neta aguinaldo</th>
               <th>Dias de pago</th>
               <th>Aumento en gratificacion</th>
               <th>Calculo bruto</th>
               <th>Pago neto</th>
               <th>Editar</th>
          </tr>
        </thead>
        <tbody>
      </table>
    </section>
    </div>
</div>
 <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
      <style type="text/css"></style>
      <link rel="stylesheet" href="../css/bootstrap-3.3.5/dist/css/bootstrap.min.css"><!--el que guss ocupa-->
      <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
      <link href="../../Vista/css/login.css" rel="stylesheet">
      <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="../../Vista/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css" href="../../Vista/css/dataTables.keyTable.css">
        <link rel="stylesheet" type="text/css" href="../../Vista/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="../../Vista/css/buttons.dataTables.min.css"/>

      <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
      <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
      <script type="text/javascript" language="javascript" src="../../Vista/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../Vista/js/dataTables.keyTable.js"></script>
      <script src="finiquitos.js"></script>
  </body>
</html>
