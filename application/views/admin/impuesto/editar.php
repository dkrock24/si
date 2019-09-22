<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Impuesto</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                
                    <div id="panelDemo10" class="panel menu_title_bar">     
                                                
                        <div class="panel-heading menuTop">Editar Impuesto : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                             <div class="panel-body menuContent">        
                            
                            <form class="form-horizontal" name="editar" action='../update' method="post">
                                <input type="hidden" value="<?php echo $impuesto[0]->id_tipos_impuestos; ?>" name="id_tipos_impuestos">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Impuesto" value="<?php echo $impuesto[0]->nombre ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Porcentage</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="porcentage" name="porcentage" placeholder="Porcentage" value="<?php echo $impuesto[0]->porcentage ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">SRN</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="suma_resta_nada" name="suma_resta_nada" placeholder="Suma Resta Nada" value="<?php echo $impuesto[0]->suma_resta_nada ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Aplicar a Producto</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="aplicar_a_producto" name="aplicar_a_producto" placeholder="Aplicar a producto" value="<?php echo $impuesto[0]->aplicar_a_producto ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Aplicar a Cliente</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="aplicar_a_cliente" name="aplicar_a_cliente" placeholder="Aplicar a Cliente" value="<?php echo $impuesto[0]->aplicar_a_cliente ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Aplicar a Proveedor</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="aplicar_a_proveedor" name="aplicar_a_proveedor" placeholder="Aplicar a proveedor" value="<?php echo $impuesto[0]->aplicar_a_proveedor ?>">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">GBE</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="aplicar_a_grab_brut_exent" name="aplicar_a_grab_brut_exent" placeholder="Grab Bruto Exent" value="<?php echo $impuesto[0]->aplicar_a_grab_brut_exent ?>">
                                                
                                            </div>
                                        </div>      

                                        

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Especial</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="especial" name="especial" min="0" max="1" value="<?php echo $impuesto[0]->especial ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Excluyente</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="excluyente" name="excluyente" min="0" max="1" value="<?php echo $impuesto[0]->excluyente ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Condicion</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="condicion" name="condicion" min="0" max="1" value="<?php echo $impuesto[0]->condicion ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Condicion Valor</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="c_valor" name="c_valor" value="<?php echo $impuesto[0]->condicion_valor ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label no-padding-right">Mensaje</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mensaje" name="mensaje" value="<?php echo $impuesto[0]->mensaje ?>">
                                            </div>
                                        </div>                                  

                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-8">
                                                
                                                <label>
                                                    <select name="imp_estado" class="form-control">
                                                        <?php
                                                        if($impuesto[0]->imp_estado == 1){
                                                            ?>
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="0">Inactivo</option>
                                                            <option value="1">Activo</option>                                                           
                                                            <?php
                                                        }
                                                        ?>
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
