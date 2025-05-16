$(inicioNuevaEmpresa());  
function inicioNuevaEmpresa(){
     $("#frmempresa").submit(function(e) {
         //Detengo el comportamiento normal del evento submit.
         e.preventDefault();
         guardarEmpresa();
     });     
}

 function guardarEmpresa() {
     var nombreEmpresa = $("#inprazonsocialnuevaempresa").val();
     var nombreRepLegal = $("#inpnombrereplegalempresa").val();
     var apellidoPatRepLegal = $("#inpapepaternoreplegalempresa").val();
     var apellidoMatRepLegal = $("#inpapematernoreplegalempresa").val();
     var rfcEmpresa = $("#inprfnuevoempresa").val();
     var cp = $("#inpcodigopostalnuevoempresa").val();
     var municipioEmpresa = $("#inpdelmunnuevaempresa").val();
     var coloniaEmpresa = $("#inpcolonianuevaempresa").val();
     var calleEmpresa = $("#inpcallenuevaempresa").val();
     var numIntEmpresa = $("#inpnuminteriornuevaempresa").val();
     var numExtEmpresa = $("#inpnumexteriornuevaempresa").val();
     var telefonoEmpresa = $("#inptelefononuevaempresa").val();
     //alert("Entra");
     var data = $("#frmempresa").serialize();     
     if (nombreEmpresa == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Nombre o Razon Social</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inprazonsocialnuevaempresa").css('border', '#D0021B 1px solid'); //para marcar el campo en rojo
         $(document).scrollTop(0);
     } else if (cp == "" || !/^([0-9]{5})*$/.test(cp)) {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Codigo Postal Valido </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpnuevocodigopostalsuc").css('border', '#D0021B 1px solid');
         $("#inpnuevoentidadsuc").val("");
         $("#selnuevodelimsssuc").empty();
         $("#selnuevosubdelegacionimsssuc").empty();
         $(document).scrollTop(0);
     } else if (nombreRepLegal == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Nombre Representante Legal</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpnombrereplegalempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (apellidoPatRepLegal == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Apellido Paterno Representante Legal</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpapepaternoreplegalempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (apellidoMatRepLegal == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Apellido Materno Representante Legal</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpapematernoreplegalempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (rfcEmpresa == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese RFC de la Empresa</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inprfnuevoempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (municipioEmpresa == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Delegación/Municipio </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpdelmunnuevaempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (coloniaEmpresa == '0') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Seleccione Colonia de la Empresa</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpcolonianuevaempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (calleEmpresa == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Calle</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpcallenuevaempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else if (numExtEmpresa == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Numero Exterior</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inpnumexteriornuevaempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     }else if (telefonoEmpresa  == '') {
         var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-danger'><strong>Ingrese Telefono</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
         $("#errorMsj").html(Msgerror);
         $("#inptelefononuevaempresa").css('border', '#D0021B 1px solid');
         $(document).scrollTop(0);
     } else {
         
                   $.ajax({
                       type: "POST",
                       url: "ajax_newEmpresa.php",
                       data: data,
                       dataType: "json",
                       success: function(response) {
                           //console.log(response);                           
                           var Msgerror = "<div id='errorMsgtblsalarios' class='alert alert-success'><strong>Empresa Registrada Con Éxito </strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#errorMsj").html(Msgerror);
                            $(document).scrollTop(0);                           
                            $("#inpcolonianuevaempresa").empty();
                            $("#inpdelmunnuevaempresa").empty();                                            
                            $('#frmempresa').trigger("reset"); 
                       },
                       error: function(jqXHR, textStatus, errorThrown) {
                           alert(jqXHR.responseText);
                       }
                   });
     }
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
                     $('#inpdelmunnuevaempresa').append('<option value="' + response.datos[0].nombreMunicipio + '">' + response.datos[0].nombreMunicipio + '</option>'); //verificar que rollo con esto
                 }
             },
             error: function(jqXHR, textStatus, errorThrown) {
                 alert(jqXHR.responseText);
             }
         });
     }
 }