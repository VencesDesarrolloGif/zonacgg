<?php
  $registrosDeClientes = $negocio -> negocio_getRegistrosByCliente($cliente);  

?>
<div align="center">
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Pago SUA</h4></div>
	  <select id="selanio" name="selanio" class="input-large"></select>
    <select id="selmes" name="selmes" class="input-large" style="display:none;"></select>
    <select id="selectReg" name="selectReg" class="input-large" onchange="obtenerArchivosSua()" style="display:none;">
    </select>        

    <div class="card-body text-primary">      	
          <div id="divSua"></div>      
    </div>            
    
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Formato Capacitacíón</h4></div>
    <div class="card-body text-primary">        
          <span class="btn btn-success btn-file" onclick="descargarCapacitacion();">
            <!--<a href='download_pagoSua.php'><img src='img/pdf.png' height='24px' width='24px'/></a>-->
            <a href='#'><img src='img/pdf.png' height='24px' width='24px'/></a>
          </span>      
    </div>            
    
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Permiso Federal</h4></div>
    <div class="card-body text-primary">        
          <span class="btn btn-success btn-file" onclick="descargarPermiso();">
            <!--<a href='download_pagoSua.php'><img src='img/pdf.png' height='24px' width='24px'/></a>-->
            <a href='#'><img src='img/pdf.png' height='24px' width='24px'/></a>
          </span>      
    </div>            
    
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Permiso Local</h4></div>
    <select id="slEntidadPL" name="slEntidadPL" class="input-large">
                <option value="">ENTIDAD</option>
                        <?php                        
                for ($i = 0; $i < count($entidadesCliente); $i++) {    
                        echo "<option value='" . $entidadesCliente[$i]["idEntidadFederativa"] . "'>" . $entidadesCliente[$i]["nombreEntidadFederativa"] . " </option>";    
                }
                      ?>
              </select>
    <div class="card-body text-primary">        
          <span class="btn btn-success btn-file" onclick="descargarPermisoLocal();">
            <!--<a href='download_pagoSua.php'><img src='img/pdf.png' height='24px' width='24px'/></a>-->
            <a href='#'><img src='img/pdf.png' height='24px' width='24px'/></a>
          </span>      
    </div>            
    
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>CFDI Nomina Por Cliente</h4></div>

