
<script type="text/javascript">
    var productos = {};
    var producto_almacen = [];
    var contador = 0;

    function buscar_codigo()
    {
        var codigo = $("#codigo").val();

        $.ajax({
            url: "<?php echo base_url() ?>producto/combo/get_productos_codigo/"+ codigo,
            datatype: 'json',
            cache: false,

            success: function(data) {
                var datos = JSON.parse(data);
                var p = {};
                p = datos["productos"];

                productos = p;
                producto();
            },
            error: function() {}
        });
    }

    $(document).on("change", "#producto", function() {
        var val = $(this).val();
        if (val != 0) {
            $(".producto_combo").show();
            $("#produto_principal").val($(this).val());
        } else {
            $(".producto_combo").hide();
            $("#produto_principal").val();

        }
    });

    function producto() {

        producto_almacen[contador] = productos;

        var html = "<span>";

        $.each(productos, function(i, item) {
            html += '<div class="form-group" id="total' + item.id_entidad + '">';
            html += '<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Producto</label>';
            html += '<div class="col-sm-4">';
            html += item.name_entidad;
            html += '</div>';
            html += '<div class="col-sm-4">';
            html += '<span><i class="fa fa-info-circle" id="' + item.id_entidad + '"></i>  </span>';
            html += "<input type='text' name='" + item.id_entidad + "'/>";
            html += '</div>';
            html += '<div class="col-sm-2">';
            html += "<a href='#' class='btn btn-warning borrar' id='" + item.id_entidad + "'>Borrar</a>";
            html += '</div>';

            html += '</div>';
        });
        html += "</span>";
        contador++;
        $(".lista_productos").prepend(html);

    }

    function btn_agregar()
    {
        $(".producto_combo").val();
        var id = $(".producto_combo").val();

        $.ajax({
            url: "<?php echo base_url() ?>producto/combo/get_productos_id/"+ id,
            datatype: 'json',
            cache: false,

            success: function(data) {
                var datos = JSON.parse(data);
                var p = {};
                p = datos["productos"];

                productos = p;
                producto();
            },
            error: function() {}
        });
    }

    $(document).on("click", ".borrar", function() {
        var id = $(this).attr("id");
        $("#total" + id).remove();

    });

    function guardar_combo() {

        var flag = true;

        $.each(producto_almacen, function(i, item) {

            var valor = $('input[name=' + item[0].id_entidad + ']').val();

            if (valor == "") {
                flag = false;
                $('i[id=' + item[0].id_entidad + ']').text("Ingrese Valor");
            } else {
                flag = true;

                $('i[id=' + item[0].id_entidad + ']').text("");
            }
        });
    }
</script>

<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <h3 style="height: 50px; font-size: 13px;">
            <a name="producto/combo/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Lista Combo</button>
            </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">Nuevo</button>
        </h3>
        <div class="panel menu_title_bar">
            <div class="panel-heading">Nuevo Combo</div>
            <!-- START table-responsive-->
            <div class="">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-white">
                            <div class="panel-body">
                                <div class="col-lg-4">
                                    <div id="" class="panel">
                                        <div class="panel-heading menuTop">Combo Formulario :</div>
                                        <p>
                                            <div class="panel-body menuContent">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right">Producto</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" name="producto" id="producto" readonly>
                                                            <option value="<?php echo $combo[0]->Producto_Combo; ?>"><?php echo $combo[0]->uno; ?></option>
                                                            <?php
                                                            foreach ($productos as $key => $value) {
                                                                if ($combo[0]->Producto_Combo != $value->id_entidad) {
                                                            ?>
                                                                    <option value="<?php echo $value->id_entidad ?>"><?php echo $value->name_entidad ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <br><br>
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">Agregar</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control producto_combo" name="producto_combo">
                                                            <option value="0">Selecionar</option>
                                                            <?php
                                                            foreach ($productos_2 as $key => $value) {
                                                            ?>
                                                                <option value="<?php echo $value->id_entidad ?>"><?php echo $value->name_entidad ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <br><br>
                                                <div class="form-group">
                                                    <label for="inputPassword3" class="col-sm-2 control-label no-padding-right"><br>Codigo</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="codigo" id="codigo" placeholder="Codigo Barras" class="form-control" />
                                                        <span class="btn btn-default" onClick="buscar_codigo();">Buscar</span>
                                                        <br><br><hr>
                                                    </div>
                                                </div>

                                                <br><br>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary" onClick="btn_agregar()" style="float:right;"><i class="fa fa-plus-circle"> </i> Agregar Producto</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div id="" class="panel">
                                        <div class="panel-heading menuTop">Productos en Combo :</div>
                                        <p>

                                            <div class="panel-body menuContent">
                                                <form class="form-horizontal" id='combo' method="post">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Codigo</td>
                                                            <td>Precio</td>
                                                            <td>Nombre</td>
                                                            <td>Cantidad</td>
                                                            <td>Accion</td>
                                                        </tr>
                                                        <tbody>
                                                        <?php
                                                        if ($combo) {
                                                            foreach ($combo as $key => $value) {
                                                            ?>
                                                                <tr id="total<?php echo $value->internalId ?>">
                                                                    <td><label for="inputEmail3" class="control-label no-padding-right"><?php echo $value->codigoBarras; ?></label></td>
                                                                    <td><label for="inputEmail3" class="control-label no-padding-right"><?php echo $value->precio; ?></label></td>
                                                                    <td><label for="inputEmail3" class="control-label no-padding-right"><?php echo $value->dos ?></label></td>
                                                                    <td><label for="inputEmail3" class="control-label no-padding-right"><span><i class="fa fa-info-circle" id='<?php echo $value->producto_a_descargar_Combo ?> '></i> </span>
                                                                        <br><input type='number' style="width:80px;" name='<?php echo $value->producto_a_descargar_Combo ?>' min="1" value="<?php echo $value->cantidad ?>" id='<?php echo $value->producto_a_descargar_Combo ?> ' required="required" /></div></label></td>
                                                                    <td>
                                                                        <a href='#' style="float:right;" class='btn btn-danger borrar' id='<?php echo $value->internalId ?>'>Borrar</a>
                                                                    </td>
                                                                </tr>                                                                
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table><br><br><hr>
                                                    <span class="lista_productos"></span>
                                                    <input type="hidden"  id="produto_principal" name="produto_principal" value="<?php echo $value->Producto_Combo ?>">
                                                    <input type="button" name="<?php echo base_url() ?>producto/combo/update" data="combo" class="btn btn-success enviar_data" value="Guardar">
                                                </form>
                                            </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>