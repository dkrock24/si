<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/mesa/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Mesas</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Mesas </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='mesa' method="post">
                                <input type="hidden" class="form-control" id="id_reserva_mesa" name="id_reserva_mesa" placeholder="" value="<?php echo $mesa[0]->id_reserva_mesa; ?>">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_mesa" name="nombre_mesa" placeholder="Nombre Mesa" value="<?php echo $mesa[0]->nombre_mesa; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="descripcion_mesa" name="descripcion_mesa" placeholder="Descripcion Mesa" value="<?php echo $mesa[0]->descripcion_mesa; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="codigo_mesa" name="codigo_mesa" placeholder="Codigo Mesa" value="<?php echo $mesa[0]->codigo_mesa; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Capacidad</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="capacidad_mesa" name="capacidad_mesa" placeholder="Capacidad mesa" value="<?php echo $mesa[0]->capacidad_mesa; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">

                                        <label>
                                                <select name="estado_mesa" class="form-control">
                                                    <?php if($mesa[0]->estado_mesa == 1): ?>
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
                                            <input type="button" name="<?php echo base_url() ?>reservas/mesa/update" data="mesa" class="btn btn-success enviar_data" value="Guardar">
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