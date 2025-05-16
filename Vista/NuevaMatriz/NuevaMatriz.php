<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h2 class="card-title">Creación Nueva Matriz</h2>
            <div id="MensajeNuevaMatriz"></div>
            <img title='Consulta/Cargar/Actualizar Pagina' src='img/start.png' class='cursorImg' onclick="CargarEntidadesParaMatriz();" width="80px"></center>
        </center>
        <form class="form-inline"  method="post" id="form_NuevaMatriz" action="ficheroExcelMovimientos.php" target="_blank" enctype='multipart/form-data'>

            <!-----------------------comienza fila 1 y el formulario --------------------------------------------------->  
            <div align="center" ><br>
                <div  style="max-width: 80rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <h3>Selecciona La Entidad Que Será La Nueva Matriz</h3><br>

                    <div calss="row">
                
                        <label class="control-label label" for="selectNuevaMatriz">Entidades</label>
                        <select class="span3" id="selectNuevaMatriz" name="selectNuevaMatriz"></select>     
    
                    </div>

                    <h4>La Nueva Matriz Será</h4><br>

                    <div calss="row">
                
                        <label class="control-label label" for="ImpFactura">Nueva Matriz</label>
                        <input class="span3"  id="InpNuevaMatriz" name="InpNuevaMatriz" type="text" readonly="true">
    
                    </div><br>

                    <h3>Selecciona Las Entidades Que Estarán A Cargo De Esta Matriz</h4><br>

                    <div calss="row">
                        <label class="control-label label" for="SelectEnidadParaMatriz">Entidades</label>
                        <select class="span3" id="SelectEnidadParaMatriz" name="SelectEnidadParaMatriz" ></select>
                    </div><br>

                    <div calss="row">
                        <button id="AgregarNuevaEntidadMatriz" name="AgregarNuevaEntidadMatriz" class="btn btn-success " type="button"> 
                        <span class="glyphicon glyphicon-floppy-save"></span>Agregar Entidad</button>   
                    </div><br>
                    <div calss="row">
                        <div id="tablaCreadaParaMatriz" name="tablaCreadaParaMatriz" >
                            <table id='tablaMatriz' class='table table-bordered'><thead><th>N°</th><th>ENTIDAD</th><th>NOMBRE ENTIDAD</th></thead><tbody></tbody></table>
                        </div>
                    </div><br>
                    <div calss="row">
                        <button id="GuardarNuevaEntidadMatriz" name="GuardarNuevaEntidadMatriz" class="btn btn-primary " type="button"> 
                        <span class="glyphicon glyphicon-floppy-save"></span>Guardar Nueva Matriz</button>   
                    </div><br>
                </div>
            </div>
        </form>        
            <script src="NuevaMatriz/NuevaMatriz.js"></script>
            <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html> 