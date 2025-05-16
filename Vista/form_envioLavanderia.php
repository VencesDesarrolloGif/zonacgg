<div id="muestratablaEnvios" align="center">
   <h1>UNIFORMES ENVIADOS A LAVANDERIA</h1>
   <br>
    <img src="img/botonbuscar.jpg" id="btnBuscarUnifEnvLavanderia" width="150">
    <br>
        <section>
            <table id="listaUniformesenviadosalavan" style="display:none;" cellspacing="0" width="100%">
                <thead>
                    <tr>                        
                        <th>Folio Lavanderia</th>
                        <th>Entidad</th>
                        <th>Sucursal</th>
                        <th>Fecha Envio</th>
                        <th>Detalle</th>                       
                    </tr>
                </thead> 
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>Folio Lavanderia</th>
                        <th>Entidad</th>
                        <th>Sucursal</th>
                        <th>Fecha Envio</th>
                        <th>Detalle</th>   
                    </tr>
                </tfoot>
            </table>
        </section>
</div>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>  

<div align="center">
     <div id="modaldetallelavanderiaFolio" name="modaldetallelavanderiaFolio" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >            
          <div class="modal-header">
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><img src="">Detalle Envio</h4>
          </div>

          <div class="modal-body-plantilla">
            
              <div class="hero-unit" id="listaDetalleLavanderia" name="listaDetalleLavanderia">
                  
              </div>

              <div class="modal-footer" align="centers">
                  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>                  
              </div>
          </div>
    </div>     
 
</div>
<div id="muestratblRecibirUniformes" align="center" style="display: none">
  <img  id="imgRefresh" style="cursor:pointer" src="img/refresh-icon.png"  title="REGRESAR"><b style="color:#456789;font-size:100%;">Regresar</b><br><br>
<label class="control-label label" style="color:#456789;font-size:100%;">Folio de Nota o Factura</label>
  <input type="text" id="folioRecibidoLavanderia">  
  <label class="control-label label" style="color:#456789;font-size:100%;">Costo de Nota o Factura</label>
  <input type="text" id="costoLavanderia">
  <label class="control-label label" style="color:#456789;font-size:100%;">Entidad De Recepción Stock</label>
  <select id="EntidadStock" name="EntidadStock"></select>
  <input type="hidden" id="foliolavanderia">
<br>
<br><br>
<div id="listaUniformes"></div>
        <button id='btnaplicar' type="button" class="btn btn-primary" data-dismiss="modal" >Aplicar</button>
</div>
<script type="text/javascript">
var listaUniformeslava = null;
var numUniformeslav=0;

$("#btnBuscarUnifEnvLavanderia").click(function(){
  consultauniformesenviadosalavnderia();
});

