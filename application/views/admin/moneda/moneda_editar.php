<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="admin/moneda/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Moneda</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">    
                    <div class="panel-heading menuTop"><i class="fa fa-pencil" style="font-size: 20px;"></i>  Editar Moneda : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                        <div class="panel-body menuContent">        
                    <p> 
                    <form class="form-horizontal" name="moneda" id='moneda' method="post">
                        <input type="hidden" value="<?php echo $monedas[0]->id_moneda; ?>" name="id_moneda">
                        <div class="row">

                            <div class="col-lg-6">
                                <!-- Otro -->
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="moneda_nombre" name="moneda_nombre" placeholder="Nombre Moneda" value="<?php echo $monedas[0]->moneda_nombre ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Simbolo</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="moneda_simbolo" name="moneda_simbolo" placeholder="Simbolo" value="<?php echo $monedas[0]->moneda_simbolo ?>">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Alias</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="moneda_alias" name="moneda_alias" placeholder="Alias" value="<?php echo $monedas[0]->moneda_alias ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        
                                        <label>
                                            <select name="moneda_estado" class="form-control">
                                                <?php
                                                if($monedas[0]->moneda_estado == 1){
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
                                    <div class="col-sm-offset-2 col-sm-10">
                                    <input type="button" name="<?php echo base_url() ?>admin/moneda/update" data="moneda" class="btn btn-success enviar_data" value="Guardar">
                                    </div>
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
</section>
