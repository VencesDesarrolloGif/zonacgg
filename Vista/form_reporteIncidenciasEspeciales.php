
<div class="containerRequisiciones">
    <h4>CONSULTAR INCIDENCIAS ESPECIALES</h4>

     Del  <input type="text" id="txtFechaIE1" name="txtFechaIE1" class="input-medium">
        al
        <input type="text" id="txtFechaIE2" name="txtFechaIE2" class="input-medium">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="consultaIncidenciasEspeciales();">Consultar</button>
        <br>
        <br>
        
        
        <section>

            <table id="detalleIncidenciasEspeciales" class="display nowrap" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Fecha Asistencia</th>
                        <th>Punto Servicio</th>
                        <th>Incidencia</th>
                        <th>Motivo</th>
                        <th>Comentario</th>
                        <th>Usuario Captura</th>
                        <th>Fecha Captura</th>
                        <th>Usuario Edicion</th>
                        <th>Fecha Edicion</th>
                        
                        </tr>
                </thead>

                <tbody></tbody>

                <tfoot>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Fecha Asistencia</th>
                        <th>Punto Servicio</th>
                        <th>Incidencia</th>
                        <th>Motivo</th>
                        <th>Comentario</th>
                        <th>Usuario Captura</th>
                        <th>Fecha Captura</th>
                        <th>Usuario Edicion</th>
                        <th>Fecha Edicion</th>


                    </tr>
                </tfoot>
            </table>
        </section>
</div>

<script type="text/javascript">

var tableDetalleIE = null;

function consultaIncidenciasEspeciales(){

    var fechaConsulta1=$("#txtFechaIE1").val();
    var fechaConsulta2=$("#txtFechaIE2").val();

    if (fechaConsulta1=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Detalle de asistencia: </strong> Proporcione Fecha Inicio de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

    return;


    }

    if (fechaConsulta2=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Detalle de asistencia: </strong> Proporcione Fecha Final de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

    return;
    

    }

    if (tableDetalleIE != null)
        {
            tableDetalleIE.destroy ();
        }
  


  
        tableDetalleIE = $('#detalleIncidenciasEspeciales').DataTable( {
        ajax: {
            url: 'ajax_getDetallesIncidenciasEspeciales.php'
            ,type: 'POST'
            ,data : {"fechaConsulta1":fechaConsulta1, "fechaConsulta2":fechaConsulta2 }
       }
        ,"columns": [
            { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "descripcionPuesto" }
            ,{ "data": "incidenciaFecha" }
            ,{ "data": "puntoServicio" }
            ,{ "data": "nomenclaturaIncidenciaEspecial" }
            ,{ "data": "MotivoIncidencia" }
            ,{ "data": "incidenciaComentario" }
            ,{ "data": "incidenciaUsuarioCaptura" }
            ,{ "data": "incidenciaFechaRegistro" }
            ,{ "data": "incidenciaUsuarioEdited" }
            ,{ "data": "incidenciaLastEdited" }
                  
        ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: [
            'copy', 'excel'
        ]

    } );



}

  $('#txtFechaIE1').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });

  $('#txtFechaIE2').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });



</script>
