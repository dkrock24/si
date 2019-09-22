<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Impuesto</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">    
                                                
                    <div class="panel-heading menuTop">Nuevo Impuesto</div>
                        <div class="panel-body menuContent">        
                           
                                    <form class="form-horizontal" name="impuesto" action='save' method="post">
                                        <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; ?>" name="id_submenu">
                                        <div class="row">


                                            <div class="col-lg-6">
                                                <!-- Otro -->
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Nombre</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Impuesto" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Porcentaje</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="porcentaje" name="porcentaje" placeholder="Porcentaje" value="0.00<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">SRN</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="suma_resta_nada" name="suma_resta_nada" placeholder="Suma Resta Nada" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Aplicar a Producto</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="aplicar_a_producto" name="aplicar_a_producto" min="0" max="1" placeholder="Aplicar a producto" value="0<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Aplicar a Cliente</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="aplicar_a_cliente" name="aplicar_a_cliente" min="0" max="1" placeholder="Aplicar a Cliente" value="0<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Aplicar a Proveedor</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="aplicar_a_proveedor" name="aplicar_a_proveedor" min="0" max="1" placeholder="Aplicar a proveedor" value="0<?php //echo $onMenu[0]->nombre_submenu ?>">
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">GBE</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="aplicar_a_grab_brut_exent" name="aplicar_a_grab_brut_exent" placeholder="Grab Bruto Exent" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                        
                                                    </div>
                                                </div>   

                                               

                                                

                                               


                                            </div>

                                            <div class="col-lg-6">

                                                 <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Especial</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="especial" name="especial" min="0" max="1" value="0<?php //echo $onMenu[0]->url_submenu ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Excluyente</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="excluyente" name="excluyente" min="0" max="1" value="0<?php //echo $onMenu[0]->url_submenu ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Condicion</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" class="form-control" id="condicion" name="condicion" min="0" max="1" value="0<?php //echo $onMenu[0]->url_submenu ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Condicion Valor</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="c_valor" name="c_valor"value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Mensaje</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="mensaje" name="mensaje"value="<?php //echo $onMenu[0]->url_submenu ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-offset-4 col-sm-8">
                                                        
                                                        <label>
                                                            <select name="imp_estado" class="form-control">
                                                                <option value="1">Activo</option>
                                                                <option value="0">Inactivo</option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>

                                                 <div class="form-group">
                                                    <div class="col-sm-offset-4 col-sm-8">
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
