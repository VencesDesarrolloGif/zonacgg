$('#inpFechaRecep').datetimepicker({   
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
  });

$("#selectTipoRecepcion").change(function(){
  $("#divTablaRecepcionExterna").hide();
  $("#btnRegistrarRecepcion").hide();
  var tipoRecepcion=$("#selectTipoRecepcion").val();

  if(tipoRecepcion=='1'){//de alguna matriz gif
     waitingDialog.show();
    cargarMatrizReceptora();
    $("#divTablaRecepcionExterna").hide();
    $("#divRecepcionTarjetasInternaParaMatrizR").hide();
  }else if (tipoRecepcion=='2'){//externa
     waitingDialog.show();
     consultaUsuarioMAtriz();
     $("#divRecepcionTarjetasInternas").hide();
     $("#divRecepcionTarjetasInternaParaMatrizR").hide();
  }else if (tipoRecepcion=='3'){//Recpecion A Matriz
     $("#divRecepcionTarjetasInternas").hide();
     $("#divTablaRecepcionExterna").hide();
     obtenerTotalTarjetasDisponiblesParaRecibirAMatrizR();

  }else if (tipoRecepcion=='0'){//externa
      limpiarCampos();
      bloquearCampos();
  }
});


/////////////////////////// Funciones Para Recibir a Una Matriz ///////////////////////////////////////////////////////////////////
function obtenerTotalTarjetasDisponiblesParaRecibirAMatrizR(){
    deseleccionar_TarjetasDespensaPorEntidadParaMatrizR();
    deseleccionar_checksAdicionalesGeneral();
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "recepcionTarjetas/ajax_obtenerTotalTarjetasDisponiblesARecibirParaMatrizR.php",
        dataType: "json",
        success: function(response) {
          $("#divRecepcionTarjetasInternaParaMatrizR").show();
          var DuenioMatriz = response.opcion;
          var responsematriz = response.matriz;
          if(DuenioMatriz == "0"){
            var TotalTarjetasDisponiblesParaMatrizR = response.datos.length;
            var datosTarjetasDisponiblesParaMatrizR = response.datos;
            $("#txtTotalTarjetasARecibirMatrizR").val(TotalTarjetasDisponiblesParaMatrizR);
            $("#txtEntidadDeRecepcionParaMatrizR").val(responsematriz);
            if(TotalTarjetasDisponiblesParaMatrizR != "0"){
                $('#divTarjetasDisponiblesParaRecibirPorMatrizR').html(""); 
                var listaTarjetasDisponiblesParaMatrizR="<form id='checkTarjetasDisponiblesParaRecibirPorMatrizR'>";
                listaTarjetasDisponiblesParaMatrizR="<table class='table table-hover' id='tablaTarjetsDisponiblesParaRecibirPorMatrizR'><thead><th>Número Pedido</th><th>Iut Tarjeta</th><th>Nombre Entidad Envio</th><th>Fecha Envio</th></thead><tbody>";
                if (datosTarjetasDisponiblesParaMatrizR.length > 0)
                {
                    listaTarjetasDisponiblesParaMatrizR+="<br/>";
                    listaTarjetasDisponiblesParaMatrizR+="<a href='javascript:seleccionar_TarjetasDespensaPorEntidadParaMatrizR()'>Marcar todos</a>";
                    listaTarjetasDisponiblesParaMatrizR+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                    listaTarjetasDisponiblesParaMatrizR+="<a href='javascript:deseleccionar_TarjetasDespensaPorEntidadParaMatrizR()'>Marcar ninguno</a>";
                    listaTarjetasDisponiblesParaMatrizR+="<br/>";
                    for ( var i = 0; i < datosTarjetasDisponiblesParaMatrizR.length; i++ )
                    {
                        var  IdTarjetaDespensa= datosTarjetasDisponiblesParaMatrizR[i].IdTarjetaDespensa;
                        var  NumeroPedido= datosTarjetasDisponiblesParaMatrizR[i].NumeroPedido;
                        var  idIutTarjeta= datosTarjetasDisponiblesParaMatrizR[i].idIutTarjeta;
                        var  FechaASignacionentidad= datosTarjetasDisponiblesParaMatrizR[i].FechaEnvioAMatriz;
                        var  nombreEntidadmatriz= datosTarjetasDisponiblesParaMatrizR[i].nombreEntidadFederativa;

                        listaTarjetasDisponiblesParaMatrizR += "<tr><td>"+NumeroPedido+"</td><td>"+idIutTarjeta+"</td><td>"+nombreEntidadmatriz+"</td><td>"+FechaASignacionentidad+"</td>";
                        listaTarjetasDisponiblesParaMatrizR += "<td><input type='checkbox' style='width: 25px; height: 25px' id=RadioTarjeta  name="+idIutTarjeta+" value='"+IdTarjetaDespensa+"'></td><tr> ";
                    }
                    listaTarjetasDisponiblesParaMatrizR += "</tbody></table>";
                    listaTarjetasDisponiblesParaMatrizR+="<button id='btnGardarRecepcionTarjetasMatrizR' type='button' class='btn btn-secondary' onclick='aplicarRecepcionParaMatrizR();'><span class='glyphicon glyphicon-ok'></span>Recibir Tarjetas</button></form>";
                    $('#divTarjetasDisponiblesParaRecibirPorMatrizR').html(listaTarjetasDisponiblesParaMatrizR); 
                }else{
                    $('#divTarjetasDisponiblesParaRecibirPorMatrizR').html("<div><h1>No se encontraron tarjetas disponibles</h1></div>"); 
                }
                $("#MensajeSinTarjetasDisponiblesParaMatrizR").hide();
                $("#DivListaTarjetasDisponiblesParaMatrizR").show();
            }else{
                $("#MensajeSinTarjetasDisponiblesParaMatrizR").show();
                $("#DivListaTarjetasDisponiblesParaMatrizR").hide();
            }
          }else{
            $("#MensajeSinPermisosNecesariosParaMatrizR").show();
            $("#MensajeSinTarjetasDisponiblesParaMatrizR").hide();
            $("#DivListaTarjetasDisponiblesParaMatrizR").hide();
          }

            waitingDialog.hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
            waitingDialog.hide();
        }
    });
 }
