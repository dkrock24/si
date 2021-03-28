
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/pais/dep/<?php echo $dep[0]->pais; ?>" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Lista Departamentos</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Departamento</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel menu_title_bar">

                    <div class="panel-body">
                        <div class="col-lg-6">

                            <div id="" class="panel panel-info">
                                <div class="panel-heading">Editar Departamento : <?php echo $dep[0]->nombre_departamento ?> </div>
                                <p>
                                <form class="form-horizontal" id='update_dep' method="post">
                                    <input type="hidden" value="<?php echo $dep[0]->id_departamento; ?>" name="id_departamento">
                                    <input type="hidden" value="<?php echo $dep[0]->id_pais; ?>" name="id_pais">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="codigo_depa" name="codigo_departamento" placeholder="Codigo Departamento" value="<?php echo $dep[0]->codigo_departamento ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_dep" name="nombre_departamento" placeholder="Nombre menu" value="<?php echo $dep[0]->nombre_departamento ?>">
                                            <p class="help-block">Nombre dep.</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Zona</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="zona_depa" name="zona_departamento" placeholder="Zona Departamento" value="<?php echo $dep[0]->zona_departamento ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">

                                            <label>
                                                <select name="estado_departamento" class="form-control">
                                                    <?php
                                                    if ($dep[0]->estado_departamento == 1) {
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
                                            <input type="button" name="<?php echo base_url() ?>admin/pais/update_dep" data="update_dep" class="btn btn-success enviar_data" value="Guardar">
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