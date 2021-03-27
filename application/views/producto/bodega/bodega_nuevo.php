<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">                
            <a name="producto/bodega/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Lista Bodegas</button> 
        </a> 
        <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
        </h3>
        
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop"><i class="fa fa-bars" style="font-size: 20px;"></i> Crear Bodega <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="menuContent">  
                        <div class="b">    
                            <div class="panel-heading"></div>
                            </p>
                            <form class="form-horizontal" id='bodega' method="post">
                                <div class="row">
                                    <div class="col-lg-6">                
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" id="nombre_bodega" name="nombre_bodega" value="<?php //echo $roles[0]->role ?>">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Direccion</label>
                                            <div class="col-sm-10">
                                                <input type="text" required class="form-control" id="direccion_bodega" name="direccion_bodega" value="<?php //echo $roles[0]->pagina ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Encargado</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="encargado_bodega" name="encargado_bodega" value="<?php //echo $roles[0]->pagina ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Sucursal</label>
                                            <div class="col-sm-10">
                                                <select name="Sucursal" class="form-control">
                                                    <?php
                                                    if(isset($sucursal)){
                                                        foreach ($sucursal as $sucursales) {
                                                            ?>
                                                            <option value="<?php echo $sucursales->id_sucursal; ?>"><?php echo $sucursales->nombre_sucursal; ?></option>
                                                            <?php
                                                        }
                                                    }else{
                                                        ?>
                                                        <option value="">No Hay Sucursal</option>
                                                        <?php
                                                    }                                   
                                                    ?>
                                                </select>                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Principal</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="predeterminada_bodega">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>                                                            
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <label>
                                                    <select name="bodega_estado" class="form-control">
                                                        <option value="0">Inactivo</option>
                                                        <option value="1">Activo</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                        <input type="button" name="<?php echo base_url() ?>producto/bodega/crear" data="bodega" class="btn btn-success enviar_data" value="Guardar">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
