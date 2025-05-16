<?php
require('../libs/fpdf/fpdf.php');
// require('../libs/fpdi/fpdi.php');
?>
<div class="container" align="center">
<div id="divMensajerRecepcionUniforme"></div>   
<div id="divAdeudo"></div>   
<form class="form-horizontal"  method="post" name='from_cardexEmpleado' id="from_cardexEmpleado" enctype="multipart/form-data">
  <legend><h3>Recepción de Uniformes</h3></legend>  
    <h3 style="color: red;"><img src="img/alert.png">TIPO DE RECEPCIÓN</h3>
     <table>
       <tr>
           <td>
               <div class="chart-container" style="width:2vw">
                <center>
                   <input type="radio" id="siRecepUni" name="siRecepUni" value="">
                   </center>
                   <h4>USO PROPIO</h4>
               </div>
           </td>
           <td>
               <div class="chart-container" style="width:2vw">
                   <input type="hidden" id="ESPACIORecpcion" name="ESPACIORecpcion" value="">
                   <h4></h4>                                        
               </div>
           </td>
           <td>
               <div class="chart-container" style="width:2vw">
                <center>
                   <input type="radio" id="noRecepUni" name="NoRecepUni" value="">
                </center>
                   <h4>USO PLANTILLA</h4>                                        
               </div>
           </td> 
       </tr>      
     </table>
  <div id="fotoEmpleadoRec" style="width:140px;height:148px;border:1px solid;text-align:center;"></div> 
  <br>   
  <table class="table1"  >
        <tr>
          <td><label class="control-label label " for="txtNombre">Nombre Empleado</label></td>
          <td><input id="txtNombre" name="txtNombre" type="text" class="input-large" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtFechaAlta">Fecha Alta</label></td>
          <td><input id="txtFechaAlta" name="txtFechaAlta" type="text" class="input-medium" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtFechaBaja">Fecha Baja</label></td>
          <td><input id="txtFechaBaja" name="txtFechaBaja" type="text" class="input-medium" readonly /></td>        
        </tr>
        <tr >
          <td><label class="control-label label " for="txtbusqueda">No. de Empleado</label> </td>          
          <td><input type="text" name="txtbusqueda" id="txtbusqueda"class="search-query" disabled="true" placeholder="Buscar  (00-0000-00)" aria-describedby="basic-addon2" onkeyup="verificaEmpleado();" onblur=""><img src="img/search.png"></td>
         </tr>
           <tr>
              <td><label class="control-label label " for="inpCobertura">Cobertura</label> </td> 
              <td><input id="inpCobertura" name="inpCobertura" type="text" class="input-medium" readonly /></td>        
          </tr> 
         <tr>
            <div id="divEntidadUsuario" >
              <td><label class="control-label label " for="SelectEntidadUsuario">Entidad De Recepción</label> </td> 
              <td><select id="SelectEntidadUsuario" name="SelectEntidadUsuario" disabled="true">
                <!-- <option value='0'>ENTIDAD FEDERATIVA</option> -->
              </select></td>
            </div>
          </tr>

          <tr>
            <div id="divsucursalUsuario" >
              <td><label class="control-label label " for="SelectSucursalUsuario">Sucursal De Recepción</label> </td> 
              <td><select id="SelectSucursalUsuario" name="SelectSucursalUsuario" disabled="true">
                <!-- <option value='0'>SUCURSAL</option> -->
              </select></td>
            </div>
          </tr>
         
      <input type="hidden" class="input-medium" readonly="true" id="FirmaInternaBajaUnihidden" name="FirmaInternaBajaUnihidden">   
      <input type="hidden" class="input-medium" readonly="true" id="FirmaIntenaEmpleadoRecepcion" name="FirmaIntenaEmpleadoRecepcion">
      <input type="hidden" class="input-medium" readonly="true" id="numempleadoFirmaBajaUnihidden" name="numempleadoFirmaBajaUnihidden">
      <input type="hidden" class="input-medium" readonly="true" id="NombreSolicitanteBajaUnihidden" name="NombreSolicitanteBajaUnihidden">
      <input type="hidden" class="input-medium" readonly="true" id="tipopuestoemp" name="tipopuestoemp">
      <input type="hidden" class="input-medium" readonly="true" id="banderaFiniquito" name="banderaFiniquito">
      <input type="hidden" class="input-medium" readonly="true" id="EstatusImssHidden" name="EstatusImssHidden">
      <input type="hidden" class="input-medium" readonly="true" id="EstatusEmpleadoBEU" name="EstatusEmpleadoBEU">
      <input type="hidden" class="input-medium" readonly="true" id="largodeudaFiniquito" name="largodeudaFiniquito">
      <input type="hidden" class="input-medium" readonly="true" id="EstatusFiniquitoHidden" name="EstatusFiniquitoHidden">
      <input type="hidden" class="input-medium" readonly="true" id="firmauniformefiniquito" name="firmauniformefiniquito">
      <input type="hidden" class="input-medium" readonly="true" id="largoListaUniformesFiniquito" name="largoListaUniformesFiniquito">
   </table>
 </form> 
<br>      
  <button id="btnConfirmarUniRec" disabled="true" class='btn btn-success' type='button' onclick='RevisarChecks();'> <img src="img/hojaDatos.png" width='20%' >Confirmar</button>
  <button id="btnAFiniquito" disabled="true" class='btn btn-primary' type='button' onclick='abrirmodalFirmaFiniquio();'> <img src="img/hojaDatos.png" width='20%' >Firma Directa</button>
<br><!--recibirUniforme-->
   
  <div style="width:2500px; padding:5px;">
    <div id="listFiniquitosPendientes" style="width:750px; background:#EAECEE; float:left;"></div>
    <div id="cardexEmpleado" style="width:1000px; background:#AED6F1; float:center;"></div>
  </div> 
    
