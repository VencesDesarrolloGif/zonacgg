<center><h3>Detalle de Contrato</h3></center>
<br>
<div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaDC" id="modalFirmaElectronicaDC" data-backdrop="static" style="display:none;">
  <div id="errorModalFirmaDC"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title" align="center"><img src="img/alert.png">Escriba su numero de empleado y la contraseña que generó!!!</h3>
      </div>
      <div class="modal-body" align="center">
        <span class="add-on"># Empleado</span>
        <input type="text" id="NumEmpModalFirmaDC" class="input-medium" name="NumEmpModalFirmaDC" placeholder="00-0000-00 Ó 00-00000-00">
        <span class="add-on">Contraseña</span>
        <input type="password" id="constraseniaFirmaDC" class="input-xlarge"name="constraseniaFirmaDC" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
      </div>
      <div class="modal-body" align="center">
        <button type="button" id="btnFirmarRechazoTransfer" name="btnFirmarRechazoTransfer" onclick="RevisarFirmaInternaDC();" class="btn btn-primary" >Firmar</button>
        <button type="button" id="btnCancelarRechaziFirma" name="btnCancelarRechaziFirma"onclick="cancelarFirmaDCo();" class="btn btn-danger" >Cancelar</button>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<input type="hidden" id="idContratoClienteHidden">

<section>
<center>

<select id="cuatrimestreDetalleContrato" name="cuatrimestreDetalleContrato" class="input-medium"  >
  <option value="0">Cuatrimestre</option>
  <option value="1">Enero-Abril</option>
  <option value="2">Mayo-Agosto</option>
  <option value="3">Septiembre-Diciembre</option>
</select>

    <select id="anioDetalleContrato" name="anioDetalleContrato" class="input-medium">
      <option value="" selected>Año</option>
      <?php $year = date("Y");
      for($i=$year; $i>=2020; $i--){
          echo '<option value="'.$i.'">'.$i.'</option>';
         }
      ?>
    </select>

<img id="btnBuscarDetalleContrato" src="img\botonbuscar.jpg" onclick="consultaDetalleContrato();" style="width: 6.5%;" title="Buscar">
</center>
<table id="tablaDetalleContrato"  class="records_list table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="display: none;">
    <thead>
        <tr>
            <th style="text-align: center;background-color: #B0E76E">Contrato</th>
            <th style="text-align: center;background-color: #B0E76E;">Estatus</th>
            <th style="text-align: center;background-color: #B0E76E">RFC del sujeto obligado</th>
            <th style="text-align: center;background-color: #B0E76E">Número de contrato</th>
            <th style="text-align: center;background-color: #B0E76E">Tipo de Contrato</th>
            <th style="text-align: center;background-color: #B0E76E">Objeto del contrato</th>
            <th style="text-align: center;background-color: #B0E76E">Monto del contrato</th>
            <th style="text-align: center;background-color: #B0E76E">Vigencia(del contrato)</th>
            <th style="text-align: center;background-color: #B0E76E">Fecha de inicio(del contrato)</th>       
            <th style="text-align: center;background-color: #B0E76E">Fecha de término(del contrato)</th>
            <th style="text-align: center;background-color: #B0E76E">Número estimado mensual de trabajadores que se pondrán a disposición(del contrato)</th>
            <th style="text-align: center;background-color: #B0E76E">Registro Federal de Contribuyentes</th>
            <th style="text-align: center;background-color: #B0E76E">Nombre, denominación o razón social</th>
            <th style="text-align: center;background-color: #B0E76E">Registro Patronal ante el IMSS</th>
            <th style="text-align: center;background-color: #B0E76E">Calle</th>
            <th style="text-align: center;background-color: #B0E76E">Número exterior</th>
            <th style="text-align: center;background-color: #B0E76E">Número interior</th>
            <th style="text-align: center;background-color: #B0E76E">Entre calle</th>
            <th style="text-align: center;background-color: #B0E76E">Y calle</th>
            <th style="text-align: center;background-color: #B0E76E">Colonia</th>
            <th style="text-align: center;background-color: #B0E76E">Código Postal</th>
            <th style="text-align: center;background-color: #B0E76E">Municipio o Alcaldía</th>
            <th style="text-align: center;background-color: #B0E76E">Entidad federativa</th>
            <th style="text-align: center;background-color: #B0E76E">correo electronico</th>
            <th style="text-align: center;background-color: #B0E76E">telefono (numero, extensión)</th>
        </tr>
    </thead>        
