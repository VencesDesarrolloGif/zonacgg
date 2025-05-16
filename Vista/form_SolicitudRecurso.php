 <!-- <td><label class="control-label1 label" for="fechaIngreso">AAAAAAAAAA</label></td> -->
<?php
// if ($usuario["rol"] == "Comprobaciones de flujo" ) {
    $catalogoLineaNegocio                = $negocio->negocio_obtenerListaLineaNegocio();
    $fechaActual = $negocio->negocio_consultaFecha();    
    $catalogoIVASR= $negocio->negocio_obteneriva();
// }
?>

    <div align="center">
      <fieldset>
        <legend>SOLICITUD DE PAGOS</legend>
      </fieldset>
    
<div id="msgerrorbusquedaempleado"></div>
   

<div class="card border-primary mb-3" style="max-width: 100rem;border-style: double;"> <br>  

<div>
            <label class="control-label label" for="lineanegocio">Fecha</label>  
            <input id="inpFechaActual" name="inpFechaActual" type="text" readonly class="input-small" value= <?php echo $fechaActual['0']["fechaActual"]; ?>>     
       
            <label class="control-label label" for="lineanegocio">Empresa</label>
            <input id="inpEmpresa" name="inpEmpresa" type="text" class="input-large">
           

       </div><br>

<form class="form-inline"  method="post" name='form_SolicitudPagos' id="form_SolicitudPagos" enctype="multipart/form-data">
  <div align="center">
    
       

 <input id="idEmpresa" name="idEmpresa" type="hidden" class="input-slarge">

      <div >
        <label class="control-label label " for="numeroEmpleado">N° Empleado Solicitante</label> 
        <input type="text" name="txtBusquedaEmpleado" id="txtBusquedaEmpleado" class="search-query" placeholder="Buscar  (00-0000-00)" aria-describedby="basic-addon2" onkeyup="BuscaEmpleado();" ><img src="img/search.png">
      </div><br><br>


      <div>

             <div >
  <label class="control-label label" for="conceptos">Gastos varios</label>
            <input class='radio' type='radio' name='conceptos' id='conceptos' value='0' onclick="myFunction()">
             <label class="control-label label" for="conceptos">Viáticos</label>
            <input class='radio' type='radio' name='conceptos' id='conceptos' value='1' onclick="myFunction()">
            <label class="control-label label" for="conceptos">Prestamo</label>
            <input class='radio' type='radio' name='conceptos' id='conceptos' value='2' onclick="myFunction()">

</div><br>

<label class="control-label label" >Solicitante</label>
        <input class="span5"  id="nombreEmpSolicita" name="nombreEmpSolicita" type="text"  readonly style="margin-right: 12%"> 

        <input class="span5"  id="hdnidLineanegSolicitante" name="hdnidLineanegSolicitante" type="hidden"  readonly > 
        <input class="span5"  id="hdnidEntidadSolicitante" name="hdnidEntidadSolicitante" type="hidden"  readonly > 
        <input class="span5"  id="hdnCategoria" name="hdnCategoria" type="hidden"  readonly > 


              <label class="control-label label " for="numeroEmpleado">N° Empleado</label> 
              <input id="entidadEmpleadoSolicita" name="entidadEmpleadoSolicita" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>-
              <input id="ConsecutivoEmpleadoSolicita" name="ConsecutivoEmpleadoSolicita" type="text" placeholder="0000" class="input-small-mini" maxlength="4" readonly>
              <input id="CategoriaEmpleadoSolicita" name="CategoriaEmpleadoSolicita" type="text" placeholder="00" class="input-mini-mini" maxlength="2" readonly>  
      </div><br>

      <div>
      <label class="control-label label" >Benificiario</label>
        <input class="span5"  id="benificiario" name="benificiario" type="text"  readonly style="margin-right: 15%"> 



              <label class="control-label label " for="antigueda">Antiguedad:</label> 
              <input id="aniosAntiguedad" name="aniosAntiguedad" type="text"  class="input-mini-mini" maxlength="2" readonly>
              <label class="control-label label " for="anios">Años</label>  

      </div><br>

      <div>
      <label class="control-label label" >Banco</label>
              <select id="selBancoBeneficiario" name="selBancoBeneficiario" class="input-large"></select>
              <label class="control-label label " for="antigueda">N° Cuenta:</label> 
              <input id="cuentaSolicitante" name="cuentaSolicitante" type="text"  class="span3" onkeypress='return validaNumericosSolicitudRecursos(event)' readonly>
              <label class="control-label label " for="anios">N° Cuenta Clabe</label>  
              <input id="cuentaClabeSolicitante" name="cuentaClabeSolicitante" type="text"  class="span3"  onkeypress='return validaNumericosSolicitudRecursos(event)' readonly>
            <label class="control-label label" ><div id="imgEditar" style="display: none"><img src='img/edit.png' style="cursor: pointer;display: block" onclick="editarSolicitud();"></label></div>
      </div><br>

