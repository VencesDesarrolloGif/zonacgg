<div class="container" align="center">
<form class="form-horizontal"  method="post" name='form_asignarUnifSup' id="form_asignarUnifSup" enctype="multipart/form-data">
  <legend><h3>Asignar Uniforme</h3></legend>  
  <div id="divMensajeAsignacionSupervisor"></div>   
  <center>
    <label for="inpBuscarEmp">No. de Empleado</label>
    <input type="text" name="inpBuscarEmp" id="inpBuscarEmp"class="search-query" placeholder="Buscar (00-0000-00)" aria-describedby="basic-addon2" onkeyup="verificaConsultaEmpleadoAsignacionSup();" onblur=""><img src="img/search.png">
  </center>
    <br>
  <div id="fotoEmpleado" style="width:140px;height:133px;border:1px solid;text-align:center;"></div> 
  <br>   
  <table class="table1">
        <tr>
          <td><label class="control-label label " for="inpNombreEmpleado">Nombre Empleado</label></td>
          <td><input id="inpNombreEmpleado" name="inpNombreEmpleado" type="text" class="input-XLarge" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtTallaCamisa">Talla Camisa</label></td>
          <td><input id="txtTallaCamisa" name="txtTallaCamisa" type="text" class="input-mini" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtTallaPantalon">Talla Pantalón</label></td>
          <td><input id="txtTallaPantalon" name="txtTallaPantalon" type="text" class="input-mini" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtNumeroCalzado">Numero Calzado</label></td>
          <td><input id="txtNumeroCalzado" name="txtNumeroCalzado" type="text" class="input-mini" readonly /></td>        
        </tr>
        <tr>
          <td><label class="control-label label " for="txtPuntoServicio">Punto de Servicio</label></td>
          <td><input id="txtPuntoServicio" name="txtPuntoServicio" type="text" class="input-large" readonly /></td>        
        </tr>
        <tr>
          <td></td>
          <td><button type='button' class='btn btn-success' id='btnAsignar' name='btnAsignar' disabled="true">Asignar Uniforme</button></td>
        </tr> 
      <input type="hidden" class="input-medium" id="numempleadoFirmaAsignacionhiddenSUP" name="numempleadoFirmaAsignacionhiddenSUP" readonly="true">
      <input type="hidden" class="input-medium" id="NombreSolicitanteAsignacionSup" name="NombreSolicitanteAsignacionSup" readonly="true">
      <input type="hidden" class="input-medium" id="FirmaInternaAsignacionSup" name="FirmaInternaAsignacionSup" readonly="true">
      <input type="hidden" class="input-medium" id="FirmaIntenaEmpleadoQueRecibeSup" name="FirmaIntenaEmpleadoQueRecibeSup" readonly="true">
      <input type="hidden" class="input-medium" id="idTipoPuestoSup" name="idTipoPuestoSup" readonly="true">
      <input type="hidden" class="input-medium" id="banderaIdOrden" name="banderaIdOrden" readonly="true">
   </table>
   <br>
   <h3 style=" color: blue; display: none;" id="tituloStock">Uniformes en Stock</h3>
  <div id="stockSupervisor" style="width:950px; background:#AED6F1; float:center; display: none;"></div>
  <input id="banderatabla" name="banderatabla" type="hidden" class="input-large"/>
</form>
</div>
<center>
</center>

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaAsignacionSupervisor" id="modalFirmaElectronicaAsignacionSupervisor" data-backdrop="static">
  <div id="errorModalFirmaInternaAsignacionSupSupervisor"></div>
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
        <input type="text" id="NumEmpModalBajaAsignacionSupervisor" class="input-medium" name="NumEmpModalBajaAsignacionSupervisor" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaAsignacionSupervisor" class="input-xlarge"name="constraseniaFirmaAsignacionSupervisor" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarDocSupervisor" name="btnFirmarDocSupervisor" style="display: none;" onclick="RevisarFirmaInternaAsignacionSupSupervisor();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarFirmaSupervisor" name="btnCancelarFirmaSupervisor"onclick="cancelarFirmaAsignacionSupervisor();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElementoAsignacionSupervisor" id="modalFirmaElementoAsignacionSupervisor" data-backdrop="static">
  <div id="errormodalFirmaElementoAsignacionSupervisor"></div>
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
        <input type="password" maxlength="10" id="constraseniaFirmaElementoAsignacionSupervisor" class="input-xlarge"name="constraseniaFirmaElementoAsignacionSupervisor" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" id="ActivarActualizarCuentaSupervisor" align="center" style="display: none;">
          <p><a  href="form_activacionCuentaUsuario.php" target="_blank">Activar/Actualizar Cuenta</a></p>
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarDocSupervisorGuardiaSupervisor" name="btnFirmarDocSupervisorGuardiaSupervisor" style="display: none;" onclick="asignarUnifSup(0);" class="btn btn-primary" >Continuar</button>
        <button type="button" id="btnCancelarFirmaSupervisor" name="btnCancelarFirmaSupervisor"onclick="cancelarFirmaEmpleadoAsignacionSupervisor();" class="btn btn-danger" >Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////// modal Firma Guardia Administrativo////////////////////////////////////////////////////////////////// -->



