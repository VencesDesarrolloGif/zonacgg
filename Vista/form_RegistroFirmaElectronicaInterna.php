 <div id="errorFirmaInterna"></div><br>
  <div align="center">
    <a id="MostrarRegistroContrasenia"onclick="MostraregistroRecuperacionFirmaElectronica(0)"style="cursor: pointer;" data-toggle="tab">REGISTRAR NUEVA CONTRASEÑA</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
    <a id="MostrarRecuperacionContrasenia"onclick="MostraregistroRecuperacionFirmaElectronica(1)"style="cursor: pointer;" data-toggle="tab">RECUPERAR CONTRASEÑA </a><br><br>
  </div>
<div id="divRegistroFirmaElectronica" style="display: none;">
 <form class="form-inline"  method="post" id="form_RegistroFirmaElectronica" target="_blank" enctype='multipart/form-data'>
  <div align="center"><br>
    <div  style="max-width: 100rem; border-style: groove; border-color: rgb(133, 193, 233); "><br>
      <h2>BIENVENIDO AL REGISTRO DE LA FIRMA ELECTRONICA INTERNA</h2>
      <br>
      <div>
        <span class="add-on">Número Del Empleado</span>
        <input id="impNumeroEmpleadoFirma" name="impNumeroEmpleadoFirma" type="text" class="input-medium" placeholder="00-0000-00 ó 00-00000-00" title="Ingrese El Número Que Le Fue Otorgado Por Gif Seguridad Privada" >
      </div><br>
      <div>
        <span class="add-on">Nombre</span>
        <input id="impNombreEmpleadoFirma" name="impNombreEmpleadoFirma" type="text" class="input-medium" title="Ingrese Su Nombre">
        <span class="add-on">Apellido Paterno</span>
        <input id="impApellidoPaternoFirma" name="impApellidoPaternoFirma" type="text" class="input-medium" title="Ingrese Su Apellido Paterno">
        <span class="add-on">Apellido Materno</span>
        <input id="impApellidoMaternoFirma" name="impApellidoMaternoFirma" type="text" class="input-medium" title="Ingrese Su Apellido Materno">
      </div><br>
      <div>
        <span class="add-on">Pais De Nacimiento</span>
        <select id="selPaisNaciomientoFirma" name="selPaisNaciomientoFirma" class="input-medium"></select> 
        <span class="add-on">Entidad De Nacimiento</span>
        <select id="selEntidadNacimientoFirma" name="selEntidadNacimientoFirma" class="input-medium"></select>
      </div><br>
       <div>
        <span class="add-on">Municipio De Nacimiento</span>
        <select id="selMunicipioNacimientoFirma" name="selMunicipioNacimientoFirma" class="input-medium"></select>
      </div><br>
       <div>
        <span class="add-on">CURP</span>
        <input id="impCrupEmpleadoFirma" name="impCrupEmpleadoFirma" type="text" class="input-xlarge" title="Ingrese Su Curp">
        <span class="add-on">Telefono Celular</span>
        <input id="impTelefonoEmpleadoFirma" name="impTelefonoEmpleadoFirma" type="text" class="input-xlarge" title="Ingrese El Telefono Celular Registrado Al Realizar Su Alta ">
      </div><br>
       <div>
        <span class="add-on">Correo(Personal)</span>
        <input id="impCorreoEmpleadoFirma" name="impCorreoEmpleadoFirma" type="text" class="input-xlarge" title="Ingrese El Correo Registrado Al Realizar Su Alta" placeholder="ejemplo@dominio.com">
      </div><br>
      <h3>Preguntas Para Restaurar La Contraseña Ingresada En Caso De Perdida !!!</h3>
      <h5>Recuerda guardar las respuestas y recordarlas para no perder tu contraseña</h5><br>
      <div>
        <span class="add-on">Primer Pregunta</span>
        <select id="selPreguntaUnoFirma" name="selPreguntaUnoFirma" class="input-xlarge"></select>
        <input id="impPrimerPregunta" name="impPrimerPregunta" type="text" class="input-xlarge" title="Ingrese Respuesta A La Primer Pregunta ">
      </div><br>
      <div>
        <span class="add-on">Segunda Pregunta</span>
        <select id="selPreguntaDosFirma" name="selPreguntaDosFirma" class="input-xlarge"></select>
        <input id="impSegundaPregunta" name="impSegundaPregunta" type="text" class="input-xlarge" title="Ingrese Respuesta A La Segunda Pregunta ">
      </div><br>
      <div>
        <span class="add-on">Tercera Pregunta</span>
        <select id="selPreguntaTresFirma" name="selPreguntaTresFirma" class="input-xlarge"></select>
        <input id="impTerceraPregunta" name="impTerceraPregunta" type="text" class="input-xlarge" title="Ingrese Respuesta A La Tercera Pregunta ">
      </div><br>
      <div>
        <button id="cancelarFirmaInterna" name="cancelarFirmaInterna" class="btn btn-danger" style="display: none;" type="button" ;> 
        <span class="glyphicon glyphicon-floppy-save "></span>Cancelar</button>        
        <button id="guardarFirmaInterna" name="guardarFirmaInterna" class="btn btn-primary" style="display: none;" type="button" ;> 
        <span class="glyphicon glyphicon-floppy-save "></span>Solicitar</button>
      </div><br>
      <div>
        <input id="NombreHidden" name="NombreHidden" type="hidden" class="input-medium">
        <input id="ApellidoPatHidden" name="ApellidoPatHidden" type="hidden" class="input-medium">
        <input id="ApellidoMatHidden" name="ApellidoMatHidden" type="hidden" class="input-medium">
        <input id="PaisHidden" name="PaisHidden" type="hidden" class="input-medium">
        <input id="EntidadHidden" name="EntidadHidden" type="hidden" class="input-medium">
        <input id="MunicipioHidden" name="MunicipioHidden" type="hidden" class="input-medium">
        <input id="CURPHidden" name="CURPHidden" type="hidden" class="input-medium">
        <input id="TelefonoHidden" name="TelefonoHidden" type="hidden" class="input-medium">
        <input id="CorreoHidden" name="CorreoHidden" type="hidden" class="input-medium">
        <input id="ContraseniaFirma" name="ContraseniaFirma" type="hidden" class="input-medium">
      </div>
    </div>
  </div>
 </form>
