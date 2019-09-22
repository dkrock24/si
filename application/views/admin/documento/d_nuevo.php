<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Documento</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">

                <div id="panelDemo10" class="panel menu_title_bar">    
                                        
                    <div class="panel-heading menuTop">Nuevo Tipo Documento : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="panel-body menuContent">        
                
                        <form class="form-horizontal" name="moneda" action='save' method="post">
                            <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="nombre" name="nombre" placeholder="Nombre Documento" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Inventario</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="efecto_inventario" name="efecto_inventario" placeholder="Efecto Inventario" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Iva</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="efecto_en_iva" name="efecto_en_iva" placeholder="Efecto Iva" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Cuentas</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="efecto_en_cuentas" name="efecto_en_cuentas" placeholder="Efecto Cuentas" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Cajas</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="efecto_en_caja" name="efecto_en_caja" placeholder="Efecto Cajas" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Reportes</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="efecto_en_report_venta" name="efecto_en_report_venta" placeholder="Efecto Reportes" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Autmatico</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="automatico" name="automatico" placeholder="Autmatico" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Emitir a</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" required id="emitir_a" name="emitir_a" placeholder="Emitir a" value="<?php //echo $onMenu[0]->icon_submenu ?>">
                                        </div>
                                    </div>

                                    

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            
                                            <label>
                                                <select name="estado" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">Guardar</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                   
            </div>
        </div>
    </div>
</section>
