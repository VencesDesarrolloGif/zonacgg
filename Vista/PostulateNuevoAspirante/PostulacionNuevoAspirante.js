$(funcuininicialAvisoPAspirantes());

function funcuininicialAvisoPAspirantes(){
    $("#inpSiAviso").prop("checked", false);
    $("#ContunuarPostulate").hide();
    $("#divNuevoAspirante").hide();
}

$('#inpSiAviso').change(function() {
    if ($('#inpSiAviso').is(":checked")) {
        $("#ContunuarPostulate").show();
    }else{
        $("#ContunuarPostulate").hide();
        $("#inpSiAviso").prop("checked", false);
    }
});
window.onload = function() {
  var myInput = document.getElementById('txtareaAviso');
  myInput.onpaste = function(e) {
    e.preventDefault();
    alert("esta acción está prohibida");
  }
  
  myInput.oncopy = function(e) {
    e.preventDefault();
    alert("esta acción está prohibida");
  }
}
$('#ContunuarPostulate').click(function() {
    $("#divNuevoAspirante").show();
    $("#divAvisoDePrivacidadPostulate").hide();
    $("#divValPuestoEntidad").show();
    GetEntidadALaborar();
    GetSelectoresInicialesPostulate();
});
// Validaciones Vacantes Disponibles ////////////////////////////////
$('#SelEntidadALaborar').change(function() {
    var SelEntidadALaborar = $("#SelEntidadALaborar").val();
    var SelectPuestoPostulate = $("#SelectPuestoPostulate").val();
    if(SelEntidadALaborar == 0){
        $("#divTotalVacantes").html(""); 
        alert("Selecciona La Entidad A Laborar");
        if ($('#checkSiPostulate').is(":checked")) {
            $("#divLaboradoAntes").show();
            $("#divEmpleadoNoExistePostulate").show();
        }else{
            $("#divLaboradoAntes").hide();
            $("#divEmpleadoNoExistePostulate").hide();
            // reiniciarPrePostulate();
        }
    }else if(SelectPuestoPostulate == 0){
        $("#divTotalVacantes").html(""); 
        alert("Selecciona El Puesto Solicitado");
        if ($('#checkSiPostulate').is(":checked")) {
        //     // $("#divLaboradoAntes").show();
        //     // $("#divEmpleadoNoExistePostulate").show();
        }else{
            $("#divLaboradoAntes").hide();
            $("#divEmpleadoNoExistePostulate").hide();
            // reiniciarPrePostulate();  
        }
    }else{
        ObtenerTotalDeVacantesPostulate(SelEntidadALaborar,SelectPuestoPostulate);
    }
});
$('#SelectPuestoPostulate').change(function() {
    var SelEntidadALaborar = $("#SelEntidadALaborar").val();
    var SelectPuestoPostulate = $("#SelectPuestoPostulate").val();
    if(SelEntidadALaborar == 0){
        $("#divTotalVacantes").html(""); 
        alert("Selecciona La Entidad A Laborar");
        if ($('#checkSiPostulate').is(":checked")) {
            $("#divLaboradoAntes").show();
            $("#divEmpleadoNoExistePostulate").show();
        }else{
            $("#divLaboradoAntes").hide();
            $("#divEmpleadoNoExistePostulate").hide();
            // reiniciarPrePostulate();
        }
    }else if(SelectPuestoPostulate == 0){
        $("#divTotalVacantes").html(""); 
        alert("Selecciona El Puesto Solicitado");
        if ($('#checkSiPostulate').is(":checked")) {
        //     // $("#divLaboradoAntes").show();
        //     // $("#divEmpleadoNoExistePostulate").show();
        }else{
            $("#divLaboradoAntes").hide();
            $("#divEmpleadoNoExistePostulate").hide();
            // reiniciarPrePostulate();  
        }
    }else{
        ObtenerTotalDeVacantesPostulate(SelEntidadALaborar,SelectPuestoPostulate);
    }
});
function ObtenerTotalDeVacantesPostulate(SelEntidadALaborar,SelectPuestoPostulate){
    $.ajax({
        type: "POST",
        url: "ajax_GetTotalDeVacantesPostulate.php",
        data:{"SelEntidadALaborar":SelEntidadALaborar,"SelectPuestoPostulate":SelectPuestoPostulate},
        dataType: "json",
        async:false,
        success: function(response) {
            var vacantes = response.datos[0].TotalVacantes;
            if(vacantes > 0){
                var vac = "<H3>Existen "+vacantes+" Vacantes Disponibles</H3>";
                $("#divLaboradoAntes").show();
                $("#divEmpleadoNoExistePostulate").show();
                var PuestoPostulate = $("#SelectPuestoPostulate option:selected" ).text();
                $("#empPuestoPostulate").val(PuestoPostulate);
            }else{
                $("#divLaboradoAntes").hide();
                $("#divEmpleadoNoExistePostulate").hide();
                var vac = "<H3>No Existen Vacantes Disponibles Para Este Puesto En Esta Entidad A Laborar</H3>";
                $("#checkSiPostulate").prop("checked", false);
                reiniciarPrePostulate();
            }
            $("#divTotalVacantes").html(vac); 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });  
}
/////////////////////////////////////////////////////////////////////
function GetSelectoresInicialesPostulate(){
    GetTipoDeSangre(); 
    GetEstadoNacimiento(); 
    GetGradoDeEstudio(); 
    // GetEntidadALaborar();
}
function GetTipoDeSangre(){
    $.ajax({
        type: "POST",
        url: "ajax_GetTipoDeSangrePostulate.php",
        dataType: "json",
        success: function(response) {
            var datos = response.datos;
            $('#selectEmpTipoSangrePostulate').empty().append('<option value="0">TIPO SANGRE</option>');
            $.each(datos, function(i) {
                $('#selectEmpTipoSangrePostulate').append('<option value="' + response.datos[i].idTipoSangre+ '">' + response.datos[i].tipoSangre + '</option>');
            }); 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });  
}

function GetEstadoNacimiento(){
    $.ajax({
        type: "POST",
        url: "ajax_GetEstadoNacimientoPostulate.php",
        dataType: "json",
        success: function(response) {
            var datos = response.datos;
            $('#selectEmpEntidadPostulate').empty().append('<option value="0">ESTADO</option>');
            $.each(datos, function(i) {
                $('#selectEmpEntidadPostulate').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
            }); 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });  
}

function GetGradoDeEstudio(){
    $.ajax({
        type: "POST",
        url: "ajax_GetGradoDeEstudioPostulate.php",
        dataType: "json",
        success: function(response) {
            var datos = response.datos;
            $('#selectEmpEstudioPostulate').empty().append('<option value="0">GRADO</option>');
            $.each(datos, function(i) {
                $('#selectEmpEstudioPostulate').append('<option value="' + response.datos[i].idGradoEstudios+ '">' + response.datos[i].descripcionGradoEstudios + '</option>');
            }); 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });  
}

function GetEntidadALaborar(){
    $.ajax({
        type: "POST",
        url: "ajax_GetEstadoNacimientoPostulate.php",
        dataType: "json",
        success: function(response) {
            var datos = response.datos;
            $('#SelEntidadALaborar').empty().append('<option value="0">ESTADO</option>');
            $.each(datos, function(i) {
                $('#SelEntidadALaborar').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
            }); 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
        }
    });  
}

//***************  movimientos checks pregunta haz laborado antes con nosotros **************************//

$('#checkSiPostulate').change(function() {
    if ($('#checkSiPostulate').is(":checked")) {
        $("#divEmpleadoNoExistePostulate").hide();
        $("#divEmpleadoExistePostulate").show();
        $("#msginformativoPostulate").html(""); 
        $('#msginformativoPostulate').fadeOut();

    }else{
        $("#divEmpleadoNoExistePostulate").show();
        $("#divEmpleadoExistePostulate").hide();
        $("#msginformativoPostulate").html(""); 
        $('#msginformativoPostulate').fadeOut();
        reiniciarPrePostulate();
    }
});
//*******************************************************************************************************
//***************  Busca por curp o folio si es que ha laborado en la empresa  **************************//
$("#btnbuscarPostulate").click(function(){
    var curbusquedastr=$("#busquedacurpPostulate").val();
    var numafiliacionimss=$("#busquedanumimssPostulate").val();
    var curbusqueda=curbusquedastr.toUpperCase();
    if(curbusqueda!="" && numafiliacionimss==""){
        if(/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/.test(curbusqueda)){
            consultaexistiaempleadoPostulate(curbusqueda,numafiliacionimss,1);
        }else {
            errorHazTrabajadoAqui("Verifica El CURP");
          }
    }else if(curbusqueda=="" && numafiliacionimss!=""){
        if(/^(([0-9]{11}))$/.test(numafiliacionimss)){
            consultaexistiaempleadoPostulate(curbusqueda,numafiliacionimss,0);
        }else{
            errorHazTrabajadoAqui("Verifica El N° AFILIACIÓN IMSS");
        }
    }else{
        errorHazTrabajadoAqui("Ingresa El CURP o N° AFILIACIÓN IMSS");
    }
});
  function errorHazTrabajadoAqui(msj){
    $('#msginformativoPostulate').fadeIn()
    alertMsg1="<div id='msginformativoPostulate1' class='alert alert-error'>Precontratación: <h4>"+msj+"<h4></div>";      
    $("#msginformativoPostulate").html(alertMsg1);                        
    $(document).scrollTop(0);
    $('#msginformativoPostulate').delay(4000).fadeOut('slow');
    
  }
function consultaexistiaempleadoPostulate(curp,numafiliacionimss,caso){// caso=1 busqueda por curp, caso=0 busqueda por imss
    $('#msginformativoPostulate').fadeIn();
    $("#divEmpleadoExistePostulate").hide();
    $("#busquedacurpPostulate").val("");
    $("#busquedanumimssPostulate").val("");
    $.ajax({
        async : false,
        type: "POST",
        url: "ajax_obtenerFolioPrecontraReingresoEmpleadoPostulate.php",
        data:{"curp":curp,"numafiliacionimss":numafiliacionimss,"folioPreseleccion":0,"caso":caso},
        dataType: "json",
        success: function(response) {
            var status=response.status;
            if(status=="sinDatos"){
                $('#msginformativoPostulate').fadeIn();
                alertMsg1="<div id='msginformativoPostulate1' class='alert alert-danger'><h4>No hemos encontrado información de registro intenta con otra opcion de busqueda o completa el siguiente formulario</h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                $("#msginformativoPostulate").html(alertMsg1); 
                $(document).scrollTop(0);
                $('#msginformativoPostulate').delay(20000).fadeOut('slow');
                reiniciarPrePostulate();
                $("#divEmpleadoNoExistePostulate").show();
                $("#divEmpleadoExistePostulate").hide();
                $("#checkSiPostulate").prop("checked", false);
               }else{
                    var numeroempleado=response.datosEmpleado[0].numempleado;
                    var folioPreselecciontblempleados=response.datosEmpleado[0].foliopreseleccion;
                    var folioPreselecciontblempleadospreseleccion=response.datosEmpleado[0].foliotblempleadopreseleccion;

                    if(folioPreselecciontblempleados==null && folioPreselecciontblempleadospreseleccion==null){
                        // alertMsg1="<div id='msginformativoPostulate1' class='alert alert-warning'><h4>Tu numero de empleado es: "+numeroempleado+" Completa el siguiente formulario y entrega este número al personal de contrataciones</h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                        // $("#msginformativoPostulate").html(alertMsg1); 
                        reiniciarPrePostulate();
                        $("#divEmpleadoNoExistePostulate").show();
                        $("#divEmpleadoExistePostulate").hide();
                        $("#checkSiPostulate").prop("checked", false);
                    }else{
                        foliodefinido=folioPreselecciontblempleados;
                        // alertMsg1="<div id='msginformativoPostulate1' class='alert alert-warning'><h4>Tu numero de empleado es: "+numeroempleado+" por favor verifica tus datos, en caso de estar correctos presiona el boton GUARDAR de lo contrario ingresa correctamente tu información y presiona el boton GUARDAR</h4><a href='#' class='close' data-dismiss='alert'>&times;</a></div>"; 
                        // $("#msginformativoPostulate").html(alertMsg1); 
                        if(folioPreselecciontblempleados==null){
                            var foliodefinido=folioPreselecciontblempleadospreseleccion;
                        }else if(folioPreselecciontblempleadospreseleccion==null){
                            foliodefinido=folioPreselecciontblempleados;
                        }
                        traerDatosPrecontratacionPostulate(foliodefinido);
                        $("#divNuevoAspirante").show();
                        $("#divAvisoDePrivacidadPostulate").hide();
                        $("#divEmpleadoNoExistePostulate").show();
                    }
                }

               $("#numempleadopreseleccionPostulate").val(numeroempleado);
                $("#folioempleadopreseleccionPostulate").val(foliodefinido);

            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);

            }
        });
}
function traerDatosPrecontratacionPostulate(folioPreseleccion){
    $.ajax({
        async : false,
        type: "POST",
        url: "ajax_obtenerFolioPrecontraReingresoEmpleadoPostulate.php",
        data:{"curp":0,"numafiliacionimss":0,"folioPreseleccion":folioPreseleccion,"caso":0},
        dataType: "json",
        success: function(response) {
            $("#numLicenciaPreseleccionPostulate").val("");
            $("#fechavigencialicenciaPostulate").val("");
            $("#tdnumlicenciaprecontrataPostulate").hide();
            $("#tdfechavigencialicenciaPostulate").hide();
            $("#tablesolicitudEmpleoPostulate").show();
            $("#tblcriteriosdebusquedaPostulate").hide();
            $("#empPuestoPostulate").val(response.datosAspitante[0].puestoPreseleccion);
            $("#empApPaternoPostulate").val(response.datosAspitante[0].apPaternoPreseleccion);
            $("#empApMaternoPostulate").val(response.datosAspitante[0].apMaternoPreseleccion);
            $("#empNombrePostulate").val(response.datosAspitante[0].nombrePreseleccion);
            $("#empEdadPostulate").val(response.datosAspitante[0].edadPreseleccion);
            $("#empPesoPostulate").val(response.datosAspitante[0].pesoPreseleccion);
            $("#empEstaturaPostulate").val(response.datosAspitante[0].estaturaPreseleccion);
            $("#empTallaCamisaPostulate").val(response.datosAspitante[0].tallaCamisaPreseleccion);
            $("#empTallaPantalonPostulate").val(response.datosAspitante[0].tallaPantalonPreseleccion);
            $("#empNumCalzadoPostulate").val(response.datosAspitante[0].numCalzadoPreseleccion);
            $("#selectEmpCivilPostulate").val(response.datosAspitante[0].edoCivilPreseleccion);
            $("#selectEmpSexoPostulate").val(response.datosAspitante[0].generoPreseleccion);
            $("#selectEmpTipoSangrePostulate").val(response.datosAspitante[0].tipoSangrePreseleccion);
            $("#empFechaNacPostulate").val(response.datosAspitante[0].fechaNacPreseleccion);
            $("#selectEmpEntidadPostulate").val(response.datosAspitante[0].entidadNacPreseleccion);
            $("#empCodPostalPostulate").val(response.datosAspitante[0].cpPreseleccion);
            $("#empCallePostulate").val(response.datosAspitante[0].callePreseleccion);
            $("#empNumeroCPostulate").val(response.datosAspitante[0].numeroPreseleccion);
            $("#empColoniaPostulate").val(response.datosAspitante[0].coloniaPreseleccion);
            $("#empMunicipioPostulate").val(response.datosAspitante[0].municipioPreseleccion);
            $("#empCiudadPostulate").val(response.datosAspitante[0].ciudadPreseleccion);
            $("#empTelFijoPostulate").val(response.datosAspitante[0].telFijoPreseleccion);
            $("#empTelMovilPostulate").val(response.datosAspitante[0].telMovilPreseleccion);
            $("#empEmailPostulate").val(response.datosAspitante[0].emailPreseleccion);
            var a = response.datosAspitante[0].idEntidadALaborar;
            var b = response.datosAspitante[0].idPuestoSeleccionado;
            if(a == null || a == "NULL" || a == "null" || a == "" || a == "0"){
                $("#SelEntidadALaborar").val(0);
            }else{
                $("#SelEntidadALaborar").val(response.datosAspitante[0].idEntidadALaborar);
            }
            if(b == null || b == "NULL" || b == "null" || b == "" || b == "0"){
                $("#SelectPuestoPostulate").val(0);
            }else{
                $("#SelectPuestoPostulate").val(response.datosAspitante[0].idPuestoSeleccionado);
            }
            if(response.datosAspitante[0].infonavitPreseleccion==1){$("#checkEmpInfonavitPostulate").prop("checked", true);}else{$("#checkEmpInfonavitPostulate").prop("checked", false);}
            if(response.datosAspitante[0].fonacotPreseleccion==1){$("#checkEmpFonacotPostulate").prop("checked", true);}else{$("#checkEmpFonacotPostulate").prop("checked", false);}
            if(response.datosAspitante[0].cartillaPreseleccion==1){$("#checkEmpCartillaPostulate").prop("checked", true);}else{$("#checkEmpCartillaPostulate").prop("checked", false);}
            if(response.datosAspitante[0].licenciaPreseleccion==1){
                $("#checkEmpLicenciaPostulate").prop("checked", true);
                $("#checkEmpLicenciaPermanentePostulate").prop("checked", true);
                $("#tdnumlicenciaprecontratapermanentePostulate").show();
                if(response.datosAspitante[0].licenciapermanente==0){
                    $("#numLicenciaPreseleccionPostulate").val("");
                    $("#fechavigencialicenciaPostulate").val("");///////////descomentar una vez que este el datop en la bd  
                    $("#tdnumlicenciaprecontrataPostulate").hide(); 
                    $("#tdfechavigencialicenciaPostulate").hide();
                }else{
                    $("#numLicenciaPreseleccionPostulate").val(response.datosAspitante[0].numlicenciapreseleccion);
                    $("#fechavigencialicenciaPostulate").val(response.datosAspitante[0].fechavigencialicencia);///////////descomentar una vez que este el datop en la bd  
                    $("#tdnumlicenciaprecontrataPostulate").show(); 
                    $("#tdfechavigencialicenciaPostulate").show();
                }
            } else{
                $("#checkEmpLicenciaPostulate").prop("checked", false);
                $("#checkEmpLicenciaPermanentePostulate").prop("checked", false);
                $("#tdnumlicenciaprecontratapermanentePostulate").hide();
            }
            
            $("#empImssPostulate").val(response.datosAspitante[0].nImssPreseleccion);
            $("#empNombreUEPostulate").val(response.datosAspitante[0].nombreE1Preseleccion);
            $("#empFecha1E1Postulate").val(response.datosAspitante[0].fecha1E1Preseleccion);
            $("#empFecha2E1Postulate").val(response.datosAspitante[0].fecha2E1Preseleccion);
            $("#empTelE1Postulate").val(response.datosAspitante[0].telefonoE1Preseleccion);
            $("#empCausaSepE1Postulate").val(response.datosAspitante[0].causaE1Preseleccion);
            $("#empNombreEAPostulate").val(response.datosAspitante[0].nombreE2Preseleccion);
            $("#empFecha1E2Postulate").val(response.datosAspitante[0].fecha1E2Preseleccion);
            $("#empFecha2E2Postulate").val(response.datosAspitante[0].fecha2E2Preseleccion);
            $("#empTelE2Postulate").val(response.datosAspitante[0].telefonoE2Preseleccion);
            $("#empCausaSepE2").val(response.datosAspitante[0].causaE2Preseleccion);
            if(response.datosAspitante[0].personasACargoPreseleccion==1){$("#checkEmpPersonasPostulate").prop("checked", true);}else{$("#checkEmpPersonasPostulate").prop("checked", false);}
            $("#selectEmpEstudioPostulate").val(response.datosAspitante[0].gradoEPreseleccion);
            $("#empCursoEspecialPostulate").val(response.datosAspitante[0].cursoEspecialPreseleccion);
            $("#empEnfermedadPostulate").val(response.datosAspitante[0].enfermedadPreseleccion);
            $("#empPadrePostulate").val(response.datosAspitante[0].padrePreseleccion);
            $("#empMadrePostulate").val(response.datosAspitante[0].madrePreseleccion);
            $("#empEsposaPostulate").val(response.datosAspitante[0].esposaPreseleccion);
            $("#empHijo1Postulate").val(response.datosAspitante[0].ben1Preseleccion);
            $("#empHijo2Postulate").val(response.datosAspitante[0].ben2Preseleccion);
            $("#empHijo3Postulate").val(response.datosAspitante[0].ben3Preseleccion);
            $("#empHijo4Postulate").val(response.datosAspitante[0].ben4Preseleccion);
            $("#empHijo5Postulate").val(response.datosAspitante[0].ben5Preseleccion);
            $("#empNombreR1Postulate").val(response.datosAspitante[0].nombreR1Preseleccion);
            $("#empTelR1Postulate").val(response.datosAspitante[0].telefonoR1);
            $("#empNombreR2Postulate").val(response.datosAspitante[0].nombreR2);
            $("#empTelR2Postulate").val(response.datosAspitante[0].telefonoR2);
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);

        }
    });
}
//*******************************************************************************************************
//***************  Seteamos Las Fechas a un tipo Especifico********* **********************************//
$('#empFechaNacPostulate').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
});
$('#empFecha1E1Postulate').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
});
 $('#empFecha2E1Postulate').datetimepicker({
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
});
//*******************************************************************************************************
//***************  Limpia el formulario y deja todo como el comienzo **********************************//
function reiniciarPrePostulate(){
    $("#form_registroPreseleccionPostulate")[0].reset();
    GetSelectoresInicialesPostulate();      
    $("#txtFolioSolicitudPostulate").val("");
    $("#busquedacurpPostulate").val("");
    $("#busquedanumimssPostulate").val("");  
    $("#SelectPuestoPostulate").val(0);
    $("#numempleadopreseleccionPostulate").val("");
    $("#folioempleadopreseleccionPostulate").val("");
} 
//****************************************************************************************************************
//*  Obtenemos el folio preeseleccion en caso de no haber problema guardamos la informacion despues del success //
$('#btnGuardarPostulate').click(function() {
    $.ajax({
        type: "POST",
        url: "ajax_obtenerFolioPresPostulate.php",
        dataType: "json",
        async : false,
        success: function(response) {
            if (response.status == "success")
            {                    
                console.log(response);
                var folio = response.folioPre[0].folioPres;  
                alert(folio);                   
                $("#txtFolioSolicitudPostulate").val(folio);
                guardarPreseleccionPostulate();
            }              
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
    });      
});

function guardarPreseleccionPostulate(){
    var datos=$("#form_registroPreseleccionPostulate").serialize();
    var infonavitPostulate=0;
    var fonacotPostulate=0;
    var cartillaPostulate=0;
    var licenciaPostulate=0;
    var licenciapermanentePostulate=0;
    var personasPostulate=0;
    var txtFolioSolicitudPostulate=$("#txtFolioSolicitudPostulate").val();
    var SelEntidadALaborar=$("#SelEntidadALaborar").val();
    var empPuestoPostulate=$("#empPuestoPostulate").val();
    var SelectPuestoPostulate=$("#SelectPuestoPostulate").val();
    if( $('#checkEmpInfonavitPostulate').is(':checked') ) {
        infonavitPostulate=1;
    }
    if( $('#checkEmpFonacotPostulate').is(':checked') ) {
        fonacotPostulate=1;
    }
    if( $('#checkEmpCartillaPostulate').is(':checked') ) {
        cartillaPostulate=1;
    }
    if( $('#checkEmpLicenciaPostulate').is(':checked') ) {
        licenciaPostulate=1;
    }
     if( $('#checkEmpLicenciaPermanentePostulate').is(':checked') ) {
        licenciapermanentePostulate=1;
    }
    if( $('#checkEmpPersonasPostulate').is(':checked') ) {
        personasPostulate=1;
    }
    datos += "&infonavitPostulate=" + infonavitPostulate; 
    datos += "&fonacotPostulate=" + fonacotPostulate; 
    datos += "&cartillaPostulate=" + cartillaPostulate; 
    datos += "&licenciaPostulate=" + licenciaPostulate; 
    datos += "&licenciapermanentePostulate=" + licenciapermanentePostulate; 
    datos += "&personasPostulate=" + personasPostulate; 
    datos += "&txtFolioSolicitudPostulate=" + txtFolioSolicitudPostulate; 
    datos += "&SelEntidadALaborar=" + SelEntidadALaborar; 
    datos += "&empPuestoPostulate=" + empPuestoPostulate; 
    datos += "&SelectPuestoPostulate=" + SelectPuestoPostulate; 
    $.ajax({
        async : false,
        type: "POST",
        url: "ajax_registrarPreseleccionPostulate.php",
        data: datos,
        dataType: "json",
        success: function(response) {
            var mensaje=response.message;
             if (response.status == "success")
             { 
                if($("#numempleadopreseleccionPostulate").val()=="" &&  $("#folioempleadopreseleccionPostulate").val()==""){
                    $("#SelEntidadALaborar").val("");
                    $("#SelectPuestoPostulate").val("");
                    var folio=$("#txtFolioSolicitudPostulate").val();
                    alertMsg1="<h4>Tu Folio De Empleado Es:"+folio+"<h4>";
                    $("#divNumeroEmpleado").html(alertMsg1); 
                    new QRious({
                        element: document.querySelector("#codigoPostulate"),
                        value: folio, // La URL o el texto
                        size: 150,
                        backgroundAlpha: 0, // 0 para fondo transparente
                        foreground: "#0905FA", // Color del QR
                        level: "L", // Puede ser L,M,Q y H (L es el de menor nivel, H el mayor)
                    });
                    $(document).scrollTop(0);
                    $("#SelEntidadALaborar").val(0);
                    $("#SelectPuestoPostulate").val(0);
                    $("#divEmpleadoExistePostulate").hide();
                    $("#checkSiPostulate").prop("checked", false);
                    $("#modalVistaTerminoPostulate").modal();
                    $("#divLaboradoAntes").hide();
                    $("#divEmpleadoNoExistePostulate").hide();
                    $("#divTotalVacantes").html(""); 
                    reiniciarPrePostulate();
                }else {
                    var Num = $("#numempleadopreseleccionPostulate").val();
                    alertMsg1="<h4>Tu Número De Empleado Es: "+Num+"</h4>"; 
                    $("#divNumeroEmpleado").html(alertMsg1); 
                    new QRious({
                        element: document.querySelector("#codigoPostulate"),
                        value: Num, // La URL o el texto
                        size: 150,
                        backgroundAlpha: 0, // 0 para fondo transparente
                        foreground: "#0905FA", // Color del QR
                        level: "L", // Puede ser L,M,Q y H (L es el de menor nivel, H el mayor)
                    });
                    $(document).scrollTop(0);
                    // $('#msginformativoPostulate').delay(10000).fadeOut('slow');
                    reiniciarPrePostulate();
                    $("#SelEntidadALaborar").val(0);
                    $("#SelectPuestoPostulate").val(0);
                    $("#divEmpleadoExistePostulate").hide();
                    $("#checkSiPostulate").prop("checked", false);
                    $("#modalVistaTerminoPostulate").modal();
                    $("#divLaboradoAntes").hide();
                    $("#divEmpleadoNoExistePostulate").hide();
                    $("#divTotalVacantes").html(""); 
                } 
             }else{
                $('#msgierrorPostulate').fadeIn();
                alertMsg1="<div id='msgierrorPostulate1' class='alert alert-error'><strong>Error por favor verifique:</strong>"+mensaje+"</div>";
                $("#msgierrorPostulate").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msgierrorPostulate').delay(3000).fadeOut('slow');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
    });
  }

//****************************************************************************************************************
//***************  setear llos imputs al cambiar de foco *******************************************************//
  $('#busquedacurpPostulate').focus(function() {
  $("#busquedanumimssPostulate").val("");
});
$('#busquedanumimssPostulate').focus(function() {
  $("#busquedacurpPostulate").val("");
});
//****************************************************************************************************************
//***************  Limpia el formulario y deja todo como el comienzo **********************************//
$("#checkEmpLicenciaPostulate").click(function(){ 
    if( $('#checkEmpLicenciaPostulate').is(':checked') ) {
        $("#tdnumlicenciaprecontrataPostulate").show('slow');
        $("#tdfechavigencialicenciaPostulate").show('slow');
        $("#tdnumlicenciaprecontratapermanentePostulate").show('slow');
        $("#checkEmpLicenciaPermanentePostulate").prop('checked','');
    }else{
        $("#tdnumlicenciaprecontrataPostulate").hide();
        $("#tdfechavigencialicenciaPostulate").hide();
        $("#tdnumlicenciaprecontratapermanentePostulate").hide();
        $("#checkEmpLicenciaPermanentePostulate").prop('checked','checked');
    }

    $('#numLicenciaPreseleccionPostulate').val("");
    $('#fechavigencialicenciaPostulate').val("");
});


$("#checkEmpLicenciaPermanentePostulate").click(function(){ 
    if( $('#checkEmpLicenciaPermanentePostulate').is(':checked') ) {      
        $("#tdnumlicenciaprecontrataPostulate").show();
        $("#tdfechavigencialicenciaPostulate").hide();    
        $("#fechavigencialicenciaPostulate").val("");    
    }else{
        $("#tdnumlicenciaprecontrataPostulate").show('slow');
        $("#tdfechavigencialicenciaPostulate").show('slow');
    }
    $('#numLicenciaPreseleccionPostulate').val("");
    $('#fechavigencialicenciaPostulate').val("");
})
//*******************************************************************************************************