</div>
<div align="center" id="divRecuperarFirmaElectronica" style="display: none;"><br>
    <div  style="max-width: 100rem; border-style: groove; border-color: rgb(133, 193, 233); "><br>
      <h2>BIENVENIDO A LA RECUPERACIÓN DE LA FIRMA ELECTRONICA INTERNA</h2>
      <br>
      <div>
        <span class="add-on">Número Del Empleado</span>
        <input id="impNumeroEmpleadoFirmaR" name="impNumeroEmpleadoFirmaR" type="text" class="input-medium" placeholder="00-0000-00 ó 00-00000-00" title="Ingrese El Número Que Le Fue Otorgado Por Gif Seguridad Privada" >
      </div><br>
      
      <h5>Ingresa una de las tres preguntas secretas que proporcionaste al registrar tu contraseña </h5><br>
      <div>
        <span class="add-on">Pregunta De Recuperación</span>
        <select id="selPreguntaUnoFirmRa" name="selPreguntaUnoFirmaR" class="input-xlarge"></select>
        <input id="impPrimerPreguntaR" name="impPrimerPreguntaR" type="text" class="input-xlarge" title="Ingrese Respuesta A La Primer Pregunta ">
      </div><br>
      <div>
        <span class="add-on" id="spCorreoAEnviarR" style="display: none;">Correo De Recuperación</span>
        <input id="CorreoAEnviarR" name="CorreoAEnviarR" type="text" class="input-xlarge" readonly="true" style="display: none;" title="Se Enviara El Link A Este Correo Para Continuar ">
      </div><br>
      <div>
        <button id="cancelarRecuperacionFirmaInterna" name="cancelarRecuperacionFirmaInterna" class="btn btn-danger" style="display: none;" type="button" ;> 
        <span class="glyphicon glyphicon-floppy-save "></span>Cancelar</button>        
        <button id="RecuperarFirmaInterna" name="RecuperarFirmaInterna" class="btn btn-primary" style="display: none;" type="button" ;> 
        <span class="glyphicon glyphicon-floppy-save "></span>Solicitar</button>
      </div><br>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" name="modalcontraseniaFirma" id="modalcontraseniaFirma" data-backdrop="static">
  <div id="errorFirmaInternaModal"></div>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><img src="img/ok.png">ESCRIBE LA CONTRASEÑA A REGISTRAR</h4>
        <h5 class="modal-title">LA CONTRASEÑA ES INTRANSFERIBLE RECUERDA GUARDARLA BIEN !!</h5>
      </div>
      <div class="modal-body">
        <span class="add-on">Escribir La Contraseña</span>
        <input id="ContraseniaFirma1" name="ContraseniaFirma1" type="password" class="input-medium">
        <br>
        <span class="add-on">Escribir Nuevamente La Contraseña</span>
        <input id="ContraseniaFirma2" name="ContraseniaFirma2" type="password" class="input-medium">
      </div>
      <div class="modal-body">
        <button id="guardarIncertarFirmaInterna" name="guardarIncertarFirmaInterna" class="btn btn-primary" type="button" ;> 
        <span class="glyphicon glyphicon-floppy-save "></span>Guardar</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  
