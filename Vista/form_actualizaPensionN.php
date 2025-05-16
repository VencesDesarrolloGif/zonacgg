<div align="center">
  <h2>Actualización de Pensiones para Nominas</h2>
  <br>
  <select id="slPeriodoPN" name="slPeriodoPN" class="input-large ">
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
       <button class="btn-primary" onclick="getEmpleadosWithPensionN()">Descargar</button>
    </div>
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Actualizar Pensiones</h4></div>
	   <form enctype='multipart/form-data' id='pensionNomina' name='pensionNomina'>
    <div class="card-body text-primary">
			<label class="control-label label" for="deudorPensionN">Selecciona archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='deudorPensionN' name='deudorPensionN'/> 
          </span>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <h4 id="hultimavezpensionnomina"></h4>
</div>
<script type="text/javascript">


  
  var fileExtension="";

  $('#deudorPensionN').change(function(){           
      var periodo=$('select[name="slPeriodoPN"] option:selected').text();
      if(periodo=="PERIODO"){
        alert("Seleccione el periodo");
        $("#pensionNomina")[0].reset();
        return ;
      }
      var file = $("#deudorPensionN")[0].files[0];      
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        //información del formulario
        var formData = new FormData($("#pensionNomina")[0]);
        formData.append('tipo', 'pensionN'+periodo);
        formData.append('documento', 'deudorPensionN');
        
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
        var msj=verificarCierrePeriodo($("#slPeriodoPN").val());
        if(msj!='correcto'){
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";             
              $("#alertMsg").html(alertMsg1);
              $('#msgAlert').delay(2000).fadeOut('slow'); 
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
				        actualizaPensionNomina();                              
            },
            //si ha ocurrido un error
            error: function(){
                alert("Error inesperado");
            }
        });
  });  


  function actualizaPensionNomina(){
    //alert("actualizando");
    var periodo=$('select[name="slPeriodoPN"] option:selected').text();
    waitingDialog.show();
  		$.ajax({
            
            type: "POST",
            url: "ajax_actualizarDeudores.php",  
            data: {"tipo": "pensionN"+periodo},        
            dataType: "json",
             success: function(response) {
             	var mensaje=response.mensaje;             	
                if (response.status == "correcto")
                {             		
                   alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Correcto: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#pensionNomina")[0].reset(); 
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(2000).fadeOut('slow');                         
                    waitingDialog.hide();                   

                }else
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensjae+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#pensionNomina")[0].reset();
                        $("#alertMsg").html(alertMsg1);
                        $('#msgAlert').delay(2000).fadeOut('slow'); 
                        waitingDialog.hide();                   
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
                  //alert("Error funcion")
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


function getEmpleadosWithPensionN()
{
        
//  alert(apellido);  
  var periodo=$("#slPeriodoPN").val();
  if(periodo==""){
      alert("Seleccione el periodo");
      return 0;
  }
  window.open("empleadosWithPrestamos.php?option=31&periodo="+periodo,'_self');

}

$("#slPeriodoPN").change(function(){
var periodo=$('select[name="slPeriodoPN"] option:selected').text();
consultarultimasubidadeduccionpensionnomina(periodo);
});

function consultarultimasubidadeduccionpensionnomina(periodo){
  $.ajax({
            type: "POST",
            url: "ajax_getultimadeduccion.php",  
            data: {"tipo": "pensionN"+periodo},        
            dataType: "json",
             success: function(response) {
              //console.log("ultimadeduccionsubida");
             // console.log(response);
              if(response.datos.length!=0){
                var fecha =response.datos[0].fecha;
                $("#hultimavezpensionnomina").html("Última Carga de Archivo: "+ fecha);          
              }else{$("#hultimavezpensionnomina").html("Última Carga de Archivo: Sin Información");}
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
               
            }
        });
}



  

</script>