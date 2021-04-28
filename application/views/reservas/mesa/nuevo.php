<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/mesa/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Mesas</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nuevo</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Nuevo Mesas </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='mesa' method="post">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Mesas a Crear</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" min="1" max="10" id="numero_mesa" name="numero_mesa" placeholder="#" value="1">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_mesa" name="nombre_mesa" placeholder="Nombre Mesa" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="descripcion_mesa" name="descripcion_mesa" placeholder="Descripcion Mesa" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="codigo_mesa" name="codigo_mesa" placeholder="Codigo Mesa" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Incrementar Codigo</label>
                                        <div class="col-sm-9">
                                            <label>
                                                <select name="incrementar" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>
                                            </label>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Capacidad</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="capacidad_mesa" name="capacidad_mesa" placeholder="Capacidad mesa" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">

                                            <label>
                                                <select name="estado_mesa" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="button" name="<?php echo base_url() ?>reservas/mesa/crear" data="mesa" class="btn btn-success enviar_data" value="Guardar">
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