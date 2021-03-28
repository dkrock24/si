<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/impresor/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Impresor</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>

        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop"><i class="fa fa-print" style="font-size: 20px;"></i> Crear Impresor </div>
                    <div class="panel-body menuContent">
                        <p>
                            <form class="form-horizontal" id="impresor">
                            <input type="hidden" name="id_impresor" value="<?php echo $impresor[0]->id_impresor ?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="impresor_nombre" name="impresor_nombre" value="<?php echo $impresor[0]->impresor_nombre ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="impresor_descripcion" name="impresor_descripcion" value="<?php echo $impresor[0]->impresor_descripcion ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Color</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="impresor_color" name="impresor_color" value="<?php echo $impresor[0]->impresor_color ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Modelo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="impresor_modelo" name="impresor_modelo" value="<?php echo $impresor[0]->impresor_modelo ?>">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Marca</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="impresor_marca" name="impresor_marca" value="<?php echo $impresor[0]->impresor_marca ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Url</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="impresor_url" name="impresor_url" value="<?php echo $impresor[0]->impresor_url ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">

                                                <label>
                                                    <select name="impresor_estado" class="form-control">
                                                        <?php if($impresor[0]->impresor_estado  ==1 ) : ?>
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                        <?php else: ?>
                                                            <option value="0">Inactivo</option>
                                                            <option value="1">Activo</option>
                                                        <?php endif ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                            <input type="button" name="<?php echo base_url() ?>admin/impresor/update" data="impresor" class="btn btn-success enviar_data" value="Guardar">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>