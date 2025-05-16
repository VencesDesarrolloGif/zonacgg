<div id='mserrordocumentoincapacidad' name='mserrordocumentoincapacidad' ></div>
<center><h3>Archivos Incapacidad</h3><br>
<img style='width: 50px' title='CARGAR ARCHIVOS DE INCAPACIDAD QUINCENA ACTUAL' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick='inicioVisualizaArchInc();'>QUINCENA ACTUAL</center><br> 
<section>
  <center>
    <span class="add-on">Del:</span>
    <input class="input-medium" id="fechainiciobusquedadocumentoincapacidad" name="fechainiciobusquedadocumentoincapacidad" type="date">
    <span class="add-on">A:</span>
    <input class="input-medium" id="fechafinbusquedadocumentoincapacidad" name="fechafinbusquedadocumentoincapacidad" type="date">
    &nbsp
    <button  type="button" class="botonNormal azulTransparente" onclick="cosnultadocumentos('','',2);">Buscar Por Fechas</button>  <br>
   <!-- <div id="btnexcel" style="display:none">
      <div  style="text-align: left;"> &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-default" onclick="downloadexcel();">Excel</button></div>
    </div>-->
  </center>
  <table id="tabladocunmentosincapacidad11"  width="100%" style="display: none;">
    <thead>
      <tr>
        <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Nombre empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Registro patronal</th>
        <th style="text-align: center;background-color: #B0E76E">Supervisor</th>
        <th style="text-align: center;background-color: #B0E76E">Folio incapacidad</th>
        <th style="text-align: center;background-color: #B0E76E">Tipo incapacidad</th>
        <th style="text-align: center;background-color: #B0E76E">Dias incapacidad</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha inicio incapacidad</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha fin incapacidad</th>
        <th style="text-align: center;background-color: #B0E76E">Tipo de archivo</th>
        <th style="text-align: center;background-color: #B0E76E">Archivo</th>
      </tr>
    </thead>
    <tbody>
    </table>
  </section>
  <script type="text/javascript">

//$(inicioVisualizaArchInc());  

function inicioVisualizaArchInc(){
  <?php
      $diasAsistencia= $negocio -> obtenerListaDiasParaAsistencia ("QUINCENAL");
        //echo $diasAsistencia;
      ?>
      fechasAsistencia = [];
      <?php
      foreach ($diasAsistencia as $dia):
        ?>
        <?php echo "fechasAsistencia.push ('" . $dia["fecha"] . "');\n" ?>
        <?php
      endforeach;
      ?>
      fecha1 = fechasAsistencia [0];
      fecha2 = fechasAsistencia [fechasAsistencia.length - 1];
      cosnultadocumentos(fecha1,fecha2,1);
}

    function cosnultadocumentos(fecha1,fecha2,opcion){
      tabledocumentosincapacidada = [];
      if(opcion==2){

        fecha1=$("#fechainiciobusquedadocumentoincapacidad").val();
        fecha2=$("#fechafinbusquedadocumentoincapacidad").val();
        if(fecha1==""){
          var mensaje="Selecciona fecha Del:";
          alertMsg1="<div id='msgAlert' class='alert alert-danger'>"+"<h3>"+mensaje+"</h3>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mserrordocumentoincapacidad").html(alertMsg1);
          $('#msgAlert').delay(7000).fadeOut('slow');
          return;
        }else if(fecha2==""){
          var mensaje="Selecciona fecha A:";
          alertMsg1="<div id='msgAlert' class='alert alert-danger'>"+"<h3>"+mensaje+"</h3>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mserrordocumentoincapacidad").html(alertMsg1);
          $('#msgAlert').delay(7000).fadeOut('slow');
          return;

        }else if(fecha1>fecha2){
          var mensaje="La fecha Del: no puede ser mayor a la fecha A:";
          alertMsg1="<div id='msgAlert' class='alert alert-danger'>"+"<h3>"+mensaje+"</h3>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mserrordocumentoincapacidad").html(alertMsg1);
          $('#msgAlert').delay(7000).fadeOut('slow');
          return;

        }
      }
    waitingDialog.show();
    $.ajax ({
      type: "POST",
      url: "ajax_consultadocumentosIncapacidad.php",
      data: {"fecha1":fecha1,"fecha2":fecha2,"opcion":opcion},
      dataType: "json",
      success: function (response) {
        //alert("entre");
        var a=response.datos.length;
        for(var i=0; i<a;i++){
         var b=response.datos[i].length;
         for(var j=0;j<b;j++){
          var record=response.datos[i][j];
          tabledocumentosincapacidada.push(record);
        }
      }   
      loadDataInTableDocumentosIncapacidad(tabledocumentosincapacidada);   
      waitingDialog.hide();
      $("#tabladocunmentosincapacidad11").show();
    },
    error: function(jqXHR, textStatus, errorThrown){
      waitingDialog.hide();
      alert(jqXHR.responseText); 
    }
  });
}
  var tabledocumentosincapacidad = null;
  function loadDataInTableDocumentosIncapacidad(data) {
   if (tabledocumentosincapacidad != null) {
     tabledocumentosincapacidad.destroy();
   }
   tabledocumentosincapacidad = $('#tabladocunmentosincapacidad11').DataTable({
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
     "columns": [{
       "data": "numeroempleado"
     }, {"data": "nombreempleado"
   },{"data": "registroPatronal"
   },{"data": "nombresupervisor"
 },  {"data": "folioincapacidad"
},  {"data": "tipoIncapacidad"
},  {"data": "diasIncapacidad"
},{"data": "fechaInicioIncapacidad"
},  {"data": "fechaFInIncapacidad"
}, {"data": "tipoarchivo"
},{"data": "rutarachivo"
},],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
       });

     }
     function abrirarchivo(numeroempleado,nombrearchivo){
      window.open("uploads/DocumentosIncapacidad/"+numeroempleado +"/"+nombrearchivo, 'fullscreen=no',"scrollbars=no");
    }

  </script>


