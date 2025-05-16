<form class="form-inline"  method="post" id="form_registroCliente" action="ficheroExcelMovimientos.php" target="_blank" enctype='multipart/form-data'>
    <div align="center">
        <div  style="max-width: 100rem; border-style: groove; border-color: rgb(51,153,255); "><br>
            <b><h1>Registro de cliente</h1></b>
            <table>
                <tr>
                    <td  rowspan="14"><img src="img/clientes.jpg" width="330px"></td>
                    <td>
                        <div class= "row"  align="center">
                            <label class="control-label label" for="numCliente">Numero Cliente</label>
                            <input id="txtNumeroCliente" placeholder="0000-000-0000" name="txtNumeroCliente" type="text" class="span3 input-medium" maxlength="13" >
            
                            <label class="control-label label" for="NumeroContrato">Numero Contrato</label>
                            <select id="txtNumeroContrato" name="txtNumeroContrato" type="text" class="span3"></select>
            
                            <label class="control-label label" for="Anexo">Anexo Contrato</label>
                            <select id="txtAnexoContrato" name="txtAnexoContrato" type="text" class="span3"></select>
                        </div><br>
                        <div class= "row"  align="center">
                            <label class="control-label label" for="TipoContrato">Tipo Contrato</label>
                            <select id="txtTipoContrato" name="txtTipoContrato" type="text" class="input-medium"></select>
        
                            <label class="control-label label" for="ObjetoContrato">Objeto Contrato</label>
                            <input id="txtObjetoContrato" name="txtObjetoContrato" type="text" class="span3 input-medium">

                            <label class="control-label label" for="FechafinC">Fecha Fin Contrato</label>
                            <input id="txtFechafinC" name="txtFechafinC" type="date" class="span3 input-medium" readonly="true">
                        </div><br>
                        <div class= "row"  align="center">
                            <label class="control-label label" for="VigenciaAnio">Vigencia Contrato(Años)</label>
                            <select id="txtVigenciaAnio" name="txtVigenciaAnio" class="span3" onchange="GenerarFechaFinal();"></select>
            
                            <label class="control-label label" for="VigenciaMes">Vigencia Contrato(Meses)</label>
                            <select id="txtVigenciaMes" name="txtVigenciaMes" class="span3" onchange="GenerarFechaFinal();"></select>
            
                            <label class="control-label label" for="FechaInicioC">Fecha Inicio Contrato</label>
                            <input id="txtFechaInicioC" name="txtFechaInicioC" type="date" class="span3 input-medium" onchange="GenerarFechaFinal();">
                        </div><br>
                        <div class= "row"  align="center">
                    
                            <label class="control-label label" id="lblpersonaF">Persona Fisica</label>
                            <input id="CheckPersonaF" name="CheckPersonaF" type="checkbox" style="transform: scale(1.5);">

                            <label class="control-label label" id="lblpersonaM">Persona Moral</label>
                            <input id="CheckPersonaM" name="CheckPersonaM" type="checkbox" style="transform: scale(1.5);">
                         
                            <label class="control-label label" for="rfc" id="labelRfcCliente" style="display: none;">RFC(Razon Social)</label>
                            <input id="txtRfcCliente" name="txtRfcCliente" type="text" class="input-medium"  maxlength="12" style="display: none;">
        
                            <label class="control-label label" for="razonSocial">Razon Social</label>
                            <input id="txtRazonSocial" name="txtRazonSocial" type="text" class="span3 input-xlarge">
        
                            <label class="control-label label" for="RegistroPatronalC">Reg.patronal ante el IMSS</label>
                            <input id="txtRegistroPatronalC" name="txtRegistroPatronalC" type="text"  maxlength="11">
                        </div>
                        <div class= "row">
                            <h2 align="center" >Datos Cliente</h2>
                        </div>
                        <div  style="max-width: 75rem; border-style: outset; border-color: rgb(51,153,255); border-radius: 20px;"><br>
                            <div class= "row"  align="center">
                                <label class="control-label label" for="nombreComercial">Nombre Comercial</label>
                                <input id="txtNombreComercial" name="txtNombreComercial" type="text" class="span3 input-xlarge">
            
                                 <label class="control-label label" for="contacto">Nombre Contacto</label>
                                <input id="txtNombreContacto" name="txtNombreContacto" type="text" class="span3 input-xlarge">
            
                                <label class="control-label label" for="telefonoFijo">Telefono Fijo</label>
                                <input id="txtTelefonoFijoCliente" name="txtTelefonoFijoCliente" max="9999999999" type="number">
                            </div><br>
    
                            <div class= "row"  align="center">
                                <label class="control-label label" for="telefonoMovil">Telefono Movil</label>
                                <input id="txtTelefonoMovilCliente" name="txtTelefonoMovilCliente" type="number" max="9999999999">
            
                                <label class="control-label label" for="CpContrato">Codigo Postal</label>
                                <input id="txtCpContrato" name="txtCpContrato" class="span3 input-small" onkeyup="consultaCPCliente();" maxlength="5">
            
                                <label class="control-label label" for="Asentamiento">Asentamiento</label>
                                <select id="txtAsentamiento" name="txtAsentamiento" class="span3 input-xlarge "></select>
                            </div><br>

                            <div class= "row"  align="center">
                                <label class="control-label label" for="EntidadCliente">Entidad Federativa</label> 
                                <select id="txtEntidadCliente" name="txtEntidadCliente" onchange="TraerMunicipios(0);" class="span3 input-large"></select>

                                <label class="control-label label" for="Municipio">Municipio/Alcaldia</label>
                                <select id="txtMunicipio" name="txtMunicipio" onchange="TraerColonias(0);" type="text" class="span3 input-large"></select>

                                <label class="control-label label" for="ColoniaCliente">Colonia</label>
                                <select id="txtColoniaCliente" name="txtColoniaCliente" type="text" class="span3 input-large"></select>
                            </div><br>

                            <div class= "row"  align="center">
                                <label class="control-label label" for="CallePrincipal">Calle Principal</label>
                                <input id="txtCallePrincipal" name="txtCallePrincipal" type="text">

                                <label class="control-label label" for="NumeroExterior">Num Exterior</label>
                                <input id="txtNumeroExterior" name="txtNumeroExterior" type="text" class="span3 input-small">

                                <label class="control-label label" for="NumeroInteriro">Num Interior</label>
                                <input id="txtNumeroInteriro" name="txtNumeroInteriro" type="text" class="span3 input-small">
                            </div><br>

                            <div class= "row"  align="center">
                                <label class="control-label label" for="Calle1">Entre Calle</label>
                                <input id="txtCalle1" name="txtCalle1" type="text" >

                                <label class="control-label label" for="Calle2">Y Calle</label>
                                <input id="txtCalle2" name="txtCalle2" type="text">

                                <label class="control-label label" for="CorreoCliente">Correo Electronico</label>
                                <input id="txtCorreoCliente" name="txtCorreoCliente" type="text" placeholder="CorreoEjemplo@Extención.com" >
                            </div><br>

                            <div class= "row"  align="center">
                                <label class="control-label label" for="MontoContrato">Monto Del Contrato</label>
                                <input id="txtMontoContrato" name="txtMontoContrato" type="number" >

                                <label class="control-label label" for="txtArchivoContrato">Adjuntar Contrato (.PDF) </label>
                                <span class="btn btn-success btn-file" >Examinar
                                <input type='file' class='btn-success' id='txtArchivoContrato' name='txtArchivoContrato[]' multiple="" accept=".pdf"/>  
                                </span>

                                
                            </div><br>
                        </div><br>

                        <div class= "row">
                            <h2 align="center" >Datos Del Contratante</h2>
                        </div>
                        <div class= "row">
                            <h5 align="center" >Captura la información de la persona con la que se celebró el contrato. Los campos marcados con asterisco son obligatorios</h5>
                        </div>

                        <div  style="max-width: 75rem; border-style: outset; border-color: rgb(51,153,255); border-radius: 20px;"><br>
                            
                            <div class= "row"  align="center">
                                <label class="control-label label" for="RfcContratante">RFC Contratante*</label>
                                <input id="txtRfcContratante" name="txtRfcContratante" type="text" class="input-medium"  maxlength="13" >
                            </div><br>

                            <div class= "row"  align="center">
                                <label class="control-label label" for="NombreContratante">Nombre(s)*</label>
                                <input id="txtNombreContratante" name="txtNombreContratante" type="text" class="span3 input-xlarge">
            
                                <label class="control-label label" for="PrimerApellidoContratante">Primer Apellido*</label>
                                <input id="txtPrimerApellidoContratante" name="txtPrimerApellidoContratante" type="text" class="span3 input-xlarge">

                                <label class="control-label label" for="SegundoApellidoContratante">Segundo Apellido</label>
                                <input id="txtSegundoApellidoContratante" name="txtSegundoApellidoContratante" type="text" class="span3 input-xlarge">
                            </div><br>
    
                            <div class= "row"  align="center">
                                <label class="control-label label" for="CorreoContratante">Correo Electronico*</label>
                                <input id="txtCorreoContratante" name="txtCorreoContratante" type="text" placeholder="CorreoEjemplo@Extención.com" >

                                <label class="control-label label" for="TelMovilContratante">Telefono Movil*</label>
                                <input id="txtTelMovilContratante" name="txtTelMovilContratante" type="number" max="9999999999">

                                <label class="control-label label" for="TelFijoContratante">Telefono Fijo</label>
                                <input id="txtTelFijoContratante" name="txtTelFijoContratante" type="number" max="9999999999">
                            </div><br>
                        </div><br>
                        <div class= "row" align="center">
                            <button id="guardarCliente" name="guardarCliente" class="btn btn-primary" type="button" onclick="guardarCliente1();"> 
                            <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
                        </div><br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>


