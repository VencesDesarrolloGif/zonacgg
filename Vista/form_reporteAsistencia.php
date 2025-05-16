
<div class="containerRequisiciones">
    <h4>CONSULTAR DETALLE DE ASISTENCIA</h4>

     Del  <input type="text" id="fechaConsultaDetalleAsistencia1" name="fechaConsultaDetalleAsistencia1" class="input-medium">
        al
        <input type="text" id="txtConsultaAsistencia2" name="txtConsultaAsistencia2" class="input-medium">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="styleTable3();">Consultar</button>
        <br>
        <br>
        
        
        <section>

            <table id="detalleAsistencia" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre</th>
                        <th>Id Plantilla</th>
                        <th>Puesto</th>
                        <th>Rol Operativo</th>
                        <th>Fecha Asistencia</th>
                        <th>Punto Servicio</th>
                        <th>Incidencia</th>
                        <th>Tipo Incidencia</th>
                        <th>Comentario</th>
                        <th>Usuario Captura</th>
                        <th>Fecha Captura</th>
                        <th>Usuario Edicion</th>
                        <th>Fecha Edicion</th>
                        <th>Nombre Usuario</th>
                        
                        </tr>
                </thead>

                <tbody></tbody>

                <tfoot>
                    <tr>
                        <th># Empleado</th>
                        <th>Nombre</th>
                        <th>Id Plantilla</th>
                        <th>Puesto</th>
                        <th>Rol Operativo</th>
                        <th>Fecha Asistencia</th>
                        <th>Punto Servicio</th>
                        <th>Incidencia</th>
                        <th>Tipo Incidencia</th>
                        <th>Comentario</th>
                        <th>Usuario Captura</th>
                        <th>Fecha Captura</th>
                        <th>Usuario Edicion</th>
                        <th>Fecha Edicion</th>
                        <th>Nombre Usuario</th>


                    </tr>
                </tfoot>
            </table>
        </section>
</div>

<script type="text/javascript">

var tableDetalleAsistencia = null;

function styleTable3(){

    var fechaConsulta1=$("#fechaConsultaDetalleAsistencia1").val();
    var fechaConsulta2=$("#txtConsultaAsistencia2").val();

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

    if (tableDetalleAsistencia != null)
        {
            tableDetalleAsistencia.destroy ();
        }
  



        tableDetalleAsistencia = $('#detalleAsistencia').DataTable( {
        ajax: {
            url: 'ajax_getDetalleAsistencia.php'
            ,type: 'POST'
            ,data : {"fechaConsulta1":fechaConsulta1, "fechaConsulta2":fechaConsulta2 }
       }
        ,"columns": [
            { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "idPlantillaAsis" }
            ,{ "data": "descripcionPuesto" }
            ,{ "data": "roloperativo" }
            ,{ "data": "fechaAsistencia" }
            ,{ "data": "puntoServicio" }
            ,{ "data": "nomenclaturaIncidencia" }
            ,{ "data": "IncidenciaTurnoAsistencia" }
            ,{ "data": "comentarioIncidencia" }
            ,{ "data": "usuarioCapturaAsistencia" }
            ,{ "data": "fechaRegistroAsistencia" }
            ,{ "data": "usuarioEditedAsistencia" }
            ,{ "data": "lastEditedIncidencia" }
            ,{ "data": "nombreUsuarioCaptura" }
                  
        ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: [
            'copy', 'excel'
        ]

    } );



}

  $('#fechaConsultaDetalleAsistencia1').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });

  $('#txtConsultaAsistencia2').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });



</script>
