

<script type="text/javascript">
    $(document).ready(function() {

        $('#persona_modal').appendTo("body");


        $(document).on('click', '.persona_codigo', function() {
            $('#persona_modal').modal('show');
            get_clientes_lista();
        });

        function get_clientes_lista() {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control buscar_producto' name='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre Completo</th><th>DUI</th><th>NIT</th><th>Telefono</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: "<?php echo base_url(); ?>/admin/cliente/get_empleado",
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var clientes = datos["empleado"];

                    $.each(clientes, function(i, item) {

                        table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '</td><td>' + item.dui + '</td><td>' + item.nit + '</td><td>' + item.tel + '</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_persona" id="' + item.id_persona + '" name="' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '">Agregar</a></td></tr>';
                        contador_precios++;


                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".cliente_lista_datos").html(table);

                },
                error: function() {}
            });
        }

        // filtrar producto
    $(document).on('keyup', '.buscar_producto', function(){
        var texto_input = $(this).val();

        $("#list tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
        });        
    });

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
            <a name="admin/cliente/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Clientes</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

        </h3>
        <div class="row">
            <div class="col-lg-12">

                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Editar Cliente : <?php //echo $cliente[0]->nombre_submenu 
                                                                        ?> </div>
                    <div class="menuContent">
                        <div class="b">    
                            <div class="panel-heading"></div>
                            <form class="form-horizontal" enctype="multipart/form-data" id="cliente">
                                <input type="hidden" value="<?php echo $cliente[0]->id_cliente; ?>" name="id_cliente">
                                <div class="row">

                                    <div class="col-lg-4">

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right"></label>
                                            <div class="col-sm-9">
                                            <?php
                                            if($cliente[0]->logo_type){
                                                ?>
                                                <img src="data: <?php echo $cliente[0]->logo_type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($cliente[0]->logo_cli) ?>" clas="preview_producto" style="width:50%" />
                                                <?php
                                            }?><br>

                                            </div>
                                        </div>

                                        <div class="form-group">                                            
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Logo</label>
                                            <div class="col-sm-8">
                                                <input type="file" class="form-control" id="logo_cli" name="logo_cli" placeholder="Logo" value="<?php //echo $cliente[0]->titulo_submenu ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Website</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="website_cli" name="website_cli" placeholder="Website" value="<?php echo $cliente[0]->website_cli ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NRC</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nrc_cli" name="nrc_cli" placeholder="NRC" value="<?php echo $cliente[0]->nrc_cli ?>">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4" style="border-left:1px solid grey;border-right:1px solid grey">

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">NIT</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" required id="nit_cliente" name="nit_cliente" placeholder="NIT" value="<?php echo $cliente[0]->nit_cliente ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">DUI</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="dui_cliente" name="dui_cliente" placeholder="DUI" value="<?php echo $cliente[0]->dui_cli ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Clase Cliente</label>
                                            <div class="col-sm-8">
                                                
                                                <select class="form-control" id="clase_cli" name="clase_cli"  >
                                                    
                                                <option value="<?php echo $cliente[0]->clase_cli;  ?>"><?php echo $cliente[0]->clase_cli;  ?></option>
                                                    <?php 
                                                        $cliente_class = array("A","B","C","D");
                                                        foreach ($cliente_class as $value) {

                                                            if($cliente[0]->clase_cli != $value){
                                                                ?>
                                                                <option value="<?php echo $value;  ?>"><?php echo $value;  ?></option>
                                                                <?php
                                                            }
                                                            
                                                        }                                                    
                                                    ?>                                                  

                                                 </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Email</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="mail_cli" name="mail_cli" placeholder="Email" value="<?php echo $cliente[0]->mail_cli ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Nombre Empresa</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nombre_empresa_o_compania" name="nombre_empresa_o_compania" placeholder="Nombre Empresa" value="<?php echo $cliente[0]->nombre_empresa_o_compania ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">N Cuenta</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" required id="numero_cuenta" name="numero_cuenta" placeholder="N Cuenta" value="<?php echo $cliente[0]->numero_cuenta ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Exento</label>
                                            <div class="col-sm-8">
                                                <select id="aplica_impuestos" name="aplica_impuestos" class="form-control">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Dirección</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="direccion_cliente" name="direccion_cliente" placeholder="Direccion" value="<?php echo $cliente[0]->direccion_cliente ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">% Descuento</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="porcentage_descuentos" name="porcentage_descuentos" placeholder="Descuento" value="<?php echo $cliente[0]->porcentage_descuentos ?>">

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-4">
                                        <!-- Otro -->
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-8">

                                                <input type="text" class="form-control persona_codigo" value="<?php echo $cliente[0]->primer_nombre_persona . ' ' . $cliente[0]->segundo_nombre_persona . ' ' . $cliente[0]->primer_apellido_persona . ' ' . $cliente[0]->segundo_apellido_persona; ?>">
                                                <input type="hidden" class="form-control" id="persona" name="Persona" value="<?php echo $cliente[0]->Persona; ?>">
                                               <!-- <select id="Persona" name="Persona" class="form-control">
                                                    <?php
                                                    foreach ($persona as $key => $p) {
                                                        if ($cliente[0]->Persona == $p->id_persona) {
                                                            ?>
                                                            <option value="<?php echo $p->id_persona; ?>"><?php echo $p->primer_nombre_persona . ' ' . $p->segundo_nombre_persona . ' ' . $p->primer_apellido_persona . ' ' . $p->segundo_apellido_persona; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        foreach ($persona as $key => $p) {
                                                            if ($cliente[0]->Persona != $p->id_persona) {
                                                                ?>
                                                            <option value="<?php echo $p->id_persona; ?>"><?php echo $p->primer_nombre_persona . ' ' . $p->segundo_nombre_persona . ' ' . $p->primer_apellido_persona . ' ' . $p->segundo_apellido_persona; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                -->
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Natural</label>
                                            <div class="col-sm-8">
                                                
                                                <select class="form-control" id="natural_juridica" name="natural_juridica">
                                                <?php 
                                                    if($cliente[0]->natural_juridica == 0){
                                                        ?>
                                                        <option value="0">Natural</option>
                                                        <option value="1">Juridica</option>
                                                        <?php

                                                    }else{
                                                        ?>
                                                        <option value="1">Juridica</option>
                                                        <option value="0">Natural</option>                                                    
                                                        <?php
                                                    }
                                                ?>                                                   
                                                </select>    
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Pago</label>
                                            <div class="col-sm-8">
                                                <select id="TipoPago" name="TipoPago" class="form-control">
                                                    <?php

                                                    foreach ($pago as $key => $pp) {
                                                        if ($cliente[0]->TipoPago == $pp->id_modo_pago) {
                                                            ?>
                                                            <option value="<?php echo $pp->id_modo_pago; ?>"><?php echo $pp->codigo_modo_pago; ?></option>
                                                        <?php
                                                            }
                                                        }

                                                        foreach ($pago as $key => $p) {
                                                            if ($cliente[0]->TipoPago != $p->id_modo_pago) {
                                                                ?>
                                                            <option value="<?php echo $p->id_modo_pago; ?>"><?php echo $p->codigo_modo_pago; ?></option>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Documento</label>
                                            <div class="col-sm-8">
                                                <select id="TipoDocumento" name="TipoDocumento" class="form-control">
                                                    <?php
                                                    foreach ($documento as $key => $d) {
                                                        if ($cliente[0]->TipoDocumento == $d->id_tipo_documento) {
                                                            ?>
                                                            <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre; ?></option>
                                                        <?php
                                                            }
                                                        }

                                                        foreach ($documento as $key => $d) {
                                                            if ($cliente[0]->TipoDocumento != $p->id_tipo_documento) {
                                                                ?>
                                                            <option value="<?php echo $d->id_tipo_documento; ?>"><?php echo $d->nombre; ?></option>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Tipo Cliente</label>
                                            <div class="col-sm-8">
                                                <select id="id_cliente_tipo" name="id_cliente_tipo" class="form-control">
                                                    <option value="<?php echo $cliente[0]->id_cliente_tipo; ?>"><?php echo $cliente[0]->nombre_cliente_tipo ?></option>
                                                    <?php

                                                    foreach ($clienteTipo as $key => $clienteTipo) {
                                                        if ($clienteTipo->id_cliente_tipo != $cliente[0]->id_cliente_tipo) {
                                                            ?>
                                                            <option value="<?php echo $clienteTipo->id_cliente_tipo; ?>"><?php echo $clienteTipo->nombre_cliente_tipo; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Formas Pago</label>
                                            <div class="col-sm-9">

                                                <?php
                                                if ($pagoCliente) {
                                                    foreach ($pagoCliente as $key => $pc) {
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label"><?php echo $pc->nombre_modo_pago ?></label>
                                                            <div class="col-sm-10">

                                                                <label class="switch">

                                                                    <?php
                                                                    if ($pc->for_pag_emp_estado == 1) {
                                                                    ?>
                                                                        <input type="checkbox" checked="checked" name="<?php echo $pc->id_modo_pago ?>">
                                                                        <span></span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <input type="checkbox" name="<?php echo $pc->id_modo_pago ?>">
                                                                        <span></span>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </label>
                                                            </div>
                                                        </div>

                                                    <?php
                                                        }
                                                    } else {
                                                    
                                                    foreach ($pago as $key => $p) {
                                                        ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label"><?php echo $p->nombre_modo_pago ?></label>
                                                            <div class="col-sm-10">

                                                                <label class="switch">

                                                                    <input type="checkbox" name="<?php echo $p->id_modo_pago ?>">
                                                                    <span></span>

                                                                </label>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">

                                                <label>
                                                    <select name="estado" class="form-control">
                                                        <?php
                                                        if ($cliente[0]->estado_cliente == 1) {
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


                                    </div>
                                </div>

                                <div class="panel-footer text-right">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">                                           
                                            <input type="button" name="<?php echo base_url() ?>admin/cliente/update" data="cliente" class="btn btn-warning enviar_data" value="Guardar">
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