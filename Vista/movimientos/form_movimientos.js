$("#selectAnioMov").change(function(){
  $("#archivoMov").val("");
  if($("#selectAnioMov").val()=='0'){
       $("#selectMesMov").hide();
       $("#selectMesMov").val(0);
       $("#divZIPActualMov").hide();
    }else{
          $("#selectMesMov").show();
          $("#btncargarMov").prop("disabled", false);
          $("#divZIPActualMov").hide();
      }
      $("#formMov")[0].reset(); 
});

$("#selectMesMov").change(function(){
    $("#archivoMov").val("");
    if($("#selectMesMov").val()==0){
       $("#btncargarMov").prop("disabled", true);
       $("#divZIPActualMov").hide();
    }else{
          waitingDialog.show();
          $("#btncargarMov").prop("disabled", false);
          $("#divZIPActualMov").hide();

        var mes=$("#selectMesMov").val();
        var anioActual = $("#selectAnioMov").val();

        $.ajax({            
            type: "POST",
            url: "movimientos/ajax_ConsultaCargaMov.php",
            data:{mes,anioActual},
            dataType: "json",
            success:function(response){ 
                    if(response.status=='success'){  
                      if(response.datos.length==1){
                        $("#divZIPActualMov").show();  
                        // var p="<span class='btn btn-success btn-file'><a href='https://"+location.hostname+"/zonacgg/Vista/uploads/movimientos/movimiento_"+mes+anioActual+".zip'><img src='img/ZIP.png' height='24px' width='24px'/></a></span>";
                        var p = "<span class='btn btn-success btn-file'><a href='" + window.location.protocol + "//" + location.hostname + "/zonacgg/Vista/uploads/movimientos/movimiento_" + mes + anioActual + ".zip'><img src='img/ZIP.png' height='24px' width='24px'/></a></span>";

                        $("#divZIPActualMov").html(p);  
                          waitingDialog.hide();
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#formMov")[0].reset(); 
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                            $("#btncargarMov").prop("disabled",false); 
                            $("#divZIPActualMov").hide();
                            waitingDialog.hide();
                      }
                    }
            },
            error: function(jqXHR, textStatus, errorThrown){
                  alert(jqXHR.responseText); 
            }
        });
    }
});

function cargarMov (){     

    waitingDialog.show();
    var mes = $("#selectMesMov").val();
    var archivoMov = $("#archivoMov").val();
    var anio = $("#selectAnioMov").val();

    if(mes==="0"){
       waitingDialog.hide();
       alert("Selecciona un mes");
       return;
    }else if(archivoMov==""){
       waitingDialog.hide();
       alert("Selecciona un archivo");
       return;
    }

    var formData = new FormData($("#formMov")[0]);
    formData.append('mes', mes);
    formData.append('anio', anio);
             
    $.ajax({            
        type: "POST",
        url: "movimientos/ajax_uploadMov.php",
        data:formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success:function(response){ 
            var msj=response.message;
            if(response.status=='success'){   
 		       alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#formMov")[0].reset(); 
               $("#alertMsg").html(alertMsg1);                    
               $('#msgAlert').delay(2000).fadeOut('slow');   
               $("#selectMesMov").val(0);
               $("#valorActualizarMov").val();    
               waitingDialog.hide();
               $("#divZIPActualMov").hide();
            }else{
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#formMov")[0].reset(); 
                  $("#alertMsg").html(alertMsg1);                    
                  $('#msgAlert').delay(2000).fadeOut('slow');       
                  waitingDialog.hide();                  
            }
        },error:function(jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText); 
                waitingDialog.hide();                  
          }
    });
  }

function mostrarZIP(archivo){ 
     window.open("uploads/DocumentosSISUB/"+archivo+".pdf",'fullscreen=no');
     waitingDialog.hide();
}


