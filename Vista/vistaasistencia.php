<?php
?>
<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_consultaAsignaciones" name="form_consultaAsignaciones" action="" target="_blank">
    <div id="msgerrorbuscadorporfecha" id="msgerrorbuscadorporfecha"> </div>
    <fieldset>
      <h1>Registro de asistencia</h1>
    </fieldset><br>
    <center>
      <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="sustituciondeReadu();" width="50px">
    </center><br>
     <span class="add-on">Del:</span>
          <input class="input-medium" id="fechainiciobusqueda" name="fechainiciobusqueda" type="date">

          <span class="add-on">A:</span>
          <input class="input-medium" id="fechafinbusqueda" name="fechafinbusqueda" type="date">
<?php if ($usuario['rol'] == "Supervisor") {?>
  <button type="button" class="btn btn-primary" onclick="listarasistenciasporfechasupervisor();">Buscar</button>
<?php } else {?>
      <button type="button" class="btn btn-primary" onclick="listarasistenciasporfecha();">Buscar</button>
      <?php }?>
    <section>
      <table id="tablaAsignaciones" class="tablaRH" cellspacing="0" width="80%" style="display: none;">
        <thead>
          <tr>
            <th>Punto de servico</th>
            <th>Número de empleado</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Entrada</th>
            <th>Salida comida</th>
            <th>Entrada comida</th>
            <th>Salida de turno</th>
            <th>Fecha asistencia</th>
            <th>Turno</th>
            <th>foto</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>
  </form>
</div>
<div align="center">
  	<div id="modalfotoguardia" name="modalfotoguardia" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
    	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Detalle Supervisiones</h4>
        </div>
	    <div class="modal-body-plantilla">
	    	<div   style="width:50%; height: 50%;" id="imgguardia" name="imgguardia"></div>
	      <div class="modal-footer" align="centers">
	          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	      </div>
	    </div>
    </div>
</div>
 <script type="text/javascript">
    // $(document).ready (function ()
    // {
    //       var obj = "<?php echo $usuario["rol"]; ?>";
    //       if (obj == "Analista Asistencia") { //si no esta definida es que no es supervisor y queire decir que es superadmin  y se consultan los supervisores asi como los puntos de servicio
    //           traetodoslospuntosdeservicio();
    //       } else if(obj == "Supervisor"){ //de lo contrario quiere decir que si es supervisor y solo se consultan los puntos de servicio asi como sus guardias de los mismos.
    //           listaparasupervisores();
    //       }

    // });
    function sustituciondeReadu(){
      var obj = "<?php echo $usuario["rol"]; ?>";
          if (obj == "Analista Asistencia") { //si no esta definida es que no es supervisor y queire decir que es superadmin  y se consultan los supervisores asi como los puntos de servicio
              traetodoslospuntosdeservicio();
          } else if(obj == "Supervisor"){ //de lo contrario quiere decir que si es supervisor y solo se consultan los puntos de servicio asi como sus guardias de los mismos.
              listaparasupervisores();
          }
    }
    /////////////////////////////////////PARA EL CASO QUE SEA SUPERVISOR/////////////////////////////////////////////////
          function listaparasupervisores() {  
            waitingDialog.show();
            var tableAsignaciones = null;
            var dataTableAsignaciones = [];
            var fechainiciobusqueda=0;
            var fechafinbusqueda=0;
              $.ajax({
                  type: "POST",
                  url: "ajax_listacatalogospuntosservicios.php",
                  data: {"accion": 3,"fechainicio":fechainiciobusqueda,"fechafin":fechafinbusqueda},
                  dataType: "json",
                  success: function(response) {
                   for (var i = 0; i < response.datos.length; i++)
                    {
                        var record = response.datos[i];
                        dataTableAsignaciones.push (record);
                    }
                   loadDataInTableAsignaciones (dataTableAsignaciones);
                   $("#tablaAsignaciones").show();
                   waitingDialog.hide();

                  },
                  error: function(jqXHR, textStatus, errorThrown) { 
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
              });
          }
///////************************************************PARA EL CASO QUE EN EL CHECKBOX ESTE SELECCIONADO*************************************************
 //-------------------------para los inputs de fech---------------------------------
$('#txtFechaInicioEventual').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});
$('#txtFechaFinEventualllllll').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});
//-------------------------------------------------------------------------------------
  var tableAsignaciones = null;