</div>
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////// modal Firma  Administrativo////////////////////////////////////////////////////////////////// -->
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaBajaUni" id="modalFirmaElectronicaBajaUni" data-backdrop="static">
  <div id="errorModalFirmaInternaBajaUni"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <h5>ADMINISTRATIVO</h5>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalBajaBajaUni" class="input-medium" name="NumEmpModalBajaBajaUni" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaBajaUni" class="input-xlarge"name="constraseniaFirmaBajaUni" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        
      <button type="button" id="btnFirmarDocBajaUni" name="btnFirmarDocBajaUni" style="display: none;" onclick="RevisarFirmaInternaBajaUni();" class="btn btn-primary" >Firmar</button>
      <button type="button" id="btnCancelarFirmaBajaUni" name="btnCancelarFirmaBajaUni"onclick="cancelarFirmaBajaUni12();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////// modal Firma Guardia ////////////////////////////////////////////////////////////////// -->
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElementoRecepcion" id="modalFirmaElementoRecepcion" data-backdrop="static">
  <div id="errormodalFirmaElementoRecepcion"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" align="center"><img src="img/alert.png">Firma De Recibido Del Elemento!!</h2>
      </div>
       <div class="modal-body" align="center">
          <h4 class="modal-title" align="center">Escriba la contraseña que recibe al activar su cuenta en la plataforma de Gif Seguridad Privada</h4>
      </div>
      <div class="modal-body" align="center">
          <span class="add-on">Contraseña</span>
        <input type="password" maxlength="10" id="constraseniaFirmaElementoRecepcion" class="input-xlarge"name="constraseniaFirmaElementoRecepcion" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" id="ActivarActualizarCuentaRecepcion" align="center" style="display: none;">
          <p><a  href="form_activacionCuentaUsuario.php" target="_blank">Activar/Actualizar Cuenta</a></p>
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarDoc" name="btnFirmarDoc" onclick=" recibirUniforme(1);" class="btn btn-primary" >Continuar</button>
        <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirmaEmpleadoRecepcion();" class="btn btn-danger" >Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////// modal Firma Guardia Administrativo////////////////////////////////////////////////////////////////// -->
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaRecepcionAdmin" id="modalFirmaElectronicaRecepcionAdmin" data-backdrop="static"> <!-- modal FirmaBajaEmpleado -->
  <div id="errorModalFirmaRecepcionAdmin"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <h5>GUARDIA</h5>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalRecepcionAdmin" class="input-medium" name="NumEmpModalRecepcionAdmin" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaRecepcionAdmin" class="input-xlarge"name="constraseniaFirmaRecepcionAdmin" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarRecepcionAdmin" name="btnFirmarRecepcionAdmin" style="display: none;" onclick="RevisarFirmaInternaRecepcionAdmin();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaRecepcionAdmin" name="btnCancelarFirmaRecepcionAdmin"onclick="cancelarFirmaRecepcionAdmin();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- FIN modal FirmaBajaEmpleado -->

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////// modal Firma  Administrativo Fniquito Directo////////////////////////////////////////////////////////////////// -->
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaFiniquito" id="modalFirmaElectronicaFiniquito" data-backdrop="static">
  <div id="errorModalFirmaFiniquito"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
      </div>
      <div class="modal-body" align="center">
        <h5>ADMINISTRATIVO</h5>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaFiniquito" class="input-medium" name="NumEmpModalFirmaFiniquito" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaFiniquito" class="input-xlarge"name="constraseniaFirmaFiniquito" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarFiniquito" name="btnFirmarFiniquito" style="display: none;" onclick="RevisarFirmaInternaFiniquito();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaFiniquito" name="btnCancelarFirmaFiniquito"onclick="cancelarFirmaBajaUni();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<script type="text/javascript">
var entEmp="";
var consecEmp="";
var categoEmp="";
$(CargarTablaBajaEmpleados());

$("#noRecepUni").change(function(){
  limpiarInfoEmp();
  $("#SelectEntidadUsuario").empty(); 
  $("#SelectSucursalUsuario").empty(); 
  $('#divAdeudo').fadeOut();
  if($('#noRecepUni').is(":checked")){
     $("#noRecepUni").val(1);
     $("#siRecepUni").prop("checked", false);
     $("#siRecepUni").val(0);
     eliminarRecibidosTMP();
   }else{
         $("#noRecepUni").val(0);
        }
});

$("#siRecepUni").change(function(){
  limpiarInfoEmp();
  $("#SelectEntidadUsuario").empty(); 
  $("#SelectSucursalUsuario").empty(); 
  $('#divAdeudo').fadeOut();
  
  if($('#siRecepUni').is(":checked")){
     $("#siRecepUni").val(1);
     $("#noRecepUni").prop("checked", false);
     $("#noRecepUni").val(0);
     eliminarRecibidosTMP();
   }else{
         $("#siRecepUni").val(0);
        }
 });


function verificaEmpleado(){
  var valSI= $("#siRecepUni").val();
  var valNO= $("#noRecepUni").val();
  var txtSearch = $("#txtbusqueda").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1= /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;

  if(txtSearch.length != 10 && txtSearch.length != 11){ 
     $("#SelectEntidadUsuario").prop("disabled", false);
     $("#SelectEntidadUsuario").val("");
     $("#SelectSucursalUsuario").val("");
     $('#cardexEmpleado').hide();
     $('#cardexEmpleado').html("");
     $("#fotoEmpleadoRec").html("");
     $("#txtNombre").val("");
     $("#txtFechaAlta").val("");
     $("#txtFechaBaja").val("");
     $("#inpCobertura").val("");
     waitingDialog.hide();
     $('#divAdeudo').fadeOut();
     return;
    }else{
          if(expreg.test(txtSearch)   || expreg1.test(txtSearch)){
             waitingDialog.show();
             $('#divAdeudo').fadeOut();
             var numeroEmpleado = $("#txtbusqueda").val();          
             consultaEmpleado2(numeroEmpleado);
         }
      }
}

function consultaEmpleado2 (numeroEmpleado){
var numeroEmpleado1 = numeroEmpleado;
 $.ajax({
         type: "POST",
         url: "ajax_obtenerEmpleadoPorId.php",
         data:{"numeroEmpleado":numeroEmpleado1},
         dataType: "json",
         success: function(response) {
                if (response.status == "success"){
                   var empleadoEncontrado = response.empleado;
                   var coberturaEmpleado= response.coberturaEMP;
                    if(empleadoEncontrado.length == 0){
                       mensaje ="No existe Número de empleado";
                       cargarmensajeerrorRecepcionUniforme(mensaje,"error");
                       $('#divAdeudo').fadeOut();                  
                     }else{                                          
                           var empleadoEntidad    = empleadoEncontrado[0].entidadFederativaId;
                           var empleadoConsecutivo= empleadoEncontrado[0].empleadoConsecutivoId;
                           var empleadoCategoria  = empleadoEncontrado[0].empleadoCategoriaId;
                           var empleadoApellidoPaterno = empleadoEncontrado[0].apellidoPaterno;
                           var empleadoApellidoMaterno = empleadoEncontrado[0].apellidoMaterno;
                           var nombreEmpleado=empleadoEncontrado[0].nombreEmpleado;  
                           var fechaIngreso  =empleadoEncontrado[0].fechaIngresoEmpleado;                       
                           var fechaBaja =empleadoEncontrado[0].fechaBajaEmpleado;
                           var foto = empleadoEncontrado[0].fotoEmpleado;
                           var idTipoPuesto = empleadoEncontrado[0].idTipoPuesto;
                           var empleadoEstatusImss = empleadoEncontrado[0].empleadoEstatusImss;
                           var TOTALcoberturaEmpleado = coberturaEmpleado[0].TOTAL;
                           $("#EstatusEmpleadoBEU").val(empleadoEstatusImss);
                           $("#tipopuestoemp").val(idTipoPuesto);
                           $("#fotoEmpleadoRec").html ("<img src='thumbs/" + foto + "' / width='100%'>");
                           $("#txtNombre").val(nombreEmpleado+" "+empleadoApellidoPaterno+" "+empleadoApellidoMaterno);
                           $("#txtFechaAlta").val(fechaIngreso);                            
                           $("#txtFechaBaja").val(fechaBaja);  
                           $("#inpCobertura").val(TOTALcoberturaEmpleado);
                           consultaCardex(empleadoEntidad,empleadoConsecutivo,empleadoCategoria);
                           obtenerEstatusEmpleadoParaFirmaFiniquito(numeroEmpleado1);
                      }
                  cargarSelectorEntidadesBaja();
                  eliminarRecibidosTMP();  
                  waitingDialog.hide();
                }else if (response.status == "error" && response.message == "No autorizado"){
                    window.location = "login.php";
                    waitingDialog.hide();
                    $('#divAdeudo').fadeOut();
                }
            },error: function(jqXHR, textStatus, errorThrown){
                              alert(jqXHR.responseText);
                              waitingDialog.hide();
                              limpiarInfoEmp();
                              $('#divAdeudo').fadeOut();
                             }
        });
}

