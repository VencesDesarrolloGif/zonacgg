<?php
session_start();
$usuario = $_SESSION;
if ($usuario == null) {
    header("Location: ../login/login.html");
} else {}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
include '../encabezado.html';
?>
  </head>
  <body>
	<form id="empleadosProcesoBaja" name ="empleadosProcesoBaja" method="post" action="" target="_blank">
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalconfirmacion" name="modalconfirmacion" >
		  	<div class="modal-header">
		   		<h4 class="modal-title" id="myModalLabel"> <img src="../img/ok.png">¿Desea cerrar este periodo?</h4>
		   	</div>
		    <div class="modal-body">
			    <div class="input-prepend">
			      <span class="add-on">De: </span>
			      <input id="rangoinicio" readonly  type="text" class="input-small" >
			      <span class="add-on">Al:</span>
			      <input id="rangofin" readonly name="txtNumeroLoteImssBaja" type="text" class="input-small" >
			    </div>
		    </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick='cierranomina(2);'>Confirmar</button>
			 </div>
		</div>
	</form>
	<div id="errorMsg" name="errorMsg"> </div>
	<div class="container" align="center"><h1>Nomina</h1><br>
	<div class="tabbable" >
		<ul class="nav nav-tabs">
			<li id="DNomina" style="margin-left: 40%"><a id="containerNominaActual1" href="#containerNominaActual" data-toggle="tab">Nomina Actual<span id="spanDatosPersonales" ></span></a></li>
		  	<li id="DBusqueda"><a id="containerBusqueda1" href="#containerBusqueda" data-toggle="tab">Busqueda<span id="spanDatosGenerales" ></span></a></li>
		  
		  
		</ul>
	</div>
	<div class="tab-content">		
     	<div align="center" class="tab-pane active" id="containerNominaActual" >
      		<center>
        		<div>
		          <select id='seltiponomina'></select>&nbsp;&nbsp;
		          <select id='selperiodonomina'></select><br>
		          <button class="btn-primary" id="btncierraperiodo" onclick='cierranomina(1);'>Cerrar Periodo</button>
          		</div><br>	          	
        	</center>
        </div>
        <div align="center" class="tab-pane" id="containerBusqueda" >
      		<center>
        		<div>
        			<select id='selBusquedaPer' onchange="cargaranios();"></select>&nbsp;&nbsp;
		          	<select id='selBusquedaAnio'></select>&nbsp;&nbsp;
		          	<select id='selBusquedaRango'></select><br><br>	          	
          		</div><br>          		          
        	</center>
        </div>
     </div>
     	<div style="border: 1px solid;width: 30%">
		            <h4>Mostrar Conceptos</h4>
		            <form id="formSel" class="form-inline">
		                <select id='seltipo' >
		                </select>
		                <select id='selectDeducciones' onchange="quitarDeduccion();">
		                </select>
		            </form>
	          	</div>
	   </div>
		        <div id="periodo" style="display: none;margin-left:4%" >
		            <form id="formSel" class="form-inline">
		            	<input type="hidden" id="idrango">

		            	<input type="hidden" id="hdnacciondownloadexcel" value="0">

		            	<h4 style="font-family:cursive;">Periodo:
		            	<label id="numperiodoquincena"></label>
		            	<label id="fechainicio"></label> <label >Al</label> <label id="fechafin" ></label>
		            	</h4>
		            </form>


		         </div>
		         <br><br>
			        <div id="displayshowtable" style="display:none">
					<div style="text-align: left"> &nbsp<button  type="button" class="btn btn-default" onclick="downloadexcel();">Excel</button></div>
			        <table id="tablanomina"  class="display" width="100%"  style="display:block">
			          <thead>
			            <tr>
			              <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
			              <th style="text-align: center;background-color: #B0E76E">Nombre</th>
			              <th style="text-align: center;background-color: #B0E76E">Puesto</th>
			              <th style="text-align: center;background-color: #B0E76E">Entidad</th>
			              <th style="text-align: center;background-color: #B0E76E">Fecha ingreso imss</th>
			              <th style="text-align: center;background-color: #B0E76E">Número seguro social</th>
			              <th style="text-align: center;background-color: #B0E76E">Número cuenta</th>
			              <th style="text-align: center;background-color: #B0E76E">Número cuenta clabe</th>
			              <th style="text-align: center;background-color: #B0E76E">Banco</th>
			              <th style="text-align: center;background-color: #B0E76E">Infonavit<a href='javascript:myFunction("Infonavit",9);'><img src='../../Vista/img/cancelar.png'/></a></th>
			              <th style="text-align: center;background-color: #B0E76E">Fonacot<a href='javascript:myFunction("Fonacot",10);'><img src='../../Vista/img/cancelar.png'/></a></th>
			              <th style="text-align: center;background-color: #B0E76E">Pensión<a href='javascript:myFunction("Pensión",11);'><img src='../../Vista/img/cancelar.png'/></a></th>
			              <th style="text-align: center;background-color: #B0E76E">Prestamo<a href='javascript:myFunction("Prestamo",12);'><img src='../../Vista/img/cancelar.png'/></a></th>
			              <th style="text-align: center;background-color: #B0E76E">Alimentos<a href='javascript:myFunction("Alimentos",13);'><img src='../../Vista/img/cancelar.png'/></a></th>
			              <th style="text-align: center;background-color: #B0E76E">Salario<a href='javascript:myFunction("salario",14);'><img src='../../Vista/img/cancelar.png'/></a></th>
			            </tr>
			          </thead>
			          <tbody>
			        </table>
			    </div>
      	</section>
        <link href="../../Vista/css/bootstrap.css" rel="stylesheet">
        <link href="../../Vista/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="../../Vista/css/login.css" rel="stylesheet">
        <link href="../../Vista/css/animate-custom.css" rel="stylesheet">
        <script type="text/javascript" src="../../Vista/js/jquery-2.1.1.js"></script>
		<script type="text/javascript" src="../bootstrap-3.3.5/js/bootstrap-loader.js"></script>
        <script type="text/javascript" src="../../Vista/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../Vista/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="../../Vista/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../../Vista/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="../../Vista/css/buttons.dataTables.min.css"/>
        <script type="text/javascript" language="javascript" src="../../Vista/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" language="javascript" src="../../Vista/js/jszip.min.js"></script>
        <script type="text/javascript" language="javascript" src="../../Vista/js/buttons.html5.min.js"></script>
        <script src="nomina.js"></script>
        <script src="bootbox.js"></script>
  </body>
</html>
