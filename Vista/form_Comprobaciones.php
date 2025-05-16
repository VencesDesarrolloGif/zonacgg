<!-- <td><label class="control-label1 label" for="fechaIngreso">AAAAAAAAAA</label></td> -->

<form class="form-inline"  method="post" id="form_Comprobaciones"  target="_blank" enctype='multipart/form-data'>
<?php
if ($usuario["rol"] == "Comprobaciones de flujo" || $usuario["rol"] == "Comprobacion Regional") {
    $catalogoTipoMovimientos   = $negocio->negocio_ListaTipoMovimientosFinancieros();
    $catalogoEmpresas          = $negocio->negocio_ListaEmpresas();
    $catalogoBancos            = $negocio->negocio_ListaBancos();
    $catalogoTipoTransacciones = $negocio->negocio_ListaTipoTransacciones();
//$catalogoClavesClasificaciones= $negocio -> negocio_ListaClavesClasificacionesPorTipo(2);
    $catalogoDepartamentos               = $negocio->negocio_obtenerListaDepartamentos();
    $fechaActual                         = $negocio->negocio_consultaFecha();
    $catalogoTipoMovimientoSinObligacion = $negocio->negocio_ListaTipoMovimientosFinancierosSinObligaciones();
    $catalogoEntidadesFederativas        = $negocio->negocio_obtenerListaEntidadesFeferativas();
    $catalogoLineaNegocio                = $negocio->negocio_obtenerListaLineaNegocio();
    $listaBeneficiarios = $negocio->obtenerListaBeneficiarios();
    $listaConceptos     = $negocio->obtenerListaConceptos();
    $catalogoIVA        = $negocio->negocio_obteneriva();
    $fechaActual= $negocio -> negocio_consultaFecha();   
}
?>

<div id='MensajeCompro' ></div>
<div align="center"><br>
  <div id="formComprobacion" style="display: none"><br> 
  <legend>REGISTRO DE MOVIMIENTOS COMPROBACIONES</legend>
<!---------------------------------Comienza primera fila y el Formulario -------------------------------------->
    <div class= "row" >
      <input id="casocomprueba1" name="casocomprueba1" style="display: none" type="int" class="span3" value="0">
       <div id="visualizarpdfCompro"></div>

      <label class="control-label" for="fechaIngresoCompro">Fecha Movimiento</label>
      <input id="fechaMovimientoCompro" name="fechaMovimientoCompro" readonly="readonly" type="date" class="span3" value= <?php echo $fechaActual['0']["fechaActual"]; ?>>
      <input id="impid" name="impid" readonly="readonly"  style="display: none" type="text" class="span3" >

      <label class="control-label" for="lbltotalacomprobar">Total A Comprobar</label>
      <input id="imptotalacomprobar" name="imptotalacomprobar" readonly="readonly"type="text" class="span3" >

      <label id="ReembolsoCompro1" name="ReembolsoCompro1"class="control-label label" for="ReembolsoCompro" style="display: none">Reembolso a Caja</label>
      <input id="ReembolsoCompro" name="ReembolsoCompro" type="checkbox" class="material-switch pull-center" value="0" style="display: none">

      <label class="control-label label" for="lblCLienteCaja1Compro" id="lblCLienteCaja1Compro" style="display: none">Encargado Caja</label>
      <select id="selectCLienteCajaCompro" name="selectCLienteCajaCompro" class="span3" style="display: none">
      <option value="0">Elije Empleado</option><br>
      </select>
    </div>  
<!---------------------------------Termina Primera Fila y Comienza Segunda Fila--------------------------------------><br>
    <div class= "row">
      <label class="control-label" for="lblLineaNegocioCompro">Linea de Negocio</label>
      <select id="selectLineaNegocioCompro" name="selectLineaNegocioCompro" class="span3" onChange="">
        <option value="0">LINEA NEGOCIO</option>
          <?php
          for ($i = 0; $i < count($catalogoLineaNegocio); $i++){
              echo "<option value='" . $catalogoLineaNegocio[$i]["idLineaNegocio"] . "'>" . $catalogoLineaNegocio[$i]["descripcionLineaNegocio"] . " </option>";
          }
          ?>
      </select>
     
      <label class="control-label" for="lblclaveClasificacion">Clave Categoria</label>
       <input id="selectClaveClasificacionCompro" name="selectClaveClasificacionCompro"  type="text" class="span3">
      <!--<select id="selectClaveClasificacionCompro" name="selectClaveClasificacionCompro" class="span3" >
        <option value="0">CLAVES</option>
      </select>-->
  
      <label class="control-label" for="lblEmpresaCompro">Empresa</label>
        <select id="selectEmpresaCompro" name="selectEmpresaCompro" class="span3" onChange="">
          <option value="0">EMPRESA</option>
          <?php
            for ($i = 0; $i < count($catalogoEmpresas); $i++) {
              echo "<option value='" . $catalogoEmpresas[$i]["idEmpresa"] . "'>" . $catalogoEmpresas[$i]["nombreEmpresa"] . " </option>";
            }
          ?>
        </select>
    </div>
