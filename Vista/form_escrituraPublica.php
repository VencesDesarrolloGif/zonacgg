<center> 
  <br>
   <div class="col-lg-12" style="font-size:50px;">Escritura Constitutiva</div>
</center>
<div id="divMensajeEscrituraPublica"></div> 
<br>
<center>
  <br>
  <div id="DivRepresentanteLegal">
    <label>Representante legal</label>
    <input type="text" id="txtRepresentanteLegal" class="input-xlarge" disabled="true">
    <input type="hidden" id="txtRepresentanteLegalHidden" class="input-xlarge">
  </div>
  <div id="DivAdministradorUnico">
    <label>Administrador Único</label>
    <input type="text" id="txtAdministradorUnico" class="input-xlarge" disabled="true">
    <input type="hidden" id="txtAdministradorUnicoHidden" class="input-xlarge">   
  </div>
  <div id="DivNumeroEscritura">
    <label>Número de Escritura</label>
    <input type="text" id="txtNumeroEscritura" class="input-xlarge" disabled="true">
    <input type="hidden" id="txtNumeroEscrituraHidden" class="input-xlarge">   
  </div>
  <div id="DivNombreNotarioPublico">
    <label>Nombre del Notario Público</label>
    <input type="text" id="txtNombreNotarioPublico" class="input-xlarge" disabled="true">
    <input type="hidden" id="txtNombreNotarioPublicoHidden" class="input-xlarge">   
  </div>
  <div id="DivNumeroNotarioPublico">
    <label>Número de Notario Público</label>
    <input type="text" id="txtNumeroNotarioPublico" class="input-xlarge" disabled="true">
    <input type="hidden" id="txtNumeroNotarioPublicoHidden" class="input-xlarge">   
  </div>
  <div id="DivFechaEscrituraPublica">
    <label>Fecha de Escritura Constitutiva</label>
    <input type="date" id="txtFechaEscrituraPublica" class="input-xlarge" disabled="true">
    <input type="hidden" id="txtFechaEscrituraPublicaHidden" class="input-xlarge">   
  </div>
  <div id="DivFolioMercantil">
    <label>Folio Mercantil</label>
    <input type="text" id="txtFolioMercantil" class="input-xlarge" disabled="true">
    <input type="hidden" id="txtFolioMercantilHidden" class="input-xlarge">   
  </div>

<form enctype='multipart/form-data' id='archivoEscrituraP' name='archivoEscrituraP'>
  <label>Cargar Documento</label>
  <input type='file' class='btn-success' id='documentoCargado' name='documentoCargado[]' multiple="" disabled="true" /> 
</form>

  <div id="DivtxtnombreDocumento">
    <input type="hidden" id="txtnombreDocumentoHidden" class="input-xlarge">   
    <input type="hidden" id="txtcasoEP" class="input-xlarge">   
  </div>

  <input type="image" id="btnEditarEscritura" src="img\editarLapiz.jpg" style="width: 4%;" title="Editar" hidden="true">
  <input type="image" id="btnAbrirDocumento"  src="img\hojaDatos.png" style="width: 2.5%;" title="Abrir documento" class="cursorImg" hidden="true">
  <input type="image" id="btnGuardarEscritura"src="img\guardar.jpg" style="width: 2.7%; display: none;" title="Guardar cambios" hidden="true">

</center>

<script type="text/javascript">

$(obtenerEscrituraPublica());  

function obtenerEscrituraPublica(){
 $.ajax({
         type: "POST",
         url: "ajax_ObtenerUltimaEscrituraPublica.php",
         dataType: "json",
         success: function(response) {
             if(response.status == "success"){
                $("#txtRepresentanteLegal").val(response["representantelegal"]);
                $("#txtAdministradorUnico").val(response["administradorunico"]);
                $("#txtNumeroEscritura").val(response["numerodeescritura"]);
                $("#txtNombreNotarioPublico").val(response["nombreDelNotarioPublico"]);
                $("#txtNumeroNotarioPublico").val(response["numeroNotarioPublico"]);
                $("#txtFechaEscrituraPublica").val(response["fechaEscrituraPublica"]);
                $("#txtFolioMercantil").val(response["folioMercantil"]);

                $("#txtRepresentanteLegalHidden").val(response["representantelegal"]);
                $("#txtAdministradorUnicoHidden").val(response["administradorunico"]);
                $("#txtNumeroEscrituraHidden").val(response["numerodeescritura"]);
                $("#txtNombreNotarioPublicoHidden").val(response["nombreDelNotarioPublico"]);
                $("#txtNumeroNotarioPublicoHidden").val(response["numeroNotarioPublico"]);
                $("#txtFechaEscrituraPublicaHidden").val(response["fechaEscrituraPublica"]);
                $("#txtFolioMercantilHidden").val(response["folioMercantil"]);
                $("#txtnombreDocumentoHidden").val(response["nombreDocumento"]);
                $("#txtcasoEP").val(response["caso"]);
                var informacion= $("#txtcasoEP").val();
                $("#btnEditarEscritura").prop("hidden", false);
                //alert(informacion);
                if(informacion=='1') {//si tenga informacion
                    $("#btnAbrirDocumento").prop("hidden", false);
                }
              }
         },error:function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText);
            }
  });
}

