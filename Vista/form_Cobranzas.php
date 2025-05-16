<?php

if ($usuario["rol"] == "Cobranza" ) {

    $catalogoClientes = $negocio->negocio_obtenerListaClientesActivos();
    $catalogoEmpresas          = $negocio->negocio_ListaEmpresas();
    $catalogoEntidadesFederativas        = $negocio->negocio_obtenerListaEntidadesFeferativas();
    $catalogoLineaNegocio                = $negocio->negocio_obtenerListaLineaNegocio();
    $catalogoBancos            = $negocio->negocio_ListaBancos();
     $catalogoTipoTransacciones = $negocio->negocio_ListaTipoTransacciones();
    $catalogoIVA        = $negocio->negocio_obteneriva();
  $fechaActual= $negocio -> negocio_consultaFecha();
   
}
?>
<b><h1>COBRANZA</h1></b>
<br>
<div id='Mensaje' >

</div>
<form class="form-inline"  method="post" id="form_Cobranzas" action="ficheroExcelMovimientos.php" target="_blank" enctype='multipart/form-data'>

<!-----------------------comienza fila 1 y el formulario --------------------------------------------------->  
  <div align="center" ><br>
    <div  style="max-width: 100rem; border-style: groove; border-color: rgb(51,153,255); "><br>
      <div class= "row">
    
        <label class="control-label label  " for="fechaIngreso">Fecha Movimiento</label>
        <input class="span3 input-medium"  id="fechaMovimiento" name="fechaMovimiento" type="date"  value= <?php echo $fechaActual['0']["fechaActual"]; ?>>
   
        <label class="control-label label " for="SelecCliente" id="lblCLienteCaja1" >Nombre Cliente</label>
        <select  class="span3"  id="SelecCliente" name="SelecCliente" >
          <option value="0">ELIJA EL CLIENTE</option>
          <?php
            for ($i = 0; $i < count($catalogoClientes); $i++) {
              echo "<option value='" . $catalogoClientes[$i]["idCliente"] . "'>" . $catalogoClientes[$i]["razonSocial"] . " </option>";
            }
          ?>   
        </select>

        <label class="control-label label  " for="SelectPeriodoCo">Periodo De Cobro</label>
        <input class="span3 input-medium" id="SelectPeriodoCo" name="SelectPeriodoCo" type="date" value= <?php echo $fechaActual['0']["fechaActual"]; ?> >
        
      </div>
<!----------------------------termina fila 1 y comienza fila 2 -----------------------------------><br><br>
      <div class= "row">
      
        <label class="control-label label " for="empresa">Empresa</label>
        <select class="span3"  id="empresa" name="empresa"  >
          <option value="0">ELIJA LA EMPRESA</option>
          <?php
            for ($i = 0; $i < 1;/*count($catalogoEmpresas);deshabilitar cuando se habran mas empresas*/ $i++) {
              echo "<option value='" . $catalogoEmpresas[$i]["idEmpresa"] . "'>" . $catalogoEmpresas[$i]["nombreEmpresa"] . " </option>";
            }
          ?>
        </select>

        <label class="control-label label" for="tratipoTransaccionnsaccion">Tipo Transaccion</label>
        <select class="span3" id="tipoTransaccion" name="tipoTransaccion" >
          <option value="0">ELIJA EL TIPO DE TRANSACCION</option>
          <?php
            for ($i = 0; $i < count($catalogoTipoTransacciones); $i++){
              echo "<option value='" . $catalogoTipoTransacciones[$i]["idTipoTransaccion"] . "'>" . $catalogoTipoTransacciones[$i]["descripcionTransaccion"] . " </option>";
            }
          ?>
        </select>

        <label class="control-label label" for="renumeroReferenciaferencia"># Referencia </label>
        <input class="span3" id="numeroReferencia" name="numeroReferencia" type="text" >

      </div>
