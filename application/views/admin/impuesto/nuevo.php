<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Impuesto</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Nuevo Impuesto</div>
                    <div class="menuContent">
                    <div class="b">    
                        <div class="panel-heading"></div>
                        <form class="form-horizontal" name="impuesto" action='save' method="post">
                            <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; 
                                                        ?>" name="id_submenu">
                            <div class="row">


                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Nombre Impuesto</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Impuesto" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Porcentaje Impuesto</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <input type="text" class="form-control" id="porcentaje" name="porcentaje" placeholder="Porcentaje" value="0.00<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Suma - Resta - Nada</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="suma_resta_nada" name="suma_resta_nada">
                                                <option value="1">Si</option>
                                                <option value="2">No</option>
                                                <option value="3">Nada</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Aplicar a Producto</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="aplicar_a_producto" name="aplicar_a_producto">
                                                <option value="1">Si</option>
                                                <option value="2">No</option>
                                                <option value="3">Nada</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Aplicar a Cliente</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="aplicar_a_cliente" name="aplicar_a_cliente">
                                                <option value="1">Si</option>
                                                <option value="2">No</option>
                                                <option value="3">Nada</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Aplicar a Proveedor</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="aplicar_a_proveedor" name="aplicar_a_proveedor">
                                                <option value="1">Si</option>
                                                <option value="2">No</option>
                                                <option value="3">Nada</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> GBE</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="aplicar_a_grab_brut_exent" name="aplicar_a_grab_brut_exent">
                                                <option value="1">Si</option>
                                                <option value="2">No</option>
                                                <option value="3">Nada</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Es Impuesto Especial para ser calculado a categorias especificas = Si</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="especial" name="especial">
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6" style="border-left:1px solid grey;">

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Es Impuesto Excluyente para ser calculado en general = Si</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="excluyente" name="excluyente">
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Tendra Impuesto Condicion para ser evaluada = Si</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <select class="form-control" id="condicion" name="condicion">
                                                <option value="0">No</option>
                                                <option value="1">Si</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Si Condicon es Si, poner simbolo para comparar</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <input type="text" class="form-control" id="c_simbolo" name="c_simbolo" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Si Condicon es Si, poner valor para comparar</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <input type="text" class="form-control" id="c_valor" name="c_valor" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Mensaje Interno para la condicion</label>
                                        <div class="col-sm-7 col-sm-off-1">
                                            <input type="text" class="form-control" id="mensaje" name="mensaje" value="<?php //echo $onMenu[0]->url_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <label>
                                                <select name="imp_estado" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer text-right">
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="submit" class="btn btn-info">Guardar</button>
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