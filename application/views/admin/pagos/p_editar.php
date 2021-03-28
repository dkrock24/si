<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/pagos/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Pagos</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>

        </h3>

        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop"><i class="fa fa-bars" style="font-size: 20px;"></i> Editar Forma Pago <?php //echo $pagos[0]->id_modo_pago 
                                                                                                                                ?> </div>
                    <div class="panel-body menuContent">
                        <p>
                            <form class="form-horizontal" id="pagos">
                            <input type="hidden" class="form-control" id="id_modo_pago" name="id_modo_pago" placeholder="Nombre" value="<?php echo $pagos[0]->id_modo_pago ?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nombre_modo_pago" name="nombre_modo_pago" placeholder="Nombre" value="<?php echo $pagos[0]->nombre_modo_pago ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="codigo_modo_pago" name="codigo_modo_pago" placeholder="Codigo" value="<?php echo $pagos[0]->codigo_modo_pago ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="descripcion_modo_pago" name="descripcion_modo_pago" placeholder="Descripcion" value="<?php echo $pagos[0]->descripcion_modo_pago ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Valor</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="valor_modo_pago" name="valor_modo_pago" placeholder="Descripcion" value="<?php echo $pagos[0]->valor_modo_pago ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">

                                                <label>
                                                    <select name="estado_modo_pago" class="form-control">
                                                        <?php
                                                        if ($pagos[0]->estado_modo_pago == 1) {
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
                                            <input type="button" name="<?php echo base_url() ?>admin/pagos/update" data="pagos" class="btn btn-success enviar_data" value="Guardar">
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