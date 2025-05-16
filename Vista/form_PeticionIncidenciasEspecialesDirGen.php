<div class="containertableconfirmsueldos"  align="left" STYLE="background-color:white">
 <center>
 </center>


<div class="modal hide fade" id="modalSueldoAdmin" name="modalSueldoAdmin">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div id="divMsgErrorSueldo" name="divMsgErrorSueldo"></div>
        <h5 class="modal-title">Edición de sueldo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body-edita-sueldo">
        <div class="input-prepend">
          <span class="add-on">NÚMERO EMPLEADO</span>
          <input id="inpnumeroempleadoadmin" name="inpnumeroempleadoadmin" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">NOMBRE EMPLEADO</span>
          <input id="inpnombreempleado" name="inpnombreempleado" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">FECHA INGRESO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpfechaingreso" name="inpfechaingreso" type="date" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">PUESTO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inppuestoempleado" name="inppuestoempleado" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">ROL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inprolempleado" name="inprolempleado" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">PUNTO SERVICIO &nbsp;&nbsp;&nbsp;</span>
          <input id="inppuntoservicioempleado" name="inppuntoservicioempleado" type="text" class="input-xlarge" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">ENTIDAD &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpentidadempleado" name="inpentidadempleado" type="text" class="input-medium" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">SUELDO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpsueldoempleado" name="inpsueldoempleado" onblur="calcularCuota();" type="text" class="input-medium" >
          <input id="hdnSueldoanteriroEmpleado" name="hdnSueldoanteriroEmpleado"  type="text" class="input-medium" >
        </div>
        <div class="input-prepend">
          <span class="add-on">CUOTA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <input id="inpcuotaempleado" name="inpcuotaempleado" type="text"  class="input-medium" readonly>
          <input id="hdncuotaempleado" name="hdncuotaempleado" type="text" " class="input-medium" readonly>
        </div>
      </div> <!-- fin modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="insertSueldoAdministrativoHistorico();">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    <table id="tableconfirmarPeticionIncidencia" name="tableconfirmarPeticionIncidencia" class="display editinplace" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Rol Operativo</th>
                        <th style="text-align: center;background-color: #B0E76E">Descripción Turno Extra</th>
                         <th style="text-align: center;background-color: #B0E76E">Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Turno Extra</th>
                        <th style="text-align: center;background-color: #B0E76E">Acción</th>
                       
                       
                     </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Rol Operativo</th>
                         <th style="text-align: center;background-color: #B0E76E">Descripción Turno Extra</th>
                          <th style="text-align: center;background-color: #B0E76E">Supervisor</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Turno Extra</th>
                        <th style="text-align: center;background-color: #B0E76E">Acción</th>
                       
                    </tr>
                </tfoot>

                <tbody></tbody>
    </table>

</div>
<script type="text/javascript">
  $(document).ready (function ()
  {
    <?php if ($usuario["rol"] == "Direccion General"): ?>
        getpeticionesincidenciassaconfirmar();
    <?php endif;?>

  }); // fin document ready
    var tableconfirmarPeticionIncidencia = null;
    var dataTablePeticionesincidencias = [];
        function getpeticionesincidenciassaconfirmar(){
        $.ajax ({
            type: "POST"
            ,url: "ajax_getpeticionesincidenciasdirgen.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                dataTablePeticionesincidencias = [];

                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];

                        dataTablePeticionesincidencias.push (record);

                    }

                   loadDataInTablePeticionesIncidencias (dataTablePeticionesincidencias);
                }
            }
            ,error : function (response)
            {
                alert ("ocurrio un error");
            }
        });
    } 
     function loadDataInTablePeticionesIncidencias (data)
    {
        if (tableconfirmarPeticionIncidencia != null)
        {
            tableconfirmarPeticionIncidencia.destroy ();
            tableconfirmarPeticionIncidencia = null;
        }
        if (data.length == 0)
        {
           // alert ("No hay datos para cargar");
        }

        tableconfirmarPeticionIncidencia = $('#tableconfirmarPeticionIncidencia').DataTable( {
               "language": {
             "emptyTable": "No hay peticiones disponibles",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "No se han encontrado coincidencias",
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
        "columns": [
            { "data": "numeroempleado"}
            ,{ "data": "nombreempleado" }
            ,{"data":"descripcionPuesto"}
            ,{"data":"nombrepuntoservicio"}
            ,{"data":"roloperativoincidencia"}
            ,{"data":"descripcionincidenciaespecial"}
            ,{"data":"nombresupervisor"}
            ,{"data":"Fechadeincidencia"}

            ,{"data":"edicion"}

       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['copy', 'excel']

    } );

}  

function confirmarocancelarPeticionIncidenciaEspecial(idIncidenciaEspecial,accion){
    $.ajax({
            type: "POST",
            url: "ajax_confirmaorechasapeticionincidencia.php",
            data: {idIncidenciaEspecial:idIncidenciaEspecial,accion:accion},
            dataType: "json",
            success: function(response) {
                //console.log(response);
              getpeticionesincidenciassaconfirmar();
              },
           error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
            }
        });
}
</script>