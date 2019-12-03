<script>
    $(document).ready(function() {

        // OBTENER ORDENES PARA CONVERTIRLAS A VENTA

        var contador_ingreso = 0;
        var cnt22 = 0;

        $(document).on('keypress', '#orden_numero', function(e) {

            if (e.keyCode == 13) {

                if (this.value != "") {
                    getImpuestosLista();
                    get_orden(this.value);
                    
                } else {
                    _orden = [];
                    depurar_producto();
                    contador_ingreso = 0;
                }
            }

        });

        if(path == "../"){
            
            var id_orden = window.location.pathname.split("/").pop();

            get_orden(id_orden);
            
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

    });
</script>