function consultaCardex(empleadoEntidad,empleadoConsecutivo,empleadoCategoria){
var valSI= $("#siRecepUni").val();
var valNO= $("#noRecepUni").val();
var cobertura = $("#inpCobertura").val();
var estatusEmp= $("#EstatusEmpleadoBEU").val();
entEmp=empleadoEntidad;
consecEmp=empleadoConsecutivo;
categoEmp=empleadoCategoria;
actualizaIconosFormatos(entEmp,consecEmp,categoEmp);
$.ajax({    
        async:false,        
        type: "POST",
        url: "ajax_getAsignacionesByEmpleado.php",
        data : {"entidadEmpleado":empleadoEntidad,"consecutivoEmpleado":empleadoConsecutivo, "categoriaEmpleado":empleadoCategoria,"valSI":valSI,"valNO":valNO},
        dataType: "json",
        success: function(response){
          if(response.status == "success"){
            var cardex= response.lista;
            var deuda = response.deudaUniformes;
            var totalUniformesARecibir1= response.totalUniformes;
            $("#largoListaUniformesFiniquito").val(totalUniformesARecibir1);                
            $("#largodeudaFiniquito").val(deuda); 
            var numeroEmpleado=empleadoEntidad+"-"+empleadoConsecutivo+"-"+empleadoCategoria;
            
            if(valSI==1 && totalUniformesARecibir1==0 && deuda!=0) {
              var mensaje="Este empleado cuenta con uniformes por devolver que eran para plantilla";
              cargarMSJAdeudos(mensaje,"error");
            }else if(valSI==1 && totalUniformesARecibir1!=0 && deuda!=0 && (estatusEmp!='7')) {
              var mensaje="Este empleado cuenta con uniformes por devolver de uso propio y de plantilla";
              cargarMSJAdeudos(mensaje,"error");
            }else if(valSI==1 && totalUniformesARecibir1==0 && deuda==0) {
              var mensaje="Este empleado no tiene adeudos de uniforme";
              cargarMSJAdeudos(mensaje,"success");
            }else if(valNO==1 && totalUniformesARecibir1==0 && deuda!=0) {
              var mensaje="Este empleado cuenta con uniformes por devolver de uso propio";
              cargarMSJAdeudos(mensaje,"error");
            }else if(valNO==1 && totalUniformesARecibir1!=0 && deuda!=0) {
              var mensaje="Este empleado cuenta con uniformes por devolver de uso propio y de plantilla";
              cargarMSJAdeudos(mensaje,"error");
            }else if(valNO==1 && totalUniformesARecibir1==0 && deuda==0) {
              var mensaje="Este empleado no tiene adeudos de uniforme";
              cargarMSJAdeudos(mensaje,"success");
            }

            if(valSI==1 && totalUniformesARecibir1!=0 && deuda!=0 && estatusEmp=='7'){
               alert("Este empleado cuenta con uniformes por devolver que eran para plantilla,recepcione esos uniformes y posteriormente recepcione los uniformes de uso propio para generar el finiquito correctamente");
               var mensaje="Este empleado cuenta con uniformes por devolver de uso propio y de plantilla";
               cargarMSJAdeudos(mensaje,"error");
               $("#btnConfirmarUniRec").prop("disabled", true);
               $("#btnAFiniquito").prop("disabled", true);
            }else{
                  var listaTable="<table class='table table-hover'><thead> <th>Codigo Uniforme</th> <th>Descripcion</th> <th>Fecha Asignación</th> <th>Tipo recepcion</th> <th>Porcentaje de cobro</th> <th>Monto a cobrar</th> <th>Recibir</th> <th>Recibido</th></thead><tbody>";
                  for(var i = 0; i < cardex.length; i++ ){
                      var idUniforme=cardex[i].idUniforme;
                      var tipoMerca =cardex[i].idTipoMercancia;
                      var codigoUniforme =cardex[i].codigoUniforme;
                      var descripcionUni =cardex[i].descUniforme;
                      var fechaAsignacion=cardex[i].fechaAsignacion;
                      var costoUniforme  =cardex[i].costoUniforme;

                      if(valNO=='1') {//USO PLANTILLA
                         var idAsignacionUniformeASupervisor=cardex[i].idAsignacionUniformeASupervisor;
                      }else{
                         var idAsignacionUniformeASupervisor='0';
                      }
                      // camisa          pantalon        sastre          abrigo          chamarras 
                      if(tipoMerca==1 || tipoMerca==2 || tipoMerca==3 || tipoMerca==6 || tipoMerca==7){
                         var opciones="<select id='uniformeR"+i+"' name='uniformeR' class='input-medium' onchange='calcularPorcentajes(\""+tipoMerca+"\",\""+i+"\",\""+costoUniforme+"\",\""+idUniforme+"\",\""+cobertura+"\")'>";
                         opciones+="<option value='10'>Movimiento</option>";
                         opciones+="<option value='0'>RECIBIR A STOCK</option>";
                         opciones+="<option value='1'>LAVANDERIA</option>";
                         opciones+="<option value='2'>DESTRUCCION</option>";
                         opciones+="<option value='3'>COBRO</option></select>";
                      }else if(tipoMerca==4){//aditamentos
                              var opciones="<select id='uniformeR"+i+"'name='uniformeR'class='input-medium'onchange='calcularPorcentajes(\""+tipoMerca+"\",\""+i+"\",\""+costoUniforme+"\",\""+idUniforme+"\",\""+cobertura+"\")'>";
                              opciones+="<option value='10'>Movimiento</option>";
                              opciones+="<option value='0'>RECIBIR A STOCK</option>";
                              opciones+="<option value='2'>DESTRUCCION</option>";
                              opciones+="<option value='3'>COBRO</option>";
                      }else if(tipoMerca==5 && valSI==1){//5 es calzado uso propio
                              var opciones="<select id='uniformeR"+i+"' name='uniformeR' class='input-medium'onchange='calcularPorcentajes(\""+tipoMerca+"\",\""+i+"\",\""+costoUniforme+"\",\""+idUniforme+"\",\""+cobertura+"\")'>";
                              opciones+="<option value='10'>Movimiento</option>";
                              opciones+="<option value='3'>COBRO</option></select>";
                      }else if(tipoMerca==5 && valSI==0){//5 es calzado uso plantilla
                               var opciones="<select id='uniformeR"+i+"' name='uniformeR' class='input-medium'onchange='calcularPorcentajes(\""+tipoMerca+"\",\""+i+"\",\""+costoUniforme+"\",\""+idUniforme+"\",\""+cobertura+"\")'>";
                               opciones+="<option value='10'>Movimiento</option>";
                               opciones+="<option value='0'>RECIBIR A STOCK</option>";
                               opciones+="<option value='2'>DESTRUCCION</option>";
                               opciones+="<option value='3'>COBRO</option>";
                      }

                      var opcionesPorcentajes="<select id='porcentaje"+i+"' name='porcentaje' class='input-medium' onchange='mostrarMontoACobrar(\""+i+"\",\""+costoUniforme+"\")'>";
                      opcionesPorcentajes+="<option value='200'>PORCENTAJE</option>";

                      listaTable += "<td>"+codigoUniforme+" </td><td>"+descripcionUni+" </td><td>"+fechaAsignacion+"</td><td>"+opciones+"</td><td>"+opcionesPorcentajes+"</td>";

                      if((cobertura < 90 && valSI==1) || (valSI==0)){
                         listaTable += "<td><input id='montoCobro"+i+"' readonly='true' value='"+costoUniforme+"'></td>";
                      }else if(cobertura >= 90 && valSI==1){//uso propio no se cobra
                         listaTable += "<td><input id='montoCobro"+i+"' readonly='true' value='0'></td>";
                      }
                      
                      listaTable +="<td><button id='recibir"+i+"' name='recibir' class='btn btn-primary' type='button' onclick='insertarRecepcionTemporal(\"" + numeroEmpleado + "\",\"" +idUniforme + "\",\"" +fechaAsignacion+ "\",\""+tipoMerca+"\",\""+idAsignacionUniformeASupervisor+"\",\""+i+"\",\""+costoUniforme+"\");'>Recibir</button></td>";
                      listaTable += "<td><input type='checkbox' id='check"+i+"' value='check"+i+"' disabled='true' style='transform: scale(2);'></td></tr>";
                    }//FOR   
                   listaTable += "</tbody></table>";
                   $('#cardexEmpleado').html(listaTable);
                   $('#cardexEmpleado').show();
                  }//ELSE
                 }else{//ELSE SUCCESS
                      alert("error Response");
                      }
            },           
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
  }

function calcularPorcentajes (tipoMerca,i,costoUniforme,idUniforme,cobertura){

  var  tipoRecepcionTexto= $("#uniformeR"+i+" option:selected" ).text();
  $("#porcentaje"+i+"").empty(); 

  if(tipoRecepcionTexto=="Movimiento"){
     mensaje ="Seleccione un porcentaje";
     cargarmensajeerrorRecepcionUniforme(mensaje,"warning");
  }

  if(tipoRecepcionTexto=="RECIBIR A STOCK"){//no se les debe cobrar nada
    $("#porcentaje"+i+"").append('<option value="0">0%</option>');
    $("#porcentaje"+i+"").val(0);
    $("#montoCobro"+i+"").val(0);
  }else{
    $.ajax({
           type: "POST",
           url: "ajax_obtenerPorcentajesXuniforme.php",
           data:{tipoRecepcionTexto,idUniforme,cobertura,costoUniforme},
           dataType: "json",
           success:function(response) {
              if(response.status == "success"){
                 var porcentaje = response.porcentaje;
                 var montoCobro = response.montoCobro;
                 $("#porcentaje"+i+"").empty(); 
                 $("#porcentaje"+i+"").append('<option value="200">PORCENTAJE</option>');
        
                  for(var j = 1; j < 7; j++){//ya que solo son 6 periodos
                      $("#porcentaje"+i+"").append('<option value="'+ (response[j].porcentaje) +'">' + response[j].porcentaje + '%</option>');
                  }
                 $("#porcentaje"+i+"").val(porcentaje);
                 $("#montoCobro"+i+"").val(montoCobro);
              }
             },error:function(jqXHR, textStatus, errorThrown){
                    alert(jqXHR.responseText);
               }
    });  
  }//else
}

function mostrarMontoACobrar(i,costo){
  
  var porcentaje= $("#porcentaje"+i+"").val();

  if(porcentaje=='200') {
     mensaje ="Seleccione un porcentaje";
     cargarmensajeerrorRecepcionUniforme(mensaje,"warning");
  }else{
        var costoRecalculado= (costo/100)*porcentaje;
        var montoAcobrarNuevo= costoRecalculado.toFixed(2);
        $("#montoCobro"+i+"").val(montoAcobrarNuevo);
  }
  
}


function insertarRecepcionTemporal(numeroEmpleado,idUniforme,fechaAsignacion,tipoMerca,idUniformeSupervisor,i,costoActualUniforme){

  var tipoRecepcion=$("#uniformeR"+i+"").val();
  var valorPlantilla=$("#noRecepUni").val();
  var porcentajeCobro=$("#porcentaje"+i+"").val();
  var coberturaEmpleado=$("#inpCobertura").val();

  if(tipoRecepcion==0 && valorPlantilla=='1'){//stock y uso plantilla
     mensaje ="Este uniforme no se cobrará al empleado";//se manda el mensaje ya que muestra un precio
     cargarmensajeerrorRecepcionUniforme(mensaje,"warning");
  }

  var entidadUsuario  = $("#SelectEntidadUsuario").val();
  var sucursalUsuario  = $("#SelectSucursalUsuario").val();
  var estatusRecepcion= $("#uniformeR"+i+"").val();
  var monto = $("#montoCobro"+i+"").val();
  
  if((!/^([0-9])*$/.test(monto)) && (!/^(([0-9]+)?(.[0-9]+)?)$/.test(monto))){
    mensaje ="Ingrese un monto valido";
    cargarmensajeerrorRecepcionUniforme(mensaje,"error");
  }else if(estatusRecepcion==10){
           mensaje ="Seleccione el tipo de recepción";
           cargarmensajeerrorRecepcionUniforme(mensaje,"error");
  }else if(entidadUsuario=="" || entidadUsuario=="null" || entidadUsuario=="NULL" || entidadUsuario==null || entidadUsuario=="0"){
           mensaje ="Selecciona La Entidad De Recepción";
           cargarmensajeerrorRecepcionUniforme(mensaje,"error");
  }else if(sucursalUsuario=="" || sucursalUsuario=="null" || sucursalUsuario=="NULL" || sucursalUsuario==null || sucursalUsuario=="0"){
           mensaje ="Selecciona La Sucursal De Recepción";
           cargarmensajeerrorRecepcionUniforme(mensaje,"error");
  }else if((estatusRecepcion==1 || estatusRecepcion==3) && (monto==0)){
           mensaje ="Ingrese un monto";
           cargarmensajeerrorRecepcionUniforme(mensaje,"error");
  }else{
    //alert("entre");
        $("#check"+i+"").prop("checked", true);
        $("#uniformeR"+i+"").prop("disabled", true);
        $("#montoCobro"+i+"").prop("readonly", true);
        $("#recibir"+i+"").prop("disabled", true);
        $("#btnConfirmarUniRec").prop("disabled", false);
        $.ajax({
                type: "POST",
                url: "ajax_insertRecepcionTemporal.php",
                data:{numeroEmpleado,idUniforme,estatusRecepcion,entidadUsuario,fechaAsignacion,monto,tipoMerca,idUniformeSupervisor,porcentajeCobro,coberturaEmpleado,costoActualUniforme,sucursalUsuario},
                dataType: "json",
                success:function(response){
                  if(response.status == "success"){
                     waitingDialog.hide();
                  }else{
                        mensaje="Error Al recibir uniforme";
                        cargarmensajeerrorRecepcionUniforme(mensaje,"error");
                        waitingDialog.hide(); 
                       }
                },
                error:function(jqXHR, textStatus, errorThrown){
                       alert(jqXHR.responseText);
                }
        });
  }//ELSE
}

function recibirUniforme(opcion){
  var FirmaEmpleadoRecibido = $("#constraseniaFirmaElementoRecepcion").val();
  //opcion 1 es cuando el empleado a dar de baja es operativo y se requiere su firma
  if(opcion=="1" && FirmaEmpleadoRecibido==""){
     cargaerroresFirmaInternaElementoRecepcion("Ingrese la contraseña generada al activar la cuenta del elemento en la plataforma de Gif Segurdad Privda"); 
  }else{
        var NumeroEmpFirma = $("#numempleadoFirmaBajaUnihidden").val();
        var NombreEmp= $("#NombreSolicitanteBajaUnihidden").val();
        var FirmaEmp = $("#FirmaInternaBajaUnihidden").val();
        var FirmaGuardia = $("#FirmaIntenaEmpleadoRecepcion").val();
        var NumeroGuardia= $("#txtbusqueda").val();
        var NombreGuardia= $("#txtNombre").val();
        var estatusImss  = $("#EstatusImssHidden").val();
        var estatusfiniquito= $("#EstatusFiniquitoHidden").val();
        var idfuncion = 0;
        var banderaFiniquito= $("#banderaFiniquito").val();//si la badera es 1 no debe uniformes por recibir de la otra manera(uso propio/plantilla)
        var valRsi= $("#siRecepUni").val();//uso propio
        var valRno= $("#noRecepUni").val();//uso plantilla
        var cobertura= $("#inpCobertura").val();
        var sucursal= $("#SelectSucursalUsuario").val();
        $("#modalFirmaElementoRecepcion").modal("hide");
        waitingDialog.show();
        var sucursalUsr = $("#SelectSucursalUsuario").val();
        var entidadUsr = $("#SelectEntidadUsuario").val();

        $.ajax({     
            type: "POST",
            url: "ajax_actualizarAsignacionesEmpleado.php",
            data:{"NumeroEmpFirma":NumeroEmpFirma,"NombreEmp":NombreEmp,"FirmaEmp":FirmaEmp,"FirmaGuardia":FirmaGuardia,"NumeroGuardia":NumeroGuardia,"NombreGuardia":NombreGuardia,"idfuncion":idfuncion,"estatusImss":estatusImss,"estatusfiniquito":estatusfiniquito,"banderaFiniquito":banderaFiniquito,"valRsi":valRsi,"valRno":valRno,"cobertura":cobertura,"sucursalUsr":sucursalUsr,"entidadUsr":entidadUsr},
            dataType: "json",
            success:function(response){
                if(response.status == "success"){
                   var entidad    = response[0]["empleadoEntidad"];
                   var consecutivo= response[0]["empleadoConsecutivo"];
                   var tipo       = response[0]["empleadoCategoria"];
                   consultaCardex(entidad,consecutivo,tipo);
                   getStockUniforme(); 
                   eliminarRecibidosTMP(); 
                   var mensaje=response.message;
                   cargarmensajeerrorRecepcionUniforme(mensaje,"success"); 
                   $("#btnConfirmarUniRec").prop("disabled", true);
                   $("#btnAFiniquito").prop("disabled", true);
                   waitingDialog.hide();
                }else{
                    var mensaje=response.message;
                    alert(mensaje);
                   waitingDialog.hide();
                }
            },           
            error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText); 
                waitingDialog.hide();
            }
        });
    }//ELSE
}


