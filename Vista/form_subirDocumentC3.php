<div align="center">
<h2>DC-3 PDF</h2>
<div class="card border-primary mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Seleccione entidad y cliente</h4></div>
      <select id="slClienteC3" name="slClienteC3" class="input-large ">
              <option value="">CLIENTE</option>
                <?php
                  for ($i = 0; $i < count($catatoloClientes); $i++)
                  {
                    echo "<option value='" . $catatoloClientes [$i]["idCliente"] . "' >" . $catatoloClientes [$i]["razonSocial"] . " </option>";
                  }
                ?>
            </select>
            <select id="slEntidadC3" name="slEntidadC3" class="input-large ">
              <option value="">ENTIDAD</option>                
            </select>
  </div>  
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Subir Documento DC-3</h4></div>    
	   <form enctype='multipart/form-data' id='formC3' name='formC3'>
    <div class="card-body text-primary">
			<label class="control-label label" for="docuC3[]">Selecciona archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='docuC3[]' name='docuC3[]' multiple="" accept=".pdf"/>  
          </span>
          <button type="button" class="btn btn-primary" onclick="subirDS3()">Cargar</button>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
</div>
<script type="text/javascript">


  function subirDS3(){     
        var entidad= $("#slEntidadC3").val();
        var cliente= $("#slClienteC3").val();
      //alert("entidad: "+entidad+" CLIENTE: "+cliente);
      if(entidad==""){
        alert("Seleccione una entidad");
        $("#formC3")[0].reset();
        return ;
      }  

      if(cliente==""){
        alert("Seleccione un cliente");
        $("#formC3")[0].reset();
        return ;
      }                  

        //información del formulario
        var formData = new FormData($("#formC3")[0]);        
        formData.append('entidad', entidad);
        formData.append('cliente', cliente);
        //var message = ""; 
        //hacemos la petición ajax  
        /*for (var value of formData.values()) {
              console.log(value); 
        }*/          
        $.ajax({
            type: "POST",
            url: "upload_DS3.php",
            data:formData,
            dataType: "json",

            cache: false,
            contentType: false,
            processData: false,        
            //una vez finalizado correctamente
            success: function(response){    
			         var msj=response.message;
                if(response.status=='success'){   
                    //alert("subido");
                          alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#formC3")[0].reset(); 
                        $("#alertMsg").html(alertMsg1);                    
                        $('#msgAlert').delay(2000).fadeOut('slow');                     
                }else{
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#formC3")[0].reset(); 
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
  

$("#slClienteC3").change(function() {
    var cliente = $("#slClienteC3").val();
    //1=percepciones
    //2=deducciones    
    $("#slEntidadC3").empty();  
    $('#slEntidadC3').append('<option value="">ENTIDAD</option>');
    if(cliente != ""){
        $.ajax({
            type: "POST",
            url: "ajax_obtenerEntidadesByCliente.php",
            data: {
                "cliente": cliente,
            },
            dataType: "json",
            success: function(response) {
                // console.log(response);
                var entidades = response.datos;                              
                $.each(entidades, function(i) {
                     $('#slEntidadC3').append('<option value="' + entidades[i].idEntidadFederativa + '">' +  entidades[i].nombreEntidadFederativa + '</option>');

                });               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });            
    }
});  


</script>