<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/impuesto/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Impuesto</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>

        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Impuesto : <?php //echo $onMenu[0]->nombre_submenu 
                                                                            ?> </div>
                    <div class="menuContent">
                        <div class="b">
                            <div class="panel-heading"></div>
                            <form class="form-horizontal" id="impuesto">
                                <input type="hidden" value="<?php echo $impuesto[0]->id_tipos_impuestos; ?>" name="id_tipos_impuestos">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Nombre Impuesto</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <input type="text" required class="form-control" id="nombre" name="nombre" placeholder="Nombre Impuesto" value="<?php echo $impuesto[0]->nombre ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Porcentaje Impuesto</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <input type="text" required class="form-control" id="porcentage" name="porcentage" placeholder="Porcentage" value="<?php echo $impuesto[0]->porcentage ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Suma - Resta - Nada</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="suma_resta_nada" name="suma_resta_nada">
                                                    <?php
                                                    if ($impuesto[0]->suma_resta_nada == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else if ($impuesto[0]->suma_resta_nada == 2) {
                                                    ?>
                                                        <option value="2">No</option>
                                                        <option value="1">Si</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else {
                                                    ?>
                                                        <option value="3">Nada</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>

                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Aplicar a Producto</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="aplicar_a_producto" name="aplicar_a_producto">
                                                    <?php
                                                    if ($impuesto[0]->aplicar_a_producto == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else if ($impuesto[0]->aplicar_a_producto == 2) {
                                                    ?>
                                                        <option value="2">No</option>
                                                        <option value="1">Si</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else {
                                                    ?>
                                                        <option value="3">Nada</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>

                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Aplicar a Cliente</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="aplicar_a_cliente" name="aplicar_a_cliente">
                                                    <?php
                                                    if ($impuesto[0]->aplicar_a_cliente == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else if ($impuesto[0]->aplicar_a_cliente == 2) {
                                                    ?>
                                                        <option value="2">No</option>
                                                        <option value="1">Si</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else {
                                                    ?>
                                                        <option value="3">Nada</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>

                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Aplicar a Proveedor</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="aplicar_a_proveedor" name="aplicar_a_proveedor">
                                                    <?php
                                                    if ($impuesto[0]->aplicar_a_proveedor == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else if ($impuesto[0]->aplicar_a_proveedor == 2) {
                                                    ?>
                                                        <option value="2">No</option>
                                                        <option value="1">Si</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else {
                                                    ?>
                                                        <option value="3">Nada</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> GBE</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="aplicar_a_grab_brut_exent" name="aplicar_a_grab_brut_exent">
                                                    <?php
                                                    if ($impuesto[0]->aplicar_a_proveaplicar_a_grab_brut_exentedor == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else if ($impuesto[0]->aplicar_a_grab_brut_exent == 2) {
                                                    ?>
                                                        <option value="2">No</option>
                                                        <option value="1">Si</option>
                                                        <option value="3">Nada</option>
                                                    <?php

                                                    } else {
                                                    ?>
                                                        <option value="3">Nada</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Es Impuesto Especial para ser calculado a categorias especificas = Si</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="especial" name="especial">
                                                    <?php
                                                    if ($impuesto[0]->especial  == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6" style="border-left:1px solid grey;">

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Es Impuesto Excluyente para ser calculado en general = Si</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="excluyente" name="excluyente">
                                                    <?php
                                                    if ($impuesto[0]->excluyente  == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Tendra Impuesto Condicion para ser evaluada = Si</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" id="condicion" name="condicion">
                                                    <?php
                                                    if ($impuesto[0]->condicion  == 1) {
                                                    ?>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Si Condicon es Si, poner simbolo para comparar</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <input type="text" class="form-control" id="c_simbolo" name="c_simbolo" value="<?php echo $impuesto[0]->condicion_simbolo ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Si Condicon es Si, poner valor para comparar</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <input type="text" class="form-control" id="c_valor" name="c_valor" value="<?php echo $impuesto[0]->condicion_valor ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Mensaje Interno para la condicion</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <input type="text" class="form-control" id="mensaje" name="mensaje" value="<?php echo $impuesto[0]->mensaje ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"><i class="fa fa-info-circle"></i> Marcalo si el impuesto es para combustible</label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select class="form-control" name="es_combustible">
                                                    <?php if($impuesto[0]->es_combustible == 1): ?>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                    <?php else: ?>
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>
                                                    <?php endif ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-offset-1 col-sm-3"></label>
                                            <div class="col-sm-7 col-sm-off-1">
                                                <select name="imp_estado" class="form-control">
                                                    <?php
                                                    if ($impuesto[0]->imp_estado == 1) {
                                                    ?>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="0">Inactivo</option>
                                                        <option value="1">Activo</option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer text-right">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                        <input type="button" name="<?php echo base_url() ?>admin/impuesto/update" data="impuesto" class="btn btn-success enviar_data" value="Guardar">
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
    </div>
</section>