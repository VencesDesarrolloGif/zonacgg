<div class="container" align="center">
<form class="form-horizontal"  method="post" name='form_generarFactura' id="form_generarFactura" enctype="multipart/form-data">

  <legend><h3>Datos de Factura</h3></legend>
  <table class="table1"  >
        <tr >
          <td><label class="control-label label " for="folioFactura">Folio</label></td>
          <td><input id="folioFactura" name="folioFactura" type="text" class="input-large"/></td>

        </tr>
        <tr>
          <td><label class="control-label label " for="selectListaProveedores">Proveedor</label></label> </td>
          <td><select id="selectListaProveedores" name="selectListaProveedores" class="input-large">
              <?php
                  for ($i=0; $i<count($catalogoProveedores); $i++)
                  {
                    echo "<option value='". $catalogoProveedores[$i]["idProveedor"]."'>". $catalogoProveedores[$i]["nombreProveedor"] ." </option>";
                  }                  
                ?>
                </select>
          </td>
        </tr>
        <tr>
          <td><label class="control-label label" for="selectLineaNegocio" >Linea de Negocio</label></td>
          <td><select id="selectLineaNegocio" name="selectLineaNegocio" class="input-large">
             <option>LiNEA NEGOCIO</option>
              <?php
                for ($i=0; $i<count($catalogoLineaNegocio); $i++)
                {
                echo "<option value='". $catalogoLineaNegocio[$i]["idLineaNegocio"]."'>". $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] ." </option>";
                }
              ?>
              </select>
          </td>
        
        <tr>
          <td><label class="control-label label" for="selectTipoPago" >Tipo de Pago</label></td>
          <td><select id="selectTipoPago" name="selectTipoPago" class="input-large" onchange="cambiarTipoPago()">
                <option value='0'>TIPO PAGO</option>
                <option value='1'>CONTADO</option>
                <option value='2'>CREDITO</option>
              </select>
          </td>
        </tr> 
        <tr>

          <td><div name="divLblFormaPago" id="divLblFormaPago"></div></td>
          <td>
            <div id="divFormaPago" name="divFormaPago"></div>
          </td>         
        </tr> 
        <tr>
          <td><label class="control-label label " for="selectTipoMF">Tipo de Mercancia</label></td>          
            <td><select id="selectTipoMF" name="selectTipoMF" onchange="cambioTipoMercaFac()">
                <option>TIPO MERCANCIA</option>
              <?php
                for ($i=0; $i<count($catalogoTiposMercancia); $i++)
                {
                echo "<option value='". $catalogoTiposMercancia[$i]["idTipoMercancia"]."'>". $catalogoTiposMercancia[$i]["descripcionTipoMercancia"] ." </option>";
                }
              ?>
            </select></td>
        </tr>      
        <tr>
          <td><label class="control-label label " for="txtMercancia">Uniforme</label></label> </td>
          <td><input id="txtMercancia" name="txtMercancia" type="text" class="input-small" />
            <select id="selectMercancia" name="selectMercancia" onchange="cambioTipoUniformeFac()">
               
            </select></td>
        </tr>
        <tr>
          <td><label class="control-label label " for="cantUni">Cantidad</label></label> </td>
          <td><input id="cantUni" name="cantUni" type="text" class="input-small-mini" /></td>
          <td><button class="btn btn-primary" type='button' id='btnCantidadUni' name='btnCantidadUni' onclick='agregarCompra()'><span class="glyphicon glyphicon-refresh"></span>Agregar</button></td>
        </tr>
        <tr>
          <td><label class="control-label label " for="precioUni">Precio</label></label> </td>
          <td><input id="precioUni" name="precioUni" type="text" class="input-small" /></td>
        </tr>       
        <tr>
          <td><label class="control-label2 label " for="subTotalFac">Subtotal</label></label> </td>
          <td><input id="subTotalFac" name="subTotalFac" type="text" class="input-small" readonly/></td>
        </tr>  
        <tr>
        <tr>
          <td><label class="control-label label " for="ivaFac">IVA</label></label> </td>
          <td><input id="ivaFac" name="ivaFac" type="text" class="input-small" readonly/></td>
        </tr> 
        <tr>
          <td><label class="control-label2 label " for="totalFac">Total Factura</label></label> </td>
          <td><input id="totalFac" name="totalFac" type="text" class="input-small" readonly/></td>
        </tr> 
        </tr>
        <tr>
          <td><label class="control-label label " for="selEntidadesNewFactura">Entidad A Recibir</label></label> </td>
          <td><select id="selEntidadesNewFactura" name="selEntidadesNewFactura" ></select></td>
        </tr>
        <tr>
          <td><label class="control-label label " for="selSucursalNewFactura">Sucursal A Recibir</label></label> </td>
          <td><select id="selSucursalNewFactura" name="selSucursalNewFactura">
              <option value="0">SUCURSAL</option>
          </select></td>
        </tr>         
          <td><label class="control-label label " for="checkEntregada">Mercancia Entregada</label></label> </td>
          <td><input id="checkEntregada" name="checkEntregada" type="checkbox" class="checkbox" /></td>
        </tr>
        <tr>
          <td><label class="control-label label " for="checkPagada">Factura Pagada</label></label> </td>
          <td><input id="checkPagada" name="checkPagada" type="checkbox" class="checkbox" /></td>
        </tr>

   </table>
   <br>
   <button type='button' class='btn btn-success' id='btnRegistrarProveedor' name='btnRegistrarProveedor' onclick='generarFacturaAlmacen()'><span class="glyphicon glyphicon-floppy-save"></span>Generar Factura</button>


