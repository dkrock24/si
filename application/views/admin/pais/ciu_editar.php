<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/pais/ciu/<?php echo $ciu[0]->departamento ?>" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Municipios</button></a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel menu_title_bar">

                    <div class="panel-body">
                        <div class="col-lg-6">

                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Editar Ciudad : <?php echo $ciu[0]->nombre_ciudad ?> </div>
                                <p>
                                <form class="form-horizontal" id='update_ciu' method="post">
                                    <input type="hidden" value="<?php echo $ciu[0]->id_ciudad; ?>" name="id_ciu">
                                    <input type="hidden" value="<?php echo $ciu[0]->departamento; ?>" name="departamento">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_ciu" name="codigo_ciu" placeholder="Codigo Ciudad" value="<?php echo $ciu[0]->codigo_ciudad ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_ciu" name="nombre_ciu" placeholder="Nombre Ciudad" value="<?php echo $ciu[0]->nombre_ciudad ?>">
                                            <p class="help-block">Nombre Ciudad.</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="estado_ciu" class="form-control">
                                                    <?php
                                                    if ($ciu[0]->estado_ciudad == 1) {
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
                                            <input type="button" name="<?php echo base_url() ?>admin/pais/update_ciu" data="update_ciu" class="btn btn-success enviar_data" value="Guardar">
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