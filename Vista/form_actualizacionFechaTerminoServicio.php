
    <style>
        .editableFechaBajaPS span{display:block;}
        .editableFechaBajaPS span:hover {background:url(img/edit.png) 90% 50% no-repeat;cursor:pointer}
        td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
        a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
        .guardarFechaBajaPS{background:url(img/save.png) 0 0 no-repeat}
        .cancelarFechaBajaPS{background:url(img/cancel.png) 0 0 no-repeat}
    
        .mensajeFechaBajaPS{display:block;text-align:center;margin:0 0 20px 0}
        .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
        .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
    </style>
    <div >
        <h2>ACTUALIZACIÓN DE FECHA DE TERMINO DE PUNTO DE SERVICIO</h2>
        <div class="mensajeFechaBajaPS"></div>
        <table class="editinplace table table-hover" id="editinplaceFechaBajasPS" name="editinplaceFechaBajasPS">
            <tr>
                <th>Id. Punto</th>
                <th>Centro de Costo</th>
                <th>Punto Servicio</th>
                <th>Entidad</th>
                <th>Direccion</th>
                <th>Fecha Inicio</th>
                <th>Fecha Termino</th>
                
        </table>
    </div>

<script type="text/javascript">
var rolUsuario="<?php echo $usuario['rol']; ?>";
$(inicioActualizacionFTPS());  

function inicioActualizacionFTPS(){

    if(rolUsuario=="Ventas" ){

       tableFechaBajasPS();
        var td,campo,valor,id;
        $(document).on("click","td.editableFechaBajaPS span",function(e){

            campo=$(this).closest("td").data("campo");
            td=$(this).closest("td");
            valor=$(this).text();
            id=$(this).closest("tr").find(".id").text();
            idPuntoServicio=$(this).closest("tr").find(".id").text();

            e.preventDefault();
            $("td:not(.id)").removeClass("editableFechaBajaPS");
           
            td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardarFechaBajaPS' href='#'>Guardar</a><a class='enlace cancelarFechaBajaPS' href='#'>Cancelar</a>");
       });// mecanismo para cancelar edicion del campo 

        $(document).on("click",".cancelarFechaBajaPS",function(e){
            e.preventDefault();
            td.html("<span>"+valor+"</span>");
            $("td:not(.id)").addClass("editableFechaBajaPS");
        });// fin  mecanismo para cancelar edicion del campo 

        //mecanismo para editar datos ps
        $(document).on("click",".guardarFechaBajaPS",function(e){
            $(".mensajeFechaBajaPS").html("<img src='img/loading.gif'>");
            e.preventDefault();
            nuevovalor=$(this).closest("td").find("input").val();
            fechaVencida=$(this).closest("td").attr("fechaVencida");
            idPuntoServicio=$(this).closest("td").attr("idPuntoServicio");

            if(nuevovalor.trim()!=""){
                $.ajax({
                    type: "POST",
                    url: "ajax_actualizaDatoPuntoServicioByCampo.php",
                    data: { campo: campo, valor: nuevovalor, "idPuntoServicio":idPuntoServicio, fechaVencida:fechaVencida}, 
                    dataType: "json",
                    success: function(response) {
                        var mensaje=response.message;

                if (response.status == "success"){
                    $(".mensajeFechaBajaPS").html("<p class='ok'>"+mensaje+"</p>")
                    td.html("<span>"+nuevovalor+"</span>");
                    $("td:not(.id)").addClass("editableFechaBajaPS");
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                    $(".mensajeFechaBajaPS").html("<p class='ok'>"+mensaje+"</p>")
                    $("#editinplace").find("tr:gt(0)").remove();
                    tableFechaBajasPS();
                } else if(response.status=="error"){
                    $(".mensajeFechaBajaPS").html(mensaje);
                    //td.html("<span>"+nuevovalor+"</span>");
                    $("td:not(.id)").addClass("editableFechaBajaPS");
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                    $(".mensajeFechaBajaPS").html("<p class='ko'>"+mensaje+"</p>")
                }
            },
            error: function (response){
                console.log (response);
            }
        });
    }else $(".mensajeFechaBajaPS").html("<p class='ko'>Debes ingresar un valor</p>");
    });//fin mecanismo para editar datos ps
    } // fin condicion para verificar usuario ps
}

function tableFechaBajasPS(){
        $("#editinplaceFechaBajasPS").find("tr:gt(0)").remove();

        $.ajax({
            
            type: "POST",
            url: "ajax_getPuntosByFechaVencimiento.php",
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                 
                    var puntosEncontrados = response.listaPuntos;
                                     
                    for ( var i = 0; i < puntosEncontrados.length; i++ ){
                      var idPuntoServicio = puntosEncontrados[i].idPuntoServicio;
                      var puntoServicio = puntosEncontrados[i].puntoServicio;
                      var nombreEntidadFederativa = puntosEncontrados[i].nombreEntidadFederativa;
                      var direccionPuntoServicio = puntosEncontrados[i].direccionPuntoServicio;
                      var fechaInicioServicio = puntosEncontrados[i].fechaInicioServicio;
                      var fechaTerminoServicio = puntosEncontrados[i].fechaTerminoServicio;
                      var numeroCentroCosto = puntosEncontrados[i].numeroCentroCosto;
                      
                                            
                    $('#editinplaceFechaBajasPS').append(
                    "<tr><td class='id'>"+idPuntoServicio+"</td><td class='id'>"+numeroCentroCosto+"</td><td>"+puntoServicio+"</td><td>"+nombreEntidadFederativa+"</td><td>"+direccionPuntoServicio+
                    "</td><td>"+fechaInicioServicio+"</td><td class='editableFechaBajaPS' data-campo='fechaTerminoServicio' fechaVencida='"+fechaTerminoServicio+"' idPuntoServicio='"+idPuntoServicio+"'><span>"+fechaTerminoServicio+
                    "</span></td></tr>");
                    }                    
                    //$('#editinplace').html(listaPersonalActivoTable); 
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                {
                    //window.location = "login.php";
                }
            },
            error: function (response)
            {
                console.log (response);

            }
        });

    }


    






</script>

