<div class="container" align="center" >
    <h3>CONSULTAR UNIFORMES RECIBIDOS</h3>
    <br>   
    <div>
        TIPO: <select id="selectTipoReceive" name="selectTipoReceive" class="input-large" data-live-search="true" data-size="9">
            <option value="0">RECIBIDOS A STOCK</option>
            <option value="1">LAVANDERIA</option>
            <option value="2">DESTRUCCION</option>
            <option value="3">COBRO</option>
            </select>
            <br>
            <br>
     Del  <input type="text" id="fechaRecibidos1" name="fechaRecibidos1" class="input-medium">
        al
        <input type="text" id="fechaRecibidos2" name="fechaRecibidos2" class="input-medium">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="consultaRecibidos();">Consultar</button>
        <br><div id="MuestraSeccionEnvioLavanderiaFolio" style="display:none;">
        <span >Seleccione La Entidad Origen</span>
        <select id="selEntidades" name="selEntidades"></select>
        <br>
        <span >Seleccione La Sucursal Origen</span>
        <select id="selSucursalEnvLavanderia" name="selSucursalEnvLavanderia" >
            <option value="0">Sucursal</option>
        </select>
        <button type='button' class='btn btn-success' id='btnEnvioLavanderia' name='btnEnvioLavanderia' ><span class="glyphicon glyphicon-floppy-save"></span>Enviar a Lavanderia</button>
      </div>
        <br>
        <br>
        <br>
        <section>
            <table id="listaRecibidosTable" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>                        
                        <th>Codigo Uniforme</th>
                        <th>Descripcion</th>
                        <th>Numero Empleado</th>
                        <th>Nombre Empleado</th>
                        <th>Fecha Recepcion</th>
                        <th>Usuario Recepcion</th>    
                        <th>Enviar a Lavanderia</th>                                          
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>Codigo Uniforme</th>
                        <th>Descripcion</th>
                        <th>Numero Empleado</th>
                        <th>Nombre Empleado</th>
                        <th>Fecha Recepcion</th>
                        <th>Usuario Recepcion</th> 
                        <th>Enviar a Lavanderia</th> 
                    </tr>
                </tfoot>
            </table>
        </section>
    </div>
</div>
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>

<script type="text/javascript">

var tableConsultaReceive = null;
function consultaRecibidos(){
    var fechaConsulta1=$("#fechaRecibidos1").val();
    var fechaConsulta2=$("#fechaRecibidos2").val();
    var tipoRecepcion=$("#selectTipoReceive").val();

    if(fechaConsulta1!= '' && fechaConsulta2!=''){
        if(tableConsultaReceive != null){
           tableConsultaReceive.destroy ();
        }
        
        tableConsultaReceive = $('#listaRecibidosTable').DataTable({
            ajax: {
                url: 'ajax_getUniRecibidosByFecha.php'
                ,type: 'POST'
                ,data : {"fechaConsulta1":fechaConsulta1, "fechaConsulta2":fechaConsulta2, "tipoR":tipoRecepcion }
            }
            ,"columns": [            
                 { "className": "dt-body-center","data": "codigoUniforme" }
                ,{ "className": "dt-body-center","data": "descripcionTipo" }
                ,{ "className": "dt-body-center","data": "numeroEmpleado" }
                ,{ "data": "nombreEmpleado" }
                ,{ "className": "dt-body-center","data": "fechaRecibido" }
                ,{ "className": "dt-body-center","data": "usuarioRecepcion" } 
                ,{ "data": "incremetBajauniforme" }  
            ] ,
            'columnDefs': [{
                'targets': 6,
                'checkboxes': {
                    'selectRow': true
                }
            }
            ],
            'select': {
                'style': 'multi'
            },
            'order': [[1, 'asc']]
                ,processing: true
                ,dom: 'Bfrtip'
                ,buttons: [
                    'copy', 'excel'
                ]
            } );
        if (tipoRecepcion != 1) {
         var table = $("#listaRecibidosTable").DataTable();
         table.columns([6]).visible(false);
         $("#MuestraSeccionEnvioLavanderiaFolio").css("display","none");

     }else{$("#MuestraSeccionEnvioLavanderiaFolio").css("display","block");
          cargarSelectorEntidades()}
    }else{
        alert('Introduzca rango de fecha');
    }
}
  
