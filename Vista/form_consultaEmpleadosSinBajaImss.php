
    <style>
        .editableBaja span{display:block;}
        .editableBaja span:hover {background:url(img/edit.png) 90% 50% no-repeat;cursor:pointer}
        td input{height:24px;width:200px;border:1px solid #ddd;padding:0 5px;margin:0;border-radius:6px;vertical-align:middle}
        a.enlace{display:inline-block;width:24px;height:24px;margin:0 0 0 5px;overflow:hidden;text-indent:-999em;vertical-align:middle}
        .guardarBaja{background:url(img/save.png) 0 0 no-repeat}
        .cancelarBaja{background:url(img/cancel.png) 0 0 no-repeat}

        .mensajeBaja{display:block;text-align:center;margin:0 0 20px 0}
        .ok{display:block;padding:10px;text-align:center;background:green;color:#fff}
        .ko{display:block;padding:10px;text-align:center;background:red;color:#fff}
    </style>
    <div >
        <h2>Generar Baja Imss</h2><br>
        <img title='Consulta/Cargar/Actualizar Pagina' src='img/ActualizarEjecutar.jpg' class='cursorImg' onclick="inicioConsultaEmpleadosSinBajaImss();" width="50px"><br>
        <select id="selectRegistroPatronalBaja" name="selectRegistroPatronalBaja" onchange="tablaEmpleadosSInBajaPorRegistro();" >
            <option value='0'>REGISTRO PATRONAL</option>
                <?php
for ($i = 0; $i < count($catalogoRegistrosPatronales); $i++) {
    echo "<option value='" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . "'>" . $catalogoRegistrosPatronales[$i]["idcatalogoRegistrosPatronales"] . " (" . $catalogoRegistrosPatronales[$i]["nombreEntidadFederativa"] . ") </option>";
}
?>
        </select> <button class="btn btn-primary" type="button" onclick="generartxtBajaPorRegistroPatronal();"> Generar txt</button>
        <div class="mensajeBaja"></div>
        <table class="editinplace table table-hover" id="editinplaceBajas" name="editinplaceBajas">
            <tr>
                <th>#Empleado</th>
                <th>Ap. Paterno</th>
                <th>Ap. Materno</th>
                <th>Nombre(s)</th>
                <th>Registro Patronal</th>
                <th>Fecha Alta</th>
                <th>Fecha Baja</th>
                <th>Motivo Baja</th>
                <th>Lote Imss</th>
                <th>Generación txt</th>
        </table>
    </div>

<script type="text/javascript">

var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioConsultaEmpleadosSinBajaImss());  

function inicioConsultaEmpleadosSinBajaImss(){ 
    tableBajasImss();
    var td,campo,valor,id;
    $("#selectRegistroPatronalBaja").val(0);

}

$(document).on("click",".guardarBaja",function(e)
{
    $(".mensajeBaja").html("<img src='img/loading.gif'>");
    e.preventDefault();
    if (campo=="fechaBajaImss"){
        nuevovalor=$(this).closest("td").find("input").val();
    }else {
        nuevovalor=$(this).closest("td").find("select").val();
    }
    if(nuevovalor.trim()!="")
    {
        $.ajax({
            type: "POST",
            url: "ajax_actualizaDatosImssTable.php",
            data: { campo: campo, valor: nuevovalor, "numeroEmpleado":numeroEmpleado},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status == "success")
                {
                    $(".mensajeBaja").html("<p class='ok'>"+mensaje+"</p>")
                    td.html("<span>"+nuevovalor+"</span>");
                    $("td:not(.id)").addClass("editableBaja");
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                    $(".mensajeBaja").html("<p class='ok'>"+mensaje+"</p>")
                    $("#editinplace").find("tr:gt(0)").remove();
                    opcionTablaBaja();
                } else if(response.status=="error"){
                    $(".mensajeBaja").html("<p class='ko'>"+mensaje+"</p>");
                    $("td:not(.id)").addClass("editableBaja");
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                }
            },
            error: function (response)
            {
                console.log (response);
            }
        });
    }else $(".mensajeBaja").html("<p class='ko'>Debes ingresar un valor</p>");
});

$(document).on("click",".cancelarBaja",function(e)
{
    e.preventDefault();
    td.html("<span>"+valor+"</span>");
    $("td:not(.id)").addClass("editableBaja");
});

