$("#selectAnioICSOE").change(function(){
  if($("#selectAnioICSOE").val()=='0'){
       $("#selectCuatriICSOE").hide();
       $("#divPDFActualICSOE").hide();
    }else{
          $("#selectCuatriICSOE").show();
          $("#btncargarICSOE").prop("disabled", false);
          $("#divPDFActualICSOE").hide();
      }
      $("#formICSOE")[0].reset(); 
});

$("#selectCuatriICSOE").change(function(){
    if($("#selectCuatriICSOE").val()==0){
       $("#btncargarICSOE").prop("disabled", true);
       $("#divPDFActualICSOE").hide();
    }else{
          waitingDialog.show();
          $("#btncargarICSOE").prop("disabled", false);
          $("#divPDFActualICSOE").hide();

          var cuatrimestre= $("#selectCuatriICSOE").val();
          var anioActual = $("#selectAnioICSOE").val();

          $.ajax({            
              type: "POST",
              url: "ICSOE/ajax_ConsultaCargaICSOE.php",
              data:{cuatrimestre,anioActual},
              dataType: "json",
              success:function(response){ 
                       if(response.status=='success'){  
                        if(response.datos.length==1){
                           var pdf=response.datos[0]["NombreArchivoICSOE"];
                           var p="<a onclick=generarPDFICSOE('"+pdf+"');><img disabled src='img/pdf.png' height='54px' width='54px'/></a>";
                            $("#divPDFActualICSOE").show();
                            $("#divPDFActualICSOE").html(p);
                            $("#btncargarICSOE").prop("disabled",false);  
                            waitingDialog.hide();
                        }else{
                              var msj="Aún no se ha cargado esta información";
                              alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                              $("#formICSOE")[0].reset(); 
                              $("#alertMsg").html(alertMsg1);                    
                              $('#msgAlert').delay(2000).fadeOut('slow');
                              $("#btncargarICSOE").prop("disabled",false); 
                              $("#divPDFActualICSOE").hide();
                              waitingDialog.hide();
                        }
                      }
              },
              error: function(jqXHR, textStatus, errorThrown){
                    alert(jqXHR.responseText); 
              }
          });
    }
    $("#formICSOE")[0].reset(); 
});

function cargarICSOE (){     

    waitingDialog.show();
    var anioICSOE = $("#selectAnioICSOE").val();
    var cuatrimestre = $("#selectCuatriICSOE").val();
    var valorAct     = $("#valorActualizar").val();
    var archivoICSOE = $("#archivoICSOE").val();

    if(cuatrimestre==="0"){
       waitingDialog.hide();
       alert("Selecciona un cuatrimestre");
       return;
    }else if(archivoICSOE==""){
       waitingDialog.hide();
       alert("Selecciona un archivo");
       return;
    }

    var formData = new FormData($("#formICSOE")[0]);
    formData.append('anioICSOE', anioICSOE);
    formData.append('cuatrimestre', cuatrimestre);
    formData.append('valorAct', valorAct);
         
    $.ajax({            
        type: "POST",
        url: "ICSOE/ajax_uploadICSOE.php",
        data:formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success:function(response){ 
            var msj=response.message;
            if(response.status=='success'){   
 		       alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#formICSOE")[0].reset(); 
               $("#alertMsg").html(alertMsg1);                    
               $('#msgAlert').delay(2000).fadeOut('slow');   
               $("#selectCuatriICSOE").val(0);
               $("#valorActualizar").val();    
               waitingDialog.hide();
               $("#divPDFActualICSOE").hide();
            }else{
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#formICSOE")[0].reset(); 
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

function generarPDFICSOE(archivo){ 
     window.open("uploads/DocumentosICSOE/"+archivo+".pdf",'fullscreen=no');
     waitingDialog.hide();
}


