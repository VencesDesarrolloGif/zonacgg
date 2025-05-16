<div align="center">
  <h2>Opinión de cumplimientos</h2>
  <div class="card border-success mb-3" style="max-width: 60rem;">
    <div class="card-header">
     <h2>IMSS</h2>
    </div>    
    <br>
<select id="selectmesOPIMSS" name="selectmesOPIMSS">
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

    <div class="card-body text-primary">
			
        <form enctype='multipart/form-data' id='formOpinionIMSS' name='formOpinionIMSS'>

          <label class="control-label label" for="archivoOpinionIMSS">Seleccionar archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='archivoOpinionIMSS' name='archivoOpinionIMSS[]' multiple="" accept=".pdf"/>  
          </span>

         </div>  
         <div class="card-body text-primary">
         <button type="button" class="btn btn-primary" onclick="btncargaroPimsS()">Cargar</button>    
         </div>      
        </form>
  </div>
</div>
<script type="text/javascript">

function btncargaroPimsS (){ 
        var mes=$("#selectmesOPIMSS").val();
        var archivoinfonavit=$("#archivoOpinionIMSS").val();
        if(mes==="0"){
           alert("Selecciona un mes");
           return;

        }else if(archivoinfonavit==""){
          alert("Selecciona archivo IMSS");
           return;
        }
        //información del formulario
        var formData = new FormData($("#formOpinionIMSS")[0]);
        formData.append('mes', mes);
         
        $.ajax({            
            type: "POST",
            url: "ajax_uploadOpinionCumplimientoIMSS.php",
            data:formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){ 
                    var msj=response.message;
                    if(response.status=='success'){   
        				    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#formOpinionIMSS")[0].reset(); 
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');                     
                    }else{
                          alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                          $("#formOpinionIMSS")[0].reset(); 
                          $("#alertMsg").html(alertMsg1);                    
                          $('#msgAlert').delay(2000).fadeOut('slow');       
                    }
            },
            //si ha ocurrido un error
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
  }



</script>