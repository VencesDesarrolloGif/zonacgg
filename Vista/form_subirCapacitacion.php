<div align="center">
  <h2>Subir Formato de Capacitación</h2>
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Seleccione Cliente</h4></div>
      <select id="selClienteC" name="selClienteC" class="input-large ">
              <option value="">CLIENTE</option>
                <?php
                  for ($i = 0; $i < count($catatoloClientes); $i++)
                  {
                    echo "<option value='" . $catatoloClientes [$i]["idCliente"] . "' >" . $catatoloClientes [$i]["razonSocial"] . " </option>";
                  }
                ?>
            </select>
    <div class="card-header"></div>     
	   <form enctype='multipart/form-data' id='formCapacitacion' name='formCapacitacion'>
    <div class="card-body text-primary">
			<label class="control-label label" for="capacitacion">Selecciona archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='capacitacion' name='capacitacion'/>  
          </span>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
</div>
<script type="text/javascript">


  
  var fileExtension="";

  $('#capacitacion').change(function(){     
        var cliente= $("#selClienteC").val();

        if(cliente==""){
            alert("Seleccione un cliente");
            $("#formCapacitacion")[0].reset();
            return ;
        }     
        var file = $("#capacitacion")[0].files[0];      
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        //información del formulario
        var formData = new FormData($("#formCapacitacion")[0]);
        formData.append('tipo', 'capacitacion');
        formData.append('cliente', cliente);
        //var message = ""; 
        //hacemos la petición ajax  
        /*for (var value of formData.values()) {
              console.log(value); 
        }*/        
        if(!isDocumentPDF(fileExtension))
                {                  
                  alert("Formato de archivo incorrecto");
                  return;                  
                }    
        $.ajax({
            url: 'upload_documentoCliente.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,


            //mientras enviamos el archivo
            beforeSend: function(){
                //message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                //showMessage(message)                    
            },
            //una vez finalizado correctamente
            success: function(data){    
				      alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#formCapacitacion")[0].reset(); 
                    $("#alertMsg").html(alertMsg1);                    
                    $('#msgAlert').delay(2000).fadeOut('slow');                     
            },
            //si ha ocurrido un error
            error: function(){
                alert("Error inesperado");
            }
        });
  });  

  function isDocumentPDF(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'pdf':
            return true;
        break;        
        default:
            return false;
        break;
    }
}     



</script>