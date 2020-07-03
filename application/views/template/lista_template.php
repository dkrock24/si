<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

<script type="text/javascript">

    var headers = <?php echo json_encode($fields['field']); ?>;
    var records = <?php echo json_encode($registros); ?>;
    var documento_titulo = <?php echo json_encode($fields['titulo']); ?>;

    $(document).ready(function() {
        $(".filtro-input").each(function() {
            //console.log($(this).val());
            if($(this).val() != ""){
                $(this).focus();
            }
        });
    });

        
    $(document).on("change", "#total_pagina", function() {
        $.ajax({
            type: "post",
            url: "",
            success: function() {
                //location.reload();
                $('#pagina_x').submit();
            }
        });
    });

    $(document).on('keydown', '.filtro-input', function(e) {

        if (e.which == 13) {
            $('form#filtros').submit();
            return false;    //<---- Add this line
        }
    });
</script>

<style>

</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/css_general.css" />

<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; "><i class="icon-arrow-right"></i> <?php echo $fields['titulo']; ?></h3>

        <div class="panel menu_title_bar">
        <?php $this->load->view('notificaciones/success'); ?>
            <!-- START table-responsive-->
            <div class="dataList">
                <table id="datatable1" class="table table-striped table-hover" width="100%">
                    <thead class="linea_superior">
                        <tr class="">
                            <th width="5%">

                                <form method="post" id="pagina_x" name="data">
                                    <select class="form-control" id="total_pagina" name="total_pagina">
                                        <option class="0">-</option>
                                        <option class="10">10</option>
                                        <option class="15">15</option>
                                        <option class="20">20</option>
                                        <option class="50">50</option>
                                        <option class="100">100</option>
                                    </select>
                                </form>
                                
                            </th>
                            <form action="<?php echo base_url(). '\..' . $_SERVER['PATH_INFO'] ?>" method="post" id="filtros">
                                <?php
                                foreach ($column as $key => $combo) {
                                    ?>
                                    
                                    <th style="color: black;">
                                    <?php
                                    if(isset($filtros)){
                                        ?>
                                        <input type="text" name="<?php echo $fields['field'][$key]; ?>" value="<?php echo @$filtros[$fields['field'][$key]] ?>" class="form-control filtro-input" /><br>
                                        <?php
                                    }
                                    ?>                                
                                        <?php echo $combo; ?>
                                    </th>
                                <?php
                                }
                                ?>                            
                            </form>

                            <th class="alignRigth">
                                <div class="btn-group dropleft" role="group">
                                    <button type="button" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opcion</button>
                                    
                                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                        <?php
                                        if ($acciones) {
                                            foreach ($acciones as $key => $value) {
                                                $url = base_url();
                                                $num = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));

                                                if ($num) {
                                                    $url = $url . '\..' . $_SERVER['PATH_INFO'] . '\../../' . $value->accion_btn_url;
                                                } else {
                                                    $url = $value->accion_btn_url;
                                                }

                                                if($value->accion_btn_codigo){
                                                    $url = "#";
                                                    
                                                }

                                                if ($value->accion_valor == 'btn_superior') {
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo $url;  ?>" onclick="<?php echo $value->accion_btn_nombre;  ?>"  id="">
                                                            <span class="btn btn-info">
                                                                <i class='<?php echo $value->accion_btn_icon; ?>'></i>
                                                            </span>
                                                            <?php echo $value->accion_nombre;  ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <li class="divider"></li>
                                        
                                        <li>
                                            <a href="#" class="listar_giros" id="<?php ?>" data-toggle="modal" data-target="#ModalEmpresa">
                                                <span class="btn btn-warning">
                                                    <i class="fa fa-building-o"></i>
                                                </span> Empresa
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="datosLista" class="menuContent">
                        <?php
                        $contador = $contador_tabla;
                        if ($registros) {
                            foreach ($registros as $table) {
                                $id =  $fields['id'][0];
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $contador; ?></th>
                                        <?php
                                        foreach ($fields['field'] as $key => $field) {

                                            if ($field != 'estado') {
                                        ?>
                                    <td>
                                        <?php
                                            $a = substr($table->$field, 0, 1);
                                            if(isset($fields['reglas'][$field]['aplicar'])){
                                                echo $fields['reglas'][$field]['valor'];
                                            }
                                            
                                            if(isset($fields['reglas'][$field]['condicion'])){
                                                
                                                if($fields['reglas'][$field]['condicion'] == 1){
                                                    
                                                    if($table->$field == 'Devolucion'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-danger'>".$table->$estado."</span></h5>";
                                                    }
                                                    else if($table->$field == 'En proceso'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-primary'>".$table->$estado."</span></h5>";
                                                    }
                                                    else if($table->$field == 'Facturada'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-success'>".$table->$estado."</span></h5>";
                                                    }
                                                    else if($table->$field == 'Anulada'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-warning'>".$table->$estado."</span></h5>";
                                                    }
                                                    else if($table->$field == 'Procesada'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-info'>".$table->$estado."</span></h5>";
                                                    }
                                                    else if($table->$field == 'Creado'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-success'>".$table->$estado."</span></h5>";
                                                    }
                                                    else if($table->$field == 'Enviado'){
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-danger'>".$table->$estado."</span></h5>";
                                                    }else{
                                                        $estado = $fields['estado'][0];
                                                        echo "<h5><span class='label label-warning'>".$table->$estado."</span></h5>";
                                                    }
                                                }
                                            }

                                            if(!isset($fields['reglas'][$field]['condicion'])){
                                                echo $table->$field;
                                            }
                                            
                                        ?>
                                    </td>
                                <?php
                            }/*
                            if ($field == 'estado') {
                                $estado = $fields['estado'][0];
                                ?>
                                    <td>
                                        <?php
                                        if ($table->$estado == 1) {
                                        ?>
                                        <span class="label label-success" style="background: #39b2d6">Activo</span>
                                        <?php
                                        } else if($table->$estado == 0) {
                                        ?>
                                        <span class="label label-warning" style="background: #d26464">Inactivo</span>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                        <span class="label label-warning" style="background: #5ad246">Completado</span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                            <?php
                                }*/
                            }
                            ?>

                            <td class="alignRigth">
                                <div class="btn-group dropright mb-sm">
                                    <button type="button" data-toggle="dropdown" class="btn dropdown-toggle btn-xs" style="background: #dde6e9">Opcion
                                        <span class="caret"></span>
                                    </button>
                                    <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                        <?php

                                                if ($acciones) {

                                                    foreach ($acciones as $key => $value) {

                                                        $url = base_url();
                                                        $num = is_numeric(substr($_SERVER['PATH_INFO'], -1, 1));

                                                        if ($num) {
                                                            $url = $url . '\..' . $_SERVER['PATH_INFO'] . '\../../' . $value->accion_btn_url;
                                                        } else {
                                                            $url = $value->accion_btn_url;
                                                        }
                                                        $vista = $value->Vista;
                                                        if ($value->accion_valor == 'btn_medio' && $value->accion_nombre != 'Eliminar') {
                                        ?>

                                                        <li>
                                                            <a href="<?php echo  $url;  ?>/<?php echo $table->$id; ?>">
                                                                <span class="btn btn-success">
                                                                    <i class="<?php echo $value->accion_btn_icon; ?>"></i>
                                                                </span>
                                                                <?php echo $value->accion_nombre;  ?>
                                                                
                                                            </a>
                                                        </li>

                                                <?php
                                                                }

                                                                if ($value->accion_valor == 'btn_medio' && $value->accion_nombre == 'Eliminar') {
                                                                    ?>

                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="<?php echo $url;  ?>/<?php echo $table->$id; ?>">
                                                            <span class="btn btn-danger">
                                                                <i class="<?php echo $value->accion_btn_icon; ?>"></i>
                                                            </span>
                                                            <?php echo $value->accion_nombre;  ?>
                                                        </a>
                                                    </li>
                                                <?php
                                                        }
                                                    }
                                                }

                                                ?>
                                        <li class="divider"></li>

                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php
                            $contador += 1;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="text-right  panel-footer bg-gray-light">
                <ul class="nav nav-pills" style="display:inline-block; color:black;">
                    <li class="nav-item">
                        <a class="nav-link active" style="color:black;">[ <?= $total_pagina; ?>  ] <?= $x_total; ?> / <?= $total_records; ?></a>
                    </li>
                </ul>
                <ul class="pagination pagination-md">
                    <?php foreach ($links as $link) {
                        echo "<li class='page-item '>" . $link . "</li>";
                    } ?>
                </ul>
            </div>
        </div>
    </div>
    </div>

</section>