$("#btnAbrirDocumento").click(function(){
  var nombreDocumento = $("#txtnombreDocumentoHidden").val();
  //alert(nombreDocumento);
  window.open("ajax_CargarDocumentoEscrituraPublica.php?&nombreDocumento=" + nombreDocumento,'fullscreen=no');

});

$("#btnEditarEscritura").click(function(){
    $("#documentoCargado").prop("disabled", false);
    $("#btnGuardarEscritura").prop("disabled", false);
    $("#txtRepresentanteLegal").prop("disabled", false);
    $("#txtAdministradorUnico").prop("disabled", false);
    $("#txtNumeroEscritura").prop("disabled", false);
    $("#txtNombreNotarioPublico").prop("disabled", false);
    $("#txtNumeroNotarioPublico").prop("disabled", false);
    $("#txtFechaEscrituraPublica").prop("disabled", false);
    $("#txtFolioMercantil").prop("disabled", false);
    $("#btnGuardarEscritura").show();
});

$("#btnGuardarEscritura").click(function(){
 var mansaje="";

var RepresentanteLegal   = $("#txtRepresentanteLegal").val();
var AdministradorUnico   = $("#txtAdministradorUnico").val();
var NumeroEscritura      = $("#txtNumeroEscritura").val();
var NombreNotarioPublico = $("#txtNombreNotarioPublico").val();
var NumeroNotarioPublico = $("#txtNumeroNotarioPublico").val();
var FechaEscrituraPublica= $("#txtFechaEscrituraPublica").val();
var FolioMercantil       = $("#txtFolioMercantil").val();

var RepresentanteLegalH   = $("#txtRepresentanteLegalHidden").val();
var AdministradorUnicoH   = $("#txtAdministradorUnicoHidden").val();
var NumeroEscrituraH      = $("#txtNumeroEscrituraHidden").val();
var NombreNotarioPublicoH = $("#txtNombreNotarioPublicoHidden").val();
var NumeroNotarioPublicoH = $("#txtNumeroNotarioPublicoHidden").val();
var FechaEscrituraPublicaH= $("#txtFechaEscrituraPublicaHidden").val();
var FolioMercantilH       = $("#txtFolioMercantilHidden").val();
var caso                  = $("#txtcasoEP").val();
var documentoCargado      = $("#documentoCargado").val();


   
if((RepresentanteLegal!='' && RepresentanteLegal!='NULL' && RepresentanteLegal!='null') && (AdministradorUnico!='' && AdministradorUnico!='NULL' && AdministradorUnico!='null') && (NumeroEscritura!='' && NumeroEscritura!='NULL' && NumeroEscritura!='null') && (NombreNotarioPublico!='' && NombreNotarioPublico!='NULL' && NombreNotarioPublico!='null') && (NumeroNotarioPublico!='' && NumeroNotarioPublico!='NULL'&& NumeroNotarioPublico!='null') && (FechaEscrituraPublica!='' && FechaEscrituraPublica!='NULL' && FechaEscrituraPublica!='null') && (FolioMercantil!='' && FolioMercantil!='NULL' && FolioMercantil!='null') && (documentoCargado!='' && documentoCargado!='NULL' && documentoCargado!='null') && caso=='0'){
        var casoDocumento='1';//nadamas para emparejar lo que se recibe en la funcion
        guardarCambiosEscrituraPublica(casoDocumento);
    }

 if (caso=='1') {
  if ((RepresentanteLegal != RepresentanteLegalH) || (AdministradorUnico != AdministradorUnicoH) || (NumeroEscritura != NumeroEscrituraH) || (NombreNotarioPublico != NombreNotarioPublicoH) || (NumeroNotarioPublico != NumeroNotarioPublicoH) || (FechaEscrituraPublica != FechaEscrituraPublicaH) || (FolioMercantil != FolioMercantilH) || (documentoCargado!='' && documentoCargado!='NULL' && documentoCargado!='null')) {

    //alert("cambio alguno");
    if(documentoCargado!='' && documentoCargado!='NULL' && documentoCargado!='null') {
        var casoDocumento='1';//se debe modificar el archivo
      }else if (documentoCargado=='' || documentoCargado=='NULL' || documentoCargado=='null') {
        var casoDocumento='0';// se debe quedar el documento anterior
      }
    }
    guardarCambiosEscrituraPublica(casoDocumento);
    } else if ((RepresentanteLegal == RepresentanteLegalH) && (AdministradorUnico ==AdministradorUnicoH) && (NumeroEscritura == NumeroEscrituraH) && (NombreNotarioPublico == NombreNotarioPublicoH)  && (NumeroNotarioPublico == NumeroNotarioPublicoH) && (FechaEscrituraPublica == FechaEscrituraPublicaH) && (FolioMercantil == FolioMercantilH) && (documentoCargado=='' || documentoCargado=='NULL' || documentoCargado=='null')) {
    mensaje ="No Editó Ningun Campo";
    cargarmensajeEscrituraPublica(mensaje, 'error');//Revisar guarde documento
 }//caso1
});

