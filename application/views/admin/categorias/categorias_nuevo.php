<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">            
        
        <h3 style="height: 50px; font-size: 13px;">  
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Categorias</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
            
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-white">

                
                        <div class="panel-body">
                                    <div class="col-lg-6">
                            <div id="" class="panel panel-default">
                                <div class="panel-heading">Nueva Categoria <a href="<?php echo base_url().'producto/producto/nuevo' ?>" style='float: right;' class="btn btn-primary"><i class="fa fa-arrow-left"></i> Producto</a></div>
                                    <p>
                                    <form class="form-horizontal" action='crear' method="post">
                                        <input type="hidden" value="<?php //echo $dep; ?>" name="id_departamento">
                                        
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categoria1</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="categoria_padre" name="nombre_categoria" placeholder="Nombre" value="">
                                                <p class="help-block">Categoria / Sub Categoria.</p>
                                            </div>
                                        </div>   
                                        
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Imagen</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="img_cate" name="img_cate" placeholder="Tipo" value="">
                                                <p class="help-block">Imagen Categoria.</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Empresa</label>
                                            <div class="col-sm-10">
                                                
                                                <select class="form-control" id="Empresa" name="Empresa" >
                                                    <?php
                                                    foreach ($empresa as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id_empresa ?>"><?php echo $value->nombre_comercial ?></option>
                                                        <?php
                                                    }
                                                    ?>  
                                                </select>
                                                <p class="help-block">Empresa Nombre</p>
                                            </div>
                                        </div>                                        

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categoria2</label>
                                            <div class="col-sm-10">
                                                <select name="categoria_padre" class="form-control">
                                                    <option value="0">Selecione Categoria</option>
                                                    <?php
                                                    foreach ($categorias as $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id_categoria ?>"><?php echo $value->nombre_categoria; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>   
                                                <p class="help-block">Categoria.</p>                                             
                                            </div>
                                        </div>                                        


                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                
                                                <label>
                                                    <select name="categoria_estado" class="form-control">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>              
                                                    </select>
                                                </label>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Guardar</button>
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
    </div>
</section>
