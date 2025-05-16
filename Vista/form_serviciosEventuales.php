<?php
$catalogoEntidades= $negocio -> negocio_obtenerListaEntidadesFeferativas();
$catalogoClientes= $negocio -> negocio_obtenerListaClientesActivos();
$catalogoPuestosOp= $negocio -> obtenerCatalogoPuestoPorTipoPuesto('03', 1);
$catalogoTurnosE = $negocio -> negocio_obtenerListaTurnos();
?>
<div class="container" align="center">
<form class="form-horizontal" id="form_registroServicioEventual" name="form_registroServicioEventual" target="_blank">
<!--INICIO MODAL PARA CREAR NUEVO SERVICIO EVENTUAL -->
<div id="modalEventual" name="modalEventual" style="display:none;" class="modalPlantilla hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="msgModalEventual" id="msgModalEventual">
        </div>
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarServEventual();"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nuevo Servicio Eventual</h4>
      </div>

      <div class="modal-body-plantilla">
        <div class="input-prepend">
          <span class="add-on">Folio</span>
          <input class="input-mini" id="txtFolioEventual" name="txtFolioEventual" type="text" readonly>
          <input id="txtFolioEv" name="txtFolioEv" type="hidden">
        </div>
        <div class="input-prepend">
          <span class="add-on">idServicio</span>
          <input class="input-mini-mini" id="txtIdEventual" name="txtIdEventual" type="text" readonly>
        </div>
        <div class="input-prepend">
          <span class="add-on">Cliente</span>
          <select id="selectClienteEv" name="selectClienteEv" class="input-xlarge " onChange="">
                <option value="">CLIENTE</option>
                <?php
              for ($i=0; $i<count($catalogoClientes); $i++)
              {
                echo "<option value='". $catalogoClientes[$i]["idCliente"]."'>". $catalogoClientes[$i]["razonSocial"] ." </option>";
              }
              ?>
            </select>   
        </div>

        <div class="input-prepend">
          <span class="add-on">Entidad</span>
          <select id="selectEntidadEv" name="selectEntidadEv" class="input-xlarge " onChange="">
                <option value="00">ENTIDAD</option>
                <?php
              for ($i=0; $i<count($catalogoEntidades); $i++)
              {
                echo "<option value='". $catalogoEntidades[$i]["idEntidadFederativa"]."'>". $catalogoEntidades[$i]["nombreEntidadFederativa"] ." </option>";
              }
              ?>
            </select>   
        </div>

        <div class="input-prepend">
          <span class="add-on">Punto Servicio</span>
          <input class="input-xlarge" id="txtNombreServicio" name="txtNombreServicio" type="text">
        </div>
        <br>        
        <div class="input-prepend">
          <span class="add-on">Fecha Inicio</span>
          <input class="input-medium" id="txtFechaInicioEventual" name="txtFechaInicioEventual" type="date">
        </div>
        <br>
        <div class="input-prepend">
          <span class="add-on">Fecha Termino</span>
          <input class="input-medium" id="txtFechaFinEventual" name="txtFechaFinEventual" type="date">         
        </div>
        
      <br>
          <div class="input-prepend">
          <span class="add-on">Puesto</span>
        
          <select id="selectPuestoEv" name="selectPuestoEv" class="input-medium " onChange="">
                <option value="00">PUESTO</option>
                <?php
              for ($i=0; $i<count($catalogoPuestosOp); $i++)
              {
                echo "<option value='". $catalogoPuestosOp[$i]["IdPuesto"]."'>". $catalogoPuestosOp[$i]["descripcionPuesto"] ." </option>";
              }
              ?>
            </select>           
        </div> 

        <div class="input-prepend">
        <span class="add-on">Tipo Turno</span>
        <select id="selectTurnoEv" name="selectTurnoEv" class="input-medium ">
                    <option value="">TURNO</option>
                      <?php
                        for ($i = 0; $i < count($catalogoTurnosE); $i++)
                        {
                    echo "<option value='" . $catalogoTurnosE [$i]["idTipoTurno"] . "' >" . $catalogoTurnosE [$i]["descripcionTurno"] . " </option>";
                        }
                      ?>
        </select>        
      </div>     
        <div class="input-prepend">
          <span class="add-on">No.Elementos</span>
        
          <input class="input-mini-mini" id="txtNElementos" name="txtNElementos" type="text" >          
        </div>    

        <div class="input-prepend">
          <span class="add-on">LINEA NEGOCIO</span>
        
          <input class="input-medium" id="txtLineaNegocioEv" name="txtLineaNegocioEv" type="text" readonly value="SEGURIDAD FISICA">          
        </div>              
        <br>
        <div class="input-prepend">
          <span class="add-on">Dirección:</span>
        
          <textarea id="txtDireccionEv" name="txtDireccionEv" class="txtArea" required></textarea>          
        </div>  
    <br>
    <br>
  <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="guardarServicio();">Guardar</button>
  </div>
  </div> <!-- fin modal body-->
    </div><!--Fin modal nuevo Servicio Eventual-->
  </form>


  <form class="form-horizontal" id="form_asignarElemento" name="form_asignarElemento" target="_blank">

