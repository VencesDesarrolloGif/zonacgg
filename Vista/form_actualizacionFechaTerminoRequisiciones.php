
    <style>
        .editableFechaBajaRequisicion span{display:block;}
        .editableFechaBajaRequisicion span:hover {background:url(img/edit.png) 90% 50% no-repeat;cursor:pointer}
        td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
        a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
        .guardarFechaBajaRequisicion{background:url(img/save.png) 0 0 no-repeat}
        .cancelarFechaBajaRequisicion{background:url(img/cancel.png) 0 0 no-repeat}
    
        .mensajeFechaBajaRequisicion{display:block;text-align:center;margin:0 0 20px 0}
        .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
        .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
    </style>
    <div >
        <h2>ACTUALIZACIÓN DE FECHA DE TERMINO DE REQUISICIÓN</h2>
        <div class="mensajeFechaBajaRequisicion"></div>
        <table class="editinplace table table-hover" id="editinplaceFechaBajaRequisiciones" name="editinplaceFechaBajaRequisiciones">
            <tr>
                <th>No. Requisicion</th>
                <th>Id Punto</th>
                <th>Punto Servicio</th>
                <th>Fecha Inicio servicio</th>
                <th>Fecha Termino servicio</th>
                <th># Elementos</th>
                <th>Puesto</th>
                <th>Fecha Inicio Plantilla</th>
                <th>Fecha Termino Plantilla</th>
                <th>Cancelar</th>
                
        </table>
    </div>

<script type="text/javascript">
var rolUsuario="<?php echo $usuario['rol']; ?>";
$(InicioActFechaTerReq());  