function cargarmensajeEscrituraPublica(mensaje,tipo){
  $('#divMensajeEscrituraPublica').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-"+tipo+"'><strong></strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeEscrituraPublica").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajeEscrituraPublica').delay(3000).fadeOut('slow');
}

function guardarCambiosEscrituraPublica(casoDocumento){
 //alert("entrefuncionGua5rdar");
var RepresentanteLegal   = $("#txtRepresentanteLegal").val();
var AdministradorUnico   = $("#txtAdministradorUnico").val();
var NumeroEscritura      = $("#txtNumeroEscritura").val();
var NombreNotarioPublico = $("#txtNombreNotarioPublico").val();
var NumeroNotarioPublico = $("#txtNumeroNotarioPublico").val();
var FechaEscrituraPublica= $("#txtFechaEscrituraPublica").val();
var FolioMercantil       = $("#txtFolioMercantil").val();
var nombreDocumento      = $("#txtnombreDocumentoHidden").val();
var casoDocumento       = casoDocumento;
var formData = new FormData($("#archivoEscrituraP")[0]);

 if (RepresentanteLegal=='' || RepresentanteLegal=='NULL' || RepresentanteLegal=='null') {
        mensaje ="Por favor llene el campo Representante legal";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (AdministradorUnico=='' || AdministradorUnico=='NULL' || AdministradorUnico=='null') {
        mensaje ="Por favor llene el campo Administrador Único";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (NumeroEscritura=='' || NumeroEscritura=='NULL' || NumeroEscritura=='null') {
        mensaje ="Por favor llene el campo Número de Escritura";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (NombreNotarioPublico=='' || NombreNotarioPublico=='NULL' || NombreNotarioPublico=='null') {
        mensaje ="Por favor llene el campo Nombre del Notario Público";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (NumeroNotarioPublico=='' || NumeroNotarioPublico=='NULL' || NumeroNotarioPublico=='null') {
        mensaje ="Por favor llene el campo Número de Notario Público";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (FechaEscrituraPublica=='' || FechaEscrituraPublica=='NULL' || FechaEscrituraPublica=='null') {
        mensaje ="Por favor llene el campo Fecha de Escritura Constitutiva";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (FolioMercantil=='' || FolioMercantil=='NULL' || FolioMercantil=='null') {
        mensaje ="Por favor llene el campo Folio Mercantil";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if ((documentoCargado=='' || documentoCargado=='NULL' || documentoCargado=='null') && caso=='0') {
        mensaje ="Por favor cargue el documento";
        cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (/[^A-Z-a-z ]/.test(RepresentanteLegal)) {
            mensaje ="Por favor escriba unicamente letras en el campo Representante Legal";
            cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (/[^A-Z-a-z ]/.test(AdministradorUnico)) {
            mensaje ="Por favor escriba unicamente letras en el campo Administrador Unico";
            cargarmensajeEscrituraPublica(mensaje, 'error');
    }
    else if (/[^A-Z-a-z ]/.test(NombreNotarioPublico)) {
            mensaje ="Por favor escriba unicamente letras en el campo Nombre Notario Publico";
            cargarmensajeEscrituraPublica(mensaje, 'error');
    }


    else{


formData.append('RepresentanteLegal',RepresentanteLegal);
formData.append('AdministradorUnico',AdministradorUnico);
formData.append('NumeroEscritura',NumeroEscritura);
formData.append('NombreNotarioPublico',NombreNotarioPublico);
formData.append('NumeroNotarioPublico',NumeroNotarioPublico);
formData.append('FechaEscrituraPublica',FechaEscrituraPublica);
formData.append('FolioMercantil',FolioMercantil);
formData.append('nombreDocumento',nombreDocumento);
formData.append('casoDocumento',casoDocumento);

$.ajax({
        type: "POST",
        url: "ajax_GuardarDocEscrituraPublica.php",
        data:formData, 
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        async:false, 
        success: function(response) {
            if(response.status == "success"){
               mensaje ="Actualizado Con Éxito";
               cargarmensajeEscrituraPublica(mensaje, 'success');
               obtenerEscrituraPublica();
             }
        },error:function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText);
          }
       });

    }

}


</script>