<!----------------------------termina fila 2 y comienza fila 3 -----------------------------------><br><br>
      <div calss="row">

        <label class="control-label label" for="selectTipoDeBanco">Banco</label>
        <select class="span3" id="selectTipoDeBanco" name="selectTipoDeBanco">
          <option value="0">ELIJA EL BANCO</option>
          <?php
            for ($i = 0; $i < count($catalogoBancos); $i++){
              echo "<option value='" . $catalogoBancos[$i]["idBanco"] . "'>" . $catalogoBancos[$i]["nombreBanco"] . " </option>";
            }
          ?>
        </select>

        <label class="control-label label" for="selectNumCuenta">Numero De Cuenta</label>
        <select class="span3" id="selectNumCuenta" name="selectNumCuenta" >
          <option value="0">ELIJA EL # DE CUENTA</option></select>  

      </div>
<!----------------------------termina fila 3 y comienza fila 4 -----------------------------------><br><br>
      <div  style="max-width: 65rem; border-style: groove; border-color: rgb(51,153,255); "><br>
      <div calss="row">

        <label class="control-label label" for="ImpFactura">#Factura</label>
        <input class="span3"  id="ImpFactura" name="ImpFactura" type="text" >

        <label class="control-label label" for="ejercicio">ejercicio Factura</label>
        <select class="span3" id="ejercicio" name="ejercicio" ></select>

        <label class="control-label label" for="SelectPeriodoFac">Periodo Factura</label>
        <select class="span3" id="SelectPeriodoFac" name="SelectPeriodoFac" >
        <option value="0">PERIODO</option></select>     
    
      </div>
<!----------------------------termina fila 4 y comienza fila 5 -----------------------------------><br><br>
      <div calss="row">

        <label class="control-label label" for="selectLineaNegocio">Linea Negocio</label>
        <select  class="span3" id="selectLineaNegocio" name="selectLineaNegocio">
          <option value="0">ELIJA LA LINEA DE NEGOCIO</option>
          <?php
            for ($i = 0; $i < count($catalogoLineaNegocio); $i++){
              echo "<option value='" . $catalogoLineaNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] . " </option>";
            }
          ?>
        </select>

        <label class="control-label label" for="selectEntidades">Entidad</label>
        <select class="span3 " id="selectEntidades" name="selectEntidades" >
          <option value="0">ELIJA LA ENTIDAD</option>
            <?php
              for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++){
                echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
              }
            ?>
        </select>

        <label class="control-label label" for="txtSubTotal">Sub Total</label>
        <input class="span3" id="txtSubTotal" name="txtSubTotal" type="text" onblur="sumatoriaCobra()" >
        
      </div>
<!----------------------------termina fila 5 y comienza fila 6 -----------------------------------><br><br>
      <div calss="row">

        <label class="control-label label" for="txtDescuento">Descuento</label>
        <input class="span3" id="txtDescuento" name="txtDescuento" type="text" onblur="sumatoriaCobra()" >

        <label class="control-label label" for="txtIva">Tasa De Iva </label>
        <select class="span3" id="txtIva" name="txtIva" onblur="sumatoriaCobra()">
          <option value="0">ELIJA EL IVA</option>
          <?php
            for ($i = 0; $i < count($catalogoIVA); $i++){
              echo "<option value='" . $catalogoIVA[$i]["valor"] . "'>" . $catalogoIVA[$i]["descripcionIva"] . " </option>";
            }
          ?>
        </select>

        <label class="control-label label" for="IvaCalculado">Iva Calculado: </label>
        <input class="span3" id="IvaCalculado" name="IvaCalculado" type="text"  readonly="readonly" >

      </div>
     <div calss="row"> <br><br>

<div style="margin-right: 35%"> 

      <label class="control-label label" for="Total">Total </label>
      <input class="span3" id="Total" name="Total" type="text"  readonly="readonly" >
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      <button id="Agregar" name="Agregar" class="btn btn-primary " type="button"> 
      <span class="glyphicon glyphicon-floppy-save"></span>Agregar Entidad</button>   

  

  </div>
    </div>
    <br> </div>
<!----------------------------termina fila 6 y comienza tabla y botones -----------------------------------><br>

    <div id="tablaCreada" name="tablaCreada" >
    <table id='tabla' class='table table-bordered'><thead><th>N°</th><th>#FACTURA</th><th>EJERCICIO</th><th>PERIODO FACTURA</th><th>LINEA NEGOCIO</th><th>ENTIDAD</th><th>SUB TOTAL</th><th>DESCUENTO</th><th>TASA DE IVA</th><th>IVA CALCULADO</th><th>TOTAL</th></thead><tbody></tbody></table>
      
  </div>
 
   <div id="totaldetotales" style="margin-right: -87%; display: none">

    <label class="control-label label" for="Totales">NETO </label>
    <input class="span2" id="Totales" name="Totales" type="text"  readonly="readonly" >
    </div><br>

   <input type='file' class='btn-success ' id='DocPdfCobranza' name='DocPdfCobranza[]' accept=".pdf" /><br><br>


  <div>                
    <button id="guardar" name="guardar" class="btn btn-primary " type="button" ;> 
    <span class="glyphicon glyphicon-floppy-save "></span>Guardar</button>



  </div>