<!--MODAL PARA ASIGNAR ELEMENTOS A SERVICIO EVENTUAL -->
<div id="modalElementoEv" name="modalElementoEv" style="display:none;" class="modalFactura hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" >
        <div id="msgModalAsig" id="msgModalAsig">
        </div>
      <div class="modal-header">
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarAsignacionEv();"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Asignar Elemento</h4>
      </div>

      <div class="modal-body-plantilla">
        <div class="input-prepend">
          <span class="add-on">Servicio</span>
          <input class="input-xlarge" id="txtNombreEventual" name="txtNombreEventual" type="text" readonly>
          <input id="txtIdServicioEv" name="txtIdServicioEv" type="hidden">
        </div>        
        <br>
        <div class="input-prepend">
          <span class="add-on">Asignados</span>
          <input class="input-mini" id="txtAsignados" name="txtAsignados" type="text" readonly>
        </div>
        <br>
        <br>
        <span class="add-on">Empleado?</span>
        <div class="input-prepend">                  
                  <div class="material-switch pull-right">
                    <input id="checkEmpleado" name="checkEmpleado" type="checkbox" checked />
                    <label for="checkEmpleado" class="label-success1"></label>
                  </div>
        </div>
        <br>
        <br>
        <div class="input-prepend">
          <span class="add-on">Numero Elemento</span>
          <input class="input-medium" id="txtNumEmpleadoEv" name="txtNumEmpleadoEv" type="text" onkeyup="consultaEmpleadoKey();">
          <input id="txtConsecutivoEl" name="txtConsecutivoEl" type="hidden">
        </div>
        <br>
        <div class="input-prepend">
          <span class="add-on">Nombre Elemento</span>
          <input class="input-medium" id="txtNombreElementoEv" name="txtNombreElementoEv" type="text">
        </div>  
        <br>            
        <div class="input-prepend">
          <span class="add-on">Apellido Paterno</span>
          <input class="input-medium" id="txtApPaternoEv" name="txtApPaternoEv" type="text" >
        </div>  
        <br>      
        <div class="input-prepend">
          <span class="add-on">Apellido Materno</span>
          <input class="input-medium" id="txtApMaternoEv" name="txtApMaternoEv" type="text" >
        </div>                            
    <br>
    <br>
  <div class="modal-footer">
      <button type="button" class="btn btn-success" onclick="asignarElementoEv();">Asignar</button>
  </div>
  </div> <!-- fin modal body-->
    </div><!--FIn modal Asignar Elemento a Eventual-->
  </form>

    <div id="listEventuales" name="listEventuales">
        <?php if($usuario["rol"]!= "Analista Asistencia"){?>
      <button class="btn btn-info" id="btnNuevoEventual" name="btnNuevoEventual" onclick="modalNuevoEventual();"><img src="img/sumar.png">Nuevo</button>
       <?php } ?>
      <h1>Servicios Eventuales</h1><br>
      <img title='Obtener Los Servicios Eventuales' src='img/ActualizarEjecutar.jpg' class='cursorImg' id='btnguardar' onclick="inicioServEvent();" width="50px"></center>
    </div>    


</div>

<div class="tab-pane fade active in" align="center">
        <section>

            <table id="tableServiciosEv" class="tablaRH2" style="display: none;">
                <thead>
                    <tr>
                        <th>FOLIO</th>
                        <th>SERVICIO</th>
                        <th>CLIENTE</th>
                        <th>ENTIDAD</th>
                        <th>DIRECCION</th>
                        <th>PUESTO</th>
                        <th>TURNO</th>
                        <th># ELEMENTOS</th>
                        <th>FECHA INICIO</th>
                        <th>FECHA TERMINO</th>
                        <th>USUARIO REGISTRO</th>
                        <th>FECHA REGISTRO</th>
                        <th>COSTO</th>                        
                        <th>ACCIONES</th>
                    </tr>
                </thead>

                <tbody></tbody>

            </table>
                     
        </section>
        
</div>

<script type="text/javascript">

var tableEventuales = null;

// $(inicioServEvent());  

