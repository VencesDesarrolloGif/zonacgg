 $(document).ready(function() {
 });

function CargarMatrices(){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "EdicionMatriz/ajax_ListaMatrices.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#selectEdicionMatriz11').empty().append('<option value="0" selected="selected">Matrices</option>');
            $.each(datos, function(i) {
                $('#selectEdicionMatriz11').append('<option value="' + response.datos[i].IdMatriz+ '">' + response.datos[i].nombreEntidadmatriz + '</option>');
            }); 
            $("#AgregarentidadMatrizEdit").hide();
            $("#DivTabla").hide();
            $("#BajaMatriz").hide();
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  
 }

 
$("#selectEdicionMatriz11").change(function()
  {
    var idMatriz =$("#selectEdicionMatriz11").val();
    CargarEntidadesParaAsignarALaMatrizEdcion();
    TraerDatosMatrisParaeditar(idMatriz);

    $("#AgregarentidadMatrizEdit").show();
    $("#DivTabla").show();
    $("#BajaMatriz").show();

});

function CargarEntidadesParaAsignarALaMatrizEdcion(){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "EdicionMatriz/ajax_ListaEntidadesParaAsignarALaMatrizEdicion.php",
        dataType: "json",
        success: function(response) {
            var datos = response.datos;
            $('#selectAgregarEntidad').empty().append('<option value="0" selected="selected">Entidades</option>');
            $.each(datos, function(i) {
                $('#selectAgregarEntidad').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
            });
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });  

}
 function TraerDatosMatrisParaeditar(idMatriz){ 
    waitingDialog.show();
    tablaMAtrizEdicion = [];
    $.ajax({
        type: "POST",
        url: "EdicionMatriz/ajax_ObtenerDatosEdicionMatriz.php",
        data: {"idMatriz":idMatriz},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    tablaMAtrizEdicion.push(record);
                }
                loadDataIntableDatosMatrizAEditar(tablaMAtrizEdicion);
                waitingDialog.hide();
            }else{
                var mensaje = response.message;
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
     });
 }
 var tablaDeDatosAEditarMatriz = null;

 function loadDataIntableDatosMatrizAEditar(data) {
    if(tablaDeDatosAEditarMatriz != null) {
        tablaDeDatosAEditarMatriz.destroy();
    }
    tablaDeDatosAEditarMatriz = $('#tablaEdicionMatriz').DataTable({
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
         "columns": [
         {  
             "data": "IdEntidadAsignada"
         }, 
         {   
             "data": "nombreEntidadAsignada"
         }, 
         {   
             "data": "UsuarioRegistroEntidad"
         }, 
         {   
             "data": "FechaRegistroEntidad"
         }, 
         {   "className": "dt-body-center",
             "data": "accion"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
 }
 $("#selectAgregarEntidad").change(function()
  {
    waitingDialog.show();
    var IdEntidad =$("#selectAgregarEntidad").val();
    var IdMatriz =$("#selectEdicionMatriz11").val();
    var entidad= $('select[name="selectAgregarEntidad"] option:selected').text(); 
    $.ajax({
        type: "POST",
        url: "EdicionMatriz/ajax_AgregarentidadAMatriz.php",
        data: {"IdEntidad":IdEntidad,"IdMatriz":IdMatriz,"entidad":entidad},
        dataType: "json",
        success: function(response) {
            CargarEntidadesParaAsignarALaMatrizEdcion();
            TraerDatosMatrisParaeditar(IdMatriz);
            
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });  

});

 function ElimiarEntidadDeLaMatriz(IdMatrizEntidad,idEntidadAsignada1){
    var IdEntidad= $('select[name="selectEdicionMatriz11"] option:selected').text();
    var IdEntidadAsignada = idEntidadAsignada1.replace(/-/gi, " "); 
    var IdMatriz =$("#selectEdicionMatriz11").val();
      if(IdEntidadAsignada==IdEntidad){
        cargaerroresmatricesEdicicon("Esta entidad No puede Ser Eliminada Devido Que Es Dependencia Directa De La Matriz");
    }else{
        waitingDialog.show();
        $.ajax({
            type: "POST",
            url: "EdicionMatriz/ajax_EliminarEntidadDeMatriz.php",
            data: {"IdMatrizEntidad":IdMatrizEntidad},
            dataType: "json",
            success: function(response) {
                TraerDatosMatrisParaeditar(IdMatriz);
                CargarEntidadesParaAsignarALaMatrizEdcion();
                waitingDialog.hide();     
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        }); 
    }
}

function DarDeBajaMatriz(){
    var IdMatriz =$("#selectEdicionMatriz11").val();
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "EdicionMatriz/ajax_DarDeBajaMatriz.php",
        data: {"IdMatriz":IdMatriz},
        dataType: "json",
        success: function(response) {
            CargarMatrices();
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    }); 
    
}
function cargaerroresmatricesEdicicon(mensaje){
  alertMsj1="<div class='alert alert-error' id='Mensaje'>"+mensaje+"<data-dismiss='alert'>";
  $("#MensajeEditarMatrizEdicicpn").html(alertMsj1);
  $(document).scrollTop(0);
  $('#Mensaje').delay(4000).fadeOut('slow');
}
  
