<script>
    $(document).ready(function() {

        $('#existencias').appendTo("body");
        $('#procesar_venta').appendTo("body");
        $('#cliente_modal').appendTo("body");
        $('#vendedores_modal').appendTo("body");
        $('#presentacion_modal').appendTo("body");
        $('#en_proceso').appendTo("body");
        $('#en_reserva').appendTo("body");
        $('.dataSelect').hide();
        $('.dataSelect2').hide();
        $(".producto_buscar").focus();
        $('.1dataSelect').hide();
        $('.1dataSelect2').hide();

        $("input").focus(function() {
            $(this).css('background', 'red');
        });

        var pagos_mostrados = [];
        var pagos_array = [];
        var bodega = 0;
        var _productos_precio2;

        getImpuestosLista();          
        bodega = $("#bodega_select").val();

        function getProductsList(){

            sucursal = $("#sucursal_id").val();
            interno_bodega = bodega;        
            bodega = $("#bodega_select").val();    
     
            $.ajax({
                url: "get_productos_lista/" + sucursal + "/" + bodega,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var productos = datos["productos"];
                    _productos_lista = productos;

                },
                error: function() {}
            });
            
        }

        function getImpuestosLista(){

            $.ajax({
                url: "get_impuestos_lista",
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
            /* Filtro de productos */
            var busqueda_texto = $(".existencia_buscar").val();

            if (busqueda_texto.length != 0) {
                
                if ($(".existencia_buscar").is(":focus")) {
                    
                    if (e.keyCode == 13) {

                        search_texto(this.value);
                    }
                }

            } else {
                $('.dos').empty();
            }
        });

        function existencia_buscar(_productos_lista , texto) {

            var $listBox = $('.1dataSelect');
            var contador_precios = 1;
            var table_tr = "";
            var producto_id = 0;

            $listBox.show();

            var result = [];

            var x = JSON.parse(_productos_lista);

            result = x.filter(function(a){ 

                var name = a.name_entidad.toUpperCase();
                var codigo_barras = a.codigo_barras;
                var pres_cod_bar = a.pres_cod_bar;

                if (name.includes(texto.toUpperCase()) || codigo_baras.includes(texto) || pres_cod_bar.includes(texto)) {
                    return  a;
                }
                
            });

            console.log(result);

            $.each(result, function(i, item) {

                var name = item.name_entidad.toUpperCase();
                var cod_barra = item.cod_barra;

                
                    producto_id = item.id_entidad;
                    var precio = 0;

                    table_tr += '<option value="' + item.id_entidad + '">' + item.nombre_marca + ' ' + item.name_entidad + ' ' + item.presentacion + ' ' + item.cod_barra + '</option>';
                    contador_precios++;
            });

            $(".1dataSelect").html(table_tr);
            
            //$("#grabar").focus();
        }

        $(document).on('keypress', '.1dataSelect', function() {

            if (event.which == 13) {
                get_producto_completo2(this.value);
                event.preventDefault();
                $(".producto_buscar").empty();
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
                url: "../existencias/get_producto_completo/" + producto_id,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var contador = 1;
                    var existencias_total = 0;
                    var html = '';

                    $.each(datos['producto'], function(i, item) {

                        existencias_total += parseInt(item.Cantidad);
                        if ($('#sucursal_id2').val() == item.id_sucursal) {
                            html += '<tr style="background:#2D3B48;color:white;">';
                        } else {
                            html += '<tr>';
                        }
                        html += '<td>' + contador + '</td>';
                        html += '<td>' + item.nombre_sucursal + '</td>';
                        html += '<td>' + item.nombre_bodega + '</td>';
                        html += '<td>' + item.Cantidad + '</td>';
                        html += '<td>' + item.valor + '</td>';
                        html += '<td>' + 0.00 + '</td>';
                        html += '<td>' + item.valor + '</td>';
                        html += '<td>' + item.Descripcion + '</td>';
                        html += '</tr>';
                        contador++;
                    });
                    html += '<tr><td colspan="3"></td><td>' + existencias_total + '</td><td colspan="4"></td></tr>'
                    $('.dos').html(html);

                },
                error: function() {
                    alert("Error Conexion");
                }
            });
        }

        $(document).on('keypress', '.producto_buscar', function(e) {
            /* 1 - Input Buscar Producto */

            var texto_busqueda = $(".producto_buscar").val();

            if (texto_busqueda.length != 0) {

                if ($(".producto_buscar").is(":focus")) {
                    
                    if (e.keyCode == 13) {
                        
                        search_texto($(".producto_buscar").val());
                        
                    }
                }

            } else {
                $('.dataSelect').empty();
                $('.dataSelect').hide();
            }
        });

        /* 2 - Filtrado del texto a buscar en productos */
        function search_texto(texto) {

            sucursal = $("#sucursal_id").val();
            var bodega = $("#bodega_select").val();

            interno_sucursal = sucursal;
            interno_bodega = bodega;
            $.ajax({
                url: "get_productos_lista/" + sucursal + "/" + bodega + "/" + texto,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var productos = datos["productos"];
                    var producto_id = 0;
                    _productos_lista = productos;

                    showProducts(_productos_lista);

                },
                error: function() {}
            });
            
        }

        function showProducts(_productos_lista){

            var producto_id = 0;
            var contador_precios = 1;
            interno_bodega = bodega;
            var table_tr = "";
                       
            $.each(_productos_lista, function(i, item) {

                    producto_id = item.id_entidad;
                    
                    table_tr += '<option value="' + item.id_producto_detalle + '">' + item.nombre_marca + ' ' + item.name_entidad + ' - ' + item.presentacion + '</option>';
                    contador_precios++;
                
                $('.dataSelect').show();
            });

            $(".dataSelect").html(table_tr);
        }

        $(document).on('keydown', '.producto_buscar', function() {

            if (event.keyCode == 40) {
                $('.dataSelect').focus();
                $(".producto_buscar").val("");
                document.getElementById('dataSelect').selectedIndex = 0;
            }
        });

        /* 3 - Selecionado Producto de la lista y precionando ENTER */
        $(document).on('keypress', '.dataSelect', function() {

            if (event.which == 13) {                
                get_producto_completo(this.value);
                event.preventDefault();
                $("#producto_buscar").val(this.value);
                $('#dataSelect').hide();
                $('#dataSelect').empty();
                $("#grabar").focus();
                $(".producto_buscar").val("");
            }

        });

        function get_producto_completo(producto_id) {
            /* 4 - Buscar producto por Id para agregarlo a la linea */
            $("#grabar").attr('disabled');
            var codigo, presentacion, tipo, precioUnidad, descuento, total

            /*
             * Identificadores de valores del producto
             * 1 = Presentacion / 10 = Modelo / 14 = Costo / 18 = Almacenaje / 19 = Minimos
             * 20 = Medios / 21= maximos / 22 = Descuento Limite / 23 = Precio Venta
             * 24 = Iva / 26 = Incluye / 11 = Imagen / 4 = Cod_Barras
             */

            $.ajax({
                url: "get_producto_completo/" + producto_id + "/" + interno_bodega,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);

                    var precio_unidad   = datos['producto'][8].valor;
                    _productos_precio2  = datos["prod_precio"];
                    producto_escala     = datos['producto'][0].Escala;
                    
                    $.each(_productos_precio2, function(i, item) {
                        if (item.id_producto_detalle == producto_id) {
                            _productos_precio = item;
                        }
                    });

                    _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);
                    _conf.impuesto = parseInt(datos['impuesto'][0].valor_conf);

                    if (parseInt(_productos_precio.length) >= 1 && producto_escala != 1) {
                        //get_presentacio_lista( _productos_precio );
                        seleccionar_productos_array(producto_id);

                    } else {
                        enLinea();
                    }

                    $("#producto").val(datos['producto'][12].valor);
                    $("#bodega").val(datos['producto'][0].nombre_bodega);
                    $("#precioUnidad").val(_productos_precio.unidad);

                    $("#descripcion").val(datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca);

                    producto_cantidad_linea = datos['producto'][0].factor;
                    $("#cantidad").val(1);
                    precioUnidad = _productos_precio.unidad;

                    set_calculo_precio(precioUnidad, producto_cantidad_linea);

                    _productos.producto_id      = datos['producto'][0].id_entidad;
                    _productos.combo            = datos['producto'][0].combo;
                    _productos.inventario_id    = datos['producto'][0].id_inventario;
                    _productos.producto         = datos['atributos'].Cod_Barras;
                    _productos.descuento_limite = datos['atributos'].Descuento_Limite;
                    _productos.descuento        = 0.00; // datos['producto'][7].valor;
                    _productos.cantidad         = producto_cantidad_linea;
                    _productos.total            = 0.00; //$("#total").val();
                    _productos.id_producto_combo = null;
                    _productos.combo_total      = null;
                    _productos.invisible        = 0;
                    _productos.bodega           = datos['producto'][0].nombre_bodega;
                    _productos.id_bodega        = datos['producto'][0].id_bodega;
                    _productos.impuesto_id      = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                    _productos.por_iva         = datos['producto'][0].porcentage;
                    _productos.gen              = datos['producto'][10].valor;
                    _productos.iva              = datos['atributos']['Incluye Iva']; //datos['producto'][9].valor;
                    _productos.descripcion      = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                    _productos.total            = _productos_precio.precio;
                    _productos.categoria        = datos['producto'][0].categoria;

                },
                error: function() {}
            });
        }

        function get_presentacio_lista(_productos_precio) {
            /* 5 - Retornando lista de presentaciones dentro de la tabla */
            var contador_precios = 1;
            var table_tr;

            if (_productos_precio.length > 1) {
                // Productos con una lista de presentaciones
                $.each(_productos_precio, function(i, item) {
                    table_tr += '<option value="' + item.id_producto_detalle + '">' + item.presentacion + '</option>';
                    contador_precios++;
                });
                $(".dataSelect2").html(table_tr);
                $('.dataSelect2').show();
            } else {
                // Productos con 1 Unica Presentacion 
                seleccionar_productos_array(_productos_precio[0].id_producto_detalle);
            }
            $('.dataSelect2').focus();

            document.getElementById('dataSelect2').selectedIndex = 0;
        }

        function enLinea() {

            $("#presentacion").val(_productos_precio.presentacion);
            $("#factor").val(_productos_precio.factor);
            _productos.presentacion = _productos_precio.presentacion;
            _productos.precioUnidad = _productos_precio.unidad;
            _productos.presentacionFactor = _productos_precio.factor;
            _productos.id_producto_detalle = _productos_precio.id_producto_detalle;

            _productos.presentacionPrecio = _productos_precio.precio
            _productos.presentacionUnidad = _productos_precio.unidad;
            _productos.presentacionCliente = _productos_precio.Cliente;
            _productos.producto2 = _productos_precio.id_producto_detalle;
            _productos.presentacionCodBarra = _productos_precio.cod_barra;
        }

        function validar_escalas(c) {
            /* Valida las escalas de los productos cuando se aunmenta la cantidad */
            var total_precio_escala = 0;

            $.each(_productos_precio2, function(i, item) {

                pf = parseInt(item.factor);
                if (c == pf) {
                    total_precio_escala = item.unidad;
                    _productos.presentacion = item.presentacion;
                    _productos.presentacionFactor = item.factor;
                    _productos.id_producto_detalle = item.id_producto_detalle;
                    $("#presentacion").val(item.presentacion);
                    $("#factor").val(item.factor);
                } else {

                    if (c >= pf) {
                        total_precio_escala = item.unidad;
                        _productos.presentacionFactor = item.factor;
                        _productos.presentacion = item.presentacion;
                        _productos.id_producto_detalle = item.id_producto_detalle;
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
                //$(".producto_buscar").focus();
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

                $(this).css('background', '#0f4871');
                $(this).css('color', '#fff');

                currCell = $(this);
                currCell.focus();
                var producto_imagen_id = $(this).attr('id');
                //imagen(producto_imagen_id);
            });

            function imagen(producto_imagen_id) {
                getImagen(producto_imagen_id);
            }

            document.onkeydown = function(e) {

                //console.log(e.keyCode);

                switch (e.keyCode) {
                    case 37:
                        //alert('left');
                        $(".producto_buscar").focus();
                        break;
                    case 38:
                        //alert('up');
                        break;
                    case 39:
                        //alert('right');
                        $("#cantidad").focus();
                        break;
                    case 40:
                        //alert('down');
                        break;
                    case 91:
                        // F1
                        $("#documentoModel").modal();
                    case 113:
                        // F2
                        producto_tabla_foco();
                        break;
                    case 114:
                        //F3
                        eliminar_elemento_tabla(id_celda);
                        break;
                    case 115:
                        //F4
                        f4_guardar();
                        break;
                    case 118:
                        //F7
                        f7_foco_efectivo();
                        break;
                    case 177:
                        f8_table_pagos();
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

                    id_celda = $(currCell.closest('tr').prev()).attr('name');

                    var pagoLinea = $(currCell.closest('tr').prev()).attr('id');
                    pagoLinea = parseInt(pagoLinea);
                    $("input[name=pagoInput" + pagoLinea + "]").focus();

                    $('tr').css('background', 'none');
                    $('tr').css('color', 'black');

                    if ($(currCell.closest('tr')).attr('id')) {
                        imagen($(currCell.closest('tr').prev()).attr('id'));
                    }


                } else if (e.keyCode == 40) {
                    // Down Arrow
                    c = currCell.closest('tr').next().find('td:eq(' +
                        currCell.index() + ')');

                    id_celda = $(currCell.closest('tr').next()).attr('name');

                    var pagoLinea = $(currCell.closest('tr')).attr('id');
                    pagoLinea = parseInt(pagoLinea) + 1;
                    $("input[name=pagoInput" + pagoLinea + "]").focus();

                    $('tr').css('background', 'none');
                    $('tr').css('color', 'black');

                    if ($(currCell.closest('tr')).attr('id')) {
                        imagen($(currCell.closest('tr').next()).attr('id'));
                    }

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
                    currCell.parent().css('color', '#fff');
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

                currCell = $('.productos_tabla').first();
                id_celda = $(currCell).attr('name');
                currCell.focus();
                $(currCell).css('background', '#0f4871');
                $(currCell).css('color', '#fff');
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

                    //console.log("-> ", precio_id, item.precio);

                    _productos.presentacion = item.presentacion;
                    _productos.id_producto_detalle = item.id_producto_detalle;
                    _productos.presentacionFactor = item.factor;
                    _productos.presentacionPrecio = item.precio;
                    _productos.presentacionUnidad = item.unidad;
                    _productos.presentacionCliente = item.Cliente;
                    _productos.presentacionCliente = item.Sucursal;
                    _productos.presentacionCodBarra = item.cod_barra;

                    _productos.precioUnidad = item.unidad;
                    _productos.total = item.precio;
                    _productos.producto2 = item.id_producto_detalle

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
            $(".producto_buscar").empty();
            $(".producto_buscar").focus();
            if (_productos.cantidad != null) {
                _productos.descuento = $("#descuento").val();

                if (contador_productos == 0) {
                    _productos.descuento = $("#descuento").val();

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
                $("#cantidad").val(1);
            });

        }

        function grabar_primeraves() {

            _orden[contador_productos] = _productos;

            _productos.descuento_calculado = calcular_descuento(_productos.descuento, _productos.total, _productos.descuento_limite);

            agregar_producto();

        }

        function grabar_mas() {
            var existe = 0;
            var cnt = 0;

            if (_productos != "") {

                contador_productos = _orden.length;

                if (_orden.length >= 1) {

                    $.each(_orden, function(i, item) {

                        if (item.producto2 == _productos.producto2 && item.id_producto_combo == null) {
                            existe = 1;

                            var cantidad = parseInt(_productos.cantidad) + parseInt(item.cantidad);

                            if (producto_escala != 0) {

                                var c = validar_escalas(cantidad);

                                _orden[cnt].presentacion = _productos.presentacion;
                                _orden[cnt].presentacionFactor = _productos.presentacionFactor;
                                _orden[cnt].precioUnidad = c;

                                var total_temp = calcularTotalProducto(c, cantidad);
                                $(".total" + _orden[cnt]['producto2']).text(total_temp);
                                _orden[cnt]['total'] = total_temp;
                            } else {

                                if (item.combo != 1) {
                                    var total_temp = calcularTotalProducto(_productos.presentacionPrecio, cantidad);
                                }
                            }
                            _orden[cnt]['total'] = total_temp;

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
                    producto_id: producto_id,
                    id_bodega: id_bodega,
                    id_producto_detalle: id_producto_detalle
                },
                url: "producto_combo",

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

                _productos.descuento_calculado = 0;
                _productos.id_producto_combo = id_producto_detalle;
                _productos.id_producto_detalle = datos['precios'][0].id_producto_detalle;
                _productos.descuento_limite = datos['atributos'].Descuento_Limite;
                _productos.presentacionCliente = datos['prod_precio'][0].Cliente;
                _productos.presentacionCodBarra = datos['precios'][0].cod_barra;
                _productos.presentacionPrecio = datos['precios'][0].precio;
                _productos.presentacionUnidad = datos['precios'][0].unidad;
                _productos.combo_total = null;

                _productos.producto2 = datos['precios'][0].id_producto_detalle;
                _productos.producto_id = datos['producto'][0].id_entidad;
                _productos.combo = datos['producto'][0].combo;
                _productos.inventario_id = datos['producto'][0].id_inventario;
                _productos.producto = datos['atributos'].Cod_Barras;
                _productos.descuento = 0.00;
                _productos.invisible = 0;
                _productos.cantidad = parseInt(datos['combo_cantidad']) * cantidad_final;
                _productos.precioUnidad = datos['prod_precio'][0].precio;
                _productos.bodega = datos['producto'][0].nombre_bodega;
                _productos.id_bodega = datos['producto'][0].id_bodega;
                _productos.impuesto_id = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                _productos.por_iva = datos['producto'][0].porcentage;
                _productos.gen = datos['producto'][10].valor;
                _productos.iva = datos['atributos']['Incluye Iva']; //datos['producto'][9].valor;
                _productos.descripcion = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                _productos.presentacion = datos['producto'][0].valor;
                _productos.total = (datos['prod_precio'][0].precio * _productos.cantidad);
                _productos.presentacionFactor = (datos['combo_cantidad'] * producto_cantidad_linea);

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
            console.log(p);
            p.forEach(function(datos) {

                

                var cantidad_final = combo_recalculo_cantidad(id_producto_detalle);

                _productos.descuento_calculado = 0;
                _productos.id_producto_combo = id_producto_detalle;
                _productos.id_producto_detalle = datos['precios'][0].id_producto_detalle;
                _productos.descuento_limite = datos['atributos'].Descuento_Limite;
                _productos.presentacionCliente = datos['prod_precio'][0].Cliente;
                _productos.presentacionCodBarra = datos['precios'][0].cod_barra;
                _productos.presentacionPrecio = datos['precios'][0].precio;
                _productos.presentacionUnidad = datos['precios'][0].unidad;
                _productos.combo_total = null;

                _productos.producto2 = datos['precios'][0].id_producto_detalle;
                _productos.producto_id = datos['producto'][0].id_entidad;
                _productos.combo = datos['producto'][0].combo;
                _productos.inventario_id = datos['producto'][0].id_inventario;
                _productos.producto = datos['atributos'].Cod_Barras;
                _productos.descuento = 0.00;
                _productos.cantidad = parseInt(datos['combo_cantidad']) * cantidad_final;
                _productos.precioUnidad = datos['prod_precio'][0].precio;
                _productos.bodega = datos['producto'][0].nombre_bodega;
                _productos.id_bodega = datos['producto'][0].id_bodega;
                _productos.impuesto_id = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                _productos.por_iva = datos['producto'][0].porcentage;
                _productos.gen = datos['producto'][10].valor;
                _productos.iva = datos['atributos']['Incluye Iva']; // datos['producto'][9].valor;
                _productos.descripcion = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                _productos.presentacion = datos['producto'][0].valor;
                _productos.total = 0.00;
                _productos.presentacionFactor = (datos['combo_cantidad'] * producto_cantidad_linea);
                _productos.invisible = 1;

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

        $(document).on('change', '#cantidad', function() {
            // Actualizar la cantidad

            var cantidad = $("#cantidad").val();

            if (_productos.producto != null && _productos.combo != 1) {
                
                producto_cantidad_linea = cantidad;
                //var producto_precio_flag = productos_precios_validacion();

                var precion = $("#precioUnidad").val();
                var cantidad = producto_cantidad_linea;


                if (producto_escala == 1) {

                    var escala_precio = validar_escalas(cantidad);

                    $("#total").val(calcularTotalProducto(escala_precio, cantidad));
                    $("#precioUnidad").val(escala_precio);
                    _productos.precioUnidad = escala_precio;

                } else {

                    $("#total").val(calcularTotalProducto(_productos.presentacionPrecio, cantidad));
                    $("#precioUnidad").val(_productos.precioUnidad);
                }

                _productos.cantidad = cantidad;
                _productos.total = $("#total").val();
                factor_precio = 0;
                factor_total = 0;
            } else {
                $("#total").val(calcularTotalProducto(_productos.presentacionPrecio, cantidad));
                $("#precioUnidad").val(_productos.precioUnidad);
                _productos.cantidad = cantidad;
                //_productos.total = $("#total").val();
                factor_precio = 0;
                factor_total = 0;
            }
        });

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
            $("#bodega_select").empty();
            var select_option;
            $.ajax({
                url: "get_bodega_sucursal/" + sucursal,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var bodega = datos["bodega"];
                    $.each(bodega, function(i, item) {
                        select_option += '<option value="' + item.id_bodega + '">' + item.nombre_bodega + '</option>';
                    });

                    $("#bodega_select").html(select_option);

                    var correlativo = datos['correlativo'];
                    $("#c_numero").val(correlativo[0].siguiente_valor);
                },
                error: function() {}
            });
        }

        function productos_precios_validacion() {

            var factor = 0;
            var precio_unidad = 0;
            var precio_total = 0;
            var flag = false;

            var descuento_digitado = $("descuento").val();

            if (_productos_precio != null) {
                console.log(_productos_precio);
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
                //alert(descuento_limite);
                if (descuento) {

                    if (primer_digito == 0) {

                        if (tipo_descuento_limite == 0) {
                            // Limite en %   
                            if (descuento <= parseInt(descuento_limite)) {
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

            $(".iva_nombre").html(iva_nombre);
            $(".iva_valor").text(iva_valor);
            $(".iva_total").html(iva_total);

            total_msg += parseFloat(imp_espeical_total);

            // --------------- * -----------------------------
            $(".total_msg").text(total_msg.toFixed(2));
            $(".cantidad_tabla").text(t.toFixed(2));
            $(".sub_total_tabla").text(t2.toFixed(2));
            $(".total_tabla").text(total_msg.toFixed(2));
            $(".descuento_tabla").text(descuento.toFixed(2));

            $("#compra_venta").text(total_msg.toFixed(2));
            $("#restante_venta").text(total_msg.toFixed(2));

        }

        $(document).on('click', '.guardar', function() {
            // Recargar Los Tipos de Pago Por Cliente
            var cli_form_pago = $("#cliente_codigo").val();
            var tipo_documento = $("#id_tipo_documento").val();

            guardarX(cli_form_pago, tipo_documento);

            $("#procesar_venta").modal();
            $('#procesar_btn').hide();
        });

        function f4_guardar() {

            var cli_form_pago = $("#cliente_codigo").val();
            var tipo_documento = parseInt($("#id_tipo_documento").val());

            pagos_mostrados[pagos_mostrados.length] = tipo_documento;

            guardarX(cli_form_pago, tipo_documento);

            $("#procesar_venta").modal();
            $('#procesar_btn').hide();
        }

        function guardarX(cli_form_pago, tipo_documento) {
            $.ajax({
                url: "get_form_pago/" + cli_form_pago + "/" + tipo_documento,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var metodo_pago = datos["metodo_pago"];
                    var metodo_pago_principal = datos['metodo_pago_doc'];

                    var _html = "";
                    var cou = 1;

                    _html += '<table class="table formas_pagos_valores">';

                    _html += '<thead><tr><td></td><td>Monto</td><td>Numero</td><td>Banco</td><td>Serie</td></tr></thead>';

                    pagos_mostrados.forEach(element => {                       

                        $.each(metodo_pago, function(i, item) {

                            if( element == parseInt(item.id_modo_pago) ){
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
                },
                error: function() {}
            });
        }

        function generar_select_pagos(metodo_pago){
            
            var options = "";

            $.each(metodo_pago, function(i, item) {
                options += "<option value='"+item.id_modo_pago+"'>"+item.nombre_modo_pago+"</option>";
            });

            $("#extraMetodoPago").html(options);

        }

        $(document).on('click', '.addMetodoPago', function() {
            var metodo_add = parseInt($("#extraMetodoPago").val());
            
            //if (pagos_mostrados.includes(metodo_add)) {

                pagos_mostrados[pagos_mostrados.length] = metodo_add;

                var cli_form_pago = $("#cliente_codigo").val();
                var tipo_documento = parseInt($("#id_tipo_documento").val());
                guardarX(cli_form_pago, tipo_documento);

            //}
        });

        $(document).on('change', '.metodo_pago_input', function() {

            if (total_msg <= 0) {
                return;
            }

            var temp = 0.00;
            var cambio = 0.00;
            var leng = $(this).attr('count');
            var count = 1;

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
            console.log(pagos_array);
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
            procesar_venta($('.guardar').attr('id'));
        });

        $(document).on('click', '#add_pago', function() {

            var select = $("#metodo_pago");
            var container = $("#metodo_pago_lista");

            var val = select.val();
            var text = select.selectedIndex;

            var html_ = "";
            html_ = "<input type='text' placeholder='" + text + "' name='" + val + "' class='form-control'>";

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

                if (element.id_producto_detalle == producto_id && element.id_producto_combo == null) {

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

        function depurar_producto() {
            // Remueve los productos selecionados
            contador_tabla = 1;


            if (_orden.length >= 1) {
                var tr_html = "";

                _orden.forEach(function(element) {
                    if (element.invisible == 0) {
                        tr_html += "<tr class='productos_tabla' style='' id='" + element.producto_id + "' name='" + element.id_producto_detalle + "'>";
                        tr_html += "<td class='border-table-left'>" + contador_tabla + "</td>";
                        tr_html += "<td class=''>" + element.producto + "</td>";
                        tr_html += "<td class=''>" + element.descripcion + "</td>";
                        tr_html += "<td class=''>" + element.cantidad + "</td>";
                        tr_html += "<td class=''>" + element.presentacion + "</td>";
                        tr_html += "<td class=''>" + element.presentacionFactor + "</td>";
                        tr_html += "<td class=''>" + element.precioUnidad + "</td>";
                        tr_html += "<td class=''>" + element.descuento_calculado + "</td>";
                        tr_html += "<td class=' total'>" + element.total + "</td>";
                        tr_html += "<td class=' '>" + element.bodega + "</td>";
                        if (element.combo == 1 || !element.id_producto_combo) {
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

                $(".producto_agregados").html(tr_html);

            } else {
                contador_productos = 0;
                _orden = [];
                _productos = {};
                _impuestos_orden_condicion = [];
                _impuestos_orden_especial = [];
                _impuestos_orden_excluyentes = [];

                total_msg = parseFloat(0.00);
                $(".total_msg").text("$ " + total_msg.toFixed(2));
                $(".producto_agregados").empty();
                calculo_totales();
            }

        }

        function get_clientes_lista() {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'><input type='text' placeholder='Buscar Cliente' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<tr class='bg-info-dark'><th>#</th><th>Codigo</th><th>Nombre Cliente</th><th>NRC</th><th>NIT</th><th>Action</th></tr>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: "get_clientes_lista",
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var clientes = datos["clientes"];
                    var cliente_id = 0;
                    clientes_lista = clientes;

                    $.each(clientes, function(i, item) {

                        if (cliente_id != item.id_cliente) {
                            cliente_id = item.id_cliente;
                            var precio = 0;

                            table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.id_cliente + '</td><td>' + item.nombre_empresa_o_compania + '</td><td>' + item.nrc_cli + '</td><td>' + item.nit_cliente + '</td><td><a href="#" class="btn btn-primary btn-xs seleccionar_cliente" id="' + item.id_cliente + '" name="' + item.nombre_empresa_o_compania + '" rel="' + item.direccion_cliente + '" impuesto="' + item.aplica_impuestos + '">Agregar</a></td></tr>';
                            contador_precios++;
                        }

                    });
                    table += table_tr;
                    table += "</tbody></table>";

                    $(".cliente_lista_datos").html(table);

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

            var tipo_documento = $("#id_tipo_documento").val();

            var sucursal_origen = $("#sucursal_id2").val();

            var cliente_id = $("#cliente_codigo").val();

            var formulario = $('#encabezado_form').serializeArray();

            var orden_estado = $(this).attr('name');
            var impuestos_data = {
                'imp_condicion': _impuestos_orden_condicion,
                'imp_especial': _impuestos_orden_especial,
                'imp_excluyente': _impuestos_orden_excluyentes
            }

            if (_orden.length != 0) {

                $.ajax({
                    type: 'POST',
                    data: {
                        orden: _orden,
                        encabezado: formulario,
                        estado: orden_estado,
                        impuestos: impuestos_data,
                        pagos: pagos_array,
                        documento_tipo: tipo_documento,
                        cliente: cliente_id,
                        sucursal_origen: sucursal_origen,
                    },
                    url: method,

                    success: function(data) {

                        //location.reload();
                    },
                    error: function() {}
                });
            }
        }

        $(document).on('click', '.seleccionar_cliente', function() {
            var id = $(this).attr('id');

            $("#cliente_codigo").val($(this).attr('id'));
            $("#cliente_nombre").val($(this).attr('name'));
            $("#direccion_cliente").val($(this).attr('rel'));
            $("#impuesto").val($(this).attr('impuesto'));
            $('#cliente_modal').modal('hide');

            $.ajax({
                url: "get_clientes_documento/" + id,
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
                        $("#id_tipo_documento").html("<option value='" + documentoSelecionado.id_tipo_documento + "'>" + documentoSelecionado.nombre + "</option>");
                    }

                    $.each(tipo_documento, function(i, item) {
                        if (item.id_tipo_documento != clienteWithDocumento[0].TipoDocumento) {
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
        });

        $(document).on('click', '.seleccionar_empleado', function() {

            $(".vendedores_lista").text($(this).attr('name'));
            $('#vendedores_modal').modal('hide');
        });

        function get_empleados_lista(sucursal) {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Codigo Empleado</th><th>Nombre Empleado</th><th>Apellido Empleado</th><th>Apellido Empleado</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                url: "get_empleados_by_sucursal/" + sucursal,
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

        $(document).on('click','#btn_update_products', function(){
            sessionStorage.clear();
            location.reload();
        });

        $(document).on('click', '.cliente_codigo', function() {
            $('#cliente_modal').modal('show');
            get_clientes_lista();
        });

        $(document).on('click', '.vendedores_lista', function() {
            $('#vendedores_modal').modal('show');
            get_empleados_lista($(this).attr("id"));
        });

        $(document).on('click', '#btn_existencias', function() {
            
            $(".existencia_buscar").focus();
            $('#existencias').modal('show');   
            
            setTimeout(function (){
                $('.existencia_buscar').focus();
            }, 1000);         

        });

        $(document).on('click', '#btn_impuestos', function() {
            _config_impuestos();
            depurar_producto();
        });

    });
</script>