function cargarSelectorEntidades(){
    $.ajax({
      type: "POST",
      url: "ajax_getEntidadesUsuario.php",
      dataType: "json",
      success: function(response) {
        //console.log(response.datos);
        $("#selEntidades").empty(); 
        $('#selEntidades').append('<option value="0">Entidad Federativa</option>');
        if (response.status == "success"){
          for (var i = 0; i < response.datos.length; i++){
            $('#selEntidades').append('<option value="' + (response.datos[i].idEntidadFederativa) + '">' + response.datos[i].nombreEntidadFederativa + '</option>');
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

$("#selectTipoReceive").change(function(){
  var tipoRecep = $("#selectTipoReceive").val();
  if(tipoRecep!=1){//lavanderia
     var table = $("#listaRecibidosTable").DataTable();
         table.columns([6]).visible(false);
         $("#MuestraSeccionEnvioLavanderiaFolio").css("display","none");
  }else{
    $("#MuestraSeccionEnvioLavanderiaFolio").css("display","block");
    cargarSelectorEntidades();
  }
});

$("#selEntidades").change(function(){
  var entLav = $("#selEntidades").val();
  if (entLav!=0){
    consultaSucursales(entLav);
  }else{
    $('#selSucursalEnvLavanderia').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
  }
});

function consultaSucursales(entidadElegida){  
    $.ajax({
        type: "POST",
        url: "ajax_SucursalesXentLav.php",
        data:{"EntidadSeleccionada":entidadElegida},
        dataType: "json",
        success: function(response) {
            if (response.status == "success"){
              var sucursal=response.sucursales;
              $('#selSucursalEnvLavanderia').empty().append('<option value="0" selected="selected">SUCURSAL</option>');
              $.each(sucursal, function(i) {
                $('#selSucursalEnvLavanderia').append("<option value='"+sucursal[i].idSucursalI+"' title='"+sucursal[i].nombreSucursal+"'>"+sucursal[i].nombreSucursal+"</option>");
              });
              $('#selSucursalEnvLavanderia').focus();                  
            }else{
              alert(msj);
             }
        },error: function(jqXHR, textStatus, errorThrown){
               alert(jqXHR.responseText); 
         }
    });
}

$('#fechaRecibidos1').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
});

$('#fechaRecibidos2').datetimepicker({
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',
  });

$("#btnEnvioLavanderia").click(function(){
  var idUniformes =tableConsultaReceive.column(6).checkboxes.selected();
  var EntidadesUsuario = $("#selEntidades").val();
  var sucursalUsuario = $("#selSucursalEnvLavanderia").val();
  if(idUniformes.length==0){
      alert("No Has Seleccionado Nada Para El Envio Favor De Revisar");
  }else if(EntidadesUsuario=="" || EntidadesUsuario==0 || EntidadesUsuario==null || EntidadesUsuario=="null" || EntidadesUsuario=="NULL"){
    alert("Seleccione La Entidad De Origen");
  }else if(sucursalUsuario=="" || sucursalUsuario==0 || sucursalUsuario==null || sucursalUsuario=="null" || sucursalUsuario=="NULL"){
    alert("Seleccione La Sucursal De Origen");
  }else{
      consultaUltimoFolio();
    }
});

function consultaUltimoFolio(){
  $("#btnEnvioLavanderia").prop("disabled", true);
  $("#selEntidades").prop("readonly", true);
  $("#selSucursalEnvLavanderia").prop("readonly", true);
  $.ajax({
      type: "POST",
      url: "ajax_consultaUltimoFolioEnvioLavan.php",
      dataType: "json",
      success: function(response) {
        var ultimofolio=response.datos;
        enviarLavan(ultimofolio); 
      },
      error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
      }
  });
}  

function enviarLavan(ultimofolio){
  var idUniformes =tableConsultaReceive.column(6).checkboxes.selected();
  var EntidadesUsuario = $("#selEntidades").val();
  var sucursalUsuario = $("#selSucursalEnvLavanderia").val();
  for(var i=0;i<idUniformes.length;i++){
      var idUni=idUniformes[i];
      // alert(idUni);
    $.ajax({
            type: "POST",
            url: "ajax_enviolavanderia.php",
            data: {
                "idIncrementUniformes": idUni,
                "ultimofolio":ultimofolio,
                "iteracion":i,
                "EntidadesUsuario":EntidadesUsuario,
                "sucursalUsuario":sucursalUsuario
            },
            dataType: "json",
            success: function(response) {
              consultaRecibidos();
              $("#selEntidades").prop("readonly", false);
              $("#selSucursalEnvLavanderia").prop("readonly", false);
              $("#btnEnvioLavanderia").prop("disabled", false); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });
  }
  alert("tu folio generado es: "+ultimofolio);
}
</script>