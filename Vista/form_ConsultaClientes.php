<div align="center">
    <form class="form-horizontal"  method="post" id="form_catalogoClientes" action="ficheroExcelMovimientos.php" target="_blank">
    	<fieldset ><legend>Catalogo Clientes </legend></fieldset>

        <div id="divTablaCatalogoClientes" style="display: none;">
          <table id="tablaCatalogoClientes"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th style="text-align: center;background-color: #B0E76E">Cuenta Contabilidad</th>
                      <th style="text-align: center;background-color: #B0E76E">Razon Social</th>
                      <th style="text-align: center;background-color: #B0E76E">Nombre Comercial</th>
                      <th style="text-align: center;background-color: #B0E76E">RFC Cliente</th>
                      <th style="text-align: center;background-color: #B0E76E">Nombre Contacto</th> 
                      <th style="text-align: center;background-color: #B0E76E">Tel Fijo</th> 
                      <th style="text-align: center;background-color: #B0E76E">Tel movil</th> 
                      <th style="text-align: center;background-color: #B0E76E">Correo</th> 
                      <th style="text-align: center;background-color: #B0E76E">Dirección Fiscal</th> 
                      <th style="text-align: center;background-color: #B0E76E">Editar Cliente</th> 
                      <th style="text-align: center;background-color: #B0E76E">Editar Contrato</th> 
                      <th style="text-align: center;background-color: #B0E76E">Nuevo Contrato</th> 
                  </tr>
              </thead>
          </table>
        </div>

        <div id="consultaClientes"></div>

        <div id="modalSeleccionarContrato" name="modalSeleccionarContrato" class="modalEdit fade" role="dialog" style="margin-left: -16%; width: 55%; height: 50%;display: none;" >
            <div id="msjErrorSeleccionarContrato"></div>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1"> <img src="img/warning.png">Selecciona EL Contrato A Editar !!!</h4>
            </div>
            <div class="modal-body">
                <div class="input-prepend">
                    <span class="add-on">Contrato</span>
                    <select id="txtContratoAEditar1" name="txtContratoAEditar1" type="text" class="span3 input-large"></select>
                </div><br><br>

                <div class="input-prepend">
                    <span class="add-on">Numero Cliente</span>
                    <input id="txtNumeroAEditar" readonly="true" placeholder="0000-000-000" name="txtNumeroAEditar" type="text" class="span3 input-medium" maxlength="12" >

                    <span class="add-on">Razon Social</span>
                    <input id="txtRazonSocialAEditar" readonly="true" name="txtRazonSocialAEditar" type="text" class="span3 input-xlarge">
        
                    <span class="add-on">Reg.patronal ante el IMSS</span>
                    <input id="txtRegistroPatronalv" name="txtRegistroPatronalv" type="text"  maxlength="11" readonly="true"> 
                </div><br><br>

                 <div class="input-prepend">
                    <span class="add-on">Tipo Contrato</span>
                    <input id="txtTipov" name="txtTipov" type="text" class="span3 input-medium"  readonly="true">
        
                    <span class="add-on">Objeto Contrato</span>
                    <input id="txtObjetov" name="txtObjetov" type="text" class="span3 input-medium"  readonly="true">

                    <span class="add-on">Fecha Fin Contrato</span>
                    <input id="txtFechafinv" name="txtFechafinv" type="date" class="span3 input-medium" readonly="true">
                </div><br><br>

                <div class="input-prepend">
                    <span class="add-on">Vigencia Contrato(Años)</span>
                    <input id="txtVigenciaAniov" name="txtVigenciaAniov" type="text" class="span3 input-medium"  readonly="true">

            
                    <span class="add-on">Vigencia Contrato(Meses)</span>
                    <input id="txtVigenciaMesv" name="txtVigenciaMesv" type="text" class="span3 input-medium"  readonly="true">

            
                    <span class="add-on">Fecha Inicio Contrato</span>
                    <input id="txtFechaIniciov" name="txtFechaIniciov" type="date" class="span3 input-medium"  readonly="true">
                </div><br><br>
            </div>
            <div class="modal-footer">
                <button id="ContinuarEdicion" name="ContinuarEdicion" class="btn btn-primary" type="button" onclick="ContinuarEdicion1();"> 
                <span class="glyphicon glyphicon-floppy-save"></span>Continuar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

        <div id="modalEditarCliente" name="modalEditarCliente" class="modalEdit fade fade" role="dialog"  style="margin-left: -16%; width: 55%; height: 80%;display: none;" >
            <div id="msjErrorModalEditarCliente"></div>
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">Edición Del Cliente !!!</h4>
            </div>
            <div class="modal-body">
                <div class="input-prepend" >
                    <span class="add-on">Numero Cliente</span>
                    <input id="txtNumeroClienteEditarCliente" readonly="true" placeholder="0000-000-000" name="txtNumeroClienteEditarCliente" type="text" class="span3 input-medium" maxlength="12" >
    
                    <span class="add-on" id="NumeroEditarCliente">Numero Contrato</span>
                    <select id="txtNumeroEditarCliente" name="txtNumeroEditarCliente" title="Por Favor Verifica La Estructura Del Contrato" type="text" class="span3"></select>
    
                    <span class="add-on" id="AnexoEditarCliente">Anexo Contrato</span>
                    <select id="txtAnexoEditarCliente" name="txtAnexoEditarCliente" title="Por Favor Verifica La Estructura Del Contrato" type="text" class="span3"></select>
                </div><br>

                <div class="input-prepend" id="DivUno">
                    <span class="add-on" >Tipo Contrato</span>
                    <select id="txtTipoEditarCliente" name="txtTipoEditarCliente" type="text" class="input-medium"></select>
        
                    <span class="add-on">Objeto Contrato</span>
                    <input id="txtObjetoEditarCliente" name="txtObjetoEditarCliente" type="text" class="span3 input-medium">

                    <span class="add-on">Fecha Fin Contrato</span>
                    <input id="txtFechafinEditarCliente" name="txtFechafinEditarCliente" type="date" class="span3 input-medium" readonly="true">
                </div><br>

                <div class="input-prepend" id="DivDos">
                    <span class="add-on">Vigencia Contrato(Años)</span>
                    <select id="txtVigenciaAnioEditarCliente" name="txtVigenciaAnioEditarCliente" class="span3 input-medium" onchange="GenerarFechaFinalEditarCliente();"></select>
            
                    <span class="add-on">Vigencia Contrato(Meses)</span>
                    <select id="txtVigenciaMesEditarCliente" name="txtVigenciaMesEditarCliente" class="span3 input-medium" onchange="GenerarFechaFinalEditarCliente();"></select>
            
                    <span class="add-on">Fecha Inicio Contrato</span>
                    <input id="txtFechaInicioEditarCliente" name="txtFechaInicioEditarCliente" type="date" class="span3 input-small" onchange="GenerarFechaFinalEditarCliente();">
                </div><br>

                <div class="input-prepend">
                    <span class="add-on">RFC(Razon Social)</span>
                    <input id="txtRfcEditarCliente" readonly="true" name="txtRfcEditarCliente" type="text" class="input-medium"  maxlength="12" >
        
                    <span class="add-on">Razon Social</span>
                    <input id="txtRazonSocialEditarCliente" readonly="true" name="txtRazonSocialEditarCliente" type="text" class="span3 input-xlarge">
        
                    <span class="add-on" id="RegistroPatronalEditarCliente">Reg.patronal ante el IMSS</span>
                    <input id="txtRegistroPatronalEditarCliente" name="txtRegistroPatronalEditarCliente" type="text"  maxlength="11">
                </div><br>

                <div class="input-prepend" id="diveditpdf" style="display: none;">
                <div class="input-prepend">
                    <h3 align="center" >Contrato Actual</h3>
                </div><br>
                    <img src="img/pdf.jpg" width="10%" onclick="abrirDocumentoPDF();"/>
                    <br><br>
                    <span id="SpamArchivo2" class="add-on">Editar Contrato (.PDF)</span>
                    <input type='file' class='btn-success' id='contratoEditado' name='contratoEditado[]' multiple="" accept=".pdf"/>
                </div><br>
                <br><br>
                <div class="input-prepend">
                    <h3 align="center" >Datos Cliente</h3>
                </div><br>
                <div class="input-prepend">
                    <span class="add-on">Nombre Comercial</span>
                    <input id="txtNombreComercialEditarCliente" readonly="true" name="txtNombreComercialEditarCliente" type="text" class="span3 input-xlarge">
            
                    <span class="add-on">Nombre Contacto</span>
                    <input id="txtNombreContactoEditarCliente" name="txtNombreContactoEditarCliente" type="text" class="span3 input-xlarge">
            
                    <span class="add-on">Telefono Fijo</span>
                    <input id="txtTelefonoFijoEditarCliente" name="txtTelefonoFijoEditarCliente" max="9999999999" type="number">
                </div><br>

                <div class="input-prepend">
                    <span class="add-on">Telefono Movil</span>
                    <input id="txtTelefonoMovilEditarCliente" name="txtTelefonoMovilEditarCliente" type="number" max="9999999999">
            
                    <span class="add-on">Codigo Postal</span>
                    <input id="txtCpContratoEditarCliente" name="txtCpContratoEditarCliente" onkeyup="consultaCpEditarCliente();" maxlength="5">
            
                    <span class="add-on">Asentamiento</span>
                    <select id="txtAsentamientoEditarCliente" name="txtAsentamientoEditarCliente" class="span3 input-xlarge "></select>
                </div><br>

                <div class="input-prepend">
                    <span class="add-on">Entidad Federativa</span>
                    <select id="txtEntidadEditarCliente" name="txtEntidadEditarCliente" onchange="TraerMunicipiosEditarCliente(0);" class="span3 input-large"></select>

                    <span class="add-on">Municipio/Alcaldia</span>
                    <select id="txtMunicipioEditarCliente" name="txtMunicipioEditarCliente" onchange="TraerColoniasEditarCliente(0);" type="text" class="span3 input-large"></select>

                    <span class="add-on">Colonia</span>
                    <select id="txtColoniaEditarCliente" name="txtColoniaEditarCliente" type="text" class="span3 input-large"></select>
                </div><br>

                <div class="input-prepend">
                    <span class="add-on">Calle Principal</span>
                    <input id="txtCallePrincipalEditarCliente" name="txtCallePrincipalEditarCliente" type="text">

                    <span class="add-on">Num Exterior</span>
                    <input id="txtNumeroExteriorEditarCliente" name="txtNumeroExteriorEditarCliente" type="text" class="span3 input-small">

                    <span class="add-on">Num Interior</span>
                    <input id="txtNumeroInteriroEditarCliente" name="txtNumeroInteriroEditarCliente" type="text" class="span3 input-small">
                </div><br>

                <div class="input-prepend">
                    <span class="add-on">Entre Calle</span>
                    <input id="txtCalle1EditarCliente" name="txtCalle1EditarCliente" type="text" >

                    <span class="add-on">Y Calle</span>
                    <input id="txtCalle2EditarCliente" name="txtCalle2EditarCliente" type="text">

                    <span class="add-on">Correo Electronico</span>
                    <input id="txtCorreoEditarCliente" name="txtCorreoEditarCliente" type="text" placeholder="CorreoEjemplo@Extención.com" >
                </div><br>

                <div class="input-prepend" id="DivTres">
                    <span class="add-on">Monto Del Contrato</span>
                    <input id="txtMontotxtCorreoEditarCliente" name="txtMontotxtCorreoEditarCliente" type="number" >

                    <span id="SpamArchivo1" class="add-on">Adjuntar Contrato (.PDF)</span>
                    <input type='file' class='btn-success' id='txtArchivoEditarCliente' name='txtArchivoEditarCliente[]' multiple="" accept=".pdf"/>
                </div><br>

                <div class="input-prepend" id="DivCuatro">
                    <h3 align="center" >Datos Del Contratante</h3>
                </div><br>
                <div class="input-prepend" id="DivCinco">
                    <h5 align="center" >Captura la información de la persona con la que se celebró el contrato. Los campos marcados con asterisco son obligatorios</h5>
                </div><br>
                <div class="input-prepend" id="DivSeis">
                    <span class="add-on">RFC Contratante*</span>
                    <input id="txtRfcContratantetxtCorreoEditarCliente" name="txtRfcContratantetxtCorreoEditarCliente" type="text" class="input-medium"  maxlength="13" >
                </div><br>
                <div class="input-prepend" id="DivSiete">
                    <span class="add-on">Nombre(s)*</span>
                    <input id="txtNombreContratantetxtCorreoEditarCliente" name="txtNombreContratantetxtCorreoEditarCliente" type="text" class="span3 input-xlarge">
            
                    <span class="add-on">Primer Apellido*</span>
                    <input id="txtPrimerApellidoContratantetxtCorreoEditarCliente" name="txtPrimerApellidoContratantetxtCorreoEditarCliente" type="text" class="span3 input-xlarge">

                    <span class="add-on">Segundo Apellido</span>
                    <input id="txtSegundoApellidoContratantetxtCorreoEditarCliente" name="txtSegundoApellidoContratantetxtCorreoEditarCliente" type="text" class="span3 input-xlarge">
                </div><br>
                <div class="input-prepend" id="DivOcho">
                    <span class="add-on">Correo Electronico*</span>
                    <input id="txtCorreoContratantetxtCorreoEditarCliente" name="txtCorreoContratantetxtCorreoEditarCliente" type="text" placeholder="CorreoEjemplo@Extención.com" >

                    <span class="add-on">Telefono Movil*</span>
                    <input id="txtTelMovilContratantetxtCorreoEditarCliente" name="txtTelMovilContratantetxtCorreoEditarCliente" type="number" max="9999999999">

                    <span class="add-on">Telefono Fijo</span>
                    <input id="txtTelFijoContratantetxtCorreoEditarCliente" name="txtTelFijoContratantetxtCorreoEditarCliente" type="number" max="9999999999">
                </div><br>
            </div>
            <div class="modal-footer">
                <button id="guardarActualizarContrato" name="guardarActualizarContrato" class="btn btn-primary" type="button" onclick="ActualzarGurdarContrato();"> 
                <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
            <input id="BanderaCliente" name="BanderaCliente" type="hidden" class="span3 input-xlarge">
            <input id="idCliente" name="idCliente" type="hidden" class="span3 input-xlarge">
            <input id="idContratoCliente" name="idContratoCliente" type="hidden" class="span3 input-xlarge">

            <input id="claveNominaHidden" name="claveNominaHidden" type="hidden" class="span3 input-xlarge">
            <input id="accionHidden" name="accionHidden" type="hidden" class="span3 input-xlarge">
            <input id="NumEmpModalNCHodden" name="NumEmpModalNCHodden" type="hidden" class="span3 input-xlarge">
            <input id="contraseniaInsertadaCifradaHodden" name="contraseniaInsertadaCifradaHodden" type="hidden" class="span3 input-xlarge">

        </div>

    </form>
