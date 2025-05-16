<div>
    <div id="msgerrorandexito"></div>
        <input type="hidden" id="lineanegocioo1" class="input-xlarge">
        <input type="hidden" id="lineanegocioo2" class="input-xlarge">
        <input id="accion" type="hidden" value="0">
    <div id="hiddenRegistroSueldos">  
        <form class="form-horizontal" id="form_consultaTabulador" name="form_consultaTabulador" action="ficheroExcelTabulador.php?accion=1" target="_blank" method="post">
            <a id="aplantillasinactivas" style="cursor: pointer;display: none;">Plantillas Inactivas</a>
            <center>
                <h2>Registro de Sueldos</h2><br>
                <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick="crearTablaSueldos();" width="50px">
            </center><br>
            <div class="mensajeSueldo"></div>
            <input type="hidden" id="datos_tabulador" name="datos_tabulador" />
            <section> 
                <table id="editinplaceSueldo" style="display:none;"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th style="text-align: center;background-color: #B0E76E">Id Punto Servicio</th>
                            <th style="text-align: center;background-color: #B0E76E">Punto Servicio</th>
                            <th style="text-align: center;background-color: #B0E76E">Entidad Federativa</th>
                            <th style="text-align: center;background-color: #B0E76E">Cliente</th>
                            <th style="text-align: center;background-color: #B0E76E">Puesto</th>
                            <th style="text-align: center;background-color: #B0E76E">Rol</th>
                            <th style="text-align: center;background-color: #B0E76E">Rol Operativo</th>
                            <th style="text-align: center;background-color: #B0E76E">Estatus</th>
                            <th style="text-align: center;background-color: #B0E76E">Fecha Inicio servicio</th>
                            <th style="text-align: center;background-color: #B0E76E">Fecha término servicio</th>
                            <th style="text-align: center;background-color: #B0E76E">Sueldo</th>
                            <th style="text-align: center;background-color: #B0E76E">Editar</th>
                        </tr>
                    </thead>
                </table>
            </section>
    
        </form>
    </div>
    <div id="hiddenRegistroSueldosInactivos" style="display: none">  
        <form class="form-horizontal" id="form_consultaTabuladorplantillasinactivas" name="form_consultaTabuladorplantillasinactivas" action="ficheroExcelTabulador.php?accion=2" target="_blank" method="post">
            <a id="aplantillasactivas" style="cursor: pointer;">Registro Sueldos</a>
            <h2>Plantillas Inactivas</h2>
            <div class="mensajeSueldovvg"></div>
            <input type="hidden" id="datos_tabuladorplnatillasinactivas" name="datos_tabuladorplnatillasinactivas" />
            <table class="editinplace table table-hover" id="editinplaceSueldoPlantillasInactivas" name="editinplaceSueldoPlantillasInactivas">
              <tr>
                <th>Id Punto Servicio</th>
                <th>Punto Servicio</th>
                <th>Entidad Federativa</th>
                <th>Cliente</th>
                <th>Puesto</th>
                <th>Rol</th>
                <th>Rol Operativo</th>
                <th>Fecha Inicio servicio</th>
                <th>Fecha término servicio</th>
                <th>Accion</th>
              </tr>
            </table>
  
        </form>
    </div>
    <div id="modalActualizarSueldo"  style="display:none;" name="modalActualizarSueldo" class="modalEdit hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="mensajeErrorSuledoModal"></div>
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"> <img src="img/warning.png">¿DESEA ACTUALIZAR EL SUELDO DEL PUNTO DE SERVICIO?</h4>
        </div>
        <div class="modal-body">
            <div class="input-prepend">
                <span class="add-on">ID PUNTO SERVICIO</span>
                <input id="idPuntoModalSueldo" name="idPuntoModalSueldo" type="text" class="input-small" readonly>
            </div>
            <div class="input-prepend">
                <span class="add-on">SUELDO ACTUAL</span>
                <input id="sueldoModalSueldo" name="sueldoModalSueldo" type="text" class="input-medium" readonly >
                <span class="add-on">NUEVO SUELDO</span>
                <input id="SueldoNuevoModalSueldo" name="SueldoNuevoModalSueldo" type="text" class="input-medium">
            </div>
            <div class="input-prepend">
                <input id="puestoPlantillaIdHidden" name="puestoPlantillaIdHidden" type="hidden" class="input-small" readonly>
                <input id="tipoTurnoPlantillaIdHidden" name="tipoTurnoPlantillaIdHidden" type="hidden" class="input-small" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="botonNormal rojoTransparente" data-dismiss="modal">Cancelar</button>
            <button type="button" class="botonNormal verdeTransparente" onclick='guardarNuevoSueldoParaPuntosServicio();'>Guardar Cambios</button>
        </div>
    </div>  <!-- FIN MODAL BAJA EMPLEADO -->
