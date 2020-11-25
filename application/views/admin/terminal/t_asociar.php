<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        $(".agregar").on('click', function() {

            var id_usuario = $(this).attr('name');
            var id_terminal = $(this).attr('id');

            var params = {
                usuario: id_usuario,
                terminal: id_terminal,
                method: 'agregar'
            };

            procesar(params);
        });

        $(".eliminar").on('click', function() {

            var id_usuario = $(this).attr('name');
            var id_terminal = $(this).attr('id');

            var params = {
                usuario: id_usuario,
                terminal: id_terminal,
                method: 'inactivar'
            };

            procesar(params);
        });

        function procesar(params) {

            $.ajax({
                url: "../" + params.method,
                datatype: 'json',
                cache: false,
                type: 'POST',
                data: params,

                success: function(data) {

                    location.reload();

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
                url: "../" + params.method,
                datatype: 'json',
                cache: false,
                type: 'POST',
                data: params,

                success: function(data) {
                    if (data == 1) {
                        console.log(data);
                        $(".estado" + params.impresor).removeClass("inactive");
                        $(".estado" + params.impresor).addClass("activo");

                        $(".estado" + params.impresor).text("Activo");

                    } else {
                        console.log(data);
                        $(".estado" + params.impresor).removeClass("activo");
                        $(".estado" + params.impresor).addClass("inactive");
                        $(".estado" + params.impresor).text("Inactivo");
                    }

                },
                error: function() {}
            });
        }

        $("#buscar").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#datatable1 tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
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
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; ">
            <a href="../index" style="top: -12px;position: relative; text-decoration: none">
                <button type="button" class="mb-sm btn btn-pill-right btn-primary btn-outline"> Terminales</button>
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
                <li class="nav-item">
                    <a class="nav-link active" id="terminal" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">TERMINALES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">IMPRESORES</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="terminal">
                    <div class="row">

                        <div class="col-lg-6">
                            <h4><u>EMPRESA</u> USUARIOS </h4>
                            <table id="datatable1" class="table table-striped table-hover">
                                <thead class="linea_superior">
                                    <tr>
                                        <th style="color: black;">#</th>
                                        <th style="color: black;">Sucursal</th>
                                        <th style="color: black;">usuario</th>
                                        <th style="color: black;">Apellidos</th>
                                        <th style="color: black;">Nombres</th>
                                        <th style="color: black;">Estado</th>

                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contado = 1;
                                    if ($usuario) {
                                        foreach ($usuario as $ter_usu) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $contado; ?></th>


                                                <td><?php echo $ter_usu->nombre_sucursal; ?></td>
                                                <td><?php echo $ter_usu->nombre_usuario; ?></td>
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

                                                <td>

                                                    <a href="#" class="btn btn-primary btn-sm agregar" rel="" name="<?php echo $ter_usu->id_usuario; ?>" id="<?php echo $terminal[0]->id_terminal; ?>"><i class="fa fa-plus-circle" style="font-size:18px"></i></a>

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

                        <div class="col-lg-6">
                            <h4><u>TERMINAL</u> USUARIO </h4>
                            <table id="datatable1" class="table table-striped table-hover">
                                <thead class="linea_superior">
                                    <tr>
                                        <th style="color: black;">#</th>
                                        <th style="color: black;">Sucursal</th>
                                        <th style="color: black;">Terminal</th>
                                        <th style="color: black;">Codigo</th>
                                        <th style="color: black;">usuario</th>
                                        <th style="color: black;">Apellidos</th>
                                        <th style="color: black;">Nombres</th>
                                        <th style="color: black;">Estado</th>

                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contado = 1;
                                    if ($terminal_usuario) {
                                        foreach ($terminal_usuario as $ter_usu) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $contado; ?></th>
                                                <td><?php echo $ter_usu->nombre_sucursal; ?></td>
                                                <td><?php echo $ter_usu->nombre; ?></td>
                                                <td><?php echo $ter_usu->codigo; ?></td>
                                                <td><?php echo $ter_usu->nombre_usuario; ?></td>
                                                <td><?php echo $ter_usu->primer_apellido_persona . " " . $ter_usu->segundo_apellido_persona; ?></td>
                                                <td><?php echo $ter_usu->primer_nombre_persona . " " . $ter_usu->segundo_nombre_persona; ?></td>



                                                <td>
                                                    <?php
                                                    if ($ter_usu->estado_terminal_cajero == 1) {
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

                                                <td>

                                                    <a href="#" name="<?php echo $ter_usu->id_usuario; ?>" id="<?php echo $terminal[0]->id_terminal; ?>" class="btn btn-warning btn-sm eliminar"><i class="fa fa-refresh" style="font-size:18px"></i></a>

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
                <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                        <th style="color: black;">DOCUMENTO</th>
                                        <th style="color: black;">IMPRESOR</th>
                                        <th style="color: black;">MODELO</th>
                                        <th style="color: black;">URL</th>
                                        <th style="color: black;">Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contado = 1;
                                    if ($impresores) {
                                        foreach ($impresores as $impresor) {
                                            $id_impresor = $impresor->id_impresor_terminal;
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $contado; ?></th>


                                                <td><?php echo $impresor->terminal_nombre . " " . $impresor->terminal_codigo; ?></td>
                                                <td><?php echo $impresor->documento_nombre; ?></td>
                                                <td><?php echo $impresor->impresor_nombre . " " . $impresor->impresor_marca; ?></td>
                                                <td><?php echo $impresor->impresor_modelo . " " . $impresor->impresor_color; ?></td>
                                                <td><?php echo $impresor->impresor_url; ?></td>

                                                <td>
                                                    <?php
                                                    if ($impresor->impresor_terminal_estado == 1) {
                                                    ?>
                                                        <span class="label label-success <?php echo 'estado' . $id_impresor; ?>" style="background: #39b2d6">Activo</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="label label-warning <?php echo 'estado' . $id_impresor; ?>" style="background: #d26464">Inactivo</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>

                                                <td>

                                                    <i class="btn btn-primary btn-sm activar_ipresor" rel="" name="<?php echo $id_impresor; ?>" id="<?php //echo $id_empresor; 
                                                                                                                                                    ?>"><i class="fa fa-plus-circle" style="font-size:18px"></i></i>

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