function inicioServEvent(){
      obtenerUltimoFolioEv();
      $("#txtNombreElementoEv").prop('readonly', true);
      $("#txtApPaternoEv").prop('readonly', true);
      $("#txtApMaternoEv").prop('readonly', true);
      getEventuales();
}

function getEventuales(){
      waitingDialog.show();
  var dataTableEventuales = [];

        $.ajax ({
            type: "POST"  
            ,url: "ajax_obtenerEventualesTable.php"
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {                        
                        var record = response.data[i];                                            
                        dataTableEventuales.push (record);                         
                    }
                    loadDataInTableEventuales (dataTableEventuales);
                    $("#tableServiciosEv").show();
                    waitingDialog.hide();
                }
            }
            ,error : function (jqXHR, textStatus, errorThrown)
            {
                alert (jqXHR.responseText);
                waitingDialog.hide();
            }
        });
    }


function loadDataInTableEventuales(data){
  //alert("HOLA");

  if (tableEventuales != null)
        {
            tableEventuales.destroy ();
            
        }

        tableEventuales = $('#tableServiciosEv').DataTable( {
        "language" : {
              "emptyTable" :         "No hay eventuales disponibles en la tabla",
              "info" :               "Del _START_ al _END_ de _TOTAL_",
              "infoEmpty" :          "Mostrando 0 registros de un total de 0.",
              "infoFiltered" :       "(filtrados de un total de _MAX_ registros)",
              "infoPostFix" :        "(actualizados)",
              "lengthMenu" :         "Mostrar _MENU_ registros",
              "loadingRecords" :     "Cargando....",
              "processing"     :     "Procesando....",
              "search" :             "Buscar:",
              "searchPlaceholder" :  "Dato para buscar",
              "zeroRecords" :        "no se han encontrado coincidencias",
              "paginate" : {
                   "first" :         "Primera",
                   "last" :          "Ultima",
                   "next" :          "Siguiente",
                   "previous" :      "Anterior"
              },
              "aria" : {
                 "sortAscending" :   "Ordenación ascendente",
                 "sortDescending" :  "Ordenación descendente"
              }
           },
           data: data,
          destroy: true
        , "order": [[10,"desc"]]
        ,"columns": [
            { "data": "folioEventual"}
            ,{ "data": "nombreServicio" }
            ,{ "data": "razonSocial" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "direccionEventual" }
            ,{ "data": "descripcionPuesto" }
            ,{ "data": "descripcionTurno" }
            ,{ "data": "numElementosEv" }
            ,{ "data": "fechaInicioEv" }
            ,{ "data": "fechaFinEv" }
            ,{ "data": "usuarioCaptura" }
            ,{ "data": "fechaCaptura" }
            ,{ "data": "costoEventual" }
            ,{ "data": "acciones" }

       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'        
        ,buttons: ['excel']

    } );

}

function consultaEmpleadoKey()
{  
  var txtSearch = $("#txtNumEmpleadoEv").val ();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;

  if (txtSearch.length != 10 && txtSearch.length != 11)
  {   

        $("#txtNombreElementoEv").val("");
        $("#txtApPaternoEv").val("");
        $("#txtApMaternoEv").val("");
        return;
  }else{

    if(expreg.test(txtSearch) || expreg1.test(txtSearch))
    {
      var numeroEmpleado = $("#txtNumEmpleadoEv").val();    
     
      consultaEmpleadoEv(numeroEmpleado);
    }
  }
}

function consultaEmpleadoEv (numeroEmpleado)
{
    var numeroEmpleado1 = numeroEmpleado;

    //alert(numeroEmpleado1);    
 $.ajax({
            
            type: "POST",
            url: "ajax_obtenerEmpleadoPorId.php",
            data:{"numeroEmpleado":numeroEmpleado1},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
             
                   var empleadoEncontrado = response.empleado;


                    if (empleadoEncontrado.length == 0){
                    

                        alertMsg1="<div id='msgAlertAe' class='alert alert-error'><strong><center>No existe Número de empleado</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       
                        $("#msgModalAsig").html(alertMsg1);
                        $('#msgAlertAe').delay(2000).fadeOut('slow');                    

                        
                    }else{                                          

                      for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                            var empleadoEntidad = empleadoEncontrado[i].entidadFederativaId;
                            var empleadoConsecutivo = empleadoEncontrado[i].empleadoConsecutivoId;
                            var empleadoCategoria = empleadoEncontrado[i].empleadoCategoriaId;
                            var empleadoApellidoPaterno= empleadoEncontrado[i].apellidoPaterno;
                            var empleadoApellidoMaterno= empleadoEncontrado[i].apellidoMaterno;
                            var nombreEmpleado= empleadoEncontrado[i].nombreEmpleado;
                            var estatusEmpleado= empleadoEncontrado[i].empleadoEstatusId;
                            var tallaCamisa=empleadoEncontrado[i].tallaCamisa;
                            var tallaPantalon=empleadoEncontrado[i].tallaPantalon;
                            var numCalzado=empleadoEncontrado[i].numCalzado;
                            var puntoServicio=empleadoEncontrado[i].puntoServicio;                            
                            if(estatusEmpleado!=0){                                
                                $("#txtNombreElementoEv").val(nombreEmpleado);
                                $("#txtApPaternoEv").val(empleadoApellidoPaterno);
                                $("#txtApMaternoEv").val(empleadoApellidoMaterno);                                
                            }else{
                                alertMsg1="<div id='msgAlertAe' class='alert alert-error'><strong><center>Empleado dado de baja</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       
                                $("#msgModalAsig").html(alertMsg1);
                                $('#msgAlertAe').delay(2000).fadeOut('slow');
                            }
                      }

                                                                                                                  
                  }                    

                }else if (response.status == "error")
                {
                    alert(response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });

}
  
  
function obtenerUltimoFolioEv()
  {
   // var rutalogo="img/logoGif.jpg";

      $.ajax({
            
            type: "POST",
            url: "ajax_obtenerUltimoFolioEventual.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                
                    var folio = response.ultimoFolio.folioEv;
                    var numId = response.ultimoFolio.idEve;                    
                    $("#txtFolioEventual").val("EV-"+folio);                                      
                    $("#txtFolioEv").val(folio);
                    $("#txtIdEventual").val(numId);
                }              
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
  }


  function limpiarServEventual(){
      var form=document.getElementById("form_registroServicioEventual");
      form.reset(); 
  }

  function limpiarAsignacionEv(){    
      var form=document.getElementById("form_asignarElemento");      
      form.reset(); 
  }


  function asignarElementoEv(){
      var datastring = $("#form_asignarElemento").serialize();          
      console.log(datastring);
        $.ajax({
            type: "POST",
            url: "ajax_asignarElementoEv.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;    
                //console.log(datastring);            
                if (response.status=="success") {
                  
                    alertMsg1="<div id='msgAlertEv' class='alert alert-success'><trong>Asignación:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlertEv').delay(3000).fadeOut('slow');
                    limpiarAsignacionEv();  
                    $('#modalElementoEv').modal('hide');                  
                                                    


                    //$( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    //obtenerUltimoNueroOrden();
                              
                } else if (response.status=="error")
                {                  
                  alertMsg1="<div id='msgAlertEv' class='alert alert-error'><strong>Error de asignación:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgModalAsig").html(alertMsg1);
                    $('#msgAlertEv').delay(2000).fadeOut('slow');
                    //mostrarModalMediosComunicacion();
                }
              },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);

            }
        });
  }

  function modalNuevoEventual(){
    $('#modalEventual').modal('show');
    obtenerUltimoFolioEv();

  }



  $( '#checkEmpleado' ).on( 'click', function() {
    if( $(this).is(':checked') ){
        // Hacer algo si el checkbox ha sido seleccionado
        $("#txtNumEmpleadoEv").prop('readonly', false);
        $("#txtNumEmpleadoEv").val("");
        $("#txtNombreElementoEv").prop('readonly', true);
        $("#txtApPaternoEv").prop('readonly', true);
        $("#txtApMaternoEv").prop('readonly', true);
        $("#txtNombreElementoEv").val("");
        $("#txtApPaternoEv").val("");
        $("#txtApMaternoEv").val("");
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado  
        var consecutivo=$("#txtConsecutivoEl").val();        
        $("#txtNumEmpleadoEv").val(consecutivo);      
        $("#txtNumEmpleadoEv").prop('readonly', true);
        $("#txtNombreElementoEv").prop('readonly', false);
        $("#txtApPaternoEv").prop('readonly', false);
        $("#txtApMaternoEv").prop('readonly', false);
        $("#txtNombreElementoEv").val("");
        $("#txtApPaternoEv").val("");
        $("#txtApMaternoEv").val("");
        
    }
});


  function modalAsignarElemento(idEventual,numElementos,nombreServicio){
    $("#txtNombreEventual").val(nombreServicio);
    $("#txtIdServicioEv").val(idEventual);
    var asignados=consultaAsignadosEv(idEventual);
    if(asignados>=numElementos){
        alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>Imposible asignar: Ya se asignaron los elementos</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
        $("#alertMsg").html(alertMsg1);
        $('#msgAlert').delay(2000).fadeOut('slow');
        return;  
    }
    $("#txtAsignados").val(asignados);    
    generarConsecutivoEV();
    $('#modalElementoEv').modal();

    

  }


  function consultaAsignadosEv(eventualId){
      //alert("entra");
      var numAsig=0;
      $.ajax({   
            async: false,          
            type: "POST",
            url: "ajax_obtenerAsignadosEventual.php",
            data: {"idEventual":eventualId},
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                
                  var asignados=response.asignaciones;                                      
                  numAsig=asignados;
                }              
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText);

            }
        });
      //alert(numAsig);
      return numAsig;
  }

  function generarConsecutivoEV()
  {
   // var rutalogo="img/logoGif.jpg";

      $.ajax({
            
            type: "POST",
            url: "ajax_generarConsecutivoElementoEv.php",
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                
                    var consecutivo = response.consecutivoEl.consecutivoEv;                              
                    $("#txtConsecutivoEl").val(consecutivo);                        

                }              
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR.responseText);
            }
        });
  }


  
  function guardarServicio()
  {      
        var datastring = $("#form_registroServicioEventual").serialize();


        $.ajax({
            type: "POST",
            url: "ajax_registroServicioEventual.php",
            data: datastring,
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;    
                //console.log(datastring);            
                if (response.status=="success") {
                  
                    alertMsg1="<div id='msgAlertEv' class='alert alert-success'><trong>Requisicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#msgModalEventual").html(alertMsg1);
                    $('#msgAlertEv').delay(3000).fadeOut('slow');
                    var form=document.getElementById("form_registroServicioEventual");
                    form.reset(); 
                    $('#modalEventual').modal('hide');

                    obtenerUltimoFolioEv();    
                    getEventuales();                             


                    //$( "#cliente" ).val("CLIENTE");
                    //document.getElementById("form_registroPuntoServicio").reset();
                    //obtenerUltimoNueroOrden();
                              
                } else if (response.status=="error")
                {                  
                  alertMsg1="<div id='msgAlertEv' class='alert alert-error'><strong>Error en el registro:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    $("#msgModalEventual").html(alertMsg1);
                    $('#msgAlertEv').delay(3000).fadeOut('slow');
                    $('#modalEventual').modal('hide');

                    //mostrarModalMediosComunicacion();
                }
              },
            error: function(jqXHR, textStatus, errorThrown){ 
                  alert(jqXHR.responseText);
                    $('#modalEventual').modal('hide');


            }
        });
    
  }

  function generarFormatoEventual(idEventual){            


      window.open("generadorFormatoEventual.php?eventualId="+idEventual+"",'Informe2','fullscreen=no');
  }

  function editarCosto(idEventual,event){
      var keycode = (event.keyCode ? event.keyCode : event.which);
      var RE = /^\d*\.?\d*$/;        
      if(keycode == '13'){  
          var costoNuevo=$("#txtCosto"+idEventual).val();          
          if(costoNuevo==""){
              return;
          }
          if (RE.test(costoNuevo)) {              
               $.ajax({
                type: "POST",
                url: "ajax_actualizarCostoEventual.php",
                data: {"idEventual":idEventual,"costoNuevo":costoNuevo},
                dataType: "json",
                success: function(response) {
                    var mensaje=response.message;    
                    //console.log(datastring);            
                    if (response.status=="success") {
                      
                                                      
                        alertMsg1="<div id='msgAlert' class='alert alert-success'>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                      $("#alertMsg").html(alertMsg1);
                      $('#msgAlert').delay(2000).fadeOut('slow'); 
                      styleTableEventuales();                        
                                  
                    } else if (response.status=="error")
                    {                  
                       alert("Error");
                        //mostrarModalMediosComunicacion();
                    }
                  },
                error: function(jqXHR, textStatus, errorThrown){
                      alert(jqXHR.responseText);

                }
            });
          }else{
             alertMsg1="<div id='msgAlert' class='alert alert-error'><strong><center>Por favor verifique: Costo no permitido</center></strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                       
            $("#alertMsg").html(alertMsg1);
            $('#msgAlert').delay(2000).fadeOut('slow');  
          }
      }
  }

  

var formatter = new Intl.NumberFormat('en-US', {
  style: 'currency',
  currency: 'USD',
  minimumFractionDigits: 2,
});



$('#txtFechaInicioEventual').datetimepicker({
 
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});

$('#txtFechaFinEventual').datetimepicker({
 
  timepicker:false,
  format:'Y-m-d',
  formatDate:'Y-m-d',

});
//
</script>