</div>
<script type="text/javascript">

// $(inicioRegSueldo());  

function inicioRegSueldo(){

    //alert("hola");
    <?php
    if ($usuario["rol"] =="Ventas" || $usuario["rol"] == "Administracion Seguridad Electronica")
  {
  ?> 

      <?php
      if ($usuario["rol"] =="Ventas")
      {
      ?>
      $("#lineanegocioo1").val(1);
      $("#lineanegocioo2").val(3);
      <?php
      }
      ?>


      <?php
      if ($usuario["rol"] == "Administracion Seguridad Electronica")
      {
      ?>
      $("#lineanegocioo1").val(2);
      $("#lineanegocioo2").val(4);
      <?php
      }
      ?> 
      $("#accion").val(0);
     crearTablaSueldos();

         var td,campo,valorSueldo,id, puestoId, rolId;
         $(document).on("click","td.editableSueldo span",function(e){
            
            campo=$(this).closest("td").data("campo");
      puestoId=$(this).closest("td").attr("puestoPlantillaId");
      rolId=$(this).closest("td").attr("tipoTurnoPlantillaId");
      //alert("puestoId:"+puestoId+", rolId:"+rolId);
            td=$(this).closest("td");
            valorSueldo=$(this).text();
            id=$(this).closest("tr").find(".id").text();
            puntoServicioPlantillaId=$(this).closest("tr").find(".id").text();

            e.preventDefault();
            $("td:not(.id)").removeClass("editableSueldo");
            
            td.text("").html("<input type='text' name='"+campo+"' value='"+valorSueldo+"'><a class='enlaceSueldo guardarSueldo' href='#'>Guardar</a><a class='enlaceSueldo cancelarSueldo' href='#'>Cancelar</a>");            
        });

         //funcionalidad para cancelar edicion de sueldo
    $(document).on("click",".cancelarSueldo",function(e)
        {
            //alert(valorSueldo);
            e.preventDefault();
            td.html("<span>"+valorSueldo+"</span>");
            $("td:not(.id)").addClass("editableSueldo");
        });
    //termina funcionalidad para edicion de sueldo 

    //funcionalidad para edicion de sueldo
        $(document).on("click",".guardarSueldo",function(e)
        {
            $(".mensajeSueldo").html("<img src='img/loading.gif'>");
            e.preventDefault();
            nuevovalor=$(this).closest("td").find("input").val();
            if(nuevovalor.trim()!=""){
                $.ajax({
                    type: "POST",
                    url: "ajax_actualizaSueldo.php",
                    data: { campo: campo, valor: nuevovalor, puntoServicioPlantillaId:puntoServicioPlantillaId, puestoId: puestoId, rolId:rolId }, 
                    dataType: "json",
                    success: function(response) {
                        var mensaje=response.message;

                if (response.status == "success")
                {
                    $(".mensajeSueldo").html("<p class='okSueldo'>"+mensaje+"</p>")

                    td.html("<span>"+nuevovalor+"</span>");
                    $("td:not(.id)").addClass("editableBaja");
                    setTimeout(function() {$('.okSueldo,.koSueldo').fadeOut('fast');}, 3000);
                    $(".mensajeSueldo").html("<p class='okSueldo'>"+mensaje+"</p>");
                    $("#editableSueldo").find("tr:gt(0)").remove();
                    crearTablaSueldos();
                } else if(response.status=="error"){
                    $(".mensajeSueldo").html(mensaje);
                    //td.html("<span>"+nuevovalor+"</span>");
                    $("td:not(.id)").addClass("editinplaceSueldo");
                    setTimeout(function() {$('.okSueldo,.koSueldo').fadeOut('fast');}, 3000);
                    $(".mensajeSueldo").html("<p class='koSueldo'>"+mensaje+"</p>");
                }
            },
            error: function (response)
            {
                console.log (response);
            }
                });
            }
            else $(".mensajeSueldo").html("<p class='koSueldo'>Debes ingresar un valor</p>");
        });
    // termina funcionalidad para edicion de sueldo
                <?php
                }
                ?>
}

