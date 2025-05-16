<div class="container" align="center">
	<span class="label">Fecha Registro Baja</span>
  <input type="date" name="txtFechaCapturaBajaaa" id="txtFechaCapturaBajaaa"  onchange="generarReporteFechaCapturaBaja();"><img src="img/search.png">
  <table id="empleadosCapturadosBaja" class="editinplace table table-bordered" width="70%">
    <thead>
      <tr>
        <th style="text-align: center;">#Empleado</th>
        <th style="text-align: center;">Ap. Paterno</th>
        <th style="text-align: center;">Ap. Materno</th>
        <th style="text-align: center;">Nombre(s)</th>
        <th style="text-align: center;">Fecha Ingreso</th>
        <th style="text-align: center;">Fecha Baja</th>
        <th style="text-align: center;">Tipo Baja</th>
        <th style="text-align: center;">Motivo Baja</th>
        <th style="text-align: center;">Comentario Baja</th>
        <th style="text-align: center;">Usuario registro</th>
        <th style="text-align: center;">Periodo</th>
      </tr>
    </thead>
  </table>
</div>
<script type="text/javascript">

// var currentDate2 = $.datepicker.formatDate('yy-mm-dd', new Date());
// $("#txtFechaCapturaBaja").val(currentDate2);
// $(generarReporteFechaCapturaBaja());  


	function generarReporteFechaCapturaBaja(){
		var fechaCaptura=$("#txtFechaCapturaBajaaa").val();
    tableReporteBajaC = [];
    $.ajax({
      type: "POST",
      url: "ajax_consultaEmpleadosPorFechaCapturaBaja.php",
      data: {"fechaCaptura": fechaCaptura},
      dataType: "json", 
      success: function(response) {
        if (response.status == "success")
        {
          var empleadoEncontrado = response.listaEmpleados;               
          for ( var i = 0; i < empleadoEncontrado.length; i++ ){
            var record = response.listaEmpleados[i];
            tableReporteBajaC.push(record);
            loadDataIntablaReporteBajaC(tableReporteBajaC);
          } 
        }                   
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
      }
    });
	}

  var tablaRepoBajaV = null;
  function loadDataIntablaReporteBajaC(data) {
   if (tablaRepoBajaV != null) {
     tablaRepoBajaV.destroy();
   }
   tablaRepoBajaV = $('#empleadosCapturadosBaja').DataTable({
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
        },{"data": "fechaBajaEmpleado"
        },{"data": "descripcionTipoBaja"
        },{"data": "descripcionMotivoBaja"
        },{"data": "comentarioBaja"
        },{"data": "usuarioRegistroBaja"
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