<div id="divmuestragastosvariosOviaticos" style="display: none">
  <div>
    <label class="control-label label " for="gato">Descripcion Gasto</label> 
    <input id="inpTipoGasto" name="inpTipoGasto" type="text"  class="span3">

    <label class="control-label label" for="subtotal">Sub Total</label>
    <input id="txtSubTotalSR" name="txtSubTotalSR" type="int" class="soloNumeros span3" onblur="sumatoriaSR();" style="text-align:right;">

    <label class="control-label label" for="descuento">Descuento</label></td>
    <input id="txtDescuentoSR" name="txtDescuentoSR" type="text" class="soloNumeros span3" onblur="sumatoriaSR();" style="text-align:right;">

    <td><label class="control-label label" for="Iva">Tasa De Iva </label></td>
    <td>
      <select id="txtIvaSR" name="txtIvaSR" class="soloNumeros span3" onChange="" onblur="sumatoriaSR();" style="text-align:right;">
        <option value="0">ELIJA EL IVA</option>
        <?php
          for ($i = 0; $i < count($catalogoIVASR); $i++) {
              echo "<option value='" . $catalogoIVASR[$i]["valor"] . "'>" . $catalogoIVASR[$i]["descripcionIva"] . " </option>";
          }
        ?>
      </select>
    </td>

    <label class="control-label label" for="txtIvaRetenidoSR">Iva Retenido </label></td>
    <input id="txtIvaRetenidoSR" name="txtIvaRetenidoSR" type="text" class="soloNumeros span3" onblur="sumatoriaSR();" style="text-align:right;">
    <br>
    <br>
    <label class="control-label label " for="inpTipoGastoImporte">Importe</label> 
    <input id="inpTipoGastoImporte" name="inpTipoGastoImporte" type="text" class="span3" style="text-align:right;">


    <button id="btnguardarSolicitud" name="btnguardarSolicitud" class="btn btn-primary" type="button"   onclick="agregar();"> <span class="    glyphicon glyphicon-floppy-save"></span>Agregar</button>
  </div><br>
  <div id="datostabla" style="display: none">  
    <table id='tablass' class='table table-bordered'>
      <thead>
        <th>No</th><th>Gasto</th><th>Importe</th></thead><tbody></table>
  </div>
</div><br>

      <div>
      <label class="control-label label" >Clave</label>
              <select id="selclaveBeneficiario" name="selclaveBeneficiario" class="input-large"></select>

               <label class="control-label label " for="importe">Importe $</label> 
              <input id="inpImporte" name="inpImporte" type="text"  class="span3" style="text-align:right;">
            
               <label class="control-label label" >Concepto del Pago</label>
               <textarea id="observacion" name="observacion" rows="4" cols="50"></textarea>



      </div><br>
        <div>
     
         
          <a id="descargaArchivosSoliciudPago" style="cursor: pointer;display: none" onclick="descargaSolicitud();">Descargar Solicitud.</a>
              



      </div><br>

      <div >
        <label class="control-label label" for="docuaSolicitud[]">Selecciona archivo: </label>
            <span class="btn btn-success btn-file" >Examinar
              <input type='file' class='btn-success' id='docuSolicitudPago' name='docuSolicitudPago[]' multiple="" accept=".pdf" /> 
            </span>

      </div><br>
          <div> <button id="btnguardarSolicitud" name="btnguardarSolicitud" class="btn btn-primary" type="button"  style="margin-left: 50%;" onclick="guardarSolicitud();"> <span class="    glyphicon glyphicon-floppy-save"></span>Guardar</button>
      </div>

   
  </div>   
  
  
