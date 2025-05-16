<div align="center">
  <div id="divMensajeCargaNomina"></div> 
  <h2>Comprobantes de Nómina</h2>
  <br>
  <div class="card border-primary mb-3" style="max-width: 50rem;">

    <div class="card-header"><h4>Seleccione entidad y cliente</h4></div>  

      <select id="slCliente" name="slCliente" class="input-large ">
              <option value="">CLIENTE</option>
                <?php
                  for ($i = 0; $i < count($catatoloClientes); $i++)
                  {
                    echo "<option value='" . $catatoloClientes [$i]["idCliente"] . "' >" . $catatoloClientes [$i]["razonSocial"] . " </option>";
                  }
                ?>
      </select>

      <select id="selmesCFDINomina" name="selmesCFDINomina" class="input-large" style="display: none"></select>

      <select id="anioCN" name="anioCN" style="display:none;">
        <option value="0" selected>EJERCICIO</option>
        <?php $year = date("Y");
        for($i=$year; $i>=2020; $i--){
            echo '<option value="'.$i.'">'.$i.'</option>';
           }
        ?>
      </select>

  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Actualizar CFDI</h4></div>	   
    <div class="card-body text-primary">
			<label class="control-label label" for="docuNomina">Selecciona archivo: </label>
        <form enctype='multipart/form-data' id='pagosNomina' name='pagosNomina'>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='docuNomina[]' name='docuNomina[]' multiple=""> 
          </span>
          <button type="button" class="btn btn-primary" onclick="enviar()">Cargar</button>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
</div>
<script type="text/javascript">

$(inicioNominasPDF());  

function inicioNominasPDF(){
   cargarmesesCFDIComprobanteNomina();
}

function enviar() {

      var cliente= $("#slCliente").val();
      var mesCFDI= $("#selmesCFDINomina").val(); 
      var anio= $("#anioCN").val(); 

      if(cliente==""){
        alert("Seleccione un cliente");
        $("#pagosNomina")[0].reset();
        return ;
      }    

      if(mesCFDI=="0"){
        alert("Seleccione un mes");
        $("#pagosNomina")[0].reset();
        return ;
      } 

      if(anio=="0"){
        alert("Seleccione un ejercicio");
        $("#pagosNomina")[0].reset();
        return ;
      } 

      var formData = new FormData($("#pagosNomina")[0]);  
      formData.append('cliente', cliente); 
      formData.append('mesCFDI', mesCFDI); 
      formData.append('anio', anio); 
   
       $.ajax({
            
            type: "POST",
            url: "upload_nomina.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
             success: function(response) {
                if(response.status=='success'){
                     $("#pagosNomina")[0].reset(); 
                      $("#slCliente").val("");
                      $("#selmesCFDINomina").hide();
                      $("#selmesCFDINomina").val(0);
                      $("#anioCN").hide();
                      $("#anio").val(0);
                      var mensaje ="Archivo subidos correctamente";
                      cargarmensajeNominaPDF(mensaje,"success");
                }else{
                     $("#pagosNomina")[0].reset(); 
                      var mensaje =response.message;
                      cargarmensajeNominaPDF(mensaje,"error");         
                }
                    
            },
             error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
}

function cargarmesesCFDIComprobanteNomina() {
  var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
  var values = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
  $('#selmesCFDINomina').empty().append('<option value="0">MES</option>');
  for (var i in meses) {
      $('#selmesCFDINomina').append('<option value="' + values[i] + '">' + meses[i] + '</option>');
  }
}

$("#slCliente").change(function(){
  if($("#slCliente").val()==0){
     $("#selmesCFDINomina").hide();
     $("#anioCN").hide();
  }else{
        $("#selmesCFDINomina").show();
  }
});


$("#selmesCFDINomina").change(function(){
  if($("#selmesCFDINomina").val()==0){
     $("#anioCN").hide();
  }else{
        $("#anioCN").show();
  }
});


function cargarmensajeNominaPDF(mensaje,statusCarga){
  $('#divMensajeCargaNomina').fadeIn('slow');
  mensajeErrorP="<div id='msgAlert' class='alert alert-"+statusCarga+"'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
  $("#divMensajeCargaNomina").html(mensajeErrorP);
  $(document).scrollTop(0);
  $('#divMensajeCargaNomina').delay(3000).fadeOut('slow');
}


</script>