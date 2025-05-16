<!DOCTYPE html>
<html lang="en">
    <head>
      <center><h3>Catalogo especificación de incidencia</h3></center><br>
    </head>
    <body>
        <section>
          <center>
            <div>
              <select id="selectIncidencias" name="selectIncidencias" class="input-large ">
                <option value="0">INCIDENCIA</option>
              </select>
            </div>
            <br>
            <div id="divEsp" ></div>
            <br>
            <button style="margin-bottom: 0.5%; display: none;" type="button" class="btn btn-primary" id="agregarEsp">Agregar</button>
          </center>
        </section>

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalAddEspecificacion" id="modalAddEspecificacion" data-backdrop="static">
          <div id="errormodalAddEspecificacion"></div>
          <div class="modal-dialog" role="document">
            <div class="modal-content">  
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" align="center"><img src="img/alert.png"> Escribe la especificación</h3>
              </div>
              <div class="modal-body" align="center">
                <span class="add-on">Incidencia</span>
                <input type="text" id="idIncidenciaModal" class="input-medium" name="idIncidenciaModal" readonly>
                <span class="add-on">Especificación</span>
                <textarea id="txtEspecificacion" style="width: 330px; height: 20px;"></textarea>
              </div>
              <div class="modal-body" align="center">
                <button type="button" id="btnGuardarEsp" name="btnGuardarEsp" onclick="guardarEsp();" style="display: block;" class="btn btn-primary" >Guardar</button><br>
                <button type="button" id="btnCancelarEsp" name="btnCancelarEsp"onclick="cancelarEsp();" class="btn btn-danger" >Cancelar</button>
              </div>      
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
       
        <script src="CatalogoEspecificacionesIncidencias/funciones_catalogoEsp.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>