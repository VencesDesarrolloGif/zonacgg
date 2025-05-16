 $(llenaselempresa()); 

 function llenaselempresa() {
     $.ajax({
         type: "POST",
         url: "../empresa/ajax_llenaselectoresempregsuc.php",
         data:{
             idempresa: 0,
             IdRegistroPatronal: 0,
             idsucursal: 0,
             accion: 0
         },
         dataType: "json",
         success: function(response) {
             datos = response.datos;
             $('#selempresa').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
             $('#selenuevompresa').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
             $.each(datos, function(i) {
                 $('#selempresa').append('<option value="' + response.datos[i].idEmpresa + '">' + response.datos[i].razonSocial + '</option>');
                 $('#selenuevompresa').append('<option value="' + response.datos[i].idEmpresa + '">' + response.datos[i].razonSocial + '</option>');
             });
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 $("#selempresa").change(function() {
     $("#divBotonesTP").hide();
     $("#msjSinTarjetas").hide();
     var idempresa = $("#selempresa").val();
     $("#datos").empty();
     $('#inpacteconomicasuc').val("");
     $('#inpcallenumeroycolsuc').val("");
     $('#inpcodigopostalsuc').val("");
     $('#inpentidadsuc').val("");
     $('#inppoblacionmunicipiosuc').val("");
     $('#inptelefonosuc').val("");
     $('#seldelimsssuc').empty();
     $('#selsubdelegacionimsssuc').empty();
     $('#selmesiniciomodafisuc').empty();
     $('#selanioiniciomodafisuc').empty();
     $('#selregpatronal').empty();
     $('#selsucursal').empty();
     $('#selareageosuc').empty();
     $("#datos").empty();
     $('#inpnombrepatronoresponsable').val("");
     $('#selclaseriegodetrab').empty();
     $('#selfraccionriegodetrab').empty();
     $('#inpprimainiciomodafisuc').val("");
     $("#imagenagregar").hide();
     $("#selectoresparaagregarprima").hide();
     $("#btnguardarprima").hide();
     limpiaerrores();
     if ($('#selempresa').val() != '0') {
         $.ajax({
             type: "POST",
             url: "../empresa/ajax_llenaselectoresempregsuc.php",
             data: {
                 idempresa: idempresa,
                 IdRegistroPatronal: 0,
                 idsucursal: 0,
                 accion: 1
             },
             dataType: "json",
             success: function(response) {
                 // console.log(response);
                 //datos = response.datos;
                 datosfiscales = response.datosfiscales;
                 //parallenar los datos fiscales
                 $('#selregpatronal').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $.each(datosfiscales, function(i) {
                     //SE LLENAN LOS DATOS DEL FORM EMPRESA DATOS FISCALES
                     $('#inprazonsocialempresa').val(response.datosfiscales[i].razonSocial);
                     $('#inpcoloniaempresa').val(response.datosfiscales[i].coloniaEmpresa);
                     $('#inpcalleempresa').val(response.datosfiscales[i].calleEmpresa);
                     $('#inpnuminteriorempresa').val(response.datosfiscales[i].numInteriorEmpresa);
                     $('#inpnumexteriorempresa').val(response.datosfiscales[i].numExteriorEmpresa);
                     $('#inpdelmunempresa').val(response.datosfiscales[i].delegacionMuEmpresa);
                     $('#inptelefonoempresa').val(response.datosfiscales[i].telefonoEmpresa);
                     $('#inpcodigopostal').val(response.datosfiscales[i].codPostalEmpresa);
                     $('#inprepresentantelegal').val(response.datosfiscales[i].nombreRLEmpresa + " " + response.datosfiscales[i].apPaternoRLEmpresa + " " + response.datosfiscales[i].apMaternoRLEmpresa);
                     $('#inprfc').val(response.datosfiscales[i].rfc);
                     if (response.datosfiscales[i].idcatalogoRegistrosPatronales == null) {
                         $('#selregpatronal').empty().append('<option value="0" selected="selected">-No existe registro patronal asociado-</option>');
                     } else {
                         $('#selregpatronal').append('<option value="' + response.datosfiscales[i].idcatalogoRegistrosPatronales + '">' + response.datosfiscales[i].idcatalogoRegistrosPatronales + '</option>');
                     }
                 });
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 });

$("#selregpatronal").change(function(){

     $("#msjSinTarjetas").hide();
     var idempresa = $("#selempresa").val();
     var idregistropatronal = $("#selregpatronal").val();
     $('#selsucursal').empty();
     $("#datos").empty();
     $('#inpacteconomicasuc').val("");
     $('#inpcallenumeroycolsuc').val("");
     $('#inpcodigopostalsuc').val("");
     $('#inpentidadsuc').val("");
     $('#inppoblacionmunicipiosuc').val("");
     $('#inptelefonosuc').val("");
     $('#seldelimsssuc').empty();
     $('#selsubdelegacionimsssuc').empty();
     $('#selmesiniciomodafisuc').empty();
     $('#selanioiniciomodafisuc').empty();
     limpiaerrores();
     $('#selareageosuc').empty();
     $("#datos").empty();
     $('#inpnombrepatronoresponsable').val("");
     $('#selclaseriegodetrab').empty();
     $('#selfraccionriegodetrab').empty();
     $('#selmesfraccionriesgodetrab').empty();
     $('#selaniofraccionriesgodetrab').empty();
     $('#inpprimainiciomodafisuc').val("");
     $("#imagenagregar").hide();
     $("#selectoresparaagregarprima").hide();
     $("#btnguardarprima").hide();

     if($('#selregpatronal').val() != '0'){
         $.ajax({
             type: "POST",
             url: "../empresa/ajax_llenaselectoresempregsuc.php",
             data:{
                 idempresa: idempresa,
                 IdRegistroPatronal: idregistropatronal,
                 idsucursal: 0,
                 accion: 2
             },
             dataType: "json",
             success: function(response){
                 datos = response.datos;
                 $('#selsucursal').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $.each(datos, function(i){
                     $('#selsucursal').append('<option value="' + response.datos[i].IdSuc + '">' + response.datos[i].descripcionSucursal + '</option>');
                 });
             },
             error: function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText);
             }
         });
     }
     traerCatalogoTarjetasPatronales();
     $("#divBotonesTP").show();
 });
 $("#selsucursal").change(function() {
     var idempresa = $("#selempresa").val();
     var idregistropatronal = $("#selregpatronal").val();
     var idsucursal = $("#selsucursal").val();
     $("#datos").empty();
     if (idsucursal == 0) {
         $('#inpacteconomicasuc').val("");
         $('#inpcallenumeroycolsuc').val("");
         $('#inpcodigopostalsuc').val("");
         $('#inpentidadsuc').val("");
         $('#inppoblacionmunicipiosuc').val("");
         $('#inptelefonosuc').val("");
         $('#seldelimsssuc').empty();
         $('#selsubdelegacionimsssuc').empty();
         $('#selmesiniciomodafisuc').empty();
         $('#selanioiniciomodafisuc').empty();
         $('#selareageosuc').empty();
         $("#datos").empty();
         $('#inpnombrepatronoresponsable').val("");
         $('#selclaseriegodetrab').empty();
         $('#selfraccionriegodetrab').empty();
         $('#selmesfraccionriesgodetrab').empty();
         $('#selaniofraccionriesgodetrab').empty();
         $('#inpprimainiciomodafisuc').val("");
         $("#imagenagregar").hide();
         $("#selectoresparaagregarprima").hide();
         $("#btnguardarprima").hide();
         limpiaerrores();
     } else {
         $.ajax({
             type: "POST",
             url: "../empresa/ajax_llenaselectoresempregsuc.php",
             data: {
                 idempresa: idempresa,
                 IdRegistroPatronal: idregistropatronal,
                 idsucursal: idsucursal,
                 accion: 3
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 datos = response.datos;
                 datosparaselectores = response.datosparaselectoresfrmsucursal;
                 datosparaselectoresfraccionyclase = response.datosselectoresfraccionyclase;
                 var mes = "";
                 $.each(datosparaselectoresfraccionyclase, function(i) {
                     //este array sirve solo para llenar el input de entidad y los selectores  dependientes
                     $('#selclaseriegodetrab').empty().append('<option value="' + response.datosselectoresfraccionyclase[i].idRiesgo + '">' + response.datosselectoresfraccionyclase[i].PrimaMedia + " " + response.datosselectoresfraccionyclase[i].TipoRiesgo + '</option>');
                     $('#selfraccionriegodetrab').empty().append('<option value="' + response.datosselectoresfraccionyclase[i].idFraccion + '">' + response.datosselectoresfraccionyclase[i].idFraccion + "-" + response.datosselectoresfraccionyclase[i].Descripcion + '</option>');
                 });
                 $.each(datosparaselectores, function(i) {
                     //este array sirve solo para llenar el input de entidad y los selectores  dependientes
                     $("#inpentidadsuc").val(response.datosparaselectoresfrmsucursal[i].idEstado + " " + response.datosparaselectoresfrmsucursal[i].nombreEntidadFederativa);
                 });
                 $.each(datos, function(i) {
                     $("#inpacteconomicasuc").val(response.datos[i].ActividadEconomica);
                     $("#inpcallenumeroycolsuc").val(response.datos[i].CalleNumero);
                     $("#inpcodigopostalsuc").val(response.datos[i].CodigoPostal);
                     $('#inppoblacionmunicipiosuc').empty().append('<option value="' + response.datos[i].PoblacionMunicipio + '">' + response.datos[i].PoblacionMunicipio + '</option>'); ///verificar si al guardar sera la descripcion o el id 
                     $("#inptelefonosuc").val(response.datos[i].Telefono);
                     $('#seldelimsssuc').empty().append('<option value="' + response.datos[i].DelegacionImss + '">' + response.datos[i].DelegacionImss + '</option>');
                     $('#selsubdelegacionimsssuc').empty().append('<option value="' + response.datos[i].SubdelegacionImss + '">' + response.datos[i].SubdelegacionImss + '</option>');
                     $('#selareageosuc').empty().append('<option value="' + response.datos[i].AreaGeografica + '">' + response.datos[i].AreaGeografica + '</option>');
                     if (response.datos[i].Mes == "01") {
                         mes = "ENERO";
                     } else if (response.datos[i].Mes == "02") {
                         mes = "FEBRERO";
                     } else if (response.datos[i].Mes == "03") {
                         mes = "MARZO";
                     } else if (response.datos[i].Mes == "04") {
                         mes = "ABRIL";
                     } else if (response.datos[i].Mes == "05") {
                         mes = "MAYO";
                     } else if (response.datos[i].Mes == "06") {
                         mes = "JUNIO";
                     } else if (response.datos[i].Mes == "07") {
                         mes = "JULIO";
                     } else if (response.datos[i].Mes == "08") {
                         mes = "AGOSTO";
                     } else if (response.datos[i].Mes == "09") {
                         mes = "SEPTIEMBRE";
                     } else if (response.datos[i].Mes == "10") {
                         mes = "OCTUBRE";
                     } else if (response.datos[i].Mes == "11") {
                         mes = "NOVIEMBRE";
                     } else if (response.datos[i].Mes == "12") {
                         mes = "DICIEMBRE";
                     }
                     $('#selmesiniciomodafisuc').empty().append('<option value="' + mes + '">' + mes + '</option>');
                     $('#selanioiniciomodafisuc').empty().append('<option value="' + response.datos[i].Anio + '">' + response.datos[i].Anio + '</option>');
                     $("#inpnombrepatronoresponsable").val(response.datos[i].nombreResponsable);
                     llenarselectoresprimariesgo(idregistropatronal, "");
                 });
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 });

 function llenarselectoresprimariesgo(IdRegistroPatronal, mensaje) {
     limpiaerrores();
     if (mensaje !== "") {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Con Éxito </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $(document).scrollTop(0);
     }
     $.ajax({
         type: "POST",
         url: "../empresa/ajax_llenaselectoresempregsuc.php",
         data: {
             idempresa: 0,
             IdRegistroPatronal: IdRegistroPatronal,
             idsucursal: 0,
             accion: 4
         },
         dataType: "json",
         success: function(response) {
             datos = response.datostblfraccionprimariesgo;
             $("#datos").empty();
             var mes = "";
             var tabla = "<table id='tabla' class='table table-bordered'><thead><th>Año</th><th>Mes</th><th>Prima</th></thead><tbody>";
             $.each(datos, function(i) {
                 tabla += "<tr><td ><input id='inpanioprimar" + i + "' type='text' readonly='true' value='" + response.datostblfraccionprimariesgo[i].anioPrimaR + "'></td>";
                 if (response.datostblfraccionprimariesgo[i].mesPrimaR == "01") {
                     mes = "ENERO";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "02") {
                     mes = "FEBRERO";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "03") {
                     mes = "MARZO";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "04") {
                     mes = "ABRIL";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "05") {
                     mes = "MAYO";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "06") {
                     mes = "JUNIO";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "07") {
                     mes = "JULIO";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "08") {
                     mes = "AGOSTO";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "09") {
                     mes = "SEPTIEMBRE";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "10") {
                     mes = "OCTUBRE";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "11") {
                     mes = "NOVIEMBRE";
                 } else if (response.datostblfraccionprimariesgo[i].mesPrimaR == "12") {
                     mes = "DICIEMBRE";
                 }
                 tabla += "<td><input id='inpmesprimar" + i + "' type='text' readonly='true' value='" + mes + "'></td>";
                 tabla += "<td><input  id='inpcantprimariesgo" + i + "' type='text' readonly='true' value='" + response.datostblfraccionprimariesgo[i].cantPrimaRiesgo + "'></td>";
             });
             $("#datos").append(tabla);
             $("#imagenagregar").show();
             $("#selectoresparaagregarprima").hide();
             $("#btnguardarprima").hide();
             $("#inpprimainiciomodafisuc").val("");
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

 function agregarprima() {
     limpiaerrores();
     $("#selectoresparaagregarprima").show("slow");
     $("#btnguardarprima").show("slow");
     cargarmeses();
     cargaranios();
 }

 function guardarprima() {
     limpiaerrores();
     var selmes = $("#selmesfraccionriesgodetrab").val();
     var selanio = $("#selaniofraccionriesgodetrab").val();
     var prima = $("#inpprimainiciomodafisuc").val();
     var registropatronal = $("#selregpatronal").val();
     if (selmes === "0") {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Mes</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selmesfraccionriesgodetrab").css('border', '#D0021B 1px solid'); //para marcar el campo en rojo
         $(document).scrollTop(0);
     } else if (selanio === "0") {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Año</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selaniofraccionriesgodetrab").css('border', '#D0021B 1px solid'); //para marcar el campo en rojo
         $(document).scrollTop(0);
     } else if (prima === "" || !/^([0-9]*\.?[0-9])*$/.test(prima)) {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Debe ingresar prima de riesgo</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpprimainiciomodafisuc").css('border', '#D0021B 1px solid'); //para marcar el campo en rojo
         $(document).scrollTop(0);
     } else {
         $.ajax({
             type: "POST",
             url: "../empresa/ajax_newRiesgotrabajo.php",
             data: {
                 mesriesgo: selmes,
                 anioriesgo: selanio,
                 primariesgo: prima,
                 registropatronal: registropatronal
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 llenarselectoresprimariesgo(registropatronal, "exito");
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }

 function cargaranios() {
     $('#selaniofraccionriesgodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selaniofraccionriesgodetrab"); //llenar con js un selector de fechas
     for (var i = n; i >= 1990; i--) {
         select.options.add(new Option(i, i));
     }
 }

 function cargarmeses() {
     var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
     var values = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
     $('#selmesfraccionriesgodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     for (var i in meses) {
         $('#selmesfraccionriesgodetrab').append('<option value="' + values[i] + '">' + meses[i] + '</option>');
     }
 }

 function limpiaerrores() {
     $("#errorMsj").html("");
     $("#selaniofraccionriesgodetrab").removeAttr("style");
     $("#selmesfraccionriesgodetrab").removeAttr("style");
     $("#inpprimainiciomodafisuc").removeAttr("style");
 }

 //-----------------------------TARJETAS PATRONALES------------------------------------------------------------------------------------------------------

function traerCatalogoTarjetasPatronales(){
    $("#divErrorTarjetaPatronal").html("");
    $("#datosTarjetaPatronal").html("");
    $("#btneditarTarjetaPatronal").prop("disabled", false);
    $("#btnguardarTarjetaPatronal").prop("disabled", true);
    $("#btnagregarTarjetaPatronal").prop('disabled', false);
    var registroPatronalActual = $("#selregpatronal").val();


    $.ajax({
        type: "POST",
        url: "ajax_ConsultaTarjetasPatronales.php",
        data: {registroPatronalActual},
        dataType: "json",
        success: function(response) {
         if(response.status == "success"){
            if(response.datos.length!=0){
              var mensaje= response.message;
              var datos  = response.datos;
              $("#datosTarjetaPatronal").empty();
              var tabla  = "<table id='tabla' class='table table-bordered'><thead> <th>No</th> <th>Registro Patronal</th> <th>Fecha Expedición </th> <th>Fecha termino de vigencia</th> <th>Tarjeta Patronal</th> <th>Editar</th> <th>Eliminar</th> </thead><tbody>";
              $(document).scrollTop(0);
              $.each(datos, function(i){
                  var idTP= datos[i].idTarjetasPatronales;

               tabla += "<tr><td><input class='form-control' id='inpidTarjetasPatronales" + idTP + "' type='text' readonly='true' value='" + datos[i].idTarjetasPatronales + "'>    <input id='inpidTarjetasPatronalesHidden" + idTP + "' type='hidden' value='" + datos[i].idTarjetasPatronales + "'></td>";                        
               
               tabla += "<td><input class='form-control' id='inpregistroPatronalTarjeta" + idTP + "' type='text' readonly='true' value='" + datos[i].registroPatronalTarjeta + "'>   <input id='inpregistroPatronalTarjetaHidden"   + idTP + "' type='hidden'  value='" + datos[i].registroPatronalTarjeta + "'></td>";
               
               tabla += "<td><input class='form-control' id='inpfechaExpedicionIn" + idTP + "' type='text' readonly='true' value='" + datos[i].fechaExpedicion+"'><input id='inpfechaExpedicionHidden"+ idTP + "' type='hidden'  value='" + datos[i].fechaExpedicion +"'></td>";

               tabla += "<td><input class='form-control' id='inpfechaFinVigenciaIn" + idTP + "' type='text' readonly='true' value='" + datos[i].fechaFinVigencia+"'><input id='inpfechaFinVigenciaHidden"+ idTP + "' type='hidden'  value='" + datos[i].fechaFinVigencia +"'></td>";

               tabla += "<td><img style='width: 17%' title='abrir' src='../img/pdf.png' class='cursorImg' id='btnabrirTarjetaPatronal' onclick=generarPDFTarjetaPatronal('"+ datos[i].nombreDocumento +"')></td>";

               tabla += "<td><img style='width: 40px' title='Editar' src='../img/editarLapiz.jpg' class='cursorImg' id='btneditarTarjetaPatronal' onclick=editarTarjetaPatronal('"+ idTP +"')></td>";

               tabla += "<td><img style='width: 25%' title='Eliminar' src='../img/eliminar.png' class='cursorImg' id='btneliminarTarjetaPatronal' onclick=EliminarTarjetaPatronalbtn('"+ idTP +"')></td>";
              });                
            $("#datosTarjetaPatronal").append(tabla);
            }else{
            $("#msjSinTarjetas").show();
            }
            $("#ModalTarjetaPatronal").modal("hide");
            $("#procesandoTarjetaPatronal").hide();
         }else{
             var mensaje = response.message;
         }
        },error:function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });
}

function generarPDFTarjetaPatronal(nombreDocumento){ 
    // alert(nombreDocumento);
     window.open("../../vista/uploads/TarjetaPatronal/"+nombreDocumento+"",'fullscreen=no');
}

function cargarRegistrosPatronales(){
    var idempresa = $("#selempresa").val();
    var registroPatronalActual = $("#selregpatronal").val();
    $.ajax({
            type: "POST",
            url: "ajax_ConsultaRegistrosPatronalesXempresa.php",
            data: {idempresa},
            dataType: "json",
            success: function(response) {
            $("#selRegistroPatronal").empty(); 
            $('#selRegistroPatronal').append('<option value="0">Registro Patronal</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){
               $('#selRegistroPatronal').append('<option value="' + (response.datos[i].idcatalogoRegistrosPatronales) + '">' + response.datos[i].idcatalogoRegistrosPatronales + '</option>');
              }
              $("#selRegistroPatronal").val(registroPatronalActual);
          }else{
                alert("Error Al Cargar Las Entidades");
               }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
}

// ELIMINAR

function EliminarTarjetaPatronalbtn(id){
    var idTP = $("#inpidTarjetasPatronalesHidden" + id).val();
    $("#ModalTarjetaPatronal").modal("show"); 
    $("#procesandoTarjetaPatronal").show(); 
    $.ajax({
         type: "POST",
         url: 'ajax_EliminarTarjetaPatronal.php',
         data: {idTP},
         dataType: "json",
         success: function(response){ 
            if(response.status == "success"){
             $("#ModalTarjetaPatronal").modal("hide");
             $("#procesandoTarjetaPatronal").hide();
             $("#divMSGTarjetaPatronal").html("");
             $("#divMSGTarjetaPatronal").fadeIn();
             traerCatalogoTarjetasPatronales();
             var mensajeElim = response.mensaje;
             alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
             $("#divMSGTarjetaPatronal").html(alertMsg1); 
             $("#divMSGTarjetaPatronal").delay('4000').fadeOut('slow');         
            }else{
             var mensajeElim = response.mensaje;
             alert(mensajeElim);
             alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
             $("#divMSGTarjetaPatronal").html(alertMsg1); 
             $("#divMSGTarjetaPatronal").delay('4000').fadeOut('slow');
             $("#divMSGTarjetaPatronal").html("");
             $("#procesandoTarjetaPatronal").hide();
             $("#ModalTarjetaPatronal").modal("hide");
             $("#divMSGTarjetaPatronal").fadeIn();
            }
         },error:function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
     });
}


// ************************************************************

//EDITAR

function editarTarjetaPatronal(id){
    cargarRegistrosPatronales();
    var fechaExpedicionActual = $("#inpfechaExpedicionIn" + id).val();
    var fechaFinVigenciaActual= $("#inpfechaFinVigenciaIn" + id).val();
    $("#selectFechaExpedicion").val(fechaExpedicionActual);
    $("#selectFechaFinVigencia").val(fechaFinVigenciaActual);
    $("#idTarjetaPatronalHidden").val(id);
    $("#documentoCargadoTarjetaPatronal").val("");
    $("#modalEditarTarjetaPatronal").modal("show");
}

function verificarVigencia(){
    $("#procesandoTarjetaPatronal").show();
    var fechaExpedicion = $("#selectFechaExpedicion").val();
    var fechaVigenciaFin= $("#selectFechaFinVigencia").val();
    var idTPEdit = $("#idTarjetaPatronalHidden").val();
    var registroPatronal= $("#selRegistroPatronal").val();
    // var existe=true;
    if(fechaExpedicion > fechaVigenciaFin) {
          alert("la fecha no puede ser mayor a la vigencia");
          return;
        }
        else if(fechaExpedicion == fechaVigenciaFin) {
          alert("las fechas no pueden ser iguales");
          return;
        }

    $.ajax({
            type: "POST",
            url: 'ajax_ConsultaVigenciaTP.php',
            data: {fechaExpedicion,idTPEdit,fechaVigenciaFin,registroPatronal},
            dataType: "json",
            success: function(response){ 
                if(response.status == "success"){
                   // si no hay activa una tarjeta patronal en esas fechas ;
                   guardarEdicionTP(1);
                }else if(response.status == "error"){
                        // var existe = true;
                        var idTarjetaActiva= response["idTarjetaActiva"];
                        $("#idTarjetaActivaHidden").val(idTarjetaActiva);
                        $("#modalEditarTarjetaPatronal").modal("hide");
                        $("#modalTarjetaPatronalExistente").modal();
                }
            },error:function(jqXHR, textStatus, errorThrown){
                    alert(jqXHR.responseText);
                }
    });
}

function continuarModalExistente(){

    var comentario = $("#comentarioEdicion").val();

    if(comentario==''){
       alert("Ingrese el motivo del cambio de tarjeta patronal");
       return;
    }else{
      guardarEdicionTP(2);
    }
}

function guardarEdicionTP(valor){
    var fechaExpedicion = $("#selectFechaExpedicion").val();
    var fechaFinVigencia= $("#selectFechaFinVigencia").val();
    var registroPatronal= $("#selRegistroPatronal").val();
    var idTPEdit = $("#idTarjetaPatronalHidden").val();
    var tipoEdicion= valor;
    var formData = new FormData($("#archivoEditTarjetaPatronal")[0]);
    var documentoCargadoTarjetaPatronal = $("#documentoCargadoTarjetaPatronal").val();
    var caso='0';

    if(tipoEdicion=='2'){
       var comentario = $("#comentarioEdicion").val();
       var idTarjetaActiva = $("#idTarjetaActivaHidden").val();
       formData.append('comentario',comentario);
       formData.append('idTarjetaActiva',idTarjetaActiva);
    }

    if(documentoCargadoTarjetaPatronal!= "") {
     var caso='1';
    }
        formData.append('fechaExpedicion',fechaExpedicion);
        formData.append('fechaFinVigencia',fechaFinVigencia);
        formData.append('registroPatronal',registroPatronal);
        formData.append('idTPEdit',idTPEdit);
        formData.append('caso',caso);
        formData.append('tipoEdicion',tipoEdicion);

        $.ajax({
              type: "POST",
              url: 'ajax_EditarTarjetaPatronal.php',
              data: formData,
              dataType: "json",
              cache: false,
              contentType: false,
              processData: false,
              success: function(response){ modalEditarTarjetaPatronal
                 if(response.status == "success"){
                    $("#divMSGTarjetaPatronal").html("");
                    $("#procesandoTarjetaPatronal").hide();
                    $("#modalTarjetaPatronalExistente").modal("hide");
                    $("#modalEditarTarjetaPatronal").modal("hide");
                    $("#divMSGTarjetaPatronal").fadeIn();
                    traerCatalogoTarjetasPatronales();
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+response.mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#divMSGTarjetaPatronal").html(alertMsg1); 
                    $("#divMSGTarjetaPatronal").delay('4000').fadeOut('slow');
                 }else{
                       alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+response.mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#divMSGTarjetaPatronal").html(alertMsg1); 
                       $("#divMSGTarjetaPatronal").delay('4000').fadeOut('slow');
                       $("#divMSGTarjetaPatronal").html("");
                       $("#procesandoTarjetaPatronal").hide();
                       $("#modalEditarTarjetaPatronal").modal("hide");
                       $("#divMSGTarjetaPatronal").fadeIn();
                 }
             },error:function(jqXHR, textStatus, errorThrown){
                     alert(jqXHR.responseText);
                 }
        });
}

//AGREGAR TARJETA PATRONAL
function agregarTarjetaPatronal(){
    $("#selectFechaExpedicionAdd").val("");
    $("#selectFechaFinVigenciaAdd").val("");
    $("#documentoCargadoTarjetaPatronalAdd").val("");
    $("#modalAgregarTarjetaPatronal").modal("show");
}

function verificarVigenciaAdd(){//AQUIIIIIIA
    $("#procesandoTarjetaPatronal").show();
    var fechaExpedicionAdd = $("#selectFechaExpedicionAdd").val();
    var fechaVigenciaAdd = $("#selectFechaFinVigenciaAdd").val();
    var registroPatronal = $("#selregpatronal").val();
    var documentoCargadoTarjetaPatronalAdd = $("#documentoCargadoTarjetaPatronalAdd").val();

    if(fechaExpedicionAdd > fechaVigenciaAdd) {
      alert("la fecha no puede ser mayor a la vigencia");
      return;
    }
    else if(fechaExpedicionAdd == fechaVigenciaAdd) {
      alert("las fechas no pueden ser iguales");
      return;
    }else if(documentoCargadoTarjetaPatronalAdd== "") {
      alert("cargue un documento (PDF,JPEG,PNG)");
      return;
    }

    $.ajax({
            type: "POST",
            url: 'ajax_ConsultaVigenciaTPadd.php',
            data: {fechaExpedicionAdd,fechaVigenciaAdd,registroPatronal},
            dataType: "json",
            success: function(response){ 
            if(response.status == "success"){
               guardarTPAdd(1);
            }else if(response.status == "error"){
                    var idTarjetaActivaAdd= response["idTarjetaActiva"];
                    $("#idTarjetaActivaHidden").val(idTarjetaActivaAdd);
                    $("#modalAgregarTarjetaPatronal").modal("hide");
                    $("#modalTarjetaPatronalExistenteAdd").modal();
            }
            },error:function(jqXHR, textStatus, errorThrown){
                    alert(jqXHR.responseText);
                }
        });
}

function guardarTPAdd(caso){
    
    var fechaExpedicionAdd= $("#selectFechaExpedicionAdd").val();
    var fechaVigenciaAdd  = $("#selectFechaFinVigenciaAdd").val();
    var registroPatronal  = $("#selregpatronal").val();
    var idTarjetaActiva   = $("#idTarjetaActivaHidden").val();
    var formData = new FormData($("#archivoAddTarjetaPatronal")[0]);
    var documentoCargadoTarjetaPatronalAdd = $("#documentoCargadoTarjetaPatronalAdd").val();

    formData.append('FechaExpedicionAdd',fechaExpedicionAdd);
    formData.append('FechaFinVigenciaAdd',fechaVigenciaAdd);
    formData.append('registroPatronal',registroPatronal);
    formData.append('idTarjetaActiva',idTarjetaActiva);
    formData.append('caso',caso);

    if(caso=='2'){
        var comentario = $("#comentarioAdd").val();
        if(comentario==''){
           alert("Ingrese el motivo del cambio de tarjeta patronal");
           return;
        }else{
          formData.append('comentario',comentario);
        }
    }

    $.ajax({
         type: "POST",
         url: 'ajax_insertarTarjetaPatronal.php',
         data: formData,
         dataType: "json",
         cache: false,
         contentType: false,
         processData: false,
         async:false, 
         success: function(response){ 
            if(response.status == "success"){
               $("#divMSGTarjetaPatronal").html("");
               $("#procesandoTarjetaPatronal").hide();
               $("#modalAgregarTarjetaPatronal").modal("hide");
               $("#modalTarjetaPatronalExistenteAdd").modal("hide");
               $("#divMSGTarjetaPatronal").fadeIn();
               traerCatalogoTarjetasPatronales();
               var mensajeElim = response.mensaje;
               alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#divMSGTarjetaPatronal").html(alertMsg1); 
               $("#divMSGTarjetaPatronal").delay('4000').fadeOut('slow'); 
               $("#msjSinTarjetas").hide();
            }else{
                  var mensajeElim = response.mensaje;
                  alert(mensajeElim);
                  alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>"+mensajeElim+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#divMSGTarjetaPatronal").html(alertMsg1); 
                  $("#divMSGTarjetaPatronal").delay('4000').fadeOut('slow');
                  $("#divMSGTarjetaPatronal").html("");
                  $("#procesandoTarjetaPatronal").hide();
                  $("#modalAgregarTarjetaPatronal").modal("hide");
                  $("#modalTarjetaPatronalExistenteAdd").modal("hide");
                  $("#divMSGTarjetaPatronal").fadeIn();
            }
        },error:function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
            }
     });
}

function cerrarModalEdicionExistente(){
    $("#modalTarjetaPatronalExistente").modal("hide");
}

function cerrarModalEdicionExistenteAdd(){
    $("#modalTarjetaPatronalExistenteAdd").modal("hide");
}



