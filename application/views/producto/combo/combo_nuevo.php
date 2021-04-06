
<script type="text/javascript">
    var productos = {};
    var producto_almacen = [];
    var contador = 0;

    $(document).ready(function() {
        $(".producto_combo").hide();
        $("#codigo").hide();
    });

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
            $("#codigo").show();
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
            html += "<input type='text' class='form-control dependientes' placeholder='Cantidad' name='" + item.id_entidad + "'/>";
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

    function btn_agregar(){
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
    $(document).on("click", "#guardar_combo", function() {
        guardar_combo();
    });

    function guardar_combo() {

            var flag = false;

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

            if (flag) {
                $("#lista_productos").submit();
            }

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

        <div class="row">
            <div class="col-lg-12">
                <div id="" class="panel menu_title_bar">
                    <!-- START table-responsive-->
                    <div class="row">
                        <div class="col-lg-4">
                            <div id="" class="panel">
                                <div class="panel-heading menuTop">Crear Combo : </div>
                                <div class="panel-body menuContent">

                                    <div class="panel ">
                                        <div class="panel-body">
                                            <div class="alert alert-default">
                                                <i class="fa fa-info-circle"></i>
                                                <strong>Info!</strong> Seleccionar Producto creado como combo.
                                            </div>

                                            <div class="alert alert-default">
                                                <i class="fa fa-info-circle"></i>
                                                <strong>Info!</strong> Agregar Producto al combo.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Producto Combo</label>

                                        <div class="col-sm-9">

                                            <select class="form-control" name="producto" id="producto" readonly>
                                                <option value="0">Selecionar</option>
                                                <?php
                                                if($productos_combo) {
                                                    foreach ($productos_combo as $key => $value) {
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

                                        <label for="inputPassword3" class="col-sm-3 control-label no-padding-right"><br>Dependientes</label>
                                        <div class="col-sm-9">

                                            <select class="form-control producto_combo" name="producto_combo">
                                                <option value="0">Selecionar</option>
                                                <?php
                                                foreach ($productos as $key => $value) {
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
                                        <label for="inputPassword3" class="col-sm-3 control-label no-padding-right"><br>Codigo</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="codigo" id="codigo" placeholder="Codigo Barras" class="form-control" />
                                            <span class="btn btn-default" onClick="buscar_codigo();">Buscar</span>
                                        </div>
                                    </div>

                                    <br><br>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9"><br>
                                            <button type="submit" class="btn btn-primary" onClick="btn_agregar()" style="float:right;"><i class="fa fa-plus-circle"> </i> Agregar Producto</button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div id="" class="panel">
                                <div class="panel-heading menuTop">Lista Productos Agregados : </div>

                                <div class="panel-body menuContent">
                                    <form class="form-horizontal lista_productos" id='combo' method="post">

                                        <input type="hidden" id="produto_principal" name="produto_principal" value="">
                                        <!-- <a id="guardar_combo" class='btn btn-primary' onClick='guardar_combo()' value='Guardar Combo'>Guardar Combo</a> -->
                                        <input type="button" name="<?php echo base_url() ?>producto/combo/crear" data="combo" class="btn btn-success enviar_data" value="Guardar">
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>