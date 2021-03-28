<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a href="../index" style="top: -12px;position: relative; text-decoration: none"><a name="admin/pais/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                    <button type="button" class="mb-sm btn btn-success"> Pais</button> </a>
                <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Pais : <?php echo $pais[0]->nombre_pais ?> </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='pais' method="post">
                                    <input type="hidden" value="<?php echo $pais[0]->id_pais; ?>" name="id_pais">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_pais" name="nombre_pais" placeholder="Nombre menu" value="<?php echo $pais[0]->nombre_pais ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="URL" value="<?php echo $pais[0]->zip_code ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Moneda</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" id="moneda_pais" name="moneda_pais" placeholder="ICON">
                                                <?php
                                                foreach ($moneda as $value) {
                                                    if ($pais[0]->id_moneda == $value->id_moneda) {
                                                ?>
                                                        <option value="<?php echo  $value->id_moneda; ?>"><?php echo $value->moneda_nombre . ' ' . $value->moneda_alias; ?></option>
                                                    <?php
                                                    }
                                                }
                                                foreach ($moneda as $value) {
                                                    if ($pais[0]->id_moneda != $value->id_moneda) {
                                                    ?>
                                                        <option value="<?php echo  $value->id_moneda; ?>"><?php echo $value->moneda_nombre . ' ' . $value->moneda_alias; ?></option>
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
                                                <select name="estado_pais" class="form-control">
                                                    <?php
                                                    if ($pais[0]->estado_pais == 1) {
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
                                            <input type="button" name="<?php echo base_url() ?>admin/pais/crear" data="pais" class="btn btn-success enviar_data" value="Guardar">
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