<script type="text/javascript">
$(document).ready(function() {
  MostraregistroRecuperacionFirmaElectronica(0);
  GetSelectorPaisFirmaInterna();
});
var correoRecuperacion = "";// Recuperacion De La contraeña
var Respuesta1 = "";
var Respuesta2 = "";
var Respuesta3 = "";
var idRespuesta1 = "";
var idRespuesta2 = "";
var idRespuesta3 = "";
  function MostraregistroRecuperacionFirmaElectronica(opcion){
    if(opcion=="0"){
      BorrarformaularioRegistroFirma();
      $("#divRegistroFirmaElectronica").show();
      $("#divRecuperarFirmaElectronica").hide();
    }else{
      CargarPrimerPregunta(2);
      BorrarformaulariRecuperacionFirma();
      $("#divRegistroFirmaElectronica").hide();
      $("#divRecuperarFirmaElectronica").show();
    }
  }

$("#impNumeroEmpleadoFirma").blur(function () 
{

 var impNumeroEmpleadoFirma = $("#impNumeroEmpleadoFirma").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(impNumeroEmpleadoFirma) || expreg1.test(impNumeroEmpleadoFirma)){
    consultaEmpleadoFirmaInterna(impNumeroEmpleadoFirma);
  }else{
    cargaerroresFirmaInterna("El Formato Del Numero De Empleado Es Incorrecto");
    $("#impNumeroEmpleadoFirma").val("");
    $("#cancelarFirmaInterna").hide();
    $("#guardarFirmaInterna").hide();
  }
});


