<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {


    });
</script>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Proveedores</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>

        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Proveedor</div>
                    <div class="menuContent">
                        <form class="form-horizontal" enctype="multipart/form-data" name="cliente" action='../update' method="post">
                            <input type="hidden" value="<?php echo $proveedor[0]->id_proveedor; ?>" name="id_proveedor">
                            <div class="b">
                                <div class="panel-heading"></div>
                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Codigo</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="codigo_proveedor" name="codigo_proveedor" placeholder="Codigo Proveedor" value="<?php echo $proveedor[0]->codigo_proveedor?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="empresa" name="empresa_proveedor" placeholder="Empresa" value="<?php echo $proveedor[0]->empresa_proveedor ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Titular</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="titular_proveedor" name="titular_proveedor" placeholder="NRC" value="<?php echo $proveedor[0]->titular_proveedor ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NRC</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nrc" name="nrc" placeholder="NRC" value="<?php echo $proveedor[0]->nrc ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NIT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nit_empresa" name="nit_empresa" placeholder="NIT" value="<?php echo $proveedor[0]->nit_empresa ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Giro</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="giro" name="giro" placeholder="Giro" value="<?php echo $proveedor[0]->giro ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Direccion Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="direc_empresa" name="direc_empresa" placeholder="Direccion Empresa" value="<?php echo $proveedor[0]->direc_empresa ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Telefono</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="tel_empresa" name="tel_empresa" placeholder="Telefono" value="<?php echo $proveedor[0]->tel_empresa ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Celular</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="cel_empresa" name="cel_empresa" placeholder="Celular" value="<?php echo $proveedor[0]->cel_empresa ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Website</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="website" name="website" placeholder="Website" value="<?php echo $proveedor[0]->website ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-9">
                                                <select id="Persona_Proveedor" name="Persona_Proveedor" class="form-control">
                                                    <?php
                                                    foreach ($persona as $key => $p) {
                                                        if ($proveedor[0]->Persona_Proveedor == $p->id_persona) {
                                                            ?>
                                                            <option value="<?php echo $p->id_persona; ?>"><?php echo $p->primer_nombre_persona . ' ' . $p->segundo_nombre_persona . ' ' . $p->primer_apellido_persona . ' ' . $p->segundo_apellido_persona; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        foreach ($persona as $key => $p) {
                                                            if ($proveedor[0]->Persona_Proveedor != $p->id_persona) {
                                                                ?>
                                                            <option value="<?php echo $p->id_persona; ?>"><?php echo $p->primer_nombre_persona . ' ' . $p->segundo_nombre_persona . ' ' . $p->primer_apellido_persona . ' ' . $p->segundo_apellido_persona; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Natural</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="natural_juridica" name="natural_juridica" placeholder="Natural Juridica" value="<?php echo $proveedor[0]->natural_juridica ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Linea</label>
                                            <div class="col-sm-9">
                                                <select id="lineas" name="lineas" class="form-control">
                                                    <?php
                                                    foreach ($linea as $key => $l) {
                                                        if ($proveedor[0]->lineas == $l->id_linea) {
                                                            ?>
                                                            <option value="<?php echo $l->id_linea; ?>"><?php echo $l->tipo_producto; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        foreach ($linea as $key => $l) {
                                                            if ($proveedor[0]->lineas != $l->id_linea) {
                                                                ?>
                                                            <option value="<?php echo $l->id_linea; ?>"><?php echo $l->tipo_producto; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <label>
                                                    <select name="estado" class="form-control">
                                                        <?php
                                                        if ($proveedor[0]->estado == 1) {
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
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group img_logo">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Logo</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="logo" name="logo" placeholder="Logo" value="<?php //echo $proveedor[0]->titulo_submenu ?>">
                                                <?php
                                                if($proveedor[0]->logo_type){
                                                    ?>
                                                    <img src="data: <?php echo $proveedor[0]->logo_type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($proveedor[0]->logo) ?>" clas="preview_producto polaroid" style="width:50%" />
                                                    <?php
                                                }
                                                ?>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>