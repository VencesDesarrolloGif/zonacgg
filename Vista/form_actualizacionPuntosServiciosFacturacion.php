<div class="container" align="center">
  <form class="form-horizontal"  method="post" id="form_catalogoPuntosServiciosFacturacion" name="form_catalogoPuntosServiciosFacturacion" action="" target="_blank">
    <fieldset>        
      <legend>Catalogo puntos servicios</legend>
    </fieldset>
  
    <section>
      <table id="tablePuntosServiciosFacturacion" class="display" cellspacing="0" width="80%">
        <thead>
          <tr>
            <th>ID PUNTO</th>
            <th>#CENTRO COSTO</th>
            <th>PUNTO SERVICIO</th>
            <th>CLIENTE</th>
            <th>ENTIDAD</th>
            <th>FECHA INICIO</th>
            <th>FECHA TERMINO</th>
            <th>TÉRMINOS DE FACTURACIÓN</th>
            <th>CENTRO COSTO FACTURACIÓN</th>
            <th>PUNTO SERVICIO FACTURACIÓN</th>
            <th>EDITAR</th>
            
          </tr>
        </thead>

        <tbody></tbody>
      </table>
    </section>
  </form>

  <div class="modal fade" tabindex="-1" role="dialog" name="modalEdicionPuntoFacturacion" id="modalEdicionPuntoFacturacion" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <div id="divMsgFacturacion" name="divMsgFacturacion"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edición de punto de servicio</h4>
                  </div>
                  <div class="modal-body">
                    <div class="input-prepend">
                      <span class="add-on">Cliente:</span>
                      <input class="input-xlarge" id="txtRazonSocial" name="txtRazonSocial" type="text" readonly >
                    </div><br>
                    <div class="input-prepend">
                      <span class="add-on">Centro de Costo:</span>
                      <input class="input-mini" id="txtIdPunto" name="txtIdPunto" type="hidden">
                      <input class="input-mini" id="txtCentroCosto" name="txtCentroCosto" type="text" readonly >
                    </div>
                    <div class="input-prepend">
                      <span class="add-on">Punto servicio:</span>
                      <input class="input-xlarge" id="txtNamePunto" name="txtNamePunto" type="text" readonly >
                    </div>
                    <div class="input-prepend">
                      <span class="add-on">Nuevo número de centro de costo:</span>
                      <input class="input-medium" id="txtCentroCostoEdited" name="txtCentroCostoEdited" type="text" maxlength="8">
                    </div>
                    <div class="input-prepend">
                      <span class="add-on">Nuevo nombre de punto servicio:</span>
                      <input class="input-xlarge" id="txtNamePuntoEdited" name="txtNamePuntoEdited" type="text">
                    </div>
                    
                  </div>
                  <div class="modal-footer">
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambiosPuntosServicios();">Guardar</button>

                                      </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
</div>

<script type="text/javascript">

var tableServiciosFacturacion = null;
var rolUsuario="<?php echo $usuario['rol']; ?>";

$(inicioActPSF());  
function inicioActPSF(){
  if(rolUsuario=="Facturacion"){
     getPuntosServiciosFacturacion();
    }
}






function getPuntosServiciosFacturacion(){
  var dataTablePuntosFacturacion = [];

        $.ajax ({
            type: "POST"
            ,url: "ajax_obtenerPuntosServiciosTable.php"
            ,data : {"banderaBusquedaPuntos":banderaBusquedaPuntos}
            ,dataType: "json"
            ,async: false
            ,success: function (response)
            {
                if (response.status == "success")
                {
                    for (var i = 0; i < response.data.length; i++)
                    {
                        var record = response.data[i];
                        //console.log(record);
                        //alert(record.esatusPunto);

                        if (record.esatusPunto==1)
                        {
                            dataTablePuntosFacturacion.push (record);
                        }
                        
                        
                    }

                    loadDataInTableFacturacion (dataTablePuntosFacturacion);
                }
            }
            ,error : function (response)
            {
                alert ("ocurrio un error");
            }
        });
    }

    function loadDataInTableFacturacion (data)
    {
        if (tableServiciosFacturacion != null)
        {
            tableServiciosFacturacion.destroy ();
            //tableServiciosFacturacion = null;
        }

        if (data.length == 0)
        {
            alert ("No hay datos para cargar");
        }

        tableServiciosFacturacion = $('#tablePuntosServiciosFacturacion').DataTable( {
        data: data,
        destroy: true,
        "columns": [
            { "data": "idPuntoServicio" }
            ,{ "data": "numeroCentroCosto"}
            ,{ "data": "puntoServicio" }
            ,{ "data": "razonSocial" }
            ,{ "data": "nombreEntidadFederativa" }
            ,{ "data": "fechaInicioServicio" }
            ,{ "data": "fechaTerminoServicio" }
            ,{ "data": "terminoFacturacion" }

            
            ,{ "data": "centroCostoFacturacion" }
            ,{ "data": "nombrePuntoFacturacion" }
            
            ,{ "data": "accion_edita_punto_facturacion" }
            

       ]
        //,serverSide: true
        ,processing: true
        ,dom: 'Bfrtip'
        ,buttons: ['excel']

    } );

}

function modalEditarPuntoFacturacion(idPuntoServicio, idCliente,centroCosto,puntoServicio, entidad,fechaInicio, fechaTermino, razonSocial, nombrePuntoFacturacion,centroCostoFacturacion ){

  $("#modalEdicionPuntoFacturacion").modal();
  $("#txtIdPunto").val(idPuntoServicio);
  $("#txtNamePunto").val(puntoServicio);
  $("#txtRazonSocial").val(razonSocial);
  $("#txtCentroCosto").val(centroCosto);
  $("#txtCentroCostoEdited").val(centroCostoFacturacion);
  $("#txtNamePuntoEdited").val(nombrePuntoFacturacion);
  

}

function guardarCambiosPuntosServicios(){
  var idPuntoServicio=$("#txtIdPunto").val();
  var nombrePuntoFacturacion=$("#txtNamePuntoEdited").val();
  var centroCostoFacturacion=$("#txtCentroCostoEdited").val();

  $.ajax({
            type: "POST",
            url: "ajax_updatePuntoServicioFacturacion.php",
            data: {idPuntoServicio:idPuntoServicio,nombrePuntoFacturacion:nombrePuntoFacturacion,centroCostoFacturacion:centroCostoFacturacion},
            dataType: "json",
            success: function(response) {
            var mensaje=response.message;
                if (response.status == "success")
                {

                  alertMsg1="<div id='msgAlert'  name='msgAlert' class='alert alert-success'><strong>Edicion:</strong>"+mensaje+"<a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#alertMsg").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                    getPuntosServiciosFacturacion();
                    $('#modalEdicionPuntoFacturacion').modal('hide');
                    
                    $("#txtCentroCostoEdited").val();
                    $("#txtNamePuntoEdited").val();

                 }else if (response.status=="error")
                {
                  alertMsg1="<div id='msgAlert' name='msgAlert'  class='alert alert-error'><strong>Edicion:</strong>"+mensaje+" <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
                   
                    $("#divMsgFacturacion").html(alertMsg1);
                    $('#msgAlert').delay(3000).fadeOut('slow');
                }
            },           

            error: function(){
                  alert('error handing here');
            }
        });
}
</script>