</form>
  </div>   </div> 
<script type="text/javascript">

$(inicioSolicitudRecurso());  

function inicioSolicitudRecurso(){
  $("#inpEmpresa").val("GIF SEGURIDAD").prop("readonly", true);
  $("#idEmpresa").val(1);
  $("#selBancoBeneficiario").prop("disabled", true);
}

function sumatoriaSR() {
    
  var subtotalesSR1 = $("#txtSubTotalSR").val();

  if(subtotalesSR1 % 1 !=0){
     var subtotalesSR= subtotalesSR1;
     $("#txtSubTotalSR").val(subtotalesSR);
  }else{
        var subtotalesSR= Number.parseFloat(subtotalesSR1).toFixed(2);
        $("#txtSubTotalSR").val(subtotalesSR);
  }

  var descuentoSR1 = $("#txtDescuentoSR").val();
  if (descuentoSR1!=""){

    if(descuentoSR1 % 1 !=0){
      var descuentosSR= descuentoSR1;
      $("#txtDescuentoSR").val(descuentosSR);
    }else{
          var descuentosSR= Number.parseFloat(descuentoSR1).toFixed(2);
          $("#txtDescuentoSR").val(descuentosSR);
    }
  }else{
    var descuentosSR = $("#txtDescuentoSR").val();
  }


  var ivaretenSR1   = $("#txtIvaRetenidoSR").val();
  if (ivaretenSR1!=""){

    if(ivaretenSR1 % 1 !=0){
      var ivaretenSR= ivaretenSR1;
      $("#txtIvaRetenidoSR").val(ivaretenSR);
    }else{
          var ivaretenSR= Number.parseFloat(ivaretenSR1).toFixed(2);
          $("#txtIvaRetenidoSR").val(ivaretenSR);
    }
  }else{
        var ivaretenSR   = $("#txtIvaRetenidoSR").val();
  }


      var ivaporcentSR = $("#txtIvaSR").val();
      var subtotalesintSR = parseFloat(subtotalesSR);
      var descuentosintSR = parseFloat(descuentosSR);
      var ivaporcentintSR = parseFloat(ivaporcentSR);
      var ivaretenintSR = parseFloat(ivaretenSR);
      if (subtotalesSR == "" || descuentosSR == "" || ivaretenSR == "") {
          $("#inpTipoGastoImporte").val('');//aaaaaaaaaaaaa
      } else {
          var sumatoriaSR = (subtotalesintSR - descuentosintSR);
          var resustaldoivaSR = (sumatoriaSR * ivaporcentintSR);
          var resultadosumatoriaSR = (sumatoriaSR + resustaldoivaSR);
          var resultadototalSR = (resultadosumatoriaSR - ivaretenintSR).toFixed(2.5);
      }
      $("#inpTipoGastoImporte").val(resultadototalSR);
  }

