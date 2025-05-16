<div id="alertMsgAsignaciones"></div>
<br>
  <select id="selectSupervisorAsignacion" name="selectSupervisorAsignacion" class="input-xlarge" onchange="getListaPuntosServiciosBySupervisor();" >
      <option>SUPERVISOR</option>
              <?php
                for ($i=0; $i<count($catalogoSupervisoresOperativos); $i++)
                {
                echo "<option value='". $catalogoSupervisoresOperativos[$i]["supervisorId"]."'>". $catalogoSupervisoresOperativos[$i]["nombre"] ." </option>";
                }
              ?>
    </select>
    <br>
    <br>
<div class="divServicios" >
  <h4>Eliminación de puntos de servicios</h4>
    <br>
    <input type="text" name="txtSearchPunto" id="txtSearchPunto"class="search-query " aria-describedby="basic-addon2" onkeyup="" onblur=""><img src="img/search.png"><img src="img/refresh-icon.png" class="cursorImg" onclick="getListaPuntosServiciosBySupervisor();">
    <br>
    <br>
  <h4>Puntos de servicios asignados al supervisor</h4>
  <div id="divLista" name="divLista">

    <ul class='list' id='lhs' name='lhs'>
      
    </ul>

  </div>
</div>
<div class="divServicios">
	<div class="trash" id="makeMeDroppable"> 
  </div>
</div>

<div class='divServicios'>
  <h4>Asignación de Puntos</h4>
      <br>
    <input type="text" name="txtSearchPuntoName" id="txtSearchPuntoName"class="search-query " aria-describedby="basic-addon2" onkeyup="" onblur=""><img src="img/search.png"><img src="img/refresh-icon.png" class="cursorImg" onclick="puntosServiciosGenerales();">
    <br>
    <br>
  <h4>Catalogo Puntos de Servicios</h4>
  <div id="divListaServicios" name="divListaServicios" class="input-group">
    
  <br>

    <ul class='list' id='lhs1' name='lhs1'>
      
    </ul>

  </div>
</div>

<script type="text/javascript">

$( init );

function init() {

  $('#makeMeDroppable').droppable( {
    drop: handleDropEvent
  } );

}

function handleDropEvent( event, ui ) {
  
  var draggable = ui.draggable;
  var id = draggable.attr('id');
  var puntoServicio=draggable.attr('puntoServicio');
  //alert(puntoServicio);

  eliminarAsignacion(id,puntoServicio);
  }


