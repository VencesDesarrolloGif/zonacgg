$("#selectDocXML").change(function(){
    if($("#selectDocXML").val()=='0'){
       $("#selectAnioXML").hide();
       $("#selectMesXML").hide();
       $("#divPDFActualXML").hide();
    }else{
          $("#selectAnioXML").show();
          $("#selectAnioXML").val(0);
          $("#selectMesXML").hide();
          $("#btncargarXML").prop("disabled", false);
          $("#divPDFActualXML").hide();
      }
      $("#formXML")[0].reset(); 
});


$("#selectAnioXML").change(function(){
  if($("#selectAnioXML").val()=='0'){
       $("#selectMesXML").hide();
       $("#selectMesXML").val(0);
       $("#divPDFActualXML").hide();
    }else{
          $("#selectMesXML").show();
          $("#divPDFActualXML").hide();
      }
      $("#formXML")[0].reset(); 
});

$("#selectMesXML").change(function(){
    if($("#selectMesXML").val()==0){
       $("#btncargarXML").prop("disabled", true);
       $("#divPDFActualXML").hide();
    }else{
          waitingDialog.show();
          $("#btncargarXML").prop("disabled", false);
          $("#divPDFActualXML").hide();

        var mesXML    =$("#selectMesXML").val();
        var anioActual=$("#selectAnioXML").val();
        var tipoDoc   =$("#selectDocXML").val();

        $.ajax({            
            type: "POST",
            url: "XML/ajax_ConsultaCargaXML.php",
            data:{mesXML,anioActual,tipoDoc},
            dataType: "json",
            success:function(response){ 
                    if(response.status=='success'){  
                      if(response.datos.length==1){
                         var pdf=response.datos[0]["nombreDocumentoXML"];
                         if (tipoDoc=='1'){
                             var p="<a href='http://"+location.hostname+"/zonacgg/Vista/uploads/DocumentosXMLIMSS/XML_IMSS"+mesXML+anioActual+".zip'><img src='img/ZIP.png' height='50px' width='50px'/></a>";
                         }
                         if (tipoDoc=='2'){
                            var p="<a href='http://"+location.hostname+"/zonacgg/Vista/uploads/DocumentosXMLINFONAVIT/XML_INFONAVIT"+mesXML+anioActual+".zip'><img src='img/ZIP.png' height='50px' width='50px'/></a>";
                         }
                          $("#divPDFActualXML").show();
                          $("#divPDFActualXML").html(p);
                          $("#btncargarXML").prop("disabled",false);  
                          waitingDialog.hide();
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#formXML")[0].reset(); 
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                            $("#btncargarXML").prop("disabled",false); 
                            $("#divPDFActualXML").hide();
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

function cargarXML (){     

    waitingDialog.show();
    var mesXML = $("#selectMesXML").val();
    var archivoXML = $("#archivoXML").val();
    var anioActual=$("#selectAnioXML").val();
    var tipoDoc   =$("#selectDocXML").val();

    if(anioActual=='0'){
       waitingDialog.hide();
       alert("Selecciona el ejercicio");
       return;
    }else if(mesXML==="0"){
       waitingDialog.hide();
       alert("Selecciona un mes");
       return;
    }else if(archivoXML==""){
       waitingDialog.hide();
       alert("Selecciona un archivo");
       return;
    }else if(tipoDoc=='0'){
       waitingDialog.hide();
       alert("Selecciona el tipo de documento");
       return;
    }
    var formData = new FormData($("#formXML")[0]);
    formData.append('anioActual', anioActual);
    formData.append('mesXML', mesXML);
    formData.append('tipoDoc', tipoDoc);
         
    $.ajax({            
        type: "POST",
        url: "XML/ajax_uploadXML.php",
        data:formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success:function(response){ 
            var msj=response.mensaje;
            if(response.status=='success'){   
 		       alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#formXML")[0].reset(); 
               $("#alertMsg").html(alertMsg1);                    
               $('#msgAlert').delay(2000).fadeOut('slow');   
               $("#selectMesXML").val(0);
               waitingDialog.hide();
               $("#divPDFActualXML").hide();
               $("#selectAnioXML").hide();
               $("#selectMesXML").hide();
               $("#divPDFActualXML").hide();
               $("#selectAnioXML").val('0');
               $("#selectMesXML").val('0');
               $("#selectDocXML").val('0');
               $("#divPDFActualXML").val('');
            }else{
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#formXML")[0].reset(); 
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