function abrirModalBajasUniformes() {
 $("#modalFirmaElectronicaBajaUni").modal();
}

$("#NumEmpModalBajaBajaUni").keyup(function (){
  var NumEmpModalBaja = $("#NumEmpModalBajaBajaUni").val();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
  if(expreg.test(NumEmpModalBaja) || expreg1.test(NumEmpModalBaja)){
    consultaEmpleadoFirmaInternaBajaUni(NumEmpModalBaja);
  }else{
    $("#constraseniaFirmaBajaUni").val("");
    $("#btnFirmarDocBajaUni").hide();
  }
});

function consultaEmpleadoFirmaInternaBajaUni(numeroEmpleado){
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerroresFirmaInternaBajaUnidforme("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaBajaUni").val("");
          $("#btnFirmarDocBajaUni").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaInternaBajaUnidforme("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH"); 
            $("#NumEmpModalBajaBajaUni").val("");
            $("#btnFirmarDocBajaUni").hide();
          }else{
            $("#btnFirmarDocBajaUni").show();
          }
        }
      }else{
        cargaerroresFirmaInternaBajaUnidforme(response.menssaje); 
        $("#NumEmpModalBajaBajaUni").val("");
        $("#btnFirmarDocBajaUni").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}

function RevisarFirmaInternaBajaUni(){//firma de almacen
  var NumEmpModalBaja  =$("#NumEmpModalBajaBajaUni").val();
  var constraseniaFirma=$("#constraseniaFirmaBajaUni").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBajaUnidforme("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBajaUnidforme("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
      if(response.status == "success"){
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
             cargaerroresFirmaInternaBajaUnidforme("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingresó en el registro");
            }else{
              var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
              var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
              var tipopuestoemp = $("#tipopuestoemp").val()
              $("#numempleadoFirmaBajaUnihidden").val(NumEmpModalBaja);
              $("#NombreSolicitanteBajaUnihidden").val(nombre);
              $("#FirmaInternaBajaUnihidden").val(contraseniaInsertadaCifrada);
              var largoListaUniformesFiniquito = $("#largoListaUniformesFiniquito").val();
              var largodeudaFiniquito = $("#largodeudaFiniquito").val();
              var EstatusImss11=$("#EstatusImssHidden").val();
              var cobertura11  =$("#inpCobertura").val();
              //condición que no pida la firma del guardia
              if(EstatusImss11=="7" && cobertura11 < "90"){//baja con cobertura menor
                $("#FirmaIntenaEmpleadoRecepcion").val("");
                recibirUniforme(0);
              }else{
                  if(tipopuestoemp=="02"){
                    $("#modalFirmaElectronicaRecepcionAdmin").modal();//firma Administrativo
                    $("#NumEmpModalRecepcionAdmin").val("");
                    $("#constraseniaFirmaRecepcionAdmin").val(""); 
                  }else{
                    $("#modalFirmaElementoRecepcion").modal();//firma guarida
                    $("#constraseniaFirmaElementoRecepcion").val("");
                  }
              }
              $("#NumEmpModalBajaBajaUni").val("");
              $("#constraseniaFirmaBajaUni").val("");
              $("#modalFirmaElectronicaBajaUni").modal("hide");
            }//else
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });
  }
}

