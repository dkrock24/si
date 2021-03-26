<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/sucursal/index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-success"> Lista Sucursales</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="" class="panel menu_title_bar">
                    <div class="panel-heading menuTop"><i class="fa fa-home" style="font-size: 40px;"></i>Editar Sucursal</div>

                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='sucursal' method="post">
                                    <input type="hidden" name="id_sucursal" value="<?php echo $sucursal[0]->id_sucursal; ?>">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="nombre_sucursal" name="nombre_sucursal" value="<?php echo $sucursal[0]->nombre_sucursal ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Direccion</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="direct" name="direct" value="<?php echo $sucursal[0]->direct ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Encargado</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="encargado" name="encargado_sucursal" value="<?php echo $sucursal[0]->encargado_sucursal ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Telefono</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $sucursal[0]->tel ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="tel" name="codigo_sucursal" value="<?php echo $sucursal[0]->codigo_sucursal ?>">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Celular</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="cel" name="cel" value="<?php echo $sucursal[0]->cel ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Empresa</label>
                                        <div class="col-sm-10">
                                            <select name="Empresa_Suc" class="form-control">
                                                <?php

                                                foreach ($empresa as $e) {
                                                    if ($sucursal[0]->Empresa_Suc == $e->id_empresa) {
                                                        ?>
                                                        <option value="<?php echo $e->id_empresa; ?>"><?php echo $e->nombre_comercial; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    foreach ($empresa as $e) {
                                                        if ($sucursal[0]->Empresa_Suc != $e->id_empresa) {
                                                            ?>
                                                        <option value="<?php echo $e->id_empresa; ?>"><?php echo $e->nombre_comercial; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Ciudad</label>
                                        <div class="col-sm-10">
                                            <select name="Ciudad_Suc" class="form-control">
                                                <?php
                                                foreach ($ciudad as $c) {
                                                    if ($sucursal[0]->Ciudad_Suc == $c->id_ciudad) {
                                                        ?>
                                                        <option value="<?php echo $c->id_ciudad; ?>"><?php echo $c->nombre_departamento.' / '. $c->nombre_ciudad; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    foreach ($ciudad as $c) {
                                                        if ($sucursal[0]->Ciudad_Suc != $c->id_ciudad) {
                                                            ?>
                                                        <option value="<?php echo $c->id_ciudad; ?>"><?php echo $c->nombre_departamento.' / '. $c->nombre_ciudad; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="sucursal_estado" class="form-control">
                                                    <?php
                                                    if ($sucursal[0]->sucursal_estado == 1) {
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
                                        <input type="button" name="<?php echo base_url() ?>admin/sucursal/update" data="sucursal" class="btn btn-warning enviar_data" value="Guardar">                                        
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