
<script type="text/javascript">

function setEmpresa(){
    var id_empresa = $(".empresa_").val();
    $.ajax({
        url: "<?php echo base_url(). 'admin/empleado/get_sucursal/'; ?>"+ id_empresa,
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
}

setEmpresa();

function getSucursal(){

    var id_empresa = $(".empresa_").val();
    $.ajax({
        url: "<?php echo base_url(). 'admin/empleado/get_sucursal/'; ?>"+ id_empresa,
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
}

function getEmpleados(){
    $('#persona_modal').modal('show');
    accion = $(".encargado_lista").attr("id");
    get_encargado_lista();
}

function get_encargado_lista() {
    var table = "<table class='table table-sm table-hover'>";
    table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control buscar_producto' name='buscar_producto'/> </td></tr>"
    table += "<th>#</th><th>Nombre Completo</th><th>DUI</th><th>NIT</th><th>Telefono</th><th>Action</th>";
    var table_tr = "<tbody id='list'>";
    var contador_precios = 1;

    $.ajax({
        url: "get_persona",
        url: "<?php echo base_url(). 'admin/empleado/get_persona'; ?>",
        datatype: 'json',
        cache: false,

        success: function(data) {
            var datos = JSON.parse(data);
            var persona = datos["persona"];

            $.each(persona, function(i, item) {

                table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '</td><td>' + item.dui + '</td><td>' + item.nit + '</td><td>' + item.cel + '</td><td><a href="#" class="btn btn-primary btn-xs encargado" id="' + item.id_persona + '" name="' + item.primer_nombre_persona + ' ' + item.segundo_nombre_persona + ' ' + item.primer_apellido_persona + ' ' + item.segundo_apellido_persona + '">Agregar</a></td></tr>';
                contador_precios++;
            });
            table += table_tr;
            table += "</tbody></table>";

            $(".cliente_lista_datos").html(table);

        },
        error: function() {}
    });
}

function getPersona(){
    $('#persona_modal').modal('show');
    accion = $(this).attr("id");
    get_persona_lista();
}

function get_persona_lista() {
    var table = "<table class='table table-sm table-hover'>";
    table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control buscar_producto' name='buscar_producto'/> </td></tr>"
    table += "<th>#</th><th>Nombre Completo</th><th>DUI</th><th>NIT</th><th>Telefono</th><th>Action</th>";
    var table_tr = "<tbody id='list'>";
    var contador_precios = 1;

    $.ajax({
        url: "<?php echo base_url(). 'admin/empleado/get_persona'; ?>",
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



    $(document).ready(function() {

        var accion = "";

        $('#persona_modal').appendTo("body");
        $('#encargado_modal').appendTo("body");

        $('#error').appendTo("body");

        $(document).on('change', '.Imagen', function() {
            readURL(this);
        });


        


        // filtrar producto
        $(document).on('keyup', '.buscar_producto', function() {
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
                url: "<?php echo base_url(). 'admin/empleado/validar_persona/'; ?>"+ id,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    if (data) {
                        $(".notificacion_texto").text("Empleado ya vinculado a un usuario existente.");
                        $('#error').modal('show');

                    } else {
                        if (accion == 'encargado_nombre') {
                            $("#encargado_id").val(id);
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

        // Seleccionar encargado
        $(document).on('click', '.encargado', function() {
            var id = $(this).attr("id");
            var name = $(this).attr("name");

            if (accion == 'encargado_nombre') {
                $("#encargado_id").val(id);
                $("#encargado_nombre").val(name);
            } else {
                $("#Persona_E").val(id);
                $("#persona_nombre").val(name);
            }

            $('#persona_modal').modal('hide');
        });

        $(document).on('click', '#btn_save', function() {
            var password = $("#password").val();
            var password2 = $("#password2").val();

            if ((password == password2) && (password != '' && password2 != '')) {
                var data = "";
                $('input[type^="text"]').each(function () {
                    if($(this).val()!=""){
                        $('form#crear').submit();
                    }else{
                        
                        data += "Campo " + $(this).attr('name') + " esta vacio <br>";
                    }
                });
                $(".msg").html(data);
                
            } else {
                $(".notificacion_texto").text("Password Diferente.");
                $('#error').modal('show');
            }
        });

        $("#imagen_nueva").hide();

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.preview_producto').attr('src', e.target.result);
                    console.log(e.target.result);
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
    <div class="content-wrapper">>
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/empleado/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Empleado</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>

        </h3>
        <form class="form-horizontal" enctype="multipart/form-data" id="empleado" name="usuario" method="post">
            <div class="row">
                <div class="col-lg-12">

                    <div id="panelDemo10" class="panel menu_title_bar">

                        <div class="panel-heading menuTop"><i class="fa fa-user-circle fa-lg"></i> Nuevo Empleado </div>
                        
                        <div class="menuContent">

                            <input type="hidden" value="" name="id_submenu">
                            <div class="b">
                                <div class="panel-heading">                                   
                                </div>
                                <div class="row">

                                    <div class="col-lg-4">
                                    <i class="fa fa-info-circle text-purple"></i> Información Básica.
                                        <br><br>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Contratacion</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" required id="fecha_contratacion_empleado" name="fecha_contratacion_empleado" placeholder="Empresa" value="<?= date("Y-m-d"); ?>">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Horas</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" required id="horas_laborales_mensuales_empleado" name="horas_laborales_mensuales_empleado" placeholder="Hora laborales" value="8">
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Turno</label>
                                            <div class="col-sm-9">
                                                
                                                <select id="turno" name="turno" class="form-control">
                                                    <?php
                                                    foreach ($turnos as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value->id_turno ?>"><?php echo $value->nombre_turno ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Alias</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" required id="alias" name="alias" placeholder="Alias" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Nivel</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" required id="nivel" name="nivel" placeholder="Nivel" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Puesto</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" required id="puesto" name="puesto" placeholder="Puesto" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Seccion</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" required id="seccion" name="seccion" placeholder="Seccion" value="">

                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-lg-4" style="border-left:1px solid grey;border-right:1px solid grey">
                                    <i class="fa fa-info-circle text-purple"></i> Información Básica.
                                        <br><br>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Cargo</label>
                                            <div class="col-sm-9">
                                                <select id="Cargo_Laboral_E" required name="Cargo_Laboral_E" class="form-control">
                                                    <?php
                                                    if($cargos){
                                                        foreach ($cargos as $key => $p) {
                                                            ?>
                                                            <option value="<?php echo $p->id_cargo_laboral; ?>"><?php echo $p->cargo_laboral; ?></option>
                                                        <?php
                                                        }
                                                    }else{
                                                        ?>
                                                        <option value=""><?php echo "No Exiten Cargos"; ?></option>
                                                        <?php 
                                                    }
                                                    
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                            <div class="col-sm-9">
                                                <select required name="Empresa" class="form-control empresa_" onchange="getSucursal();">
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
                                                <select id="Sucursal" required name="Sucursal" class="form-control">

                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Fotografia</label>
                                            <div class="col-sm-9">
                                                <input type="file" class="form-control Imagen" id="img" name="img_empleado" placeholder="Foto" value="asstes/img/nofotoprofile.png">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Encargado</label>
                                            <div class="col-sm-9">

                                                <input type="text" required class="form-control encargado_lista" onClick="getEmpleados();" name="" placeholder="Persona" value="">
                                                <input type="hidden" class="form-control encargado_lista" id="encargado_id" name="encargado" placeholder="Persona" value="">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Persona</label>
                                            <div class="col-sm-9">
                                                <input type="text" required class="form-control seleccionar_encargado" onClick="getPersona();" name="persona" placeholder="Encargado" value="<?php //echo $onMenu[0]->titulo_submenu 
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

                                    <div class="col-lg-4" >
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
                                            <span class="msg"></span>
                                            <?php
                                            if($cargos){
                                                ?>
                                                <input type="button" name="<?php echo base_url() ?>admin/empleado/crear" data="empleado" class="btn btn-warning enviar_data" value="Guardar">                                     
                                                <?php
                                            }else{
                                                ?>
                                                <span class="btn btn-danger">
                                                    <i class="fa fa-info-circle fa-lg"> Boton Desactivado. </i>
                                                </span>
                                                
                                                
                                                <?php
                                            }
                                            ?>
                                            
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