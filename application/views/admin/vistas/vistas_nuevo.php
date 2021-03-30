<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/vistas/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Vistas</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div id="panelDemo10" class="panel panel-info menu_title_bar">
                            <div class="panel-heading">Nuevo Vista : </div>
                            <div class="panel-body">
                                <p>
                                <form class="form-horizontal" id='vistas' method="post">
                                    <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; 
                                                                ?>" name="id_submenu">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="vista_nombre" name="vista_nombre" placeholder="Nombre Vista" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="vista_codigo" name="vista_codigo" placeholder="Codigo Vista" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Accion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="vista_accion" name="vista_accion" placeholder="Accion Vista" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="vista_descripcion" name="vista_descripcion" placeholder="Descripcion Vista" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="vista_url" name="vista_url" placeholder="Url Vista" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="vista_estado" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="button" name="<?php echo base_url() ?>admin/vistas/crear" data="vistas" class="btn btn-success enviar_data" value="Guardar">
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