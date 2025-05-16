<div class="container" align="center">
	<input type="date" name="txtFechaCaptura" id="txtFechaCaptura"  onchange="generarReporteFechaCaptura();"><img src="img/search.png">
    <table id="empleadosCapturados1" class="editinplace table table-bordered" width="50%">
      <thead> 
        <tr>
          <th style="text-align: center;">#Empleado</th>
          <th style="text-align: center;">Ap. Paterno</th>
          <th style="text-align: center;">Ap. Materno</th>
          <th style="text-align: center;">Nombre(s)</th>
          <th style="text-align: center;">Fecha Ingreso</th>
          <th style="text-align: center;">Usuario Captura</th>
          <th style="text-align: center;">Fecha Captura</th>
          <th style="text-align: center;">Periodo</th>
        </tr>
      </thead>
    </table>
</div>
<script type="text/javascript">

// $(generarReporteFechaCaptura());  

// var currentDate1 = $.datepicker.formatDate('yy-mm-dd', new Date());
// $("#txtFechaCaptura").val(currentDate1);

	function generarReporteFechaCaptura(){ 
    tableReporteC = [];
		//$("#empleadosCapturados").find("tr:gt(0)").remove();
		var fechaCaptura=$("#txtFechaCaptura").val();
    $.ajax({        
      type: "POST",
      url: "ajax_consultarEmpleadosPorFechaCaptura.php",
      data: {"fechaCaptura": fechaCaptura},
      dataType: "json",
      success: function(response) {
        if (response.status == "success")
        {
          var empleadoEncontrado = response.listaEmpleados;             
          for ( var i = 0; i < empleadoEncontrado.length; i++ ){
            var record = response.listaEmpleados[i];
            tableReporteC.push(record);
            loadDataIntablaReporteC(tableReporteC);
          } 
        }                   
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
      }
    });
 }
var tablaRepoV = null;
  function loadDataIntablaReporteC(data) {
   if (tablaRepoV != null) {
     tablaRepoV.destroy();
   }
   tablaRepoV = $('#empleadosCapturados1').DataTable({
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
     "iDisplayLength":30,
     data: data,
     destroy: true,
     "columns": [{
       "data": "numeroEmpleado"
       },{"data": "apellidoPaterno"
        },{"data": "apellidoMaterno"
        },{"data": "nombreEmpleado"
        },{"data": "fechaIngresoEmpleado"
        },{"data": "UsuarioMovimineto"
        },{"data": "empleadoFechaCaptura"
        },{"data": "Periodo"
        },],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
       });
     }
  
</script>