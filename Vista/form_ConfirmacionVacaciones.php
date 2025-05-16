<div id='mserrorConfirmacionVacaciones' name='mserrorConfirmacionVacaciones' ></div>
<center><h3>Confirmación Vacaciones</h3></center><br>
<section>
  <center>
    <span class="add-on">Del:</span>
    <input class="input-medium" id="fechainiciobusquedaConfirmacionVacaciones" name="fechainiciobusquedaConfirmacionVacaciones" type="date">
    <span class="add-on">A:</span>
    <input class="input-medium" id="fechafinbusquedaConfirmacionVacaciones" name="fechafinbusquedaConfirmacionVacaciones" type="date">
    <input class="input-medium" id="fechainicooculta" name="fechainicooculta" type="hidden">
      
    &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="cosnultaVacacionesSolicitadas('','',2);">Buscar</button>  
   <!-- <div id="btnexcel" style="display:none">
      <div  style="text-align: left;"> &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-default" onclick="downloadexcel();">Excel</button></div>
    </div>-->
  </center>
  <table id="tablaConfirmacionVacaciones"  width="100%">
    <thead>
      <tr>
        <th style="text-align: center;background-color: #B0E76E">Número empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Nombre empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Folio Vacaciones</th>
        <th style="text-align: center;background-color: #B0E76E">RolOperativo</th>
        <th style="text-align: center;background-color: #B0E76E">Tipo Vacaciones</th>
        <th style="text-align: center;background-color: #B0E76E">Aniversario</th>
        <th style="text-align: center;background-color: #B0E76E">Dias Vacaciones</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha Inicio Vacaciones</th>
        <th style="text-align: center;background-color: #B0E76E">Nombre Usuario</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha Registro Petición</th>
        <th style="text-align: center;background-color: #B0E76E">Estatus Petición</th>
        <th style="text-align: center;background-color: #B0E76E">Archivo</th>
        <th style="text-align: center;background-color: #B0E76E">Aceptar</th>
        <th style="text-align: center;background-color: #B0E76E">Declinar</th>
      </tr>
    </thead>
    <tbody>
    </table>
  </section>
  <script type="text/javascript">

$(primerFuncion());  

    function primerFuncion(){
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
      $("#fechainicooculta").val(fecha1);
      cosnultaVacacionesSolicitadas(fecha1,fecha2,1);
    }

    function cosnultaVacacionesSolicitadas(fecha1,fecha2,opcion){
      var fechaInicioasistencia = $("#fechainicooculta").val(); 
      tabledocumentosVacaciones = [];
      if(opcion==2){
        fecha1=$("#fechainiciobusquedaConfirmacionVacaciones").val();
        fecha2=$("#fechafinbusquedaConfirmacionVacaciones").val();
        if(fecha1==""){
          var mensaje="Selecciona fecha Del:";
          alertMsg1="<div id='msgAlert' class='alert alert-danger'>"+"<h3>"+mensaje+"</h3>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mserrorConfirmacionVacaciones").html(alertMsg1);
          $('#msgAlert').delay(7000).fadeOut('slow');
          return;
        }else if(fecha2==""){
          var mensaje="Selecciona fecha A:";
          alertMsg1="<div id='msgAlert' class='alert alert-danger'>"+"<h3>"+mensaje+"</h3>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mserrorConfirmacionVacaciones").html(alertMsg1);
          $('#msgAlert').delay(7000).fadeOut('slow');
          return;
        }else if(fecha1>fecha2){
          var mensaje="La fecha Del: no puede ser mayor a la fecha A:";
          alertMsg1="<div id='msgAlert' class='alert alert-danger'>"+"<h3>"+mensaje+"</h3>"+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#mserrorConfirmacionVacaciones").html(alertMsg1);
          $('#msgAlert').delay(7000).fadeOut('slow');
          return;
        }
      }
    //alert("listo para consultar");
    $.ajax ({
      type: "POST",
      url: "ajax_consultadocumentosVacaciones.php",
      data: {"fecha1":fecha1,"fecha2":fecha2,"fechaInicioasistencia":fechaInicioasistencia},
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          for (var i = 0; i < response.datos.length; i++) {
            var record = response.datos[i];
            tabledocumentosVacaciones.push(record);
          }
          loadDataInTablaVacaciones(tabledocumentosVacaciones);  
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
      }
    });
  }
  var tablaVacaciones = null;
  function loadDataInTablaVacaciones(data) {
   if (tablaVacaciones != null) {
     tablaVacaciones.destroy();
   }
   tablaVacaciones = $('#tablaConfirmacionVacaciones').DataTable({
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
       "data": "NumeroEmpleado"
        },{"data": "NombreEmpleado"
        },{"data": "folioVacaciones"
        },{"data": "RolOperativo"
        },{"data": "TipoVacaciones"
        },{"data": "Aniversario"
        },{"data": "diasVacaciones"
        },{"data": "fechaInicioVacaciones"
        },{"data": "NumbreUsuario"
        },{"data": "FechaPeticion"
        },{"data": "EstatusVacaciones"
        },{"data": "rutarachivo"
        },{"data": "Aceptar"
        },{"data": "Declinar"
        },],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
       });
     }
     function abrirarchivoVacaciones(numeroempleado,nombrearchivo){
      window.open("uploads/DocumentosVacaciones/"+numeroempleado +"/"+nombrearchivo, 'fullscreen=no',"scrollbars=no");
    }

    function ActualizarDeclinarFolioVacaciones(fechaInicioVacaciones,Folio,EntidadUsuario,ConsecutivoUsuario,CartegoriaUsuario,Opcion){
     $.ajax({
      type: "POST",
      url: "ajax_ActualizarDeclinarFolioVacaciones.php",
      data: {"fechaInicioVacaciones":fechaInicioVacaciones,"Folio":Folio,"EntidadUsuario":EntidadUsuario,"ConsecutivoUsuario":ConsecutivoUsuario,"CartegoriaUsuario":CartegoriaUsuario,"Opcion":Opcion},
      dataType: "json",
      success: function(response) {
        if (response.status == "success"){
          alert("Registro Actualizado Correctamente");
          $("#fechainiciobusquedaConfirmacionVacaciones").val("");
          $("#fechafinbusquedaConfirmacionVacaciones").val("");
          primerFuncion()

        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });      
    }

  </script>


