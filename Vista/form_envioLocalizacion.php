<div class="hero-unit">
<div id="tiempo1" style="font-family: verdana; font-size: 16px;"></div>
<table id="reloj" border='0'>

	<tr>

		<td><h2>Hora dispositivo: </h2></td>
		<td><div id='hora'></div></td>
		<td><div><h2>:</h2></div></td>
		<td><div id='minuto'></div></td>
	</tr>
	<tr>
		<td><h2>Hora servidor: </h2></td>
		<td><div id='hora2'></div></td>
		<td><div><h2>:</h2></div></td>
		<td><div id='minuto2'></div></td>
	</tr>
</table>
	<h1><a href="javascript:detectar();">Enviar ubicación</a></h1><br>
	<img class="cursorImg" src="img/ubicacion.png" data-toggle="tooltip" title="Enviar ubicación" height="200" width="200" onclick="detectar();">
	<div id="divUbicaciones" name="divUbicaciones"></div>
</div>
<div id="mapa"></div>
<script language="javascript">

//getFecha();
Reloj();
getDateServer();
getUbicacionesDay();

function Reloj() {
	var tiempo = new Date();
	var hora = tiempo.getHours();
	var minuto = tiempo.getMinutes();
	
	document.getElementById('hora').innerHTML = "<h2>"+hora+"</h2>";
	document.getElementById('minuto').innerHTML = "<h2>"+minuto+"</h2>";
	
	setTimeout('Reloj()', 1000);
	str_hora = new String(hora);
	if (str_hora.length == 1) {
		document.getElementById('hora').innerHTML = "<h2>"+'0' + hora+"</h2>";
	}
	if (hora>12) {
		format=parseInt(hora-12);

		document.getElementById('hora').innerHTML = "<h2>"+'0'+ format+"</h2>";
	}
	str_minuto = new String(minuto);
	if (str_minuto.length == 1) {
		document.getElementById('minuto').innerHTML = "<h2>"+'0' + minuto+"</h2>";
	}

}
function detectar(){
	
	if (typeof navigator.geolocation == 'object'){
    	navigator.geolocation.getCurrentPosition(guardar_ubicacion,function(){document.getElementById('mapa').innerHTML="No se pudo detectar la ubicación"});
	}

	else{
  		document.getElementById('mapa').innerHTML="La geolocalización no funciona en este navegador.";
	}
}

function guardar_ubicacion(p){
	var coords = p.coords.latitude + "," + p.coords.longitude;

	var  f= new Date();
	var fechaDispositivo=f.getDate() + "-" + (f.getMonth() +1) + "-" + f.getFullYear()+" "+f.getHours()+":"+f.getMinutes()+":"+f.getSeconds();
	var latitude=p.coords.latitude;
	var longitude=p.coords.longitude;
	//alert(latitude+ " " +longitude);
	waitingDialog.show();
	
	$.ajax({
        type: "POST",
        url: "ajax_registroUbicacion.php",
        data: {latitude:latitude, longitude:longitude, fechaDispositivo:fechaDispositivo},
        dataType: "json",
        success: function(response) {
            var mensaje=response.message;

            if (response.status=="success") {
            	waitingDialog.hide();  
            	getUbicacionesDay();
            	alert(mensaje);
            } else if (response.status=="error")
            {
            	waitingDialog.hide(); 
              	alert(mensaje);
            }
          },
        error: function(){
              alert('error handing here');
        }
    });
}

