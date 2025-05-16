<div align="center">
 <form class="form-horizontal"  method="post" id="form_catalogoFacturas" name="form_catalogoFacturas" action="" target="_blank">
     <div id="modalDetalleFactura" name="modalDetalleFactura" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
            <div id="msgModalConsultaFactura" id="msgModalConsultaFactura">
            </div>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><img src="img/sueldoIcon.png">Detalle factura</h4>
          </div>
          <div class="modal-body-plantilla">
              <div class="hero-unit" id="listaDetalleFactura" name="listaDetalleFactura">
              </div>
              <span class="add-on">Mercancia entregada</span>
              <div class="input-prepend">
                  <div class="material-switch pull-right">
                    <input id="entregadaEstado" name="mercanciaEntregada" type="checkbox"/>
                    <label for="entregadaEstado" class="label-success1" onclick="desabilitar1()"></label>
                  </div>
             </div>
             <br>
             <span class="add-on">Factura pagada</span>
            <div class="input-prepend">
                  <div class="material-switch pull-right">
                    <input id="pagadaEstado" name="facturaPagada" type="checkbox"/>
                    <label for="pagadaEstado" class="label-success1" onclick="desabilitar2()"></label>
                  </div>
            </div>
            <div class="modal-footer" align="centers">
                  <button class="btn" data-dismiss="modal" aria-hidden="true" >Close</button>
                  <input id="btnGuardar" type="button" class="btn btn-primary"  value="Guardar" onclick="guardarCambioFactura()" />
              </div>
          </div>
    </div>     
  </form>
</div>
<div class="container" align="center">
    <fieldset>        
      <h1>Lista Facturas</h1>
    </fieldset>
    <section>
      <table id="tableFacturas" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th>Folio Factura</th>
            <th>Entidad a Recibir</th>
            <th>Sucursal a Recibir</th>
            <th>Linea de Negocio</th>
            <th>Proveedor</th>
            <th>Fecha Generación</th>
            <th>Mercancia Entregada</th>                        
            <th>Fecha Entrega</th>
            <th>Pago</th>
            <th>Forma o Plazo de Pago</th>
            <th>Factura Pagada</th>
            <th>Fecha de Pago</th>            
            <th>Total</th>            
            <th>Detalle</th>   
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </section>  
</div>
<script type="text/javascript">

$(getFacturas());  
var tableFacturas = null;

function desabilitar1(){
  if(document.form_catalogoFacturas.entregadaEstado.checked == false){
     document.form_catalogoFacturas.btnGuardar.disabled=false;    
     document.form_catalogoFacturas.entregadaEstado.checked=false;
  }else{
        document.form_catalogoFacturas.btnGuardar.disabled=false;
        document.form_catalogoFacturas.entregadaEstado.checked=true;
  }
}

function desabilitar2(){
    if(document.form_catalogoFacturas.pagadaEstado.checked == false){
        document.form_catalogoFacturas.btnGuardar.disabled=false;
        document.form_catalogoFacturas.pagadaEstado.checked=false;
    }else{
        document.form_catalogoFacturas.btnGuardar.disabled=false;
        document.form_catalogoFacturas.pagadaEstado.checked=true;
    }
}

function getFacturas(){
  var dataTableFacturas = [];

  $.ajax({
          type: "POST",
          url: "ajax_getFacturas.php",
          dataType: "json",
          async: false,
          success: function (response){
            if (response.status == "success"){
              for(var i = 0; i < response.data.length; i++){                        
                  var record = response.data[i];
                  dataTableFacturas.push (record);                        
              }
              loadDataInTableFacturas (dataTableFacturas);
            }
          },error : function (jqXHR, textStatus, errorThrown){
                alert (jqXHR.responseText);
          }
    });
}

function loadDataInTableFacturas(data){
  
  if (tableFacturas != null){
      tableFacturas.destroy ();
  }

  tableFacturas = $('#tableFacturas').DataTable( {
          "language" : {
              "emptyTable" :         "No hay facturas disponibles en la tabla",
              "info" :               "Del _START_ al _END_ de _TOTAL_",
              "infoEmpty" :          "Mostrando 0 registros de un total de 0.",
              "infoFiltered" :       "(filtrados de un total de _MAX_ registros)",
              "infoPostFix" :        "(actualizados)",
              "lengthMenu" :         "Mostrar _MENU_ registros",
              "loadingRecords" :     "Cargando....",
              "processing"     :     "Procesando....",
              "search" :             "Buscar:",
              "searchPlaceholder" :  "Dato para buscar",
              "zeroRecords" :        "no se han encontrado coincidencias",
              "paginate" : {
                   "first" :         "Primera",
                   "last" :          "Ultima",
                   "next" :          "Siguiente",
                   "previous" :      "Anterior"
              },
              "aria" : {
                 "sortAscending" :   "Ordenación ascendente",
                 "sortDescending" :  "Ordenación descendente"
              }
           },
        data: data,
        destroy: true,
        "columns": [
            { "data": "idFactura" }
            ,{ "data": "nombreEntidadFederativa"}
            ,{ "data": "nombreSucursal"}
            ,{ "data": "descripcionLineaNegocio"}
            ,{ "data": "nombreProveedor"}
            ,{ "data": "fechaFactura"}
            ,{ "data": "mercanciaEntregada"}
            ,{ "data": "fechaMercanciaEntregada"}
            ,{ "data": "formaPagoFactura"}
            ,{ "data": "descripcionPago"}
            ,{ "data": "facturaPagada"}
            ,{ "data": "fechaPagoFactura"}
            ,{ "data": "totalFactura", render: $.fn.dataTable.render.number(',','.', 2,'$') }
            ,{ "data": "accion_ver_detalle" }           
       ]
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']
    } );
}