function seleccionar_TarjetasDespensaPorEntidadParaMatrizR(){ 
   for (i=0;i<document.form_TarjetasParaRecepcionarTarjetasMatrizR.elements.length;i++) 
      if(document.form_TarjetasParaRecepcionarTarjetasMatrizR.elements[i].type == "checkbox")  
         document.form_TarjetasParaRecepcionarTarjetasMatrizR.elements[i].checked=1 
} 

 function deseleccionar_TarjetasDespensaPorEntidadParaMatrizR(){ 
   for (i=0;i<document.form_TarjetasParaRecepcionarTarjetasMatrizR.elements.length;i++) 
      if(document.form_TarjetasParaRecepcionarTarjetasMatrizR.elements[i].type == "checkbox")  
         document.form_TarjetasParaRecepcionarTarjetasMatrizR.elements[i].checked=0 
}

function aplicarRecepcionParaMatrizR(){
  var tarjetasSeleccionadasPParaMatrizR = $("input[type=checkbox]:checked");
  if(tarjetasSeleccionadasPParaMatrizR.length<"1"){
      alert("No Se Ha Seleccionado Ninguna Tarjeta Favor De Marcar Las Tarjetas A Enviar");
  }else{
      $("#NoEmpModalFirmaRecepcionTarjetas").val("");
      $("#constraseniaFirmaRecepcionTarjetas").val("");
      $("#modalFirmaElectronicaRecepcionTarjetas").modal();
  }
}