/*function detectar(){
	if (navigator.geolocation)
		{			
			var success = function(position)
			{
				alert("entra");
				var coords = position.coords.latitude + "," + position.coords.longitude;

				var  f= new Date();
				var fechaDispositivo=f.getDate() + "-" + (f.getMonth() +1) + "-" + f.getFullYear()+" "+f.getHours()+":"+f.getMinutes()+":"+f.getSeconds();
				var latitude=position.coords.latitude;
				var longitude=position.coords.longitude;
				alert(latitude+ " " +longitude);
				waitingDialog.show();
				$.ajax({
			        type: "POST",			        
			        url: "ajax_registroUbicacion.php",
			        data: {latitude:latitude, longitude:longitude, fechaDispositivo:fechaDispositivo},
			        dataType: "json",
			        success: function(response) {
			            var mensaje=response.message;

			            if (response.status=="success") {
			            	waitingDialog.hide();  
			            	getUbicacionesDay();
			            	alert(mensaje);
			            } else if (response.status=="error")
			            {
			            	waitingDialog.hide(); 
			              	alert(mensaje);
			            }
			          },
			        error: function(){
			              alert('error handing here');
			        }
    			});


			}
			navigator.geolocation.getCurrentPosition(success, function(msg){
				alert("error");
			});


		}
		else
		{
			alert("Su navegador no soporta la API de geolocalización.");
		}
}*/


function getDateServer(){
   // var rutalogo="img/logoGif.jpg";
  $.ajax({
        
        type: "POST",
        url: "ajax_getDate.php",
        dataType: "json",
        success: function(response) {
            if (response.status == "success")
            {
            
                var fecha=new Date(response.dateServer);
				//alert(fecha);
				var hora=fecha.getHours();
				var minuto=fecha.getMinutes();
				var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
				var day=fecha.getDay();
				var dayName=diasSemana[day];
				//alert(dayName);
				//alert(day);

				document.getElementById("tiempo1").innerHTML = "<h2>"+dayName+","+ fecha.getDate()+" de "+meses[fecha.getMonth()]+" de "+fecha.getFullYear()+"</h2>";
				//+ ", " + + " de " + meses[fecha.getMonth()] + " de " + f.getFullYear()+"</h2>";
				
					document.getElementById('hora2').innerHTML = "<h2>"+hora+"</h2>";
					document.getElementById('minuto2').innerHTML = "<h2>"+minuto+"</h2>";
					
					setTimeout('getDateServer()', 60000);
					str_hora = new String(hora);
					if (str_hora.length == 1) {
						document.getElementById('hora2').innerHTML = "<h2>"+'0' + hora+"</h2>";
					}
					if (hora>12) {
						format=parseInt(hora-12);
						document.getElementById('hora2').innerHTML = "<h2>"+'0'+ format+"</h2>";
					}
					str_minuto = new String(minuto);
					if (str_minuto.length == 1) {
						document.getElementById('minuto2').innerHTML = "<h2>"+'0' + minuto+"</h2>";
					}
			             
            }              
        },
        error: function (response)
        {
            console.log (response);

        }
    });
 }
function getUbicacionesDay()
{
	
	var  f= new Date();
	var fecha1=f.getFullYear()+"-"+(f.getMonth() +1)+"-"+f.getDate();
	//alert("consultando");

  $.ajax({
        
        type: "POST",
        url: "ajax_getUbicacionesGuardiaByFecha.php",
        data: {fecha1:fecha1},
        dataType: "json",
        success: function(response) {
            if (response.status == "success")
            {
                 
                var lista = response.ubicaciones;
            	listaTable="<table class='table table-hover' ><thead><th></th><th></th></thead><tbody>";

                for ( var i = 0; i < lista.length; i++ ){

                	var fecha = lista[i].fechaCaptura;
                	//alert(fecha);
                    
              		listaTable += "<tr><td><h2>Ubicación enviada a las: </h2></td><td><h2>"+fecha+" </h2></td><tr>";
                }       
              listaTable += "</tbody></table>";
              $('#divUbicaciones').html(listaTable);     
                                  
             }
        },           

        error: function (response)
        {
            console.log (response);

        }
    });
}
	/* 
	function distancia(lat2,lon2)
	{
	 	var lat1="19.3992379";
	    var lon1="-99.0946041";
	  	//var lat2="19.404178899999998";
	  	//var lon2="-99.1290236";

	   	rad = function(x) {return x*Math.PI/180;}
	    var R = 6378.137; //Radio de la tierra en km
	   	var dLat = rad( lat2 - lat1 );
	   	var dLong = rad( lon2 - lon1 );
	   	var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
	   	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
	   	var d = R * c;

	   	alert(d);
		//return d.toFixed(3); //Retorna tres decimales
	}
	*/
</script>