function cancelarFirmaBajaUni12(){
  $("#modalFirmaElectronicaBajaUni").modal("hide");
  $("#NumEmpModalBajaBajaUni").val("");
  $("#constraseniaFirmaBajaUni").val("");
}

function cargaerroresFirmaInternaBajaUnidforme(mensaje){
  $('#errorModalFirmaInternaBajaUni1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaBajaUni1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaBajaUni").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaBajaUni1').delay(4000).fadeOut('slow'); 
}    

$("#constraseniaFirmaElementoRecepcion").blur(function (){
  var contrasenia = $("#constraseniaFirmaElementoRecepcion").val();
  var numEmpleado = $("#txtbusqueda").val();
  $.ajax({
    type: "POST",
    url: "ajax_obtenercontraseniaEmpASignacion.php",
    data:{"contrasenia":contrasenia,"numEmpleado":numEmpleado},
    dataType: "json",
    success: function(response) {
      //console.log(response);
      if (response.status == "success"){
        var FirmaEmp = response.empleado["0"].contrasenia;
        $("#FirmaIntenaEmpleadoRecepcion").val(FirmaEmp);
        $("#ActivarActualizarCuentaRecepcion").hide();
      }else{
        cargaerroresFirmaInternaElementoRecepcion(response.menssaje); 
        $("#ActivarActualizarCuentaRecepcion").show();
        $("#constraseniaFirmaElementoRecepcion").val("");
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
});

function cargaerroresFirmaInternaElementoRecepcion(mensaje){
  $('#errormodalFirmaElementoRecepcion1').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaElementoRecepcion1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaElementoRecepcion").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaElementoRecepcion1').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaEmpleadoRecepcion(){
  $("#modalFirmaElementoRecepcion").modal("hide");
  $("#modalFirmaElectronicaBajaUni").modal();
  $("#constraseniaFirmaElementoRecepcion").val("");
}
//////////////////Comienza Modal Firma Del Guardia 03 //////////////////////////////////

$("#NumEmpModalRecepcionAdmin").keyup(function () {

 var NumEmpModalBajaRh = $("#NumEmpModalRecepcionAdmin").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBajaRh) || expreg1.test(NumEmpModalBajaRh)){
    consultaEmpleadoFirmaRecepcionAdmin(NumEmpModalBajaRh);
  }else{
    $("#constraseniaFirmaRecepcionAdmin").val("");
    $("#btnFirmarRecepcionAdmin").hide();
  }
});

function consultaEmpleadoFirmaRecepcionAdmin (numeroEmpleado){
  var caso = "0";
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado,"caso":caso},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerroresFirmaRecepcionAdmin("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalRecepcionAdmin").val("");
          $("#btnFirmarRecepcionAdmin").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaRecepcionAdmin("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH");
            $("#NumEmpModalRecepcionAdmin").val("");
            $("#btnFirmarRecepcionAdmin").hide();
          }else{
            $("#btnFirmarRecepcionAdmin").show();
          }
        }
      }else{
        cargaerroresFirmaRecepcionAdmin(response.menssaje);
        $("#NumEmpModalRecepcionAdmin").val("");
        $("#btnFirmarRecepcionAdmin").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
function cargaerroresFirmaRecepcionAdmin(mensaje){
  $('#errorModalFirmaRecepcionAdmin1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaRecepcionAdmin1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaRecepcionAdmin").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaRecepcionAdmin1').delay(4000).fadeOut('slow'); 
}

function RevisarFirmaInternaRecepcionAdmin(){//revision del empleado administrativo que entrega los uniformes
  var NumEmpModalBaja = $("#NumEmpModalRecepcionAdmin").val();
  var constraseniaFirma = $("#constraseniaFirmaRecepcionAdmin").val();
  var txtNumeroEmpleadoModal = $("#txtbusqueda").val();
  
  if(NumEmpModalBaja==""){
    cargaerroresFirmaRecepcionAdmin("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
      cargaerroresFirmaRecepcionAdmin("Escriba la contraseña para continuar");
  }else{
       $.ajax({
       type: "POST",
       url: "ajax_getFirmaSolicitada.php",
       data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
       dataType: "json",
       success: function(response) {
        if(response.status == "success"){
          var RespuestaLargo = response["datos"].length;
          if(RespuestaLargo == "0"){
             cargaerroresFirmaRecepcionAdmin("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
             $("#constraseniaFirmaRecepcionAdmin").val("");
          }else{
               var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
               var NumeroDuenioFirma = response.datos["0"].EntidadFirma + "-" + response.datos["0"].ConsecutivoFirma + "-" + response.datos["0"].CategoriaFirma;
               var contraseniaInsertadaCifrada = response.datos["0"].ContraseniaFirma;
           
              if(NumeroDuenioFirma != txtNumeroEmpleadoModal){
                 cargaerroresFirmaRecepcionAdmin("La firma No pertenece Al Administrativo que se esta dando de baja Por Favor ingresar la firma interna de quien se esta dando de baja");
                 $("#constraseniaFirmaRecepcionAdmin").val("");
                 $("#NumEmpModalRecepcionAdmin").val("");
              }else{
                   $("#modalFirmaElectronicaRecepcionAdmin").modal("hide");
                   $("#FirmaIntenaEmpleadoRecepcion").val(contraseniaInsertadaCifrada);
                   recibirUniforme(0);
              }
         }//else respuesta largo
       }
     },
     error: function(jqXHR, textStatus, errorThrown) {
         alert(jqXHR.responseText);
       }
     });
   }
} 
function cancelarFirmaRecepcionAdmin(){
  $("#NumEmpModalRecepcionAdmin").val("");
  $("#constraseniaFirmaRecepcionAdmin").val("");
  $("#modalFirmaElectronicaRecepcionAdmin").modal("hide");
  $("#modalFirmaElectronicaBajaUni").modal();
}

///////////////////////////////////////////////////////////////////////////////////////////////
     
function CargarTablaBajaEmpleados(){
  $.ajax({     
    type: "POST",
    url: "ajax_obtenerEmpleadosProcesoFiniquitoParaAlmacen.php",
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var listaFini = response.datos;
        var listaTableFini="<table class='table table-hover' ><thead><caption>LISTA DE EMPLEADOS EN PROCESO DE FINIQUITO (SE REQUIERE RECOGER UNIFORMES)</caption><th>#Empleado</th><th>Nombre Empleado</th><th>Fehca Baja Empleado</th><th>#Reclutador</th><th>Nombre Reclutador</th></thead><tbody>";
        for ( var i = 0; i < listaFini.length; i++ ){
          var FechaBajaEmpleado=listaFini[i].FechaBajaEmpleado;
          var NombreEmpleado=listaFini[i].NombreEmpleado;
          var NombreReclutador=listaFini[i].NombreReclutador;
          var NumEmpleado=listaFini[i].NumEmpleado;
          var NumRecluetador=listaFini[i].NumRecluetador;
          if(NombreReclutador=="" || NumRecluetador==""){
            NombreReclutador = "Sin Reclutador";
            NumRecluetador = "Sin Reclutador";
          }
          listaTableFini += "<tr><td>"+NumEmpleado+" </td><td>"+NombreEmpleado+" </td><td>"+FechaBajaEmpleado+"</td><td>"+NumRecluetador+"</td><td>"+NombreReclutador+"</td></tr>";
        }  
        listaTableFini += "</tbody></table>";
        $('#listFiniquitosPendientes').html(listaTableFini);
      }else{
        alert("error Response");
      }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText); 
    }
  });
}