function ActualizarRecepcionTarjetasParaMatrizR(){
    var tarjetasSeleccionadasMatrizR = $("input[type=checkbox]:checked");
    var NumEmpModalFirmaParaEntidad = $("#NumeroFirmaTarjetasMatrizRHidden").val();
    var constraseniaFirmaParaEntidad = $("#ContraseniaFirmaTarjetasMatrizRHidden").val();
    waitingDialog.show();
    for (var i = 0; i < tarjetasSeleccionadasMatrizR.length; i++)
    {
        if (tarjetasSeleccionadasMatrizR[i].checked == true)
        {
            var IdTarjetaDespensa = tarjetasSeleccionadasMatrizR[i].value;
            $.ajax({
                type: "POST",
                url: "recepcionTarjetas/ajax_ActualizarRecepcionDeTarjetasMatrizR.php",
                data:{"IdTarjetaDespensa":IdTarjetaDespensa,"NumEmpModalFirmaParaEntidad":NumEmpModalFirmaParaEntidad,"constraseniaFirmaParaEntidad":constraseniaFirmaParaEntidad},
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
    }
    obtenerTotalTarjetasDisponiblesParaRecibirAMatrizR();
    waitingDialog.hide(); 
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////// Funciones Para Recibir A Una Entidad ///////////////////////////////////////////




function cargarMatrizReceptora(){
  deseleccionar_TarjetasDespensaPorEntidadParaRecibir();
  deseleccionar_checksAdicionalesGeneral();
  $("#DivListaTarjetasDisponiblesParaMatriz").hide();
  $.ajax({            
      type:"POST",
      url: "recepcionTarjetas/ajax_consultaMatriz.php",
      dataType: "json",
      success: function(response) {
        var datos = response.datos;
        var Largodatos = response.datos.length;
        $('#SelectEntidadDeRecepcion').empty().append('<option value="0" selected="selected">Entidades</option>');
        $.each(datos, function(i) {
            $('#SelectEntidadDeRecepcion').append('<option value="' + response.datos[i].IdEntidadAsignada+'">' + response.datos[i].nombreEntidadAsignada + '</option>');
        });
        $("#divRecepcionTarjetasInternas").show(); 
        waitingDialog.hide();     
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
          waitingDialog.hide();     
      }
    }); 
}

$("#SelectEntidadDeRecepcion").change(function(){
    //deseleccionar_TarjetasDespensaPorEntidadParaRecibir();
    //deseleccionar_checksAdicionalesGeneral();
    var EntidadABuscar = $("#SelectEntidadDeRecepcion").val();
    obtenerTotalTarjetasDisponiblesEnCadaEntidadParaRecibir(EntidadABuscar);

});
function deseleccionar_TarjetasDespensaPorEntidadParaRecibir(){ 
   for (i=0;i<document.form_TarjetasParaRecepcionarTarjetasInternas1.elements.length;i++) 
      if(document.form_TarjetasParaRecepcionarTarjetasInternas1.elements[i].type == "checkbox")  
         document.form_TarjetasParaRecepcionarTarjetasInternas1.elements[i].checked=0 
}

function seleccionar_TarjetasDespensaPorEntidadParaRecibir(){ 
   for (i=0;i<document.form_TarjetasParaRecepcionarTarjetasInternas1.elements.length;i++) 
      if(document.form_TarjetasParaRecepcionarTarjetasInternas1.elements[i].type == "checkbox")  
         document.form_TarjetasParaRecepcionarTarjetasInternas1.elements[i].checked=1 
} 
function deseleccionar_checksAdicionalesGeneral(){// Se creo debido a que interferia en este modulo lo schecks de otros modulos  
    var largochecks = $("input[type=checkbox]:checked");
   for (i=0;i<largochecks.length;i++) 
      if(largochecks[i].type == "checkbox")  
         largochecks[i].checked=0 
}

function obtenerTotalTarjetasDisponiblesEnCadaEntidadParaRecibir(EntidadABuscar){
    waitingDialog.show();
    $.ajax({
        type: "POST",
        url: "recepcionTarjetas/ajax_obtenerTotalTarjetasDisponiblesLaEntidadParaRecibir.php",
        data:{'EntidadABuscar': EntidadABuscar},
        dataType: "json",
        success: function(response) {
            console.log(response);
            var TotalTarjetasDisponiblesParaREcepcion = response.datos.length;
            var datosTarjetasDisponiblesParaREcepcion = response.datos;
            $("#txtTotalTarjetasARecibirEntidad").val(TotalTarjetasDisponiblesParaREcepcion);
            if(TotalTarjetasDisponiblesParaREcepcion != "0"){
                $('#divTarjetasDisponiblesParaRecibirPorEntidad').html(""); 
                var listaTarjetasDisponiblesParaREcepcion="<form id='checkTarjetasDisponiblesParaREcibirPorEntidad'>";
                listaTarjetasDisponiblesParaREcepcion="<table class='table table-hover' id='tablaTarjetsDisponiblesParaRecibirPorEnti'><thead><th>Número Pedido</th><th>Iut Tarjeta</th><th>Nombre Matriz</th><th>Fecha Envio</th></thead><tbody>";
                if (datosTarjetasDisponiblesParaREcepcion.length > 0)
                {
                    listaTarjetasDisponiblesParaREcepcion+="<br/>";
                    listaTarjetasDisponiblesParaREcepcion+="<a href='javascript:seleccionar_TarjetasDespensaPorEntidadParaRecibir()'>Marcar todos</a>";
                    listaTarjetasDisponiblesParaREcepcion+="<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
                    listaTarjetasDisponiblesParaREcepcion+="<a href='javascript:deseleccionar_TarjetasDespensaPorEntidadParaRecibir()'>Marcar ninguno</a>";
                    listaTarjetasDisponiblesParaREcepcion+="<br/>";
                    for ( var i = 0; i < datosTarjetasDisponiblesParaREcepcion.length; i++ )
                    {
                        var  IdTarjetaDespensa= datosTarjetasDisponiblesParaREcepcion[i].IdTarjetaDespensa;
                        var  NumeroPedido= datosTarjetasDisponiblesParaREcepcion[i].NumeroPedido;
                        var  idIutTarjeta= datosTarjetasDisponiblesParaREcepcion[i].idIutTarjeta;
                        var  FechaASignacionentidad= datosTarjetasDisponiblesParaREcepcion[i].FechaASignacionentidad;
                        var  nombreEntidadmatriz= datosTarjetasDisponiblesParaREcepcion[i].nombreEntidadmatriz;

                        listaTarjetasDisponiblesParaREcepcion += "<tr><td>"+NumeroPedido+"</td><td>"+idIutTarjeta+"</td><td>"+nombreEntidadmatriz+"</td><td>"+FechaASignacionentidad+"</td>";
                        listaTarjetasDisponiblesParaREcepcion += "<td><input type='checkbox' style='width: 25px; height: 25px' id=RadioTarjeta  name="+idIutTarjeta+" value='"+IdTarjetaDespensa+"'></td><tr> ";
                    }
                    listaTarjetasDisponiblesParaREcepcion += "</tbody></table>";
                    listaTarjetasDisponiblesParaREcepcion+="<button id='btnGardarRecepcionTarjetas' type='button' class='btn btn-secondary' onclick='aplicarRecepcionPorEntidad();'><span class='glyphicon glyphicon-ok'></span>Recibir Tarjetas</button></form>";
                    $('#divTarjetasDisponiblesParaRecibirPorEntidad').html(listaTarjetasDisponiblesParaREcepcion); 
                }else{
                    $('#divTarjetasDisponiblesParaRecibirPorEntidad').html("<div><h1>No se encontraron tarjetas disponibles</h1></div>"); 
                }
                $("#MensajeSinTarjetasDisponiblesParaRecepcion").hide();
                $("#DivListaTarjetasDisponiblesParaMatriz").show();
            }else{
                $("#MensajeSinTarjetasDisponiblesParaRecepcion").show();
                $("#DivListaTarjetasDisponiblesParaMatriz").hide();
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

 function aplicarRecepcionPorEntidad(){
  var entidadAEnviar = $("#SelectEntidadTransferir").val();
  var tarjetasSeleccionadas = $("input[type=checkbox]:checked");
  if(tarjetasSeleccionadas.length<"1"){
      alert("No Se Ha Seleccionado Ninguna Tarjeta Favor De Marcar Las Tarjetas A Enviar");
  }else{
      $("#NoEmpModalFirmaRecepcionTarjetas").val("");
      $("#constraseniaFirmaRecepcionTarjetas").val("");
      $("#modalFirmaElectronicaRecepcionTarjetas").modal();
  }
}

function ActualizarRecepcionTarjetasParaEntidad(){
    var tarjetasSeleccionadas = $("input[type=checkbox]:checked");
    var NumEmpModalFirmaParaEntidad = $("#NumeroFirmaEnvioTarjetasHidden").val();
    var constraseniaFirmaParaEntidad = $("#ContraseniaFirmaEnvioTarjetasHidden").val();
    waitingDialog.show();
    for (var i = 0; i < tarjetasSeleccionadas.length; i++)
    {
        if (tarjetasSeleccionadas[i].checked == true)
        {
            var IdTarjetaDespensa = tarjetasSeleccionadas[i].value;
            $.ajax({
                type: "POST",
                url: "recepcionTarjetas/ajax_ActualizarRecepcionDeTarjetasPorEntidad.php",
                data:{"IdTarjetaDespensa":IdTarjetaDespensa,"NumEmpModalFirmaParaEntidad":NumEmpModalFirmaParaEntidad,"constraseniaFirmaParaEntidad":constraseniaFirmaParaEntidad},
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
    }
    cargarMatrizReceptora();
    waitingDialog.hide(); 
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////// Funciones Para Cargar Tarjetas nuevas //////////////////////////////////////////////////////////////////////////////////
function consultaTarjetasSinAsignar(idMatriz){
  
  $.ajax({            
      type:"POST",
      url: "recepcionTarjetas/ajax_consultaTarjetasSinAsignar.php",
      data: {"noMatriz": idMatriz},
      dataType: "json",
      success: function(response){
        if(response.status=="success"){
              waitingDialog.hide();
               $("#divTablaRecepcionExterna").show();
              
        }else if(response.status=="error"){
                 var mensaje=response.mensaje;
                cargarmensajeRecepcionTarjeta(mensaje);
                waitingDialog.hide();
        }                 
      },
      error:function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText); 
            waitingDialog.hide();
      }
  });
}


function consultaUsuarioMAtriz(){
  
  $.ajax({            
      type:"POST",
      url: "recepcionTarjetas/ajax_consultaUsuarioMatriz.php",
      dataType: "json",
      success: function(response){
        if(response.status=="success"){
          var datos=response.datos;
          if(datos.length!=0) {
          var idMatriz=datos[0]["IdMatriz"];
            $("#selectMatrizRecepcion").empty();
            $('#selectMatrizRecepcion').append('<option value="0">SELECCIONAR</option>');
            $('#selectMatrizRecepcion').append('<option value="' + datos[0].IdMatriz + '">' +datos[0].nombreEntidadmatriz + '</option>');
            consultaTarjetasSinAsignar(idMatriz);
          }else{
                var mensaje="NO CUENTA CON LOS PERMISOS PARA RECIBIR TARJETAS";
                cargarmensajeRecepcionTarjeta(mensaje);
                waitingDialog.hide();
          }
        }else if(response.status=="error"){
                 waitingDialog.hide(); 
        }                 
      },
      error:function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText); 
            waitingDialog.hide();
      }
  });
}

$("#selectMatrizRecepcion").change(function(){

  var matriz=$("#selectMatrizRecepcion").val();

  if(matriz=='0'){
     bloquearCampos();
     $("#btnRegistrarRecepcion").hide();
  }else{
        desBloquearCampos();
        $("#btnRegistrarRecepcion").show();
       }
});

$("#btnRegistrarRecepcion").click(function(){

  var pedido = $("#txtNoPedido").val();
  var matrizRecepcion = $("#selectMatrizRecepcion").val();
  var fechaRecep = $("#inpFechaRecep").val();
  var documentoDePedido = $("#documentoDePedido").val();
  var excelTarjetas = $("#excelTarjetas").val();

  var fechaHoy = new Date();
  var dia = fechaHoy.getDate();
  var mes = fechaHoy.getMonth() +1;

  if(mes=='1' || mes=='2' || mes=='3' || mes=='4' || mes=='5' || mes=='6' || mes=='7' || mes=='8' || mes=='9'){
    mes="0"+mes;
  }
  if(dia=='1' || dia=='2' || dia=='3' || dia=='4' || dia=='5' || dia=='6' || dia=='7' || dia=='8' || dia=='9'){
    dia="0"+dia;
  }

  var fechaactual=(fechaHoy.getFullYear() + "-" + mes + "-" + dia);

  if(matrizRecepcion==0){
     var mensaje="Selecciona una matriz";
     cargarmensajeRecepcionTarjeta(mensaje);
     return;
  }
  
  if(pedido=='' || pedido==null || pedido=="null" || pedido=="NULL"){
     var mensaje="Indique el numero de pedido";
     cargarmensajeRecepcionTarjeta(mensaje);
     return;
  }
  
  if(fechaRecep=='' || fechaRecep=='null'){
     var mensaje="Indique por favor la fecha en que se reciben las tajetas";
     cargarmensajeRecepcionTarjeta(mensaje);
     return;
  }
  
  if(fechaRecep > fechaactual){
     var mensaje="La fecha de recepcion no puede ser mayor a la fecha actual";
     cargarmensajeRecepcionTarjeta(mensaje);
     return;
  }
  
  if(documentoDePedido==""){
     var mensaje="Por favor Cargue el documento de pedido";
     cargarmensajeRecepcionTarjeta(mensaje);
     return;
  }
  
  if(excelTarjetas==""){
     var mensaje="Por favor Cargue el documento excel";
     cargarmensajeRecepcionTarjeta(mensaje);
     return;
  }

  var file = $("#excelTarjetas")[0].files[0];      
  var fileName = file.name;//obtenemos el nombre del archivo
  fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);//obtenemos la extensión del archivo
  var fileSize = file.size;//obtenemos el tamaño del archivo
  var fileType = file.type;//obtenemos el tipo de archivo image/png ejemplo

  var fileDP = $("#documentoDePedido")[0].files[0];      
  var fileNameDP = fileDP.name;//obtenemos el nombre del archivo
  fileExtensionDP = fileNameDP.substring(fileNameDP.lastIndexOf('.') + 1);//obtenemos la extensión del archivo
  var fileSizeDP = fileDP.size;//obtenemos el tamaño del archivo
  var fileTypeDP = fileDP.type;//obtenemos el tipo de archivo image/png ejemplo

  var formData = new FormData($("#form_cargarTarjetas")[0]);
  
  if(!isDocument(fileExtension)){
     var mensaje="El archivo cargado en el documento excel tarjetas, NO es EXCEL por favor cargue el archivo correcto";
     cargarmensajeRecepcionTarjeta(mensaje);              
     return;                  
  }
  if(!isDocumentDP(fileExtensionDP)){
     var mensaje="El formato Documento de pedido es incorrecto, Por favor Cargue un archivo permitido(jpg,png,pdf)";
     cargarmensajeRecepcionTarjeta(mensaje);              
     return;                  
  }
            $("#modalFirmaElectronicaRecepcionTarjetas").modal();
});

function isDocument(extension){
  
  switch(extension.toLowerCase()){
         case 'xlsx':
         return true;
         break;        
         default:
         return false;
         break;
    }
}

function isDocumentDP(extension){

    switch(extension.toLowerCase()){
           case 'jpg':
           return true;
           break;
           case 'JPG':
           return true;
           break;
           case 'PNG':
           return true;
           break;
           case 'png':
           return true;
           break;
           case 'pdf':
           return true;
           break;     
           default:
           return false;
           break;
    }
} 

$("#NoEmpModalFirmaRecepcionTarjetas").keyup(function (){
  var NumEmpModalRT = $("#NoEmpModalFirmaRecepcionTarjetas").val();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
  if(expreg.test(NumEmpModalRT) || expreg1.test(NumEmpModalRT)){
    consultaEmpleadoFirmaInternaRT(NumEmpModalRT);
  }else{
    $("#constraseniaFirmaRecepcionTarjetas").val("");
    $("#btnFirmarRecepcionTarjetas").hide();
  }
});

function consultaEmpleadoFirmaInternaRT(numeroEmpleado){
  $.ajax({
    type: "POST",
    url: "recepcionTarjetas/ajax_obtenerEmpXIdFirmaTarjetas.php",
    data:{"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerrorModalRT("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NoEmpModalFirmaRecepcionTarjetas").val("");
          $("#btnFirmarRecepcionTarjetas").hide();
        }else{
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerrorModalRT("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH"); 
            $("#NoEmpModalFirmaRecepcionTarjetas").val("");
            $("#btnFirmarRecepcionTarjetas").hide();
          }else{
            $("#btnFirmarRecepcionTarjetas").show();
          }
        }
      }else{
        cargaerrorModalRT("error ajax_obtenerEmpXIdFirmaTarjetas"); 
        $("#NoEmpModalFirmaRecepcionTarjetas").val("");
        $("#btnFirmarRecepcionTarjetas").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}

function revisarFirmaRecepcionTarjeta(){

  var noEmpFirma =$("#NoEmpModalFirmaRecepcionTarjetas").val();
  var pwdEmpFirma=$("#constraseniaFirmaRecepcionTarjetas").val();
 
  if(noEmpFirma==""){
    cargaerrorModalRT("Ingrese un numero de empleado");
  }else if(pwdEmpFirma==""){
           cargaerrorModalRT("Escriba la contraseña para continuar");
  }else{
     $.ajax({
            type: "POST",
            url: "recepcionTarjetas/ajax_RevisarFirmaEmpleado.php",
            data: {"noEmpFirma":noEmpFirma,"pwdEmpFirma":pwdEmpFirma},
            dataType: "json",
            success: function(response) {
              if(response.status == "success"){
                  var RespuestaLargo = response["datos"].length;
                  if(RespuestaLargo == "0"){
                     cargaerrorModalRT("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingresó en el registro");
                  }else{
                        $("#modalFirmaElectronicaRecepcionTarjetas").modal("hide");
                        waitingDialog.show();
                        var BanderaRedireccionAFunciones = $("#selectTipoRecepcion").val();
                        var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
                        var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
                        if(BanderaRedireccionAFunciones == "1"){
                          $("#NumeroFirmaEnvioTarjetasHidden").val(noEmpFirma);
                          $("#ContraseniaFirmaEnvioTarjetasHidden").val(contraseniaInsertadaCifrada);
                          ActualizarRecepcionTarjetasParaEntidad();
                        }else if(BanderaRedireccionAFunciones == "2"){
                          registrarRecepcion();
                        }else if(BanderaRedireccionAFunciones == "3"){
                          $("#NumeroFirmaTarjetasMatrizRHidden").val(noEmpFirma);
                          $("#ContraseniaFirmaTarjetasMatrizRHidden").val(contraseniaInsertadaCifrada);
                          ActualizarRecepcionTarjetasParaMatrizR();
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

function registrarRecepcion(){
    waitingDialog.show();
  var noEmpleado=$("#NoEmpModalFirmaRecepcionTarjetas").val();
  var firmaEmpleado=$("#constraseniaFirmaRecepcionTarjetas").val();
  var pedido=$("#txtNoPedido").val();
  var matrizRecepcion=$("#selectMatrizRecepcion").val();
  var fechaRecep  =$("#inpFechaRecep").val();
  var documentoDePedido = $("#documentoDePedido").val();
  var excelTarjetas = $("#excelTarjetas").val();

  var formData = new FormData($("#form_cargarTarjetas")[0]);
  formData.append('noEmpleado', noEmpleado);
  formData.append('firmaEmpleado', firmaEmpleado);
 
  $.ajax({
          url: 'recepcionTarjetas/upload_RecepcionTarjetas.php',//borrar todo  
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          success: function(response){
           insertarTarjetas(pedido,matrizRecepcion);
          },
          error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                  waitingDialog.hide();
          }
        });
  }

function insertarTarjetas(pedido,matrizRecepcion){
  $.ajax({            
          type:"POST",
          url: "recepcionTarjetas/ajax_insertarTarjetas.php",
          data: {"noPedido": pedido,"matriz": matrizRecepcion},
          dataType: "json",
          success: function(response){
            var mensajeIns=response.mensaje;
            if(response.status=="success"){
                waitingDialog.hide();
               cargarmensajeRecepcionTarjetaSuccess(mensajeIns);
               $("#modalFirmaElectronicaRecepcionTarjetas").modal("hide");
               limpiarCampos();
               bloquearCampos();
               $("#NoEmpModalFirmaRecepcionTarjetas").val("");
               $("#constraseniaFirmaRecepcionTarjetas").val("");
            }else if(response.status=="error"){
                waitingDialog.hide();
                cargarmensajeRecepcionTarjeta(mensajeIns);
                $("#modalFirmaElectronicaRecepcionTarjetas").modal("hide");
                $("#NoEmpModalFirmaRecepcionTarjetas").val("");
                $("#constraseniaFirmaRecepcionTarjetas").val("");
                eliminarPedidoCreado(mensajeIns);     
            }                 
          },
          error: function(jqXHR, textStatus, errorThrown){
                var mensajeIns="error en insert";
                eliminarPedidoCreado();     
                $("#modalFirmaElectronicaRecepcionTarjetas").modal("hide");
                $("#NoEmpModalFirmaRecepcionTarjetas").val("");
                $("#constraseniaFirmaRecepcionTarjetas").val("");
                // alert(jqXHR.responseText);
                waitingDialog.hide(); 
          }
  });
}

function eliminarPedidoCreado(){
    var pedido=$("#txtNoPedido").val();
  $.ajax({            
          type:"POST",
          url: "recepcionTarjetas/ajax_EliminarPedido.php",
          data: {pedido},
          dataType: "json",
          success: function(response){
            if(response.status=="success"){
                 var mensaje="Error al insertar datos del documento excel, por favor verifique que el documento cumpla con los requerimientos";
                cargarmensajeRecepcionTarjeta(mensaje);
            }else if (response.status=="error"){
                 var mensaje=response.mensaje;
                 cargarmensajeRecepcionTarjeta(mensaje);
            }                 
          },
          error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText); 
          }
  });
}

function cargarmensajeRecepcionTarjetaSuccess(mensaje){
  $('#divMensajeRecepcionTarjeta').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-success'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeRecepcionTarjeta").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajeRecepcionTarjeta').delay(3000).fadeOut('slow');
}

function cargarmensajeRecepcionTarjeta(mensaje){
  $('#divMensajeRecepcionTarjeta').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-error'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeRecepcionTarjeta").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajeRecepcionTarjeta').delay(3000).fadeOut('slow');
}

function cargaerrorModalRT(mensaje){
  $('#errorModalFirmaRecepcionTarjetas').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaRecepcionTarjetas' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaRecepcionTarjetas").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaRecepcionTarjetas').delay(4000).fadeOut('slow'); 
}  

function desBloquearCampos(){
  $("#txtNoPedido").prop("disabled", false);
  $("#inpFechaRecep").prop("disabled", false);
  $("#documentoDePedido").prop("disabled", false);
  $("#excelTarjetas").prop("disabled", false);
  $("#btnRegistrarRecepcion").prop("disabled", false);
}

function bloquearCampos(){
  $("#txtNoPedido").prop("disabled", true);
  $("#inpFechaRecep").prop("disabled", true);
  $("#documentoDePedido").prop("disabled", true);
  $("#excelTarjetas").prop("disabled", true);
}

function limpiarCampos(){
  $("#txtNoPedido").val("");      
  $("#inpFechaRecep").val("");
  $("#documentoDePedido").val('');
  $("#excelTarjetas").val('');
  $("#selectMatrizRecepcion").val(0);
  $("#selectTipoRecepcion").val(0);
}

function cancelarFirmaRecepcionTarjetas(){
    $("#modalFirmaElectronicaRecepcionTarjetas").modal("hide");
    $("#NoEmpModalFirmaRecepcionTarjetas").val("");
    $("#constraseniaFirmaRecepcionTarjetas").val("");
}