</table>
</section>
<script type="text/javascript"> 

function consultaDetalleContrato() { 
    
    var cuatrimestre= $("#cuatrimestreDetalleContrato").val();
    var anio= $("#anioDetalleContrato").val();

    if(cuatrimestre==''){
       alert("selecciones un cuatrimestre");
       return;
    }else if (anio==''){
        alert("selecciones un año");
        return;
    }
    tableDetCont = [];

    $.ajax({
          type: "POST",
          url: "ajax_ConsultaDetalleContrato.php",
          data:{cuatrimestre,anio},
          dataType: "json", 
          success: function(response){
              if(response.status == "success"){
                // waitingDialog.hide();
                $("#tablaDetalleContrato").show();
                var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";
                for(var i = 0; i < response.datosContrato.length; i++){

                    var claveClienteNominaCliente= response.datosContrato[i]["claveClienteNominaCliente"];
                    var NombreArchivo= response.datosContrato[i]["NombreArchivo"];
                    var usrActual= response.datosContrato[i]["usrActual"];
                    var estatusValidacion= response.datosContrato[i]["estatusValidacion"];
                    var idContratoCliente= response.datosContrato[i]["idContratoCliente"];

                    pdfcontrato="<img style='width: 90%' title='Insertar monto negociado' src='img/pdf.png' class='cursorImg'  id='btnRechazar' onclick=mostrarDocumento('"+claveClienteNominaCliente+"','"+NombreArchivo+"','"+usrActual+"','"+idContratoCliente+"')>";

                    response.datosContrato[i]["pdfcontrato"] = pdfcontrato;
                    objetoContratoValidado= validarTexto(response.datosContrato[i]["ObjetoContrato"]);
                    callePrincipaCM= validarTexto(response.datosContrato[i]["CallePrincipaC"]);
                    numeroExteriorC= validarTexto(response.datosContrato[i]["NumeroExteriorC"]);
                    numeroInterirC = validarTexto(response.datosContrato[i]["NumeroInterirC"]);
                    primerCalle    = validarTexto(response.datosContrato[i]["PrimerCalle"]);
                    segundaCalle   = validarTexto(response.datosContrato[i]["SegundaCalle"]);
                    nombreAsentamiento = validarTexto(response.datosContrato[i]["nombreAsentamiento"]);
                    codigoPostalC  = validarTexto(response.datosContrato[i]["CodigoPostalC"]);
                    nombreMunicipio= validarTexto(response.datosContrato[i]["nombreMunicipio"]);
                    nombreEntidadFederativa = validarTexto(response.datosContrato[i]["nombreEntidadFederativa"]);
                    telefonoFijoCliente = validarTexto(response.datosContrato[i]["telefonoFijoCliente"]);
                    response.datosContrato[i]["objetoContratoV"] = objetoContratoValidado;
                    response.datosContrato[i]["CallePrincipaC"] = callePrincipaCM;
                    response.datosContrato[i]["NumeroExteriorC"]= numeroExteriorC;
                    response.datosContrato[i]["NumeroInterirC"] = numeroInterirC;
                    response.datosContrato[i]["PrimerCalle"] = primerCalle;
                    response.datosContrato[i]["SegundaCalle"]= segundaCalle;
                    response.datosContrato[i]["nombreAsentamiento"]= nombreAsentamiento;
                    response.datosContrato[i]["CodigoPostalC"]  = codigoPostalC;
                    response.datosContrato[i]["nombreMunicipio"]= nombreMunicipio;
                    response.datosContrato[i]["nombreEntidadFederativa"]= nombreEntidadFederativa;
                    response.datosContrato[i]["telefonoFijoCliente"]= telefonoFijoCliente;

                    var record = response.datosContrato[i];
                    tableDetCont.push(record);
                   }
                loadDataInTableDetCont(tableDetCont);
               }else{
                     var mensaje = response.message;
                     console.log("mal");
                     // waitingDialog.hide();
                     $("#tablaDetalleContrato").hide();
                    }
          },error:function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
                  // waitingDialog.hide();
                  $("#tablaDetalleContrato").hide();
                 }
        });
 }

