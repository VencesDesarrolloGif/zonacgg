
<div class="containertableSueldos"  align="left" STYLE="background-color:white">
 <center>

 <!--<button type="button" class="btn btn-success" onclick="obtenerLista('sinSueldo');">Elementos sin sueldo</button>
 <button type="button" class="btn btn-warning" onclick="obtenerLista('conSueldo');">Elementos con sueldo</button>
 <img src="img/refresh-icon.png" class="cursorImg" onclick='getSueldosEmpleados();obtenerLista(cargarLista);'>-->

 </center>
</div>

<div class="modal hide fade" id="modalSueldoAdmin" name="modalSueldoAdmin">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div id="divMsgErrorSueldo" name="divMsgErrorSueldo"></div>
        <h5 class="modal-title">Edición de sueldo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body-edita-sueldo">
        <div class="input-prepend">
          <span class="add-on">NÚMERO EMPLEADO</span>
          <input id="inpnumeroempleadoadmin" name="inpnumeroempleadoadmin" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="inpnombreempleado" name="inpnombreempleado" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA INGRESO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpfechaingreso" name="inpfechaingreso" type="date" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">PUESTO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inppuestoempleado" name="inppuestoempleado" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">ROL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inprolempleado" name="inprolempleado" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">PUNTO SERVICIO &nbsp;&nbsp;&nbsp;</span>
          <input id="inppuntoservicioempleado" name="inppuntoservicioempleado" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">ENTIDAD &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpentidadempleado" name="inpentidadempleado" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">SUELDO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpsueldoempleado" name="inpsueldoempleado" onblur="calcularCuota();" type="text" class="input-medium" >
          <input id="hdnSueldoanteriroEmpleado" name="hdnSueldoanteriroEmpleado"  type="hidden" class="input-medium" >
        </div>
        <div class="input-prepend">
          <span class="add-on">CUOTA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpcuotaempleado" name="inpcuotaempleado" type="text"  class="input-medium" readonly>
          <input id="hdncuotaempleado" name="hdncuotaempleado" type="hidden"  class="input-medium" readonly>
        </div>
      </div> <!-- fin modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="insertSueldoAdministrativoHistorico();">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
    <table id="tableSueldos" name="tableSueldos" class="display editinplace" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Ingreso</th>
                        <th style="text-align: center;background-color: #B0E76E">Estatus empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Turno</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>
                        <th style="text-align: center;background-color: #B0E76E">Sueldo</th>
                        <th style="text-align: center;background-color: #B0E76E">Cuota Diaria</th>
                        <th style="text-align: center;background-color: #B0E76E">Editar</th>
                     </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Ingreso</th>
                        <th style="text-align: center;background-color: #B0E76E">Estatus empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Turno</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>
                        <th style="text-align: center;background-color: #B0E76E">Sueldo</th>
                        <th style="text-align: center;background-color: #B0E76E">Cuota Diaria</th>
                        <th style="text-align: center;background-color: #B0E76E">Editar</th>
                    </tr>
                </tfoot>
                <tbody></tbody>
    </table>
    <script type="text/javascript">
var tableSueldos = null;
var dataTableSueldosAdmin = [];
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioSueldosAdmin());  

