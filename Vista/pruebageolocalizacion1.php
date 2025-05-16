<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <center><h3>GEOLOCALIZACIÓN</h3></center>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
</head>
<body>
  <br>
  <div align="center">
    <label class="control-label label" id="lblpuntoserviciogeo">PUNTO DE SERVICIO</label>
    <select id="SelPuntoServicioGeo" name="SelPuntoServicioGeo" class="span3"></select>
  </div><br>
  <div align="center" style="display: none;" id="divInpNumEmpleadoGeo">
    <label class="control-label label" id="lblpuntoserviciogeo">NÚMERO EMPLEADO</label>
    <input type="text" id="inpNumEmpleadoGeo" name="inpNumEmpleadoGeo" placeholder="00-(0000 ó 00000)-00" onblur="verificaEmpleadoGeo();" maxlength="11">
  </div>
</body>
</html>
<script type="text/javascript"> //empieza lo de js
$(entrageo()); 

function entrageo(){
  console.log(navigator.geolocation);
  if(navigator.geolocation){
    var success = function(position){
      var latitud = position.coords.latitude,
      longitud = position.coords.longitude;
      alert(latitud);
      alert(longitud);
      CargarSelectorPuntosServicoXGeolacalizacion(latitud,longitud);
    }
    navigator.geolocation.getCurrentPosition(success, function(msg){
      alert("Denegaste Permisos De Geolocalizacion No Se Cargaran Los Puntos De Servicio");
      console.error( msg );});
  }
}

function CargarSelectorPuntosServicoXGeolacalizacion(latitud,longitud){
  $.ajax({
    type: "POST",
    url: "ajax_PuntosServicioGeoParaRostro.php",
    data: {"latitud": latitud,"longitud": longitud},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success"){
        for (var i = 0; i < response.datos.length; i++){
          $('#SelPuntoServicioGeo').append('<option value="' + (response.datos[i].idpuntos) + '">' + response.datos[i].puntoServicio + '</option>');
        }
        var SelPuntoServicio = $("#SelPuntoServicioGeo").val();
        if(SelPuntoServicio != "0"){
          $("#inpNumEmpleadoGeo").val("");
          $("#divInpNumEmpleadoGeo").show();
        }else{
          $("#inpNumEmpleadoGeo").val("");
          $("#divInpNumEmpleadoGeo").hide();
        }
      }else{
        alert("Error Al Cargar El Punto De Servicio");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
    }
  });
}
$("#SelPuntoServicioGeo").change(function() {
  $("#inpNumEmpleadoGeo").val("");
});

function verificaEmpleadoGeo()
{
  var numeroEmpleado = $("#inpNumEmpleadoGeo").val();
  var expreg = /^[0-9]{2}\-[0-9]{4}\-[0-9]{2}/;
  var expreg1 = /^[0-9]{2}\-[0-9]{5}\-[0-9]{2}/;

  
  if(expreg.test(numeroEmpleado) || expreg1.test(numeroEmpleado))
  {
    CargarFotosEmpleado(numeroEmpleado);
  }else if (numeroEmpleado.length != 10 && numeroEmpleado.length != 11){
    alert("Ingrese El Número De Empleado Completo");
  }else{
    alert("ingrese El Numero De Empleado Correcto");
  }
}
function CargarFotosEmpleado(numeroEmpleado){
  var PuntoServicioGeo = $("#SelPuntoServicioGeo").val();
  $.ajax({
    type: "POST",
    url: "ajaxRevisarStatusEmpleado.php",
    data: {"numeroEmpleado": numeroEmpleado},
    dataType: "json",
    async:false,
    success: function(response) {
      if (response.status == "success"){
        var EstatuaEmp = response.datos[0].empleadoEstatusId;
        if(EstatuaEmp == "0"){
          alert("El Empleado Esta Dado De Baja No Se Puede Acceder");
        }else{
          EscanearEmpleadoAutorizacion();
        }
      }else{
        alert("Error Al Cargar El Punto De Servicio");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
    }
  });
}

function EscanearEmpleadoAutorizacion(){
  alert("Entre A Realizar Reconocimiento Facial");
}

</script>