<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElementoAsignacionSupervisorAdmin" id="modalFirmaElementoAsignacionSupervisorAdmin" data-backdrop="static"> <!-- modal FirmaBajaEmpleado -->
  <div id="errormodalFirmaElementoAsignacionSupervisorAdmin1"></div>
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
        <input type="text" id="NumEmpModalBajaAsignacionSupervisorAdmin" class="input-medium" name="NumEmpModalBajaAsignacionSupervisorAdmin" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaAsignacionSupervisorAdmin" class="input-xlarge"name="constraseniaFirmaAsignacionSupervisorAdmin" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        
        <button type="button" id="btnFirmarAsignacionAdminSupervisor" name="btnFirmarAsignacionAdminSupervisor" style="display: none;" onclick="RevisarFirmaInternaAsigAdminSup();" class="btn btn-primary" >Continuar</button>
        <button type="button" id="btnCancelarFirmaSupervisorAsignacionAdmin" name="btnCancelarFirmaSupervisorAsignacionAdmin"onclick="cancelarFirmaIntAsigAdminSup();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div> <!-- FIN modal FirmaBajaEmpleado -->


<!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<script type="text/javascript">

function verificaConsultaEmpleadoAsignacionSup(){
  
  limpiarFormularioSup();
  var inpBuscarEmp = $("#inpBuscarEmp").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
   if (expreg.test(inpBuscarEmp) || expreg1.test(inpBuscarEmp)){
       var numeroEmpleado = $("#inpBuscarEmp").val();    
       consultaDatosEmpleado(numeroEmpleado);
       $("#tituloStock").hide();
       $("#stockSupervisor").hide();
      }
}

