<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link  href="css-Bootstrap-V4.1.3/css/bootstrap.min.css" >
        <link rel="stylesheet" href="css-Bootstrap-V4.1.3/popper.min.js" >
    </head>
    <body>
        <input class="span3" id="BanderaUsuarioLogeado" name="BanderaUsuarioLogeado" type="hidden" readonly="true">
        <div id="LinksUsuarioMatriz" style="display:none">
            <center>
                <a id="TransferirTarjeta"onclick="MostrarDivReservados(0)"style="cursor: pointer;" data-toggle="tab">TRANSFERIR TARJETAS</a>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <a id="StockTarjetas"onclick="MostrarDivReservados(1)"style="cursor: pointer;" data-toggle="tab">VER STOCK TARJETAS</a><br>
                <input class="span3" id="BanderaIdMatriz" name="BanderaIdMatriz" type="hidden" readonly="true">
            </center>
        </div>
        <div id="DivTransferirTarjetas" style="display:none">
            <center>
                <h2 class="card-title">Distribución Tarjetas De Despensa</h2>
                <div id="MensajeTransferirTarjetas"></div>
                <div id="UrlTransferencia">
                    <a id="TransferirTarjetaAEntidades"onclick="MostrarTransferencia(0)"style="cursor: pointer; color: green;" data-toggle="tab">TRANSFERIR TARJETAS A ENTIDADES</a>
                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <a id="TransferirTarjetaAMatriz"onclick="MostrarTransferencia(1)"style="cursor: pointer; color: green;" data-toggle="tab">TRANSFERIR TARJETAS A MATRIZ</a><br><br>
                </div>
            
                <div id="TransferirAEntidades" style="display:none">
                    <h3>Transferir Tarjetas De Despensa A Las Entidades A Su Cargo</h3>
                    <div class="row" id="DivTotalDeTarjetasDisponibles">                
                        <label class="control-label label" for="TotlaTarjetasDisponibles">Total De Tarjetas Disponibles</label>
                        <input class="span3" id="TotlaTarjetasDisponibles" name="TotlaTarjetasDisponibles" type="text" readonly="true">
                    </div>
                    <div class="row" id="MensajeSinTarjetas" style="display:none">
                        <h3 style="color: red;">No Cuentas Con Tarjetas Disponibles Para Transferir Ingresa El Nuevo Pedido Para Continuar</h3>
                    </div>
                    <div class="row" id="EntidadesAMandar" style="display:none">
                        <h4>Seleccione La Entidad A Transferir</h4>
                        <label class="control-label label" for="SelectEntidadTransferir">Entidades</label>
                        <select class="span3" id="SelectEntidadTransferir" name="SelectEntidadTransferir"></select>     
                    </div>
                    <div id="DivListaTarjetasDisponibles" style="display:none">
                        <form class="form-horizontal" id="form_TarjetasParaEntidades" name="form_TarjetasParaEntidades">
                            <center><h3>Informacion De Las Tarjetas Disponibles</h3></center>
                            <br>
                            <div id="divTarjetasDisponibles" align="center"></div> 
                            <input class="span3" id="numeroFirmaEnvioAentidad" name="numeroFirmaEnvioAentidad" type="hidden" readonly="true">
                            <input class="span3" id="ContraseniaFirmaEnvioAEntidad" name="ContraseniaFirmaEnvioAEntidad" type="hidden" readonly="true"> 
                        </form>
                    </div>
                </div>

                <div id="TransferirAMatriz" style="display:none">
                    <h3>Transferir Tarjetas De Despensa A La Matriz</h3>  
                    <div class="row" id="EntidadesParaMandarAMatriz" >
                        <h4>Seleccione La Entidad A Transferir</h4>
                        <label class="control-label label" for="SelectEntidadTransferiraMatriz">Entidades</label>
                        <select class="span3" id="SelectEntidadTransferiraMatriz" name="SelectEntidadTransferiraMatriz"></select>     
                    </div>              
                    <div class="row" id="DivTotalDeTarjetasDisponiblesParaMatriz" style="display:none">                
                        <label class="control-label label" for="TotlaTarjetasDisponiblesParaMatriz">Total De Tarjetas Disponibles</label>
                        <input class="span3" id="TotlaTarjetasDisponiblesParaMatriz" name="TotlaTarjetasDisponiblesParaMatriz" type="text" readonly="true">
                    </div><br>
                    <div class="row" id="MensajeSinTarjetasDisponibles" style="display:none">
                        <h3 style="color: red;">No Cuentas Con Tarjetas Disponibles Para Transferir</h3>
                    </div>
                    <div class="row" id="TotalDisponibleParaMatriz" style="display:none">
                        <h4>Matriz A Transferir</h4>
                        <label class="control-label label" for="MatrizATransferir">Matriz</label>
                        <input class="span3" id="MatrizATransferir" name="MatrizATransferir" type="text" readonly="true">
                        <input class="span3" id="IdMatrizATransfer" name="IdMatrizATransfer" type="hidden" readonly="true">
                    </div>
                    <div id="DivListaTarjetasDisponiblesParaMatriz11" style="display:none">
                        <form class="form-horizontal" id="form_TarjetasParaMatriz" name="form_TarjetasParaMatriz">
                            <center><h3>Informacion De Las Tarjetas Disponibles</h3></center>
                            <br>
                            <div id="divTarjetasDisponiblesParaMatriz11" align="center"></div>  
                        </form>
                    </div>
    
                </div>
            </center>
        </div>

        <div id="VerStock" style="display:none">
            <center>
                <h2 class="card-title">STOCK DE TARJETAS DE DESPENSA</h2>
                <div id="MensajeStockTarjetas"></div>
                <div class="row" id="EntidadesParaVerStock" >
                    <h4>Seleccione La Entidad Para Ver Su Stock</h4>
                    <label class="control-label label" for="SelectEntidadStock">Entidades</label>
                    <select class="span3" id="SelectEntidadStock" name="SelectEntidadStock"></select>     
                </div>
                <div class="row" id="divTotalStockMatriz" style="display:none">
                    <h3>Stock De Tarjetas Restantes En La Matriz</h3>
                    <label class="control-label label" for="TotalStockMatriz">Total De Tarjetas En Matriz Para Asignar</label>
                    <input class="span3" id="TotalStockMatriz" name="TotalStockMatriz" type="text" readonly="true">
                </div>
                <div id="StockPorEntidades" style="display:none">
                    <h3>Stock De Tarjetas Por Entidades</h3>

                    <div class="row">
                        <section>
                            <table id="tablaStockPorEntidades"  class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="95%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="text-align: center;background-color: #B0E76E">NÚMERO EMPLEADO</th>
                                        <th style="text-align: center;background-color: #B0E76E">NOMBRE EMPLEADO</th>
                                        <th style="text-align: center;background-color: #B0E76E">MATRIZ</th>
                                        <th style="text-align: center;background-color: #B0E76E">ENTIDAD</th>
                                        <th style="text-align: center;background-color: #B0E76E">ID PEDIDO</th>
                                        <th style="text-align: center;background-color: #B0E76E">IUT TARJETA</th> 
                                        <th style="text-align: center;background-color: #B0E76E">ESTATUS TARJETA</th> 
                                        <th style="text-align: center;background-color: #B0E76E">ESTATUS ASIGNACIÓN A ENTIDAD</th> 
                                        <th style="text-align: center;background-color: #B0E76E">ESTATUS ASIGNACIÓN A EMPLEADO</th> 
                                        <th style="text-align: center;background-color: #B0E76E">COMENTARIO TARJETA</th> 
                                    </tr>
                                </thead>
                            </table>
                        </section>   
                    </div><br>
                </div>
            </center>
        </div>

        <div class="modalEdit hide fade" tabindex="-1" role="dialog" name="modalFirmaElectronicaParaEntidad" id="modalFirmaElectronicaParaEntidad" data-backdrop="static">
            <div id="errorModalFirmaInternaParaEntidad"></div>
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h3 class="modal-title" align="center"><img src="img/alert.png">Escribe tu numero de empleado y la contraseña que generaste !!</h3>
                </div>
                <div class="modal-body" align="center">
                  <span class="add-on"># Empleado</span>
                  <input type="text" id="NumEmpModalFirmaParaEntidad" class="input-medium" name="NumEmpModalFirmaParaEntidad" placeholder="00-0000-00 Ó 00-00000-00">
                  <input type="hidden" id="banderaModalFirma" class="input-medium" name="banderaModalFirma">
                  <span class="add-on">Contraseña</span>
                  <input type="password" id="constraseniaFirmaParaEntidad" class="input-xlarge"name="constraseniaFirmaParaEntidad" title="El campo identifica entre mayusculas y minusculas favor de considerarlo">
                </div>
                <div class="modal-body" align="center">
                  <button type="button" id="btnFirmarParaEnvioDeTarjetaParaentidad" name="btnFirmarParaEnvioDeTarjetaParaentidad" onclick="RevisarFirmaInternaParaEnvioDeTarjetaParaEntidad();" style="display: block;" class="btn btn-primary" >Firmar</button><br>
                  <button type="button" id="btnCancelarFirma" name="btnCancelarFirma"onclick="cancelarFirmaParaEnvioDeTarjetaParaEntidad();" class="btn btn-danger" >Cancelar</button>
                </div>      
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
            
            <script src="DistribucionTarjetas/DistribucionTarjetas.js"></script>
            <link rel="stylesheet" href="css-Bootstrap-V4.1.3/js/bootstrap.min.js">
    </body>
</html> 