$(document).on("click","td.editableBaja span",function(e){
    campo=$(this).closest("td").data("campo");
    td=$(this).closest("td");
    valor=$(this).text();
    id=$(this).closest("tr").find(".id").text();
    numeroEmpleado=$(this).closest("tr").find(".id").text();
    e.preventDefault();
    $("td:not(.id)").removeClass("editableBaja");
    if(campo=="idMotivoBajaImss"){
        select="<select id='"+campo+"' name='"+campo+"'>";
        optionSelect="";
        <?php
        if (isset($catalogoMotivoBajaImss)) {
            for ($i = 0; $i < count($catalogoMotivoBajaImss); $i++) {
                $value   = $catalogoMotivoBajaImss[$i]["motivoBajaImssId"];
                $mostrar = $catalogoMotivoBajaImss[$i]["descripcionMotivoBajaImss"];
        ?>
                var valort="<?php echo $value; ?>";
                var mostrart="<?php echo $mostrar; ?>";
                optionSelect +="<option value='"+valort+"'>"+mostrart+"</option>";
        <?php
            } // for
        } // if
        ?>
        select +=""+optionSelect+"</select><a class='enlace guardarBaja' href='#'>Guardar</a><a class='enlace cancelarBaja' href='#'>Cancelar</a>";
        td.text("").html(select);
    }else{
        td.text("").html("<input type='date' name='"+campo+"' value='"+valor+"' class='input-medium'><a class='enlace guardarBaja' href='#'>Guardar</a><a class='enlace cancelarBaja' href='#'>Cancelar</a>");
    }
});