function consultaDatosEmpleado (numeroEmpleado)
{
    var numeroEmpleado1 = numeroEmpleado;
    $.ajax({
            type: "POST",
            url: "ajax_obtenerDatosEmpleado.php",
            data:{"numeroEmpleado":numeroEmpleado1},
            dataType: "json",
             success: function(response) {
                if (response.status == "success"){
                    var empleadoEncontrado = response.empleado;
                     if(empleadoEncontrado.length == 0){
                        mensaje="No existe Número de empleado";
                        cargarmensajeAsignacionSupervisor(mensaje,"error");
                        }else{                                          
                          for(var i = 0; i < empleadoEncontrado.length; i++ ){
                              var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                              var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                              var inpNombreEmpleado  = empleadoEncontrado[i].nombreEmpleado;
                              var tallaCamisa  =empleadoEncontrado[i].tallaCEmpleado;
                              var tallaPantalon=empleadoEncontrado[i].tallaPEmpleado;
                              var numCalzado   =empleadoEncontrado[i].numCalzadoEmpleado;
                              var estatusEmpleado= empleadoEncontrado[i].empleadoEstatusId;
                              var puntoServicio  =empleadoEncontrado[i].puntoServicio;
                              var foto = empleadoEncontrado[i].fotoEmpleado;
                              var idTipoPuestoSup = empleadoEncontrado[i].idTipoPuestoSup;
                              $("#idTipoPuestoSup").val(idTipoPuestoSup);
                             if(estatusEmpleado!=0){
                                $("#fotoEmpleado").html ("<img src='thumbs/" + foto + "' />");
                                $("#inpNombreEmpleado").val(inpNombreEmpleado+" "+empleadoApellidoPaterno+" "+empleadoApellidoMaterno);
                                $("#txtTallaCamisa").val(tallaCamisa);
                                $("#txtTallaPantalon").val(tallaPantalon);
                                $("#txtNumeroCalzado").val(numCalzado);
                                $("#txtPuntoServicio").val(puntoServicio);
                                cargarUniformesStockSupervisor();     
                                $("#btnAsignar").prop("disabled",false);
                                $("#tituloStock").show();
                                $("#stockSupervisor").show();
                               }else{
                                     mensaje="Empleado dado de baja";
                                     cargarmensajeAsignacionSupervisor(mensaje,"error");
                                     $("#tituloStock").hide();
                                     $("#stockSupervisor").hide();
                                    }
                             } 
                           } 
                }else if (response.status == "error"){
                          //alert(response.error);
                          mensaje=response.error;
                          cargarmensajeAsignacionSupervisor(mensaje,"error");
                         }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
}

function cargarUniformesStockSupervisor(){

      $.ajax({    
            async:false,        
            type: "POST",
            url: "ajax_UniformesStockSupervisor.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success"){
                    var stockUniformes = response.stock;
                    var listaTable="<table id='aa' class='table table-hover'><thead><th>Codigo Uniforme</th><th>Descripcion</th><th>Fecha Asignación</th><th>Monto a cobrar</th><th>Asignar</th></thead><tbody>";
                    $("#banderatabla").val(stockUniformes.length);
                    for(var i = 0; i < stockUniformes.length; i++){
                        var fechaAsignacionASup=stockUniformes[i].fechaAsignacionASup;
                        var codigoUniforme =stockUniformes[i].codigoUniforme;
                        var descripcionUni =stockUniformes[i].descUniforme;
                        var tipoMerca      =stockUniformes[i].idTipoMercancia;
                        var idUniforme     =stockUniformes[i].idUniforme;
                        var costoUniforme  =stockUniformes[i].costoUniforme;
                        var idAsignacion   =stockUniformes[i].idAsignacionUniformeASupervisor;
                        if (costoUniforme==0) {
                            var costoUniforme1="NO APLICA";
                          }else{
                                var costoUniforme1 =stockUniformes[i].costoUniforme;
                              }
                        listaTable += "<td>"+codigoUniforme+" </td><td>"+descripcionUni+" </td><td>"+fechaAsignacionASup+"</td>";
                        listaTable += "<td><input id='montoCobro"+i+"' value='"+costoUniforme1+"' disabled=true></td>";
                        listaTable += "<td><input id='check"+i+"' onclick=activarcheck("+idAsignacion+","+i+"); value='' type='checkbox' style='transform: scale(2);'></td></tr>";
                      }   
                    listaTable += "</tbody></table>";
                    $('#stockSupervisor').html(listaTable);
                    $('#stockSupervisor').show();
                 }else{
                  var mensaje=response.error;
                    cargarmensajeAsignacionSupervisor(mensaje,"error")
                 }
            },           
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
                  //alert("Error funcion")
            }
        });
}

function activarcheck(id,i){

  var valorcheck = $("#check"+i+"").val();

  if (valorcheck == "") {
       $("#check"+i+"").val(id);
    }else{
       $("#check"+i+"").val("");
    }
}

$("#btnAsignar").click(function(){
  $("#modalFirmaElectronicaAsignacionSupervisor").modal();
});