function obtenerEstatusEmpleadoParaFirmaFiniquito(numeroEmpleado){
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEstatusEMpladoParaFirmaFniquitoUni.php",
    data:{"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    async: false,
     success: function(response) {
        if (response.status == "success")
        {//idUniformeF
          var datosEmp = response.empleado.length;
          var largoListaUniformesFiniquito = $("#largoListaUniformesFiniquito").val();
          var largodeudaFiniquito = $("#largodeudaFiniquito").val();
          if(datosEmp=="0"){
            $("#EstatusImssHidden").val(3);
            $("#EstatusFiniquitoHidden").val(0);
           // $("#firmauniformefiniquito").val(0);
          }else{
            $("#EstatusImssHidden").val(response.empleado[0].empleadoEstatusImss);
            $("#EstatusFiniquitoHidden").val(response.empleado[0].estatusFiniquito);
            $("#firmauniformefiniquito").val(response.empleado[0].idUniformeF);
          }
          var EstatusImss =$("#EstatusImssHidden").val();
          var EstatusFiniquito=$("#EstatusFiniquitoHidden").val();
          var firmauniformefiniquito=$("#firmauniformefiniquito").val();
          if((largoListaUniformesFiniquito =="0" && largodeudaFiniquito=="0") && EstatusImss =="7" && (EstatusFiniquito =="0" || EstatusFiniquito =="6") && firmauniformefiniquito === ""){
            $("#btnConfirmarUniRec").prop("disabled", true);
            $("#btnAFiniquito").prop("disabled", false);
          }else{
            $("#btnAFiniquito").prop("disabled", true);
          }
        }
    },error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}
//////////////////Comienza Modal Firma Del Administrativo Para El Finiquito //////////////////////////////////

$("#NumEmpModalFirmaFiniquito").keyup(function () {

 var NumEmpModalBajaRh = $("#NumEmpModalFirmaFiniquito").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBajaRh) || expreg1.test(NumEmpModalBajaRh)){
    consultaEmpleadoFirmaRecepcionAdminFniquito(NumEmpModalBajaRh);
  }else{
    $("#constraseniaFirmaFiniquito").val("");
    $("#btnFirmarFiniquito").hide();
  }
});

