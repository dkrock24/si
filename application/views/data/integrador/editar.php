<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">  
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="data/integrador/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin"> 
                <button type="button" class="mb-sm btn btn-success"> Integracion</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>

        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">    
                                 
                    <div class="panel-heading menuTop"><i class="fa fa-bars" style="font-size: 20px;"></i> Editar Integracion <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="panel-body menuContent">        
                        <p> 
                        <form class="form-horizontal" id="integrador" method="post">
                        <input type="hidden" name="id_integrador" value="<?php echo $integrador[0]->id_integrador ?>" />
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_integrador" name="nombre_integrador" placeholder="Nombre Integrador" value="<?php echo $integrador[0]->nombre_integrador ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">URL</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="url_integrador" name="url_integrador" placeholder="Url" value="<?php echo $integrador[0]->url_integrador ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Metodo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="metodo" name="metodo" placeholder="Metodo" value="<?php echo $integrador[0]->metodo ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Parametro</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="parametro1" name="parametro1" placeholder="Parametro" value="<?php echo $integrador[0]->parametro1 ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Sucursal</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="sucursal" name="sucursal" placeholder="Sucursal" value="<?php echo $integrador[0]->sucursal ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">ACCION</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="accion_integrador" name="accion_integrador" placeholder="Accion" value="<?php echo $integrador[0]->accion_integrador ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            
                                            <label>
                                                <select name="estado_integrador" class="form-control">
                                                    <?php
                                                        if($integrador[0]->estado_integrador == 1){
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
                                            <input type="button" name="<?php echo base_url() ?>data/integrador/update" data="integrador" class="btn btn-success enviar_data" value="Guardar">
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
