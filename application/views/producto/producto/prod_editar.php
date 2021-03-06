<script>
    $('#producto_asociado_modal').appendTo("body");

    // Llamadas de funciones catalogos
    get_cliente();
    atributos();

    // Obtener los clientes desde la base de datos mediante Ajax
    function get_cliente() {

        $.ajax({
            url: "<?php echo base_url(). 'producto/producto/get_clientes/'; ?>",
            datatype: 'json',
            cache: false,

            success: function(data) {
                var datos = JSON.parse(data);
                obj_cliente = datos['cliente'];
                obj_impuesto = datos['impuesto'];
                obj_sucursales = datos['sucursal'];

            },
            error: function() {}
        });
    }

    // Busca el Giro para dibujar los inputs del producto
    function atributos() {
        var id = $("#id_producto").val();

        $.ajax({
            url: "<?php echo base_url(). 'producto/producto/get_atributos_producto/'; ?>"+ id,
            datatype: 'json',
            cache: false,

            success: function(data) {

                var datos = JSON.parse(data);
                var atributos = datos["atributos"];
                $(".giro_atributos").empty();

                var id_producto = 0;
                $.each(atributos, function(i, item) {

                    if (id_producto != item.id_prod_atributo) {
                        if (item.tipo_atributo == 'text' || item.tipo_atributo == 'file') {
                            $(".giro_atributos").append(html_template_text(item, atributos));
                        }
                        if (item.tipo_atributo == 'select') {
                            $(".giro_atributos").append(html_template_select(item.id_prod_atributo, atributos));
                        }
                        if (item.tipo_atributo == 'radio') {
                            $(".giro_atributos").append(html_template_radio(item.id_prod_atributo, atributos));
                        }
                        if (item.tipo_atributo == 'check') {
                            $(".giro_atributos").append(html_template_check(item.id_prod_atributo, atributos));
                        }
                        id_producto = item.id_prod_atributo;
                    }
                });
            },
            error: function() {}
        });
    }

    // Dibuja los atributos de tipo TEXT
    function html_template_text(item, atributos) {
        var html_template = "";
        html_template = '<div class="col-sm-3">' +
            '<div class="form-group">' +
            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">' + item.nam_atributo + '</label><br>' +
            '<div class="col-sm-offset-1 col-sm-11">' +
            '<input type="' + item.tipo_atributo + '" name="' + item.AtributoId + '" value="' + item.valor + '"  class="form-control ' + item.nam_atributo + '">' +
            '</div>' +
            '<span class="col-sm-1 control-label no-padding-right"></span>' +
            '</div>' +
            '</div>';
        return html_template;
    }

    // Dibuja los atributos de tipo SELECT
    function html_template_select(id, plantilla) {

        var opciones = "";
        var nombre = "";
        var delimitador = 0;
        var atributo_id = 0;

        $.each(plantilla, function(i, item) {

            if (id == item.id_prod_atributo) {
                if (item.valor == item.attr_valor) {
                    opciones += '<option value="' + item.valor + '">' + item.attr_valor + '</option>';
                }
            }
        });
        $.each(plantilla, function(i, item) {

            if (id == item.id_prod_atributo) {
                if (item.valor != item.attr_valor) {
                    opciones += '<option value="' + item.attr_valor + '">' + item.attr_valor + '</option>';
                }
                nombre = item.nam_atributo;
                atributo_id = item.AtributoId;
            }
        });

        var html_template = "";
        html_template = '<div class="col-sm-3">' +
            '<div class="form-group">' +
            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">' + nombre + '</label><br>' +
            '<div class="col-sm-offset-1 col-sm-11">' +
            '<select name="' + atributo_id + '" class="form-control ' + atributo_id + '">' + opciones + '</select>' +
            '</div>' +
            '<span class="col-sm-1 control-label no-padding-right"></span>' +
            '</div>' +
            '</div>';
        return html_template;
    }

    // Dibuja los atributos de tipo CHECK -- PENDIENTE
    function html_template_check(id, plantilla) {

        var opciones = "";
        var nombre = "";

        $.each(plantilla, function(i, item) {
            var checked2 = "";

            if (item.valor == 1 || item.valor == 'on') {
                checked2 = "checked";
                incluyeIva = obj_impuesto[0].porcentage;
            }

            if (id == item.id_prod_atributo) {
                nombre = item.nam_atributo;
                opciones += '<input type="hidden" value="' + item.valor + '" name="' + item.AtributoId + '">' +
                    //'<input type="checkbox" '+checked2+' class="check'+item.AtributoId+'" name="'+item.AtributoId+'"/>'+item.attr_valor+'<br>';    

                    '<span class="inline checkbox c-checkbox">' +
                    '<label>' +
                    '<input type="checkbox" id="todo-item-1" ' + checked2 + ' class="check' + item.AtributoId + '" name="' + item.AtributoId + '"/>' +
                    '<span class="fa fa-check"></span>' +
                    '</label></span>';


            }
        });

        var html_template = "";
        html_template = '<div class="col-sm-3">' +
            '<div class="form-group">' +
            '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">' + nombre + '</label><br>' +
            '<div class="col-sm-offset-1 col-sm-11">' +
            opciones +
            '</div>' +
            '<span class="col-sm-1 control-label no-padding-right"></span>' +
            '</div>' +
            '</div>';

        return html_template;
    }

    $(document).ready(function() {

        var html_cliente2;
        var obj_cliente;
        var obj_sucursales;
        var obj_impuesto;
        var incluyeIva = 0;
        var gravado = 0;
        var incluyeIva = 0;
        var gravado_contador = 0;
        var contador_precios = 0;
        var obj_precios_cont = [];
        var precios_contador = 0;
        var checked = 0;

        $(document).on('click', '#producto_asociado', function() {
            $('#producto_asociado_modal').modal('show');
            //get_productos_lista();
        });


        function get_productos_lista() {

            var table = "<table class='table table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Nombre</th><th>Id Producto</th><th>Marca</th><th>Categoria</th><th>Sub Categoria</th><th>Giro</th><th>Empresa</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: "../get_productos_lista",
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var productos = datos["productos"];

                    $.each(productos, function(i, item) {

                        table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.name_entidad + '</td><td>' + item.id_entidad + '</td><td>' + item.nombre_marca + '</td><td>' + item.nombre_categoria + '</td><td>' + item.SubCategoria + '</td><td>' + item.nombre_giro + '</td><td>' + item.nombre_razon_social + '</td><td><a href="#" class="btn btn-primary relacionar_producto" id="' + item.id_entidad + '">Relacionar</a></td></tr>';
                        contador_precios++;
                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".productos_lista_datos").html(table);

                },
                error: function() {}
            });
        }

        // Agregar el Id del producto al input del producto relacionado
        $(document).on('click', '.relacionar_producto', function() {
            var id = $(this).attr("id");
            $("#producto_asociado").val(id);
            $('#producto_asociado_modal').modal('hide');
        });

        // filtrar producto
        $(document).on('keyup', '#buscar_producto', function() {
            var texto_input = $(this).val();

            $("#list tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(texto_input) > -1)
            });


        });

        $("#categoria").change(function() {
            $("#sub_categoria").empty();
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(). 'producto/producto/sub_categoria_byId/'; ?>"+ id,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    $.each(JSON.parse(data), function(i, item) {

                        var datos = JSON.parse(data);
                        var subcategorias = datos["subcategorias"];
                        var marcas = datos['marcas'];

                        $("#sub_categoria").empty();
                        $.each(subcategorias, function(i, item) {
                            $("#sub_categoria").append('<option value=' + item.id_categoria + '>' + item.nombre_categoria + '</option>');
                        });

                        $("#marca").empty();
                        $.each(marcas, function(i, item) {
                            $("#marca").append('<option value=' + item.id_marca + '>' + item.nombre_marca + '</option>');
                        });
                    });
                },
                error: function() {}
            });
        });

        $("#empresa").change(function() {
            $("#giro").empty();
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(). 'producto/producto/get_giros_empresa/'; ?>"+ id,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);

                    $("#id_empresa").val(datos[0].Empresa);
                    $("#giro").append('<option value="0">Selecione Giro</option>');
                    $.each(JSON.parse(data), function(i, item) {
                        $("#giro").append('<option value=' + item.id_giro_empresa + '>' + item.nombre_giro + '</option>');
                    });

                },
                error: function() {}
            });
        });

        $(document).on('click', '.deletePrecio', function() {

            html_remove_precios($(this).attr('name'));

        });

        // Calculando utilidad de Productos Dinamicamente
        $(document).on('keyup', '.calculoUtilidad', function() {
            var contador = $(this).attr('id');
            // calculando utilidad para el precio especifico
            calculoUtilidad(contador);

        });

        // Calculo general de los valores en la tabla de los precios
        // Uitlidad
        function calculoUtilidad(contador) {

            gravado = $("#iva").val();
            incluyeIva = $('#incluye_iva').val();

            var factor = $('input[name*=factor' + contador + ']').val();
            var unidad = $('input[name*=unidad' + contador + ']').val();
            var precio = $('input[name*=precio' + contador + ']').val();
            var costo = $('input[name*=costo]').val();
            var total = (factor * unidad);
            var x;

            if (gravado == 'Gravados' && incluyeIva != 0) {

                //Remover IVA del precio del producto
                x = (unidad / 1.13);

                var utilidad = x - costo;
            } else {

                var utilidad = (total / factor) - costo;
            }

            $('.precio' + contador).val((total).toFixed(2));
            $('.utilidad' + contador).val((utilidad).toFixed(2));
        }

        // Calcula la utilidad posterior al agregar precios a la tabla de factores
        function calcularUtilidadPosPrecios() {

            //Recorremos los precios exstentes para actualizar sus valores dinamicamente
            obj_precios_cont.forEach(function(element) {

                calculoUtilidad(element);

            });

        }

        $(document).on('change', '#iva', function () {
            incluyeIva = obj_impuesto[0].porcentage;
            calcularUtilidadPosPrecios();
        });
        
        //Validar si Gravado Y Quitar Iva estan set
        $(document).on('change', '#incluye_iva', function () {

            //Recorrer Precios existentes
            var temp_cont = 1;

            while (temp_cont <= precios_contador) {
                obj_precios_cont.push(temp_cont);
                temp_cont++;
            }
            //Position [0] es iva        
            incluyeIva = obj_impuesto[0].porcentage;

            //$('.check26').attr('checked');

            // Validando si es gravado
            
            calcularUtilidadPosPrecios();
        });

        // Dibuja los precios y utlidades en la pantalla de nuevo cliente
        precios_contador = $("#precios_contador").val();
        var contador = 0;
        if (precios_contador != 0) {
            contador = precios_contador;
        } else {
            contador = 0;
        }

        $("#AgregarPrecios").click(function() {
            contador++;
            obj_precios_cont.push(contador);

            var cliente = html_get_cliente(contador);
            var sucursal = html_get_sucursal(contador);
            var html = "<tr id='" + contador + "'>" +
                "<td>" + contador + "</td>" +
                "<td><input type='text' size='10' name='presentacion" + contador + "' class=''/></td>" +
                "<td><input type='file' name='img" + contador + "' /></td>"+
                "<td><input type='text' size='3' name='factor" + contador + "' class=''></td>" +
                "<td><input type='text' size='3' name='unidad" + contador + "' class='calculoUtilidad' id='" + contador + "'></td>" +
                "<td><input type='text' size='4' name='precio" + contador + "' class='precio" + contador + "' value=''></td>" +

                "<td><input type='text' size='5' name='cbarra" + contador + "' class=''></td>" +
                "<td>" + cliente + "</td>" +
                "<td>" + sucursal + "</td>" +
                "<td><input type='text' size='4' name='utilidad" + contador + "' readonly class='utilidad" + contador + "' value=''/></td>" +
                "<td>" +
                "<div class='btn-group mb-sm'>" +
                " <span class='btn btn-warning btn-sm deletePrecio' name='" + contador + "'><i class='fa fa-trash'></i></span>" +

                " </div>" +
                "   </td>" +
                " </tr>";
            $(".preciosTable").append(html);
        });

        // Remover los precios por presentacion de la tabla
        function html_remove_precios(id_tr) {
            console.log(obj_precios_cont);
            $('table#preciosTable tr#' + id_tr).remove();

            obj_precios_cont.forEach(function(element) {

                if (id_tr == element) {

                    obj_precios_cont.splice(obj_precios_cont.indexOf(element), 1);
                }

            });
            contador_precios -= 1;
        }

        // Dibujar Objeto Select del Cliente
        function html_get_cliente(contador) {
            html_cliente = '<select name="cliente' + contador + '">';
            html_cliente += '<option value=""> - </option>';

            $.each(obj_cliente, function(i, item) {
                html_cliente += '<option value=' + item.id_cliente + '>' + item.nombre_empresa_o_compania + '</option>';
            });

            html_cliente += "</select>";
            html_cliente2 = html_cliente;

            return html_cliente2;
        }

        // Dibujar Objeto select del Sucursal
        function html_get_sucursal(contador) {
            html_sucursal = '<select name="sucursal' + contador + '">';
            html_sucursal += '<option value=""> - </option>';
            $.each(obj_sucursales, function(i, item) {
                html_sucursal += '<option value=' + item.id_sucursal + '>' + item.nombre_sucursal + '</option>';
            });
            html_sucursal += "</select>";
            html_sucursal2 = html_sucursal;

            return html_sucursal2;
        }

        

        // Dibuja los atributos de tipo RADIO
        function html_template_radio(id, plantilla) {

            var opciones = "";
            var nombre = "";

            $.each(plantilla, function(i, item) {

                if (id == item.id_prod_atributo) {
                    nombre = item.nam_atributo;
                    opciones += '<input type="radio" class="" name="' + item.id_prod_atributo + '" value="' + nombre + '"/>' + item.attr_valor + '<br>';
                }
            });

            var html_template = "";
            html_template = '<div class="col-sm-3">' +
                '<div class="form-group">' +
                '<label for="inputEmail3" class="col-sm-offset-1 control-label no-padding-right">' + nombre + '</label><br>' +
                '<div class="col-sm-offset-1 col-sm-11">' +
                opciones +
                '</div>' +
                '<span class="col-sm-1 control-label no-padding-right"></span>' +
                '</div>' +
                '</div>';
            return html_template;
        }

        $(document).on('change', '.Imagen', function() {
            readURL(this);
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

        // Eliminar Nueva Imagen
        $(document).on('click', '.nueva_imagen', function() {
            $("input[name*=11]").val(null);
            $("#imagen_nueva").hide();
        });

    });
