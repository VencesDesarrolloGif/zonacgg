 $(document).ready(function() {
    RevisionUsuarioLogeadoParaVista();
    //location.reload();
 });

function RevisionUsuarioLogeadoParaVista(){
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_RevisionUsuarioLogeadoParaVista.php",
        dataType: "json",
        success: function(response) {
            var EsEncargadoDeMatriz = response.datos.length;
            $("#BanderaUsuarioLogeado").val(EsEncargadoDeMatriz);
            var IdMatrizAsignacion="";
            var RolUsuario = response.datos1;
            if(EsEncargadoDeMatriz != "0"){
                IdMatrizAsignacion  = response.datos[0].IdMatrizAsignacion;
                $("#BanderaIdMatriz").val(IdMatrizAsignacion);
            }else{
                $("#BanderaIdMatriz").val(IdMatrizAsignacion);
            }
            if(RolUsuario === "Contrataciones")  
            {
                $("#StockTarjetasGeneral").show();
                $("#StockTarjetas").hide();
            }else{
                $("#StockTarjetasGeneral").hide();
                $("#StockTarjetas").show();
            }
            MostrarOpcionesVista(IdMatrizAsignacion);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
 }

 function MostrarOpcionesVista(IdMatrizAsignacion){
    $("#BanderaIdMatriz").val(IdMatrizAsignacion);
    $("#LinksUsuarioMatriz").show();
 }

function MostrarDivReservados(opcion){
    var banderaMatriz = $("#BanderaUsuarioLogeado").val();
    $("#StockPorEntidades").hide();
    $("#StockPorEntidadesGeneral").hide();
    $("#TransferirAMatriz").hide();
    $("#SucursalParaMoverAMatriz").hide();
    $("#TransferirAEntidades").hide();
    if(banderaMatriz!= "0"){
        if(opcion=="0"){
            $("#DivTransferirTarjetas").show();
            $("#UrlTransferencia").show();
            $("#VerStock").hide();
            $("#SucursalParaStock").hide();
            $("#VerStockGeneral").hide();
            $("#SucursalParaStockGeneral").hide();
        }else if(opcion=="2"){
            $("#VerStockGeneral").show();
            $("#SucursalParaStockGeneral").hide();
            $("#VerStock").hide();
            $("#SucursalParaStock").hide();
            $("#DivTransferirTarjetas").hide();
            $("#UrlTransferencia").hide();
            ObtenerEntidadesParaStockGeneral();
        }else{
            $("#VerStock").show();
            $("#SucursalParaStock").hide();
            $("#DivTransferirTarjetas").hide();
            $("#UrlTransferencia").hide();
            $("#VerStockGeneral").hide();
            $("#SucursalParaStockGeneral").hide();
            obtenaerTotalDeDartjetasRestantesEnMatriz();
            $("#divTotalStockMatriz").show();
            ObtenerEntidadesParaStock();
        }
    }else{
        if(opcion=="0"){
            $("#VerStock").hide();
            $("#SucursalParaStock").hide();
            $("#DivTransferirTarjetas").show();
            $("#UrlTransferencia").hide();
            MostrarTransferencia(1);
        }else{
            $("#VerStock").show();
            $("#SucursalParaStock").hide();
            $("#DivTransferirTarjetas").hide();
            $("#UrlTransferencia").hide();
            $("#divTotalStockMatriz").hide();
            ObtenerEntidadesParaStock();
        }        
    }    
}

function ObtenerEntidadesParaStockGeneral(){

    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerEntidadesGenerales.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#SelectEntidadStockGeneral').empty().append('<option value="0" selected="selected">Entidades</option>');
            $.each(datos, function(i) {
                $('#SelectEntidadStockGeneral').append('<option value="' +response.datos[i].idEntidadFederativa+'">' + response.datos[i].nombreEntidadFederativa + '</option>');
            }); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  
}

$("#SelectEntidadStockGeneral").change(function()
{
    var EntidadDeSucursal = $("#SelectEntidadStockGeneral").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerSucursalesPorEntidad.php",
        data:{'EntidadDeSucursal': EntidadDeSucursal},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            var Largodatos = response.datos.length;
            $('#SelectSucursalParaStockGeneral').empty().append('<option value="0" selected="selected">Sucursal</option>');
            $.each(datos, function(i) {
                $('#SelectSucursalParaStockGeneral').append('<option value="' + response.datos[i].idSucursalI+'">' + response.datos[i].nombreSucursal + '</option>');
            });
            $("#SucursalParaStockGeneral").show(); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    }); 
   
});

