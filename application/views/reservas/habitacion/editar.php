<!-- Main section-->
<style>
    .input-check {
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/habitacion/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Habitacion</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Habitación </div>
                    <div class="panel-body menuContent">
                        <form class="form-horizontal" id='habitacion' method="post">
                        <div class="row">
                            <div class="col-lg-6">
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
                                                    <?php if($habitacion[0]->estado_habitacion == 7): ?>
                                                    <option value="7">Activo</option>
                                                    <option value="8">Inactivo</option>
                                                    <?php else: ?>
                                                    <option value="8">Inactivo</option>
                                                    <option value="7">Activo</option>
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
                            </div>

                            <div class="col-lg-6">
                                    <table class="table">
                                    <tr>
                                        <td>#</td>
                                        <td>Articulo Habitacion</td>
                                        <td>Modelo</td>
                                        <td>Cantidad</td>
                                    </tr>
                                    <?php
                                    $cc = 0;
                                    $existentes = [];
                                    if( $articulos ){
                                        foreach ($articulos as $key => $articulo) {

                                            if ($habitacion_articulos) {
                                                foreach ($habitacion_articulos as $key => $ha) {
                                                    if ($ha->articulo == $articulo->id_reserva_articulo) {
                                                        $existentes[] = $ha->articulo;
                                                        ?>
                                                        <tr>
                                                            <td class="box-padding">
                                                                <input type="checkbox" checked class="input-check" name="articulo-<?php echo $cc; ?>" value="<?php echo $articulo->id_reserva_articulo; ?>">
                                                            </td>
                                                            <td><?php echo $articulo->nombre_articulo; ?></td>
                                                            <td><?php echo $articulo->modelo_articulo; ?></td>
                                                            <td>
                                                                <input type="number" name="cantidad-<?php echo $key; ?>" value="1">
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                            }

                                            $diferente = in_array($articulo->id_reserva_articulo , $existentes);
                                            if (empty($diferente)) {
                                                ?>
                                                <tr>
                                                    <td class="box-padding">
                                                        <input type="checkbox" class="input-check" name="articulo-<?php echo $key; ?>" value="<?php echo $articulo->id_reserva_articulo; ?>">
                                                    </td>
                                                    <td><?php echo $articulo->nombre_articulo; ?></td>
                                                    <td><?php echo $articulo->modelo_articulo; ?></td>
                                                    <td>
                                                        <input type="number" name="cantidad-<?php echo $key; ?>" value="1">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    </table>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>