$(inicioNvoRegPat());  
// $(llenaselempresa());  
function inicioNvoRegPat(){
    consultarEntidadesRP();
     // $("#frmnuevasucursal").submit(function(e) {
         //Detengo el comportamiento normal del evento submit.
         // e.preventDefault();
         // guardarfrmnuevoregistropatronall();
     // });
     llenaselempresa();
}
var entCompletasIDSelector = [];
var entCompletasNameSelector = [];

var municipiosCompletosIDSelector = [];
var municipiosCompletosNameSelector = [];

 function llenaselempresa() {
     $.ajax({
         type: "POST",
         url: "../empresa/ajax_llenaselectoresempregsuc.php",
         data: {
             idempresa: 0,
             IdRegistroPatronal: 0,
             idsucursal: 0,
             accion: 0
         },
         dataType: "json",
         success: function(response) {
             //console.log(response);
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
 $("#selenuevompresa").change(function() {
     $("#errorMsj").html("");
 });

 function consultaentidadydelegacionesimssfrmnuevasucursal() {
     var cp = $("#inpnuevocodigopostalsuc").val();
     limpiaerrores();
     if (cp == "" || !/^([0-9]{5})*$/.test(cp)) {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Codigo Postal Valido </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpnuevocodigopostalsuc").css('border', '#D0021B 1px solid');
         $("#inpnuevoentidadsuc").val("");
         $("#selnuevodelimsssuc").empty();
         $("#selnuevosubdelegacionimsssuc").empty();
         $(document).scrollTop(0);
     } else {
         $("#errorMsj").html("");
         $.ajax({
             type: "POST",
             url: "../empresa/ajax_llenaselectoreentidadcolnuevaempresa.php",
             data: {
                 cp: cp,
                 accion: 2,
             },
             dataType: "json",
             success: function(response) {
                 datos = response.datos;
                 datosdelegacionysubimss = response.datossubdelegacionimss;
                 $('#selnuevosubdelegacionimsssuc').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $.each(datosdelegacionysubimss, function(i) {
                     $('#selnuevosubdelegacionimsssuc').append('<option value="' + response.datossubdelegacionimss[i].descripcionSubdelegacion + '">' + response.datossubdelegacionimss[i].descripcionSubdelegacion + '</option>'); //verificar que rollo con esto
                 });
                 $('#inpnuevopoblacionmunicipiosuc').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $('#selnuevodelimsssuc').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $.each(datos, function(i) {
                     $('#inpnuevoentidadsuc').val(response.datos[i].idEntidadFederativa + " " + response.datos[i].nombreEntidadFederativa);
                     $('#hdnnuevoentidadsuc').val(response.datos[i].idEntidadFederativa);
                     $('#inpnuevopoblacionmunicipiosuc').append('<option value="' + response.datos[i].nombreAsentamiento + '">' + response.datos[i].nombreAsentamiento + '</option>'); //verificar que rollo con esto
                 });
                 if (datos == 0) {
                     var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Codigo Postal No Valido </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#errorMsj").html(Msgerror);
                     $("#inpnuevocodigopostalsuc").css('border', '#D0021B 1px solid');
                     $("#inpnuevoentidadsuc").val("");
                     $(document).scrollTop(0);
                 } else {
                     $('#selnuevodelimsssuc').append('<option value="' + response.datos[0].nombreEntidadFederativa + '">' + response.datos[0].nombreEntidadFederativa + '</option>'); //verificar que rollo con esto
                     cargaranios(); //FUNCION QUE LLENA LOS SELECTORES DINAMICAMENTE DESDE JS
                     cargarmeses(); //FUNCION QUE LLENA LOS SELECTORES DINAMICAMENTE DESDE JS
                     cargaareas(); //FUNCION QUE LLENA LOS SELECTORES DINAMICAMENTE DESDE JS
                     llenaselclase();
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }
 //PARA LLENAR LOS SELECTORES DE AÑOS MES INICIO DE AFILIACION/////////////////////////////////////////////////////////
 function cargaranios() {
     $('#selnuevoanioiniciomodafisuc').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     $('#selnuevoaniofraccionriesgodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selnuevoanioiniciomodafisuc"); //llenar con js un selector de años
     var select2 = document.getElementById("selnuevoaniofraccionriesgodetrab"); //llenar con js un selector de fechas
     for (var i = n; i >= 1990; i--) {
         select.options.add(new Option(i, i));
         select2.options.add(new Option(i, i));
     }
 }

 function cargarmeses() {
     var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
     var values = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
     $('#selnuevomesiniciomodafisuc').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     $('#selnuevomesfraccionriesgodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     for (var i in meses) {
         $('#selnuevomesfraccionriesgodetrab').append('<option value="' + values[i] + '">' + meses[i] + '</option>');
         $('#selnuevomesiniciomodafisuc').append('<option value="' + values[i] + '">' + meses[i] + '</option>'); //verificar que rollo con esto
         // document.getElementById("selnuevomesiniciomodafisuc").innerHTML += "<option value='" + array[i] + "'>" + array[i] + "</option>"; //llenar con js un selector apartir de un arreglo
     }
 }

 function cargaareas() {
     var areas = ["Area A ", "Area B", "Area C"];
     $('#selnuevoareageosuc').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     for (var i in areas) {
         $('#selnuevoareageosuc').append('<option value="' + areas[i] + '">' + areas[i] + '</option>'); //verificar que rollo con esto
         // document.getElementById("selnuevomesiniciomodafisuc").innerHTML += "<option value='" + array[i] + "'>" + array[i] + "</option>"; //llenar con js un selector apartir de un arreglo
     }
 }

 function llenaselclase() {
     $.ajax({
         type: "POST",
         url: "../empresa/ajax_llenaselectoresnuevoclaseyfraccionregpatronal.php",
         data: {
             accion: 0,
             idriesgo: 0
         },
         dataType: "json",
         success: function(response) {
             //console.log(response);
             datos = response.datos;
             $('#selnuevoclaseriegodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
             $.each(datos, function(i) {
                 $('#selnuevoclaseriegodetrab').append('<option value="' + response.datos[i].idRiesgo + '">' + response.datos[i].PrimaMedia + " " + response.datos[i].TipoRiesgo + '</option>'); //verificar que rollo con esto
             });
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }
 $('#selnuevoclaseriegodetrab').change(function() {
     var idriesgo = $("#selnuevoclaseriegodetrab").val();
     $.ajax({
         type: "POST",
         url: "../empresa/ajax_llenaselectoresnuevoclaseyfraccionregpatronal.php",
         data: {
             accion: 1,
             idriesgo: idriesgo
         },
         dataType: "json",
         success: function(response) {
             //console.log(response);
             datos = response.datosriesgo;
             $('#selnuevofraccionriegodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
             $.each(datos, function(i) {
                 $('#selnuevofraccionriegodetrab').append('<option value="' + response.datosriesgo[i].idFraccion + '">' + response.datosriesgo[i].idFraccion + " - " + response.datosriesgo[i].Descripcion + '</option>'); //verificar que rollo con esto
             });
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 });
 $('#btnguardafrmsucursal').click(function() {
    guardarfrmnuevoregistropatronall();
 });
 function guardarfrmnuevoregistropatronall() {

    if(tblEntSeleccionadasID.length==0 && tblMunicipiosSeleccionadosID.length==0){
       var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>SELECCIONA LAS ENTIDADES Y MUNICIPIOS A LAS QUE PERTENECERÁ ESTE REGISTRO PATRONAL</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
       $("#errorMsj").html(Msgerror);
       $(document).scrollTop(0);
       return;
    }

    // meter la validacion que elija al menos un municipio o entidad para continuar
     var selenuevompresa = $("#selenuevompresa").val();
     var selnuevopoblacionmunicipiosuc = $("#inpnuevopoblacionmunicipiosuc").val();
     var selnuevodelimsssuc = $("#selnuevodelimsssuc").val();
     var selnuevosubdelegacionimsssuc = $("#selnuevosubdelegacionimsssuc").val();
     var selnuevoareageosuc = $("#selnuevoareageosuc").val();
     var selnuevomesiniciomodafisuc = $("#selnuevomesiniciomodafisuc").val();
     var selnuevoanioiniciomodafisuc = $("#selnuevoanioiniciomodafisuc").val();
     var selnuevomesfraccionriesgodetrab = $("#selnuevomesfraccionriesgodetrab").val();
     var selnuevoaniofraccionriesgodetrab = $("#selnuevoaniofraccionriesgodetrab").val();
     var selnuevoclaseriegodetrab = $("#selnuevoclaseriegodetrab").val();
     var selnuevofraccionriegodetrab = $("#selnuevofraccionriegodetrab").val();
     var cp = $("#inpnuevocodigopostalsuc").val();
     // var data = $("#frmnuevasucursal").serialize();
     limpiaerrores();
     if (selenuevompresa == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Empresa </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selenuevompresa").css('border', '#D0021B 1px solid'); //para marcar el campo en rojo
         $(document).scrollTop(0);
     } else if (cp == "" || !/^([0-9]{5})*$/.test(cp)) {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Codigo Postal Valido </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpnuevocodigopostalsuc").css('border', '#D0021B 1px solid');
         $("#inpnuevoentidadsuc").val("");
         $("#selnuevodelimsssuc").empty();
         $("#selnuevosubdelegacionimsssuc").empty();
         $(document).scrollTop(0);
     } else if (selnuevopoblacionmunicipiosuc == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Poblacion y Municipio/Delegacion </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpnuevopoblacionmunicipiosuc").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevodelimsssuc == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Delegacion Imss </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevodelimsssuc").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevosubdelegacionimsssuc == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Subdelegacion Imss </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevosubdelegacionimsssuc").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevoareageosuc == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Area Geografica </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevoareageosuc").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevomesiniciomodafisuc == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Mes de Inicio del Modulo de Afiliacion </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevomesiniciomodafisuc").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevoanioiniciomodafisuc == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Año de Inicio del Modulo de Afiliacion </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevoanioiniciomodafisuc").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevomesfraccionriesgodetrab == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Mes </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevomesfraccionriesgodetrab").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevoaniofraccionriesgodetrab == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Año </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevoaniofraccionriesgodetrab").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevoclaseriegodetrab == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Clase </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevoclaseriegodetrab").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (selnuevofraccionriegodetrab == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Fracción </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#selnuevofraccionriegodetrab").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else {

        var hdnnuevoentidadsuc= $("#hdnnuevoentidadsuc").val();
        var inpnuevoregpatronal= $("#inpnuevoregpatronal").val();
        var inpnuevosucursal= $("#inpnuevosucursal").val();
        var inpnuevoacteconomicasuc= $("#inpnuevoacteconomicasuc").val();
        var inpnuevocallenumeroycolsuc= $("#inpnuevocallenumeroycolsuc").val();
        var inpnuevotelefonosuc= $("#inpnuevotelefonosuc").val();
        var inpnuevonombrepatronoresponsable= $("#inpnuevonombrepatronoresponsable").val();
        var inpnuevoprimainiciomodafisuc= $("#inpnuevoprimainiciomodafisuc").val();

        if(tblEntSeleccionadasID.length==0){
            tblEntSeleccionadasID="SIN INFORMACION";
        }
            
        if(tblMunicipiosSeleccionadosID.length==0){
            tblMunicipiosSeleccionadosID="SIN INFORMACION";
        }


         $.ajax({
             type: "POST",
             url: "../nuevoregpatronal/ajax_guardanuevoregpatronalysuc.php",
             data: {selenuevompresa:selenuevompresa,
                    selnuevopoblacionmunicipiosuc:selnuevopoblacionmunicipiosuc,
                    selnuevodelimsssuc:selnuevodelimsssuc,
                    selnuevosubdelegacionimsssuc:selnuevosubdelegacionimsssuc,
                    selnuevoareageosuc:selnuevoareageosuc,
                    selnuevomesiniciomodafisuc:selnuevomesiniciomodafisuc,
                    selnuevoanioiniciomodafisuc:selnuevoanioiniciomodafisuc,
                    selnuevomesfraccionriesgodetrab:selnuevomesfraccionriesgodetrab,
                    selnuevoaniofraccionriesgodetrab:selnuevoaniofraccionriesgodetrab,
                    selnuevoclaseriegodetrab:selnuevoclaseriegodetrab,
                    selnuevofraccionriegodetrab:selnuevofraccionriegodetrab,
                    cp:cp,
                    hdnnuevoentidadsuc:hdnnuevoentidadsuc,
                    inpnuevoregpatronal:inpnuevoregpatronal,
                    inpnuevosucursal:inpnuevosucursal,
                    inpnuevoacteconomicasuc:inpnuevoacteconomicasuc,
                    inpnuevocallenumeroycolsuc:inpnuevocallenumeroycolsuc,
                    inpnuevotelefonosuc:inpnuevotelefonosuc,
                    inpnuevonombrepatronoresponsable:inpnuevonombrepatronoresponsable,
                    inpnuevoprimainiciomodafisuc:inpnuevoprimainiciomodafisuc,
                    tblEntSeleccionadasID:tblEntSeleccionadasID,
                    tblMunicipiosSeleccionadosID:tblMunicipiosSeleccionadosID
             },
             dataType: "json",
             success: function(response) {
                 var mensaje = response.status;
                 if (mensaje == "existereg") {
                     var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ya Existe Registro Patronal</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#errorMsj").html(Msgerror);
                     $(document).scrollTop(0);
                     $("#radioEntidad").prop("checked", false);
                     $("#radioMunicipio").prop("checked", false);
                     // $("#errorMsj").html("");
                     limpiaerrores();
                 } else {
                     limpiaerrores();
                     var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Registro Patronal Guardado Con Éxito </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#errorMsj").html(Msgerror);
                     $('#errorMsj').delay(3000).fadeOut('slow');
                     $(document).scrollTop(0);
                     $('#frmnuevasucursal').trigger("reset"); //reset el form con jquery
                     $("#inpcolonianuevaempresa").empty();
                     $("#inpdelmunnuevaempresa").empty();
                     $("#inpnuevopoblacionmunicipiosuc").empty();
                     $("#selnuevodelimsssuc").empty();
                     $("#selnuevosubdelegacionimsssuc").empty();
                     $("#selnuevoareageosuc").empty();
                     $("#selnuevomesiniciomodafisuc").empty();
                     $("#selnuevoanioiniciomodafisuc").empty();
                     $("#selnuevomesfraccionriesgodetrab").empty();
                     $("#selnuevoaniofraccionriesgodetrab").empty();
                     $("#selnuevoclaseriegodetrab").empty();
                     $("#selnuevofraccionriegodetrab").empty();
                     consultarEntidadesRP();
                     $("#radioEntidad").val(0);
                     $("#radioMunicipio").val(0);
                     $("#divTablaEntidadesAsignadas").hide();
                     $("#divTablaMunicipiosAsignados").hide();
                     $("#divMunicipio").hide();
                     $("#btnAgregarEntidad").hide();
                     $("#btnAgregarMunicipio").hide();
                     // waitingDialog.hide();
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }

 function limpiaerrores() {
     $("#errorMsj").html("");
     $("#inpcodigopostalnuevoempresa").removeAttr("style");
     $("#inpnuevocodigopostalsuc").removeAttr("style");
     $("#selenuevompresa").removeAttr("style");
     $("#inpnuevopoblacionmunicipiosuc").removeAttr("style");
     $("#selnuevodelimsssuc").removeAttr("style");
     $("#selnuevosubdelegacionimsssuc").removeAttr("style");
     $("#selnuevoareageosuc").removeAttr("style");
     $("#selnuevomesiniciomodafisuc").removeAttr("style");
     $("#selnuevoanioiniciomodafisuc").removeAttr("style");
     $("#selnuevomesfraccionriesgodetrab").removeAttr("style");
     $("#selnuevoaniofraccionriesgodetrab").removeAttr("style ");
     $("#selnuevoclaseriegodetrab").removeAttr("style");
     $("#selnuevofraccionriegodetrab").removeAttr("style");
 }
 //****************************************************************************
 //****************************************************************************
 //****************************************************************************
 //****************************************************************************
 //****************************************************************************
 //****************************************************************************
 //****************************************************************************
 //****************************************************************************
 //****************************************************************************
 /*
  function guardarnuevaempresa() {
      var delegecaionmuni = $("#inpdelmunnuevaempresa").val();
      var colonia = $("#inpcolonianuevaempresa").val();
      var data = $("#frmempresa").serialize();
   
      if (delegecaionmuni == 0) {
          var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Delegacion/Municipio: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#errorMsj").html(Msgerror);
          $("#inpdelmunnuevaempresa").css('border', '#D0021B 1px solid'); //para marcar el campo en rojo
          $("#inpcolonianuevaempresa").removeAttr("style");
      } else if (colonia == 0) {
          var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Colonia: </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#errorMsj").html(Msgerror);
          $("#inpcolonianuevaempresa").css('border', '#D0021B 1px solid'); //para marcar el campo en rojo
          $("#inpdelmunnuevaempresa").removeAttr("style");
      } else {
          $.ajax({
              type: "POST",
              url: "../empresa/ajax_guardanuevaempresa.php",
              data: data,
              dataType: "json",
              success: function(response) {
                  //console.log(response);
                  var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Empresa Registrada Con Éxito </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#errorMsj").html(Msgerror);
                  $("#inpdelmunnuevaempresa").removeAttr("style");
                  $("#inpcolonianuevaempresa").removeAttr("style");
                  $('#frmempresa').trigger("reset"); //reset el form con jquery
                  $("#inpcolonianuevaempresa").empty();
                  $("#inpdelmunnuevaempresa").empty();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
          });
      }
  }

  function nuevoregistropatronal() {
      $("#errorMsj").html("");
      document.getElementById("frmnuevasucursal").reset(); //reset form con js
      // $('#frmsucursal').trigger("reset"); //reset form con jquery
      $("#hdnaccionfrmsucursal").val("nuevoregistropatronal");
      $("#hdnaccionfrmnuevaempresa").val("");
      $("#displayfrmempresa").hide();
      $("#displaynuevofrmsuc").show();
      $("#muestranuevosinputsdefrmempresa").hide();
      llenaselempresa();
  }

  
   function nuevaempresa() {
     $("#errorMsj").html("");
     //document.getElementById("frmempresa").reset(); //reset form con js
     $('#frmempresa').trigger("reset"); //reset el form con jquery
     $("#inpcolonianuevaempresa").empty();
     $("#inpdelmunnuevaempresa").empty();
     $("#hdnaccionfrmnuevaempresa").val("nuevaempresa");
     $("#hdnaccionfrmsucursal").val("");
     $("#displaynuevofrmsuc").hide();
     $("#btnsfrmempresa").show();
     $("#displayfrmempresa").hide();
     $("#inputsdefrmempresaconsulta").hide();
     $("#muestranuevosinputsdefrmempresa").show();
 }

 function consultaentidadymunicipio() {
     var cp = $("#inpcodigopostalnuevoempresa").val();
     if (cp == "" || !/^([0-9]{5})*$/.test(cp)) {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Codigo Postal No Valido </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpnuevocodigopostalsuc").css('border', '#D0021B 1px solid');
         $("#inpcolonianuevaempresa").empty().append('<option value="0" selected="selected">Ingrese Codigo Postal valido </option>');
         $("#inpdelmunnuevaempresa").empty().append('<option value="0" selected="selected">Ingrese Codigo Postal valido</option>');
         $(document).scrollTop(0);
         cp = 0;
     } else {
         limpiaerrores();
         $.ajax({
             type: "POST",
             url: "../empresa/ajax_llenaselectoreentidadcolnuevaempresa.php",
             data: {
                 cp: cp,
                 accion: 1,
             },
             dataType: "json",
             success: function(response) {
                 //console.log(response);
                 datos = response.datos;
                 $('#inpcolonianuevaempresa').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $('#inpdelmunnuevaempresa').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
                 $.each(datos, function(i) {
                     $('#inpcolonianuevaempresa').append('<option value="' + response.datos[i].nombreAsentamiento + '">' + response.datos[i].nombreAsentamiento + '</option>'); //verificar que rollo con esto
                 });
                 if (datos == 0) {
                     var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Codigo Postal No Valido </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                     $("#errorMsj").html(Msgerror);
                     $("#inpcodigopostalnuevoempresa").css('border', '#D0021B 1px solid');
                     $("#inpdelmunnuevaempresa").empty();
                     $("#inpcolonianuevaempresa").empty();
                     $(document).scrollTop(0);
                 } else {
                     limpiaerrores();
                     $('#inpdelmunnuevaempresa').append('<option value="' + response.datos[0].nombreMunicipio + '">' + response.datos[0].nombreMunicipio + '</option>'); //verificar que rollo con esto
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }*/

 function consultarEntidadesRP(){

    $.ajax({
      type: "POST",
      url: "../nuevoregpatronal/ajax_EntidadesRP.php",
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
         $("#entidadesSucursales").empty(); 
         $('#entidadesSucursales').append('<option value="0">ENTIDADES</option>');
         if(response.status == "success"){
            for(var i = 0; i < response.entidades.length; i++){
                var idEntidad= response.entidades[i]["idEntidadFederativa"];
                var entidad= response.entidades[i]["nombreEntidadFederativa"];
                var entidadMayuscula=entidad.toUpperCase();
                entCompletasIDSelector.push(idEntidad);
                entCompletasNameSelector.push(entidadMayuscula);
                $('#entidadesSucursales').append('<option value="' + (idEntidad) + '">' + entidadMayuscula + '</option>');
            }
        }else{
              alert("Error Al Cargar Las Lineas de Negocio");
        }
       }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}

$("#entidadesSucursales").change(function(){

  var entidadSelect= $("#entidadesSucursales").val();


     $("#selectMunicipios").empty();
     $('#selectMunicipios').append('<option value="0">SELECCIONAR</option>');
     // $("#divMunicipio").hide();

  if(entidadSelect==0){
     $("#radioEntidad").val(0);
     $("#radioMunicipio").val(0);
     $("#btnAgregarEntidad").hide();
     $("#radioEntidad").prop("checked", false);
     $("#radioMunicipio").prop("checked", false);
     $("#radioEntidad").prop("disabled", true);
     $("#radioMunicipio").prop("disabled", true);
     $("#divMunicipio").hide();
  }else{
     $("#radioEntidad").prop("disabled", false);
     $("#radioMunicipio").prop("disabled", false);
  }

  if ($('#radioMunicipio').is(":checked")){
    consultarMunicipiosXEntidad();
  }
});

$("#radioEntidad").change(function(){
  
     $("#selectMunicipios").empty();
     $('#selectMunicipios').append('<option value="0">SELECCIONAR</option>');

  if($('#radioEntidad').is(":checked")){
    
     $("#btnAgregarMunicipio").hide();
     $("#radioEntidad").val(1);
     $("#radioMunicipio").prop("checked", false);
     $("#radioMunicipio").val(0);
     $("#btnAgregarEntidad").show();
     $("#divMunicipio").hide();
   }else{
         $("#radioEntidad").val(0);
        }
});

$("#radioMunicipio").change(function(){
  $("#selectMunicipios").empty();
  $('#selectMunicipios').append('<option value="0">SELECCIONAR</option>');

  if($('#radioMunicipio').is(":checked")){
     $("#radioMunicipio").val(1);
     $("#radioEntidad").prop("checked", false);
     $("#radioEntidad").val(0);
     $("#inpnuevocodigopostalsuc").prop("disabled", false);
     $("#divMunicipio").show();
     consultarMunicipiosXEntidad();
     $("#btnAgregarEntidad").hide();
     // $("#selectMunicipios").show();
   }else{
         $("#radioMunicipio").val(0);
         $("#inpnuevocodigopostalsuc").prop("disabled", true);
        }

    var entidadSelect= $("#entidadesSucursales").val();

    if(entidadSelect!=0){
        consultarMunicipiosXEntidad();
    }
 });

$("#selectMunicipios").change(function(){
  
  var municipioSelect= $("#selectMunicipios").val();
  if (municipioSelect!=0){
     $("#btnAgregarMunicipio").show();
  }else{
     $("#btnAgregarMunicipio").hide();
  }

 });



function consultarMunicipiosXEntidad(){

    var entidadSelect= $("#entidadesSucursales").val();

    $.ajax({
      type: "POST",
      url: "../nuevoregpatronal/ajax_ConsultarMunicipiosXEntidad.php",
      data: {entidadSelect: entidadSelect},
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
         $("#selectMunicipios").empty(); 
         $('#selectMunicipios').append('<option value="0">SELECCIONAR</option>');
         if(response.status == "success"){
            for(var i = 0; i < response.municipios.length; i++){
                var idMunicipio= response.municipios[i]["idMunicipio"];
                var nombreMunicipio= response.municipios[i]["nombreMunicipio"];
                var nombreMunicipioMayusculas=nombreMunicipio.toUpperCase();
                $('#selectMunicipios').append('<option value="' + (idMunicipio) + '">' + nombreMunicipioMayusculas + '</option>');
            }
        }else{
              alert("Error Al Cargar Las Lineas de Negocio");
        }
       }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}

var tblEntSeleccionadasID = [];
var tblEntSeleccionadasName = [];

function cargaTablaEntidades(tipo){

    if (tipo=='1'){
      var entidad   = $('#entidadesSucursales').val();
      var nombreEnt = $('select[id="entidadesSucursales"] option:selected').text();
      tblEntSeleccionadasID.push(entidad);
      tblEntSeleccionadasName.push(nombreEnt);
    }

    if (tblEntSeleccionadasID.length>=1){//si hay minimo una entidad elegida se llena la tabla
        var tblEntidadesAsignadas = "<table id='tblEntidadesAsignadas' class='table table-bordered'><thead><th>ENTIDADES ASIGNADAS</th><th>ELIMINAR</th></thead><tbody>";
        tblEntidadesAsignadas += "<tr>";
        
        for(var i = 0; i < tblEntSeleccionadasID.length; i++) {
            var nombreEntArray=tblEntSeleccionadasName[i];
            tblEntidadesAsignadas += "<td>"+tblEntSeleccionadasName[i]+"</td>";
            tblEntidadesAsignadas += "<td><img src='../../vista/img/eliminar.png' title='ELIMINAR ENTIDAD' style='cursor:pointer' width='45%'; onclick='eliminarEntidadRP(\""+i+"\")'/></td></tr>"  
        }
    
        $("#divTablaEntidadesAsignadas").show();
        $("#divTablaEntidadesAsignadas").html(tblEntidadesAsignadas);
    }

    if(tipo=='1'){
       reconsultarEntidadesRP(tblEntSeleccionadasID);
    }
}
function reconsultarEntidadesRP(entidadesSeleccionadas){

    $.ajax({
      type: "POST",
      url: "../nuevoregpatronal/ajax_ReconsultaEntidadesRP.php",
      data: {entidadesSeleccionadas: entidadesSeleccionadas},
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
         $("#entidadesSucursales").empty(); 
         $('#entidadesSucursales').append('<option value="0">ENTIDADES</option>');
         if(response.status == "success"){
            for(var i = 0; i < response.entidades.length; i++){
                var idEntidad= response.entidades[i]["idEntidadFederativa"];
                var entidad= response.entidades[i]["nombreEntidadFederativa"];
                var entidadMayuscula=entidad.toUpperCase();
                entCompletasIDSelector.push(idEntidad);
                entCompletasNameSelector.push(entidadMayuscula);
                $('#entidadesSucursales').append('<option value="' + (idEntidad) + '">' + entidadMayuscula + '</option>');
            }
        }else{
              alert("Error Al Cargar Las Lineas de Negocio");
        }
       }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}

function eliminarEntidadRP(i){

    tblEntSeleccionadasID.splice(i, 1);//se elimina la entidad por posicion en el arreglo
    tblEntSeleccionadasName.splice(i, 1);//se elimina la entidad por posicion en el arreglo

    if(tblEntSeleccionadasID.length<1){
       $("#divTablaEntidadesAsignadas").hide();
       consultarEntidadesRP();
    }else{
        reconsultarEntidadesRP(tblEntSeleccionadasID);
    }
    cargaTablaEntidades(2);
}
///////////////TERMINA ENTIDADES, EMPIEZA MUNICIPIOS/////////////

var tblMunicipiosSeleccionadosID = [];
var tblMunicipiosSeleccionadosName = [];

function cargaTablaMunicipios(tipo){

    if (tipo=='1'){
      var municipio   = $('#selectMunicipios').val();
      var nombreMunicipio = $('select[id="selectMunicipios"] option:selected').text();
      tblMunicipiosSeleccionadosID.push(municipio);
      tblMunicipiosSeleccionadosName.push(nombreMunicipio);
    }

    if (tblMunicipiosSeleccionadosID.length>=1){//si hay minimo una municipio elegida se llena la tabla
        var tblMunicipiosAsignados = "<table id='tblMunicipiosAsignados' class='table table-bordered'><thead><th>MUNICIPIOS ASIGNADOS</th><th>ELIMINAR</th></thead><tbody>";
        tblMunicipiosAsignados += "<tr>";
        
        for(var i = 0; i < tblMunicipiosSeleccionadosID.length; i++) {
            tblMunicipiosAsignados += "<td>"+tblMunicipiosSeleccionadosName[i]+"</td>";
            tblMunicipiosAsignados += "<td><img src='../../vista/img/eliminar.png' title='ELIMINAR' style='cursor:pointer' width='45%'; onclick='eliminarMunicipioRP(\""+i+"\")'/></td></tr>"  
        }
    
        $("#divTablaMunicipiosAsignados").show();
        $("#divTablaMunicipiosAsignados").html(tblMunicipiosAsignados);
    }

    if(tipo=='1'){
       reconsultarMunicipiosRP(tblMunicipiosSeleccionadosID);
    }
}

function reconsultarMunicipiosRP(municipiosSeleccionados){

    var entidadMunicipio = $('#entidadesSucursales').val();


    $.ajax({
      type: "POST",
      url: "../nuevoregpatronal/ajax_ReconsultaMunicipiosRP.php",
      data: {municipiosSeleccionados: municipiosSeleccionados,entidadMunicipio:entidadMunicipio},
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
         $("#selectMunicipios").empty(); 
         $('#selectMunicipios').append('<option value="0">SELECCIONAR</option>');
         if(response.status == "success"){
            for(var i = 0; i < response.municipios.length; i++){
                var idMunicipio= response.municipios[i]["idMunicipio"];
                var municipio= response.municipios[i]["nombreMunicipio"];
                var municipioMayuscula=municipio.toUpperCase();
                municipiosCompletosIDSelector.push(idMunicipio);
                municipiosCompletosNameSelector.push(municipioMayuscula);
                $('#selectMunicipios').append('<option value="' + (idMunicipio) + '">' + municipioMayuscula + '</option>');
            }
        }else{
              alert("Error Al Cargar Las Lineas de Negocio");
        }
       }
      },
      error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
      }
    });
}

function eliminarMunicipioRP(i){

    tblMunicipiosSeleccionadosID.splice(i, 1);//se elimina la entidad por posicion en el arreglo
    tblMunicipiosSeleccionadosName.splice(i, 1);//se elimina la entidad por posicion en el arreglo

    if(tblMunicipiosSeleccionadosID.length<1){
       $("#divTablaMunicipiosAsignados").hide();
       consultarMunicipiosXEntidad();
    }else{
        reconsultarMunicipiosRP(tblMunicipiosSeleccionadosID);
    }
    cargaTablaMunicipios(2);
}

//al agregar entidad borrar los municipios de esa entidad