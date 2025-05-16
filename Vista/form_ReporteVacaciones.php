<div id='mserrorReporteVacaciones' name='mserrorReporteVacaciones' ></div>
<center><h3>Reporte De Vacaciones</h3><br>
<img style='width: 50px' title='CARGAR REPORTE DE VACACIONES ' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick='ReporteVacacionesSolicitadas();'></center><br>
<section> 
  <table id="tablaReporteVacaciones"  width="100%" style="display: none;">
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
        <th style="text-align: center;background-color: #B0E76E">Comentario</th>
      </tr>
    </thead>
    <tbody>
    </table>
  </section>

<script type="text/javascript">

// $(inicioReporteVac());  

// function inicioReporteVac(){
//     ReporteVacacionesSolicitadas();
// }

  function ReporteVacacionesSolicitadas(){ 
    waitingDialog.show();
    tableReporteVacaciones = [];
    $.ajax ({
      type: "POST",
      url: "ajax_consultaReporteVacaciones.php",
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          for (var i = 0; i < response.datos.length; i++) {
            var record = response.datos[i];
            tableReporteVacaciones.push(record);
          }
          loadDataInTablaReporteVacaciones(tableReporteVacaciones);  
          waitingDialog.hide();
          $("#tablaReporteVacaciones").show();
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        waitingDialog.hide();
        alert(jqXHR.responseText); 
      }
    });
  }
  var tablaRepoVacaciones = null;
  function loadDataInTablaReporteVacaciones(data) {
   if (tablaRepoVacaciones != null) {
     tablaRepoVacaciones.destroy();
   }
   tablaRepoVacaciones = $('#tablaReporteVacaciones').DataTable({
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
        },{"data": "PeriodoVacaciones"
        },{"data": "diasVacaciones"
        },{"data": "fechaInicioVacaciones"
        },{"data": "NumbreUsuario"
        },{"data": "fechaInsertVacaciones"
        },{"data": "Descripcion"
        },{"data": "rutarachivo"
        },{"data": "comentarioIncidencia"
        },],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
       });
     }
     function abrirarchivoReporteVacaciones(numeroempleado,nombrearchivo1,nombrearchivo2,caso){
      if(caso==1){
        var nombrearchivoTotal = nombrearchivo1;
      }else{
        var nombrearchivoTotal = nombrearchivo1 + " " + nombrearchivo2;
      }
      window.open("uploads/DocumentosVacaciones/"+numeroempleado +"/"+nombrearchivoTotal, 'fullscreen=no',"scrollbars=no");
    }

  </script>


