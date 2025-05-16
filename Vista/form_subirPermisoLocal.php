<div align="center">
  <h2>Subir Permiso Local</h2>
  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Seleccione entidad</h4></div>
            <select id="slEntidadPer" name="slEntidadPer" class="input-large ">
                      <option value="">ENTIDAD</option>
                        <?php
                          for ($i = 0; $i < count($catalogoEntidadesFederativas); $i++)
                          {
                            echo "<option value='" . $catalogoEntidadesFederativas [$i]["idEntidadFederativa"] . "' >" . $catalogoEntidadesFederativas [$i]["nombreEntidadFederativa"] . " </option>";
                          }
                        ?>
                    </select>
	   <form enctype='multipart/form-data' id='formPermisoL' name='formPermisoL'>
    <div class="card-body text-primary">
			<label class="control-label label" for="permisoL">Selecciona archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='permisoL' name='permisoL'/>  
          </span>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
</div>
<script type="text/javascript">


  
  var fileExtension="";

  $('#permisoL').change(function(){     
        var entidad=$("#slEntidadPer").val();

        if(entidad==""){
            alert("Seleccione una entidad");
            $("#formC3")[0].reset();
            return ;
        }  

        var file = $("#permisoL")[0].files[0];      
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        //información del formulario
        var formData = new FormData($("#formPermisoL")[0]);
        formData.append('tipo', 'permisoL');
        formData.append('entidad', entidad);
        //var message = ""; 
        //hacemos la petición ajax  
        /*for (var value of formData.values()) {
              console.log(value); 
        }*/        
        if(!isDocumentPDF2(fileExtension))
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
                   $("#formPermisoL")[0].reset(); 
                    $("#alertMsg").html(alertMsg1);                    
                    $('#msgAlert').delay(2000).fadeOut('slow');                     
            },
            //si ha ocurrido un error
            error: function(){
                alert("Error inesperado");
            }
        });
  });  

  function isDocumentPDF2(extension)
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