function crearTablaSueldos(){
    <?php
    if ($usuario["rol"] =="Ventas")
    {
    ?>
        $("#lineanegocioo1").val(1);
        $("#lineanegocioo2").val(3);
    <?php
    }
    if ($usuario["rol"] == "Administracion Seguridad Electronica")
    {
    ?>
        $("#lineanegocioo1").val(2);
        $("#lineanegocioo2").val(4);
    <?php
    }
    ?> 
    var lineanegocioo10 =$("#lineanegocioo1").val();
    var lineanegocioo20 =$("#lineanegocioo2").val();

    // $("#editinplaceSueldo").find("tr:gt(0)").remove();
    // $("#editinplaceSueldoPlantillasInactivas").find("tr:gt(0)").remove();
    var accion=$("#accion").val();
    waitingDialog.show();
    registrosSueldosConsulta = [];
    $.ajax({ 
        type: "POST",
        url: "ajax_getTabuladorSueldos.php",
        data:{"accion":accion,"lineanegocioo10":lineanegocioo10,"lineanegocioo20":lineanegocioo20},
        dataType: "json",
        async: false,
        success: function(response) {
            if(response.status == "success") {
               for (var i = 0; i < response.lista.length; i++) {
                    var record = response.lista[i];
                    registrosSueldosConsulta.push(record);
                }
                if(accion==0){// esta accion es para Registro sueldos en el else va el registr sueldos de empleados inactivos que se quito se tendreia que volver a generar en caso de ser necesario
                    loadDataIntableSueldosPuntos(registrosSueldosConsulta);
                }
                waitingDialog.hide();
                $("#editinplaceSueldo").show();
            }else{
                var mensaje = response.message;
                waitingDialog.hide();
            }
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
             waitingDialog.hide();
         }
    });
}
var tablaDeSueldosDeLosPuntos = null;

 function loadDataIntableSueldosPuntos(data) {
    if(tablaDeSueldosDeLosPuntos != null) {
        tablaDeSueldosDeLosPuntos.destroy();
    }
    tablaDeSueldosDeLosPuntos = $('#editinplaceSueldo').DataTable({
     "language": {
             "emptyTable": "No hay registro disponible",
             "info": "Del _START_ al _END_ de _TOTAL_",
             "infoEmpty": "Mostrando 0 registros de un total de 0.",
             "infoFiltered": "(filtrados de un total de _MAX_ registros)",
             "infoPostFix": "(actualizados)",
             "lengthMenu": "Mostrar _MENU_ registros",
             "loadingRecords": "Cargando....",
             "processing": "Procesando....",
             "search": "Buscar:",
             "searchPlaceholder": "Dato para buscar",
             "zeroRecords": "no se han encontrado coincidencias",
             "paginate": {
                 "first": "Primera",
                 "last": "Ultima",
                 "next": "Siguiente",
                 "previous": "Anterior"
             },
             "aria": {
                 "sortAscending": "Ordenación ascendente",
                 "sortDescending": "Ordenación descendente"
             }
         },
         data: data,
         destroy: true,
         "columns": [ 
         {   
             "data": "puntoServicioPlantillaId"
         },
         {   
             "data": "puntoServicio"
         },
         {   
             "data": "nombreEntidadFederativa"
         },
         {   
             "data": "razonSocial"
         },
         {   
             "data": "descripcionPuesto"
         },
         {   
             "data": "descripcionTurno"
         },
         {  
             "data": "rolOperativoPlantilla"
         },
         {   
             "data": "esatusPunto"
         },
         {   
             "data": "fechaInicioPuntoServicio"
         },
         {   
             "data": "fechaTerminoPuntoServicio"
         },
         {   
             "data": "sueldo"
         },
         {   
             "data": "Archivo"
         },
          ],
         processing: true,
         dom: 'Bfrtip',
         buttons: {
            buttons: ['excel']
         }

        });
 } 

