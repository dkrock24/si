<!-- Main section-->
<style>
    .input-check {
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    .table thead tr th{
        color: #fff;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/habitacion/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Habitación</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Nuevo Habitación </div>
                    <div class="panel-body menuContent">
                        <form class="form-horizontal" id='habitacion' method="post">
                            <div class="row">
                                <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nombre_habitacion" name="nombre_habitacion" placeholder="Nombre Habitación" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="descripcion_habitacion" name="descripcion_habitacion" placeholder="Descripcion Habitación" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="codigo_habitacion" name="codigo_habitacion" placeholder="Codigo" value="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Precio Base</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="precio_base_habitacion" name="precio_base_habitacion" placeholder="Precio Base" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Precio Estimado</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="precio_estimado_habitacion" name="precio_estimado_habitacion" placeholder="Precio Estimado" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Precio Tiempo</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="precio_tiempo_habitacion" name="precio_tiempo_habitacion" placeholder="Precio Tiempo" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tamaño Habitación</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tamano_habitacion" name="tamano_habitacion" placeholder="Tamaño Habitación" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Capacidad Habitación</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="capacidad_habitacion" name="capacidad_habitacion" placeholder="Capacidad Habitación" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">

                                                <label>
                                                    <select name="estado_habitacion" class="form-control">
                                                        <option value="7">Activo</option>
                                                        <option value="8">Inactivo</option>
                                                    </select>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="button" name="<?php echo base_url() ?>reservas/habitacion/crear" data="habitacion" class="btn btn-success enviar_data" value="Guardar">
                                            </div>
                                        </div>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table">
                                    <thead style="background:#4974a7;">
                                        <tr>
                                            <th>#</th>
                                            <th>Articulo Habitación</th>
                                            <th>Modelo</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if($articulos) {
                                        foreach ($articulos as $key => $articulo) {
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