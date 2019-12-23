<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var accion = "";

        $('#persona_modal').appendTo("body");
        $('#encargado_modal').appendTo("body");

        $('#error').appendTo("body");

        $(document).on('change', '.Imagen', function() {
            readURL(this);
        });

        $(document).on('click', '.seleccionar_encargado', function() {
            $('#persona_modal').modal('show');
            accion = $(this).attr("id");
            get_encargado_lista();
        });

        function get_encargado_lista() {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre Completo</th><th>DUI</th><th>NIT</th><th>Telefono</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: "get_persona",
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var persona = datos["persona"];

                    $.each(persona, function(i, item) {

                        table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '</td><td>' + item.dui + '</td><td>' + item.nit + '</td><td>' + item.cel + '</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_persona" id="' + item.id_persona + '" name="' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '">Agregar</a></td></tr>';
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
        $(document).on('keyup', '#buscar_producto', function() {
            var texto_input = $(this).val();

            $("#list tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
            });
        });

        // Seleccionar Persona
        $(document).on('click', '.seleccionar_persona', function() {
            var id = $(this).attr("id");
            var name = $(this).attr("name");

            $.ajax({
                url: "validar_persona/" + id,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    if (data) {
                        $(".notificacion_texto").text("Empleado ya vinculado a un usuario existente.");
                        $('#error').modal('show');

                    } else {
                        if (accion == 'encargado_nombre') {
                            $("#encargado").val(id);
                            $("#encargado_nombre").val(name);
                        } else {
                            $("#Persona_E").val(id);
                            $("#persona_nombre").val(name);
                        }

                        $('#persona_modal').modal('hide');
                    }
                },
                error: function() {}
            });
        });

        $(document).on('click', '#btn_save', function() {
            var password = $("#password").val();
            var password2 = $("#password2").val();

            if ((password == password2) && (password != '' && password2 != '')) {
                $('form#crear').submit();
            } else {
                $(".notificacion_texto").text("Password Diferente.");
                $('#error').modal('show');
            }
        });

        $(document).on('change', '#Empresa', function() {
            var id_empresa = $(this).val();
            $.ajax({
                url: "get_sucursal/" + id_empresa,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var sucursal = datos["sucursal"];
                    var Sucursal = '';
                    $.each(sucursal, function(i, item) {
                        Sucursal += '<option value="' + item.id_sucursal + '">' + item.nombre_sucursal + '</option>';

                    });
                    $("#Sucursal").html(Sucursal);
                },
                error: function() {}
            });
        });




        $("#imagen_nueva").hide();

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.preview_producto').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
                $("#imagen_nueva").show();
            }
        }
    });