function BuscaEmpleado(){
      var txtSearch = $("#txtBusquedaEmpleado").val ();
      var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
      if (txtSearch.length != 10)
        {return;}
      if(expreg.test(txtSearch))
      {
         numeBuscaEmpleado(txtSearch);
         $("#msgerrorbusquedaempleado").html("");
      }/*else{
       alertMsg1="<div class='alert alert-block' id='msg'>No existe número de empleado<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#msg").html(alertMsg1);
            $("#form_abonocaja")[0].reset();
            $("#descargaarchivos").hide();
      }*/
    }
    function numeBuscaEmpleado (numeroEmpleado){
        var numeroEmpleado1 = numeroEmpleado;
    $("#msgerrorbusquedaempleado").html("");

     $.ajax({   
                type: "POST",
                url: "ajax_obtenerEmpleadoPorId.php",
                data:{"numeroEmpleado":numeroEmpleado1},
                dataType: "json",
                 success: function(response) {
                    console.log(response);
                if(response.empleado[0]==null ){
                    alertMsg1="<div class='alert alert-error' id='msgerrorbusquedaempleado'>No existe número de empleado<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgerrorbusquedaempleado").html(alertMsg1);
                   
                    limpiaFormulario();
                }else{
                  var Fecha=response.empleado[0].fechaIngresoEmpleado; 
                  var fecha = new Date(Fecha)
                  var hoy = new Date()
                  var antiguedadempleado = parseInt((hoy -fecha)/365/24/60/60/1000);
                  var lineanegocio= response.empleado[0].empleadoLineaNegocioId; 
                    $("#entidadEmpleadoSolicita").val(response.empleado[0].entidadFederativaId);
                    $("#ConsecutivoEmpleadoSolicita").val(response.empleado[0].empleadoConsecutivoId);
                    $("#CategoriaEmpleadoSolicita").val(response.empleado[0].idTipoPuesto);
                    $("#nombreEmpSolicita").val(response.empleado[0].apellidoPaterno+" "+ response.empleado[0].apellidoMaterno  +" "+response.empleado[0].nombreEmpleado);
                    $("#benificiario").val(response.empleado[0].apellidoPaterno+" "+ response.empleado[0].apellidoMaterno  +" "+response.empleado[0].nombreEmpleado).prop("readonly",true); //para el benificiario En caso que sea el mismo del numero de empleado
                    $("#aniosAntiguedad").val(antiguedadempleado).prop("readonly",true);//para el benificiario En caso que sea el mismo del numero de empleado
                    $("#descargaArchivosSoliciudPago").show(); 
                    $("#imgEditar").show(); 
                    $("#hdnidLineanegSolicitante").val(response.empleado[0].empleadoLineaNegocioId);
                    $("#hdnidEntidadSolicitante").val(response.empleado[0].entidadFederativaId);
                    $("#hdnCategoria").val(response.empleado[0].descripcionCategoria);
                    var numcuentabeneficiario= response.empleado[0].numeroCta;    //para el benificiario En caso que sea el mismo del numero de empleado
                    var ctaclabebeneficiario= response.empleado[0].numeroCtaClabe;    //para el benificiario En caso que sea el mismo del numero de empleado
                    traebancoporctaclabe(ctaclabebeneficiario,numcuentabeneficiario,lineanegocio);
                    //consultabancoporctaclave(cuentaclabe,lineanegocio); 



                  }              
                  },
                //si ha ocurrido un error
                error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText); 
                }
            });
    }


function traebancoporctaclabe(ctaclabebeneficiario,numcuentabeneficiario,lineanegocio){
 $.ajax({
      type: "POST",
          url: "ajax_ObtenerBancoSolicitanteByCtaClabe.php",
          data:{"accion":0,"ctaclabebeneficiario":ctaclabebeneficiario,"lineanegocio":lineanegocio},
          dataType: "json",       
          //una vez finalizado correctamente
          success: function(response) {
          //console.log(response);
            var datos = response.datos;
            var listaClaves=response.datos.listaclaves;
            $('#selBancoBeneficiario').empty().append('<option value="'+datos.idbanco+'"selected="selected">'+datos.nombrebanco+'</option>').prop("disabled",true);
            $('#cuentaSolicitante').val(numcuentabeneficiario).prop("readonly",true);
            $('#cuentaClabeSolicitante').val(ctaclabebeneficiario).prop("readonly",true);
            $('#selclaveBeneficiario').empty().append('<option value="0" selected="selected">CLAVE</option>');
            $.each(listaClaves, function(i) {
              $('#selclaveBeneficiario').append('<option value="'+listaClaves[i].idClasificacion+'">' + listaClaves[i].descripcionClasificacion+ '</option>');
            }); 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
          }
          
   }); 
}