$("#SelectSucursalParaStockGeneral").change(function()
{
    var IdEntidadARevisar = $("#SelectSucursalParaStockGeneral").val();
    MostrarStockGeneralaaa(IdEntidadARevisar);
});

 function MostrarStockGeneralaaa(IdEntidadARevisar){
    waitingDialog.show();
    if(IdEntidadARevisar === "General1"){
        $("#SelectEntidadStockGeneral").val(0);
        $("#SucursalParaStockGeneral").hide();
    }
    tablaListaEnStockGeneral = [];
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_obtenerTotalTarjetasDisponiblesPorEntidadParaStock.php",
        data:{'IdEntidadARevisar': IdEntidadARevisar},
        dataType: "json",
        async:false,
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    tablaListaEnStockGeneral.push(record);
                }
                loadDataIntableTarjetasParaStockGeneral(tablaListaEnStockGeneral);
                $("#StockPorEntidadesGeneral").show();
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


var tablaDeDatosDeTarjetasParaStockGeneral = null;

 function loadDataIntableTarjetasParaStockGeneral(data) {
    if(tablaDeDatosDeTarjetasParaStockGeneral != null) {
        tablaDeDatosDeTarjetasParaStockGeneral.destroy();
    }
    tablaDeDatosDeTarjetasParaStockGeneral = $('#tablaStockPorEntidadesGeneral').DataTable({
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
             "data": "NumeroEmpleadoAsignado"
         },
         {  
             "data": "NombreEmpleadoAsignado"
         },
         {  
             "data": "nombreEntidadmatriz"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "nombreSucursal"
         }, 
         {   
             "data": "NumeroPedido"
         },
         {   
             "data": "idIutTarjeta"
         },
         {   
             "data": "descripcionEstatus"
         }, 
         {   "className": "dt-body-center",
             "data": "descripcionEstatusAsignacion"
         },
         {   "className": "dt-body-center",
             "data": "IdASignacionEmp"
         },
         {   "className": "dt-body-center",
             "data": "comentario"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ['excel']
         }

        });
 }



function obtenaerTotalDeDartjetasRestantesEnMatriz(){
    var idMatriz = $("#BanderaIdMatriz").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_obtenaerTotalDeDartjetasRestantesEnMatriz.php",
        data:{'idMatriz': idMatriz},
        dataType: "json",
        success: function(response) {
            Total = response.datos[0].totalTarjetaDisp;
            $("#TotalStockMatriz").val(Total);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });
}

function ObtenerEntidadesParaStock(){

    waitingDialog.show();
    var IdMatriz = $("#BanderaIdMatriz").val();
    var banderaMatriz = $("#BanderaUsuarioLogeado").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerEntidades.php",
        data:{'IdMatriz': IdMatriz,'banderaMatriz': banderaMatriz},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            var Largodatos = response.datos.length;
            $('#SelectEntidadStock').empty().append('<option value="0" selected="selected">Entidades</option>');
            $.each(datos, function(i) {
                $('#SelectEntidadStock').append('<option value="' + response.datos[i].IdEntidadAsignada+"_"+response.datos[i].IdMatrizPrincipal+'">' + response.datos[i].nombreEntidadAsignada + '</option>');
            }); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  

}

$("#SelectEntidadStock").change(function()
{
    waitingDialog.show();
    var idEntidadARevisar1 = $("#SelectEntidadStock").val();
    var idEntidadARevisar2 = idEntidadARevisar1.split("_");
    var EntidadDeSucursal = idEntidadARevisar2[0];
        
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerSucursalesPorEntidad.php",
        data:{'EntidadDeSucursal': EntidadDeSucursal},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            var Largodatos = response.datos.length;
            $('#SelectSucursalParaStock').empty().append('<option value="0" selected="selected">Sucursal</option>');
            $.each(datos, function(i) {
                $('#SelectSucursalParaStock').append('<option value="' + response.datos[i].idSucursalI+'">' + response.datos[i].nombreSucursal + '</option>');
            });
            $("#SucursalParaStock").show(); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  
   
});