function asignarUnifSup(opcion){
  var numempleadoFirmaAsignacion  = $("#numempleadoFirmaAsignacionhiddenSUP").val();
  var NombreSolicitanteAsignacionSup = $("#NombreSolicitanteAsignacionSup").val();
  var FirmaInternaAsignacionSup      = $("#FirmaInternaAsignacionSup").val();
  var FirmaIntenaEmpleadoQueRecibeSup= $("#FirmaIntenaEmpleadoQueRecibeSup").val();
  var contrasenia = $("#constraseniaFirmaElementoAsignacionSupervisor").val();
  var NombreEmpleado = $("#inpNombreEmpleado").val();
  var NumeroEmpleado = $("#inpBuscarEmp").val();
  var totalchecks   = $("#banderatabla").val();
  $("#banderaIdOrden").val(0);

  if(contrasenia == "" && opcion=="0"){
     cargaerroresFirmaInternaElementoAsignacion("Ingrese la contraseña generada al activar la cuenta del elemento en la plataforma de Gif Segurdad Privda");
    }else{  
       for(var i = 0; i < totalchecks; i++) {
          var idOrden=$("#banderaIdOrden").val();
           var montoACobrar=$("#montoCobro"+i).val();
           var check       =$("#check"+i).val(); 

         if(check!=""){

            $.ajax({
                   type: "POST",
                   url: "ajax_ConfirmarAsignacionSupervisor.php",
                   data:{"numempleadoFirmaAsignacion":numempleadoFirmaAsignacion,"NombreSolicitanteAsignacionSup":NombreSolicitanteAsignacionSup,"FirmaInternaAsignacionSup":FirmaInternaAsignacionSup,"FirmaIntenaEmpleadoQueRecibeSup":FirmaIntenaEmpleadoQueRecibeSup,"NombreEmpleado":NombreEmpleado,"NumeroEmpleado":NumeroEmpleado,"montoACobrar":montoACobrar,"check":check,"idOrden":idOrden},
                   dataType: "json",
                   async: false,
                   success: function(response) {
                     if(response.status == "success"){
                        waitingDialog.hide();
                        console.log(response);
                        var mensaje=response.message;
                        $("#banderaIdOrden").val(response.IdOrden);
                        cargarmensajeAsignacionSupervisor(mensaje,response.status);
                        limpiarFormularioSup();
                        $("#inpBuscarEmp").val("");
                        $("#modalFirmaElementoAsignacionSupervisor").modal("hide");
                        $("#constraseniaFirmaElementoAsignacionSupervisor").val("");
                        $("#stockSupervisor").hide();
                      }else{
                          var mensaje=response.message;
                          cargaerroresFirmaInternaElementoAsignacion(mensaje);  
                          waitingDialog.hide();
                          $("#stockSupervisor").hide();
                         }
                   },error: function(jqXHR, textStatus, errorThrown) {
                          alert(jqXHR.responseText); 
                          waitingDialog.hide();
                          }
                 });
          }//if check
        }//for

      }//ELSE
  }//funcion

function cargarmensajeAsignacionSupervisor(mensaje,tipo){
  $('#divMensajeAsignacionSupervisor').fadeIn('slow');
  mensajeAlert="<div id='msgAlert' class='alert alert-"+tipo+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeAsignacionSupervisor").html(mensajeAlert);
  $(document).scrollTop(0);
  $('#divMensajeAsignacionSupervisor').delay(3000).fadeOut('slow');
}

function limpiarFormularioSup(){
  $("#btnAsignar").prop("disabled",true);
  $("#fotoEmpleado").html ("");
  $("#inpNombreEmpleado").val("");
  $("#txtTallaCamisa").val("");
  $("#txtTallaPantalon").val("");
  $("#txtNumeroCalzado").val("");
  $("#txtPuntoServicio").val("");
}

$("#NumEmpModalBajaAsignacionSupervisor").keyup(function (){

 var NumEmpModalBaja = $("#NumEmpModalBajaAsignacionSupervisor").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBaja) || expreg1.test(NumEmpModalBaja)){
    consultaEmpleadoFirmaInternaBajaAsignacion(NumEmpModalBaja);
  }else{
    //cargaerroresFirmaInternaBajaAsignacion("El Formato Del Numero De Empleado Es Incorrecto");
    $("#constraseniaFirmaAsignacionSupervisor").val("");
    $("#btnFirmarDocSupervisor").hide();
  }
});

function consultaEmpleadoFirmaInternaBajaAsignacion(numeroEmpleado){
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorIdFirmaBaja.php",
    data:{"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerroresFirmaInternaBajaAsignacion("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaAsignacionSupervisor").val("");
          $("#btnFirmarDocSupervisor").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaInternaBajaAsignacion("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH"); 
            $("#NumEmpModalBajaAsignacionSupervisor").val("");
            $("#btnFirmarDocSupervisor").hide();
          }else{
            $("#btnFirmarDocSupervisor").show();
          }
        }
      }else{
        cargaerroresFirmaInternaBajaAsignacion(response.menssaje); 
        $("#NumEmpModalBajaAsignacionSupervisor").val("");
        $("#btnFirmarDocSupervisor").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
}

