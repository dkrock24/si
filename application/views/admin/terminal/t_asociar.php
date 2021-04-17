<script type="text/javascript">

    function agregar(id_usuario, id_terminal) {
        var _html0 = '<i class="fa fa-desktop" style="font-size:18px; color:#39b2d6;"></i>';
        var _html1 = '<i class="fa fa-desktop" style="font-size:18px; color:#39b2d6;"></i>';
        var params = {
            usuario: id_usuario,
            terminal: id_terminal,
            dispositivo: $('input[id='+id_usuario+']').val(),
            method: 'agregar'
        };

        procesar(params, _html0, _html1);
    }

    function eliminar(id_usuario, id_terminal) {
        var _html0 = '<i class="fa fa-ban" style="font-size:18px; color:#39b2d6;"></i>';
        var _html1 = '<i class="fa fa-ban" style="font-size:18px; color:grey;"></i>';
        var params = {
            usuario: id_usuario,
            terminal: id_terminal,
            method: 'inactivar'
        };
        
        procesar(params, _html0, _html1);
    }

    $(document).on('keyup', '#filtrar_nombre', function(){
        var texto_input = $(this).val();

        $(".list tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
        });        
    });

    $(".dispositivo").change('click', function(){
        var id_usuario = $(this).attr('id');
        var id_terminal = $(this).attr('name');

        var params = {
            usuario: id_usuario,
            terminal: id_terminal,
            dispositivo: $(this).val(),
            method: 'dispositivo'
        };
        
        procesar(params);
    });

    function procesar(params, _html0, _html1) {
        $.ajax({
            url: "<?php echo base_url(); ?>admin/terminal/"+params.method,
            datatype: 'json',
            cache: false,
            type: 'POST',
            data: params,

            success: function(data) {
                var result = JSON.parse(data);

                if (result.terminal) {
                    $(".terminal" + params.usuario).html(_html1);
                }

                if (result.inactivar == false) {
                    $(".estado" + params.usuario).html(_html1);
                }

                if (result.inactivar == true) {
                    $(".estado" + params.usuario).html(_html0);
                }
            },
            error: function() {}
        });
    }

    // Impresor
    $(".activar_ipresor").on('click', function() {

        var impresor = $(this).attr('name');

        var params = {
            impresor: impresor,
            method: 'impresor_estado'
        };

        impresor_estado(params);
    });

    function impresor_estado(params) {

        $.ajax({
            url: "<?php echo base_url(); ?>admin/terminal/"+params.method,
            datatype: 'json',
            cache: false,
            type: 'POST',
            data: params,

            success: function(data) {
                if (data == 1) {

                    $(".estado" + params.impresor).removeClass("inactive");
                    $(".estado" + params.impresor).addClass("activo");

                    $(".estado" + params.impresor).text("Activo");

                } else {

                    $(".estado" + params.impresor).removeClass("activo");
                    $(".estado" + params.impresor).addClass("inactive");
                    $(".estado" + params.impresor).text("Inactivo");
                }

            },
            error: function() {}
        });
    }

    // Activar principal
    $(".activar_principal").on('click', function() {

        var impresor = $(this).attr('name');

        var params = {
            impresor: impresor,
            method: 'impresor_principal'
        };

        impresor_principal(params);
    });

    function impresor_principal(params) {

        $.ajax({
            url: "<?php echo base_url(); ?>admin/terminal/"+params.method,
            datatype: 'json',
            cache: false,
            type: 'POST',
            data: params,

            success: function(data) {
                if (data == 1) {
                    $(".principal" + params.impresor).removeClass("btn-default");
                    $(".principal" + params.impresor).addClass("btn-info");

                } else {
                    $(".principal" + params.impresor).removeClass("btn-info");
                    $(".principal" + params.impresor).addClass("btn-default");
                }

            },
            error: function() {}
        });
    }

    $("#buscar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#dataImpresores tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

</script>
<!-- Main section-->
<style>
    .activo {
        background: #39b2d6 !important;
    }

    .inactive {
        background: #ffc107 !important;
    }

    .codigo_navegador{
        color:#e44848;
    }
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; ">
            <a name="admin/terminal/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-pill-right btn-info btn-outline" style="color:white;"> Terminales</button>
            </a>

            <?php $this->load->view('notificaciones/success'); ?>
        </h3>
        <div class="panel menu_title_bar">
            <table class="table">
                <tr>
                    <td>
                        <h3>Terminal :<?php echo $terminal[0]->nombre; ?></h3>
                    </td>
                    <td>
                        <h3>Codigo :<?php echo $terminal[0]->codigo; ?></h3>
                    </td>
                    <td>
                        <h3>Numero :<?php echo $terminal[0]->numero; ?></h3>
                    </td>
                    <td>
                        <h3>Dispositivo :<?php echo $terminal[0]->dispositivo; ?></h3>
                    </td>
                    <td>
                        <h3>SO :<?php echo $terminal[0]->sist_operativo; ?></h3>
                    </td>
                    <td>
                        <h3>Numero :<?php echo $terminal[0]->marca; ?></h3>
                    </td>
                    <td>
                        <h3>M :<?php echo $terminal[0]->modelo; ?></h3>
                    </td>
                    <td>
                        <h3>S :<?php echo $terminal[0]->series; ?></h3>
                    </td>
                </tr>
            </table>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link active" id="terminal" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">TERMINALES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">IMPRESORES</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="terminal">
                    <div class="row">

                        <div class="col-lg-12">
                            <h4><u>LISTA</u> USUARIOS </h4>
                            <input type="text" name="filtrar_nombre" id="filtrar_nombre" value="" class="form-control"  placeholder="Buscar Usuario" style="float:right; width:250px;" />
                            <br><br><span style="float:right;"> CODIGO NAVEGADOR : <span class="codigo_navegador" > <?php echo $this->session->uuid; ?></span></span>
                            <table id="datatable1" class="table table-striped table-hover">
                                <thead class="linea_superior">
                                    <tr>
                                        <th style="color: black;">#</th>
                                        <th style="color: black;">Sucursal</th>
                                        <th style="color: black;">Apellidos</th>
                                        <th style="color: black;">Nombres</th>
                                        <th style="color: black;">Usuario</th>
                                        <th style="color: black;">Terminal</th>
                                        <th style="color: black;">Estado</th>
                                        <th style="color: black;">Agregar</th>
                                        <th style="color: black;">Dispositivo</th>
                                        <th style="color: black;">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <?php
                                    $contado = 1;
                                    if ($usuario) {
                                        foreach ($usuario as $ter_usu) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $contado; ?></th>
                                                <td><?php echo $ter_usu->nombre_sucursal; ?></td>
                                                <td><?php echo $ter_usu->primer_apellido_persona . " " . $ter_usu->segundo_apellido_persona; ?></td>
                                                <td><?php echo $ter_usu->primer_nombre_persona . " " . $ter_usu->segundo_nombre_persona; ?></td>
                                                <td>
                                                    <?php
                                                    if ($ter_usu->estado == 1) {
                                                    ?>
                                                        <span class="label label-success" style="background: #39b2d6">Activo</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="label label-warning" style="background: #d26464">Inactivo</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>

                                                <td class="terminal<?php echo $ter_usu->id_usuario ?>">
                                                    <?php if(isset($ter_usu->id_terminal_cajero)): ?>
                                                        <i class="fa fa-desktop" style="font-size:18px; color:#39b2d6;"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-desktop" style="font-size:18px; color:grey;"></i>
                                                    <?php endif ?>
                                                </td>
                                                <td class="estado<?php echo $ter_usu->id_usuario ?>">
                                                    <?php if(isset($ter_usu->id_terminal_cajero)): ?>
                                                        <i class="fa fa-ban" style="font-size:18px; color:#39b2d6;"></i>
                                                    <?php else: ?>
                                                        <i class="fa fa-ban" style="font-size:18px; color:grey;"></i>
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" onClick="agregar(<?php echo $ter_usu->id_usuario; ?>,<?php echo $terminal[0]->id_terminal; ?>)" rel="" name="" id=""><i class="fa fa-plus-circle" style="font-size:18px"></i></a>
                                                </td>
                                                <td><input type="text" name="<?php echo $terminal[0]->id_terminal; ?>" class="dispositivo" id="<?php echo $ter_usu->id_usuario; ?>" value="" class="form-control" autocomplete="off" /></td>
                                                <td>
                                                    <a onClick="eliminar(<?php echo $ter_usu->id_usuario; ?>,<?php echo $terminal[0]->id_terminal; ?>);" class="btn btn-warning btn-sm"><i class="fa fa-refresh" style="font-size:18px"></i></a>

                                                </td>
                                            </tr>
                                    <?php
                                            $contado += 1;
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">

                        <div class="col-lg-12">
                            <h4>TERMINALES / IMPRESORES </h4>
                            <div class="row">
                                <div class="col-sm-offset-8 col-lg-1" style="text-align:right;">
                                    <h4>Buscar</h4>
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" name="buscar" value="" id="buscar" class="form-control" />
                                </div>
                            </div>
                            <table id="datatable1" class="table table-striped table-hover impresores">
                                <thead class="linea_superior">
                                    <tr>
                                        <th style="color: black;">#</th>
                                        <th style="color: black;">TERMINAL</th>
                                        <th style="color: black;">CODIGO</th>
                                        <th style="color: black;">DOCUMENTO</th>
                                        <th style="color: black;">IMPRESOR</th>
                                        <th style="color: black;">MARCA</th>
                                        <th style="color: black;">MODELO</th>
                                        <th style="color: black;">COLOR</th>
                                        <th style="color: black;">URL</th>
                                        <th style="color: black;">Estado</th>

                                    </tr>
                                </thead>
                                <tbody id="dataImpresores">
                                    <?php
                                    $contado = 1;
                                    if ($impresores) {
                                        foreach ($impresores as $impresor) {
                                            $id_impresor = $impresor->id_impresor_terminal;
                                    ?>
                                            <tr>
                                                <td scope="row"><?php echo $contado; ?></td>
                                                <td><?php echo $impresor->terminal_nombre; ?></td>
                                                <td><?php echo $impresor->terminal_codigo; ?></td>
                                                <td class="d_nombre"><?php echo $impresor->documento_nombre; ?></td>
                                                <td><?php echo $impresor->impresor_nombre; ?></td>
                                                <td><?php echo $impresor->impresor_marca; ?></td>
                                                <td><?php echo $impresor->impresor_modelo; ?></td>
                                                <td><?php echo $impresor->impresor_color; ?></td>
                                                <td><?php echo $impresor->impresor_url; ?></td>

                                                <td>
                                                    <?php
                                                    if ($impresor->impresor_terminal_estado == 1) {
                                                    ?>
                                                        <span class="label label-success <?php echo 'estado' . $id_impresor; ?>" style="background: #27c24c;">ACTIVO</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="label label-warning <?php echo 'estado' . $id_impresor; ?>" style="background: #d26464">INACTIVO</span>
                                                    <?php
                                                    }
                                                    ?>
                                                    <span style="float:right">
                                                        <i class="btn btn-default btn-sm activar_ipresor" style="background:#a74973;color:white;" rel="" name="<?php echo $id_impresor; ?>" id="<?php //echo $id_empresor; 
                                                                                                                                                                                                ?>"><i class="fa fa-pencil" style="font-size:18px;"></i></i>
                                                        <?php if ($impresor->impresor_principal == 1) : ?>
                                                            <i class="btn btn-info btn-sm activar_principal <?php echo 'principal' . $id_impresor; ?>" rel="" name="<?php echo $id_impresor; ?>" id="<?php //echo $id_empresor; 
                                                                                                                                                                                                        ?>"><i class="fa fa-check-circle" style="font-size:18px"></i></i>
                                                        <?php else : ?>
                                                            <i class="btn btn-default btn-sm activar_principal <?php echo 'principal' . $id_impresor; ?>" rel="" name="<?php echo $id_impresor; ?>" id="<?php //echo $id_empresor; 
                                                                                                                                                                                                        ?>"><i class="fa fa-check-circle" style="font-size:18px"></i></i>
                                                        <?php endif ?>
                                                    </span>
                                                </td>


                                            </tr>
                                    <?php
                                            $contado += 1;
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>

                            <div class="text-right  panel-footer bg-gray-light">
                                <ul class="pagination pagination-md">

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    </div>
</section>