<!----------------------------------termina tabla y botones -----------------------------------------------><br><br>

 </div>
</div>
</form>
<!-----------------------------termina el form y ciere de div----------------------------------------->
<script type="text/javascript">
$(inicioCobranzas());  

function inicioCobranzas(){
  insertarsaldodiarioCobranza();
  cargaselPeriodo();
  $("#ImpFactura").attr('maxlength','10');
  ejercicio();
}

$("#guardar").click(function () 
{
  $("#Mensaje").removeClass('alert alert-error').html('');
   var fechaMovimiento=$("#fechaMovimiento").val();
   var SelecCliente=$("#SelecCliente").val();
   var empresa=$("#empresa").val();
   var tipoTransaccion=$("#tipoTransaccion").val();
   var numeroReferencia1=$("#numeroReferencia").val();
   var selectTipoDeBanco=$("#selectTipoDeBanco").val();
   var selectNumCuenta=$("#selectNumCuenta").val();
   var SelectPeriodoCo=$("#SelectPeriodoCo").val();
   var DocPdfCobranza=$("#DocPdfCobranza").val();
   var tabla = $("#tabla tr").length;

  if (fechaMovimiento=="") {
  cargaerrores('Seleccione La Fecha');
  }
  else if (SelecCliente==="0") {
  cargaerrores('Seleccione El Nombre Del Cliente');
  } 
  else if (SelectPeriodoCo=="") {
  cargaerrores('Seleccione El Periodo De Cobro'); 
  }
  else if (empresa==="0") {
  cargaerrores('Seleccione La Empresa');
  }
  else if (tipoTransaccion==="0") {
  cargaerrores('Ingrese El Tipo De Transaccion');
  }
  else if (numeroReferencia1=="" || !/^([0-9])*$/.test(numeroReferencia1)) {
  cargaerrores('Ingrese Un Numero De Referencia Correcto');
  }
  else if (selectTipoDeBanco==="0") {
  cargaerrores('Seleccione Un Banco');
  }
  else if (selectNumCuenta==="0") {
  cargaerrores('Seleccione Una Cuenta');
  }
  else if (tabla===1) {
  cargaerrores('Agregue Un Registro');
  }
  else if (DocPdfCobranza==="") {
  cargaerrores('Seleccione Archivo');
  }
  else
  {

    var infactura         = Array();
    var inpidperiodofac   = Array();
    var inpidlineanegocio = Array();
    var inentidad         = Array();
    var insubtotal        = Array();
    var indescuento       = Array();
    var intasaiva         = Array();
    var intotaliva        = Array();
    var intotal           = Array();
    var inpidejerciciofac = Array();
    
   for (var i=0; i<tabla-1;i++) 
    {
      infactura[i]        = $("#infactura" + i).val();
      inpidperiodofac[i]  = $("#inpidperiodofac" + i).val();
      inpidlineanegocio[i]= $("#inpidlineanegocio" + i).val();
      inentidad[i]        = $("#inentidad" + i).val();
      insubtotal[i]       = $("#insubtotal" + i).val();
      indescuento[i]      = $("#indescuento" + i).val();
      intasaiva[i]        = $("#intasaiva" + i).val();
      intotaliva[i]       = $("#intotaliva" + i).val();
      intotal[i]          = $("#intotal" + i).val();
      inpidejerciciofac[i]  = $("#inpidejerciciofac" + i).val();
    }


    $.ajax
    ({
      type: "POST",
      url: "ajax_registroMovimientoCobranza.php",
      data: 
      {
        'infactura': infactura,
        'inpidperiodofac': inpidperiodofac,
        'inpidlineanegocio': inpidlineanegocio,
        'inentidad': inentidad,
        'insubtotal': insubtotal,
        'indescuento': indescuento,
        'intasaiva': intasaiva,
        'intotaliva': intotaliva,
        'intotal': intotal,
        'fechaMovimiento':fechaMovimiento,
        'SelecCliente':SelecCliente,
        'empresa':empresa,
        'tipoTransaccion':tipoTransaccion,
        'numeroReferencia1':numeroReferencia1,
        'selectTipoDeBanco':selectTipoDeBanco,
        'selectNumCuenta':selectNumCuenta,
        'SelectPeriodoCo':SelectPeriodoCo,
        'DocPdfCobranza':DocPdfCobranza,
        'inpidejerciciofac':inpidejerciciofac
      },

      dataType: "json",
       success: function(response) {
              
              var estatusCobranza=response.status;
              var registroCobranza=response.Registromov;
              var mensajeCobranza=response.message;
              if(estatusCobranza!="error"){
              enviarPdf1(registroCobranza);
              insertarenlibrosaldos(selectTipoDeBanco,selectNumCuenta);
              }
              showMessage1(mensajeCobranza, response.status);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
      });
 }
});
  $("#selectTipoDeBanco").change(function()
  {
    var valorselectorbanco  =  $("#selectTipoDeBanco").val();
    if(valorselectorbanco!=0)
    {
      $.ajax({
        type: "POST",
        url: "ajax_listaCuentasBancarias.php",
        data:{"valorselectorbanco":valorselectorbanco},
        dataType: "json",
        success: function(response) {
         // console.log(response);
          var datos = response.datos;
          $('#selectNumCuenta').empty().append('<option value="0" selected="selected">ELIJA EL # DE CUENTA</option>');
          $.each(datos, function(i) {
            $('#selectNumCuenta').append('<option value="' + response.datos[i].idCuentaBancaria+ '">' + response.datos[i].numCuenta + '</option>');
          });     
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
      });  
   }
   else{$('#selectNumCuenta').empty();}
   });

  function cargaselPeriodo() {
    var meses = ["ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
    $('#SelectPeriodoFac').empty().append('<option value="0" selected="selected">ELIJA EL PERIODO</option>');    
    var a = 1;
    for (var i in meses) {
      $('#SelectPeriodoFac').append('<option value="' + a + '">' + meses[i] + '</option>');
      a++;
    }
  }
$("#Agregar").click(function () {
$("#Mensaje").removeClass('alert alert-error').html('');   

var entidad= $('select[name="selectEntidades"] option:selected').text();   //$("#selectEntidades").val(); // cambiar por el texto
var identidad=$("#selectEntidades").val();

var desperiodofactura= $('select[name="SelectPeriodoFac"] option:selected').text();
var idperiodofact=$("#SelectPeriodoFac").val();

var desejerciciofactura= $('select[name="ejercicio"] option:selected').text();
var idejerciciofact=$("#ejercicio").val();

var desclineanegocio= $('select[name="selectLineaNegocio"] option:selected').text();
var idlineanegocio=$("#selectLineaNegocio").val();

var ImpFactura1=$("#ImpFactura").val();

var subtotal1=$("#txtSubTotal").val();
var subtotal2=(subtotal1*1);
var subtotal=(subtotal2).toFixed(2.5);  

var descuento1=$("#txtDescuento").val();
var descuento2=(descuento1*1);
var descuento=(descuento2).toFixed(2.5);  

var iva=$("#txtIva").val();
var ivacalculado=$("#IvaCalculado").val();
var total=$("#Total").val();


if (ImpFactura1=="" || !/^([A-Z-a-z-0-9\-])*$/.test(ImpFactura1)) {
cargaerrores('Ingrese Un Numero De Factura Correcto');
}
else if (idejerciciofact==="0") {
cargaerrores('Seleccione Ejercicio De Factura');
}
else if (idperiodofact==="0") {
cargaerrores('Seleccione El Periodo De Factura');
}
else if (idlineanegocio==="0") {
cargaerrores('Seleccione Una Linea De Negocio');
}
else if (identidad=="0") {
cargaerrores('Seleccione La Entidad'); 
}
else if(subtotal=="" || !/^(([0-9]+)?(.[0-9]+)?)$/.test(subtotal)){
cargaerrores('Ingrese El Sub Total Correcto');
}
else if(descuento=="" || !/^(([0-9]+)?(.[0-9]+)?)$/.test(descuento)){
cargaerrores('Ingresa El Descuento Correcto');
}
else if(iva=="0"){
cargaerrores('Seleccione La Taza De Iva');
}

else{
   
    var b = $("#tabla tr").length;
    var table = document.getElementById("tabla");
    var row = table.insertRow(b);
    var contfila = row.insertCell(0);
    var cell1 = row.insertCell(1);
    var cell2 = row.insertCell(2);
    var cell3 = row.insertCell(3);
    var cell4 = row.insertCell(4);
    var cell5 = row.insertCell(5);
    var cell6 = row.insertCell(6);
    var cell7 = row.insertCell(7);
    var cell8 = row.insertCell(8);
    var cell9 = row.insertCell(9);
    var cell10 = row.insertCell(10);

    for (var i = 0; i < b; i++) {
     

        contfila.innerHTML = " <td > " + (i + 1) + " </td>";

        cell1.innerHTML = "<input class='span2' id='infactura" + i + "' type='text' readonly>";
         cell2.innerHTML = "<input class='span2' id='inpejerciciofac" + i + "' type='text' readonly> <input class='span2' id='inpidejerciciofac" + i + "' type='hidden' readonly>   ";
         cell3.innerHTML = "<input class='span2' id='inpdescperiodofac" + i + "' type='text' readonly><input class='span2' id='inpidperiodofac" + i + "' type='hidden' readonly>";
         cell4.innerHTML = "<input class='span2' id='inpdesclineanegocio" + i + "' type='text' readonly><input class='span2' id='inpidlineanegocio" + i + "' type='hidden' readonly>";
        cell5.innerHTML = "<input class='span2' id='descentidad" + i + "' type='text' readonly> <input class='span2' id='inentidad" + i + "' type='hidden' readonly>   ";
        cell6.innerHTML = "<input class='span2' id='insubtotal" + i + "' type='text' readonly>";
        cell7.innerHTML = "<input class='span2' id='indescuento" + i + "' type='text' readonly>";
        cell8.innerHTML = "<input class='span2' id='intasaiva" + i + "' type='text'readonly>";
        cell9.innerHTML = "<input class='span2' id='intotaliva" + i + "' type='text'readonly>";
        cell10.innerHTML = "<input class='span2' id='intotal" + i + "' type='text'readonly>";


       

    }

    

$("#totaldetotales").show();
$("#descentidad"+(b-1)).val(entidad);
$("#inentidad"+(b-1)).val(identidad);
$("#infactura"+(b-1)).val(ImpFactura1);
$("#inpdescperiodofac"+(b-1)).val(desperiodofactura);
$("#inpidperiodofac"+(b-1)).val(idperiodofact);
$("#inpdesclineanegocio"+(b-1)).val(desclineanegocio);
$("#inpidlineanegocio"+(b-1)).val(idlineanegocio);
$("#insubtotal"+(b-1)).val(subtotal);
$("#indescuento"+(b-1)).val(descuento);
$("#intasaiva"+(b-1)).val(iva);
$("#intotaliva"+(b-1)).val(ivacalculado);
$("#intotal"+(b-1)).val(total);
$("#inpejerciciofac"+(b-1)).val(desejerciciofactura);
$("#inpidejerciciofac"+(b-1)).val(idejerciciofact);


var suma=0;
 for (var i = 0; i < b; i++) {
       var a=$("#intotal"+i).val();
       var a1=parseFloat(a);
       var suma=(a1+=suma);
    }

$("#Totales").val(suma);


$("#ImpFactura").val("");
$("#SelectPeriodoFac").val("0");
$("#selectLineaNegocio").val("0");
$("#selectEntidades").val("0");
$("#txtSubTotal").val("");
$("#txtDescuento").val("");
$("#txtIva").val("0");
$("#IvaCalculado").val("");
$("#Total").val("");
$("#ejercicio").val("0");

  }
});

function sumatoriaCobra()
{
  var subtotales=$("#txtSubTotal").val();
  var descuentos=$("#txtDescuento").val();
  var ivaporcent=$("#txtIva").val();
  var subtotalesint=parseFloat(subtotales);
  var descuentosint=parseFloat(descuentos);
  var ivaporcentint=parseFloat(ivaporcent);
  if(subtotales=="" || descuentos=="" || ivaporcent==0 ){
   $("#Total").val('');
   $("#IvaCalculado").val('');
  }
  else{
    var sumatoria=(subtotalesint-descuentosint);
    var resustaldoiva1= (sumatoria*ivaporcentint);
    var resustaldoiva= (resustaldoiva1).toFixed(2.5); 
    var resultadosumatoria= (sumatoria+resustaldoiva1).toFixed(2.5);
    
  }
  $("#Total").val(resultadosumatoria);
    $("#IvaCalculado").val(resustaldoiva);
}

function cargaerrores(mensaje){
  alertMsj1="<div class='alert alert-error' id='Mensaje'>"+mensaje+"<data-dismiss='alert'>";
  $("#Mensaje").html(alertMsj1);
  $(document).scrollTop(0);
}
  function showMessage1(mensaje, status)
{
    $("#msg").show ();
    if (status=="success") {
        alertMsg1="<div class='alert alert-success' id='msg'>"+mensaje+" <data-dismiss='alert'>";

        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msg').delay(4000).fadeOut('slow');

        $("#fechaMovimiento").val("<?php echo date("Y-m-d"); ?>");
        $("#SelecCliente").val("0");
        $("#SelectPeriodoCo").val("<?php echo date("Y-m-d"); ?>");
        $("#empresa").val("0");
        $("#tipoTransaccion").val("0");
        $("#numeroReferencia").val("");
        $("#selectTipoDeBanco").val("0");
        $("#selectNumCuenta").val("0");
        $("#DocPdfCobranza").val("");
        $("#totaldetotales").hide();
        var b = $("#tabla tr").length;
        for(var i=b; i>1; i-- )
        {
          alert(i);
          var table = document.getElementById("tabla").deleteRow(1);  
          
        }


    } else if (status=="error")
    {
        alertMsg1="<div class='alert alert-error' id='msg'><strong>Error en el registro de movimiento:</strong>"+mensaje+" <<data-dismiss='alert'>";

        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msg').delay(4000).fadeOut('slow');
   }

}


function enviarPdf1(registro){  
     var fechamov=$("#fechaMovimiento").val();
     var SelecClientePDF=$("#SelecCliente").val();
     var NombreUsuario= 1;
     var formData = new FormData($("#form_Cobranzas")[0]);   


        formData.append('fechamov', fechamov);
        formData.append('NombreUsuario', NombreUsuario);
        formData.append('SelecClientePDF', SelecClientePDF);
        formData.append('idRegistroMovimiento', registro);
        //hacemos la petición ajax  
        for (var value of formData.values()) {
             // console.log(value); 
        }       
        $.ajax({
            type: "POST",
            url: "upload_ArchivoAbonoCob.php",
            data:formData,
            dataType: "json",

            cache: false,
            contentType: false,
            processData: false,        
            //una vez finalizado correctamente
             success: function(response) {
            // console.log(response);
              
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
          
        });
  }  


function ejercicio(){  

     $('#ejercicio').empty().append('<option value="0" selected="selected">SELECCIONE EJERCICIO</option>');
   //  $('#selnuevoaniofraccionriesgodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("ejercicio"); //llenar con js un selector de años
  //   var select2 = document.getElementById("selnuevoaniofraccionriesgodetrab"); //llenar con js un selector de fechas
     for (var i = n; i >= 2017; i--) {
         select.options.add(new Option(i, i));
   //      select2.options.add(new Option(i, i));
     }
 }

function insertarenlibrosaldos(selectTipoDeBanco,selectNumCuenta){  
           
        $.ajax({
            type: "POST",
            url: "upload_insertarlibrosaldos.php",
            data:{"selectTipoDeBanco":selectTipoDeBanco,"selectNumCuenta":selectNumCuenta},
            dataType: "json",     
            //una vez finalizado correctamente
             success: function(response) {
            // console.log(response);
              
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
          
        });
  }  
  function insertarsaldodiarioCobranza(){
  $.ajax({
            type: "POST",
            url: "ajax_insertarSaldoDiario.php",
            dataType: "json", 
             success: function(response) {
             //console.log("insersaldodiario",response);

         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
          
        });

}
 
 </script>
