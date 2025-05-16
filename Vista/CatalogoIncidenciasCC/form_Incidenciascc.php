<!DOCTYPE html>
<html lang="en">
    <head>
      <center><h3>Catalogo de incidencias</h3></center><br>
    </head>
    <body>
        <section>
          <center>
            <div id="divCatInc" ></div>
            <br>
            <button style="margin-bottom: 0.5%; display: none;" type="button" class="btn btn-primary" id="agregarInc">Agregar</button>
          </center>
        </section>

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalAddIncCat" id="modalAddIncCat" data-backdrop="static">
          <div id="errormodalAddIncCat"></div>
          <div class="modal-dialog" role="document">
            <div class="modal-content">  
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" align="center"><img src="img/alert.png"> Escribe la incidencia</h3>
              </div>
              <div class="modal-body" align="center">
                <span class="add-on">Incidencia</span>
                <textarea id="txtNuevaInc" style="width: 330px; height: 20px;"></textarea>
              </div>
              <div class="modal-body" align="center">
                <button type="button" id="btnGuardarEsp" name="btnGuardarEsp" onclick="guardarInc();" style="display: block;" class="btn btn-primary" >Guardar</button><br>
                <button type="button" id="btnCancelarEsp" name="btnCancelarEsp"onclick="cancelarInc();" class="btn btn-danger" >Cancelar</button>
              </div>      
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
       
        <script src="CatalogoIncidenciasCC/funciones_incidenciasCC.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>