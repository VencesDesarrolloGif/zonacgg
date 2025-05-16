<div align="center">	

	<input type="text" name="txtSearchNombreP" id="txtSearchNombreP" class="input-xlarge" placeholder="APELLIDOS NOMBRE(S) (FOLIO)" ><a href="#"><img src="img/search.png" onClick="consultaPreseleccionPorNombre();"></a>	


	<div id="listaDePreseleccion" >
  
  	</div>

</div>

<script type="text/javascript">
	
	

	$('#txtSearchNombreP').keypress(function(event){  
       var keycode = (event.keyCode ? event.keyCode : event.which);  
      if(keycode == '13'){  
           //alert('Se ha presionado Enter!');  
           consultaPreseleccionPorNombre();           
      }   
 	});

  function consultaPreseleccionPorNombre(){
      var valor=$('#txtSearchNombreP').val();
      
      $.ajax({      
            async: false,      
            type: "POST",
            url: "ajax_obtenerPreseleccionByNombre.php",
            data:{"nombre":valor},
            dataType: "json",
             success: function(response) {  

                if (response.status == "success")
                {                        
                    var aspirantes=response.aspirante;
                    if(aspirantes.length !=0 ){                        
                        var preseleccionTable="<table class='table table-hover' id='tablePre'><thead><th>Folio</th><th>Nombre Completo</th><th>Edad</th><th>Puesto Solicitado</th><th>Expediente</th></thead><tbody>";

                        for (var i=0;i<aspirantes.length;i++){
                          
                            var folio=aspirantes[i].folioPreseleccion;
                            var nombre=aspirantes[i].nombrePreseleccion;
                            var apPaterno=aspirantes[i].apPaternoPreseleccion;
                            var apMaterno=aspirantes[i].apMaternoPreseleccion;
                            var puestoSolicitado=aspirantes[i].puestoPreseleccion;
                            var edad=aspirantes[i].edadPreseleccion;
                            var edoCivil=aspirantes[i].edoCivilPreseleccion;
                            var nombreCompleto= nombre+" "+apPaterno+" "+apMaterno;
                                                          
                            var solicitud="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-solicitud.png";
                            var testMedico="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-doctor.png";
                            var etico="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-etica.png";

                            var constancia="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-servicio.png";
                            var protesta="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-protesta.png";
                            var doping="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-doping.png";
                            var renuncia="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-renuncia.png";
                            var cCompromiso="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-compromiso.png";
                            var privacidad="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-privacidad.png";
                            var croquis="http://<?php echo $_SERVER["SERVER_NAME"] . ":" .  $_SERVER["SERVER_PORT"]  . dirname ($_SERVER ["SCRIPT_NAME"]); ?>/img/icon-croquis.png";    

                            preseleccionTable+="<tr><td>"+folio+"</td><td>"+nombreCompleto+"</td><td>"+edad+" AÑOS</td><td>"+puestoSolicitado+"</td><td>";


                            preseleccionTable+="<button type='button' onClick='generarSolicitud(\""+folio+"\");'><img class='cursorImg' src='"+solicitud+"' data-toggle='tooltip' data-placement='right' title='SOLICITUD' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarTestMedico(\""+folio+"\");'><img class='cursorImg' src='"+testMedico+"' data-toggle='tooltip' data-placement='right' title='TEST MEDICO' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarPerfilEtico(\""+folio+"\");'><img class='cursorImg' src='"+etico+"' data-toggle='tooltip' data-placement='right' title='PERFIL ÉTICO' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarConstanciaServ(\""+folio+"\");'><img class='cursorImg' src='"+constancia+"' data-toggle='tooltip' data-placement='right' title='CONSTANCIA DE SERVICIO' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarProtesta(\""+folio+"\");'><img class='cursorImg' src='"+protesta+"' data-toggle='tooltip' data-placement='right' title='PROTESTA' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarDoping(\""+folio+"\");'><img class='cursorImg' src='"+doping+"' data-toggle='tooltip' data-placement='right' title='DOPING' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarRenuncia(\""+folio+"\");'><img class='cursorImg' src='"+renuncia+"' data-toggle='tooltip' data-placement='right' title='RENUNCIA' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarCartaCompromiso(\""+folio+"\");'><img class='cursorImg' src='"+cCompromiso+"' data-toggle='tooltip' data-placement='right' title='CARTA COMPROMISO' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarAvisoPrivacidad(\""+folio+"\");'><img class='cursorImg' src='"+privacidad+"' data-toggle='tooltip' data-placement='right' title='AVISO DE PRIVACIDAD' ></button>";

                            preseleccionTable+="<button  type='button' onClick='generarCroquis(\""+folio+"\");'><img class='cursorImg' src='"+croquis+"' data-toggle='tooltip' data-placement='right' title='CROQUIS' ></button>";                       

                            preseleccionTable+="</td></tr>";
                                                                                      
                        }
                        preseleccionTable+="</tbody></table>";
                        $('#listaDePreseleccion').html(preseleccionTable);





                    }else{                        
                         alertMsg1="<div id='msgAlert' class='alert alert-error'>Error: No se encontraron coincidencias en Preselección<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";                        
                        $("#alertMsg").html(alertMsg1);   
                        $('#listaDePreseleccion').html("");                                              
                        $(document).scrollTop(0);
                        $('#msgAlert').delay(3000).fadeOut('slow');
                    }
                  
                }            
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });

  }

  function generarSolicitud(folio)
    {
      var folioA=folio; 
         
    //  alert(apellido);
      window.open("generadorSolicitudEmpleo.php?folioAspirante="+folioA+"",'nombre','fullscreen=no');
     //
     //window.open("http://www.cnn.com/", "CNN_WindowName","menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes");
      //parent.opener=top;
      //opener.close();

    }

     function generarTestMedico(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorTestMedico.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
     //
      //parent.opener=top;
      //opener.close();

    }
    
     function generarPerfilEtico(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorPerfilEtico.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');
     //
      //parent.opener=top;
      //opener.close();

    }

    function generarConstanciaServ(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorConstanciaServicio.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');

    }

    function generarProtesta(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorProtesta.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');

    }

     function generarDoping(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorPruebaDoping.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');

    }

     function generarRenuncia(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorVoluntaria.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');

    }
    
    function generarCartaCompromiso(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorCartaCompromiso.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');

    }
    
    function generarAvisoPrivacidad(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorAvisoPrivacidad.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');

    }
    
    function generarCroquis(folio)
    {

      var folioAs=folio;
            
    //  alert(apellido);
      window.open("generadorCroquis.php?folioAspirante="+folioAs+"",'Informe3','fullscreen=no');

    }

</script>