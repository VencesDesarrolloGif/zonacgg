
<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_consultaasistenciaAdministrativos" name="form_consultaasistenciaAdministrativos" action="" target="_blank">
    <div id="msgerrorbuscadorporfechaadministrativos" id="msgerrorbuscadorporfechaadministrativos"> </div>
    <fieldset>
      <h1>Asistencias Administrativos</h1>
    </fieldset><br>
    <center>
      <img title='Obtener asistencia Administrativos' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="consultarasistenciasadministrativosS();" width="50px">
    </center><br>
     <span class="add-on">Del:</span>
          <input class="input-medium" id="fechainiciobusquedaadministradores" name="fechainiciobusquedaadministradores" type="date">

          <span class="add-on">A:</span>
          <input class="input-medium" id="fechafinbusquedaadministradores" name="fechafinbusquedaadministradores" type="date">

      <button type="button" class="btn btn-primary" onclick="muestraasistenciaadministrativosporfecha();">Buscar</button><br>

    <section>
      <table id="tablaasistenciasadministrativos" class="tablaRH" class="table-responsive" cellspacing="0" width="80%" style="display: none;">
        <thead>


          <tr>
                <th rowspan="2">Número de empleado</th>
                <th rowspan="2">Nombre</th>
                <th rowspan="2">Puesto</th>
                <th rowspan="2">Punto de asistencia</th>
                <th rowspan="2">Entrada</th>
                <th colspan="2">Comida</th>
                <th rowspan="2">Salida</th>
                <th  rowspan="2">Fecha asistencia</th>
                <th rowspan="2">Calificacion oficina(PUNTOS)</th>
                <th rowspan="2">Detalle</th>
          </tr>
          <tr>
            <th>Salida</th>
            <th>Entrada</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
  </form>
</div>


 <div align="center">
    <div id="modalFotoOficina" name="modalFotoOficina" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><img src="">Detalle Oficina</h4>
        </div>
      <div class="modal-body-plantilla">
        <div   id="fotoOficina" name="fotoOficina"></div>
        <div class="hero-unit" id="listaSupervisiones" name="listaSupervisiones"></div>
        <div class="modal-footer" align="centers">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
      </div>
    </div>
</div>
<script src="/zonacgg/Vista/AsistenciaAdministrativos/AsistenciaAdministrativos.js"></script>
