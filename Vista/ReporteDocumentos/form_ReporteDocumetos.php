<!DOCTYPE html>
<div id="mensajeerrorDocumentosEmpleados"></div>
<center><h3>REPORTE DOCUMENTOS EMPLEADOS POR FECHAS</h3></center>
<br>
  <center>
    <select id="selectBusqueda">
      <option value="0">BUSQUEDA</option>
      <option value="1">GENERAL</option>
      <option value="2">ENTIDAD</option>
    </select>
    <br>
    <br>
    <span class="add-on">Inicio:</span>
    <input class="input-medium" id="FechaInicioConsultaDoc" name="FechaInicioConsultaDoc" type="date">
    <span class="add-on">Termino:</span>
    <input class="input-medium" id="FechaFinConsultaDoc" name="FechaFinConsultaDoc" type="date">
    &nbsp<button id="btnConsultarDocumentosEmpleados" style="margin-bottom: 0.5%" type="button" class="btn btn-primary">Buscar</button> 
  </center>
  <br>
  <br>

  <div id="tablaSeleccionarEntidades" align="center"></div>
  <input type="hidden" name="totalEntidadesHidden" id="totalEntidadesHidden">
    <br>
    <br>
  <form class="form-horizontal" id="form_TablaConteoXEntidad" name="form_TablaConteoXEntidad" action="ReporteDocumentos/ficheroExcelConteoXEntidad.php?accion=1" target="_blank" method="post">
    &nbsp&nbsp<img id="descargarTablaReporteDoc" name="descargarTablaReporteDoc"  src="img/exportExcel.png" class='cursorImg' width="2%" title="Descargar tabla" style="display:none">
    <br>
    <input type="hidden" id="datosConteoTotal" name="datosConteoTotal"/>
    <div id="tablaConteoTotalXEntidad"></div>
  </form>
    <br>
    <br>
  <table id='tablaSemaforo' align="center" style="display:none">
    <thead>
        <th>Documento en la empresa<img src="img /Cuadroverde.PNG" style='width: 12%'></th>
        <th>Documento prestado al empleado<img src="img /CuadroAmarillo.PNG" style='width: 10%'></th>
        <th>Documento entregado al empleado<img src="img /CuadroRojo.PNG" style='width: 10%'></th>
        <th>Sin documento<img src="img /CuadroAzul.PNG" style='width: 15%'></th>
    </thead>
  </table>
  <br>
  <br>
<label style="display: none;" id="notaDoc">NOTA: El documento mostrado es informativo, el documento fisico original debe estar guardado en el expediente</label>
<form class="form-horizontal" id="form_TablaDocumentosEmp" name="form_TablaDocumentosEmp" action="ReporteDocumentos/ficheroExcelConteoDocEmp.php?accion=1" target="_blank" method="post">
    &nbsp&nbsp<img id="descargarTablaReporteDocEmpleados" name="descargarTablaReporteDocEmpleados"  src="img/exportExcel.png" class='cursorImg' width="2%" title="Descargar tabla" style="display:none">
     <input type="hidden" id="datosDocEmp" name="datosDocEmp"/>
    <div id="tablaDocumentosTotalesEmpleados" ></div>
</form>
<script src="ReporteDocumentos/funciones_ReporteDocumentos.js"></script>
</html>