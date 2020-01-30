<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#persona_modal').appendTo("body");


        $(document).on('click', '.persona_codigo', function() {
            $('#persona_modal').modal('show');
            get_clientes_lista();
        });

        function get_clientes_lista() {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre Completo</th><th>DUI</th><th>NIT</th><th>Telefono</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: "get_empleado",
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var clientes = datos["empleado"];

                    $.each(clientes, function(i, item) {

                        table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '</td><td>' + item.dui + '</td><td>' + item.nit + '</td><td>' + item.cel + '</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_persona" id="' + item.id_empleado + '" name="' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '">Agregar</a></td></tr>';
                        contador_precios++;


                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".cliente_lista_datos").html(table);

                },
                error: function() {}
            });
        }

        // Seleccionar persona
        $(document).on('click', '.seleccionar_persona', function(){
            var id = $(this).attr("id");
            var name = $(this).attr("name");

            $("#persona").val(id);
            $(".persona_codigo").val(name);
            $('#persona_modal').modal('hide');

        });


        $("#departamento").change(function() {
            $("#ciudad").empty();
            var html_option;
            var departamento = $(this).val();

            $.ajax({
                url: "getCiudadId/" + departamento,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var ciudad = datos["ciudad"];

                    $.each(ciudad, function(i, item) {
                        html_option += "<option>" + item.nombre_ciudad + "</option>";
                    });
                    $("#ciudad").html(html_option);
                },
                error: function() {}
            });
        });
    });
</script>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Clientes</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

        </h3>
        <div class="row">
            <div class="col-lg-12">


                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Nuevo Cliente : <?php //echo $onMenu[0]->nombre_submenu 
                                                                        ?> </div>
                    <div class="panel-body menuContent">
                        <p>
                            <form class="form-horizontal" enctype="multipart/form-data" name="cliente" action='crear' method="post">
                                <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; 
                                                            ?>" name="id_submenu">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Website</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="website_cli" name="website_cli" placeholder="Website" value="<?php //echo $onMenu[0]->nombre_submenu 
                                                                                                                                                            ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NRC</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nrc_cli" name="nrc_cli" placeholder="NRC" value="<?php //echo $onMenu[0]->url_submenu 
                                                                                                                                                ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NIT</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" required id="nit_cliente" name="nit_cliente" placeholder="NIT" value="<?php //echo $onMenu[0]->icon_submenu 
                                                                                                                                                                ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">DUI</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" required id="dui_cliente" name="dui_cliente" placeholder="DUI" value="<?php //echo $onMenu[0]->icon_submenu 
                                                                                                                                                                ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Clase Cliente</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="clase_cli" name="clase_cli" placeholder="Clase Cliente" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                            ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="mail_cli" name="mail_cli" placeholder="Email" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                    ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Nombre Empresa</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nombre_empresa_o_compania" name="nombre_empresa_o_compania" placeholder="Nombre Empresa" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                                                            ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">N Cuenta</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" required id="numero_cuenta" name="numero_cuenta" placeholder="N Cuenta" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                                        ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Exento</label>
                                            <div class="col-sm-9">
                                                <select id="aplica_impuestos" name="aplica_impuestos" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>

                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Direccion</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Direccion" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                                        ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">% Descuento</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="porcentage_descuentos" name="porcentage_descuentos" placeholder="Descuento" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                                                ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-9">
                                            <input type="text" class="form-control persona_codigo" value="">
                                            <input type="hidden" class="form-control" id="persona" name="Persona" placeholder="Persona" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Cliente</label>
                                            <div class="col-sm-9">

                                                <select class="form-control" id="natural_juridica" name="natural_juridica">
                                                    <option value="0">Natural</option>
                                                    <option value="1">Juridica</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6">
                                        <!-- Otro -->

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Logo</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control" id="logo_cli" name="logo_cli" placeholder="Logo" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Pago Predefinido</label>
                                            <div class="col-sm-9">
                                                <select id="TipoPago" name="TipoPago" class="form-control">
                                                    <?php
                                                    foreach ($pago as $key => $p) {
                                                    ?>
                                                        <option value="<?php echo $p->id_modo_pago; ?>"><?php echo $p->codigo_modo_pago; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Documento</label>
                                            <div class="col-sm-9">
                                                <select id="TipoDocumento" name="TipoDocumento" class="form-control">
                                                    <?php
                                                    foreach ($documento as $key => $d) {
                                                    ?>
                                                        <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre; ?></option>
                                                    <?php

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Cliente</label>
                                            <div class="col-sm-9">
                                                <select id="id_cliente_tipo" name="id_cliente_tipo" class="form-control">
                                                    <?php
                                                    foreach ($clienteTipo as $key => $clienteTipo) {
                                                    ?>
                                                        <option value="<?php echo $clienteTipo->id_cliente_tipo; ?>"><?php echo $clienteTipo->nombre_cliente_tipo; ?></option>
                                                    <?php

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Formas Pago</label>
                                            <div class="col-sm-9">

                                                <?php
                                                foreach ($pago as $key => $fp) {
                                                ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"><?php echo $fp->nombre_modo_pago ?></label>
                                                        <div class="col-sm-10">

                                                            <label class="switch">
                                                                <input type="checkbox" checked="checked" name="<?php echo $fp->id_modo_pago ?>">
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">

                                                <label>
                                                    <select name="estado" class="form-control">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn btn-info">Guardar</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </form>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>


<!-- Modal Large CLIENTES MODAL-->
<div id="persona_modal" tabindex="-1" role="dialog" aria-labelledby="persona_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info-dark">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Persona</h4>
            </div>
            <div class="modal-body">
                <p class="cliente_lista_datos">

                </p>

            </div>
            <div class="modal-footer bg-gray-light">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->