function consultaEmpleadoFirmaRecepcionAdminFniquito (numeroEmpleado){
  var caso = "1";
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado,"caso":caso},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        
        if(empleadoExtiste=="0"){
          cargaerroresFirmaFiniquito("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalFirmaFiniquito").val("");
          $("#btnFirmarFiniquito").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaFiniquito("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH");
            $("#NumEmpModalFirmaFiniquito").val("");
            $("#btnFirmarFiniquito").hide();
          }else{
            $("#btnFirmarFiniquito").show();
          }
        }
      }else{
        cargaerroresFirmaFiniquito(response.menssaje);
        $("#NumEmpModalFirmaFiniquito").val("");
        $("#btnFirmarFiniquito").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
function cargaerroresFirmaFiniquito(mensaje){
  $('#errorModalFirmaFiniquito1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaFiniquito1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaFiniquito").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaFiniquito1').delay(4000).fadeOut('slow'); 
}

function RevisarFirmaInternaFiniquito (){
  var NumEmpModalBaja = $("#NumEmpModalFirmaFiniquito").val();
  var constraseniaFirma = $("#constraseniaFirmaFiniquito").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaFiniquito("El numero de empleado no puede estar vaacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaFiniquito("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var RespuestaLargo = response["datos"].length;
        if(RespuestaLargo == "0"){
          cargaerroresFirmaFiniquito("La Contraseña ingresada es incorrecta favor de escribrla exactamente como la ingreso en el registro");
        }else{
          var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          var tipopuestoemp = $("#tipopuestoemp").val()
          $("#numempleadoFirmaBajaUnihidden").val(NumEmpModalBaja);
          $("#NombreSolicitanteBajaUnihidden").val(nombre);
          $("#FirmaInternaBajaUnihidden").val(contraseniaInsertadaCifrada);
          $("#NumEmpModalFirmaFiniquito").val("");
          $("#constraseniaFirmaFiniquito").val("");
          $("#modalFirmaElectronicaFiniquito").modal("hide");
          firmarA0();
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

function cancelarFirmaRecepcionAdmin(){
  $("#NumEmpModalFirmaFiniquito").val("");
  $("#constraseniaFirmaFiniquito").val("");
  $("#modalFirmaElectronicaFiniquito").modal("hide");
}

///////////////////////////////////////////////////////////////////////////////////////////////

function abrirmodalFirmaFiniquio(){
  $("#NumEmpModalFirmaFiniquito").val("");
  $("#constraseniaFirmaFiniquito").val("");
  $("#modalFirmaElectronicaFiniquito").modal();
}

function firmarA0(){//firmadirecta

  var NumeroEmpFirma = $("#numempleadoFirmaBajaUnihidden").val();
  var NombreEmp = $("#NombreSolicitanteBajaUnihidden").val();
  var FirmaEmp = $("#FirmaInternaBajaUnihidden").val();
  var FirmaGuardia = $("#FirmaIntenaEmpleadoRecepcion").val();
  var NumeroGuardia = $("#txtbusqueda").val();
  var NombreGuardia = $("#txtNombre").val();
  var estatusImss =$("#EstatusImssHidden").val();
  var estatusfiniquito =$("#EstatusFiniquitoHidden").val();
  var idfuncion= 1;
  var banderaFiniquito = $("#banderaFiniquito").val();
  var valRsi =$("#siRecepUni").val();
  var valRno =$("#noRecepUni").val();
  $("#modalFirmaElementoRecepcion").modal("hide");
  waitingDialog.show();
  var sucursalUsr = $("#SelectSucursalUsuario").val();
  var entidadUsr = $("#SelectEntidadUsuario").val();


  $.ajax({     
      type: "POST",
      url: "ajax_actualizarAsignacionesEmpleado.php",
      data:{"NumeroEmpFirma":NumeroEmpFirma,"NombreEmp":NombreEmp,"FirmaEmp":FirmaEmp,"FirmaGuardia":FirmaGuardia,"NumeroGuardia":NumeroGuardia,"NombreGuardia":NombreGuardia,"idfuncion":idfuncion,"estatusImss":estatusImss,"estatusfiniquito":estatusfiniquito,"banderaFiniquito":banderaFiniquito,"valRsi":valRsi,"valRno":valRno,"sucursalUsr":sucursalUsr,"entidadUsr":entidadUsr},
            dataType: "json",
            success:function(response){
                if(response.status == "success"){
                   var entidad= response["empleadoEntidad"];
                   var consecutivo= response["empleadoConsecutivo"];
                   var tipo= response["empleadoCategoria"];
                   consultaCardex(entidad,consecutivo,tipo);
                   var mensaje=response.message;
                  cargarmensajeerrorRecepcionUniforme(mensaje,"success");
                   CargarTablaBajaEmpleados();
                   waitingDialog.hide();
                   $("#btnConfirmarUniRec").prop("disabled", true);
                   $("#btnAFiniquito").prop("disabled", true);
                }else{
                    var mensaje=response.message;
                    cargarmensajeerrorRecepcionUniforme(mensaje,"error");
                    waitingDialog.hide();
                }
            },           
            error: function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText); 
                waitingDialog.hide();
            }
        });
 
}

function RevisarChecks(){//que haya recibido todos y no tenga adeudos del otro tipo de recepcion
  var largoListaUniformesFiniquito = $("#largoListaUniformesFiniquito").val();
  var EstatusImss = $("#EstatusImssHidden").val();
  var EstatusFiniquito = $("#EstatusFiniquitoHidden").val();
  var firmauniformefiniquito = $("#firmauniformefiniquito").val();
  var largodeudaFiniquito = $("#largodeudaFiniquito").val();              //en espera       vacacionespendientes
  if(largoListaUniformesFiniquito != "0" && EstatusImss =="7" && (EstatusFiniquito=="0" || EstatusFiniquito=="6") && firmauniformefiniquito==""){
    $.ajax({     
      type: "POST",
      url: "ajax_obtenerlargoRecepcionesTemporales.php",
      dataType: "json",
      success:function(response){
        if(response.status == "success"){
          var largoRTMP= response["largoRecepcionTMP"];
          if(largoRTMP == largoListaUniformesFiniquito){//recibio todos los uniformes
              if(largodeudaFiniquito=="0"){//si no debe de platilla o uso propio
                $("#banderaFiniquito").val(1);
              }else{
                    $("#banderaFiniquito").val(0);
              }
              abrirModalBajasUniformes();
          }else{
            var mensaje="Recibe todos los uniformes";
            cargarmensajeerrorRecepcionUniforme(mensaje,"error");
          }
        }//if success
      },error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText); 
      }       
    });
  }else{
    $("#banderaFiniquito").val(0);
    abrirModalBajasUniformes();
  }
}

