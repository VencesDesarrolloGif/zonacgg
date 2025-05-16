<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <center><h2 class="card-title">Asignación De Una Matriz</h2>
            <div id="MensajeAsignacionMatriz"></div>
        </center>
        <form class="form-inline"  method="post" id="form_AsignacionMatriz" action="ficheroExcelMovimientos.php" target="_blank" enctype='multipart/form-data'>

            <!-----------------------comienza fila 1 y el formulario --------------------------------------------------->  
            <div align="center" ><br>
                <div  style="max-width: 100rem; border-style: groove; border-color: rgb(51,153,255); "><br>
                    <h3>Ingrese El Empleado Que Estará A Cargo De La Matriz</h3>

                    <div calss="row">                
                        <label class="control-label label" for="NumeroEmpleadoAsignacionMatriz"># Empleado </label>
                        <input class="span3" id="NumeroEmpleadoAsignacionMatriz" name="NumeroEmpleadoAsignacionMatriz" placeholder="00-0000-00 ó 00-00000-00" onkeyup="verificaConsultaEmpleadoAsignacionMatriz();"type="text" >
                    </div><br>

                    <div calss="row" id="DivInformacionEmpladoParaAsignar" style="display:none">                
                        <label class="control-label label" for="NombreEmpleadoParaAsignar">Nombre Empleado </label>
                        <input class="span3" id="NombreEmpleadoParaAsignar" name="NombreEmpleadoParaAsignar" type="text" readonly="true">

                        <label class="control-label label" for="PuestoEmpleadoParaAsignar">Puesto Empleado </label>
                        <input class="span3" id="PuestoEmpleadoParaAsignar" name="PuestoEmpleadoParaAsignar" type="text" readonly="true" >
                    </div><br>

                    <div calss="row" id="DivInformacionEmpladoParaAsignar1" style="display:none">                
                        <label class="control-label label" for="EntidadTrabajoParaAsignar">Entidad De Trabajo</label>
                        <input class="span3" id="EntidadTrabajoParaAsignar" name="EntidadTrabajoParaAsignar" type="text" readonly="true">

                        <label class="control-label label" for="LineaNegocioParaAsignar">Linea De Negocio</label>
                        <input class="span3" id="LineaNegocioParaAsignar" name="LineaNegocioParaAsignar" type="text" readonly="true" >
                    </div><br>

                    <div calss="row" id="DivTablaUsuarioAsignar" style="display:none">
                        <h3 id="tituloTablaUsuarioParaAsignacion1">Seleccione El Usuario Que Estará A Cargo De La Matriz</h3>
                        <h5 id="tituloTablaUsuarioParaAsignacion">Si No Hay Registros Agrege Un Nuevo Usuario Con El Rol De Lider de Unidad O Contrataciones</h5><br>
                            <section>
                                <table id="tablaUsuarioAsigancionMatriz"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="text-align: center;background-color: #B0E76E">Usuarios</th>
                                            <th style="text-align: center;background-color: #B0E76E">Rol Usuario</th>
                                            <th style="text-align: center;background-color: #B0E76E">Nombre Asignado</th> 
                                            <th style="text-align: center;background-color: #B0E76E">Fecha Asiganción</th> 
                                            <th style="text-align: center;background-color: #B0E76E">Seleccionar</th> 
                                        </tr>
                                    </thead>
                                </table>
                            </section>
                    </div><br>

                    <div calss="row" id="DivUsuariiEmpleadoAsignar" style="display:none">                
                        <label class="control-label label" for="UsuarioSeleccionadoParaAsignar">Usuario Seleccionado</label>
                        <input class="span3" id="UsuarioSeleccionadoParaAsignar" name="UsuarioSeleccionadoParaAsignar" type="text" readonly="true">

                        <label class="control-label label" for="RolUsuarioParaAsignar">Rol Del Usuario</label>
                        <input class="span3" id="RolUsuarioParaAsignar" name="RolUsuarioParaAsignar" type="text" readonly="true" >
                    </div><br>

                    <div calss="row" id="DivAsignarMatriz" style="display:none">
                        <h4>Seleccione La Matriz A Asignar</h4>
                        <label class="control-label label" for="selectAsignarMatrizUsuario">Matrices</label>
                        <select class="span3" id="selectAsignarMatrizUsuario" name="selectAsignarMatrizUsuario"></select>     
                    </div>

                    <div calss="row" id="DivDesAsignarMatriz" style="display:none">
                        <h4>Matriz A Quitar De La Asignación </h4>
                        <label class="control-label label" for="selectDesAsignarMatriz">Matrices</label>
                        <select class="span3" id="selectDesAsignarMatriz" name="selectDesAsignarMatriz"></select>     
                    </div><br>

                    <div calss="row" id="DivTablAsignar" style="display:none">
                        <h3 id="tituloTablaAsigancion" style="display:none">Datos De La Matriz A Asignar</h3>
                        <h3 id="tituloTablaDesAsigancion" style="display:none">Datos De La Matriz A Quitar De La Asignación</h3><br>
                            <section>
                                <table id="tablaAsigancionMatriz"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="text-align: center;background-color: #B0E76E">Id Entidad</th>
                                            <th style="text-align: center;background-color: #B0E76E">Nombre Entidad</th>
                                            <th style="text-align: center;background-color: #B0E76E">Fecha Asignacion</th> 
                                            <th style="text-align: center;background-color: #B0E76E">Usuario Asignacion</th> 
                                        </tr>
                                    </thead>
                                </table>
                            </section>
                    </div><br>
                    <div calss="row" id="DivBotonAsignar" style="display:none">
                        <button id="GuardarAsigancionMatrizEmpleado" name="GuardarAsigancionMatrizEmpleado" class="btn btn-primary " type="button"> 
                        <span class="glyphicon glyphicon-floppy-save"></span>Guardar Asignación</button>   
                    </div>

                    <div calss="row" id="DivBotonDesAsignar" style="display:none">
                        <button id="GuardarDesaasignacionMatrizEmpleado" name="GuardarDesaasignacionMatrizEmpleado" class="btn btn-danger " type="button"> 
                        <span class="glyphicon glyphicon-floppy-save"></span>Quitar Asignación</button>   
                    </div><br>
                </div>
            </div>
        </form>        
            <script src="AsignacionMatriz/AsignacionMatriz.js"></script>
            <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html> 