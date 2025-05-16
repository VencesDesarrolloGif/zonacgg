<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h2 class="card-title">Edicion De Una Matriz</h2>
            <div id="MensajeEditarMatrizEdicicpn"></div>
            <img title='Consulta/Cargar/Actualizar Pagina' src='img/start.png' class='cursorImg' onclick="CargarMatrices();" width="80px"></center>
        </center>
        <form class="form-inline"  method="post" id="form_EdicionMatriz" action="ficheroExcelMovimientos.php" target="_blank" enctype='multipart/form-data'>

            <!-----------------------comienza fila 1 y el formulario --------------------------------------------------->  
            <div align="center" ><br>
                <div  style="max-width: 100rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <h3>Selecciona La Matriz Que Desea Editar</h3>

                    <div calss="row">                
                        <label class="control-label label" for="selectEdicionMatriz11">Matrices</label>
                        <select class="span3" id="selectEdicionMatriz11" name="selectEdicionMatriz11"></select>     
                    </div><br>

                    <div calss="row" id="AgregarentidadMatrizEdit" style="display:none">
                        <h4>Agregar Una Nueva Entidad A La Matriz</h4>
                        <label class="control-label label" for="selectAgregarEntidad">Entidades</label>
                        <select class="span3" id="selectAgregarEntidad" name="selectAgregarEntidad"></select>     
                    </div><br>

                    <div calss="row" id="DivTabla" style="display:none">
                        <h3>Datos De La Matriz A Editar</h3><br>
                            <section>
                                <table id="tablaEdicionMatriz"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="text-align: center;background-color: #B0E76E">Id Entidad</th>
                                            <th style="text-align: center;background-color: #B0E76E">Nombre Entidad</th>
                                            <th style="text-align: center;background-color: #B0E76E">Fecha Asignacion</th> 
                                            <th style="text-align: center;background-color: #B0E76E">Usuario Asignacion</th> 
                                            <th style="text-align: center;background-color: #B0E76E">Quitar Entidad De La Matriz</th> 
                                        </tr>
                                    </thead>
                                </table>
                            </section>
                    </div><br>
                    <div calss="row" id="BajaMatriz" style="display:none">
                        <center>
                            <h3>Dar De Baja Esta Matriz</h3>
                            <h5>Las Entidades Asignadas Pasaran A Estar Disponibles Para Asignar a Otra Matriz</h5><br>
                            <img title='Inabilitar Matriz' src='img/dardebaja.png' class='cursorImg' id='btnguardar' onclick="DarDeBajaMatriz();" width="50px">
                        </center>
                    </div><br>
                </div>
            </div>
        </form>        
            <script src="EdicionMatriz/EdicionMatriz.js"></script>
            <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html> 