<!---------------------------------Termina Segunda Fila y Comienza Tercera Fila--------------------------------------><br>
    <div class= "row">
      <label class="control-label" for="lblTipoDeBancoCompro">Tipo De Banco</label>
      <input id="impBancocomprueba" name="impBancocomprueba" style="display: none" type="text" class="span3">

      <select id="selectTipoDeBancoCompro" name="selectTipoDeBancoCompro" style="display: none" class="span3" onChange="">
        <option value="0">Banco</option>
        <?php
          for ($i = 0; $i < count($catalogoBancos); $i++){
          echo "<option value='" . $catalogoBancos[$i]["idBanco"] . "'>" . $catalogoBancos[$i]["nombreBanco"] . " </option>";}
        ?>
      </select>

      <label class="control-label" for="lblNumCuentaCompro">Numero De Cuenta</label>
      <input id="impNumCuentaCompro" name="impNumCuentaCompro" style="display: none" type="text" class="span3" >
      <select id="selectNumCuentaCompro" name="selectNumCuentaCompro" style="display: none" class="span3" onChange="">
        <option value="0"></option>
      </select>

      <label class="control-label" for="lblTransaccionCompro">Tipo Transaccion</label>
        <select id="selectTipoTransaccionCompro" name="selectTipoTransaccionCompro" class="span3" onChange="">
          <option value="0">TIPO TRANSACCION</option>
          <?php
            for ($i = 0; $i < count($catalogoTipoTransacciones); $i++){
               echo "<option value='" . $catalogoTipoTransacciones[$i]["idTipoTransaccion"] . "'>" . $catalogoTipoTransacciones[$i]["descripcionTransaccion"] . " </option>";
            }
          ?>
        </select>
    </div>
<!---------------------------------Termina Tercera Fila y Comienza Cuarta Fila--------------------------------------><br>
    <div class= "row">
      <label class="control-label" for="lblDepartamentoCompro">Departamento </label>
        <select id="selectDepartamentoCompro" name="selectDepartamentoCompro" class="span3" onChange="">
          <option value="0">DEPARTAMENTO</option>
          <?php
            for ($i = 0; $i < count($catalogoDepartamentos); $i++){
              echo "<option value='" . $catalogoDepartamentos[$i]["idDepto"] . "'>" . $catalogoDepartamentos[$i]["nombreDepto"] . " </option>";
            }
          ?>
        </select>

      <label class="control-label" for="lblSubDepartamentoCompro">Sub Departamento </label>
        <select id="selectSubDepartamentoCompro" name="selectSubDepartamentoCompro" class="span3" onChange="">
          <option value="0"> SUB DEPARTAMENTO</option>
        </select>

      <label class="control-label" for="lblEntidadesCompro">Entidad</label>
        <select id="selectEntidadesCompro" name="selectEntidadesCompro" class="span3" onChange="">
          <option value="0">ENTIDAD</option>
          <?php
            for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++){
              echo "<option value='" . $catalogoEntidadesFederativas[$i]["idEntidadFederativa"] . "'>" . $catalogoEntidadesFederativas[$i]["nombreEntidadFederativa"] . " </option>";
            }
          ?>
        </select>
    </div>
<!----------------------Termina Cuarta Fila y Comienza Quinta Fila En Div Interno Primera Fila Para La Tabla ----------------------------><br>
<div id="formComprobaciontabla" name="formComprobaciontabla"><br>
        <div class= "row">
          <label class="control-label" for="lblBeneficiario">Beneficiario </label>
          <input id="impBeneficiarioCompro" name="impBeneficiarioCompro" type="text" class="span3">

          <label class="control-label" for="lblConceptoCompro">Concepto</label>
          <input id="impConceptoCompro" name="impConceptoCompro" type="text" class="span3">
    
          <label class="control-label" for="lblreferenciaCompro"># Referencia </label>
          <input id="impNumeroReferenciaCompro" name="impNumeroReferenciaCompro" type="text" class="span3">
        </div>
<!-------------------------Termina Quinta Fila y Comienza Sexta Fila Segunda Fila De La Tabla---------------------------------><br> 
        <div class= "row">
          <label class="control-label" for="lblsubtotalCompro">Sub Total</label>
          <input id="impSubTotalCompro" name="impSubTotalCompro" type="text" class="span3" onblur="sumatoriaComprobacion();" >
    
          <label class="control-label" for="lblDescuentoCompro">Descuento</label>
          <input id="impDescuentoCompro" name="impDescuentoCompro" type="text" class="span3" onblur="sumatoriaComprobacion();" >

          <label class="control-label" for="lblIvaRetenidoCompro">Iva Retenido </label>
          <input id="impIvaRetenidoCompro" name="impIvaRetenidoCompro" type="text" class="span3" onblur="sumatoriaComprobacion();" >
        </div>