function cargarmensajeerrorRecepcionUniforme(mensaje,tipo){
  $('#divMensajerRecepcionUniforme').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-"+tipo+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajerRecepcionUniforme").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajerRecepcionUniforme').delay(3000).fadeOut('slow');
}

function cargarMSJAdeudos(mensaje,tipo){
  $('#divAdeudo').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-"+tipo+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divAdeudo").html(mensajeErrorP);
  $(document).scrollTop(0);
  //$('#divAdeudo').delay(3000).fadeOut('slow');
}

function limpiarInfoEmp(){
  $("#txtbusqueda").prop("disabled", false);
  $("#txtbusqueda").val("");
  $("#SelectEntidadUsuario").prop("disabled", false);
  $("#SelectEntidadUsuario").val("");
  $("#SelectSucursalUsuario").prop("disabled", false);
  $("#SelectSucursalUsuario").val("");
  $('#cardexEmpleado').hide();
  $('#cardexEmpleado').html("");
  $("#fotoEmpleadoRec").html("");
  $("#txtNombre").val("");
  $("#txtFechaAlta").val("");
  $("#txtFechaBaja").val("");
  $("#inpCobertura").val("");
}

function actualizaIconosFormatos(entidad,consecutivo,tipo){
 var iconsAlta = $("#iconAlta");       
 var image = "<p><a href='download_documento.php?id=1&entidadEmpleado="+entidad+"&consecutivoEmpleado="+consecutivo+"&tipoEmpleado="+tipo+"'><img src='img/pdf.png' height='24px' width='24px'/></a></p>";        
 iconsAlta.html (image); 
 var iconsBaja = $("#iconBaja");
 var image1 = "<p><a href='download_documento.php?id=2&entidadEmpleado="+entidad+"&consecutivoEmpleado="+consecutivo+"&tipoEmpleado="+tipo+"'><img src='img/pdf.png' height='24px' width='24px'/></a></p>";        
 iconsBaja.html (image1);
}

function cargarSelectorEntidadesBaja(){
    $.ajax({
      type: "POST",
      url: "ajax_getEntidadesUsuario.php",
      dataType: "json",
      success: function(response) {
        $("#SelectEntidadUsuario").empty(); 
        $('#SelectEntidadUsuario').append('<option value="0">ENTIDAD FEDERATIVA</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){
               $('#SelectEntidadUsuario').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
              }
        }else{
          alert("Error Al Cargar Las Entidades");
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

$("#SelectEntidadUsuario").change(function (){

  const entidadSelect=$("#SelectEntidadUsuario").val();
  if(entidadSelect!=0){
    cargarSelectorSucursalesBaja(entidadSelect);
  }

});


function cargarSelectorSucursalesBaja(EntidadSeleccionada){

  $.ajax({
    type: "POST",
    url: "ajax_SucursalesXentRecepcionUnif.php",
    data:{"EntidadSeleccionada":EntidadSeleccionada},
    dataType: "json",
    success: function(response) {
      $("#stockUniforme").val(""); 
      $("#SelectSucursalUsuario").empty(); 
      $('#SelectSucursalUsuario').append('<option value="0">SUCURSAL</option>');
      if(response.status == "success"){
      $("#SelectSucursalUsuario").prop("disabled",false);
        for(var i = 0; i < response.datos.length; i++){
             $('#SelectSucursalUsuario').append('<option value="' + (response.datos[i].idSucursalI) + '">' + response.datos[i].nombreSucursal + '</option>');
        }
      }else{
            alert("Error Al Cargar Las Entidades");
      }
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert(jqXHR.responseText);
    }
  });
}

function eliminarRecibidosTMP(){
 $.ajax({     
         type: "POST",
         url: "ajax_EliminarRecepcionesUniTMP.php",
         dataType: "json",
         success:function(response){
                 if(response.status == "success"){
                    waitingDialog.hide();
                   }else{
                    alert("aqui2");
                         var mensaje=response.message;
                         alert(mensaje);
                        }
         },           
         error: function(jqXHR, textStatus, errorThrown){
               alert(jqXHR.responseText); 
               //alert("Error funcion")
              }
  });
}
</script>