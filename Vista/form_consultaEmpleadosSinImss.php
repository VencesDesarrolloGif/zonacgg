

<center>
    <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick="inicioConsultaEmpSinImss();" width="50px"><br>
</center>
<div class="containerTable">
        <section>

            <table id="empleadosProcesoBaja" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th># Empleado</th>

                        <th>Ap. Paterno</th>
                        <th>Ap. Materno</th>
                        <th>Nombre</th>
                        <th>Fecha Alta</th>
                        <th>Registro Pat</th>
                        <th>Folio Txt</th>
                        <th>Rechazar</th>
                        </tr> 
                </thead>

                <tbody></tbody>

            </table>

            <button class="btn btn-large" type="button" onclick="mostrarModalConfirmacionImss();"> <img src="img/confirmarImss.png">Confirmar lote</button>


        </section>

</div>

<div id="myModalRechazado" name="myModalRechazado" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  >
  <div id="alertMsg11">
  </div>

    <div class="modal-header">

      <h4 class="modal-title" id="myModalLabel"> <img src="img/rechazarImss.png">¿Desea indicar que el empleado fue rechazado por IMSS?</h4>
    </div>

    <div class="modal-body">


        <div class="input-prepend">
          <span class="add-on"># EMPLEADO</span>
          <input id="txtNumeroEmpleadoModalImss" name="txtNumeroEmpleadoModalImss" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="txtNombreEmpleadoModalImss" name="txtNombreEmpleadoModalImss" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA INGRESO</span>
          <input id="txtFechaImssModal" name="txtFechaIngresoModalImss" type="date" class="input-medium" readonly>
        </div>

    </div>
      <div class="modal-footer">


        <button type="button" class="btn btn-primary" onclick='rechazaAltaImss();'>Si, rechazar</button>
      </div>
</div>  <!-- FIN MODAL BAJA EMPLEADO -->


  <!-- modal confirmacion imss -->

  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="myModalConfirmacionAltaImss" name="myModalConfirmacionAltaImss" >
    <div id="alertMsgconfirm">
    </div>

   <div class="modal-header">

      <h4 class="modal-title" id="myModalLabel"> <img src="img/ok.png">¿Desea confirmar imss?</h4>
    </div>

    <div class="modal-body">


        <div class="input-prepend">
          <span class="add-on"># Lote generado txt</span>
          <input id="txtNumeroLoteTxt" name="txtNumeroLoteTxt" type="text" class="input-small" maxlength="10">
          <span class="add-on">#Lote Imss</span>
          <input id="txtNumeroLoteImss" name="txtNumeroLoteImss" type="text" class="input-small" maxlength="11">
        </div>


    </div>
      <div class="modal-footer">


        <button type="button" class="btn btn-primary" onclick='confirmaLoteImss();'>Confirmar Imss</button>

      </div>
    </div>  <!-- FIN MODAL confirmacion imss-->

<script type="text/javascript">

var table1AltaImssAA = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioConsultaEmpSinImss());  

function inicioConsultaEmpSinImss(){
  if (rolUsuario=="Coordinador Imss" )
    {
    styleTableImss();
    }
}

function confirmar_imss_rechazo(empleadoId, nombreEmpleado, fechaImss)
{
   // alert (empleadoId);
    $('#myModalRechazado').modal();
    $("#txtNumeroEmpleadoModalImss").val(empleadoId);
    $("#txtNombreEmpleadoModalImss").val(nombreEmpleado);
    $("#txtFechaImssModal").val(fechaImss);
}