</form>

</div>

<script type="text/javascript">

var listaCompraUniformes = null;
var numUniformes=0;
var subtotal=0;
var total=0;

$(inicioGeneracionFactura());  
// $(cargarSelectorEntidadesNewFactura());  

function inicioGeneracionFactura(){
  reiniciarCompra();
}

$("#selEntidadesNewFactura").change(function (){

  var entidadElegida=$("#selEntidadesNewFactura").val();

  if (entidadElegida!=0){
    $.ajax({
          type: "POST",
          url: "GenerarFactura/ajax_consultaSucursalesAlmacen.php",
          data:{"entidadElegida":entidadElegida},
          dataType: "json",
          success: function(response) {
              // var msj=response.error;
              if (response.status == "success"){
                var sucursal=response.sucursales;
                $('#selSucursalNewFactura').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
                $.each(sucursal, function(i) {
                  $('#selSucursalNewFactura').append("<option value='"+sucursal[i].idSucursalI+"' title='"+sucursal[i].nombreSucursal+"'>"+sucursal[i].nombreSucursal+"</option>");
                });
                $('#selSucursalNewFactura').focus();                  
              }else{
                alert(msj);
               }
          },error: function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText); 
           }
    });
  }else{
        $('#selSucursalNewFactura').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
  }
});
  