</div>

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaNuevoContrato" id="modalFirmaElectronicaNuevoContrato" data-backdrop="static" style="display:none;">
  <div id="errorModalFirmaNuevoContrato"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escriba su numero de empleado y la contraseña que generó!!!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaNuevoContrato" class="input-medium" name="NumEmpModalFirmaNuevoContrato" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaNuevoContrato" class="input-xlarge"name="constraseniaFirmaNuevoContrato" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarNuevoContrato" name="btnFirmarNuevoContrato" onclick="RevisarFirmaInternaNuevoContrato();" class="btn btn-primary">Firmar</button>
        <button type="button" id="btnCancelarNuevoContrato" name="btnCancelarNuevoContrato"onclick="cancelarFirmaNuevoContrato();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">

var datosCliente=[];
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioConsultaClientes());  

function inicioConsultaClientes(){
    if(rolUsuario=="Ventas" || rolUsuario == "Administracion Seguridad Electronica"){
            obtenerListaClientes();
            CargarCatalogosManualesEdicionCLiente();
        }
}

function cancelarFirmaNuevoContrato(){
    $("#NumEmpModalFirmaNuevoContrato").val("");
    $("#constraseniaFirmaNuevoContrato").val("");
    $("#modalFirmaElectronicaNuevoContrato").modal('hide');
}

    function abrirDocumentoPDF(){

        var numeroCliente=$("#txtNumeroClienteEditarCliente").val();
        var tipovPdf=$("#txtNumeroEditarCliente").val();
        var anexo=$("#txtAnexoEditarCliente").val();
        var fechaInicioCompleta= $("#txtFechaInicioEditarCliente").val();
        var fechaseparada = fechaInicioCompleta.split("-", 3);
        var dia=fechaseparada[2];
        var mes=fechaseparada[1];
        var anio=fechaseparada[0];
        window.open("uploads/ContratosClientes/"+numeroCliente+"/Contrato_"+numeroCliente+"_"+tipovPdf+"_"+anexo+"_"+anio+"-"+mes+"-"+dia+".pdf");
    }

    function obtenerListaClientes(){
        tablaCatCl = [];

        $.ajax({
            type: "POST",
            url: "ajax_obtenerListaClientes.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var listaClientes = response.listaClientes;
                    // listaClientesTable="<table class='table table-hover' id='Exportar_a_Excel1'><thead><th>Cuenta Contabilidad.</th><th>Razon Social</th><th>Nombre Comercial</th><th>RFC Cliente</th><th>Nombre Contacto</th><th>Tel Fijo</th>";
                    // listaClientesTable +="<th>Tel Movil</th><th>Correo</th><th>Dirección Fiscal</th><th>Editar Cliente</th><th>Editar Contrato</th><th>Nuevo Contrato</th></thead><tbody>";
                    for ( var i = 0; i < listaClientes.length; i++ ){
                        var record = response.listaClientes[i];
                        tablaCatCl.push(record);
                    	/*var claveNomina = listaClientes[i].claveClienteNomina;
                        var razonSocial = listaClientes[i].razonSocial;
                        var nombreComercial = listaClientes[i].nombreComercial;
                        var rfcCliente = listaClientes[i].rfcCliente;
                        var contactoCliente = listaClientes[i].contactoCliente;
                        var telefonoFijoCliente =listaClientes[i].telefonoFijoCliente;
                        var telefonoMovilCliente= listaClientes[i].telefonoMovilCliente;
                        var correoCliente = listaClientes[i].correoCliente;
                        var estatusCliente=listaClientes[i].estatusCliente;
                        var direccionFiscalCliente=listaClientes[i].direccionFiscalCliente1;
                       /* if (estatusCliente ==1 ){
                            imgRuta="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/Ok-icon1.png";
                        }
                        else if(estatusCliente ==0){
                            imgRuta="http://<?php echo $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/cancel.png";
                        }*/
                        // listaClientesTable += "<tr><td>"+claveNomina+" </td><td>"+razonSocial+" </td><td>"+nombreComercial+"</td><td>"+rfcCliente+"</td><td>"+contactoCliente+"</td><td>"+telefonoFijoCliente+"</td><td>"+telefonoMovilCliente+"</td><td>"+correoCliente+"</td><td>"+direccionFiscalCliente+"</td><td><img style='width: 40%' title='Editar Cliente' src='img/clients.png' class='cursorImg' id='btnCLienteEdit' onclick=EditarContratosIniciales('"+claveNomina+"',2)></td><td><img style='width: 40%' title='Editar Contrato' src='img/edit.png' class='cursorImg' id='btnPapeleta' onclick=EditarContratosIniciales('"+claveNomina+"',0)></td><td><img style='width: 30%' title='Agregar Un Nuevo Contrato' src='img/addMenu.png' class='cursorImg' onclick=EditarContratosIniciales('"+claveNomina+"',1)></td><td></td><td></td>";
                    }       
                    // listaClientesTable += "</tbody></table>";
                    // $('#consultaClientes').html(listaClientesTable); 
                    /////////////////////////

                   $("#divTablaCatalogoClientes").show();
                   CargarTablaCatClientes(tablaCatCl);    
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
    }

    function EditarContratosInicialesEDIT(claveNomina,Accion){
        ReestablecerCampos();
        // var claveNomina=$("#claveNominaHidden").val();
        // var Accion=$("#accionHidden").val();
        $.ajax({
            type: "POST",
            url: "ajax_GetDatosClientePorClave.php",
            data: {"claveNomina" : claveNomina},
            dataType: "json",
            success: function(response) {
                var datosCliente1 = response.datos; 
                datosCliente=datosCliente1;
                var largodatos = datosCliente1.length;
                var DatoARevisar = datosCliente1[0].idContratoCliente;
                var nombreComercial = datosCliente1[0].nombreComercial;
                if(Accion == "0" && largodatos=="1" && (DatoARevisar=="" || DatoARevisar=="null" || DatoARevisar=="NULL" || DatoARevisar==null)){
                    alert("El Cliente "+nombreComercial+" No Cuenta Con Ningun Contrato Ingresado Por Favor Capture Todos Los Datos Requeridos");
                    $("#BanderaCliente").val(1);
                    AccionARealizarPorConsulta(0);
                }else if(Accion == "0" && largodatos=="1" && DatoARevisar!="" && DatoARevisar!="null" && DatoARevisar!="NULL" && DatoARevisar!=null){  
                    alert("El Cliente "+nombreComercial+" Ya Cuenta Un Contrato Ingresado Por Favor Modifique Solo Los Campos Requeridos");
                    $("#BanderaCliente").val(2); 
                    AccionARealizarPorConsulta(0);
                    $("#diveditpdf").show();
                }else if(Accion == "0" && largodatos>"1"){
                    alert("El Cliente "+nombreComercial+" Cuenta Con Mas De Un Contrato Ingresado Por Favor Seleccione El Contratos A Modifiar Y Solo Cambie Los Campos Requeridos");
                    $("#BanderaCliente").val(3);
                    AccionARealizarPorConsultaModal();
                    $("#diveditpdf").show();
                }else if(Accion=="1"){
                    $("#BanderaCliente").val(4); 
                    AccionARealizarPorConsulta(0);
                    $("#diveditpdf").hide();
                }else if(Accion=="2"){
                    $("#BanderaCliente").val(5); 
                    AccionARealizarPorConsulta(0);
                    $("#diveditpdf").hide();
                }                
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        }); 
        
    }


    function EditarContratosIniciales(NumEmpModalNC,contraseniaInsertadaCifrada){
        ReestablecerCampos();
        var claveNomina=$("#claveNominaHidden").val();
        var Accion=$("#accionHidden").val();
        $.ajax({
            type: "POST",
            url: "ajax_GetDatosClientePorClave.php",
            data: {"claveNomina" : claveNomina},
            dataType: "json",
            success: function(response) {
                var datosCliente1 = response.datos; 
                datosCliente=datosCliente1;
                var largodatos = datosCliente1.length;
                var DatoARevisar = datosCliente1[0].idContratoCliente;
                var nombreComercial = datosCliente1[0].nombreComercial;
                if(Accion == "0" && largodatos=="1" && (DatoARevisar=="" || DatoARevisar=="null" || DatoARevisar=="NULL" || DatoARevisar==null)){
                    alert("El Cliente "+nombreComercial+" No Cuenta Con Ningun Contrato Ingresado Por Favor Capture Todos Los Datos Requeridos");
                    $("#BanderaCliente").val(1);
                    AccionARealizarPorConsulta(0);
                }else if(Accion == "0" && largodatos=="1" && DatoARevisar!="" && DatoARevisar!="null" && DatoARevisar!="NULL" && DatoARevisar!=null){  
                    alert("El Cliente "+nombreComercial+" Ya Cuenta Un Contrato Ingresado Por Favor Modifique Solo Los Campos Requeridos");
                    $("#BanderaCliente").val(2); 
                    AccionARealizarPorConsulta(0);
                    $("#diveditpdf").show();
                }else if(Accion == "0" && largodatos>"1"){
                    alert("El Cliente "+nombreComercial+" Cuenta Con Mas De Un Contrato Ingresado Por Favor Seleccione El Contratos A Modifiar Y Solo Cambie Los Campos Requeridos");
                    $("#BanderaCliente").val(3);
                    AccionARealizarPorConsultaModal();
                    $("#diveditpdf").show();
                }else if(Accion=="1"){
                    $("#BanderaCliente").val(4); 
                    AccionARealizarPorConsulta(0);
                    $("#diveditpdf").hide();
                }else if(Accion=="2"){
                    $("#BanderaCliente").val(5); 
                    AccionARealizarPorConsulta(0);
                    $("#diveditpdf").hide();
                }                
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        }); 
        
    }
    function ReestablecerCampos()
    {
        $("#contratoEditado").val("");
        $("#txtNumeroClienteEditarCliente").val("");
        $("#txtRfcEditarCliente").val("");
        $("#txtRazonSocialEditarCliente").val("");
        $("#txtNombreComercialEditarCliente").val("");
        $("#txtNombreContactoEditarCliente").val("");
        $("#txtTelefonoFijoEditarCliente").val("");
        $("#txtTelefonoMovilEditarCliente").val("");
        $("#txtCorreoEditarCliente").val("");
        $("#idCliente").val("");
        $("#txtNumeroEditarCliente").val(0);
        $("#txtAnexoEditarCliente").val("LETRAS");
        $("#txtTipoEditarCliente").val(0);
        $("#txtObjetoEditarCliente").val("");
        $("#txtFechafinEditarCliente").val("");
        $("#txtVigenciaAnioEditarCliente").val(0);
        $("#txtVigenciaMesEditarCliente").val(0);
        $("#txtFechaInicioEditarCliente").val("");
        $("#txtRegistroPatronalEditarCliente").val("");
        $("#txtCpContratoEditarCliente").val("");
        $("#txtEntidadEditarCliente").val(0);
        $("#txtMunicipioEditarCliente").val(0);
        $("#txtColoniaEditarCliente").val(0);
        $("#txtCallePrincipalEditarCliente").val("");
        $("#txtNumeroInteriroEditarCliente").val("");
        $("#txtNumeroExteriorEditarCliente").val("");
        $("#txtCalle1EditarCliente").val("");
        $("#txtCalle2EditarCliente").val("");
        $("#txtMontotxtCorreoEditarCliente").val("");
        $("#txtRfcContratantetxtCorreoEditarCliente").val("");
        $("#txtNombreContratantetxtCorreoEditarCliente").val("");
        $("#txtPrimerApellidoContratantetxtCorreoEditarCliente").val("");
        $("#txtSegundoApellidoContratantetxtCorreoEditarCliente").val("");
        $("#txtCorreoContratantetxtCorreoEditarCliente").val("");
        $("#txtTelMovilContratantetxtCorreoEditarCliente").val("");
        $("#txtTelFijoContratantetxtCorreoEditarCliente").val("");
        $("#contratoEditado").val("");

        $("#txtNumeroAEditar").val("");   
        $("#txtRazonSocialAEditar").val("");
        $("#txtRegistroPatronalv").val("");
        $("#txtTipov").val("");
        $("#txtObjetov").val("");
        $("#txtFechafinv").val("");
        $("#txtVigenciaAniov").val("");
        $("#txtVigenciaMesv").val("");
        $("#txtFechaIniciov").val("");
        $("#idContratoCliente").val("");
        $("#txtNumeroEditarCliente").prop("disabled",false);
        $("#txtAnexoEditarCliente").prop("disabled",false);
        $("#txtVigenciaAnioEditarCliente").prop("disabled",false);
        $("#txtVigenciaMesEditarCliente").prop("disabled",false);
        $("#txtFechaInicioEditarCliente").prop("disabled",false);

        $("#txtCorreoEditarCliente").prop("readonly",true);
        $("#txtCpContratoEditarCliente").prop("readonly",true);
        $("#txtAsentamientoEditarCliente").prop("disabled",true);
        $("#txtEntidadEditarCliente").prop("disabled",true);
        $("#txtMunicipioEditarCliente").prop("disabled",true);
        $("#txtColoniaEditarCliente").prop("disabled",true);
        $("#txtCallePrincipalEditarCliente").prop("readonly",true);
        $("#txtNumeroInteriroEditarCliente").prop("readonly",true);
        $("#txtNumeroExteriorEditarCliente").prop("readonly",true);
        $("#txtCalle1EditarCliente").prop("readonly",true);
        $("#txtCalle2EditarCliente").prop("readonly",true);
        $("#txtTelefonoMovilEditarCliente").prop("readonly",true);
        $("#txtTelefonoFijoEditarCliente").prop("readonly",true);

        $("#txtArchivoEditarCliente").show();
        $("#SpamArchivo1").show();
        $("#ContinuarEdicion").hide();
        $("#txtNombreContactoEditarCliente").prop("readonly",true);
        $("#NumeroEditarCliente").show();
        $("#txtNumeroEditarCliente").show();
        $("#AnexoEditarCliente").show();
        $("#txtAnexoEditarCliente").show();
        $("#DivUno").show();
        $("#DivDos").show();
        $("#RegistroPatronalEditarCliente").show();
        $("#txtRegistroPatronalEditarCliente").show();
        $("#DivTres").show();
        $("#DivCuatro").show();
        $("#DivCinco").show();
        $("#DivSeis").show();
        $("#DivSiete").show();
        $("#DivOcho").show();

        // $("#claveNominaHidden").val("");
        // $("#accionHidden").val("");
        // $("#NumEmpModalFirmaNuevoContrato").val("");
        // $("#constraseniaFirmaNuevoContrato").val("");
    }


    function AccionARealizarPorConsulta(Posicion){
        var Opcion = $("#BanderaCliente").val();
        $("#txtNumeroClienteEditarCliente").val(datosCliente[Posicion].claveClienteNomina);
        $("#txtRfcEditarCliente").val(datosCliente[Posicion].rfcCliente);
        $("#txtRazonSocialEditarCliente").val(datosCliente[Posicion].razonSocial);
        $("#txtNombreComercialEditarCliente").val(datosCliente[Posicion].nombreComercial);
        $("#txtNombreContactoEditarCliente").val(datosCliente[Posicion].contactoCliente);
        $("#txtTelefonoFijoEditarCliente").val(datosCliente[Posicion].telefonoFijoCliente);
        $("#txtTelefonoMovilEditarCliente").val(datosCliente[Posicion].telefonoMovilCliente);
        $("#txtCorreoEditarCliente").val(datosCliente[Posicion].correoCliente);
        $("#idCliente").val(datosCliente[Posicion].idCliente);
        if(Opcion=="2" || Opcion=="3"){
            $("#txtNumeroEditarCliente").val(datosCliente[Posicion].NumeroContrato);
            $("#txtAnexoEditarCliente").val(datosCliente[Posicion].AnexoNumCliente);
            $("#txtTipoEditarCliente").val(datosCliente[Posicion].TipoContrato);
            $("#txtObjetoEditarCliente").val(datosCliente[Posicion].ObjetoContrato);
            $("#txtFechafinEditarCliente").val(datosCliente[Posicion].FechaFinalC);
            $("#txtVigenciaAnioEditarCliente").val(datosCliente[Posicion].VigenciaAnios);
            $("#txtVigenciaMesEditarCliente").val(datosCliente[Posicion].ViegenciaMeses);
            $("#txtFechaInicioEditarCliente").val(datosCliente[Posicion].FechaInicioC);
            $("#txtRegistroPatronalEditarCliente").val(datosCliente[Posicion].RegistroPatronal);
            $("#txtCpContratoEditarCliente").val(datosCliente[Posicion].CodigoPostalC);
            consultaCpEditarCliente();
            $("#txtEntidadEditarCliente").val(datosCliente[Posicion].EntidadC);
            TraerMunicipiosEditarCliente(0);
            $("#txtMunicipioEditarCliente").val(datosCliente[Posicion].MunicipioC);
            TraerColoniasEditarCliente(0);
            $("#txtColoniaEditarCliente").val(datosCliente[Posicion].ColoniaC);
            $("#txtCallePrincipalEditarCliente").val(datosCliente[Posicion].CallePrincipaC);
            $("#txtNumeroInteriroEditarCliente").val(datosCliente[Posicion].NumeroInterirC);
            $("#txtNumeroExteriorEditarCliente").val(datosCliente[Posicion].NumeroExteriorC);
            $("#txtCalle1EditarCliente").val(datosCliente[Posicion].PrimerCalle);
            $("#txtCalle2EditarCliente").val(datosCliente[Posicion].SegundaCalle);
            $("#txtMontotxtCorreoEditarCliente").val(datosCliente[Posicion].MontoContrato);
            $("#txtRfcContratantetxtCorreoEditarCliente").val(datosCliente[Posicion].RfcContratante);
            $("#txtNombreContratantetxtCorreoEditarCliente").val(datosCliente[Posicion].NombreContratante);
            $("#txtPrimerApellidoContratantetxtCorreoEditarCliente").val(datosCliente[Posicion].PrimerApellidoContratante);
            $("#txtSegundoApellidoContratantetxtCorreoEditarCliente").val(datosCliente[Posicion].SegundoApellidoContratante);
            $("#txtCorreoContratantetxtCorreoEditarCliente").val(datosCliente[Posicion].CorreoContratante);
            $("#txtTelMovilContratantetxtCorreoEditarCliente").val(datosCliente[Posicion].TelefonoMovilContratante);
            $("#txtTelFijoContratantetxtCorreoEditarCliente").val(datosCliente[Posicion].TelefonoFijoContratante);

            $("#txtNumeroEditarCliente").prop("disabled",true);
            $("#txtAnexoEditarCliente").prop("disabled",true);
            $("#txtVigenciaAnioEditarCliente").prop("disabled",true);
            $("#txtVigenciaMesEditarCliente").prop("disabled",true);
            $("#txtFechaInicioEditarCliente").prop("disabled",true);
            $("#txtArchivoEditarCliente").hide();
            $("#SpamArchivo1").hide();
        }else if(Opcion=="1" || Opcion=="4" || Opcion=="5"){
            $("#txtCpContratoEditarCliente").val(datosCliente[Posicion].CodigoPostalCliente);
            consultaCpEditarCliente();
            $("#txtEntidadEditarCliente").val(datosCliente[Posicion].EntidadCliente);
            TraerMunicipiosEditarCliente(0);
            $("#txtMunicipioEditarCliente").val(datosCliente[Posicion].MunicipioCliente);
            TraerColoniasEditarCliente(0);
            $("#txtColoniaEditarCliente").val(datosCliente[Posicion].ColoniaCliente);
            $("#txtCallePrincipalEditarCliente").val(datosCliente[Posicion].CallePrincipaCliente);
            $("#txtNumeroInteriroEditarCliente").val(datosCliente[Posicion].NumeroInterirCliente);
            $("#txtNumeroExteriorEditarCliente").val(datosCliente[Posicion].NumeroExteriorCliente);
            $("#txtCalle1EditarCliente").val(datosCliente[Posicion].PrimerCalleCliente);
            $("#txtCalle2EditarCliente").val(datosCliente[Posicion].SegundaCalleCliente);
            if(Opcion=="5"){
                
                $("#txtNombreContactoEditarCliente").prop("readonly",false);
                $("#txtCpContratoEditarCliente").prop("readonly",false);
                $("#txtEntidadEditarCliente").prop("disabled",false);
                $("#txtMunicipioEditarCliente").prop("disabled",false);
                $("#txtColoniaEditarCliente").prop("disabled",false);
                $("#txtCallePrincipalEditarCliente").prop("readonly",false);
                $("#txtNumeroInteriroEditarCliente").prop("readonly",false);
                $("#txtNumeroExteriorEditarCliente").prop("readonly",false);
                $("#txtCalle1EditarCliente").prop("readonly",false);
                $("#txtCalle2EditarCliente").prop("readonly",false);
                $("#txtTelefonoMovilEditarCliente").prop("readonly",false);
                $("#txtTelefonoFijoEditarCliente").prop("readonly",false);
                $("#txtAsentamientoEditarCliente").prop("disabled",false);
                $("#txtCorreoEditarCliente").prop("readonly",false);
                $("#NumeroEditarCliente").hide();
                $("#txtNumeroEditarCliente").hide();
                $("#AnexoEditarCliente").hide();
                $("#txtAnexoEditarCliente").hide();
                $("#DivUno").hide();
                $("#DivDos").hide();
                $("#RegistroPatronalEditarCliente").hide();
                $("#txtRegistroPatronalEditarCliente").hide();
                $("#DivTres").hide();
                $("#DivCuatro").hide();
                $("#DivCinco").hide();
                $("#DivSeis").hide();
                $("#DivSiete").hide();
                $("#DivOcho").hide();

            }
        }
        $("#modalEditarCliente").modal(); 
    }

    function AccionARealizarPorConsultaModal(){
        $('#txtContratoAEditar1').empty().append('<option value="ELEGIR">ELEGIR</option>');
        for (var i = 0; i < datosCliente.length; i++) {
            $('#txtContratoAEditar1').append("<option value="+i+">"+datosCliente[i].NumeroContrato+datosCliente[i].AnexoNumCliente+"</option>");
        }
        $("#modalSeleccionarContrato").modal();   
    }

    $("#txtContratoAEditar1").change(function()
    {
        var Posicion = $("#txtContratoAEditar1").val();
        if(Posicion=="ELEGIR"){
            $("#txtNumeroAEditar").val("");
            $("#txtRazonSocialAEditar").val("");
            $("#txtRegistroPatronalv").val("");
            $("#txtTipov").val("");
            $("#txtObjetov").val("");
            $("#txtFechafinv").val("");
            $("#txtVigenciaAniov").val("");
            $("#txtVigenciaMesv").val("");
            $("#txtFechaIniciov").val("");
            $("#idContratoCliente").val("");
            alertMsg1="<div class='alert alert-error' id='msg'><strong>Error Al Continuar: </strong>Seleccione Un Contrato Para Continuar<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msjErrorSeleccionarContrato").html(alertMsg1);
            $(document).scrollTop(0);
            $('#msg').delay(3000).fadeOut('slow');
            $("#ContinuarEdicion").hide();
        }else{
            $("#txtNumeroAEditar").val(datosCliente[Posicion].claveClienteNominaCliente);
            $("#txtRazonSocialAEditar").val(datosCliente[Posicion].razonSocial);
            $("#txtRegistroPatronalv").val(datosCliente[Posicion].RegistroPatronal);
            $("#txtTipov").val(datosCliente[Posicion].TipoContrato);
            $("#txtObjetov").val(datosCliente[Posicion].ObjetoContrato);
            $("#txtFechafinv").val(datosCliente[Posicion].FechaFinalC);
            $("#txtVigenciaAniov").val(datosCliente[Posicion].VigenciaAnios);
            $("#txtVigenciaMesv").val(datosCliente[Posicion].ViegenciaMeses);
            $("#txtFechaIniciov").val(datosCliente[Posicion].FechaInicioC);
            $("#idContratoCliente").val(datosCliente[Posicion].idContratoCliente);
            
            $("#ContinuarEdicion").show();
        }
    });

    function ContinuarEdicion1(){
        $("#modalSeleccionarContrato").modal('hide');   

        var Posicion = $("#txtContratoAEditar1").val();
        AccionARealizarPorConsulta(Posicion);
    }

    function CargarCatalogosManualesEdicionCLiente(){
    $('#txtNumeroEditarCliente').empty();
    $('#txtVigenciaAnioEditarCliente').empty();
    $('#txtVigenciaMesEditarCliente').empty();
    for(var i = 0; i < 12; i++){
        if(i < 11){
            $('#txtNumeroEditarCliente').append("<option value="+i+">"+i+"</option>");
            $('#txtVigenciaAnioEditarCliente').append("<option value="+i+">"+i +" Años</option>");
        }
        $('#txtVigenciaMesEditarCliente').append("<option value="+i+">"+i+" Meses</option>");
    }
    //////////// Selector  Tipo De Contrato /Entidades/Colonias/Municipios//
    TraerTiposContratosEditarCliente();
    TraerEntidadesEditarCliente();
    //////////////////////////////////////////////////////////
    $('#txtMunicipioEditarCliente').empty().append('<option value="0">Municipios</option>');
    $('#txtColoniaEditarCliente').empty().append('<option value="0">Colonias</option>');
    $('#txtAsentamientoEditarCliente').empty().append('<option value="0">Asentamiento</option>');
    $('#txtAnexoEditarCliente').empty().append('<option>LETRAS</option><option>A</option><option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option><option>H</option><option>I</option><option>J</option><option>K</option><option>L</option><option>M</option><option>N</option><option>Ñ</option><option>O</option><option>P</option><option>Q</option><option>R</option><option>S</option><option>T</option><option>U</option><option>V</option><option>W</option><option>X</option><option>Y</option><option>Z</option>');
  }

  function TraerTiposContratosEditarCliente(){
    $.ajax({
        type: "POST",
        url: "ajax_TraerTiposContratosClientes.php",
        dataType: "json",
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtTipoEditarCliente').empty().append('<option value="0">Tipo</option>');
          $.each(datos, function(i) {
            $('#txtTipoEditarCliente').append('<option value="' + response.datos[i].idTipoContrato+ '">' + response.datos[i].Descripcion + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }

  function TraerEntidadesEditarCliente(){
    $.ajax({
        type: "POST",
        url: "ajax_TraerEntidadesCliente.php",
        dataType: "json", 
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtEntidadEditarCliente').empty().append('<option value="0">Entidades</option>');
          $.each(datos, function(i) {
            $('#txtEntidadEditarCliente').append('<option value="' + response.datos[i].idEntidadFederativa+ '">' + response.datos[i].nombreEntidadFederativa + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }

  function consultaCpEditarCliente()
{
    var codigoPostal = $("#txtCpContratoEditarCliente").val();
    if (codigoPostal.length == 5)
    {
        $.ajax({
            type: "POST",
            url: "ajax_obtenerDirecciones.php",
            data: {txtCP : codigoPostal},
            dataType: "json",
            async:false,
            success: function(response) {
                if (response.listaDirecciones.length == 0)
                {   
                    alertMsg1="<div class='alert alert-error' id='msg1'><strong>Mensaje </strong>El código postal es inválido<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msjErrorModalEditarCliente").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msg1').delay(3000).fadeOut('slow');
                }else 
                {
                    $('#txtAsentamientoEditarCliente').empty().append('<option value="0">Asentamiento</option>');
                    for (var i = 0; i < response.listaDirecciones.length; i++)
                    {
                        var direccion = response.listaDirecciones [i];
                        var params = "\"" + direccion.idAsentamiento + "\"," +
                            "\"" + direccion.nombreEntidadFederativa + "\"," +
                            "\"" + direccion.nombreMunicipio + "\"," +
                            "\"" + direccion.nombreAsentamiento + "\"," +
                            "\"" + direccion.municipioAsentamiento + "\"";
                        $('#txtAsentamientoEditarCliente').append('<option value="'+direccion.idAsentamiento+'&'+direccion.municipioAsentamiento+'&'+direccion.idEstado+'">' + params + '</option>');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
        $('#txtEntidadEditarCliente').val(0);
        $('#txtMunicipioEditarCliente').empty().append('<option value="0">Municipios</option>');
        $('#txtColoniaEditarCliente').empty().append('<option value="0">Colonias</option>');
    }
}
function TraerMunicipiosEditarCliente(Accion){
    $('#txtColoniaEditarCliente').empty().append('<option value="0">Colonias</option>');
    if(Accion=="0"){
        $('#txtAsentamientoEditarCliente').val(0);
    }
    var txtEntidadCliente=$("#txtEntidadEditarCliente").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerMunicipiosCliente.php",
        data: {txtEntidadCliente : txtEntidadCliente},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtMunicipioEditarCliente').empty().append('<option value="0">Municipios</option>');
          $.each(datos, function(i) {
            $('#txtMunicipioEditarCliente').append('<option value="' + response.datos[i].idMunicipio+ '">' + response.datos[i].nombreMunicipio + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }

  function TraerColoniasEditarCliente(Accion){
    if(Accion=="0"){
        $('#txtAsentamientoEditarCliente').val(0);
    }
    var txtMunicipio=$("#txtMunicipioEditarCliente").val();
    $.ajax({
        type: "POST",
        url: "ajax_TraerColoniasCliente.php",
        data: {txtMunicipio : txtMunicipio},
        dataType: "json",
        async:false,
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#txtColoniaEditarCliente').empty().append('<option value="0">Colonias</option>');
          $.each(datos, function(i) {
            $('#txtColoniaEditarCliente').append('<option value="' + response.datos[i].idAsentamiento+ '">' + response.datos[i].nombreAsentamiento + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    });  
  }

  $("#txtAsentamientoEditarCliente").change(function()
{
    var txtAsentamiento = $("#txtAsentamientoEditarCliente").val();
    var splitasentamiento = txtAsentamiento.split('&'); 
    var idColonia = splitasentamiento[0];
    var idmunicipio = splitasentamiento[1];
    var idEntidad = splitasentamiento[2];
    $("#txtEntidadEditarCliente").val(idEntidad);
    TraerMunicipiosEditarCliente(1);
    $("#txtMunicipioEditarCliente").val(idmunicipio);
    TraerColoniasEditarCliente(1);
    $("#txtColoniaEditarCliente").val(idColonia);

});

function GenerarFechaFinalEditarCliente(){
    var txtVigenciaAnio =$("#txtVigenciaAnioEditarCliente").val();
    var txtVigenciaMes =$("#txtVigenciaMesEditarCliente").val();
    var txtFechaInicioC =$("#txtFechaInicioEditarCliente").val();
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
        $("#txtFechafinEditarCliente").val(fechafin);
    }  
}


function ActualzarGurdarContrato()
    {
        var NumEmpModalNC = $("#NumEmpModalNCHodden").val();
        var contraseniaInsertadaCifrada = $("#contraseniaInsertadaCifradaHodden").val();
        //guardar nuevo pdf
        var txtNumeroEditarCliente = $("#txtNumeroEditarCliente").val();
        var txtAnexoEditarCliente = $("#txtAnexoEditarCliente").val();
        var txtVigenciaAnioEditarCliente = $("#txtVigenciaAnioEditarCliente").val();
        var txtVigenciaMesEditarCliente = $("#txtVigenciaMesEditarCliente").val();
        var txtFechaInicioEditarCliente = $("#txtFechaInicioEditarCliente").val();
        var txtAsentamientoEditarCliente = $("#txtAsentamientoEditarCliente").val();
        var txtEntidadEditarCliente = $("#txtEntidadEditarCliente").val();
        var txtMunicipioEditarCliente = $("#txtMunicipioEditarCliente").val();
        var txtColoniaEditarCliente = $("#txtColoniaEditarCliente").val();
        var formData = new FormData($("#form_catalogoClientes")[0]);
        formData.append('txtNumeroEditarCliente', txtNumeroEditarCliente);
        formData.append('txtAnexoEditarCliente', txtAnexoEditarCliente);
        formData.append('txtVigenciaAnioEditarCliente', txtVigenciaAnioEditarCliente);
        formData.append('txtVigenciaMesEditarCliente', txtVigenciaMesEditarCliente);
        formData.append('txtFechaInicioEditarCliente', txtFechaInicioEditarCliente);
        formData.append('txtAsentamientoEditarCliente', txtAsentamientoEditarCliente);
        formData.append('txtEntidadEditarCliente', txtEntidadEditarCliente);
        formData.append('txtMunicipioEditarCliente', txtMunicipioEditarCliente);
        formData.append('txtColoniaEditarCliente', txtColoniaEditarCliente);
        formData.append('NumEmpModalNC', NumEmpModalNC);
        formData.append('contraseniaInsertadaCifrada', contraseniaInsertadaCifrada);
        $.ajax({
            type: "POST",
            url: "ajax_UpdateContratosCliente.php",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                var mensaje=response.message;
                var status=response.status;
                alertMsg1="<div class='alert alert-"+status+"' id='msg1'><strong>Mensaje </strong>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                $("#msjErrorModalEditarCliente").html(alertMsg1);
                $(document).scrollTop(0);
                $('#msg1').delay(3000).fadeOut('slow');
                if(status =="success"){
                   $("#NumEmpModalFirmaNuevoContrato").val("");
                   $("#constraseniaFirmaNuevoContrato").val("");
                   ReestablecerCampos();
                   $("#modalEditarCliente").modal('hide');
                   obtenerListaClientes();
                   CargarCatalogosManualesEdicionCLiente();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }

    function AgregarContratoNuevo(){
        alert("Entre A Registrar Un Nuevo Contrato");
    }

  $("#contratoEditado").click(function(){
    var mensaje="Al actualizar el contrato, el pdf actual se eliminará";
    var status="warning";
    alertMsg1="<div class='alert alert-"+status+"' id='msg1'><strong>NOTA:</strong>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msjErrorModalEditarCliente").html(alertMsg1);
    $(document).scrollTop(0);
    // $('#msg1').delay(3000).fadeOut('slow');   

});

window.onload = function() {
  var myInput = document.getElementById('txtObjetoEditarCliente');
  myInput.onpaste = function(e) {
    e.preventDefault();
    alert("Esta acción está prohibida");
  }
  
  myInput.oncopy = function(e) {
    e.preventDefault();
    alert("Esta acción está prohibida");
  }
}
 
$("#inpBusquedaCientes").on("keyup search input paste cut", function() { 
    // var letraa = $("#letra").val();
    var tablaEstatus = $("#Exportar_a_Excel1");
    // var bandera = $("#bandera").val();
    // if(bandera=="1" && letraa=="13"){
        tablaEstatus.search(this.value).draw();   
    // }
}); 

 var tablaCC = null;

function CargarTablaCatClientes(data) {
  
  if(tablaCC != null) {
      tablaCC.destroy();
    }

   tablaCC = $('#tablaCatalogoClientes').DataTable({
    "language":{
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
               "paginate":{
                          "first": "Primera",
                          "last": "Ultima",
                          "next": "Siguiente",
                          "previous": "Anterior"
                         },
               "aria":{
                       "sortAscending": "Ordenación ascendente",
                       "sortDescending": "Ordenación descendente"
                      }
         },
   data: data,
   destroy: true,
   "columns": [{"className": "dt-body-center","data": "claveClienteNomina"},
             {"data": "razonSocial"},
             {"data": "nombreComercial"},
             {"className": "dt-body-center","data": "rfcCliente"},
             {"className": "dt-body-center","data": "contactoCliente"},
             {"className": "dt-body-center","data": "telefonoFijoCliente"},
             {"className": "dt-body-center","data": "telefonoMovilCliente"},
             {"className": "dt-body-center","data": "correoCliente"},
             {"className": "dt-body-center","data": "direccionFiscalCliente1"},
             {"className": "dt-body-center","data": "editarCliente"},
             {"className": "dt-body-center","data": "editarContrato"},
             {"className": "dt-body-center","data": "nuevoContrato"},],
   processing: true,
   dom: 'Bfrtip',
    buttons: [
            {
                extend: 'excelHtml5',
                title: function () {
                        var date = new Date();
                        var year = date.getFullYear();
                        var month = ("0" + (date.getMonth() + 1)).slice(-2);
                        var day = ("0" + date.getDate()).slice(-2);
                        return (
                          "reporte" +
                          day +
                          "-" +
                          month +
                          "-" +
                          year
                        );
                      },
            },
        ]
  });
}

function abrirModalFirmaNuevoContrato(claveNomina,Accion){
    // alert(claveNomina);
    // alert(Accion);
    $("#claveNominaHidden").val(claveNomina);
    $("#accionHidden").val(Accion);
    $("#modalFirmaElectronicaNuevoContrato").modal();
}

function RevisarFirmaInternaNuevoContrato (){
  var NumEmpModalNC = $("#NumEmpModalFirmaNuevoContrato").val();
  var constraseniaFirma = $("#constraseniaFirmaNuevoContrato").val();
  if(NumEmpModalNC==""){
   alert("El numero de empleado no puede estar vaacio");
   return;
  }else if(constraseniaFirma==""){
     alert("Escriba la contraseña para continuar");
     return;
  }else{
    $.ajax({
      type:"POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalNC,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
      if (response.status == "success"){
        var RespuestaLargo = response["datos"].length;
        if(RespuestaLargo == "0"){
          alert("La contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
        }else{
          $("#NumEmpModalNCHodden").val(NumEmpModalNC);
          $("#contraseniaInsertadaCifradaHodden").val(constraseniaFirma);
          $("#modalFirmaElectronicaNuevoContrato ").modal('hide');
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          EditarContratosIniciales(NumEmpModalNC,contraseniaInsertadaCifrada);
        }
      }else{

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}
</script>