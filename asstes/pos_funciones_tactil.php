<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
<script>
    var documento_inventario    = 0;


    function seleccionar_productos_array(precio_id) {

        if (_productos_precio.length > 1 ) {
            var item = _productos_precio.find(x => x.id_producto_detalle === precio_id);

            if (item) {

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
        }
    }

    $(document).ready(function() {

        $("#documento_limite_modal").appendTo('body');
        $('#existencias').appendTo("body");
        $('#procesar_venta').appendTo("body");
        $('#cliente_modal').appendTo("body");
        $('#vendedor_modal').appendTo("body");
        $('#vendedores_modal').appendTo("body");
        $('#presentacion_modal').appendTo("body");
        $("#autorizacion_descuento").appendTo("body");
        $("#devolucion").appendTo("body");
        $('#imprimir').appendTo("body");
        $('#anulado').appendTo("body");        
        $('#en_proceso').appendTo("body");
        $('#en_reserva').appendTo("body");
        $('#m_orden_creada').appendTo("body");
        $('.dataSelect').hide();
        $('.dataSelect2').hide();
        $('.1dataSelect').hide();
        $('.1dataSelect2').hide();
        $('.cliente_codigo2').hide();
        $('.msg_error').hide(); 
        $('.xyz').hide();

        var input_producto_buscar   = $(".producto_buscar");
        var input_bodega_select     = $("#bodega_select");
        var input_sucursal          = $("#sucursal_id").val();
        var input_cantidad          = $("#cantidad");
        var total_venta             = 0.00;
        var convetirToNegativo      = false;
        var convetirToAnulado       = false;
        var input_devolucion        = "";
        var input_devolucion_nombre = "";
        var input_devolucion_id     = "";
        var input_devolucion_dui    = "";
        var input_devolucion_nit    = "";
        var error                   = false;
        var total_elementos         = 0;
        var contadorCorrelativos    = 0;
        var total_venta             = 0.00;
        var total_cambio            = 0.00;
        var _correlativos_lista     = [];
        var correlativo_disponible  = false;
        var documento_limite        = 0;
        var height = 39;

        input_producto_buscar.focus();
        bodega = input_bodega_select.val();

        var bodega = 0;
        var pagos_array = [];
        var correlativos_array = [];
        var interno_bodega = 0;
        var pagos_mostrados = [];
        var _productos_precio2;
        var flag_autenticacion = false;
        var producto_cantidad_linea = 1;
        var input_autorizacion_descuento = 0;
        var mondeda_global = '';
        
        getImpuestosLista();
        get_limite_documento();

        function getImpuestosLista() {
            /** Load Impuestos everytime */

            $.ajax({
                url: "<?php echo base_url(); ?>producto/orden/get_impuestos_lista",
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

    load_mask();
    
    var valor1_html = "";
    var documento_editar_valor = $("#numero_documento_persona").val();
    var documento_tipo_persona = numero_documento_persona_lenght($("#numero_documento_persona").val());
    
    if(documento_tipo_persona == 9){
        $("input:radio[id=dui]").attr('checked', true);
    }
    if(documento_tipo_persona == 14){
        $("input:radio[id=nit]").attr('checked', true);
    }
    
    $("input:radio[name=identificacion]").on('change', function(){

        if ($(this).val() == 'nit') {
            valor1_html = '<input type="text" name="numero_documento_persona" data-accept="" id="numero_documento_persona" class="form-control" placeholder="____-______-___-_" value="'+documento_editar_valor+'" data-slots="_">';
        } else {
            valor1_html = '<input type="text" name="numero_documento_persona" data-accept="" id="numero_documento_persona" class="form-control" placeholder="________-_" value="'+documento_editar_valor+'" data-slots="_">';
        }
        $(".valor1").html(valor1_html);
        load_mask();
    });

    var dui_lenght = 0;
    // This code empowers all input tags having a placeholder and data-slots attribute
    function load_mask(){
        for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
            const pattern = el.getAttribute("placeholder"),
                slots = new Set(el.dataset.slots || "_"),
                prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
                first = [...pattern].findIndex(c => slots.has(c)),
                accept = new RegExp(el.dataset.accept || "\\d", "g"),
                clean = input => {
                    input = input.match(accept) || [];
                    return Array.from(pattern, c =>
                        input[0] === c || slots.has(c) ? input.shift() || c : c
                    );
                },
                format = () => {
                    const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                        i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                        return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                    });
                    
                    el.value = clean(el.value).join``;
                    el.setSelectionRange(i, j);
                    back = false;
                };
            let back = false;
            el.addEventListener("keydown", (e) => back = e.key === "Backspace");
            el.addEventListener("input", format);
            el.addEventListener("focus", format);
            el.addEventListener("blur", () => el.value === pattern && (el.value=""));
        }
    }

    $(document).on('click',"#guardar_orden", function(){
        if (_orden.length != 0) {
            $("#guardar_orden").attr("disabled","disabled");
            procesar_venta($("#guardar_orden").attr('name'));
        }
    });

    function numero_documento_persona_lenght(valor){
        return  (valor.match(/\d/g) || []).length;
    }

/**
 * PROCESAR VENTA
 */
function procesar_venta(method) {

    if (total_msg >= documento_limite && (documento_limite != "")) {
        var tipo_radio = $("input:radio[name=identificacion]:checked").val();
        var numero_documento_persona = $("#numero_documento_persona").val();

        if ($("#numero_documento_persona").val() == "") {
            $("#numero_documento_persona").css("border","3px solid red");
            $("#documento_limite_modal").modal('show');
            $("#guardar_orden").attr("disabled",false);
            return false;
        }
        var document_caracter = numero_documento_persona_lenght(numero_documento_persona)

        if(tipo_radio == 'nit' && document_caracter < 14) {
            $('.documento_formato').html("FORMATO NIT INCOMPATIBLE <br> Caracteres Encontrados "+ document_caracter);
            $("#documento_limite_modal").modal('show');
            $("#guardar_orden").attr("disabled",false);
            return false;
        }

        if(tipo_radio == 'dui' && document_caracter < 9) {
            $('.documento_formato').html("FORMATO DUI INCOMPATIBLE <br> Caracteres Encontrados "+ document_caracter);
            $("#documento_limite_modal").modal('show');
            $("#guardar_orden").attr("disabled",false);
            return false;
        }

        var cliente_nombre_nombre = $("#cliente_nombre").val().toLowerCase();
        if(cliente_nombre_nombre == 'varios') {
            $('.documento_formato').html("DEBE INGRESAR NOMBRE CLIENTE CORRESPONDIENTE AL DOCUMENTO" );
            $("#documento_limite_modal").modal('show');
            $("#guardar_orden").attr("disabled",false);
            return false;
        }

        
    }

    var tipo_documento  = $("#id_tipo_documento").val();
    var sucursal_origen = $("#sucursal_id2").val();
    var cliente_id      = $("#cliente_codigo").val();
    var correlativo_documento = $("#correlativo_documento").val();
    var formulario      = $('#encabezado_form').serializeArray();
    var orden_estado    = $("#orden_estado").val(); //$(this).attr('name');
    var orden_numero    = $("#orden_numero").val();
    var vista_id        = formulario.find(x => x.name === 'vista_id').value;

    this.convetirToNegativo  =  $("#check_devolucion").is(":checked")   ? true : false;

    formulario[formulario.length] = { name : 'devolucion_nit'       , value :  $("#input_devolucion_nit").val()};           
    formulario[formulario.length] = { name : 'devolucion_dui'       , value :  $("#input_devolucion_dui").val()};
    formulario[formulario.length] = { name : 'devolucion_nombre'    , value :  $("#input_devolucion_nombre").val()};
    formulario[formulario.length] = { name : 'devolucion_documento' , value :  $("#input_devolucion").val()};
    formulario[formulario.length] = { name : 'check_devolucion'     , value :  this.convetirToNegativo };

    formulario[formulario.length] = { name : 'doc_cli_nombre'     , value :  $("#doc_cli_nombre").val() };
    formulario[formulario.length] = { name : 'doc_cli_identificacion', value :  $("#doc_cli_identificacion").val() };
    formulario[formulario.length] = { name : 'input_devolucion_id'  , value : this.input_devolucion_id ?? 0 };

    if ($("#orden_estado_venta").val()) {
        orden_estado = $("#orden_estado_venta").val();
    }

    if(_impuestos_orden_iva[0]){
        _impuestos_orden_iva[0].ordenImpTotal = total_iva;                
    }else{
        _impuestos_orden_iva.ordenImpTotal = total_iva;
    }

    var impuestos_data = {
        'imp_condicion' : _impuestos_orden_condicion,
        'imp_especial'  : _impuestos_orden_especial,
        'imp_excluyente': _impuestos_orden_excluyentes,
        'imp_iva'       : _impuestos_orden_iva,
        'exento_iva'    : _impuestos_orden_exento
    }

    _orden[0]['total_dinero'] = total_venta;
    _orden[0]['total_cambio'] = total_cambio;

    if (_orden.length != 0) {
        $.ajax({
            type: 'POST',
            data: {
                orden       : _orden,
                encabezado  : formulario,
                estado      : orden_estado,
                impuestos   : impuestos_data,
                pagos       : pagos_array,
                cliente     : cliente_id,
                orden_numero: orden_numero,
                documento_tipo      : tipo_documento,
                sucursal_origen     : sucursal_origen,
                correlativo_documento: correlativo_documento,
                correlativos_extra: correlativos_array,
            },
            url: "<?php echo base_url(); ?>producto/orden/"+ method,

            success: function(data) {

                var datos = JSON.parse(data);

                if(method == "update_orden"){
                    location.reload();
                    return;
                }
                
                if(orden_numero){
                    cerrar_orden(orden_numero);
                }

                if(!datos.code){
                    if (method == "guardar_orden") {
                        window.location.href = "<?php echo base_url(); ?>producto/orden/nuevo?data=" + data;
                        $(".numero_correlativo").text(data);
                        reset_calculos();
                        depurar_producto();
                        $("#guardar_orden").attr("disabled",false);
                    }
                    else if (method == "../venta/guardar_venta") 
                    {                                
                        $(".transacion").text(datos['msj_title'] + datos['msj_orden']);
                        $(".print_venta").attr("href", "venta/" + datos['id']);
                        if(vista_id == 13){
                            if(orden_numero){
                                window.location.href = "../../venta/facturacion/" + datos['id'];
                            }else{
                                window.location.href = "../venta/facturacion/" + datos['id'];
                            }
                        }else{
                            window.location.href = "../venta/facturacion/" + datos['id'];                            
                        }
                    }
                }else{
                    $(".db_msj").html("<i class='fa fa-exclamation-triangle'></i> Base de Datos Notificación. CODIGO : " +datos.code);
                }                        
            },
            error: function() {}
        });
    }

    if (method != "update_orden") {
        //cerrar_orden($("#orden_numero").val());
    }
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

        $(document).on('click', '#existencia_buscar_click', function(e) {
            var busqueda_texto = $(".existencia_buscar").val();

            if (busqueda_texto.length != 0) {

                get_existencia(busqueda_texto);

            } else {
                $('.dos').empty();
            }
        });

        function get_existencia(texto) {
            /** Load existencias - Producto filtrados */

            sucursal        = input_sucursal;
            var bodega      = input_bodega_select.val();
            interno_bodega  = bodega;
            interno_sucursal= sucursal;

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>producto/orden/get_productos_lista",
                datatype: 'json',
                data: {
                    sucursal: sucursal,
                    bodega: bodega,
                    texto: texto,
                },
                cache: false,

                success: function(data) {

                    var datos       = JSON.parse(data);
                    var productos   = datos["productos"];

                    if (productos != "") {

                        var producto_id = 0;
                        _productos_lista = productos;

                        existencia_buscar(_productos_lista, texto);
                    } else {

                        var type = "info";
                        var title = "Verifique Sucursal y Bodega ";
                        var mensaje = "Error en Parametros : search_texto 2";
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
                table_tr += '<option value="' + item.id_entidad + '" style="font-size: 18px; color:red;">' + item.nombre_marca + ' ' + item.name_entidad + ' - ' + item.presentacion + ' - ' + precio.toFixed(2) + '</option>';
                contador_precios++;

                $('.1dataSelect').show();
            });

            $(".1dataSelect").html(table_tr);

            $('.1dataSelect').focus();
            document.getElementById('1dataSelect').selectedIndex = 0;
        }

        var input = document.getElementById("buscar_orden");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                var buscar_orden = $("#buscar_orden").val();
                window.location.href = "<?php echo base_url(); ?>producto/orden/editar/" + buscar_orden;         
            }
        });

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

        $(document).on('click', '.1dataSelect', function() {

                get_producto_completo2(this.value);
                event.preventDefault();
                input_producto_buscar.empty();
                $('.1dataSelect').hide();
                $('.1dataSelect').empty();
                $(".existencia_buscar").focus();
                $(".existencia_buscar").select();
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

            $.ajax({
                url: "<?php echo base_url(); ?>producto/existencias/get_producto_completo/"+ producto_id,
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
                        html += '<td>' + item.moneda_simbolo + " " + item.precio + '</td>';
                        html += '<td>' + item.presentacion + '</td>';
                        html += '<td>' + item.codigo_barras + '</td>';
                        html += '</tr>';
                        contador++;
                    });
                    html += '<tr><td colspan="2"></td><td>Total</td><td>' + existencias_total + '</td><td colspan="4"></td></tr>'
                    $('.dos').html(html);

                },
                error: function() {
                    alert("Error Conexion");
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

        $(document).on('click', '#producto_buscar_click', function(e) {
            /* 1 - Input Buscar Producto CLICK*/

            var texto_busqueda = input_producto_buscar.val();

            if (texto_busqueda.length != 0) {
                search_texto(input_producto_buscar.val());
            } else {
                $('.dataSelect').empty();
                $('.dataSelect').hide();
            }
        });

        function search_texto(texto) {
            /* 2 - Filtrado del texto a buscar en productos */

            sucursal    = input_sucursal;
            var bodega  = input_bodega_select.val();
            interno_sucursal = sucursal;            

            interno_bodega = bodega;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>producto/orden/get_productos_lista/",
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
                    mondeda_global = datos['moneda'][0];
                    if (productos != "") {

                        var producto_id = 0;
                        _productos_lista = productos;

                        showProducts(_productos_lista);
                    } else {
                        input_producto_buscar.val("");
                        var type = "info";
                        var title = "Verifique Sucursal y Bodega ";
                        var mensaje = "<b>Mensaje :</b> No se encontro ningun resultado";
                        var boton = "info";
                        var finalMessage = "Intentelo de nuevo!"
                        var url = null;
                        var focusBoton = input_producto_buscar;
                        generalAlert(type, mensaje, title, boton, finalMessage,url,focusBoton);

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
            cliente_producto= $("#cliente_codigo").val();
            sucursal_producto= $("#sucursal_id").val();

            if (_productos_lista.length == 1) {
                if(_productos_lista[0].Cantidad == 0){
                    <?php
                        if ( $configuracion[0]->valor_conf == 1 ) :
                    ?>
                        var type = "info";
                        var title = _productos_lista[0].name_entidad +" Sin Existencias ";
                        var mensaje = "";
                        var boton = "info";
                        var finalMessage = "Gracias..."
                        var url = null;
                        var focusBoton = input_producto_buscar;
                        generalAlert(type, mensaje, title, boton, finalMessage,url, focusBoton);
                    <?php endif ?>
                }
                get_producto_completo(_productos_lista[0].id_producto_detalle);
                input_producto_buscar.val("");

            } else {

                var prod_escala_prev    = 0;
                var prod_escala_next    = 0;
                var prod_escala_cont    = 0;
                var prod_temp_id        = 0;
                var id_producto_presentacion = 0;
                var conInterno = 0;
                var idInterno = 0;
                table_tr += "<option value='0'> Selecione Producto </option>";
                $.each(_productos_lista, function(i, item) {

                    if ((id_producto_presentacion != item.id_entidad)
                        //&& (item.productoCliente == cliente_producto || item.productoCliente==null ||item.productoCliente==0)
                        //&& (item.productoSucursal == sucursal_producto || item.productoSucursal==null ||item.productoSucursal==0)
                        ) {
                        prod_escala_prev = item.id_entidad;
                        id_producto_presentacion = item.id_entidad;

                        if (prod_escala_prev != prod_escala_next || item.Escala == 0) {
                            prod_escala_next= item.id_entidad;
                            prod_temp_id    = item.id_producto_detalle;
                            producto_id     = item.id_entidad;
                            precio          = parseFloat(item.precio);
                            table_tr        += '<option value="' + item.id_entidad + '" style="font-family: monospace;">' + item.nombre_marca + ' ' +item.modelo + ' '+ item.name_entidad + ' - ' + item.presentacion + ' - ' + mondeda_global.moneda_simbolo + " " + precio.toFixed(2) + '</option>';
                            contador_precios++;
                            prod_escala_cont++;
                            conInterno++;
                            idInterno = item.id_entidad;
                        }
                    }
                });
                if (conInterno == 1) {
                    filtrar_presentaciones(idInterno);
                } else {
                    $('.dataSelect').show();               
                    $(".dataSelect").html(table_tr);
                    selected = document.getElementById('dataSelect').selectedIndex = 0;
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

        /* 3 -Traer Presentaciones */
        $(document).on('keypress', '.dataSelect', function() {

            if (event.which == 13) {
                filtrar_presentaciones(this.value);
                event.preventDefault();
                $('#dataSelect').hide();
                input_producto_buscar.val("");
            }

        });

        $(document).on('change', '.dataSelect', function() {
            
            filtrar_presentaciones(this.value);
            event.preventDefault();
            $('#dataSelect').hide();
            input_producto_buscar.val("");

        });

        function filtrar_presentaciones(producto)
        {
            var table_tr = "";
            var contador_precios = 1;
            $(".dataSelect2").html(table_tr);
            var prod_escala_prev    = 0;
            var prod_escala_next    = 0;
            var prod_escala_cont    = 0;
            var prod_temp_id        = 0;
            table_tr += "<option value='0'> Selecione Producto </option>";
            $.each(_productos_lista, function(i, item) {

                if (producto == item.id_entidad ){
                    prod_escala_prev = item.id_entidad;
                    
                    if (prod_escala_prev != prod_escala_next || item.Escala == 0) {
                        prod_escala_next= item.id_entidad;
                        prod_temp_id    = item.id_producto_detalle;
                        producto_id     = item.id_entidad;
                        precio          = parseFloat(item.precio);
                        table_tr        += '<option value="' + item.id_producto_detalle + '" style="font-family: monospace;">' + item.nombre_marca + ' ' +item.modelo + ' '+ item.name_entidad + ' - ' + item.presentacion + ' - ' + mondeda_global.moneda_simbolo + " " + precio.toFixed(2) + '</option>';
                        contador_precios++;
                        prod_escala_cont++;
                    }
                }
            });
            if (prod_escala_cont <= 1) {

                get_producto_completo(prod_temp_id);
                input_producto_buscar.val("");

            } else {
                $('.dataSelect2').show();
                $(".dataSelect2").html(table_tr);
                document.getElementById('dataSelect2').selectedIndex = 0;
                document.getElementById('dataSelect2').focus();
                $('.dataSelect2').siblings().show();
            }
        }

        /* Buscar Producto Real */
        $(document).on('keypress', '.dataSelect2', function() {

            if (event.which == 13) {
                get_producto_completo(this.value);
                event.preventDefault();
                $('#dataSelect').hide();
                input_producto_buscar.val("");
            }

            if (event.which == 49) {
                $('#dataSelect').show();
                selected = document.getElementById('dataSelect').selectedIndex = 0;
                document.getElementById('dataSelect').focus();
                $('#dataSelect2').hide();
            }
        });

        /* Buscar Producto Real  CLICK*/
        $(document).on('change', '.dataSelect2', function() {
            get_producto_completo(this.value);
            event.preventDefault();
            $('#dataSelect').hide();
            input_producto_buscar.val("");
        });

        function get_producto_completo(producto_id) {

            /* 4 - Buscar producto por Id para agregarlo a la linea */
            $("#grabar").attr('disabled');
            var codigo, presentacion, tipo, precioUnidad, descuento, total
            interno_bodega = input_bodega_select.val();

            if (!interno_bodega) {

                var type    = "info";
                var title   = "Verifique Sucursal y Bodega ";
                var mensaje = "Error en Parametros : get_producto_completo";
                var boton   = "info";
                var finalMessage = "Gracias..."
                generalAlert(type, mensaje, title, boton, finalMessage);

                return;
            }

            $.ajax({
                //url: path + "get_producto_completo/" + producto_id + "/" + interno_bodega,
                url: "<?php echo base_url(); ?>producto/orden/get_producto_completo/"+ producto_id + "/" + interno_bodega,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos           = JSON.parse(data);
                    var precio_unidad   = datos['producto'][0].unidad;
                    _productos_precio2  = datos["prod_precio"];
                    producto_escala     = datos['producto'][0].Escala;
                    
                    var pre             = _productos_precio2.find(x => x.id_producto_detalle === producto_id);
                    if (pre) {
                        _productos_precio = pre;
                    }

                    _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);
                    _conf.impuesto      = parseInt(datos['impuesto'][0].valor_conf);
                    _conf.descuentos    = parseInt(datos['descuentos'][0].valor_conf);

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

                    _productos.producto_id  = datos['producto'][0].id_entidad;
                    _productos.combo        = datos['producto'][0].combo;
                    _productos.inventario_id = datos['producto'][0].id_inventario;
                    _productos.producto     = datos['producto'][0].codigo_barras;
                    _productos.descuento_limite = datos['producto'][0].descuento_limite;
                    _productos.descuento    = 0.00; // datos['producto'][7].valor;
                    _productos.cantidad     = producto_cantidad_linea;
                    _productos.total        = 0.00; //$("#total").val();
                    _productos.id_producto_combo = null;
                    _productos.combo_total  = null;
                    _productos.invisible    = 0;
                    _productos.bodega       = datos['producto'][0].nombre_bodega;
                    _productos.id_bodega    = datos['producto'][0].id_bodega;
                    _productos.impuesto_id  = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                    _productos.por_iva      = datos['producto'][0].porcentage;
                    _productos.gen          = datos['producto'][0].iva;
                    _productos.iva          = datos['producto'][0].incluye_iva; //datos['producto'][9].valor;
                    _productos.descripcion  = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                    _productos.total        = _productos_precio.precio;
                    _productos.categoria    = datos['producto'][0].categoria;
                    _productos.escala       = producto_escala;

                    grabar();
                    //_config_impuestos();
                    agregar_producto();
                    depurar_producto();

                    producto_cantidad_linea = 1;

                },
                error: function() {
                    alert("Error : Verificar Producto y Bodega");
                }
            });
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

        function enLinea() {

            $("#presentacion").val(_productos_precio.presentacion);
            $("#factor").val(_productos_precio.factor);
            _productos.presentacion         = _productos_precio.presentacion;
            _productos.precioUnidad         = _productos_precio.unidad;
            _productos.presentacionFactor   = _productos_precio.factor;
            _productos.id_producto_detalle  = _productos_precio.id_producto_detalle;
            _productos.presentacionPrecio   = _productos_precio.precio
            _productos.presentacionUnidad   = _productos_precio.unidad;
            _productos.presentacionCliente  = _productos_precio.Cliente;
            _productos.producto2            = _productos_precio.id_producto_detalle;
            _productos.presentacionCodBarra = _productos_precio.cod_barra;
        }

        function validar_escalas(c) {
            /* Valida las escalas de los productos cuando se aunmenta la cantidad */

            var total_precio_escala = 0;
            var newValor;
            $.each(_productos_precio2, function(i, item) {

                pf = parseInt(item.factor);

                if (c == pf) {

                    total_precio_escala             = parseFloat(item.unidad);
                    _productos.precioUnidad          = parseFloat(item.unidad);
                    _productos.presentacion         = item.presentacion;
                    _productos.presentacionFactor   = item.factor;
                    _productos.id_producto_detalle  = item.id_producto_detalle;
                    $("#presentacion").val(item.presentacion);
                    $("#factor").val(item.factor);

                } else {

                    if (c >= pf) {
                        total_precio_escala             = parseFloat(item.unidad);
                        _productos.precioUnidad          = parseFloat(item.unidad);
                        _productos.presentacionFactor   = item.factor;
                        _productos.presentacion         = item.presentacion;
                        _productos.id_producto_detalle  = item.id_producto_detalle;
                        $("#presentacion").val(item.presentacion);
                        $("#factor").val(item.factor);
                    }
                }

            });
            return _productos;
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
            var contadorPagoIndice = 1;

            $(document).on("click", ".producto_agregados > tr", function() {
                //$('tr').css('background', 'none');
                $('tr').css('color', 'black');

                id_celda = $(this).attr('name');

                $(this).css('background', '#ececec');
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
                switch (e.key) {
                    case 'ArrowLeft': 
                        input_producto_buscar.select();             
                        input_producto_buscar.focus();
                        $('.producto_agregados > tr').blur();
                        $("#dataSelect").hide();
                        
                        currCell = 0;
                        moveCursorToEnd(input_producto_buscar);
                        break;
                    case 'Enter': $("#procesar_btn").focus();
                        break
                    case 'ArrowUp':
                        break;
                    case '?': // /;
                        focus_general_input(input_cantidad, 1);
                        break;
                    case 'ArrowDown':
                        break;
                    case '!':
                        $("#documentoModel").modal();
                        break;
                    case '"':                  
                        producto_tabla_foco();
                        break;
                    case '#':
                        eliminar_elemento_tabla(id_celda);
                        break;
                    case '$':
                        f4_guardar();
                        break
                    case '%':
                        open_devolucion();
                        break;
                    case '&':
                        show_existencias();
                        break;
                    case '/':
                        descuento();
                        break;
                    case '(':
                        f7_foco_efectivo();
                        break;                    
                    case ')':
                        f8_table_pagos();
                        break;
                    case '-':
                        //focus_general_input($("#buscar_orden"), 0);
                        focus_general_input($("#orden_numero"), 0);
                        //orden_numero
                        break;
                    case '*':
                        focus_general_input($("#descuento"), 0);
                        break;
                    case 'C':
                        focus_general_input($("#venta_numero"), 0);
                        break;
                    case '=': open_anulado_modal();
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

                    if($('#procesar_venta').not(":visible")){
                        c = currCell.closest('tr').prev().find('td:eq(' +currCell.index() + ')');

                        height -= 39;
                        //$('.lista_productos').animate({scrollIntoView: height}, 1);
                        id_celda = $(currCell.closest('tr').prev()).attr('name');

                        if($('.dataSelect').not(":visible")){
                            var Xh = $(currCell.closest('tr').prev()).attr('name');
                            console.log(Xh);
                            $("input[cd=" + Xh + "]").focus();
                            $("input[cd=" + Xh + "]").select();
                        }

                        //$('tr').css('background', 'none');$('tr').css('background', 'none');
                        $('tr').css('color', 'black');

                        if ($(currCell.closest('tr')).attr('id')) {
                            imagen($(currCell.closest('tr').prev()).attr('id'));
                        }
                        $('.lista_productos').animate({
                            scrollTop: height
                        }, 1);
                    }

                    if($('#procesar_venta').is(":visible")){
                        // Subir en modal de pagos al siguiente metodo de pago
                        if($("input[name=pagoInput" + (contadorPagoIndice-1) + "]:first").length){
                            contadorPagoIndice = contadorPagoIndice -1;
                        }
                        console.log("Subiendo -->", contadorPagoIndice);
                        $("input[name=pagoInput" + contadorPagoIndice + "]:first").focus();


                    }                    
                
                } else if (e.keyCode == 40) {
                    // Down Arrow

                    if($('#procesar_venta').not(":visible")){
                        c = currCell.closest('tr').next().find('td:eq(' +currCell.index()+ ')');

                        $('.lista_productos').animate({
                            scrollIntoView: height
                        }, 1);
                        height += 39;

                        id_celda = $(currCell.closest('tr').next()).attr('name');

                        var pagoLinea = $(currCell.closest('tr')).attr('id');
                        if($('.dataSelect').not(":visible")){
                            var Xh = $(currCell.closest('tr').next()).attr('name');
                            $("input[cd=" + Xh + "]").focus();
                            $("input[cd=" + Xh + "]").select();
                        }
                        //$('tr').css('background', 'none');
                        $('tr').css('color', 'black');

                        if ($(currCell.closest('tr')).attr('id')) {
                            imagen($(currCell.closest('tr').next()).attr('id'));
                        }

                        $('.lista_productos').animate({
                            scrollTop: height
                        }, 1);
                    }                   

                    if($('#procesar_venta').is(":visible")){
                        // Bajar en modal de pagos al siguiente metodo de pago
                        if($("input[name=pagoInput" + (contadorPagoIndice+1) + "]:first").length){
                            contadorPagoIndice = contadorPagoIndice +1;
                        }
                        console.log("Bajando -->", contadorPagoIndice);
                        $("input[name=pagoInput" + contadorPagoIndice + "]:first").focus();
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

                    currCell.parent().css('background', '#ececec');
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

            $(".anulado").click(function(){
                $('#anulado').on('shown.bs.modal', function(e){                    
                    setTimeout(function() {                    
                        $(".btn_anular_documento").focus();
                    }, 100);  
                });
            });

            function open_anulado_modal(){
                show_anulado_numero();
                $("#anulado").modal();
                $('#anulado').on('shown.bs.modal', function(e){                    
                    setTimeout(function() {                    
                        $(".btn_anular_documento").focus();
                    }, 100);  
                });
            }

            $(document).on('click', '.anulado', function(e) {
                show_anulado_numero();
            });

            function show_anulado_numero(){
                var msg_anulado = "# " + $("#input_devolucion").val();

                $(".anular_documento").text(msg_anulado);
            }

            function open_devolucion(){
                $("#devolucion").modal();
                setTimeout(function() {                    
                    $("#check_devolucion").focus();
                    $(".check_devolucion").css('border','2px solid #4974a7'); 
                }, 100);
            }

            function producto_tabla_foco() {
                //$("#lista_productos").select();
                //$('.lista_productos').focus();
                $('.lista_productos').animate({
                    scrollTop: 0
                }, 100);

                currCell = $('.producto_agregados > tr').first();
                if($('.dataSelect').not(":visible")){
                    var Xh = $(currCell).attr('name');
                    valorInput = $("input[cd=" + Xh + "]").val();
                    $("input[cd=" + Xh + "]").focus();
                    $("input[cd=" + Xh + "]").select();
                    
                    setTimeout(() => {
                        $("input[cd=" + Xh + "]").val(valorInput);
                    }, 200);
                }

                //$('tr').css('background', 'none');
                $('tr').css('color', 'black');
                id_celda = $(currCell).attr('name');
                $(currCell).css('background', '#ececec');
                $(currCell).css('color', 'black');
                //currCell.focus();
            }

            function f7_foco_efectivo() {
                $("#extraMetodoPago").focus();
            }

            $(document).on('change', '#extraMetodoPago', function() {
                $(".addMetodoPago").focus();
                $(".addMetodoPago").removeClass("bg-green");
                $(".addMetodoPago").css("background-color","#1e983b");
                $(".addMetodoPago").css("color","#fff");
                //add_metodo_pago($("#extraMetodoPago").val());
            });

            // Selecionando otro meotodo de pago para agregarlo al modal de pago

            function f8_table_pagos() {
                //$("input[name=pagoInput1]").focus();
                var valor_pago = $("input[name='pagoInput1']:first").val();
                $("input[name='pagoInput1']:first").focus();
                currCell = $('.pagos_tabla').first();

                setTimeout(() => {
                    $("input[name='pagoInput1']:first").val(valor_pago);
                }, 200);

                id_celda = $(currCell).attr('name');
                //currCell.focus();
                $(currCell).css('background', '#0f4871');
                $(currCell).css('color', '#fff');
            }

        });


        /* FIN DE ACCESOS DIRECTOS */

        $(document).keypress(function(e) {
            if (e.keyCode == 43) { // 43(+)

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
            $(this).css("background", "#ececec");
            $(this).css("color", "black");

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
                        //_config_impuestos();
                        //depurar_producto();
                    }
                }
            }

            $('.uno').find('input').each(function() {

                this.value = '';
                $("#grabar").val("Agregar");
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

        function descuento(){
            // Descuento Aprobacion flag_autenticacion
            $("#autorizacion_descuento").modal();
            $("#input_autorizacion_descuento").focus();
            setTimeout(() => {
                $("#input_autorizacion_descuento").val("");
            }, 100);
        }

        $(document).on('click', '#btn_discount', function() {
            descuento();
        });

        $(".btn_aut_desc").click(function() {

            var user    = input_autorizacion_descuento   = $("#input_autorizacion_descuento").val();
            var passwd  = input_autorizacion_descuento   = $("#input_autorizacion_passwd").val();

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
                    //url: "autenticar_usuario_descuento",
                    url: "<?php echo base_url(); ?>producto/orden/autenticar_usuario_descuento",

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

            _orden[contador_productos]      = _productos;
            _productos.descuento_calculado  = calcular_descuento(_productos.descuento, _productos.total, _productos.descuento_limite);

            //agregar_producto();
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

                                var c = validar_escalas(cantidad);

                                _orden[cnt].presentacion = c.presentacion;
                                _orden[cnt].presentacionFactor = c.presentacionFactor;
                                _orden[cnt].precioUnidad = c.precioUnidad;

                                var total_temp = calcularTotalProducto(c.precioUnidad, cantidad);
                                $(".total" + _orden[cnt]['producto2']).text(total_temp);
                                _orden[cnt]['total'] = total_temp;
                            } else {
                                
                                if (item.combo != 1) {                                    
                                    var total_temp = calcularTotalProducto(item.presentacionPrecio, cantidad);
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

                            
                        }

                        cnt++;
                    });
                    
                    calculo_totales();
                    //depurar_producto();
                } else {
                    grabar_combo();

                    _productos.descuento            = $("#descuento").val();
                    _productos.descuento_calculado  = calcular_descuento(_productos.descuento, _productos.total, _productos.descuento_limite);
                    _orden[contador_productos]      = _productos;
                    //agregar_producto();

                }
            }
            if (existe == 0) {
                grabar_combo();

                _productos.descuento            = $("#descuento").val();
                _productos.descuento_calculado  = calcular_descuento(_productos.descuento, _productos.total, _productos.descuento_limite);
                _orden[contador_productos]      = _productos;
                //agregar_producto();
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
                //url: path + "producto_combo",
                url: "<?php echo base_url(); ?>producto/orden/producto_combo",

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
                _productos.producto                 = datos['producto'][0].codigo_barras;
                _productos.descuento                = 0.00;
                _productos.invisible                = 0;
                _productos.cantidad                 = parseInt(datos['combo_cantidad']) * cantidad_final;
                _productos.precioUnidad             = datos['prod_precio'][0].precio;
                _productos.bodega                   = datos['producto'][0].nombre_bodega;
                _productos.id_bodega                = datos['producto'][0].id_bodega;
                _productos.impuesto_id              = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                _productos.por_iva                  = datos['producto'][0].porcentage;
                _productos.iva                      = datos['producto'][0].incluye_iva; //datos['producto'][9].valor;
                _productos.descripcion              = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                _productos.presentacion             = datos['producto'][0].presentacion;
                _productos.total                    = (datos['prod_precio'][0].precio * _productos.cantidad);
                _productos.presentacionFactor       = (datos['combo_cantidad'] * producto_cantidad_linea);

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

                console.log("agrupado ", _productos.total);

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
                //_config_impuestos();
                depurar_producto();
            }
            
        }

        function sumar_combo_total(combo_padre_total, id_producto_detalle) {

            var combo_x = _orden.filter(x => x.id_producto_detalle  ==  id_producto_detalle);
            
            combo_x.forEach(function(element) {
                _orden[_orden.indexOf(element)].combo_total = combo_padre_total;
                _orden[_orden.indexOf(element)].total       = combo_padre_total;
                _orden[_orden.indexOf(element)].precioUnidad= combo_padre_total / _orden[_orden.indexOf(element)].cantidad ;
            });

            depurar_producto();
        }

        function agregar_agrupado(id_producto_detalle, p) {
            var sub_total;
            var unidad;
                        
            p.forEach(function(datos) {

                var prodOrden = _orden.filter(x => x.id_producto_detalle  ==  id_producto_detalle);

                prodOrden.forEach(function(element) {
                    
                    var id                  = _orden.indexOf(element);
                    sub_total               = (datos['combo_cantidad']              * datos['prod_precio'][0].precio);
                    _orden[id].total        = parseFloat(_orden[id].total)          + (parseFloat(sub_total) * _orden[id].cantidad);
                    _orden[id].precioUnidad = parseFloat(_orden[id].precioUnidad)   + parseFloat(sub_total);
                    _orden[id].combo_total  = parseFloat(_orden[id].total)          + (parseFloat(sub_total) * _orden[id].cantidad);
                    recalcular_descuento_combo(id_producto_detalle, _orden[id].total, _orden[id].descuento);
                    _orden[id].descuento_calculado = calcular_descuento(_orden[id].descuento, _orden[id].total, _orden[id].descuento_limite);
                    
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
                _productos.producto                 = datos['producto'][0].codigo_barras;
                _productos.descuento                = 0.00;
                _productos.invisible                = 0;
                _productos.cantidad                 = parseInt(datos['combo_cantidad']) * cantidad_final;
                _productos.precioUnidad             = datos['prod_precio'][0].precio;
                _productos.bodega                   = datos['producto'][0].nombre_bodega;
                _productos.id_bodega                = datos['producto'][0].id_bodega;
                _productos.impuesto_id              = datos['producto'][0].tipos_impuestos_idtipos_impuestos;
                _productos.por_iva                  = datos['producto'][0].porcentage;
                _productos.iva                      = datos['producto'][0].incluye_iva; //datos['producto'][9].valor;
                _productos.descripcion              = datos['producto'][0].name_entidad + " " + datos['producto'][0].nombre_marca;
                _productos.presentacion             = datos['producto'][0].presentacion;
                _productos.total                    = (datos['prod_precio'][0].precio * _productos.cantidad);
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

            var cantidad = input_cantidad.val();

            producto_cantidad_linea = cantidad;

            if (_productos.producto != null && _productos.combo != 1) {

                producto_cantidad_linea = cantidad;
                //var producto_precio_flag = productos_precios_validacion();

                var precion = $("#precioUnidad").val();
                var cantidad = producto_cantidad_linea;

                if (producto_escala == 1) {
                    var escala_precio = validar_escalas(cantidad);
                    calcularTotalProducto(escala_precio.precioUnidad, cantidad)
                    $("#precioUnidad").val(escala_precio.precioUnidad);
                    _productos.precioUnidad = escala_precio.precioUnidad;

                } else {
                    calcularTotalProducto(_productos.presentacionPrecio, cantidad)
                    $("#precioUnidad").val(_productos.precioUnidad);
                }

                factor_total = 0;
                factor_precio = 0;
                _productos.cantidad = cantidad;
                _productos.total = $("#total").val();

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
                //url: path + "get_bodega_sucursal/" + sucursal,
                url: "<?php echo base_url(); ?>producto/orden/get_bodega_sucursal/" + sucursal,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    select_option ="";
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

            var flag            = false;
            var factor          = 0;
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
                    solicitar_documento_total_mayor_documento();
                }
            }
        }

        $(document).on('change', '#factura_documento', function() {
            get_limite_documento();
        });

        function get_limite_documento(){
            var factura_documento_id = $("#factura_documento").val();

            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>producto/orden/limite_documento/"+ factura_documento_id,
                success: function(result) {
                    documento_limite = result;
                }
            });
        }

        function solicitar_documento_total_mayor_documento()
        {
            if (total_msg >= documento_limite ) {
                $("#numero_documento_persona").css("border","3px solid red");
            }
        }

        $(document).on('change', '#id_tipo_documento', function() {

            
            $('.id_tipo_documento_main option[value='+$(this).val()+']').prop('selected', true);


            var cli_form_pago   = $("#cliente_codigo").val();
            var tipo_documento  = parseInt($(this).val());
            var sucursal_id     = $("#sucursal_id2").val();
            
            documento_inventario = tipo_documento;

            correlativo_documento(cli_form_pago, tipo_documento, sucursal_id);
        });

        $(document).on('change', '.id_tipo_documento_main', function() {
            valor = $('.id_tipo_documento_main option:selected').val();
            
            $('.id_tipo_documento option[value='+valor+']').prop('selected', true);

            var cli_form_pago   = $("#cliente_codigo").val();
            var tipo_documento  = parseInt($(this).val());
            var sucursal_id     = $("#sucursal_id2").val();
            documento_inventario= tipo_documento;

            correlativo_documento(cli_form_pago, tipo_documento, sucursal_id);
        });

        function getTotalElementos(){
            return this.total_elementos;
        }

        /*
        * PROCESO ANULAR
        */
        $(document).on('click','.btn_anular_documento', function(){

            convetirToAnulado   =  $("#check_anulacion").is(":checked")    ? true : false;

            var notificar_data = {
                id : "#anular_documento_msg",
                msj : "Ingresar N° Orden Para Anular",
                color: "#2b957a",
                text_class :".anular_documento_msg",
                icon : "fa fa-exclamation-circle"
            };
            
            if(convetirToAnulado){
                var nota_anulado = $("#nota_anulacion").val();
                anulacion_data   = {nota_anulacion:nota_anulado, id:_orden[0].id};

                path = "../venta";
                $.ajax({
                    type: "POST",
                    //url: path + "/anular_venta",
                    url: "<?php echo base_url(); ?>producto/orden/anular_venta",
                    datatype: 'json',
                    data : anulacion_data,
                    cache: false,

                    success: function(data) {
                        window.location.href = "venta_rapida";
                    },
                    error: function() {}
                });
            }else{                
                notificador(notificar_data);
            }
        });

        function notificador(notificar_data){
            $(notificar_data.id).css("background-color", notificar_data.color);
            $(notificar_data.text_class).html("<i class='"+notificar_data.icon+"'></i> "+notificar_data.msj);

            setTimeout(function() {
                $(notificar_data.id).css("background-color", "#fff");                
                $(notificar_data.text_class).html("");
            }, 3000);
        }

        $(document).on('click', '.guardar', function() {
            f4_guardar();
        });

        function f4_guardar() {
            var cli_form_pago   = $("#cliente_codigo").val();
            var tipo_documento  = parseInt($("#id_tipo_documento").val());
            var sucursal_id     = $("#sucursal_id2").val();
            var id_modo_pag     = $("#modo_pago_id").val();

            if (!pagos_mostrados.includes(id_modo_pag)) {
                pagos_mostrados[pagos_mostrados.length] = id_modo_pag;
            }
            
            guardarX(cli_form_pago, tipo_documento, sucursal_id);
            correlativo_documento(cli_form_pago, tipo_documento, sucursal_id);

            $("#procesar_venta").modal();
            $('#procesar_btn').hide();
        }

        function correlativo_documento(cli_form_pago, tipo_documento, sucursal_id) {
            var total_articulos = getTotalElementos();
            contadorCorrelativos = 0;
            $.ajax({
                //url: path + "get_correlativo_documento/" + tipo_documento + "/" + sucursal_id + "/"+total_articulos,
                url: "<?php echo base_url(); ?>producto/orden/get_correlativo_documento/"+ tipo_documento + "/" + sucursal_id + "/"+total_articulos,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos           = JSON.parse(data);
                    var correlativo     = datos["correlativo"];
                    documento_inventario= correlativo[0].efecto_inventario;
                    documento_limite    = correlativo[0].monto_limite;
                    $("#correlativo_documento").val(correlativo[0].siguiente_valor);
                    var inputs = "<hr>";
                    var increment = 1;
                    cantidad_por_documento = datos['cantidad_por_documento'];
                    
                    $.each(datos['numeros_correlativos'], function(i, item) {
                        inputs += "<div class='col-lg-3 col-md-3'><input type='text' class='form-control correlativo"+item+" lista_correlativos' name='"+item+"' value='"+item+"' id='correlativo"+item+"' /></div>";
                        $(".correlativo"+item).appendTo("body");
                        _correlativos_lista[_correlativos_lista.length] = item;
                        increment++;
                        contadorCorrelativos++;
                    });

                    $(".correlativos_documentos").html(inputs);
                    depurar_producto();
                },
                error: function() {}
            });
        }

        $(document).on('change','.lista_correlativos', function(){
            var correlativo_documento   = $("#id_tipo_documento").val();
            correlativo_id              = $(this).attr('id');
            var correlativo_numero      = $(this).val();            

            verificar_correlativo(correlativo_documento, correlativo_numero);
        });

        function verificar_correlativo(documento , correlativo){
            data = { documento,correlativo,input_sucursal };
            $.ajax({
                type: 'POST',
                //url: path + "../venta/check_correlativo",
                url: "<?php echo base_url(); ?>producto/venta/check_correlativo",
                data : data,
                cache: false,
                datatype: 'json',

                success: function(data) {
                    var venta = JSON.parse(data);
                    venta = venta ? venta[0] : venta;
                    console.log(venta);
                    if (venta != null) {
                        correlativo_disponible = true;
                        $(".mensajes_varios").text(venta.nombre + venta.serie_correlativo + venta.num_correlativo +" no disponible");
                    }else{
                        correlativo_disponible = false;
                        $(".mensajes_varios").text("");
                    }
                },
                error: function() {}
            });
        }

        function guardarX(cli_form_pago, tipo_documento, sucursal_id) {
            var sucursal_id     = input_sucursal;
            var internal_total  = this.total_venta;

            $.ajax({
                //url: path + "get_form_pago/" + cli_form_pago + "/" + tipo_documento + "/" + sucursal_id,
                url: "<?php echo base_url(); ?>producto/orden/get_form_pago/"+ cli_form_pago + "/" + tipo_documento + "/" + sucursal_id,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos       = JSON.parse(data);
                    var metodo_pago = datos["metodo_pago"];
                    var metodo_pago_principal = datos['metodo_pago_doc'];

                    var _html = "";
                    var cou = 1;                    

                    _html += '<table class="table formas_pagos_valores">';

                    _html += '<thead style="background:rgb(236, 236, 236);"><tr><td><span class="badge badge-success" style="background:#2D3B48;font-size: 16px;"> # 9</span></td><td>Monto</td><td>Numero</td><td>Banco</td><td>Serie</td></tr></thead>';

                    pagos_mostrados.forEach(element => {

                        $.each(metodo_pago, function(i, item) {
                            
                            if (element == parseInt(item.id_modo_pago)) {
                                _html += '<tr class="pagos_tabla"  id="' + cou + '"><td><div class="btn bg-green">' + item.nombre_modo_pago + '</div></td>';
                                _html += '<td class="">' +
                                    '<input type="text" count=' + metodo_pago.length + ' size="9px" name="pagoInput' + cou + '" ids=' + item.id_modo_pago + ' id=' + item.nombre_modo_pago + ' class="metodo_pago_input" autocomplete="off"/></td>';
                                
                                _html += '<td><input type="text" count=' + metodo_pago.length + '  size="14px" name="val' + cou + '" placeholder="" class="metodo_pago_input" autocomplete="off" /></td>';
                                _html += '<td><input type="text" count=' + metodo_pago.length + ' size="14px" name="ban' + cou + '" placeholder="" class="metodo_pago_input" autocomplete="off" /></td>';
                                _html += '<td><input type="text" count=' + metodo_pago.length + ' size="14px" name="ser' + cou + '" placeholder="" class="metodo_pago_input" autocomplete="off" /></td>';
                                _html += '</tr>';
                                cou++;
                            }
                        });
                    });
                    _html += '</table>';
                    
                    generar_select_pagos(metodo_pago);
                    $("#metodos_pagos").html(_html);
                    $("input[name='pagoInput1']:first").focus();
                    $("input[name='pagoInput1']:first").val(internal_total);
                    $("input[name='pagoInput1']:first").select();

                    if($("#check_devolucion").is(":checked")){
                        this.convetirToNegativo = true;
                        $('#orden_estado option[value=10]').prop('selected', 'selected').change();
                    }
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
            add_metodo_pago(metodo_add);
        });

        function add_metodo_pago(metodo_add){

            $(".addMetodoPago").css("background-color","#2D3B48");
            $(".addMetodoPago").css("color","#fff");
            
            pagos_mostrados[pagos_mostrados.length] = metodo_add;

            var cli_form_pago = $("#cliente_codigo").val();
            var tipo_documento = parseInt($("#id_tipo_documento").val());
            guardarX(cli_form_pago, tipo_documento);
        }

        $(document).on('keyup', '.metodo_pago_input', function() {
            pagos_proceso($(this).attr('count'));
        });

        $(document).on('change', '.metodo_pago_input', function() {
            pagos_proceso($(this).attr('count'));
        });

        function pagos_proceso(leng){
            if (total_msg <= 0 && this.convetirToNegativo==false) {
                return;
            }
            
            var temp    = 0.00;
            var cambio  = 0.00;
            var leng    = leng;
            var count   = 1;
            pagos_array = [];
            correlativos_array = [];

            while (count <= contadorCorrelativos) {
                correlativos_array[count-1] = $(":input[name=correlativo" + count + "]").val();
                count++;
            }
            count = 0;
            while (count <= leng) {

                types = $(":input[name=pagoInput" + count + "]").attr('id');
                value = $(":input[name=pagoInput" + count + "]").val();
                ids   = $(":input[name=pagoInput" + count + "]").attr('ids');

                val = $(":input[name=val" + count + "]").val();
                ban = $(":input[name=ban" + count + "]").val();
                ser = $(":input[name=ser" + count + "]").val();

                pagos_array[pagos_array.length] = {
                    id      : ids,
                    type    : types,
                    amount  : value,
                    valor   : val,
                    banco   : ban,
                    serie   : ser
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

            $("#cambio_venta").text(cambio);

            if (cambio == 0 && !correlativo_disponible) {
                $("#cambio_venta").text(0.00);
                $("#restante_venta").text(0.00);
                $('#procesar_btn').show();
                //$('#procesar_btn').focus();
            } else if (cambio >= 0.01) {
                $("#cambio_venta").text(cambio.toFixed(2));
                $('#procesar_btn').show();
                //$('#procesar_btn').focus();
            } else if (cambio <= 0) {
                $("#restante_venta").text(cambio.toFixed(2));
            }
            total_venta = total_msg;
            total_cambio = cambio;
        }

        $(document).on('click', '#procesar_btn', function() {
            if(this.convetirToNegativo == true || documento_inventario == 1){
                if(
                    $("#input_devolucion").val()        == "" &&
                    $("#input_devolucion_nit").val()    == "" &&
                    $("#input_devolucion_dui").val()    == "" &&
                    $("#input_devolucion_nombre").val() == "")
                    {
                    $(".input_devolucion_btn").hide();
                    $("#devolucion").modal();
                    setTimeout(function() {
                        $("#check_devolucion").focus();
                    }, 100);
                }else{
                    procesar_venta($(this).attr('name'));
                }
            }else{
                procesar_venta($(this).attr('name'));
            }
        });

        $(document).on('click', '#add_pago', function() {

            var select      = $("#metodo_pago");
            var container   = $("#metodo_pago_lista");
            var val         = select.val();
            var text        = select.selectedIndex;
            var html_       = "";
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

                if (element.id_producto_detalle == producto_id && (element.id_producto_combo == null || element.id_producto_combo == 0)) {

                    total_msg -= parseInt(calcularTotalProducto(element.precioUnidad, element.cantidad));
                    $(".total_msg").text("$ " + total_msg.toFixed(2));

                    _orden.splice(_orden.indexOf(element), 1);
                    if (_conf.impuesto == 1) {
                        //_config_impuestos();
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
                var key = e.key;
                if (key == 'Q') { //Modal de Facturacion en Venta Rapida                    
                    av($('#id_tipo_documento'), "white");
                }
                if (key == 'W') {
                    av($('#cliente_codigo'), "none");
                }
                if (key == 'E') {
                    av($('#modo_pago_id'), "white");
                }
                if (key == 'R') {
                    av($('#cliente_nombre'), "white");
                }
                if (key == 'T') {
                    av($('#sucursal_id') , "white");
                }
                if (key == 'Y') {
                    av($('#bodega_select'), "white");
                }
                if (key == 'U') {
                    av($('#sucursal_id2'), "white");
                }
                if (key == 'I') {
                    av($('#fecha_factura'), "white");                    
                }
                $(this).css("background", "white");
            }
        });

        function av(input, color){
            $(".lineas_formulario").remove();
            $( input ).before( '<i class="fa fa-check lineas_formulario" style="color:#68af93"></i>' );
            setTimeout(function() { input.focus() }, 1000);
            input.addClass("background_inputs");
            setTimeout(function() {
                input.removeClass("background_inputs");
                input.css("color", "black");
            }, 1000);
        }

        function get_clientes_lista(texto_cliente) {

            $(".buscar_cliente").focus();
            $(".cliente_codigo2").html(table_tr);
            $(".cliente_codigo_click").text("");
            var table_tr = "";

            $.ajax({
                //url: path + "get_clientes_lista/" + texto_cliente,
                url: "<?php echo base_url(); ?>producto/orden/get_clientes_lista/"+ texto_cliente,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos = JSON.parse(data);
                    var clientes = datos["clientes"];
                    var cliente_id = 0;

                    clientes_lista = clientes;
                    if(clientes){
                        var client = clientes;

                        if (client.length == 1) {
                            cliente_id = client.id_cliente;

                            $.each(client, function(i, item) {
                                buscar_cliente_proceso(item.id_cliente,item.nombre_empresa_o_compania,item.direccion_cliente,item.saldos);
                            });

                        }else{
                            $.each(client, function(i, item) {
                                table_tr += '<option value="' + item.id_cliente + '" name="' + 
                                item.nombre_empresa_o_compania + '" rel="' + 
                                item.direccion_cliente + '" impuesto="' + 
                                item.aplica_impuestos + '">' + 
                                item.nombre_empresa_o_compania + ' / NRC ' + item.nrc_cli + ' / NIT ' + item.nit_cliente + ' / Saldo $ ' + item.saldos + '</option>';
                            });

                            $('.cliente_codigo2').show();
                            $(".cliente_codigo2").html(table_tr);
                            document.getElementById('cliente_codigo2').selectedIndex = 0;
                            document.getElementById('cliente_codigo2').focus();
                        }
                    } else {
                        $(".cliente_codigo_click").text("No Hay Datos");
                    }

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


        function cerrar_orden(correlativo_orden) {

            $.ajax({
                type: 'POST',
                data: {
                    correlativo_orden: correlativo_orden,
                },
                url: path + "cerrar_orden",

                success: function(data) {

                    //location.reload();
                    //window.location.href = "nuevo";
                },
                error: function() {}
            });
        }

        $(document).on('keypress', '.cliente_codigo2', function() {

            var id = $(this).val();
            var cliente_nombre = $(this).find('option:selected').attr("name");
            var cliente_direccion = $(this).find('option:selected').attr("rel");

            buscar_cliente_proceso(id,cliente_nombre,cliente_direccion);
        });

        function buscar_cliente_proceso(id,cliente_nombre,cliente_direccion,saldos)
        {
            var saldos = saldos ? null : 0.00;
            $("#cliente_codigo").val(id);
            $("#cliente_nombre").val(cliente_nombre);
            $("#direccion_cliente").val(cliente_direccion);
            $("#impuesto").val($(this).attr('impuesto'));
            $('#cliente_codigo2').modal('hide');
            $(".saldo").text("Saldo $ " + saldos +" - ");
            $.ajax({
                //url: path + "get_clientes_documento/" + id,
                url: "<?php echo base_url(); ?>producto/orden/get_clientes_documento/" + id,
                datatype: 'json',
                cache: false,

                success: function(data) {

                    var datos       = JSON.parse(data);
                    var tipo_pago   = datos["tipoPago"]; // Lista de todos los tipos de pago
                    var tipo_documento      = datos["tipoDocumento"]; // Todos los tipos de documentos 
                    var clienteTipoPagos    = datos["cliente_tipo_pago"]; // Tipos de pago asignados al cliente
                    var clienteWithDocumento= datos["clienteDocumento"]; // Informacion unica del cliente

                    clientes_lista = clienteTipoPagos;
                    calculo_totales();
                    // Set de documento a cliente
                    var documentoSelecionado = tipo_documento.find(x => x.id_tipo_documento == clienteWithDocumento[0].TipoDocumento);

                    $.each(tipo_documento, function(i, item) {
                        var n = item.nombre;
                        if (n.includes('Orden')) {
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
        }

        $(document).on('click', '.seleccionar_empleado', function() {

            $(".vendedores_lista1").text($(this).attr('name'));
            $("#vendedor1").val($(this).attr('id'));
            $('#vendedores_modal').modal('hide');
            $('#vendedor_modal').modal('hide');
        });

        function get_empleados_lista(sucursal) {

            var table = "<table class='table table-sm table-hover'>";
            table += "<tr><td colspan='9'>Buscar <input type='text' class='form-control' name='buscar_producto' id='buscar_producto'/> </td></tr>"
            table += "<th>#</th><th>Codigo Empleado</th><th>Nombre Empleado</th><th>Apellido Empleado</th><th>Apellido Empleado</th><th>Action</th>";
            var table_tr = "<tbody id='list'>";
            var contador_precios = 1;

            $.ajax({
                //url: path + "get_empleados_by_sucursal/" + sucursal,
                url: "<?php echo base_url(); ?>producto/orden/get_empleados_by_sucursal/"+ sucursal,
                datatype: 'json',
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var clientes = datos["empleados"];
                    var cliente_id = 0;

                    //clientes.find(x => x.id_cliente !== cliente_id);

                    $.each(clientes, function(i, item) {

                        if (cliente_id != item.id_empleado) {
                            cliente_id = item.id_empleado;
                            var precio = 0;

                            table_tr += '<tr><td>' + contador_precios + '</td><td>' + item.codigo_empleado + '</td><td>' + item.primer_nombre_persona + '</td><td>' + item.segundo_nombre_persona + '</td><td>' + item.primer_apellido_persona + '</td><td><a href="#" class="btn btn-primary btn-ms seleccionar_empleado" id="' + item.id_empleado + '" name="' + item.primer_nombre_persona + ' ' + item.primer_apellido_persona + '">Agregar</a></td></tr>';
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

        $(document).on('click', '.cliente_codigo_click', function() {
            get_clientes_lista($("#cliente_codigo").val());
        });

        $(document).on('click', '.vendedores_lista1', function() {
            $('#vendedor_modal').modal('show');
            get_empleados_lista($(this).attr("id"));
        });

        $(document).on('click', '#btn_existencias', function() {
            show_existencias();
        });

        $(document).on('change', '.cntProducto', function() {
            //if (event.which == 13) {
                var prod_id_input  = $(this).attr('cd');
                var prod_val_input = $(this).val();

                if( prod_val_input > 0 ){
                    var x = _orden.find(x => x.producto2 == prod_id_input);

                    if (x.escala == 1) {
                        productTemp = validar_escalas(prod_val_input);

                        _orden[_orden.indexOf(x)].precioUnidad = productTemp.precioUnidad;
                        _orden[_orden.indexOf(x)].presentacion = productTemp.presentacion;
                        _orden[_orden.indexOf(x)].presentacionFactor = productTemp.presentacionFactor;

                        var unidad_factor = _orden[_orden.indexOf(x)].precioUnidad;
                        _orden[_orden.indexOf(x)].cantidad  = prod_val_input;
                        _orden[_orden.indexOf(x)].total     = calcularTotalProducto(productTemp.precioUnidad, prod_val_input);

                    }else{
                        var unidad_factor = _orden[_orden.indexOf(x)].precioUnidad * _orden[_orden.indexOf(x)].presentacionFactor;
                        _orden[_orden.indexOf(x)].cantidad  = prod_val_input;
                        _orden[_orden.indexOf(x)].total     = calcularTotalProducto(unidad_factor, prod_val_input);
                    }
                    $(".total_items").text(total_items);
                    //this.total_elementos = _orden.

                    depurar_producto();
                }
            //}
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
                
                var prod_id_input  = $(this).attr('name');
                var prod_val_input = $(this).val();
                
                var x = _orden.find(x => x.producto == prod_id_input);

                _orden[_orden.indexOf(x)].presentacionPrecio  = prod_val_input;
                _orden[_orden.indexOf(x)].precioUnidad        = prod_val_input;
                _orden[_orden.indexOf(x)].presentacionUnidad  = prod_val_input;
                _orden[_orden.indexOf(x)].total     = calcularTotalProducto(_orden[_orden.indexOf(x)].cantidad,prod_val_input);
                depurar_producto();
            }
        });        

        $(document).on('click', '#btn_impuestos', function() {
            //_config_impuestos();
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
        gravado_exento = "";
        total_items    = 0;
        //total_iva = Math.abs(total_iva);
        if (_orden.length >= 1) {
            var tr_html = "";           
            
            _orden.forEach(function(element) {
                
                gravado_exento = _orden[_orden.indexOf(element)].tipo;

                _orden[_orden.indexOf(element)].total               = Math.abs(element.total);
                _orden[_orden.indexOf(element)].desc_val            = Math.abs(element.desc_val);
                _orden[_orden.indexOf(element)].precioUnidad        = Math.abs(element.precioUnidad);
                _orden[_orden.indexOf(element)].descuento_calculado = Math.abs(element.descuento_calculado);

                if(this.documento_inventario == 1 || this.convetirToNegativo == true)
                {
                    _orden[_orden.indexOf(element)].total               = element.total * -1;
                    _orden[_orden.indexOf(element)].desc_val            = element.desc_val * -1;
                    _orden[_orden.indexOf(element)].precioUnidad        = element.precioUnidad * -1;
                    _orden[_orden.indexOf(element)].descuento_calculado = element.descuento_calculado * -1;
                }

                var precio_tag  = parseFloat(element.precioUnidad);
                var desc_tag    = parseFloat(element.descuento_calculado);
                var total_tag   = parseFloat(element.total);
                
                if (element.invisible == 0) {
                    tr_html += "<tr class='productos_tabla' style='' id='" + element.producto_id + "' name='" + element.id_producto_detalle + "'>";
                    tr_html += "<td class='border-table-left'>" + contador_tabla + "</td>";
                    tr_html += "<td class=''>" + element.producto + "</td>";
                    tr_html += "<td class=''>" + element.descripcion + "</td>";
                    tr_html += "<td class=''><input type='text' autocomplete='off' name='cntProducto' cd='"+element.id_producto_detalle+"' class='form-control cntProducto' size='3' id='" + element.producto + "' value='" + element.cantidad + "' style='border:1px solid grey;'></input></td>";
                    tr_html += "<td class=''>" + element.presentacion + "</td>";
                    tr_html += "<td class=''>" + element.presentacionFactor + "</td>";
                    if(precio_tag==0){
                        tr_html += "<td class=''><input type='text' class='form-control preProducto' size='4' name='" + element.producto + "' value='" + precio_tag.toFixed(2) + "' style='border:1px solid red;'></input></td>";
                    } else {
                        tr_html += "<td class=''><input type='text' class='form-control preProducto' size='4' name='" + element.producto + "' value='" + precio_tag.toFixed(2) + "' style='border:1px solid grey;'></input></td>";
                    }

                    tr_html += "<td class=''><input type='text' class='form-control cntProducto' size='4' id='d" + element.producto + "' value='" + desc_tag.toFixed(2) + "' style='border:1px solid grey;'></input></td>";
                    tr_html += "<td class=' total'>" + total_tag.toFixed(2) +" "+ gravado_exento + "</td>";
                    tr_html += "<td class=' '>" + element.bodega + "</td>";
                    if (element.combo == 1 || !element.id_producto_combo || element.invisible == 0) {
                        tr_html += "<td class='border-left'><button type='button' class='btn btn-labeled bg-green eliminar' name='" + element.id_producto_detalle + "' id='eliminar' value=''><span class=''><i class='fa fa-times'></i></span></button></td>";
                    } else {
                        tr_html += "<td class='border-left'> - </td>";
                    }

                    tr_html += "</tr>";
                    total_items+=1;
                    contador_tabla++;
                }
            });
            $(".cantidad_tabla").val(4);
            $(".sub_total_tabla").val(4);
            $(".total_items").text(total_items);
            this.total_elementos = total_items;

            calculo_totales();
            $("#cantidad").val(1);

            $(".producto_agregados").html(tr_html);

        } else {
            reset_calculos();
        }
    }

    function reset_calculos()
    {
        contador_productos          = 0;
        _orden                      = [];
        _productos                  = {};
        _impuestos_orden_condicion  = [];
        _impuestos_orden_especial   = [];
        _impuestos_orden_excluyentes= [];

        total_msg = parseFloat(0.00);
        $(".total_msg").text("$ " + total_msg.toFixed(2));
        $(".producto_agregados").empty();
        calculo_totales();
    }

    function calculo_totales() {

        var t           = 0;
        var t2          = 0;
        var sub         = 0;
        var descuento   = 0;
        var iva_nombre  = "";
        var iva_valor   = "";
        var iva_total   = "";
        var imp_espeical_total = 0;

        // --------------- * -----------------------------

        if (_orden != null) {
            _orden.forEach(function(element) {

                t += parseInt(element.cantidad);
                if (
                    (_conf.comboAgrupado == 0) && 
                    (element.id_producto_combo != null && 
                    element.combo == 0)) 
                {
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

            var impuestos_nombre    = "";
            var impuestos_valor     = "";
            var impuestos_total     = "";

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
                if (element.condicion_simbolo == "+") 
                {
                    imp_espeical_total += parseFloat(sub);
                } else if (element.condicion_simbolo == " - ") 
                {
                    imp_espeical_total -= parseFloat(sub);
                }

                impuestos_nombre += "<i style='text-align: right;color:grey;'>" + element.ordenImpName + "(" + element.ordenImpVal + ")</i><br>";

                impuestos_total += "<i style='text-align: right;color:grey;'><?php echo $moneda[0]->moneda_simbolo." "; ?> " + sub + "</i><br>";

            });

            $(".impuestos_nombre").html(impuestos_nombre);
            $(".impuestos_total").html(impuestos_total);
        } else {
            $(".impuestos_nombre").empty();
            $(".impuestos_total").empty();
        }

        /* ------------Impuestos - IVA -----------*/
        
        if(documento_inventario==1)
        {
            sub_total_ = sub_total_ * (-1);
        }else{
            sub_total_ = Math.abs(sub_total_);
        }

        if(!this.convetirToNegativo){
            total_msg = (t2 - descuento);
        }else{
            total_msg = (t2 - descuento);
        }

        $(".iva_nombre").empty();
        $(".iva_valor").empty();
        $(".iva_total").empty();
        var temp = 0;
        if (total_iva != 0 && _orden.length != 0) {
            total_msg += parseFloat(total_iva_suma);
        }
        

        iva_nombre += "<p style='text-align: right;'>IVA</p>";
        iva_valor += total_iva.toFixed(2);
        iva_total += "<p><?php echo $moneda[0]->moneda_simbolo; ?>" + total_msg.toFixed(2) + "</p>";


        var exento_valor = exento_iva_suma.toFixed(2);

        $(".iva_nombre").html(iva_nombre);
        $(".iva_valor").text(iva_valor);
        $(".iva_total").html(iva_total);
        $(".exento_valor").text(exento_valor);

        total_msg += parseFloat(imp_espeical_total);

        sub_total_ = parseFloat(sub_total_);

        // --------------- * -----------------------------
        $(".total_msg").        text(total_msg.toFixed(2));
        $(".cantidad_tabla").   text(t.toFixed(2));
        $(".sub_total_tabla").  text(sub_total_.toFixed(2));
        $(".total_tabla").      text(total_msg.toFixed(2));
        $(".descuento_tabla").  text(descuento.toFixed(2));
        $("#compra_venta").     text(total_msg.toFixed(2));
        $("#restante_venta").   text(total_msg.toFixed(2));
        this.total_venta        = total_msg.toFixed(2);
    }

    function existAutorizatio() {

        $(document).ready(function() {
            validar_autorizacion();
        });

        function validar_autorizacion() {
            alert(input_autorizacion_descuento);
        }

    }

    $(document).ready(function() {

    var interval = setInterval(function() {
        var momentNow = moment();
//        $('#time-part').html(momentNow.format('MMMM DD'));
        $('#format-date').html(momentNow.format('hh:mm A'));
        $('.time-time').html(momentNow.format('hh:mm A'));
      }, 100);

      var momentNow = moment();

      var months = {

        January: {
          Name : "January",
          Translate : "Enero"
        },

        February: {
          Name : "February",
          Translate : "Febrero"
        }, 

        March: {
          Name : "March",
          Translate : "Marzo"
        }, 

        April: {
          Name : "April",
          Translate : "Abril"
        }, 

        May: {
          Name : "May",
          Translate : "Mayo"
        }, 

        June: {
          Name : "June",
          Translate : "Junio"
        }, 

        July: {
          Name : "July",
          Translate : "julio"
        }, 

        August: {
          Name : "August",
          Translate : "Agosto"
        },

        September: {
          Name : "September",
          Translate : "Septiembre"
        },

        October: {
          Name : "October",
          Translate : "Octubre"
        },

        November: {
          Name : "November",
          Translate : "Noviembre"
        },

        December: {
          Name : "December",
          Translate : "Diciembre"
        },

      };

      for(var i in months){
        if(i ==  momentNow.format('MMMM') ){
          //console.log(months[i].Translate);
          $('#time-part').html(months[i].Translate +" "+ momentNow.format('DD') + " / "+ momentNow.format('Y'));
          $('.time-date').html(months[i].Translate +" "+ momentNow.format('DD') + " / "+ momentNow.format('Y'));
        }
      }
    });
</script>