function RevisarFirmaInternaAsignacionSupSupervisor(){

  var NumEmpModalBaja = $("#NumEmpModalBajaAsignacionSupervisor").val();
  var constraseniaFirma = $("#constraseniaFirmaAsignacionSupervisor").val();
 
 if(NumEmpModalBaja==""){
   cargaerroresFirmaInternaBajaAsignacion("El numero de empleado no puede estar vaacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaInternaBajaAsignacion("Escriba la contraseña para continuar");
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
          cargaerroresFirmaInternaBajaAsignacion("La Contraseña ingresada es incorrecta favor de escribrla exactamente como la ingreso en el registro");
        }else{
              var idTipoPuestoSup1 = $("#idTipoPuestoSup").val();
              var nombre = response.datos["0"].nombreEmpleado + " " + response.datos["0"].apellidoPaterno + " " + response.datos["0"].apellidoMaterno;
              var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
              $("#numempleadoFirmaAsignacionhiddenSUP").val(NumEmpModalBaja);
              $("#NombreSolicitanteAsignacionSup").val(nombre);
              $("#FirmaInternaAsignacionSup").val(contraseniaInsertadaCifrada);
              $("#modalFirmaElectronicaAsignacionSupervisor").modal("hide");
              $("#NumEmpModalBajaAsignacionSupervisor").val("");
              $("#constraseniaFirmaAsignacionSupervisor").val("");
              if(idTipoPuestoSup1 == "02"){
                $("#NumEmpModalBajaAsignacionSupervisorAdmin").val("");
                $("#constraseniaFirmaAsignacionSupervisorAdmin").val("");
                $("#modalFirmaElementoAsignacionSupervisorAdmin").modal();
                $("#btnFirmarAsignacionAdminSupervisor").hide();
              }else{
                $("#modalFirmaElementoAsignacionSupervisor").modal();
                $("#constraseniaFirmaElementoAsignacionSupervisor").val("");
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

function cancelarFirmaAsignacionSupervisor(){
  $("#modalFirmaElectronicaAsignacionSupervisor").modal("hide");
  $("#NumEmpModalBajaAsignacionSupervisor").val("");
  $("#constraseniaFirmaAsignacionSupervisor").val("");
}

function cargaerroresFirmaInternaBajaAsignacion(mensaje){
  $('#errorModalFirmaInternaAsignacionSupSupervisor1').fadeIn();
  msjerrorbaja="<div id='errorModalFirmaInternaAsignacionSupSupervisor1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorModalFirmaInternaAsignacionSupSupervisor").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorModalFirmaInternaAsignacionSupSupervisor1').delay(4000).fadeOut('slow'); 
}

function cancelarFirmaEmpleadoAsignacionSupervisor(){
  $("#modalFirmaElementoAsignacionSupervisor").modal("hide");
  $("#modalFirmaElectronicaAsignacionSupervisor").modal();
  $("#constraseniaFirmaElementoAsignacionSupervisor").val("");
}

$("#constraseniaFirmaElementoAsignacionSupervisor").blur(function (){
  $("#btnFirmarDocSupervisorGuardiaSupervisor").hide();
  var contrasenia = $("#constraseniaFirmaElementoAsignacionSupervisor").val();
  var numEmpleado = $("#inpBuscarEmp").val();
  $.ajax({
    type: "POST",
    url: "ajax_obtenercontraseniaEmpASignacion.php",
    data:{"contrasenia":contrasenia,"numEmpleado":numEmpleado},
    dataType: "json",
    success: function(response) {
      if (response.status == "success"){
        var FirmaEmp = response.empleado["0"].contrasenia;
        $("#FirmaIntenaEmpleadoQueRecibeSup").val(FirmaEmp);
        $("#ActivarActualizarCuentaSupervisor").hide();
        $("#btnFirmarDocSupervisorGuardiaSupervisor").show();
      }else{
        cargaerroresFirmaInternaElementoAsignacion(response.menssaje); 
        $("#ActivarActualizarCuentaSupervisor").show();
        $("#constraseniaFirmaElementoAsignacionSupervisor").val("");
        $("#btnFirmarDocSupervisorGuardiaSupervisor").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
});

function cargaerroresFirmaInternaElementoAsignacion(mensaje){
  $('#errormodalFirmaElementoAsignacionSupervisor1').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaElementoAsignacionSupervisor1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaElementoAsignacionSupervisor").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaElementoAsignacionSupervisor1').delay(4000).fadeOut('slow'); 
}

//////////////////////////////////////////////// Modal Firma Recepcion cuando el empleado es administrativo ////////////////////////////////////////////////

$("#NumEmpModalBajaAsignacionSupervisorAdmin").keyup(function () 
{

 var NumEmpModalBajaRh = $("#NumEmpModalBajaAsignacionSupervisorAdmin").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(NumEmpModalBajaRh) || expreg1.test(NumEmpModalBajaRh)){
    consultaEmpleadoFirmaAsignacionAdmin(NumEmpModalBajaRh);
  }else{
   // cargaerroresFirmaAsigAdmin("El Formato Del Numero De Empleado Es Incorrecto");
    $("#constraseniaFirmaAsignacionSupervisorAdmin").val("");
    $("#btnFirmarAsignacionAdminSupervisor").hide();
  }
});
function consultaEmpleadoFirmaAsignacionAdmin (numeroEmpleado){
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
          cargaerroresFirmaAsigAdmin("El Empleado No Existe En La Base De Registro De Firmas Favor De Verificar");
          $("#NumEmpModalBajaAsignacionSupervisorAdmin").val("");
          $("#btnFirmarAsignacionAdminSupervisor").hide();
        }else {
          var EstatusFirmaInterna = response.empleado[0].EstatusFirmaInterna;
          if(EstatusFirmaInterna=="0"){
            cargaerroresFirmaAsigAdmin("Esta Firma Fue Dada De Baja Favor de solicitar Otra o Comunicarse Con RH");
            $("#NumEmpModalBajaAsignacionSupervisorAdmin").val("");
            $("#btnFirmarAsignacionAdminSupervisor").hide();
          }
          else{
           $("#btnFirmarAsignacionAdminSupervisor").show(); 
          }
        }
      }else{
        cargaerroresFirmaAsigAdmin(response.menssaje);
        $("#NumEmpModalBajaAsignacionSupervisorAdmin").val("");
        $("#btnFirmarAsignacionAdminSupervisor").hide();
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
function cargaerroresFirmaAsigAdmin(mensaje){
  $('#errormodalFirmaElementoAsignacionSupervisorAdmin1').fadeIn();
  msjerrorbaja="<div id='errormodalFirmaElementoAsignacionSupervisorAdmin1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errormodalFirmaElementoAsignacionSupervisorAdmin").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errormodalFirmaElementoAsignacionSupervisorAdmin1').delay(4000).fadeOut('slow'); 
}


function RevisarFirmaInternaAsigAdminSup(){
  var NumEmpModalBaja = $("#NumEmpModalBajaAsignacionSupervisorAdmin").val();
  var constraseniaFirma = $("#constraseniaFirmaAsignacionSupervisorAdmin").val();
  var txtNumeroEmpleadoModal = $("#inpBuscarEmp").val();
 if(NumEmpModalBaja==""){
   cargaerroresFirmaAsigAdmin("El numero de empleado no puede estar vacio");
  }else if(constraseniaFirma==""){
     cargaerroresFirmaAsigAdmin("Escriba la contraseña para continuar");
  }else{
    $.ajax({
      type: "POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModalBaja,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
    success: function(response) {
      if (response.status == "success")
      {
        var RespuestaLargo = response["datos"].length;
        if(RespuestaLargo == "0"){
          cargaerroresFirmaAsigAdmin("La Contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
          $("#constraseniaFirmaAsignacionSupervisorAdmin").val("");
        }else{
          var NumeroDuenioFirma = response.datos["0"].EntidadFirma + "-" + response.datos["0"].ConsecutivoFirma + "-" + response.datos["0"].CategoriaFirma;
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          //alert(NumeroDuenioFirma + " " + "NumeroDuenioFirma");
          //alert(txtNumeroEmpleadoModal + " " + "txtNumeroEmpleadoModal");
          if(NumeroDuenioFirma != txtNumeroEmpleadoModal){
            cargaerroresFirmaAsigAdmin("La firma No pertenece Al Administrativo que se esta dando de baja Por Favor ingresar la firma interna de quien se esta dando de baja");
            $("#constraseniaFirmaAsignacionSupervisorAdmin").val("");
            $("#NumEmpModalBajaAsignacionSupervisorAdmin").val("");
            $("#btnFirmarAsignacionAdminSupervisor").hide();
          }else{
            $("#modalFirmaElementoAsignacionSupervisorAdmin").modal("hide");
            $("#FirmaIntenaEmpleadoQueRecibeSup").val(contraseniaInsertadaCifrada);
            asignarUnifSup(1);
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


function cancelarFirmaIntAsigAdminSup(){
  $("#NumEmpModalBajaAsignacionSupervisorAdmin").val("");
  $("#constraseniaFirmaAsignacionSupervisorAdmin").val("");
  $("#modalFirmaElementoAsignacionSupervisorAdmin").modal("hide");
  $("#modalFirmaElectronicaAsignacionSupervisor").modal();
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


</script>