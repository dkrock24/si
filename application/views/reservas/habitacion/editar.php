<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/habitacion/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Habitacion</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Nuevo Habitacion </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='habitacion' method="post">
                                    <input type="hidden" class="form-control" id="id_reserva_habitacion" name="id_reserva_habitacion" placeholder="Nombre Habitacion" value="<?php echo $habitacion[0]->id_reserva_habitacion; ?>">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_habitacion" name="nombre_habitacion" placeholder="Nombre Habitacion" value="<?php echo $habitacion[0]->nombre_habitacion; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="descripcion_habitacion" name="descripcion_habitacion" placeholder="Descripcion Habitacion" value="<?php echo $habitacion[0]->descripcion_habitacion; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="codigo_habitacion" name="codigo_habitacion" placeholder="Codigo" value="<?php echo $habitacion[0]->codigo_habitacion; ?>">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Precio Base</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="precio_base_habitacion" name="precio_base_habitacion" placeholder="Precio Base" value="<?php echo $habitacion[0]->precio_base_habitacion; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Precio Estimado</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="precio_estimado_habitacion" name="precio_estimado_habitacion" placeholder="Precio Estimado" value="<?php echo $habitacion[0]->precio_estimado_habitacion; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Precio Tiempo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="precio_tiempo_habitacion" name="precio_tiempo_habitacion" placeholder="Precio Tiempo" value="<?php echo $habitacion[0]->precio_tiempo_habitacion; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tamaño Habitacion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tamano_habitacion" name="tamano_habitacion" placeholder="Tamaño Habitacion" value="<?php echo $habitacion[0]->tamano_habitacion; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Capacidad Habitacion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="capacidad_habitacion" name="capacidad_habitacion" placeholder="Capacidad Habitacion" value="<?php echo $habitacion[0]->capacidad_habitacion; ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">

                                            <label>
                                                <select name="estado_habitacion" class="form-control">
                                                    <?php if($habitacion[0]->estado_habitacion == 1): ?>
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
                                            <input type="button" name="<?php echo base_url() ?>reservas/habitacion/update" data="habitacion" class="btn btn-success enviar_data" value="Guardar">
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