<select id="selmesCDFIDescarga" name="selmesCDFIDescarga" class="input-large"></select>
<select id="selanioCDFIDescarga" name="selanioCDFIDescarga" class="input-large"  style="display: none" onchange="obtenerArchivosNom()"></select>





    <div class="card-body text-primary">        
          <div id="divNom"></div>      
    </div>            
    
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <!--<div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Documento DC-3 Por Entidad</h4></div>
    <select id="slEntidadC3" name="slEntidadC3" class="input-large" onchange="obtenerArchivosDc3()">
                <option value="">ENTIDAD</option>
                        <?php                        
            /*    for ($i = 0; $i < count($entidadesCliente); $i++) {    
                        echo "<option value='" . $entidadesCliente[$i]["idEntidadFederativa"] . "'>" . $entidadesCliente[$i]["nombreEntidadFederativa"] . " </option>";    
                }*/
                      ?>
              </select>
    <div class="card-body text-primary">        
          <div id="divDc3"></div>    
    </div>                  
  </div>
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Afil-06 Por Entidad</h4></div>
    <select id="slEntidadA6" name="slEntidadA6" class="input-large" onchange="obtenerArchivosAfil()">
                <option value="">ENTIDAD</option>
                        <?php                        
           /*     for ($i = 0; $i < count($entidadesCliente); $i++) {    
                        echo "<option value='" . $entidadesCliente[$i]["idEntidadFederativa"] . "'>" . $entidadesCliente[$i]["nombreEntidadFederativa"] . " </option>";    
                }*/
                      ?>
              </select>
    <div class="card-body text-primary">        
          <div id="divAfil"></div>               
    </div>            
    
    <button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>
  </div>-->


  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Opinion de cumplimientos IMSS</h4></div>
    
    <select id="selectMesOpIMSS" name="selectMesOpIMSS" class="input-large" ></select>
    <select id="selectAnioOpIMSS" name="selectAnioOpIMSS" class="input-large"  style="display: none" onchange="obtenerOpinionIMSS()"></select>

    <div class="card-body text-primary">        
          <div id="divOpinionIMSS"></div>      
    </div>            
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Opinion de cumplimientos INFONAVIT</h4></div>
    <select id="selectAnioOpInfonavit" name="selectAnioOpInfonavit" class="input-large" ></select>
    <select id="selectMesOpInfonavit" name="selectMesOpInfonavit" class="input-large" style="display: none"></select>

    <select id="selectRegOpinionInfonavit" name="selectRegOpinionInfonavit" class="input-large" style="display: none" onchange="obtenerOpinionInfonavit()"></select>

    <div class="card-body text-primary">        
          <div id="divOpinionInfonavit"></div>      
    </div>            
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>REPSE</h4></div>
      <center>
       <input type="image" id="btnAbrirDocumentoRepseCliente"  src="img\hojaDatos.png" style="width: 8%;" title="Abrir documento" class="cursorImg">
      </center>

      <div id="DivtxtnombreDocumentoRepse">
       <input type="hidden" id="txtnombreDocumentoREPSEHiddenCliente" class="input-xlarge">   
    </div>
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>ICSOE</h4></div>
    <select id="selectCuatrimestreICSOE" name="selectCuatrimestreICSOE" class="input-large" ></select>
    <select id="selectAnioICSOE" name="selectAnioICSOE" class="input-large"  style="display: none" onchange="obtenerICSOE()"></select>

    <div class="card-body text-primary">        
          <div id="divICSOE"></div>      
    </div>            
  </div>


  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>SISUB</h4></div>
    <select id="selectCuatrimestreSISUB" name="selectCuatrimestreSISUB" class="input-large" ></select>
    <select id="selectAnioSISUB" name="selectAnioSISUB" class="input-large"  style="display: none" onchange="obtenerSISUB()"></select>

    <div class="card-body text-primary">        
          <div id="divSISUB"></div>      
    </div>            
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>SAT</h4></div>
    <select id="selectAnioDocSAT" name="selectAnioDocSAT" class="input-large" ></select>
    <select id="selectMesSAT" name="selectMesSAT" class="input-large"  style="display: none">
      <option value="0">MES</option>
      <option value="01">ENERO</option>
      <option value="02">FEBRERO</option>
      <option value="03">MARZO</option>
      <option value="04">ABRIL</option>
      <option value="05">MAYO</option>
      <option value="06">JUNIO</option>
      <option value="07">JULIO</option>
      <option value="08">AGOSTO</option>
      <option value="09">SEPTIEMBRE</option>
      <option value="10">OCTUBRE</option>
      <option value="11">NOVIEMBRE</option>
      <option value="12">DICIEMBRE</option>
    </select>

    <select id="selectDocSAT" name="selectDocSAT" class="input-large"  style="display: none">
      <option value="0">DOCUMENTO</option>
      <option value="1">DECLARACIÓN ISR</option>
      <option value="2">DECLARACIÓN IVA</option>
      <option value="3">PAGOS ISR</option>
      <option value="4">PAGOS IVA</option>
      <option value="5">OPINION SAT</option>
      <option value="6">CONSTANCIA DE SITUACIÓN FISCAL</option>
      <option value="7">AFFIDAVIT</option>
    </select>

    <div class="card-body text-primary">        
          <div id="divDocSAT"></div>      
    </div>            
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>IMSS</h4></div>
    
    <select id="selectDocIMSS" name="selectDocIMSS" class="input-large">
      <option value="0">DOCUMENTO</option>
      <option value="1">IMSS XML</option>
      <option value="2">INFONAVIT XML</option>
      <option value="3">EMA</option>
      <option value="4">EBA</option>
      <option value="5">TARJETA PATRONAL</option>
    </select>

    <select id="selectAnioDocIMSS" name="selectAnioDocIMSS" class="input-large" style="display: none"></select>
    <select id="selectMesIMSS" name="selectMesIMSS" class="input-large"  style="display: none">
      <option value="0">MES</option>
      <option value="01">ENERO</option>
      <option value="02">FEBRERO</option>
      <option value="03">MARZO</option>
      <option value="04">ABRIL</option>
      <option value="05">MAYO</option>
      <option value="06">JUNIO</option>
      <option value="07">JULIO</option>
      <option value="08">AGOSTO</option>
      <option value="09">SEPTIEMBRE</option>
      <option value="10">OCTUBRE</option>
      <option value="11">NOVIEMBRE</option>
      <option value="12">DICIEMBRE</option>
    </select>

    <select id="selectRegPatIMSS" name="selectRegPatIMSS" class="input-large"  style="display: none"></select>


    <div class="card-body text-primary">        
          <div id="divDocIMSS"></div>      
    </div>            
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>MOVIMIENTOS</h4></div>
    
    <select id="selectAnioDocMovimientos" name="selectAnioDocMovimientos" class="input-large"></select>
    <select id="selectMesMov" name="selectMesMov" class="input-large"  style="display: none">
      <option value="0">MES</option>
      <option value="1">ENERO</option>
      <option value="2">FEBRERO</option>
      <option value="3">MARZO</option>
      <option value="4">ABRIL</option>
      <option value="5">MAYO</option>
      <option value="6">JUNIO</option>
      <option value="7">JULIO</option>
      <option value="8">AGOSTO</option>
      <option value="9">SEPTIEMBRE</option>
      <option value="10">OCTUBRE</option>
      <option value="11">NOVIEMBRE</option>
      <option value="12">DICIEMBRE</option>
    </select>

    <div class="card-body text-primary">        
          <div id="divDocMovimientos"></div>      
    </div>            
  </div>