<!-------------------------Termina Sexta Fila y Comienza Septima Fila Tercera Fila De La Tabla-----------------------------------><br>  
        <div class= "row">
          <label class="control-label" for="lblIvaCompro">Tasa De Iva </label>
          <select id="selectIvaCompro" name="selectIvaCompro" class="span3" onChange="" onblur="sumatoriaComprobacion();"> 
            <option value="0">ELIJA EL IVA</option>
            <?php
             for ($i = 0; $i < count($catalogoIVA); $i++){
             echo "<option value='" . $catalogoIVA[$i]["valor"] . "'>" . $catalogoIVA[$i]["descripcionIva"] . " </option>";
             }
            ?>
          </select>
          
          <label class="control-label" for="lblTotalCompro">Total </label>
          <input id="impTotalCompro" name="impTotalCompro" type="text" class="span3" readonly="true">     
          
        </div>
<!---------------------------------Termina Septima Fila  y Comienza Boton de Agregar ----------------------------------><br>
        <div class= "row">
 

  
          <button id="btnAgregarCompro" name="btnAgregarCompro" class="btn btn-primary" type="button" onclick="agregaratablaCompro();"><span class="glyphicon glyphicon-floppy-save"></span>Agregar</button><br>    

            

        </div><br>
      </div>
<!-----------------------------Termina termina Boton De Agregar y Comienza La Tabla -------------------------------------->
      <div id="tablaCreadaComprobacion" name="tablaCreadaComprobacion" >
        <table id='tablaComproba' class='table table-bordered'>
          <thead>
            <th>N°</th>
            <th>#REFERENCIA</th>
            <th>BENEFICIARIO</th>
            <th>CONCEPTO</th>
            <th>SUB TOTAL</th>
            <th>DESCUENTO</th>
            <th>IVA RETENIDO</th>
            <th>TASA DE IVA</th>
            <th>TOTAL</th>
            <th>SUBIR ARCHIVO</th>

          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div id="totaldetotalesComprueba" style="margin-right: -51%; display: none">
        <label class="control-label" for="Totales1">TOTAL COMPROBADO </label>
        <input class="span2" id="Totales1" name="Totales1" type="text"  readonly="readonly" >
      </div>
<!-------------------------------Termina La Tabla y Comienza Y Botones De Guardar Y Cancelar------------------------------><br>  
      <div class= "row">
        <button id="btnGuardarCompro" name="btnGuardarCompro" class="btn btn-primary" type="button" onclick="guardarMovimientoComprobaciones();"> <span class="glyphicon glyphicon-floppy-save"></span>Guardar</button>      
 
        <button id="btnCancelarCompro" name="btnCancelarCompro" class="btn btn-danger" type="button" onclick="formComprobaciones1();" > <span class="glyphicon glyphicon-remove"></span>Cancelar</button>
      </div><br>
    </div>
  </div>
 <!--------------------------------------- Terminan Los Botones y El </div> prueba modal --><br>
  <div id="comprobacionesconysinsolicitud" name="comprobacionesconysinsolicitud"></div>
  <br>
  <input class="span8" id="hdnrolusuario" name="hdnrolusuario" type="hidden"  readonly="readonly" value= "<?php echo $usuario["rol"]; ?>"  > 
  <a  id="listacon" onclick=" creartablablaComprobacionconysinsolicitud(0);" style="cursor: pointer" data-toggle="tab">LISTA DE COMPROBACIONES POR SOLICITUD</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  <a id="listasin" onclick=" creartablablaComprobacionconysinsolicitud(1);" style="cursor: pointer" data-toggle="tab">LISTA DE COMPROBACIONES SIN SOLICITUD</a>
  <div id='tiComprobacionPorSolicitud' name="tituloComprobacionPorSolicitud" style="display:none">
  <center><h3>LISTA DE COMPROBACIONES POR SOLICITUD</h3><h5 style="display:none" id="tituloComprobacionPorSolicitud"></h5></center>
  </div>
  <div id='tiComprobacionSinSolicitud' name="tiComprobacionSinSolicitud" style="display:none">
  <center><h3>LISTA DE COMPROBACIONES SIN SOLICITUD</h3><h5 style="display:none" id="tituloComprobacionSinSolicitud"></h5></center>
  </div>  
    <section>
    <div id="muestratablaComprobacionconysinsolicitud" style="display:none; max-width: 110rem;">
      <table id="tablaComprobacionconysinsolicitud"  width="100%">
        <thead>
          <tr>
            <th style="text-align: center;background-color: #85CFE9">Estatus </th>
            <th style="text-align: center;background-color: #85CFE9">Folio </th>
            <th style="text-align: center;background-color: #85CFE9">Fecha Del Abono</th>
            <th style="text-align: center;background-color: #85CFE9">Clave De Clasificación</th>
            <th style="text-align: center;background-color: #85CFE9">Beneficiario</th>
            <th style="text-align: center;background-color: #85CFE9">Concepto</th>
            <th style="text-align: center;background-color: #85CFE9">Total A Comprobar</th>
            <th style="text-align: center;background-color: #85CFE9">Comprobar</th>
           </tr> 
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </section> 

 <div id="tblconceptoscomprueba" name="tblconceptoscomprueba">