function limpiaFormulario(){
$("#txtBusquedaEmpleado").val("");
$("#descargaArchivosSoliciudPago").hide();
$("#imgEditar").hide();
$("#nombreEmpSolicita").val("");
$("#entidadEmpleadoSolicita").val("");
$("#ConsecutivoEmpleadoSolicita").val("");
$("#CategoriaEmpleadoSolicita").val("");
$("#benificiario").val("").prop("readonly",true);
$("#aniosAntiguedad").val("").prop("readonly",true);
$("#selBancoBeneficiario").empty().prop("disabled",true);
$("#cuentaSolicitante").val("").prop("readonly",true);
$("#cuentaClabeSolicitante").val("").prop("readonly",true);
$("#selclaveBeneficiario").empty();
$("#inpImporte").val("");
$("#observacion").val("");
$("#docuaSolicitud").val("");
$("#docuSolicitudPago").val("");
$("#divmuestragastosvariosOviaticos").hide();
$("#conceptos").prop('checked', false); 

$("#txtSubTotalSR").val(0);
$("#txtDescuentoSR").val(0);
$("#txtIvaSR").val(0);
$("#txtIvaRetenidoSR").val(0);
resettablagastoimporte();




}

function resettablagastoimporte(){
var b=$("#tablass tr").length;
if(b!=1){
for(var i=b;i>1;i--){
document.getElementById("tablass").deleteRow(1);
}
}


$("#inpTipoGasto").val("");
$("#inpTipoGastoImporte").val("");
$("#datostabla").hide();

}

$("#inpTipoGastoImporte").blur(function(){
  var importe1=$("#inpTipoGastoImporte").val();
  if(importe1 % 1 !=0){
     var importe= importe1;
     $("#inpTipoGastoImporte").val(importe);
  }else{
        var importe= Number.parseFloat(importe1).toFixed(2);
        $("#inpTipoGastoImporte").val(importe);
  }
});

function editarSolicitud(){
$("#benificiario")          .prop("readonly",false);
$("#aniosAntiguedad")       .prop("readonly",false);
$("#selBancoBeneficiario")  .prop("disabled",false);
$("#cuentaSolicitante")     .prop("readonly",false);
$("#cuentaClabeSolicitante").prop("readonly",false);
$.ajax({
      type: "POST",
          url: "ajax_ObtenerBancoSolicitanteByCtaClabe.php",
          data:{"accion":1,"ctaclabebeneficiario":0,"lineanegocio":0},
          dataType: "json",       
          //una vez finalizado correctamente
          success: function(response) {
          var listabancos=response.datos;
           //console.log(listabancos);
            $('#benificiario').val("");
             $('#aniosAntiguedad').val(0);
            $('#cuentaSolicitante').val("");
            $('#cuentaClabeSolicitante').val("");
            $('#selBancoBeneficiario').empty().append('<option value="-0" selected="selected">BANCO</option>');
            $.each(listabancos, function(i) {
              $('#selBancoBeneficiario').append('<option value="'+listabancos[i].idCuentaBanco+'">' + listabancos[i].nombreBanco+ '</option>');
            }); 
          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
          }
          
   }); 

}
function descargaSolicitud(){
  if(validaformulario()){
    $("#msgerrorbusquedaempleado").html("");
var nombresolicitante=$("#nombreEmpSolicita").val();
var numeroEmpleado=($("#entidadEmpleadoSolicita").val()+"-"+$("#ConsecutivoEmpleadoSolicita").val()+"-"+$("#CategoriaEmpleadoSolicita").val());
var benificiario=$("#benificiario").val();
var idbanco=$("#selBancoBeneficiario").val();
var banco=$('select[id="selBancoBeneficiario"] option:selected').text();
var cuentabenificiario=$("#cuentaSolicitante").val();
var cuentaclabebeneficiario=$("#cuentaClabeSolicitante").val();
var idclave=$("#selclaveBeneficiario").val();
var descripcionclave=$('select[id="selclaveBeneficiario"] option:selected').text();
var importe=$("#inpImporte").val();
var observacion=$("#observacion").val();




        var descripciones = Array();
        var importes=Array();
        //var sobreexcedente = Array();
        var b = $("#tablass tr").length;
        var c = $("#tablass tr:last td").length;
        //alert(b);
        for (var i = 0; i < b - 1; i++) {
            descripciones[i] = $("#inpparagastosconcepto" + i).val();
            importes[i] = $("#inpimportetbl" + i).val();
            

          }


var descripcionEmpresa=$("#inpEmpresa").val();
var descripcionbanco=$("#selBancoBeneficiario option:selected").text();   
var data=$("#form_SolicitudPagos").serialize();
      data += "&descripciones=" + descripciones;
      data += "&importes=" + importes;
       data += "&descripcionEmpresa=" + descripcionEmpresa;
       data += "&descripcionbanco=" + descripcionbanco;

window.open("generadorSolicitudPago.php?"+data, 'SOLICITUD DE PAGOS', 'fullscreen=no'); 
  }
}