</div>
<script type="text/javascript">

$(inicioDescargaDocCl());  

function inicioDescargaDocCl(){
     cargaraniosDocumentCLient();
     cargarmesesDocumentCLient();
     cargaraniosDocumentCLientOpINFONAVIT();
     cargarmesesDocumentCLientOpINFONAVIT();
     cargaraniosDocumentCLientOpIMSS();
     cargarmesesDocumentCLientOpIMSS();
     obtenerREPSE();
     cargarCuatrimestreICSOE();
     cargarCuatrimestreSISUB();
     cargaraniosICSOE();
     cargaraniosSISUB();
     cargaraniosDocSAT();
     cargaraniosDocIMSS();
     cargaraniosDocMov();
}

function cargaraniosDocMov() {
     $('#selectAnioDocMovimientos').empty().append('<option value="0" >EJERCICIO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selectAnioDocMovimientos"); //llenar con js un selector de fechas
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
     }
 }

  $("#selectAnioDocMovimientos").change(function(){
    if($("#selectAnioDocMovimientos").val()==0){
       $("#selectMesMov").hide();
       $("#selectMesMov").val(0);
    }else{
          $("#selectMesMov").show();
    }
    $("#divDocMovimientos").html("");
  });

  $("#selectMesMov").change(function(){
    if($("#selectMesMov").val()==0){
      $("#divDocMovimientos").html("");
    }else if( $("#selectMesMov").val()!=0 ){
            consultarMovXMes();
    }
  });

  function consultarMovXMes(){
    var anio=  $('#selectAnioDocMovimientos').val();  
    var mes=$('#selectMesMov').val();    
    $("#divDocMovimientos").html("");
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_consultarZipMov.php",
              data: {"mes":mes,"anio":anio},
              dataType: "json",
              success: function(response) {
                var total= response.datos["total"];
                  if(total!=0){ 
                    var p="<span class='btn btn-success btn-file'><a href='" + window.location.protocol + "//" + location.hostname + "/zonacgg/Vista/uploads/movimientos/movimiento_"+mes+anio+".zip'><img src='img/ZIP.png' height='24px' width='24px'/></a></span>";
                    $("#divDocMovimientos").html(p);                    
                  }else{
                      swal("Atencion","Aún no se ha cargado esta información","warning");
                      $("#divDocMovimientos").html("");
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
}


// ------------------------------------------------------------------

 $("#selectDocIMSS").change(function(){
  if($("#selectDocIMSS").val()==0){
    $("#selectAnioDocIMSS").hide();
    $("#selectMesIMSS").hide();
    $("#selectRegPatIMSS").hide();
    
  }else{
    $("#selectAnioDocIMSS").show();
    $("#selectAnioDocIMSS").val(0);
    $("#selectMesIMSS").hide();
    $("#selectMesIMSS").val(0);
    $("#selectRegPatIMSS").hide();
    $("#selectRegPatIMSS").val(0);
  }
    $("#divDocIMSS").html("");
 });

  $("#selectAnioDocIMSS").change(function(){
    if($("#selectAnioDocIMSS").val()==0){
       $("#selectMesIMSS").hide();
       $("#selectMesIMSS").val(0);
       $("#selectRegPatIMSS").hide();
       $("#selectRegPatIMSS").val(0);
    }else{
          $("#selectMesIMSS").show();
          $("#selectRegPatIMSS").hide();
          $("#selectRegPatIMSS").val(0);
    }
    $("#divDocIMSS").html("");
  });

  $("#selectMesIMSS").change(function(){
    if($("#selectMesIMSS").val()==0){
       $("#selectRegPatIMSS").hide();
       $("#selectRegPatIMSS").val(0);
    }else if( ($("#selectMesIMSS").val()!=0) &&  ($("#selectDocIMSS").val()==1 || $("#selectDocIMSS").val()==2)){
            consultaDocXMLImssInfonavit();
    }else if( ($("#selectMesIMSS").val()!=0) &&  ($("#selectDocIMSS").val()==3 || $("#selectDocIMSS").val()==4 || $("#selectDocIMSS").val()==5)){
          $("#selectRegPatIMSS").show();
          $("#selectRegPatIMSS").val(0);
          $("#divDocIMSS").html("");
          cargarRegistrosPatronales();
    }
  });

  $("#selectRegPatIMSS").change(function(){
    if($("#selectRegPatIMSS").val()==0){
           $("#divDocIMSS").html("");
    }else if( ($("#selectMesIMSS").val()!=0) &&  ($("#selectDocIMSS").val()==3 || $("#selectDocIMSS").val()==4)){
          consultarDocEMAEBA();
    }else if ($("#selectDocIMSS").val()==5){
        consultaDocTarjetaPatronal();
    }
  });

function consultaDocTarjetaPatronal(){
    var anioDoc = $('#selectAnioDocIMSS').val();    
    var mesDoc  = $('#selectMesIMSS').val();    
    var regDoc  = $('#selectRegPatIMSS').val();   

    $("#divDocIMSS").html("");
    $.ajax({
            async:false,
            type: "POST",
            url: "ajax_ConsultaTarjetaPatronalXCliente.php",
            data: {anioDoc,mesDoc,regDoc},
            dataType: "json",
            success: function(response){
                  if(response.datos.length==1){   
                       var nombreArchivo= response.datos[0]["nombreDocumento"];
                       var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/TarjetaPatronal/"+nombreArchivo+"'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    $("#divDocIMSS").html(p);                    
                  }else{
                    var msj="Aún no se ha cargado esta información";
                    alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });
}

function consultaDocXMLImssInfonavit(){
    var tipoDoc = $('#selectDocIMSS').val();  
    var anioDoc = $('#selectAnioDocIMSS').val();    
    var mesDoc  = $('#selectMesIMSS').val();    
    var regDoc  = $('#selectRegPatIMSS').val();   

    $("#divDocIMSS").html("");
    $.ajax({
            async:false,
            type: "POST",
            url: "ajax_ConsultaXMLImssInfonavit.php",
            data: {tipoDoc,anioDoc,mesDoc,regDoc},
            dataType: "json",
            success: function(response) {
                  if(response.datos.length==1){   

                    if(tipoDoc=='1'){
                       var nombreDocumentoIMSSXML= response.datos[0]["NombreArchivoXMLImss"];
                       var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/DocumentosXMLIMSS/"+nombreDocumentoIMSSXML+"'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    
                    }else{
                          var nombreDocumentoInfonavitXML= response.datos[0]["NombreArchivoXMLInfonavit"];
                          var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/DocumentosXMLINFONAVIT/"+nombreDocumentoInfonavitXML+"'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    }
                    $("#divDocIMSS").html(p);                    
                  }else{
                    var msj="Aún no se ha cargado esta información";
                    alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });
}



function consultarDocEMAEBA(){
    var tipoDoc = $('#selectDocIMSS').val();  
    var anioDoc = $('#selectAnioDocIMSS').val();    
    var mesDoc  = $('#selectMesIMSS').val();    
    var regDoc  = $('#selectRegPatIMSS').val();   

    $("#divDocIMSS").html("");
    $.ajax({
            async:false,
            type: "POST",
            url: "ajax_ConsultaEMAEBA.php",
            data: {tipoDoc,anioDoc,mesDoc,regDoc},
            dataType: "json",
            success: function(response) {
                  if(response.datos.length==1){   

                    if(tipoDoc=='3'){
                       var nombreArchivo= response.datos[0]["NombreArchivoIDSEEMA"];
                       var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/DocumentosIDSEEMA/"+nombreArchivo+"'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    
                    }else if(tipoDoc=='4'){
                          var nombreArchivo= response.datos[0]["NombreArchivoIDSEEBA"];
                          var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/DocumentosIDSEEBA/"+nombreArchivo+"'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    }
                    $("#divDocIMSS").html(p);                    
                  }else{
                    var msj="Aún no se ha cargado esta información";
                    alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
    });
}

function cargarRegistrosPatronales(){

  var anio = $('#selectAnioDocIMSS').val();  
  var mes  = $('#selectMesIMSS').val();
  var cliente=<?php echo $cliente?>; 
        $.ajax({
              async:false,
              type: "POST",
              url: "ajax_ConsultarRegistrosPatronales.php",
              data: {"idCliente": cliente ,"anio": anio, "mes": mes},
              dataType: "json",
              success: function(response) {
                  if(response.status=="success"){
                          $("#selectRegPatIMSS").empty(); 
                          $('#selectRegPatIMSS').append('<option value="0">REGISTRO PATRONAL</option>');
                          for(var i = 0; i < response.datos.length; i++){
                            $('#selectRegPatIMSS').append('<option value="' + (response.datos[i].registroPatronal) + '">' + response.datos[i].registroPatronal + '</option>');
                          }
                      }else{
                            var msj="no cuenta con registros patronales";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                      }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
        });
}

function cargaraniosDocIMSS() {
     $('#selectAnioDocIMSS').empty().append('<option value="0" >EJERCICIO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selectAnioDocIMSS"); //llenar con js un selector de fechas
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
     }
 }



////////////////////////////////////////////////
  $("#selectAnioDocSAT").change(function(){
  if($("#selectAnioDocSAT").val()==0){
    $("#selectMesSAT").hide();
    $("#selectDocSAT").hide();
    
  }else{
    $("#selectMesSAT").show();
    $("#selectMesSAT").val(0);
    $("#selectDocSAT").hide();
    $("#selectDocSAT").val(0);
  }
  $("#divDocSAT").html("");
 });

    $("#selectMesSAT").change(function(){
  if($("#selectMesSAT").val()==0){
    $("#selectDocSAT").hide();
  }else{
    $("#selectDocSAT").show();
    $("#selectDocSAT").val(0);
  }
  $("#divDocSAT").html("");
 });


$("#selectDocSAT").change(function(){
  if($("#selectDocSAT").val()!=0){
    var anio = $('#selectAnioDocSAT').val();
    var mes  = $('#selectMesSAT').val();  
    var documento = $('#selectDocSAT').val();
        $.ajax({
              async:false,
              type: "POST",
              url: "ajax_ConsultaDocumentosSAT.php",
              data: {"anio": anio, "mes": mes, "documento": documento},
              dataType: "json",
              success: function(response) {
                  if(response.datos.length==1){
                         var pdf=response.datos[0]["nombrePdfSAT"];
                         var p="<a onclick=generarPDFSAT('"+pdf+"','"+documento+"');><img src='img/pdf.png' height='54px' width='54px'/></a>";
                          $("#divDocSAT").html(p);
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                            $("#divDocSAT").html("");
                      }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
  }else{
    $("#divDocSAT").html("");
  }
 });

function generarPDFSAT(archivo,documento){ 

  if(documento=='1'){
       window.open("uploads/DeclaracionISR/"+archivo);
       waitingDialog.hide();
    }if(documento=='2'){
       window.open("uploads/DeclaracionIVA/"+archivo);
       waitingDialog.hide();
    }if(documento=='3'){
       window.open("uploads/PagosISR/"+archivo);
       waitingDialog.hide();
    }if(documento=='4'){
       window.open("uploads/PagosIVA/"+archivo);
       waitingDialog.hide();
    }if(documento=='5'){
       window.open("uploads/OpinionSAT/"+archivo);
       waitingDialog.hide();
    }if(documento=='6'){
       window.open("uploads/ConstanciaDeSituacionFiscal/"+archivo);
       waitingDialog.hide();
    }if(documento=='7'){
       window.open("uploads/AFFIDAVIT/"+archivo);
       waitingDialog.hide();
    }
}

function cargaraniosDocSAT() {
     $('#selectAnioDocSAT').empty().append('<option value="0" >EJERCICIO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selectAnioDocSAT"); //llenar con js un selector de fechas
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
     }
 }

$("#selectAnioOpInfonavit").change(function(){
  if($("#selectAnioOpInfonavit").val()==0){
    $("#selectMesOpInfonavit").hide();
    $("#selectRegOpinionInfonavit").hide();
    
  }else{
    $("#selectMesOpInfonavit").show();
    $("#selectMesOpInfonavit").val(0);
    $("#selectRegOpinionInfonavit").hide();
    $("#selectRegOpinionInfonavit").val(0);
  }
  $("#divOpinionInfonavit").html("");
 });

 $("#selectMesOpInfonavit").change(function(){
  if($("#selectMesOpInfonavit").val()==0){
    $("#selectRegOpinionInfonavit").hide();
    $("#selectRegOpinionInfonavit").val(0);
  }else{
        var mes  = $('#selectMesOpInfonavit').val();  
        var anio = $('#selectAnioOpInfonavit').val();
        $.ajax({
              async:false,
              type: "POST",
              url: "ajax_ConsultarRegistrosPatronalesOpinionInfonavit.php",
              data: {"anio": anio, "mes": mes},
              dataType: "json",
              success: function(response) {
                  if(response.status=="success"){
                          $("#selectRegOpinionInfonavit").empty(); 
                          $('#selectRegOpinionInfonavit').append('<option value="0">REGISTRO PATRONAL</option>');
                          for(var i = 0; i < response.datos.length; i++){
                            $('#selectRegOpinionInfonavit').append('<option value="' + (response.datos[i].idregistroP) + '">' + response.datos[i].idregistroP + '</option>');
                          }
                          // $("#divOpinionInfonavit").html(p);
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                      }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
        $("#selectRegOpinionInfonavit").show();
  }
  $("#divOpinionInfonavit").html("");

 });

$("#selanio").change(function(){
  if($("#selanio").val()==0){
    $("#selmes").hide();
    $("#selectReg").hide();
    
  }else{
    $("#selmes").show();
    $("#selmes").val(0);
    $("#selectReg").hide();
    $("#selectReg").val(0);
  }
  $("#divSua").html("");
 });

$("#selmes").change(function(){
  if($("#selmes").val()==0){
    $("#selectReg").hide();
    $("#selectReg").val(0);
  }else{
        var mes  = $('#selmes').val();  
        var anio = $('#selanio').val();
        var cliente=<?php echo $cliente?>; 
        $.ajax({
              async:false,
              type: "POST",
              url: "ajax_ConsultarRegistrosPatronales.php",
              data: {"idCliente": cliente ,"anio": anio, "mes": mes},
              dataType: "json",
              success: function(response) {
                  if(response.status=="success"){
                          $("#selectReg").empty(); 
                          $('#selectReg').append('<option value="0">REGISTRO PATRONAL</option>');
                          for(var i = 0; i < response.datos.length; i++){
                            $('#selectReg').append('<option value="' + (response.datos[i].registroPatronal) + '">' + response.datos[i].registroPatronal + '</option>');
                          }
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                      }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
        $("#selectReg").show();
  }
  $("#divSua").html("");

 });

function obtenerSISUB(){
    var cuatrimestre=  $('#selectCuatrimestreSISUB').val();  
    var anio =$('#selectAnioSISUB').val();    
    $("#divSISUB").html("");
    if(anio!="0"){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_ConsultaCargaSISUB.php",
              data: {cuatrimestre,anio},
              dataType: "json",
              success: function(response) {
                  if(response.datos.length==1){
                         var pdf=response.datos[0]["NombreArchivoSISUB"];
                         var p="<a onclick=generarPDFSISUB('"+pdf+"');><img src='img/pdf.png' height='54px' width='54px'/></a>";
                          $("#divSISUB").html(p);
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                      }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}

function generarPDFSISUB(archivo){ 
     window.open("uploads/DocumentosSISUB/"+archivo+".pdf",'fullscreen=no');
     waitingDialog.hide();
}

function cargaraniosSISUB() {
     $('#selectAnioSISUB').empty().append('<option value="0" >AÑO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selectAnioSISUB"); //llenar con js un selector de fechas
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
     }
 }

 $("#selectCuatrimestreSISUB").change(function(){
  if($("#selectCuatrimestreSISUB").val()==0){
     $("#selectAnioSISUB").hide();
  }else{
        $("#selectAnioSISUB").show();
      }
   $("#divSISUB").html("");
   $("#selectAnioSISUB").val(0);
 });
//////////////////////////////
function obtenerICSOE(){
    var cuatrimestre=  $('#selectCuatrimestreICSOE').val();  
    var anio =$('#selectAnioICSOE').val();    
    $("#divICSOE").html("");
    if(anio!="0"){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_ConsultaCargaICSOE.php",
              data: {cuatrimestre,anio},
              dataType: "json",
              success: function(response) {
                  if(response.datos.length==1){
                         var pdf=response.datos[0]["NombreArchivoICSOE"];
                         var p="<a onclick=generarPDFICSOE('"+pdf+"');><img src='img/pdf.png' height='54px' width='54px'/></a>";
                          $("#divICSOE").html(p);
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $(document).scrollTop(0);
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                      }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}

function generarPDFICSOE(archivo){ 
     window.open("uploads/DocumentosICSOE/"+archivo+".pdf",'fullscreen=no');
     waitingDialog.hide();
}

function cargaraniosICSOE() {
     $('#selectAnioICSOE').empty().append('<option value="0" >AÑO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selectAnioICSOE"); //llenar con js un selector de fechas
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
     }
 }

 $("#selectCuatrimestreICSOE").change(function(){
  if($("#selectCuatrimestreICSOE").val()==0){
     $("#selectAnioICSOE").hide();
  }else{
        $("#selectAnioICSOE").show();
      }
   $("#divICSOE").html("");
   $("#selectAnioICSOE").val(0);
 });

function obtenerREPSE(){
 $.ajax({
         type: "POST",
         url: "ajax_obtenerUltimoDocumentoRepse.php",
         dataType: "json",
         success: function(response) {
             if(response.status == "success"){
                $("#txtnombreDocumentoREPSEHiddenCliente").val(response["nombreDocumento"]);
              }
         },error:function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText);
            }
  });
}

$("#btnAbrirDocumentoRepseCliente").click(function(){
  var nombreDocumento = $("#txtnombreDocumentoREPSEHiddenCliente").val();
  //alert(nombreDocumento);
  window.open("ajax_CargarDocumentoREPSE.php?&nombreDocumento=" + nombreDocumento,'fullscreen=no');

});

function obtenerOpinionIMSS(){
    var mes=  $('#selectMesOpIMSS').val();  
    var anio=$('#selectAnioOpIMSS').val();    
    $("#divOpinionIMSS").html("");
    if(anio!="0"){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_generarLinkOpinionIMSS.php",
              data: {"mes":mes,"anio":anio},
              dataType: "json",
              success: function(response) {
                  if(response.status!='error'){                    
                    var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/DocumentosOpinionCumplimiento/Imss/"+mes+anio+"/documento.zip'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    $("#divOpinionIMSS").html(p);                    
                  }else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+response.message+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                          
                    $("#alertMsg").html(alertMsg1);                    
                    $('#msgAlert').delay(2000).fadeOut('slow');
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}


function obtenerOpinionInfonavit(){
    var registro= $('#selectRegOpinionInfonavit').val();  
    var mes=  $('#selectMesOpInfonavit').val();  
    var anio=$('#selectAnioOpInfonavit').val();    
    $("#divOpinionInfonavit").html("");
    if(anio!="0"){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_generarLinkOpinionInfonavit.php",
              data: {
                  "registro": registro,"mes":mes,"anio":anio
              },
              dataType: "json",
              success: function(response) {
                  // console.log(response);
                  if(response.status!='error'){                    
                    var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/DocumentosOpinionCumplimiento/Infonavit/"+registro+mes+anio+"/documento.zip'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    $("#divOpinionInfonavit").html(p);                    
                  }else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+response.message+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                          
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
                                
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}



function obtenerArchivosSua(){
    var registro= $('#selectReg').val();  
     var mes=  $('#selmes').val();  
    var anio=$('#selanio').val();    
    $("#divSua").html("");
    //alert("carpeta: "+entidad+"_"+cliente);
    if(anio!="0"){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_generarLink.php",
              data: {
                  "registro": registro , "tipo":'sua',"mes":mes,"anio":anio
              },
              dataType: "json",
              success: function(response) {
                  // console.log(response);
                  if(response.status!='error'){                    
                    var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/documentosContabilidad/pagoSua/"+registro+mes+anio+"/documento.zip'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    $("#divSua").html(p);                    
                  }else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+response.message+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                          
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
                                
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}

function descargarCapacitacion(){
    var cliente = <?php echo $cliente ?>;
    window.location.href = "download_documentoCliente.php?documento=capacitacion_"+cliente;
}

function descargarPermiso(){
    
    window.location.href = "download_documentoCliente.php?documento=permisoF";
}

function descargarPermisoLocal(){
    var entidad= $('#slEntidadPL').val();
    if(entidad==""){
      alert("Seleccione una entidad");
      return;
    }
    window.location.href = "download_documentoCliente.php?documento=permisoL_"+entidad;
}


function obtenerArchivosNom(){
     var entidad= '0';//solo para mandarlo
     var mesCFDI= $('#selmesCDFIDescarga').val();
     var anioCFDI= $('#selanioCDFIDescarga').val(); 


    var cliente = <?php echo $cliente ?>;
    $("#divNom").html("");
    //alert("carpeta: "+entidad+"_"+cliente);
    if(anioCFDI!=""){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_generarLink.php",
              data: {
                  "entidad": entidad , "cliente":cliente, "tipo":'nomina',  "mesCFDI":mesCFDI  , "anioCFDI":anioCFDI
              },
              dataType: "json",
              success: function(response) {
                  // console.log(response);
                  if(response.status!='error'){                    
                    var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/nomina/"+cliente+"_"+mesCFDI+"_"+anioCFDI+"/documento.zip'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    $("#divNom").html(p);                    
                  }else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+response.message+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                          
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
                                
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}

function obtenerArchivosAfil(){
    var entidad= $('#slEntidadA6').val();
    var cliente = <?php echo $cliente ?>;
    $("#divAfil").html("");
    //alert("carpeta: "+entidad+"_"+cliente);
    if(entidad!=""){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_generarLink.php",
              data: {
                  "entidad": entidad , "cliente":cliente, "tipo":'afil',
              },
              dataType: "json",
              success: function(response) {
                  // console.log(response);
                  if(response.status!='error'){                    
                    var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/otrosDocumentos/AFIL06/"+entidad+"_"+cliente+"/documento.zip'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    $("#divAfil").html(p);                    
                  }else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+response.message+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                          
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
                                
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}


function obtenerArchivosDc3(){
    var entidad= $('#slEntidadC3').val();
    var cliente = <?php echo $cliente ?>;
    $("#divDc3").html("");
    //alert("carpeta: "+entidad+"_"+cliente);
    if(entidad!=""){
      $.ajax({
              async:false,
              type: "POST",
              url: "ajax_generarLink.php",
              data: {
                  "entidad": entidad , "cliente":cliente, "tipo":'dc3',
              },
              dataType: "json",
              success: function(response) {
                  // console.log(response);
                  if(response.status!='error'){                    
                    var p="<span class='btn btn-success btn-file'><a href='https://www.zonagifseguridad.com.mx/zonacgg/Vista/uploads/otrosDocumentos/DC-3/"+entidad+"_"+cliente+"/documento.zip'><img src='img/pdf.png' height='24px' width='24px'/></a></span>";
                    $("#divDc3").html(p);                    
                  }else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+response.message+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                          
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                  }
                                
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.responseText);
              }
      });
    }
}




function cargaraniosDocumentCLient() {
     $('#selanio').empty().append('<option value="0" >AÑO</option>');
     $('#selanioCDFIDescarga').empty().append('<option value="0" >AÑO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selanio"); //llenar con js un selector de fechas
     var select1 = document.getElementById("selanioCDFIDescarga");
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
         select1.options.add(new Option(i, i));
     }
 }

 function cargarmesesDocumentCLient() {
     var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
     var values = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
     $('#selmes').empty().append('<option value="0">MES</option>');
     $('#selmesCDFIDescarga').empty().append('<option value="0">MES</option>');
     for (var i in meses) {
         $('#selmes').append('<option value="' + values[i] + '">' + meses[i] + '</option>');
         $('#selmesCDFIDescarga').append('<option value="' + values[i] + '">' + meses[i] + '</option>');
     }
 }

 function cargaraniosDocumentCLientOpINFONAVIT() {
     $('#selectAnioOpInfonavit').empty().append('<option value="0" >AÑO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selectAnioOpInfonavit"); //llenar con js un selector de fechas
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
     }
 }

function cargarmesesDocumentCLientOpINFONAVIT() {
     var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
     var values = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
     $('#selectMesOpInfonavit').empty().append('<option value="0">MES</option>');
     for (var i in meses) {
         $('#selectMesOpInfonavit').append('<option value="' + values[i] + '">' + meses[i] + '</option>');
     }
 }


 function cargaraniosDocumentCLientOpIMSS() {
     $('#selectAnioOpIMSS').empty().append('<option value="0" >AÑO</option>');
     var n = (new Date()).getFullYear();
     var select = document.getElementById("selectAnioOpIMSS"); //llenar con js un selector de fechas
     for (var i = n; i >= 2020; i--) {
         select.options.add(new Option(i, i));
     }
 }

function cargarmesesDocumentCLientOpIMSS() {
     var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
     var values = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
     $('#selectMesOpIMSS').empty().append('<option value="0">MES</option>');
     for (var i in meses) {
         $('#selectMesOpIMSS').append('<option value="' + values[i] + '">' + meses[i] + '</option>');
     }
 }

 function cargarCuatrimestreICSOE() {
     var cuatrimestre = ["ENERO-ABRIL","MAYO-AGOSTO","SEPTIEMBRE-DICIEMBRE"];
     var values = ["01", "02", "03"];
     $('#selectCuatrimestreICSOE').empty().append('<option value="0">CUATRIMESTRE</option>');
     for (var i in cuatrimestre) {
         $('#selectCuatrimestreICSOE').append('<option value="' + values[i] + '">' + cuatrimestre[i] + '</option>');
     }
 }

  function cargarCuatrimestreSISUB() {
     var cuatrimestre = ["ENERO-ABRIL","MAYO-AGOSTO","SEPTIEMBRE-DICIEMBRE"];
     var values = ["01", "02", "03"];
     $('#selectCuatrimestreSISUB').empty().append('<option value="0">CUATRIMESTRE</option>');
     for (var i in cuatrimestre) {
         $('#selectCuatrimestreSISUB').append('<option value="' + values[i] + '">' + cuatrimestre[i] + '</option>');
     }
 }

 $("#selectMesOpIMSS").change(function(){
  if($("#selectMesOpIMSS").val()==0){
    $("#selectAnioOpIMSS").hide();
  }else{
    $("#selectAnioOpIMSS").show();
    $("#selectAnioOpIMSS").val(0);
  }
 $("#divOpinionIMSS").html("");
 });



$("#slEntidadC").change(function(){
  if($("#slEntidadC").val()==0){
     $("#selmesCDFIDescarga").hide();
     $("#selanioCDFIDescarga").hide();
  }else{
        $("#selmesCDFIDescarga").show();
        $("#selanioCDFIDescarga").hide();
  }
  $("#divNom").html("");
  $("#selmesCDFIDescarga").val(0);
  $("#selanioCDFIDescarga").val(0);
});

 $("#selmesCDFIDescarga").change(function(){
  if($("#selmesCDFIDescarga").val()==0){
    $("#selanioCDFIDescarga").hide();
    
  }else{
    $("#selanioCDFIDescarga").show();
    $("#selanioCDFIDescarga").val(0);
  }

 $("#divNom").html("");
 });


</script>