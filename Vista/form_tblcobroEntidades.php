 <?php

if ($usuario["rol"] == "Cobranza" ) {
    $catalogoLineadeNegocio                = $negocio->negocio_obtenerListaLineaNegocio();   
}
?>
<div id="msgerrortblcobroentidades" id="msgerrortblcobroentidades"> </div>
  <center><h3>Flujo de Negocios</h3><h5 style="" id="titulo">Tendencia de cobranza</h5></center>
    <section>
      <center>
        <div class="container">
          <li><a  style="cursor: pointer;" id="facturadomes">TENDENCIA DE COBRANZA</a></li>
          <li><a style="cursor: pointer;" id="cobromensual">COBRANZA MENSUAL</a></li><br>
      </div>
        <div >
          <input id="accion" value="0" type="hidden">
           <select id="sellineanegocio" name="sellineanegocio" class="input-large " onChange="">
        <option value="0">Linea de Negocio</option>
        <?php
          for ($i = 0; $i < count($catalogoLineadeNegocio); $i++) {
          echo "<option value='" . $catalogoLineadeNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineadeNegocio[$i]["descripcionLineaNegocio"] . " </option>";
          }
        ?>
      </select>
          <select id='selejercicio'></select>
        </div><br>
        <div >
          <button style="margin-bottom: 0.5%" type="button" class="btn btn-primary" onclick="buscarejercicotblcobro();">Buscar</button>
        </div>
      </center>
    <div id="muestratabla" style="display:none">
      <table id="tablacobroxEntidad"  width="100%">
        <thead>
          <tr>
            <th style="text-align: center;background-color: #B0E76E">Entidad</th>
            <th style="text-align: center;background-color: #B0E76E">Enero</th>
            <th style="text-align: center;background-color: #B0E76E">Febrero</th>
            <th style="text-align: center;background-color: #B0E76E">Marzo</th>
            <th style="text-align: center;background-color: #B0E76E">Abril</th>
            <th style="text-align: center;background-color: #B0E76E">Mayo</th>
            <th style="text-align: center;background-color: #B0E76E">Junio</th>
            <th style="text-align: center;background-color: #B0E76E">Julio</th>
            <th style="text-align: center;background-color: #B0E76E">Agosto</th>
            <th style="text-align: center;background-color: #B0E76E">Septiembre</th>
            <th style="text-align: center;background-color: #B0E76E">Octubre</th>
            <th style="text-align: center;background-color: #B0E76E">Noviembre</th>
            <th style="text-align: center;background-color: #B0E76E">Diciembre</th>
          </tr>
        </thead>
        <tbody>
      </table>
    </div>
  </section> 
 <script type="text/javascript">

$("#sellineanegocio").change(function(){
if($("#sellineanegocio").val()!=0){
     $('#selejercicio').empty().append('<option value="0" selected="selected">SELECCIONE EJERCICIO</option>');
   //  $('#selnuevoaniofraccionriesgodetrab').empty().append('<option value="0" selected="selected">- Seleccione -</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selejercicio"); //llenar con js un selector de años
  //   var select2 = document.getElementById("selnuevoaniofraccionriesgodetrab"); //llenar con js un selector de fechas
     for (var i = n; i >= 2017; i--) {
         select.options.add(new Option(i, i));
   //      select2.options.add(new Option(i, i));
     }
   }else{$('#selejercicio').empty();}
 });

 function buscarejercicotblcobro(){
    var accion=$("#accion").val();
    var lineanegocio=$("#sellineanegocio").val();
    var ejercicio=$("#selejercicio").val();
    limpiaerroresfrmcobroentidad();
      if(lineanegocio=="0"){
        cargaerroresfrmcobroentidad("sellineanegocio","Seleccione linea de negocio");
      }else if(ejercicio==0){
        cargaerroresfrmcobroentidad("selejercicio","Seleccione ejercicio");
      }else{
         tablecobroxentidades = [];
           $.ajax({
               type: "POST",
               url: "ajax_consultatblcobroentidades.php",
               data:{"ejercicio":ejercicio,"lineanegocio":lineanegocio,"accion":accion},
               dataType: "json",
               success: function(response) {
                //console.log(response);
                   if (response.status == "success") {
                      $("#muestratabla").show();
                       for (var i = 0; i < response.datos.length; i++) {
                           var record = response.datos[i];
                           tablecobroxentidades.push(record);
                          // console.log(record);
                       }
                       loadDataInTablecobroentidades(tablecobroxentidades);
                   } else {
                       var mensaje = response.message;
                       //console.log("mal");
                   }
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   alert(jqXHR.responseText);
               }
           });
        }
  }
 


 var tablecobentidad = null;
 function loadDataInTablecobroentidades(data) {
     if (tablecobentidad != null) {
         tablecobentidad.destroy();
     }
     tablecobentidad = $('#tablacobroxEntidad').DataTable({
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
         "columns": [{
             "data": "descEntidad"
         }, {
             "data": "enero"
         },{
             "data": "febrero"
         },{
             "data": "marzo"
         },{
             "data": "abril"
         },{
             "data": "mayo"
         },{
             "data": "junio"
         },{
             "data": "julio"
         },{
             "data": "agosto"
         },{
             "data": "septiembre"
         },{
             "data": "octubre"
         },{
             "data": "noviembre"
         },{
             "data": "diciembre"
         }, ],
         // ]
         //,serverSide: true
         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     });
     
 }
 function cargaerroresfrmcobroentidad(obj,mensaje){
   var Msgerror = "<div id='msgerrortblcobroentidades' class='alert alert-danger'><strong  class='text-justify'>"+mensaje+"</strong> <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
          $("#msgerrortblcobroentidades").html(Msgerror);
          $("#"+obj).css('border', '#D0021B 1px solid');
 }
 function limpiaerroresfrmcobroentidad(){
    $("#msgerrortblcobroentidades").html("");
    $("#sellineanegocio").removeAttr("style");
    $("#selejercicio").removeAttr("style");
  }
$("#cobromensual").click(function(){
  limpiaerroresfrmcobroentidad();
  $("#selejercicio").empty();
  $("#sellineanegocio").val(0);
  $("#accion").val(1);
  $("#muestratabla").hide();
  $("#titulo").html("Cobranza Mensual");  
});
$("#facturadomes").click(function(){
  limpiaerroresfrmcobroentidad();
  $("#selejercicio").empty();
  $("#sellineanegocio").val(0);
  $("#accion").val(0);
  $("#muestratabla").hide();
  $("#titulo").html("Tendencia de cobranza");
});

</script>
