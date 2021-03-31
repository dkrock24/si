<!-- Main section-->
<style type="text/css">
    .preview_producto {
        width: 50%;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/cargo/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Cargos</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

        </h3>
        <div class="row">
            <div class="col-lg-6">

                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop"><i class="fa fa-user" style="font-size:22px;color:grey;"></i> Nuevo Cargo Laboral :  </div>
                    <form class="form-horizontal" enctype="multipart/form-data" id="cargo" name="cargo" method="post">
                    <div class="menuContent">
                        <div class="b">
                                <input type="hidden" value="<?php   ?>" name="id_submenu">

                                <div class="row">

                                    <div class="col-lg-12">

                                            <div class="panel-heading">
                                                <br>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Nombre</label>
                                                <div class="col-sm-9">
                                                    <input type="text" required class="form-control" id="cargo_laboral" name="cargo_laboral" placeholder="Nombre" value="<?php //echo $onMenu[0]->nombre_submenu 
                                                                                                                                                                ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Descripción</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="descripcion_cargo_laboral" name="descripcion_cargo_laboral" placeholder="Descripcion" value="<?php //echo $onMenu[0]->url_submenu 
                                                                                                                                                                                                ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Salario</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="salario_mensual_cargo_laboral" name="salario_mensual_cargo_laboral" placeholder="Salario" value="<?php //echo $onMenu[0]->icon_submenu 
                                                                                                                                                                                                    ?>">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">

                                                    <label>
                                                        <select name="estado" class="form-control">
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                        </select>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="panel-footer text-right">
                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-9">
                                                        <input type="button" name="<?php echo base_url() ?>admin/cargo/crear" data="cargo" class="btn btn-warning enviar_data" value="Guardar">                                     
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>