</div>
</form>

<!-------------estilos  tanto de la tabla como del formulario------------>
  <style>
  #formComprobacion {
    padding: 0px;
    width:1550px;
    background-color:#efefef;
    display:inline-block;
    position:padding-left;
    border: 4px solid;
    border-radius: 55px;
  }

    #formComprobaciontabla {
    padding: 5px;
    width:1000px;
    background-color:#efefef;
    display:inline-block;
    position:padding-left;
    border: 4px solid;
    border-radius: 55px;
  }
</style> 
<script type="text/javascript">
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioActSPS());  

function inicioActSPS(){
    var rolUsuario=$("#hdnrolusuario").val();
    if(rolUsuario=="Comprobacion Regional"){
          $("#listasin").hide("swing");
    } 
}
/*---------------------------- Funcion Que Crea La Tabla Dependiendo El Click Si Es 0 u 1-------------------------------------*/
function creartablablaComprobacionconysinsolicitud(caso1){
  $("#casocomprueba1").val(caso1);
  var caso=$("#casocomprueba1").val();
  tableComprobacionconysinsolicitud = [];

  //alert(caso);
    $.ajax({
      type: "POST",
      url: "ajax_consultartablaComprobacionconysinsolicitud.php",
      data:{"caso": caso},
      dataType: "json",
      success: function(response) 
      {
        //console.log(response);
        if (response.status == "success") 
        {
          $("#muestratablaComprobacionconysinsolicitud").show();
          if (caso==0){
            $("#tiComprobacionPorSolicitud").show();
            $("#tiComprobacionSinSolicitud").hide();
          }else{
             $("#tiComprobacionSinSolicitud").show();
             $("#tiComprobacionPorSolicitud").hide();
            }
          for (var i = 0; i < response.datos.length; i++) 
          {
            var record = response.datos[i];
            tableComprobacionconysinsolicitud.push(record);
          }
          loadDataInTableComprobacionconysinsolicitud(tableComprobacionconysinsolicitud);
        } 
        else 
        {
          var mensaje = response.message;
        }
      },
      error: function(jqXHR, textStatus, errorThrown) 
      {
        alert(jqXHR.responseText);
      }
    });

}
/*---------------------------- Funcion Que Llena La Tabla Dependiendo El Click Si Es 0 u 1-------------------------------------*/
var tablecomprobacionconysinsolicitud = null;
 function loadDataInTableComprobacionconysinsolicitud(data) {
     if (tablecomprobacionconysinsolicitud != null) {
         tablecomprobacionconysinsolicitud.destroy();
     }
     tablecomprobacionconysinsolicitud = $('#tablaComprobacionconysinsolicitud').DataTable({
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
             "data": "Estatus"
         },{
             "data": "Folio"
         },{
             "data": "Fecha"
         },{
             "data": "Clave"
         },{
             "data": "Beneficiario"
         },{
             "data": "Concepto"
         },{
             "data": "Total"
         },{
             "data": "Comprobar"
         },],

         processing: true,
         dom: 'Bfrtip',
         buttons: ['excel']
     }); 
 }
/*---------------------------- Funcion Que Llena El Formulario Dependiendo De El Click Si Es 0 u 1-------------------------------------*/
function comprobarComprobacionconysinsolicitud(Linea,ClaveC,Banco,Cuenta,Transaccion,Departamento,SubDepartamento,Empresa,Entidad,total1,folio)
{    
  $("#listacon").hide();
  $("#listasin").hide();
  $("#tiComprobacionPorSolicitud").hide();
  $("#tiComprobacionSinSolicitud").hide();
  $("#muestratablaComprobacionconysinsolicitud").hide();
  $("#impBancocomprueba").show();
  $("#impNumCuentaCompro").show();
  $("#selectLineaNegocioCompro").val(Linea);
  $("#selectDepartamentoCompro").val(Departamento);
  $("#imptotalacomprobar").val(total1);
  $("#impid").val(folio);
//  obtenerListaClavesComprobacion();
  obtenersubdepartamentoscomprobacion();
  $("#formComprobacion").show();
  $("#selectClaveClasificacionCompro").val(ClaveC);
  $("#impBancocomprueba").val(Banco);
  $("#impNumCuentaCompro").val(Cuenta);
  $("#selectTipoTransaccionCompro").val(Transaccion);
  $("#selectSubDepartamentoCompro").val(SubDepartamento);
  $("#selectEmpresaCompro").val(Empresa);
  $("#selectEntidadesCompro").val(Entidad);
  $("#formComprobacion").show("Slide");
  $("#tblconceptoscomprueba").hide();
  $('#selectLineaNegocioCompro').prop('disabled', true);
  $('#selectClaveClasificacionCompro').prop('disabled', true);
  $('#impBancocomprueba').prop('disabled', true);
  $('#impNumCuentaCompro').prop('disabled', true);
  $('#selectTipoTransaccionCompro').prop('disabled', true);
  $('#selectDepartamentoCompro').prop('disabled', true);
  $('#selectSubDepartamentoCompro').prop('disabled', true);
  $('#selectEmpresaCompro').prop('disabled', true);
  $('#selectEntidadesCompro').prop('disabled', true);
  //$('#impTotalCompro').prop('readonly', false);
}