$("#SelectSucursalParaStock").change(function()
{
    var IdEntidadARevisar = $("#SelectSucursalParaStock").val();
    tablaListaEnStock = [];
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_obtenerTotalTarjetasDisponiblesPorEntidadParaStock.php",
        data:{'IdEntidadARevisar': IdEntidadARevisar},
        dataType: "json",
        async:false,
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.datos.length; i++) {
                    var record = response.datos[i];
                    tablaListaEnStock.push(record);
                }
                loadDataIntableTarjetasParaStock(tablaListaEnStock);
                $("#StockPorEntidades").show();
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
});


var tablaDeDatosDeTarjetasParaStock = null;

 function loadDataIntableTarjetasParaStock(data) {
    if(tablaDeDatosDeTarjetasParaStock != null) {
        tablaDeDatosDeTarjetasParaStock.destroy();
    }
    tablaDeDatosDeTarjetasParaStock = $('#tablaStockPorEntidades').DataTable({
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
             "data": "NumeroEmpleadoAsignado"
         },
         {  
             "data": "NombreEmpleadoAsignado"
         },
         {  
             "data": "nombreEntidadmatriz"
         }, 
         {   
             "data": "nombreEntidadFederativa"
         }, 
         {   
             "data": "NumeroPedido"
         },
         {   
             "data": "idIutTarjeta"
         },
         {   
             "data": "descripcionEstatus"
         }, 
         {   "className": "dt-body-center",
             "data": "descripcionEstatusAsignacion"
         },
         {   "className": "dt-body-center",
             "data": "IdASignacionEmp"
         },
         {   "className": "dt-body-center",
             "data": "comentario"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ['excel']
         }

        });
 }

 function MostrarTransferencia(opcion){
    deseleccionar_TarjetasDespensa();
    deseleccionar_TarjetasDespensaParaMatriz();
    deseleccionar_checksAdicionales();
    if(opcion =="0"){
        $("#TransferirAEntidades").show();
        $("#TransferirAMatriz").hide();
        $("#SucursalParaMoverAMatriz").hide();
        obtenerTotalTarjetasDisponiblesEnMatriz();
    }else{
        $("#TransferirAMatriz").show();
        $("#SucursalParaMoverAMatriz").hide();
        $("#TransferirAEntidades").hide();
        ObtenerEntidades();
        $("#TotalDisponibleParaMatriz").hide();
        $("#DivListaTarjetasDisponiblesParaMatriz11").hide();
        $("#DivTotalDeTarjetasDisponiblesParaMatriz").hide();

    }
 }

 function obtenerTotalTarjetasDisponiblesEnMatriz(){
    waitingDialog.show();
    $("#SucursalAMandar").hide();
    var IdMatriz = $("#BanderaIdMatriz").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_obtenerTotalTarjetasDisponiblesEnMatriz.php",
        data:{'IdMatriz': IdMatriz},
        dataType: "json",
        success: function(response) {
            console.log(response);
            var TotalTarjetasDisponibles = response.datos.length;
            var datosTarjetasDisponibles = response.datos;
            $("#TotlaTarjetasDisponibles").val(TotalTarjetasDisponibles);
            if(TotalTarjetasDisponibles != "0"){
                CargarEntidadesAMandarTarjetas();
                $('#divTarjetasDisponibles').html(""); 
                var listaTarjetasDisponibles="<form id='checkTarjetasDisponibles'>";
                listaTarjetasDisponibles="<table class='table table-hover' id='tablaTarjetsDisponiblesParaMandar'><thead><th>Número Pedido</th><th>Iut Tarjeta</th></thead><tbody>";
                if (datosTarjetasDisponibles.length > 0)
                {
                    listaTarjetasDisponibles+="<br/>";
                    listaTarjetasDisponibles+="<a href='javascript:seleccionar_TarjetasDespensa()'>Marcar todos</a>";
                    listaTarjetasDisponibles+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                    listaTarjetasDisponibles+="<a href='javascript:deseleccionar_TarjetasDespensa()'>Marcar ninguno</a>";
                    listaTarjetasDisponibles+="<br/>";
                    for ( var i = 0; i < datosTarjetasDisponibles.length; i++ )
                    {
                        var  IdTarjetaDespensa= datosTarjetasDisponibles[i].IdTarjetaDespensa;
                        var  NumeroPedido= datosTarjetasDisponibles[i].NumeroPedido;
                        var  idIutTarjeta= datosTarjetasDisponibles[i].idIutTarjeta;

                        listaTarjetasDisponibles += "<tr><td>"+NumeroPedido+"</td><td>"+idIutTarjeta+"</td>";
                        listaTarjetasDisponibles += "<td><input type='checkbox' style='width: 25px; height: 25px' id=RadioTarjeta  name="+idIutTarjeta+" value='"+IdTarjetaDespensa+"'></td><tr> ";
                    }
                    listaTarjetasDisponibles += "</tbody></table>";
                    listaTarjetasDisponibles+="<button id='btnGardarEnvioTarjetas' type='button' class='btn btn-secondary' onclick='aplicarEnvioTarjetas();'><span class='glyphicon glyphicon-ok'></span>Enviar Tarjetas</button></form>";
                    $('#divTarjetasDisponibles').html(listaTarjetasDisponibles); 
                }else{
                    $('#divTarjetasDisponibles').html("<div><h1>No se encontraron tarjetas disponibles</h1></div>"); 
                }
                $("#MensajeSinTarjetas").hide();
                $("#EntidadesAMandar").show();
                $("#DivListaTarjetasDisponibles").show();
            }else{
                $("#MensajeSinTarjetas").show();
                $("#EntidadesAMandar").hide();
                
                $("#DivListaTarjetasDisponibles").hide();
                //FaltaELPresoDeMostrarLasTarjetas
            }

            waitingDialog.hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });
 }
 function aplicarEnvioTarjetas(){
    var entidadAEnviar = $("#SelectSucursalTransferir").val();
    var tarjetasSeleccionadas = $("input[type=checkbox]:checked");
    if(tarjetasSeleccionadas.length<"1"){
        alert("No Se Ha Seleccionado Ninguna Tarjeta Favor De Marcar Las Tarjetas A Enviar");
    }else if(entidadAEnviar =="0" || entidadAEnviar == "" || entidadAEnviar == "Entidades" ||  entidadAEnviar == "null"){
        alert("Selecciona La Entidad y Sucursal Que Recibirá Las Tarjetas");
    }else{
        $("#banderaModalFirma").val(1);
        $("#NumEmpModalFirmaParaEntidad").val("");
        $("#constraseniaFirmaParaEntidad").val("");
        $("#modalFirmaElectronicaParaEntidad").modal();
    }
}