function insertarActualizarDatosImss(){


          var numeroEmpleado=$("#txtNumeroEmpleadoModalImss").val();
          var salarioDiario=$("#txtSalarioDiario").val();
          var fechaImss=$("#txtFechaImssModal").val();
          var numeroLote=$("#txtNumLoteImss").val();
          var registroPatronal=$("#selectRegistroP").val();
          var tipoTrabajador=$("#selectTipoTrabajador").val();
          var estatusEmpleado=1;

        $.ajax({
            type: "POST",
            url: "ajax_insertaActualizaDatosImss.php",
            data: {"numeroEmpleado":numeroEmpleado,"salarioDiario":salarioDiario,"fechaImss":fechaImss,
            "numeroLote":numeroLote, "registroPatronal":registroPatronal,"tipoTrabajador":tipoTrabajador, "estatusEmpleado":estatusEmpleado },
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {


                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Imss</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg11").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $('#myModalConfirmacionAltaImss').modal('hide');
                   // styleTable();
                    $("#txtSalarioDiario").val("");
                    $("#txtFechaImssModal").val("");
                    $("#txtNumLoteImss").val("");
                    $("#selectRegistroP").val("REGISTRO PATRONAL");
                    $("#selectTipoTrabajador").val("TIPO TRABAJADOR");
                    styleTableImss();



                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en confirmación de alta Imss:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg11").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');


                }
              },
            error: function(){
                  alert('error handing here');
            }
        });

      }

      function rechazaAltaImss(){

          var numeroEmpleado=$("#txtNumeroEmpleadoModalImss").val();
          var folioTxt="";
          var empleadoEstatusImss="1";

        $.ajax({
            type: "POST",
            url: "ajax_rechazaAltaImss.php",
            data: {"numeroEmpleado":numeroEmpleado,"folioTxt":folioTxt,"empleadoEstatusImss":empleadoEstatusImss},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {


                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Imss</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg11").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $('#myModalRechazado').modal('hide');
                    styleTableImss();
                    tabla();



                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en confirmación de alta Imss:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg11").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');


                }
              },
            error: function(){
                  alert('error handing here');
            }
        });

      }



          function confirmaLoteImss(){

          var folioTxt=$("#txtNumeroLoteTxt").val();
          var numeroLote=$("#txtNumeroLoteImss").val();
          var empleadoEstatusImss=3;


        $.ajax({
            type: "POST",
            url: "ajax_confirmaAltaImss.php",
            data: {"folioTxt":folioTxt,"numeroLote":numeroLote, "empleadoEstatusImss":empleadoEstatusImss},
            dataType: "json",
            async:false,
            success: function(response) {
                var mensaje=response.message;

                if (response.status=="success") {


                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Datos Imss</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgconfirm").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

                    $("#txtNumeroLoteTxt").val("");
                    $("#txtNumeroLoteImss").val("");

                    $('#myModalConfirmacionAltaImss').modal('hide');

                    styleTableImss();
                    functioninserhistoricomovimientosimss(folioTxt,numeroLote);

                } else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en confirmación:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsgconfirm").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');


                }
              },
             error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });

      }

      function mostrarModalConfirmacionImss()
      {
   // alert (empleadoId);
        $('#myModalConfirmacionAltaImss').modal();

      }


function styleTableImss(){
    if (table1AltaImssAA != null)
    {
        table1AltaImssAA.destroy ();
    }
    table1AltaImssAA = $('#empleadosProcesoBaja').DataTable( {
    ajax: {
        url: 'ajax_obtenerEmpleadosProcesoImss.php'
        ,type: 'POST'
    }
        ,"columns": [
            { "data": "numeroEmpleado"}
            ,{ "data": "apellidoPaterno" }
            ,{ "data": "apellidoMaterno" }
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "fechaImss" }
            ,{ "data": "registroPatronal" }
            ,{ "data": "folioTxt" }
            ,{ "data": "accion_confirmar_imss_alta" }
        ]
        ,processing: true
        ,"bPaginate": false
        ,"bPaginate": false
        ,dom: 'Bfrtip'
        ,buttons: ['excel']
    } );
console.log(table1AltaImssAA);
}


     $("#descargarEmpleadosSinImss").click(function(event) {
     $("#datos_a_enviar_sin_imss").val( $("<div>").append( $("#empleadosProcesoBaja").eq(0).clone()).html());
     $("#datosPersonalSinImss").submit();
    });






     function functioninserhistoricomovimientosimss(folioTxt,numeroLote){

        $.ajax({
            type: "POST",
            url: "ajax_historicomovimss.php",
            data: {"folioTxt":folioTxt,
            "accion":1,"numeroLote":numeroLote},
            dataType: "json",
            success: function(response) {

              },
              error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });

     }


</script>
