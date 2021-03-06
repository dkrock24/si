<script>

    function correlativo_documento(cli_form_pago, tipo_documento, sucursal_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>producto/orden/get_correlativo_documento/" + tipo_documento + "/" + sucursal_id + "/" + 0,
            datatype: 'json',
            cache: false,
            success: function(data) {
                var datos       = JSON.parse(data);
                var correlativo = datos["correlativo"];
                $("#correlativo_documento").val(correlativo[0].siguiente_valor);
            },
            error: function() {}
        });
    }

    function buscar_correlativo() {
        var cli_form_pago = $("#cliente_codigo").val();
        var tipo_documento = parseInt($("#id_tipo_documento").val());
        var sucursal_id = $("#sucursal_id").val();

        correlativo_documento(cli_form_pago, tipo_documento, sucursal_id);
    }

    $(document).ready(function() {

        var input_producto_buscar = $(".producto_buscar");
        var input_bodega_select = $("#bodega_select");
        var input_sucursal = $("#sucursal_id").val();
        var input_cantidad = $("#cantidad");

        $('#existencias').appendTo("body");
        $('#procesar_venta').appendTo("body");
        $('#cliente_modal').appendTo("body");
        $('#vendedor_modal').appendTo("body");
        $('#vendedores_modal').appendTo("body");
        $('#presentacion_modal').appendTo("body");
        $("#autorizacion_descuento").appendTo("body");
        $('#imprimir').appendTo("body");
        $('#en_proceso').appendTo("body");
        $('#en_reserva').appendTo("body");
        $('#m_orden_creada').appendTo("body");
        $('.dataSelect').hide();
        $('.dataSelect2').hide();
        $('.1dataSelect').hide();
        $('.1dataSelect2').hide();
        $('.cliente_codigo2').hide();
        $("#persona_modal").appendTo("body");

        var height = 39;

        input_producto_buscar.focus();
        bodega = input_bodega_select.val();

        var pagos_mostrados = [];
        var pagos_array = [];
        var bodega = 0;
        var _productos_precio2;
        var interno_bodega = 0;
        var producto_cantidad_linea = 1;
        var input_autorizacion_descuento = 0;
        var flag_autenticacion = false;

        getImpuestosLista();

        if (path == "../") {
            var compra = window.location.pathname.split("/").pop();
            get_compra(compra);
        }

        function get_compra(compra) {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>producto/compras/autoload_traslado",
                datatype: 'json',
                data: {
                    id: compra
                },
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var registros = datos["traslado"];

                    if (!registros) {

                        var type = "info";
                        var title = "Compra No Valida ";
                        var mensaje = "Compra Estado No Valida : get_orden";
                        var boton = "info";
                        var finalMessage = "Gracias..."

                        generalAlert(type, mensaje, title, boton, finalMessage);
                    }

                    _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);
                    _conf.impuesto = parseInt(datos['impuesto'][0].valor_conf);

                    registros.forEach(function(element) {
                        get_producto_compra(
                            element.id_producto_detalle,
                            element.cantidad_pro_compra,
                            element.presentacionUnidad
                        );
                    });

                },
                error: function() {}
            });
        }

        function get_producto_compra(producto_id, cantidad , presentacionUnidad) {

            /* 4 - Buscar producto por Id para agregarlo a la linea */
            $("#grabar").attr('disabled');
            var codigo, presentacion, tipo, precioUnidad, descuento, total

            $.ajax({
                url: "<?php echo base_url(); ?>producto/compras/get_producto_completo/" + producto_id ,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var precio_unidad = datos['producto'][0].unidad;
                    _productos_precio2 = datos["prod_precio"];
                    producto_escala = datos['producto'][0].Escala;

                    $.each(_productos_precio2, function(i, item) {
                        if (item.id_producto_detalle == producto_id) {

                            _productos_precio = item;
                        }
                    });

                    _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);
                    _conf.impuesto = parseInt(datos['impuesto'][0].valor_conf);
                    _conf.descuentos = parseInt(datos['descuentos'][0].valor_conf);

                    if (parseInt(_productos_precio.length) >= 1 && producto_escala != 1) {

                        seleccionar_productos_array(producto_id);

                    } else {
                        enLinea();
                    }

                    $("#producto").val(datos['producto'][0].unidad);
                    $("#bodega").val(datos['producto'][0].nombre_bodega);
                    $("#precioUnidad").val(_productos_precio.unidad);

                    $("#descripcion").val(datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca);
                    producto_cantidad_linea = cantidad;
                    if (input_cantidad.val() == "") {

                        producto_cantidad_linea = 1; //datos['producto'][0].factor;

                    } else {
                        _productos_precio.precio = _productos_precio.unidad * cantidad;
                    }

                    precioUnidad = _productos_precio.unidad;

                    set_calculo_precio(precioUnidad, producto_cantidad_linea);
                    //console.log("datos -", datos['producto'][0]);
                    _productos.producto_id = datos['producto'][0].id_entidad;
                    _productos.combo = datos['producto'][0].combo;
                    _productos.inventario_id = datos['producto'][0].id_inventario;
                    _productos.producto = datos['producto'][0].codigo_barras;
                    _productos.descuento_limite = datos['producto'][0].descuento_limite;
                    _productos.descuento = 0.00; // datos['producto'][7].valor;
                    _productos.cantidad = cantidad;
                    _productos.total = 0.00; //$("#total").val();
                    _productos.id_producto_combo = null;
                    _productos.combo_total = null;
                    _productos.invisible = 0;
                    _productos.bodega = datos['producto'][0].nombre_bodega;
                    _productos.id_bodega = datos['producto'][0].id_bodega;
                    _productos.impuesto_id = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                    _productos.por_iva = datos['producto'][0].porcentage;
                    _productos.gen = datos['producto'][0].iva;
                    _productos.iva = datos['producto'][0].incluye_iva; //datos['producto'][9].valor;
                    _productos.descripcion = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                    _productos.total = _productos_precio.precio;
                    _productos.categoria = datos['producto'][0].categoria;
                    _productos.presentacionUnidad = presentacionUnidad;

                    grabar();
                    _config_impuestos();
                    agregar_producto();
                    depurar_producto();

                    producto_cantidad_linea = 1;

                },
                error: function() {
                    alert("Error : Verificar Producto y Bodega");
                }
            });

        }

        function getImpuestosLista() {
            /** Load Impuestos everytime */

            $.ajax({
                url: "<?php echo base_url(); ?>producto/compras/get_impuestos_lista",
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);

                    _impuestos['cat'] = datos["impuesto_categoria"];
                    _impuestos['cli'] = datos["impuesto_cliente"];
                    _impuestos['doc'] = datos["impuesto_documento"];
                    _impuestos['pro'] = datos["impuesto_proveedor"];

                },
                error: function() {}
            });

        }

        $(document).on('keypress', '.existencia_buscar', function(e) {
            /* Filtro de productos Existencias */

            var busqueda_texto = $(".existencia_buscar").val();

            if (busqueda_texto.length != 0) {

                if ($(".existencia_buscar").is(":focus")) {

                    if (e.keyCode == 13) {

                        get_existencia(this.value);
                    }
                }

            } else {
                $('.dos').empty();
            }
        });

        function get_existencia(texto) {
            /** Load existencias - Producto filtrados */

            sucursal = input_sucursal;
            var bodega = input_bodega_select.val();

            interno_sucursal = sucursal;
            interno_bodega = bodega;

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>producto/compras/get_productos_lista",
                datatype: 'json',
                data: {
                    sucursal: sucursal,
                    bodega: bodega,
                    texto: texto
                },
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var productos = datos["productos"];

                    if (productos != "") {

                        var producto_id = 0;
                        _productos_lista = productos;

                        existencia_buscar(_productos_lista, texto);
                    } else {

                        var type = "info";
                        var title = "Verifique Sucursal y Bodega ";
                        var mensaje = "Error en Parametros : search_texto";
                        var boton = "info";
                        var finalMessage = "Gracias..."
                        generalAlert(type, mensaje, title, boton, finalMessage);

                    }

                },
                error: function() {}
            });
        }

        function existencia_buscar(_productos_lista, texto) {

            var table_tr = "";
            var producto_id = 0;
            var contador_precios = 1;

            interno_bodega = bodega;

            $.each(_productos_lista, function(i, item) {

                producto_id = item.id_entidad;
                precio = parseInt(item.precio_venta);
                table_tr += '<option value="' + item.id_entidad + '">' + item.nombre_marca + ' ' + item.name_entidad + ' - ' + item.presentacion + ' - ' + precio.toFixed(2) + '</option>';
                contador_precios++;

                $('.1dataSelect').show();
            });

            $(".1dataSelect").html(table_tr);

            $('.1dataSelect').focus();
            document.getElementById('1dataSelect').selectedIndex = 0;

        }

        $(document).on('keypress', '.1dataSelect', function() {

            if (event.which == 13) {
                get_producto_completo2(this.value);
                event.preventDefault();
                input_producto_buscar.empty();
                $('.1dataSelect').hide();
                $('.1dataSelect').empty();
                $(".existencia_buscar").focus();
                $(".existencia_buscar").select();
            }

        });

        $(document).on('keydown', '.existencia_buscar', function() {
            /* Validar Codigo Flecha Abajo - Modal Existencias */
            $(".existencia_buscar").focus();
            if (event.keyCode == 40) {
                $('.1dataSelect').focus();
                document.getElementById('1dataSelect').selectedIndex = 0;
            }
        });

        function get_producto_completo2(producto_id) {
            /* Mostrar Existencias */
            $("#grabar").attr('disabled');
            var codigo, presentacion, tipo, precioUnidad, descuento, total

            /*
             * Identificadores de valores del producto
             * 1 = Presentacion / 10 = Modelo / 14 = Costo / 18 = Almacenaje / 19 = Minimos
             * 20 = Medios / 21= maximos / 22 = Descuento Limite / 23 = Precio Venta
             * 24 = Iva / 26 = Incluye / 11 = Imagen / 4 = Cod_Barras
             */

            $.ajax({
                url: "<?php echo base_url(); ?>producto/existencias/get_producto_completo/" + producto_id,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var html = '';
                    var datos = JSON.parse(data);
                    var contador = 1;
                    var existencias_total = 0;

                    $.each(datos['producto'], function(i, item) {

                        existencias_total += parseInt(item.Cantidad);
                        if ($('#sucursal_id2').val() == item.id_sucursal) {
                            html += '<tr style="background:#none;color:black;">';
                        } else {
                            html += '<tr>';
                        }
                        html += '<td>' + contador + '</td>';
                        html += '<td>' + item.nombre_sucursal + '</td>';
                        html += '<td>' + item.nombre_bodega + '</td>';
                        html += '<td>' + item.Cantidad + '</td>';
                        html += '<td>' + item.moneda_simbolo + " " + Number(item.precio).toFixed(2) + '</td>';
                        html += '<td>' + 0.00 + '</td>';
                        html += '<td>' + item.moneda_simbolo + " " + Number(item.Utilidad).toFixed(2) + '</td>';
                        html += '<td>' + item.cod_barra + '</td>';
                        html += '</tr>';
                        contador++;
                    });
                    html += '<tr style="background:#0f4871;color:white;"><td colspan="3">TOTAL</td><td>' + existencias_total + '</td><td colspan="4"></td></tr>'
                    $('.dos').html(html);

                },
                error: function() {
                    alert("Error Conexion1");
                }
            });
        }

        $(document).on('keypress', '.producto_buscar', function(e) {
            /* 1 - Input Buscar Producto */

            var texto_busqueda = input_producto_buscar.val();

            if (texto_busqueda.length != 0) {

                if (input_producto_buscar.is(":focus")) {

                    if (e.keyCode == 13) {

                        search_texto(input_producto_buscar.val());

                    }
                }

            } else {
                $('.dataSelect').empty();
                $('.dataSelect').hide();
            }
        });

        function search_texto(texto) {
            /* 2 - Filtrado del texto a buscar en productos */

            sucursal        = input_sucursal;
            var bodega      = input_bodega_select.val();
            interno_sucursal= sucursal;
            interno_bodega  = bodega;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>producto/compras/get_productos_lista",
                datatype: 'json',
                data: {
                    texto: texto
                },
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var productos = datos["productos"];

                    if (productos != "") {

                        var producto_id = 0;
                        _productos_lista = productos;

                        showProducts(_productos_lista);
                    } else {

                        var type = "info";
                        var title = "Verifique Sucursal y Bodega ";
                        var mensaje = "Error en Parametros : search_texto";
                        var boton = "info";
                        var finalMessage = "Gracias..."
                        generalAlert(type, mensaje, title, boton, finalMessage);

                    }

                },
                error: function() {}
            });


        }

        function showProducts(_productos_lista) {

            var producto_id = 0;
            var contador_precios = 1;
            interno_bodega = bodega;
            var table_tr = "";
            $(".dataSelect").html(table_tr);

            if (_productos_lista.length == 1) {

                get_producto_completo(_productos_lista[0].id_producto_detalle);
                input_producto_buscar.val("");

            } else {

                var prod_escala_prev = 0;
                var prod_escala_next = 0;
                var prod_escala_cont = 0;
                var prod_temp_id = 0;

                $.each(_productos_lista, function(i, item) {

                    if (item.precio_venta != 0) {
                        prod_escala_prev = item.id_entidad;

                        if (prod_escala_prev != prod_escala_next || item.Escala == 0) {
                            prod_escala_next = item.id_entidad;
                            prod_temp_id = item.id_producto_detalle;
                            producto_id = item.id_entidad;
                            precio = parseFloat(item.precio);
                            table_tr += '<option value="' + item.id_producto_detalle + '">' + item.nombre_marca + ' ' + item.name_entidad + ' - ' + item.presentacion + ' - ' + precio.toFixed(2) + '</option>';
                            contador_precios++;
                            prod_escala_cont++;
                        }
                    }
                });

                if (prod_escala_cont <= 1) {
                    get_producto_completo(prod_temp_id);
                    input_producto_buscar.val("");

                } else {

                    $('.dataSelect').show();
                    $(".dataSelect").html(table_tr);
                    document.getElementById('dataSelect').selectedIndex = 0;
                    document.getElementById('dataSelect').focus();

                }


            }
        }

        $(document).on('keydown', '.producto_buscar', function() {

            if (event.keyCode == 40) {
                $('.dataSelect').focus();
                document.getElementById('dataSelect').selectedIndex = 0;
            }
        });

        /* 3 - Selecionado Producto de la lista y precionando ENTER */
        $(document).on('keypress', '.dataSelect', function() {

            if (event.which == 13) {
                get_producto_completo(this.value);
                event.preventDefault();
                $('#dataSelect').hide();
                $('#dataSelect').empty();
                input_producto_buscar.val("");
            }

        });

        function get_producto_completo(producto_id) {

            /* 4 - Buscar producto por Id para agregarlo a la linea */
            $("#grabar").attr('disabled');
            var codigo, presentacion, tipo, precioUnidad, descuento, total

            interno_bodega = input_bodega_select.val();

            if (!interno_bodega) {

                var type = "info";
                var title = "Verifique Sucursal y Bodega ";
                var mensaje = "Error en Parametros : get_producto_completo";
                var boton = "info";
                var finalMessage = "Gracias..."
                generalAlert(type, mensaje, title, boton, finalMessage);

                return;
            }

            $.ajax({
                url: "<?php echo base_url(); ?>producto/compras/get_producto_completo/" + producto_id,
                datatype: 'json',
                cache: false,

                success: function(data) {                   

                    var datos           = JSON.parse(data);
                    var precio_unidad   = datos['producto'][0].unidad;
                    _productos_precio2  = datos["prod_precio"];
                    producto_escala     = datos['producto'][0].Escala;

                    $.each(_productos_precio2, function(i, item) {
                        if (item.id_producto_detalle == producto_id) {
                            _productos_precio = item;
                        }
                    });

                    _conf.impuesto      = parseInt(datos['impuesto'][0].valor_conf);
                    _conf.descuentos    = parseInt(datos['descuentos'][0].valor_conf);
                    _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);

                    if (parseInt(_productos_precio.length) >= 1 && producto_escala != 1) {
                        seleccionar_productos_array(producto_id);
                    } else {
                        enLinea();
                    }

                    $("#producto").val(datos['producto'][0].unidad);
                    $("#bodega").val(datos['producto'][0].nombre_bodega);
                    $("#precioUnidad").val(_productos_precio.unidad);

                    $("#descripcion").val(datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca);

                    if (input_cantidad.val() == "") {
                        producto_cantidad_linea = 1; //datos['producto'][0].factor;
                    } else {
                        _productos_precio.precio = _productos_precio.precio * producto_cantidad_linea;
                    }

                    precioUnidad = _productos_precio.unidad;
                    set_calculo_precio(precioUnidad, producto_cantidad_linea);
                    _productos.producto_id      = datos['producto'][0].id_entidad;
                    _productos.combo            = datos['producto'][0].combo;
                    _productos.inventario_id    = datos['producto'][0].id_inventario;
                    _productos.producto         = datos['producto'][0].codigo_barras;
                    _productos.descuento_limite = datos['producto'][0].descuento_limite;
                    _productos.descuento        = 0.00; // datos['producto'][7].valor;
                    _productos.cantidad         = producto_cantidad_linea;
                    _productos.total            = 0.00; //$("#total").val();
                    _productos.id_producto_combo= null;
                    _productos.combo_total      = null;
                    _productos.invisible        = 0;
                    _productos.bodega           = datos['producto'][0].nombre_bodega;
                    _productos.id_bodega        = $("#bodega_select").val();
                    _productos.impuesto_id      = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                    _productos.por_iva          = datos['producto'][0].porcentage;
                    _productos.gen              = datos['producto'][0].iva;
                    _productos.iva              = datos['producto'][0].incluye_iva; //datos['producto'][9].valor;
                    _productos.descripcion      = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                    _productos.total            = _productos_precio.precio;
                    _productos.categoria    = datos['producto'][0].categoria;

                    grabar();

                    _config_impuestos();
                    agregar_producto();
                    depurar_producto();

                    producto_cantidad_linea = 1;

                },
                error: function() {
                    alert("Error : Verificar Producto y Bodega");
                }
            });

        }

        function enLinea() {

            $("#presentacion").val(_productos_precio.presentacion);
            $("#factor").val(_productos_precio.factor);
            _productos.producto2            = _productos_precio.id_producto_detalle;
            _productos.presentacion         = _productos_precio.presentacion;
            _productos.precioUnidad         = _productos_precio.unidad;
            _productos.presentacionFactor   = _productos_precio.factor;
            _productos.presentacionPrecio   = _productos_precio.precio
            _productos.presentacionUnidad   = _productos_precio.unidad;
            _productos.presentacionCliente  = _productos_precio.Cliente;
            _productos.id_producto_detalle  = _productos_precio.id_producto_detalle;
            _productos.presentacionCodBarra = _productos_precio.cod_barra;
        }

        function validar_escalas(c) {
            /* Valida las escalas de los productos cuando se aunmenta la cantidad */
            var total_precio_escala = 0;
            $.each(_productos_precio2, function(i, item) {

                pf = parseInt(item.factor);

                if (c == pf) {                    
                    _productos.producto             = item.cod_barra;
                    total_precio_escala             = item.unidad;
                    _productos.precioUnidad         = item.unidad;
                    _productos.presentacion         = item.presentacion;
                    _productos.presentacionFactor   = item.factor;
                    _productos.id_producto_detalle  = item.id_producto_detalle;
                    _productos.presentacionCodBarra = item.cod_barra;
                    $("#presentacion").val(item.presentacion);
                    $("#factor").val(item.factor);                    

                } else {                    
                    if (c >= pf) {
                        _productos.producto             = item.cod_barra;
                        total_precio_escala             = item.unidad;
                        _productos.precioUnidad         = item.unidad;
                        _productos.presentacion         = item.presentacion;
                        _productos.presentacionFactor   = item.factor;
                        _productos.id_producto_detalle  = item.id_producto_detalle;
                        _productos.presentacionCodBarra = item.cod_barra;
                        $("#presentacion").val(item.presentacion);
                        $("#factor").val(item.factor);
                    }
                }
            });
            return total_precio_escala;
        }

        $(document).on('keypress', '.dataSelect2', function() {
            /* 6 - Selecionado Presentacion de la lista y precionando ENTER */
            if (event.which == 13) {
                var precio_id = this.value;
                event.preventDefault();
                $('.dataSelect2').hide();
                $('.dataSelect2').empty();
                $("#grabar").focus();

                seleccionar_productos_array(precio_id);
            }
        });

        /* CONTROL DE ACCESOS DIRECTOS */

        jQuery(document).ready(function() {

            var currCell = $('.producto_agregados > tr').first();
            var editing = false;
            var id_celda = 0;

            $(document).on("click", "tr", function() {
                $('tr').css('background', 'none');
                $('tr').css('color', 'black');

                id_celda = $(this).attr('name');

                $(this).css('background', '#c4e0b3');
                $(this).css('color', 'black');

                currCell = $(this);

                currCell.focus();
                var producto_imagen_id = $(this).attr('id');
                //imagen(producto_imagen_id);
            });

            function imagen(producto_imagen_id) {
                getImagen(producto_imagen_id);
            }

            function moveCursorToEnd(input_producto_buscar) {
                var v = input_producto_buscar.val();
                input_producto_buscar.val("Demo").focus().val(v);
            }

            function focus_general_input(input, valor) {

                input.focus();

                if (valor == 0) {

                    setTimeout(function() {
                        input.val("");
                    }, 50);
                } else {

                    input.focus().val();
                }

            }


            document.onkeydown = function(e) {
                //productos_tabla

                switch (e.keyCode) {
                    case 37: //alert('left');                  
                        input_producto_buscar.focus();
                        moveCursorToEnd(input_producto_buscar);
                        break;
                    case 38: //alert('up');                        
                        break;
                    case 111: // / ;
                        focus_general_input(input_cantidad, 1);
                        break;
                    case 40:
                        //alert('down');
                        break;
                    case 91: // F1                        
                        $("#documentoModel").modal();
                    case 113: // F2                        
                        producto_tabla_foco();
                        break;
                    case 114: //F3                        
                        eliminar_elemento_tabla(id_celda);
                        break;
                    case 115: //F4                        
                        f4_guardar();
                        break;
                    case 118: //F7                        
                        f7_foco_efectivo();
                        break;
                    case 119: //F8
                        show_existencias();
                        break;
                    case 177: //
                        f8_table_pagos();
                        break;
                    case 106: // *
                        focus_general_input($("#orden_numero"), 0);
                        break;
                    case 190: // *
                        focus_general_input($("#descuento"), 0);
                        break;

                }

                var c = "";
                if (e.keyCode == 39) {
                    // Right Arrow
                    c = currCell.next();
                } else if (e.keyCode == 37) {
                    // Left Arrow
                    c = currCell.prev();
                } else if (e.keyCode == 38) {

                    // Up Arrow
                    c = currCell.closest('tr').prev().find('td:eq(' +
                        currCell.index() + ')');

                    height -= 39;

                    //$('.lista_productos').animate({scrollIntoView: height}, 1);                        

                    id_celda = $(currCell.closest('tr').prev()).attr('name');

                    var pagoLinea = $(currCell.closest('tr').prev()).attr('id');
                    pagoLinea = parseInt(pagoLinea);
                    $("input[name=pagoInput" + pagoLinea + "]").focus();

                    $('tr').css('background', 'none');
                    $('tr').css('color', 'black');

                    if ($(currCell.closest('tr')).attr('id')) {
                        imagen($(currCell.closest('tr').prev()).attr('id'));
                    }

                    $('.lista_productos').animate({
                        scrollTop: height
                    }, 1);


                } else if (e.keyCode == 40) {
                    // Down Arrow                   

                    c = currCell.closest('tr').next().find('td:eq(' +
                        currCell.index() + ')');

                    $('.lista_productos').animate({
                        scrollIntoView: height
                    }, 1);
                    height += 39;

                    id_celda = $(currCell.closest('tr').next()).attr('name');

                    var pagoLinea = $(currCell.closest('tr')).attr('id');
                    pagoLinea = parseInt(pagoLinea) + 1;
                    $("input[name=pagoInput" + pagoLinea + "]").focus();

                    $('tr').css('background', 'none');
                    $('tr').css('color', 'black');

                    if ($(currCell.closest('tr')).attr('id')) {
                        imagen($(currCell.closest('tr').next()).attr('id'));
                    }

                    $('.lista_productos').animate({
                        scrollTop: height
                    }, 1);


                } else if (!editing && (e.keyCode == 13 || e.keyCode == 32)) {
                    // Enter or Spacebar - edit cell
                    //e.preventDefault();
                    //edit();
                } else if (!editing && (e.keyCode == 9 && !e.shiftKey)) {
                    // Tab
                    //e.preventDefault();
                    //c = currCell.next();
                } else if (!editing && (e.keyCode == 9 && e.shiftKey)) {
                    // Shift + Tab
                    e.preventDefault();
                    c = currCell.prev();
                }

                // If we didn't hit a boundary, update the current cell
                if (c.length > 0) {
                    currCell.parent().css('background', 'none');
                    currCell.parent().css('color', '#131e26');

                    //$('tr').css('color','#131e26');
                    currCell = c;
                    var x = currCell.parent().index();
                    currCell.focus();

                    currCell.parent().css('background', '#0f4871');
                    currCell.parent().css('color', 'black');
                }
            }


            $('#edit').keydown(function(e) {
                if (editing && e.which == 27) {
                    editing = false;
                    $('#edit').hide();
                    currCell.toggleClass("editing");
                    currCell.focus();
                }
            });

            function producto_tabla_foco() {

                //$("#lista_productos").select();
                $('.lista_productos').focus();

                $(this).css("background", "red");

                $('.lista_productos').animate({
                    scrollTop: 0
                }, 100);

                currCell = $('.producto_agregados > tr').first();

                $('tr').css('background', 'none');
                $('tr').css('color', 'black');
                id_celda = $(currCell).attr('name');
                $(currCell).css('background', '#0f4871');
                $(currCell).css('color', 'black');
                //currCell.focus();

            }

            function f7_foco_efectivo() {
                $("#extraMetodoPago").focus();
            }

            function f8_table_pagos() {
                $("input[name=pagoInput1]").focus();
                currCell = $('.pagos_tabla').first();
                id_celda = $(currCell).attr('name');
                currCell.focus();
                $(currCell).css('background', '#0f4871');
                $(currCell).css('color', '#fff');
            }

        });


        /* FIN DE ACCESOS DIRECTOS */

        $(document).keypress(function(e) {
            if (e.keyCode == 43) { // 43(+)

                //var x = e.keyCode; 
                //var y = String.fromCharCode(x);

                $("#grabar").focus();
            }
            if (e.keyCode === 38) { // 46(.)   32(espacio)  

                if (_productos.presentacion != null) {
                    grabar();
                }
            }
            if (e.keyCode === 95) { // 95(-)

                $("#btn_delete").focus();

                $("#eliminar").css("background", "black");

                $("button[type=button]").focus(function() {

                    $(this).css("background", "#27c24c");
                });

                $("button[type=button]").blur(function() {

                    $(this).css("background", "#6964bb");
                });

            }
        });

        $("input[type=text]").focus(function() {
            $(this).css("background", "#0f4871");
            $(this).css("color", "white");

            $('.dataSelect2').hide();
        });
        $("input[type=text]").blur(function() {
            $(this).css("background", "white");
            $(this).css("color", "black");
        });

        $("input[type=number]").focus(function() {
            $(this).css("background", "#0f4871");
            $(this).css("color", "white");
        });

        $("input[type=number]").blur(function() {
            $(this).css("background", "white");
            $(this).css("color", "black");
        });

        $("button[type=button]").focus(function() {

            $(this).css("background", "#27c24c");
        });

        $("button[type=button]").blur(function() {

            $(this).css("background", "#6964bb");
        });

        function seleccionar_productos_array(precio_id) {

            $.each(_productos_precio, function(i, item) {

                if (precio_id == item.id_producto_detalle) {

                    _productos.presentacion         = item.presentacion;
                    _productos.id_producto_detalle  = item.id_producto_detalle;
                    _productos.presentacionFactor   = item.factor;
                    _productos.presentacionPrecio   = item.precio;
                    _productos.presentacionUnidad   = item.unidad;
                    _productos.presentacionCliente  = item.Cliente;
                    _productos.presentacionCliente  = item.Sucursal;
                    _productos.presentacionCodBarra = item.cod_barra;
                    _productos.precioUnidad         = item.unidad;
                    _productos.total                = item.precio;
                    _productos.producto2            = item.id_producto_detalle

                    $("#presentacion").val(_productos.presentacion);
                    $("#precioUnidad").val(_productos.presentacionUnidad);
                    $("#factor").val(item.factor);

                    set_calculo_precio(item.unidad, item.factor);
                }
            });
        }

        $(document).on('click', '#grabar', function() {

            grabar();

            if (_conf.impuesto == 1) {
                _config_impuestos();
                depurar_producto();
            }

        });

        function grabar() {
            // 7 - Grabar producto en la orden
            $('.lista_productos').animate({
                scrollTop: height
            }, 500);
            height += 39;

            input_producto_buscar.empty();
            input_producto_buscar.focus();
            if (_productos.cantidad != null) {

                // Verificar si se tiene permiso de descuento
                check_descuento_permiso();

                if (contador_productos == 0) {

                    grabar_combo();
                    grabar_primeraves();


                } else {
                    grabar_mas();

                    if (_conf.impuesto == 1) {
                        _config_impuestos();
                        depurar_producto();
                    }
                }
            }

            $('.uno').find('input').each(function() {

                this.value = '';
                $("#grabar").val("Agregar");
                //$("#cantidad").val(1);
            });

        }

        function check_descuento_permiso() {

            if (_conf.descuentos == 1) {

                // Validar Descuento 
                if (flag_autenticacion) {
                    _productos.descuento = $("#descuento").val();
                } else {
                    _productos.descuento = 0.00;
                }

            } else {
                // Aplicar Descuento sin validacion
                _productos.descuento = $("#descuento").val();
            }

        }

        $(document).on('click', '#btn_discount', function() {

            // Descuento Aprobacion flag_autenticacion

            $("#autorizacion_descuento").modal();

        });

        $(".btn_aut_desc").click(function() {

            var user = input_autorizacion_descuento = $("#input_autorizacion_descuento").val();
            var passwd = input_autorizacion_descuento = $("#input_autorizacion_passwd").val();

            autenticar_usuario_descuento(user, passwd);

        });

        function autenticar_usuario_descuento(user, passwd) {

            if (user && passwd) {

                $.ajax({
                    type: 'POST',
                    data: {
                        user: user,
                        passwd: passwd,
                    },
                    dataType: 'json',
                    url: "autenticar_usuario_descuento",

                    success: function(data) {

                        flag_autenticacion = data;

                        if (flag_autenticacion) {
                            $("#btn_discount").css("background", "orange");
                        }

                    },
                    error: function() {
                        alert("Error En autenticar_usuario_descuento");
                    }
                });
            }
        }

        function grabar_primeraves() {

            var cantidad = parseInt(_productos.cantidad);
            //validar_escalas(cantidad);
      
            _orden[contador_productos]      = _productos;
            _productos.descuento_calculado  = calcular_descuento(_productos.descuento, _productos.total, _productos.descuento_limite);

            agregar_producto();
        }

        function grabar_mas() {
            var existe = 0;
            var cnt = 0;

            if (_productos != "") {

                contador_productos = _orden.length;

                if (_orden.length >= 1) {

                    $.each(_orden, function(i, item) {

                        // Validar productos similares para agupacion
                        if (item.producto2 == _productos.producto2 && (item.id_producto_combo == null || item.id_producto_combo == 0)) {
                            existe = 1;

                            var cantidad = parseInt(_productos.cantidad) + parseInt(item.cantidad);
                            if (cantidad <= 0) {
                                cantidad = 1;
                            }

                            if (producto_escala != 0) {

                                //var c = validar_escalas(cantidad);
                                //_orden[cnt].precioUnidad        = c;
                                _orden[cnt].presentacion        = _productos.presentacion;
                                _orden[cnt].presentacionFactor  = _productos.presentacionFactor;
                                _orden[cnt].id_producto_detalle = _productos.id_producto_detalle;
                                _orden[cnt].producto            = _productos.producto;

                                var total_temp = calcularTotalProducto(_orden[cnt].precioUnidad, cantidad);
                                $(".total" + _orden[cnt]['producto2']).text(total_temp);
                                _orden[cnt]['total'] = total_temp;
                            } else {

                                if (item.combo != 1) {
                                    var total_temp = calcularTotalProducto(item.presentacionPrecio, cantidad);
                                }
                            }
                            _orden[cnt]['total']    = total_temp;
                            _orden[cnt]['cantidad'] = cantidad;

                            if ($("#descuento").val() != "") {
                                _orden[cnt].descuento = $("#descuento").val();
                            }

                            _orden[cnt].descuento_calculado = calcular_descuento(_orden[cnt].descuento, _orden[cnt].total, _orden[cnt].descuento_limite);

                            if (item.combo == 1) {
                                var t = (_orden[cnt].precioUnidad * cantidad);

                                if (_conf.comboAgrupado == 1) {
                                    _orden[cnt].descuento_calculado = calcular_descuento(_orden[cnt].descuento, t, _orden[cnt].descuento_limite);

                                } else {
                                    var x = _orden[cnt].combo_total * _orden[cnt].cantidad;
                                    _orden[cnt].descuento_calculado = calcular_descuento(_orden[cnt].descuento, x, _orden[cnt].descuento_limite);
                                }
                                _orden[cnt].total = _orden[cnt].precioUnidad * _orden[cnt].cantidad;
                                //recalcular_factor_combo( item.id_producto_detalle , cantidad  );
                            }
                            calculo_totales();
                            depurar_producto();
                        }
                        cnt++;
                    });
                } else {
                    grabar_combo();

                    _productos.descuento = $("#descuento").val();
                    _productos.descuento_calculado = calcular_descuento(_productos.descuento, _productos.total, _productos.descuento_limite);

                    _orden[contador_productos] = _productos;
                    agregar_producto();
                }
            }
            if (existe == 0) {
                grabar_combo();

                _productos.descuento = $("#descuento").val();
                _productos.descuento_calculado = calcular_descuento(_productos.descuento, _productos.total, _productos.descuento_limite);

                _orden[contador_productos] = _productos;
                agregar_producto();
                existe = 0;
            }
        }

        function grabar_combo() {
            if (_productos.combo == 1) {
                combo_descuento = $("#descuento").val();
                producto_combo(_productos.producto_id, _productos.id_bodega, _productos.id_producto_detalle);
            }
        }
        // ------------------  COMBO
        function producto_combo(producto_id, id_bodega, id_producto_detalle) {

            $.ajax({
                type: 'POST',
                data: {
                    id_bodega:          id_bodega,
                    producto_id:        producto_id,
                    id_producto_detalle:id_producto_detalle
                },
                url: path + "producto_combo",

                success: function(data) {
                    var productoX = JSON.parse(data);

                    if (_conf.comboAgrupado == 0) {
                        agregar_directo(id_producto_detalle, productoX);
                    } else {
                        agregar_agrupado(id_producto_detalle, productoX);
                        agregar_invisible(id_producto_detalle, productoX);
                    }
                },
                error: function() {
                    alert("Error En Combo");
                }
            });
        }

        function combo_recalculo_cantidad(id_producto_detalle) {
            var cant;
            _orden.forEach(function(element) {
                if (element.id_producto_detalle == id_producto_detalle) {
                    cant = element.cantidad;
                }
            });
            return cant;
        }

        function agregar_directo(id_producto_detalle, p) {
            var combo_padre_total = 0;

            p.forEach(function(datos) {
                var cantidad_final = combo_recalculo_cantidad(id_producto_detalle);
                _productos.descuento_calculado  = 0;
                _productos.id_producto_combo    = id_producto_detalle;
                _productos.id_producto_detalle  = datos['precios'][0].id_producto_detalle;
                _productos.descuento_limite     = datos['atributos'].Descuento_Limite;
                _productos.presentacionCliente  = datos['prod_precio'][0].Cliente;
                _productos.presentacionCodBarra = datos['precios'][0].cod_barra;
                _productos.presentacionPrecio   = datos['precios'][0].precio;
                _productos.presentacionUnidad   = datos['precios'][0].unidad;
                _productos.combo_total          = null;
                _productos.producto2            = datos['precios'][0].id_producto_detalle;
                _productos.producto_id          = datos['producto'][0].id_entidad;
                _productos.combo                = datos['producto'][0].combo;
                _productos.inventario_id        = datos['producto'][0].id_inventario;
                _productos.producto             = datos['atributos'].Cod_Barras;
                _productos.descuento            = 0.00;
                _productos.invisible            = 0;
                _productos.cantidad             = parseInt(datos['combo_cantidad']) * cantidad_final;
                _productos.precioUnidad         = datos['prod_precio'][0].precio;
                _productos.bodega               = datos['producto'][0].nombre_bodega;
                _productos.id_bodega            = datos['producto'][0].id_bodega;
                _productos.impuesto_id          = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                _productos.por_iva              = datos['producto'][0].porcentage;
                _productos.gen                  = datos['producto'][10].valor;
                _productos.iva                  = datos['atributos']['Incluye Iva']; //datos['producto'][9].valor;
                _productos.descripcion          = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                _productos.presentacion         = datos['producto'][0].valor;
                _productos.total                = (datos['prod_precio'][0].precio * _productos.cantidad);
                _productos.presentacionFactor   = (datos['combo_cantidad'] * producto_cantidad_linea);

                if (combo_descuento) {
                    combo_total += _productos.total;
                    combo_padre_total += _productos.total;
                } else {
                    combo_padre_total += _productos.total;
                }

                if (datos != null) {
                    var tr_html = "<tr class='yxy' style=''>";
                    tr_html += "<td class='border-table-left'>" + contador_tabla + "</td>";
                    tr_html += "<td class='border-left'>" + _productos.producto + "</td>";
                    tr_html += "<td class='border-left'>" + _productos.descripcion + "</td>";
                    tr_html += "<td class='border-left " + _productos.producto2 + "'>" + _productos.cantidad + "</td>";
                    tr_html += "<td class='border-left presentacion" + _productos.producto2 + "'>" + _productos.presentacion + "</td>";
                    tr_html += "<td class='border-left factor" + _productos.producto2 + "'>" + _productos.presentacionFactor + "</td>";
                    tr_html += "<td class='border-left precioUnidad" + _productos.producto2 + "'>" + _productos.precioUnidad + "</td>";
                    tr_html += "<td class='border-left'>" + _productos.descuento_calculado + "</td>";
                    tr_html += "<td class='border-left total" + _productos.producto2 + "'>" + _productos.total + "</td>";
                    tr_html += "<td class='border-left '>" + _productos.bodega + "</td>";
                    if (_productos.combo) {
                        tr_html += "<td class='border-left'><input type='button' class='btn btn-primary btn-xs eliminar' name='" + _productos.id_producto_detalle + "' id='eliminar' value='Eliminar'/></td>";
                    } else {
                        tr_html += "<td class='border-left'> - </td>";
                    }

                    tr_html += "</tr>";

                    $(".producto_agregados").append(tr_html);
                }

                contador_productos = _orden.length;
                _orden[contador_productos] = _productos;
                _productos = {};

                calculo_totales();

            });
            if (combo_total) {
                recalcular_descuento_combo(id_producto_detalle, combo_total, combo_descuento);
            }
            sumar_combo_total(combo_padre_total, id_producto_detalle);

            if (_conf.impuesto == 1) {
                _config_impuestos();
                depurar_producto();
            }

        }

        function sumar_combo_total(combo_padre_total, id_producto_detalle) {
            _orden.forEach(function(element) {
                if (element.id_producto_detalle == id_producto_detalle) {
                    _orden[_orden.indexOf(element)].combo_total = combo_padre_total;
                }
            });
            depurar_producto();
        }

        function agregar_agrupado(id_producto_detalle, p) {
            var sub_total;
            var unidad;

            p.forEach(function(datos) {

                _orden.forEach(function(element) {
                    if (element.id_producto_detalle == id_producto_detalle) {
                        var id = _orden.indexOf(element);

                        sub_total = (datos['combo_cantidad'] * datos['prod_precio'][0].precio);

                        _orden[id].total = parseInt(_orden[id].total) + (parseFloat(sub_total) * _orden[id].cantidad);

                        _orden[id].precioUnidad = parseFloat(_orden[id].precioUnidad) + parseFloat(sub_total);

                        _orden[id].combo_total = parseInt(_orden[id].total) + (parseFloat(sub_total) * _orden[id].cantidad);

                        recalcular_descuento_combo(id_producto_detalle, _orden[id].total, _orden[id].descuento);

                        _orden[id].descuento_calculado = calcular_descuento(_orden[id].descuento, _orden[id].total, _orden[id].descuento_limite);
                    }
                });
                calculo_totales();
            });

            if (_conf.impuesto == 1) {
                impuestos();
            }
            depurar_producto();
        }

        function agregar_invisible(id_producto_detalle, p) {
            var combo_padre_total = 0;

            p.forEach(function(datos) {
                var cantidad_final = combo_recalculo_cantidad(id_producto_detalle);
                _productos.descuento_calculado      = 0;
                _productos.id_producto_combo        = id_producto_detalle;
                _productos.id_producto_detalle      = datos['precios'][0].id_producto_detalle;
                _productos.descuento_limite         = datos['atributos'].Descuento_Limite;
                _productos.presentacionCliente      = datos['prod_precio'][0].Cliente;
                _productos.presentacionCodBarra     = datos['precios'][0].cod_barra;
                _productos.presentacionPrecio       = datos['precios'][0].precio;
                _productos.presentacionUnidad       = datos['precios'][0].unidad;
                _productos.combo_total              = null;
                _productos.producto2                = datos['precios'][0].id_producto_detalle;
                _productos.producto_id              = datos['producto'][0].id_entidad;
                _productos.combo                    = datos['producto'][0].combo;
                _productos.inventario_id            = datos['producto'][0].id_inventario;
                _productos.producto                 = datos['atributos'].Cod_Barras;
                _productos.descuento                = 0.00;
                _productos.cantidad                 = parseInt(datos['combo_cantidad']) * cantidad_final;
                _productos.precioUnidad             = datos['prod_precio'][0].precio;
                _productos.bodega                   = datos['producto'][0].nombre_bodega;
                _productos.id_bodega                = datos['producto'][0].id_bodega;
                _productos.impuesto_id              = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                _productos.por_iva                  = datos['producto'][0].porcentage;
                _productos.gen                      = datos['producto'][10].valor;
                _productos.iva                      = datos['atributos']['Incluye Iva']; // datos['producto'][9].valor;
                _productos.descripcion              = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                _productos.presentacion             = datos['producto'][0].valor;
                _productos.total                    = 0.00;
                _productos.presentacionFactor       = (datos['combo_cantidad'] * producto_cantidad_linea);
                _productos.invisible                = 1;

                if (combo_descuento) {
                    combo_total += _productos.total;
                    combo_padre_total += _productos.total;
                } else {
                    combo_padre_total += _productos.total;
                }
                contador_productos = _orden.length;
                _orden[contador_productos] = _productos;
                _productos = {};

                calculo_totales();

            });
            if (combo_total) {
                recalcular_descuento_combo(id_producto_detalle, combo_total, combo_descuento);
            }
            sumar_combo_total(combo_padre_total, id_producto_detalle);

        }

        function recalcular_descuento_combo(id_producto_detalle, combo_total, combo_descuento) {

            _orden.forEach(function(element) {
                if (element.id_producto_detalle == id_producto_detalle) {
                    var d = calcular_descuento(combo_descuento, combo_total, element.descuento_limite);
                    _orden[_orden.indexOf(element)].descuento = combo_descuento;
                    _orden[_orden.indexOf(element)].descuento_calculado = d;
                    _orden[_orden.indexOf(element)].combo_total = combo_total;
                }
            });
            depurar_producto();
        }

        function recalcular_factor_combo(id_producto_detalle, cantidad) {

            _orden.forEach(function(element) {
                if (element.id_producto_combo == id_producto_detalle) {

                    var pf = _orden[_orden.indexOf(element)].presentacionFactor;
                    var pu = _orden[_orden.indexOf(element)].precioUnidad;
                    _orden[_orden.indexOf(element)].cantidad = cantidad * pf;
                    _orden[_orden.indexOf(element)].total = cantidad * pf * pu;
                }
            });
            depurar_producto();
        }
        // ------------------ END COMBO

        function set_calculo_precio(precioUnidad, producto_cantidad_linea) {
            // General - Set Calculo Precio
            $("#total").val(calcularTotalProducto(precioUnidad, producto_cantidad_linea));
        }

        $(document).on('change', input_cantidad, function() {
            changeCantidad();
        });

        function changeCantidad() {
            // Actualizar la cantidad
            var cantidad = $("#cantidad").val();

            producto_cantidad_linea = cantidad;

            if (_productos.producto != null && _productos.combo != 1) {

                producto_cantidad_linea = cantidad;

                var precion = $("#precioUnidad").val();
                var cantidad = producto_cantidad_linea;

                if (producto_escala == 1) {
                    //var escala_precio = validar_escalas(cantidad);
                    //calcularTotalProducto(escala_precio, cantidad)
                    //$("#precioUnidad").val(escala_precio);
                    //_productos.precioUnidad = escala_precio;

                } else {
                    calcularTotalProducto(_productos.presentacionPrecio, cantidad)
                    $("#precioUnidad").val(_productos.precioUnidad);
                }

                _productos.cantidad = cantidad;
                _productos.total = $("#total").val();
                factor_precio = 0;
                factor_total = 0;

            } else {
                calcularTotalProducto(_productos.presentacionPrecio, cantidad)
                $("#precioUnidad").val(_productos.precioUnidad);
                _productos.cantidad = cantidad;
                factor_precio = 0;
                factor_total = 0;
            }
        }

        function calcularTotalProducto(precio, cantidad) {
            // total Producto
            var total = (precio * cantidad);
            return Number(total).toFixed(2);
        }

        $(document).on('change', '#sucursal_id', function() {
            correlativos_sucursales($(this).val());
        });

        $(document).on('change', '#sucursal_id2', function() {
            correlativos_sucursales($(this).val());
        });

        function correlativos_sucursales(sucursal) {
            // Cambiar Bodega
            input_bodega_select.empty();
            var select_option;
            $.ajax({
                url: "<?php echo base_url(); ?>producto/orden/get_bodega_sucursal/" + sucursal,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var bodega = datos["bodega"];
                    $.each(bodega, function(i, item) {
                        select_option += '<option value="' + item.id_bodega + '">' + item.nombre_bodega + '</option>';
                    });

                    input_bodega_select.html(select_option);

                    var correlativo = datos['correlativo'];
                    $("#c_numero").val(correlativo[0].siguiente_valor);
                },
                error: function() {}
            });
        }

        function productos_precios_validacion() {

            var factor          = 0;
            var flag            = false;
            var precio_total    = 0;
            var precio_unidad   = 0;

            var descuento_digitado = $("descuento").val();

            if (_productos_precio != null) {
                $.each(_productos_precio, function(i, item) {
                    factor = _productos_precio['factor'];
                    if (factor == producto_cantidad_linea) {
                        factor_precio = item.unidad;
                        factor_total = item.precio;
                        $("#total").val(calcularTotalProducto(factor_precio, factor));
                        $("#precioUnidad").val(factor_precio);
                        _productos.cantidad = producto_cantidad_linea;
                        flag = true;
                    }
                });
            }
            return flag;
        }

        function calcular_descuento(descuento, total, descuento_limite) {
            var valor = 0;

            if (descuento) {
                var primer_digito = descuento.substring(0, 1);
                var tipo_descuento_limite = descuento_limite.substring(0, 1);

                if (descuento) {
                    if (primer_digito == 0) {
                        if (tipo_descuento_limite == 0) {
                            // Limite en %   
                            if (descuento <= descuento_limite) {
                                valor = descuento * total;
                            } else {
                                valor = descuento_limite * total;
                            }
                        } else {
                            // Limite #
                            valor = (parseInt(descuento_limite) / 100);
                            if (descuento <= valor) {
                                valor = descuento * total;
                            } else {
                                valor = (parseInt(descuento_limite) / 100) * total;
                            }
                        }
                    } else {
                        if (tipo_descuento_limite == 0) {
                            // Limite en %  y descuento %
                            valor = (descuento / 100);
                            if (valor <= parseInt(descuento_limite)) {
                                valor = valor * total;
                            } else {
                                valor = descuento_limite * total;
                            }
                        } else {
                            // Limite # y descuento # 
                            valor = (descuento / 100);
                            if (valor <= (descuento_limite / 100)) {
                                valor = valor * total;
                            } else {
                                valor = total * (descuento_limite / 100);
                            }
                        }
                    }
                    _productos.descuento_calculado = valor.toFixed(2);
                } else {
                    _productos.descuento_calculado = valor.toFixed(2);
                }
            }
            return valor;
        }

        function agregar_producto() {
            if (_productos.presentacion != null) {
                if (factor_total != 0 && factor_precio != 0) {
                    _productos.total = factor_total;
                    _productos.precioUnidad = factor_precio;
                }

                total_msg += parseFloat(_productos.total);

                $(".total_msg").text("$ " + total_msg.toFixed(2));

                contador_productos = _orden.length;

                if (_productos != null) {
                    var tr_html = "<tr class='productos_tabla' style='' name='" + _productos.id_producto_detalle + "'>";
                    tr_html += "<td class='border-table-left'>" + contador_tabla + "</td>";
                    tr_html += "<td class='border-left'>" + _productos.producto + "</td>";
                    tr_html += "<td class='border-left'>" + _productos.descripcion + "</td>";
                    tr_html += "<td class='border-left " + _productos.producto2 + "'>" + _productos.cantidad + "</td>";
                    tr_html += "<td class='border-left presentacion" + _productos.producto2 + "'>" + _productos.presentacion + "</td>";
                    tr_html += "<td class='border-left factor" + _productos.producto2 + "'>" + _productos.presentacionFactor + "</td>";
                    tr_html += "<td class='border-left precioUnidad" + _productos.producto2 + "'>" + _productos.precioUnidad + "</td>";
                    tr_html += "<td class='border-left'>" + _productos.descuento_calculado + "</td>";
                    tr_html += "<td class='border-left total" + _productos.producto2 + "'>" + _productos.total + "</td>";
                    tr_html += "<td class='border-left '>" + _productos.bodega + "</td>";
                    tr_html += "<td class='border-left'><button type='button' class='btn btn-labeled bg-green eliminar' name='" + _productos.id_producto_detalle + "' id='eliminar' value=''><span class=''><i class='fa fa-times'></i></span></button></td>";

                    tr_html += "</tr>";

                    calculo_totales();

                    $(".producto_agregados").append(tr_html);

                    _productos = {};
                    factor_total = 0;
                    factor_precio = 0;
                    contador_tabla++;
                }
            }
        }

        $(document).on('click', '.guardar', function() {
            f4_guardar();
        });

        function f4_guardar() {

            var id_modo_pag     = $("#modo_pago_id").val();
            var sucursal_id     = $("#sucursal_id").val();
            var cli_form_pago   = $("#cliente_codigo").val();
            var tipo_documento  = parseInt($("#id_tipo_documento").val());

            if (!pagos_mostrados.includes(id_modo_pag)) {
                pagos_mostrados[pagos_mostrados.length] = id_modo_pag;
            }

            guardarX(cli_form_pago, tipo_documento, sucursal_id);
            correlativo_documento(cli_form_pago, tipo_documento, sucursal_id);

            $("#procesar_venta").modal();
            $('#procesar_btn').hide();
        }

        function guardarX(cli_form_pago, tipo_documento, sucursal_id) {

            var sucursal_id = input_sucursal;
            $.ajax({
                url: path + "get_form_pago/" + cli_form_pago + "/" + tipo_documento + "/" + sucursal_id,
                datatype: 'json',
                cache: false,
                success: function(data) {

                    var datos       = JSON.parse(data);
                    var metodo_pago = datos["metodo_pago"];
                    var metodo_pago_principal = datos['metodo_pago_doc'];

                    var _html = "";
                    var cou = 1;

                    _html += '<table class="table formas_pagos_valores">';
                    _html += '<thead><tr><td></td><td>Monto</td><td>Numero</td><td>Banco</td><td>Serie</td></tr></thead>';
                    pagos_mostrados.forEach(element => {
                        $.each(metodo_pago, function(i, item) {
                            if (element == parseInt(item.id_modo_pago)) {
                                _html += '<tr class="pagos_tabla" id="' + cou + '"><td><div class="btn bg-green">' + item.nombre_modo_pago + '</div></td>';
                                _html += '<td class="">' +
                                    '<input type="text" count=' + metodo_pago.length + ' size="9px" name="pagoInput' + cou + '" ids=' + item.id_modo_pago + ' id=' + item.nombre_modo_pago + ' class="metodo_pago_input"></td>';

                                _html += '<td><input type="text" count=' + metodo_pago.length + '  size="14px" name="val' + cou + '" placeholder="" class="metodo_pago_input" /></td>';
                                _html += '<td><input type="text" count=' + metodo_pago.length + ' size="14px" name="ban' + cou + '" placeholder="" class="metodo_pago_input" /></td>';
                                _html += '<td><input type="text" count=' + metodo_pago.length + ' size="14px" name="ser' + cou + '" placeholder="" class="metodo_pago_input" /></td>';
                                _html += '</tr>';
                                cou++;
                            }
                        });
                    });
                    _html += '</table>';
                    generar_select_pagos(metodo_pago);
                    $("#metodos_pagos").html(_html);
                    $("input[name='pagoInput1']").focus();
                },
                error: function() {}
            });
        }

        function generar_select_pagos(metodo_pago) {
            var options = "";

            $.each(metodo_pago, function(i, item) {
                options += "<option value='" + item.id_modo_pago + "'>" + item.nombre_modo_pago + "</option>";
            });
            $("#extraMetodoPago").html(options);
        }

        $(document).on('click', '.addMetodoPago', function() {
            var metodo_add = parseInt($("#extraMetodoPago").val());
            pagos_mostrados[pagos_mostrados.length] = metodo_add;

            var cli_form_pago = $("#cliente_codigo").val();
            var tipo_documento = parseInt($("#id_tipo_documento").val());
            guardarX(cli_form_pago, tipo_documento);
        });

        $(document).on('change', '.metodo_pago_input', function() {

            if (total_msg <= 0) {
                return;
            }

            var temp    = 0.00;
            var cambio  = 0.00;
            var leng    = $(this).attr('count');
            var count   = 1;

            pagos_array = [];
            while (count <= leng) {
                types = $(":input[name=pagoInput" + count + "]").attr('id');
                value = $(":input[name=pagoInput" + count + "]").val();
                ids = $(":input[name=pagoInput" + count + "]").attr('ids');

                val = $(":input[name=val" + count + "]").val();
                ban = $(":input[name=ban" + count + "]").val();
                ser = $(":input[name=ser" + count + "]").val();

                pagos_array[pagos_array.length] = {
                    id: ids,
                    type: types,
                    amount: value,
                    valor: val,
                    banco: ban,
                    serie: ser
                }
                count++;
            }

            $("#cambio_venta").text(0.00);
            $("#restante_venta").text(0.00);
            $('#procesar_btn').hide();

            $.each(pagos_array, function(i, item) {
                if (pagos_array[i].amount) {
                    temp += parseFloat(pagos_array[i].amount);
                }
            });
            cambio = temp.toFixed(2) - total_msg.toFixed(2);
            cambio = cambio * 1;

            $("#cambio_venta").text(11);

            if (cambio == 0) {
                $("#cambio_venta").text(0.00);
                $("#restante_venta").text(0.00);
                $('#procesar_btn').show();
            } else if (cambio >= 0.01) {

                $("#cambio_venta").text(cambio.toFixed(2));
                $('#procesar_btn').show();
            } else if (cambio <= 0) {
                $("#restante_venta").text(cambio.toFixed(2));
            }

        });

        $(document).on('click', '#procesar_btn', function() {
            procesar_venta($(this).attr('name'));
        });

        $(document).on('click', '#guardar_orden', function() {
            procesar_venta($(this).attr('name'));
        });

        $(document).on('click', '#add_pago', function() {
            var val         = select.val();
            var text        = select.selectedIndex;
            var select      = $("#metodo_pago");
            var container   = $("#metodo_pago_lista");

            var html_   = "";
            html_       = "<input type='text' placeholder='" + text + "' name='" + val + "' class='form-control'>";

            container.append(html_);

        });

        $(document).on('click', '.eliminar', function() {
            // Remover los Productos de la lista.
            var producto_id = $(this).attr('name');
            eliminar_elemento_tabla(producto_id);
        });

        function eliminar_elemento_tabla(producto_id) {
            var x = 0;
            var _orden_temp = [];

            remover_combo(producto_id);

            _orden.forEach(function(element) {

                if (element.id_producto_detalle == producto_id && (element.id_producto_combo == null || element.id_producto_combo == 0)) {

                    total_msg -= parseInt(calcularTotalProducto(element.precioUnidad, element.cantidad));
                    $(".total_msg").text("$ " + total_msg.toFixed(2));

                    _orden.splice(_orden.indexOf(element), 1);
                    if (_conf.impuesto == 1) {
                        _config_impuestos();
                        depurar_producto();
                    }
                    depurar_producto();
                }
            });
        }

        function remover_combo(producto_id) {
            var L = 1;

            while (L <= _orden.length) {
                _orden.forEach(function(element) {

                    if (element.id_producto_combo == producto_id) {

                        _orden.splice(_orden.indexOf(element), 1);
                        depurar_producto();
                    }
                });
                L++;
            }
        }

        $(document).on('keydown keyup input click', function(e) {
            if ($('#documentoModel').is(':visible')) {

                var key = e.which;

                if (key == 39) { //Modal de Facturacion en Venta Rapida
                    $("#id_tipo_documento").focus();
                    $("#id_tipo_documento").css("background", "#27c24c");
                    clear_color($("#id_tipo_documento"), "black");
                }

                $(this).css("background", "white");
            }
        });

        function clear_color(input, color) {
            setTimeout(function() {
                input.css("background", color);
            }, 3000);
        }

        function get_clientes_lista(texto_cliente) {

            $(".buscar_cliente").focus();
            $(".cliente_codigo2").html(table_tr);

            var table_tr = "";

            $.ajax({
                url: "<?php echo base_url(); ?>producto/compras/get_proveedor_lista/" + texto_cliente,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var clientes = datos["clientes"];
                    var cliente_id = 0;
                    clientes_lista = clientes;

                    $.each(clientes, function(i, item) {

                        if (cliente_id != item.id_proveedor) {
                            cliente_id = item.id_proveedor;

                            table_tr += '<option value="' + item.id_proveedor + '" name="' + item.empresa_proveedor + '" rel="' + item.direc_empresa + '">' + item.nit_empresa + ' - ' + item.nrc + ' - ' + item.empresa_proveedor + '</option>';
                        }
                    });

                    $('.cliente_codigo2').show();
                    $(".cliente_codigo2").html(table_tr);
                    document.getElementById('cliente_codigo2').selectedIndex = 0;
                    document.getElementById('cliente_codigo2').focus();
                    $(".buscar_cliente").focus();
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

        function procesar_venta(method) {

            var tipo_documento  = $("#id_tipo_documento").val();
            var sucursal_origen = $("#sucursal_id2").val();
            var formulario      = $('#encabezado_form').serializeArray();

            if ($("#orden_estado_venta").val()) {
                orden_estado = $("#orden_estado_venta").val();
            }

            var impuestos_data = {
                'imp_condicion' : _impuestos_orden_condicion,
                'imp_especial'  : _impuestos_orden_especial,
                'imp_excluyente': _impuestos_orden_excluyentes,
                'imp_iva'       : _impuestos_orden_iva
            }

            var empleado_encargado = $("#firma_llegada").val();

            if (_orden.length != 0 && empleado_encargado!="") {
;
                $.ajax({
                    type: 'POST',
                    data: {
                        orden: _orden,
                        encabezado: formulario,
                        impuestos: impuestos_data,
                        documento_tipo: tipo_documento,
                        sucursal_origen: sucursal_origen,
                    },
                    url: path + method,
                    success: function(data) {

                        var compra_result   = JSON.parse(data);
                        var id_compra       = formulario[0].value;

                        if (method == "guardar_compra") {
                            
                            if(compra_result.message){
                                errorDb(compra_result.message);
                            }else{
                                window.location.href = "editar/" + compra_result.id;
                            }

                        } else if (method == "../venta/guardar_venta") {

                            //location.reload();
                            $(".transacion").text(compra_result['msj_title'] + compra_result['msj_orden']);
                            $(".print_venta").attr("href", "venta/" + compra_result['id']);
                            window.location.href = "../compras/editar/" + id_compra;

                        } else if (method == "update_compra") {
                            window.location.href = compra_result;
                        }
                    },
                    error: function() {
                        alert("Error al procesar Compra");
                    }
                });
            }else{
                var msg = $(".msg_error");
                msg.html("<h2 style='display: inline-block;'><label class='label label-danger'>Falta Encargado de Traslado</label></h2>");
            }

            if (method != "update_orden") {
                //cerrar_orden($("#orden_numero").val());
            }
        }

        function errorDb(mensaje){
            $('.cancel').focus();
            swal({
                html: true,
                title: "Notificatión",
                text: mensaje,
                type: "warning",
                //showCancelButton: true,
                confirmButtonText: "Salir",
                //cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                //closeOnCancel: false,
                //showLoaderOnConfirm: true,
            }, function (isConfirm) {

                if (isConfirm) {
                  
                    swal("Vuelva a intentarlo");
                    //redirec("index");
                } else {
                    swal("Salir", "Debes Hacer Login de Nuevo", "error");
                } 
            });
        }

        function cerrar_orden(correlativo_orden) {

            $.ajax({
                type: 'POST',
                data: {
                    correlativo_orden: correlativo_orden,
                },
                url: path + "cerrar_orden",
                success: function(data) {
                    //location.reload();
                    window.location.href = "nuevo";
                },
                error: function() {}
            });
        }

        $(document).on('keypress', '.cliente_codigo2', function() {

            var id = $(this).val();
            var cliente_nombre = $(this).find('option:selected').attr("name");
            var cliente_direccion = $(this).find('option:selected').attr("rel");


            $("#cliente_codigo").val(id);
            $("#cliente_nombre").val(cliente_nombre);
            $("#direccion_cliente").val(cliente_direccion);
            $("#impuesto").val($(this).attr('impuesto'));
            $('#cliente_codigo2').modal('hide');

            $.ajax({
                url: "<?php echo base_url(); ?>producto/orden/get_clientes_documento/" + id,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var tipo_documento = datos["tipoDocumento"]; // Todos los tipos de documentos 
                    var clienteWithDocumento = datos["clienteDocumento"]; // Informacion unica del cliente
                    var tipo_pago = datos["tipoPago"]; // Lista de todos los tipos de pago
                    var clienteTipoPagos = datos["cliente_tipo_pago"]; // Tipos de pago asignados al cliente

                    clientes_lista = clienteTipoPagos;
                    calculo_totales();
                    // Set de documento a cliente
                    var documentoSelecionado = tipo_documento.find(x => x.id_tipo_documento == clienteWithDocumento[0].TipoDocumento);

                    if (documentoSelecionado != null) {
                        // Opcion predefinado de documento para el cliente
                        //$("#id_tipo_documento").html("<option value='" + documentoSelecionado.id_tipo_documento + "'>" + documentoSelecionado.nombre + "</option>");
                    }

                    $.each(tipo_documento, function(i, item) {
                        var n = item.nombre;
                        if (n.includes('Orden')) {
                            //if (item.id_tipo_documento != clienteWithDocumento[0].TipoDocumento) {
                            $("#id_tipo_documento").append("<option value='" + item.id_tipo_documento + "'>" + item.nombre + "</option>");
                        }
                    });

                    // Set de forma de pago a cliente
                    $("#modo_pago_id").empty();

                    var pagoSelecionado = tipo_pago.find(x => x.id_modo_pago == clienteWithDocumento[0].TipoPago);

                    if (pagoSelecionado != null) {
                        $("#modo_pago_id").html("<option value='" + pagoSelecionado.id_modo_pago + "'>" + pagoSelecionado.nombre_modo_pago + "</option>");
                    }

                    $.each(clienteTipoPagos, function(i, item) {
                        $("#modo_pago_id").append("<option value='" + item.id_modo_pago + "'>" + item.nombre_modo_pago + "</option>");
                    });
                },
                error: function() {}
            });

            $(".cliente_codigo2").hide();
            $(".cliente_codigo").focus();
        });

        $(document).on('click', '.seleccionar_empleado', function() {

            $(".vendedores_lista1").text($(this).attr('name'));
            $("#vendedor1").val($(this).attr('id'));
            $('#vendedores_modal').modal('hide');
        });

        function get_empleados_lista(sucursal) {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Codigo Empleado</th><th>Nombre Empleado</th><th>Apellido Empleado</th><th>Apellido Empleado</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: path + "get_empleados_by_sucursal/" + sucursal,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var clientes = datos["empleados"];
                    var cliente_id = 0;

                    $.each(clientes, function(i, item) {

                        if (cliente_id != item.id_empleado) {
                            cliente_id = item.id_empleado;
                            var precio = 0;

                            table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.id_empleado + '</td><td>' + item.primer_nombre_persona + '</td><td>' + item.segundo_nombre_persona + '</td><td>' + item.primer_apellido_persona + '</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_empleado" id="' + item.id_empleado + '" name="' + item.primer_nombre_persona + ' ' + item.primer_apellido_persona + '">Agregar</a></td></tr>';
                            contador_precios++;
                        }

                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".vendedor_lista_datos").html(table);

                },
                error: function() {}
            });
        }

        $(document).on('click', '#btn_update_products', function() {
            sessionStorage.clear();
            location.reload();
        });

        $(document).on('keypress', '.cliente_codigo', function() {

            if (event.which == 13) {
                get_clientes_lista($(this).val());
            }

        });

        $(document).on('keyup', '.cliente_codigo', function() {

            setTimeout(function() {
                //$(".buscar_cliente").focus();
            }, 1000);

            //get_clientes_lista();
        });

        $(document).on('click', '.vendedores_lista1', function() {
            $('#vendedor_modal').modal('show');
            get_empleados_lista($(this).attr("id"));
        });

        $(document).on('click', '#btn_existencias', function() {

            show_existencias();
        });

        $(document).on('keypress', '.cntProducto', function() {
            if (event.which == 13) {
                var prod_id_input = $(this).attr('id');
                var prod_val_input = $(this).val();
                _orden.forEach(function(element) {
                    if (element.producto == prod_id_input) {
                        _orden[_orden.indexOf(element)].cantidad = prod_val_input;
                        _orden[_orden.indexOf(element)].total = calcularTotalProducto(_orden[_orden.indexOf(element)].precioUnidad, prod_val_input);
                        depurar_producto();
                    }
                });
            }
        });

        $(document).keydown(function(e) {
            // Collapsar Menu Information            
            switch (e.which) {
                case 219: // 0
                    $("#information").trigger("click")
                    break;
            }
        });

        $(document).on('keypress', '.preProducto', function() {

            if (event.which == 13) {

                var prod_id_input = $(this).attr('id');
                var prod_val_input = $(this).val();
                _orden.forEach(function(element) {

                    if (element.producto == prod_id_input) {
                        _orden[_orden.indexOf(element)].presentacionPrecio = prod_val_input;
                        _orden[_orden.indexOf(element)].precioUnidad = prod_val_input;
                        _orden[_orden.indexOf(element)].presentacionUnidad = prod_val_input;
                        _orden[_orden.indexOf(element)].total = calcularTotalProducto(_orden[_orden.indexOf(element)].cantidad, prod_val_input);
                        depurar_producto();
                    }
                });
            }
        });

        $(document).on('keypress', '.cntTotal', function() {

            if (event.which == 13) {

                var prod_id_input = $(this).attr('id');
                var prod_val_input = $(this).val();
                _orden.forEach(function(element) {
                    if (element.producto == prod_id_input) {

                        _orden[_orden.indexOf(element)].presentacionPrecio = prod_val_input;

                        /*_orden[_orden.indexOf(element)].precioUnidad = 
                                prod_val_input / _orden[_orden.indexOf(element)].cantidad;

                        _orden[_orden.indexOf(element)].presentacionUnidad = 
                                prod_val_input / _orden[_orden.indexOf(element)].cantidad;

*/
                        _orden[_orden.indexOf(element)].cantidad = 
                                ( _orden[_orden.indexOf(element)].presentacionPrecio / _orden[_orden.indexOf(element)].precioUnidad );
  
                        _orden[_orden.indexOf(element)].total = 
                                calcularTotalProducto(_orden[_orden.indexOf(element)].cantidad, _orden[_orden.indexOf(element)].precioUnidad);

                        depurar_producto();
                    }
                });
            }
        });

        $(document).on('click', '#btn_impuestos', function() {
            _config_impuestos();
            depurar_producto();
        });

    });

    function show_existencias() {

        $(".existencia_buscar").focus();
        $('#existencias').modal('show');

        setTimeout(function() {
            $('.existencia_buscar').focus();
        }, 1000);

    }

    function depurar_producto() {
        // Remueve los productos selecionados
        _config_impuestos();        
        contador_tabla = 1;
        if (_orden.length >= 1) {
            var tr_html = "";

            _orden.forEach(function(element) {

                var precio_tag = parseFloat(element.precioUnidad);
                var desc_tag = parseFloat(element.descuento_calculado);
                var total_tag = parseFloat(element.total);
                if (element.invisible == 0) {
                    tr_html += "<tr class='productos_tabla' style='' id='" + element.producto_id + "' name='" + element.id_producto_detalle + "'>";
                    tr_html += "<td class='border-table-left'>" + contador_tabla + "</td>";
                    tr_html += "<td class=''>" + element.producto + "</td>";
                    tr_html += "<td class=''>" + element.descripcion + "</td>";
                    tr_html += "<td class=''><input type='text' class='form-control cntProducto' size='3' id='" + element.producto + "' value='" + element.cantidad + "' style='border:1px solid orange;width:90px;'></input></td>";
                    tr_html += "<td class=''>" + element.presentacion + "</td>";
                    tr_html += "<td class=''>" + element.presentacionFactor + "</td>";
                    tr_html += "<td class=''><input type='text' class='form-control preProducto' size='4' id='" + element.producto + "' value='" + precio_tag.toFixed(2) + "' style='border:1px solid blue;'></input></td>";
                    tr_html += "<td class=''><input type='text' class='form-control cntTotal' size='4' id='" + element.producto + "' value='" + total_tag.toFixed(2) + "' style='border:1px solid green;width:100px;'></input></td>";
                    if (element.combo == 1 || !element.id_producto_combo || element.invisible == 0) {
                        tr_html += "<td class='border-left'><button type='button' class='btn btn-labeled bg-green eliminar' name='" + element.id_producto_detalle + "' id='eliminar' value=''><span class=''><i class='fa fa-times'></i></span></button></td>";
                    } else {
                        tr_html += "<td class='border-left'> - </td>";
                    }

                    tr_html += "</tr>";

                    contador_tabla++;
                }
            });
            $(".cantidad_tabla").val(4);
            $(".sub_total_tabla").val(4);

            calculo_totales();
            $("#cantidad").val(1);

            $(".producto_agregados").html(tr_html);

        } else {
            contador_productos = 0;
            _orden = [];
            _productos = {};
            _impuestos_orden_condicion = [];
            _impuestos_orden_especial = [];
            _impuestos_orden_excluyentes = [];
            _impuestos_orden_iva = [];

            total_msg = parseFloat(0.00);
            $(".total_msg").text("$ " + total_msg.toFixed(2));
            $(".producto_agregados").empty();
            calculo_totales();
        }
    }

    function calculo_totales() {

        var descuento = 0;
        var t = 0;
        var t2 = 0;
        var sub = 0;
        var imp_espeical_total = 0;
        var iva_nombre = "";
        var iva_valor = "";
        var iva_total = "";

        // --------------- * -----------------------------

        if (_orden != null) {
            _orden.forEach(function(element) {

                t += parseInt(element.cantidad);
                if ((_conf.comboAgrupado == 0) && (element.id_producto_combo != null && element.combo == 0)) {

                    //t2 +=parseFloat(element.total);
                } else {
                    if (element.id_producto_combo == 0 || element.id_producto_combo == null) {
                        t2 += parseFloat(element.total);
                    }
                }
                descuento += parseFloat(element.descuento_calculado);

            });
        } else {
            t = 0;
        }

        /* ------------Impuestos Especial Dibujados  -----------*/

        if (_impuestos_orden_condicion.length != 0 || _impuestos_orden_excluyentes != 0) {

            var impuestos_nombre = "";
            var impuestos_valor = "";
            var impuestos_total = "";

            _impuestos_orden_condicion.forEach(function(element) {
                sub = element.ordenImpTotal.toFixed(2);
                imp_espeical_total += parseFloat(sub);
                //t2 += parseFloat(sub);
                impuestos_nombre += "<i style='text-align: right;'>" + element.ordenImpName + "(" + element.ordenImpVal + ")</i><br>";
                impuestos_total += "<i><?php echo $moneda[0]->moneda_simbolo; ?>" + sub + "</i><br>";

            });

            _impuestos_orden_especial.forEach(function(element) {
                sub = element.ordenImpTotal.toFixed(2);
                imp_espeical_total += parseFloat(sub);
                impuestos_nombre += "<i style='text-align: right;'>" + element.ordenImpName + "(" + element.ordenImpVal + ")</i><br>";
                impuestos_total += "<i><?php echo $moneda[0]->moneda_simbolo; ?>" + sub + "</i><br>";

            });

            _impuestos_orden_excluyentes.forEach(function(element) {

                sub = element.ordenImpTotal.toFixed(2);
                if (element.condicion_simbolo == "+") {
                    imp_espeical_total += parseFloat(sub);
                } else if (element.condicion_simbolo == " - ") {
                    imp_espeical_total -= parseFloat(sub);
                }
                impuestos_nombre += "<i style='text-align: right;'>" + element.ordenImpName + "(" + element.ordenImpVal + ")</i><br>";

                impuestos_total += "<i><?php echo $moneda[0]->moneda_simbolo; ?> " + sub + "</i><br>";

            });

            $(".impuestos_nombre").html(impuestos_nombre);
            $(".impuestos_total").html(impuestos_total);
        } else {
            $(".impuestos_nombre").empty();
            $(".impuestos_total").empty();
        }

        /* ------------Impuestos - IVA -----------*/

        total_msg = (t2 - descuento);

        $(".iva_nombre").empty();
        $(".iva_valor").empty();
        $(".iva_total").empty();
        var temp = 0;
        if (total_iva != 0 && _orden.length != 0) {
            total_msg += parseFloat(total_iva_suma);
        }

        iva_nombre += "<p style='text-align: right;'>IVA</p>";
        iva_valor += "<?php echo $moneda[0]->moneda_simbolo; ?>" + total_iva.toFixed(2);
        iva_total += "<p><?php echo $moneda[0]->moneda_simbolo; ?>" + total_msg.toFixed(2) + "</p>";

        var exento_valor = "<?php echo $moneda[0]->moneda_simbolo; ?>" + exento_iva_suma.toFixed(2);

        $(".iva_nombre").html(iva_nombre);
        $(".iva_valor").text(iva_valor);
        $(".iva_total").html(iva_total);
        $(".exento_valor").text(exento_valor);

        total_msg += parseFloat(imp_espeical_total);

        // --------------- * -----------------------------
        $(".total_msg").text(total_msg.toFixed(2));
        $(".cantidad_tabla").text(t.toFixed(2));
        $(".sub_total_tabla").text(sub_total_.toFixed(2));
        $(".total_tabla").text(total_msg.toFixed(2));
        $(".descuento_tabla").text(descuento.toFixed(2));

        $("#compra_venta").text(total_msg.toFixed(2));
        $("#restante_venta").text(total_msg.toFixed(2));
    }

    function existAutorizatio() {

        $(document).ready(function() {

            validar_autorizacion();
        });

        function validar_autorizacion() {

            alert(input_autorizacion_descuento);
        }

    }
</script>