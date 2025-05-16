<!DOCTYPE html>
<div id="mensajeerrorDocumentosXAdministrativos"></div>
<center><h3>DETALLE DE PENDIENTES ADMINISTRATIVOS</h3></center>
<br>
  <center>
    <span class="add-on">Inicio:</span>
    <input class="input-medium" id="FechaInicioConsultaDocCont" name="FechaInicioConsultaDocCont" type="date">
    <span class="add-on">Termino:</span>
    <input class="input-medium" id="FechaFinConsultaDocCont" name="FechaFinConsultaDocCont" type="date">
    &nbsp<button id="btnConsultarDocumentosEmpleadosCont" style="margin-bottom: 0.5%" type="button" class="btn btn-primary">Buscar</button>  
    <br>
    <button id="descargaTablaDetalleDePendientesAdminitrativos" name="descargaTablaDetalleDePendientesAdminitrativos" class="btn btn-success" type="button" style="display:none;"> <span class="glyphicon glyphicon-download-alt"></span>Descargar</button>
  </center>
  <br>
  <br>
<!-- <label style="display: none;" id="notaDoc">NOTA: El documento mostrado es informativo, el documento fisico original debe estar guardado en el expediente</label> -->
<form class="form-horizontal" id="form_tablasDinamicaDetallePendienteAdmin" name="form_tablasDinamicaDetallePendienteAdmin" action="ReporteDocumentosPorContratante/ficheroExportReporteDocumentoPorContratante.php" target="_blank" method="post">
  <input type="hidden" id="datos_TablaDetalleDePendientesAdminitrativoshidden" name="datos_TablaDetalleDePendientesAdminitrativoshidden"/>
  <div id="tablaContratantesDoc" ></div>
</form>
<script src="ReporteDocumentosPorContratante/funciones_ReporteDocumentosContratante.js"></script>
</html>