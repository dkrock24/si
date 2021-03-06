<script type="text/javascript">

    function remover(id){
        jQuery.ajax({
            url: "<?php echo base_url(); ?>admin/marca/delete_categoria_marca/"+ id,
            type: 'GET',
            cache: false,

            success: function(data) {
                var datos = JSON.parse(data);
                var html_ = "";
                var cont = 1;

                $.each(datos, function(i , item){

                    html_ += '<tr class="uno">';
                    html_ += '<td>' + cont + '</td>';
                    html_ += '<td>' + item.nombre_marca + '</td>';
                    html_ += '<td>' + item.nombre_categoria + '</td>';
                    html_ += '<td>' + item.descripcion_marca + '</td>';
                    html_ += '<td>';
                        html_ += '<span class="btn" style="background: #39b2d6; color: white;" onClick="remover('+ item.id_mar_cat +')" id="'+ item.id_mar_cat +'"><i class="fa fa-trash"></i></span>';
                        html_ += '</td>';
                    html_ += '</tr>';
                    cont++;
                });

                $('#categoria_marca').html(html_);
            },
            error: function() {}
        });
    }

    $(document).ready(function() {

        $(".crear").click(function() {
            var categoria = $("#categoria1").val();
            var marca = $("#marca1").val();

            data = {
                categoria: categoria,
                marca: marca
            };

            $.ajax({
                url: "<?php echo base_url(); ?>/admin/marca/save_categoria_marca",
                data: data,
                type: 'POST',
                cache: false,
                datatype: 'json',

                success: function(data) {
                    var datos = JSON.parse(data);
                    var html_ = "";
                    var cont = 1;

                    $.each(datos, function(i , item){

                        html_ += '<tr class="uno">';
                        html_ += '<td>' + cont + '</td>';
                        html_ += '<td>' + item.nombre_marca + '</td>';
                        html_ += '<td>' + item.nombre_categoria + '</td>';
                        html_ += '<td>' + item.descripcion_marca + '</td>';
                        html_ += '<td>';
                        html_ += '<span class="btn" style="background: #39b2d6; color: white;" onClick="remover('+ item.id_mar_cat +')" id="'+ item.id_mar_cat +'"><i class="fa fa-trash"></i></span>';
                            html_ += '</td>';
                        html_ += '</tr>';
                        cont++;
                    });

                    $('#categoria_marca').html(html_);
                },
                error: function() {}
            });
        });
    });
</script>

<style type="text/css">
    .marca_categoria {
        width: 95%;
        height: 350px;
        overflow-y: scroll;
    }
    hr {
        color: black;
        border-color: black;
    }
</style>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/marca/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Marca</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nuevo</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Nueva Marca : <?php //echo $onMenu[0]->nombre_submenu ?> </div>
                    <div class="panel-body menuContent">

                        <div class="row">
                            <form class="form-horizontal" name="marca" id='marca' method="post">

                                <div class="alert alert-default">
                                    <i class="fa fa-info-circle"></i>
                                    <strong>Info!</strong> Crear Nueva Marca.
                                </div>

                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="nombre_marca" name="nombre_marca" placeholder="Nombre Marca" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Descripcion</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="descripcion_marca" name="descripcion_marca" placeholder="Descripcion Marca" value="<?php //echo $onMenu[0]->nombre_submenu ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categoria</label>
                                        <div class="col-sm-10">
                                            <select name="main_categoria" id="categoria" class="form-control">
                                                <?php
                                                if(isset($categoria)){
                                                    foreach ($categoria as $key => $c) {
                                                        ?>
                                                        <option value="<?php echo $c->id_categoria ?>"><?php echo $c->nombre_categoria ?></option>
                                                    <?php
                                                    }
                                                }
                                                else{
                                                    ?>
                                                    <option value="">No Hay Categoria</option>
                                                    <?php
                                                }                                                
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="estado" class="form-control">
                                                    <option value="1">Activo</option>
                                                    <option value="0">Inactivo</option>
                                                </select>
                                            </label>
                                            <input type="button" name="<?php echo base_url() ?>admin/marca/crear" data="marca" class="btn btn-warning enviar_data" value="Guardar">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="alert alert-default">
                                            <i class="fa fa-info-circle"></i>
                                            <strong>Info!</strong> Vincular Marca Existente con Categoria Existente.
                                        </div>

                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Categorias</label>
                                        <div class="col-sm-10">
                                            <select name="categoria" id="categoria1" class="form-control">
                                                <?php
                                                foreach ($categoria as $key => $c) {
                                                    ?>
                                                    <option value="<?php echo $c->id_categoria ?>"><?php echo $c->nombre_categoria ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Marca</label>
                                        <div class="col-sm-10">
                                            <select name="marca" id="marca1" class="form-control">
                                                <?php
                                                foreach ($marca as $key => $m) {
                                                    ?>
                                                    <option value="<?php echo $m->id_marca ?>"><?php echo $m->nombre_marca ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right"></label>
                                        <div class="col-sm-10">
                                            <span class="btn btn-info crear">Crear</span>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="col-lg-6" style="
                                                    height: 500px;
                                                    position: relative;
                                                    overflow: scroll;
                                                ">
                                <table class="table marca_categoria">
                                    <thead style="background: #cfdbe2;color: black;">
                                        <tr>
                                            <th>#</th>
                                            <th>Marca</th>
                                            <th>Categoria</th>
                                            <th>Marca Descripcion</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="categoria_marca">
                                        <?php
                                        $cont = 1;
                                        if($marca_categoria){
                                        foreach ($marca_categoria as $key => $mc) {
                                            ?>
                                            <tr>
                                                <td><?php echo $cont; ?></td>
                                                <td><?php echo $mc->nombre_marca ?></td>
                                                <td><?php echo $mc->nombre_categoria ?></td>
                                                <td><?php echo $mc->descripcion_marca ?></td>
                                                <td>
                                                    <span class="btn" style="background: #39b2d6; color: white;" onClick="remover(<?php echo $mc->id_mar_cat; ?>)" id="<?php echo $mc->id_mar_cat; ?>"><i class="fa fa-trash"></i></span>
                                                </td>
                                            </tr>
                                        <?php
                                            $cont++;
                                        } }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>