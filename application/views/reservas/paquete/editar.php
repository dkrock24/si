<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/paquete/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Paquete</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Nuevo Paquete </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <form class="form-horizontal" id='paquete' method="post" enctype="multipart/form-data">
                                <div class="col-lg-6">
                                    <input type="hidden" name="id_reserva_paquete" value="<?php echo $paquete[0]->id_reserva_paquete; ?>">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputEmail3" class="">Nombre</label>
                                            <input type="text" class="form-control" id="nombre_paquete" name="nombre_paquete" placeholder="Nombre Paquete" value="<?php echo $paquete[0]->nombre_paquete; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputEmail3" class="">Precio</label>
                                            <input type="number" class="form-control" id="precio_paquete" name="precio_paquete" placeholder="Precio Paquete" value="<?php echo $paquete[0]->precio_paquete; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputEmail3" class="control-label no-padding-right">Descripcion</label>
                                            <textarea class="form-control" id="descripcion_paquete" name="descripcion_paquete"><?php echo $paquete[0]->descripcion_paquete; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputEmail3" class="">Imagen Paquete</label>
                                            <input type="file" class="form-control" id="imagen_paquete" name="imagen_paquete">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputEmail3" class="">Limite Persona</label>
                                            <input type="text" class="form-control" id="limite_personas" name="limite_personas" placeholder="Limite Personas" value="<?php echo $paquete[0]->limite_personas; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <?php
                                            $habitacion = $paquete[0]->habitacion ? 'checked' : '';
                                            ?>
                                            <input type="checkbox" <?php echo $habitacion; ?> id="habitacion" name="habitacion" value="1">
                                            <label for="inputEmail3">Habitación</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <?php
                                            $estadia_paquete = $paquete[0]->estadia_paquete ? 'checked' : '';
                                            ?>
                                            <input type="checkbox" <?php echo $estadia_paquete; ?> id="estadia_paquete" name="estadia_paquete" value="1">
                                            <label for="inputEmail3" class="">Estadia</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <?php
                                            $check_comida = $paquete[0]->comida_paquete ? 'checked' : '';
                                            ?>
                                            <input type="checkbox" <?php echo $check_comida; ?> id="comida_paquete" name="comida_paquete" value="1">
                                            <label for="inputEmail3" class="">Comida</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10">

                                            <label>
                                                <select name="estado_reserva_paquete" class="form-control">
                                                    <?php if ($paquete[0]->estado_reserva_paquete == 7) : ?>
                                                        <option value="7">Activo</option>
                                                        <option value="8">Inactivo</option>
                                                    <?php else : ?>
                                                        <option value="8">Inactivo</option>
                                                        <option value="7">Activo</option>
                                                    <?php endif ?>
                                                </select>
                                            </label>
                                            <input type="button" name="<?php echo base_url() ?>reservas/paquete/update" data="paquete" class="btn btn-success enviar_data" value="Guardar">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php if ($paquete[0]->imagen_tipo) : ?>
                                                <img src="data: <?php echo $paquete[0]->imagen_tipo ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($paquete[0]->imagen_paquete) ?>" clas="preview_producto" style="width:80%;" />
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>