function ActualizarEnvioTarjetasParaentidad(){
    var entidadAEnviar = $("#SelectSucursalTransferir").val();
    var tarjetasSeleccionadas = $("input[type=checkbox]:checked");
    var NumEmpModalFirmaParaEntidad = $("#numeroFirmaEnvioAentidad").val();
    var constraseniaFirmaParaEntidad = $("#ContraseniaFirmaEnvioAEntidad").val();
    var tarjetaAEnviarParaEnEntidad = [];
    for (var i = 0; i < tarjetasSeleccionadas.length; i++)
    {
        if (tarjetasSeleccionadas[i].checked == true)
        {
            tarjetaAEnviarParaEnEntidad.push (tarjetasSeleccionadas[i].value);
        }
    }
    if (tarjetaAEnviarParaEnEntidad.length > 0)
    {
        $.ajax({
            type: "POST",
            url: "DistribucionTarjetas/ajax_ActualizarEvioDeTarjetas.php",
            data:{"tarjetaAEnviarParaEnEntidad":tarjetaAEnviarParaEnEntidad,"entidadAEnviar":entidadAEnviar,"NumEmpModalFirmaParaEntidad":NumEmpModalFirmaParaEntidad,"constraseniaFirmaParaEntidad":constraseniaFirmaParaEntidad},
            dataType: "json",
            async: false,
            success: function(response) {
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }
    MostrarTransferencia(0);
    waitingDialog.hide(); 
}

 function CargarEntidadesAMandarTarjetas(){
    waitingDialog.show();
    var IdMatriz = $("#BanderaIdMatriz").val();
    var banderaMatriz = $("#BanderaUsuarioLogeado").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerEntidadesAEnviarTarjetas.php",
        data:{'IdMatriz': IdMatriz,'banderaMatriz': banderaMatriz},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            var Largodatos = response.datos.length;
            $('#SelectEntidadTransferir').empty().append('<option value="0" selected="selected">Entidades</option>');
            $.each(datos, function(i) {
                $('#SelectEntidadTransferir').append('<option value="' + response.datos[i].IdEntidadAsignada+'">' + response.datos[i].nombreEntidadAsignada + '</option>');
            }); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  
 }
 $("#SelectEntidadTransferir").change(function()
{
    waitingDialog.show();
    var EntidadDeSucursal = $("#SelectEntidadTransferir").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerSucursalesPorEntidad.php",
        data:{'EntidadDeSucursal': EntidadDeSucursal},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            var Largodatos = response.datos.length;
            $('#SelectSucursalTransferir').empty().append('<option value="0" selected="selected">Sucursal</option>');
            $.each(datos, function(i) {
                $('#SelectSucursalTransferir').append('<option value="' + response.datos[i].idSucursalI+'">' + response.datos[i].nombreSucursal + '</option>');
            });
            $("#SucursalAMandar").show(); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  
});
function seleccionar_TarjetasDespensa(){ 
   for (i=0;i<document.form_TarjetasParaEntidades.elements.length;i++) 
      if(document.form_TarjetasParaEntidades.elements[i].type == "checkbox")  
         document.form_TarjetasParaEntidades.elements[i].checked=1 
} 
function deseleccionar_TarjetasDespensa(){ 
   for (i=0;i<document.form_TarjetasParaEntidades.elements.length;i++) 
      if(document.form_TarjetasParaEntidades.elements[i].type == "checkbox")  
         document.form_TarjetasParaEntidades.elements[i].checked=0 
}

function deseleccionar_checksAdicionales(){// Se creo debido a que interferia en este modulo lo schecks de otros modulos  
    var largochecks = $("input[type=checkbox]:checked");
   for (i=0;i<largochecks.length;i++) 
      if(largochecks[i].type == "checkbox")  
         largochecks[i].checked=0 
}

 function ObtenerEntidades(){
    waitingDialog.show();
    var IdMatriz = $("#BanderaIdMatriz").val();
    var banderaMatriz = $("#BanderaUsuarioLogeado").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerEntidades.php",
        data:{'IdMatriz': IdMatriz,'banderaMatriz': banderaMatriz},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            var Largodatos = response.datos.length;
            $('#SelectEntidadTransferiraMatriz').empty().append('<option value="0" selected="selected">Entidades</option>');
            $.each(datos, function(i) {
                $('#SelectEntidadTransferiraMatriz').append('<option value="' + response.datos[i].IdEntidadAsignada+"_"+response.datos[i].IdMatrizPrincipal+'">' + response.datos[i].nombreEntidadAsignada + '</option>');
            }); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });  
 }

 
$("#SelectEntidadTransferiraMatriz").change(function()
{
    waitingDialog.show();
    var idEntidadARevisar1 = $("#SelectEntidadTransferiraMatriz").val();
    var idEntidadARevisar2 = idEntidadARevisar1.split("_");
    var EntidadDeSucursal = idEntidadARevisar2[0];
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_ObtenerSucursalesPorEntidad.php",
        data:{'EntidadDeSucursal': EntidadDeSucursal},
        dataType: "json",
        success: function(response) {
         // console.log(response);
            var datos = response.datos;
            $('#SelectSucursalTransferiraMatriz').empty().append('<option value="0" selected="selected">Sucursal</option>');
            $.each(datos, function(i) {
                $('#SelectSucursalTransferiraMatriz').append('<option value="' + response.datos[i].idSucursalI+'">' + response.datos[i].nombreSucursal + '</option>');
            }); 
            waitingDialog.hide();     
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();     
        }
    });
    $("#SucursalParaMoverAMatriz").show();  
});

 $("#SelectSucursalTransferiraMatriz").change(function()
{
    waitingDialog.show();
    var IdEntidadARevisar = $("#SelectSucursalTransferiraMatriz").val();
    $.ajax({
        type: "POST",
        url: "DistribucionTarjetas/ajax_obtenerTotalTarjetasDisponiblesPorEntidad.php",
        data:{'IdEntidadARevisar': IdEntidadARevisar},
        dataType: "json",
        success: function(response) {
            if (response.status == "success") {
                var TotalTarjetasDisponibles = response.datos.length;
                var TarjetasDisponibles = response.datos;
                $("#TotlaTarjetasDisponiblesParaMatriz").val(TotalTarjetasDisponibles);
                $("#DivTotalDeTarjetasDisponiblesParaMatriz").show();;
    
                if(TotalTarjetasDisponibles != "0"){
                    var datosTarjetasDisponibles = response.datos[0]["nombreEntidadmatriz"];
                    var IdMatriz = response.datos[0]["IdMatriz"];
                    var datosTarjetasDisponiblesParaMatriz = response.datos;
                    $("#MatrizATransferir").val(datosTarjetasDisponibles);
                    $("#IdMatrizATransfer").val(IdMatriz);

                    $('#divTarjetasDisponiblesParaMatriz11').html(""); 
                    var listaTarjetasDisponiblesParaMatriz="<form id='checkTarjetasDisponiblesParaMatriz'>";
                    listaTarjetasDisponiblesParaMatriz="<table class='table table-hover' id='tablaTarjetsDisponiblesParaMandaraMatriz'><thead><th>Número Pedido</th><th>Iut Tarjeta</th></thead><tbody>";
                    if (datosTarjetasDisponiblesParaMatriz.length > 0)
                    {
                        listaTarjetasDisponiblesParaMatriz+="<br/>";
                        listaTarjetasDisponiblesParaMatriz+="<a href='javascript:seleccionar_TarjetasDespensaParaMatriz()'>Marcar todos</a>";
                        listaTarjetasDisponiblesParaMatriz+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                        listaTarjetasDisponiblesParaMatriz+="<a href='javascript:deseleccionar_TarjetasDespensaParaMatriz()'>Marcar ninguno</a>";
                        listaTarjetasDisponiblesParaMatriz+="<br/>";
                        for ( var i = 0; i < datosTarjetasDisponiblesParaMatriz.length; i++ )
                        {
                            var  IdTarjetaDespensa= datosTarjetasDisponiblesParaMatriz[i].IdTarjetaDespensa;
                            var  NumeroPedido= datosTarjetasDisponiblesParaMatriz[i].NumeroPedido;
                            var  idIutTarjeta= datosTarjetasDisponiblesParaMatriz[i].idIutTarjeta;
    
                            listaTarjetasDisponiblesParaMatriz += "<tr><td>"+NumeroPedido+"</td><td>"+idIutTarjeta+"</td>";
                            listaTarjetasDisponiblesParaMatriz += "<td><input type='checkbox' style='width: 25px; height: 25px' id=RadioTarjeta  name="+idIutTarjeta+" value='"+IdTarjetaDespensa+"'></td><tr> ";
                        }
                        listaTarjetasDisponiblesParaMatriz += "</tbody></table>";
                        listaTarjetasDisponiblesParaMatriz+="<button id='btnGardarEnvioTarjetas' type='button' class='btn btn-secondary' onclick='aplicarEnvioTarjetasAMatriz();'><span class='glyphicon glyphicon-ok'></span>Enviar Tarjetas</button></form>";
                        $('#divTarjetasDisponiblesParaMatriz11').html(listaTarjetasDisponiblesParaMatriz); 
                    }else{
                        $('#divTarjetasDisponiblesParaMatriz11').html("<div><h1>No se encontraron tarjetas disponibles</h1></div>"); 
                    }
                    $("#MensajeSinTarjetasDisponibles").hide();
                    $("#TotalDisponibleParaMatriz").show();
                    $("#DivListaTarjetasDisponiblesParaMatriz11").show();
                }else{
                    $("#MensajeSinTarjetasDisponibles").show();
                    $("#DivListaTarjetasDisponiblesParaMatriz11").hide();
                    $("#DivListaTarjetasDisponibles").hide();
                    $("#TotalDisponibleParaMatriz").hide();
    
                    //FaltaELPresoDeMostrarLasTarjetas
                }
                waitingDialog.hide();
            }else{
                alert(response.status);
                waitingDialog.hide();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });
});

 function seleccionar_TarjetasDespensaParaMatriz(){ 
   for (i=0;i<document.form_TarjetasParaMatriz.elements.length;i++) 
      if(document.form_TarjetasParaMatriz.elements[i].type == "checkbox")  
         document.form_TarjetasParaMatriz.elements[i].checked=1 
} 
function deseleccionar_TarjetasDespensaParaMatriz(){ 
   for (i=0;i<document.form_TarjetasParaMatriz.elements.length;i++) 
      if(document.form_TarjetasParaMatriz.elements[i].type == "checkbox")  
         document.form_TarjetasParaMatriz.elements[i].checked=0 
}

function aplicarEnvioTarjetasAMatriz(){

    
    var tarjetasSeleccionadasParaMatriz = $("input[type=checkbox]:checked");
    if(tarjetasSeleccionadasParaMatriz.length<"1"){
        alert("No Se Ha Seleccionado Ninguna Tarjeta Favor De Marcar Las Tarjetas A Enviar");
    }else{
        $("#banderaModalFirma").val(0);
        $("#NumEmpModalFirmaParaEntidad").val("");
        $("#constraseniaFirmaParaEntidad").val("");
        $("#modalFirmaElectronicaParaEntidad").modal();
    }

            
}

function ActualizarEnvioTarjetasParaMatriz(){
    var IdMatriz = $("#IdMatrizATransfer").val();
    var NumEmpModalFirmaParaEntidad = $("#numeroFirmaEnvioAentidad").val();
    var constraseniaFirmaParaEntidad = $("#ContraseniaFirmaEnvioAEntidad").val();
    var tarjetasSeleccionadasParaMatriz = $("input[type=checkbox]:checked");
    var tarjetaAEnviarAMatriz = [];

    for (var i = 0; i < tarjetasSeleccionadasParaMatriz.length; i++)
    {
        if (tarjetasSeleccionadasParaMatriz[i].checked == true)
        {
            tarjetaAEnviarAMatriz.push (tarjetasSeleccionadasParaMatriz[i].value);
        }
    }
    if (tarjetaAEnviarAMatriz.length > 0)
    {
        $.ajax({
            type: "POST",
            url: "DistribucionTarjetas/ajax_ActualizarEvioDeTarjetasParaMatriz.php",
            data:{"tarjetaAEnviarAMatriz":tarjetaAEnviarAMatriz,"IdMatriz":IdMatriz,"NumEmpModalFirmaParaEntidad":NumEmpModalFirmaParaEntidad,"constraseniaFirmaParaEntidad":constraseniaFirmaParaEntidad},
            dataType: "json",
            async: false,
            success: function(response) {
            },
            error: function(jqXHR, textStatus, errorThrown) {
                waitingDialog.hide(); 
                alert(jqXHR.responseText);
            }
        });
    }
    MostrarTransferencia(1);
    waitingDialog.hide();  
}

function RevisarFirmaInternaParaEnvioDeTarjetaParaEntidad(){
  var NumEmpModalBaja = $("#NumEmpModalFirmaParaEntidad").val();
  var constraseniaFirma = $("#constraseniaFirmaParaEntidad").val();
  var banderaModalFirma = $("#banderaModalFirma").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaEnvioTarjetaAEntidad("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaEnvioTarjetaAEntidad("Escriba la contraseña para continuar");
  }else{
    $("#modalFirmaElectronicaParaEntidad").modal("hide");
    waitingDialog.show();  
    $.ajax({
      type: "POST",
      url: "DistribucionTarjetas/ajax_obtenerFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var RespuestaLargo = response["datos"].length;
        if(RespuestaLargo == "0"){
        $("#modalFirmaElectronicaParaEntidad").modal();
          cargaerroresFirmaInternaEnvioTarjetaAEntidad("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          waitingDialog.hide();    
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          $("#numeroFirmaEnvioAentidad").val(NumEmpModalBaja);
          $("#ContraseniaFirmaEnvioAEntidad").val(contraseniaInsertadaCifrada);
          $("#modalFirmaElectronicaParaEntidad").modal("hide");
          $("#NumEmpModalFirmaParaEntidad").val("");
          $("#constraseniaFirmaParaEntidad").val("");
          if(banderaModalFirma=="1"){
            ActualizarEnvioTarjetasParaentidad();
          }else{
            ActualizarEnvioTarjetasParaMatriz();
          }
        }
         
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cancelarFirmaParaEnvioDeTarjetaParaEntidad(){
  $("#modalFirmaElectronicaParaEntidad").modal("hide");
  $("#NumEmpModalFirmaParaEntidad").val("");
  $("#constraseniaFirmaParaEntidad").val("");
}

function cargaerroresFirmaInternaEnvioTarjetaAEntidad(mensaje){
  $('#errorModalFirmaInternaParaEntidad').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaParaEntidad1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaParaEntidad").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaParaEntidad').delay(4000).fadeOut('slow'); 
}