function guardarSolicitud(){

var docuSolicitudPago=$("#docuSolicitudPago").val();
  if(validaformulario()){

    if(docuSolicitudPago==="" /*|| !/([0-9]{5,60})?$/.test(benificiario)*/){
 
    pintaerrordownloadarchivo("Selecciona un archivo .PDF");
  }else{
 var idClaveClasificacion=$("#selclaveBeneficiario").val();
  var idBancoBeneficiario=$("#selBancoBeneficiario").val();
  var formData = new FormData($("#form_SolicitudPagos")[0]);
  formData.append('idClaveClasificacion', idClaveClasificacion);
  formData.append('idBancoBeneficiario', idBancoBeneficiario);
      //for (var value of formData.values()) {}
    $.ajax({
        type: "POST",
        url: "ajax_registroSolicitudPagoUploadArchivo.php",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
          var mensaje =response.message;
            if(response.status=="success"){
 alertMsg1="<div class='alert alert-success' id='msgerrorbusquedaempleado'>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbusquedaempleado").html(alertMsg1);
    $(document).scrollTop(0);
    limpiaFormulario();

            }
        },error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.responseText);
          }
    });
  }
  }
}
function pintaerrordownloadarchivo(mensaje){
 alertMsg1="<div class='alert alert-error' id='msgerrorbusquedaempleado'>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
    $("#msgerrorbusquedaempleado").html(alertMsg1);
    $(document).scrollTop(0);

}

function validaformulario(){
var validado = true;
var nombresolicitante=$("#nombreEmpSolicita").val();
var numeroEmpleado=($("#entidadEmpleadoSolicita").val()+"-"+$("#ConsecutivoEmpleadoSolicita").val()+"-"+$("#CategoriaEmpleadoSolicita").val());
var benificiario=$("#benificiario").val();
var idbanco=$("#selBancoBeneficiario").val();
var banco=$('select[id="selBancoBeneficiario"] option:selected').text();
var cuentabenificiario=$("#cuentaSolicitante").val();
var cuentaclabebeneficiario=$("#cuentaClabeSolicitante").val();
var idclave=$("#selclaveBeneficiario").val();
var descripcionclave=$('select[id="selclaveBeneficiario"] option:selected').text();
var importe=$("#inpImporte").val();
var observacion=$("#observacion").val();

 var categorias = new Array();
 $("input[name='conceptos']:checked").each(function() {categorias.push($(this).val());});

var largotabla = $("#tablass tr").length;



 if(numeroEmpleado=="--"){
validado=false;
    pintaerrordownloadarchivo("Ingresa Número de empleado solicitante");
}else if(categorias.length==0){
validado=false;
 pintaerrordownloadarchivo("Seleccione un concepto(Gastos varios,Viáticos,Prestamo)");
}
  else if(benificiario==="" /*|| !/([0-9]{5,60})?$/.test(benificiario)*/){
    validado=false;
    pintaerrordownloadarchivo("Ingresa un Beneficiario");
  }else if(idbanco==="-0"){
    validado=false;
    pintaerrordownloadarchivo("Seleccione Banco");
  }else if(cuentabenificiario==""|| !/^([0-9]{0,20})?$/.test(cuentabenificiario)){
    validado=false;
    pintaerrordownloadarchivo("Verifique número de cuenta");
  }else if (cuentaclabebeneficiario=="" || !/^([0-9]{0,20})?$/.test(cuentaclabebeneficiario) ){
    validado=false;
     pintaerrordownloadarchivo("Verifique número de cuenta clabe");
  }else if((categorias==0 || categorias==1) && largotabla==1){
    validado=false;
     pintaerrordownloadarchivo("Agregue un Gasto y un Importe");

  }else if(idclave=="0"){
    validado=false;
    pintaerrordownloadarchivo("Seleccione clave");
  }else if(importe=="" || !/^[0-9]+(\.[0-9]{0,2})?$/.test(importe)){
    validado=false;
    pintaerrordownloadarchivo("Verifique importe $");
  }else if(observacion==""){
validado=false;
    pintaerrordownloadarchivo("Ingresa Concepto del Pago");

  }










  //alert(validado);
return validado;
}


