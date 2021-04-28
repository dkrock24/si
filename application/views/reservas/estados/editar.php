<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/estado/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Estado</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Estado </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='estado' method="post">
                                     <input type="hidden" name="id_reserva_estados" value="<?php echo $estados[0]->id_reserva_estados ?>">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_reserva_estados" name="nombre_reserva_estados" placeholder="Nombre Estado" value="<?php echo $estados[0]->nombre_reserva_estados ?>">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">

                                            <label>
                                                <select name="estado" class="form-control">
                                                    <?php if($estados[0]->estado == 1): ?>
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
                                            <input type="button" name="<?php echo base_url() ?>reservas/estado/update" data="estado" class="btn btn-success enviar_data" value="Guardar">
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