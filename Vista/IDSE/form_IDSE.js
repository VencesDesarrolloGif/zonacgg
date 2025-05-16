$(document).ready(function() {
   cargarRegistrosPatronalesIDSE();

 });

function cargarRegistrosPatronalesIDSE(){
    $.ajax({
            type: "POST",
            url: "ajax_consultaRegistrosPatronales.php",
            dataType: "json",
            success: function(response) {
            //console.log(response.datos);
            $("#selectRegPatIDSE").empty(); 
            $('#selectRegPatIDSE').append('<option value="0">REGISTRO PATRONAL</option>');
        if(response.status == "success"){
           for(var i = 0; i < response.datos.length; i++){
               $('#selectRegPatIDSE').append('<option value="' + (response.datos[i].idcatalogoRegistrosPatronales) + '">' + response.datos[i].idcatalogoRegistrosPatronales + '</option>');
              }
          }else{
                alert("Error Al Cargar Las Entidades");
               }
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert(jqXHR.responseText);
      }
    });
  }

$("#selectRegPatIDSE").change(function(){
    if($("#selectRegPatIDSE").val()=='0'){
       $("#selectDocIDSE").hide();
       $("#selectAnioIDSE").hide();
       $("#selectMesIDSE").hide();
       $("#divPDFActualIDSE").hide();
    }else{
          $("#selectDocIDSE").show();
          $("#selectDocIDSE").val(0);
          $("#selectAnioIDSE").hide();
          $("#selectMesIDSE").hide();
          $("#btncargarIDSE").prop("disabled", false);
          $("#divPDFActualIDSE").hide();
      }
      $("#formIDSE")[0].reset(); 
});

$("#selectDocIDSE").change(function(){
    if($("#selectDocIDSE").val()=='0'){
       $("#selectAnioIDSE").hide();
       $("#selectMesIDSE").hide();
       $("#divPDFActualIDSE").hide();
    }else{
          $("#selectAnioIDSE").show();
          $("#selectAnioIDSE").val(0);
          $("#selectMesIDSE").hide();
          $("#btncargarIDSE").prop("disabled", false);
          $("#divPDFActualIDSE").hide();
      }
      $("#formIDSE")[0].reset(); 
});


$("#selectAnioIDSE").change(function(){
  if($("#selectAnioIDSE").val()=='0'){
       $("#selectMesIDSE").hide();
       $("#selectMesIDSE").val(0);
       $("#divPDFActualIDSE").hide();
    }else{
          $("#selectMesIDSE").show();
          $("#divPDFActualIDSE").hide();
      }
      $("#formIDSE")[0].reset(); 
});

$("#selectMesIDSE").change(function(){
    if($("#selectMesIDSE").val()==0){
       $("#btncargarIDSE").prop("disabled", true);
       $("#divPDFActualIDSE").hide();
    }else{
          waitingDialog.show();
          $("#btncargarIDSE").prop("disabled", false);
          $("#divPDFActualIDSE").hide();

        var regPatIDSE=$("#selectRegPatIDSE").val();
        var mesIDSE   =$("#selectMesIDSE").val();
        var anioActual=$("#selectAnioIDSE").val();
        var tipoDoc   =$("#selectDocIDSE").val();

        $.ajax({            
            type: "POST",
            url: "IDSE/ajax_ConsultaCargaIDSE.php",
            data:{mesIDSE,anioActual,tipoDoc,regPatIDSE},
            dataType: "json",
            success:function(response){ 
                    if(response.status=='success'){  
                      if(response.datos.length==1){
                         var pdf=response.datos[0]["nombreDocumentoIDSE"];
                             var p="<a onclick=generarPDFIDSE('"+tipoDoc+"','"+regPatIDSE+"','"+mesIDSE+"','"+anioActual+"');><img src='img/pdf.png' height='54px' width='54px'/></a>";
                          $("#divPDFActualIDSE").show();
                          $("#divPDFActualIDSE").html(p);
                          $("#btncargarIDSE").prop("disabled",false);  
                          waitingDialog.hide();
                      }else{
                            var msj="Aún no se ha cargado esta información";
                            alertMsg1="<div id='msgAlert' class='alert alert-warning'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                            $("#formIDSE")[0].reset(); 
                            $("#alertMsg").html(alertMsg1);                    
                            $('#msgAlert').delay(2000).fadeOut('slow');
                            $("#btncargarIDSE").prop("disabled",false); 
                            $("#divPDFActualIDSE").hide();
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

function cargarIDSE (){     

    waitingDialog.show();
    var regPatIDSE=$("#selectRegPatIDSE").val();
    var mesIDSE = $("#selectMesIDSE").val();
    var archivoIDSE = $("#archivoIDSE").val();
    var anioActual=$("#selectAnioIDSE").val();
    var tipoDoc   =$("#selectDocIDSE").val();

    if(anioActual=='0'){
       waitingDialog.hide();
       alert("Selecciona el ejercicio");
       return;
    }else if(mesIDSE==="0"){
       waitingDialog.hide();
       alert("Selecciona un mes");
       return;
    }else if(archivoIDSE==""){
       waitingDialog.hide();
       alert("Selecciona un archivo");
       return;
    }else if(tipoDoc=='0'){
       waitingDialog.hide();
       alert("Selecciona el tipo de documento");
       return;
    }
    var formData = new FormData($("#formIDSE")[0]);
    formData.append('regPatIDSE', regPatIDSE);
    formData.append('anioActual', anioActual);
    formData.append('mesIDSE', mesIDSE);
    formData.append('tipoDoc', tipoDoc);
         
    $.ajax({            
        type: "POST",
        url: "IDSE/ajax_uploadIDSE.php",
        data:formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success:function(response){ 
            var msj=response.mensaje;
            if(response.status=='success'){   
 		       alertMsg1="<div id='msgAlert' class='alert alert-success'><strong>Archivo subido correctamente </strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
               $("#formIDSE")[0].reset(); 
               $("#alertMsg").html(alertMsg1);                    
               $('#msgAlert').delay(2000).fadeOut('slow');   
               $("#selectMesIDSE").val(0);
               waitingDialog.hide();selectDocIDSE
               $("#divPDFActualIDSE").hide();
               $("#selectRegPatIDSE").show();
               $("#selectRegPatIDSE").val('0');
               $("#selectAnioIDSE").hide();
               $("#selectAnioIDSE").val('0');
               $("#selectMesIDSE").hide();
               $("#selectMesIDSE").val('0');
               $("#selectDocIDSE").val('0');
               $("#selectDocIDSE").hide();
               $("#divPDFActualIDSE").hide();
               $("#divPDFActualIDSE").val('');

            }else{
                  alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>"+msj+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#formIDSE")[0].reset(); 
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

function generarPDFIDSE(tipoDoc,regPatIDSE,mesIDSE,anioActual){ 
                          

    if (tipoDoc=='1'){
         var archivo = "IDSE_EMA_"+regPatIDSE+"_"+mesIDSE+anioActual;
         window.open("uploads/DocumentosIDSEEMA/"+archivo+".pdf",'fullscreen=no');
    }
    if (tipoDoc=='2'){
         var archivo = "IDSE_EBA_"+regPatIDSE+"_"+mesIDSE+anioActual;
         window.open("uploads/DocumentosIDSEEBA/"+archivo+".pdf",'fullscreen=no');
    }
    waitingDialog.hide();
}