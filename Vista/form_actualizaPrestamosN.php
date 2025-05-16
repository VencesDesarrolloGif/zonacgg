<div align="center">
  <h2>Actualización de Prestamos para Nominas</h2>
  <br>
  <select id="slPeriodoPNo" name="slPeriodoPNo" class="input-large ">
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
       <button class="btn-primary" onclick="getEmpleadosPrestamoN()">Descargar</button>
    </div>
  </div>

  <div class="card border-success mb-3" style="max-width: 50rem;">
    <div class="card-header"><h4>Actualizar Prestamos</h4></div>
     <form enctype='multipart/form-data' id='prestamoNomina' name='prestamoNomina'>
    <div class="card-body text-primary">
      <label class="control-label label" for="deudorPrestamoN">Selecciona archivo: </label>
          <span class="btn btn-success btn-file" >Examinar
            <input type='file' class='btn-success' id='deudorPrestamoN' name='deudorPrestamoN'/> 
          </span>
    </div>            
    </form>
    <!--<button class='btn btn-success' type='button' onclick='actualizarDeudores();'> <img src='img/hojaDatos.png' width='20%'>Formato Alta</button>-->
  </div>
  <h4 id="hultimaveprestamosnomina"></h4>
</div>
<script type="text/javascript">


  
  var fileExtension="";

  $('#deudorPrestamoN').change(function(){  
      var periodo=$('select[name="slPeriodoPNo"] option:selected').text();
      if(periodo=="PERIODO"){
        alert("Seleccione el periodo");
        $("#prestamoNomina")[0].reset();
        return ;
      }         
      var file = $("#deudorPrestamoN")[0].files[0];      
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;

        //información del formulario
        var formData = new FormData($("#prestamoNomina")[0]);
        formData.append('tipo', 'prestamosN'+periodo);
        formData.append('documento', 'deudorPrestamoN');
        
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
        var msj=verificarCierrePeriodo($("#slPeriodoPNo").val());
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
                actualizaPrestamoNomina();                              
            },
            //si ha ocurrido un error
            error: function(){
                alert("Error inesperado");
            }
        });
  });  //que veas que si funcionana tus putadas
 

  function actualizaPrestamoNomina(){
    var periodo=$('select[name="slPeriodoPNo"] option:selected').text();
    //alert("actualizando");
    waitingDialog.show();
      $.ajax({
            
            type: "POST",
            url: "ajax_actualizarDeudores.php",  
            data: {"tipo": "prestamosN"+periodo},        
            dataType: "json",
             success: function(response) {
              var mensaje=response.mensaje;               
                if (response.status == "correcto")
                {                 
                   alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Correcto: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   $("#prestamoNomina")[0].reset(); 
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert').delay(2000).fadeOut('slow');                         
                    waitingDialog.hide();                   

                }else
                {
                    alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+mensjae+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       $("#prestamoNomina")[0].reset();
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


function getEmpleadosPrestamoN()
{
        
//  alert(apellido);  
  var periodo=$("#slPeriodoPNo").val();
  if(periodo==""){
      alert("Seleccione el periodo");
      return 0;
  }
  window.open("empleadosWithPrestamos.php?option=31&periodo="+periodo,'_self');
  //verificarCierrePeriodo(1);

}

$("#slPeriodoPNo").change(function(){
var periodo=$('select[name="slPeriodoPNo"] option:selected').text();
consultarultimasubidadeduccionprestamonomina(periodo);
});

function consultarultimasubidadeduccionprestamonomina(periodo){
  $.ajax({
            type: "POST",
            url: "ajax_getultimadeduccion.php",  
            data: {"tipo": "prestamosN"+periodo},        
            dataType: "json",
             success: function(response) {
              //console.log("ultimadeduccionsubida");
             // console.log(response);
              if(response.datos.length!=0){
                var fecha =response.datos[0].fecha;
                $("#hultimaveprestamosnomina").html("Última Carga de Archivo: "+ fecha);          
              }else{$("#hultimaveprestamosnomina").html("Última Carga de Archivo: Sin Información");}
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);
               
            }
        });
}




  

</script>