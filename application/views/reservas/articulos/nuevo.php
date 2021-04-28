<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/estado/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Estado</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nuevo</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Nuevo Articulo </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-6">
                                <form class="form-horizontal" id='articulo' method="post">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nombre_articulo" name="nombre_articulo" placeholder="Nombre Articulo" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="descripcion_articulo" name="descripcion_articulo" placeholder="Descripcion Articulo" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Marca</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="marca_articulo" name="marca_articulo" placeholder="Marca Articulo" value="">

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Modelo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="modelo_articulo" name="modelo_articulo" placeholder="Modelo Articulo" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Tamaño</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="tamano_articulo" name="tamano_articulo" placeholder="Tamaño Articulo" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Color</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="color_articulo" name="color_articulo" placeholder="Color Articulo" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Codigo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="codigo_articulo" name="codigo_articulo" placeholder="Codigo Articulo" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">

                                            <label>
                                                <select name="estado_articulo" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="button" name="<?php echo base_url() ?>reservas/articulo/crear" data="articulo" class="btn btn-success enviar_data" value="Guardar">
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