<script type="text/javascript">

$(Funcion_Ready_RegistrarCLiente());

function Funcion_Ready_RegistrarCLiente(){
  CargarSelectoresMAnuales();
}

function showMessage1 (mensaje, status)
{
    $("#msg").show ();
    if (status=="success") {

        alertMsg1="<div class='alert alert-success' id='msg' >"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
       
                $("#alertMsg").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msg').delay(4000).fadeOut('slow');
                $("#txtNumeroCliente").val('');
                $("#txtRfcCliente").val('');
                $("#txtRazonSocial").val('');
                $("#txtNombreComercial").val('');
                $("#txtNombreContacto").val('');
                $("#txtTelefonoFijoCliente").val('');
                $("#txtTelefonoMovilCliente").val('');
                $("#textarea").val('');
                $("#txtCorreoCliente").val('');
                $("#txtNumeroContrato").val(0);
                $("#txtTipoContrato").val(0);
                $("#txtObjetoContrato").val('');
                $("#txtVigenciaAnio").val(0);
                $("#txtVigenciaMes").val(0);
                $("#txtFechaInicioC").val('');
                $("#txtFechafinC").val('');
                $("#txtRegistroPatronalC").val('');
                $("#txtCpContrato").val('');
                $("#txtAsentamiento").val(0);
                $("#txtEntidadCliente").val(0);
                $("#txtMunicipio").val(0);
                $("#txtColoniaCliente").val(0);
                $("#txtCallePrincipal").val('');
                $("#txtNumeroInteriro").val('');
                $("#txtNumeroExterior").val('');
                $("#txtCalle1").val('');
                $("#txtCalle2").val('');
                $("#txtAnexoContrato").val("LETRAS");
                $("#txtMontoContrato").val("");
                $("#txtArchivoContrato").val("");
                $("#txtRfcContratante").val("");
                $("#txtNombreContratante").val("");
                $("#txtPrimerApellidoContratante").val("");
                $("#txtSegundoApellidoContratante").val("");
                $("#txtCorreoContratante").val("");
                $("#txtTelMovilContratante").val("");
                $("#txtTelFijoContratante").val("");
                CargarSelectoresMAnuales();
                obtenerListaClientes();

                            
    } else if (status=="error")
    {
        alertMsg1="<div class='alert alert-error' id='msg'><strong>Error en el registro de cliente:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
       
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msg').delay(3000).fadeOut('slow');
    }
    }


	function guardarCliente1()
    {
        var Persona;
        if($('#CheckPersonaF').is(":checked")) {
            Persona = "Persona Fisica";
        }else if($('#CheckPersonaM').is(":checked")) {
            Persona = "Persona Moral";
        }else{
            Persona = "0";
        } 
        var estatusCliente=1;
        var formData = new FormData($("#form_registroCliente")[0]);
        formData.append('estatusCliente', estatusCliente);
        formData.append('Persona', Persona);
        $.ajax({
            type: "POST",
            url: "ajax_registroCliente.php",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                var mensaje=response.message;
               showMessage1 (mensaje, response.status);
               // displayControlOfMovimientoPanel1 ();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });   
    }

  function CargarSelectoresMAnuales(){
    /////////////// Selector Numero De Contrato/meses/años //////////////
    $('#txtNumeroContrato').empty();
    $('#txtVigenciaAnio').empty();
    $('#txtVigenciaMes').empty();
    for(var i = 0; i < 12; i++){
        if(i < 11){
            $('#txtNumeroContrato').append("<option value="+i+">"+i+"</option>");
            $('#txtVigenciaAnio').append("<option value="+i+">"+i +" Años</option>");
        }
        $('#txtVigenciaMes').append("<option value="+i+">"+i+" Meses</option>");
    }
    //////////// Selector  Tipo De Contrato /Entidades/Colonias/Municipios//
    TraerTiposContratosClientes();
    TraerEntidades();
    //////////////////////////////////////////////////////////
    $('#txtMunicipio').empty().append('<option value="0">Municipios</option>');
    $('#txtColoniaCliente').empty().append('<option value="0">Colonias</option>');
    $('#txtAsentamiento').empty().append('<option value="0">Asentamiento</option>');
    $('#txtAnexoContrato').empty().append('<option>LETRAS</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option><option>L</option><option>M</option><option>N</option><option>Ñ</option><option>O</option><option>P</option><option>Q</option><option>R</option><option>S</option><option>T</option><option>U</option><option>V</option><option>W</option><option>X</option><option>Y</option><option>Z</option>');
  }

  function TraerTiposContratosClientes(){
    $.ajax({
        type: "POST",
        url: "ajax_TraerTiposContratosClientes.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtTipoContrato').empty().append('<option value="0">Tipo</option>');
          $.each(datos, function(i) {
            $('#txtTipoContrato').append('<option value="' + response.datos[i].idTipoContrato+ '">' + response.datos[i].Descripcion + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }
  function TraerEntidades(){
    $.ajax({
        type: "POST",
        url: "ajax_TraerEntidadesCliente.php",
        dataType: "json", 
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtEntidadCliente').empty().append('<option value="0">Entidades</option>');
          $.each(datos, function(i) {
            $('#txtEntidadCliente').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }
  function TraerMunicipios(Accion){
    $('#txtColoniaCliente').empty().append('<option value="0">Colonias</option>');
    if(Accion=="0"){
        $('#txtAsentamiento').val(0);
    }
    var txtEntidadCliente=$("#txtEntidadCliente").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerMunicipiosCliente.php",
        data: {txtEntidadCliente : txtEntidadCliente},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtMunicipio').empty().append('<option value="0">Municipios</option>');
          $.each(datos, function(i) {
            $('#txtMunicipio').append('<option value="' + response.datos[i].idMunicipio+ '">' + response.datos[i].nombreMunicipio + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }
  function TraerColonias(Accion){
    if(Accion=="0"){
        $('#txtAsentamiento').val(0);
    }
    var txtMunicipio=$("#txtMunicipio").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerColoniasCliente.php",
        data: {txtMunicipio : txtMunicipio},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtColoniaCliente').empty().append('<option value="0">Colonias</option>');
          $.each(datos, function(i) {
            $('#txtColoniaCliente').append('<option value="' + response.datos[i].idAsentamiento+ '">' + response.datos[i].nombreAsentamiento + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }
  function consultaCPCliente()
{
    var codigoPostal = $("#txtCpContrato").val();
    if (codigoPostal.length == 5)
    {
        $.ajax({
            type: "POST",
            url: "ajax_obtenerDirecciones.php",
            data: {txtCP : codigoPostal},
            dataType: "json",
            success: function(response) {
                if (response.listaDirecciones.length == 0)
                {   
                    showMessage1 ("El código postal es inválido", "error");
                }else 
                {
                    $('#txtAsentamiento').empty().append('<option value="0">Asentamiento</option>');
                    for (var i = 0; i < response.listaDirecciones.length; i++)
                    {
                        var direccion = response.listaDirecciones [i];
                        var params = "\"" + direccion.idAsentamiento + "\"," +
                            "\"" + direccion.nombreEntidadFederativa + "\"," +
                            "\"" + direccion.nombreMunicipio + "\"," +
                            "\"" + direccion.nombreAsentamiento + "\"," +
                            "\"" + direccion.municipioAsentamiento + "\"";
                        $('#txtAsentamiento').append('<option value="'+direccion.idAsentamiento+'&'+direccion.municipioAsentamiento+'&'+direccion.idEstado+'">' + params + '</option>');
                        /*displayDirecciones += "<p>" + (i + 1) + "<a href='javascript:setDireccionData(" + params + ")';>" +
                            direccion.nombreTipoAsentamiento + " " +
                            direccion.nombreAsentamiento + " " +
                            direccion.nombreMunicipio + ", " +
                            direccion.nombreEntidadFederativa + "</a></p>";*/
                    }
                   // $("#multipleDirecciones").html (displayDirecciones);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
        $('#txtEntidadCliente').val(0);
    $('#txtMunicipio').empty().append('<option value="0">Municipios</option>');
    $('#txtColoniaCliente').empty().append('<option value="0">Colonias</option>');
    }
}

$("#txtAsentamiento").change(function()
{
    var txtAsentamiento = $("#txtAsentamiento").val();
    var splitasentamiento = txtAsentamiento.split('&'); 
    var idColonia = splitasentamiento[0];
    var idmunicipio = splitasentamiento[1];
    var idEntidad = splitasentamiento[2];
    $("#txtEntidadCliente").val(idEntidad);
    TraerMunicipios(1);
    $("#txtMunicipio").val(idmunicipio);
    TraerColonias(1);
    $("#txtColoniaCliente").val(idColonia);

});

function GenerarFechaFinal(){
    var txtVigenciaAnio =$("#txtVigenciaAnio").val();
    var txtVigenciaMes =$("#txtVigenciaMes").val();
    var txtFechaInicioC =$("#txtFechaInicioC").val();
    var nuevafecha = new Date(txtFechaInicioC);
    if((txtVigenciaAnio!="0" || txtVigenciaMes!="0") && txtFechaInicioC!=""){
        var totalmesesanios = txtVigenciaAnio*12;
        var totalmeses = (parseInt(totalmesesanios) + parseInt(txtVigenciaMes));
        nuevafecha.setMonth(nuevafecha.getMonth() + totalmeses);
        dia = nuevafecha.getDate();
        if(dia <= "9"){
            dia = "0"+dia;
        }
        mes = parseInt(nuevafecha.getMonth()) + 1;
        if(mes <= "9"){
            mes = "0" + mes; 
        } 
        ano = nuevafecha.getFullYear();
        var fechafin = ano + "-" + mes + "-" + dia; 
        $("#txtFechafinC").val(fechafin);
    }  
}

// se implemneta persona fisica y persona moral en datos del contratante

$('#CheckPersonaF').change(function() {
    if($('#CheckPersonaF').is(":checked")) {
        $("#CheckPersonaM").prop("checked", false);  
        $("#txtRfcCliente").val("");
        document.getElementById("txtRfcCliente").setAttribute("maxlength", "13");
        $("#labelRfcCliente").show();
        $("#txtRfcCliente").show();
    }else {
        $("#txtRfcCliente").val("");
        $("#labelRfcCliente").hide();
        $("#txtRfcCliente").hide();

    }
});

$('#CheckPersonaM').change(function() {
    if($('#CheckPersonaM').is(":checked")) {
        $("#CheckPersonaF").prop("checked", false);  
        $("#txtRfcCliente").val("");
        document.getElementById("txtRfcCliente").setAttribute("maxlength", "12");
        $("#labelRfcCliente").show();
        $("#txtRfcCliente").show();
    }else {
        $("#txtRfcCliente").val("");
        $("#labelRfcCliente").hide();
        $("#txtRfcCliente").hide();
    }
});




</script>