function myFunction(){
 // var concepto=$("#conceptos").val();
  //alert(concepto);
  var categorias = new Array();
 
        $("input[name='conceptos']:checked").each(function() {
            categorias.push($(this).val());
        });
 
       if(categorias==0 || categorias==1){
          $("#divmuestragastosvariosOviaticos").show();
          $("#inpImporte").prop("readonly",true);
          $("#selclaveBeneficiario").prop("disabled",false);
       }else{
             $("#divmuestragastosvariosOviaticos").hide();
             $("#inpImporte").prop("readonly",false).val("");
             resettablagastoimporte();
             // $("#selclaveBeneficiario").hide();
             $("#selclaveBeneficiario").prop("disabled",true);

   //setear la tabla de nuevo

       }


}




function agregar(){


                  
  var gasto=$("#inpTipoGasto").val();
  var importe=$("#inpTipoGastoImporte").val();                     
   // $("#errorMsgtblsalarios").html("");
    //$("#btneditar").prop("disabled", true);



    if(gasto=="" || !/^([A-Za-zÁÉÍÓÚñáéíóúÑ\s])+$/.test(gasto)){

pintaerrordownloadarchivo("Verifique Gasto");
    }else if(importe=="" || !/^[0-9]+(\.[0-9]{0,2})?$/.test(importe)){
       pintaerrordownloadarchivo("Verifique Importe");

    }else{
        $("#msgerrorbusquedaempleado").html("");
        $("#datostabla").show();
    var b = $("#tablass tr").length;
    var table = document.getElementById("tablass");
    var row = table.insertRow(b);
   
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
   var sumaimporte=0;
    for (var i = 0; i < b; i++) {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input id='inpparagastosconcepto" + i + "' type='text'   value='" + gasto + "'   readonly >";
        cell2.innerHTML = "<input id='inpimportetbl" + i + "' type='text'  value='" + importe + "'  readonly style='text-align:right;'>";

      
    }
$("#inpTipoGasto").val("");
$("#inpTipoGastoImporte").val("");
$("#txtSubTotalSR").val(0);
$("#txtDescuentoSR").val(0);
$("#txtIvaSR").val(0);
$("#txtIvaRetenidoSR").val(0);   
    sumatoriaimporte();
}

}

function sumatoriaimporte(){
var b = $("#tablass tr").length;
var suma1=0.0;
 for (var i = 0; i < (b-1); i++) {
var a=$("#inpimportetbl"+i).val();
var valor=parseFloat(a);
suma1=(valor+suma1);

  if(suma1 % 1 !=0){
     var suma= suma1;
  }else{
        var suma= Number.parseFloat(suma1).toFixed(2);
  }
 }
 $("#inpImporte").val(suma);
}

$('#selBancoBeneficiario').change(function(){
    $("#cuentaSolicitante").val("");
    $("#cuentaClabeSolicitante").val("").attr("maxlength","18");
        var banco1=$("#selBancoBeneficiario").val();
        if(banco1=='030'){
            $("#cuentaSolicitante").attr("maxlength","12");
        }else if(banco1=='012' || banco1=='021'){
            $("#cuentaSolicitante").attr("maxlength","10");
        }else if(banco1=='014'){
            $("#cuentaSolicitante").attr("maxlength","11");
        }else{
            $("#cuentaSolicitante").attr("maxlength","14");
        }
  });

  function validaNumericosSolicitudRecursos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;        
}

  </script>










