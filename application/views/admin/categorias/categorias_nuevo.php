
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/categorias/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn  btn-success"> Categorias</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

        </h3>
        <div class="row">

            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Nueva Categoria <a href="<?php echo base_url() . 'producto/producto/nuevo' ?>" style='float: right;' class="btn btn-primary"><i class="fa fa-arrow-left"></i> Producto</a></div>

                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='categoria'>
                                    <input type="hidden" value="<?php //echo $dep; ?>" name="id_departamento">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Giro</label>
                                        <div class="col-sm-8">
                                            <select name="codigo_giro" class="form-control">
                                                <?php
                                                if(isset($giros)){                                                
                                                    foreach ($giros as $g) {
                                                        ?>
                                                        <option value="<?php echo $g->id_giro ?>"><?php echo $g->nombre_giro ?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                        <option value="">No Hay Giro</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categoria1</label>
                                        <div class="col-sm-8">
                                            <input type="text" required class="form-control" id="categoria_padre" name="nombre_categoria" placeholder="Nombre" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categoria2</label>
                                        <div class="col-sm-8">
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
                                            <input type="button" name="<?php echo base_url() ?>admin/categorias/crear" data="categoria" class="btn btn-success enviar_data" value="Guardar">
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