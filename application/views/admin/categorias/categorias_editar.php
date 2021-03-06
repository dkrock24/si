
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">            
        
        <h3 style="height: 50px; font-size: 13px;">  
            <a name="admin/categorias/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Categorias</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                           
                <div id="panelDemo10" class="panel menu_title_bar">   
                    <div class="panel-heading menuTop">Editar Categoria </div>
                        <div class="panel-body menuContent">  
                             <div class="row">
                                <div class="col-lg-6">
                                <form class="form-horizontal" id='categoria'>
                                <input type="hidden" value="<?php echo $categorias[0]->id_categoria; ?>" name="id_categoria">
                                
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Giro</label>
                                    <div class="col-sm-10">
                                        <select name="codigo_giro" class="form-control">
                                        <option value="<?php echo $categorias[0]->id_giro ?>"><?php echo $categorias[0]->nombre_giro ?></option>
                                            <?php
                                            foreach ($giros as $g) {
                                                if($g->id_giro != $categorias[0]->id_giro){
                                                ?>
                                                <option value="<?php echo $g->id_giro ?>"><?php echo $g->nombre_giro ?></option>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categoria1</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="categoria_padre" name="nombre_categoria" placeholder="Nombre" value="<?php echo $categorias[0]->nombre_categoria; ?>">
                                    </div>
                                </div>   
                            

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Empresa</label>
                                    <div class="col-sm-10">
                                        
                                        <select class="form-control" id="Empresa" name="Empresa" >
                                            <option value="<?php echo $categorias[0]->Empresa ?>"><?php echo $categorias[0]->nombre_comercial ?></option>
                                            <?php
                                            /*foreach ($empresa as $key => $value) {
                                                if($categorias[0]->Empresa != $value->id_empresa){
                                                ?>
                                                <option value="<?php echo $value->id_empresa ?>"><?php echo $value->nombre_comercial ?></option>
                                                <?php
                                                }
                                            }*/
                                            ?>  
                                        </select>
                                        
                                    </div>
                                </div>   

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categoria2</label>
                                    <div class="col-sm-10">
                                        <select name="categoria_padre" class="form-control">
                                            <?php
                                            if($categorias[0]->id_padre == ''){
                                                ?>
                                                <option value="0">Selecione Categoria</option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="<?php echo $categorias[0]->id_padre ?>"><?php echo $categorias[0]->nombre_padre; ?></option>
                                                <?php
                                            }
                                            ?>
                                            
                                            <?php
                                            if($categorias[0]->id_categoria_padre !=null){
                                                foreach ($categorias_padres as $value) {
                                                if($categorias[0]->id_padre != $value->id_categoria){
                                                    ?>
                                                    <option value="<?php echo $value->id_categoria ?>"><?php echo $value->nombre_categoria; ?></option>
                                                    <?php
                                                    }
                                                }
                                            }                                                    
                                            ?>
                                        </select>   
                                                                                  
                                    </div>
                                </div>                                        


                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                    <label>
                                        <select name="categoria_estado" class="form-control">
                                            <?php
                                            if ($categorias[0]->categoria_estado == 1) {
                                                ?>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            <?php
                                            } else {
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
                                    <input type="button" name="<?php echo base_url() ?>admin/categorias/update" data="categoria" class="btn btn-success enviar_data" value="Guardar">
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
