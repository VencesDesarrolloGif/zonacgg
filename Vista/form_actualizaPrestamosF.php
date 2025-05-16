<div align="center">
  <h2>Actualización de prestamos para finiquitos</h2>
  <br>
  <select id="slPeriodoPF" name="slPeriodoPF" class="input-large ">
              <option value="">PERIODO</option>
                <?php
                  for ($i = 0; $i < count($catalogoPeriodos); $i++)
                  {
                    echo "<option value='" . $catalogoPeriodos [$i]["tipoPeriodoId"] . "' >" . $catalogoPeriodos [$i]["descripcionTipoPeriodo"] . " </option>";
                  }
                ?>
            </select>
  <div class="card border-primary mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Descargar Empleados</h4></div>
    <div class="card-body text-primary">
       <button class="btn-primary" onclick="getEmpleadosWithPrestamos()">Descargar</button>
    </div>
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Actualizar Prestamos</h4></div>
	   <form enctype='multipart/form-data' id='formDeudores' name='formDeudores'>
    <div class="card-body text-primary">
			<label class="control-label label" for="prestamosF">Selecciona archivo: </label>
           <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='prestamosF' name='prestamosF'/> 
            </span>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <h4 id="hultimaveprestamosfiniquito"></h4>
</div>
<script type="text/javascript">

  
  
  var fileExtension="";

  $('#prestamosF').change(function(){      
       var periodo=$('select[name="slPeriodoPF"] option:selected').text();
      if(periodo=="PERIODO"){
        alert("Seleccione el periodo");
        $("#formDeudores")[0].reset();
        return ;
      }         
      var file = $("#prestamosF")[0].files[0];      
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        //información del formulario
        var formData = new FormData($("#formDeudores")[0]);
        formData.append('tipo', 'prestamosF'+periodo);
        formData.append('documento', 'prestamosF');
        
        //var message = ""; 
        //hacemos la petición ajax  
        /*for (var value of formData.values()) {
              console.log(value); 
        }*/        
        if(!isDocument(fileExtension))
        {                  
          alert("Formato de archivo incorrecto");
          return;                  
        }    
        $.ajax({
            url: 'upload_deudores.php',  
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
				        actualizaDeudores();                              
            },
            //si ha ocurrido un error
            error: function(){
                alert("Error inesperado");
            }
        });
  });  


  function actualizaDeudores(){
      var periodo=$('select[name="slPeriodoPF"] option:selected').text();      
      waitingDialog.show();
  		$.ajax({
            
            type: "POST",
            url: "ajax_actualizarDeudores.php", 
            data: {"tipo": "prestamosF"+periodo},         
            dataType: "json",
             success: function(response) {
             	var mensaje=response.mensaje;             	
                if (response.status == "correcto")
                {             		
                   alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Correcto: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#formDeudores")[0].reset(); 
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(2000).fadeOut('slow');   
                    calculoFiniquito(0);                                       
                    waitingDialog.hide(); 


                }else
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#formDeudores")[0].reset(); 
                        $("#alertMsg").html(alertMsg1);
                        $('#msgAlert').delay(2000).fadeOut('slow'); 
                        waitingDialog.hide(); 

                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
                  //alert("Error funcion")
                  waitingDialog.hide(); 

            }
        });
  }

  function isDocument(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'xlsx':
            return true;
        break;        
        default:
            return false;
        break;
    }
}     


function getEmpleadosWithPrestamos()
{
        
  var periodo=$("#slPeriodoPF").val();
  if(periodo==""){
      alert("Seleccione el periodo");
      return 0;
  } 

  window.open("empleadosWithPrestamos.php?option=21&periodo="+periodo,'_self');

}


$("#slPeriodoPF").change(function(){
var periodo=$('select[name="slPeriodoPF"] option:selected').text();
consultarultimasubidadeduccionprestamofiniquito(periodo);
});

function consultarultimasubidadeduccionprestamofiniquito(periodo){
  $.ajax({
            type: "POST",
            url: "ajax_getultimadeduccion.php",  
            data: {"tipo": "prestamosF"+periodo},        
            dataType: "json",
             success: function(response) {
              //console.log("ultimadeduccionsubida");
             // console.log(response);
              if(response.datos.length!=0){
                var fecha =response.datos[0].fecha;
                $("#hultimaveprestamosfiniquito").html("Última Carga de Archivo: "+ fecha);          
              }else{$("#hultimaveprestamosfiniquito").html("Última Carga de Archivo: Sin Información");}
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
               
            }
        });
}

  

</script>