function consultauniformesenviadosalavnderia() {
     tableLavanderrria = [];
     $.ajax({
         type: "POST",
         url: "ajax_consultaUniformesporFoliosDeEnvioLavan.php",
         data: {"accion":1,"folio":0,"arrayDatos":0,"costoNotaFactura":0,"folioRecibidoLavan":0},
         dataType: "json",
         success: function(response) {
          //console.log(response);
             if (response.status == "success") {
                 $("#listaUniformesenviadosalavan").show();
                 for (var i = 0; i < response.data.length; i++) {
                     var record = response.data[i];
                     tableLavanderrria.push(record);
                 }
                 loadDataInconsultalavanderia(tableLavanderrria);
             } else {
                 console.log("mal");
             }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });
 }

var tableConsuluniformes= null;

 function loadDataInconsultalavanderia(data) {
    if (tableConsuluniformes != null) {
        tableConsuluniformes.destroy();
    }
     tableConsuluniformes = $('#listaUniformesenviadosalavan').DataTable({
         "language": {
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
         "columns": [{"className": "dt-body-center",
             "data": "folios"
         }, {"className": "dt-body-center",
             "data": "nombreEntidadFederativa"
         },{"className": "dt-body-center",
             "data": "nombreSucursal"
         }, {"className": "dt-body-center",
             "data": "fechaEnvioLavanderia"
         }, {"className": "dt-body-center",
             "data": "accion_ver_detallessss"
         } ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: []
     });
}
function mostrarModalDetalleFoliosUniformesLavanderia(folio){
    $("#modaldetallelavanderiaFolio").modal();
    $.ajax({
        type: "POST",
        url: "ajax_consultaUniformesporFoliosDeEnvioLavan.php",
        dataType: "json",
        data:{"accion":2,"folio":folio,"arrayDatos":0,"costoNotaFactura":0,"folioRecibidoLavan":0},
        success: function(response) {
         if (response.status == "success"){
              var detallenvios = response.data;                      
              document.getElementById("listaDetalleLavanderia").innerHTML="";        
                detalleEnvioTable="<table  class='table table-hover' id='"+folio+"'><thead  style='color:#456789;font-size:100%;'><th> Tipo Uniforme</th><th>Descripcion Uniforme</th><th>Cantidad</th></thead><tbody>";                   
                  for (var i=0;i<detallenvios.length;i++){
                        var tipoUniforme=detallenvios[i].codigoUniforme;
                        var descripcion=detallenvios[i].descripcionTipo;
                        var cantidadUniforme=detallenvios[i].cantidadUniEnvio;                          
                        detalleEnvioTable+="<tr style='color:#456789;font-size:80%;'><td>"+tipoUniforme+"</td><td>"+descripcion+"</td><td>"+cantidadUniforme+"</td></tr>";       
                  }
                        detalleEnvioTable += "</tbody></table>";
                        $('#listaDetalleLavanderia').html(detalleEnvioTable);                                       
          } 
                
        },error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
  });
}
function cargarSelectorEntidadesStock(){
    $.ajax({
      type: "POST",
      url: "ajax_getEntidadesUsuario.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#EntidadStock").empty(); 
        $('#EntidadStock').append('<option value="0">Entidad Federativa</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {
            $('#EntidadStock').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
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
function mostrarListaParaRecibirUniformes(folio){
  cargarSelectorEntidadesStock();
  $("#muestratablaEnvios").hide();
  $("#muestratblRecibirUniformes").show();
  $("#foliolavanderia").val(folio);           
   $.ajax({
          type: "POST",
          url: "ajax_consultaUniformesporFoliosDeEnvioLavan.php",
          
          dataType: "json",
          data:{"accion":2,"folio":folio,"arrayDatos":0,"costoNotaFactura":0,"folioRecibidoLavan":0},
          success: function(response) {
                if (response.status == "success"){
                        var detallenvios = response.data;                      
                        document.getElementById("listaUniformes").innerHTML="";
                        var detalleEnvioTable="<table  class='table table-hover' id='"+folio+"'><thead  style='color:#456789;font-size:100%;'><th> Tipo Uniforme</th><th>Descripcion Uniforme</th><th>Cantidad</th><th>Stock</th><th>Destruccion</th><th>declinar</th></thead><tbody>";                   
                        for ( var i = 0; i < detallenvios.length; i++ ){
                            var tipoUniforme=detallenvios[i].codigoUniforme;
                            var descripcion=detallenvios[i].descripcionTipo;
                            var cantidadUniforme=detallenvios[i].cantidadUniEnvio; 
                            var idTipoUniforme=detallenvios[i].idTipoUniforme;//el id que servira para insertar el uniforme al stock(almacen) 
                            var idunicoBajaUniforme=detallenvios[i].incremetBajauniforme;                           
                              detalleEnvioTable += "<tr><td ><input id='tipouniforme" + i + "' type='text' readonly='true' value='" +tipoUniforme + "'><input id='idtipouniforme" + i + "' type='hidden' readonly='true' value='" +idTipoUniforme + "'><input id='idunicobajauniforme" + i + "' type='hidden' readonly='true' value='" +idunicoBajaUniforme + "'></td>";
                              detalleEnvioTable += "<td><input id='descripcionuniforme" + i + "' type='text' readonly='true' value='" + descripcion + "'></td>";
                              detalleEnvioTable += "<td><input id='cantidaduniforme" + i + "' type='text' readonly='true' value='" + cantidadUniforme + "' ></td>";
                              detalleEnvioTable += "<td><label class='radio'><input type='radio' name='optionsRadios" + i + "'  id='optionsRadios" + i + "'  value='1' ></label></td>"
                              detalleEnvioTable += "<td><label class='radio'><input type='radio' name='optionsRadios" + i + "'  id='optionsRadios" + i + "'  value='2' ></label></td>"
                              detalleEnvioTable += "<td><label class='radio'><input type='radio' name='optionsRadios" + i + "'  id='optionsRadios" + i + "' value='3'></label></td></tr>"
                        }
                            $("#listaUniformes").append(detalleEnvioTable);                
                } 
                  
          },error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
              }
    });
}
$("#imgRefresh").click(function(){
  mostrarrvistas();
});
function mostrarrvistas(){
  $("#muestratablaEnvios").show();
  $("#muestratblRecibirUniformes").hide();
  $("#foliolavanderia").val("");
}
$("#btnaplicar").click(function(){
    $("#btnaplicar").prop("disabled",true);
    var b = $("#listaUniformes tr").length;
    var c = $("#listaUniformes tr:last td").length;
    var folio=$("#foliolavanderia").val();
    var usuarioEntidadStock = $("#EntidadStock").val();
    var valoresRadios = new Array();

var folioRecibidoLavanderia=$("#folioRecibidoLavanderia").val();
var costoNotaFactura=$("#costoLavanderia").val();

if(folioRecibidoLavanderia==""){

  alert("Verifica Folio de Nota o Factura");
 $("#btnaplicar").prop("disabled",false);
}else if(costoNotaFactura==""  || !/^(([0-9]+)?(.[0-9]+)?)$/.test(costoNotaFactura)){
  alert("Verifica Costo de Nota o Factura" );
   $("#btnaplicar").prop("disabled",false);
}else{
    for (var i = 0; i < b-1 ; i++) {    
          var valoresRadioBtns=$('input:radio[name=optionsRadios'+i+']:checked').val();
          var idTipoUniforme=$("#idtipouniforme"+i).val();
          var idunicobajauniforme=$("#idunicobajauniforme"+i).val();
          if(valoresRadioBtns==undefined){
              alert("por favor seleccione accion en la fila "+ (i+1));
              valoresRadios=[];
              //idsUnifomres=[];
              $("#btnaplicar").prop("disabled",false);
              break;
          }else if(usuarioEntidadStock=="0" && valoresRadioBtns=="1"){
              for (var i = 0; i < b-1 ; i++) {    
              
              if(valoresRadioBtns==1){
                alert("Selecciona La Entidad A Enviar El Stock");
                $("#btnaplicar").prop("disabled",false);
              }
            }
          }else{
              valoresRadios.push(valoresRadioBtns+";"+idTipoUniforme+";"+idunicobajauniforme);
              if((valoresRadios.length==(b-1))){
                $.ajax({
                      type: "POST",
                      url: "ajax_consultaUniformesporFoliosDeEnvioLavan.php",
                      dataType: "json",
                      data:{"accion":3,"folio":folio,"arrayDatos":valoresRadios,"costoNotaFactura":costoNotaFactura,"folioRecibidoLavan":folioRecibidoLavanderia,"usuarioEntidadStock":usuarioEntidadStock},
                  success: function(response) {
                    alert("datos guardados correctamente");
                    consultauniformesenviadosalavnderia();
                    mostrarrvistas();
                    $("#btnaplicar").prop("disabled",false);  
                  },
                    error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText);
                    }
                });
              }
            }    
    }
  }
});
</script>
