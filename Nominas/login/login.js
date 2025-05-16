$(document).ready(function() {
$("#form_login").submit(function(e){
    e.preventDefault(); 
    var datastring = $("#form_login").serialize();

    $.ajax({
            type: "POST",
            url: "ajax_login.php",
            data : datastring,
            dataType: "json",
            success: function(response) {
                if (response.status == "success")
                {
                                        
                    var mensaje = response.message;  
                    var usuario=response.usuario;                  
                   // alert("hola: "+usuario);
                    window.location.href='../menu/menu.php';
                    
                      $(document).scrollTop(0);//te lleva hasta arriba del documento
                    //var msg="<div id='msgAlert' class='alert alert-success'><strong>"+mensaje+"</strong><a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                    //$("#divMsgCorreoRestauracion").html(msg);
                    //$('#msgAlert').delay(3000).fadeOut('slow');                                       
                }else{
                  //waitingDialog.hide();                    
                  var mensaje=response.message;

                  $(document).scrollTop(0);
                  var Msgerror = "<div id='errorMsg' class='alert alert-error'><strong>" + mensaje + "</strong>" + " <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                  $("#errorMsg").html(Msgerror);
                  
                  
                }
            },
           error: function(jqXHR, textStatus, errorThrown){
                 alert(jqXHR.responseText); 
            }
        });
      // Fin Funcion
  }); 
});


