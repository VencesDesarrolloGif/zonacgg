
<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_consultaAsignaciones" name="form_consultaAsignaciones" action="" target="_blank">
    <div id="msgerrorbuscadorporfechasupervisiones" id="msgerrorbuscadorporfechasupervisiones"> </div>
    
    <fieldset>
      <h1>Registro de supervisiones</h1>
    </fieldset><br>
    <center>
      <img title='Obtener El Registro De Supervisiones' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="readyVistaAsistencia();" width="50px">
    </center><br>

     <span class="add-on">Del:</span>
          <input class="input-medium" id="fechainiciobusquedasupervision" name="fechainiciobusquedasupervision" type="date">

          <span class="add-on">A:</span>
          <input class="input-medium" id="fechafinbusquedasupervision" name="fechafinbusquedasupervision" type="date">
<?php if ($usuario['rol'] == "Supervisor") {?>
  <button type="button" class="btn btn-primary" onclick="listaSupervisionessupervisorporfecha();">Buscar</button>
<?php } else {?>
      <button type="button" class="btn btn-primary" onclick="listaSupervisionesanalistaporfecha();">Buscar</button>
      <?php }?>
    <section>
      <table id="tablasupervisiones" class="tablaRH" cellspacing="0" width="80%" style="display: none;">
        <thead>
          <tr>
            <th>Punto de servico</th>
            <th>Número de empleado</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Entrada supervision</th>
            <th>Salida supervision</th>
            <th>Fecha asistencia</th>
            <th>Detalle</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
  </form>
</div>
 <div align="center">
  	<div id="modalSupervision" name="modalSupervision" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
    	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><img src="">Detalle Supervisiones</h4>
        </div>
	    <div class="modal-body-plantilla">
	    	<div  style="margin-right: 85%" id="foto" name="foto"></div>
        <form class="form-horizontal" id="form_vistaAsistenciaSup" name="form_vistaAsistenciaSup" action="ficheroExport_VistaAsistenciaSup.php" target="_blank" method="post">
          <input type="hidden" id="DatosExcelSup" name="DatosExcelSup" />
	        <div class="hero-unit" id="listaSupervisiones" name="listaSupervisiones"></div><br>
          <button class="botonNormal azulTransparente" id="btnDesgargaExcelAsisSup" >Descargar Excel</button>
        </form>
	      <div class="modal-footer" align="centers">
            
	          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	      </div>
	    </div>
    </div>
</div>
<script src="/zonacgg/Vista/Supervisiones/vistaasistenciaSup.js"></script>
