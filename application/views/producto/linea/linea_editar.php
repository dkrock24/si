<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">                
            <a name="producto/linea/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Lista Linea</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Editar</button>
        </h3>
        
        <!-- START table-responsive-->
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">  
                    <div class="panel-heading menuTop">Editar Linea </div>
                    <div class="panel-body menuContent">    
                        <div class="row">
                            <div class="col-lg-6">    
                                <form class="form-horizontal" id='linea' name="linea" method="post">
                                    <input type="hidden" name="id_linea" value="<?php echo $lineas[0]->id_linea; ?>">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tipo</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="tipo_producto" name="tipo_producto" value="<?php echo $lineas[0]->tipo_producto ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="descripcion_tipo_producto" name="descripcion_tipo_producto" value="<?php echo $lineas[0]->descripcion_tipo_producto ?>">
                                        </div>
                                    </div>                                     

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="estado_linea" class="form-control">
                                                    <?php
                                                    if ($lineas[0]->estado_linea == 0) {
                                                        ?>
                                                        <option value="0">Inactivo</option>
                                                        <option value="1">Activo</option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>                                                                        
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                        <input type="button" name="<?php echo base_url() ?>producto/linea/update" data="linea" class="btn btn-warning enviar_data" value="Guardar">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>                                    
            </div>
        </div>
    </div>
</section>
