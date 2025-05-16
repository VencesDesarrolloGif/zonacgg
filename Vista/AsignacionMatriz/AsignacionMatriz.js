function verificaConsultaEmpleadoAsignacionMatriz()
{
    var txtSearch = $("#NumeroEmpleadoAsignacionMatriz").val ();
    var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
    var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
    if (txtSearch.length != 10 && txtSearch.length != 11)
    {
        return;
    }
    if(expreg.test(txtSearch) || expreg1.test(txtSearch))
    {
        var numeroEmpleado = $("#NumeroEmpleadoAsignacionMatriz").val();
        consultaEmpleadoAsignacionMatriz(numeroEmpleado);
    }
}

function consultaEmpleadoAsignacionMatriz (numeroEmpleado)
{
    waitingDialog.show();
    var numeroEmpleado1 = numeroEmpleado;
    $.ajax({
        type: "POST",
        url: "AsignacionMatriz/ajax_obtenerEmpleadoPorIdParaASignarMatriz.php",
        data:{"numeroEmpleado":numeroEmpleado1},
        dataType: "json",
        success: function(response) {
            if (response.status == "success")
            {                   
               var empleadoEncontrado = response.datos;
               if (empleadoEncontrado.length == 0){
                    cargaerroresAsignacionMatriz("No existe Número de empleado");
                    limpiarFormularioAsigancionMatriz();
                    waitingDialog.hide();
                }else{
                    var nombreEmpleado= empleadoEncontrado[0].nombreEmpleado;
                    var apellidoPaterno = empleadoEncontrado[0].apellidoPaterno;
                    var apellidoMaterno = empleadoEncontrado[0].apellidoMaterno;
                    var descripcionPuesto = empleadoEncontrado[0].descripcionPuesto;
                    var nombreEntidadFederativa= empleadoEncontrado[0].nombreEntidadFederativa;
                    var entidadFederativaId= empleadoEncontrado[0].entidadFederativaId;
                    var empleadoConsecutivoId= empleadoEncontrado[0].empleadoConsecutivoId;
                    var empleadoCategoriaId= empleadoEncontrado[0].empleadoCategoriaId;
                    var descripcionLineaNegocio= empleadoEncontrado[0].descripcionLineaNegocio;
                    $("#NombreEmpleadoParaAsignar").val(nombreEmpleado+" "+apellidoPaterno+" "+apellidoMaterno);
                    $("#PuestoEmpleadoParaAsignar").val(descripcionPuesto);
                    $("#EntidadTrabajoParaAsignar").val(nombreEntidadFederativa);
                    $("#LineaNegocioParaAsignar").val(descripcionLineaNegocio);
                    obtenerListaUsuariosAsignados(entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId);
                    $("#DivInformacionEmpladoParaAsignar").show();
                    $("#DivInformacionEmpladoParaAsignar1").show();
                     waitingDialog.hide();
                }
            }else{
                cargaerroresAsignacionMatriz("Error al realizar la consulta del con el numero de empleado ingresado favor de verificar");
                limpiarFormularioAsigancionMatriz();
                waitingDialog.hide();

            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
            limpiarFormularioAsigancionMatriz();

        }
    });
}  
function obtenerListaUsuariosAsignados(entidadFederativaId,empleadoConsecutivoId,empleadoCategoriaId)
{ 
    var datosRevision =""; 
    var UsuarioAsignado =""; 
    var RolAsignado =""; 
    var idMatriz =""; 
    var DescricionMatriz =""; 

    $.ajax({
        type: "POST",
        url: "AsignacionMatriz/ajax_RevisonSiTieneAsigancionDeMatriz.php",
        dataType: "json",
        data: {"entidadFederativaId":entidadFederativaId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoCategoriaId":empleadoCategoriaId},
        async:false,
        success: function(response) {
            console.log(response);
            datosRevision    = response.datos.length;
            if(datosRevision>0){
                UsuarioAsignado  = response.datos[0].usuarioAsignacion;
                RolAsignado      = response.datos[0].descripcionRolUsuario;
                idMatriz         = response.datos[0].IdMatrizAsignacion;
                DescricionMatriz = response.datos[0].nombreEntidadmatriz;
                // waitingDialog.hide();     
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });
    if(datosRevision!="0"){
        $("#UsuarioSeleccionadoParaAsignar").val(UsuarioAsignado);
        $("#RolUsuarioParaAsignar").val(RolAsignado);
        $('#selectAsignarMatrizUsuario').empty().append('<option value="' + idMatriz+ '">' + DescricionMatriz + '</option>');
        $("#DivUsuariiEmpleadoAsignar").show();
        $("#DivAsignarMatriz").show();
        CargarTablaEntidadesMatriz(0);
    }else{
        tablausuariosParaAsignacion = [];
        $.ajax({
            type: "POST",
            url: "AsignacionMatriz/ajax_obtenerListaUsuariosAsignados.php",
            data: {"entidadFederativaId":entidadFederativaId,"empleadoConsecutivoId":empleadoConsecutivoId,"empleadoCategoriaId":empleadoCategoriaId},
            dataType: "json",
            async:false,
            success: function(response) {
                if(response.status == "success") {
                   for (var i = 0; i < response.datos.length; i++) {
                        var record = response.datos[i];
                        tablausuariosParaAsignacion.push(record);
                    }
                    loadDataIntableUsuarioPAraAsignar(tablausuariosParaAsignacion);
                    $("#DivTablaUsuarioAsignar").show();
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
 }
 var tablaDeDatosDeUsuariosParaasignar = null;

 function loadDataIntableUsuarioPAraAsignar(data) {
    if(tablaDeDatosDeUsuariosParaasignar != null) {
        tablaDeDatosDeUsuariosParaasignar.destroy();
    }
    tablaDeDatosDeUsuariosParaasignar = $('#tablaUsuarioAsigancionMatriz').DataTable({
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
             "data": "usuario"
         }, 
         {   
             "data": "descripcionRolUsuario"
         }, 
         {   
             "data": "NombreEmpleadoUsuario"
         }, 
         {   
             "data": "fechaCreacion"
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

  function AsignarUsuarioEmpleadoMatriz(usuario,descripcionRolUsuario1){
    waitingDialog.show();
    var descripcionRolUsuario = descripcionRolUsuario1.replace(/-/gi, " "); 
    $("#DivTablaUsuarioAsignar").hide();
    $("#UsuarioSeleccionadoParaAsignar").val(usuario);
    $("#RolUsuarioParaAsignar").val(descripcionRolUsuario);
    $.ajax({
        type: "POST",
        url: "AsignacionMatriz/ajax_ListaMatricesParaAsignaraUsuario.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#selectAsignarMatrizUsuario').empty().append('<option value="0" selected="selected">Matrices</option>');
            $.each(datos, function(i) {
                $('#selectAsignarMatrizUsuario').append('<option value="' + response.datos[i].IdMatriz+ '">' + response.datos[i].nombreEntidadmatriz + '</option>');
            }); 
            $("#DivUsuariiEmpleadoAsignar").show();
            $("#DivAsignarMatriz").show();
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  
}

 
$("#selectAsignarMatrizUsuario").change(function()
  {
    waitingDialog.show();
    $("#DivTablAsignar").hide();
    $("#DivBotonAsignar").hide();
    $("#tituloTablaAsigancion").hide();
    CargarTablaEntidadesMatriz(1);
    
 });

function CargarTablaEntidadesMatriz(opcion){
    var idMatriz = $("#selectAsignarMatrizUsuario").val();
    tablaEntidadesMatrizAsignar = [];
    $.ajax({
        type: "POST",
        url: "AsignacionMatriz/ajax_obtenerListaEntidadesMatriz.php",
        data: {"idMatriz":idMatriz},
        dataType: "json",
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    tablaEntidadesMatrizAsignar.push(record);
                }
                loadDataIntableEntidadesMatrizAsignar(tablaEntidadesMatrizAsignar);
                $("#DivTablAsignar").show();
                if(opcion=="1"){
                    $("#DivBotonAsignar").show();
                    $("#tituloTablaAsigancion").show();
                }else{
                    $("#DivBotonDesAsignar").show();
                    $("#tituloTablaDesAsigancion").show();
                }
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

 var tablaDeDatosDeEntidadesParaMatrizAsignar = null;

 function loadDataIntableEntidadesMatrizAsignar(data) {
    if(tablaDeDatosDeEntidadesParaMatrizAsignar != null) {
        tablaDeDatosDeEntidadesParaMatrizAsignar.destroy();
    }
    tablaDeDatosDeEntidadesParaMatrizAsignar = $('#tablaAsigancionMatriz').DataTable({
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
             "data": "FechaRegistroEntidad"
         }, 
         {   
             "data": "UsuarioRegistroEntidad"
         }, 
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: []
         }

        });
}

$("#GuardarAsigancionMatrizEmpleado").click(function()
{
    waitingDialog.show();
    var IdMatriz = $("#selectAsignarMatrizUsuario").val();
    var NumeroEmpleado = $("#NumeroEmpleadoAsignacionMatriz").val();
    var Usuario = $("#UsuarioSeleccionadoParaAsignar").val();
    if(selectAsignarMatrizUsuario=="0"){
        cargaerroresAsignacionMatriz("Seleccione La Matriz A Asignar En Caso De No Haber Genere Una Nueva Matriz");
        waitingDialog.hide();
    }else{
        $.ajax({
            type: "POST",
            url: "AsignacionMatriz/ajax_RegistrarAsignacionEntidad.php",
            data:{'IdMatriz': IdMatriz,'NumeroEmpleado': NumeroEmpleado,'Usuario': Usuario},
            dataType: "json",
            success: function(response) {
                if(response.status == "success"){
                    var mensajeSucces = response.message
                    alertMsj1="<div class='alert alert-success' id='Mensaje1'>"+mensajeSucces+"<data-dismiss='alert'>";
                    $("#MensajeAsignacionMatriz").html(alertMsj1);
                    $(document).scrollTop(0);
                    $('#Mensaje1').delay(4000).fadeOut('slow');
                    limpiarFormularioAsigancionMatriz();
                 }
                 waitingDialog.hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
                 waitingDialog.hide();
             }
        });
    }
});

$("#GuardarDesaasignacionMatrizEmpleado").click(function()
{
    waitingDialog.show();
    var IdMatriz = $("#selectAsignarMatrizUsuario").val();
    var NumeroEmpleado = $("#NumeroEmpleadoAsignacionMatriz").val();
    var Usuario = $("#UsuarioSeleccionadoParaAsignar").val();
    if(selectAsignarMatrizUsuario=="0"){
        cargaerroresAsignacionMatriz("Seleccione La Matriz A Asignar En Caso De No Haber Genere Una Nueva Matriz");
        waitingDialog.hide();
    }else{
        $.ajax({
            type: "POST",
            url: "AsignacionMatriz/ajax_DesAsignarMatriz.php",
            data:{'IdMatriz': IdMatriz,'NumeroEmpleado': NumeroEmpleado,'Usuario': Usuario},
            dataType: "json",
            success: function(response) {
                if(response.status == "success"){
                    var mensajeSucces = response.message
                    alertMsj1="<div class='alert alert-success' id='Mensaje1'>"+mensajeSucces+"<data-dismiss='alert'>";
                    $("#MensajeAsignacionMatriz").html(alertMsj1);
                    $(document).scrollTop(0);
                    $('#Mensaje1').delay(4000).fadeOut('slow');
                    limpiarFormularioAsigancionMatriz();
                 }
                 waitingDialog.hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
                 waitingDialog.hide();
             }
        });
    }
});

function cargaerroresAsignacionMatriz(mensaje){
  alertMsj1="<div class='alert alert-error' id='Mensaje'>"+mensaje+"<data-dismiss='alert'>";
  $("#MensajeAsignacionMatriz").html(alertMsj1);
  $(document).scrollTop(0);
  $('#Mensaje').delay(4000).fadeOut('slow');
}

function limpiarFormularioAsigancionMatriz(){
    $("#DivInformacionEmpladoParaAsignar").hide();
    $("#DivInformacionEmpladoParaAsignar1").hide();
    $("#DivTablaUsuarioAsignar").hide();
    $("#DivUsuariiEmpleadoAsignar").hide();
    $("#DivAsignarMatriz").hide();
    $("#DivDesAsignarMatriz").hide();
    $("#DivTablAsignar").hide();
    $("#DivBotonAsignar").hide();
    $("#DivBotonDesAsignar").hide();
    $("#tituloTablaAsigancion").hide();
    $("#tituloTablaDesAsigancion").hide();
    $("#NombreEmpleadoParaAsignar").val("");
    $("#PuestoEmpleadoParaAsignar").val("");
    $("#EntidadTrabajoParaAsignar").val("");
    $("#LineaNegocioParaAsignar").val("");
    $("#UsuarioSeleccionadoParaAsignar").val("");
    $("#RolUsuarioParaAsignar").val("");
    $("#NumeroEmpleadoAsignacionMatriz").val("");

}

