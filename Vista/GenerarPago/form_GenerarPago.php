<center>
  <button class="botonNormal azulTransparente" type="button" onclick="generarTablaEmpleadosConFolio();"> Reconsultar Empleados</button>
  <br>
  <br>
  <section>
      <table id="tablaEmpleadosProcesoPago1" style="display:none;" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead class="thead-dark">
          <tr>
            <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
            <th style="text-align: center;background-color: #B0E76E">Nombre</th>
            <th style="text-align: center;background-color: #B0E76E">Entidad</th>
            <th style="text-align: center;background-color: #B0E76E">Puesto</th>
            <th style="text-align: center;background-color: #B0E76E">Tipo Puesto</th>
            <th style="text-align: center;background-color: #B0E76E">Fecha Baja</th>
            <th style="text-align: center;background-color: #B0E76E">Total</th>
            <th style="text-align: center;background-color: #B0E76E">Banco</th>
            <th style="text-align: center;background-color: #B0E76E">Numero Cuenta</th>
            <th style="text-align: center;background-color: #B0E76E">Cuenta Clabe</th>
            <th style="text-align: center;background-color: #B0E76E">Folio</th>
            <th style="text-align: center;background-color: #B0E76E">Declinar Folio</th>
            <th style="text-align: center;background-color: #B0E76E">Error de cuenta</th>
          </tr>
        </thead>
      </table>
    </section><br>
      <button class="btn btn-large" type="button" onclick="mostrarModalConfirmacionPago();"> <img src="img/confirmarImss.png">Confirmar folio</button>
</center>

<!-- INICIO MODAL confirmacion pago-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalConfirmacionPago" name="modalConfirmacionPago" style="display:none;">
  <div id="alertMsjConfirmacionPago"></div> 
  <div class="modal-header">
    <h4 class="modal-title" id="myModalLabel"><img src="img/ok.png">¿Confirmar comprobante?</h4>
  </div>
  <div class="modal-body">
    <div class="input-prepend">
      <span class="add-on"># Folio</span>
      <input id="numeroFolioSPF" name="numeroFolioSPF" type="text" class="input-small">
      <span class="add-on">#Folio Comprobante</span>
      <input id="numeroFolioComprobantePago" name="numeroFolioComprobantePago" type="text" class="input-small">
      <br>
      <br>
    <form id="empleadosProcesoPago" name ="empleadosProcesoPago" enctype='multipart/form-data'>
      <span class="btn btn-success btn-file">Comprobante:</span>
      <input type='file' class='btn-success' id='docComprobante' name='docComprobante[]'/>
    </form>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick='confirmarLotePagoFiniquitos();'>Confirmar</button>
  </div>
</div>  <!-- FIN MODAL confirmacion pago-->

<!-- INICIO MODAL quitar empleado de un folio-->
<div id="modalQuitarFolio" name="modalQuitarFolio" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div id="alertMsjQuitarFolio"></div>
    <div class="modal-header">
      <h4 class="modal-title" id="labelPreguntaQuitarFolio"><img src="img/rechazarImss.png">¿Declinar folio?</h4>
    </div>
    <div class="modal-body">
        <div class="input-prepend">
          <span class="add-on"># EMPLEADO</span>
          <input id="numeroEmpQuitarFolio" name="numeroEmpQuitarFolio" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="nombreEmpQuitarFolio" name="nombreEmpQuitarFolio" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">FOLIO</span>
          <input id="folioEmpQuitar" name="folioEmpQuitar" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <input id="idFiniquitoHidden" name="idFiniquitoHidden" type="hidden" class="input-medium" readonly>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick='quitarFolio();'>Si, eliminar</button>
    </div>
</div>

<div id="modalErrorCuenta" name="modalErrorCuenta" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div id="alertMsjErrorCuenta"></div>
    <div class="modal-header">
      <h4 class="modal-title" id="labelPreguntaErrorCuenta"><img src="img/rechazarImss.png">¿Declinar movimiento por error en datos bancarios?</h4>
    </div>
    <div class="modal-body">
        <div class="input-prepend">
          <span class="add-on"># EMPLEADO</span>
          <input id="numeroEmpErrorCuenta" name="numeroEmpErrorCuenta" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="nombreEmpErrorCuenta" name="nombreEmpErrorCuenta" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <input id="idFiniquitoErrorCuentaHidden" name="idFiniquitoErrorCuentaHidden" type="hidden" class="input-medium" readonly>
        </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick='eliminarPorErrorCuenta();'>Si</button>
    </div>
</div>
<script type="text/javascript">

function eliminarEmpError(idFiniquito, numeroEmpleado, nombreEmpleado){
  $('#modalErrorCuenta').modal();
  $("#numeroEmpErrorCuenta").val(numeroEmpleado);
  $("#idFiniquitoErrorCuentaHidden").val(idFiniquito);
  $("#nombreEmpErrorCuenta").val(nombreEmpleado);
}

