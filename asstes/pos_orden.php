<script>
    $(document).ready(function() {

        // OBTENER ORDENES PARA CONVERTIRLAS A VENTA

        registro_editado = 1;

        var contador_ingreso = 0;
        var cnt22 = 0;

        $(document).on('keypress', '#orden_numero', function(e) {

            if (e.keyCode == 13) {
                
                if (this.value != "") {
                    getImpuestosLista();
                    get_orden(this.value);
                    
                } else {
                    _orden = [];
                    getImpuestosLista();
                    depurar_producto();
                    contador_ingreso = 0;
                }
            }
        });

        $(document).on('keypress', '#input_devolucion', function(e) {
            // Cargar Venta en pantalla
            if (e.keyCode == 13) {                
                if (this.value != "") {
                    getImpuestosLista();
                    get_venta(this.value);                    
                }
            }
        });       

        if(path == "../"){            
            var id_orden = window.location.pathname.split("/").pop();
            getImpuestosLista();
            get_orden(id_orden);            
        }

        function get_venta(venta_id){
            var convetirToNegativo = false;
            $("#devolucion").modal('hide');
            $("#input_devolucion").val('');
            if($("#check_devolcuion").is(":checked")){
                convetirToNegativo = true;
            }
            
            $.ajax({
                type: "POST",
                url: "../venta/autoload_venta",
                datatype: 'json',
                data: {
                    id: venta_id
                },
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var venta = datos["orden_detalle"];

                    if(!venta){
                        var type = "info";
                        var title = "Venta No Valida ";
                        var mensaje = "Venta No Existe : autoload_ventan";
                        var boton = "info";
                        var  finalMessage = "Gracias..."
                        generalAlert(type , mensaje , title , boton, finalMessage);
                    }

                    _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);
                    _conf.impuesto = parseInt(datos['impuesto'][0].valor_conf);                    

                    venta.forEach(function(element) {
                        if(convetirToNegativo){
                            venta[venta.indexOf(element)].precioUnidad = element.precioUnidad * -1;
                            venta[venta.indexOf(element)].total = element.total * -1;                            
                        }
                        contador_ingreso++;
                    });

                    contador_productos = contador_ingreso;
                    _orden = venta;
                    depurar_producto();
                    if (_conf.impuesto == 1) {
                        
                        _config_impuestos();
                        depurar_producto();                        
                    }
                },
                error: function() {}
            });
        }

        function get_orden(orden_id) {

            $.ajax({
                type: "POST",
                url: path+"autoload_orden",
                datatype: 'json',
                data: {
                    id: orden_id
                },
                cache: false,

                success: function(data) {
                    var datos = JSON.parse(data);
                    var orden = datos["orden_detalle"];

                    if(!orden){
                        var type = "info";
                        var title = "Orden No Valida ";
                        var mensaje = "Orden Estado No Valida : get_orden";
                        var boton = "info";
                        var  finalMessage = "Gracias..."
                        generalAlert(type , mensaje , title , boton, finalMessage);
                    }

                    _conf.comboAgrupado = parseInt(datos['conf'][0].valor_conf);
                    _conf.impuesto = parseInt(datos['impuesto'][0].valor_conf);                    

                    orden.forEach(function(element) {
                        contador_ingreso++;
                    });

                    contador_productos = contador_ingreso;
                    _orden = orden;
                    depurar_producto();
                    if (_conf.impuesto == 1) {
                        
                        _config_impuestos();
                        depurar_producto();                        
                    }
                },
                error: function() {}
            });
        }

        function getImpuestosLista() {

            $.ajax({
                url: path+"get_impuestos_lista",
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

        function validation_imputs(){
            
        }

    });
</script>