function inicioSueldosAdmin(){
    <?php if ($usuario["rol"] == "Tabulador Administrativo"): ?>
        getSueldosEmpleados();
    <?php endif;?>
}

        function getSueldosEmpleados(){
        $.ajax ({
            type: "POST"
            ,url: "ajax_getSueldosAdministrativos.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                dataTableSueldosAdmin = [];

                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];

                        dataTableSueldosAdmin.push (record);

                    }

                    loadDataInTableSueldos (dataTableSueldosAdmin);
                }
            }
            ,error : function (response)
            {
                alert ("ocurrio un error");
            }
        });
    }

     function loadDataInTableSueldos (data)
    {
        if (tableSueldos != null)
        {
            tableSueldos.destroy ();
            tableSueldos = null;
        }

        if (data.length == 0)
        {
            alert ("No hay datos para cargar");
        }

        tableSueldos = $('#tableSueldos').DataTable( {
             "language": {
             "emptyTable": "No hay registros disponibles",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "No se han encontrado coincidencias",
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
            { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "fechaIngresoEmpleado" }
            ,{ "data": "descripcionEstatusEmpleado" }
            ,{ "data": "descripcionPuesto" }
            ,{ "data": "descripcionTurno" }
            ,{ "data": "puntoServicio" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "sueldoEmpleado" }
            ,{ "data": "cuotaDiaria" }
            //,{ "data": "bonoAsistencia" }
            //,{ "data": "bonoPuntualidad" }
            ,{ "data": "edicion" }
            //,{ "data": "ElementosEnPuntoServicio" }
            //,{ "data": "diferencia" }
       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['copy', 'excel']

    } );

}
    function showModalEdicionSueldoAdministrativos(numeroEmpleado, nombreEmpleado, fechaIngreso, descripcionPuesto, descripcionTurno, puntoServicio, nombreEntidadFederativa,sueldoEmpleado, bonoAsistencia, bonoPuntualidad, cuotaDiaria){
        $("#modalSueldoAdmin").modal();
        $("#inpnumeroempleadoadmin").val(numeroEmpleado);//cambiar nombre de los inputs
        $("#inpnombreempleado").val(nombreEmpleado);
        $("#inpfechaingreso").val(fechaIngreso);
        $("#inppuestoempleado").val(descripcionPuesto);
        $("#inprolempleado").val(descripcionTurno);
        $("#inppuntoservicioempleado").val(puntoServicio);
        $("#inpentidadempleado").val(nombreEntidadFederativa);
        $("#inpsueldoempleado").val(sueldoEmpleado);
        //$("#txtSueldoEmpleadoHISTORIAL").val(sueldoEmpleado);//POR DEFINIRSE PARA GUARDAR EL SUELDO ANTERIOR
        $("#inpcuotaempleado").val(cuotaDiaria);
        $("#hdnSueldoanteriroEmpleado").val(sueldoEmpleado);
         $("#hdncuotaempleado").val(cuotaDiaria);
        
    }

    function insertSueldoAdministrativoHistorico(){
        var numeroEmpleado=$("#inpnumeroempleadoadmin").val();
        var sueldoEmpleado=$("#inpsueldoempleado").val();
        var cuotaDiariaEmpleado=$("#inpcuotaempleado").val();
        var sueldoAnterior=$("#hdnSueldoanteriroEmpleado").val();
        var cuotaAnterior=$("#hdncuotaempleado").val();
        $.ajax({
            type: "POST",
            url: "ajax_registrohistoricosueldoadmin.php",
            data: {numeroEmpleado:numeroEmpleado,sueldoEmpleado:sueldoEmpleado,  cuotaDiariaEmpleado:cuotaDiariaEmpleado ,sueldoAnterior:sueldoAnterior,cuotaAnterior:cuotaAnterior},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;

                if (response.message=="EXISTE UNA PETICION DE SUELDO ANTERIOR") {

                    $('#modalSueldoAdmin').modal('hide');

                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Actualización de sueldo: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $(document).scrollTop(0);
                    getSueldosEmpleados();

                } else if (response.message=="PETICION ENVIADA"){ 
                    $('#modalSueldoAdmin').modal('hide');

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Actualización de sueldo: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    $(document).scrollTop(0);
                    getSueldosEmpleados();
                }  else if (response.status=="error")
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en actualización de sueldo:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";

                    $("#divMsgErrorSueldo").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }
              },
           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
    }

    function calcularCuota(){
        var numeroEmpleado=$("#txtNumeroEmpleadoES").val();
        var sueldoEmpleado=$("#inpsueldoempleado").val();
        var cuotaDiariaEmpleado=(sueldoEmpleado/30);
        $("#inpcuotaempleado").val(cuotaDiariaEmpleado);
    }
    </script>