function getListaPuntosServiciosBySupervisor()
    {
      var supervisorId='';
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"):
      ?>
      supervisorId=$("#selectSupervisorAsignacion").val();
      <?php
      endif;
      ?>

       $.ajax({
            type: "POST",
            url: "ajax_getPuntosBySupervisor.php",
            data: {"supervisorId":supervisorId},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntos = response.puntos;
                    var puntosOptions = "";
                    //var puntosOptions = "<ul class='list' id='lhs' name='lhs'>";
                    for (var i = 0; i < puntos.length; i++)
                    {

                      var puntoServicio=puntos[i].puntoServicio;

                        puntosOptions += "<li class='class' id='li_"+puntos[i].puntoServicioId+"' name='li_"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "' puntoServicio='"+puntoServicio+"' >" + puntos[i].puntoServicio + "";
                        puntosOptions +="<span class='input-group-addon cursorImg' onclick='eliminarAsignacion("+puntos[i].puntoServicioId+" ,\"" + puntoServicio + "\");' >x</span></li>";
                    }
                      $("#lhs").html (puntosOptions);
                      init();
                      $('#lhs').sortable({ connectWith: '#makeMeDroppable' })
                      $("#lhs" ).disableSelection();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }

    function getListaPuntosServiciosBySupervisorAndNombre()
    {
      var supervisorId='';
      var nombre=$("#txtSearchPunto").val();
      <?php
      if($usuario["rol"] =="Analista Asistencia" || $usuario["rol"] =="Facturacion"):
      ?>
      supervisorId=$("#selectSupervisorAsignacion").val();
      <?php
      endif;
      ?>
       $.ajax({
            type: "POST",
            url: "ajax_getPuntosServiciosBySupervisorAndNombrePunto.php",
            data: {"supervisorId":supervisorId, "nombre":nombre},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntos = response.puntos;
                    var puntosOptions = "";
                    //var puntosOptions = "<ul class='list' id='lhs' name='lhs'>";
                    for (var i = 0; i < puntos.length; i++)
                    {
                      var puntoServicio=puntos[i].puntoServicio;
                        puntosOptions += "<li class='class' id='li_"+puntos[i].puntoServicioId+"' name='li_"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "' puntoServicio='"+puntoServicio+"' >" + puntos[i].puntoServicio + "";
                        puntosOptions +="<span class='input-group-addon cursorImg' onclick='eliminarAsignacion("+puntos[i].puntoServicioId+" ,\"" + puntoServicio + "\");' >x</span></li>";
                    }
                      $("#lhs").html (puntosOptions);
                      $('#lhs').sortable({ connectWith: '#makeMeDroppable' })
                      $("#lhs" ).disableSelection();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }

        function eliminarAsignacion(id,puntoServicio){

        var supervisorId=$("#selectSupervisorAsignacion").val();
        var idPunto = id;
        

       $.ajax({
            type: "POST",
            url: "ajax_elimiarAsignacionPuntoSupervisor.php",
            data: {idPunto:idPunto, supervisorId:supervisorId},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {
            
                    $("#"+ id).remove();
                    alert("El punto de servicio "+ puntoServicio +" fue eliminado");
                    getListaPuntosServiciosBySupervisor();

                } else if (response.status=="error")
                {
                    alert(mensaje);
                }

              },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });  

  
      }

function puntosServiciosGenerales()
    {
      
       $.ajax({
            type: "POST",
            url: "ajax_getPuntosByAnalista.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntos = response.puntos;
                    var puntosOptions = "";

                    for (var i = 0; i < puntos.length; i++)
                    {
                      var idPuntoServicio=puntos[i].idPuntoServicio;
                      var puntoServicio=puntos[i].puntoServicio;

                      //alert(idPuntoServicio+"-"+puntoServicio);

                        puntosOptions += "<li class='class' id='lip_"+puntos[i].puntoServicioId+"' name='lip_"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "' >" + puntos[i].puntoServicio + "";
                        puntosOptions += "<span class='input-group-addon cursorImg' onclick='asignarPunto("+idPuntoServicio+" ,\"" + puntoServicio + "\");' >+</span></li>";

                    }


                      $("#lhs1").html (puntosOptions);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }


    function getListaPuntosServiciosByNombre()
    {
      
      var nombre=$("#txtSearchPuntoName").val();
      
       $.ajax({
            type: "POST",
            url: "ajax_getPuntosServiciosByNombrePunto.php",
            data: {"nombre":nombre},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var puntos = response.puntos;
 
                    var puntosOptions = "";

                    for (var i = 0; i < puntos.length; i++)
                    {

                      var idPuntoServicio=puntos[i].idPuntoServicio;
                      var puntoServicio=puntos[i].puntoServicio;

                        puntosOptions += "<li class='class' id='lip_"+puntos[i].puntoServicioId+"' name='lip_"+puntos[i].puntoServicioId+"' value='" + puntos[i].puntoServicioId + "' >" + puntos[i].puntoServicio + "";
                        puntosOptions += "<span class='input-group-addon cursorImg' onclick='asignarPunto("+idPuntoServicio+" ,\"" + puntoServicio + "\");' >+</span></li>";
                    }


                      $("#lhs1").html (puntosOptions);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });
    }

  
    function asignarPunto(idPuntoServicio, puntoServicio)
    {
      var supervisorId=$("#selectSupervisorAsignacion").val();
      // alert("entre");
      if(supervisorId=="SUPERVISOR"){
        alert("Seleccione supervisor");
      
      }else{
          // alert("entre dos jaja");
            $.ajax({
            type: "POST",
            url: "ajax_asignacionPuntoServicioSupervisor.php",
            data: {"supervisorId":supervisorId,"puntoServicioId":idPuntoServicio },
            dataType: "json",
            success: function(response) {
              var mensaje=response.message;

                if (response.status == "success")
                { 
                    
                    var lista = document.getElementById("lhs");
                    var nuevoElemento = "<li class='class' id='li_"+idPuntoServicio+"' name='li_"+idPuntoServicio+"' value='" + idPuntoServicio + "' >" + puntoServicio+ "</li>";
                    lista.innerHTML = lista.innerHTML + nuevoElemento;

                    alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Asignacion Puntos Servicios: </strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsgAsignaciones").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Error en Asignacion Puntos Servicios:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsgAsignaciones").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }        });

        //alert (idPuntoServicio +"-"+ supervisorId+" "+puntoServicio);
         

      }

    }


       $('#txtSearchPunto').keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which);  
      if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           getListaPuntosServiciosBySupervisorAndNombre();
           //$("#txtSearch").val("");
        }   
      }); 


       $('#txtSearchPuntoName').keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which);  
      if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           getListaPuntosServiciosByNombre();
           //$("#txtSearch").val("");
        }   
      }); 

</script>

<script language="javascript">
$(puntosServiciosGenerales());  
</script>