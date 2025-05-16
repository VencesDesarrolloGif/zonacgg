$("#selectAnioSISUB").change(function(){
  if($("#selectAnioSISUB").val()=='0'){
       $("#selectCuatriSISUB").hide();
       $("#divPDFActualSISUB").hide();
    }else{
          $("#selectCuatriSISUB").show();
          $("#btncargarSISUB").prop("disabled", false);
          $("#divPDFActualSISUB").hide();
      }
      $("#formSISUB")[0].reset(); 
});

$("#selectCuatriSISUB").change(function(){
    if($("#selectCuatriSISUB").val()==0){
       $("#btncargarSISUB").prop("disabled", true);
       $("#divPDFActualSISUB").hide();
    }else{
          waitingDialog.show();
          $("#btncargarSISUB").prop("disabled", false);
          $("#divPDFActualSISUB").hide();

        var cuatrimestre=$("#selectCuatriSISUB").val();
        var anioActual = $("#selectAnioSISUB").val();

        $.ajax({            
            type: "POST",
            url: "SISUB/ajax_ConsultaCargaSISUB.php",
            data:{cuatrimestre,anioActual},
            dataType: "json",
            success:function(response){ 
                    if(response.status=='success'){  
                      if(response.datos.length==1){
                         var pdf=response.datos[0]["NombreArchivoSISUB"];
                         var p="<a onclick=generarPDFSISUB('"+pdf+"');><img src='img/pdf.png' height='54px' width='54px'/></a>";
                          $("#divPDFActualSISUB").show();
                          $("#divPDFActualSISUB").html(p);
                          $("#btncargarSISUB").prop("disabled",false);  
                          waitingDialog.hide();
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#formSISUB")[0].reset(); 
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                            $("#btncargarSISUB").prop("disabled",false); 
                            $("#divPDFActualSISUB").hide();
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

function cargarSISUB (){     

    waitingDialog.show();
    var cuatrimestre = $("#selectCuatriSISUB").val();
    var valorAct     = $("#valorActualizar").val();
    var archivoSISUB = $("#archivoSISUB").val();
    var anio = $("#selectAnioSISUB").val();

    if(cuatrimestre==="0"){
       waitingDialog.hide();
       alert("Selecciona un cuatrimestre");
       return;
    }else if(archivoSISUB==""){
       waitingDialog.hide();
       alert("Selecciona un archivo");
       return;
    }

    var formData = new FormData($("#formSISUB")[0]);
    formData.append('cuatrimestre', cuatrimestre);
    formData.append('valorAct', valorAct);
    formData.append('anio', anio);
             
    $.ajax({            
        type: "POST",
        url: "SISUB/ajax_uploadSISUB.php",
        data:formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success:function(response){ 
            var msj=response.message;
            if(response.status=='success'){   
 		       alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#formSISUB")[0].reset(); 
               $("#alertMsg").html(alertMsg1);                    
               $('#msgAlert').delay(2000).fadeOut('slow');   
               $("#selectCuatriSISUB").val(0);
               $("#valorActualizar").val();    
               waitingDialog.hide();
               $("#divPDFActualSISUB").hide();
            }else{
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#formSISUB")[0].reset(); 
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

function generarPDFSISUB(archivo){ 
     window.open("uploads/DocumentosSISUB/"+archivo+".pdf",'fullscreen=no');
     waitingDialog.hide();
}