</script>
<!-- Main section-->
<style type="text/css">
    .preview_producto {
        width: 50%;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a href="index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-left btn-primary btn-outline"> Empleado</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

        </h3>
        <form class="form-horizontal" enctype="multipart/form-data" id="crear" name="usuario" action='crear' method="post">
            <div class="row">
                <div class="col-lg-12">

                    <div id="panelDemo10" class="panel menu_title_bar">

                        <div class="panel-heading menuTop">Nuevo Empleado </div>
                        <div class="panel-body menuContent">

                            <input type="hidden" value="<?php //echo $onMenu[0]->id_submenu; 
                                                        ?>" name="id_submenu">

                            <div class="panel b">
                                <div class="panel-heading">
                                    <div class="pull-right">
                                        <div class="label label-info">Importante</div>
                                    </div>
                                    <h4 class="m0">Crear Nuevo Empleado</h4>
                                    <small class="text-muted">Crear Nuevo.</small>
                                </div>
                                <div class="row">



                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Contratacion</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="fecha_contratacion_empleado" name="fecha_contratacion_empleado" placeholder="Empresa" value="<?php //echo $onMenu[0]->fecha_contratacion_empleado 
                                                                                                                                                                                            ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Horas</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="horas_laborales_mensuales_empleado" name="horas_laborales_mensuales_empleado" placeholder="Hora laborales" value="<?php //echo $onMenu[0]->horas_laborales_mensuales_empleado 
                                                                                                                                                                                                                ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Turno</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="turno" name="turno" placeholder="Turno" value="<?php //echo $onMenu[0]->turno 
                                                                                                                                                ?>">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Alias</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="alias" name="alias" placeholder="Alias" value="<?php //echo $onMenu[0]->alias 
                                                                                                                                            ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Nivel</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="nivel" name="nivel" placeholder="Nivel" value="<?php //echo $onMenu[0]->alias 
                                                                                                                                            ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Puesto</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="puesto" name="puesto" placeholder="Puesto" value="<?php //echo $onMenu[0]->puesto 
                                                                                                                                                ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Seccion</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="seccion" name="seccion" placeholder="Seccion" value="<?php //echo $onMenu[0]->seccion 
                                                                                                                                            ?>">

                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-lg-4">
                                        <!-- Otro -->

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Cargo</label>
                                            <div class="col-sm-9">
                                                <select id="Cargo_Laboral_E" name="Cargo_Laboral_E" class="form-control">
                                                    <?php
                                                    foreach ($cargos as $key => $p) {
                                                        ?>
                                                        <option value="<?php echo $p->id_cargo_laboral; ?>"><?php echo $p->cargo_laboral; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                            <div class="col-sm-9">
                                                <select id="Empresa" name="Empresa" class="form-control">
                                                    <option>Selecione Empresa</option>
                                                    <?php
                                                    foreach ($empresa as $key => $p) {
                                                        ?>
                                                        <option value="<?php echo $p->id_empresa; ?>"><?php echo $p->nombre_comercial; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sucursal</label>
                                            <div class="col-sm-9">
                                                <select id="Sucursal" name="Sucursal" class="form-control">

                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fotografia</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control Imagen" id="img" name="img_empleado" placeholder="Foto" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                        ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Encargado</label>
                                            <div class="col-sm-9">

                                                <input type="text" class="form-control encargado_codigo" id="encargado" name="encargado" placeholder="Persona" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                                        ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control seleccionar_encargado" id="persona_nombre" name="persona" placeholder="Encargado" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                                                ?>">
                                                <input type="hidden" class="form-control persona_codigo" id="Persona_E" name="Persona_E" placeholder="Persona" value="<?php //echo $onMenu[0]->titulo_submenu 
                                                                                                                                                                        ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">

                                                <img src="" name="" id="imagen_nueva" class="preview_producto" />
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




                                    </div>

                                    <div class="col-lg-4">
                                        <i class="fa fa-info-circle text-purple"></i> Vincular Sucursales al Empleado.
                                        <br><br>

                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="row"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cont = 1;
                                                foreach ($empresa as $e) {
                                                    ?>
                                                    <tr>

                                                        <td>

                                                            <span class="label label-success " style="font-size: 15px;">
                                                                <span class="fa-stack">
                                                                    <i class="fa fa-home"></i>
                                                                </span>
                                                                <?php echo $e->nombre_razon_social; ?></span>

                                                            <br><br>
                                                            <?php

                                                                foreach ($sucursal_lista as $value) {
                                                                    if ($e->id_empresa == $value->Empresa_Suc) {

                                                                        ?>
                                                                    <input type="checkbox" value="<?php echo $value->id_sucursal ?>" name="<?php echo $value->id_sucursal ?>">
                                                                    <label><?php echo $value->nombre_sucursal; ?></label>
                                                                    <br>
                                                            <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $cont++;
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="panel-footer text-right">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="button" id="btn_save" class="btn btn-info">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>
</section>

<!-- Modal Large CLIENTES MODAL-->
<div id="persona_modal" tabindex="-1" role="dialog" aria-labelledby="persona_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Buscar Persona</h4>
            </div>
            <div class="modal-body">
                <p class="cliente_lista_datos">

                </p>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->

<!-- Modal Large CLIENTES MODAL-->
<div id="error" tabindex="-1" role="dialog" aria-labelledby="error" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info-dark">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title"><i class="fa fa-warning fa-fw"></i> Notificación</h4>
            </div>
            <div class="modal-body">
                <p style="text-align: center; font-size: 18px;" class="notificacion_texto"></p>
            </div>
            <div class="modal-footer bg-gray">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->