function mostrarModalDetalle(idFactura,pagada,entregada){

  $('#modalDetalleFactura').modal();            
  document.getElementById("btnGuardar").disabled = true;
  consultaDetalleFactura(idFactura);
}

function consultaDetalleFactura(idFactura){
  
  var facturaId=idFactura;
  $.ajax({
              
          type: "POST",
          url: "ajax_consultaDetalleFactura.php",
          data:{"facturaId":facturaId},
          dataType: "json",
          success: function(response) {
            if (response.status == "success"){
              var lista = response.lista;                      
              document.getElementById("listaDetalleFactura").innerHTML="";                  
              detalleFacturaTable="<table  class='table table-hover' id='"+facturaId+"'><thead  style='color:#456789;font-size:100%;'><th> Tipo Uniforme</th><th>Descripcion Uniforme</th><th>Cantidad</th><th>Precio</th></thead><tbody>";

              for(var i = 0; i < lista.length; i++ ){
                  var tipoUniforme=lista[i].codigoUniforme;
                  var descripcionTipo=lista[i].descripcionTipo;
                  var cantidadUniforme=lista[i].cantidadUniforme;
                  var precioUniforme=lista[i].precioUniforme;
                  detalleFacturaTable+="<tr style='color:#456789;font-size:80%;'><td>"+tipoUniforme+"</td><td>"+descripcionTipo+"</td><td>"+cantidadUniforme+"</td><td>"+format(precioUniforme,2)+"</td><td></tr>";
              }
              detalleFacturaTable += "</tbody></table>";
              $('#listaDetalleFactura').html(detalleFacturaTable); 
              obtenerStatusFactura(idFactura);
            }else if(response.status == "error" && response.message == "No autorizado"){
                     window.location = "login.php";
            }
          },error: function (response){
                  alert("error inesperado");
          }
  });
}

function guardarCambioFactura(){
  var folioFactura=document.getElementsByTagName("table")[3].id;
  var entregada=document.form_catalogoFacturas.entregadaEstado.checked;
  var pagada=document.form_catalogoFacturas.pagadaEstado.checked;
  var valEntregada=0;
  var valPagada=0;
  // console.log(entregada);
  // console.log(pagada);
  if(entregada == true)
     valEntregada=1;
  if(pagada == true)
     valPagada=1;
  
  // alert(valEntregada);
  // alert(valPagada);
  $.ajax({
              
         type: "POST",
         url: "ajax_guardarCambioFactura.php",
         data:{"facturaId": folioFactura,"mercanciaEntregada":valEntregada, "facturaPagada":valPagada },
         dataType: "json",
         success: function(response) {
            if(response.status == "success"){
               var mensaje=response.message;
               alertMsg1="<div id='msgAlertFactura' class='alert alert-success'><trong>Edicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#msgModalConsultaFactura").html(alertMsg1);
               $('#msgAlertFactura').delay(2000).fadeOut('slow');
               document.getElementById("btnGuardar").disabled = true; 
               getFacturas();
            }else if (response.status == "error"){
                      alert(response.message);
            }
          },error: function (response){
                  alert("error de actualizacionFactura");
              }
        });
}

function format(amount, decimals) {

  amount += ''; // por si pasan un numero en vez de un string
  amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto
  decimals = decimals || 0; // por si la variable no fue fue pasada

  if(isNaN(amount) || amount === 0) 
     return parseFloat(0).toFixed(decimals);
     amount = '' + amount.toFixed(decimals);
     var amount_parts = amount.split('.'),
     regexp = /(\d+)(\d{3})/;
    while (regexp.test(amount_parts[0]))
      amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
    return "$"+amount_parts.join('.');
}
    
function obtenerStatusFactura(idFactura){

  var facturaId=idFactura;
  $.ajax({
          type: "POST",
          url: "ajax_consultaEstadoFactura.php",
          data:{"facturaId":facturaId},
          dataType: "json",
          success: function(response) {
            if(response.status == "success"){
              var estado = response.estado;                      
              
              if(estado["mercanciaEntregada"]==1){
                document.getElementById("entregadaEstado").checked=true;
              }
              
              if(estado["facturaPagada"]==1){
                document.getElementById("pagadaEstado").checked=true;
              }
            }else if (response.status == "error"){
                      alert("error");
            }
          },error: function (response){
                  alert("error consultaEstado");
          }
  });
}
</script>