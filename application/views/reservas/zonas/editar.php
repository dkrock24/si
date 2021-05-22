<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/zona/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Lista</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Ediatr Estadia / Evento </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='zona' method="post">
                                <input type="hidden" class="form-control" id="id_reserva_zona" name="id_reserva_zona" placeholder="" value="<?php echo $zona[0]->id_reserva_zona; ?>">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_zona" name="nombre_zona" placeholder="" value="<?php echo $zona[0]->nombre_zona; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="descripcion_zona" name="descripcion_zona" placeholder="" value="<?php echo $zona[0]->descripcion_zona; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Marca</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="ubicacion_zona" name="ubicacion_zona" placeholder="" value="<?php echo $zona[0]->ubicacion_zona; ?>">

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Capacidad</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="capacidad_zona" name="capacidad_zona" placeholder="" value="<?php echo $zona[0]->capacidad_zona; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Precio</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="precio_zona" name="precio_zona" placeholder="" value="<?php echo $zona[0]->precio_zona; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Evento</label>
                                        <div class="col-sm-10">
                                            <?php
                                            $check = $zona[0]->evento == 1 ? 'checked' : '';
                                            ?>
                                            <input type="checkbox" <?php echo $check; ?> id="precio_zona" name="evento" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="codigo_zona" name="codigo_zona" placeholder="" value="<?php echo $zona[0]->codigo_zona; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">

                                            <label>
                                                <select name="estado_zona" class="form-control">
                                                    <?php if($zona[0]->estado_zona == 1): ?>
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
                                            <input type="button" name="<?php echo base_url() ?>reservas/zona/update" data="zona" class="btn btn-success enviar_data" value="Guardar">
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