function EditarRegistroSueldoPuntosServicio(puntoServicioPlantillaId,puestoPlantillaId,tipoTurnoPlantillaId,sueldo){
    $("#SueldoNuevoModalSueldo").val("");
    $("#idPuntoModalSueldo").val(puntoServicioPlantillaId);
    $("#sueldoModalSueldo").val(sueldo);
    $("#puestoPlantillaIdHidden").val(puestoPlantillaId);
    $("#tipoTurnoPlantillaIdHidden").val(tipoTurnoPlantillaId);
    $("#modalActualizarSueldo").modal('show');
}

function guardarNuevoSueldoParaPuntosServicio() {
    var campo = "sueldo";
    var puntoServicioPlantillaId = $("#idPuntoModalSueldo").val();
    var nuevovalor = $("#SueldoNuevoModalSueldo").val();
    var puestoId = $("#puestoPlantillaIdHidden").val();
    var rolId = $("#tipoTurnoPlantillaIdHidden").val();
    if(nuevovalor==""){
        alertMsg1="<div id='msgerrorandexitosueldos' class='alert alert-error'><strong>EL NUEVO SUELDO NO PUEDE IR EL CAMPO VACIO INGRESALO  </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
        $("#mensajeErrorSuledoModal").html(alertMsg1);
        $(document).scrollTop(0);
        $('#msgerrorandexitosueldos').delay(3000).fadeOut('slow');
    }else{
        $.ajax({
            type: "POST",
            url: "ajax_actualizaSueldo.php",
            data: { campo: campo, valor: nuevovalor, puntoServicioPlantillaId:puntoServicioPlantillaId, puestoId: puestoId, rolId:rolId }, 
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status == "success")
                {
                    alertMsg1="<div id='mensajesuccessueldo' class='alert alert-success'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgerrorandexito").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#mensajesuccessueldo').delay(3000).fadeOut('slow');
                    $("#modalActualizarSueldo").modal('hide');
                    crearTablaSueldos();
                } else if(response.status=="error"){
                    alertMsg1="<div id='msgAlert1' class='alert alert-error'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#mensajeErrorSuledoModal").html(alertMsg1);
                    $(document).scrollTop(0);
                    $('#msgAlert1').delay(3000).fadeOut('slow');

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }
}

  function getTabuladorSueldosByPuntoServicio(){
    $("#editinplaceSueldo").find("tr:gt(0)").remove();
    $("#editinplaceSueldoPlantillasInactivas").find("tr:gt(0)").remove();

    var puntoServicioName=$("#txtSearchSueldo").val();
 var accion=$("#accion").val();

    $.ajax({
            
            type: "POST",
            url: "ajax_getTabuladorSueldosByPuntoServicio.php",
            dataType: "json",
            data:{"puntoServicioName":puntoServicioName,"accion":accion},
             success: function(response) {
                if (response.status == "success")
                {
                 
                    var lista = response.lista;
                                     
                    for ( var i = 0; i < lista.length; i++ ){

                      var puntoServicioPlantillaId = lista[i].puntoServicioPlantillaId;
                      var puntoServicio = lista[i].puntoServicio;
                      var razonSocial = lista[i].razonSocial;
                      var descripcionPuesto=lista[i].descripcionPuesto;
                      var descripcionTurno=lista[i].descripcionTurno;
                      var sueldo=lista[i].sueldo;
                      var puestoPlantillaId=lista[i].puestoPlantillaId;
                      var tipoTurnoPlantillaId=lista[i].tipoTurnoPlantillaId;
                      var nombreEntidadFederativa=lista[i].nombreEntidadFederativa;
                      var esatusPunto=lista[i].esatusPunto;
                      var fechaTerminoPuntoServicio=lista[i].fechaTerminoPuntoServicio;
                      var fechaInicioPuntoServicio=lista[i].fechaInicioPuntoServicio;
                      var estatusPlantilla=lista[i].estatusPlantilla;
                      var servicioPlantillaId=lista[i].servicioPlantillaId;
                      var roloperativoPlantilla=lista[i].rolOperativoPlantilla;   

                      if(sueldo==null){
                        sueldo="NO DEFINIDO";
                      }

                      if(esatusPunto==1){
                        esatusPunto="ACTIVO";
                      }else{
                        esatusPunto="INACTIVO";
                      }
                      if(accion==0){
                    $('#editinplaceSueldo').append(
                          "<tr><td class='id'>"+puntoServicioPlantillaId+"</td><td width='190px'>"+puntoServicio+"</td><td>"+nombreEntidadFederativa+"</td><td width='230px'>"+razonSocial+
                          "</td><td>"+descripcionPuesto+"</td><td>"+descripcionTurno+"</td><td>"+roloperativoPlantilla+"</td><td>"+esatusPunto+"</td><td>"+fechaInicioPuntoServicio+"</td><td>"+fechaTerminoPuntoServicio+"</td><td class='editableSueldo' data-campo='sueldo' puestoPlantillaId='"+puestoPlantillaId+"' tipoTurnoPlantillaId='"+tipoTurnoPlantillaId+"'><span>"+sueldo+"</span></td></tr>");
                  }else if(accion==1){
                        $('#editinplaceSueldoPlantillasInactivas').append(
                          "<tr><td>"+puntoServicioPlantillaId+"</td><td width='190px'>"+puntoServicio+"</td><td>"+nombreEntidadFederativa+"</td><td width='230px'>"+razonSocial+
                          "</td><td>"+descripcionPuesto+"</td><td>"+descripcionTurno+"</td><td>"+roloperativoPlantilla+"</td><td>"+fechaInicioPuntoServicio+"</td><td>"+fechaTerminoPuntoServicio+"</td><td> <img style='width: 34%' title='Activar' src='img/Ok-icon1.png' class='cursorImg' id='btnguardar' onclick=activarplantilla('"+esatusPunto+"',"+estatusPlantilla+","+puntoServicioPlantillaId+","+servicioPlantillaId+")></td></tr>");

                } 
                                                              }                    
                    //$('#editinplace').html(listaPersonalActivoTable); 
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });

  }

  $('#txtSearchSueldo').keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which);  
      if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           getTabuladorSueldosByPuntoServicio();
           $("#txtSearchSueldo").val("");
      }   
 }); 

  $("#descargarTabulador").click(function(event) {
    var accion=$("#accion").val();
    if(accion==0){
  $("#datos_tabulador").val( $("<div>").append( $("#editinplaceSueldo").eq(0).clone()).html());
  $("#form_consultaTabulador").submit();
}else if(accion==1){
  $("#datos_tabuladorplnatillasinactivas").val( $("<div>").append( $("#editinplaceSueldoPlantillasInactivas").eq(0).clone()).html());
  $("#form_consultaTabuladorplantillasinactivas").submit();
}
  });

 