function eliminarPorErrorCuenta(){
 
  var idFiniquito=$("#idFiniquitoErrorCuentaHidden").val();
  $.ajax({
    async: false,
    type: "POST",
    url: "GenerarPago/ajax_EliminarErrorCuenta.php",
    data: {"idFiniquito":idFiniquito},
    dataType: "json",
    success: function(response) {
       var mensaje=response.message;
       if(response.status=="error"){
          alert("Error al eliminar por cuenta");
       }else{
         $('#modalErrorCuenta').modal('hide');
         swal("Listo", "Se regresó el elemento al area correspondiente","success");
         generarTablaEmpleadosConFolio();
       }
      },
    error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
    }
  });
}


$(generarTablaEmpleadosConFolio());  



function generarTablaEmpleadosConFolio(){
  empConFolio = [];
  $.ajax({
    type: "POST",
    url: "GenerarPago/ajax_obtenerEmpleadosFolio.php",
    dataType: "json",
    async: false,
    success: function(response) {
        if(response.status == "success") {
           for (var i = 0; i < response.data.length; i++) {
                var record = response.data[i];
                empConFolio.push(record);
            }
            loadtableConfirmacionesPagoPendientes(empConFolio);
            $("#tablaEmpleadosProcesoPago1").show();
        }else{
            var mensaje = response.message;
        }
     },
     error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
     }
  });

}


var tableConfirmacionesPagoPendientes = null;

 function loadtableConfirmacionesPagoPendientes(data) {
    if(tableConfirmacionesPagoPendientes != null) {
        tableConfirmacionesPagoPendientes.destroy();
    }
    tableConfirmacionesPagoPendientes = $('#tablaEmpleadosProcesoPago1').DataTable({
     "language": {
             "emptyTable": "No hay registro disponible",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "no se han encontrado coincidencias",
             "paginate": {
                 "first": "Primera",
                 "last": "Ultima",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "aria": {
                 "sortAscending": "Ordenación ascendente",
                 "sortDescending": "Ordenación descendente"
             }
         },
         data: data,
         destroy: true,
         "columns": [
            { "data": "numeroEmpleado"},
            { "data": "nombreEmpleado" },
            { "data": "nombreEntidadFederativa" },
            { "data": "descripcionPuesto" },
            { "data": "descripcionCategoria" },
            { "data": "fechaBajaImss" },
            { "className": "dt-body-right","data": "netoAlPago" },
            { "data": "idBanco" },
            { "data": "numeroCuenta" },
            { "data": "numeroCuentaClave" },
            { "className": "dt-body-right","data": "folioSPF"},
            { "className": "dt-body-center","data": "eliminarFolio" },
            { "className": "dt-body-center","data": "errorCuenta" },],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ['excel']
         }

        });
 }

function eliminarFolioEmpleado(idFiniquito, numeroEmpleado, nombreEmpleado,folioSPF){
  $('#modalQuitarFolio').modal();
  $("#numeroEmpQuitarFolio").val(numeroEmpleado);
  $("#idFiniquitoHidden").val(idFiniquito);
  $("#nombreEmpQuitarFolio").val(nombreEmpleado);
  $("#folioEmpQuitar").val(folioSPF);
}

function quitarFolio(){
 
  var idFiniquito=$("#idFiniquitoHidden").val();
  $.ajax({
    async: false,
    type: "POST",
    url: "GenerarPago/ajax_EliminarFolioSPF.php",
    data: {"idFiniquito":idFiniquito},
    dataType: "json",
    success: function(response) {
       var mensaje=response.message;
       if(response.status=="error"){
          alert("Error al eliminiar folio");
       }else{
         $('#modalQuitarFolio').modal('hide');
         swal("Listo", "Se elimino el folio correctamente","success");
         generarTablaEmpleadosConFolio();
       }
      },
    error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
    }
  });
}

function confirmarLotePagoFiniquitos(){

  var folioSPF=$("#numeroFolioSPF").val();
  var folioComprobante=$("#numeroFolioComprobantePago").val();
  var formData = new FormData($("#empleadosProcesoPago")[0]);
  formData.append('folioSPF', folioSPF);
  formData.append('folioComprobante', folioComprobante);

  $.ajax({
        type: "POST",
        url: "GenerarPago/ajax_RegistrarPagoPorFolio.php",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async:false, 
        success: function(response) {
          var mensaje=response.message;
          if (response.status=="success"){
              swal("Listo", "Comprobación cargada correctamente","success");
              $("#numeroFolioSPF").val("");
              $("#numeroFolioComprobantePago").val("");
              $("#docComprobante").val("");
              $('#modalConfirmacionPago').modal('hide');
              generarTablaEmpleadosConFolio();
          }else if(response.status=="error"){
                swal("Alto", "Error al cargar comprobacion","error");
          }
        },error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
          }
  });
}

function mostrarModalConfirmacionPago(){
  $('#modalConfirmacionPago').modal();
}
</script>