function mostrarDocumento (claveClienteNominaCliente,nombreArchivo,usrActual,idContratoCliente){

    if (usrActual=='mirandam'){
        $.ajax({
              type: "POST",
              url: "ajax_insertRevisionContrato.php",
              data:{idContratoCliente},
              dataType: "json", 
              success: function(response){
                if(response.status == "success"){
                   console.log(response['estatusRevisionPdf']);
                }else{
                      console.log("error al actualizar estatus revision");
                }
              },error:function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText);
                     }
            });    
    }
    window.open("uploads/ContratosClientes/"+claveClienteNominaCliente+"/"+nombreArchivo+".pdf");
}

function validarContrato (estatusRevisionPdf,idContratoCliente){
    $("#idContratoClienteHidden").val(idContratoCliente);
    if(estatusRevisionPdf=='1'){
       $("#modalFirmaElectronicaDC").modal();
    }else{
        $.ajax({
              type: "POST",
              url: "ajax_consultaRevisionContrato.php",
              data:{idContratoCliente},
              dataType: "json", 
              success: function(response){
                if(response.status == "success"){
                   var statusActual=response.estatusRevisionPdf;
                   if (statusActual==0){
                      alert("Para poder validar este contrato, primero debe revisar el archivo pdf del contrato");
                   }else{
                       $("#modalFirmaElectronicaDC").modal();
                   }
                }else{
                      alert("Error al reconsultar estatus");
                }
              },error:function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText);
                      // waitingDialog.hide();
                      $("#tablaDetalleContrato").hide();
                     }
        });
    }

}
 
 function validarTexto (textoOriginal){
    var textoFinal = textoOriginal;
    var specialChars = "!@#$^&%*()+=-[]\/{}|:<>?,.";
    for (var j = 0; j < specialChars.length; j++) {
        textoFinal = textoFinal.replace(new RegExp("\\" + specialChars[j], 'gi'), '').toUpperCase();
    }
    textoFinal = textoFinal.replace(/á|ä/gi,"A");
    textoFinal = textoFinal.replace(/é|ë/gi,"E");
    textoFinal = textoFinal.replace(/í|ï/gi,"I");
    textoFinal = textoFinal.replace(/ó|ö/gi,"O");
    textoFinal = textoFinal.replace(/ú|ü/gi,"U");
    textoFinal = textoFinal.replace(/ñ/gi,"N");
    return textoFinal;
 }

 var tableDetalleCont = null;

