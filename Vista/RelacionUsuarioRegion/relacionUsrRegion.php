<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
    </head>
    <body>

    <div id="divMensajeRelacion"></div>
    <table>
        <tr>
            <td valign="top">
              <div style="max-width: 50rem; border-style: groove; border-color: rgba(51,153,255,.5); " id="divRelacionUSRregion" align="center" >
                <center><h3 class="card-title">Relación Región-Usuario</h3>
                <br>
                <span>REGION:</span>
                <select id="SelRegion"></select>

                <span>LINEA DE NEGOCIO:</span>
                <select id="SelLineaNegocio">
                    <option value="0">LINEA DE NEGOCIO</option>
                </select>
                <br>
                <br>
                <span>USUARIO:</span>
                <select id="SelUsuario">
                    <option value="0">USUARIO</option>
                </select>

                <br>
                <br>
                <button style="width: 150px;height: 40px;border-radius: 20px;background-color: rgba(159, 209, 13,.8);color: blue;" id="btnAsignarRegionAUsr">ASIGNAR</button>
                <br>
                <br>
                <table>
                    <tr>
                        <td valign="top">
                            <div style="max-width: 50rem; border-style: groove; border-color: rgba(51,153,255,.5); " id="divListaUsuariosAsignados" align="center" ><br>
                                    <h4>Usuarios Asignados</h4><br>
                                    <div id="divListaUsuariosAsignados">
                                        <ul class='list' id='listaUsuariosAsignados' name='listaUsuariosAsignados'></ul>
                                    </div>
                            </div>
                        </td>
                    </tr>
                </table>
              </div>
            </td>
            <td valign="top">
              <div style="max-width: 100rem; border-style: groove; border-color: rgba(51,153,255,.5); " id="divRelacionUSRcliente" align="center" >
                <center><h3 class="card-title">Relación Usuario-Cliente</h3>
                <br>
                <span>USUARIO:</span>
                <select id="SelUsuarioUSRcliente">
                </select>    

                <span>LINEA DE NEGOCIO:</span>
                <select id="SelLineaNegocioC">
                    <option value="0">LINEA DE NEGOCIO</option>
                </select>
                <br>            
                <br>            
                <span>CLIENTE:</span>
                <select id="SelCliente">
                    <option value="0">CLIENTE</option>
                </select>
                <br>
                <br>
                <button style="width: 100px;height: 50px;border-radius: 20px;background-color: rgba(159, 209, 13,.8);color: blue;" id="btnAsignarClienteAUsr">ASIGNAR</button>
                <br>
                <br>
                <table>
                    <tr>
                        <td valign="top">
                            <div style="max-width: 70rem; border-style: groove; border-color: rgba(51,153,255,.5); " id="divListaClientesAsignados" align="center" ><br>
                                    <h4>Clientes Asignados</h4><br>
                                    <div id="divListaClientesAsignados">
                                        <ul class='list' id='listaClientesAsignados' name='listaClientesAsignados'></ul>
                                    </div>
                            </div>
                        </td>
                    </tr>
                </table>
              </div>
            </td><!--TERMINA PARTE USR-CLIENTE-->
        </tr>
    </table>
        <script src="RelacionUsuarioRegion/relacionUsrRegion.js"></script>
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html>