function tableBajasImss(){
        $("#editinplaceBajas").find("tr:gt(0)").remove();

        $.ajax({

            type: "POST",
            url: "ajax_obtenerEmpleadosSinBajaImss.php",
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {

                    var empleadoEncontrado = response.listaEmpleados;

                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                      var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                      var apellidoPaterno = empleadoEncontrado[i].apellidoPaterno;
                      var apellidoMaterno = empleadoEncontrado[i].apellidoMaterno;
                      var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                      var registroPatronal = empleadoEncontrado[i].registroPatronal;
                      var fechaBajaEmpleado = empleadoEncontrado[i].fechaBajaImss;
                      var descripcionMotivoBajaImss = empleadoEncontrado[i].descripcionMotivoBajaImss;
                      var fechaAlta = empleadoEncontrado[i].fechaImss;
                      var numerolote= empleadoEncontrado[i].numeroLote;
                        if(descripcionMotivoBajaImss!='CAMBIO REGISTRO PATRONAL'){
                            $('#editinplaceBajas').append(
                            "<tr><td class='id'>"+numeroEmpleado+"</td><td>"+apellidoPaterno+"</td><td>"+apellidoMaterno+"</td><td>"+nombreEmpleado+
                            "</td><td>"+registroPatronal+"</td><td>"+fechaAlta+"</td><td class='editableBaja' data-campo='fechaBajaImss'><span>"+fechaBajaEmpleado+
                            "</span></td><td class='editableBaja' data-campo='idMotivoBajaImss'><span>"+descripcionMotivoBajaImss+"</span></td><td>"+numerolote+"</td></tr>");
                        }else{
                            $('#editinplaceBajas').append(
                            "<tr><td class='id'>"+numeroEmpleado+"</td><td>"+apellidoPaterno+"</td><td>"+apellidoMaterno+"</td><td>"+nombreEmpleado+
                            "</td><td>"+registroPatronal+"</td><td>"+fechaAlta+"</td><td class='editableBaja' data-campo='fechaBajaImss'><span>"+fechaBajaEmpleado+
                            "</span></td><td>"+descripcionMotivoBajaImss+"</td><td>"+numerolote+"</td></tr>");
                        }
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


    function tablaEmpleadosSInBajaPorRegistro(){

        var registroPatronal=$("#selectRegistroPatronalBaja").val();
        $("#editinplaceBajas").find("tr:gt(0)").remove();

        $.ajax({

            type: "POST",
            url: "ajax_obtenerEmpleadosSinBajaPorRegistroPatronal.php",
            data: {"registroPatronal": registroPatronal},
            dataType: "json",
             success: function(response) {
                if (response.status == "success")
                {

                    var empleadoEncontrado = response.listaEmpleados;

                    for ( var i = 0; i < empleadoEncontrado.length; i++ ){
                        var numeroEmpleado = empleadoEncontrado[i].numeroEmpleado;
                        var apellidoPaterno = empleadoEncontrado[i].apellidoPaterno;
                        var apellidoMaterno = empleadoEncontrado[i].apellidoMaterno;
                        var nombreEmpleado = empleadoEncontrado[i].nombreEmpleado;
                        var registroPatronal = empleadoEncontrado[i].registroPatronal;
                        var fechaBajaEmpleado = empleadoEncontrado[i].fechaBajaImss;
                        var descripcionMotivoBajaImss = empleadoEncontrado[i].descripcionMotivoBajaImss;
                        var fechaAlta= empleadoEncontrado[i].fechaImss;
                        var emisionAltaImssConfirmada=empleadoEncontrado[i].emisionBajaConfirmada;//estatus que se va agregar a la tabla y que se trae de la misma en la consulta
                        var numerolote= empleadoEncontrado[i].numeroLote;
                            if(emisionAltaImssConfirmada==1){
                                var iconImss="img/Ok-icon1.png";
                            }else{
                                var iconImss="img/cancel.png";
                            }
                        if(descripcionMotivoBajaImss!='CAMBIO REGISTRO PATRONAL'){
                            $('#editinplaceBajas').append(
                            "<tr><td class='id'>"+numeroEmpleado+"</td><td>"+apellidoPaterno+"</td><td>"+apellidoMaterno+"</td><td>"+nombreEmpleado+
                            "</td><td>"+registroPatronal+"</td><td>"+fechaAlta+"</td><td class='editableBaja' data-campo='fechaBajaImss'><span>"+fechaBajaEmpleado+
                            "</span></td><td class='editableBaja' data-campo='idMotivoBajaImss'><span>"+descripcionMotivoBajaImss+"</span></td><td>"+numerolote+"</td><td><img src='"+iconImss+"' class='cursorImg'  onclick='cambiarEstatusParaGenerarTxtBajaimss(\"" + numeroEmpleado + "\","+emisionAltaImssConfirmada+");'></td></tr>");
                        }else{
                            $('#editinplaceBajas').append(
                            "<tr><td class='id'>"+numeroEmpleado+"</td><td>"+apellidoPaterno+"</td><td>"+apellidoMaterno+"</td><td>"+nombreEmpleado+
                            "</td><td>"+registroPatronal+"</td><td>"+fechaAlta+"</td><td class='editableBaja' data-campo='fechaBajaImss'><span>"+fechaBajaEmpleado+
                            "</span></td><td>"+descripcionMotivoBajaImss+"</td><td>"+numerolote+"</td><td><img src='"+iconImss+"' class='cursorImg'  onclick='cambiarEstatusParaGenerarTxtBajaimss(\"" + numeroEmpleado + "\","+emisionAltaImssConfirmada+");'></td></tr>");
                        }
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

    function opcionTablaBaja(){

        var registroPatronal=$("#selectRegistroPatronalBaja").val();
        if(registroPatronal=="REGISTRO PATRONAL" || registroPatronal=="0"){
            tableBajasImss();
        } else{
            tablaEmpleadosSInBajaPorRegistro();
        }

    }



    function generartxtBajaPorRegistroPatronal(){
    var registroPatronal=$("#selectRegistroPatronalBaja").val();
        if (registroPatronal=="REGISTRO PATRONAL" || registroPatronal=="0"){
            alertMsg1="<div id='msgAlert' class='alert alert-error'><strong>Generacion de archivo</strong>Seleccione un registro patronal <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
            $("#alertMsg").html(alertMsg1);
            $('#msgAlert').delay(3000).fadeOut('slow');
        }else{
            var win = window.open("generadorTxtBajaImss.php?registroPatronal="+registroPatronal+"", 'Archivo Imss',"width=600,height=600,scrollbars=no");
            var timer = setInterval(function() {
                if(win.closed) {
                    clearInterval(timer);
                            opcionTablaBaja();
                            styleTableImssBajas();
                            //styleTableImssBajas
                            }
            }, 1000);

        }
    }

function cambiarEstatusParaGenerarTxtBajaimss(numeroEmpleado,emisionAltaImssConfirmada){
        var newEstatusEmisionAlta="";
        if (emisionAltaImssConfirmada==1){
            newEstatusEmisionAlta=0;
        }else{
            newEstatusEmisionAlta=1;
        }
        $.ajax({
            type: "POST",
            url: "ajax_actualizaEstatusEmisionBajaImss.php",
            data: {"numeroEmpleado":numeroEmpleado,"newEstatusEmisionAlta":newEstatusEmisionAlta},
            dataType: "json",
            success: function(response) {
                var mensaje=response.message;
                if (response.status=="success") {
                    opcionTablaBaja();
                } else if (response.status=="error")
                {
                    alert(mensaje);
                }
              },
            error: function(){
                  alert('error handing here');
            }
        });
    }

</script>