function traetodoslospuntosdeservicio(){
  waitingDialog.show();
  var fechainiciobusqueda=0;
  var fechafinbusqueda=0;
  var dataTableAsignaciones = [];
  $.ajax ({
    type: "POST"
    ,url: "ajax_listacatalogospuntosservicios.php"
    ,data: {"accion": 1,"fechainicio":fechainiciobusqueda,"fechafin":fechafinbusqueda}
    ,dataType: "json"
    ,async: false
    ,success: function (response)
    {
      for (var i = 0; i < response.datos.length; i++)
      {
          var record = response.datos[i];
          dataTableAsignaciones.push (record);
      }
      loadDataInTableAsignaciones (dataTableAsignaciones);
      $("#tablaAsignaciones").show();
      waitingDialog.hide();
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
      waitingDialog.hide();
   }
  });
}
    function loadDataInTableAsignaciones (data)
    {
        if (tableAsignaciones != null)
        {
            tableAsignaciones.destroy ();
        }
        tableAsignaciones = $('#tablaAsignaciones').DataTable( {
          "language" : {
              "emptyTable" :         "No hay registro de asistencia disponible",
              "info" :               "Del _START_ al _END_ de _TOTAL_",
              "infoEmpty" :          "Mostrando 0 registros de un total de 0.",
              "infoFiltered" :       "(filtrados de un total de _MAX_ registros)",
              "infoPostFix" :        "(actualizados)",
              "lengthMenu" :         "Mostrar _MENU_ registros",
              "loadingRecords" :     "Cargando....",
              "processing"     :     "Procesando....",
              "search" :             "Buscar:",
              "searchPlaceholder" :  "Dato para buscar",
              "zeroRecords" :        "no se han encontrado coincidencias",
              "paginate" : {
                   "first" :         "Primera",
                   "last" :          "Ultima",
                   "next" :          "Siguiente",
                   "previous" :      "Anterior"
              },
              "aria" : {
                 "sortAscending" :   "Ordenación ascendente",
                 "sortDescending" :  "Ordenación descendente"
              }
           },
        data: data,
        destroy: true,
        "columns": [
            { "data": "puntoServicio" },
            { "data": "numeroempleado"},
            { "data": "nombre"},
            { "data": "descripcionPuesto"},
            { "data": "horaEntrada"},
            { "data": "salidaComer"},
            { "data": "regresoComer"},
            { "data": "salidaTurno"},
            { "data": "fechaAsistencia"},
            { "data": "idTurno"},
            {"data": "fotoguardiamodal"},]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

    } );
}
function listarasistenciasporfecha()
{  var dataTableAsignaciones = [];
  var fechafinbusqueda=$("#fechafinbusqueda").val();
  var fechainiciobusqueda=$("#fechainiciobusqueda").val();
    //-----------------------------------VALIDACIONES----------------------------------------
 if( fechainiciobusqueda===""){
    Msgerrorfechainiciobusqueda="<div id='msgerrorbuscadorporfecha' class='alert alert-error'><strong>Debe introducir fecha inicio:</strong>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbuscadorporfecha").html(Msgerrorfechainiciobusqueda);
  }else if(fechafinbusqueda==="")
  {$("#listaporfecha").empty();
    Msgerrorfechafinbusqueda="<div id='msgerrorbuscadorporfecha' class='alert alert-error'><strong>Debe introducir fecha termino:</strong>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbuscadorporfecha").html(Msgerrorfechafinbusqueda);
  }else if(fechainiciobusqueda>fechafinbusqueda){
    $("#listaporfecha").empty();
  Msgerrorfechamenorque="<div id='msgerrorbuscadorporfecha' class='alert alert-error'><strong>  No puede seleccionar en 'a:' una fecha menor a 'Del:':</strong>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbuscadorporfecha").html(Msgerrorfechamenorque);
  }else//EJECUCION DEL QUERY QUE HARA LA CONSULTA PARA MOSTRAR LA TABLA POR FECHAS
  { $("#listaporfecha").empty();
      $("#msgerrorbuscadorporfecha").html("");
 $.ajax({
                  type: "POST",
                  url: "ajax_listacatalogospuntosservicios.php",
                  data: {
                      "accion": 2,
                      "fechainicio":fechainiciobusqueda,
                      "fechafin":fechafinbusqueda
                  },
                  dataType: "json",
                  success: function(response) {
                    console.log(response);
                    for (var i = 0; i < response.datos.length; i++)
                    {
                        var record = response.datos[i];
                        //console.log(record);
                        //alert(record.esatusPunto);
                        dataTableAsignaciones.push (record);
                    }
//console.log(dataTableAsignaciones);
                   loadDataInTableAsignaciones (dataTableAsignaciones);

                  },
                  error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
              });}
}