$("#aplantillasinactivas").click(function(){
   $("#msgerrorandexito").html("");
 $("#accion").val(1);
  $("#hiddenRegistroSueldos").hide();
$("#hiddenRegistroSueldosInactivos").show();
  crearTablaSueldos();
 
  
}); 


$("#aplantillasactivas").click(function(){
   $("#msgerrorandexito").html("");
 $("#accion").val(0);
  $("#hiddenRegistroSueldosInactivos").hide();
  $("#hiddenRegistroSueldos").show();
 
  crearTablaSueldos();
 
});

function activarplantilla(estatuspunto,estatusplantilla,idpuntoservicio,idplantilla){
  $.ajax({
         type: "POST",
         url: "ajax_activaPuntoservplantilla.php",
         data:{"estatuspunto":estatuspunto,"estatusplantilla":estatusplantilla,"idpuntoservicio":idpuntoservicio,"idplantilla":idplantilla},
         dataType: "json",
         success: function(response) {
          //console.log(response);
             if (response.status == "success") {
              
              if(response.tipoactivacion==1){
              Msgerrorfechainiciobusqueda = "<div id='msgerrorandexito' class='alert alert-success'><strong>Activación de plantilla con éxito</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            }else if(response.tipoactivacion==2){
              Msgerrorfechainiciobusqueda = "<div id='msgerrorandexito' class='alert alert-success'><strong>Activación de punto de servicio y plantilla con éxito</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            }
              $("#msgerrorandexito").html(Msgerrorfechainiciobusqueda); 
              $(document).scrollTop(0);   
             crearTablaSueldos();
                
             } else {
                 var mensaje = response.message;
                 console.log("mal");
                   
             }   
         },
         error: function(jqXHR, textStatus, errorThrown) {
             alert(jqXHR.responseText);
         }
     });





}


</script>