function InicioActFechaTerReq(){

    if (rolUsuario=="Ventas" ){
    
        tableFechaBajasRequisicion();

        var td,campo,valor,id;
        $(document).on("click","td.editableFechaBajaRequisicion span",function(e){

            campo=$(this).closest("td").data("campo");
            td=$(this).closest("td");
            valor=$(this).text();
            id=$(this).closest("tr").find(".id").text();
            servicioPlantillaId=$(this).closest("tr").find(".id").text();

            e.preventDefault();
            $("td:not(.id)").removeClass("editableFechaBajaRequisicion");
           
            td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><a class='enlace guardarFechaBajaRequisicion' href='#'>Guardar</a><a class='enlace cancelarFechaBajaRequisicion' href='#'>Cancelar</a>");          
       });
        // mecanismo para cancelar edicion del campo 

        $(document).on("click",".cancelarFechaBajaRequisicion",function(e){
            e.preventDefault();
            td.html("<span>"+valor+"</span>");
            $("td:not(.id)").addClass("editableFechaBajaRequisicion");
        });
        // fin  mecanismo para cancelar edicion del campo 
        //mecanismo para editar datos ps

        $(document).on("click",".guardarFechaBajaRequisicion",function(e){
            $(".mensajeFechaBajaRequisicion").html("<img src='img/loading.gif'>");
            e.preventDefault();
            nuevovalor=$(this).closest("td").find("input").val();
            fechaVencida=$(this).closest("td").attr("fechaVencida");
            servicioPlantillaId=$(this).closest("td").attr("servicioPlantillaId");
            fechaTerminoServicio=$(this).closest("td").attr("fechaTerminoServicio");
            if(nuevovalor.trim()!=""){
                if(nuevovalor<fechaVencida){
                    $(".mensajeFechaBajaRequisicion").html("<p class='ko'>El valor de la fecha ingresada no puede ser menor a la fecha que tenia la plantilla</p>");
                }else{
                    $.ajax({
                    type: "POST",
                    url: "ajax_actualizaDatoRequisicionByCampo.php",
                    data: { campo: campo, valor: nuevovalor, "servicioPlantillaId":servicioPlantillaId,fechaTerminoServicio:fechaTerminoServicio}, 
                    dataType: "json",
                    success: function(response) {
                        var mensaje=response.message;

                if (response.status == "success"){
                    $(".mensajeFechaBajaRequisicion").html("<p class='ok'>"+mensaje+"</p>")

                    td.html("<span>"+nuevovalor+"</span>");
                    $("td:not(.id)").addClass("editableFechaBajaRequisicion");
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                    $(".mensajeFechaBajaRequisicion").html("<p class='ok'>"+mensaje+"</p>")
                    $("#editinplace").find("tr:gt(0)").remove();
                    tableFechaBajasRequisicion();
                } else if(response.status=="error"){
                    $(".mensajeFechaBajaRequisicion").html(mensaje);
                    $(document).scrollTop(0);
                    $("td:not(.id)").addClass("editableFechaBajaRequisicion");
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                    $(".mensajeFechaBajaRequisicion").html("<p class='ko'>"+mensaje+"</p>")
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }                
            });
                }
            }
            else $(".mensajeFechaBajaRequisicion").html("<p class='ko'>Debes ingresar un valor</p>");
        });//fin mecanismo para editar datos ps
    } // fin condicion para verificar usuario ps
}



function tableFechaBajasRequisicion(){
        $("#editinplaceFechaBajaRequisiciones").find("tr:gt(0)").remove(); 

        $.ajax({
            
            type: "POST",
            url: "ajax_getRequisicionesByFechaVencimiento.php",
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {
                 
                  var requisicionesEncontrados = response.listaRequisiciones;
                                     
                  for ( var i = 0; i < requisicionesEncontrados.length; i++ ){
                      var servicioPlantillaId = requisicionesEncontrados[i].servicioPlantillaId;
                      var puntoServicioPlantillaId = requisicionesEncontrados[i].puntoServicioPlantillaId;
                      var puntoservicio = requisicionesEncontrados[i].puntoservicio;
                      var fechaInicioServicio = requisicionesEncontrados[i].fechaInicioServicio;
                      var fechaTerminoServicio = requisicionesEncontrados[i].fechaTerminoServicio;

                      var numeroElementos = requisicionesEncontrados[i].numeroElementos;
                      var descripcionPuesto = requisicionesEncontrados[i].descripcionPuesto;
                      var fechaInicio = requisicionesEncontrados[i].fechaInicio;
                      var fechaTerminoPlantilla = requisicionesEncontrados[i].fechaTerminoPlantilla;
                      var campo="estatusPlantilla";
                      const f = new Date();
                      var fecha1 = (f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate());
                      if(fechaTerminoPlantilla > fecha1){
                        $('#editinplaceFechaBajaRequisiciones').append(
                        "<tr><td class='id'>"+servicioPlantillaId+"</td><td>"+puntoServicioPlantillaId+"</td><td>"+puntoservicio+"</td><td>"+fechaInicioServicio+
                        "</td><td>"+fechaTerminoServicio+"</td><td>"+numeroElementos+"</td><td>"+descripcionPuesto+
                        "</td><td>"+fechaInicio+"</td><td class='editableFechaBajaRequisicion' data-campo='fechaTerminoPlantilla' fechaVencida='"+fechaTerminoPlantilla+
                        "' servicioPlantillaId='"+servicioPlantillaId+"' fechaTerminoServicio='"+fechaTerminoServicio+"'><span>"+fechaTerminoPlantilla+
                        "</span></td><td></td></tr>");
                      }else{          
                        $('#editinplaceFechaBajaRequisiciones').append(
                        "<tr><td class='id'>"+servicioPlantillaId+"</td><td>"+puntoServicioPlantillaId+"</td><td>"+puntoservicio+"</td><td>"+fechaInicioServicio+
                        "</td><td>"+fechaTerminoServicio+"</td><td>"+numeroElementos+"</td><td>"+descripcionPuesto+
                        "</td><td>"+fechaInicio+"</td><td class='editableFechaBajaRequisicion' data-campo='fechaTerminoPlantilla' fechaVencida='"+fechaTerminoPlantilla+
                        "' servicioPlantillaId='"+servicioPlantillaId+"' fechaTerminoServicio='"+fechaTerminoServicio+"'><span>"+fechaTerminoPlantilla+
                        "</span></td><td><img src='img/cancel.png' class='cursorImg' onclick='cancelarRequisicion("+servicioPlantillaId+",\"" + campo + "\",\"" + fechaTerminoServicio + "\");'></td></tr>");
                    }
                  }                    
                    //$('#editinplace').html(listaPersonalActivoTable); 
                                  }
                else if (response.status == "error" && response.message == "No autorizado")
                { 
                    //window.location = "login.php";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }
        });

    }

    function cancelarRequisicion(servicioPlantillaId,campo, fechaTerminoServicio ){

       
        var campo = campo;
        var nuevovalor =0;
        var servicioPlantillaId=servicioPlantillaId;

                $.ajax({
                    type: "POST",
                    url: "ajax_actualizaDatoRequisicionByCampo.php",
                    data: { campo: campo, valor: nuevovalor, "servicioPlantillaId":servicioPlantillaId, fechaTerminoServicio:fechaTerminoServicio}, 
                    dataType: "json",
                    success: function(response) {
                        var mensaje=response.message;

                if (response.status == "success")
                {
                    $(".mensajeFechaBajaRequisicion").html("<p class='ok'>"+mensaje+"</p>");
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                    $(".mensajeFechaBajaRequisicion").html("<p class='ok'>"+mensaje+"</p>");
                      

                    $("#editinplace").find("tr:gt(0)").remove();

                    tableFechaBajasRequisicion();
                    

                } else if(response.status=="error"){
                    $(".mensajeFechaBajaRequisicion").html(mensaje);
                    $(document).scrollTop(0);
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                    $(".mensajeFechaBajaRequisicion").html("<p class='ko'>"+mensaje+"</p>")

                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
            }               
        });
    }


</script>