/*------------------Función Que Muestra El Selector Del Cliente-----------*/
$('#ReembolsoCompro').change(function()
{
   $('#selectLineaNegocioCompro').val(0);
      $('#selectClaveClasificacionCompro').empty();
  if($('#ReembolsoCompro').is(":checked"))
   {      
      $('#ReembolsoCompro').val(1);
      $('#lblCLienteCaja1Compro').show("swing");
      $('#selectCLienteCajaCompro').show( "swing");
      cargaselclientecaja1();
   }
  else
   {
      $('#ReembolsoCompro').val(0);

      $('#lblCLienteCaja1Compro').hide("swing");
      $('#selectCLienteCajaCompro').hide("swing");
      $('#visualizarpdfCompro').hide("swing");
   }
});
/*------------------Función Que Carga El Selector Del Cliente-----------*/
function cargaselclientecaja1()
{
  var valorCliente=$("#ReembolsoCompro").val();
  var lblCLienteCaja=$("#selectCLienteCajaCompro").val();
  if(valorCliente!=0){
   $.ajax(
   {
    type: "POST",
    url: "ajax_ObtenerListaEmpleadosCaja.php",
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,        
    //una vez finalizado correctamente
    success: function(response) {
    //console.log(response);
      var datos = response.datos;
      $('#selectCLienteCajaCompro').empty().append('<option value="0" selected="selected">Empleado</option>');
      $.each(datos, function(i) {
        $('#selectCLienteCajaCompro').append('<option value="'+datos[i].EntidadEmpCaja+datos[i].consecutivoEmpCaja+datos[i].categoriaEmpCaja+'">' + datos[i].nombre+ '</option>');
      });  
      if($('#selectCLienteCajaCompro option').length === 1){
      // de no quedar opciones disponibles en el selector de servicios (solo existiria la opción 0), limpio la lista y coloco una opcion 0 con un mensaje.
        $('#selectCLienteCajaCompro').empty().append('<option value="0" selected="selected">No hay Empleados Asignados</option>');
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
          
   }); 
  }
   else
  {
  $('#selectCLienteCajaCompro').empty();
  }
}
/*------------------Función Que Realiza Las Operaciones Del TOtal Ingresado-----------*/
function sumatoriaComprobacion()
{
  var subtotales=$("#impSubTotalCompro").val();
  var descuentos=$("#impDescuentoCompro").val();
  var ivaporcent=$("#selectIvaCompro").val();
  var ivareten=$("#impIvaRetenidoCompro").val();
  var subtotalesint=parseFloat(subtotales);
  var descuentosint=parseFloat(descuentos);
  var ivaporcentint=parseFloat(ivaporcent);
  var ivaretenint=parseFloat(ivareten);
  if(subtotales=="" || descuentos=="" || ivareten=="" ){
   $("#impTotalCompro").val('');
  }
  else{
    var sumatoria=(subtotalesint-descuentosint);
    var resustaldoiva= (sumatoria*ivaporcentint);
    var resultadosumatoria= (sumatoria+resustaldoiva);
    var resultadototalparcial= (resultadosumatoria-ivaretenint); 
    var resultadototal= (resultadototalparcial).toFixed(2.5);
  }
  $("#impTotalCompro").val(resultadototal);
}
/*------------------Función Que Realiza La Seleccion De Las CLaves Por Linea De Negocio-----------*/
//$("#selectLineaNegocioCompro").change(function()
function obtenerListaClavesComprobacion() {
  var check = $("#ReembolsoCompro").val();
  var valorClaves  =  $("#selectLineaNegocioCompro").val();
  if(valorClaves!=0 ){
    $.ajax({
      type: "POST",
      url: "ajax_obtenerListaClavesPorTipoMovimiento.php",
      data: {"valorClaves": valorClaves,
              "check": check},
      dataType: "json",
      async:false,
      success: function(response) {
        var datos = response.listaClavesPorTipoMovimiento;
       // console.log(datos);
        $('#selectClaveClasificacionCompro').empty().append('<option value="0" selected="selected">Claves</option>');
        $.each(datos, function(i) {
          $('#selectClaveClasificacionCompro').append('<option value="' + datos[i].claveClasificacion + '">' + datos[i]. claveClasificacion+":  "+datos[i].descripcionClasificacion+ '</option>');
        });     
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });  
  }
  else{$('#selectClaveClasificacionCompro').empty();}
}
/*------------------Función Que Realiza La Seleccion De Las Cuentas Bancarias De Cada Banco---------------*/
$("#selectTipoDeBancoCompro").change(function(){
  var valorselectorbanco  =  $("#selectTipoDeBancoCompro").val();
  if(valorselectorbanco!=0){
    $.ajax({
      type: "POST",
      url: "ajax_listaCuentasBancarias.php",
      data:{"valorselectorbanco":valorselectorbanco},
      dataType: "json",
      success: function(response) {
      //  console.log(response);
        var datos = response.datos;
        $('#selectNumCuentaCompro').empty().append('<option value="0" selected="selected">Cuenta</option>');
        $.each(datos, function(i) {
          $('#selectNumCuentaCompro').append('<option value="' + response.datos[i].idCuentaBancaria+ '">' + response.datos[i].numCuenta + '</option>');
        });     
      },
      error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
      }
    });  
  }
  else{$('#selectNumCuentaCompro').empty();} 
});
/*------------------Función Que Realiza La Seleccion De Los Sub Departamentos Por Cada Departamento ---------------*/
//$("#selectDepartamentoCompro").change(function()
  function obtenersubdepartamentoscomprobacion(){
  var valorsubdepartamento  =  $("#selectDepartamentoCompro").val();
  if(valorsubdepartamento!=0){
    $.ajax({
      type: "POST",
      url: "ajax_listaSubDepartamentos.php",
      data:{"valorsubdepartamento":valorsubdepartamento},
      dataType: "json",
      async:false,
      success: function(response) {
        var datos = response.datos;
        $('#selectSubDepartamentoCompro').empty().append('<option value="0" selected="selected">Sub Departamento</option>');
        $.each(datos, function(i) {
          $('#selectSubDepartamentoCompro').append('<option value="' + response.datos[i].idSubDepto+ '">' + response.datos[i].nombreSubDepto+ '</option>');
        });     
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
      }
    });  
  }
  else{$('#selectSubDepartamentoCompro').empty();}
}
/*------------------Función Que Carga y Guarda El Pdf En Una Ruta Predeterminada-------------------- ---------------*/
function enviarPdfComprobaciones(i,idMovCompro){
  var fechamov=$("#fechaMovimientoCompro").val();
  var impid=$("#impid").val();
  var NombreUsuario= 1;

  //información del formulario
  var formData = new FormData($("#form_Comprobaciones")[0]);   
  formData.append('fechamov', fechamov);
  formData.append('NombreUsuario', NombreUsuario);
  //formData.append('fileDocPdfCompro', fileDocPdfCompro);
  formData.append('impid', impid);
  formData.append('i', i);
  formData.append('idMovCompro', idMovCompro);
 // hacemos la petición ajax  
  for (var value of formData.values()) {
  }   
  $.ajax({
    type: "POST",
    url: "upload_ArchivoComprobaciones.php",
    data:formData,
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,        
    //una vez finalizado correctamente
    success: function(response) {
    //  console.log(response);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
/*------------------Función Que Guarda Todos Los Movimientos Y Realiza las Validaciones ---------------*/

function guardarMovimientoComprobaciones()
{

  $("#Mensaje").removeClass('alert alert-error').html('');
    var tabla1 = $("#tablaComproba tr").length;
    var impid= $("#impid").val();
    if(tabla1==1){
       cargaerroresCompro('Agrege Un Registro');
    }else{

    var inBeneficiarioCompro    = Array();
    var inConceptoCompro        = Array();
    var inNumeroReferenciaCompro= Array();
    var inSubTotalCompro        = Array();
    var inDescuentoCompro       = Array();
    var inIvaRetenidoCompro     = Array();
    var inselectIvaCompro       = Array();
    var inTotalCompro           = Array();
    var fileDocPdfCompro      = Array();

    var bandera=true;
   for (var i=0; i<tabla1-1;i++) 
    {
      inBeneficiarioCompro[i]    =$("#inBeneficiarioCompro" + i).val();
      inConceptoCompro[i]        =$("#inConceptoCompro" + i).val();
      inNumeroReferenciaCompro[i]=$("#inNumeroReferenciaCompro" + i).val();
      inSubTotalCompro[i]        =$("#inSubTotalCompro" + i).val();
      inDescuentoCompro[i]       =$("#inDescuentoCompro" + i).val();
      inIvaRetenidoCompro[i]     =$("#inIvaRetenidoCompro" + i).val();
      inselectIvaCompro[i]       =$("#inselectIvaCompro" + i).val();
      inTotalCompro[i]           =$("#inTotalCompro" + i).val();
      fileDocPdfCompro[i]        =$("#fileDocPdfCompro" + i).val(); 

        if(fileDocPdfCompro[i]==""){
          bandera=false;
          cargaerroresCompro('Seleccione El Archivo Del Registro: ' + (i+1));
          break;
          }
    }
    if(bandera){
    $.ajax
    ({
      type: "POST",
      url: "ajax_RegistroMovimientoComprobaciones.php",
      data: 
      { 'impid': impid,
        'inBeneficiarioCompro': inBeneficiarioCompro,    
        'inConceptoCompro': inConceptoCompro,        
        'inNumeroReferenciaCompro': inNumeroReferenciaCompro,
        'inSubTotalCompro': inSubTotalCompro,        
        'inDescuentoCompro': inDescuentoCompro,       
        'inIvaRetenidoCompro': inIvaRetenidoCompro,     
        'inselectIvaCompro': inselectIvaCompro,       
        'inTotalCompro': inTotalCompro,              
      },

      dataType: "json",
       success: function(response) {

              //console.log(response);
              var estatus=response.status;
              var mensaje=response.message;
              if(estatus!="error"){
                for (var i=0; i<tabla1-1;i++){
                var idMovCompro=response.idMovimientoCompro[i];
                enviarPdfComprobaciones(i,idMovCompro);
                }
                actualizarestatusmovimiento();
                showMessageCompro (mensaje, response.status);
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
      });
  }
 }
}
/*----------FUNCION QUE ACTUALIZA EL ESTATUS QUE DE LIBROMOVIMIENTOS EL MISMO QUE MUESTRA LA TABLA INICIAL-------------*/
function actualizarestatusmovimiento(){
  var casoactulizar=$("#casocomprueba1").val();
  var idlibromovimientos=$("#impid").val();
  //alert(idlibromovimientos);
  $.ajax({
    type: "POST",
    url: "ajax_UpdateestatusmovimientoComprobaciones.php",
    data:{"idlibromovimientos":idlibromovimientos,"casoactulizar":casoactulizar},
    dataType: "json",       
    //una vez finalizado correctamente
    success: function(response) {
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
}
/*-------------------------------FUNCIÓN QUE CREA LA TABLA CON LOS DATOS INGRESADOS -----------------------------------*/

function agregaratablaCompro() 
{
  $("#MensajeCompro").removeClass('alert alert-error').html(''); 
  var impBeneficiarioCompro=$("#impBeneficiarioCompro").val();
  var impConceptoCompro=$("#impConceptoCompro").val();
  var impNumeroReferenciaCompro=$("#impNumeroReferenciaCompro").val();
  var impSubTotalCompro=$("#impSubTotalCompro").val();
  var impDescuentoCompro=$("#impDescuentoCompro").val();
  var impIvaRetenidoCompro=$("#impIvaRetenidoCompro").val();
  var iva= $('select[name="selectIvaCompro"] option:selected').text();   //$("#selectIvaCompro").val(); // cambiar por el texto
  var selectIvaCompro=$("#selectIvaCompro").val();
  var impTotalCompro=$("#impTotalCompro").val(); 

  
  if (impBeneficiarioCompro=="") {
  cargaerroresCompro('Ingrese El Beneficiario');
  }
  else if (impConceptoCompro=="") {
  cargaerroresCompro('Ingrese El Concepto');
  } 
  else if (impNumeroReferenciaCompro=="" || !/^([A-Z-a-z-0-9\-])*$/.test(impNumeroReferenciaCompro)) {
  cargaerroresCompro('Ingrese El Numero De Referencia Correcto'); 
  }
  else if(!verificaReferncia(1)){
    cargaerroresCompro('El Numero De Referencia Ya Se Registro Previamente');
  }
  else if (impSubTotalCompro=="" || !/^(([0-9]+)?(.[0-9]+)?)$/.test(impSubTotalCompro)) {
  cargaerroresCompro('Ingrese El Sub Total');
  }
  else if (impDescuentoCompro=="" || !/^(([0-9]+)?(.[0-9]+)?)$/.test(impDescuentoCompro)) {
  cargaerroresCompro('Ingrese El Desacuento');
  }
  else if (impIvaRetenidoCompro=="" || !/^(([0-9]+)?(.[0-9]+)?)$/.test(impIvaRetenidoCompro)) {
  cargaerroresCompro('Ingrese El Iva Retenido');
  }
  /*else if (selectIvaCompro==="0") {
  cargaerroresCompro('Seleccione El Iva');
  }*/
  else if (impTotalCompro==="0") {
  cargaerroresCompro('Ingrese El Total');
  }
  else
  {
    if(verificaReferncia(2))
    {
      var b = $("#tablaComproba tr").length;
      var table = document.getElementById("tablaComproba");
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
      for (var i = 0; i < b; i++) 
      {
        contfila.innerHTML = " <td > " + (i + 1) + " </td>";
        cell1.innerHTML = "<input class='span2' id='inNumeroReferenciaCompro" + i + "' type='text' readonly>";
        cell2.innerHTML = "<input class='span2' id='inBeneficiarioCompro" + i + "' type='text' readonly>";
        cell3.innerHTML = "<input class='span2' id='inConceptoCompro" + i + "' type='text' readonly>";
        cell4.innerHTML = "<input class='span2' id='inSubTotalCompro" + i + "' type='text' readonly>";
        cell5.innerHTML = "<input class='span2' id='inDescuentoCompro" + i + "' type='text' readonly>";
        cell6.innerHTML = "<input class='span2' id='inIvaRetenidoCompro" + i + "' type='text' readonly>";
        cell7.innerHTML = "<input class='span2' id='inselectIvaCompro" + i + "' type='text'readonly>";
        cell8.innerHTML = "<input class='span2' id='inTotalCompro" + i + "' type='text' readonly>";
        cell9.innerHTML = "<input class='span2' id='fileDocPdfCompro" + i + "'   name='fileDocPdfCompro"+i+"[]'  type='file' accept='.pdf' >";
      }
      $("#totaldetotalesComprueba").show();
      $("#inBeneficiarioCompro"+(b-1)).val(impBeneficiarioCompro);
      $("#inConceptoCompro"+(b-1)).val(impConceptoCompro);
      $("#inNumeroReferenciaCompro"+(b-1)).val(impNumeroReferenciaCompro);
      $("#inSubTotalCompro"+(b-1)).val(impSubTotalCompro);
      $("#inDescuentoCompro"+(b-1)).val(impDescuentoCompro);
      $("#inIvaRetenidoCompro"+(b-1)).val(impIvaRetenidoCompro);
      $("#inselectIvaCompro"+(b-1)).val(selectIvaCompro);
      $("#inTotalCompro"+(b-1)).val(impTotalCompro);
      $("#fileDocPdfCompro"+(b-1)).val();
      var suma1=0;
      for (var i = 0; i < b; i++) 
      {
       var a=$("#inTotalCompro"+i).val();
       var a1=parseFloat(a);
       var suma1=(a1+=suma1);
      }
      $("#Totales1").val(suma1);
      $("#impBeneficiarioCompro").val("");
      $("#impConceptoCompro").val("");
      $("#impNumeroReferenciaCompro").val("");
      $("#impSubTotalCompro").val("");
      $("#impDescuentoCompro").val("");
      $("#impIvaRetenidoCompro").val("");
      $("#selectIvaCompro").val("0");//AQUI ES EK DEK IVA
      $("#impTotalCompro").val("");
      $("#fileDocPdfCompro").val("");  
    }
    else
    {
      cargaerroresCompro('El Numero De ReferenciaAcaba De Ser Agregado Por Favor Verifique');
    }
  }
}
function verificaReferncia(parametro)
{
  var tamañoReferencia = $("#tablaComproba tr").length;
  var numreferencia=$("#impNumeroReferenciaCompro").val();
  var bandera=true;
  if(parametro==1)
  {
    $.ajax({
        type: "POST",
        url: "ajax_validacionreferenciacomprobacion.php",
        data:{"numreferencia":numreferencia},
        dataType: "json",       
        success: function(response) {
          console.log(response);
          if(response.status=="error"){
            bandera=false;
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.responseText);
        }
    }); 
  
  } else
  {
    for(var k = 0; k < tamañoReferencia; k++)
    {
      var imput=$("#inNumeroReferenciaCompro"+k).val();
      if(numreferencia==imput)
        {
          bandera=false;
          break;
        }
    }
  }
 
  return bandera;
}


/*-------------------------------FUNCIÓN QUE SELECCIONA EL BANCO  Y CARGA LAS CUANTAS POR BANCO -----------------------------------*/

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

/*------------------Función Quecancela Toda La opercion Y Regresa Al Formulario Inicial ---------------*/
function formComprobaciones1 ()
  { 
      var b = $("#tablaComproba tr").length;
    for(var i=b; i>1; i-- )
     {var table = document.getElementById("tablaComproba").deleteRow(1);}

    var caso2=$("#casocomprueba1").val();
    creartablablaComprobacionconysinsolicitud(caso2);
    $('#form_Comprobaciones')[0].reset();
    $("#totaldetotalesComprueba").hide("Slide");
    $("#formComprobacion").hide("Slide");
    $("#listasin").show("Slide");
    $("#listacon").show("Slide");
  }
/*-----------------FUNCION QUE CARGA LOS ERRORES -------------------------------------------------------*/
  function cargaerroresCompro(mensaje){
  alertMsj1="<div class='alert alert-error' id='Mensaje'>"+mensaje+"<data-dismiss='alert'>";
  $("#MensajeCompro").html(alertMsj1);
  $(document).scrollTop(0);
}
/*----------------------------Función Carga Y Muestra Los Errores ---------------------- ---------------*/
  
   function showMessageCompro (mensaje, status)
{
    $("#msg").show ();
    if (status=="success") 
    {
        alertMsg1="<div class='alert alert-success' id='msg'>"+mensaje+"<data-dismiss='alert'>";

        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msg').delay(4000).fadeOut('slow');

        var b = $("#tablaComproba tr").length;
        for(var i=b; i>1; i-- )
        {var table = document.getElementById("tablaComproba").deleteRow(1);}

        var cas2=$("#casocomprueba1").val();
        creartablablaComprobacionconysinsolicitud(cas2);
        $('#form_Comprobaciones')[0].reset();
        $("#totaldetotalesComprueba").hide("Slide");
        $("#formComprobacion").hide("Slide");
        $("#listasin").show("Slide");
        $("#listacon").show("Slide");
    } 
    else if (status=="error")
    {
        alertMsg1="<div class='alert alert-error' id='msg'><strong>Error en el registro de movimiento: </strong>"+mensaje+" <data-dismiss='alert'>";
        $("#alertMsg").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msg').delay(4000).fadeOut('slow');
    }

}
  </script>