</script>
<style type="text/css">
    .icon-center {
        text-align: center;
    }

    .menu-cuadro {
        width: 40%;
        border: 0px solid black;
        text-align: center;
        margin-left: 7%;
    }

    .menu-cuadro:hover {
        color: #23b7e5;
    }

    .preview_producto {
        width: 100%;
    }

    .alenado-left {
        float: right;
    }

    .right {
        text-align: right;

    }

    .deletePrecio{
        background: #0f4871;
    }

    #AgregarPrecios{
        background:#82b74b;
        color:black;
    }
</style>
<!-- Main section-->
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">  
            <a name="producto/producto/index"" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Producto</button> 
            </a> 
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Editar</button>
            
        </h3>
        <div class="row" style="margin-top: -50px !important;">
            <div class="col-lg-12">

                <div class="col-lg-3">
                    <div id="" class="panel panel-default">
                        <div class="panel-heading menuTop"><i class="fa fa-pencil right"></i> Editar Producto :</div>
                        <div class="panel-body menuContent">
                            <div class="row">
                                <?php
                                $contador_break = 0;
                                if($acciones){
                                    foreach ($acciones as $key => $value) {
                                        ?>
                                        <div class="col-sm-6 menu-cuadro " id="<?php echo $value->accion_btn_css; ?>">
                                            <a href="<?php echo base_url() . $value->accion_btn_url; ?>" class="link_btn">
                                                <h1 class="icon-center">
                                                    <i class="<?php echo $value->accion_btn_icon; ?>"></i>
                                                </h1>
                                            </a>
                                            <span class="icon-center">
                                                <?php echo $value->accion_nombre; ?>
                                            </span>

                                        </div>
                                    <?php
                                    }
                                }else{
                                    ?>
                                    <div style="text-align:center">
                                        <h2 >
                                            <i class="fa fa-exclamation-triangle"></i>
                                            
                                        </h2>
                                        <label>Necesita permiso para ver esta sección.</label>
                                    </div>                                   
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <!--<div class="row">
                            <br>
                            <hr>
                            <br>
                            <div class="col-sm-12">
                                <p style="text-align: center">Producto Imagen</p>
                                <?php

                                if ($producto[0]->producto_img_blob) {
                                    ?>
                                    <img src="data: <?php echo $producto[0]->imageType ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($producto[0]->producto_img_blob) ?>" clas="preview_producto" style="width:100%" />

                                <?php
                                }

                                ?>

                            </div>
                        </div>

                        <div class="row" id="imagen_nueva">
                            <br>
                            <hr>
                            <div class="col-sm-12">
                                <p style="text-align: center">Nueva Imagen (<a href="#" class="nueva_imagen"><i class="fa fa-trash"></i> Eliminar </a>) </p>
                                <img src="" name="" id="" class="preview_producto" />
                            </div>
                        </div> -->

                    </div>
                </div>

                <form class="form-horizontal" enctype="multipart/form-data" id='producto' method="post">

                    <div class="col-lg-9">

                        <div id="" class="panel panel-default" style="margin-top: 100px;">
                            <div class="panel-heading menuTop">Producto General : </div>
                            <div class="panel-body menuContent">

                                <input type="hidden" name="empresa" value="" id="id_empresa">
                                <input type="hidden" name="id_producto" value="<?php echo $producto[0]->id_entidad; ?>" id="id_producto">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Nombre</label>
                                            <div class="col-sm-8">
                                                <input type="text" value="<?php echo $producto[0]->name_entidad; ?>" class="form-control" id="name_entidad" name="name_entidad" placeholder="Nombre Producto">

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Empresa</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="empresa" name="empresa">
                                                    <option value="<?php echo $producto[0]->id_empresa ?>"><?php echo $producto[0]->nombre_razon_social ?></option>
                                                    <?php
                                                    foreach ($empresa as $value) {
                                                        ?>
                                                        <option value="<?php echo  $value->id_empresa; ?>"><?php echo $value->nombre_razon_social; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">Giro</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="giro" name="giro">
                                                    <option value="<?php echo $producto[0]->Giro ?>"><?php echo $producto[0]->nombre_giro ?></option>
                                                    <?php
                                                    foreach ($empresa_giro as $key => $value) {
                                                        if($value->id_giro_empresa != $producto[0]->Giro ){
                                                        ?>
                                                        <option value="<?php echo $value->id_giro_empresa ?>"><?php echo $value->nombre_giro ?></option>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Categoria</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="categoria" name="categoria">
                                                    <option value="<?php echo $producto[0]->id_categoria; ?>"><?php echo $producto[0]->nombre_categoria; ?></option>
                                                    <?php
                                                    foreach ($categorias as $value) {
                                                        if ($producto[0]->id_categoria != $value->id_categoria) {
                                                            ?>
                                                            <option value="<?php echo $value->id_categoria; ?>"><?php echo $value->nombre_categoria; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Sub Categoria</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="sub_categoria" name="sub_categoria">
                                                    <option value="<?php echo $producto[0]->id_sub_categoria; ?>"><?php echo $producto[0]->SubCategoria; ?></option>
                                                    <?php
                                                    foreach ($sub_categorias as $categoria) {
                                                        if ($categoria->id_categoria != $producto[0]->id_sub_categoria) {
                                                            ?>
                                                            <option value="<?php echo $categoria->id_categoria; ?>"><?php echo $categoria->nombre_categoria; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>

                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Marca</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="Marca" name="Marca">
                                                    <option value="<?php echo $producto[0]->Marca; ?>"><?php echo $producto[0]->nombre_marca; ?></option>
                                                    <?php
                                                    foreach ($marcas as $value) {
                                                        if ($producto[0]->Marca != $value->id_marca) {
                                                            ?>
                                                            <option value="<?php echo  $value->id_marca; ?>"><?php echo $value->nombre_marca; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Proveedor1</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="proveedor1" name="proveedor1">
                                                    <option value="<?php echo $producto_proveedor[0]->id_proveedor; ?>"><?php echo $producto_proveedor[0]->empresa_proveedor; ?></option>
                                                    <?php
                                                    foreach ($proveedor as $value) {
                                                        if ($producto_proveedor[0]->id_proveedor != $value->id_proveedor) {
                                                            ?>
                                                            <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa_proveedor; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Proveedor2</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="proveedor2" name="proveedor2">
                                                    <option value="<?php echo $producto_proveedor[0]->id_proveedor; ?>"><?php echo $producto_proveedor[0]->empresa_proveedor; ?></option>
                                                    <?php
                                                    foreach ($proveedor as $value) {
                                                        if ($producto_proveedor[0]->id_proveedor != $value->id_proveedor) {
                                                            ?>
                                                            <option value="<?php echo  $value->id_proveedor; ?>"><?php echo $value->empresa_proveedor; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Estado</label>
                                            <div class="col-sm-8">

                                                <label>
                                                    <select name="producto_estado" class="form-control">
                                                        <?php
                                                        if ($producto[0]->producto_estado == 1) {
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
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Relacion</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="producto_asociado" value="<?php echo $producto[0]->id_producto_relacionado ?>" id="producto_asociado" class="form-control">

                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <?php
                                    $check_escala = "";
                                    $check_combo  = "";

                                    if ($producto[0]->Escala) {
                                        $check_escala = 'checked';
                                    }
                                    if ($producto[0]->combo) {
                                        $check_combo = 'checked';
                                    }
                                    ?>

                                    <div class="col-sm-4">
                                        
                                        <label for="inputPassword3" class=" col-sm-3 control-label no-padding-right">Escala</label>
                                        <div class=" col-sm-3">                                           
                                            
                                            <span class="inline checkbox c-checkbox">
                                                <label>
                                                    <input type='checkbox' id="todo-item-1" <?php echo $check_escala; ?> name="escala" class="">
                                                    <span class="fa fa-check"></span>
                                                </label>
                                            </span>
                                            
                                        </div>
                                    </div>

                                    <div class="col-sm-4">

                                        <label for="inputPassword3" class=" col-sm-3 control-label no-padding-right">Combo</label>
                                        <div class="col-sm-3">
                                            
                                            <span class="inline checkbox c-checkbox">
                                                <label>
                                                    <input type='checkbox' id="todo-item-1" <?php echo $check_combo; ?> name="combo" class="">
                                                    <span class="fa fa-check"></span>
                                                </label>
                                            </span>

                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Codigo</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="codigo_barras" value="<?php echo $producto[0]->codigo_barras ?>" id="codigo_barras" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Modelo</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="modelo" value="<?php echo $producto[0]->modelo ?>" id="modelo" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-0 col-sm-3 control-label no-padding-right">Costo</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="costo" value="<?php echo $producto[0]->costo ?>" id="costo" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Minimos</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="minimos" value="<?php echo $producto[0]->minimos ?>" id="minimos" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Medios</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="medios" value="<?php echo $producto[0]->medios ?>" id="medios" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-0 col-sm-3 control-label no-padding-right">Maximos</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="maximos" value="<?php echo $producto[0]->maximos ?>" id="maximos" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Ubicación</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="almacenaje" value="<?php echo $producto[0]->almacenaje ?>" id="almacenaje" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Desc. %</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="descuento_limite" value="<?php echo $producto[0]->descuento_limite ?>" id="descuento_limite" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-0 col-sm-3 control-label no-padding-right">Pre. Venta</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="precio_venta" value="<?php echo $producto[0]->precio_venta ?>" id="precio_venta" class="form-control">
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-4">
                                    <?php $tipos = array('Gravados','Exentos','No Sujeto'); ?>
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-offset-1 col-sm-3 control-label no-padding-right">Iva</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="iva" id="iva">
                                                
                                                    <option value="<?php echo $producto[0]->iva ?>"><?php echo $producto[0]->iva ?></option>
                                                    <?php 
                                                        foreach($tipos as $tipo){ 
                                                            if($tipo != $producto[0]->iva){
                                                        ?>
                                                        <option value="<?php echo $tipo ?>"><?php echo $tipo ?></option>
                                                    <?php } }?>
                                                </select>
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label no-padding-right">Incluye</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="incluye_iva" id="incluye_iva">
                                                    <?php
                                                    if($producto[0]->incluye_iva == 1){
                                                        ?>
                                                        <option value="1">Si</option>
                                                        <option value="0">No</option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="0">No</option>
                                                        <option value="1">Si</option>                                                    
                                                        <?php
                                                    }
                                                    ?>
                                                    
                                                </select>
                                            </div>
                                            <div class="col-sm-1"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-3">
                                                <input type="button" name="<?php echo base_url() ?>producto/producto/update" data="producto" class="btn btn-success enviar_data" value="Guardar">
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 alenado-left">
                        <div id="" class="panel panel-default" style="margin-top: 10px !important;">
                            <div class="panel-heading menuTop">Producto Precios : </div>
                            <div class="panel-body menuContent">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="table-responsive">
                                            <table class="table table-hover" id="preciosTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Presentacion</th>
                                                        <th>Imagen</th>
                                                        <th>Factor</th>
                                                        <th>Unidad</th>
                                                        <th>Precio</th>
                                                        <th>Code Barra</th>
                                                        <th>Cliente</th>
                                                        <th>Sucursal</th>
                                                        <th>Utilidad</th>
                                                        <th>
                                                            <div class="btn-group">
                                                                <span id="AgregarPrecios" class="btn btn-default"><i class="fa fa-plus-circle"></i></span>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="preciosTable">
                                                    <?php
                                                    $cont_table = 1;

                                                    if ($precios) {
                                                        foreach ($precios as  $precio) {

                                                            ?>
                                                            <tr id="<?php echo $cont_table ?>">
                                                                <td><?php echo $cont_table; ?></td>
                                                                <input type="hidden" name="id_producto_detalle<?php echo $cont_table ?>" value="<?php echo $precio->id_producto_detalle; ?>">
                                                                <td>
                                                                <?php if ($precio->imagen_type) : ?>
                                                                    <img src="data: <?php echo $precio->imagen_type ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($precio->imagen_presentacion) ?>" clas="preview_producto" style="width:20%;" />
                                                                <?php endif ?>
                                                                    <input type="text" size='10' class='presentacion<?php echo $cont_table ?>' name="presentacion<?php echo $cont_table ?>" value="<?php echo $precio->presentacion; ?>">
                                                                </td>
                                                                <td><input type="file" name="img<?php echo $cont_table ?>" /></td>
                                                                <td><input type="text" size='3' class='factor<?php echo $cont_table ?>' name="factor<?php echo $cont_table ?>" value="<?php echo $precio->factor; ?>"></td>
                                                                <td><input type="text" size='3' class='unidad<?php echo $cont_table ?> calculoUtilidad' name="unidad<?php echo $cont_table ?>" value="<?php echo $precio->unidad; ?>" id="<?php echo $cont_table ?>"></td>
                                                                <td><input type="text" size='4' class='precio<?php echo $cont_table ?>' name="precio<?php echo $cont_table ?>" value="<?php echo $precio->precio; ?>"></td>
                                                                <td><input type="text" size='5' class='cbarra<?php echo $cont_table ?>' name="cbarra<?php echo $cont_table ?>" value="<?php echo $precio->cod_barra; ?>"></td>
                                                                <td>
                                                                    <select name="cliente<?php echo $cont_table ?>">
                                                                        <?php
                                                                                if ($precio->Cliente == 0) {
                                                                                    ?>
                                                                            <option value="0"> - </option>
                                                                            <?php
                                                                                    }

                                                                                    foreach ($clientes as $key => $value) {
                                                                                        if ($value->id_cliente == $precio->Cliente) {
                                                                                            ?>
                                                                                <option value="<?php echo $value->id_cliente; ?>"><?php echo $value->nombre_empresa_o_compania; ?></option>
                                                                                <option value="0"> - </option>
                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    foreach ($clientes as $key => $value) {
                                                                                        if ($value->id_cliente != $precio->Cliente) {
                                                                                            ?>
                                                                                <option value="<?php echo $value->id_cliente; ?>"><?php echo $value->nombre_empresa_o_compania; ?></option>
                                                                        <?php
                                                                                    }
                                                                                }

                                                                                ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="sucursal<?php echo $cont_table ?>">
                                                                        <?php

                                                                                if ($precio->Sucursal == 0) {
                                                                                    ?>
                                                                            <option value="0"> - </option>
                                                                            <?php
                                                                                    }

                                                                                    foreach ($sucursal as $key => $value) {
                                                                                        if ($value->id_sucursal == $precio->Sucursal) {
                                                                                            ?>
                                                                                <option value="<?php echo $value->id_sucursal; ?>"><?php echo $value->nombre_sucursal; ?></option>
                                                                                <option value="0"> - </option>
                                                                            <?php
                                                                                        }
                                                                                    }

                                                                                    foreach ($sucursal as $key => $value) {
                                                                                        if ($value->id_sucursal != $precio->Sucursal) {
                                                                                            ?>
                                                                                <option value="<?php echo $value->id_sucursal; ?>"><?php echo $value->nombre_sucursal; ?></option>
                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                    </select>
                                                                </td>

                                                                <td><input type="text" size='4' class='utilidad<?php echo $cont_table ?>' name="utilidad<?php echo $cont_table ?>" value="<?php echo $precio->Utilidad; ?>"></td>
                                                                <td>
                                                                    <div class='btn-group mb-sm'>
                                                                        <span class='btn btn-warning btn-sm deletePrecio' name='<?php echo $cont_table ?>'><i class='fa fa-trash'></i></span>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                    <?php
                                                            $cont_table += 1;
                                                        }
                                                    }
                                                    $cont_table -= 1;
                                                    ?>
                                                    <input type="hidden" name="precios_contador" id="precios_contador" value="<?php echo $cont_table; ?>">
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">

                        <div id="" class="panel panel-default" style="margin-top: 10px !important;">
                            <div class="panel-heading menuTop">Producto Atributos : </div>
                            <div class="panel-body menuContent">
                                <p class="form-horizontal giro_atributos">

                                </p>
                            </div>
                        </div>

                    </div>

                </form>


            </div>
        </div>
    </div>
</section>

<!-- Modal Large-->
<div id="producto_asociado_modal" tabindex="-1" role="dialog" aria-labelledby="producto_asociado_modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 id="myModalLabelLarge" class="modal-title">Lista de Productos</h4>
            </div>
            <div class="modal-body">
                <p class="productos_lista_datos"></p>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Small-->