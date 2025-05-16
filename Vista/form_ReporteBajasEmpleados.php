<center><h3>Reporte De Bajas Empleados</h3><br>
<img style='width: 50px' title='Actualizar Modulo' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick='ReporteBajasEmple();'></center>
<section> 
  <table id="tablaReporteBajasEmpleados"  width="100%" style="display: none;">
    <thead>
      <tr>
        <th style="text-align: center;background-color: #B0E76E">Número Empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Nombre Empleado</th>
        <th style="text-align: center;background-color: #B0E76E">Entidad A Laborar</th>
        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th> 
        <th style="text-align: center;background-color: #B0E76E">Fecha Registro</th>
        <th style="text-align: center;background-color: #B0E76E">Usuario Solicitud Baja</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha Solicitud</th>
        <th style="text-align: center;background-color: #B0E76E">Usuario Aceptación Baja</th>
        <th style="text-align: center;background-color: #B0E76E">Fecha Aceptación Baja</th>
        <th style="text-align: center;background-color: #B0E76E">Estatus Petición Baja</th>
        <th style="text-align: center;background-color: #B0E76E">Archivo Baja</th>

      </tr>
    </thead>
    <tbody>
    </table>
  </section>

<script type="text/javascript">
  // $( document ).ready(function() {
  //   ReporteBajasEmple();
  // });

  function ReporteBajasEmple(){ 
    waitingDialog.show();
    tableReporteBajas = [];
    $.ajax ({
      type: "POST",
      url: "ajax_consultaAchivosBajaEmpleados.php",
      dataType: "json",
      success: function (response) {
        if (response.status == "success") {
          for (var i = 0; i < response.datos.length; i++) {
            var record = response.datos[i];
            tableReporteBajas.push(record);
          }
          loadDataIntablaReporteBajasEmpleados(tableReporteBajas);
          waitingDialog.hide();
          $("#tablaReporteBajasEmpleados").show();  
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        waitingDialog.hide();
        alert(jqXHR.responseText); 
      }
    });
  }
  var tablaRepoBajaEmp = null;
  function loadDataIntablaReporteBajasEmpleados(data) {
   if (tablaRepoBajaEmp != null) {
     tablaRepoBajaEmp.destroy();
   }
   tablaRepoBajaEmp = $('#tablaReporteBajasEmpleados').DataTable({
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
        },{"data": "EntidadTrabajo"
        },{"data": "PuestoEmpleado"
        },{"data": "PuntosServicio"
        },{"data": "FechaRegistro"
        },{"data": "UsuarioSolicitud"
        },{"data": "fechaSolicitud"
        },{"data": "UsuarioAceptacion"
        },{"data": "FechaAcpetacion"
        },{"data": "EstatusArchivoBaja"
        },{"data": "rutarachivo"
        },],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
       });
     }
     function abrirarchivoRegistroBaja(NumEmpBaja,rolUsuario,NombreArchivoBaja,fechaSolicitud){
     var RolUsuario = rolUsuario.replace(/-/g," ");

     if(NombreArchivoBaja=="" || NombreArchivoBaja=="NULL" || NombreArchivoBaja=="null" || NombreArchivoBaja== null){
      window.open("generadordocBajaEmpleadoHistorico.php?numempleado=" + NumEmpBaja+"&RolUsuario=" + RolUsuario+"&fechaSolicitud=" + fechaSolicitud,'fullscreen=no');
    }else{
      window.open("uploads/ArchivosBaja/"+NumEmpBaja +"/"+NombreArchivoBaja, 'fullscreen=no',"scrollbars=no");
    }
    }

  </script>