function reiniciarCompra(){     
    
    listaCompraUniformes = new Array();
    numUniformes=0;
    subtotal=0;
    var total=0;    
    document.form_generarFactura.reset();
    cargarSelectorEntidadesNewFactura();

}
function cargarSelectorEntidadesNewFactura(){
    $.ajax({
      type: "POST",
      url: "ajax_getEntidadesUsuario.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selEntidadesNewFactura").empty(); 
        $('#selEntidadesNewFactura').append('<option value="0">ENTIDAD FEDERATIVA</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#selEntidadesNewFactura').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
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

function agregarCompra(){
    var folioFactura=$("#folioFactura").val();
    var tipoMercancia=$("#txtMercancia").val();
    var txtCantidad=$("#cantUni").val();
    var txtPrecio=$("#precioUni").val();
    var ERDecimal = /^([0-9])*[.]?[0-9]*$/;
    if(folioFactura==""){
        alert("Introduce el folio de la factura");
    }else if(tipoMercancia==""){
        alert("Selecciona o escribe el tipo de uniforme");
    }else if(txtCantidad==""){
        alert("Escribe la cantidad de uniformes");
    }else if(txtPrecio==""){
        alert("Escribe el precio del uniforme");
    }else{
        var numUniformeSelect=obtenerTipoUniformeFac(tipoMercancia);
        if(numUniformeSelect==0){
            alert("Tipo de uniforme invalido");
        }else{                  
            if(isNaN(parseInt(txtCantidad))){
                alert("La cantidad debe ser numero entero");
            }else if(!ERDecimal.test(txtPrecio)){
                alert("El precio debe ser numero decimal");
            }else{
                var cantidad=parseInt(txtCantidad);
                var precio=parseFloat(txtPrecio);                 
                subtotal=subtotal+(parseInt(txtCantidad)*parseFloat(txtPrecio));
                subtotal.toFixed(3);                
                var compra={};
                compra.idFactura=folioFactura;
                compra.tipoUniforme=numUniformeSelect;
                //alert("tipoUniforme: "+numUniformeSelect+" cantidad: "+cantidad);
                compra.cantidadUni=cantidad;
                compra.precioUni=precio;
                listaCompraUniformes[numUniformes]=compra;
                var iva=subtotal*.16;
                total=subtotal+iva;
                total.toFixed(2);                
                $("#subTotalFac").val(subtotal);
                $("#ivaFac").val(iva);
                $("#totalFac").val(total);
                $( "#folioFactura" ).prop( "disabled", true );
                $("#txtMercancia").val("");
                $("#selectMercancia option[value='"+numUniformeSelect+"']").remove();
                numUniformes++;                  
            }
        }
    }    
    //var select=document.getElementById("selectMercancia");
    //var lineaNegocio=select.selectedIndex;


}

function generarFacturaAlmacen(){        
        var folioFactura=$("#folioFactura").val();                
        var opcionPago=document.getElementById("selectTipoPago").selectedIndex;        
        var tipoPago=document.getElementById("selectTipoPago").options[opcionPago].text;                 
        var total=$("#totalFac").val();  
        var lineaNegocio=document.form_generarFactura.selectLineaNegocio.selectedIndex;
        var opcionProv=document.getElementById('selectListaProveedores').selectedIndex;
        var proveedor=document.getElementById('selectListaProveedores').options[opcionProv].value;
        var entidadProducto = $("#selEntidadesNewFactura").val();
        var sucursalProducto = $("#selSucursalNewFactura").val();
        if(document.form_generarFactura.checkEntregada.checked)
          var entregada=1;            
        else
          var entregada=0;
        if(document.form_generarFactura.checkPagada.checked)
          var pagada=1;
        else
          var pagada=0;
        if(folioFactura==""){
            alert("Introduce el folio de la factura");
        }else if(lineaNegocio == 0){
            alert("Selecciona la linea de negocio");
        }else if(opcionPago == 0){
            alert("Selecciona el tipo de pago");
        }else if(listaCompraUniformes.length == 0){
            alert("No se han agregado uniformes");
        }else if(entidadProducto == "" || entidadProducto == "NULL" || entidadProducto == "null" || entidadProducto == null || entidadProducto == "0" ){
          alert("No Se Ha Agregado Entidad De Recepción");
        }else if(sucursalProducto == "" || sucursalProducto == "NULL" || sucursalProducto == "null" || sucursalProducto == null || sucursalProducto == "0" ){
          alert("No Se Ha Agregado sucursal De Recepción");
        }else{
          var decPago=document.getElementById("selectDescPago");                  
          var opcionDescripcionPago=decPago.selectedIndex;                
          var textDescPago=decPago.options[opcionDescripcionPago].text;     
          $.ajax({            
            type: "POST",
            url: "GenerarFactura/ajax_newFactura.php",
            data: {"mercanciaEntregada":entregada, "facturaPagada":pagada, "tipoPago":tipoPago,"descripcionPago":textDescPago,
                    "totalFactura":total, "proveedor":proveedor, "listaUniformes":listaCompraUniformes, "lineaNegocio":lineaNegocio,"entidadProducto":entidadProducto,"sucursalProducto":sucursalProducto},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {                    
                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Generacion de factura: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                 
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(4000).fadeOut('slow');
                    reiniciarCompra();
                    // window.setTimeout('location.reload()', 2000);
                } else if (response.status=="error"){
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Generacion de factura:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(4000).fadeOut('slow');
                }                 
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
        }          
}
    
     function cambioTipoUniformeFac(){          
          var select=document.getElementById("selectMercancia");

          var opcion=select.selectedIndex;          
          var nombreTipoUniforme=select.options[opcion].text; 
          if(opcion!=0)         
              $("#txtMercancia").val(nombreTipoUniforme);
          else
              $("#txtMercancia").val("");

     }

     function cambioTipoMercaFac(){

      var tipoM=$("#selectTipoMF").val();

      $.ajax({
            
            type: "POST",
            url: "ajax_getUniformesByTipo.php",
            data:{"tipoMerca":tipoM},
            dataType: "json",
             success: function(response) {
                var msj=response.error;
                if (response.status == "success")
                {
                  var uniformes=response.listaUni;
                  //alert(uniformes.length);
                  $('#selectMercancia').empty().append('<option selected="selected">UNIFORME</option>');
                  $("#txtMercancia").val("");
                  $.each(uniformes, function(i) {
                      $('#selectMercancia').append("<option value='"+uniformes[i].idTipoUniforme+"' title='"+uniformes[i].descripcionTipo+"'>"+uniformes[i].codigoUniforme+"</option>");
                  });
                  $('#selectMercancia').focus();                  
                }else{
                    alert(msj);
                }
            },
             error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });

  }

     function obtenerTipoUniformeFac(txtMercancia){        
        var totalOpciones=document.form_generarFactura.selectMercancia.length;

        for(var i = 1; i < totalOpciones; i++){            
            var opcionUniforme=document.form_generarFactura.selectMercancia.options[i].text;                     
            if(txtMercancia == opcionUniforme){                
                var valor=document.form_generarFactura.selectMercancia.options[i].value;                
                return valor;
            }
        }
        return 0;
     }

     function cambiarTipoPago(){
          var opcionPago=document.getElementById("selectTipoPago").selectedIndex;
          if(opcionPago == 1){
              getFormasDePago();
          }else if(opcionPago == 2){
              getPlazosDeCredito();
          }else{
            $("#divFormaPago").html("");
            $("#divLblFormaPago").html("");
          }
          

      }

      function getFormasDePago(){
          $.ajax({
              type: "POST",
              url: "ajax_obtenerListaFormasPagos.php",              
              dataType: "json",
              success: function(response) {
                  if (response.status == "success")

                  {

                    var listaFormasPago = response.listaFormasPago;
                    var formasPagoOptions="<select name='selectDescPago' id='selectDescPago'>";
                    
                    for ( var i = 0; i < listaFormasPago.length; i++ ){
                      formasPagoOptions += "<option value='" + listaFormasPago[i].idFormaPago + "'>" + listaFormasPago[i].descripcionFormaPago + "</option>";
                    }
                    formasPagoOptions += "</select>";
                    $("#divFormaPago").html (formasPagoOptions);
                    $("#divLblFormaPago").html("<label class='control-label2 label' for='selectDescPago'>Forma de Pago</label>");
                  }                  
              },
              error: function (response)
              {
                  console.log (response);
              }
          });

      }


      function getPlazosDeCredito(){
          $.ajax({
              type: "POST",
              url: "ajax_obtenerListaPlazosCredito.php",              
              dataType: "json",
              success: function(response) {
                  if (response.status == "success")

                  {                    
                    var listaPlazos = response.listaPlazosCredito;
                    var plazosPagoOptions="<select name='selectDescPago' id='selectDescPago'>";
                    
                    for ( var i = 0; i < listaPlazos.length; i++ ){
                      plazosPagoOptions += "<option value='" + listaPlazos[i].idPlazo + "'>" + listaPlazos[i].descripcionPlazo + "</option>";
                    }
                    plazosPagoOptions += "</select>";
                    $("#divFormaPago").html (plazosPagoOptions);
                    $("#divLblFormaPago").html("<label class='control-label2 label' for='selectDescPago'>Plazo de Crédito</label>");
                  }                  
              },
              error: function (response)
              {
                  console.log (response);
              }
          });

      }

</script>