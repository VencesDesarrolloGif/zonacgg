<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <center><h3 class="card-title">SUPER USUARIO</h3>
        <br>
        <div id="LinkSuperUsuario">
            <center>
                <a id="CrearSuperUsuario"onclick="MostrarDivPorOpcionSuperUsuario(0)"style="cursor: pointer;" data-toggle="tab">CREAR SUPER USUARIO</a>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <a id="BlquearSuperUsuario"onclick="MostrarDivPorOpcionSuperUsuario(1)"style="cursor: pointer;" data-toggle="tab">BLOQUEAR SUPER USUARIO</a>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <a id="BlquearSuperUsuario"onclick="MostrarDivPorOpcionSuperUsuario(2)"style="cursor: pointer;" data-toggle="tab">ACTIVAR SUPER USUARIO</a>
            </center>
        </div><br>
        <div id="divCrearSuperUsuario" align="center" style="display: none;">
            <div class= "row">
                <label class="control-label label">N° Empleado Creación</label>
                <input type="text" name="inpNumeroEmpleado" id="inpNumeroEmpleado"class="search-query" placeholder="Numero Empleado" aria-describedby="basic-addon2" onblur=""><img src="img/search.png">
            </div><br>
            <div id="divDatosBusqueda" style="display:none;">
                <div class= "row">
                    <label class="control-label label " for="NumeroEmpleado">N° Empleado</label>
                    <input id="NumeroSuperUsuario" name="NumeroSuperUsuario" type="text"class="input-large" readonly>
                    <label class="control-label label " for="NombrEmepleado">Nombre</label>
                    <input id="NombreSuperUsuario" name="NombreSuperUsuario" type="text"class="input-large" readonly>
                </div><br>
                <div class= "row">
                    <label class="control-label label " for="PuestoEmpleado">Puesto</label>
                    <input id="PuestoSuperUsuario" name="PuestoSuperUsuario" type="text"class="input-large" readonly>
                    <label class="control-label label " for="FechaIngresoEmp">Fecha Ingreso</label>
                    <input id="FechaSuperUsuario" name="FechaSuperUsuario" type="text" class="input-large" readonly>
                </div><br>
                <div class= "row">
                    <label class="control-label label " for="UsuarioSuper" >Usuario</label>
                    <input id="UsuarioSuperUsuario" name="UsuarioSuperUsuario" type="text"class="input-large" maxlength="10" style="text-transform: lowercase;">
                    <label class="control-label label " for="PuestoEmpleado">Contraseña</label>
                    <input id="ContraseniaSuperUsuario" name="ContraseniaSuperUsuario" type="Password" class="input-large">
                </div><br>
                <div class= "row">
                    <button type='button' class='btn btn-success' id='btnCrearSuperUsuario' name='btnCrearSuperUsuario'>Crear Super Usuario</button>
                </div>
            </div>
        </div>
        <div id="divBloquearSuperUsuario" style="display: none;">
            <div class= "row">
                <label class="control-label label">N° Empleado Bloqueo</label>
                <input type="text" name="inpNumeroEmpleadoBloqueo" id="inpNumeroEmpleadoBloqueo"class="search-query" placeholder="Numero Empleado" aria-describedby="basic-addon2" onblur=""><img src="img/search.png">
            </div><br>
            <div id="divDatosBusquedaBloqueo" style="display:none;">
                <div class= "row">
                    <label class="control-label label " for="NumeroEmpleadoBloqueo">N° Empleado</label>
                    <input id="NumeroSuperUsuarioBloqueo" name="NumeroSuperUsuarioBloqueo" type="text"class="input-large" readonly>
                    <label class="control-label label " for="NombrEmepleadoBloqueo">Nombre</label>
                    <input id="NombreSuperUsuarioBloqueo" name="NombreSuperUsuarioBloqueo" type="text"class="input-large" readonly>
                    
                </div><br>
                <div class= "row">
                    <label class="control-label label " for="PuestoEmpleadoBloqueo">Puesto</label>
                    <input id="PuestoSuperUsuarioBloqueo" name="PuestoSuperUsuarioBloqueo" type="text"class="input-large" readonly>
                    <label class="control-label label " for="FechaIngresoEmpBloqueo">Fecha Ingreso</label>
                    <input id="FechaSuperUsuarioBloqueo" name="FechaSuperUsuarioBloqueo" type="text" class="input-large" readonly>
                </div><br>
                <div class= "row">
                    <label class="control-label label " for="UsuarioSuperBloqueo">Usuario</label>
                    <input id="UsuarioSuperUsuarioBloqueo" name="UsuarioSuperUsuarioBloqueo" type="text"readonly>
                    <label class="control-label label " for="PuestoEmpleadoBloqueo">Contraseña</label>
                    <input id="ContraseniaSuperUsuarioBloqueo" name="ContraseniaSuperUsuarioBloqueo" type="Password" class="input-large" readonly>
                </div><br>
                <div class= "row">
                    <button type='button' class='btn btn-success' id='btnBloquearSuperUsuario' name='btnBloquearSuperUsuario' style="display:none;">Bloquear Usuario</button>
                </div>
            </div>
        </div>
        <div id="divActivarSuperUsuario" style="display: none;">
            <div class= "row">
                <label class="control-label label">N° Empleado Activar</label>
                <input type="text" name="inpNumeroEmpleadoActivar" id="inpNumeroEmpleadoActivar"class="search-query" placeholder="Numero Empleado" aria-describedby="basic-addon2" onblur=""><img src="img/search.png">
            </div><br>
            <div id="divDatosBusquedaActivar" style="display:none;">
                <div class= "row">
                    <label class="control-label label " for="NumeroEmpleadoActivar">N° Empleado</label>
                    <input id="NumeroSuperUsuarioActivar" name="NumeroSuperUsuarioActivar" type="text"class="input-large" readonly>
                    <label class="control-label label " for="NombrEmepleadoActivar">Nombre</label>
                    <input id="NombreSuperUsuarioActivar" name="NombreSuperUsuarioActivar" type="text"class="input-large" readonly>
                    
                </div><br>
                <div class= "row">
                    <label class="control-label label " for="PuestoEmpleadoActivar">Puesto</label>
                    <input id="PuestoSuperUsuarioActivar" name="PuestoSuperUsuarioActivar" type="text"class="input-large" readonly>
                    <label class="control-label label " for="FechaIngresoEmpActivar">Fecha Ingreso</label>
                    <input id="FechaSuperUsuarioActivar" name="FechaSuperUsuarioActivar" type="text" class="input-large" readonly>
                </div><br>
                <div class= "row">
                    <label class="control-label label " for="UsuarioSuperActivar">Usuario</label>
                    <input id="UsuarioSuperUsuarioActivar" name="UsuarioSuperUsuarioActivar" type="text"class="input-large" readonly>
                    <label class="control-label label " for="PuestoEmpleadoActivar">Contraseña</label>
                    <input id="ContraseniaSuperUsuarioActivar" name="ContraseniaSuperUsuarioActivar" type="Password" class="input-large">
                </div><br>
                <div class= "row">
                    <button type='button' class='btn btn-success' id='btnActivarSuperUsuario' name='btnActivarSuperUsuario' style="display:none;">Activar Usuario</button>
                </div>
            </div>
        </div>


        <script src="SuperUsuario/SuperUsuario.js"></script>
    </body>
</html>