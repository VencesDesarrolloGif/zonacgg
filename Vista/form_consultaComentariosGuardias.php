<?php

?>


<form class="form-horizontal" id="form_consultaComentarios" name="form_consultaComentarios">
<div class="container" align="center" >
   Del  <input type="text" id="fecha1Comentarios" name="fecha1Comentarios" class="input-medium">
        al
        <input type="text" id="fecha2Comentarios" name="fecha2Comentarios" class="input-medium">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="getMessagesGuardias();">Consultar</button>
        <br>
        <br>

        <table id="tableComentarios" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#Empleado</th>
                        <th># Nombre</th>
                        <th>Supervisor</th>
                        <th>Fecha</th>
                        <th>Comentarios</th>
                    </tr>
                </thead>

                <tbody></tbody>

                <tfoot>
                    <tr>
                        <th>#Empleado</th>
                        <th># Nombre</th>
                        <th>Supervisor</th>
                        <th>Fecha</th>
                        <th>Comentarios</th>
                    </tr>
                </tfoot>
            </table>
	<div id="divComentariosGuardias">
        	
    </div>



</div>  <!-- div container fin -->
</form>

<script type="text/javascript">

<?php 
  if ($usuario["rol"] =="Analista Asistencia")
                {
                ?>

                var currentDate1 = $.datepicker.formatDate('yy-mm-dd', new Date());
                $("#fecha1Comentarios").val(currentDate1);
                $("#fecha2Comentarios").val(currentDate1);

                var tableComentarios=null;
                //getSolicitudesBajas();
                //setInterval("getSolicitudesBajas()",110000);
                getMessagesGuardiasByDay();

                <?php
            }
            ?>
	
 
  function getMessagesGuardias(){

    var fecha1=$("#fecha1Comentarios").val();
    var fecha2=$("#fecha2Comentarios").val();

    if (fecha1=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Consulta de comentarios: </strong> Proporcione Fecha Inicio de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

    return;


    }

    if (fecha2=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Consulta de comentarios:</strong> Proporcione Fecha Final de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

    return;
    

    }

    if (tableComentarios != null)
        {
            tableComentarios.destroy ();
        }
  
        tableComentarios = $('#tableComentarios').DataTable( {
        ajax: {
            url: 'ajax_consultaComentariosByFecha.php'
            ,type: 'POST'
            ,data : {"fecha1":fecha1, "fecha2":fecha2 }
       }
            ,"columns": [
             { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado"}
            ,{ "data": "supervisor" }
            ,{ "data": "fechaComentario" }
            ,{ "data": "comentario" }
            
        ]
        ,"language": {
                "zeroRecords": "No se encontraron comentarios",
            }
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

    } );


}

function getMessagesGuardiasByDay(){

    var fecha1=$("#fecha1Comentarios").val();
    var fecha2=$("#fecha2Comentarios").val();

    if (fecha1=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Consulta de comentarios: </strong> Proporcione Fecha Inicio de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

    return;


    }

    if (fecha2=="")
    {
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Consulta de comentarios:</strong> Proporcione Fecha Final de consulta <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');

    return;
    

    }

    if (tableComentarios != null)
        {
            tableComentarios.destroy ();
        }
  
        tableComentarios = $('#tableComentarios').DataTable( {
        ajax: {
                url: 'ajax_getComentariosGuardiasByDay.php'
                ,type: 'POST'
                ,data : {"fecha1":fecha1}
            }
            ,"columns": [
                { "data": "numeroEmpleado"}
                ,{ "data": "nombreEmpleado"}
                ,{ "data": "supervisor" }
                ,{ "data": "fechaComentario" }
                ,{ "data": "comentario" }
            ]
            ,"language": {
                "zeroRecords": "No se encontraron comentarios",
            }
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel'
        ]

    } );


}

$('#fecha1Comentarios').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });

  $('#fecha2Comentarios').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

  });

</script>