function loadDataInTableDetCont(data) {

    if(tableDetalleCont != null) {
       tableDetalleCont.destroy();
      }
    tableDetalleCont = $('#tablaDetalleContrato').DataTable({
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
             "paginate": {
                 "first": "Primera",
                 "last": "Ultima",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "aria": {
                 "sortAscending": "Ordenación ascendente",
                 "sortDescending": "Ordenación descendente"
             }
         },
         data: data,
         destroy: true,
         "columns": [
         {   "className": "dt-body-center",
             "data": "pdfcontrato"
         },
         {   "className": "dt-body-center",
             "data": "validacionDC"
         }, 
         {   "className": "dt-body-center",
             "data": "RfcContratante"
         }, 
         {   
             "data": "NumeroContrato"
         }, 
         {   "className": "dt-body-center",
             "data": "Descripcion"
         }, 
         {   "className": "dt-body-center",
             "data": "objetoContratoV"
         }, 
         {   "className": "dt-body-center",
             "data": "MontoContrato" 
         }, 
         {   "className": "dt-body-center",
             "data": "vigencia"
         },
         {   "className": "dt-body-center",
             "data": "FechaInicioC"
         },
         {   "className": "dt-body-center",
             "data": "FechaFinalC"
         },
         {   "className": "dt-body-center",
             "data": "noGuardias"
         },
         {   "className": "dt-body-center",
             "data": "rfcCliente"
         },
         {   "className": "dt-body-center",
             "data": "razonSocial"
         },
         {   "className": "dt-body-center",
             "data": "RegistroPatronal"
         },
         {   "className": "dt-body-center",
             "data": "CallePrincipaC"
         },
         {   "className": "dt-body-center",
             "data": "NumeroExteriorC"
         },
         {   "className": "dt-body-center",
             "data": "NumeroInterirC"
         },
         {   "className": "dt-body-center",
             "data": "PrimerCalle"
         },
         {   "className": "dt-body-center",
             "data": "SegundaCalle"
         },
         {   "className": "dt-body-center",
             "data": "nombreAsentamiento"
         },
         {   "className": "dt-body-center",
             "data": "CodigoPostalC"
         },
         {   "className": "dt-body-center",
             "data": "nombreMunicipio"
         },
         {   "className": "dt-body-center",
             "data": "nombreEntidadFederativa"
         },
         {   "className": "dt-body-center",
             "data": "correoCliente"
         },
         {   "className": "dt-body-center",
             "data": "telefonoFijoCliente"
         }, ],

         processing: true,
         dom: 'Bfrtip',

          buttons: {
       buttons: ['excel']
    }
         
     });
 }

function RevisarFirmaInternaDC (){
  var NumEmpModaldc = $("#NumEmpModalFirmaDC").val();
  var constraseniaFirma = $("#constraseniaFirmaDC").val();
 
  if(NumEmpModaldc==""){
   alert("El numero de empleado no puede estar vaacio");
   return;
  }else if(constraseniaFirma==""){
     alert("Escriba la contraseña para continuar");
     return;
  }else{
    $.ajax({
      type:"POST",
      url: "ajax_getFirmaSolicitada.php",
      data: {"NumEmpModalBaja":NumEmpModaldc,"constraseniaFirma":constraseniaFirma},
      dataType: "json",
      success: function(response) {
      if (response.status == "success"){
        var RespuestaLargo = response["datos"].length;
        if(RespuestaLargo == "0"){
          alert("La contraseña ingresada es incorrecta favor de escribirla exactamente como la ingreso en el registro");
        }else{
          $("#modalFirmaElectronicaDC").modal('hide');
          var contraseniaInsertadaCifrada =response.datos["0"].ContraseniaFirma;
          validarDetalleContrato(NumEmpModaldc,contraseniaInsertadaCifrada);
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

function validarDetalleContrato (NumEmpModaldc,contraseniaInsertadaCifrada){
    var idContratoCliente=$("#idContratoClienteHidden").val();

    $.ajax({
      type: "POST",
      url: "ajax_validarDetalleContrato.php",
      data:{NumEmpModaldc,contraseniaInsertadaCifrada,idContratoCliente},
      dataType: "json", 
      success: function(response){
        if(response.status == "success"){
           Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'La validación fue realizada correctamente.'
            });
           $("#NumEmpModalFirmaDC").val("");
           $("#constraseniaFirmaDC").val("");
           consultaDetalleContrato();
            
        }else{
              console.log("error al validar");
        }
      },error:function(jqXHR, textStatus, errorThrown){
              alert(jqXHR.responseText);
             }
    });    
}

function cancelarFirmaDCo(){
    $("#NumEmpModalFirmaDC").val("");
    $("#constraseniaFirmaDC").val("");
    $("#modalFirmaElectronicaDC").modal('hide');
}
</script>