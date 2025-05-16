
  

  <form class="form-horizontal" action='ajax_registrarVisitante.php' method="post" id="form_RegistrarVisitante" >
    <fieldset>
      
      <div >
        <code>Registro De Vistante</code> 
        <table class="table">
        <thead>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Nombre</th>
          <th>Area de Visita</th>
          <th>Asunto</th>
          <th>Identificación</th>
          <th>Empresa</th>

         
          </thead>
          <tbody>
          <tr>
          <td><input id="vApellidoPaterno" name="vApellidoPaterno" type="text" placeholder="LETRAS" class="input-medium" ></td>
          <td><input id="vApellidoMaterno" name="vApellidoMaterno" type="text" placeholder="LETRAS" class="input-medium" ></td>
          <td><input id="vNombre" name="vNombre" type="text" placeholder="LETRAS" class="input-medium" ></td>
          <td><select id="areaVisita" name="areaVisita" class="input-medium " onChange="obtenerPosiblesAasuntosPorArea();">
                <option>AREA DE VISITA</option>
                <?php
                for ($i = 0 ; $i < count($catalogoDepartamentos); $i++)
                {
                  echo "<option value='" . $catalogoDepartamentos [$i]["idDepto"] . "' >" . $catalogoDepartamentos [$i]["nombreDepto"] . " </option>";
                }
                ?>
                </select></td>
                <td>

                <select id="asuntoVisita" name="asuntoVisita" class="input-medium ">
               
              </select>
            </td>
            <td><select id="identificacion" name="identificacion" class="input-medium " >
               <option>IDENTIFICACION</option>
                <?php
                for ($i = 0 ; $i < count($catalogoIdentificaciones); $i++)
                {
                  echo "<option value='" . $catalogoIdentificaciones [$i]["idIdentificacion"] . "' >" . $catalogoIdentificaciones [$i]["nombreIdentifiacion"] . " </option>";
                }
                ?>
            </select></td>
            <td><input id="vEmpresa" name="vEmpresa" type="text" placeholder="LETRAS" class="input-medium" ></td>
              <td><button id="guardar" name="guardar" class="btn btn-primary" type="button" onclick="guardarVisitanteSubmit();"> Guardar</button></td>
            </tr>
          </tbody>
       </table>

    </div>
  </fieldset>
  <legend>Libro de Visitas</legend>
  <div>
 

    <div  class='tab-content' id="listaDeVisitantes">
   
    </div>

    <div id="paginacion" class='pagination' align="center">
   
    </div >
 </div>
</form>
 