function consultaEmpleadoFirmaInterna (numeroEmpleado){
  $.ajax({
    type: "POST",
    url: "ajax_obtenerEmpleadoPorId.php",
    data:{"numeroEmpleado":numeroEmpleado},
    dataType: "json",
    success: function(response) {
      console.log(response);
      if (response.status == "success"){
        var empleadoExtiste = response["empleado"].length;
        if(empleadoExtiste=="0"){
          cargaerroresFirmaInterna("El Empleado No Existe En La Base Favor De Verificar");
          $("#impNumeroEmpleadoFirma").val("");
          $("#cancelarFirmaInterna").hide();
          $("#guardarFirmaInterna").hide();
        }else{
          $("#cancelarFirmaInterna").show();
          $("#guardarFirmaInterna").show();
          $("#NombreHidden").val(response["empleado"][0].nombreEmpleado);
          $("#ApellidoPatHidden").val(response["empleado"][0].apellidoPaterno);
          $("#ApellidoMatHidden").val(response["empleado"][0].apellidoMaterno);
          $("#PaisHidden").val(response["empleado"][0].paisNacimientoId);
          $("#EntidadHidden").val(response["empleado"][0].entidadNacimientoId);
          $("#MunicipioHidden").val(response["empleado"][0].municipioNacimientoId);
          $("#CURPHidden").val(response["empleado"][0].curpEmpleado);
          $("#TelefonoHidden").val(response["empleado"][0].telefonoMovilEmpleado);
          $("#CorreoHidden").val(response["empleado"][0].correoEmpleado);
        }
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }

  });
}

function GetSelectorPaisFirmaInterna(){
    $.ajax({
      type: "POST",
      url: "ajax_getSelectorPaisFirmaInterna.php",
      dataType: "json",
      async : false,
      success: function(response) {
        //console.log(response.datos);
        $("#selPaisNaciomientoFirma").empty().append('<option value="0">Pais</option>');
        if (response.status == "success")
        {
          for (var i = 0; i < response.datos.length; i++)
          {$('#selPaisNaciomientoFirma').append('<option value="' + (response.datos[i].idPais) + '">' + response.datos[i].nombrePais + '</option>');}
        }else{alert("Error Al Cargar El Catalogo De Paises");}
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

  $("#selPaisNaciomientoFirma").change(function() {
     $('#selMunicipioNacimientoFirma').empty();
    var selPaisNaciomientoFirma = $("#selPaisNaciomientoFirma").val();
    if (selPaisNaciomientoFirma != 0 && selPaisNaciomientoFirma != "Pais") {
      $.ajax({
        type: "POST",
        url: "ajax_ObtenerEntidadesFirmaElectronica.php",
        dataType: "json",
        success: function(response) {
          var datos = response.datos;
          $('#selEntidadNacimientoFirma').empty().append('<option value="0">Entidad</option>');
          $.each(datos, function(i) {
            $('#selEntidadNacimientoFirma').append('<option value="' + response.datos[i].idEntidadFederativa + '">' + response.datos[i].nombreEntidadFederativa +'</option>') 
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
      });
    } else {     
        $('#selEntidadNacimientoFirma').empty();
        $('#selPreguntaUnoFirma').empty();
        $('#selPreguntaDosFirma').empty();
        $('#selPreguntaTresFirma').empty();
        $('#impPrimerPregunta').val("");
        $('#impSegundaPregunta').val("");
        $('#impTerceraPregunta').val("");
      }
  });

  $("#selEntidadNacimientoFirma").change(function() {
    var selEntidadNacimientoFirma = $("#selEntidadNacimientoFirma").val();
    var caso = "1";
    if (selEntidadNacimientoFirma != 0 && selEntidadNacimientoFirma != "Entidad") {
      $.ajax({
        type: "POST",
        url: "ajax_getMunicipioPorEntidadFirma.php",
        data:{"selEntidadNacimientoFirma":selEntidadNacimientoFirma},
        dataType: "json",
        success: function(response) {
          var datos = response.datos;
          $('#selMunicipioNacimientoFirma').empty().append('<option value="0">Municipio</option>');
          $.each(datos, function(i) {
            $('#selMunicipioNacimientoFirma').append('<option value="' + response.datos[i].idMunicipio + '">' + response.datos[i].nombreMunicipio +'</option>') 
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
      });
    } else {     
        $('#selMunicipioNacimientoFirma').empty();
        $('#selPreguntaUnoFirma').empty();
        $('#selPreguntaDosFirma').empty();
        $('#selPreguntaTresFirma').empty();
        $('#impPrimerPregunta').val("");
        $('#impSegundaPregunta').val("");
        $('#impTerceraPregunta').val("");
      }
  });

   $("#selMunicipioNacimientoFirma").change(function() {
    var selMunicipioNacimientoFirma = $("#selMunicipioNacimientoFirma").val();
    $('#selPreguntaUnoFirma').empty();
     $('#selPreguntaDosFirma').empty();
     $('#selPreguntaTresFirma').empty();
     $('#impPrimerPregunta').val("");
     $('#impSegundaPregunta').val("");
     $('#impTerceraPregunta').val("");
    
    if (selMunicipioNacimientoFirma != 0 && selMunicipioNacimientoFirma != "Municipio") {
      CargarPrimerPregunta(1);
    }
  });
   function CargarPrimerPregunta(Origen){
    var caso = "1";
    $.ajax({
        type: "POST",
        url: "ajax_getPreguntas.php",
        data:{"caso":caso,"pregunta1":caso,"pregunta2":caso},
        dataType: "json",
        success: function(response) {
          var datos = response.datos;
          if(Origen=="1"){
            $('#selPreguntaUnoFirma').empty().append('<option value="0">Pregunta</option>');
            $.each(datos, function(i) {
              $('#selPreguntaUnoFirma').append('<option value="' + response.datos[i].idPregunta + '">' + response.datos[i].Descripcion +'</option>') 
            });
          }else{
            $('#selPreguntaUnoFirmRa').empty().append('<option value="0">Pregunta</option>');
            $.each(datos, function(i) {
              $('#selPreguntaUnoFirmRa').append('<option value="' + response.datos[i].idPregunta + '">' + response.datos[i].Descripcion +'</option>') 
            });
          }
          
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
      });
   }

  $("#selPreguntaUnoFirma").change(function() {
    $('#selPreguntaTresFirma').empty();
    $('#selPreguntaDosFirma').empty();
    $('#impPrimerPregunta').val("");
    $('#impSegundaPregunta').val("");
    $('#impTerceraPregunta').val("");
    var caso = "2";
    var selPreguntaUnoFirma = $("#selPreguntaUnoFirma").val();
    if (selPreguntaUnoFirma != 0 && selPreguntaUnoFirma != "Pregunta") {
      $.ajax({
        type: "POST",
        url: "ajax_getPreguntas.php",
        data:{"caso":caso,"pregunta1":selPreguntaUnoFirma,"pregunta2":caso},
        dataType: "json",
        success: function(response) {
          var datos = response.datos;
          $('#selPreguntaDosFirma').empty().append('<option value="0">Pregunta</option>');
          $.each(datos, function(i) {
            $('#selPreguntaDosFirma').append('<option value="' + response.datos[i].idPregunta + '">' + response.datos[i].Descripcion +'</option>') 
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
      });
    }
  });

  $("#selPreguntaDosFirma").change(function() {
    $('#selPreguntaTresFirma').empty();
    $('#impSegundaPregunta').val("");
    $('#impTerceraPregunta').val("");
    var caso = "3";
    var selPreguntaDosFirma = $("#selPreguntaDosFirma").val();
    var selPreguntaUnoFirma = $("#selPreguntaUnoFirma").val();
    if (selPreguntaDosFirma != 0 && selPreguntaDosFirma != "Pregunta") {
      $.ajax({
        type: "POST",
        url: "ajax_getPreguntas.php",
        data:{"caso":caso,"pregunta1":selPreguntaUnoFirma,"pregunta2":selPreguntaDosFirma},
        dataType: "json",
        success: function(response) {
          var datos = response.datos;
          $('#selPreguntaTresFirma').empty().append('<option value="0">Pregunta</option>');
          $.each(datos, function(i) {
            $('#selPreguntaTresFirma').append('<option value="' + response.datos[i].idPregunta + '">' + response.datos[i].Descripcion +'</option>') 
            });
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR.responseText);
        }
      });
    }
  });

  $("#selPreguntaTresFirma").change(function() {
    $('#impTerceraPregunta').val("");
  });

  $("#guardarFirmaInterna").click(function() {
    var nombreHidden = $("#NombreHidden").val();
    var apellidoPatHidden = $("#ApellidoPatHidden").val();
    var apellidoMatHidden = $("#ApellidoMatHidden").val();
    var paisHidden = $("#PaisHidden").val();
    var entidadHidden = $("#EntidadHidden").val();
    var municipioHidden = $("#MunicipioHidden").val();
    var cURPHidden = $("#CURPHidden").val();
    var telefonoHidden = $("#TelefonoHidden").val();
    var correoHidden = $("#CorreoHidden").val();
    var impNombreEmpleadoFirma = $("#impNombreEmpleadoFirma").val();
    var impApellidoPaternoFirma = $("#impApellidoPaternoFirma").val();
    var impApellidoMaternoFirma = $("#impApellidoMaternoFirma").val();
    var selPaisNaciomientoFirma = $("#selPaisNaciomientoFirma").val();
    var selEntidadNacimientoFirma = $("#selEntidadNacimientoFirma").val();
    var selMunicipioNacimientoFirma = $("#selMunicipioNacimientoFirma").val();
    var impCrupEmpleadoFirma = $("#impCrupEmpleadoFirma").val();
    var impTelefonoEmpleadoFirma = $("#impTelefonoEmpleadoFirma").val();
    var impCorreoEmpleadoFirma = $("#impCorreoEmpleadoFirma").val();
    var selPreguntaUnoFirma = $("#selPreguntaUnoFirma").val();
    var impPrimerPregunta = $("#impPrimerPregunta").val();
    var selPreguntaDosFirma = $("#selPreguntaDosFirma").val();
    var impSegundaPregunta = $("#impSegundaPregunta").val();
    var selPreguntaTresFirma = $("#selPreguntaTresFirma").val();
    var impTerceraPregunta = $("#impTerceraPregunta").val();

    

    if(impNombreEmpleadoFirma == ""){
      cargaerroresFirmaInterna("El Campo 'Nombre' No Puede Estar vacio");
    }else if(impNombreEmpleadoFirma.toLowerCase() != nombreHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Nombre' No Coincide Con el Nombre Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(impApellidoPaternoFirma == ""){
      cargaerroresFirmaInterna("El Campo 'Apellido Paterno' No Puede Estar vacio");
    }else if(impApellidoPaternoFirma.toLowerCase() != apellidoPatHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Apellido Paterno' No Coincide Con el Apellido Parterno Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(impApellidoMaternoFirma == ""){
      cargaerroresFirmaInterna("El Campo 'Apellido Marterno' No Puede Estar vacio");
    }else if(impApellidoMaternoFirma.toLowerCase() != apellidoMatHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Apellido Marterno' No Coincide Con el Apellido Marterno Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(selPaisNaciomientoFirma == "" || selPaisNaciomientoFirma == "null" || selPaisNaciomientoFirma == "NULL" || selPaisNaciomientoFirma == 0){
      cargaerroresFirmaInterna("El Campo 'Pais De Nacimiento' No Puede Estar vacio Favor De Escoger Uno");
    }else if(selPaisNaciomientoFirma.toLowerCase() != paisHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Pais De Nacimiento' No Coincide Con el Pais De Nacimiento Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(selEntidadNacimientoFirma == "" || selEntidadNacimientoFirma == "null" || selEntidadNacimientoFirma == "NULL" || selEntidadNacimientoFirma == 0){
      cargaerroresFirmaInterna("El Campo 'Entidad De Nacimiento' No Puede Estar vacio Facor De escoger Uno");
    }else if(selEntidadNacimientoFirma.toLowerCase() != entidadHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Entidad De Nacimiento' No Coincide Con La Entidad De Nacimiento Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(selMunicipioNacimientoFirma == "" || selMunicipioNacimientoFirma == "null" || selMunicipioNacimientoFirma == "NULL" || selMunicipioNacimientoFirma == 0){
      cargaerroresFirmaInterna("El Campo 'Municipio De Nacimiento' No Puede Estar Vacio Favor De Escoger Uno");
    }else if(selMunicipioNacimientoFirma.toLowerCase() != municipioHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Municipio De Nacimiento' No Coincide Con el Municipio De Nacimiento Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(impCrupEmpleadoFirma == ""){
      cargaerroresFirmaInterna("El Campo 'CURP' No Puede Estar vacio");
    }else if(impCrupEmpleadoFirma.toLowerCase() != cURPHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'CURP' No Coincide Con el CURP Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(impTelefonoEmpleadoFirma == ""){
      cargaerroresFirmaInterna("El Campo 'Telefono Celular' No Puede Estar vacio");
    }else if(impTelefonoEmpleadoFirma.toLowerCase() != telefonoHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Telefono Celular' No Coincide Con el Telefono Celular Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(impCorreoEmpleadoFirma == ""){
      cargaerroresFirmaInterna("El Campo 'Correo Personal' No Puede Estar vacio");
    }else if(impCorreoEmpleadoFirma.toLowerCase() != correoHidden.toLowerCase()){
      cargaerroresFirmaInterna("El Campo 'Correo Personal' No Coincide Con el Correo Personal Capturado En Recursos Humanos Favor De Revisarlo");
    }else if(selPreguntaUnoFirma == "" || selPreguntaUnoFirma == "null" || selPreguntaUnoFirma == "NULL" || selPreguntaUnoFirma == 0){
      cargaerroresFirmaInterna("El Campo 'Primer Pregunta' No Puede Estar Vacio Favor De Escoger Uno");
    }else if(impPrimerPregunta == "" ){
      cargaerroresFirmaInterna("Favor De Escribr La Respuesta a La Primera Pregunta");
    }else if(selPreguntaDosFirma == "" || selPreguntaDosFirma == "null" || selPreguntaDosFirma == "NULL" || selPreguntaDosFirma == 0){
      cargaerroresFirmaInterna("El Campo 'Segunda Pregunta' No Puede Estar Vacio Favor De Escoger Uno");
    }else if(impSegundaPregunta == ""){
      cargaerroresFirmaInterna("Favor De Escribr La Respuesta a La Segunda Pregunta");
    }else if(selPreguntaTresFirma == "" || selPreguntaTresFirma == "null" || selPreguntaTresFirma == "NULL" || selPreguntaTresFirma == 0){
      cargaerroresFirmaInterna("El Campo 'Tercera Pregunta' No Puede Estar Vacio Favor De Escoger Uno");
    }else if(impTerceraPregunta == ""){
      cargaerroresFirmaInterna("Favor De Escribr La Respuesta a La Tervera Pregunta");
    }else{
      $("#modalcontraseniaFirma").modal();
      $("#ContraseniaFirma1").val("");
      $("#ContraseniaFirma2").val("");
    }
  });

  $("#guardarIncertarFirmaInterna").click(function() { 
    var ContraseniaFirma1 = $("#ContraseniaFirma1").val();
    var ContraseniaFirma2 = $("#ContraseniaFirma2").val();
    if(ContraseniaFirma1 != ContraseniaFirma2){
      $('#errorFirmaInternaModal').fadeIn();
      msjerrorbaja="<div id='errorFirmaInternaModal1' class='alert alert-error'><strong>ALERTA:</strong>La Contraseña Ingresada No Son Identicas Favor De Corregir Para Continuar<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";             
      $("#errorFirmaInternaModal").html(msjerrorbaja);
      $(document).scrollTop(0);
      $('#errorFirmaInternaModal').delay(4000).fadeOut('slow'); 
    }else{
      $("#ContraseniaFirma").val($("#ContraseniaFirma1").val());
      
      RegistrarDatosFirmaElectronica();
    }
});

  function RegistrarDatosFirmaElectronica(){
    var datastring = $("#form_RegistroFirmaElectronica").serialize();
    $.ajax({
      type: "POST",
      url: "ajax_RegistrarFirmaElectronica.php",
      data: datastring,
      dataType: "json",
      success: function(response) {
        console.log(response);
        var mensaje=response.message;
        if (response.status=="success") {
          $("#modalcontraseniaFirma").modal("hide");
          BorrarformaularioRegistroFirma();
          $('#errorFirmaInterna').fadeIn();
          msjerrorbaja="<div id='errorFirmaInterna1' class='alert alert-success'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
          $("#errorFirmaInterna").html(msjerrorbaja);
          $(document).scrollTop(0);
          $('#errorFirmaInterna').delay(5000).fadeOut('slow'); 
        }else{
          $("#modalcontraseniaFirma").modal("hide");
          cargaerroresFirmaInterna(mensaje);
        }
               
      },error: function(jqXHR, textStatus, errorThrown){
          alert(jqXHR.responseText);
      }
    });
  } 

  $("#cancelarFirmaInterna").click(function() {
    BorrarformaularioRegistroFirma();
  });

  function BorrarformaularioRegistroFirma() {
    document.getElementById("form_RegistroFirmaElectronica").reset();
    $("#selEntidadNacimientoFirma").empty();
    $("#selMunicipioNacimientoFirma").empty();
    $("#selPreguntaUnoFirma").empty();
    $("#selPreguntaDosFirma").empty();
    $("#selPreguntaTresFirma").empty();
  }
// Recuperacion de la firma intertna //////////////////////

$("#impNumeroEmpleadoFirmaR").blur(function () 
{

 var impNumeroEmpleadoFirmaR = $("#impNumeroEmpleadoFirmaR").val();
 var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
 var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;
 
 if(expreg.test(impNumeroEmpleadoFirmaR) || expreg1.test(impNumeroEmpleadoFirmaR)){
  $.ajax({
    type: "POST",
    url: "ajax_VerificacionFirmaAlamcenada.php",
    data:{"numeroEmpleado":impNumeroEmpleadoFirmaR},
    dataType: "json",
    success: function(response) {
      console.log(response);
      if (response.status == "success"){
        console.log(response);
        var empleadoExtiste = response["datos"].length;
        if(empleadoExtiste=="0"){
          cargaerroresFirmaInterna("El Empleado No Tiene Una Firma Registrada Favor De Verificar O Registrar Una Nueva");
          $("#impNumeroEmpleadoFirmaR").val("");
          $("#cancelarRecuperacionFirmaInterna").hide();
          $("#RecuperarFirmaInterna").hide();
          $("#CorreoAEnviarR").hide();
          $("#spCorreoAEnviarR").hide();
        }else{
          $("#selPreguntaUnoFirmRa").val(0);
          $("#impPrimerPreguntaR").val("");
          $("#CorreoAEnviarR").val(response["datos"][0].correoEmpleado);
          correoRecuperacion = response["datos"][0].correoEmpleado;
          Respuesta1 = response["datos"][0].RespPrimerPregunta;
          Respuesta2 = response["datos"][0].RespSegundaPregunta;
          Respuesta3 = response["datos"][0].RespTercerPregunta;
          idRespuesta1 = response["datos"][0].idPrimerPregunta;
          idRespuesta2 = response["datos"][0].idSegundaPregunta;
          idRespuesta3 = response["datos"][0].idTercerPregunta;
          $("#CorreoAEnviarR").show();
          $("#spCorreoAEnviarR").show();
          $("#cancelarRecuperacionFirmaInterna").show();
          $("#RecuperarFirmaInterna").show();
        }
      }
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
 }else{
    cargaerroresFirmaInterna("El Formato Del Numero De Empleado Es Incorrecto");
    $("#impNumeroEmpleadoFirmaR").val("");
    $("#cancelarRecuperacionFirmaInterna").hide();
    $("#RecuperarFirmaInterna").hide();
    $("#CorreoAEnviarR").hide();
    $("#spCorreoAEnviarR").hide();

  }
});

function cargaerroresFirmaInterna(mensaje){
  $('#errorFirmaInterna').fadeIn();
  msjerrorbaja="<div id='errorFirmaInterna1' class='alert alert-error'><strong>ALERTA:</strong> "+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                   
  $("#errorFirmaInterna").html(msjerrorbaja);
  $(document).scrollTop(0);
  $('#errorFirmaInterna').delay(4000).fadeOut('slow'); 
}

 function BorrarformaulariRecuperacionFirma() {
    $("#impNumeroEmpleadoFirmaR").val("");
    $("#selPreguntaUnoFirmRa").val(0);
    $("#impPrimerPreguntaR").val("");
    $("#CorreoAEnviarR").val("");
  }

 $("#cancelarRecuperacionFirmaInterna").click(function() {
  BorrarformaulariRecuperacionFirma();
 });
 $("#RecuperarFirmaInterna").click(function() {

  var idProporcionado = $("#selPreguntaUnoFirmRa").val();
  var respuestaproporcionada = $("#impPrimerPreguntaR").val();
  var bandera = 0;
  var Respuesta = "";
  if(idProporcionado == idRespuesta1){
    bandera = 1;
    Respuesta=Respuesta1;
  }else if(idProporcionado == idRespuesta2){
    bandera = 1;
    Respuesta=Respuesta2;
  }else if(idProporcionado == idRespuesta3){
    bandera = 1;
    Respuesta=Respuesta3;
  }else{
    bandera = 0;
  }

  if(bandera=="0"){
    cargaerroresFirmaInterna("La Pregunta Seleccionada NO Corresponde A Ninguna Seleccionada Al Registrar La Firma Interna Favor De Verificar !!");
  }else{
    if(respuestaproporcionada == Respuesta){
      var correo = correoRecuperacion;
    mandarcorreorecuperacionfirma(correo);
    }else{
    cargaerroresFirmaInterna("La Respueta Proporcionada NO Corresponde A La Respuesta Proporcionada Al Registrar La Firma Interna Favor De Verificar !!");

    }
  }

 });

 function mandarcorreorecuperacionfirma(correo){
  waitingDialog.show();
  $.ajax({
    type: "POST",
    url: "ajax_EnviarCorreoRestauracionFirmainterna.php",
    data:{"correo":correo},
    dataType: "json",
    success: function(response) {
      console.log(response);
      waitingDialog.hide();
     BorrarformaulariRecuperacionFirma();
      alert(response.message);
    },error: function(jqXHR, textStatus, errorThrown) {
      alert(jqXHR.responseText);
    }
  });
 }

  






</script>


