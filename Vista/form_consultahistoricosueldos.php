<div class="containertableSueldos"  align="left" STYLE="background-color:white">
      <div id="msgerror" id="msgerror"> </div>

 <center>
    <div align="center">
        <select id='seltipoconsulta'>
            <option value="0"> --Selecione--</option>
            <option value="1">Fecha Petición</option>
            <option value="2">Fecha Aceptación</option>
        </select>          
    </div><br>
    <div align="center">
          <span class="add-on">Del:</span>
          <input class="input-medium" id="fechainiciobusquedafiniquito" name="fechainiciobusquedafiniquito" type="date">
          <span class="add-on">Al:</span>
          <input class="input-medium" id="fechafinbusquedafiniquito" name="fechafinbusquedafiniquito" type="date">
           &nbsp<button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="consultatblhistoricofecha();">Buscar</button>
    </div>
 </center>

    <table id="tableConsultahistoricoSueldos" name="tableConsultahistoricoSueldos" class="display editinplace" cellspacing="0" width="90%">
                <thead>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Estatus</th>
                        <th style="text-align: center;background-color: #B0E76E">Fehca Ingreso</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Baja</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>
                        <th style="text-align: center;background-color: #B0E76E">Linea De Negocio</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Petición</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Aceptación</th>
                        <th style="text-align: center;background-color: #B0E76E">Sueldo Anteriror</th>
                        <th style="text-align: center;background-color: #B0E76E">Cuota Anteriror</th>
                        <th style="text-align: center;background-color: #B0E76E">Nuevo Sueldo</th>
                        <th style="text-align: center;background-color: #B0E76E">Nueva Cuota</th>
                        
                     </tr>
                </thead>
                 <tfoot>
                    <tr>
                        <th style="text-align: center;background-color: #B0E76E">#Empleado</th>
                        <th style="text-align: center;background-color: #B0E76E">Nombre</th>
                        <th style="text-align: center;background-color: #B0E76E">Estatus</th>
                        <th style="text-align: center;background-color: #B0E76E">Fehca Ingreso</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Baja</th>
                        <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>
                        <th style="text-align: center;background-color: #B0E76E">Linea De Negocio</th>
                        <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                        <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Petición</th>
                        <th style="text-align: center;background-color: #B0E76E">Fecha Aceptación</th>
                        <th style="text-align: center;background-color: #B0E76E">Sueldo Anteriror</th>
                        <th style="text-align: center;background-color: #B0E76E">Cuota Anteriror</th>
                        <th style="text-align: center;background-color: #B0E76E">Nuevo Sueldo</th>
                        <th style="text-align: center;background-color: #B0E76E">Nueva Cuota</th>
                        
                    </tr>
                </tfoot>

                <tbody></tbody>
    </table>

    </div>
<script type="text/javascript">

$(inicioConsultaHistSueldos());  

function inicioConsultaHistSueldos(){
    <?php if ($usuario["rol"] == "Direccion General"): ?>
        gettblhistoricosueldos();
    <?php endif;?>
}

    var tableConsultaHistoricoSueldos = null;
    var dataTableConsultarHistoricoSueldos = [];
        function gettblhistoricosueldos(){

        $.ajax ({
            type: "POST"
            ,url: "ajax_gettblhistoricosueldos.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                dataTableConsultarHistoricoSueldos = [];

                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];

                        dataTableConsultarHistoricoSueldos.push(record);
                    }
                   loadDataInTableconsultahistorysueldos(dataTableConsultarHistoricoSueldos);
                }
            }
            ,error : function (response)
            {
                alert ("ocurrio un error");
            }
        });
    }
     function loadDataInTableconsultahistorysueldos (data)
    {
        if (tableConsultaHistoricoSueldos != null)
        {
            tableConsultaHistoricoSueldos.destroy ();
            tableConsultaHistoricoSueldos = null;
        }
        if (data.length == 0)
        {
           // alert ("No hay datos para cargar");
        }
        tableConsultaHistoricoSueldos = $('#tableConsultahistoricoSueldos').DataTable( {
               "language": {
             "emptyTable": "No hay regidtro disponibles",
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
            { "data": "numeroEmpleado"}
            ,{ "data": "nombreEmpleado" }
            ,{ "data": "descripcionEstatusEmpleado" }
            ,{ "data": "FechaIngreso" }
            ,{ "data": "FechaBaja" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "descripcionLineaNegocio" }
            ,{"data":"descripcionPuesto"}
            ,{"data":"puntoServicio"}
            ,{ "data": "fechaPeticion" }
            ,{"data":"fechaAceptacion"}
            ,{"data":"sueldoAnterior"}
            ,{"data":"cuotaanterior"}
            ,{"data":"nuevoSueldo"}
            ,{"data":"cuotanueva"}
       ] 
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['copy', 'excel']

    } );

}
function consultatblhistoricofecha(){
var tipoconsulta=$("#seltipoconsulta").val();
var fechainicio=$("#fechainiciobusquedafiniquito").val();
var fechafin=$("#fechafinbusquedafiniquito").val();
 $.ajax ({
            type: "POST"
            ,url: "ajax_gethistoricosueldoporfecha.php"
            ,data:{"tipoconsulta":tipoconsulta,"fechainicio":fechainicio,"fechafin":fechafin}
            ,dataType: "json"
            ,async: false
            ,success: function (response)

            { dataTableConsultarHistoricoSueldos = [];
                $("#msgerror").html("");
                var mensaje =response.error; 
                
                if (response.status == "error")
                {
                 Msgerrorfechainiciobusqueda = "<div id='msgerrorbuscadorporfechasupervisiones' class='alert alert-error'><strong>"+mensaje+"</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgerror").html(Msgerrorfechainiciobusqueda);
                }else{//llamara a la tabla que
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data [i];
                        dataTableConsultarHistoricoSueldos.push (record);
                    }

                        loadDataInTableconsultahistorysueldos(dataTableConsultarHistoricoSueldos);
                    }
                
            }
            ,error: function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
              }
        });
}
/*
xhr, objRequest, strError){
                //console.log(xhr.responseText);
                var miTexto = xhr.responseText;
                var titulo = miTexto.search("<title>Acceder</title>");
                if(titulo !== -1){
                    alert("Su sesión ha expirado.");
                    window.location="../login/logout.cfm";*/
</script>