<script type="text/javascript">

  function obtenerPosiblesAasuntosPorArea()
    {
       
       var mitexto = $("#areaVisita option:selected").text();
       var departamentoId = $("#areaVisita").val();

      $.ajax({
            type: "POST",
            url: "ajax_seleccionarAsuntoPorDepartamento.php",
            data: {"areaVisita": departamentoId},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                    var listaAsuntos = response.listaAsuntos;
                    
                    posiblesAsuntosOptions = "<option> ASUNTO </option>";
                    for (var i = 0; i < listaAsuntos.length; i++)
                    {
                        posiblesAsuntosOptions += "<option value='" + listaAsuntos[i].idAsunto + "'>" + listaAsuntos[i].descripcionAsunto + "</option>";
                    }
                    
                    $("#asuntoVisita").html (posiblesAsuntosOptions);
                                     
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    
      }

    function guardarVisitanteSubmit()
    {
        var datastring = $("#form_RegistrarVisitante").serialize();
       
        $.ajax({
            type: "POST",
            url: "ajax_registrarVisitante.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {

                  alertMsg1="<div class='alert alert-success'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                    $("#vApellidoPaterno").val('');
                    $( "#vApellidoMaterno" ).val('');
                    $( "#vNombre" ).val('');
                    $("#listaPreviaVisitantes").remove();

                    obtenerListaVisitantesDelDia(0,10); 
                    obtenerNumeroPaginas();
                          
                    
                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
                else if (response.status=="error")
                {
                  alertMsg1="<div class='alert alert-error'><strong>Error en el registro del empleado:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $(document).scrollTop(0);
                }

            },
            error: function(){
                  alert('error handing here');
            }
        });
    }

    function obtenerListaVisitantesDelDia(inicio, numeroVisitantesPorPagina)
    {
      
      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerListaVisitantesDelDia.php",
            dataType: "json",
            data:{inicio:inicio,visitantesPorPagina:numeroVisitantesPorPagina},
            success: function(response) {
                if (response.status == "success")
                {
                  
                    var listaVisitantes = response.listaVisitantesDelDia;

                    
                    listaVisitantesTable="<table class='table table-hover'><thead><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th><th>Area Visita</th><th>Asunto</th><th>Identificacion</th><th>Hora Entrada</th></thead><tbody>";

                    for ( var i = 0; i < listaVisitantes.length; i++ ){
                      var visitanteId = listaVisitantes[i].idVisitante;



                      listaVisitantesTable += "<tr><td>"+listaVisitantes[i].visitanteApPaterno+" </td><td>"+listaVisitantes[i].visitanteApMaterno+"</td><td>"+listaVisitantes[i].visitanteNombre+"</td><td>"+listaVisitantes[i].nombreDepto+"</td><td>"+listaVisitantes[i].descripcionAsunto+"</td><td>"+listaVisitantes[i].nombreIdentifiacion+"</td><td>"+listaVisitantes[i].horarioEntrada+"</td><td><button id='btnregistrarSalida' name='guardar' class='btn btn-success' type='button' onclick='actualizarEstatusVisitante(\""+visitanteId+"\",3); ' >Registrar Salida</button></td><tr>";
                    }

                    listaVisitantesTable += "</tbody></table>";
                    $('#listaDeVisitantes').html(listaVisitantesTable); 
                    $( "#listaPreviaVisitantes" ).remove();
                   

                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });
    }

    function obtenerNumeroPaginas()
    {
      
      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerTotalVisitantesDelDia.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                  var numeroVisitantes = response.numeroDeVisitantesDelDia;
                  var numeroVisitantesPorPagina=10;
                  var numeroTotalPaginas= numeroVisitantes/numeroVisitantesPorPagina;
                             
                  paginacion = " <ul class='pagination'>" ;

                  spanVisitantes="Libro de Vistantes<span class='badge' >"+numeroVisitantes+"</span>" ;
                   $('#spanVisitantes').html(spanVisitantes); 


                  for(var i = 0 ; i < numeroTotalPaginas; i++)
                  {
                   var inicio = ((i+1)-1)*numeroVisitantesPorPagina;
                    paginacion += "<li ><a onclick='obtenerListaVisitantesDelDia(\""+inicio+"\",\""+numeroVisitantesPorPagina+"\");'>"+ (i + 1) +" </a></li>";

                  } 

                    paginacion += "</ul>";
                                                 
                    $('#paginacion').html(paginacion); 

                }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);
                console.log(paginasTotales);

            }
        });
    }


function actualizarEstatusVisitante(visitanteId, estatusVisitante)
    {
      
      var visitante= visitanteId;


        $.ajax({
            
            type: "POST",
            url: "ajax_actualizarEstatusVisitante.php",
            data:{"visitanteIdEstatus":estatusVisitante, "idVisitante": visitante},
            dataType: "json",
            success: function(response) {
                
                if (response.status=="success") {

                  obtenerListaVisitantesDelDia(0,10); 
                  obtenerNumeroPaginas();
                   
                }

            },
            error: function(){
                  alert('error handing here');

            }
        });
    }

    function mandarmensaje(inicio)
    {
      alert(inicio);
    }

    function obtenerListaVisitantesDelDiaParaDeptoRH()
    {
      
      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerListaVisitantesDelDiaParaRH.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                  
                    var listaVisitantesParaContratacion = response.listaVisitantesDelDiaParaContratacion;
              

                    listaVisitantesContratacionTable="<table class='table table-hover'><thead><th>Apellido Paterno</th><th>Apellido Materno</th><th>Nombre</th><th>Descripcion</th></thead><tbody>";

                    for ( var i = 0; i < listaVisitantesParaContratacion.length; i++ ){
                        var apellidoPaterno = listaVisitantesParaContratacion[i].visitanteApPaterno;
                        var apellidoMaterno = listaVisitantesParaContratacion[i].visitanteApMaterno;
                        var nombre = listaVisitantesParaContratacion[i].visitanteNombre;
                        var idVisitante = listaVisitantesParaContratacion[i].idVisitante;
                        
                        listaVisitantesContratacionTable += "<tr><td>"+apellidoPaterno+" </td><td>"+apellidoMaterno+"</td><td>"+nombre+"</td><td>"+listaVisitantesParaContratacion[i].descripcionAsunto+"</td><td><button id='btnregistrarSalida' name='guardar' class='btn btn-success' type='button' onclick='copiarDatosVisitanteParaContratacion (\"" + apellidoPaterno + "\", \"" + apellidoMaterno + "\", \"" + nombre + "\", \"" + idVisitante+ "\");'>Contratar</button></td></tr>";
                    }

                    listaVisitantesContratacionTable += "</tbody></table>";
                    $('#cajonleft').html(listaVisitantesContratacionTable); 
                    //$( "#listaPreviaVisitantes" ).remove();
                   

                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });
    }

    

</script>

 