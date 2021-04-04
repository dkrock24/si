<!-- Main section-->
<script>

    function remover(vista){
        var documento = $("#id_tipo_documento").val();
        metodo = "remover";
        
        display(vista, documento, metodo)
    }

    $(".vincular").click(function() {
        var vista = $(this).attr('id');
        var documento = $("#id_tipo_documento").val();
        metodo = "asociar";

        display(vista, documento, metodo);
    });

    function display(vista, documento, method){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>admin/documento/"+ metodo + "/" + documento + "/" + vista,
            datatype: 'json',
            cache: false,

            success: function(data) {
                var datos = JSON.parse(data);
                var html_ = "";
                var cont = 1;

                $.each(datos, function(i , item){

                    html_ += '<tr>';
                    html_ += '<td>' + cont + '</td>';
                    html_ += '<td>' + item.vista_nombre + '</td>';
                    html_ += '<td>';
                    html_ += '<span class="btn btn-danger" style="color: white;" onClick="remover('+ item.id_vista +')" id="'+ item.id_vista +'"><i class="fa fa-trash"></i></span>';
                        html_ += '</td>';
                    html_ += '</tr>';
                    cont++;
                });

                $('#documento_vista').html(html_);
            },
            error: function() {}
        });
    }
       
</script>
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="admin/documento/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Documento</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">

                <div id="panelDemo10" class="panel menu_title_bar">

                    <div class="panel-heading menuTop">Editar Documento : </div>
                    <div class="panel-body menuContent">

                        <form class="form-horizontal" id="documento">
                            <input type="hidden" value="<?php echo $documento[0]->id_tipo_documento; ?>" id="id_tipo_documento" name="id_tipo_documento">
                            <div class="row">

                                <div class="col-lg-6">
                                    <!-- Otro -->
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="nombre" name="nombre" placeholder="Nombre Documento" value="<?php echo $documento[0]->nombre ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Inventario</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="efecto_inventario" name="efecto_inventario" placeholder="Efecto Inventario" value="<?php echo $documento[0]->efecto_inventario ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Iva</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="efecto_en_iva" name="efecto_en_iva" placeholder="Efecto Iva" value="<?php echo $documento[0]->efecto_en_iva ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Cuentas</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="efecto_en_cuentas" name="efecto_en_cuentas" placeholder="Efecto Cuentas" value="<?php echo $documento[0]->efecto_en_cuentas ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Caja</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="efecto_en_caja" name="efecto_en_caja" placeholder="Efecto Cajas" value="<?php echo $documento[0]->efecto_en_caja ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Reportes</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="efecto_en_report_venta" name="efecto_en_report_venta" placeholder="Efecto Reportes" value="<?php echo $documento[0]->efecto_en_report_venta ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Autmatico</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="automatico" name="automatico" placeholder="Autmatico" value="<?php echo $documento[0]->automatico ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Emitir a</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="emitir_a" name="emitir_a" placeholder="Emitir a" value="<?php echo $documento[0]->emitir_a ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Copias</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" required id="copias" name="copias" placeholder="Numero de Copias" value="<?php echo $documento[0]->copias ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Monto Limite</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" required id="monto_limite" name="monto_limite" placeholder="Monto Limite" value="<?php echo $documento[0]->monto_limite ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <label>
                                                <select name="estado" class="form-control">
                                                    <?php
                                                    if ($documento[0]->estado == 1) {
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

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                        <input type="button" name="<?php echo base_url() ?>admin/documento/update" data="documento" class="btn btn-success enviar_data" value="Guardar">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <div class="content" style="border:0px solid black;height:500px;width:390px;overflow:scroll;display:inline-block;">
                                        <i class="fa fa-info-circle"></i> Seleciona las vistas en donde quieras mostrar el documento.<br><br>
                                        <table class="table">
                                            <?php
                                            $cnt = 0;
                                            foreach ($vistas as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td><?= $cnt += 1; ?></td>
                                                    <td>
                                                        <span class="">
                                                            <?= $value->vista_nombre ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="">
                                                            <a href="#" id="<?= $value->id_vista ?>" class="btn btn-info vincular">Vincular</a>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                    <div class="content" style="border:0px solid black;height:500px;width:390px;overflow:scroll;display:inline-block;">
                                        <i class="fa fa-info-circle"></i> Remover documento de la vista.<br><br>
                                        <table class="table" id="documento_vista">
                                            <?php
                                            if ($vistas_doc) {
                                                $cnt = 0;
                                                foreach ($vistas_doc as $key => $value) {
                                            ?>
                                                    <tr>
                                                        <td><?= $cnt += 1; ?></td>
                                                        <td>
                                                            <span class="">
                                                                <?= $value->vista_nombre ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="">
                                                                <a id="<?= $value->id_vista ?>" onClick="remover(<?= $value->id_vista ?>)" class="btn btn-danger remover"><i class="fa fa-trash"></i></a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </table>
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