function listarasistenciasporfechasupervisor(){
  var dataTableAsignaciones = [];
  var fechafinbusqueda=$("#fechafinbusqueda").val();
  var fechainiciobusqueda=$("#fechainiciobusqueda").val();
    //-----------------------------------VALIDACIONES----------------------------------------
 if( fechainiciobusqueda===""){
    Msgerrorfechainiciobusqueda="<div id='msgerrorbuscadorporfecha' class='alert alert-error'><strong>Debe introducir fecha inicio:</strong>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbuscadorporfecha").html(Msgerrorfechainiciobusqueda);
  }else if(fechafinbusqueda==="")
  {$("#listaporfecha").empty();
    Msgerrorfechafinbusqueda="<div id='msgerrorbuscadorporfecha' class='alert alert-error'><strong>Debe introducir fecha termino:</strong>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbuscadorporfecha").html(Msgerrorfechafinbusqueda);
  }else if(fechainiciobusqueda>fechafinbusqueda){
    $("#listaporfecha").empty();
  Msgerrorfechamenorque="<div id='msgerrorbuscadorporfecha' class='alert alert-error'><strong>  No puede seleccionar en 'A:' una fecha menor a 'Del:':</strong>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbuscadorporfecha").html(Msgerrorfechamenorque);
  }else//EJECUCION DEL QUERY QUE HARA LA CONSULTA PARA MOSTRAR LA TABLA POR FECHAS
  { $("#listaporfecha").empty();
      $("#msgerrorbuscadorporfecha").html("");
 $.ajax({
                  type: "POST",
                  url: "ajax_listacatalogospuntosservicios.php",
                  data: {
                      "accion": 4,
                      "fechainicio":fechainiciobusqueda,
                      "fechafin":fechafinbusqueda
                  },
                  dataType: "json",
                  success: function(response) {
                   // console.log(response);
                    for (var i = 0; i < response.datos.length; i++)
                    {
                        var record = response.datos[i];
                        dataTableAsignaciones.push (record); 
                    }
                   loadDataInTableAsignaciones (dataTableAsignaciones);

                  },
                  error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
        });}
 
}
function mostrarModalfotoguardia(numeroempleadoguardia,fecha,NumeroEmpleadoJunto){
	$("#imgguardia").empty();
  var splitFecha = fecha.split('-');
  var anio =splitFecha[0];
  var mes =splitFecha[1];
  var dia =splitFecha[2];
  var unionFecha = anio+mes+dia; 
  var rutaimg = NumeroEmpleadoJunto+"_"+unionFecha+'.png';
	var img = "<img style='width:100%; height:100%; border-radius: 25px;' src='../../Gif_App_Asistencia/FotosEmpleados/"+numeroempleadoguardia+"/" + rutaimg + "'>"
             $("#imgguardia").append(img);
	$('#modalfotoguardia').modal();
}
 </script>

